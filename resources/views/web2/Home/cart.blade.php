@extends('web2.layout.master')

@section('content')

<!-- Navbar End -->


<!-- Page Header Start -->
{{-- <div class="container-fluid bg-secondary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3">GIỎ HÀNG</h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="">Trang chủ</a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0">Giỏ hàng</p>
        </div>
    </div>
</div> --}}
<!-- Page Header End -->


<!-- Cart Start -->
<div class="container-fluid pt-5">
    <div class="row px-xl-5">
        <div class="col-lg-8 table-responsive mb-5">
            <table class="table table-bordered text-center mb-0">
                <thead class="bg-secondary text-dark">
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Tổng cộng</th>
                        <th>Biến thể</th>
                        <th>Xóa</th>
                    </tr>
                </thead>
                <tbody class="align-middle">
                    @foreach (session('cart', []) as $cartKey => $item)
    <tr>
        <td class="align-middle">
            <img src="{{ asset('storage/' . ($item['image'] ?? 'default.jpg')) }}" alt="" style="width: 50px;">
            {{ $item['name'] }}
        </td>
        <td class="align-middle">
            {{ number_format($item['price'], 0, ',', '.') }}₫
        </td>
        <td class="align-middle">
            <form action="{{ route('cart.update', $cartKey) }}" method="POST" class="update-cart-form">
                @csrf
                <input type="hidden" name="quantity" id="quantity-{{ $cartKey }}" value="{{ $item['quantity'] }}">
                
                <!-- Giảm số lượng -->
                <button type="button" class="btn btn-sm btn-primary btn-minus" data-cart-key="{{ $cartKey }}" data-action="decrease">-</button>
                
                <!-- Hiển thị số lượng hiện tại -->
                <input type="text" class="form-control form-control-sm bg-secondary text-center" id="quantity-display-{{ $cartKey }}" value="{{ $item['quantity'] }}" readonly>
                
                <!-- Tăng số lượng -->
                <button type="button" class="btn btn-sm btn-primary btn-plus" data-cart-key="{{ $cartKey }}" data-action="increase">+</button>
            </form>
        </td>
        
        <td class="align-middle">{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}₫</td>
        <td class="align-middle">
            @if(isset($item['variant']) && isset($item['variant']['attributes']) && count($item['variant']['attributes']) > 0)
                @foreach ($item['variant']['attributes'] as $attrName => $attrValue)
                    <p><strong>{{ $attrName }}:</strong> {{ $attrValue }}</p>
                @endforeach
            @else
                <p>Không có biến thể</p>
            @endif
        </td>
    
        <td class="align-middle">
            <form action="{{ route('cart.remove', $cartKey) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-times"></i></button>
            </form>
        </td>
    </tr>
@endforeach


                </tbody>
            </table>
            <a href="{{route('web.shop')}}">Thêm sản phẩm</a>
            
            
        </div>
        <div class="col-lg-4">
            <form action="{{ route('cart.applyPromotion') }}" method="POST">
                @csrf
                <div class="input-group">
                    <input type="text" name="coupon_code" class="form-control p-4" placeholder="Nhập mã giảm giá">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">Áp dụng mã</button>
                    </div>
                </div>
            </form>
            
            @if(session('success'))
                <p class="text-success">{{ session('success') }}</p>
            @endif
            @if(session('error'))
                <p class="text-danger">{{ session('error') }}</p>
            @endif
            
            <?php
            $cart = session('cart', []);
            $subtotal = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));
            $promotion = session('promotion');
            $shippingFee = 10000; // Phí vận chuyển cố định hoặc có thể thay đổi
            
            $discount = $promotion['discount'] ?? 0;
            $total = max(0, $subtotal - $discount + $shippingFee);
            ?>
            
            <div class="card border-secondary mb-5">
                <div class="card-header bg-secondary border-0">
                    <h4 class="font-weight-semi-bold m-0">Tóm tắt giỏ hàng</h4>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3 pt-1">
                        <h6 class="font-weight-medium">Tạm tính</h6>
                        <h6 class="font-weight-medium">{{ number_format($subtotal, 0, ',', '.') }}₫</h6>
                    </div>
                    @if($promotion)
                    <div class="d-flex justify-content-between mb-3 pt-1">
                        <h6 class="font-weight-medium text-success">Giảm giá ({{ $promotion['code'] }})</h6>
                        <h6 class="font-weight-medium text-success">-{{ number_format($discount, 0, ',', '.') }}₫</h6>
                    </div>
                    @endif
                    <div class="d-flex justify-content-between">
                        <h6 class="font-weight-medium">Phí vận chuyển</h6>
                        <h6 class="font-weight-medium">{{ number_format($shippingFee, 0, ',', '.') }}₫</h6>
                    </div>
                </div>
                <div class="card-footer border-secondary bg-transparent">
                    <div class="d-flex justify-content-between mt-2">
                        <h5 class="font-weight-bold">Tổng cộng</h5>
                        <h5 class="font-weight-bold">{{ number_format($total, 0, ',', '.') }}₫</h5>
                    </div>
                   <!-- Form chứa thông tin thanh toán -->
<form id="checkout-form" action="{{ route('checkout.index') }}" method="POST">
    @csrf <!-- Đảm bảo bảo mật khi gửi form POST -->
    
    <!-- Các trường thông tin cần thiết, ví dụ: -->
    <input type="hidden" name="totalAmount" value="{{ $totalAmount }}">
    <input type="hidden" name="cartData" value="{{ json_encode($cart) }}"> <!-- Dữ liệu giỏ hàng -->
    
    <!-- Thêm các trường khác nếu cần -->
</form>

<!-- Nút thanh toán -->
<a href="{{ route('checkout.index') }}" 
    onclick="event.preventDefault(); document.getElementById('checkout-form').submit();" 
    class="btn btn-block btn-primary my-3 py-3">
    Tiến hành thanh toán
</a>

                 
                 <form id="checkout-form" action="{{ route('checkout.index') }}" method="POST" style="display: none;">
                     @csrf
                     <input type="hidden" name="totalAmount" value="{{ $total }}">
                 </form>
                </div>
            </div>
            
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        @if(session('clear_cart'))
            localStorage.removeItem('cart'); // Xóa giỏ hàng trên trình duyệt
            console.log("Giỏ hàng đã bị xóa khỏi localStorage.");
        @endif
    });
</script>
<script>
    $(document).ready(function() {
    // Xử lý nút tăng/giảm
    $('.btn-minus, .btn-plus').on('click', function() {
        var cartKey = $(this).data('cart-key');
        var action = $(this).data('action');
        var quantityInput = $('#quantity-' + cartKey);
        var quantityDisplay = $('#quantity-display-' + cartKey);
        var currentQuantity = parseInt(quantityInput.val());

        // Tính toán số lượng mới
        var newQuantity = action === 'increase' ? currentQuantity + 1 : Math.max(1, currentQuantity - 1);

        // Cập nhật giá trị của input ẩn (sẽ gửi lên server)
        quantityInput.val(newQuantity);
        
        // Cập nhật hiển thị số lượng
        quantityDisplay.val(newQuantity);

        // Gửi yêu cầu AJAX để cập nhật giỏ hàng
        $.ajax({
            url: '{{ route('cart.update', ':cartKey') }}'.replace(':cartKey', cartKey),
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                quantity: newQuantity
            },
            success: function(response) {
                // Cập nhật sau khi thành công (có thể hiển thị thông báo, cập nhật tổng tiền, v.v.)
            },
            error: function(xhr, status, error) {
                // Xử lý lỗi nếu có
                alert('Có lỗi xảy ra khi cập nhật giỏ hàng.');
            }
        });
    });
});

</script>

<!-- Cart End -->
@endsection