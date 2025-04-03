<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Import rõ ràng model User
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            // Debug để kiểm tra $user
            Log::info('User instance:', ['class' => get_class($user), 'id' => $user->id]);
            
            if (!method_exists($user, 'createToken')) {
                Log::error('createToken method not available on User', ['class' => get_class($user)]);
                return response()->json(['error' => 'Server misconfiguration: createToken not available'], 500);
            }

            $token = $user->createToken('ChatApp')->plainTextToken;
            return response()->json(['token' => $token]);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }
}