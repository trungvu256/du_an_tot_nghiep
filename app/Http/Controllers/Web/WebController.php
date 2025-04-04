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
        $productNews = Product::orderBy('id', 'DESC')->take(4)->get();
        $list_product = Product::with('category')->paginate(8);
        $list_product_new = Product::with('category')->orderBy('created_at', 'desc')->get();
        $blogs = Blog::latest()->take(3)->get();
        return view('web2.Home.home', compact('list_product', 'list_product_new', 'blogs', 'products', 'productNews'));
    }
    public function shop(Request $request)
    {
        $query = Product::query();
    
        // Lọc theo tên sản phẩm (nếu có)
        if ($request->has('name') && !empty($request->name)) {
            $query->where('name', 'LIKE', '%' . $request->name . '%');
        }
    
        // Lọc theo danh mục (nếu có)
        if ($request->has('category') && !empty($request->category)) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->category . '%');
            });
        }
    
        // Phân trang kết quả
        $list_product = $query->paginate(12);
    
        return view('web2.Home.shop', compact('list_product'));
    }
    

    public function shopdetail($id)
    {
        $detailproduct = Product::find($id);
        $relatedProducts = Product::where('category_id', $detailproduct->category_id)
                          ->where('id', '!=', $detailproduct->id)
                          ->orderBy('id', 'DESC')
                          ->take(4)
                          ->get();

        if (!$detailproduct) {
            abort(404); // Hiển thị trang 404 nếu sản phẩm không tồn tại
        }

        return view('web2.Home.shop-detail', compact('detailproduct', 'relatedProducts'));
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
