<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Shipping;
use App\Services\GHTKService;

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

        return view('admin.order.index', compact('orders'));
    }

    // show order
    public function show($id)
    {
        $order = Order::with('orderDetails.product')->find($id);

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
        // Lấy danh sách ID đơn hàng và trạng thái
        $orderIds = $request->input('order_ids', []);
        $status = $request->input('status');
    
        // Nếu không có đơn hàng nào được chọn -> báo lỗi
        if (empty($orderIds)) {
            return redirect()->back()->with('error', '❌ Vui lòng chọn ít nhất một đơn hàng để cập nhật!');
        }
    
        // Nếu trạng thái không hợp lệ -> báo lỗi
        if ($status === null || $status === '') {
            return redirect()->back()->with('error', '❌ Vui lòng chọn trạng thái!');
        }
    
        // Đảm bảo orderIds là mảng (tránh lỗi khi gửi dữ liệu không đúng)
        if (!is_array($orderIds)) {
            $orderIds = explode(',', $orderIds);
        }
    
        // Cập nhật trạng thái đơn hàng
        $updated = Order::whereIn('id', $orderIds)->update(['status' => $status]);
    
        if ($updated > 0) {
            return redirect()->back()->with('success', '✅ Cập nhật trạng thái thành công!');
        } else {
            return redirect()->back()->with('error', '⚠️ Không có đơn hàng nào được cập nhật!');
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
}
