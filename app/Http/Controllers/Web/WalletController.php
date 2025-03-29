<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class WalletController extends Controller
{
    public function show()
    {
        $user = Auth::user(); // Lấy người dùng hiện tại

        // Lấy ví của người dùng hoặc tạo mới nếu chưa có
        $wallet = $user->wallet ?? Wallet::create(['user_id' => $user->id, 'balance' => 0]);

        // Lấy danh sách giao dịch
        $transactions = $wallet->transactions()->latest()->get();

        // Cập nhật tổng số dư ví
        $totalBalance = $transactions->sum('amount');
        $wallet->update(['balance' => $totalBalance]);

        return view('web2.wallet.index', compact('wallet', 'transactions'));
    }

    public function depositVNPay(Request $request)
    {
        $request->validate(['amount' => 'required|numeric|min:1000']);

        $vnp_TmnCode = "RJBK6J49"; // Mã đối tác VNPay
        $vnp_HashSecret = "0FFMB5EJI6AL35QE35TKCP18SYKI6N30"; // Chuỗi bảo mật
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html"; // URL VNPay Sandbox
        $vnp_ReturnUrl = route('wallet.vnpay.callback'); // Đảm bảo route này tồn tại

        $vnp_TxnRef = rand(1, 10000); // Mã giao dịch duy nhất
        $vnp_Amount = $request->input('amount') * 100; // Chuyển sang đơn vị VNĐ (x100)
        $vnp_Locale = $request->input('language', 'vn'); // Ngôn ngữ
        $vnp_BankCode = $request->input('bankCode', ''); // Mã ngân hàng (nếu có)
        $vnp_IpAddr = request()->ip(); // Lấy IP của client

        // Dữ liệu gửi lên VNPay
        $inputData = [
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => "Thanh toán GD: " . $vnp_TxnRef,
            "vnp_OrderType" => "other",
            "vnp_ReturnUrl" => $vnp_ReturnUrl,
            "vnp_TxnRef" => $vnp_TxnRef,
        ];

        if (!empty($vnp_BankCode)) {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }

        // **Sắp xếp đúng thứ tự key trước khi tạo hash**
        ksort($inputData);

        // **Tạo query string chính xác**
        $query = [];
        foreach ($inputData as $key => $value) {
            $query[] = urlencode($key) . "=" . urlencode($value);
        }
        $queryString = implode('&', $query);

        // **Tạo chữ ký đúng chuẩn**
        $vnpSecureHash = hash_hmac('sha512', $queryString, $vnp_HashSecret);

        // **Tạo URL chuyển hướng**
        $paymentUrl = $vnp_Url . "?" . $queryString . "&vnp_SecureHash=" . $vnpSecureHash;

        return redirect()->away($paymentUrl);
    }


    public function VNPay(Request $request)
    {
        return view('web2.vnpay.index');
    }


    public function vnpayCallback(Request $request)
    {
        $vnp_ResponseCode = $request->get('vnp_ResponseCode'); // Mã phản hồi từ VNPay
        $vnp_TransactionStatus = $request->get('vnp_TransactionStatus'); // Trạng thái giao dịch
        $vnp_Amount = $request->get('vnp_Amount') / 100; // Chuyển về VNĐ
        $vnp_BankCode = $request->get('vnp_BankCode');
        $user = Auth::user(); // Lấy thông tin user
    
        if ($vnp_ResponseCode == "00" && $vnp_TransactionStatus == "00") {
            // Tạo ví nếu chưa có
            $wallet = Wallet::firstOrCreate(
                ['user_id' => $user->id],
                ['balance' => 0]
            );
    
            // Tạo giao dịch
            $transaction = Transaction::create([
                'user_id' => $user->id,
                'wallet_id' => $wallet->id, // Liên kết với ví
                'amount' => $vnp_Amount,
                'bank_code' => $vnp_BankCode,
                'status' => 'success',
                'response_code' => $vnp_ResponseCode,
            ]);
    
            // Cập nhật số dư ví
            $wallet->increment('balance', $vnp_Amount);
    
            return redirect()->route('wallet.index')->with('success', 'Nạp tiền thành công!');
        }
    
        return redirect()->route('wallet.index')->with('error', 'Giao dịch thất bại!');
    }
    



    public function vnpayReturn(Request $request)
    {
        Log::info('VNPay Response', $request->all());

        $vnp_ResponseCode = $request->input('vnp_ResponseCode'); // Mã phản hồi từ VNPay
        $vnp_Amount = $request->input('vnp_Amount') / 100; // VNPay trả về số tiền nhân 100
        $vnp_BankCode = $request->input('vnp_BankCode'); // Ngân hàng thanh toán
        $vnp_TransactionNo = $request->input('vnp_TransactionNo'); // Mã giao dịch VNPay

        if ($vnp_ResponseCode == '00') { // Giao dịch thành công
            $user = auth()->user();

            if (!$user) {
                return redirect()->route('wallet.index')->with('error', 'Không tìm thấy người dùng!');
            }

            // Kiểm tra xem người dùng đã có ví chưa, nếu chưa thì tạo ví mới
            $wallet = $user->wallet ?? new Wallet(['user_id' => $user->id]);

            // Cộng tiền vào ví
            $wallet->balance += $vnp_Amount;
            $wallet->save(); // Lưu số dư mới

            // Lưu giao dịch vào bảng transactions
            Transaction::create([
                'wallet_id' => $wallet->id,
                'amount' => $vnp_Amount,
                'bank_code' => $vnp_BankCode,
                'status' => 'success',
                'transaction_no' => $vnp_TransactionNo
            ]);

            return redirect()->route('wallet.index')->with('success', 'Nạp tiền thành công!');
        }

        return redirect()->route('wallet.index')->with('error', 'Giao dịch thất bại!');
    }

    public function transactionHistory()
    {
        $user = auth()->user();
        $wallet = $user->wallet;

        if (!$wallet) {
            return redirect()->route('wallet.index')->with('error', 'Bạn chưa có ví.');
        }

        $transactions = $wallet->transactions()->orderBy('created_at', 'desc')->get();

        return view('web2.wallet.history', compact('transactions', 'wallet'));
    }




    public function croen() {
        return view('web2.wallet.withdraw');
    }
    // rút tiền
    public function withdraw(Request $request)
{
    // Validate dữ liệu đầu vào
    $validated = $request->validate([
        'bank_account' => 'required|string',
        'amount' => 'required|numeric|min:10000', // Giới hạn rút tiền tối thiểu
    ]);
    
    // Lấy ví của người dùng
    $user = Auth::user();
    $wallet = $user->wallet;
    
    // Kiểm tra nếu số dư ví bằng 0 hoặc không đủ để rút
    if ($wallet->balance <= 0) {
        return back()->with('error', 'Số dư trong ví của bạn bằng 0. Không thể thực hiện rút tiền.');
    }
    
    if ($wallet->balance < $request->amount) {
        return back()->with('error', 'Số dư trong ví không đủ để rút.');
    }
    
    // Cập nhật số dư ví sau khi rút
    $wallet->balance -= $request->amount;
    $wallet->save();
    
    // Lưu giao dịch rút tiền
    Transaction::create([
        'user_id' => $user->id,
        'wallet_id' => $wallet->id,
        'amount' => -$request->amount, // Số tiền âm vì là rút tiền
        'bank_code' => $request->bank_account, // Lưu số tài khoản ngân hàng
        'status' => 'success', // Trạng thái thành công
        'response_code' => '00', // Cung cấp mã phản hồi, ví dụ '00' là thành công
    ]);
    
    // Chuyển hướng về trang ví và thông báo thành công
    return redirect()->route('wallet.index')->with('success', 'Rút tiền thành công!');
}    
}
