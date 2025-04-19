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
            return redirect()->route('profile.confirm_password');
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
        'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        'phone' => 'nullable|string|max:255',
        'address' => 'nullable|string|max:255',
        'gender' => 'required|in:Male,Female,Unisex',
        'avatar' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
    ], [
        'name.required' => 'Vui lòng nhập họ tên.',
        'name.string' => 'Họ tên phải là chuỗi ký tự.',
        'name.max' => 'Họ tên không được vượt quá 255 ký tự.',
    
        'email.required' => 'Vui lòng nhập email.',
        'email.email' => 'Email không đúng định dạng.',
        'email.max' => 'Email không được vượt quá 255 ký tự.',
        'email.unique' => 'Email này đã được sử dụng.',
    
        'phone.string' => 'Số điện thoại phải là chuỗi ký tự.',
        'phone.max' => 'Số điện thoại không được vượt quá 255 ký tự.',
    
        'address.string' => 'Địa chỉ phải là chuỗi ký tự.',
        'address.max' => 'Địa chỉ không được vượt quá 255 ký tự.',
    
        'gender.required' => 'Vui lòng chọn giới tính.',
        'gender.in' => 'Giới tính không hợp lệ.',
    
        'avatar.image' => 'Tệp tải lên phải là hình ảnh.',
        'avatar.mimes' => 'Ảnh đại diện phải có định dạng: jpg, png, jpeg.',
        'avatar.max' => 'Ảnh đại diện không được vượt quá 2MB.',
    ]);

    // Cập nhật thông tin người dùng
    $user->name = $request->name;
    $user->email = $request->email;
    $user->phone = $request->phone;
    $user->gender = $request->gender;
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
