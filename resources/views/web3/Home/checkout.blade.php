@extends('web3.layout.master2')

@section('content')
<!-- Kết thúc Thanh Điều Hướng -->

<!-- Bắt đầu Tiêu Đề Trang -->
<div class="tf-breadcrumb">
    <div class="container">
        <ul class="breadcrumb-list">
            <li class="item-breadcrumb">
                <a href="{{ route('web.home') }}" class="text">Trang chủ</a>
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
            <!-- Form chính để gửi thông tin thanh toán -->
            <form action="{{ route('checkout.offline') }}" method="POST" id="checkoutForm">
                @csrf
                <input type="hidden" name="selected_cart_items" id="selected_cart_items" value='@json(array_keys($filteredCart))'>
                <input type="hidden" name="amount" id="offline-amount" value="{{ $totalAmount }}">

                <!-- Thông tin mua hàng -->
                <div class="mb-4">
                    <h4 class="font-weight-semi-bold mb-4">Thông tin mua hàng</h4>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Email (tùy chọn)</label>
                            <input class="form-control" type="email" name="email"
                                value="{{ Auth::check() ? Auth::user()->email : '' }}"
                                placeholder="example@email.com">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Họ và tên <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="billing_name"
                                value="{{ Auth::check() ? Auth::user()->name : '' }}"
                                placeholder="Họ và tên" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Số điện thoại <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <img src="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/flags/4x3/vn.svg"
                                            alt="Vietnam Flag" width="20">
                                    </span>
                                </div>
                                <input class="form-control" type="text" name="billing_phone"
                                    value="{{ Auth::check() ? Auth::user()->phone : '' }}"
                                    placeholder="+84 123 456 789" required>
                            </div>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Địa chỉ <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="billing_address"
                                value="{{ Auth::check() ? Auth::user()->address : '' }}"
                                placeholder="Số nhà, tên đường" required>
                        </div>
                    </div>
                </div>

                <!-- Checkbox để chọn giao hàng đến địa chỉ khác -->
                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="ship-to-different-address"
                            name="ship_to_different_address">
                        <label class="custom-control-label" for="ship-to-different-address">Giao hàng đến địa chỉ khác</label>
                    </div>
                </div>

                <!-- Thông tin giao hàng (ẩn ban đầu) -->
                <div class="collapse mb-4" id="shipping-address">
                    <h4 class="font-weight-semi-bold mb-4">Thông tin nhận hàng</h4>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Họ và tên <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="shipping_name"
                                placeholder="Họ và tên">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Số điện thoại <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <img src="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/flags/4x3/vn.svg"
                                            alt="Vietnam Flag" width="20">
                                    </span>
                                </div>
                                <input class="form-control" type="text" name="shipping_phone"
                                    placeholder="+84 123 456 789">
                            </div>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Địa chỉ <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="shipping_address"
                                placeholder="Số nhà, tên đường">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Tỉnh/Thành phố <span class="text-danger">*</span></label>
                            <select class="form-control custom-select" name="shipping_province" id="shipping_province">
                                <option value="">---</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Quận/Huyện <span class="text-danger">*</span></label>
                            <select class="form-control custom-select" name="shipping_district" id="shipping_district">
                                <option value="">---</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Phường/Xã <span class="text-danger">*</span></label>
                            <select class="form-control custom-select" name="shipping_ward" id="shipping_ward">
                                <option value="">---</option>
                            </select>
                        </div>
                        <div class="col-md-12 form-group">
                            <label>Ghi chú (tùy chọn)</label>
                            <textarea class="form-control" name="shipping_note" rows="3"
                                placeholder="Ghi chú về đơn hàng, ví dụ: thời gian hay chỉ dẫn địa điểm giao hàng chi tiết hơn"></textarea>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        @php
        // Lấy danh sách sản phẩm từ session 'selected_cart'
        $selectedCart = session()->get('selected_cart', []);
        $filteredCart = $selectedCart; // Sử dụng trực tiếp selected_cart
        $subtotal = 0;
        foreach ($filteredCart as $item) {
        $price = (!empty($item['price_sale']) && $item['price_sale'] > 0 && $item['price_sale'] < $item['price'])
            ? $item['price_sale']
            : $item['price'];
            $subtotal +=$price * $item['quantity'];
            }
            $discount=session('promotion')['discount'] ?? 0;
            $totalAmount=max(0, $subtotal - $discount);
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
                        <p>
                            @if(!empty($item['price_sale']) && $item['price_sale'] > 0)
                            {{ number_format($item['price_sale'], 0, ',', '.') }}₫
                            @else
                            {{ number_format($item['price'], 0, ',', '.') }}₫
                            @endif
                        </p>
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
                <button type="submit" form="checkoutForm" class="btn btn-success btn-payment w-100">
                    Thanh toán bằng tiền mặt
                </button>
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

                .form-control {
                    border-radius: 5px;
                    border: 1px solid #ced4da;
                }

                .form-control:focus {
                    border-color: #007bff;
                    box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
                }

                .input-group-text {
                    background-color: #fff;
                    border: 1px solid #ced4da;
                    border-right: 0;
                }

                .custom-control-label {
                    cursor: pointer;
                }

                /* CSS để tùy chỉnh giao diện dropdown giống hình ảnh */
                .custom-select {
                    position: relative;
                    appearance: none;
                    -webkit-appearance: none;
                    -moz-appearance: none;
                    background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>') no-repeat right 10px center;
                    background-size: 12px;
                    padding-right: 30px;
                }

                .custom-select:focus {
                    border-color: #007bff;
                    box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
                }

                /* Tùy chỉnh menu dropdown */
                select.custom-select {
                    max-height: 40px;
                }

                select.custom-select option {
                    padding: 8px 10px;
                    font-size: 14px;
                }

                /* Thanh cuộn cho dropdown */
                select.custom-select::-webkit-scrollbar {
                    width: 8px;
                }

                select.custom-select::-webkit-scrollbar-track {
                    background: #f1f1f1;
                    border-radius: 10px;
                }

                select.custom-select::-webkit-scrollbar-thumb {
                    background: #888;
                    border-radius: 10px;
                }

                select.custom-select::-webkit-scrollbar-thumb:hover {
                    background: #555;
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
        const isNegative = value.includes('-');
        const number = parseInt(value.replace(/[^\d]/g, '')) || 0;
        return isNegative ? -number : number;
    }

    // Hàm cập nhật tổng tiền
    function updateTotalAmount() {
        let subtotal = 0;
        const selectedItems = JSON.parse(document.getElementById('selected_cart_items').value || '[]');
        const cartItems = @json($filteredCart);

        selectedItems.forEach(cartKey => {
            const item = cartItems[cartKey];
            if (item) {
                const price = (item.price_sale && item.price_sale > 0 && item.price_sale < item.price) ?
                    item.price_sale :
                    item.price;
                subtotal += price * item.quantity;
            }
        });

        const discountElement = document.getElementById('summary-discount');
        const discount = discountElement ? getCurrencyNumber(discountElement.innerText) : 0;

        const totalAmount = Math.max(0, subtotal - Math.abs(discount));

        document.getElementById('summary-subtotal').innerText = formatCurrency(subtotal);
        document.getElementById('summary-total').innerText = formatCurrency(totalAmount);

        document.getElementById('vnpay-amount').value = totalAmount;
        document.getElementById('offline-amount').value = totalAmount;
    }

    // Cập nhật tổng tiền ban đầu
    updateTotalAmount();

    // Xử lý dropdown Tỉnh/Thành phố, Quận/Huyện, Phường/Xã bằng API
    document.addEventListener('DOMContentLoaded', function() {
        const shippingProvinceSelect = document.getElementById('shipping_province');
        const shippingDistrictSelect = document.getElementById('shipping_district');
        const shippingWardSelect = document.getElementById('shipping_ward');

        // Hàm rút gọn tên (loại bỏ "Thành phố", "Tỉnh", "Quận", "Huyện", "Phường", "Xã")
        function shortenName(name) {
            return name.replace(/^(Thành phố|Tỉnh|Quận|Huyện|Phường|Xã)\s+/i, '');
        }

        // Hàm lấy danh sách Tỉnh/Thành phố
        async function loadProvinces(targetSelect) {
            try {
                const response = await fetch('https://provinces.open-api.vn/api/p/');
                const provinces = await response.json();

                targetSelect.innerHTML = '<option value="">---</option>';
                provinces.sort((a, b) => shortenName(a.name).localeCompare(shortenName(b.name))); // Sắp xếp theo tên rút gọn
                provinces.forEach(province => {
                    const option = document.createElement('option');
                    option.value = province.code;
                    option.text = shortenName(province.name); // Hiển thị tên rút gọn
                    targetSelect.appendChild(option);
                });
            } catch (error) {
                console.error('Lỗi khi lấy danh sách tỉnh/thành phố:', error);
            }
        }

        // Hàm lấy danh sách Quận/Huyện
        async function loadDistricts(provinceCode, targetSelect, wardSelect) {
            try {
                const response = await fetch(`https://provinces.open-api.vn/api/p/${provinceCode}?depth=2`);
                const provinceData = await response.json();

                targetSelect.innerHTML = '<option value="">---</option>';
                wardSelect.innerHTML = '<option value="">---</option>';

                provinceData.districts.sort((a, b) => shortenName(a.name).localeCompare(shortenName(b.name))); // Sắp xếp theo tên rút gọn
                provinceData.districts.forEach(district => {
                    const option = document.createElement('option');
                    option.value = district.code;
                    option.text = shortenName(district.name); // Hiển thị tên rút gọn
                    targetSelect.appendChild(option);
                });
            } catch (error) {
                console.error('Lỗi khi lấy danh sách quận/huyện:', error);
            }
        }

        // Hàm lấy danh sách Phường/Xã
        async function loadWards(districtCode, targetSelect) {
            try {
                const response = await fetch(`https://provinces.open-api.vn/api/d/${districtCode}?depth=2`);
                const districtData = await response.json();

                targetSelect.innerHTML = '<option value="">---</option>';
                districtData.wards.sort((a, b) => shortenName(a.name).localeCompare(shortenName(b.name))); // Sắp xếp theo tên rút gọn
                districtData.wards.forEach(ward => {
                    const option = document.createElement('option');
                    option.value = ward.code;
                    option.text = shortenName(ward.name); // Hiển thị tên rút gọn
                    targetSelect.appendChild(option);
                });
            } catch (error) {
                console.error('Lỗi khi lấy danh sách phường/xã:', error);
            }
        }

        // Load Tỉnh/Thành phố cho shipping
        loadProvinces(shippingProvinceSelect);

        // Xử lý khi chọn Tỉnh/Thành phố (Shipping)
        shippingProvinceSelect.addEventListener('change', function() {
            const provinceCode = this.value;
            if (provinceCode) {
                loadDistricts(provinceCode, shippingDistrictSelect, shippingWardSelect);
            } else {
                shippingDistrictSelect.innerHTML = '<option value="">---</option>';
                shippingWardSelect.innerHTML = '<option value="">---</option>';
            }
        });

        // Xử lý khi chọn Quận/Huyện (Shipping)
        shippingDistrictSelect.addEventListener('change', function() {
            const districtCode = this.value;
            if (districtCode) {
                loadWards(districtCode, shippingWardSelect);
            } else {
                shippingWardSelect.innerHTML = '<option value="">---</option>';
            }
        });

        // Xử lý checkbox "Giao hàng đến địa chỉ khác"
        const shipToDifferentAddressCheckbox = document.getElementById('ship-to-different-address');
        const shippingAddressSection = document.getElementById('shipping-address');

        shipToDifferentAddressCheckbox.addEventListener('change', function() {
            if (this.checked) {
                shippingAddressSection.classList.add('show');
                // Đặt các trường trong "Thông tin nhận hàng" là bắt buộc khi checkbox được chọn
                document.querySelectorAll('#shipping-address input:not([name="shipping_note"]), #shipping-address select').forEach(field => {
                    field.setAttribute('required', 'required');
                });
            } else {
                shippingAddressSection.classList.remove('show');
                // Bỏ yêu cầu bắt buộc khi checkbox không được chọn
                document.querySelectorAll('#shipping-address input:not([name="shipping_note"]), #shipping-address select').forEach(field => {
                    field.removeAttribute('required');
                });
            }
        });

        // Thêm validation phía client khi submit form
        document.getElementById('checkoutForm').addEventListener('submit', function(event) {
            if (shipToDifferentAddressCheckbox.checked) {
                const province = shippingProvinceSelect.value;
                const district = shippingDistrictSelect.value;
                const ward = shippingWardSelect.value;

                if (!province || !district || !ward) {
                    event.preventDefault();
                    alert('Vui lòng chọn đầy đủ Tỉnh/Thành phố, Quận/Huyện và Phường/Xã!');
                    return false;
                }
            }
        });
    });
</script>
<!-- Kết thúc Thanh Toán -->
@endsection

@section('scripts')
@include('alert')
@endsection
