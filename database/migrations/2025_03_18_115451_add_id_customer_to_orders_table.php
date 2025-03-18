<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdCustomerToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::table('orders', function (Blueprint $table) {
        // Kiểm tra xem cột 'id_customer' đã tồn tại hay chưa
        if (!Schema::hasColumn('orders', 'id_customer')) {
            $table->unsignedBigInteger('id_customer')->nullable(); // Thêm cột 'id_customer'
        }
    });
}

public function down()
{
    Schema::table('orders', function (Blueprint $table) {
        // Kiểm tra xem cột 'id_customer' có tồn tại trước khi xóa
        if (Schema::hasColumn('orders', 'id_customer')) {
            $table->dropColumn('id_customer');
        }
    });
}

}