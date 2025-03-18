<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Tên nhóm khách hàng (VIP, Thân thiết, Mới,...)
            $table->decimal('min_order_value', 10, 2)->default(0); // Giá trị đơn hàng tối thiểu để vào nhóm
            $table->integer('min_order_count')->default(0); // Số lượng đơn hàng tối thiểu để vào nhóm
            $table->text('description')->nullable(); // Mô tả về nhóm khách hàng
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
        Schema::dropIfExists('customer_groups');
    }
}