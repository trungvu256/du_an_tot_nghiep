<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Catalogue;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Attribute;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WebController extends Controller
{
    //
    public function index()
    {
        $categories = Catalogue::all();
        $products = Product::where('status', 1)->get();
        $productNews = Product::where('status', 1)->orderBy('id', 'DESC')->take(4)->get();
        $list_product = Product::where('status', 1)->with('category')->paginate(8);
        $bestSellers = Product::where('status', 1)->withCount(['orderItems as total_sold' => function ($query) {
            $query->select(DB::raw("SUM(quantity)"));
        }])
            ->orderByDesc('total_sold')
            ->take(4)
            ->get();
        $blogs = Blog::latest()->take(3)->get();
        $brands = Brand::all();
        return view('web3.Home.home', compact('list_product', 'categories', 'bestSellers', 'blogs', 'products', 'productNews', 'brands'));
    }


    public function shop(Request $request)
    {
        $query = Product::query()->where('status', 1)->with(['variants', 'brand']);
        $productNews = Product::where('status', 1)->orderBy('id', 'DESC')->take(4)->get();
        // Lấy danh mục & hãng
        $categories = Catalogue::all();
        $brands = Brand::all();

        // Lấy thông tin danh mục đã chọn (nếu có)
        $selectedCategory = null;
        if ($request->filled('cate_id')) {
            $selectedCategory = Catalogue::find($request->input('cate_id'));
        }

        $selectedBrand = null;
        if ($request->filled('brand_id')) {
            $selectedBrand = Brand::find($request->input('brand_id'));
            $query->where('brand_id', $request->input('brand_id'));
        }

        // Debug dữ liệu đầu vào
        Log::info('Filter Input:', $request->all());

        // === FILTER ===
        // Lọc theo danh mục
        $cateId = null;
        if ($request->filled('cate_id')) {
            $cateId = $request->input('cate_id');
            $query->where('catalogue_id', $cateId);
            Log::info('Filtering by category:', ['cate_id' => $cateId]);
        } else {
            $nuocHoaCategory = Catalogue::where('name', 'Nước Hoa')->first();
            if ($nuocHoaCategory) {
                $cateId = $nuocHoaCategory->id;
                $query->where('catalogue_id', $cateId);
                Log::info('Default category:', ['cate_id' => $cateId]);
            } else {
                Log::warning('Default category "Nước Hoa" not found.');
            }
        }

        // Lọc theo giá
        if ($request->filled('price_range')) {
            $priceRanges = $request->input('price_range');

            $query->whereHas('variants', function ($q) use ($priceRanges) {
                $q->where(function ($query) use ($priceRanges) {
                    foreach ($priceRanges as $range) {
                        [$min, $max] = array_map('intval', explode('-', $range));
                        $query->orWhereRaw("
                            (CASE
                                WHEN price_sale IS NOT NULL AND price_sale > 0 THEN price_sale
                                ELSE price
                            END) BETWEEN ? AND ?
                        ", [$min, $max]);
                    }
                });
            });
        }

        // Lọc theo thương hiệu
        if ($request->filled('brand')) {
            $query->whereIn('brand_id', $request->input('brand'));
            Log::info('Filtering by brand:', ['brand' => $request->input('brand')]);
        }

        // Sắp xếp
        $sort = $request->input('sort');
        switch ($sort) {
            case 'new':
                $query->orderBy('created_at', 'desc');
                break;

            case 'price-low-high':
                $query->select('products.*')
                    ->addSelect([
                        'effective_price' => ProductVariant::selectRaw('
                              CASE
                                  WHEN price_sale IS NOT NULL AND price_sale > 0 THEN price_sale
                                  ELSE price
                              END
                          ')
                            ->whereColumn('product_variants.product_id', 'products.id')
                            ->orderByRaw('
                              CASE
                                  WHEN price_sale IS NOT NULL AND price_sale > 0 THEN price_sale
                                  ELSE price
                              END
                          ')
                            ->limit(1)
                    ])
                    ->orderBy('effective_price', 'asc');
                break;

            case 'price-high-low':
                $query->select('products.*')
                    ->addSelect([
                        'effective_price' => ProductVariant::selectRaw('
                              CASE
                                  WHEN price_sale IS NOT NULL AND price_sale > 0 THEN price_sale
                                  ELSE price
                              END
                          ')
                            ->whereColumn('product_variants.product_id', 'products.id')
                            ->orderByRaw('
                              CASE
                                  WHEN price_sale IS NOT NULL AND price_sale > 0 THEN price_sale
                                  ELSE price
                              END DESC
                          ')
                            ->limit(1)
                    ])
                    ->orderByDesc('effective_price');
                break;

            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        // PHÂN TRANG
        $list_product = $query->paginate(12);

        // Debug truy vấn SQL và kết quả
        Log::info('SQL Query:', ['query' => $query->toSql(), 'bindings' => $query->getBindings()]);
        Log::info('Product count:', ['count' => $list_product->count()]);

        // Nếu là AJAX => trả về danh sách sản phẩm
        if ($request->ajax()) {
            return view('web3.Home.product_list', compact('list_product'))->render();
        }

        // Nếu là request thường => trả về cả trang shop
        return view('web3.Home.shop', compact(
            'list_product',
            'categories',
            'brands',
            'productNews',
            'selectedCategory',  // Truyền tên danh mục vào view
            'selectedBrand'
        ));
    }



    public function shopdetail($id)
    {
        $categories = Catalogue::all();
        $detailproduct = Product::where('status', 1)->find($id);
        $relatedProducts = Product::where('status', 1)
            ->where('id', $detailproduct->category_id)
            ->where('id', '!=', $detailproduct->id)
            ->orderBy('id', 'DESC')
            ->take(6)
            ->get();

        if (!$detailproduct) {
            abort(404); // Hiển thị trang 404 nếu sản phẩm không tồn tại
        }

        return view('web3.Home.shop-detail', compact('detailproduct', 'relatedProducts', 'categories'));
    }

    public function cart()
    {
        return view('web3.Home.cart');
    }

    public function checkout()
    {
        return view('web3.Home.checkout');
    }

    public function contact()
    {
        $categories = Catalogue::all();
        return view('web3.Home.contact', compact('categories'));
    }

    //    Tìm kiếm
    public function search(Request $request)
    {
        $keyword = $request->input('searchInput');

        $products = Product::with('variants') // để lấy giá từng phiên bản
            ->where('status', 1)
            ->where(function($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('description', 'like', '%' . $keyword . '%');
            })
            ->paginate(25); // mỗi trang 25 sản phẩm

        return view('web3.Home.search', compact('products', 'keyword'));
    }


    // public function detail($id) {
    //     $detailproduct = Product::find($id);
    //     return view('web2.Home.shop-detail', compact('detailproduct'));
    // }


}
