<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class LoginGoogleController extends Controller
{
    // Chuyển hướng người dùng đến trang đăng nhập Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Xử lý callback từ Google
    public function handleGoogleCallback()
    {

        if (isset($_GET['checkout']) && $_GET['checkout'] == 'login') {
            $user = Socialite::driver('google')->user();
            $this->_registerOrLoginUser($user);
            return redirect()->route('web.checkout');
        } else {
            $user = Socialite::driver('google')->user();
            $this->_registerOrLoginUser($user);
            return redirect()->route('web.index');
        }

        // Return home after login

    }
}
