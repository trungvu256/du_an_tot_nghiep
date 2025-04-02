<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVnpTxnRefToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::table('orders', function (Blueprint $table) {
        $table->string('vnp_TxnRef')->nullable(); // Thêm cột vnp_TxnRef
    });
}

public function down()
{
    Schema::table('orders', function (Blueprint $table) {
        $table->dropColumn('vnp_TxnRef'); // Xóa cột vnp_TxnRef nếu cần rollback
    });
}

}
