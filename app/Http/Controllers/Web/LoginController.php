<?php

namespace App\Http\Controllers\Web;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\VarDumper\Caster\RdKafkaCaster;

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
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {    
            if(isset($_GET['checkout']) && $_GET['checkout'] == 'lolo') {
                
            }
            return redirect('/');
        } 
        else {
            return redirect()->back();
        }
    }
    public function registerStore(Request $request)
    {
        $newMenber = new User();
        $newMenber->name = $request->name;
        $newMenber->email = $request->email;
        $newMenber->password = bcrypt($request->password);
        $newMenber->is_admin = 0;
        $newMenber->save();
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
