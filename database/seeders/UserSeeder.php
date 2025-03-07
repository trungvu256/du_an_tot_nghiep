<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Khách A',
                'email' => 'khacha@example.com',
                'password' => bcrypt('password'),
                'is_admin' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Khách B',
                'email' => 'khachb@example.com',
                'password' => bcrypt('password'),
                'is_admin' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

    }
}
