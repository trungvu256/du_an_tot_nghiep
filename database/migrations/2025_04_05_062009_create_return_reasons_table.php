<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReturnReasonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('return_reasons', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // Lý do hủy
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('return_reasons');
}
}
