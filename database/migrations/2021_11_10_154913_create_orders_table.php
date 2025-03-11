<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable()->change();
            $table->string('email');
            $table->string('phone');
            $table->string('address');
            $table->bigInteger('id_user')->unsigned();
            $table->decimal('total_price', 10, 2)->default(0); // Tổng tiền
            $table->string('payment_status')->default('pending'); // Trạng thái thanh toán
            $table->tinyInteger('status')->default(0); // Trạng thái đơn hàng
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('orders');
    }
}
