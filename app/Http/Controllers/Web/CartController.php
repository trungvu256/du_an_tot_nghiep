<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Catalogue;
use App\Models\Images;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Attribute;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function shopdetail($id)
{
    // Lấy sản phẩm chi tiết
    $detailproduct = Product::findOrFail($id);
    $product = Product::with(['comments', 'reviews'])->find($id);
    $description_images = Images::where('product_id', $id)->get();


    // Lấy danh sách các danh mục liên quan
    $categoryIds = Catalogue::where('id', $detailproduct->catalogue_id)
        ->orWhere('parent_id', $detailproduct->catalogue_id)
        ->pluck('id')
        ->toArray();

    // Lấy các sản phẩm liên quan cùng danh mục
    $relatedProducts = Product::whereIn('catalogue_id', $categoryIds)
        ->where('id', '!=', $id)
        ->limit(4)
        ->get();

    // Lấy biến thể của sản phẩm với giá thấp nhất (giữa price và price_sale)
    $variant = ProductVariant::where('product_id', $id)
        ->select('id', 'price', 'price_sale', 'stock_quantity')
        ->orderByRaw("LEAST(price, IFNULL(price_sale, price)) ASC") // Lấy giá thấp nhất giữa price và price_sale
        ->first();

    $price = $variant ? $variant->price : null;

    // Lấy các sản phẩm tương tự cùng giá
    $similarProducts = Product::whereHas('variants', function ($query) use ($price) {
        $query->where('price', $price);
    })->where('id', '!=', $id)
        ->take(5)
        ->get();

    // Lưu lại các sản phẩm đã xem
    $viewedProductIds = session()->get('viewed_products', []);
    if (!in_array($id, $viewedProductIds)) {
        $viewedProductIds[] = $id;
        session()->put('viewed_products', $viewedProductIds);
    }

    // Lấy các sản phẩm đã xem
    $viewedProducts = Product::whereIn('id', $viewedProductIds)->get();

    // Lấy thông tin danh mục và thương hiệu
    $category = Catalogue::find($detailproduct->catalogue_id);
    $brands = Brand::find($detailproduct->brand_id);

    // Truy vấn tất cả thuộc tính của sản phẩm
    $attributes = [];
    foreach ($detailproduct->variants as $variant) {
        foreach ($variant->product_variant_attributes as $pivot) {
            $attrName = $pivot->attribute->name;
            $attrValue = $pivot->attributeValue->value;

            if (!isset($attributes[$attrName])) {
                $attributes[$attrName] = [];
            }

            if (!in_array($attrValue, $attributes[$attrName])) {
                $attributes[$attrName][] = $attrValue;
            }
        }
    }

    // Kiểm tra mảng attributes và loại bỏ các giá trị trùng lặp trong các thuộc tính
    foreach ($attributes as $key => $values) {
        $attributes[$key] = array_unique($values);
    }

    // Truy vấn biến thể dựa trên các thuộc tính đã chọn (giả sử đã có biến $attributes)
    $selectedVariant = $product->variants()->whereHas('product_variant_attributes', function ($query) use ($attributes) {
        foreach ($attributes as $attrName => $attrValues) {
            $query->whereHas('attributeValues', function ($query) use ($attrName, $attrValues) {
                $query->whereHas('attribute', function ($query) use ($attrName) {
                    $query->where('name', $attrName);
                })
                ->whereIn('value', $attrValues); // Tìm kiếm theo giá trị thuộc tính trong bảng attribute_values
            });
        }
    })->first();

    if ($selectedVariant) {
        return response()->json([
            'success' => true,
            'variant' => [
                'price' => $selectedVariant->price,
                'price_sale' => $selectedVariant->price_sale,
                'stock_quantity' => $selectedVariant->stock_quantity,
            ]
        ]);
    }

    // Trả về view với tất cả các dữ liệu đã truy vấn, bao gồm các thuộc tính của sản phẩm
    return view('web2.Home.shop-detail', compact(
        'detailproduct',
        'product',
        'description_images',
        'relatedProducts',
        'similarProducts',
        'viewedProducts',
        'category',
        'brands',
        'attributes',
        'variant'
    ));
}




    // public function index()
    // {
    //     $products = Product::all(); // Lấy tất cả sản phẩm
    //     return view('web2.Home.home', compact('products'));
    // }

    public function viewCart()
    {
        $cart = session()->get('cart', []);
        $totalAmount = 0;

        // Tính tổng tiền
        foreach ($cart as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
        }
        // dd($cart);
        return view('web2.Home.cart', compact('cart', 'totalAmount'));
    }

    public function createAddTocart(Request $request, $id)
{
    // Lấy thông tin sản phẩm
    $product = Product::findOrFail($id);

    // Lấy giỏ hàng từ session
    $cart = session()->get('cart', []);

    // Lấy thông tin từ request
    $attributes = json_decode($request->input('attributes'), true);
    $price = $request->input('price');
    $priceSale = $request->input('price_sale');
    $stockQuantity = $request->input('stock_quantity');
    $quantity = $request->input('quantity', 1);

    // Kiểm tra nếu không chọn đủ thuộc tính
    if (empty($attributes)) {
        return redirect()->back()->with('error', 'Vui lòng chọn đầy đủ các thuộc tính.');
    }

    // Kiểm tra giá và giá khuyến mãi
    if (empty($price) || $price <= 0) {
        return redirect()->back()->with('error', 'Giá sản phẩm không hợp lệ.');
    }

    // Kiểm tra tồn kho
    if ($stockQuantity <= 0) {
        return redirect()->back()->with('error', 'Sản phẩm đã hết hàng.');
    }

    // Kiểm tra số lượng yêu cầu so với tồn kho
    if ($quantity > $stockQuantity) {
        return redirect()->back()->with('error', "Số lượng yêu cầu vượt quá tồn kho. Chỉ còn $stockQuantity sản phẩm.");
    }

    // Lấy giá cuối cùng (ưu tiên giá khuyến mãi nếu có)
    $finalPrice = $priceSale > 0 && $priceSale < $price ? $priceSale : $price;

    // Tạo key duy nhất cho sản phẩm trong giỏ hàng (dựa trên product_id và attributes)
    $attributesString = implode('-', array_values($attributes)); // Chuyển các thuộc tính thành chuỗi
    $cartKey = $product->id . '-' . md5($attributesString);

    // Kiểm tra nếu sản phẩm đã có trong giỏ hàng
    if (isset($cart[$cartKey])) {
        // Nếu có rồi, tăng số lượng
        $newQuantity = $cart[$cartKey]['quantity'] + $quantity;
        if ($newQuantity > $stockQuantity) {
            return redirect()->back()->with('error', "Số lượng trong giỏ vượt quá tồn kho. Chỉ còn $stockQuantity sản phẩm.");
        }
        $cart[$cartKey]['quantity'] = $newQuantity;
    } else {
        // Nếu chưa có trong giỏ, thêm mới vào giỏ
        $cart[$cartKey] = [
            'id' => $product->id, // Không cần variant_id vì form không gửi
            'name' => $product->name,
            'price' => $finalPrice,
            'image' => $product->image,
            'quantity' => $quantity,
            'variant' => [
                'attributes' => $attributes,
            ]
        ];
    }

    // Lưu giỏ vào session
    session()->put('cart', $cart);

    return redirect()->route('cart.viewCart')->with('success', 'Đã thêm vào giỏ hàng');
}


    public function updateCart(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
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


    // khai bas0 mapkey
    private function mapAttributeKey($key)
    {
        $attribute = Attribute::where('name', $key)->first();
        return $attribute ? $attribute->db_column_name : null; // Trả về `null` nếu không tìm thấy
    }


    // Áp mã thanh toán
    public function applyPromotion(Request $request)
    {
        $promotionCode = $request->input('coupon_code');
        $cart = session()->get('cart', []);
        $total = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));

        // Tìm mã giảm giá trong bảng promotions
        $promotion = Promotion::where('code', $promotionCode)
            ->where('status', 'active')
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->first();

        if (!$promotion || !$promotion->isValid($total)) {
            return redirect()->back()->with('error', 'Mã giảm giá không hợp lệ hoặc không đủ điều kiện.');
        }

        // Tính số tiền giảm
        if ($promotion->type === 'percentage') {
            $discountAmount = ($total * $promotion->discount_value) / 100;
            if ($promotion->max_value && $discountAmount > $promotion->max_value) {
                $discountAmount = $promotion->max_value;
            }
        } elseif ($promotion->type === 'fixed_amount') {
            $discountAmount = $promotion->discount_value;
            if ($promotion->max_value && $discountAmount > $promotion->max_value) {
                $discountAmount = $promotion->max_value;
            }
        } elseif ($promotion->type === 'free_shipping') {
            $discountAmount = 0;
        }

        $finalTotal = max(0, $total - $discountAmount);

        // Lưu mã giảm giá vào session
        session()->put('promotion', [
            'code' => $promotion->code,
            'discount' => $discountAmount,
            'final_total' => $finalTotal,
        ]);

        return redirect()->back()->with('success', "Áp dụng mã thành công! Giảm " . number_format($discountAmount, 0, ',', '.') . "₫.");
    }


    // thanh toán

    public function index()
    {
        $cart = session('cart', []);
        $subtotal = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));
        $promotion = session('promotion');
        $shippingFee = 10000;
        $discount = $promotion['discount'] ?? 0;
        $total = max(0, $subtotal - $discount + $shippingFee);

        return view('web2.Home.checkout', compact('cart', 'subtotal', 'promotion', 'shippingFee', 'discount', 'total'));
    }

    public function remove($id)
{
    $cart = session('cart', []);
    foreach ($cart as $key => $item) {
        if ($item['id'] == $id) {
            unset($cart[$key]);
        }
    }
    session(['cart' => $cart]);

    return response()->json(['success' => true]);
}

}
