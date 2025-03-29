<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wallet;
use App\Models\Withdrawal;
use Illuminate\Support\Facades\Auth;

class WithdrawalController extends Controller
{
    public function create()
    {
        return view('wallet.withdraw');
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000',
            'bank_name' => 'required|string',
            'bank_account' => 'required|string',
        ]);

        $wallet = Auth::user()->wallet;

        if (!$wallet || $wallet->balance < $request->amount) {
            return back()->with('error', 'Số dư không đủ để rút.');
        }

        // Trừ tiền trong ví
        $wallet->balance -= $request->amount;
        $wallet->save();

        // Lưu yêu cầu rút tiền
        Withdrawal::create([
            'user_id' => Auth::id(),
            'wallet_id' => $wallet->id,
            'amount' => $request->amount,
            'bank_name' => $request->bank_name,
            'bank_account' => $request->bank_account,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Yêu cầu rút tiền đã được gửi, chờ xác nhận.');
    }
}
