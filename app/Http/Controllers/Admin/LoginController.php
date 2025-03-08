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
            'email'=> 'required|email',
            'password'=>'required|min:6',
        ]);
        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
            'is_admin' => 1
        ], $request->remember)) {
            return redirect()->route('admin.dashboard');
        } else {
            return back()->with('error', 'Email or Password is incorrect, or you do not have admin access.');
        }
    }
   public function logout() {
       Auth::logout();
       return redirect()->route('login');
   }
}
