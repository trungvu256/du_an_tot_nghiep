<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Catalogue;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Attribute;
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
    $query = Product::query()->with('variants', 'brand');

    // Lấy danh mục & hãng
    $categories = Catalogue::all();
    $brands = Brand::all();

    // Lấy các attribute value cho bộ lọc
    $capacityAttr = Attribute::where('name', 'Thể tích')->first();
    $concentrationAttr = Attribute::where('name', 'Nồng độ')->first();
    $capacities = $capacityAttr ? $capacityAttr->values : collect();
    $concentrations = $concentrationAttr ? $concentrationAttr->values : collect();

    // === FILTER ===

    // 1. Lọc khoảng giá
    if ($request->filled('price_range')) {
        $query->whereHas('variants', function ($q) use ($request) {
            foreach ($request->price_range as $range) {
                [$min, $max] = explode('-', $range);
                $q->orWhereBetween('price', [(int)$min, (int)$max]);
            }
        });
    }

    // 2. Lọc hãng
    if ($request->filled('brand')) {
        $query->whereIn('brand_id', $request->brand);
    }

    // 3. Lọc thể tích
    if ($request->filled('capacity')) {
        $query->whereHas('variants.attributeValues', function ($q) use ($request) {
            $q->whereIn('value', $request->capacity)
              ->whereHas('attribute', function ($a) {
                  $a->where('name', 'Thể tích');
              });
        });
    }

    // 4. Lọc nồng độ
    if ($request->filled('concentration')) {
        $query->whereHas('variants.attributeValues', function ($q) use ($request) {
            $q->whereIn('value', $request->concentration)
              ->whereHas('attribute', function ($a) {
                  $a->where('name', 'Nồng độ');
              });
        });
    }

    // === SORTING ===
    $sort = $request->input('sort');
    switch ($sort) {
        case 'price_asc':
            $query->with(['variants' => function ($q) {
                $q->orderBy('price', 'asc');
            }]);
            break;

        case 'price_desc':
            $query->with(['variants' => function ($q) {
                $q->orderBy('price', 'desc');
            }]);
            break;

        case 'brand':
            $query->join('brands', 'products.brand_id', '=', 'brands.id')
                  ->orderBy('brands.name', 'asc');
            break;

        case 'capacity':
            $query->whereHas('variants.attributeValues', function ($q) {
                $q->whereHas('attribute', function ($a) {
                    $a->where('name', 'Thể tích');
                });
            });
            // Nếu cần sort theo value thì cần join thêm
            break;

        case 'concentration':
            $query->whereHas('variants.attributeValues', function ($q) {
                $q->whereHas('attribute', function ($a) {
                    $a->where('name', 'Nồng độ');
                });
            });
            // Như trên, sort theo giá trị cần join
            break;
    }
    if ($request->ajax()) {
        return view('web2.Home.product_list', compact('list_product'))->render();
    }
    if ($request->filled('search')) {
        $query->where('name', 'like', '%' . $request->search . '%');
    }

    // === PHÂN TRANG VÀ TRẢ VỀ ===
    $list_product = $query->paginate(12);

   
    

    return view('web2.Home.shop', compact(
        'list_product',
        'categories',
        'brands',
        'capacities',
        'concentrations'
    ));
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
        $categories = Catalogue::all();
        return view('web2.Home.contact',compact('categories'));
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
