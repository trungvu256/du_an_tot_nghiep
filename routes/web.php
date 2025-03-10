<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\MainController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\LoginController as WebLoginController;
use App\Models\Category;
use App\Http\Controllers\Web\WebController;

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
Route::get('/admin/unban-user/{id}', [UserController::class, 'unbanUser'])->name('admin.unban.user');

Route::middleware(['auth'])->group(function () {

    Route::prefix('admin')->group(function () {
        Route::get('/', [MainController::class, 'index'])->name('admin.dashboard');
        Route::prefix('category')->group(function () {
            route::get('/', [CategoryController::class, 'index'])->name('admin.cate');
            route::get('/add', [CategoryController::class, 'create'])->name('admin.create.cate');
            route::post('/add', [CategoryController::class, 'store'])->name('admin.store.cate');
            route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('admin.edit.cate');
            route::post('/update/{id}', [CategoryController::class, 'update'])->name('admin.update.cate');
            route::delete('/delete/{id}', [CategoryController::class, 'delete'])->name('admin.delete.cate');
            route::get('/admin/cate/trash', [CategoryController::class, 'trash'])->name('admin.trash.cate');
            route::post('/admin/cate/restore/{id}', [CategoryController::class, 'restore'])->name('admin.restore.cate');
            route::delete('/admin/cate/fore-delete/{id}', [CategoryController::class, 'foreDelete'])->name('admin.foreDelete.cate');

        });
        Route::prefix('user')->group(function () {
            route::get('/', [UserController::class, 'index'])->name('admin.user');
            route::get('/add', [UserController::class, 'create'])->name('admin.create.user');
            route::post('/add', [UserController::class, 'store'])->name('admin.store.user');
            route::get('/edit/{id}', [UserController::class, 'edit'])->name('admin.edit.user');
            route::post('/update/{id}', [UserController::class, 'update'])->name('admin.update.user');
            route::get('/delete/{id}', [UserController::class, 'destroy'])->name('admin.delete.user');
        });

        //Bình luận
        Route::prefix('comment')->group(function () {
            route::get('/', [CommentController::class, 'index'])->name('admin.comment');
            route::get('/create', [CommentController::class, 'create'])->name('create.comment');
            route::post('/store', [CommentController::class, 'store'])->name('store.comment');
            route::patch('/showhidden/{id}', [CommentController::class, 'Hide_comments'])->name('admin.comment.showhidden');
        });
        Route::prefix('product')->group(function () {
            route::get('/', [ProductController::class, 'index'])->name('admin.product');
            route::get('/add', [ProductController::class, 'create'])->name('admin.add.product');
            route::post('/add', [ProductController::class, 'store'])->name('admin.store.product');
            route::get('/show/{id}', [ProductController::class, 'show'])->name('admin.show.product');
            route::get('/edit/{id}', [ProductController::class, 'edit'])->name('admin.edit.product');
            route::post('/update/{id}', [ProductController::class, 'update'])->name('admin.update.product');
            route::delete('/delete/{id}', [ProductController::class, 'delete'])->name('admin.delete.product');
            Route::get('/del-image/{id}', [ProductController::class, 'delete_img'])->name('admin.delete_img.product');
            route::get('/admin/product/trash', [ProductController::class, 'trash'])->name('admin.trash.product');
            route::post('/admin/product/restore/{id}', [ProductController::class, 'restore'])->name('admin.restore.product');
            route::delete('/admin/product/fore-delete/{id}', [ProductController::class, 'foreDelete'])->name('admin.foreDelete.product');
        });

        // Blog
        Route::prefix('blog')->group(function () {
            route::get('/', [BlogController::class, 'index'])->name('admin.blog');
            route::get('/add', [BlogController::class, 'create'])->name('admin.create.blog');
            route::post('/add', [BlogController::class, 'store'])->name('admin.store.blog');
            route::get('/edit/{id}', [BlogController::class, 'edit'])->name('admin.edit.blog');
            route::post('/update/{id}', [BlogController::class, 'update'])->name('admin.update.blog');
            route::delete('/delete/{id}', [BlogController::class, 'delete'])->name('admin.delete.blog');
            route::get('/show/{id}', [BlogController::class, 'show'])->name('admin.show.blog');
            route::post('/admin/upload-image', [BlogController::class, 'uploadImage'])->name('admin.upload.image');
            route::get('/trash', [BlogController::class, 'trash'])->name('admin.trash.blog');
            route::get('/soft-delete/{id}', [BlogController::class, 'softDelete'])->name('admin.softdelete.blog');
            route::get('/restore/{id}', [BlogController::class, 'restore'])->name('admin.restore.blog');
            route::delete('/force-delete/{id}', [BlogController::class, 'forceDelete'])->name('admin.forceDelete.blog');
        });

        //dasboard
        Route::get('/admin/revenue-data', [DashboardController::class, 'getRevenueData']);
        Route::get('/admin/best-selling-products', [DashboardController::class, 'getBestSellingProducts']);



    });

    Route::prefix('user')->group(function () {
        Route::get('/cart', [WebController::class, 'cart'])->name('user.cart');
        Route::get('/checkout', [WebController::class, 'checkout'])->name('user.checkout');
        Route::get('/contact', [WebController::class, 'contact'])->name('user.contact');
    });
    Route::get('/profile', [ProfileController::class, 'showProfile'])->name('profile');
    Route::get('/profile/confirm-password', [ProfileController::class, 'confirmPassword'])->name('profile.confirm_password');
    Route::post('/profile/confirm-password', [ProfileController::class, 'checkPassword'])->name('profile.check_password');
    Route::get('/profile/edit', [ProfileController::class, 'editProfile'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
});
//Login web
Route::get('/login', [WebLoginController::class, 'index'])->name('web.login');
Route::post('/login', [WebLoginController::class, 'store'])->name('login.store.web');
Route::get('/register', [WebLoginController::class, 'register'])->name('web.register');
Route::post('/register', [WebLoginController::class, 'registerStore'])->name('web.register.store');
Route::get('/logout', [WebLoginController::class, 'logout'])->name('web.logout');

//Forget Password
Route::get('/forget', [WebLoginController::class, 'forget'])->name('web.forget');
Route::post('/forget', [WebLoginController::class, 'postForget'])->name('web.post.forget');
Route::get('/getPass', [WebLoginController::class, 'getPass'])->name('web.getPass');
Route::post('/getPass/{id}', [WebLoginController::class, 'savePass'])->name('web.getPass.post');

//Checkout
Route::get('/checkout', [HomeController::class, 'checkout'])->name('web.checkout');
Route::post('/checkout', [HomeController::class, 'checkoutPost'])->name('web.checkout.post');

//Login with Google
Route::get('login/google', [HomeController::class, 'redirectToGoogle'])->name('login.google');
Route::get('login/google/callback', [HomeController::class, 'handleGoogleCallback']);

//web
Route::get('/', [WebController::class, 'index'])->name('web.home');
Route::get('/shop', [WebController::class, 'shop'])->name('web.shop');
Route::get('/shop/detail', [WebController::class, 'shopdetail'])->name('web.shop-detail');
