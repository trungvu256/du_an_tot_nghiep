<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Catalogue;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        // Chia sẻ dữ liệu cho layout menu
        View::composer('web3.layout.menu', function ($view) {
            $brands = Brand::all();
            $categories = Catalogue::all();
            $productNews = Product::orderBy('id', 'DESC')->take(4)->get();

            $view->with([
                'brands' => $brands,
                'categories' => $categories,
                'productNews' => $productNews
            ]);
        });
    }
}
