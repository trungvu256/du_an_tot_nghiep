@extends('admin.layouts.main')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <!-- Hiển thị hình ảnh sản phẩm -->
            <div class="col-lg-5">
                <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach ($description_images as $index => $image)
                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                            <img src="{{ asset('storage/' . $image->image) }}" class="img-fluid rounded d-block w-100" alt="Product Image">
                        </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>
            </div>

            <!-- Hiển thị thông tin sản phẩm -->
            <div class="col-lg-7">
                <h4 class="mb-3">{{ $product->name }}</h4>
                <p><strong>Thể loại:</strong> {{ $product->catalogue->name }}</p>
                <p><strong>Ngày đăng:</strong> {{ $product->created_at->format('d-m-Y') }}</p>
                {{-- <h5 class="text-danger">Giá: {{ number_format($product->price, 0, ',', '.') }} VNĐ</h5> --}}

                <div class="row mt-4">
                    @foreach($product->variants as $variant)
                        <div class="col-md-4">
                            <div class="card border shadow-sm">
                                <div class="card-body">
                                    <p><strong>SKU:</strong> {{ $variant->sku }}</p>
                                    <p><strong>Giá bán:</strong> 
                                        <span class="text-success">{{ number_format($variant->price_sale ?? $variant->price, 0, ',', '.') }} VNĐ</span>
                                    </p>
                                    <p><strong>Số lượng kho:</strong> {{ $variant->stock_quantity }}</p>
                
                                    <!-- Hiển thị danh sách thuộc tính của biến thể -->
                                    <p><strong>Thuộc tính:</strong></p>
                                    @if ($variant->attributes && count($variant->attributes) > 0)
                                        <ul>
                                            @foreach ($variant->attributes as $attr)
                                                <li>
                                                    <strong>{{ $attr->attribute->name ?? 'Không xác định' }}:</strong> 
                                                    {{ $attr->attributeValue->value ?? 'Không có giá trị' }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p class="text-muted">Không có thuộc tính.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Hiển thị mô tả sản phẩm -->
                <div class="mt-4">
                    <h5>Mô tả sản phẩm:</h5>
                    <p>{!! $product->description !!}</p>
                </div>
            </div>
        </div>

        <hr>
        <h5 class="mt-4">Thông số sản phẩm</h5>
        <table class="table table-bordered">
            <tbody>
                <tr><th>Giới tính</th><td>{{ $product->gender }}</td></tr>
                <tr><th>Thương hiệu</th><td>{{ $product->brand->name ?? 'Không có thương hiệu' }}</td></tr>
                <tr><th>Xuất xứ</th><td>{{ $product->origin }}</td></tr>
                <tr><th>Nhóm hương</th><td>{{ $product->fragrance_group }}</td></tr>
            </tbody>
        </table>

        <hr>
        <h5 class="mt-4">Đánh giá & Bình luận</h5>
        <div class="list-group">
            @forelse($product->comments as $comment)
                <div class="list-group-item">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6>{{ $comment->user->name ?? 'Ẩn danh' }} - <small>{{ optional($comment->created_at)->format('d M, Y') }}</small></h6>
                        <span class="badge bg-success"><i class="mdi mdi-star"></i> {{ $comment->rating }}</span>
                    </div>
                    <p class="mb-1">{{ $comment->content }}</p>
                </div>
            @empty
                <p class="text-muted">Chưa có bình luận nào.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
