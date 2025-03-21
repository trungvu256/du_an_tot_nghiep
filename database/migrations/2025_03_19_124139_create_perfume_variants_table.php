<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');

            $table->string('size', 50); // Giới hạn độ dài 50 ký tự
            $table->string('concentration', 50); // Giới hạn độ dài 50 ký tự
            $table->string('special_edition', 50)->nullable(); // Giới hạn 50 ký tự

            $table->decimal('price', 10, 2)->default(0);
            $table->decimal('price_sale', 10, 2)->nullable();
            $table->integer('stock_quantity')->default(0);
            $table->string('sku', 100)->unique(); // Giới hạn SKU để tránh lỗi index dài

            $table->enum('status', ['active', 'inactive'])->default('active');

            // Quan hệ cha - con
            $table->foreignId('parent_id')->nullable()->constrained('product_variants')->onDelete('cascade')->index();

            $table->timestamps();

            // Unique constraint với độ dài giới hạn
            $table->unique(['product_id', 'size', 'concentration', 'special_edition', 'parent_id'], 'product_variant_unique');
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_variants');
    }
};
