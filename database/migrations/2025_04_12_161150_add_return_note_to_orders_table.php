<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddReturnNoteToOrdersTable extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('orders', 'return_note')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->text('return_note')->nullable()->after('status');
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('orders', 'return_note')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn('return_note');
            });
        }
    }
}


