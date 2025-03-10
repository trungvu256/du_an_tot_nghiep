<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\Order;
class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 10; $i++) {
            Order::create([
                'name' => 'Khách hàng ' . $i,
                'email' => 'khach' . $i . '@example.com',
                'phone' => '09876543' . $i,
                'address' => 'Số ' . $i . ', Đường XYZ, Hà Nội',
                'id_user' => rand(1, 4), // Giả sử có 4 users
                'total_price' => rand(100000, 2000000), // Tổng tiền ngẫu nhiên
                'created_at' => Carbon::now()->subDays(rand(1, 30)),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
