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
        $product = Product::findOrFail($id);
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

        $variant = ProductVariant::where('product_id', $id)
            ->select('id', 'price', 'price_sale', 'stock_quantity')
            ->orderByRaw("LEAST(price, IFNULL(price_sale, price)) ASC") // Lấy giá thấp nhất giữa price và price_sale
            ->first();

        $price = $variant ? $variant->price : null;

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
        $category = Catalogue::find($detailproduct->catalogue_id);
        $brands = Brand::find($detailproduct->brand_id);

        // ✅ Truy vấn tất cả thuộc tính của sản phẩm
        $attributes = [];
        foreach ($detailproduct->variants as $variant) {
            foreach ($variant->attributes as $attr) {
                $attrName = $attr->attribute->name ?? 'Không xác định';
                $attrValue = $attr->attributeValue->value ?? 'Không có giá trị';
                $attributes[$attrName][] = $attrValue;
            }
        }

        // ✅ Loại bỏ giá trị trùng lặp
        foreach ($attributes as $key => $values) {
            $attributes[$key] = array_unique($values);
        }

        // Trả về view với danh sách thuộc tính
        return view('web2.Home.shop-detail', compact(
            'detailproduct',
            'description_images',
            'relatedProducts',
            'similarProducts',
            'viewedProducts',
            'category',
            'brands',
            'attributes',
            'product' // ✅ Truyền biến $attributes vào view
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
        // dd($cart);
        return view('web2.Home.cart', compact('cart'));
    }

    public function createAddTocart(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);
    
        // Lấy thông tin biến thể từ thuộc tính đã chọn
        $attributes = json_decode($request->input('attributes'), true);
    
        if (empty($attributes)) {
            return redirect()->back()->with('error', 'Vui lòng chọn đầy đủ các thuộc tính.');
        }
    
        // Tìm variant tương ứng với các thuộc tính
        $query = $product->variants();
    
        foreach ($attributes as $key => $value) {
            $columnName = $this->mapAttributeKey($key);
            if ($columnName) { 
                $query->where($columnName, $value);
            }
        }
    
        $variant = $query->first();
    
        if (!$variant) {
            return redirect()->back()->with('error', 'Không tìm thấy biến thể sản phẩm phù hợp.');
        }
    
        // Lấy giá: nếu có giá khuyến mãi thì dùng, nếu không thì dùng giá gốc
        $price = $variant->price_sale > 0 ? $variant->price_sale : $variant->price;
    
        // Lấy số lượng từ form
        $quantity = $request->input('quantity', 1);
    
        // 🔥 **Tạo key duy nhất dựa trên ID biến thể + danh sách thuộc tính**
        $attributesString = implode('-', array_values($attributes)); // Chuyển thành chuỗi
        $cartKey = $product->id . '-' . $variant->id . '-' . md5($attributesString);
    
        Log::info("Thêm vào giỏ hàng - Key: $cartKey, Variant ID: {$variant->id}, Thuộc tính: " . json_encode($attributes));
    
        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] += $quantity;
        } else {
            $cart[$cartKey] = [
                'id' => $variant->id, 
                'name' => $product->name,
                'price' => $price,
                'image' => $product->image,
                'quantity' => $quantity,
                'variant' => [
                    'id' => $variant->id,
                    'attributes' => $attributes,
                ]
            ];
        }
    
        session()->put('cart', $cart);
    
        Log::info("Giỏ hàng hiện tại:", $cart);
    
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
    
}
