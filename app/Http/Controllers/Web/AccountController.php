<?php

namespace App\Http\Controllers\Web;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserAddress;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\VarDumper\Caster\RdKafkaCaster;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;


class AccountController extends Controller
{
    public function checkaddress()
    {
        $users = User::all();
        $user = Auth::user();
        $addresses = UserAddress::where('user_id', $user->id)->get();
    
        return view('web3.Home.address', compact('user', 'addresses','users'));
    }
    public function store(Request $request)
{
    // Validate dữ liệu đầu vào
    $request->validate([
        'full_name' => 'required|string|max:255',
        'phone' => ['required', 'regex:/^0\d{9}$/'], // bắt đầu bằng 0 và có đúng 10 chữ số
        'address_detail' => 'required|string|max:255',
        'province' => 'required',
        'district' => 'required',
        'ward' => 'required',
    ], [
        'phone.required' => 'Vui lòng nhập số điện thoại.',
        'phone.regex' => 'Số điện thoại phải có đúng 10 chữ số và bắt đầu bằng số 0.',
    ]);

    // Lấy code từ form
    $provinceCode = $request->input('province');
    $districtCode = $request->input('district');
    $wardCode = $request->input('ward');

    // Lấy tên tương ứng
    $provinceData = Http::get("https://provinces.open-api.vn/api/p/{$provinceCode}")->json();
    $districtData = Http::get("https://provinces.open-api.vn/api/d/{$districtCode}?depth=2")->json();

    // Tìm tên phường
    $wardName = '';
    if (!empty($districtData['wards'])) {
        foreach ($districtData['wards'] as $ward) {
            if ($ward['code'] == $wardCode) {
                $wardName = $ward['name'];
                break;
            }
        }
    }

    // Lưu vào database
    UserAddress::create([
        'user_id' => auth()->id(),
        'full_name' => $request->full_name,
        'phone' => $request->phone,
        'address_detail' => $request->address_detail,
        'province' => $provinceData['name'] ?? '',
        'district' => $districtData['name'] ?? '',
        'ward' => $wardName,
        'is_default' => $request->is_default ? 1 : 0,
    ]);

    return redirect()->back()->with('success', 'Thêm địa chỉ thành công');
}

    
    public function destroy($id)
    {
        $address = UserAddress::where('user_id', Auth::id())->findOrFail($id);
        $address->delete();

        return redirect()->back()->with('success', 'Địa chỉ đã được xóa thành công.');
    }

    public function update(Request $request, $id)
{
    // Validate dữ liệu đầu vào
    $request->validate([
        'full_name' => 'required|string|max:255',
        'phone' => ['required', 'regex:/^0\d{9}$/'], // 10 chữ số, bắt đầu bằng 0
        'address_detail' => 'required|string|max:255',
        'province' => 'required',
        'district' => 'required',
        'ward' => 'required',
    ], [
        'phone.required' => 'Vui lòng nhập số điện thoại.',
        'phone.regex' => 'Số điện thoại phải có đúng 10 chữ số và bắt đầu bằng số 0.',
    ]);

    // Tìm địa chỉ cần cập nhật
    $address = UserAddress::where('user_id', auth()->id())->findOrFail($id);

    // Lấy code từ form
    $provinceCode = $request->input('province');
    $districtCode = $request->input('district');
    $wardCode = $request->input('ward');

    // Lấy tên tương ứng
    $provinceData = Http::get("https://provinces.open-api.vn/api/p/{$provinceCode}")->json();
    $districtData = Http::get("https://provinces.open-api.vn/api/d/{$districtCode}?depth=2")->json();

    // Tìm tên phường theo wardCode
    $wardName = '';
    if (!empty($districtData['wards'])) {
        foreach ($districtData['wards'] as $ward) {
            if ($ward['code'] == $wardCode) {
                $wardName = $ward['name'];
                break;
            }
        }
    }

    // Cập nhật địa chỉ trong database
    $address->update([
        'full_name' => $request->full_name,
        'phone' => $request->phone,
        'address_detail' => $request->address_detail,
        'province' => $provinceData['name'] ?? '',
        'district' => $districtData['name'] ?? '',
        'ward' => $wardName,
        'is_default' => $request->is_default ? 1 : 0,
    ]);

    return redirect()->route('address.index')->with('success', 'Cập nhật địa chỉ thành công');
}


public function edit($id)
    {
        $address = UserAddress::where('user_id', Auth::id())->findOrFail($id);
        return view('web3.Home.address', compact('address'));
    }
}
