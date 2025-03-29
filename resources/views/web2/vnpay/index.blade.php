<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Thanh toán VNPay</title>
    <link href="{{ asset('assets/bootstrap.min.css') }}" rel="stylesheet"/>
    <script src="{{ asset('assets/jquery-1.11.3.min.js') }}"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .payment-form {
            max-width: 500px;
            margin: auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .btn-payment {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 6px;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h3 class="text-center text-primary">Thanh toán VNPay</h3>
    <form action="{{ route('wallet.deposit.vnpay') }}" method="POST" class="payment-form">
        @csrf
        <div class="mb-3">
            <label for="amount" class="form-label">Số tiền cần nạp (VND)</label>
            <input type="number" class="form-control" id="amount" name="amount" min="1000" max="100000000" value="10000" required>
        </div>

        <h5 class="mt-3">Chọn phương thức thanh toán:</h5>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="bankCode" id="vnpayqr" value="" checked>
            <label class="form-check-label" for="vnpayqr">Cổng thanh toán VNPAYQR</label>
        </div>

        <h5 class="mt-3">Chọn ngân hàng:</h5>
        <div class="row">
            <div class="col-6">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="bankCode" id="vnbank" value="VNBANK">
                    <label class="form-check-label" for="vnbank">Thẻ ATM / Tài khoản nội địa</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="bankCode" id="intcard" value="INTCARD">
                    <label class="form-check-label" for="intcard">Thẻ quốc tế</label>
                </div>
            </div>
        </div>

        <h5 class="mt-3">Chọn ngôn ngữ giao diện:</h5>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="language" id="language_vn" value="vn" checked>
            <label class="form-check-label" for="language_vn">Tiếng Việt</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="language" id="language_en" value="en">
            <label class="form-check-label" for="language_en">Tiếng Anh</label>
        </div>

        <button type="submit" class="btn btn-primary btn-payment mt-3">💰 Thanh toán ngay</button>
    </form>

    <footer class="text-center mt-4">
        <p>&copy; VNPay {{ date('Y') }}</p>
    </footer>
</div>

</body>
</html>
