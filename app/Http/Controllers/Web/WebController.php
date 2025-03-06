<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Product;
use Illuminate\Http\Request;

class WebController extends Controller
{
    //
    public function index(){
        $list_product = Product::with('category')->paginate(8);
        $list_product_new = Product::with('category')->orderBy('created_at', 'desc')->get();
        // $list_blog = Blog::orderBy('created_at', 'desc')->take(3)->get();


        return view('web2.Home.home',compact('list_product','list_product_new'));
    }
    public function shop(){
        return view('web2.Home.shop');
    }

    public function shopdetail() {
        return view('web2.Home.shop-detail');
    }

    public function cart() {
        return view('web2.Home.cart');
    }

    public function checkout() {
        return view('web2.Home.checkout');
    }

    public function contact() {
        return view('web2.Home.contact');
    }
}