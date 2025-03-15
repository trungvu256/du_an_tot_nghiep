<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountedProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discounted_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('discount_id'); // ID của chương trình giảm giá
            $table->unsignedBigInteger('product_id'); // ID của sản phẩm
            $table->timestamps();

            // Khóa ngoại
            $table->foreign('discount_id')->references('id')->on('discounts')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discounted_products');
    }
}
