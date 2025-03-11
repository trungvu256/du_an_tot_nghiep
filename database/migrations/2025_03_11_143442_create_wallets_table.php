<?php

// ví điện tử
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->unique()->onDelete('cascade');
            $table->decimal('balance', 10, 2)->default(0); // Số dư ví
            $table->timestamps();
        });
        
    }

    public function down()
    {
        Schema::dropIfExists('wallets');
    }
};