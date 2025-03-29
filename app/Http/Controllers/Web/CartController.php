<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
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
        $categoryIds = Catalogue::where('id', $detailproduct->catalogue_id)
            ->orWhere('parent_id', $detailproduct->catalogue_id)
            ->pluck('id')
            ->toArray();
        $relatedProducts = Product::whereIn('catalogue_id', $categoryIds)
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
        return view('web2.Home.shop-detail', compact('detailproduct', 'description_images', 'relatedProducts', 'similarProducts', 'viewedProducts'));
    }

    // public function index()
    // {
    //     $products = Product::all(); // Lấy tất cả sản phẩm
    //     return view('web2.Home.home', compact('products'));
    // }

    public function viewCart()
    {
        $cart = session()->get('cart', []);
        // dd($cart);
        return view('web2.Home.cart', compact('cart'));
    }

    public function createAddTocart(Request $request, $id)
{
    // dd($request->all(), $id);

    $product = Product::findOrFail($id);
    $cart = session()->get('cart', []);

    $price = $request->price ?? ($product->variants->isNotEmpty() ? $product->variants->min('price') : $product->price);

    if (isset($cart[$id])) {
        $cart[$id]['quantity']++;
    } else {
        $cart[$id] = [
            "name" => $product->name,
            "price" => $price,
            "image" => $product->image,
            "quantity" => $request->quantity ?? 1,
        ];
    }

    session()->put('cart', $cart);
        return redirect()->route('cart.viewCart')->with('success', 'Đã thêm vào giỏ hàng');
    }

    public function updateCart(Request $request, $id) {
        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            $cart[$id]['quantity'] = max(1, $request->quantity);
            session()->put('cart', $cart);
        }
        return redirect()->route('cart.viewCart')->with('success', 'Cập nhật giỏ hàng thành công');
    }

    public function removeFromCart($id)
{
    $cart = session()->get('cart', []);

    if (isset($cart[$id])) {
        unset($cart[$id]);
        session()->put('cart', $cart);
    }

    return redirect()->route('cart.viewCart')->with('success', 'Đã xóa sản phẩm');
}

}
