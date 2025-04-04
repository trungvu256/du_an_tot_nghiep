@extends('web2.layout.master')

@section('content')
    <!-- Navbar End -->

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
                                <td class="align-middle text-center price" data-price="{{ $item['price'] }}" id="price-{{ $cartKey }}">
                                    {{ number_format($item['price'], 0, ',', '.') }}₫
                                </td>
                                <td class="align-middle">
                                    <div class="update-cart-form d-flex align-items-center justify-content-center gap-1">
                                        <input type="hidden" name="quantity" id="quantity-{{ $cartKey }}"
                                            value="{{ $item['quantity'] }}">
                                        <button type="button" class="btn btn-sm btn-outline-secondary btn-minus"
                                            data-cart-key="{{ $cartKey }}" data-action="decrease">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <input type="text" class="form-control form-control-sm text-center bg-light quantity-display"
                                            style="width: 50px;" id="quantity-display-{{ $cartKey }}"
                                            value="{{ $item['quantity'] }}" readonly>
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
                                            data-id="{{ $item['id'] }}">
                                            <i class="fa fa-times"></i>
                                        </button>


                                        <script>
                                            $(document).on('click', '.btn-remove-item', function(e) {
                                                e.preventDefault();
                                                let id = $(this).data('id'); // Lấy ID của sản phẩm

                                                $.ajax({
                                                    url: '{{ route('cart.remove', ':id') }}'.replace(':id',
                                                    id), // Thay thế :id với ID sản phẩm
                                                    type: 'POST',
                                                    data: {
                                                        _token: '{{ csrf_token() }}', // Gửi token bảo mật
                                                    },
                                                    success: function(res) {
                                                        if (res.success) {
                                                            // Nếu xóa thành công, xóa sản phẩm khỏi DOM
                                                            $('#cart-item-' + id).remove(); // Giả sử mỗi sản phẩm có ID cart-item-{id}

                                                            // Cập nhật lại tổng tiền giỏ hàng và số lượng sản phẩm
                                                            $('#summary-subtotal').text(formatCurrency(res
                                                            .totalAmount)); // Cập nhật tổng tiền
                                                            $('#summary-total').text(formatCurrency(res.totalAmount +
                                                            10000)); // Cập nhật tổng tiền + phí vận chuyển (giả sử là 10000)
                                                            $('.cart-badge').text(res
                                                            .cartCount); // Cập nhật số lượng sản phẩm trong giỏ hàng

                                                            // Hiển thị thông báo thành công
                                                        }
                                                    },
                                                    error: function(err) {
                                                        alert("Xóa thất bại!"); // Thông báo lỗi khi AJAX gặp sự cố
                                                    }
                                                });
                                            });

                                            // Hàm format tiền (nếu bạn muốn hiển thị tiền theo định dạng)
                                            function formatCurrency(value) {
                                                return value.toLocaleString('vi-VN') + '₫';
                                            }
                                        </script>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <a href="{{ route('web.shop')}}" class="btn btn-success">Thêm sản phẩm</a>
                </form>
            </div>

            <div class="col-lg-4">
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Tóm tắt giỏ hàng</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3 pt-1">
                            <h6 class="font-weight-medium">Tạm tính</h6>
                            <h6 class="font-weight-medium" id="summary-subtotal">0₫</h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Phí vận chuyển</h6>
                            <h6 class="font-weight-medium" id="summary-shipping">10.000₫</h6>
                        </div>
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
                            <input type="hidden" name="shipping_fee" id="shipping_fee">
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

    <script>
function getCurrencyNumber(value) {
    return parseInt(value.replace(/\D/g, ''));
}

document.getElementById("checkout-form").addEventListener("submit", function (e) {
    // Ngăn gửi form ngay
    e.preventDefault();

    // 1. Lấy các cartKey đã chọn
    const selected = Array.from(document.querySelectorAll(".product-checkbox:checked"))
                        .map(cb => cb.value);

    if (selected.length === 0) {
        alert("Vui lòng chọn ít nhất 1 sản phẩm để thanh toán.");
        return;
    }

    // 2. Gán vào input ẩn
    document.getElementById("selected_cart_items").value = JSON.stringify(selected);

    // 3. Lấy và gán các phần tóm tắt đơn hàng
    const subtotal = getCurrencyNumber(document.getElementById("summary-subtotal").innerText);
    const discount = getCurrencyNumber(document.getElementById("summary-discount")?.innerText || "0");
    const shipping = getCurrencyNumber(document.getElementById("summary-shipping").innerText);
    const total = getCurrencyNumber(document.getElementById("summary-total").innerText);

    document.getElementById("subtotal").value = subtotal;
    document.getElementById("discount").value = discount;
    document.getElementById("shipping_fee").value = shipping;
    document.getElementById("total").value = total;

    // Gửi form
    this.submit();
});
</script>


   <!-- HTML giữ nguyên, chỉ chỉnh sửa phần script -->
   <script>
    $(document).ready(function() {
        // Hàm định dạng tiền tệ
        function formatCurrency(value) {
            return value.toLocaleString('vi-VN') + '₫';
        }
    
        // Xử lý sự kiện tăng/giảm số lượng
        $(document).on('click', '.btn-minus, .btn-plus', function(e) {
            e.preventDefault();
    
            const cartKey = $(this).data('cart-key'); // Lấy từ data-cart-key
            const action = $(this).data('action');
            const quantityInput = $('#quantity-' + cartKey);
            const quantityDisplay = $('#quantity-display-' + cartKey);
            let quantity = parseInt(quantityInput.val());
    
            if (action === 'increase') {
                quantity++;
            } else if (action === 'decrease' && quantity > 1) {
                quantity--;
            }
    
            // Gửi AJAX để cập nhật và lưu trên server
            $.ajax({
                url: '{{ route('cart.update', ':id') }}'.replace(':id', cartKey),
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    quantity: quantity
                },
                success: function(response) {
                    if (response.success) {
                        quantityInput.val(quantity);
                        quantityDisplay.val(quantity);
    
                        const price = parseInt($('#price-' + cartKey).data('price'));
                        const itemTotal = price * quantity;
                        $('#item-total-' + cartKey).text(formatCurrency(itemTotal));
    
                        updateSummary();
                    } else {
                        alert('Cập nhật giỏ hàng thất bại!');
                    }
                },
                error: function() {
                    alert('Có lỗi xảy ra khi cập nhật giỏ hàng.');
                }
            });
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
    
            const shippingFee = 10000;
            $('#summary-subtotal').text(formatCurrency(subtotal));
            $('#summary-total').text(formatCurrency(subtotal + shippingFee));
        }
    
        $('.product-checkbox').on('change', updateSummary);
        updateSummary(); // Gọi khi trang tải
    });
    </script>
    <style>
      [id^="price-"] {
    margin-top: 1.5pc;             /* Thêm khoảng cách bên trong */
}
    </style>
@endsection
