<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    if (!Schema::hasTable('transactions')) {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id')->nullable()->unique();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('wallet_id');
            $table->integer('amount');
            $table->string('bank_code')->nullable();
            $table->string('status'); // success, failed, pending
            $table->string('response_code')->default('00'); // Thêm giá trị mặc định cho response_code
            $table->timestamps();
    
            // Thêm các chỉ mục cho các trường thường xuyên truy vấn
            $table->index(['user_id', 'wallet_id']);
            $table->index('transaction_id');
        });
    }
}
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}