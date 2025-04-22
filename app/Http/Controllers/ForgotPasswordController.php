<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Mail\MailException;

class ForgotPasswordController extends Controller
{
    public function sendOtp(Request $request)
    {
        try {
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

            return response()->json(['success' => true, 'message' => 'OTP đã được gửi đến email của bạn!']);
        } catch (MailException $e) {
            return response()->json(['message' => 'Không thể gửi email. Vui lòng thử lại sau.'], 500);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã có lỗi xảy ra. Vui lòng thử lại.'], 500);
        }
    }

    public function verifyOtp(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'otp' => 'required|digits:6',
            ]);

            $record = DB::table('password_resets')
                        ->where('email', $request->email)
                        ->where('otp', $request->otp)
                        ->first();

            if (!$record || Carbon::parse($record->created_at)->addMinutes(10)->isPast()) {
                return response()->json(['message' => 'Mã OTP không đúng hoặc đã hết hạn.'], 422);
            }

            return response()->json(['success' => true, 'message' => 'Xác minh OTP thành công!']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã có lỗi xảy ra. Vui lòng thử lại.'], 500);
        }
    }

    public function resetPassword(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email|exists:users,email',
                'password' => 'required|confirmed|min:6',
            ]);

            $user = \App\Models\User::where('email', $request->email)->first();
            if (!$user) {
                return response()->json(['message' => 'Email không tồn tại.'], 422);
            }

            $user->password = Hash::make($request->password);
            $user->save();

            DB::table('password_resets')->where('email', $request->email)->delete();

            return response()->json(['success' => true, 'message' => 'Mật khẩu đã được đặt lại thành công!']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã có lỗi xảy ra. Vui lòng thử lại.'], 500);
        }
    }
}