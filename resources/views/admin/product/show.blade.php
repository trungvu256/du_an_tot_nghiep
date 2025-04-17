@extends('admin.layouts.main')
@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <div class="col-auto">
                <a href="{{ route('admin.product') }}" class="btn btn-primary"><i class="bi bi-arrow-return-left"></i>
                    Quay lại</a>
            </div>
            <div class="d-flex align-items-center justify-content-center flex-grow-1">
                <h4 style="color: #0ab39c">{{ $product->name }}</h4>
            </div>
        </div>

        <div class="card-body">
            <div class="row gx-lg-5">
                <div class="col-xl-4 col-md-8 mt-5">
                    <div class="product-img-slider sticky-side-div">
                        <!-- Main image -->
                        <div class="main-image-container p-2 rounded bg-light mb-3">
                            <img src="{{ asset('storage/' . $product->image) }}" alt=""
                                class="img-fluid d-block w-100" id="mainImage"/>
                        </div>

                        <!-- Navigation arrows -->
                        <div class="position-relative">
                            <div class="position-absolute start-0 top-50 translate-middle-y">
                                <button class="btn btn-sm btn-light rounded-circle shadow-sm" onclick="prevImage()">
                                    <i class="bi bi-chevron-left"></i>
                                </button>
                            </div>
                            <div class="position-absolute end-0 top-50 translate-middle-y">
                                <button class="btn btn-sm btn-light rounded-circle shadow-sm" onclick="nextImage()">
                                    <i class="bi bi-chevron-right"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Thumbnail images -->
                        <div class="thumbnail-container d-flex justify-content-center mt-3 gap-2">
                            <div class="thumbnail-item active" onclick="updateMainImage('{{ asset('storage/' . $product->image) }}', 0)">
                                <img src="{{ asset('storage/' . $product->image) }}" alt=""
                                    class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover; cursor: pointer"/>
                            </div>
                            @foreach ($description_images as $index => $image)
                                <div class="thumbnail-item" onclick="updateMainImage('{{ asset('storage/' . $image->image) }}', {{ $index + 1 }})">
                                    <img src="{{ asset('storage/' . $image->image) }}" alt=""
                                        class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover; cursor: pointer"/>
                                </div>
                            @endforeach
                        </div>

                        <script>
                            let currentIndex = 0;
                            const images = [ '{{ asset('storage/' . $product->image) }}', @foreach ($description_images as $image) '{{ asset('storage/' . $image->image) }}', @endforeach ];

                            function updateMainImage(src, index) {
                                document.getElementById('mainImage').src = src;
                                currentIndex = index;

                                // Update active thumbnail
                                document.querySelectorAll('.thumbnail-item').forEach((item, i) => {
                                    if (i === index) {
                                        item.classList.add('active');
                                    } else {
                                        item.classList.remove('active');
                                    }
                                });
                            }

                            function prevImage() {
                                currentIndex = (currentIndex > 0) ? currentIndex - 1 : images.length - 1;
                                updateMainImage(images[currentIndex], currentIndex);
                            }

                            function nextImage() {
                                currentIndex = (currentIndex < images.length - 1) ? currentIndex + 1 : 0;
                                updateMainImage(images[currentIndex], currentIndex);
                            }

                            // Add some styling for active thumbnails
                            document.head.insertAdjacentHTML('beforeend', `
                                <style>
                                    .thumbnail-item.active {
                                        border: 2px solid #0ab39c;
                                    }
                                </style>
                            `);
                        </script>
                    </div>
                </div>
                <!-- end col -->

                <div class="col-xl-8">
                    <div class="mt-xl-0 mt-5">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                {{-- <h4>{{ $product->name }}</h4> --}}
                                <div class="hstack gap-3 flex-wrap justify-content-center">
                                    <div class="vr"></div>
                                    <div class="text-muted">Thể loại : <span
                                            class="text-body fw-medium">{{ $product->catalogue->name }}</span></div>
                                    <div class="vr"></div>
                                    <div class="text-muted">Ngày đăng : <span
                                            class="text-body fw-medium">{{ $product->created_at->format('d-m-Y') }}</span>
                                    </div>
                                    <div class="vr"></div>
                                    <div class="text-muted">Trạng thái : <span
                                            class="text-body fw-medium {{ $product->status == 1 ? 'text-success' : 'text-danger' }}">
                                            {{ $product->status == 1 ? 'Đang kinh doanh' : 'Ngừng kinh doanh' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-shrink-0">
                                <div>
                                    <a href="{{ route('admin.edit.product', $product->id) }}" class="btn btn-light"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Chỉnh sửa"><i
                                            class="ri-pencil-fill align-bottom"></i></a>
                                </div>
                            </div>
                        </div>

                        {{-- <div class="d-flex flex-wrap gap-2 align-items-center mt-3">
                        <div class="text-muted fs-16">
                            <span class="mdi mdi-star text-warning"></span>
                            <span class="mdi mdi-star text-warning"></span>
                            <span class="mdi mdi-star text-warning"></span>
                            <span class="mdi mdi-star text-warning"></span>
                            <span class="mdi mdi-star text-warning"></span>
                        </div>
                        <div class="text-muted">( 5.50k Customer Review )</div>
                    </div> --}}

                        <div class="mt-3">
                            <h5 class="fs-14 mb-3">Biến thể sản phẩm: </h5>
                            <div class="accordion" id="productVariantsAccordion">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingVariants">
                                        <button class="accordion-button fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseVariants" aria-expanded="true" aria-controls="collapseVariants">
                                            Xem các biến thể ({{ count($product->variants) }})
                                        </button>
                                    </h2>
                                    <div id="collapseVariants" class="accordion-collapse collapse" aria-labelledby="headingVariants" data-bs-parent="#productVariantsAccordion">
                                        <div class="accordion-body">
                                            <div class="row">
                                                @php
                                                    $variants = $product->variants->chunk(3);
                                                    $currentPage = request()->get('page', 1);
                                                    $currentVariants = $variants->get($currentPage - 1) ?? collect();
                                                @endphp
                                                @foreach ($currentVariants as $variant)
                                                    <div class="col-md-4 mb-3">
                                                        <div class="card border shadow-sm h-100">
                                                            <div class="card-body d-flex flex-column text-center">
                                                                <div class="mb-3">
                                                                    <h6 class="card-title mb-2"><i class="ri-money-dollar-circle-fill"></i> Giá bán:</h6>
                                                                    @if ($variant->price > 0 && $variant->price_sale > 0)
                                                                        <div>
                                                                            <del class="text-dark">
                                                                                {{ number_format($variant->price, 0, ',', '.') }} VNĐ
                                                                            </del>
                                                                            <div class="text-danger fw-bold">
                                                                                {{ number_format($variant->price_sale, 0, ',', '.') }} VNĐ
                                                                            </div>
                                                                        </div>
                                                                    @else
                                                                        <div class="text-success fw-bold">
                                                                            {{ number_format($variant->price_sale > 0 ? $variant->price_sale : $variant->price, 0, ',', '.') }} VNĐ
                                                                        </div>
                                                                    @endif
                                                                </div>

                                                                <div class="mb-3">
                                                                    <h6 class="card-title mb-2">Thuộc tính:</h6>
                                                                    @if ($variant->product_variant_attributes && count($variant->product_variant_attributes) > 0)
                                                                        <ul class="list-unstyled mb-0">
                                                                            @foreach ($variant->product_variant_attributes as $attr)
                                                                                <li class="mb-1">
                                                                                    <span>{{ $attr->attribute->name ?? 'Thuộc tính' }}:</span>
                                                                                    <strong>{{ $attr->attributeValue->value ?? 'Không có giá trị' }}</strong>
                                                                                </li>
                                                                            @endforeach
                                                                        </ul>
                                                                    @else
                                                                        <p class="text-muted mb-0">Không có thuộc tính.</p>
                                                                    @endif
                                                                </div>

                                                                <div>
                                                                    <h6 class="card-title mb-1">Số lượng:</h6>
                                                                    <strong>{{ $variant->stock_quantity }}</strong>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="d-flex justify-content-center mt-3">
                                                <nav>
                                                    <ul class="pagination">
                                                        @for ($i = 1; $i <= $variants->count(); $i++)
                                                            <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                                                                <a class="page-link" href="#" onclick="loadVariantsPage({{ $i }})">{{ $i }}</a>
                                                            </li>
                                                        @endfor
                                                    </ul>
                                                </nav>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script>
                            function loadVariantsPage(page) {
                                fetch(`{{ request()->url() }}?page=${page}`)
                                    .then(response => response.text())
                                    .then(html => {
                                        const parser = new DOMParser();
                                        const doc = parser.parseFromString(html, 'text/html');
                                        const newVariants = doc.querySelector('#collapseVariants .accordion-body').innerHTML;
                                        document.querySelector('#collapseVariants .accordion-body').innerHTML = newVariants;
                                    })
                                    .catch(error => console.error('Error loading page:', error));
                            }
                        </script>
                    </div>

                    <!-- end row -->


                    {{-- <div class="row">
                        <div class="col-sm-6">
                            <div class="mt-3">
                                <h5 class="fs-14">Features :</h5>
                                <ul class="list-unstyled">
                                    <li class="py-1"><i class="mdi mdi-circle-medium me-1 text-muted align-middle"></i> Full Sleeve</li>
                                    <li class="py-1"><i class="mdi mdi-circle-medium me-1 text-muted align-middle"></i> Cotton</li>
                                    <li class="py-1"><i class="mdi mdi-circle-medium me-1 text-muted align-middle"></i> All Sizes available</li>
                                    <li class="py-1"><i class="mdi mdi-circle-medium me-1 text-muted align-middle"></i> 4 Different Color</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mt-3">
                                <h5 class="fs-14">Services :</h5>
                                <ul class="list-unstyled product-desc-list">
                                    <li class="py-1">10 Days Replacement</li>
                                    <li class="py-1">Cash on Delivery available</li>
                                </ul>
                            </div>
                        </div>
                    </div> --}}


                    <div class="product-content mt-5">
                        {{-- <h5 class="fs-14 mb-3">Thông tin sản phẩm :</h5> --}}
                        <nav>
                            <ul class="nav nav-tabs nav-tabs-custom nav-success justify-content-center" id="nav-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="nav-speci-tab" data-bs-toggle="tab" href="#nav-speci"
                                        role="tab" aria-controls="nav-speci" aria-selected="true">Thông tin sản
                                        phẩm</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="nav-detail-tab" data-bs-toggle="tab" href="#nav-detail"
                                        role="tab" aria-controls="nav-detail" aria-selected="false">Mô tả</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="nav-comment-tab" data-bs-toggle="tab" href="#nav-comment"
                                        role="tab" aria-controls="nav-comment" aria-selected="false">Bình luận &
                                        đánh giá</a>
                                </li>
                            </ul>
                        </nav>
                        <div class="tab-content border border-top-0 p-4" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-speci" role="tabpanel"
                                aria-labelledby="nav-speci-tab">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover mb-0">
                                        <tbody>
                                            <tr>
                                                <th scope="row" class="bg-light text-dark text-center" style="width: 200px; vertical-align: middle; font-weight: 500; white-space: nowrap; padding-left: 200px;">Giới tính: </th>
                                                <td class="py-3 text-center">{{ $product->gender }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row" class="bg-light text-dark text-center" style="width: 200px; vertical-align: middle; font-weight: 500; white-space: nowrap; padding-left: 200px;">Thương hiệu: </th>
                                                <td class="py-3 text-center">{{ $product->brand->name ?? 'Không có thương hiệu' }}</td>
                                            </tr>
                                            {{-- <tr>
                                                <th scope="row">Longevity</th>
                                                <td>{{$product->longevity}}</td>
                                            </tr> --}}
                                            {{-- <tr>
                                                <th scope="row">Nồng độ</th>
                                                <td>{{ $product->concentration }}</td>
                                            </tr> --}}
                                            <tr>
                                                <th scope="row" class="bg-light text-dark text-center" style="width: 200px; vertical-align: middle; font-weight: 500; white-space: nowrap; padding-left: 200px;">Xuất xứ: </th>
                                                <td class="py-3 text-center">{{ $product->origin }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row" class="bg-light text-dark text-center" style="width: 200px; vertical-align: middle; font-weight: 500; white-space: nowrap; padding-left: 200px;">Phong cách: </th>
                                                <td class="py-3 text-center">{{ $product->style }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row" class="bg-light text-dark text-center" style="width: 200px; vertical-align: middle; font-weight: 500; white-space: nowrap; padding-left: 200px;">Nhóm hương: </th>
                                                <td class="py-3 text-center">{{ $product->fragrance_group }}</td>
                                            </tr>
                                            {{-- <tr>
                                                <th scope="row">Số lượng</th>
                                                <td>{{ $product->stock_quantity }}</td>
                                            </tr> --}}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-detail" role="tabpanel" aria-labelledby="nav-detail-tab">
                                <div>
                                    <p>{!! $product->description !!}</p>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-comment" role="tabpanel" aria-labelledby="nav-comment-tab">
                                <div>
                                    <div class="mt-5">
                                        <div>
                                            <h5 class="fs-14 mb-3">Bình luận & đánh giá: </h5>
                                        </div>
                                        <div class="row gy-4 gx-0 justify-content-center">
                                            <div class="col-lg-5">
                                                <div class="card border shadow-none h-100">
                                                    <div class="card-body d-flex flex-column">
                                                        <div class="d-flex align-items-center mb-3">
                                                            <div class="flex-grow-1">
                                                                <h5 class="card-title mb-0">Bình luận</h5>
                                                            </div>
                                                            <div class="flex-shrink-0">
                                                                <span class="badge bg-primary rounded-pill">{{ $product->comments()->count() }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="mt-auto text-center">
                                                            <button class="btn btn-light w-100" type="button" data-bs-toggle="collapse" data-bs-target="#commentsCollapse" aria-expanded="false" aria-controls="commentsCollapse">
                                                                Xem bình luận
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-5">
                                                <div class="card border shadow-none h-100">
                                                    <div class="card-body d-flex flex-column">
                                                        <div class="d-flex align-items-center mb-3">
                                                            <div class="flex-grow-1">
                                                                <h5 class="card-title mb-0">Đánh giá</h5>
                                                            </div>
                                                            <div class="flex-shrink-0">
                                                                <span class="badge bg-primary rounded-pill">{{ $product->reviews()->count() }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="mt-auto text-center">
                                                            <button class="btn btn-light w-100" type="button" data-bs-toggle="collapse" data-bs-target="#reviewsCollapse" aria-expanded="false" aria-controls="reviewsCollapse">
                                                                Xem đánh giá
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="collapse mt-4" id="commentsCollapse">
                                            <div class="card border shadow-none">
                                                <div class="card-body">
                                                    <h5 class="card-title mb-3">Danh sách bình luận</h5>
                                                    <div class="list-group" id="comments-list">
                                                        @forelse($product->comments()->paginate(3) as $comment)
                                                            <div class="list-group-item">
                                                                <div class="d-flex justify-content-between align-items-center">
                                                                    <h6>{{ $comment->user->name ?? 'Ẩn danh' }} -
                                                                        <small>{{ optional($comment->created_at)->format('d M, Y') }}</small>
                                                                    </h6>
                                                                </div>
                                                                <p class="mb-1">{{ $comment->comment }}</p>
                                                            </div>
                                                        @empty
                                                            <p class="text-muted">Chưa có bình luận nào.</p>
                                                        @endforelse
                                                    </div>

                                                    @if($product->comments()->count() > 3)
                                                        <div class="mt-3">
                                                            {{ $product->comments()->paginate(3)->links() }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="collapse mt-4" id="reviewsCollapse">
                                            <div class="card border shadow-none">
                                                <div class="card-body">
                                                    <h5 class="card-title mb-3">Danh sách đánh giá</h5>
                                                    <div class="list-group" id="reviews-list">
                                                        @forelse($product->reviews()->paginate(3) as $review)
                                                            <div class="list-group-item">
                                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                                    <h6 class="mb-0">{{ $review->user->name ?? 'Ẩn danh' }} -
                                                                        <small class="text-muted">{{ optional($review->created_at)->format('d M, Y') }}</small>
                                                                    </h6>
                                                                </div>
                                                                @if($review->variant)
                                                                <div class="mb-2">
                                                                    <span class="badge bg-light text-dark">
                                                                        <span style="font-size: larger; font-style: italic;">{{ $product->name }}: Dung tích: {{ $review->variant->concentration }} - Nồng độ: {{ $review->variant->size }}</span>
                                                                        @if($review->variant->special_edition)
                                                                            - {{ $review->variant->special_edition }}
                                                                        @endif
                                                                    </span>
                                                                </div>
                                                                @endif
                                                                <div class="mb-2">
                                                                    @for($i = 1; $i <= 5; $i++)
                                                                        @if($i <= $review->rating)
                                                                            <i class="mdi mdi-star text-warning"></i>
                                                                        @else
                                                                            <i class="mdi mdi-star-outline text-muted"></i>
                                                                        @endif
                                                                    @endfor
                                                                </div>
                                                                <p class="mb-1">{{ $review->review }}</p>
                                                            </div>
                                                        @empty
                                                            <p class="text-muted">Chưa có đánh giá nào.</p>
                                                        @endforelse
                                                    </div>

                                                    @if($product->reviews()->count() > 3)
                                                        <div class="mt-3">
                                                            {{ $product->reviews()->paginate(3)->links() }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- product-content -->


                    <!-- end card body -->
                </div>
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- end card body -->
    </div>
@endsection

@push('scripts')
<script>
    // Ẩn nội dung bình luận và đánh giá ban đầu
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('comments-list').style.display = 'none';
        document.getElementById('reviews-list').style.display = 'none';
    });

    // Xử lý sự kiện click tab
    document.querySelectorAll('.nav-link').forEach(tab => {
        tab.addEventListener('click', function() {
            const targetId = this.getAttribute('href');
            if (targetId === '#nav-comment') {
                // Hiển thị nội dung khi click vào tab bình luận
                document.getElementById('comments-list').style.display = 'block';
                document.getElementById('reviews-list').style.display = 'block';
            }
        });
    });
</script>
@endpush
