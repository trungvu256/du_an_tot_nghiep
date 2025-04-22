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
        $brands = Brand::all();
        // Lấy sản phẩm chi tiết
        $categories = Catalogue::all();
        $detailproduct = Product::findOrFail($id);
        $product = Product::with(['comments', 'reviews', 'variants'])->find($id);
        $description_images = Images::where('product_id', $id)->get();
        $productNews = Product::orderBy('id', 'DESC')->take(4)->get();

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
            ->orderByRaw("LEAST(price, IFNULL(price_sale, price)) ASC")
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
        $brand = Brand::find($detailproduct->brand_id);

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

        // Kiểm tra mảng attributes và loại bỏ các giá trị trùng lặp
        foreach ($attributes as $key => $values) {
            $attributes[$key] = array_unique($values);
        }

        // Kiểm tra nếu chỉ có một biến thể
        if (count($detailproduct->variants) === 1) {
            $singleVariant = $detailproduct->variants->first();
            $variant = [
                'price' => $singleVariant->price,
                'price_sale' => $singleVariant->price_sale,
                'stock_quantity' => $singleVariant->stock_quantity
            ];
        }

        // Kiểm tra nếu là AJAX request để cập nhật giá
        if (request()->ajax()) {
            if (request()->has('update_price')) {
                return $this->updateVariantPrice(request());
            }

            // Lấy thông tin từ request
            $selectedAttributes = json_decode(request()->input('attributes'), true);
            
            // Tìm biến thể dựa trên các thuộc tính đã chọn
            $selectedVariant = $product->variants()
                ->where(function($query) use ($selectedAttributes) {
                    if (isset($selectedAttributes[0])) {
                        $query->where('size', $selectedAttributes[0]);
                    }
                    if (isset($selectedAttributes[1])) {
                        $query->where('concentration', $selectedAttributes[1]);
                    }
                    if (isset($selectedAttributes[2])) {
                        $query->where('special_edition', $selectedAttributes[2]);
                    }
                })->first();

            if ($selectedVariant) {
                return response()->json([
                    'success' => true,
                    'variant' => [
                        'id' => $selectedVariant->id,
                        'price' => $selectedVariant->price,
                        'price_sale' => $selectedVariant->price_sale,
                        'stock_quantity' => $selectedVariant->stock_quantity,
                    ]
                ]);
            }
        }

        // Trả về view với tất cả các dữ liệu
        return view('web3.Home.shop-detail', compact(
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
            'categories',
            'productNews',
            'brand'
        ));
    }


    public function viewCart()
    {
        $productNews = Product::orderBy('id', 'DESC')->take(4)->get();
        $categories = Catalogue::all();
        $cart = session()->get('cart', []);
        $totalAmount = 0;

        // Tính tổng tiền
        foreach ($cart as $item) {
            $price = (!empty($item['price_sale']) && $item['price_sale'] < $item['price']) ? $item['price_sale'] : $item['price'];
            $totalAmount += $price * $item['quantity'];
        }
        // dd($cart);
        return view('web3.Home.cart', compact('cart', 'totalAmount', 'categories','productNews'));
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
            'id' => $product->id,
            'name' => $product->name,
            'price' => (float)$price,
            'price_sale' => (float)$priceSale,
            'image' => $product->image,
            'quantity' => $quantity,
            'stock_quantity' => $stockQuantity,
            'variant' => [
                'attributes' => $attributes,
            ]
        ];
    }

    // Lưu giỏ vào session
    session()->put('cart', $cart);

    return redirect()->back()->with('success', 'Đã thêm vào giỏ hàng');
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
    try {
        $cart = session()->get('cart', []);

        if (isset($cart[$cartKey])) {
            unset($cart[$cartKey]); // Xóa sản phẩm theo cartKey
            session()->put('cart', $cart); // Lưu lại giỏ hàng đã cập nhật

            // Tính lại tổng tiền
            $subtotal = 0;
            foreach ($cart as $item) {
                $price = (!empty($item['price_sale']) && $item['price_sale'] > 0 && $item['price_sale'] < $item['price'])
                    ? $item['price_sale']
                    : $item['price'];
                $subtotal += $price * $item['quantity'];
            }

            return response()->json([
                'success' => true,
                'message' => 'Sản phẩm đã được xóa khỏi giỏ hàng',
                'cartCount' => count($cart),
                'subtotal' => $subtotal
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Không tìm thấy sản phẩm trong giỏ hàng'
        ], 404);
    } catch (\Exception $e) {
        Log::error('Error removing item from cart: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Có lỗi xảy ra khi xóa sản phẩm khỏi giỏ hàng'
        ], 500);
    }
}



    // khai bas0 mapkey
    private function mapAttributeKey($key)
    {
        $attribute = Attribute::where('name', $key)->first();
        return $attribute ? $attribute->db_column_name : null; // Trả về `null` nếu không tìm thấy
    }


    // Áp mã thanh toán
    public function getValidPromotions()
    {
        $now = now();
        Log::info('Current time:', ['now' => $now->toDateTimeString()]);
        
        // Kiểm tra chi tiết về ngày
        $promotionsWithDates = Promotion::select('id', 'code', 'start_date', 'end_date', 'status', 'quantity')
            ->get()
            ->map(function($promotion) use ($now) {
                return [
                    'id' => $promotion->id,
                    'code' => $promotion->code,
                    'start_date' => $promotion->start_date,
                    'end_date' => $promotion->end_date,
                    'status' => $promotion->status,
                    'quantity' => $promotion->quantity,
                    'is_valid_date' => $promotion->start_date <= $now && $promotion->end_date >= $now
                ];
            });
        Log::info('Promotions with dates:', ['promotions' => $promotionsWithDates->toArray()]);

        // Query cuối cùng đã sửa đổi
        $validPromotions = Promotion::where(function($query) use ($now) {
            $query->whereDate('start_date', '<=', $now)
                  ->whereDate('end_date', '>=', $now);
        })
        ->where(function($query) {
            $query->where('status', 'active')
                  ->orWhere('status', 1)
                  ->orWhere('status', 'Kích hoạt');
        })
        ->where('quantity', '>', 0)
        ->get()
        ->map(function($promotion) {
            // Đảm bảo discount_value là số
            $promotion->discount_value = (float) $promotion->discount_value;
            return $promotion;
        });

        Log::info('Final valid promotions:', [
            'count' => $validPromotions->count(),
            'promotions' => $validPromotions->toArray()
        ]);
        // Log chi tiết từng promotion
        foreach ($validPromotions as $promotion) {
            Log::info('Promotion details:', [
                'id' => $promotion->id,
                'code' => $promotion->code,
                'type' => $promotion->type,
                'discount_value' => $promotion->discount_value,
                'raw_value' => $promotion->getRawOriginal('discount_value')
            ]);
        }

        return response()->json([
            'success' => true,
            'promotions' => $validPromotions
        ]);
    }

    public function applyPromotion(Request $request)
    {
        try {
            $promotionCode = $request->input('coupon_code');
            $selectedProducts = $request->input('selected_products', []);
            $cart = session()->get('cart', []);
            $now = now();

            Log::info('Applying promotion - Input data:', [
                'coupon_code' => $promotionCode,
                'current_time' => $now->toDateTimeString(),
                'selected_products' => $selectedProducts,
                'cart' => $cart
            ]);

            // Validate required inputs
            if (empty($promotionCode)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vui lòng nhập mã giảm giá!'
                ]);
            }

            // Kiểm tra xem có sản phẩm nào được chọn không
            if (empty($selectedProducts)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vui lòng chọn sản phẩm muốn áp dụng mã giảm giá!'
                ]);
            }

            // Tìm mã giảm giá
            $promotion = Promotion::where('code', $promotionCode)
                ->first();

            if (!$promotion) {
                return response()->json([
                    'success' => false,
                    'message' => 'Mã giảm giá không tồn tại!'
                ]);
            }

            Log::info('Found promotion:', [
                'promotion_id' => $promotion->id,
                'start_date' => $promotion->start_date,
                'end_date' => $promotion->end_date,
                'status' => $promotion->status,
                'quantity' => $promotion->quantity
            ]);

            // Kiểm tra trạng thái
            if ($promotion->status !== 'active' && $promotion->status !== 1 && $promotion->status !== 'Kích hoạt') {
                return response()->json([
                    'success' => false,
                    'message' => 'Mã giảm giá không khả dụng!'
                ]);
            }

            // Kiểm tra số lượng còn lại
            if ($promotion->quantity <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Mã giảm giá đã hết lượt sử dụng!'
                ]);
            }

            // Kiểm tra thời gian hiệu lực
            if (!$promotion->start_date || !$promotion->end_date) {
                return response()->json([
                    'success' => false,
                    'message' => 'Mã giảm giá không hợp lệ!'
                ]);
            }

            $startDate = \Carbon\Carbon::parse($promotion->start_date)->startOfDay();
            $endDate = \Carbon\Carbon::parse($promotion->end_date)->endOfDay();
            $now = now();

            if ($now->lt($startDate)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Mã giảm giá chưa đến thời gian sử dụng!'
                ]);
            }

            if ($now->gt($endDate)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Mã giảm giá đã hết hạn sử dụng!'
                ]);
            }

            // Tính tổng giá trị đơn hàng cho các sản phẩm được chọn
            $total = 0;
            foreach ($selectedProducts as $cartKey) {
                if (isset($cart[$cartKey])) {
                    $item = $cart[$cartKey];
                    $price = (!empty($item['price_sale']) && $item['price_sale'] < $item['price']) ? $item['price_sale'] : $item['price'];
                    $total += $price * $item['quantity'];
                }
            }

            // Kiểm tra giá trị đơn hàng tối thiểu
            if ($promotion->min_order_value && $total < $promotion->min_order_value) {
                return response()->json([
                    'success' => false,
                    'message' => 'Giá trị đơn hàng chưa đạt tối thiểu! Cần đạt ' . number_format($promotion->min_order_value, 0, ',', '.') . '₫'
                ]);
            }

            // Tính số tiền giảm
            $discountAmount = 0;
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
            }

            $finalTotal = max(0, $total - $discountAmount);

            // Lưu thông tin khuyến mãi vào session
            session()->put('promotion', [
                'id' => $promotion->id,
                'code' => $promotion->code,
                'discount' => $discountAmount,
                'final_total' => $finalTotal,
                'type' => $promotion->type,
                'discount_value' => $promotion->discount_value,
                'selected_products' => $selectedProducts
            ]);

            Log::info('Promotion applied successfully:', [
                'discount_amount' => $discountAmount,
                'final_total' => $finalTotal,
                'code' => $promotion->code
            ]);

            $response = [
                'success' => true,
                'message' => 'Áp dụng mã giảm giá thành công! Giảm ' . number_format($discountAmount, 0, ',', '.') . '₫',
                'discount' => $discountAmount,
                'final_total' => $finalTotal,
                'subtotal' => $total,
                'code' => $promotion->code,
                'promotion' => [
                    'id' => $promotion->id,
                    'code' => $promotion->code,
                    'discount' => $discountAmount,
                    'type' => $promotion->type,
                    'discount_value' => $promotion->discount_value
                ]
            ];

            Log::info('Response data:', $response);

            return response()->json($response);

        } catch (\Exception $e) {
            Log::error('Error applying promotion:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi áp dụng mã giảm giá. Vui lòng thử lại.'
            ], 500);
        }
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
        $subtotal = array_sum(array_map(function($item) {
            return $item['price'] * $item['quantity'];
        }, $filteredCart));

        // Lấy thông tin khuyến mãi từ session (nếu có)
        $promotion = session('promotion');

        // Phí giao hàng cố định (có thể thay đổi tùy theo yêu cầu)
        // $shippingFee = 10000;

        // Tính toán giá trị giảm giá (nếu có)
        $discount = $promotion['discount'] ?? 0;

        // Tính tổng tiền (đảm bảo không âm)
        $total = max(0, $subtotal - $discount);

        // Trả về view checkout với các thông tin đã tính toán
        return view('web3.Home.checkout', compact('categories', 'filteredCart', 'subtotal', 'promotion',  'discount', 'total'));
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
    $total = 0;
    $totalQuantity = 0;

    foreach ($cart as $item) {
        $price = (!empty($item['price_sale']) && $item['price_sale'] < $item['price']) ? $item['price_sale'] : $item['price'];
        $total += $price * $item['quantity'];
        $totalQuantity += $item['quantity'];
    }

    return response()->json([
        'cart' => array_values($cart), // Chuyển mảng thành chỉ số liên tục
        'total' => $total,
        'totalQuantity' => $totalQuantity
    ]);
}
public function create(Request $request, $id)
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
            'id' => $product->id,
            'name' => $product->name,
            'price' => (float)$price,
            'price_sale' => (float)$priceSale,
            'image' => $product->image,
            'quantity' => $quantity,
            'stock_quantity' => $stockQuantity,
            'variant' => [
                'attributes' => $attributes,
            ]
        ];
    }

    // Lưu giỏ vào session
    session()->put('cart', $cart);

    return redirect()->route('cart.viewCart')->with('success', 'Đã thêm vào giỏ hàng');
}

}
