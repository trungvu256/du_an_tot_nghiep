<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() {
        $users = User::all();
        $title = 'List Users';
        return view('admin.user.index',compact('title','users'));
    }
    public function create() {
        $title = 'Add Users';
        return view('admin.user.add',compact('title'));
    }
    public function store(Request $request) {
        $request->validate([
              'name'=> 'required',
              'email'=>'required|email|unique:users',
              'password'=>'required|min:6|max:25',
              'confirm-password'=>'same:password',
              'is_admin'=>'required'
        ]);
        User::create([
           'name'=>$request->name,
           'email'=>$request->email,
           'password'=> bcrypt($request->password),
           'is_admin'=>$request->is_admin,
        ]);
        return redirect()->route('admin.user')->with('success','Created User Succesfully');
    }
    public function delete($id) {
        User::find($id)->delete();
        return redirect()->route('admin.user')->with('success','Deleted User Succesfully');
    }
    public function edit($id) {
        $user = User::find($id);
        $title = 'Edit User';
        return view('admin.user.edit',compact('user','title'));
    }
    public function update(Request $request,$id) {
        $request->validate([
            'name' => 'required',
            'is_admin' => 'required',
            'email' => 'required|email',
        ]);
        $user = User::find($id);
        $data = [
            'name'=>$request->name,
            'is_admin'=>$request->is_admin,
            'email'=>$request->email,
        ];
        if($request->password) {
            $request->validate([
             'password' => 'required|min:6|max:25',
             'confirm-password' => 'same:password',
            ]);
            $data['password'] = bcrypt($request->password);        
         }
        $user->update($data);    
        return redirect()->route('admin.user')->with('success', 'Updated user successfully !');
    }
}
