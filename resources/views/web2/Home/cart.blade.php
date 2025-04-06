@extends('web2.layout.master')

@section('content')
    {{-- @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif --}}

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
                                <tr>
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
                                            <!-- Giá trị mặc định là 0 -->
                                            <button type="button" class="btn btn-sm btn-outline-secondary btn-minus"
                                                data-cart-key="{{ $cartKey }}" data-action="decrease">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <input type="text"
                                                class="form-control form-control-sm text-center bg-light quantity-display"
                                                style="width: 100px;" id="quantity-display-{{ $cartKey }}"
                                                value="{{ $item['quantity'] }}">
                                            <button type="button" class="btn btn-sm btn-outline-secondary btn-plus"
                                                data-cart-key="{{ $cartKey }}" data-action="increase">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </td>
                                    <td class="align-middle item-total" id="item-total-{{ $cartKey }}">
                                        {{ number_format((float) $item['price'] * (int) $item['quantity'], 0, ',', '.') }}₫
                                    </td>
                                    <!-- Các phần còn lại giữ nguyên -->


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
                                            <i class="fa fa-times"></i>
                                        </button>
                                        <script>
                                            // Hàm format tiền
                                            function formatCurrency(value) {
                                                return value.toLocaleString('vi-VN') + '₫';
                                            }

                                            // Xử lý xóa sản phẩm
                                            $(document).on('click', '.btn-remove-item', function(e) {
                                                e.preventDefault();
                                                let cartKey = $(this).data('cart-key'); // Lấy cartKey từ data-cart-key

                                                $.ajax({
                                                    url: '{{ route('cart.remove', ':cartKey') }}'.replace(':cartKey',
                                                    cartKey), // Thay thế :cartKey trong URL
                                                    type: 'POST',
                                                    data: {
                                                        _token: '{{ csrf_token() }}', // Gửi token bảo mật
                                                    },
                                                    success: function(res) {
                                                        if (res.success) {
                                                            // Xóa sản phẩm khỏi DOM
                                                            $('#cart-item-' + cartKey).remove();

                                                            // Cập nhật lại tổng tiền giỏ hàng và số lượng sản phẩm
                                                            $('#summary-subtotal').text(formatCurrency(res.totalAmount));
                                                            $('#summary-total').text(formatCurrency(res.totalAmount +
                                                            10000)); // Phí vận chuyển giả sử là 10000
                                                            $('.cart-badge').text(res
                                                            .cartCount); // Cập nhật số lượng sản phẩm trong giỏ hàng

                                                            // Gọi lại updateSummary để đảm bảo giao diện được cập nhật
                                                            updateSummary();
                                                        } 
                                                    },
                                                    error: function(err) {
                                                        alert("Xóa thất bại! Vui lòng thử lại.");
                                                    }
                                                });
                                            });
                                        </script>
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
                $shippingFee = 10000; // Phí vận chuyển cố định hoặc có thể thay đổi
                
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
                                <h6 class="font-weight-medium text-success">-{{ number_format($discount, 0, ',', '.') }}₫
                                </h6>
                            </div>
                        @endif
                        {{-- <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Phí vận chuyển</h6>
                            <h6 class="font-weight-medium" id="summary-shipping">10.000₫</h6>
                        </div> --}}
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
                            {{-- <input type="hidden" name="shipping_fee" id="shipping_fee"> --}}
                            <input type="hidden" name="total" id="total">

                            {{-- @foreach ($cart as $cartKey => $item)
                                <div class="cart-item">
                                    <input type="checkbox" class="cart-item-checkbox" data-cart-key="{{ $cartKey }}" />
                                    <span>{{ $item['name'] }}</span>
                                    <!-- Các thông tin khác của sản phẩm -->
                                </div>
                            @endforeach --}}

                            <button type="submit" class="btn btn-block btn-primary my-3 py-3">
                                Tiến hành thanh toán
                            </button>
                        </form>

                        <script>
                            // Khi form được submit, lấy các sản phẩm đã chọn
                            document.getElementById('checkout-form').addEventListener('submit', function(event) {
                                var selectedItems = [];
                                document.querySelectorAll('.cart-item-checkbox:checked').forEach(function(checkbox) {
                                    selectedItems.push(checkbox.getAttribute('data-cart-key'));
                                });

                                // Đưa các sản phẩm đã chọn vào input hidden
                                document.getElementById('selected_cart_items').value = JSON.stringify(selectedItems);

                                // Tính toán subtotal, discount và total ở đây (nếu cần thiết)
                                var subtotal = 0;
                                // var shipping_fee =0;
                                var discount = 0; // Lấy từ session nếu có

                                // Cập nhật subtotal và các giá trị tính toán khác
                                selectedItems.forEach(function(cartKey) {
                                    var item = {!! json_encode($cart) !!}[cartKey];
                                    subtotal += item.price * item.quantity;
                                });

                                var total = subtotal - discount;

                                // Đưa vào các input hidden
                                document.getElementById('subtotal').value = subtotal;
                                document.getElementById('discount').value = discount;
                                // document.getElementById('shipping_fee').value = shipping_fee;
                                document.getElementById('total').value = total;
                            });
                        </script>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Hàm định dạng tiền tệ
        function formatCurrency(value) {
            return value.toLocaleString('vi-VN') + '₫';
        }

        // Hàm lấy số từ chuỗi
        function getCurrencyNumber(value) {
            // Chỉ lấy các chữ số và chuyển thành số nguyên
            return parseInt(value.replace(/\D/g, '')) || 1;
        }

        // Hàm cập nhật số lượng qua AJAX
        function updateCartQuantity(cartKey, quantity) {
            const quantityInput = $('#quantity-' + cartKey);
            const quantityDisplay = $('#quantity-display-' + cartKey);
            const stockQuantity = parseInt(quantityInput.data('stock-quantity'));

            // Giới hạn số lượng: tối thiểu 1, tối đa là stock
            quantity = Math.max(1, Math.min(stockQuantity, parseInt(quantity)));

            $.ajax({
                url: '{{ route('cart.update', ':id') }}'.replace(':id', cartKey),
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    quantity: quantity
                },
                success: function(response) {
                    if (response.success) {
                        // Cập nhật giao diện
                        quantityInput.val(quantity);
                        quantityDisplay.val(quantity);

                        const price = parseInt($('#price-' + cartKey).data('price'));
                        const itemTotal = price * quantity;
                        $('#item-total-' + cartKey).text(formatCurrency(itemTotal));

                        updateSummary();
                    }
                },
                error: function(xhr) {
                    alert('Có lỗi xảy ra khi cập nhật giỏ hàng: ' + xhr.responseText);
                    quantityDisplay.val(quantityInput.val()); // Hoàn nguyên nếu lỗi
                }
            });
        }

        $(document).ready(function() {
            // Xử lý nút tăng/giảm
            $(document).on('click', '.btn-minus, .btn-plus', function(e) {
                e.preventDefault();
                const cartKey = $(this).data('cart-key');
                const action = $(this).data('action');
                const quantityDisplay = $('#quantity-display-' + cartKey);
                let quantity = parseInt(quantityDisplay.val());

                if (action === 'increase') {
                    quantity++;
                } else if (action === 'decrease' && quantity > 1) {
                    quantity--;
                }

                updateCartQuantity(cartKey, quantity);
            });

            // Xử lý khi nhập tay vào input
            $(document).on('input', '.quantity-display', function() {
                const cartKey = $(this).attr('id').replace('quantity-display-', '');
                let newQuantity = $(this).val();

                // Chỉ cho phép nhập số
                newQuantity = newQuantity.replace(/\D/g, '');
                if (newQuantity === '') newQuantity = ''; // Mặc định là 1 nếu rỗng
                $(this).val(newQuantity);

                updateCartQuantity(cartKey, newQuantity);
            });

            // Hàm cập nhật tóm tắt giỏ hàng
            function updateSummary() {
                let subtotal = 0;
                $('.product-checkbox:checked').each(function() {
                    const row = $(this).closest('tr');
                    const price = parseInt(row.find('.price').data('price'));
                    const quantity = parseInt(row.find('.quantity-display').val());
                    subtotal += price * quantity;
                });

                $('#summary-subtotal').text(formatCurrency(subtotal));
                $('#summary-total').text(formatCurrency(subtotal));
            }

            // Gắn sự kiện checkbox
            $('.product-checkbox').on('change', updateSummary);
            updateSummary();
        });

        // Xử lý submit form
        document.getElementById("checkout-form").addEventListener("submit", function(e) {
            e.preventDefault();

            const selected = Array.from(document.querySelectorAll(".product-checkbox:checked"))
                .map(cb => cb.value);

            if (selected.length === 0) {
                alert("Vui lòng chọn ít nhất 1 sản phẩm để thanh toán.");
                return;
            }

            document.getElementById("selected_cart_items").value = JSON.stringify(selected);

            let subtotal = 0;
            selected.forEach(cartKey => {
                const price = parseFloat(document.getElementById(`price-${cartKey}`).dataset.price);
                const quantity = parseInt(document.getElementById(`quantity-display-${cartKey}`).value);
                subtotal += price * quantity;
            });

            const discount = getCurrencyNumber(document.getElementById("summary-discount")?.innerText || '0');
            const shippingFee = getCurrencyNumber(document.getElementById("summary-shipping")?.innerText || '0');
            const total = subtotal - discount + shippingFee;

            document.getElementById("subtotal").value = subtotal;
            document.getElementById("discount").value = discount;
            document.getElementById("total").value = total;

            this.submit();
        });
    </script>
@endsection
