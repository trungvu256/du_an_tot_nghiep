<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function processOrder(Request $request)
    {
        $paymentMethod = $request->payment_method;
        $amount = $request->amount;

        if ($paymentMethod == 'cash') {
            // Lưu đơn hàng vào database
            $order = Order::create([
                'user_id' => auth()->id(),
                'total_amount' => $amount,
                'payment_method' => 'cash',
                'status' => 'pending', // Đơn hàng đang chờ xử lý
            ]);

            return redirect()->route('home')->with('success', 'Đơn hàng đã được tạo. Bạn sẽ thanh toán khi nhận hàng.');
        } else {
            // Chuyển sang trang thanh toán VNPay
            return redirect()->route('payment.vnpay', ['amount' => $amount]);
        }
    }
}
