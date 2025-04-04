<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Catalogue;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WebController extends Controller
{
    //
    public function index()
    {
        $categories = Catalogue::all();
        $products = Product::all();
        $productNews = Product::orderBy('id', 'DESC')->take(4)->get();
        $list_product = Product::with('category')->paginate(8);
        $bestSellers = Product::withCount(['orderItems as total_sold' => function ($query) {
            $query->select(DB::raw("SUM(quantity)"));
        }])
            ->orderByDesc('total_sold')
            ->take(4)
            ->get();
        $blogs = Blog::latest()->take(3)->get();
        return view('web2.Home.home', compact('list_product', 'categories', 'bestSellers', 'blogs', 'products', 'productNews'));
    }
    public function shop(Request $request)
    {
        $query = Product::query();
        $categories = Catalogue::all();
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

        return view('web2.Home.shop', compact('list_product', 'categories'));
    }


    public function shopdetail($id)
    {
        $categories = Catalogue::all();
        $detailproduct = Product::find($id);
        $relatedProducts = Product::where('category_id', $detailproduct->category_id)
            ->where('id', '!=', $detailproduct->id)
            ->orderBy('id', 'DESC')
            ->take(4)
            ->get();

        if (!$detailproduct) {
            abort(404); // Hiển thị trang 404 nếu sản phẩm không tồn tại
        }

        return view('web2.Home.shop-detail', compact('detailproduct', 'relatedProducts', 'categories'));
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

    public function getProductsByCategory($cate_id)
    {
        $categories = Catalogue::all();
        $list_product = Product::where('catalogue_id', $cate_id)
        ->orderBy('id', 'DESC')
        ->paginate(12);

        return view('web2.Home.shop', compact('list_product', 'categories'));
    }
}
