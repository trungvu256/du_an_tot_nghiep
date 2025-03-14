<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'branch')) {
                $table->string('branch')->nullable()->after('status');
            }
            if (!Schema::hasColumn('orders', 'region')) {
                $table->string('region')->nullable()->after('branch');
            }
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'branch')) {
                $table->dropColumn('branch');
            }
            if (Schema::hasColumn('orders', 'region')) {
                $table->dropColumn('region');
            }
        });
    }
};

