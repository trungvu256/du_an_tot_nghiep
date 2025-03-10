<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::orderBy('created_at', 'desc')->get();
        return view('admin.order.index', compact('orders'));
    }

    // Cập nhật trạng thái
    public function updateStatus (Request $request,  $id) {
     $order = Order::findOrFail($id);
     $order->status = $request->status;
     $order->save();

     return redirect()->route('admin.order')->with('success', 'Cập nhật trạng thái thành công!');
    }
    
    // show order
    public function show ($id) {
        $order = Order::with('orderDetails.product')->find($id);

        return view('admin.order.detailOder', compact('order'));
    }
}
