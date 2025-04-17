<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login()
    {
        return view('admin.login.index');
    }
    public function loginAdmin(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
    
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            // Kiểm tra xem người dùng có phải là admin không
            if (Auth::user()->is_admin !== 1) {
                Auth::logout();
                return back()->with('error', 'Tài khoản của bạn không có quyền truy cập admin.');
            }
            return redirect()->route('admin.dashboard');
        } else {
            return back()->with('error', 'Email hoặc mật khẩu không đúng.');
        }
    }
    
   public function logout() {
       Auth::logout();
       return redirect()->route('login');
   }
}