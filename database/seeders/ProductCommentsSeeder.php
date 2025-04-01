<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class ProductCommentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Xóa dữ liệu cũ nếu cần
        Schema::disableForeignKeyConstraints();
        DB::table('product_comments')->truncate();
        Schema::enableForeignKeyConstraints();

        // Dữ liệu mẫu
        $comments = [
            [
                'product_id' => 1,
                'user_id' => 4,
                'comment' => 'Sản phẩm này rất tốt, tôi rất hài lòng!',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'product_id' => 1,
                'user_id' => 4,
                'comment' => 'Giá hơi cao nhưng chất lượng tuyệt vời!',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        // Chèn vào database
        DB::table('product_comments')->insert($comments);
    }
}
