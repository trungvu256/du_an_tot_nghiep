<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            ['id' => 1, 'name' => 'Danh mục 1', 'slug' => 'danh-muc-1'],
            ['id' => 2, 'name' => 'Danh mục 2', 'slug' => 'danh-muc-2'],
        ]);

    }
}
