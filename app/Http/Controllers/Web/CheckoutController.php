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
            'categories'
        ));
    }


    public function depositVNPay(Request $request)
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
                $txnRef = now()->timestamp . rand(1000, 9999);
                $paymentDeadline = now()->addMinutes(15);

                $order = Order::create([
                    'user_id' => $user->id,
                    'name' => $user->name ?? 'Không rõ tên',
                    'email' => $user->email ?? 'no-email@example.com',
                    'phone' => $user->phone ?? '0000000000',
                    'address' => $user->address ?? 'Chưa cập nhật',
                    'txn_ref' => $txnRef,
                    'total_price' => $finalTotal,
                    'payment_status' => Order::PAYMENT_PAID,
                    'status' => Order::STATUS_PENDING,
                    'payment_deadline' => $paymentDeadline,
                    'payment_method' => Order::PAYMENT_METHOD_VNPAY,
                    'discount' => $discount, // Lưu giá trị giảm giá vào đơn hàng
                    'promotion_id' => $promotion['id'] ?? null, // Lưu promotion_id vào đơn hàng
                ]);

                $orderTotal = 0;
                $variantErrors = [];
                $selectedKeys = [];

                foreach ($selectedCart as $itemKey => $item) {
                    $variantQuery = ProductVariant::where('product_id', $item['id']);

                    foreach ($item['variant']['attributes'] as $attrName => $attrValue) {
                        $variantQuery->whereHas('product_variant_attributes', function ($query) use ($attrName, $attrValue) {
                            $query->whereHas('attribute', function($q) use ($attrName) {
                                return $q->where('name', $attrName);
                            })->whereHas('attributeValue', function($q) use ($attrValue) {
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
                    $selectedKeys[] = $itemKey; // Lưu các key của sản phẩm đã chọn để xóa sau khi thanh toán

                    event(new EventsOrderPlaced($order));
                    Mail::to($user->email)->send(new OrderPlacedMail($order));
                }

                // Lưu các key của sản phẩm đã chọn vào session
                session(['selected_cart_keys' => $selectedKeys]);

                if (!empty($variantErrors)) {
                    DB::rollBack();
                    return redirect()->route('cart.viewCart')->with('error', implode('<br>', $variantErrors));
                }

                // Cập nhật lại total_price của order sử dụng giá cuối cùng
                $order->update([
                    'total_price' => $finalTotal
                ]);

                // Thêm log để debug
                Log::info('Payment values', [
                    'finalTotal' => $finalTotal,
                    'orderTotal' => $orderTotal,
                    'discount' => $discount,
                    'selectedCart' => $selectedCart,
                    'promotion' => $promotion
                ]);

                DB::commit();

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
                Log::error('Lỗi khi tạo đơn hàng', [
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                return redirect()->route('cart.viewCart')->with('error', 'Đã xảy ra lỗi: ' . $e->getMessage());
            }
        } catch (\Exception $e) {
            Log::error('Lỗi khi xử lý thanh toán', [
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
            if ($order->payment_status !== Order::PAYMENT_COD) {
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
                $order = Order::create([
                    'user_id' => $user->id,
                    'name' => $user->name ?? 'Không rõ tên',
                    'email' => $user->email ?? 'no-email@example.com',
                    'phone' => $user->phone ?? '0000000000',
                    'address' => $user->address ?? 'Chưa cập nhật',
                    'txn_ref' => now()->timestamp . rand(1000, 9999),
                    'total_price' => $finalTotal,
                    'payment_status' => Order::PAYMENT_COD,
                    'status' => Order::STATUS_PENDING,
                    'return_status' => Order::RETURN_NONE,
                    'payment_deadline' => now()->addDays(3),
                    'payment_method' => Order::PAYMENT_METHOD_COD,
                    'discount' => $discount, // Lưu giá trị giảm giá vào đơn hàng
                    'promotion_id' => $promotion['id'] ?? null, // Lưu promotion_id vào đơn hàng
                ]);

                $orderTotal = 0;
                $variantErrors = [];
                $selectedKeys = [];

                foreach ($selectedCart as $itemKey => $item) {
                    $variantQuery = ProductVariant::where('product_id', $item['id']);

                    foreach ($item['variant']['attributes'] as $attrName => $attrValue) {
                        $variantQuery->whereHas('product_variant_attributes', function ($query) use ($attrName, $attrValue) {
                            $query->whereHas('attribute', function($q) use ($attrName) {
                                return $q->where('name', $attrName);
                            })->whereHas('attributeValue', function($q) use ($attrValue) {
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

                // Thêm log để debug
                Log::info('Offline payment values', [
                    'finalTotal' => $finalTotal,
                    'orderTotal' => $orderTotal,
                    'discount' => $discount,
                    'selectedCart' => $selectedCart,
                    'promotion' => $promotion
                ]);

                // Gửi email và kích hoạt sự kiện sau khi đã kiểm tra hết lỗi
                event(new EventsOrderPlaced($order));
                Mail::to($user->email)->send(new OrderPlacedMail($order));

                DB::commit();

                // Xóa các sản phẩm đã đặt khỏi giỏ hàng
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
                return redirect()->route('cart.viewCart')->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
            }
        } catch (\Exception $e) {
            return redirect()->route('cart.viewCart')->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

}
