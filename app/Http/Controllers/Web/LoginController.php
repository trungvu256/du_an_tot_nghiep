<?php

namespace App\Http\Controllers\Web;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\VarDumper\Caster\RdKafkaCaster;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;


class LoginController extends Controller
{
    public function index()
    {
        $categories = Category::where('parent_id', 0)->get();
        $categories_2 = Category::all();
        $categories_3 = Category::all();
        return view('web.login', compact('categories', 'categories_2', 'categories_3'));
    }
    public function register()
    {
        $categories = Category::where('parent_id', 0)->get();
        $categories_2 = Category::all();
        $categories_3 = Category::all();
        return view('web.register', compact('categories', 'categories_2', 'categories_3'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
    
        // Tìm user theo email
        $user = User::where('email', $request->email)->first();
    
        if (!$user) {
            return back()->with('error', 'Email không đúng.');
        }
        if (!Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Mật khẩu không đúng.');
        }
    
    
        // 🔥 Kiểm tra đúng thứ tự: Tài khoản có tồn tại => Check trạng thái => Kiểm tra mật khẩu
        if ($user->status == 0) {
            return back()->with('error', 'Tài khoản của bạn đã bị khóa. Vui lòng liên hệ hỗ trợ.');
        }
    
        // Nếu tài khoản không bị khóa, kiểm tra đăng nhập
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect('/');
        }
    
        // Nếu mật khẩu sai, chỉ thông báo lỗi mật khẩu
        return response()->json(['message' => 'Email hoặc mật khẩu không đúng, Vui lòng thử lại sau.'], 500);
    }
    

    public function registerStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'required|string|regex:/^0[1-9][0-9]{8}$/|unique:users,phone',
            'address' => 'nullable|string|max:255',
            'gender' => 'required|string|in:Male,Female,Other',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'agree_terms' => 'accepted',
        ], [
            'email.unique' => 'Email này đã được sử dụng.',
            'phone.unique' => 'Số điện thoại này đã được sử dụng.',
            'phone.regex' => 'Số điện thoại phải bắt đầu bằng số 0 và có đúng 10 chữ số.',
            'agree_terms.accepted' => 'Bạn phải đồng ý với điều khoản sử dụng.',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }
    
        // Xử lý ảnh đại diện nếu có
        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            try {
                $avatarPath = $request->file('avatar')->store('avatars', 'public');
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'errors' => ['avatar' => 'Tải ảnh đại diện thất bại.'],
                ], 422);
            }
        }
    
        // Lưu vào database
        $user = new User();
        $user->first_name = trim($request->first_name);
        $user->last_name = trim($request->last_name);
        $user->name = $user->first_name . ' ' . $user->last_name;
        $user->email = trim($request->email);
        $user->password = Hash::make($request->password);
        $user->phone = trim($request->phone);
        $user->address = trim($request->address);
        $user->gender = $request->gender;
        $user->avatar = $avatarPath;
        $user->status = 1;
        $user->is_admin = 0;
        $user->save();
    
        return response()->json([
            'success' => true,
            'message' => 'Tài khoản của bạn đã được tạo thành công!',
            'redirect' => url('/')
        ]);
    }


    public function logout()
    {
        
        Auth::logout();
        session()->flush();
        return redirect('/');
    }
    public function forget()
    {
        $categories = Category::where('parent_id', 0)->get();
        $categories_2 = Category::all();
        $categories_3 = Category::all();
        return view('web.forget', compact('categories', 'categories_2', 'categories_3'));
    }
    public function postForget(Request $request)
    {
        $email = $request->email;
        $checkUser = User::where('email', $email)->first();
        if (!$checkUser) {
            return redirect()->back()->with('danger', 'This email does not exist !');
        }
        $code = bcrypt(md5(time() . $email));
        $checkUser->code = $code;
        $checkUser->time_code =  Carbon::now();
        $checkUser->save();
        $url = route('web.getPass', ['code' => $checkUser->code, 'email' => $email]);
        $data = [
            'route' => $url
        ];
        Mail::send('web.email.reset_password', $data, function ($message) use ($email) {
            $message->to($email, 'Reset Password')->subject('Get password again!');
        });
        return redirect()->back()->with('success', 'Get Password in your email link !');
    }
    public function getPass(Request $request)
    {
        $categories = Category::where('parent_id', 0)->get();
        $categories_2 = Category::all();
        $categories_3 = Category::all();
        $code = $request->code;
        $email = $request->email;
        $checkUser = User::where([
            'code' => $code,
            'email' => $email
        ])->first();
        if (!$checkUser) {
            return redirect('/')->with('danger', 'Sorry, Your link to get password is erorr, Pls check it again');
        }
       
        return view('web.reset', compact('categories', 'categories_2', 'categories_3','checkUser'));
    }
    public function savePass(Request $request, $id) {
        $request->validate([
            'password'=>'required',
            'cf_password'=>'same:password'
        ]);
        $user = User::find($id);
        if($user) {
            $user->password = bcrypt($request->password);
            $user->save();
            return redirect('/');
        }
    }
   
}
