@extends('admin.layouts.main')
@section('title', 'Chi tiết đánh giá sản phẩm')
@section('content')
<div class="container mt-4">
    <div class="card shadow-lg border-0 w-100" style="max-width: 900px; margin: 0 auto;">
        <div class="card-header bg-primary text-white d-flex align-items-center">
            <i class="bi bi-star-fill mr-2" style="font-size: 1.5rem;"></i>
            <h4 class="mb-0">Chi tiết đánh giá sản phẩm</h4>
        </div>
        <div class="card-body p-4">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <h5 class="text-secondary mb-1">Tên khách hàng: </h5>
                        <p class="font-weight-bold mb-2">{{ $review->user->name ?? 'N/A' }}</p>
                    </div>
                    <div class="mb-3">
                        <h5 class="text-secondary mb-1">Mã đơn hàng: </h5>
                        <p class="mb-2">{{ $review->order->order_code ?? 'N/A' }}</p>
                    </div>
                    <div class="mb-3">
                        <h5 class="text-secondary mb-1">Số sao đánh giá: </h5>
                        <div class="mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $review->rating)
                                    <i class="bi bi-star-fill text-warning" style="font-size: 1.3rem;"></i>
                                @else
                                    <i class="bi bi-star text-muted" style="font-size: 1.3rem;"></i>
                                @endif
                            @endfor
                        </div>
                    </div>
                    <div class="mb-3">
                        <h5 class="text-secondary mb-1">Ảnh đánh giá: </h5>
                        <div class="d-flex flex-wrap align-items-center">
                            @php
                                $images = is_array($review->images) ? $review->images : json_decode($review->images, true);
                            @endphp
                            @if($images && count($images) > 0)
                                @foreach($images as $img)
                                    <img src="{{ asset(ltrim($img, '/')) }}" alt="Ảnh đánh giá" class="rounded shadow-sm mr-2 mb-2" style="width: 100px; height: 100px; object-fit: cover;">
                                @endforeach
                            @else
                                <span class="text-muted">Không có ảnh</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <h5 class="text-secondary mb-1">Sản phẩm: </h5>
                        <p class="font-weight-bold mb-2">{{ $review->product->name ?? 'N/A' }}</p>
                    </div>
                    <div class="mb-3">
                        <h5 class="text-secondary mb-1">Phân loại sản phẩm: </h5>
                        @if($review->variant && $review->variant->product_variant_attributes)
                            <ul class="mb-2 pl-3">
                                @foreach($review->variant->product_variant_attributes as $attr)
                                    <li>{{ $attr->attribute->name }}: <strong>{{ $attr->attributeValue->value }}</strong></li>
                                @endforeach
                            </ul>
                        @else
                            <p class="mb-2">Không có biến thể</p>
                        @endif
                    </div>
                    <div class="mb-3">
                        <h5 class="text-secondary mb-1">Nội dung đánh giá: </h5>
                        <p class="mb-2">{{ $review->review }}</p>
                    </div>
                    <div class="mb-3">
                        <h5 class="text-secondary mb-1">Video đánh giá: </h5>
                        @if($review->video)
                            <video src="{{ asset('/storage/review_video' . $review->video) }}" controls style="max-width: 320px; max-height: 180px;"></video>
                        @else
                            <span class="text-muted">Không có video</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-6">
                    <h5 class="text-secondary mb-1">Ngày tạo: </h5>
                    <p>{{ $review->created_at }}</p>
                </div>
                <div class="col-md-6">
                    <h5 class="text-secondary mb-1">Ngày cập nhật: </h5>
                    <p>{{ $review->updated_at }}</p>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('product-reviews.index') }}" class="btn btn-secondary">Quay lại danh sách</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endpush
