<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    public function showForm(Request $request)
{
    return view('web3.Home.forgot-password', ['email' => $request->email]);

}

public function sendOtp(Request $request)
{
    $request->validate([
        'email' => 'required|email|exists:users,email',
    ]);

    $otp = rand(100000, 999999);

    DB::table('password_resets')->updateOrInsert(
        ['email' => $request->email],
        ['otp' => $otp, 'created_at' => Carbon::now()]
    );

    // Gửi email
    Mail::raw("Mã OTP của bạn là: $otp", function ($message) use ($request) {
        $message->to($request->email)
                ->subject('Mã OTP đặt lại mật khẩu');
    });

    return redirect('/verify-otp?email=' . $request->email)
           ->with('success', 'Mã OTP đã được gửi đến email.');
}
public function showOtpForm(Request $request)
{
    return view('Web3.Home.verify-otp', ['email' => $request->email]);
}

public function verifyOtp(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'otp' => 'required|digits:6',
    ]);

    $record = DB::table('password_resets')
                ->where('email', $request->email)
                ->where('otp', $request->otp)
                ->first();

    if (!$record || Carbon::parse($record->created_at)->addMinutes(10)->isPast()) {
        return back()->withErrors(['otp' => 'Mã OTP không đúng hoặc đã hết hạn.']);
    }

    return redirect('/reset-password?email=' . $request->email)
           ->with('success', 'Xác minh thành công, vui lòng đặt lại mật khẩu.');
}
public function showResetForm(Request $request)
{
    return view('Web3.Home.reset-password', ['email' => $request->email]);
}

public function resetPassword(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|confirmed|min:6',
    ]);

    $user = \App\Models\User::where('email', $request->email)->first();
    $user->password = Hash::make($request->password);
    $user->save();

    DB::table('password_resets')->where('email', $request->email)->delete();

    return redirect('/')->with('success', 'Mật khẩu đã được đặt lại.');
}
}
