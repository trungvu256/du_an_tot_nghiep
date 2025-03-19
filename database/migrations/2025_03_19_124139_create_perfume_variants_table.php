<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerfumeVariantsTable extends Migration
{
    public function up()
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->string('size'); // Dung tích (30ml, 50ml, 100ml)
            $table->string('concentration'); // Nồng độ (EDT, EDP, Parfum)
            $table->string('special_edition')->nullable(); // Phiên bản đặc biệt (Limited, Exclusive,...)
            $table->decimal('price', 10, 2); // Giá gốc
            $table->decimal('price_sale', 10, 2)->nullable(); // Giá giảm
            $table->integer('stock_quantity')->default(0); // Tồn kho theo biến thể
            $table->timestamps();
        });
        
    }
    
    public function down()
    {
        Schema::dropIfExists('perfume_variants');
    }
}
