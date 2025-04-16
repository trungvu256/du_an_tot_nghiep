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
                                    <td class="align-middle text-center price" data-price="{{ isset($item['price_sale']) && $item['price_sale'] > 0 ? $item['price_sale'] : $item['price'] }}"
                                        id="price-{{ $cartKey }}">
                                        @if(isset($item['price_sale']) && $item['price_sale'] > 0)
                                            {{ number_format($item['price_sale'], 0, ',', '.') }}VNĐ
                                        @else
                                            {{ number_format($item['price'], 0, ',', '.') }}VNĐ
                                        @endif
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
                                        @php
                                            $finalPrice = isset($item['price_sale']) && $item['price_sale'] > 0 ? $item['price_sale'] : $item['price'];
                                            $total = $finalPrice * (int)$item['quantity'];
                                        @endphp
                                        {{ number_format($total, 0, ',', '.') }}VNĐ
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
                {{-- <form action="{{ route('cart.applyPromotion') }}" method="POST">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="coupon_code" class="form-control p-4" placeholder="Nhập mã giảm giá">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary">Áp dụng mã</button>
                        </div>
                    </div>
                </form> --}}
                <div class="mt-2">
                    <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#promotionsModal">
                        <i class="fa fa-tag"></i> Xem mã khuyến mãi có thể áp dụng
                    </button>
                </div>
                @if (session('success'))
                    <p class="text-success">{{ session('success') }}</p>
                @endif
                @if (session('error'))
                    <p class="text-danger">{{ session('error') }}</p>
                @endif

                <?php
                $cart = session('cart', []);
                $subtotal = 0;
                foreach ($cart as $item) {
                    $itemPrice = isset($item['price_sale']) && $item['price_sale'] > 0 ? $item['price_sale'] : $item['price'];
                    $subtotal += $itemPrice * $item['quantity'];
                }
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
                            <h6 class="font-weight-medium" id="summary-subtotal">{{ number_format($subtotal, 0, ',', '.') }}VNĐ</h6>
                        </div>
                        @if ($promotion)
                            <div class="d-flex justify-content-between mb-3 pt-1">
                                <h6 class="font-weight-medium text-success">Giảm giá ({{ $promotion['code'] }})</h6>
                                <h6 class="font-weight-medium text-success" id="summary-discount">-{{ number_format($discount, 0, ',', '.') }}VNĐ</h6>
                            </div>
                        @endif
                    </div>
                    <div class="card-footer border-secondary bg-transparent">
                        <div class="d-flex justify-content-between mt-2">
                            <h5 class="font-weight-bold">Tổng cộng</h5>
                            <h5 class="font-weight-bold" id="summary-total">{{ number_format($total, 0, ',', '.') }}VNĐ</h5>
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

    <!-- Modal Mã Khuyến Mãi -->
    <div class="modal fade" id="promotionsModal" tabindex="-1" role="dialog" aria-labelledby="promotionsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="promotionsModalLabel">Mã Khuyến Mãi Có Thể Áp Dụng</h5>
                    {{-- <button type="button" class="close" id="closeModalBtn" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> --}}
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="bg-secondary text-dark text-center">
                                <tr>
                                    <th>Mã</th>
                                    <th>Loại</th>
                                    <th>Giá trị</th>
                                    <th>Điều kiện</th>
                                    <th>Hạn sử dụng</th>
                                    <th>Số lượng</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody id="promotions-list" class="text-center">
                                <tr>
                                    <td colspan="7" class="text-center">Đang tải dữ liệu...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                {{-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="closeModalBtn2">Đóng</button>
                </div> --}}
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Hàm định dạng tiền tệ
        function formatCurrency(value) {
            if (typeof value !== 'number' || isNaN(value)) {
                value = 0;
            }
            return new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(value).replace(/\s+/g, '');
        }

        // Hàm lấy số từ chuỗi tiền tệ
        function getCurrencyNumber(value) {
            if (!value) return 0;
            // Kiểm tra có dấu trừ không
            const isNegative = value.includes('-');
            // Lấy số (bỏ qua tất cả ký tự không phải số)
            const number = parseInt(value.replace(/[^\d]/g, '')) || 0;
            // Trả về số âm nếu có dấu trừ, ngược lại trả về số dương
            return isNegative ? -number : number;
        }

        // Hàm cập nhật số lượng qua AJAX
        function updateCartQuantity(cartKey, quantity) {
            const quantityInput = $('#quantity-' + cartKey);
            const quantityDisplay = $('#quantity-display-' + cartKey);
            const stockQuantity = parseInt(quantityInput.data('stock-quantity')) || 0;

            // Giới hạn số lượng: tối thiểu 1, tối đa là stock
            quantity = Math.max(1, Math.min(stockQuantity, parseInt(quantity) || 1));

            // Cập nhật giao diện ngay lập tức
            quantityInput.val(quantity);
            quantityDisplay.val(quantity);

            const priceElement = $('#price-' + cartKey);
            const price = parseFloat(priceElement.data('price')) || 0;
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
                        updateSummary();
                    }
                },
                error: function(xhr) {
                    alert('Có lỗi xảy ra khi cập nhật giỏ hàng: ' + xhr.responseText);
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
                const priceElement = row.find('.price');
                const price = parseFloat(priceElement.data('price')) || 0;
                const quantity = parseInt(row.find('.quantity-display').val()) || 0;

                if (price > 0 && quantity > 0) {
                    subtotal += price * quantity;
                }
            });

            // Lấy giá trị giảm giá từ giao diện
            const discountElement = document.getElementById('summary-discount');
            const discountText = discountElement ? discountElement.innerText : '0';

            // Xử lý đặc biệt cho giá trị giảm giá có dấu trừ ở đầu
            let discount = 0;
            if (discountText.includes('-')) {
                // Nếu có dấu trừ, cần chuyển thành số âm
                discount = -Math.abs(getCurrencyNumber(discountText));
            } else {
                discount = getCurrencyNumber(discountText);
            }

            // Tính tổng cộng (trừ số tiền giảm giá)
            const total = Math.max(0, subtotal - Math.abs(discount));

            // Cập nhật giao diện
            $('#summary-subtotal').text(formatCurrency(subtotal));
            $('#summary-total').text(formatCurrency(total));

            // Cập nhật các input ẩn cho form checkout
            $('#subtotal').val(subtotal);
            $('#discount').val(Math.abs(discount));
            $('#total').val(total);

            console.log('Updated Summary:', {
                subtotal: subtotal,
                discount: discount,
                total: total
            });
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

            // Xử lý sự kiện mở modal mã khuyến mãi
            $('.btn-outline-primary').on('click', function() {
                $('#promotionsModal').modal('show');
                loadValidPromotions();
            });

            // Xử lý sự kiện đóng modal
            $('#closeModalBtn, #closeModalBtn2').on('click', function() {
                $('#promotionsModal').modal('hide');
            });
        });

        // Hàm tải danh sách mã khuyến mãi hợp lệ
        function loadValidPromotions() {
            $.ajax({
                url: '{{ route('cart.validPromotions') }}',
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        displayPromotions(response.promotions);
                    } else {
                        $('#promotions-list').html('<tr><td colspan="7" class="text-center">Không có mã khuyến mãi nào có thể áp dụng</td></tr>');
                    }
                },
                error: function() {
                    $('#promotions-list').html('<tr><td colspan="7" class="text-center">Có lỗi xảy ra khi tải danh sách mã khuyến mãi</td></tr>');
                }
            });
        }

        // Hàm hiển thị danh sách mã khuyến mãi
        function displayPromotions(promotions) {
            if (!promotions || promotions.length === 0) {
                $('#promotions-list').html('<tr><td colspan="7" class="text-center">Không có mã khuyến mãi nào có thể áp dụng</td></tr>');
                return;
            }

            let html = '';
            promotions.forEach(function(promotion) {
                // Định dạng loại khuyến mãi
                let typeText = '';
                let valueText = '';

                if (promotion.type === 'percentage') {
                    typeText = 'Phần trăm';
                    valueText = promotion.discount_value + '%';
                } else if (promotion.type === 'fixed_amount') {
                    typeText = 'Số tiền cố định';
                    valueText = formatCurrency(promotion.discount_value);
                } else if (promotion.type === 'free_shipping') {
                    typeText = 'Miễn phí vận chuyển';
                    valueText = 'Miễn phí';
                }

                // Định dạng điều kiện
                let conditionText = 'Không có điều kiện';
                if (promotion.min_order_value) {
                    // Đảm bảo giá trị min_order_value là số
                    const minOrderValue = parseFloat(promotion.min_order_value);
                    if (!isNaN(minOrderValue)) {
                        conditionText = 'Đơn hàng tối thiểu ' + formatCurrency(minOrderValue);
                    } else {
                        conditionText = 'Đơn hàng tối thiểu ' + promotion.min_order_value;
                    }
                }

                // Định dạng thời gian
                const startDate = new Date(promotion.start_date);
                const endDate = new Date(promotion.end_date);
                const dateRange = startDate.toLocaleDateString('vi-VN') + ' - ' + endDate.toLocaleDateString('vi-VN');

                // Hiển thị số lượng còn lại
                const quantityText = promotion.quantity > 0 ? promotion.quantity : '<i class="text-danger">Đã hết</i>';

                html += `
                    <tr>
                        <td><strong>${promotion.code}</strong></td>
                        <td>${typeText}</td>
                        <td>${valueText}</td>
                        <td>${conditionText}</td>
                        <td>${dateRange}</td>
                        <td>${quantityText}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-primary apply-promotion" data-code="${promotion.code}" ${promotion.quantity <= 0 ? 'disabled' : ''}>
                                Áp dụng
                            </button>
                        </td>
                    </tr>
                `;
            });

            $('#promotions-list').html(html);

            // Gắn sự kiện cho nút áp dụng
            $('.apply-promotion').on('click', function() {
                const code = $(this).data('code');
                $('input[name="coupon_code"]').val(code);
                $('#promotionsModal').modal('hide');
                // Tự động submit form áp dụng mã
                $('form[action="{{ route('cart.applyPromotion') }}"]').submit();
            });
        }

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
@section('scripts')
@include('alert')
@endsection
