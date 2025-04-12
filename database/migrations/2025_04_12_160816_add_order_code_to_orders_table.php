<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrderCodeToOrdersTable extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('orders', 'order_code')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->string('order_code', 20)->unique()->after('payment_deadline');
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('orders', 'order_code')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn('order_code');
            });
        }
    }
}
