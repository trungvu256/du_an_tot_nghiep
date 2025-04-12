@extends('admin.layouts.main')

@push('styles')
<style>
    .container-fluid {
        padding: 12px;
        background: #f3f4f6;
        min-height: 100vh;
    }

    .card {
        background: #fff;
        border-radius: 8px;
        border: none;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        margin-bottom: 12px;
    }

    .card-body {
        padding: 16px;
    }

    .card-title {
        font-size: 14px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 16px;
        text-transform: uppercase;
    }

    /* Table styles */
    .table {
        margin: 0;
    }

    .table th {
        background: #f9fafb;
        font-size: 13px;
        font-weight: 600;
        color: #4b5563;
        padding: 10px 12px;
        border-bottom: 1px solid #e5e7eb;
    }

    .table td {
        padding: 12px;
        vertical-align: middle;
        font-size: 13px;
        color: #1f2937;
        border-bottom: 1px solid #e5e7eb;
    }

    .table tfoot td {
        background: #f9fafb;
        font-size: 13px;
        padding: 10px 12px;
    }

    /* Product image */
    .product-image {
        width: 0.5px;
        height: 0.5px;
        object-fit: cover;
        border-radius: 4px;
    }

    /* Product info */
    .product-info h6 {
        font-size: 13px;
        font-weight: 500;
        margin-bottom: 4px;
        color: #1f2937;
    }

    .product-info .text-muted {
        font-size: 12px;
        color: #6b7280 !important;
    }

    /* Badge styles */
    .badge {
        padding: 4px 8px;
        font-size: 12px;
        font-weight: 500;
        border-radius: 4px;
    }

    /* Customer info */
    .customer-info {
        background: #f9fafb;
        border-radius: 6px;
        padding: 12px;
    }

    .customer-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
    }

    .customer-name {
        font-size: 13px;
        font-weight: 500;
        margin-bottom: 2px;
        color: #1f2937;
    }

    .customer-email {
        font-size: 12px;
        color: #6b7280;
    }

    .customer-details {
        font-size: 13px;
        color: #4b5563;
        margin-bottom: 6px;
    }

    .customer-details i {
        width: 16px;
        color: #6b7280;
    }

    /* Alert styles */
    .alert {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 6px;
        padding: 12px;
        margin-bottom: 0;
    }

    .alert-heading {
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 8px;
        color: #1f2937;
    }

    .alert p {
        font-size: 13px;
        color: #4b5563;
        margin-bottom: 12px;
    }

    /* Button styles */
    .btn {
        font-size: 13px;
        font-weight: 500;
        padding: 6px 12px;
        border-radius: 4px;
    }

    .btn i {
        font-size: 14px;
    }

    /* Grid spacing */
    .row {
        margin: 0 -6px;
    }

    .col-md-8, .col-md-4 {
        padding: 0 6px;
    }

    /* Header */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
    }

    .page-header h4 {
        font-size: 16px;
        font-weight: 600;
        color: #1f2937;
        margin: 0;
    }

    .btn-close {
        font-size: 14px;
        padding: 4px;
    }

    /* Order info header */
    .order-header {
        margin-bottom: 16px;
    }

    .order-code {
        font-size: 14px;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 4px;
    }

    .order-date {
        font-size: 12px;
        color: #6b7280;
    }

    /* Status badges container */
    .status-badges {
        text-align: right;
    }

    .status-badges > div {
        margin-bottom: 4px;
    }

    .status-badges > div:last-child {
        margin-bottom: 0;
    }

    /* Review styles */
    .bi-star-fill, .bi-star {
        font-size: 14px;
    }

    .text-warning {
        color: #fbbf24 !important;
    }

    .review-comment {
        font-size: 12px;
        color: #6b7280;
        margin-top: 4px;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold mb-0">Chi tiết đơn hàng</h4>
                <button type="button" class="btn-close" onclick="window.history.back()"></button>
            </div>

            <div class="row g-4">
                <!-- Thông tin đơn hàng -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div>
                                    <h5 class="card-title mb-2">Đơn hàng: {{ $order->order_code }}</h5>
                                    <p class="text-muted mb-0">Ngày tạo: {{ $order->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                                <div class="text-end">
                                    <div class="mb-2">
                                        <h2 class="card-title mb-2">TT thanh toán:
                                            @if($order->payment_status == 1)
                                            <span class="badge bg-success">Đã thanh toán (VNPay)</span>
                                        @else
                                            <span class="badge bg-primary"> Thanh toán khi nhận hàng</span>
                                        @endif </h2>

                                    </div>
                                    <div class="mb-2">
                                        <h2 class="card-title mb-2">Trạng thái đơn hàng:
                                        @switch($order->status)
                                            @case(0)
                                                <span class="badge bg-warning">⏳ Chờ xử lý</span>
                                                @break
                                            @case(1)
                                                <span class="badge bg-info">📦 Chờ lấy hàng</span>
                                                @break
                                            @case(2)
                                                <span class="badge bg-primary">🚚 Đang giao</span>
                                                @break
                                            @case(3)
                                                <span class="badge bg-success">✅ Đã giao</span>
                                                @break
                                            @case(4)
                                                <span class="badge bg-dark">🏁 Hoàn tất</span>
                                                @break
                                            @case(5)
                                                <span class="badge bg-danger">❌ Đã hủy</span>
                                                @break
                                            @case(6)
                                                <span class="badge bg-secondary">↩️ Trả hàng</span>
                                                @break
                                            @endswitch
                                        </h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Sản phẩm</th>
                                            <th class="text-center" style="width: 100px;">Số lượng</th>
                                            <th class="text-center" style="width: 150px;">Giá</th>
                                            <th class="text-center" style="width: 150px;">Thành tiền</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($order->orderItems as $item)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ asset('storage/' . ($item->product->image ?? 'default.jpg')) }}"
                                                         alt="{{ $item->product->name }}"
                                                         class="product-image me-3" style="width: 75px; height: 75px;">
                                                    <div>
                                                        <h6 class="mb-1">{{ $item->product->name }}</h6>
                                                        @if($item->productVariant)
                                                            <span class="text-muted">
                                                                Dung tích: {{ $item->productVariant->concentration }},
                                                                 Nồng độ: {{ $item->productVariant->size }}
                                                            </span>
                                                        @endif
                                                        @if($item->review)
                                                            <div class="mt-2">
                                                                <div class="d-flex align-items-center mb-1">
                                                                    @for($i = 1; $i <= 5; $i++)
                                                                        @if($i <= $item->review->rating)
                                                                            <i class="bi bi-star-fill text-warning"></i>
                                                                        @else
                                                                            <i class="bi bi-star text-warning"></i>
                                                                        @endif
                                                                    @endfor
                                                                    <span class="ms-2 text-muted">({{ $item->review->created_at->format('d/m/Y') }})</span>
                                                                </div>
                                                                @if($item->review->comment)
                                                                    <p class="mb-0 text-muted small">{{ $item->review->comment }}</p>
                                                                @endif
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center align-middle">{{ $item->quantity }}</td>
                                            <td class="text-center align-middle">{{ number_format($item->price, 0, ',', '.') }} VNĐ</td>
                                            <td class="text-center align-middle">{{ number_format($item->price * $item->quantity, 0, ',', '.') }} VNĐ</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </div>
                            </div>

                                    <tfoot class="table-light" style="margin-top: 20px;">
                                        <tr style="border-top: 16px solid transparent;">
                                            <td colspan="3" class="text-start fw-bold">Tổng tiền hàng:</td>
                                            <td class="text-end">{{ number_format($order->total_price, 0, ',', '.') }} VNĐ</td>
                                        </tr>

                                        <tr>
                                            <td colspan="3" class="text-start fw-bold">Phí vận chuyển:</td>
                                            <td class="text-end">{{ number_format($order->shipping_fee ?? 0, 0, ',', '.') }} VNĐ</td>
                                        </tr>

                                        <tr>
                                            <td colspan="3" class="text-start fw-bold">Giảm giá:</td>
                                            <td class="text-end">-{{ number_format($order->discount ?? 0, 0, ',', '.') }} VNĐ</td>
                                        </tr>

                                        <tr>
                                            <td colspan="3" class="text-start fw-bold">Tổng thanh toán:</td>
                                            <td class="text-end fw-bold fs-5 text-primary">
                                                {{ number_format($order->total_price + ($order->shipping_fee ?? 0) - ($order->discount ?? 0), 0, ',', '.') }} VNĐ
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Thông tin khách hàng và giao hàng -->
                <div class="col-md-4">
                    <!-- Thông tin khách hàng -->
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Thông tin khách hàng: </h5>
                            <div class="customer-info">

                                <div class="mb-2">

                                    <h6 class="mb-1"><i class="bi bi-person me-2"></i>Tên khách hàng: {{ $order->user->name }}</h6>
                                </div>
                                <div class="mb-2">

                                    <span class="text-muted"><i class="bi bi-envelope me-2"></i>Email: {{ $order->user->email }}</span>
                                </div>
                                <div class="mb-2">
                                    <i class="bi bi-telephone me-2"></i>
                                    SĐT: {{ $order->phone }}
                                </div>
                                <div>
                                    <i class="bi bi-geo-alt me-2"></i>
                                    Địa chỉ: {{ $order->address }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Trạng thái trả hàng -->
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Trạng thái trả hàng</h5>
                            @switch($order->return_status)
                                @case(0)
                                    <span class="badge bg-secondary">Không có yêu cầu</span>
                                    @break
                                @case(1)
                                    <div class="alert alert-warning">
                                        <h6 class="alert-heading">🔄 Đang yêu cầu trả hàng</h6>
                                        <p class="mb-3"><strong>Lý do:</strong> {{ $order->return_reason }}</p>
                                        <div class="d-flex gap-2">
                                            <button type="button" class="btn btn-success flex-grow-1" onclick="approveReturn({{ $order->id }})">
                                                <i class="bi bi-check-lg"></i> Duyệt
                                            </button>
                                            <button type="button" class="btn btn-danger flex-grow-1" onclick="declineReturn({{ $order->id }})">
                                                <i class="bi bi-x-lg"></i> Từ chối
                                            </button>
                                        </div>
                                    </div>
                                    @break
                                @case(2)
                                    <div class="alert alert-success">
                                        <h6 class="alert-heading">✅ Đã duyệt trả hàng</h6>
                                        <p class="mb-0">Chờ khách gửi trả sản phẩm</p>
                                    </div>
                                    @break
                                @case(3)
                                    <div class="alert alert-danger">
                                        <h6 class="alert-heading">❌ Đã từ chối trả hàng</h6>
                                        <p class="mb-0"><strong>Lý do:</strong> {{ $order->return_reason }}</p>
                                    </div>
                                    @break
                                @case(4)
                                    <div class="alert alert-info">
                                        <h6 class="alert-heading">🔄 Đã hoàn tất trả hàng</h6>
                                        <p class="mb-0">Đã cập nhật lại kho hàng</p>
                                    </div>
                                    @break
                            @endswitch
                        </div>
                    </div>

                    <!-- Đánh giá sản phẩm -->
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Đánh giá sản phẩm</h5>
                            @foreach($order->orderItems as $item)
                            <div class="review-item mb-3 pb-3 border-bottom">
                                {{-- <div class="d-flex align-items-center mb-2">
                                    <img src="{{ asset('storage/' . ($item->product->image ?? 'default.jpg')) }}"
                                         alt="{{ $item->product->name }}"
                                         class="product-image me-3" style="width: 40px; height: 40px;">
                                    <div>
                                        <h6 class="mb-1" style="font-size: 13px;">{{ $item->product->name }}</h6>
                                        @if($item->productVariant)
                                            <span class="text-muted" style="font-size: 12px;">
                                                {{ $item->productVariant->size }},
                                                {{ $item->productVariant->concentration }}
                                            </span>
                                        @endif
                                    </div>
                                </div> --}}
                                @if($item->review)
                                    <div class="ms-5 ps-2">
                                        <div class="d-flex align-items-center mb-1">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $item->review->rating)
                                                    <i class="bi bi-star-fill text-warning"></i>
                                                @else
                                                    <i class="bi bi-star text-warning"></i>
                                                @endif
                                            @endfor
                                            <span class="ms-2 text-muted" style="font-size: 12px;">
                                                ({{ $item->review->created_at->format('d/m/Y') }})
                                            </span>
                                        </div>
                                        @if($item->review->comment)
                                            <p class="mb-0 text-muted" style="font-size: 12px;">
                                                {{ $item->review->comment }}
                                            </p>
                                        @endif
                                    </div>
                                @else
                                    <div class="ms-5 ps-2">
                                        <span class="text-muted" style="font-size: 12px;">
                                            <i class="bi bi-chat-square-text me-1"></i>
                                            Chưa có đánh giá
                                        </span>
                                    </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function approveReturn(orderId) {
    if (confirm('Bạn có chắc chắn muốn duyệt yêu cầu trả hàng này?')) {
        fetch(`/admin/returns/${orderId}/update`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                return_status: 2
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Có lỗi xảy ra khi xử lý yêu cầu');
        });
    }
}

function declineReturn(orderId) {
    const reason = prompt('Nhập lý do từ chối trả hàng:');
    if (reason) {
        fetch(`/admin/returns/${orderId}/update`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                return_status: 3,
                return_reason: reason
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Có lỗi xảy ra khi xử lý yêu cầu');
        });
    }
}
</script>
@endpush
@endsection
