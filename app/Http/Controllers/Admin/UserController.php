<?php

namespace App\Http\Controllers\Admin;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class UserController
{
    public function index()
    {
        $title = "List User";
        $users = User::paginate(10);
        return view('admin.user.index', compact('title', 'users'));
    }

    public function create()
    {
        $users = User::all();
        $title = "Add User";
        return view('admin.user.add', compact('title', 'users'));

    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:0,1',
            'is_admin' => 'required|in:0,1',
        ]);

        $user = User::findOrFail($id);
        $user->status = $request->status;
        $user->is_admin = $request->is_admin;

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Cập nhật thành công!');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'is_admin' => 'nullable|in:0,1'
        ]);
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'is_admin' => in_array($request->is_admin, [0, 1]) ? $request->is_admin : 0
        ]);
        return back()->with('success', 'Created user succesfull !');
    }
}
