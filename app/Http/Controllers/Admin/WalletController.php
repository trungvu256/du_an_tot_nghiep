<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminWallet;
use App\Models\Order;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{
    public function show()
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để xem ví.');
        }

        $wallet = Wallet::firstOrCreate(['user_id' => $user->id]);

        return view('admin.wallets.show', compact('wallet'));
    }

    public function refund(Order $order)
    {
        if ($order->payment_status == 1) {
            try {
                DB::transaction(function () use ($order) {
                    $wallet = Wallet::firstOrCreate(['user_id' => $order->user_id]);

                    if ($wallet->balance < $order->total_price) {
                        throw new \Exception('Số dư trong ví không đủ để thực hiện hoàn tiền.');
                    }

                    // Trừ tiền trong ví khách
                    $wallet->deductBalance($order->total_price);
                    WalletTransaction::create([
                        'wallet_id' => $wallet->id,
                        'amount' => -$order->total_price,
                        'type' => 'refund',
                        'description' => 'Hoàn tiền đơn hàng ' . $order->id,
                    ]);

                    // Cộng tiền vào ví admin
                    AdminWallet::adjustBalance($order->total_price);
                    WalletTransaction::create([
                        'wallet_id' => 1, // Giả định admin wallet có ID là 1
                        'amount' => $order->total_price,
                        'type' => 'deposit',
                        'description' => 'Nhận tiền thanh toán từ khách hàng' . $order->user_id,
                    ]);

                    // Cập nhật trạng thái đơn hàng
                    $order->update(['status' => 8, 'payment_status' => 3]);
                });

                return redirect()->back()->with('success', 'Tiền đã được hoàn vào ví của khách hàng.');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }
        }

        return redirect()->back()->with('error', 'Đơn hàng chưa được thanh toán.');
    }
    public function deposit(Request $request) {
        $request->validate([
          'amount'=>'required|numeric|min:1000'
        ]);
        $user = auth()->user();
        if(!$user) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để nạp tiền!');
        }
        $wallet = Wallet::firstOrCreate(['user_id' => $user->id]);
        $wallet->addBalance($request->amount, 'nạp tiền vào ví');

        return redirect()->back()->with('success', 'Nạp tiền thành công.');
    }
}
