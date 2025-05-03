<?php

namespace App\Http\Controllers\Web;

use App\Events\OrderPlaced as EventsOrderPlaced;
use Pusher\Pusher;
use App\Http\Controllers\Controller;
use App\Mail\OrderPlacedMail;
use App\Mail\PaymentSuccessMail;
use App\Models\Catalogue;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use OrderPlaced;
use App\Models\Promotion;
use App\Models\UserAddress;
use Exception;
use Illuminate\Support\Facades\Http;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $selectedCartKeys = json_decode($request->input('selected_cart_items'), true);
        $cart = session('cart', []);
        $filteredCart = [];
        $subtotal = 0;

        foreach ($cart as $key => $item) {
            if (in_array($key, $selectedCartKeys)) {
                $filteredCart[$key] = $item;
                $price = $item['price'];
                if (isset($item['price_sale']) && $item['price_sale'] > 0 && $item['price_sale'] < $item['price']) {
                    $price = $item['price_sale'];
                }
                $subtotal += $price * $item['quantity'];
            }
        }

        $promotion = session('promotion', []);
        $discount = isset($promotion['discount']) ? $promotion['discount'] : 0;
        $totalAmount = max(0, $subtotal - $discount);

        return view('web3.Home.checkout', [
            'filteredCart' => $filteredCart,
            'subtotal' => $subtotal,
            'promotion' => $promotion,
            'discount' => $discount,
            'totalAmount' => $totalAmount
        ]);
    }

    public function checkout(Request $request)
    {
        $user = auth()->user();
        $address = $user->addresses;
        $productNews = Product::orderBy('id', 'DESC')->take(4)->get();
        $categories = Catalogue::all();

        // Lấy danh sách key được chọn từ request
        $selectedKeys = json_decode($request->input('selected_cart_items'), true);
        $allCart = session('cart', []);

        // Kiểm tra nếu không có sản phẩm nào được chọn
        if (empty($selectedKeys)) {
            return redirect()->route('cart.viewCart')->with('error', 'Không có sản phẩm nào được chọn để thanh toán.');
        }

        // Tạo giỏ hàng mới chỉ với các sản phẩm được chọn
        $filteredCart = [];
        foreach ($selectedKeys as $key) {
            if (isset($allCart[$key])) {
                $filteredCart[$key] = $allCart[$key];
            }
        }

        // Lưu giỏ hàng mới vào session
        session(['selected_cart' => $filteredCart]);

        // Tính toán subtotal cho các sản phẩm đã chọn
        $subtotal = 0;
        foreach ($filteredCart as $item) {
            if (!empty($item['price_sale']) && $item['price_sale'] < $item['price']) {
                $subtotal += $item['price_sale'] * $item['quantity'];
            } else {
                $subtotal += $item['price'] * $item['quantity'];
            }
        }

        // Lấy thông tin giảm giá từ session
        $promotion = session('promotion');
        $discount = $promotion['discount'] ?? 0;

        // Phí vận chuyển mặc định


        // Tính tổng số tiền cần thanh toán
        $totalAmount = max(0, $subtotal - $discount);

        // Trả về view với dữ liệu cần thiết
        return view('web3.Home.checkout', compact(
            'filteredCart',
            'subtotal',
            'discount',
            'productNews',
            'totalAmount',
            'categories',
            'address',
            'user'
        ));
    }


    public function depositVNPay(Request $request)
    {
        try {
            if (!Auth::check()) {
                return redirect('web3.Home.cart')->with('error', 'Bạn cần đăng nhập trước khi thanh toán');
            }
            
            $user = Auth::user();
            $selectedCart = session()->get('selected_cart', []);
            $cart = session()->get('cart', []);

            if (empty($cart)) {
                return redirect()->route('cart.viewCart')->with('error', 'Giỏ hàng của bạn đang trống!');
            }

            if (empty($selectedCart)) {
                return redirect()->route('cart.viewCart')->with('error', 'Không có sản phẩm nào được chọn!');
            }

            // Tính lại tổng tiền dựa trên price_sale nếu có
            $orderTotal = 0;
            foreach ($selectedCart as $item) {
                $price = (!empty($item['price_sale']) && $item['price_sale'] > 0 && $item['price_sale'] < $item['price'])
                    ? $item['price_sale']
                    : $item['price'];
                $orderTotal += $price * $item['quantity'];
            }

            // Áp dụng mã giảm giá nếu có
            $promotion = session('promotion');
            $discount = $promotion['discount'] ?? 0;
            $finalTotal = max(0, $orderTotal - $discount);

            if (!is_numeric($finalTotal) || $finalTotal <= 0) {
                return redirect()->route('cart.viewCart')->with('error', 'Giá trị thanh toán không hợp lệ!');
            }

            DB::beginTransaction();

            try {
                // Kiểm tra và xử lý mã giảm giá nếu có
                if (isset($promotion['id'])) {
                    $promotionModel = Promotion::where('id', $promotion['id'])
                        ->where('quantity', '>', 0)
                        ->lockForUpdate()
                        ->first();

                    if (!$promotionModel) {
                        DB::rollBack();
                        return redirect()->route('cart.viewCart')->with('error', 'Mã giảm giá không tồn tại hoặc đã hết lượt sử dụng!');
                    }

                    $promotionModel->decrement('quantity');
                }

                // Xử lý giao hàng đến địa chỉ khác
                $shipToDifferentAddress = $request->has('ship_to_different_address') && $request->input('ship_to_different_address') == '1';
                $selectedAddress = null;

                // Xử lý địa chỉ giao hàng
                if ($shipToDifferentAddress) {
                    // Lấy thông tin từ form giao hàng khác
                    $billingName = $request->billing_name ?? $user->name;
                    $billingPhone = $request->billing_phone ?? $user->phone;
                    $billingAddress = $request->billing_address ?? $user->address;

                    $name = $request->shipping_name;
                    $phone = $request->shipping_phone;
                    $address = $request->shipping_address;
                    $provinceCode = $request->input('shipping_province');
                    $districtCode = $request->input('shipping_district');
                    $wardCode = $request->input('shipping_ward');
                    $note = $request->shipping_note;

                    // Lấy tên địa điểm từ mã code
                    $provinceData = Http::timeout(5)->get("https://provinces.open-api.vn/api/p/{$provinceCode}")->json();
                    $districtData = Http::timeout(5)->get("https://provinces.open-api.vn/api/d/{$districtCode}?depth=2")->json();

                    $provinceName = $provinceData['name'] ?? '';
                    $districtName = $districtData['name'] ?? '';
                    $wardName = '';

                    // Tìm tên phường/xã theo wardCode
                    if (!empty($districtData['wards'])) {
                        foreach ($districtData['wards'] as $ward) {
                            if ($ward['code'] == $wardCode) {
                                $wardName = $ward['name'] ?? '';
                                break;
                            }
                        }
                    }

                    // Loại bỏ tiền tố
                    $provinceName = preg_replace('/^(Thành phố|Tỉnh)\s+/i', '', $provinceName);
                    $districtName = preg_replace('/^(Quận|Huyện)\s+/i', '', $districtName);
                    $wardName = preg_replace('/^(Phường|Xã)\s+/i', '', $wardName);
                } else {
                    if ($request->filled('user_address_id')) {
                        $selectedAddress = UserAddress::where('user_id', $user->id)
                            ->findOrFail($request->input('user_address_id'));

                        $billingName = $selectedAddress->full_name ?? $request->billing_name ?? $user->name;
                        $billingPhone = $selectedAddress->phone ?? $request->billing_phone ?? $user->phone;
                        $billingAddress = $selectedAddress->full_address ?? $request->billing_address ?? $user->address;

                        $name = $selectedAddress->full_name ?? $billingName;
                        $phone = $selectedAddress->phone ?? $billingPhone;
                        $address = $selectedAddress->full_address ?? $billingAddress;
                        $provinceCode = $selectedAddress->province_code ?? null;
                        $districtCode = $selectedAddress->district_code ?? null;
                        $wardCode = $selectedAddress->ward_code ?? null;
                        $provinceName = $selectedAddress->province_name ?? '';
                        $districtName = $selectedAddress->district_name ?? '';
                        $wardName = $selectedAddress->ward_name ?? '';
                        $note = null;

                        // Chỉ gọi API nếu thiếu tên và có mã code hợp lệ
                        if ((empty($provinceName) || empty($districtName) || empty($wardName)) && $provinceCode && $districtCode && $wardCode) {
                            try {
                                $provinceData = Http::timeout(5)->get("https://provinces.open-api.vn/api/p/{$provinceCode}")->json();
                                $districtData = Http::timeout(5)->get("https://provinces.open-api.vn/api/d/{$districtCode}?depth=2")->json();

                                $provinceName = $provinceData['name'] ?? '';
                                $districtName = $districtData['name'] ?? '';
                                $wardName = '';

                                if (!empty($districtData['wards'])) {
                                    foreach ($districtData['wards'] as $ward) {
                                        if ($ward['code'] == $wardCode) {
                                            $wardName = $ward['name'] ?? '';
                                            break;
                                        }
                                    }
                                }

                                // Loại bỏ tiền tố
                                $provinceName = preg_replace('/^(Thành phố|Tỉnh)\s+/i', '', $provinceName);
                                $districtName = preg_replace('/^(Quận|Huyện)\s+/i', '', $districtName);
                                $wardName = preg_replace('/^(Phường|Xã)\s+/i', '', $wardName);
                            } catch (\Exception $e) {
                                Log::error('API call failed for selected address', [
                                    'provinceCode' => $provinceCode,
                                    'districtCode' => $districtCode,
                                    'wardCode' => $wardCode,
                                    'error' => $e->getMessage(),
                                ]);
                            }
                        }
                    } else {
                        // Lấy từ thông tin tự nhập (billing)
                        $billingName = $request->billing_name;
                        $billingPhone = $request->billing_phone;
                        $billingAddress = $request->billing_address;

                        $name = $billingName;
                        $phone = $billingPhone;
                        $address = $billingAddress;
                        $provinceCode = null;
                        $districtCode = null;
                        $wardCode = null;
                        $provinceName = '';
                        $districtName = '';
                        $wardName = '';
                        $note = null;
                    }
                }

                // Kiểm tra nếu địa chỉ không đầy đủ (chỉ áp dụng khi có shipToDifferentAddress)
                if ($shipToDifferentAddress) {
                    if (empty($provinceName) || empty($districtName) || empty($wardName)) {
                        DB::rollBack();
                        return redirect()->route('cart.viewCart')->with('error', 'Thông tin địa chỉ giao hàng không đầy đủ. Vui lòng kiểm tra lại tỉnh, quận, xã.');
                    }
                }

                // Ghép địa chỉ đầy đủ
                $addressParts = [$address];
                if ($wardName) $addressParts[] = $wardName;
                if ($districtName) $addressParts[] = $districtName;
                if ($provinceName) $addressParts[] = $provinceName;

                $fullAddress = implode(', ', array_filter($addressParts));

                // Email luôn lấy từ user nếu không có trong request
                $email = $request->email ?? $user->email ?? 'no-email@example.com';

                $txnRef = now()->timestamp . rand(1000, 9999);
                $paymentDeadline = now()->addMinutes(15);

                $order = Order::create([
                    'user_id' => $user->id,
                    'billing_name' => $billingName,
                    'billing_phone' => $billingPhone,
                    'billing_address' => $billingAddress,
                    'name' => $name,
                    'email' => $email,
                    'phone' => $phone,
                    'address' => $fullAddress,
                    'province_code' => $provinceCode,
                    'district_code' => $districtCode,
                    'ward_code' => $wardCode,
                    'province_name' => $provinceName,
                    'district_name' => $districtName,
                    'ward_name' => $wardName,
                    'txn_ref' => $txnRef,
                    'total_price' => $finalTotal,
                    'payment_status' => 0, // Chưa thanh toán
                    'status' => Order::STATUS_PENDING,
                    'return_status' => Order::RETURN_NONE,
                    'payment_deadline' => $paymentDeadline,
                    'payment_method' => Order::PAYMENT_METHOD_VNPAY,
                    'discount' => $discount,
                    'promotion_id' => $promotion['id'] ?? null,
                    'note' => $note,
                ]);

                $orderTotal = 0;
                $variantErrors = [];
                $selectedKeys = [];

                foreach ($selectedCart as $itemKey => $item) {
                    $variantQuery = ProductVariant::where('product_id', $item['id']);

                    foreach ($item['variant']['attributes'] as $attrName => $attrValue) {
                        $variantQuery->whereHas('product_variant_attributes', function ($query) use ($attrName, $attrValue) {
                            $query->whereHas('attribute', function ($q) use ($attrName) {
                                return $q->where('name', $attrName);
                            })->whereHas('attributeValue', function ($q) use ($attrValue) {
                                return $q->where('value', $attrValue);
                            });
                        });
                    }

                    $variant = $variantQuery->first();

                    if (!$variant) {
                        $variantErrors[] = "Không tìm thấy biến thể sản phẩm: {$item['name']}";
                        continue;
                    }

                    $quantity = intval($item['quantity']);
                    if ($variant->stock_quantity < $quantity) {
                        $variantErrors[] = "Sản phẩm {$item['name']} không đủ số lượng (Còn {$variant->stock_quantity})";
                        continue;
                    }

                    $price = (!empty($variant->price_sale) && $variant->price_sale > 0 && $variant->price_sale < $variant->price)
                        ? $variant->price_sale
                        : $variant->price;

                    $itemTotal = $price * $quantity;
                    $orderTotal += $itemTotal;

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item['id'],
                        'product_variant_id' => $variant->id,
                        'quantity' => $quantity,
                        'price' => $price,
                    ]);

                    $selectedKeys[] = $itemKey;
                }

                if (!empty($variantErrors)) {
                    DB::rollBack();
                    return redirect()->route('cart.viewCart')->with('error', implode('<br>', $variantErrors));
                }

                // Thêm log để debug
                Log::info('VNPay payment values', [
                    'finalTotal' => $finalTotal,
                    'orderTotal' => $orderTotal,
                    'discount' => $discount,
                    'selectedCart' => $selectedCart,
                    'promotion' => $promotion,
                    'shipping_info' => [
                        'ship_to_different_address' => $shipToDifferentAddress,
                        'name' => $name,
                        'phone' => $phone,
                        'address' => $fullAddress,
                        'email' => $email,
                        'provinceCode' => $provinceCode,
                        'districtCode' => $districtCode,
                        'wardCode' => $wardCode,
                    ],
                ]);
                
                event(new EventsOrderPlaced($order));
                Mail::to($user->email)->send(new OrderPlacedMail($order));
                DB::commit();

                // Xóa sản phẩm đã đặt khỏi giỏ hàng
                $cart = session('cart', []);
                foreach ($selectedKeys as $key) {
                    if (isset($cart[$key])) {
                        unset($cart[$key]);
                    }
                }
                session(['cart' => $cart]);

                // Xóa mã giảm giá và sản phẩm đã chọn khỏi session
                session()->forget('promotion');
                session()->forget('selected_cart');
                session()->forget('selected_cart_keys');

                // Cấu hình VNPay
                $vnp_TmnCode = "RJBK6J49";
                $vnp_HashSecret = "0FFMB5EJI6AL35QE35TKCP18SYKI6N30";
                $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
                $vnp_ReturnUrl = route('checkout.vnpay.callback');

                // Dữ liệu thanh toán
                $inputData = [
                    "vnp_Version" => "2.1.0",
                    "vnp_TmnCode" => $vnp_TmnCode,
                    "vnp_Amount" => $finalTotal * 100, // Chuyển đổi sang xu
                    "vnp_Command" => "pay",
                    "vnp_CreateDate" => date('YmdHis'),
                    "vnp_CurrCode" => "VND",
                    "vnp_IpAddr" => $request->ip(),
                    "vnp_Locale" => "vn",
                    "vnp_OrderInfo" => "Thanh toan don hang #" . $txnRef,
                    "vnp_OrderType" => "billpayment",
                    "vnp_ReturnUrl" => $vnp_ReturnUrl,
                    "vnp_TxnRef" => $txnRef,
                ];

                ksort($inputData);
                $query = [];
                foreach ($inputData as $key => $value) {
                    $query[] = urlencode($key) . "=" . urlencode($value);
                }

                $queryString = implode('&', $query);
                $vnpSecureHash = hash_hmac('sha512', $queryString, $vnp_HashSecret);
                $paymentUrl = $vnp_Url . "?" . $queryString . "&vnp_SecureHash=" . $vnpSecureHash;

                return redirect()->away($paymentUrl);
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Lỗi khi tạo đơn hàng VNPay', [
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                return redirect()->route('cart.viewCart')->with('error', 'Đã xảy ra lỗi: ' . $e->getMessage());
            }
        } catch (\Exception $e) {
            Log::error('Lỗi khi xử lý thanh toán VNPay', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('cart.viewCart')->with('error', 'Đã xảy ra lỗi khi xử lý thanh toán!');
        }
    }



public function vnpayCallback(Request $request)
{
    try {
        Log::info('Nhận callback từ VNPay', ['request_data' => $request->all()]);

        $vnp_HashSecret = config('services.vnpay.hash_secret', '0FFMB5EJI6AL35QE35TKCP18SYKI6N30');
        $vnp_SecureHash = $request->input('vnp_SecureHash');
        $inputData = $request->except('vnp_SecureHash', 'vnp_SecureHashType');

        // Sắp xếp và tạo chuỗi hash
        ksort($inputData);
        $hashData = [];
        foreach ($inputData as $key => $value) {
            $hashData[] = urlencode($key) . '=' . urlencode($value);
        }
        $queryString = implode('&', $hashData);
        $calculatedHash = hash_hmac('sha512', $queryString, $vnp_HashSecret);

        if ($calculatedHash !== $vnp_SecureHash) {
            Log::error('Xác thực chữ ký VNPay thất bại', [
                'calculated_hash' => $calculatedHash,
                'received_hash' => $vnp_SecureHash
            ]);
            return redirect()->route('cart.viewCart')->with('error', 'Xác thực thanh toán không hợp lệ!');
        }

        $txnRef = $request->input('vnp_TxnRef');
        $responseCode = $request->input('vnp_ResponseCode');
        $order = Order::where('txn_ref', $txnRef)->first();

        if (!$order) {
            Log::error('Không tìm thấy đơn hàng', ['txn_ref' => $txnRef]);
            return redirect()->route('cart.viewCart')->with('error', 'Không tìm thấy đơn hàng!');
        }

        // Kiểm tra nếu đơn hàng đã thanh toán rồi
        if ($order->payment_status == 1) {
            Log::info('Đơn hàng đã được thanh toán trước đó', ['order_id' => $order->id]);
            return redirect()->route('donhang.index')->with('success', 'Đơn hàng đã được thanh toán!');
        }

        if ($responseCode === '00') {
            DB::beginTransaction();
            try {
                $order->update([
                    'payment_status' => 1, // Đã thanh toán
                    'status' => Order::STATUS_PENDING,
                    'payment_deadline' => null,
                ]);

                // Cập nhật số lượng mã khuyến mãi nếu có
                if ($order->promotion_id) {
                    $promotionModel = Promotion::find($order->promotion_id);
                    if ($promotionModel && $promotionModel->quantity > 0) {
                        $promotionModel->quantity -= 1;
                        $promotionModel->save();
                    }
                }

                if (!empty($order->email)) {
                    try {
                        Mail::to($order->email)->send(new PaymentSuccessMail($order));
                    } catch (\Throwable $mailException) {
                        Log::warning('Không thể gửi email xác nhận đơn hàng', [
                            'order_id' => $order->id,
                            'email' => $order->email,
                            'error' => $mailException->getMessage()
                        ]);
                    }
                }

                // Xóa sản phẩm đã đặt khỏi giỏ hàng
                $cart = session('cart', []);
                $selectedKeys = session('selected_cart_keys', []);
                foreach ($selectedKeys as $key) {
                    unset($cart[$key]);
                }
                session(['cart' => $cart]);
                session()->forget('promotion'); // Xóa mã giảm giá sau khi đã áp dụng
                session()->forget('selected_cart_keys');

                Log::info('Thanh toán VNPay thành công', [
                    'order_id' => $order->id,
                    'amount' => $request->input('vnp_Amount') / 100,
                    'promotion_id' => $order->promotion_id,
                    'discount' => $order->discount
                ]);

                DB::commit();

                return redirect()->route('donhang.index')->with('success', 'Thanh toán thành công!');
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Lỗi khi cập nhật trạng thái thanh toán', [
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                return redirect()->route('donhang.index')->with('error', 'Lỗi cập nhật trạng thái thanh toán: ' . $e->getMessage());
            }
        } else {
            Log::warning('VNPay trả về không thành công', [
                'txn_ref' => $txnRef,
                'response_code' => $responseCode,
                'message' => $request->input('vnp_ResponseMessage')
            ]);
            return redirect()->route('donhang.index')->with('error', 'Thanh toán không thành công: ' . $request->input('vnp_ResponseMessage'));
        }
    } catch (\Exception $e) {
        Log::error('Lỗi xử lý callback từ VNPay', [
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        return redirect()->route('donhang.index')->with('error', 'Đã xảy ra lỗi khi xử lý kết quả thanh toán!');
    }
}



    private function mapAttributeKey($key)
    {
        $map = [
            'size' => 'size', // Nếu trong database là `size`
            'color' => 'color', // Nếu trong database là `color`
            'capacity' => 'capacity', // Ví dụ thuộc tính thể tích
            'concentration' => 'concentration', // Ví dụ thuộc tính nồng độ
        ];

        return $map[$key] ?? null;
    }

    private function handleVnPayResponse($request)
    {
        // Code xử lý VNPay như trước đây
    }


    // hiển thị đơn hàng

    public function order(Request $request)
    {
        $categories = Catalogue::all();
        $orders = Order::with('user') // Lấy thông tin khách hàng
            ->when($request->status !== null, function ($query) use ($request) {
                return $query->where('status', $request->status);
            })
            ->when($request->payment_status !== null, function ($query) use ($request) {
                return $query->where('payment_status', $request->payment_status);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('web3.Home.order', compact('orders', 'categories'));
    }

    public function continuePayment($id, Request $request)
    {
        try {
            $order = Order::findOrFail($id);

            // ✅ Kiểm tra trạng thái thanh toán: Chỉ tiếp tục nếu payment_status = 2 (COD)
            if ($order->payment_status !== Order::PAYMENT_Fail) {
                return redirect()->back()->with('error', 'Đơn hàng không ở trạng thái chờ thanh toán!');
            }

            // ✅ Kiểm tra thời gian hết hạn thanh toán: Hủy nếu hết hạn
            if ($order->payment_deadline && now()->greaterThan($order->payment_deadline)) {
                $order->update(['status' => 6]); // Đã hủy
                return redirect()->back()->with('error', 'Đơn hàng đã hết hạn thanh toán!');
            }

            // ✅ Cấu hình VNPay
            $vnp_TmnCode = "RJBK6J49";
            $vnp_HashSecret = "0FFMB5EJI6AL35QE35TKCP18SYKI6N30";
            $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
            $vnp_ReturnUrl = route('checkout.vnpay.callback');

            // ✅ Dữ liệu gửi VNPay
            $inputData = [
                "vnp_Version" => "2.1.0",
                "vnp_TmnCode" => $vnp_TmnCode,
                "vnp_Amount" => $order->total_price * 100,
                "vnp_Command" => "pay",
                "vnp_CreateDate" => now()->format('YmdHis'),
                "vnp_CurrCode" => "VND",
                "vnp_IpAddr" => $request->ip(),
                "vnp_Locale" => "vn",
                "vnp_OrderInfo" => "Thanh toan don hang #" . $order->txn_ref,
                "vnp_OrderType" => "billpayment",
                "vnp_ReturnUrl" => $vnp_ReturnUrl,
                "vnp_TxnRef" => (string) $order->txn_ref,
            ];

            ksort($inputData);
            $query = [];
            foreach ($inputData as $key => $value) {
                $query[] = urlencode($key) . "=" . urlencode($value);
            }
            $queryString = implode('&', $query);

            $vnpSecureHash = hash_hmac('sha512', $queryString, $vnp_HashSecret);
            $paymentUrl = $vnp_Url . "?" . $queryString . "&vnp_SecureHash=" . $vnpSecureHash;

            // ✅ Ghi log thông tin thanh toán
            Log::info('Tạo lại link thanh toán VNPay', [
                'order_id' => $order->id,
                'paymentUrl' => $paymentUrl
            ]);

            // ✅ Lưu order ID vào session
            session(['last_order_id' => $order->id]);

            // ✅ Chuyển hướng đến VNPay
            return redirect()->away($paymentUrl);

        } catch (\Exception $e) {
            Log::error('Lỗi khi tiếp tục thanh toán VNPay', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Đã xảy ra lỗi khi tạo link thanh toán. Vui lòng thử lại!');
        }
    }



    // thanh toán bằng tiền mặt
    public function offline(Request $request)
{
    try {
        if (!Auth::check()) {
            return redirect()->route('web.login')->with('error', 'Bạn cần đăng nhập trước khi thanh toán');
        }
        $user = Auth::user();
        $selectedCart = session()->get('selected_cart', []);
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.viewCart')->with('error', 'Giỏ hàng của bạn đang trống!');
        }

        if (empty($selectedCart)) {
            return redirect()->route('cart.viewCart')->with('error', 'Không có sản phẩm nào được chọn!');
        }

        // Tính lại tổng tiền
        $orderTotal = 0;
        foreach ($selectedCart as $item) {
            $price = (!empty($item['price_sale']) && $item['price_sale'] > 0 && $item['price_sale'] < $item['price'])
                ? $item['price_sale']
                : $item['price'];
            $orderTotal += $price * $item['quantity'];
        }

        // Áp dụng giảm giá
        $promotion = session('promotion');
        $discount = $promotion['discount'] ?? 0;
        $finalTotal = max(0, $orderTotal - $discount);

        if (!is_numeric($finalTotal) || $finalTotal <= 0) {
            return redirect()->route('cart.viewCart')->with('error', 'Giá trị thanh toán không hợp lệ!');
        }

        // So sánh với amount từ form
        $submittedAmount = $request->input('amount');
        if ($submittedAmount != $finalTotal) {
            return redirect()->route('cart.viewCart')->with('error', 'Tổng tiền không khớp. Vui lòng thử lại!');
        }

        // Xử lý giao hàng đến địa chỉ khác
        $shipToDifferentAddress = $request->has('ship_to_different_address') && $request->input('ship_to_different_address') == 'on';
        $selectedAddress = null;

        // Debug: Log dữ liệu gửi từ form
        Log::debug('Form data received', [
            'ship_to_different_address' => $request->input('ship_to_different_address'),
            'shipping_name' => $request->input('shipping_name'),
            'shipping_phone' => $request->input('shipping_phone'),
            'shipping_address' => $request->input('shipping_address'),
            'shipping_province' => $request->input('shipping_province'),
            'shipping_district' => $request->input('shipping_district'),
            'shipping_ward' => $request->input('shipping_ward'),
            'billing_name' => $request->input('billing_name'),
            'billing_phone' => $request->input('billing_phone'),
            'billing_address' => $request->input('billing_address'),
            'user_address_id' => $request->input('user_address_id'),
        ]);

        if ($shipToDifferentAddress) {
            $request->validate([
                'shipping_name' => 'required|string|max:255',
                'shipping_phone' => 'required|string|max:20',
                'shipping_address' => 'required|string|max:255',
                'shipping_province' => 'required|string',
                'shipping_district' => 'required|string',
                'shipping_ward' => 'required|string',
            ], [
                'shipping_name.required' => 'Vui lòng nhập tên người nhận.',
                'shipping_phone.required' => 'Vui lòng nhập số điện thoại.',
                'shipping_address.required' => 'Vui lòng nhập địa chỉ giao hàng.',
                'shipping_province.required' => 'Vui lòng chọn tỉnh/thành phố.',
                'shipping_district.required' => 'Vui lòng chọn quận/huyện.',
                'shipping_ward.required' => 'Vui lòng chọn phường/xã.',
            ]);
        } else {
            // Nếu không chọn giao hàng đến địa chỉ khác, kiểm tra user_address_id
            if ($request->filled('user_address_id')) {
                $request->validate([
                    'user_address_id' => 'required|exists:user_addresses,id,user_id,' . $user->id,
                ], [
                    'user_address_id.required' => 'Vui lòng chọn địa chỉ giao hàng.',
                    'user_address_id.exists' => 'Địa chỉ không hợp lệ.',
                ]);
                $selectedAddress = UserAddress::where('user_id', $user->id)
                    ->findOrFail($request->input('user_address_id'));
            } else {
                // Nếu không chọn địa chỉ từ dropdown, yêu cầu nhập thông tin billing
                $request->validate([
                    'billing_name' => 'required|string|max:255',
                    'billing_phone' => 'required|string|max:20',
                    'billing_address' => 'required|string|max:255',
                ], [
                    'billing_name.required' => 'Vui lòng nhập tên người nhận.',
                    'billing_phone.required' => 'Vui lòng nhập số điện thoại.',
                    'billing_address.required' => 'Vui lòng nhập địa chỉ.',
                ]);
            }
        }

        DB::beginTransaction();

        try {
            // Kiểm tra và xử lý mã giảm giá nếu có
            if (isset($promotion['id'])) {
                $promotionModel = Promotion::where('id', $promotion['id'])
                    ->where('quantity', '>', 0)
                    ->lockForUpdate()
                    ->first();

                if (!$promotionModel) {
                    DB::rollBack();
                    return redirect()->route('cart.viewCart')->with('error', 'Mã giảm giá không tồn tại hoặc đã hết lượt sử dụng!');
                }

                $promotionModel->decrement('quantity');
            }

            // Xử lý địa chỉ giao hàng
            if ($shipToDifferentAddress) {
                // Lấy thông tin từ form giao hàng khác
                $billingName = $request->billing_name ?? $user->name;
                $billingPhone = $request->billing_phone ?? $user->phone;
                $billingAddress = $request->billing_address ?? $user->address;

                $name = $request->shipping_name;
                $phone = $request->shipping_phone;
                $address = $request->shipping_address;
                $provinceCode = $request->input('shipping_province');
                $districtCode = $request->input('shipping_district');
                $wardCode = $request->input('shipping_ward');
                $note = $request->shipping_note;

                // Lấy tên địa điểm từ mã code
                $provinceData = Http::timeout(5)->get("https://provinces.open-api.vn/api/p/{$provinceCode}")->json();
                $districtData = Http::timeout(5)->get("https://provinces.open-api.vn/api/d/{$districtCode}?depth=2")->json();

                $provinceName = $provinceData['name'] ?? '';
                $districtName = $districtData['name'] ?? '';
                $wardName = '';

                // Tìm tên phường/xã theo wardCode
                if (!empty($districtData['wards'])) {
                    foreach ($districtData['wards'] as $ward) {
                        if ($ward['code'] == $wardCode) {
                            $wardName = $ward['name'] ?? '';
                            break;
                        }
                    }
                }

                // Loại bỏ tiền tố
                $provinceName = preg_replace('/^(Thành phố|Tỉnh)\s+/i', '', $provinceName);
                $districtName = preg_replace('/^(Quận|Huyện)\s+/i', '', $districtName);
                $wardName = preg_replace('/^(Phường|Xã)\s+/i', '', $wardName);

                Log::debug('Location names retrieved (ship to different address)', [
                    'provinceCode' => $provinceCode,
                    'provinceName' => $provinceName,
                    'districtCode' => $districtCode,
                    'districtName' => $districtName,
                    'wardCode' => $wardCode,
                    'wardName' => $wardName,
                ]);
            } else {
                if ($selectedAddress) {
                    // Lấy từ user_address_id nếu có
                    $billingName = $selectedAddress->full_name ?? $request->billing_name ?? $user->name;
                    $billingPhone = $selectedAddress->phone ?? $request->billing_phone ?? $user->phone;
                    $billingAddress = $selectedAddress->full_address ?? $request->billing_address ?? $user->address;

                    $name = $selectedAddress->full_name ?? $billingName;
                    $phone = $selectedAddress->phone ?? $billingPhone;
                    $address = $selectedAddress->full_address ?? $billingAddress;
                    $provinceCode = $selectedAddress->province_code ?? null;
                    $districtCode = $selectedAddress->district_code ?? null;
                    $wardCode = $selectedAddress->ward_code ?? null;
                    $provinceName = $selectedAddress->province_name ?? '';
                    $districtName = $selectedAddress->district_name ?? '';
                    $wardName = $selectedAddress->ward_name ?? '';
                    $note = null;

                    // Chỉ gọi API nếu thiếu tên và có mã code hợp lệ
                    if ((empty($provinceName) || empty($districtName) || empty($wardName)) && $provinceCode && $districtCode && $wardCode) {
                        try {
                            $provinceData = Http::timeout(5)->get("https://provinces.open-api.vn/api/p/{$provinceCode}")->json();
                            $districtData = Http::timeout(5)->get("https://provinces.open-api.vn/api/d/{$districtCode}?depth=2")->json();

                            $provinceName = $provinceData['name'] ?? '';
                            $districtName = $districtData['name'] ?? '';
                            $wardName = '';

                            if (!empty($districtData['wards'])) {
                                foreach ($districtData['wards'] as $ward) {
                                    if ($ward['code'] == $wardCode) {
                                        $wardName = $ward['name'] ?? '';
                                        break;
                                    }
                                }
                            }

                            // Loại bỏ tiền tố
                            $provinceName = preg_replace('/^(Thành phố|Tỉnh)\s+/i', '', $provinceName);
                            $districtName = preg_replace('/^(Quận|Huyện)\s+/i', '', $districtName);
                            $wardName = preg_replace('/^(Phường|Xã)\s+/i', '', $wardName);
                        } catch (\Exception $e) {
                            Log::error('API call failed for selected address', [
                                'provinceCode' => $provinceCode,
                                'districtCode' => $districtCode,
                                'wardCode' => $wardCode,
                                'error' => $e->getMessage(),
                            ]);
                            // Dùng giá trị mặc định nếu API thất bại
                            $provinceName = $provinceName ?: '';
                            $districtName = $districtName ?: '';
                            $wardName = $wardName ?: '';
                        }
                    }

                    Log::debug('Location names retrieved (from selected address)', [
                        'selectedAddress' => [
                            'id' => $selectedAddress->id,
                            'full_name' => $selectedAddress->full_name,
                            'phone' => $selectedAddress->phone,
                            'full_address' => $selectedAddress->full_address,
                            'province_code' => $provinceCode,
                            'district_code' => $districtCode,
                            'ward_code' => $wardCode,
                            'province_name' => $provinceName,
                            'district_name' => $districtName,
                            'ward_name' => $wardName,
                        ],
                    ]);
                } else {
                    // Lấy từ thông tin tự nhập (billing)
                    $billingName = $request->billing_name;
                    $billingPhone = $request->billing_phone;
                    $billingAddress = $request->billing_address;

                    $name = $billingName;
                    $phone = $billingPhone;
                    $address = $billingAddress;
                    $provinceCode = null;
                    $districtCode = null;
                    $wardCode = null;
                    $provinceName = '';
                    $districtName = '';
                    $wardName = '';
                    $note = null;

                    Log::debug('Location names retrieved (from billing)', [
                        'billingName' => $billingName,
                        'billingPhone' => $billingPhone,
                        'billingAddress' => $billingAddress,
                    ]);
                }
            }

            // Kiểm tra nếu địa chỉ không đầy đủ (chỉ áp dụng khi có shipToDifferentAddress)
            if ($shipToDifferentAddress) {
                if (empty($provinceName) || empty($districtName) || empty($wardName)) {
                    DB::rollBack();
                    return redirect()->route('cart.viewCart')->with('error', 'Thông tin địa chỉ giao hàng không đầy đủ. Vui lòng kiểm tra lại tỉnh, quận, xã.');
                }
            }

            // Ghép địa chỉ đầy đủ
            $addressParts = [$address];
            if ($wardName) $addressParts[] = $wardName;
            if ($districtName) $addressParts[] = $districtName;
            if ($provinceName) $addressParts[] = $provinceName;

            $fullAddress = implode(', ', array_filter($addressParts));

            // Email luôn lấy từ user nếu không có trong request
            $email = $request->email ?? $user->email ?? 'no-email@example.com';

            $orderData = [
                'user_id' => $user->id,
                'billing_name' => $billingName,
                'billing_phone' => $billingPhone,
                'billing_address' => $billingAddress,
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'address' => $fullAddress,
                'province_code' => $provinceCode,
                'district_code' => $districtCode,
                'ward_code' => $wardCode,
                'province_name' => $provinceName,
                'district_name' => $districtName,
                'ward_name' => $wardName,
                'txn_ref' => now()->timestamp . rand(1000, 9999),
                'total_price' => $finalTotal,
                'payment_status' => Order::PAYMENT_COD,
                'status' => Order::STATUS_PENDING,
                'return_status' => Order::RETURN_NONE,
                'payment_deadline' => now()->addDays(3),
                'payment_method' => Order::PAYMENT_METHOD_COD,
                'discount' => $discount,
                'promotion_id' => $promotion['id'] ?? null,
                'note' => $note,
            ];

            $order = Order::create($orderData);

            $orderTotal = 0;
            $variantErrors = [];
            $selectedKeys = [];

            foreach ($selectedCart as $itemKey => $item) {
                $variantQuery = ProductVariant::where('product_id', $item['id']);

                foreach ($item['variant']['attributes'] as $attrName => $attrValue) {
                    $variantQuery->whereHas('product_variant_attributes', function ($query) use ($attrName, $attrValue) {
                        $query->whereHas('attribute', function ($q) use ($attrName) {
                            return $q->where('name', $attrName);
                        })->whereHas('attributeValue', function ($q) use ($attrValue) {
                            return $q->where('value', $attrValue);
                        });
                    });
                }

                $variant = $variantQuery->first();

                if (!$variant) {
                    $variantErrors[] = "Không tìm thấy biến thể sản phẩm: {$item['name']}";
                    continue;
                }

                $quantity = intval($item['quantity']);
                if ($variant->stock_quantity < $quantity) {
                    $variantErrors[] = "Sản phẩm {$item['name']} không đủ số lượng (Còn {$variant->stock_quantity})";
                    continue;
                }

                $price = (!empty($variant->price_sale) && $variant->price_sale > 0 && $variant->price_sale < $variant->price)
                    ? $variant->price_sale
                    : $variant->price;

                $itemTotal = $price * $quantity;
                $orderTotal += $itemTotal;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'product_variant_id' => $variant->id,
                    'quantity' => $quantity,
                    'price' => $price,
                ]);

                $variant->decrement('stock_quantity', $quantity);
                $selectedKeys[] = $itemKey;
            }

            if (!empty($variantErrors)) {
                DB::rollBack();
                return redirect()->route('cart.viewCart')->with('error', implode('<br>', $variantErrors));
            }

            Log::info('Offline payment values', [
                'finalTotal' => $finalTotal,
                'orderTotal' => $orderTotal,
                'discount' => $discount,
                'selectedCart' => $selectedCart,
                'promotion' => $promotion,
                'shipping_info' => [
                    'ship_to_different_address' => $shipToDifferentAddress,
                    'name' => $name,
                    'phone' => $phone,
                    'address' => $fullAddress,
                    'email' => $email,
                    'provinceCode' => $provinceCode,
                    'districtCode' => $districtCode,
                    'wardCode' => $wardCode,
                ],
            ]);

            event(new EventsOrderPlaced($order));
            Mail::to($user->email)->send(new OrderPlacedMail($order));

            DB::commit();

            foreach ($selectedKeys as $key) {
                unset($cart[$key]);
            }
            session(['cart' => $cart]);
            session()->forget('selected_cart');
            session()->forget('promotion');

            return redirect()->route('donhang.index')
                ->with('success', 'Đặt hàng thành công! ' . $order->getStatusText() . '. Vui lòng thanh toán khi nhận hàng.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->route('cart.viewCart')->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    } catch (\Exception $e) {
        Log::error('General error in offline payment', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);
        return redirect()->route('cart.viewCart')->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
    }
}

    public function reorder($orderId)
    {
        try {
            $order = Order::with('orderItems.product', 'orderItems.productVariant')->findOrFail($orderId);
            
            // Kiểm tra trạng thái đơn hàng
            if (!in_array($order->status, [3, 4])) { // 3: Đã hoàn thành, 4: Đã hủy
                return redirect()->back()->with('error', 'Không thể mua lại đơn hàng này!');
            }

            $cart = session('cart', []);
            
            foreach ($order->orderItems as $item) {
                if (!$item->product || !$item->productVariant) {
                    continue;
                }

                // Lấy thông tin thuộc tính của biến thể
                $attributes = [];
                foreach ($item->productVariant->product_variant_attributes as $pva) {
                    $attributes[$pva->attribute->name] = $pva->attributeValue->value;
                }

                // Tìm xem đã có sản phẩm + biến thể này trong giỏ chưa
                $foundKey = null;
                foreach ($cart as $key => $cartItem) {
                    if (
                        $cartItem['id'] == $item->product_id &&
                        isset($cartItem['variant']['id']) && $cartItem['variant']['id'] == $item->product_variant_id &&
                        $cartItem['variant']['attributes'] == $attributes
                    ) {
                        $foundKey = $key;
                        break;
                    }
                }

                if ($foundKey) {
                    // Nếu đã có, cộng dồn số lượng và cập nhật lại tồn kho
                    $cart[$foundKey]['quantity'] += $item->quantity;
                    $cart[$foundKey]['stock_quantity'] = $item->productVariant->stock_quantity;
                } else {
                    // Nếu chưa có, thêm mới với key động và lưu tồn kho
                    $cartKey = 'product_' . $item->product_id . '_' . time() . '_' . rand(1000, 9999);
                    $cart[$cartKey] = [
                        'id' => $item->product_id,
                        'name' => $item->product->name,
                        'price' => $item->productVariant->price,
                        'price_sale' => $item->productVariant->price_sale,
                        'quantity' => $item->quantity,
                        'image' => $item->product->image,
                        'stock_quantity' => $item->productVariant->stock_quantity,
                        'variant' => [
                            'id' => $item->product_variant_id,
                            'attributes' => $attributes
                        ]
                    ];
                }
            }

            // Cập nhật giỏ hàng trong session
            session(['cart' => $cart]);

            return redirect()->route('cart.viewCart')->with('success', 'Đã thêm sản phẩm vào giỏ hàng!');
        } catch (\Exception $e) {
            Log::error('Lỗi khi mua lại sản phẩm', [
                'order_id' => $orderId,
                'error' => $e->getMessage()
            ]);
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi mua lại sản phẩm!');
        }
    }
}
