<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Catalogue;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::orderBy('created_at', 'desc');
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
                if (str_starts_with($search, 'wd')) { // Chấp nhận cả "WD" và "wd"
                    $numericId = (int) substr($search, 2); // Lấy số ID sau "WD"
                    $q->where('id', $numericId);
                } elseif (is_numeric($search)) {
                    $q->where('id', $search);
                } else {
                    $q->orWhereRaw('LOWER(phone) LIKE ?', ["%$search%"]);
                }
            });
        }

        $orders = $query->paginate(10);

        return view('web3.Home.order', compact('orders','categories'));
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
         $returnReason = $request->input('return_reason'); // Lý do hủy đơn hàng
         $quantity = $request->input('quantity'); // Số lượng trả về kho

         if ($order) {
             // Kiểm tra trạng thái đơn hàng
             if ($order->status == 0 || $order->status == 1) {
                 // Cập nhật trạng thái đơn hàng là đã hủy
                 $order->status = 5;
                 $order->return_reason = $returnReason; // Lý do hủy
                 $order->save();

                 // Xử lý trả lại hàng về kho nếu có số lượng
                 if ($quantity > 0) {
                     // Ví dụ: Cập nhật lại số lượng kho
                     foreach ($order->orderItems as $item) {
                         if ($item->quantity >= $quantity) {
                             $item->product->increment('stock_quantity', $quantity); // Tăng số lượng sản phẩm về kho
                             break;
                         }
                     }
                 }

                 return redirect()->back()->with('success', 'Đơn hàng đã được hủy và hàng đã được trả về kho!');
             }

             return redirect()->back()->with('error', 'Không thể hủy đơn hàng này!');
         }

         return redirect()->back()->with('error', 'Không tìm thấy đơn hàng!');
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

                    return redirect()->back()->with('success', 'Đơn hàng đã được xác nhận là đã nhận và thanh toán thành công!');
                } catch (\Exception $e) {
                    DB::rollBack();
                    return redirect()->back()->with('error', 'Có lỗi xảy ra khi cập nhật đơn hàng!');
                }
             }

             return redirect()->back()->with('error', 'Không thể xác nhận đơn hàng này!');
         }

         return redirect()->back()->with('error', 'Không tìm thấy đơn hàng!');
     }

     // Xác nhận đã trả hàng
     public function returned($id)
     {
        $order = Order::findOrFail($id);

        // Kiểm tra nếu đơn hàng đã thanh toán qua VNPay thì không cho phép trả hàng
        if ($order->payment_status == 1 && $order->payment_method == 1) {
            return redirect()->back()->with('error', 'Đơn hàng đã thanh toán qua VNPay không được phép trả hàng!');
        }

        // Kiểm tra điều kiện trả hàng
        if ($order->status != 3 && $order->status != 4) {
            return redirect()->back()->with('error', 'Chỉ đơn hàng đã giao hoặc hoàn tất mới có thể trả hàng.');
        }

        // Kiểm tra xem đã yêu cầu trả hàng chưa
        if ($order->return_status == 0) {
            return redirect()->back()->with('error', 'Bạn cần yêu cầu trả hàng trước khi xác nhận đã trả hàng. Vui lòng chọn "Yêu cầu trả hàng" trong menu thao tác của đơn hàng.');
        }

        // Kiểm tra xem yêu cầu trả hàng đã được duyệt chưa
        if ($order->return_status != 2) {
            return redirect()->back()->with('error', 'Yêu cầu trả hàng của bạn chưa được duyệt hoặc đã bị từ chối. Vui lòng liên hệ với chúng tôi để được hỗ trợ.');
        }

        try {
            DB::beginTransaction();

            // Chỉ cập nhật trạng thái trả hàng thành "Đã duyệt"
            // Không tự động chuyển thành hoàn tất
            $order->return_status = Order::RETURN_APPROVED;
            $order->save();

            DB::commit();

            return redirect()->back()->with('success', 'Xác nhận trả hàng thành công. Vui lòng đợi admin xác nhận hoàn tất.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi cập nhật trạng thái đơn hàng. Vui lòng thử lại sau.');
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
