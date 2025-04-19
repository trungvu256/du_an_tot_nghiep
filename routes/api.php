<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\Web\WebProductController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// routes/api.php
// routes/api.php


Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/send-message', [ChatController::class, 'sendMessage']);
Route::middleware('auth:sanctum')->get('/messages', [ChatController::class, 'getMessages']);

// Thêm route API cho đánh giá sản phẩm
Route::get('/products/{product}/variants/{variant}/reviews', [WebProductController::class, 'getVariantReviews']);