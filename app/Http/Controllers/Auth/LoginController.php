<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Hiện thị form đăng nhập
    public function showLoginForm()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
        if (
            Auth::attempt([
                'email' => $request->email,
                'password' => $request->password,
                'is_admin' => 1
            ], $request->remember)
        ) {
            return redirect()->route('admin.dashboard');
        } else {
            return back()->with('error', 'Email hoặc mật khẩu không đúng hoặc bạn không có quyền truy cập trang quản trị.');
        }
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
