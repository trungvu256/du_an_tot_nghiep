<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */

    public function up(): void
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');

            $table->string('variant_name'); // Tên biến thể (VD: "Nước hoa 50ml")
            $table->decimal('price', 10, 2); // Giá cho từng biến thể
            $table->integer('size'); // Dung tích nước hoa (ml)
            $table->integer('stock'); // Số lượng tồn kho

            $table->string('sku')->unique(); // Mã SKU riêng cho từng biến thể
            $table->string('image_url')->nullable(); // Ảnh riêng của biến thể (nếu có)

            $table->enum('status', ['active', 'inactive'])->default('active'); // Trạng thái biến thể

            $table->softDeletes();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
