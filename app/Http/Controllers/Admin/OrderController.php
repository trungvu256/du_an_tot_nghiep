<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Shipping;
use App\Models\ProductReview;
use App\Services\GHTKService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::query()->orderBy('created_at', 'desc');

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

        // Trả lại thông tin cần thiết cho view
        return view('admin.order.index', [
            'orders' => $orders,
            'status' => $request->input('status'),
            'payment_status' => $request->input('payment_status'),
            'query' => $request->input('query')
        ]);
    }


    // show order
    public function show(Request $request, $id)
    {
        $order = Order::with([
            'orderItems.product',
            'orderItems.productVariant',
            'shippingInfo'
        ])->findOrFail($id);

        // Lấy thông tin số lượng tồn kho cho mỗi biến thể
        foreach ($order->orderItems as $item) {
            if ($item->productVariant) {
                $item->variant_stock = $item->productVariant->stock;
                $item->variant_price = $item->productVariant->price ?? 0;
            }
        }

        // Lấy tất cả các đánh giá liên quan đến đơn hàng này
        $reviews = ProductReview::where('order_id', $id)
        ->with('user') // Load mối quan hệ user để lấy thông tin người dùng
        ->get();

        return view('admin.order.detailOder', compact('order','reviews'), ['status' => $request->input('status')]);
    }



    public function updatePaymenStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        if (!in_array($request->payment_status, [Order::PAYMENT_PAID, Order::PAYMENT_COD, Order::PAYMENT_REFUNDED])) {
            return back()->with('error', 'Trạng thái thanh toán không hợp lệ.');
        }

        $order->payment_status = $request->payment_status;
        $order->save();

        return redirect()->route('admin.order')->with('success', 'Cập nhật trạng thái thanh toán thành công!');
    }

    public function updateStatus(Request $request)
    {
        // Lấy dữ liệu từ request
        $orderIds = $request->input('order_ids', []);  // Các id đơn hàng được chọn
        $newStatus = $request->input('status');        // Trạng thái mới
        $orderId = $request->input('order_id');        // ID đơn hàng cụ thể (nếu có)

        // Nếu có id truyền vào, sử dụng id đó để tìm đơn hàng và cập nhật trạng thái
        if ($orderId) {
            $orders = Order::where('id', $orderId)->get();

            if ($orders->isEmpty()) {
                return redirect()->back()->with('error', '⚠️ Không tìm thấy đơn hàng để cập nhật!');
            }

            $orderIds = [$orderId]; // Chỉ xử lý đơn hàng có id này
        } else {
            // Nếu không có id, xử lý với danh sách đơn hàng được chọn
            if (empty($orderIds)) {
                return redirect()->back()->with('error', '❌ Vui lòng chọn ít nhất một đơn hàng để cập nhật!');
            }

            if (!is_array($orderIds)) {
                $orderIds = explode(',', $orderIds);
            }

            $orders = Order::whereIn('id', $orderIds)->get();

            if ($orders->isEmpty()) {
                return redirect()->back()->with('error', '⚠️ Không tìm thấy đơn hàng nào để cập nhật!');
            }
        }

        // Kiểm tra nếu trạng thái mới không hợp lệ
        if ($newStatus === null || $newStatus === '') {
            return redirect()->back()->with('error', '❌ Vui lòng chọn trạng thái!');
        }

        // Quy định luồng chuyển trạng thái hợp lệ
        $validTransitions = [
            0 => [1, 5], // Chờ xử lý => Chờ lấy hàng, Đã hủy
            1 => [2, 5], // Chờ lấy hàng => Đang giao, Đã hủy
            2 => [3], // Đang giao => Đã giao
            3 => [], // Đã giao => Không chuyển tiếp
            4 => [], // Hoàn tất => Không chuyển tiếp
            5 => [], // Đã hủy => Không chuyển tiếp
            6 => [] // Trả hàng => Không chuyển tiếp
        ];

        DB::beginTransaction();

        try {
            $updatedCount = 0;

            foreach ($orders as $order) {
                $currentStatus = $order->status;

                // Kiểm tra điều kiện chuyển trạng thái hợp lệ
                if (isset($validTransitions[$currentStatus]) && in_array((int)$newStatus, $validTransitions[$currentStatus])) {
                    // Cập nhật trạng thái nếu hợp lệ
                    $order->status = $newStatus;
                    $order->save();
                    $updatedCount++;
                }
            }

            // Kiểm tra nếu có đơn hàng được cập nhật
            if ($updatedCount > 0) {
                DB::commit();
                return redirect()->back()->with('success', "✅ Cập nhật trạng thái thành công cho $updatedCount đơn hàng!");
            } else {
                DB::rollBack();
                return redirect()->back()->with('error', '⚠️ Không có đơn hàng nào được cập nhật do không thỏa mãn điều kiện chuyển trạng thái!');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', '❌ Có lỗi xảy ra: ' . $e->getMessage());
        }
    }



    public function requestReturn(Request $request, $id)
    {
        $order = Order::with(['orderItems.product', 'orderItems.productVariant'])->findOrFail($id);
        Log::info("Bắt đầu xử lý trả hàng cho đơn hàng #{$id}");

        // Kiểm tra nếu đơn hàng đã thanh toán qua VNPay thì không cho phép trả hàng
        if ($order->payment_status == 1 && $order->payment_method == 1) {
            Log::warning("Đơn hàng #{$id} đã thanh toán qua VNPay không được phép trả hàng");
            return redirect()->back()->with('error', 'Đơn hàng đã thanh toán qua VNPay không được phép trả hàng.');
        }

        // Kiểm tra xem đơn hàng có yêu cầu trả hàng không
        if ($order->return_status != Order::RETURN_REQUESTED) {
            Log::warning("Đơn hàng #{$id} không có yêu cầu hoàn trả");
            return redirect()->back()->with('error', 'Đơn hàng không có yêu cầu hoàn trả.');
        }

        // Lấy hành động từ request (approve hoặc decline)
        $action = $request->input('action');
        Log::info("Hành động yêu cầu: {$action}");

        DB::beginTransaction();
        try {
            if ($action === 'approve') {
                // Duyệt yêu cầu trả hàng
                $order->return_status = Order::RETURN_APPROVED;
                $order->save();

                DB::commit();
                return redirect()->back()->with('success', 'Đã duyệt yêu cầu trả hàng');
            } elseif ($action === 'decline') {
                // Từ chối yêu cầu trả hàng
                $order->return_status = Order::RETURN_DECLINED;
                $order->save();

                DB::commit();
                return redirect()->back()->with('success', 'Đã từ chối yêu cầu trả hàng');
            } elseif ($action === 'complete') {
                Log::info("Bắt đầu xử lý hoàn tất trả hàng");
                // Xác nhận hoàn tất trả hàng
                $order->return_status = Order::RETURN_COMPLETED;
                $order->status = Order::STATUS_RETURNED;

                // Cộng lại số lượng sản phẩm vào kho
                Log::info("Số lượng order items: " . count($order->orderItems));
                foreach ($order->orderItems as $item) {
                    Log::info("Xử lý order item #{$item->id}");
                    $product = $item->product;
                    if ($product) {
                        Log::info("Sản phẩm #{$product->id}");
                        // Nếu có variant, cập nhật số lượng variant
                        if ($item->productVariant) {
                            $variant = $item->productVariant;
                            Log::info("Variant #{$variant->id} - Số lượng hiện tại: {$variant->stock_quantity}");

                            // Lấy số lượng hiện tại
                            $currentStock = $variant->stock_quantity;
                            $addQuantity = $item->quantity;
                            $newStock = $currentStock + $addQuantity;

                            Log::info("Cập nhật số lượng variant: {$currentStock} + {$addQuantity} = {$newStock}");

                            // Cập nhật trực tiếp bằng query để đảm bảo
                            DB::table('product_variants')
                                ->where('id', $variant->id)
                                ->update(['stock_quantity' => $newStock]);

                            Log::info("Đã cập nhật số lượng variant thành: {$newStock}");
                        }

                        // Cập nhật tổng số lượng tồn kho của sản phẩm
                        Log::info("Cập nhật tổng tồn kho cho sản phẩm #{$product->id}");
                        $product->updateTotalStock();
                    }
                }

                $order->save();

                DB::commit();
                Log::info("Hoàn tất xử lý trả hàng thành công");
                return redirect()->back()->with('success', 'Đã xác nhận hoàn tất trả hàng và cập nhật số lượng sản phẩm trong kho');
            } else {
                DB::rollBack();
                Log::warning("Hành động không hợp lệ: {$action}");
                return redirect()->back()->with('error', 'Hành động không hợp lệ!');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Lỗi khi xử lý trả hàng cho đơn #{$id}: " . $e->getMessage());
            Log::error("Stack trace: " . $e->getTraceAsString());
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
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
