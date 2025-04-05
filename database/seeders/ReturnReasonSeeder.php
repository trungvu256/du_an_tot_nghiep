<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;

use Illuminate\Database\Seeder;

class ReturnReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('return_reasons')->insert([
            ['name' => 'Sản phẩm không đúng mô tả'],
            ['name' => 'Sản phẩm bị lỗi'],
            ['name' => 'Tôi thay đổi ý định mua hàng'],
            ['name' => 'Sản phẩm không phù hợp'],
            ['name' => 'Nhận được sản phẩm sau quá lâu'],
        ]);
    }
}
