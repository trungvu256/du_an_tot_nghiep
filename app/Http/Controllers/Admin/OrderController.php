<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Shipping;
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

        return view('admin.order.detailOder', compact('order'), ['status' => $request->input('status')]);
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
            0 => [1, 6],      // Chờ xử lý → Chờ lấy hàng, Đã hủy
            1 => [2, 6],      // Chờ lấy hàng → Đang giao, Đã hủy
            2 => [3, 5],      // Đang giao → Đã giao, Trả hàng
            3 => [4, 5],      // Đã giao → Hoàn tất, Trả hàng
            4 => [],          // Hoàn tất → không chuyển tiếp
            5 => [6],         // Trả hàng → Đã hủy (hoặc giữ nguyên)
            6 => [],          // Đã hủy → không chuyển tiếp
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



    public function requestReturn($id)
    {
        $order = Order::findOrFail($id);

        if ($order->return_status !== 0) {
            return redirect()->back()->with('error', 'Đơn hàng đã có yêu cầu hoàn trả.');
        }

        $order->update(['return_status' => 1]);

        return redirect()->back()->with('success', 'Đơn hàng hoàn trả đã được gửi');
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
