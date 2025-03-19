<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Catalogue;
use App\Models\Images;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function shopdetail($id)
    {
        $detailproduct = Product::findOrFail($id);

        $description_images = Images::where('product_id', $id)->get();

        
        $categoryIds = Catalogue::where('id', $detailproduct->catalogue_id)
            ->orWhere('parent_id', $detailproduct->catalogue_id)
            ->pluck('id')
            ->toArray();

        $relatedProducts = Product::whereIn('catalogue_id', $categoryIds)
            ->where('id', '!=', $id) // Loại trừ sản phẩm hiện tại
            ->limit(4)
            ->get();

        $similarProducts = Product::where('price', $detailproduct->price)
            ->where('id', '!=', $id)
            ->take(5)
            ->get();

            $viewedProductIds = session()->get('viewed_products', []);

            // Nếu sản phẩm chưa có trong danh sách, thêm vào session
            if (!in_array($id, $viewedProductIds)) {
                $viewedProductIds[] = $id;
                session()->put('viewed_products', $viewedProductIds);
            }
        
            // Truy vấn danh sách sản phẩm đã xem
            $viewedProducts = Product::whereIn('id', $viewedProductIds)->get();
        return view('web2.Home.shop-detail', compact('detailproduct', 'description_images', 'relatedProducts', 'similarProducts', 'viewedProducts'));
    }
}
