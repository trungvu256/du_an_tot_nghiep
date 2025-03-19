<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Product;
use Illuminate\Http\Request;

class WebController extends Controller
{
    //
    public function index()
    {
        $products = Product::all();
        $list_product = Product::with('category')->paginate(8);
        $list_product_new = Product::with('category')->orderBy('created_at', 'desc')->get();
        $blogs = Blog::latest()->take(3)->get();
        return view('web2.Home.home', compact('list_product', 'list_product_new', 'blogs', 'products'));
    }
    public function shop()
    {
        return view('web2.Home.shop');
    }

    public function shopdetail($id)
    {
        $detailproduct = Product::find($id);
    
        if (!$detailproduct) {
            abort(404); // Hiển thị trang 404 nếu sản phẩm không tồn tại
        }
    
        return view('web2.Home.shop-detail', compact('detailproduct'));
    }
    
    public function cart()
    {
        return view('web2.Home.cart');
    }

    public function checkout()
    {
        return view('web2.Home.checkout');
    }

    public function contact()
    {
        return view('web2.Home.contact');
    }


    // public function detail($id) {
    //     $detailproduct = Product::find($id);
    //     return view('web2.Home.shop-detail', compact('detailproduct'));
    // }
}
