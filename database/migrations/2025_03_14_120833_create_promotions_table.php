<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->decimal('discount_value', 15, 2);
            $table->enum('status', ['active', 'inactive']);
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('type', ['percentage', 'fixed_amount', 'free_shipping']);
            $table->decimal('min_order_value', 10, 2)->nullable();  // Cho phép NULL ở đây
            $table->decimal('max_value', 10, 2)->nullable();  // Cho phép NULL ở đây
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
        Schema::dropIfExists('promotions');
    }
}
