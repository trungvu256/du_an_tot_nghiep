<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('brands')->insert([
            [
                'name' => 'Chanel',
                'description' => 'Thương hiệu nước hoa cao cấp từ Pháp, nổi tiếng với Chanel No. 5.',
            ],
            [
                'name' => 'Dior',
                'description' => 'Hãng thời trang và nước hoa sang trọng với dòng Miss Dior, Sauvage.',
            ],
            [
                'name' => 'Gucci',
                'description' => 'Thương hiệu thời trang Ý với các dòng nước hoa nổi bật như Gucci Bloom.',
            ],
            [
                'name' => 'Yves Saint Laurent',
                'description' => 'Nổi tiếng với nước hoa Black Opium, Libre và L’Homme.',
            ],
            [
                'name' => 'Tom Ford',
                'description' => 'Thương hiệu nước hoa cao cấp với Black Orchid, Oud Wood.',
            ],
        ]);
    }
}
