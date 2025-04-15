<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CommentReplyController;
use App\Http\Controllers\Admin\ProductCommentController;
use App\Http\Controllers\Admin\ProductCommentReplyController;
use App\Http\Controllers\Admin\ProductReviewController;
use App\Http\Controllers\Admin\ReviewResponseController;
use App\Http\Controllers\Admin\CustomerGroupController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Web2\Web2Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\MainController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductVariantController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\AttributeValueController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ReturnOrderController;
use App\Http\Controllers\Admin\ShippingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WalletController;
use App\Http\Controllers\Auth\LoginGoogleController;
use App\Http\Controllers\Admin\CatalogueController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\ChatController as AdminChatController;
use App\Http\Controllers\Web\HomeController;

use App\Http\Controllers\Admin\DiscountController as AdminDiscountController;
use App\Http\Controllers\Admin\PerfumeVariantController;
use App\Http\Controllers\Admin\PromotionController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\Web\BlogController as WebBlogController;
use App\Http\Controllers\Web\CartController;
use App\Http\Controllers\Web\CheckoutController;
use App\Http\Controllers\Web\LoginController as WebLoginController;
use App\Http\Controllers\Web\OrderController as WebOrderController;
use App\Http\Controllers\Web\WalletController as WebWalletController;
use App\Http\Controllers\Web\ProfileController;
use App\Models\Category;
use App\Http\Controllers\Web\WebController;
use App\Http\Controllers\Web\WebProductController;
use App\Mail\OrderPlacedMail;
use App\Services\GHTKService;
use Illuminate\Support\Facades\Mail;

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

Route::middleware(['auth', 'admin'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
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

        // Đánh giá
        Route::resource('product-reviews', ProductReviewController::class);

        // Quản lý đánh giá sản phẩm
        Route::post('product-reviews/respond/{id}', [ProductReviewController::class, 'respond'])->name('product-reviews.respond');
        Route::get('product-reviews-trash', [ProductReviewController::class, 'trash'])->name('product-reviews.trash');
        Route::patch('product-reviews/{id}/restore', [ProductReviewController::class, 'restore'])->name('product-reviews.restore');
        Route::delete('product-reviews/{id}/delete-permanently', [ProductReviewController::class, 'deletePermanently'])->name('product-reviews.delete-permanently');

        // Quản lý phản hồi đánh giá sản phẩm
        Route::get('product-reviews/{review}/response/{response}/edit', [ReviewResponseController::class, 'editResponse'])->name('product-reviews.response.edit');
        Route::put('product-reviews/{review}/response/{response}', [ReviewResponseController::class, 'updateResponse'])->name('product-reviews.response.update');
        /// order

        Route::prefix('order')->group(function () {
            route::get('/order', [OrderController::class, 'index'])->name('admin.order');
            route::get('/order/{id}', [OrderController::class, 'show'])->name('admin.show.order');
            route::post('/orders/update-status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
            route::post('/orders/{id}/updatePaymenStatus', [OrderController::class, 'updatePaymenStatus'])->name('orders.updatePaymenStatus');
            route::get('/admin/orders/unfinished', [OrderController::class, 'unfinishedOrders'])->name('admin.orders.unfinished');
            Route::post('/admin/orders/ship/{id}', [OrderController::class, 'shipOrder'])->name('admin.order.ship');
            Route::post('/order/{id}/request-return', [OrderController::class, 'requestReturn'])->name('admin.order.requestReturn');
        });

        // ví điện tử
        Route::prefix('wallet')->group(function () {
            route::get('/wallet', [WalletController::class, 'show'])->name('wallet.show');
            route::post('/wallet/{order}/refund', [WalletController::class, 'refund'])->name('wallet.refund');
            route::post('/wallet/deposit', [WalletController::class, 'deposit'])->name('wallet.deposit');
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
        Route::prefix('customer-groups')->group(function () {

            // Route để hiển thị danh sách nhóm khách hàng
            Route::get('/customer', [CustomerGroupController::class, 'index'])->name('customer.index');

            // Route để tạo nhóm khách hàng mới
            Route::get('/customercreate', [CustomerGroupController::class, 'create'])->name('customer.create');
            Route::post('/customer', [CustomerGroupController::class, 'store'])->name('customer.store');

            // Route để chỉnh sửa nhóm khách hàng
            Route::get('/{group}/edit', [CustomerGroupController::class, 'edit'])->name('customer.edit');
            Route::put('/{group}', [CustomerGroupController::class, 'update'])->name('customer.update');

            // Route để xóa nhóm khách hàng
            Route::delete('/{group}', [CustomerGroupController::class, 'destroy'])->name('customer.destroy');

            // Route để phân nhóm khách hàng (phân loại khách hàng)
            Route::get('/assign', [CustomerGroupController::class, 'assignCustomerGroups'])->name('customer.assign');
            // Hiển thị form đưa khách hàng vào nhóm
            Route::get('customer-groups/{groupId}/assign', [CustomerGroupController::class, 'assignCustomers'])->name('customer.assign_customers');

            // Lưu khách hàng vào nhóm
            Route::post('customer-groups/{groupId}/assign', [CustomerGroupController::class, 'storeAssignedCustomers'])->name('customer.store_assigned_customers');

            // show
            Route::get('customer-groups/{group}/customers', [CustomerGroupController::class, 'show'])->name('customer.show_customers');
        });

        // Giảm giá theo catalogues
        Route::get('admin/catalogues', [AdminDiscountController::class, 'showDiscountToCatalogue'])->name('admin.catalogueList');
        Route::post('/catalogues/{catalogueId}/apply-discount', [AdminDiscountController::class, 'applyDiscount'])->name('admin.catalogues.applyDiscount');
        Route::post('/catalogues/{catalogueId}/remove-discount', [AdminDiscountController::class, 'removeDiscount'])
            ->name('admin.catalogues.removeDiscount');

        // Route hiển thị danh sách giảm giá
        Route::resource('discounts', AdminDiscountController::class);

        // Promotions
        Route::resource('promotions', PromotionController::class);

        // Giảm giá thep sản phẩm
        Route::get('/discounts/{discountId}/apply', [AdminDiscountController::class, 'listProductsDiscount'])->name('products.apply');
        Route::post('/discounts/{discountId}/apply', [AdminDiscountController::class, 'applyToProducts'])->name('discount.applyToProducts');

        // Route hủy giảm giá
        Route::post('/admin/admin/discounts/{discountId}/products/remove', [AdminDiscountController::class, 'removeFromProducts'])->name('discounts.remove');

        // Route Catalogue
        Route::resource('catalogues', CatalogueController::class);
        Route::get('catalogues-trash', [CatalogueController::class, 'trash'])->name('catalogues.trash');
        Route::post('catalogues/{id}/restore', [CatalogueController::class, 'restore'])->name('catalogues.restore');
        Route::delete('catalogues/{id}/force-delete', [CatalogueController::class, 'forceDelete'])->name('catalogues.forceDelete');

        // Route quản lý trả hàng
        Route::get('returns', [ReturnOrderController::class, 'index'])->name('admin.returns.index');
        Route::post('returns/{id}/update', [ReturnOrderController::class, 'update'])->name('admin.returns.update');
        Route::get('returns/export', [ReturnOrderController::class, 'export'])->name('admin.returns.export');
        Route::prefix('admin/returns')->group(function () {
            Route::get('/', [ReturnOrderController::class, 'index'])->name('admin.returns.index');
            Route::post('/{order}/approve', [ReturnOrderController::class, 'approveReturn'])->name('admin.returns.approve');
            Route::post('/{order}/decline', [ReturnOrderController::class, 'declineReturn'])->name('admin.returns.decline');
            Route::post('/{order}/update', [ReturnOrderController::class, 'update'])->name('admin.returns.update');
        });

        // Route Brand
        Route::resource('brands', BrandController::class);
        Route::get('brands-trash', [BrandController::class, 'trash'])->name('brands.trash');
        Route::patch('brands/{id}/restore', [BrandController::class, 'restore'])->name('brands.restore');
        Route::delete('brands/{id}/delete-permanently', [BrandController::class, 'deletePermanently'])->name('brands.delete-permanently');

        //  route reply comment post
        Route::get('comments/{comment}/reply/{reply}/edit', [CommentReplyController::class, 'editReply'])->name('comments.reply.edit');
        Route::put('comments/{comment}/reply/{reply}', [CommentReplyController::class, 'updateReply'])->name('comments.reply.update');
        Route::resource('product-comments', ProductCommentController::class);

        // Phản hồi bình luận sản phẩm (trả lời cho bình luận sản phẩm)
        Route::post('product-comments/respond/{id}', [ProductCommentController::class, 'respond'])->name('product-comments.respond');
        Route::get('product-comments-trash', [ProductCommentController::class, 'trash'])->name('product-comments.trash');
        Route::patch('product-comments/{id}/restore', [ProductCommentController::class, 'restore'])->name('product-comments.restore');
        Route::delete('product-comments/{id}/delete-permanently', [ProductCommentController::class, 'deletePermanently'])->name('product-comments.delete-permanently');

        // Quản lý trả lời bình luận sản phẩm
        Route::get('product-comments/{comment}/reply/{reply}/edit', [ProductCommentReplyController::class, 'editReply'])->name('product-comments.reply.edit');
        Route::put('product-comments/{comment}/reply/{reply}', [ProductCommentReplyController::class, 'updateReply'])->name('product-comments.reply.update');

    });

    Route::middleware(['auth', 'admin'])->group(
        function () {

            Route::prefix('admin')->group(function () {
                Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
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
                //order
                Route::prefix('order')->group(function () {
                    route::get('/order', [OrderController::class, 'index'])->name('admin.order');
                    route::get('/order/{id}', [OrderController::class, 'show'])->name('admin.show.order');
                    route::post('/orders/update-status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
                    route::post('/orders/{id}/updatePaymenStatus', [OrderController::class, 'updatePaymenStatus'])->name('orders.updatePaymenStatus');
                    route::get('/admin/orders/unfinished', [OrderController::class, 'unfinishedOrders'])->name('admin.orders.unfinished');
                    Route::post('/admin/orders/ship/{id}', [OrderController::class, 'shipOrder'])->name('admin.order.ship');
                });

                // Trả hàng
                Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
                    Route::get('/returns', [ReturnOrderController::class, 'index'])->name('admin.return.index');
                    Route::post('/returns/{id}/update', [ReturnOrderController::class, 'update'])->name('admin.returns.update');
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

                // Sản phẩm biến thể
                Route::get('admin/variant', [ProductVariantController::class, 'index'])->name('variant.index');
                Route::get('admin/variant/add', [ProductVariantController::class, 'create'])->name('variant.create');
                Route::post('admin/variant/add', [ProductVariantController::class, 'store'])->name('variant.store');
                Route::post('admin/variant/add-attribute-value', [ProductVariantController::class, 'storeAttributeValue'])->name('variant.storeAttributeValue');
                Route::get('admin/variant/update/{id}', [ProductVariantController::class, 'edit'])->name('variant.edit');
                Route::post('admin/variant/update/{id}', [ProductVariantController::class, 'update'])->name('variant.update');
                Route::delete('admin/variant/delete/{id}', [ProductVariantController::class, 'destroy'])->name('variant.destroy');
                Route::delete('admin/variant/destroyAttributeValue/{id}', [ProductVariantController::class, 'destroyAttributeValue'])->name('variant.destroyAttributeValue');

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
            });

            ///Giao hàng tiết kiệm
            Route::prefix('admin')->group(function () {
                Route::get('shipping/overview', [ShippingController::class, 'overview'])->name('admin.shipping.overview');
                Route::get('shipping/orders', [ShippingController::class, 'orders'])->name('admin.shipping.orders');
                Route::post('shipping/calculate-fee', [ShippingController::class, 'calculateFee'])->name('admin.shipping.calculate_fee');
                Route::post('shipping/update-status/{id}', [ShippingController::class, 'updateStatus'])->name('admin.shipping.update_status');
                Route::post('/shipping/webhook', [ShippingController::class, 'webhookUpdate'])->name('shipping.webhook');
                Route::post('/admin/shipping/ship-order/{id}', [ShippingController::class, 'shipOrder'])->name('shipping.shipOrder');
            });
            Route::prefix('user')->group(function () {
                Route::get('/cart', [WebController::class, 'cart'])->name('user.cart');
                Route::get('/checkout', [WebController::class, 'checkout'])->name('user.checkout');
                Route::get('/contact', [WebController::class, 'contact'])->name('user.contact');
            });
        }
    );

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

Route::get('/profile', [ProfileController::class, 'showProfile'])->name('profile');
Route::get('/profile/confirm-password', [ProfileController::class, 'confirmPassword'])->name('profile.confirm_password');
Route::post('/profile/confirm-password', [ProfileController::class, 'checkPassword'])->name('profile.check_password');
Route::get('/profile/edit', [ProfileController::class, 'editProfile'])->name('profile.edit');
Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');

//Login web
Route::get('/login', [WebLoginController::class, 'index'])->name('web.login');
Route::post('/login', [WebLoginController::class, 'store'])->name('login.store.web');
Route::get('/register', [WebLoginController::class, 'register'])->name('web.register');
Route::post('/', [WebLoginController::class, 'registerStore'])->name('web.register.store');
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


// blog
Route::get('/home/blog', [WebBlogController::class, 'listBlog'])->name('web.listBlog.blog');
Route::get('/home/blog/{id}', [WebBlogController::class, 'detaiWebBlog'])->name('web.detaiWebBlog.blog');

// giỏ hàng
Route::get('/shop/detail/{id}', [CartController::class, 'shopdetail'])->name('web.shop-detail');

// ví người dùng
Route::middleware(['auth'])->group(function () {
    Route::prefix('user')->group(function () {
    Route::prefix('wallet/user')->group(function () {
        Route::get('/wallet', [WebWalletController::class, 'show'])->name('wallet.index');
        Route::post('/wallet/deposit/vnpay', [WebWalletController::class, 'depositVNPay'])->name('wallet.deposit.vnpay');
        Route::get('/wallet/deposit/vnpay', [WebWalletController::class, 'VNPay'])->name('wallet.vnpay');
        Route::get('/wallet/vnpay-callback', [WebWalletController::class, 'vnpayCallback'])->name('wallet.vnpay.callback');
        Route::get('/wallet/vnpay/return', [WebWalletController::class, 'vnpayReturn'])->name('wallet.vnpay.return');
        Route::get('/wallet/history', [WebWalletController::class, 'transactionHistory'])->name('wallet.history');

        Route::get('/wallet/withdraw', [WebWalletController::class, 'croen'])->name('wallet.croen');
        Route::post('/wallet/withdraw', [WebWalletController::class, 'withdraw'])->name('wallet.withdraw');
    });


    // Thanh toán đơn hàng
    Route::prefix('checkout')->group(function () {
        Route::post('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
        Route::get('/checkout/app', [CheckoutController::class, 'appvnp'])->name('checkout.appvnp');
        Route::post('/checkout/view', [CheckoutController::class, 'checkout'])->name('checkout.view');
        Route::post('/checkout/vnpay', [CheckoutController::class, 'depositVNPay'])->name('checkout.depositVNPay');
        Route::match(['get', 'post'], '/checkout/vnpay-callback', [CheckoutController::class, 'vnpayCallback'])->name('checkout.vnpay.callback');
        Route::get('/checkout/order', [CheckoutController::class, 'order'])->name('checkout.order');
        Route::get('/order/{id}/continue-payment', [CheckoutController::class, 'continuePayment'])->name('order.continuePayment');
        Route::post('/checkout/ofline', [CheckoutController::class, 'offline'])->name('checkout.offline');
    });

    Route::prefix('donhang')->group(function () {
        Route::get('/', [WebOrderController::class, 'index'])->name('donhang.index');
        Route::get('/show/{id}', [WebOrderController::class, 'show'])->name('donhang.show');
        // Route hủy đơn hàng
        Route::post('order/{id}/cancel', [WebOrderController::class, 'cancel'])->name('order.cancel');

        // Route xác nhận đã nhận được hàng
        Route::get('order/{id}/received', [WebOrderController::class, 'received'])->name('order.received');

        // Route xác nhận đã trả hàng
        Route::get('order/{id}/returned', [WebOrderController::class, 'returned'])->name('order.returned');

        // Route yêu cầu trả hàng
        Route::post('order/{id}/request-return', [WebOrderController::class, 'requestReturn'])->name('order.requestReturn');
    });




    //cmt
    Route::post('product/{product}/comment', [WebProductController::class, 'storeComment'])->name('client.storeComment');
    Route::post('comment/{comment}/reply', [WebProductController::class, 'storeReply'])->name('client.storeReply');
});
});


    // Bình luận và phản hồi


    // Sửa và xóa bình luận
    Route::put('product/{product}/comment/{comment}/edit', [WebProductController::class, 'updateComment'])->name('client.updateComment');
    Route::delete('product/{product}/comment/{comment}/delete', [WebProductController::class, 'deleteComment'])->name('client.deleteComment');

    // Sửa và xóa phản hồi
    Route::put('comment/{comment}/reply/{reply}/edit', [WebProductController::class, 'updateReply'])->name('client.updateReply');
    Route::delete('comment/{comment}/reply/{reply}/delete', [WebProductController::class, 'deleteReply'])->name('client.deleteReply');


    // Đánh giá sản phẩm
    Route::post('/products/{product}/reviews', [WebProductController::class, 'storeReview'])->name('client.storeReview');
    Route::post('/reviews/{review}/responses', [WebProductController::class, 'storeResponse'])->name('client.storeReviewResponse');

     // Giỏ hàng
        Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
        Route::get('/viewCart', [CartController::class, 'viewCart'])->name('cart.viewCart');
        Route::post('/add/{id}', [CartController::class, 'createAddTocart'])->name('cart.create');
        Route::post('/cart/update/{id}', [CartController::class, 'updateCart'])->name('cart.update');
        Route::post('/cart/remove/{cartKey}', [CartController::class, 'removeFromCart'])->name('cart.remove');
        // Áp mã giảm giá
        Route::post('/cart/apply-promotion', [CartController::class, 'applyPromotion'])->name('cart.applyPromotion');
        Route::get('/viewCart/show', [CartController::class, 'showHeaderCart'])->name('cart.showHeaderCart');
        Route::post('/cart/removesss/{key}', [CartController::class, 'remove'])->name('cart.removess');
        Route::post('/cart/checkout-selected', [CartController::class, 'checkoutSelected'])->name('cart.checkoutSelected');
        // routes/web.php
Route::post('/cart/select-items', [CartController::class, 'selectItems'])->name('cart.selectItems');

Route::get('/gmail', [Controller::class, 'gmail'])->name('web.gmail');


