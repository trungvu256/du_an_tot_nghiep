@extends('web2.layout.master')

@section('content')
    <!-- Kết thúc Thanh Điều Hướng -->


    <!-- Bắt đầu Tiêu Đề Trang -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Thanh Toán</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="">Trang chủ</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Thanh toán</p>
            </div>
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
            $selectedCart = session()->get('selected_cart', []);
            $subtotal = 0;
            // $shipping_fee = 10000;
        
            foreach ($selectedCart as $item) {
                $subtotal += $item['price'] * $item['quantity'];
            }
        
            $discount = session('promotion')['discount'] ?? 0;
            $totalAmount = $subtotal - $discount;
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
                    <p>{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}đ</p>
                </div>
            @endforeach
        
            <hr class="mt-0">
        
            <div class="d-flex justify-content-between mb-3 pt-1">
                <h6 class="font-weight-medium">Tạm tính</h6>
                {{  $subtotal = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $filteredCart)); }}đ
            </div>
        
            @if ($discount > 0)
                <div class="d-flex justify-content-between mb-3 pt-1">
                    <h6 class="font-weight-medium text-success">Giảm giá ({{ session('promotion')['code'] }})</h6>
                    <h6 class="font-weight-medium text-success" id="summary-discount">-{{ number_format($discount, 0, ',', '.') }}đ</h6>
                </div>
            @endif
        
            {{-- <div class="d-flex justify-content-between">
                <h6 class="font-weight-medium">Phí giao hàng</h6>
                <h6 class="font-weight-medium" id="summary-shipping">{{ number_format($shipping_fee, 0, ',', '.') }}đ</h6>
            </div> --}}
        </div>
        
        <div class="card-footer border-secondary bg-transparent">
            <div class="d-flex justify-content-between mt-2">
                <h5 class="font-weight-bold">Tổng</h5>
                <h5 class="font-weight-bold" id="summary-total">
                    {{ number_format  ($totalAmount = max(0, $subtotal - $discount )) }}đ
                </h5>
            </div>
        </div>
        
    </div>

    <div class="card-footer border-secondary bg-transparent">
        <form action="{{ route('checkout.depositVNPay') }}" method="POST" class="payment-form">
            @csrf
            <input type="hidden" name="amount" value="{{ $totalAmount }}">
            <button type="submit" class="btn btn-primary btn-payment mt-3">💰 Thanh toán bằng VNPay</button>
        </form>
    </div>

    <div class="card-footer border-secondary bg-transparent">
        <form action="{{ route('checkout.offline') }}" method="POST" class="payment-form">
            @csrf
            <!-- Lấy mảng các cart_key đã chọn -->
            <input type="hidden" name="selected_cart_items" id="selected_cart_items" value="[]">
            <input type="hidden" name="amount" value="{{ $totalAmount }}">
            <button type="submit" class="btn btn-primary btn-payment">Thanh toán bằng tiền mặt</button>
        </form>
        
    </div>
</div>

        </div>
    </div>
    <script>
        // Cập nhật selected_cart_items khi người dùng chọn các sản phẩm
        let selectedItems = []; // Mảng các cart_key đã chọn
        document.querySelectorAll('.cart-item-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', (event) => {
                if (event.target.checked) {
                    selectedItems.push(event.target.dataset.cartKey);
                } else {
                    selectedItems = selectedItems.filter(item => item !== event.target.dataset.cartKey);
                }
                document.getElementById('selected_cart_items').value = JSON.stringify(selectedItems);
            });
        });
    </script>
    <script>
        // Cập nhật selected_cart_items khi người dùng chọn các sản phẩm
        let selectedItems = []; // Mảng các cart_key đã chọn
        document.querySelectorAll('.cart-item-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', (event) => {
                if (event.target.checked) {
                    selectedItems.push(event.target.dataset.cartKey);
                } else {
                    selectedItems = selectedItems.filter(item => item !== event.target.dataset.cartKey);
                }
                // Log selectedItems để kiểm tra
                console.log("Selected items: ", selectedItems);
                document.getElementById('selected_cart_items').value = JSON.stringify(selectedItems);
            });
        });
    </script>
    
    <!-- Kết thúc Thanh Toán -->
@endsection
