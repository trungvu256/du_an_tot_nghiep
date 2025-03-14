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
    
        // Lọc theo trạng thái nếu có
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
    
        // Lọc theo tìm kiếm nếu có
        if ($request->has('search')) {
            $query->where('id', 'like', '%' . $request->search . '%')
                  ->orWhere('customer_name', 'like', '%' . $request->search . '%');
        }
    
        // Lấy danh sách đơn hàng với phân trang
        $orders = $query->orderBy('created_at', 'desc')->paginate(10);
    
        return view('admin.order.index', compact('orders'));
    }
    
    
    
    // show order
    public function show ($id) {
        $order = Order::with('orderDetails.product')->find($id);

        return view('admin.order.detailOder', compact('order'));
    }

    public function updatePaymenStatus (Request $request,  $id) {
        $order = Order::findOrFail($id);

    if (!isset($request->payment_status)) {
        return back()->with('error', 'Trạng thái thanh toán không hợp lệ.');
    }

    $order->payment_status = $request->payment_status;
    $order->save();

    return redirect()->route('admin.order')->with('success', 'Cập nhật trạng thái thanh toán thành công!');
       }



}
