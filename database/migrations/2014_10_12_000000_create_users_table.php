<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable(); // Thêm họ
            $table->string('last_name')->nullable();  // Thêm tên đầy đủ
            $table->string('name');                    // Tên cũ (nếu cần có thể bỏ nếu dùng first + last)
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phone')->nullable();       // Thêm số điện thoại
            $table->string('address')->nullable();     // Thêm địa chỉ
            $table->tinyInteger('status')->default(1);
            $table->string('gender');
            $table->boolean('is_admin')->default(0); // Thêm cột is_admin mặc định là 0 (người dùng thường)
            $table->string('avatar')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
