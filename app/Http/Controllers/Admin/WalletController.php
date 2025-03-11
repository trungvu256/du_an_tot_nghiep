<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Wallet;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function refund(Order $order)
{
    if ($order->payment_status != 1) {
        return redirect()->back()->with('error', 'Đơn hàng chưa được thanh toán, không thể hoàn tiền.');
    }

    if (!$order->user_id) {
        return redirect()->back()->with('error', 'Không tìm thấy thông tin người dùng để hoàn tiền.');
    }
    $wallet = Wallet::firstOrCreate(['user_id' => $order->user_id]);

    $wallet->balance += $order->total_price;
    $wallet->save();
    $order->update([
        'status' => 7, // 7: Hoàn trả
        'payment_status' => 3 // 3: Đã hoàn tiền vào ví
    ]);

    return redirect()->back()->with('success', 'Tiền đã được hoàn vào ví thành công.');
}

}
