<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileController extends Controller
{
    public function showProfile()
    {
        return view('web2.profile'); // Thay đổi 'user.profile' thành 'web2.profile'
    }

    public function confirmPassword()
    {
        return view('web2.confirm_password'); // Thay đổi đường dẫn view
    }

    public function checkPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
        ]);

        if (Hash::check($request->password, Auth::user()->password)) {
            session(['password_confirmed' => true]);
            return redirect()->route('profile.edit');
        } else {
            return back()->with('error', 'Mật khẩu không chính xác.');
        }
    }

    public function editProfile()
    {
        if (!session('password_confirmed')) {
            return redirect()->route('profile.confirm_password')->with('error', 'Bạn cần xác nhận mật khẩu trước.');
        }

        return view('web2.profile_edit', ['user' => Auth::user()]); // Cập nhật đường dẫn view
    }

    public function updateProfile(Request $request)
    {
        if (!session('password_confirmed')) {
            return redirect()->route('profile.confirm_password')->with('error', 'Bạn cần xác nhận mật khẩu trước.');
        }

        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'avatar' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->hasFile('avatar')) {
            if ($user->avatar && file_exists(public_path('uploads/avatars/' . $user->avatar))) {
                unlink(public_path('uploads/avatars/' . $user->avatar));
            }

            $file = $request->file('avatar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/avatars'), $filename);
            $user->avatar = $filename;
        }

        $user->save();
        session()->forget('password_confirmed');

        return redirect()->route('profile')->with('success', 'Cập nhật thông tin thành công!');
    }
}
