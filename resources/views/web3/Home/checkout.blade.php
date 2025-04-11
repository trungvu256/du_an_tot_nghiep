@extends('web3.layout.master2')

@section('content')
    <!-- Kết thúc Thanh Điều Hướng -->

    <!-- Bắt đầu Tiêu Đề Trang -->
    <div class="tf-breadcrumb">
        <div class="container">
            <ul class="breadcrumb-list">
                <li class="item-breadcrumb">
                    <a href="index-2.html" class="text">Home</a>
                </li>
                <li class="item-breadcrumb dot">
                    <span></span>
                </li>
                <li class="item-breadcrumb">
                    <span class="text">Thanh toán</span>
                </li>
            </ul>
        </div>
    </div>
    <!-- Kết thúc Tiêu Đề Trang -->

    <!-- Bắt đầu Thanh Toán -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <div class="col-lg-8">
                <div class="mb-4">
                    <h4 class="font-weight-semi-bold mb-4">Địa Chỉ Thanh Toán</h4>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Họ tên</label>
                            <input class="form-control" type="text" name="first_name"
                                value="{{ Auth::check() ? Auth::user()->name : '' }}" placeholder="Văn A">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Email</label>
                            <input class="form-control" type="email" name="email"
                                value="{{ Auth::check() ? Auth::user()->email : '' }}" placeholder="example@email.com">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Số Điện Thoại</label>
                            <input class="form-control" type="text" name="phone"
                                value="{{ Auth::check() ? Auth::user()->phone : '' }}" placeholder="+84 123 456 789">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Địa Chỉ</label>
                            <input class="form-control" type="text" name="address"
                                value="{{ Auth::check() ? Auth::user()->address : '' }}" placeholder="123 Đường ABC">
                        </div>
                    </div>
                </div>
                <div class="collapse mb-4" id="shipping-address">
                    <h4 class="font-weight-semi-bold mb-4">Địa Chỉ Giao Hàng</h4>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Họ</label>
                            <input class="form-control" type="text" placeholder="Nguyễn">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Tên</label>
                            <input class="form-control" type="text" placeholder="Văn A">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Email</label>
                            <input class="form-control" type="text" placeholder="example@email.com">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Số Điện Thoại</label>
                            <input class="form-control" type="text" placeholder="+84 123 456 789">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Địa Chỉ</label>
                            <input class="form-control" type="text" placeholder="123 Đường ABC">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Thành Phố</label>
                            <input class="form-control" type="text" placeholder="Hà Nội">
                        </div>
                    </div>
                </div>
            </div>

            @php
                // Lấy danh sách sản phẩm từ session 'selected_cart'
                $selectedCart = session()->get('selected_cart', []);
                $filteredCart = $selectedCart; // Sử dụng trực tiếp selected_cart
                $subtotal = 0;
                foreach ($filteredCart as $item) {
                    $subtotal += $item['price'] * $item['quantity'];
                }
                $discount = session('promotion')['discount'] ?? 0;
                $totalAmount = max(0, $subtotal - $discount);
            @endphp

            <div class="col-lg-4">
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Tổng Đơn Hàng</h4>
                    </div>
                    <div class="card-body">
                        <h5 class="font-weight-medium mb-3">Sản Phẩm</h5>
                        @foreach ($filteredCart as $cartKey => $item)
                            <div class="d-flex justify-content-between">
                                <p>{{ $item['name'] }} (x{{ $item['quantity'] }})</p>
                                <p>{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}₫</p>
                            </div>
                        @endforeach

                        <hr class="mt-0">

                        <div class="d-flex justify-content-between mb-3 pt-1">
                            <h6 class="font-weight-medium">Tạm tính</h6>
                            <h6 class="font-weight-medium" id="summary-subtotal">{{ number_format($subtotal, 0, ',', '.') }}₫</h6>
                        </div>

                        @if ($discount > 0)
                            <div class="d-flex justify-content-between mb-3 pt-1">
                                <h6 class="font-weight-medium text-success">Giảm giá ({{ session('promotion')['code'] }})</h6>
                                <h6 class="font-weight-medium text-success" id="summary-discount">-{{ number_format($discount, 0, ',', '.') }}₫</h6>
                            </div>
                        @endif
                    </div>

                    <div class="card-footer border-secondary bg-transparent">
                        <div class="d-flex justify-content-between mt-2">
                            <h5 class="font-weight-bold">Tổng</h5>
                            <h5 class="font-weight-bold" id="summary-total">{{ number_format($totalAmount, 0, ',', '.') }}₫</h5>
                        </div>
                    </div>
                </div>

                <div class="card-footer border-secondary bg-transparent">
                    <!-- Form thanh toán VNPay -->
                    <form action="{{ route('checkout.depositVNPay') }}" method="POST" class="payment-form">
                        @csrf
                        <input type="hidden" name="amount" id="vnpay-amount" value="{{ $totalAmount }}">
                        <button type="submit" class="btn btn-primary btn-payment w-100 mt-3">
                            💰 Thanh toán bằng VNPay
                        </button>
                    </form>
                </div>

                <div class="card-footer border-secondary bg-transparent">
                    <!-- Form thanh toán tiền mặt -->
                    <form action="{{ route('checkout.offline') }}" method="POST" class="payment-form">
                        @csrf
                        <input type="hidden" name="selected_cart_items" id="selected_cart_items" value='@json(array_keys($filteredCart))'>
                        <input type="hidden" name="amount" id="offline-amount" value="{{ $totalAmount }}">
                        <button type="submit" class="btn btn-success btn-payment w-100">
                            Thanh toán bằng tiền mặt
                        </button>
                    </form>
                </div>

                <style>
                    .btn-payment {
                        font-size: 16px;
                        font-weight: bold;
                        padding: 12px;
                        text-align: center;
                        border-radius: 8px;
                        transition: all 0.3s ease;
                    }

                    .btn-payment.btn-primary {
                        background-color: #007bff;
                        border-color: #007bff;
                    }

                    .btn-payment.btn-primary:hover {
                        background-color: #0056b3;
                        border-color: #004085;
                    }

                    .btn-payment.btn-success {
                        background-color: #28a745;
                        border-color: #28a745;
                    }

                    .btn-payment.btn-success:hover {
                        background-color: #218838;
                        border-color: #1e7e34;
                    }

                    .w-100 {
                        width: 100%;
                    }

                    .card-footer {
                        padding: 20px;
                        background-color: #f8f9fa;
                        border-top: 1px solid #e0e0e0;
                        border-radius: 0 0 8px 8px;
                    }
                </style>
            </div>
        </div>
    </div>

    <script>
        // Hàm định dạng tiền tệ
        function formatCurrency(value) {
            return value.toLocaleString('vi-VN') + '₫';
        }

        // Hàm lấy số từ chuỗi tiền tệ
        function getCurrencyNumber(value) {
            // Xử lý trường hợp giá trị âm (như giảm giá)
            const isNegative = value.includes('-');
            const number = parseInt(value.replace(/[^\d]/g, '')) || 0;
            return isNegative ? -number : number;
        }

        // Hàm cập nhật tổng tiền
        function updateTotalAmount() {
            let subtotal = 0;
            const selectedItems = JSON.parse(document.getElementById('selected_cart_items').value || '[]');
            const cartItems = @json($filteredCart);

            // Tính tổng tiền của các sản phẩm được chọn
            selectedItems.forEach(cartKey => {
                const item = cartItems[cartKey];
                if (item) {
                    subtotal += item.price * item.quantity;
                }
            });

            // Lấy giá trị giảm giá từ giao diện
            const discountElement = document.getElementById('summary-discount');
            const discount = discountElement ? getCurrencyNumber(discountElement.innerText) : 0;

            // Tính tổng tiền (đảm bảo không âm)
            const totalAmount = Math.max(0, subtotal + discount); // discount là số âm

            // Cập nhật giao diện
            document.getElementById('summary-subtotal').innerText = formatCurrency(subtotal);
            document.getElementById('summary-total').innerText = formatCurrency(totalAmount);

            // Cập nhật giá trị amount trong form
            document.getElementById('vnpay-amount').value = totalAmount;
            document.getElementById('offline-amount').value = totalAmount;

            console.log('updateTotalAmount - Subtotal:', subtotal, 'Discount:', discount, 'Total:', totalAmount);
        }

        // Cập nhật selected_cart_items khi người dùng chọn các sản phẩm
        let selectedItems = @json(array_keys($filteredCart));
        document.querySelectorAll('.cart-item-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', (event) => {
                if (event.target.checked) {
                    selectedItems.push(event.target.dataset.cartKey);
                } else {
                    selectedItems = selectedItems.filter(item => item !== event.target.dataset.cartKey);
                }
                document.getElementById('selected_cart_items').value = JSON.stringify(selectedItems);
                console.log("Selected items: ", selectedItems);
                updateTotalAmount(); // Cập nhật tổng tiền khi thay đổi lựa chọn
            });
        });

        // Cập nhật tổng tiền ban đầu
        updateTotalAmount();
    </script>
    <!-- Kết thúc Thanh Toán -->
@endsection