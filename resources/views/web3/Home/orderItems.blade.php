@extends('web3.layout.master2')
@section('content')
    <!-- Thêm SweetAlert2 CSS và JS -->
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4/bootstrap-4.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}

    <div class="container">
        <div class="d-flex align-items-center justify-content-between">
            <a href="{{ route('donhang.index') }}" class="btn btn-outline-primary"><i class="bi bi-caret-left"></i> Quay lại</a>
            <h4 class="my-4 text-center text-primary flex-grow-1 text-center">Chi tiết đơn hàng #{{ $order->order_code }}</h4>
        </div>

        <hr class="my-3">

        <!-- Thông tin khách hàng -->
        <h4 class="my-3 text-secondary">Thông tin khách hàng</h4>
        <table class="table table-striped table-bordered">
            <tr>
                <th>Họ tên người nhận</th>
                <td>{{ $order->name }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $order->email }}</td>
            </tr>
            <tr>
                <th>Số điện thoại</th>
                <td>{{ $order->phone }}</td>
            </tr>
            <tr>
                <th>Địa chỉ</th>
                <td>{{ $order->address }}</td>
            </tr>
            <tr>
                <th>Tổng tiền</th>
                <td class="fw-bold text-success">
                    {{ number_format($order->total_price, 0, ',', '.') }} VNĐ
                </td>
            </tr>
            <tr>
                <th>Trạng thái đơn hàng</th>
                <td>
                    @switch($order->status)
                        @case(0) <span class="badge bg-warning">⏳ Chờ xác nhận</span> @break
                        @case(1) <span class="badge bg-info">📦 Chờ lấy hàng</span> @break
                        @case(2) <span class="badge bg-secondary">🚚 chờ giao hàng</span> @break
                        @case(3) <span class="badge bg-success">✅ đã giao</span> @break
                        @case(4) <span class="badge bg-dark">🏁 Hoàn tất</span> @break
                        @case(5) <span class="badge bg-danger">❌ Đã hủy</span> @break
                        @case(6) <span class="badge bg-secondary">↩️ Trả hàng</span> @break
                    @endswitch
                </td>
            </tr>
            <tr>
                <th>Trạng thái thanh toán</th>
                <td>
                    @switch($order->payment_status)
                        @case(1) <span class="badge bg-success">Đã thanh toán</span> @break
                        @case(2) <span class="badge bg-info">Thanh toán khi nhận hàng</span> @break
                        @case(3) <span class="badge bg-dark">Hoàn tiền</span> @break
                    @endswitch
                </td>
            </tr>
            <tr>
                <th>Trạng thái trả hàng</th>
                <td>
                    @switch($order->return_status)
                        @case(0)
                            <span class="badge bg-secondary">Không có yêu cầu trả hàng</span>
                            @if($order->status == 3 || $order->status == 4)
                                {{-- Chỉ hiển thị nút trả hàng nếu không phải thanh toán VNPay --}}
                                @if(!($order->payment_status == 1 && $order->payment_method == 1))
                                    <div class="mt-2">
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#returnModal">
                                            Yêu cầu trả hàng
                                        </button>
                                    </div>
                                @endif
                            @endif
                        @break
                        @case(1)
                            <span class="badge bg-warning">Đang yêu cầu trả hàng</span>
                            @if($order->return_reason)
                                <br>
                                <small class="text-muted">Lý do: {{ $order->return_reason }}</small>
                            @endif
                        @break
                        @case(2)
                            <span class="badge bg-success">Đã duyệt trả hàng</span>
                            @if($order->return_reason)
                                <br>
                                <small class="text-muted">Lý do: {{ $order->return_reason }}</small>
                            @endif
                        @break
                        @case(3)
                            <span class="badge bg-danger">Đã từ chối trả hàng</span>
                            @if($order->return_reason)
                                <br>
                                <small class="text-muted">Lý do: {{ $order->return_reason }}</small>
                            @endif
                        @break
                        @case(4)
                            <span class="badge bg-info">Đã hoàn tất trả hàng</span>
                            @if($order->return_reason)
                                <br>
                                <small class="text-muted">Lý do: {{ $order->return_reason }}</small>
                            @endif
                        @break
                    @endswitch
                </td>
            </tr>
        </table>

        <!-- Modal yêu cầu trả hàng -->
        <div class="modal fade" id="returnModal" tabindex="-1" aria-labelledby="returnModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="returnModalLabel">Yêu cầu trả hàng</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('order.requestReturn', $order->id) }}" method="POST" id="returnForm">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="return_reason" class="form-label">Lý do trả hàng</label>
                                <select class="form-select" id="return_reason" name="return_reason" required>
                                    <option value="">-- Chọn lý do --</option>
                                    <option value="Sản phẩm không đúng mô tả">Sản phẩm không đúng mô tả</option>
                                    <option value="Sản phẩm bị hỏng">Sản phẩm bị hỏng</option>
                                    <option value="Sản phẩm không phù hợp">Sản phẩm không phù hợp</option>
                                    <option value="Lý do khác">Lý do khác</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-primary">Gửi yêu cầu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sản phẩm trong đơn -->
        <h4 class="my-3 text-secondary">Sản phẩm trong đơn</h4>
        <table class="table table-striped table-bordered">
            <thead>
                <tr class="table-primary">
                    <th>Ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Giá</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalOrderPrice = 0;
                @endphp
                @if ($order->orderItems && count($order->orderItems) > 0)
                    @foreach ($order->orderItems as $detail)
                        @php
                            // Lấy giá của biến thể, nếu có
                            $variantPrice = $detail->variant ? $detail->variant->price : $detail->price;
                            $itemTotal = $variantPrice * $detail->quantity;
                            $totalOrderPrice += $itemTotal;
                        @endphp
                        <tr>
                            <td>
                                @if ($detail->product && $detail->product->image)
                                    <img src="{{ asset('storage/' . $detail->product->image) }}" width="50" alt="{{ $detail->product->name }}">
                                @else
                                    <span class="text-danger">Không có ảnh</span>
                                @endif
                            </td>
                            <td>{{ $detail->product->name }}
                                @if($detail->productVariant)
                                    @php
                                        $attributes = $detail->productVariant->product_variant_attributes ?? [];
                                    @endphp
                                    @if(count($attributes) > 0)
                                        @foreach($attributes as $attribute)
                                            <p class="text-muted mb-0">
                                                <strong>{{ $attribute->attribute->name }}:</strong> 
                                                {{ $attribute->attributeValue->value }}
                                            </p>
                                        @endforeach
                                    @else
                                        <p class="text-muted mb-0">Không có biến thể</p>
                                    @endif
                                @endif
                            </td>
                            <td>{{ $detail->quantity }}</td>
                            <td>
                                {{-- Hiển thị giá giống giỏ hàng --}}
                                {{ number_format($itemTotal, 0, ',', '.') }} VNĐ
                                <br>
                                <small>({{ number_format($variantPrice, 0, ',', '.') }} x {{ $detail->quantity }})</small>
                            </td>
                        </tr>
                    @endforeach
                    {{-- Hiển thị tổng giá đơn hàng --}}
                    <tr>
                        <td colspan="3" class="text-end fw-bold">Tổng cộng:</td>
                        <td class="fw-bold text-danger">{{ number_format($totalOrderPrice, 0, ',', '.') }} VNĐ</td>
                    </tr>
                @else
                    <tr>
                        <td colspan="4" class="text-center text-muted">Không có sản phẩm nào trong đơn hàng</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <!-- Thông tin vận chuyển -->
        {{-- <h4 class="my-3 text-secondary">Thông tin vận chuyển</h4>
        <table class="table table-striped table-bordered">
            <tr>
                <th>Đơn vị vận chuyển</th>
                <td>{{ $order->shipping_provider ?? 'Chưa có' }}</td>
            </tr>
            <tr>
                <th>Mã vận đơn</th>
                <td>{{ $order->tracking_number ?? 'Chưa có' }}</td>
            </tr>
        </table> --}}
    </div>


@endsection
@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const returnForm = document.getElementById('returnForm');
        const returnModal = document.getElementById('returnModal');
        const bsModal = new bootstrap.Modal(returnModal);

        returnForm.addEventListener('submit', function(e) {
            e.preventDefault();

            if (!document.getElementById('return_reason').value) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Thông báo',
                    text: 'Vui lòng chọn lý do trả hàng',
                    confirmButtonText: 'Đóng',
                    confirmButtonColor: '#3085d6'
                });
                return;
            }

            // Hiển thị loading khi đang gửi request
            Swal.fire({
                title: 'Đang xử lý...',
                text: 'Vui lòng chờ trong giây lát',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            fetch(returnForm.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: new URLSearchParams(new FormData(returnForm))
            })
            .then(response => response.json())
            .then(data => {
                // Đóng modal trước khi hiển thị thông báo
                bsModal.hide();

                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công!',
                        text: 'Yêu cầu trả hàng đã được gửi thành công',
                        showConfirmButton: true,
                        confirmButtonText: 'Đóng',
                        confirmButtonColor: '#28a745'
                    }).then((result) => {
                        // Reload trang sau khi đóng thông báo
                        location.reload();
                    });
                } else {
                    throw new Error(data.message || 'Có lỗi xảy ra');
                }
            })
            .catch(error => {
                let errorMessage = 'Có lỗi xảy ra. Vui lòng thử lại sau.';
                if (error.response && error.response.json) {
                    error.response.json().then(data => {
                        if (data.error) {
                            errorMessage = data.error;
                        }
                    });
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi!',
                    text: errorMessage,
                    showConfirmButton: true,
                    confirmButtonText: 'Đóng',
                    confirmButtonColor: '#dc3545'
                });
            });
        });
    });
</script>
@include('alert')
@endsection

