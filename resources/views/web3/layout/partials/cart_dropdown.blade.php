@if (count($cart) > 0)
    @foreach ($cart as $key => $item)
        <li class="d-flex align-items-center justify-content-between">
            <div class="d-flex">
                <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}" width="50" height="50" class="me-2">
                <div>
                    <strong>{{ $item['name'] }}</strong><br>
                    @if (isset($item['variant']) && isset($item['variant']['attributes']) && count($item['variant']['attributes']) > 0)
                    @foreach ($item['variant']['attributes'] as $attrName => $attrValue)
                        <p class="mb-0" style="font-size: 15px; font-style: italic">{{ $attrName }}: {{ $attrValue }}</p>
                    @endforeach
                @else
                    <p class="mb-0">Không có biến thể</p>
                @endif
                <br>
                    <small>{{ $item['quantity'] }} x
                        {{ number_format(!empty($item['price_sale']) && $item['price_sale'] > 0 && $item['price_sale'] < $item['price'] ? $item['price_sale'] : $item['price'], 0, ',', '.') }}
                        VNĐ</small>
                </div>
            </div>
            <button type="button"
                    class="btn btn-sm btn-danger btn-remove-item"
                    data-url="{{ route('cart.removess', $key) }}">
                x
            </button>
        </li>
        <hr>
    @endforeach
    <li class="text-center">
        <strong>
            Tổng: {{ number_format($subtotal ?? collect($cart)->sum(function($item) {
                $price = (!empty($item['price_sale']) && $item['price_sale'] > 0 && $item['price_sale'] < $item['price'])
                    ? $item['price_sale']
                    : $item['price'];
                return $item['quantity'] * $price;
            }), 0, ',', '.') }} VNĐ
        </strong>
    </li>
    
    <li class="text-center mt-2">
        <a href="{{ route('cart.viewCart') }}" class="btn btn-primary btn-sm w-100">Xem giỏ hàng</a>
    </li>
@else
    <li class="text-center text-muted">Giỏ hàng trống</li>
@endif

{{-- <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger cart-count"
      style="font-size: 10px">
    {{ session('cart') ? collect(session('cart'))->sum(fn($item) => (int) $item['quantity']) : 0 }}
</span> --}}

<!-- Đảm bảo có CSRF token trong <head> -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    // Thiết lập CSRF token mặc định cho mọi Ajax request
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).on('click', '.btn-remove-item', function (e) {
        e.preventDefault();

        const button = $(this);
        const url = button.data('url');

        $.ajax({
            url: url,
            method: 'POST',
            success: function (response) {
                if (response.success) {
                    $('.cart-dropdown').html(response.cartHtml);  // Cập nhật lại giao diện giỏ hàng
                    $('.cart-count').text(response.cartCount);     // Cập nhật số lượng
                    $('.cart-subtotal').text(response.subtotal);   // Cập nhật tổng tiền
                }
            },
            error: function (xhr) {
                console.error(xhr.responseText); // Log lỗi vào console để debug nếu cần
            }
        });
    });
});
</script>