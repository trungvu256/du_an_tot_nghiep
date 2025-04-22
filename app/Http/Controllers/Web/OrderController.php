<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Catalogue;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Request $request)
{
    // Lấy ID của người dùng hiện tại
    $userId = Auth::id();

    // Bắt đầu truy vấn với điều kiện lọc theo user_id
    $query = Order::where('user_id', $userId)
        ->with('orderItems.product', 'user') // Nạp trước quan hệ
        ->orderBy('created_at', 'desc');

    // Lấy tất cả danh mục
    $categories = Catalogue::all();

    // Lọc theo trạng thái giao hàng
    if ($request->filled('status')) {
        $query->where('status', $request->input('status'));
    }

    // Lọc theo trạng thái thanh toán
    if ($request->filled('payment_status')) {
        $query->where('payment_status', $request->input('payment_status'));
    }

    // Tìm kiếm theo mã đơn hàng hoặc số điện thoại
    if ($request->filled('query')) {
        $search = strtolower($request->input('query')); // Chuyển về chữ thường

        $query->where(function ($q) use ($search) {
            if (str_starts_with($search, 'dh')) {
                $numericId = (int) substr($search, 2);
                $q->where('order_code', $numericId);
            } elseif (is_numeric($search)) {
                $q->where('order_code', $search);
            } else {
                $q->orWhereRaw('LOWER(phone) LIKE ?', ["%$search%"]);
            }
        });
    }

    // Lấy dữ liệu với phân trang
    $orders = $query->paginate(10);

    // Truyền dữ liệu vào view
    return view('web3.Home.order', compact('orders', 'categories'));
}

    // show order
    public function show($id)
{
    $categories = Catalogue::all();
    $order = Order::with(['orderItems.product', 'shippingInfo', 'orderItems.productVariant'])->findOrFail($id);

        // Thêm danh sách lý do trả hàng
        $returnReasons = [
            'Sản phẩm không đúng mô tả',
            'Sản phẩm bị lỗi',
            'Thay đổi ý định mua hàng',
            'Sản phẩm không phù hợp',
            'Nhận được sản phẩm sau quá lâu',
            'Sản phẩm bị hư hỏng trong quá trình vận chuyển',
            'Sản phẩm không đúng với đơn hàng',
            'Lý do khác'
        ];

        return view('web3.Home.orderItems', compact('order', 'categories', 'returnReasons'));
    }

    public function updatePaymenStatus(Request $request,  $id)
    {
        $order = Order::findOrFail($id);

        if (!isset($request->payment_status)) {
            return back()->with('error', 'Trạng thái thanh toán không hợp lệ.');
        }

        $order->payment_status = $request->payment_status;
        $order->save();

        return redirect()->route('admin.order')->with('success', 'Cập nhật trạng thái thanh toán thành công!');
    }

     // Hủy đơn hàng
     public function cancel(Request $request, $id)
{
    $order = Order::find($id);
    $returnReason = $request->input('cancel_reason'); // Lý do hủy đơn hàng (theo form)
    $quantity = $request->input('quantity', 0); // Số lượng trả về kho, mặc định là 0 nếu không có

    if (!$order) {
        return response()->json([
            'success' => false,
            'message' => 'Không tìm thấy đơn hàng!'
        ], 404);
    }

    // Kiểm tra trạng thái đơn hàng
    if ($order->status == 0 || $order->status == 1) {
        try {
            DB::beginTransaction();

            // Cập nhật trạng thái đơn hàng là đã hủy
            $order->status = 5;
            $order->return_reason = $returnReason; // Lý do hủy
            $order->save();

            // Xử lý trả lại hàng về kho nếu có số lượng
            foreach ($order->orderItems as $item) {
                if ($item->product_variant_id) {
                    $variant = $item->productVariant;
                    if ($variant) {
                        $variant->increment('stock_quantity', $item->quantity);
                    }
                } else {
                    $product = $item->product;
                    if ($product) {
                        $product->increment('stock', $item->quantity);
                    }
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Đơn hàng đã được hủy và hàng đã được trả về kho!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi hủy đơn hàng: ' . $e->getMessage()
            ], 500);
        }
    }

    return response()->json([
        'success' => false,
        'message' => 'Không thể hủy đơn hàng này!'
    ], 400);
}

     // Xác nhận đã nhận được hàng
     public function received($id)
     {
         $order = Order::find($id);

         if ($order) {
            if ($order->status == 3) { // Nếu đơn hàng đang ở trạng thái "Đã giao"
                DB::beginTransaction();
                try {
                    // Cập nhật trạng thái đơn hàng thành "Hoàn tất"
                 $order->status = 4;

                    // Nếu là đơn hàng thanh toán khi nhận hàng (COD)
                    if ($order->payment_status == 2) {
                        // Cập nhật trạng thái thanh toán thành "Đã thanh toán"
                        $order->payment_status = 1;
                    }

                 $order->save();
                    DB::commit();

                    return response()->json(['success' => true, 'message' => 'Đơn hàng đã được xác nhận là đã nhận và thanh toán thành công!']);
                } catch (\Exception $e) {
                    DB::rollBack();
                    Log::error('Error confirming order received: ' . $e->getMessage()); // Ghi log lỗi
                    return response()->json(['success' => false, 'message' => 'Có lỗi xảy ra khi cập nhật đơn hàng!'], 500);
                }
             }

             // Trả về lỗi nếu trạng thái không phải là "Đã giao"
             return response()->json(['success' => false, 'message' => 'Không thể xác nhận đơn hàng ở trạng thái này!'], 400);
         }

         // Trả về lỗi nếu không tìm thấy đơn hàng
         return response()->json(['success' => false, 'message' => 'Không tìm thấy đơn hàng!'], 404);
     }

     // Xác nhận đã trả hàng
     public function returned($id)
     {
        $order = Order::findOrFail($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy đơn hàng!'
            ], 404);
        }

        // Kiểm tra nếu đơn hàng đã thanh toán qua VNPay thì không cho phép trả hàng
        if ($order->payment_status == 1 && $order->payment_method == 1) {
            return response()->json([
                'success' => false,
                'message' => 'Đơn hàng đã thanh toán qua VNPay không được phép trả hàng!'
            ], 400);
        }

        // Kiểm tra điều kiện trả hàng
        if ($order->status != 3 && $order->status != 4) {
            return response()->json([
                'success' => false,
                'message' => 'Chỉ đơn hàng đã giao hoặc hoàn tất mới có thể trả hàng.'
            ], 400);
        }

        // Kiểm tra xem đã yêu cầu trả hàng chưa
        if ($order->return_status == 0) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn cần yêu cầu trả hàng trước khi xác nhận đã trả hàng. Vui lòng chọn "Yêu cầu trả hàng" trong chi tiết của đơn hàng.'
            ], 400);
        }

        // Kiểm tra xem yêu cầu trả hàng đã được duyệt chưa
        if ($order->return_status != 2) {
            return response()->json([
                'success' => false,
                'message' => 'Yêu cầu trả hàng của bạn chưa được duyệt hoặc đã bị từ chối. Vui lòng liên hệ với chúng tôi để được hỗ trợ.'
            ], 400);
        }

        try {
            DB::beginTransaction();

            // Chỉ cập nhật trạng thái trả hàng thành "Đã duyệt"
            // Không tự động chuyển thành hoàn tất
            $order->return_status = Order::RETURN_APPROVED;
            $order->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Xác nhận trả hàng thành công. Vui lòng đợi admin xác nhận hoàn tất.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi cập nhật trạng thái đơn hàng: ' . $e->getMessage()
            ], 500);
        }
    }
    //   Trả hàng

    public function requestReturn(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        // Kiểm tra nếu đơn hàng đã thanh toán qua VNPay thì không cho phép trả hàng
        if ($order->payment_status == 1 && $order->payment_method == 1) {
            return response()->json([
                'success' => false,
                'error' => 'Đơn hàng đã thanh toán qua VNPay không được phép trả hàng!'
            ]);
        }

        // Kiểm tra điều kiện trả hàng
        if ($order->status != 3 && $order->status != 4) {
            return response()->json([
                'success' => false,
                'error' => 'Không thể yêu cầu trả hàng cho đơn hàng này!'
            ]);
        }

        // Kiểm tra xem đã có yêu cầu trả hàng chưa
        if ($order->return_status != 0) {
            return response()->json([
                'success' => false,
                'error' => 'Đơn hàng đã có yêu cầu hoàn trả.'
            ], 400);
        }

        // Kiểm tra lý do trả hàng
        $returnReason = $request->input('return_reason');
        if (empty($returnReason)) {
            return response()->json([
                'success' => false,
                'error' => 'Vui lòng chọn lý do trả hàng!'
            ], 400);
        }

        DB::beginTransaction();
        try {
            // Cập nhật trạng thái trả hàng
            $order->return_status = Order::RETURN_REQUESTED;
            $order->return_reason = $returnReason;
            $order->save();

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Yêu cầu trả hàng đã được gửi'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'error' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }
    public function unfinishedOrders()
{
    $orders = Order::where('status', '<', 5) // Chỉ lấy đơn chưa hoàn tất
                   ->paginate(10);

    return view('admin.order.unfinished', compact('orders'));
}

public function ship($id)
{
    $order = Order::with(['orderItems.product', 'history'])->findOrFail($id);
    return view('admin.order.order', compact('order'));
}

// Bàn giao cho bên giao hàng
public function shipOrder(Request $request, $id)
{
    $order = Order::findOrFail($id);

    // Cập nhật thông tin vận chuyển
    $order->shipping_provider = $request->shipping_provider;
    $order->status = 3; // Cập nhật trạng thái thành "Đang giao"
    $order->tracking_number = 'TRK' . time(); // Tạo mã vận đơn giả định
    $order->save();

    return redirect()->back()->with('success', 'Đơn hàng đã được gửi đến đơn vị vận chuyển!');
}

public function pushToShipping(Request $request, $orderId)
{
    $order = Order::find($orderId);
    if (!$order) {
        return response()->json(['error' => 'Đơn hàng không tồn tại'], 404);
    }

    $order->status = 'waiting_for_pickup'; // Chờ lấy hàng
    $order->shipping_provider = 'GHTK';
    $order->tracking_number = 'GHTK' . time();

    $order->save();

    Log::info('Đã đẩy đơn hàng', ['id' => $orderId, 'status' => $order->status]);

    return response()->json(['message' => 'Đơn hàng đã đẩy sang vận chuyển']);
}
}
