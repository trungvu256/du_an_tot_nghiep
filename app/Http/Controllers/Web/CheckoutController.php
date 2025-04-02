<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Mail\PaymentSuccessMail;
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

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        $subtotal = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));
        $promotion = session('promotion');
        $shippingFee = 10000;

        $discount = $promotion['discount'] ?? 0;
        $totalAmount = max(0, $subtotal - $discount + $shippingFee);

        return view('web2.Home.checkout', compact('totalAmount', 'cart'));
    }

    public function checkout(Request $request)
    {
        // Lấy tổng tiền từ session
        $totalAmount = session('totalAmount', 0);
    
        // Lấy giỏ hàng từ session
        $cart = session()->get('cart', []);
        dd($cart);
    
        // Kiểm tra xem giỏ hàng có chứa sản phẩm hay không
        if (empty($cart)) {
            return redirect()->route('cart.viewCart')->with('error', 'Giỏ hàng của bạn hiện tại đang trống.');
        }
    
        // Kiểm tra và lấy các id của biến thể
        foreach ($cart as $item) {
            $variantId = $item['variant']['id']; // Lấy variant_id từ giỏ hàng
            $attributes = $item['variant']['attributes']; // Lấy thuộc tính
    
            // Log để kiểm tra biến thể
            Log::info("Variant ID: $variantId, Attributes: " . json_encode($attributes));
            
            // Kiểm tra nếu variant không hợp lệ
            $variant = ProductVariant::find($variantId);
    
            if (!$variant) {
                return redirect()->route('cart.viewCart')->with('error', 'Một trong các sản phẩm trong giỏ hàng không còn tồn tại.');
            }
    
            // Tính tổng tiền giỏ hàng
            $totalAmount += $variant->price * $item['quantity'];
        }
    
        // Lưu tổng tiền vào session
        session(['totalAmount' => $totalAmount]);
    
        return view('checkout.index', compact('totalAmount', 'cart'));
    }
    


    public function depositVNPay(Request $request)
    {
        try {
            Log::info('Bắt đầu xử lý thanh toán VNPay', ['request_data' => $request->all()]);
    
            $request->validate([
                'amount' => 'required|numeric|min:1000',
            ]);
            $totalPrice = intval($request->input('amount'));
            Log::info('Total Price từ request', ['totalPrice' => $totalPrice]);
    
            if (!Auth::check()) {
                return redirect()->route('login')->with('error', 'Bạn cần đăng nhập trước khi thanh toán');
            }
    
            $user = Auth::user();
            $cart = session()->get('cart', []);
    
            if (empty($cart)) {
                return redirect()->route('cart.viewCart')->with('error', 'Giỏ hàng của bạn đang trống!');
            }
    
            DB::beginTransaction();
    
            $txnRef = now()->timestamp . rand(1000, 9999);
            $paymentDeadline = now()->addMinutes(15);
    
            // Tạo đơn hàng với payment_status = 0 (chưa thanh toán)
            $order = Order::create([
                'user_id' => $user->id,
                'email' => $user->email ?? 'no-email@example.com',
                'phone' => $user->phone ?? '0000000000',
                'address' => $user->address ?? 'Chưa cập nhật',
                'txn_ref' => $txnRef,
                'total_price' => $totalPrice,
                'payment_status' => 0, // Chưa thanh toán
                'status' => Order::STATUS_PENDING,
                'payment_deadline' => $paymentDeadline,
            ]);
            Log::info('Đơn hàng đã lưu', [
                'order_id' => $order->id,
                'total_price' => $totalPrice,
                'payment_deadline' => $paymentDeadline->toDateTimeString()
            ]);
    
            foreach ($cart as $item) {
                $variantQuery = ProductVariant::where('product_id', $item['id']);
    
                foreach ($item['variant']['attributes'] as $attrName => $attrValue) {
                    $variantQuery->whereHas('product_variant_attributes', function ($query) use ($attrName, $attrValue) {
                        $query->whereHas('attribute', fn($attrQuery) => $attrQuery->where('name', $attrName))
                              ->whereHas('attributeValue', fn($valQuery) => $valQuery->where('value', $attrValue));
                    });
                }
    
                $variant = $variantQuery->first();
    
                if (!$variant) {
                    DB::rollBack();
                    return redirect()->route('cart.viewCart')->with('error', 'Không tìm thấy biến thể sản phẩm trong kho!');
                }
    
                $quantity = intval($item['quantity']);
                if ($variant->stock_quantity < $quantity) {
                    DB::rollBack();
                    return redirect()->route('cart.viewCart')->with('error', 'Sản phẩm ' . $item['name'] . ' không đủ số lượng!');
                }
    
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'product_variant_id' => $variant->id,
                    'quantity' => $quantity,
                    'price' => $totalPrice,
                ]);
    
                $variant->decrement('stock_quantity', $quantity);
            }
    
            $vnp_TmnCode = "RJBK6J49";
            $vnp_HashSecret = "0FFMB5EJI6AL35QE35TKCP18SYKI6N30";
            $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
            $vnp_ReturnUrl = route('checkout.vnpay.callback');
    
            $inputData = [
                "vnp_Version" => "2.1.0",
                "vnp_TmnCode" => $vnp_TmnCode,
                "vnp_Amount" => $totalPrice * 100,
                "vnp_Command" => "pay",
                "vnp_CreateDate" => now()->format('YmdHis'),
                "vnp_CurrCode" => "VND",
                "vnp_IpAddr" => $request->ip(),
                "vnp_Locale" => "vn",
                "vnp_OrderInfo" => "Thanh toan don hang #" . $txnRef,
                "vnp_OrderType" => "billpayment",
                "vnp_ReturnUrl" => $vnp_ReturnUrl,
                "vnp_TxnRef" => (string) $txnRef,
            ];
    
            ksort($inputData);
            $query = [];
            foreach ($inputData as $key => $value) {
                $query[] = urlencode($key) . "=" . urlencode($value);
            }
            $queryString = implode('&', $query);
    
            $vnpSecureHash = hash_hmac('sha512', $queryString, $vnp_HashSecret);
            $paymentUrl = $vnp_Url . "?" . $queryString . "&vnp_SecureHash=" . $vnpSecureHash;
    
            Log::info('Dữ liệu gửi VNPay', [
                'inputData' => $inputData,
                'paymentUrl' => $paymentUrl
            ]);
    
            DB::commit();
    
            session(['last_order_id' => $order->id]);
            session()->forget('cart');
    
            return redirect()->away($paymentUrl);
    
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Lỗi xử lý thanh toán VNPay', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('cart.viewCart')->with('error', 'Đã xảy ra lỗi khi xử lý thanh toán. Vui lòng thử lại!');
        }
    }

    
    public function vnpayCallback(Request $request)
{
    try {
        Log::info('Nhận callback từ VNPay', ['request_data' => $request->all()]);

        $vnp_HashSecret = "0FFMB5EJI6AL35QE35TKCP18SYKI6N30";
        $vnp_SecureHash = $request->input('vnp_SecureHash');
        $inputData = $request->except('vnp_SecureHash');

        ksort($inputData);
        $query = [];
        foreach ($inputData as $key => $value) {
            $query[] = urlencode($key) . "=" . urlencode($value);
        }
        $queryString = implode('&', $query);
        $hashData = hash_hmac('sha512', $queryString, $vnp_HashSecret);

        if ($hashData !== $vnp_SecureHash) {
            Log::error('Sai chữ ký VNPay');
            return redirect()->route('cart.viewCart')->with('error', 'Xác thực thanh toán không hợp lệ!');
        }

        $txnRef = $request->input('vnp_TxnRef');
        $responseCode = $request->input('vnp_ResponseCode');
        $order = Order::where('txn_ref', $txnRef)->first();

        if (!$order) {
            Log::error('Không tìm thấy đơn hàng', ['txn_ref' => $txnRef]);
            return redirect()->route('cart.viewCart')->with('error', 'Không tìm thấy đơn hàng!');
        }

        if ($responseCode == '00') { // Thanh toán thành công
            DB::beginTransaction();

            $order->update([
                'payment_status' => 1, // Đã thanh toán
                'status' => Order::STATUS_PENDING, // Sử dụng hằng số đã định nghĩa
                'payment_deadline' => null, // Xóa deadline
            ]);

            Log::info('Thanh toán VNPay thành công', [
                'order_id' => $order->id,
                'txn_ref' => $txnRef
            ]);

            DB::commit();

            return redirect()->route('order.success')->with('success', 'Thanh toán thành công!');
        } else {
            Log::warning('Thanh toán VNPay không thành công', [
                'order_id' => $order->id,
                'response_code' => $responseCode
            ]);

            return redirect()->route('cart.viewCart')->with('error', 'Thanh toán không thành công!');
        }

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Lỗi xử lý callback VNPay', [
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        return redirect()->route('cart.viewCart')->with('error', 'Đã xảy ra lỗi khi xử lý kết quả thanh toán!');
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
        $orders = Order::with('user') // Lấy thông tin khách hàng
            ->when($request->status !== null, function ($query) use ($request) {
                return $query->where('status', $request->status);
            })
            ->when($request->payment_status !== null, function ($query) use ($request) {
                return $query->where('payment_status', $request->payment_status);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('web2.Home.order', compact('orders'));
    }

    public function continuePayment($id, Request $request)
{
    try {
        $order = Order::findOrFail($id);

        // Kiểm tra nếu đơn hàng đã thanh toán
        if ($order->payment_status == 1) {
            return redirect()->back()->with('error', 'Đơn hàng đã được thanh toán!');
        }

        // Kiểm tra thời gian hết hạn thanh toán
        if ($order->payment_deadline && now()->greaterThan($order->payment_deadline)) {
            $order->update(['status' => 6]); // Đã hủy
            return redirect()->back()->with('error', 'Đơn hàng đã hết hạn thanh toán!');
        }

        // Cấu hình VNPay
        $vnp_TmnCode = "RJBK6J49";
        $vnp_HashSecret = "0FFMB5EJI6AL35QE35TKCP18SYKI6N30";
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_ReturnUrl = route('checkout.vnpay.callback');

        // Dữ liệu gửi VNPay
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

        Log::info('Tạo lại link thanh toán VNPay', [
            'order_id' => $order->id,
            'paymentUrl' => $paymentUrl
        ]);

        // Lưu order ID vào session
        session(['last_order_id' => $order->id]);

        // Chuyển hướng đến VNPay
        return redirect()->away($paymentUrl);

    } catch (\Exception $e) {
        Log::error('Lỗi khi tiếp tục thanh toán VNPay', [
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        return redirect()->back()->with('error', 'Đã xảy ra lỗi khi tạo link thanh toán. Vui lòng thử lại!');
    }
}
}


