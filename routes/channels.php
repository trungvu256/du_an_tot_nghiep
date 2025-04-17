<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/


Broadcast::routes(['middleware' => ['auth:web']]);

// Cho phép người dùng truy cập kênh chat nếu họ là người gửi hoặc người nhận
Broadcast::channel('chat.{id}', function ($user, $id) {
    return true; // Cho phép tất cả người dùng đã xác thực truy cập kênh
});