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
                                            @php
                                                // Chỉ hiển thị "Hoàn tiền" khi:
                                                // 1. Đơn hàng có trạng thái là "Trả hàng" (status = 6)
                                                // 2. Trạng thái thanh toán là "Đã thanh toán" (payment_status = 1)
                                                // 3. Hình thức thanh toán là COD (payment_method = 0)
                                                $displayPaymentStatus = ($order->status == 6 && $order->payment_status == 1 && $order->payment_method == 0) ? 3 : $order->payment_status;
                                            @endphp

                                            @if ($displayPaymentStatus == 1)
                                                <span class="badge bg-success">🟢 Đã thanh toán</span>
                                            @elseif ($displayPaymentStatus == 2)
                                                <span class="badge bg-info">🔵 Thanh toán khi nhận hàng</span>
                                            @elseif ($displayPaymentStatus == 3)
                                                <span class="badge bg-dark">⚪ Hoàn tiền</span>
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
                                            <td class="text-end">
                                                @php
                                                    $subtotal = 0;
                                                    foreach($order->orderItems as $item) {
                                                        $subtotal += $item->price * $item->quantity;
                                                    }
                                                @endphp
                                                {{ number_format($subtotal, 0, ',', '.') }} VNĐ
                                            </td>
                                        </tr>

                                        <tr>
                                            <td colspan="3" class="text-start fw-bold">Phí vận chuyển:</td>
                                            <td class="text-end">{{ number_format($order->shipping_fee ?? 0, 0, ',', '.') }} VNĐ</td>
                                        </tr>

                                        <tr>
                                            <td colspan="3" class="text-start fw-bold">Giảm giá:</td>
                                            <td class="text-end">
                                                @if($order->promotion_id)
                                                    @php
                                                        try {
                                                            // Lấy thông tin khuyến mãi với DB Query Builder
                                                            $promotion = DB::table('promotions')->where('id', $order->promotion_id)->first();

                                                            // Tính toán số tiền giảm giá dựa trên loại mã khuyến mãi
                                                            $discountAmount = 0;
                                                            if ($promotion) {
                                                                // Tính tổng tiền hàng
                                                                $subtotal = 0;
                                                                foreach($order->orderItems as $item) {
                                                                    $subtotal += $item->price * $item->quantity;
                                                                }

                                                                if ($promotion->type === 'percentage') {
                                                                    $discountAmount = ($subtotal * $promotion->discount_value) / 100;
                                                                    if ($promotion->max_value && $discountAmount > $promotion->max_value) {
                                                                        $discountAmount = $promotion->max_value;
                                                                    }
                                                                } elseif ($promotion->type === 'fixed_amount') {
                                                                    $discountAmount = $promotion->discount_value;
                                                                    if ($promotion->max_value && $discountAmount > $promotion->max_value) {
                                                                        $discountAmount = $promotion->max_value;
                                                                    }
                                                                }
                                                            }
                                                        } catch(\Exception $e) {
                                                            $promotion = null;
                                                            $discountAmount = 0;
                                                        }
                                                    @endphp

                                                    @if($promotion)
                                                        <span class="text-danger fw-bold">-{{ number_format($discountAmount, 0, ',', '.') }} VNĐ</span>
                                                    @else
                                                        <span class="text-danger">0 VNĐ</span>
                                                    @endif
                                                @else
                                                    0 VNĐ
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <td colspan="3" class="text-start fw-bold">Tổng thanh toán:</td>
                                            <td class="text-end fw-bold fs-5 text-primary">
                                                {{ number_format($order->total_price, 0, ',', '.') }} VNĐ
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
                                            <form action="{{ route('admin.returns.approve', $order->id) }}" method="POST" class="flex-grow-1"
                                                >
                                                @csrf

                                                <button type="submit" class="btn btn-success w-100">
                                                    <i class="bi bi-check-lg"></i> Duyệt
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.returns.decline', $order->id) }}" method="POST" class="flex-grow-1"
                                                >
                                                @csrf

                                                <button type="submit" class="btn btn-danger w-100">
                                                    <i class="bi bi-x-lg"></i> Từ chối
                                                </button>
                                            </form>
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
                            @forelse($order->orderItems as $item)
                                <div class="review-item mb-3 pb-3 border-bottom">
                                    {{-- <div class="d-flex align-items-center mb-2">
                                        <img src="{{ asset('storage/' . ($item->product->image ?? 'default.jpg')) }}"
                                             alt="{{ $item->product->name }}"
                                             class="product-image me-3" style="width: 40px; height: 40px;">
                                        <div>
                                            <h6 class="mb-1" style="font-size: 13px;">{{ $item->product->name }}</h6>
                                            @if($item->productVariant)
                                                <span class="text-muted" style="font-size: 12px;">
                                                    Nồng độ - {{ $item->productVariant->size ?? '' }},
                                                    Dung tích - {{ $item->productVariant->concentration ?? '' }}
                                                </span>
                                            @endif
                                        </div>
                                    </div> --}}

                                    <!-- Tìm đánh giá tương ứng với sản phẩm hoặc biến thể -->
                                    @php
                                        $matchingReview = $reviews->first(function ($review) use ($item) {
                                            return $review->product_id == $item->product_id &&
                                                   ($item->productVariant ? $review->variant_id == $item->productVariant->id : true);
                                        });
                                    @endphp

                                    @if($matchingReview)
                                        <div class="ms-5 ps-2">
                                            <div class="d-flex align-items-center mb-1">
                                                <h6>Tổng quan:
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $matchingReview->rating)
                                                        <i class="bi bi-star-fill text-warning"></i>
                                                    @else
                                                        <i class="bi bi-star text-warning"></i>
                                                    @endif
                                                @endfor
                                                <span class="ms-2 text-muted" style="font-size: 12px;">
                                                    ({{ \Carbon\Carbon::parse($matchingReview->created_at)->format('d/m/Y') }})
                                                </span>
                                                </h6>
                                            </div>
                                            <h6>Nội dung đánh giá: </h6>
                                            @if($matchingReview->review)
                                                <p class="mb-2 text-muted" style="font-size: 12px;">
                                                    " {{ $matchingReview->review }} "
                                                </p>
                                            @endif
                                            <!-- Hiển thị hình ảnh nếu có -->
                                            <h6>Hình ảnh đánh giá: </h6>
                                            @if(!empty($matchingReview->images))
                                                <div class="review-images d-flex flex-wrap gap-2 mt-2 mb-2">
                                                    @foreach(json_decode($matchingReview->images, true) as $image)
                                                        <a href="{{ $image }}" target="_blank" class="review-image-link">
                                                            <img src="{{ $image }}" alt="Review image" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                                                        </a>
                                                    @endforeach
                                                </div>
                                            @endif
                                            <!-- Hiển thị video nếu có -->

                                            @if($matchingReview->video)
                                                <div class="review-video mt-2 mb-2">
                                                    <video controls class="rounded" style="max-width: 100%; max-height: 200px;">
                                                        <source src="{{ $matchingReview->video }}" type="video/mp4">
                                                        Your browser does not support the video tag.
                                                    </video>
                                                </div>
                                            @endif
                                            <!-- Hiển thị thông tin người dùng -->
                                            <div class="review-user mt-2">
                                                <i><small class="text-muted" style="font-size: 12px;">
                                                    Đánh giá bởi: {{ $matchingReview->user->name }}
                                                </small></i>
                                            </div>
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
                            @empty
                                <div class="alert alert-light border text-center py-3">
                                    <p class="text-muted mb-0">Không có sản phẩm nào trong đơn hàng.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal duyệt trả hàng -->
<div class="modal fade" id="returnModal" tabindex="-1" aria-labelledby="returnModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="returnModalLabel">Cập nhật trạng thái trả hàng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.returns.update', $order->id) }}" method="POST" id="returnForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Trạng thái trả hàng</label>
                        <select name="return_status" class="form-select" id="returnStatus">
                            <option value="2" selected>✅ Duyệt</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary" id="submitBtn">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal từ chối trả hàng -->
<div class="modal fade" id="declineModal" tabindex="-1" aria-labelledby="declineModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="declineModalLabel">Cập nhật trạng thái trả hàng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.returns.update', $order->id) }}" method="POST" id="declineForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Trạng thái trả hàng</label>
                        <select name="return_status" class="form-select" id="declineStatus">
                            <option value="3" selected>❌ Từ chối</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Lý do từ chối <span class="text-danger">*</span></label>
                        <textarea name="return_reason" class="form-control" rows="3" placeholder="Nhập lý do từ chối trả hàng" required>{{ $order->return_reason }}</textarea>
                        <div class="invalid-feedback">Vui lòng nhập lý do từ chối</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary" id="declineSubmitBtn">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Kiểm tra xem SweetAlert2 đã được load chưa
    if (typeof Swal === 'undefined') {
        console.error('SweetAlert2 is not loaded');
        return;
    }

    // Hàm xử lý duyệt trả hàng
    function approveReturn(orderId) {
        Swal.fire({
            title: 'Xác nhận duyệt trả hàng?',
            text: 'Bạn có chắc chắn muốn duyệt yêu cầu trả hàng này?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Duyệt',
            cancelButtonText: 'Hủy',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                return fetch(`/admin/returns/${orderId}/approve`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .catch(error => {
                    Swal.showValidationMessage(`Request failed: ${error}`)
                })
            }
        }).then((result) => {
            if (result.isConfirmed) {
                if (result.value.success) {
                    Swal.fire({
                        title: 'Thành công!',
                        text: result.value.message,
                        icon: 'success'
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'Lỗi!',
                        text: result.value.message,
                        icon: 'error'
                    });
                }
            }
        });
    }

    // Hàm xử lý từ chối trả hàng
    function declineReturn(orderId) {
        Swal.fire({
            title: 'Từ chối trả hàng',
            input: 'textarea',
            inputLabel: 'Lý do từ chối',
            inputPlaceholder: 'Nhập lý do từ chối trả hàng...',
            showCancelButton: true,
            confirmButtonText: 'Từ chối',
            cancelButtonText: 'Hủy',
            showLoaderOnConfirm: true,
            inputValidator: (value) => {
                if (!value) {
                    return 'Vui lòng nhập lý do từ chối!';
                }
            },
            preConfirm: (reason) => {
                return fetch(`/admin/returns/${orderId}/decline`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        return_reason: reason
                    })
                })
                .then(response => response.json())
                .catch(error => {
                    Swal.showValidationMessage(`Request failed: ${error}`)
                })
            }
        }).then((result) => {
            if (result.isConfirmed) {
                if (result.value.success) {
                    Swal.fire({
                        title: 'Thành công!',
                        text: result.value.message,
                        icon: 'success'
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'Lỗi!',
                        text: result.value.message,
                        icon: 'error'
                    });
                }
            }
        });
    }

    // Thêm event listener cho nút duyệt
    const approveBtn = document.querySelector('.approve-return-btn');
    if (approveBtn) {
        approveBtn.addEventListener('click', function() {
            const orderId = this.getAttribute('data-order-id');
            approveReturn(orderId);
        });
    } else {
        console.warn('Approve button not found');
    }

    // Thêm event listener cho nút từ chối
    const declineBtn = document.querySelector('.decline-return-btn');
    if (declineBtn) {
        declineBtn.addEventListener('click', function() {
            const orderId = this.getAttribute('data-order-id');
            declineReturn(orderId);
        });
    } else {
        console.warn('Decline button not found');
    }
});
</script>
@endpush
@endsection
