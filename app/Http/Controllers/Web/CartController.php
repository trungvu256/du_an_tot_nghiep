<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Catalogue;
use App\Models\Images;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Attribute;
use App\Models\ProductVariantAttribute;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function shopdetail($id)
{
    // Lấy sản phẩm chi tiết
    $categories = Catalogue::all();
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
        'variant',
        'categories'
    ));
}




    // public function index()
    // {
    //     $products = Product::all(); // Lấy tất cả sản phẩm
    //     return view('web2.Home.home', compact('products'));
    // }

    public function viewCart()
    {
        $categories = Catalogue::all();
        $cart = session()->get('cart', []);
        $totalAmount = 0;

        // Tính tổng tiền
        foreach ($cart as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
        }
        // dd($cart);
        return view('web2.Home.cart', compact('cart', 'totalAmount', 'categories'));
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


public function updateCart(Request $request, $cartKey)
{
    $quantity = (int) $request->input('quantity');
    $cart = session('cart', []);

    if (isset($cart[$cartKey])) {
        $productId = $cart[$cartKey]['id'];
        $attributes = $cart[$cartKey]['variant']['attributes'];

        $product = Product::findOrFail($productId);

        // Tìm tất cả biến thể của sản phẩm
        $variants = ProductVariant::where('product_id', $product->id)->get();

        $variant = null;
        foreach ($variants as $v) {
            // Lấy tất cả thuộc tính của biến thể
            $variantAttributes = ProductVariantAttribute::where('product_variant_id', $v->id)
                ->with('attribute', 'attributeValue')
                ->get()
                ->pluck('attributeValue.value', 'attribute.name')
                ->toArray();

            // So sánh thuộc tính
            if ($variantAttributes == $attributes) {
                $variant = $v;
                break;
            }
        }

        if (!$variant) {
            return response()->json([
                'success' => false,
                'message' => 'Biến thể sản phẩm không tồn tại.'
            ]);
        }

        $stockQuantity = $variant->stock_quantity;

        if ($quantity > $cart[$cartKey]['quantity']) { // Tăng số lượng
            if ($quantity > $stockQuantity) {
                return response()->json([
                    'success' => false,
                    'message' => "Số lượng yêu cầu vượt quá tồn kho. Chỉ còn $stockQuantity sản phẩm."
                ]);
            }
        }

        if ($quantity < 1) {
            return response()->json([
                'success' => false,
                'message' => 'Số lượng không thể nhỏ hơn 1.'
            ]);
        }

        $cart[$cartKey]['quantity'] = $quantity;
        $cart[$cartKey]['stock_quantity'] = $stockQuantity;
        session(['cart' => $cart]);

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật giỏ hàng thành công',
            'quantity' => $quantity,
            'stock_quantity' => $stockQuantity
        ]);
    }

    return response()->json([
        'success' => false,
        'message' => 'Sản phẩm không tồn tại trong giỏ hàng'
    ]);
}

public function removeFromCart(Request $request, $cartKey)
{
    $cart = session()->get('cart', []);

    if (isset($cart[$cartKey])) {
        unset($cart[$cartKey]); // Xóa chính xác sản phẩm theo cartKey
        session()->put('cart', $cart); // Lưu lại giỏ hàng đã cập nhật

        // Tính lại tổng tiền
        $totalAmount = array_reduce($cart, function ($sum, $item) {
            return $sum + ($item['price'] * $item['quantity']);
        }, 0);

        $cartCount = count($cart);

        return redirect()->back();
    }
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

    public function index(Request $request)
    {
        // Lấy danh mục sản phẩm
        $categories = Catalogue::all();
        
        // Lấy giỏ hàng từ session
        $cart = session('cart', []);
        
        // Lấy các sản phẩm đã được chọn (dựa vào selected_cart_items trong request)
        $selectedKeys = json_decode($request->input('selected_cart_items'), true);
        
        // Lọc ra các sản phẩm đã chọn
        $filteredCart = collect($cart)->only($selectedKeys)->toArray();
        
        // Tính tổng tiền tạm tính cho các sản phẩm đã chọn
        $subtotal = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $filteredCart));
        
        // Lấy thông tin khuyến mãi từ session (nếu có)
        $promotion = session('promotion');
        
        // Phí giao hàng cố định (có thể thay đổi tùy theo yêu cầu)
        // $shippingFee = 10000;
        
        // Tính toán giá trị giảm giá (nếu có)
        $discount = $promotion['discount'] ?? 0;
        
        // Tính tổng tiền (đảm bảo không âm)
        $total = max(0, $subtotal - $discount);
        
        // Trả về view checkout với các thông tin đã tính toán
        return view('web2.Home.checkout', compact('categories', 'filteredCart', 'subtotal', 'promotion',  'discount', 'total'));
    }
    

    public function remove($key)
    {
        $cart = session('cart', []);
    
        if (isset($cart[$key])) {
            unset($cart[$key]);
            session(['cart' => $cart]);
        }
    
        return response()->noContent(); // không cần trả JSON nếu chỉ reload lại
    }
    
// chọn số lượng

// CartController.php
public function selectItems(Request $request)
{
    $selectedKeys = $request->input('selected_items', []);
    $cart = session()->get('cart', []);
    $selectedCart = [];

    foreach ($selectedKeys as $key) {
        foreach ($cart as $index => $item) {
            if ($key == $item['id'] . '_' . $index) {
                $selectedCart[] = $item;
            }
        }
    }

    session()->put('selected_cart', $selectedCart);

    return redirect()->route('cart.viewCart')->with('success', 'Đã chọn sản phẩm để thanh toán.');
}


public function showHeaderCart()
{
    $cart = session('cart', []);
    $total = collect($cart)->sum(fn($item) => (int) $item['quantity'] * (float) $item['price']);
    $totalQuantity = collect($cart)->sum(fn($item) => (int) $item['quantity']);

    return response()->json([
        'cart' => array_values($cart), // Chuyển mảng thành chỉ số liên tục
        'total' => $total,
        'totalQuantity' => $totalQuantity
    ]);
}

}
