<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class ReturnOrderController extends Controller
{
    public function index()
    {
        $returnOrders = Order::where('return_status', '>', 0)->paginate(10);
        return view('admin.return.index', compact('returnOrders'));
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        
        // Kiểm tra nếu đơn hàng không có yêu cầu trả hàng
        if ($order->return_status == Order::RETURN_NONE) {
            return redirect()->back()->with('error', 'Đơn hàng này không có yêu cầu trả hàng.');
        }

        $order->return_status = $request->return_status; // Cập nhật trạng thái
        $order->save();

        return redirect()->back()->with('success', 'Cập nhật trạng thái trả hàng thành công.');
    }
}

