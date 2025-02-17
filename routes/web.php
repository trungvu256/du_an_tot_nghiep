<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\MainController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\LoginController as WebLoginController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::prefix('admin')->group(function () {
    Route::get('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/login', [LoginController::class, 'loginAdmin'])->name('admin.login.store');
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
});

Route::middleware(['auth'])->group(function () {

    Route::prefix('admin')->group(function () {
        Route::get('/main', [MainController::class, 'index'])->name('admin.main');
        });
        Route::prefix('user')->group(function () {
            route::get('/',[UserController::class,'index'])->name('admin.user');
            route::get('/add',[UserController::class,'create'])->name('admin.create.user');
            route::post('/add',[UserController::class,'store'])->name('admin.store.user');
            route::get('/edit/{id}',[UserController::class,'edit'])->name('admin.edit.user');
            route::post('/update/{id}',[UserController::class,'update'])->name('admin.update.user');
            route::get('/delete/{id}',[UserController::class,'delete'])->name('admin.delete.user');

        });


});
    //website
route::get('/',[HomeController::class,'index'])->name('web.index');
//Login web
Route::get('/login',[WebLoginController::class,'index'])->name('web.login');
Route::post('/login',[WebLoginController::class,'store'])->name('login.store.web');
Route::get('/register',[WebLoginController::class,'register'])->name('web.register');
Route::post('/register',[WebLoginController::class,'registerStore'])->name('web.register.store');
Route::get('/logout',[WebLoginController::class,'logout'])->name('web.logout');

//Forget Password
Route::get('/forget',[WebLoginController::class,'forget'])->name('web.forget');
Route::post('/forget',[WebLoginController::class,'postForget'])->name('web.post.forget');
Route::get('/getPass',[WebLoginController::class,'getPass'])->name('web.getPass');
Route::post('/getPass/{id}',[WebLoginController::class,'savePass'])->name('web.getPass.post');

//Checkout
Route::get('/checkout',[HomeController::class,'checkout'])->name('web.checkout');
Route::post('/checkout',[HomeController::class,'checkoutPost'])->name('web.checkout.post');

//Login with Google
Route::get('login/google', [HomeController::class, 'redirectToGoogle'])->name('login.google');
Route::get('login/google/callback', [HomeController::class, 'handleGoogleCallback']);

// Admin 
Route::get('/admin', [ProductController::class, 'list'])->name('admin.list');
Route::get('/create/admin', [ProductController::class, 'create'])->name('admin.create');
Route::post('/create/admin', [ProductController::class, 'store'])->name('admin.store');
Route::delete('/delete/{id}',  [ProductController::class, 'destroy'])->name('admin.destroy');
Route::get('/edit/admin/{id}', [ProductController::class, 'edit'])->name('admin.edit');
Route::put('/edit/admin/{id}', [ProductController::class, 'update'])->name('admin.update');
