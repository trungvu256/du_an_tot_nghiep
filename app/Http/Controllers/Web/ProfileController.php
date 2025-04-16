<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Catalogue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function showProfile()
    {
        $categories = Catalogue::all();
        return view('web3.profile.show', compact('categories')); // Thay đổi 'user.profile' thành 'web2.profile'
    }

    public function confirmPassword()
    {
        return view('web3.profile.confirm_password'); // Thay đổi đường dẫn view
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

        return view('web3.profile.edit', ['user' => Auth::user()]); // Cập nhật đường dẫn view
    }

    public function updateProfile(Request $request)
{
    if (!session('password_confirmed')) {
        return redirect()->route('profile.confirm_password')->with('error', 'Bạn cần xác nhận mật khẩu trước.');
    }

    $user = Auth::user();

    // Xác thực dữ liệu đầu vào
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'avatar' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
    ]);

    // Cập nhật thông tin người dùng
    $user->name = $request->name;
    $user->email = $request->email;
    $user->address = $request->address;

    // Xử lý ảnh đại diện
    if ($request->hasFile('avatar')) {
        // Kiểm tra xem có ảnh cũ không, nếu có thì xóa
        if ($user->avatar && Storage::exists('public/avatars/' . $user->avatar)) {
            Storage::delete('public/avatars/' . $user->avatar);
        }

        // Lưu ảnh mới
        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        } // Lưu vào storage/app/public/avatars

        // Cập nhật tên file vào database
        $user->avatar = $avatarPath;
    }

    // Lưu thông tin người dùng
    $user->save();

    // Xóa xác thực mật khẩu sau khi cập nhật
    session()->forget('password_confirmed');

    return redirect()->route('profile')->with('success', 'Cập nhật thông tin thành công!');
}

}
