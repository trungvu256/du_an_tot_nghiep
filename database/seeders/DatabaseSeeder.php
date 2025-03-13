<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Tạo tài khoản admin
        User::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456789'), // Mã hoá mật khẩu để bảo mật
            'phone' => '0123456789',
            'address' => '123 Đường ABC, TP. HCM',
            'status' => 1,
            'gender' => 'male',
            'is_admin' => 1, // 1 = Admin
            'avatar' => 'default-avatar.png',
            'remember_token' => Str::random(10),
        ]);

        // Tạo tài khoản user thường
        User::create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'name' => 'John Doe',
            'email' => 'user@gmail.com',
            'password' => Hash::make('123456789'),
            'phone' => '0987654321',
            'address' => '456 Đường XYZ, Hà Nội',
            'status' => 1,
            'gender' => 'male',
            'is_admin' => 0, // 0 = user
            'avatar' => 'default-avatar.png',
            'remember_token' => Str::random(10),
        ]);
    }
}
