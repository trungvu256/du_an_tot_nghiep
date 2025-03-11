<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'payment_method')) {
                $table->dropColumn('payment_method'); // Xóa cột cũ
            }
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->tinyInteger('payment_method')->default(0)->after('payment_status'); 
            // 0: Tiền mặt, 1: Chuyển khoản, 2: Ví điện tử
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'payment_method')) {
                $table->dropColumn('payment_method');
            }
            $table->string('payment_method')->nullable()->after('payment_status'); // Khôi phục về kiểu string
        });
    }
};

