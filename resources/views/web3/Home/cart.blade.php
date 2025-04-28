@extends('web3.layout.master2')

@section('content')
<style>
 
 .table-info, .table-info th {
    background-color:  #101828 !important;
    color: white !important;
}

    .custom-hover:hover {
    background-color: red !important;
    color: white !important;
    border: 2px solid black !important;
}
    .button-custom-hover:hover {
    background-color:  #101828 !important;
    color: white !important;
    border: 2px solid  #101828 !important;
    font-weight: 500 !important;
}
.flex-button {
    flex: 1 1 250px;
    max-width: 300px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.button-custom-hover:hover, .custom-hover:hover {
    background-color: black !important;
    color: white !important;
    border: 2px solid black !important;
}

@media (max-width: 576px) {
    .flex-button {
        flex: 1 1 100%;
        max-width: 100%;
    }
}
.flex-button {
    flex: 1 1 500px;
    max-width: 600px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.custom-hover:hover {
    background-color:  #101828 !important;
    color: white !important;
    border: 2px solid  #101828 !important;
}

@media (max-width: 576px) {
    .flex-button {
        flex: 1 1 100%;
        max-width: 100%;
    }
}

</style>
<div class="tf-breadcrumb">
            <div class="container">
                <ul class="breadcrumb-list">
                    <li class="item-breadcrumb">
                        <a href="/" class="text">Trang chủ</a>
                    </li>
                    <li class="item-breadcrumb dot">
                        <span></span>
                    </li>
                    <li class="item-breadcrumb">
                        <span class="text">Giỏ hàng</span>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /Breadcrumb -->



        <!-- Title Page -->

    <div class="container-fluid pt-5">
        
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                <form id="cart-items-form">
                    <table class="table table-bordered text-center mb-3">
                    <thead>
    <tr class="table-info">
        <th>Chọn</th>
        <th>Sản phẩm</th>
        <th>Giá</th>
        <th>Số lượng</th>
        <th>Tổng cộng</th>
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
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('storage/' . ($item['image'] ?? 'default.jpg')) }}" alt="" style="width: 100px; margin-right: 10px;">
                                            <div>
                                                <p class="mb-1"><strong>{{ Str::limit($item['name'], 20) }}</strong></p>
                                                @if (isset($item['variant']) && isset($item['variant']['attributes']) && count($item['variant']['attributes']) > 0)
                                                    @foreach ($item['variant']['attributes'] as $attrName => $attrValue)
                                                        <p class="mb-0">{{ $attrName }}: {{ $attrValue }}</p>
                                                    @endforeach
                                                @else
                                                    <p class="mb-0">Không có biến thể</p>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <td class="align-middle text-center price"
                                        data-price="{{ isset($item['price_sale']) && $item['price_sale'] > 0 ? $item['price_sale'] : $item['price'] }}"
                                        id="price-{{ $cartKey }}">
                                        @if (isset($item['price_sale']) && $item['price_sale'] > 0)
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
                                                style="width: 100px; height: 35px;" id="quantity-display-{{ $cartKey }}"
                                                value="{{ $item['quantity'] }}">
                                            <button type="button" class="btn btn-sm btn-outline-secondary btn-plus"
                                                data-cart-key="{{ $cartKey }}" data-action="increase">
                                                +
                                            </button>
                                        </div>
                                    </td>
                                    <td class="align-middle item-total" id="item-total-{{ $cartKey }}">
                                        @php
                                            $finalPrice =
                                                isset($item['price_sale']) && $item['price_sale'] > 0
                                                    ? $item['price_sale']
                                                    : $item['price'];
                                            $total = $finalPrice * (int) $item['quantity'];
                                        @endphp
                                        {{ number_format($total, 0, ',', '.') }}VNĐ
                                    </td>
                                    {{-- <td class="align-middle">
                                        @if (isset($item['variant']) && isset($item['variant']['attributes']) && count($item['variant']['attributes']) > 0)
                                            @foreach ($item['variant']['attributes'] as $attrName => $attrValue)
                                                <p><strong>{{ $attrName }}:</strong> {{ $attrValue }}</p>
                                            @endforeach
                                        @else
                                            <p>Không có biến thể</p>
                                        @endif
                                    </td> --}}
                                    <td class="align-middle">
                                    <button type="button" class="btn btn-sm btn-remove-item custom-hover" data-cart-key="{{ $cartKey }}" style="border: 2px solid black; background-color: white; color:  #101828;">
    x
</button>


                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                   

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
                
                {{-- @if (session('success'))
                    <p class="text-success">{{ session('success') }}</p>
                @endif
                @if (session('error'))
                    <p class="text-danger">{{ session('error') }}</p>
                @endif --}}

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

                <div class="card mb-3">
                    <div class="card-header" style="background-color:white;">
                    <h6 class="m-0 text-center" style="font-size: 1.25rem; font-weight: 500;">
    Tóm tắt giỏ hàng
</h6>
                    </div>
                    <div class="card-footer bg-transparent">
                        <div class="d-flex justify-content-between">
                        <h6 style="font-size: 1.25rem; font-weight: 400;">
    Tạm tính :
</h6>
                          
                            <h6 class="font-weight-medium" id="summary-subtotal">
                                {{ number_format($subtotal, 0, ',', '.') }}đ</h6>
                        </div>
                        <div id="discount-container">
                            @php
                                $promotion = session('promotion');
                                if ($promotion && isset($promotion['code']) && isset($promotion['discount'])) {
                                    echo '<div class="d-flex justify-content-between">';
                                    echo '<h6 class="text-success">Giảm giá (' . $promotion['code'] . ')</h6>';
                                    echo '<h6 class="font-weight-medium text-success" id="summary-discount">';
                                    echo '-' . number_format($promotion['discount'], 0, ',', '.') . '₫';
                                    echo '</h6>';
                                    echo '</div>';
                                }
                            @endphp
                        </div>
                    </div>
                    <div class="card-footer bg-transparent">
                        <div class="d-flex justify-content-between">
                        <h6 style="font-size: 1.25rem; font-weight: 400;">
    Tổng cộng :
</h6>
                            <h6 class="font-weight-bold" id="summary-total">0₫</h6>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent text-center">
                        <form id="checkout-form" action="{{ route('checkout.view') }}" method="POST">
                            @csrf
                            <input type="hidden" name="selected_cart_items" id="selected_cart_items">
                            <input type="hidden" name="subtotal" id="subtotal" value="0">
                            <input type="hidden" name="discount" id="discount" value="0">
                            <input type="hidden" name="total" id="total" value="0">

                            <div class="d-flex justify-content-center gap-2 flex-wrap">
    <button type="submit" class="btn btn-block btn-info my-1 py-2 button-custom-hover flex-button" style="border: 2px solid black; color: white; background-color:  #101828;">
        MUA NGAY
    </button>
    <a href="{{ route('web.shop') }}" class="btn btn-outline-success custom-hover flex-button" style="border: 2px solid black; color: black; text-decoration: none;">
        TIẾP TỤC MUA HÀNG
    </a>
</div>


                        </form>
                    </div>
                </div>
                <div class=" text-center">
                <div class="d-flex justify-content-center">
    <button type="button" class="btn btn-outline-success mb-2 custom-hover flex-button" style="border: 2px solid black; color: black;" id="viewPromotionsBtn">
        <i class="fa fa-tag"></i> Xem mã khuyến mãi có thể áp dụng
    </button>
</div>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal Mã Khuyến Mãi -->
    <div class="modal fade" id="promotionsModal" tabindex="-1" aria-labelledby="promotionsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="promotionsModalLabel">Mã Khuyến Mãi Có Thể Áp Dụng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Thiết lập CSRF token cho tất cả các request AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        // Hàm định dạng tiền tệ
        function formatCurrency(value) {
            if (typeof value !== 'number' || isNaN(value)) {
                value = 0;
            }
            return new Intl.NumberFormat('vi-VN', {
                style: 'decimal',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(value);
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

            // Kiểm tra nếu số lượng vượt quá tồn kho
            if (quantity > stockQuantity) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Số lượng không hợp lệ!',
                    text: `Số lượng tồn kho chỉ còn ${stockQuantity} sản phẩm. Số lượng đã được điều chỉnh về mức tối đa có thể.`,
                    confirmButtonText: 'Đã hiểu'
                });
                quantity = stockQuantity;
            }

            // Giới hạn số lượng: tối thiểu 1, tối đa là stock
            quantity = Math.max(1, Math.min(stockQuantity, parseInt(quantity) || 1));

            // Cập nhật giao diện ngay lập tức
            quantityInput.val(quantity);
            quantityDisplay.val(quantity);

            const priceElement = $('#price-' + cartKey);
            const price = parseFloat(priceElement.data('price')) || 0;
            const itemTotal = price * quantity;

            $('#item-total-' + cartKey).text(formatCurrency(itemTotal) + '₫');

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

                        // Cập nhật số lượng trong menu
                        if (response.cartCount !== undefined) {
                            // Cập nhật trực tiếp badge số lượng
                            $('.cart-count').text(response.cartCount);

                            // Sử dụng hàm toàn cục để cập nhật số lượng
                            if (typeof updateCartCount === 'function') {
                                updateCartCount(response.cartCount);
                            }

                            // Tạo sự kiện cập nhật giỏ hàng để menu có thể lắng nghe
                            $(document).trigger('cartUpdated', {
                                cartCount: response.cartCount
                            });
                        }
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi!',
                        text: 'Có lỗi xảy ra khi cập nhật giỏ hàng: ' + xhr.responseText,
                        confirmButtonText: 'Đóng'
                    });
                    quantityDisplay.val(quantityInput.val());
                    updateSummary();
                }
            });
        }

        // Hàm cập nhật tóm tắt giỏ hàng
        function updateSummary() {
            let subtotal = 0;
            let hasSelectedProducts = false;

            // Reset promotion session khi thay đổi checkbox
            if (!window.keepPromotion) {
                // Xóa phần hiển thị giảm giá nếu có
                const discountContainer = $('#summary-discount').parent();
                if (discountContainer.length) {
                    discountContainer.remove();
                }
            }

            $('.product-checkbox:checked').each(function() {
                hasSelectedProducts = true;
                const row = $(this).closest('tr');
                const priceElement = row.find('.price');
                const price = parseFloat(priceElement.data('price')) || 0;
                const quantity = parseInt(row.find('.quantity-display').val()) || 0;

                if (price > 0 && quantity > 0) {
                    subtotal += price * quantity;
                }
            });

            // Cập nhật tạm tính
            $('#summary-subtotal').text(formatCurrency(subtotal));

            if (!hasSelectedProducts) {
                // Nếu không có sản phẩm nào được chọn
                $('#summary-total').text('0₫');

                // Reset các input ẩn
                $('#subtotal').val(0);
                $('#discount').val(0);
                $('#total').val(0);
            } else {
                // Nếu có sản phẩm được chọn, chỉ hiển thị tổng tiền bằng với tạm tính
                $('#summary-total').text(formatCurrency(subtotal));

                // Cập nhật các input ẩn
                $('#subtotal').val(subtotal);
                $('#discount').val(0);
                $('#total').val(subtotal);
            }

            // Reset biến keepPromotion
            window.keepPromotion = false;
        }

        // Xử lý xóa sản phẩm
        $(document).on('click', '.btn-remove-item', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const cartKey = $(this).data('cart-key');
            const $row = $(this).closest('tr');

            Swal.fire({
                title: 'Xác nhận xóa?',
                text: "Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Có, xóa ngay!',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('cart.remove', ':cartKey') }}'.replace(':cartKey', cartKey),
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        beforeSend: function() {
                            // Disable nút xóa để tránh double-click
                            $('.btn-remove-item[data-cart-key="' + cartKey + '"]').prop(
                                'disabled', true);
                        },
                        success: function(response) {
                            if (response.success) {
                                $row.fadeOut(300, function() {
                                    $(this).remove();
                                    updateSummary();

                                    // Cập nhật số lượng trong badge
                                    if (response.cartCount !== undefined) {
                                        $('.cart-badge').text(response.cartCount);

                                        // Cập nhật badge trong header
                                        $('.cart-count').text(response.cartCount);

                                        // Sử dụng hàm toàn cục để cập nhật số lượng
                                        if (typeof updateCartCount === 'function') {
                                            updateCartCount(response.cartCount);
                                        }

                                        // Tạo sự kiện cập nhật giỏ hàng để menu có thể lắng nghe
                                        $(document).trigger('cartUpdated', {
                                            cartCount: response.cartCount
                                        });
                                    }

                                    // Hiển thị thông báo thành công
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Đã xóa!',
                                        text: 'Sản phẩm đã được xóa khỏi giỏ hàng.',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });

                                    // Kiểm tra nếu giỏ hàng trống
                                    if ($('.product-checkbox').length < 1) {
                                        setTimeout(function() {
                                            Swal.fire({
                                                icon: 'info',
                                                title: 'Giỏ hàng trống',
                                                text: 'Giỏ hàng của bạn hiện đang trống. Hãy tiếp tục mua sắm!',
                                                confirmButtonText: 'Tiếp tục mua sắm'
                                            }).then((result) => {
                                                if (result
                                                    .isConfirmed) {
                                                    window.location
                                                        .href =
                                                        '{{ route('web.shop') }}';
                                                }
                                            });
                                        }, 1500);
                                    }
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Lỗi!',
                                    text: response.message ||
                                        'Có lỗi xảy ra khi xóa sản phẩm'
                                });
                            }
                        },
                        error: function(xhr) {
                            console.error('Error:', xhr);
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi!',
                                text: 'Không thể xóa sản phẩm. Vui lòng thử lại sau.'
                            });
                        },
                        complete: function() {
                            // Enable lại nút xóa
                            $('.btn-remove-item[data-cart-key="' + cartKey + '"]').prop(
                                'disabled', false);
                        }
                    });
                }
            });
        });

        $(document).ready(function() {
            // Khởi tạo modal
            const promotionsModal = new bootstrap.Modal(document.getElementById('promotionsModal'));

            // Xử lý sự kiện mở modal mã khuyến mãi
            $('#viewPromotionsBtn').on('click', function() {
                const selectedProducts = $('.product-checkbox:checked').map(function() {
                    return $(this).val();
                }).get();

                if (selectedProducts.length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Chưa chọn sản phẩm!',
                        text: 'Vui lòng chọn sản phẩm muốn áp dụng mã giảm giá.',
                        confirmButtonText: 'Đã hiểu'
                    });
                    return;
                }

                // Lưu danh sách sản phẩm đã chọn vào data của modal
                $('#promotionsModal').data('selected-products', selectedProducts);

                // Mở modal và tải danh sách mã giảm giá
                promotionsModal.show();
                loadValidPromotions();
            });

            // Xử lý sự kiện đóng modal
            $('.btn-close, .btn-secondary').on('click', function() {
                promotionsModal.hide();
            });

            // Xử lý nút tăng/giảm
            $(document).on('click', '.btn-minus, .btn-plus', function(e) {
                e.preventDefault();
                const cartKey = $(this).data('cart-key');
                const action = $(this).data('action');
                const quantityDisplay = $('#quantity-display-' + cartKey);
                let quantity = parseInt(quantityDisplay.val()) || 1;

                if (action === 'increase') {
                    quantity += 1;
                } else if (action === 'decrease') {
                    quantity -= 1;
                }

                updateCartQuantity(cartKey, quantity);
            });

            // Xử lý khi nhập tay vào input
            $(document).on('input', '.quantity-display', function() {
                const cartKey = $(this).attr('id').replace('quantity-display-', '');
                const stockQuantity = parseInt($('#quantity-' + cartKey).data('stock-quantity')) || 0;
                let newQuantity = parseInt($(this).val().replace(/\D/g, '')) || 1;

                // Kiểm tra nếu số lượng vượt quá tồn kho
                if (newQuantity > stockQuantity) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Số lượng không hợp lệ!',
                        text: `Số lượng tồn kho chỉ còn ${stockQuantity} sản phẩm. Số lượng đã được điều chỉnh về mức tối đa có thể.`,
                        confirmButtonText: 'Đã hiểu'
                    });
                    newQuantity = stockQuantity;
                }

                $(this).val(newQuantity);
                updateCartQuantity(cartKey, newQuantity);
            });

            // Gắn sự kiện checkbox
            $('.product-checkbox').on('change', function() {
                updateSummary();

                // Nếu không còn sản phẩm nào được chọn và đang có mã giảm giá
                if ($('.product-checkbox:checked').length === 0 && $('#summary-discount').length > 0) {
                    // Xóa thông tin giảm giá
                    $('#summary-discount').parent().remove();
                    updateSummary();
                }
            });

            // Khởi tạo biến global để kiểm soát việc giữ lại promotion
            window.keepPromotion = false;

            // Kiểm tra ban đầu xem có sản phẩm nào được chọn không
            const hasSelectedProducts = $('.product-checkbox:checked').length > 0;
            if (!hasSelectedProducts) {
                // Reset tất cả các giá trị về 0
                $('#summary-subtotal').text('0₫');
                // Nếu không có sản phẩm nào được chọn, ẩn phần giảm giá
                const discountContainer = $('#summary-discount').parent();
                discountContainer.hide();
                $('#summary-total').text('0₫');
            }

            // Gọi updateSummary để cập nhật hiển thị ban đầu
            updateSummary();
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
                        $('#promotions-list').html(
                            '<tr><td colspan="7" class="text-center">Không có mã khuyến mãi nào có thể áp dụng</td></tr>'
                            );
                    }
                },
                error: function() {
                    $('#promotions-list').html(
                        '<tr><td colspan="7" class="text-center">Có lỗi xảy ra khi tải danh sách mã khuyến mãi</td></tr>'
                        );
                }
            });
        }

        // Hàm hiển thị danh sách mã khuyến mãi
        function displayPromotions(promotions) {
            if (!promotions || promotions.length === 0) {
                $('#promotions-list').html(
                    '<tr><td colspan="7" class="text-center">Không có mã khuyến mãi nào có thể áp dụng</td></tr>');
                return;
            }

            let html = '';
            promotions.forEach(function(promotion) {
                // Debug log
                console.log('Promotion data:', {
                    code: promotion.code,
                    type: promotion.type,
                    discount_value: promotion.discount_value,
                    parsed_value: Number(promotion.discount_value)
                });

                // Định dạng loại khuyến mãi
                let typeText = '';
                let valueText = '';

                if (promotion.type === 'percentage') {
                    typeText = 'Phần trăm';
                    valueText = promotion.discount_value + '%';
                } else if (promotion.type === 'fixed_amount') {
                    typeText = 'Số tiền cố định';
                    const discountValue = parseFloat(promotion.discount_value);
                    console.log('Parsed discount value:', discountValue);
                    valueText = discountValue ? formatCurrency(discountValue) + ' VNĐ' : '0 VNĐ';
                }

                // Định dạng điều kiện
                let conditionText = 'Không có điều kiện';
                if (promotion.min_order_value) {
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
                const dateRange = startDate.toLocaleDateString('vi-VN') + ' - ' + endDate.toLocaleDateString(
                    'vi-VN');

                // Hiển thị số lượng còn lại
                const quantityText = promotion.quantity > 0 ? promotion.quantity :
                    '<i class="text-danger">Đã hết</i>';

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
                const button = $(this);
                const selectedProducts = $('#promotionsModal').data('selected-products');

                // Disable nút trong khi xử lý
                button.prop('disabled', true);
                button.html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Đang xử lý...'
                    );

                // Gọi AJAX để áp dụng mã khuyến mãi
                $.ajax({
                    url: '{{ route('cart.applyPromotion') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        coupon_code: code,
                        selected_products: selectedProducts
                    },
                    success: function(response) {
                        if (response.success) {
                            // Cập nhật giao diện
                            updateDisplay(response);

                            // Đóng modal
                            $('#promotionsModal').modal('hide');

                            // Hiển thị thông báo thành công
                            Swal.fire({
                                icon: 'success',
                                title: 'Thành công!',
                                text: response.message,
                                showConfirmButton: false,
                                timer: 1500
                            });

                            // Đánh dấu các sản phẩm đã chọn
                            $('.product-checkbox').each(function() {
                                const checkbox = $(this);
                                if (response.selected_products.includes(checkbox.val())) {
                                    checkbox.prop('checked', true);
                                }
                            });
                        } else {
                            // Hiển thị thông báo lỗi
                            Swal.fire({
                                icon: 'error',
                                title: 'Không thể áp dụng!',
                                text: response.message
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi!',
                            text: 'Có lỗi xảy ra khi áp dụng mã giảm giá. Vui lòng thử lại.'
                        });
                    },
                    complete: function() {
                        // Restore nút về trạng thái ban đầu
                        button.prop('disabled', false);
                        button.html('Áp dụng');
                    }
                });
            });
        }

        // Hàm cập nhật hiển thị tổng tiền và giảm giá
        function updateDisplay(data) {
            // Cập nhật tạm tính
            $('#summary-subtotal').text(formatCurrency(data.subtotal));

            // Cập nhật phần giảm giá
            const discountContainer = $('#discount-container');
            if (data.discount && parseFloat(data.discount) > 0) {
                const discountHtml = `
                    <div class="d-flex justify-content-between">
                        <h6 class="text-success">Giảm giá (${data.code})</h6>
                        <h6 class="font-weight-medium text-success" id="summary-discount">
                            -${formatCurrency(parseFloat(data.discount))}
                        </h6>
                    </div>`;
                discountContainer.html(discountHtml);
            } else {
                discountContainer.empty();
            }

            // Cập nhật tổng cộng
            $('#summary-total').text(formatCurrency(data.final_total));

            // Cập nhật các input ẩn
            $('#subtotal').val(data.subtotal || 0);
            $('#discount').val(data.discount || 0);
            $('#total').val(data.final_total || 0);

            // Log để debug
            console.log('Discount data:', {
                discount: data.discount,
                code: data.code,
                finalTotal: data.final_total,
                subtotal: data.subtotal
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
