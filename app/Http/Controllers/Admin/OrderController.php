<?php

namespace App\Http\Controllers\Admin;

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
    $query = Order::query();

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
    public function show($id)
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
    
        return view('admin.order.detailOder', compact('order'));
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
        $orderIds = $request->input('order_ids', []);
        $status = $request->input('status');
    
        // Kiểm tra dữ liệu đầu vào
        if (empty($orderIds)) {
            return redirect()->back()->with('error', '❌ Vui lòng chọn ít nhất một đơn hàng để cập nhật!');
        }
    
        if ($status === null || $status === '') {
            return redirect()->back()->with('error', '❌ Vui lòng chọn trạng thái!');
        }
    
        // Chuyển đổi orderIds thành mảng nếu không phải mảng
        if (!is_array($orderIds)) {
            $orderIds = explode(',', $orderIds);
        }
    
        // Danh sách trạng thái không được phép cập nhật
        $nonUpdatableStatuses = ['4', '5']; // Hoàn tất (4) và Đã hủy (5)
    
        // Kiểm tra trạng thái đích không được phép
        if (in_array($status, $nonUpdatableStatuses)) {
            return redirect()->back()->with('error', '❌ Không thể cập nhật sang trạng thái Hoàn tất hoặc Đã hủy!');
        }
    
        // Lấy danh sách đơn hàng cần cập nhật
        $orders = Order::whereIn('id', $orderIds)->get();
    
        if ($orders->isEmpty()) {
            return redirect()->back()->with('error', '⚠️ Không tìm thấy đơn hàng nào để cập nhật!');
        }
    
        DB::beginTransaction();
    
        try {
            $updatedCount = 0;
    
            foreach ($orders as $order) {
                $currentStatus = $order->status;
    
                // Kiểm tra điều kiện trực tiếp cho từng trạng thái
                if (in_array($currentStatus, $nonUpdatableStatuses)) {
                    continue; // Bỏ qua đơn hàng đã hoàn tất hoặc đã hủy
                }
    
                // Điều kiện chuyển sang "Đang giao" (2)
                if ($status == '2' && $currentStatus < '1') {
                    continue; // Bỏ qua nếu chưa xác nhận
                }
    
                // Điều kiện chuyển sang "Đã giao" (3)
                if ($status == '3' && $currentStatus < '2') {
                    continue; // Bỏ qua nếu chưa đang giao
                }
    
                // Cập nhật trạng thái
                $order->status = $status;
                $order->save();
                $updatedCount++;
            }
    
            if ($updatedCount > 0) {
                DB::commit();
                return redirect()->back()->with('success', "✅ Cập nhật trạng thái thành công cho $updatedCount đơn hàng!");
            } else {
                DB::rollBack();
                return redirect()->back()->with('error', '⚠️ Không có đơn hàng nào được cập nhật do không thỏa mãn điều kiện!');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', '❌ Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
    //   Trả hàng

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
