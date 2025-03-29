<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Catalogue;
use App\Models\Images;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function shopdetail($id)
{
    $detailproduct = Product::findOrFail($id);
    $description_images = Images::where('product_id', $id)->get();
    $category = Catalogue::find($detailproduct->catalogue_id);
    $brands = Brand::find($detailproduct->brand_id);

    $relatedProducts = Product::whereIn('catalogue_id', $category)
        ->where('id', '!=', $id) 
        ->limit(4)
        ->get();
    $variant = ProductVariant::where('product_id', $id)->orderBy('price', 'asc')->first();
    if ($variant) {
        $price = $variant->price; 
    } else {
        $price = null; 
    }
    $similarProducts = Product::whereHas('variants', function ($query) use ($price) {
        $query->where('price', $price);
    })->where('id', '!=', $id)
      ->take(5)
      ->get();
    $viewedProductIds = session()->get('viewed_products', []);

    if (!in_array($id, $viewedProductIds)) {
        $viewedProductIds[] = $id;
        session()->put('viewed_products', $viewedProductIds);
    }
    $viewedProducts = Product::whereIn('id', $viewedProductIds)->get();

    // Trả về view
    return view('web2.Home.shop-detail', compact('detailproduct', 'description_images', 'relatedProducts', 'similarProducts', 'viewedProducts',  'category', 'brands'));
}

}