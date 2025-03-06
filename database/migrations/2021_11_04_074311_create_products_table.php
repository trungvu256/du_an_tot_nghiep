<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_code')->unique();
            $table->string('name');
            $table->text('description');
            $table->integer('price');
            $table->integer('price_sale')->nullable();
            $table->string('image');
            $table->string('sex'); // Giới tính
            $table->string('brand'); // Thương hiệu
            $table->string('longevity'); // Độ lưu hương
            $table->string('concentration'); // Nồng độ
            $table->string('origin'); // Xuất xứ
            $table->string('style'); // Phong cách
            $table->string('fragrance_group'); // Nhóm hương
            $table->integer('stock_quantity')->default(0);
            $table->bigInteger('category_id')->unsigned();
        
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
