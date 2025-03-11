<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wallet_id')->constrained()->onDelete('cascade'); // Liên kết với bảng ví
            $table->decimal('amount', 10, 2); // Số tiền
            $table->string('type'); // 'deposit' (nạp) hoặc 'withdraw' (trừ)
            $table->string('description')->nullable(); // Mô tả giao dịch
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('wallet_transactions');
    }
};

