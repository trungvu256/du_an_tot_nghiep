@extends('web3.layout.master2')

@section('content')
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                <form id="cart-items-form">
                    <table class="table table-bordered text-center mb-0">
                        <thead class="bg-secondary text-dark">
                            <tr>
                                <th>Chọn</th>
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
                                <tr id="cart-item-{{ $cartKey }}">
                                    <td class="align-middle">
                                        <input type="checkbox" class="product-checkbox" name="selected_products[]"
                                            value="{{ $cartKey }}" onchange="updateSummary()">
                                    </td>
                                    <td class="align-middle">
                                        <img src="{{ asset('storage/' . ($item['image'] ?? 'default.jpg')) }}"
                                            alt="" style="width: 50px;">
                                        {{ $item['name'] }}
                                    </td>
                                    <td class="align-middle text-center price" data-price="{{ $item['price'] }}"
                                        id="price-{{ $cartKey }}">
                                        {{ number_format($item['price'], 0, ',', '.') }}₫
                                    </td>
                                    <td class="align-middle">
                                        <div
                                            class="update-cart-form d-flex align-items-center justify-content-center gap-1">
                                            <input type="hidden" name="quantity" id="quantity-{{ $cartKey }}"
                                                value="{{ $item['quantity'] }}"
                                                data-stock-quantity="{{ $item['stock_quantity'] ?? 0 }}">
                                            <button type="button" class="btn btn-sm btn-outline-secondary btn-minus"
                                                data-cart-key="{{ $cartKey }}" data-action="decrease">
                                                -
                                            </button>
                                            <input type="text"
                                                class="form-control form-control-sm text-center bg-light quantity-display"
                                                style="width: 100px;" id="quantity-display-{{ $cartKey }}"
                                                value="{{ $item['quantity'] }}">
                                            <button type="button" class="btn btn-sm btn-outline-secondary btn-plus"
                                                data-cart-key="{{ $cartKey }}" data-action="increase">
                                                +
                                            </button>
                                        </div>
                                    </td>
                                    <td class="align-middle item-total" id="item-total-{{ $cartKey }}">
                                        {{ number_format((float) $item['price'] * (int) $item['quantity'], 0, ',', '.') }}₫
                                    </td>
                                    <td class="align-middle">
                                        @if (isset($item['variant']) && isset($item['variant']['attributes']) && count($item['variant']['attributes']) > 0)
                                            @foreach ($item['variant']['attributes'] as $attrName => $attrValue)
                                                <p><strong>{{ $attrName }}:</strong> {{ $attrValue }}</p>
                                            @endforeach
                                        @else
                                            <p>Không có biến thể</p>
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-danger btn-remove-item"
                                            data-cart-key="{{ $cartKey }}" onclick="return confirm('Xóa khỏi giỏ hàng')">
                                            x
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <a href="{{ route('web.shop') }}" class="btn btn-success">Thêm sản phẩm</a>
                </form>
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
                @if (session('success'))
                    <p class="text-success">{{ session('success') }}</p>
                @endif
                @if (session('error'))
                    <p class="text-danger">{{ session('error') }}</p>
                @endif

                <?php
                $cart = session('cart', []);
                $subtotal = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));
                $promotion = session('promotion');
                $discount = $promotion['discount'] ?? 0;
                $total = max(0, $subtotal - $discount);
                ?>

                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Tóm tắt giỏ hàng</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3 pt-1">
                            <h6 class="font-weight-medium">Tạm tính</h6>
                            <h6 class="font-weight-medium" id="summary-subtotal">0₫</h6>
                        </div>
                        @if ($promotion)
                            <div class="d-flex justify-content-between mb-3 pt-1">
                                <h6 class="font-weight-medium text-success">Giảm giá ({{ $promotion['code'] }})</h6>
                                <h6 class="font-weight-medium text-success" id="summary-discount">-{{ number_format($discount, 0, ',', '.') }}₫</h6>
                            </div>
                        @endif
                    </div>
                    <div class="card-footer border-secondary bg-transparent">
                        <div class="d-flex justify-content-between mt-2">
                            <h5 class="font-weight-bold">Tổng cộng</h5>
                            <h5 class="font-weight-bold" id="summary-total">0₫</h5>
                        </div>
                        <form id="checkout-form" action="{{ route('checkout.view') }}" method="POST">
                            @csrf
                            <input type="hidden" name="selected_cart_items" id="selected_cart_items">
                            <input type="hidden" name="subtotal" id="subtotal">
                            <input type="hidden" name="discount" id="discount">
                            <input type="hidden" name="total" id="total">

                            <button type="submit" class="btn btn-block btn-primary my-3 py-3">
                                Tiến hành thanh toán
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Hàm định dạng tiền tệ
        function formatCurrency(value) {
            return value.toLocaleString('vi-VN') + '₫';
        }

        // Hàm lấy số từ chuỗi tiền tệ
        function getCurrencyNumber(value) {
            return parseInt(value.replace(/\D/g, '')) || 0;
        }

        // Hàm cập nhật số lượng qua AJAX
        function updateCartQuantity(cartKey, quantity) {
            const quantityInput = $('#quantity-' + cartKey);
            const quantityDisplay = $('#quantity-display-' + cartKey);
            const stockQuantity = parseInt(quantityInput.data('stock-quantity'));

            // Giới hạn số lượng: tối thiểu 1, tối đa là stock
            quantity = Math.max(1, Math.min(stockQuantity, parseInt(quantity) || 1));

            // Cập nhật giao diện ngay lập tức
            quantityInput.val(quantity);
            quantityDisplay.val(quantity);

            const price = parseInt($('#price-' + cartKey).data('price'));
            const itemTotal = price * quantity;
            $('#item-total-' + cartKey).text(formatCurrency(itemTotal));

            // Gọi AJAX để cập nhật server
            $.ajax({
                url: '{{ route('cart.update', ':id') }}'.replace(':id', cartKey),
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    quantity: quantity
                },
                success: function(response) {
                    if (response.success) {
                        console.log('Updated quantity for cartKey:', cartKey, 'to:', quantity);
                        updateSummary();
                    }
                },
                error: function(xhr) {
                    alert('Có lỗi xảy ra khi cập nhật giỏ hàng: ' + xhr.responseText);
                    // Hoàn nguyên nếu lỗi
                    quantityDisplay.val(quantityInput.val());
                    updateSummary();
                }
            });
        }

        // Hàm cập nhật tóm tắt giỏ hàng
        function updateSummary() {
            let subtotal = 0;
            $('.product-checkbox:checked').each(function() {
                const row = $(this).closest('tr');
                const price = parseInt(row.find('.price').data('price'));
                const quantity = parseInt(row.find('.quantity-display').val());
                subtotal += price * quantity;
            });

            // Lấy giá trị giảm giá từ giao diện
            const discount = getCurrencyNumber(document.getElementById('summary-discount')?.innerText || '0');

            // Tính tổng cộng
            const total = Math.max(0, subtotal - discount);

            // Cập nhật giao diện
            $('#summary-subtotal').text(formatCurrency(subtotal));
            $('#summary-total').text(formatCurrency(total));

            // Cập nhật các input ẩn cho form checkout
            $('#subtotal').val(subtotal);
            $('#discount').val(discount);
            $('#total').val(total);

            console.log('updateSummary - Subtotal:', subtotal, 'Discount:', discount, 'Total:', total);
        }

        // Xử lý xóa sản phẩm
        $(document).on('click', '.btn-remove-item', function(e) {
            e.preventDefault();
            let cartKey = $(this).data('cart-key');

            $.ajax({
                url: '{{ route('cart.remove', ':cartKey') }}'.replace(':cartKey', cartKey),
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(res) {
                    if (res.success) {
                        $('#cart-item-' + cartKey).remove();
                        $('.cart-badge').text(res.cartCount);
                        updateSummary();
                    }
                },
                error: function(err) {
                    alert("Xóa thất bại! Vui lòng thử lại.");
                }
            });
        });

        $(document).ready(function() {
            // Xử lý nút tăng/giảm
            $(document).on('click', '.btn-minus, .btn-plus', function(e) {
                e.preventDefault();
                const cartKey = $(this).data('cart-key');
                const action = $(this).data('action');
                const quantityDisplay = $('#quantity-display-' + cartKey);
                let quantity = parseInt(quantityDisplay.val()) || 1;

                if (action === 'increase') {
                    quantity += 1; // Tăng 1 đơn vị
                } else if (action === 'decrease') {
                    quantity -= 1; // Giảm 1 đơn vị
                }

                updateCartQuantity(cartKey, quantity);
            });

            // Xử lý khi nhập tay vào input
            $(document).on('input', '.quantity-display', function() {
                const cartKey = $(this).attr('id').replace('quantity-display-', '');
                let newQuantity = $(this).val();

                // Chỉ cho phép nhập số
                newQuantity = newQuantity.replace(/\D/g, '');
                if (newQuantity === '') newQuantity = 1; // Mặc định là 1 nếu rỗng
                $(this).val(newQuantity);

                updateCartQuantity(cartKey, newQuantity);
            });

            // Gắn sự kiện checkbox
            $('.product-checkbox').on('change', updateSummary);

            // Cập nhật tóm tắt ban đầu
            updateSummary();
        });

        // Xử lý submit form checkout
        document.getElementById("checkout-form").addEventListener("submit", function(e) {
            e.preventDefault();

            const selected = Array.from(document.querySelectorAll(".product-checkbox:checked"))
                .map(cb => cb.value);

            if (selected.length === 0) {
                alert("Vui lòng chọn ít nhất 1 sản phẩm để thanh toán.");
                return;
            }

            document.getElementById("selected_cart_items").value = JSON.stringify(selected);
            this.submit();
        });
    </script>
@endsection