@extends('web3.layout.master2')
@section('content')

<body>
    <div id="wrapper">
        <!-- Breadcrumb -->
        <div class="tf-breadcrumb mb-0">
            <div class="container">
                <ul class="breadcrumb-list">
                    <li class="item-breadcrumb">
                        <a href="{{ route('web.home') }}" class="text">Trang chủ</a>
                    </li>
                    <li class="item-breadcrumb dot">
                        <span></span>
                    </li>
                    <li class="item-breadcrumb">
                        <span class="text">Chi tiết sản phẩm</span>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /Breadcrumb -->
        <!-- Product Main -->
        <section class="flat-single-product pb-0">
            <div class="tf-main-product section-image-zoom">
                <div class="container">
                    <div class="row">
                        <!-- Product Images -->
                        <div class="col-md-6">
                            <div class="tf-product-media-wrap sticky-top">
                                <div class="product-media-container d-flex">
                                    <!-- Thumbnail Slider (bên trái) -->
                                    <div class="thumbs-slider me-3">
                                        <div dir="ltr" class="swiper tf-product-media-thumbs other-image-zoom" data-preview="4" data-direction="vertical">
                                            <div class="swiper-wrapper stagger-wrap">
                                                @foreach ($description_images as $key => $image)
                                                    <div class="swiper-slide stagger-item" data-color="{{ $key == 0 ? 'black' : ($key == 1 ? 'yellow' : 'grey') }}" data-size="small">
                                                        <div class="item">
                                                            <img class="lazyload thumb-image" data-src="{{ asset('storage/' . $image->image) }}" src="{{ asset('storage/' . $image->image) }}" alt="img-product">
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Main Slider (bên phải) -->
                                    <div class="flat-wrap-media-product flex-grow-1">
                                        <div dir="ltr" class="swiper tf-product-media-main" id="gallery-swiper-started">
                                            <div class="swiper-wrapper">
                                                @foreach ($description_images as $key => $image)
                                                    <div class="swiper-slide" data-color="{{ $key == 0 ? 'black' : ($key == 1 ? 'yellow' : 'grey') }}" data-size="small">
                                                        <a href="{{ asset('storage/' . $image->image) }}" target="_blank" class="item" data-pswp-width="552px" data-pswp-height="827px">
                                                            <img class="tf-image-zoom lazyload main-image" data-zoom="{{ asset('storage/' . $image->image) }}" data-src="{{ asset('storage/' . $image->image) }}" src="{{ asset('storage/' . $image->image) }}" alt="img-product">
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="swiper-button-next nav-swiper thumbs-next"></div>
                                        <div class="swiper-button-prev nav-swiper thumbs-prev"></div>
                                    </div>
                                </div>
                            </div>

                            <script>
                            // Khởi tạo Swiper cho thumbnail và slider chính
                            document.addEventListener('DOMContentLoaded', function () {
                                const thumbsSwiper = new Swiper('.tf-product-media-thumbs', {
                                    direction: 'vertical',
                                    spaceBetween: 10,
                                    slidesPerView: 4,
                                    freeMode: true,
                                    watchSlidesProgress: true,
                                });

                                const mainSwiper = new Swiper('.tf-product-media-main', {
                                    spaceBetween: 10,
                                    navigation: {
                                        nextEl: '.thumbs-next',
                                        prevEl: '.thumbs-prev',
                                    },
                                    thumbs: {
                                        swiper: thumbsSwiper,
                                    },
                                });
                            });
                            </script>
                        </div>
                        <!-- /Product Images -->
                        <!-- Product Info -->
                        <div class="col-md-6">
                            <div class="tf-product-info-wrap position-relative">
                                <div class="tf-zoom-main"></div>
                                <div class="tf-product-info-list other-image-zoom">
                                    <!-- Thông tin chính sản phẩm -->
                                    <div class="tf-product-info-heading">
                                        <h5 class="product-info-name fw-medium">{{ $detailproduct->name }}</h5>
                                        <div class="product-info-rate">
                                            <div class="list-star">
                                                <i class="icon icon-star"></i>
                                                <i class="icon icon-star"></i>
                                                <i class="icon icon-star"></i>
                                                <i class="icon icon-star"></i>
                                                <i class="icon icon-star"></i>
                                            </div>
                                            <span class="count-review">({{ $product->reviews->count() }} Đánh giá)</span>
                                        </div>
                                        <div class="product-info-price">
                                            @php
                                                $minPriceSale = $detailproduct->variants->where('price_sale', '>', 0)->min('price_sale');
                                                $minPrice = $minPriceSale ?? $detailproduct->variants->min('price');
                                                $maxPrice = $detailproduct->variants->max('price');
                                            @endphp
                                            <div class="display-sm price-new price-on-sale" id="product-sale-price">
                                                {{ number_format($minPrice, 0, ',', '.') }} - {{ number_format($maxPrice, 0, ',', '.') }}₫
                                            </div>
                                            <div class="display-sm price-old" id="product-original-price" style="display: none; font-style: italic;"></div>
                                            <span class="badge-sale" id="discount-badge" style="display: none; font-size: smaller; font-style: italic;">Đang giảm giá!</span>
                                        </div>
                                        <div class="mb-4">
                                            <p class="text-dark font-weight-medium mb-0 mr-3">Thương hiệu : <strong>{{ $brand->name }}</strong></p>
                                        </div>
                                        <div class="mb-4">
                                            <p class="text-dark font-weight-medium mb-0 mr-3">Loại sản phẩm : <strong>{{ $category->name }}</strong></p>
                                        </div>
                                        <div class="product-info-progress-sale">
                                            <div class="title-hurry-up">
                                                <span class="text-primary fw-medium"></span> Còn lại trong kho <span class="count" id="product-stock"></span> sản phẩm!
                                            </div>
                                            <div class="progress-sold">
                                                <div class="value" style="width: 0%;" data-progress="70"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Chọn biến thể sản phẩm -->
                                    <form id="variantForm" class="d-flex flex-column" method="POST" action="{{ route('cart.create', $detailproduct->id) }}">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $detailproduct->id }}">
                                        <input type="hidden" name="name" value="{{ $detailproduct->name }}">
                                        <input type="hidden" name="image" value="{{ $detailproduct->image }}">
                                        <input type="hidden" name="price" id="selectedPrice">
                                        <input type="hidden" name="price_sale" id="selectedSalePrice">
                                        <input type="hidden" name="stock_quantity" id="selectedStock">
                                        <input type="hidden" id="selectedAttributes" name="attributes">

                                        @php
                                            $attributes = [];
                                            foreach ($detailproduct->variants as $variant) {
                                                foreach ($variant->product_variant_attributes as $attr) {
                                                    $attrName = $attr->attribute->name;
                                                    $attrValue = $attr->attributeValue->value;
                                                    if (!isset($attributes[$attrName])) {
                                                        $attributes[$attrName] = [];
                                                    }
                                                    if (!in_array($attrValue, $attributes[$attrName])) {
                                                        $attributes[$attrName][] = $attrValue;
                                                    }
                                                }
                                            }

                                            $variantData = [];
                                            foreach ($detailproduct->variants as $variant) {
                                                $attributesCombo = [];
                                                foreach ($variant->product_variant_attributes as $attr) {
                                                    $attrName = $attr->attribute->name;
                                                    $attrValue = $attr->attributeValue->value;
                                                    $attributesCombo[$attrName] = $attrValue;
                                                }
                                                $variantKey = json_encode($attributesCombo);
                                                $variantData[$variantKey] = [
                                                    'price' => $variant->price,
                                                    'price_sale' => $variant->price_sale ?? 0,
                                                    'stock' => $variant->stock_quantity,
                                                    'id' => $variant->id,
                                                ];
                                            }

                                            // Chọn biến thể mặc định (biến thể đầu tiên hoặc có giá thấp nhất)
                                            $defaultVariant = null;
                                            $defaultVariantKey = null;
                                            foreach ($variantData as $key => $data) {
                                                if (!$defaultVariant || ($data['price_sale'] > 0 ? $data['price_sale'] : $data['price']) < ($defaultVariant['price_sale'] > 0 ? $defaultVariant['price_sale'] : $defaultVariant['price'])) {
                                                    $defaultVariant = $data;
                                                    $defaultVariantKey = $key;
                                                }
                                            }
                                            $defaultAttributes = $defaultVariantKey ? json_decode($defaultVariantKey, true) : [];
                                        @endphp

                                        @if (empty($attributes))
                                            <p>Không có thuộc tính nào để chọn.</p>
                                        @else
                                            @foreach ($attributes as $attrName => $values)
                                                <div class="variant-picker-item variant-group mb-3">
                                                    <div class="variant-picker-label">
                                                        {{ $attrName }}
                                                    </div>
                                                    <div class="variant-picker-values">
                                                        @foreach ($values as $value)
                                                            <button type="button" class="btn btn-outline-dark m-1 variant-option"
                                                                    data-attribute="{{ $attrName }}" data-value="{{ $value }}"
                                                                    onclick="selectAttribute(this)">
                                                                <strong>{{ $value }}</strong>
                                                            </button>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif

                                        <!-- Số lượng và nút hành động -->
                                        <div class="tf-product-total-quantity">
                                            <div class="group-btn">
                                                <div class="wg-quantity">
                                                    <button type="button" class="btn-quantity btn-decrease" data-action="decrease">-</button>
                                                    <input type="text" id="quantity" name="quantity" value="1" class="form-control form-control-sm text-center bg-light quantity-display" style="width: 100px;">
                                                    <button type="button" class="btn-quantity btn-increase" data-action="increase">+</button>
                                                </div>
                                                <button type="button" class="tf-btn hover-primary btn-add-to-cart" onclick="addToCart(event)">Thêm vào giỏ hàng</button>
                                                <button type="submit" formaction="{{ route('checkout.create', $detailproduct->id) }}" class="tf-btn hover-primary btn-add-to-cart">Mua ngay</button>
                                            </div>
                                        </div>
                                    </form>

                                    <!-- Các hành động phụ -->

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /Product Main -->
        <!-- Product Tabs Section -->
        <section class="product-tabs-section flat-spacing-4 pt-0">
            <div class="container">
                <div class="product-tabs">
                    <!-- Tab Navigation -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab" aria-controls="description" aria-selected="true">
                                Mô tả chi tiết
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab" aria-controls="reviews" aria-selected="false">
                                Đánh giá sản phẩm
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="comments-tab" data-bs-toggle="tab" data-bs-target="#comments" type="button" role="tab" aria-controls="comments" aria-selected="false">
                                Bình luận sản phẩm
                            </button>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content">
                        <!-- Description Tab -->
                        <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                            <div class="product-description">
                                <p>{!! $detailproduct->description !!}</p>
                            </div>
                        </div>

                        <!-- Reviews Tab -->
                        <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                            <div class="product-reviews">
                                <!-- Thông tin đánh giá tổng quan -->
                                <div class="mb-3 border-bottom pb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="mb-0 fw-bold">Đánh giá sản phẩm</h5>
                                        <div id="selected-variant-info" class="text-primary">
                                            <span class="badge bg-light text-dark">Vui lòng chọn biến thể sản phẩm bên trên để xem đánh giá</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-4">
                                        <div class="card">
                                            <div class="card-body text-center">
                                                <h3 class="mb-0" id="average-rating">0.0</h3>
                                                <div class="rating-stars mb-2">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                </div>
                                                <p class="text-muted mb-0">Dựa trên <span id="total-reviews">0</span> đánh giá</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="rating-bars">
                                            @for($i = 5; $i >= 1; $i--)
                                                <div class="rating-bar-item d-flex align-items-center mb-2">
                                                    <div class="rating-label me-2">{{ $i }} sao</div>
                                                    <div class="progress flex-grow-1" style="height: 10px;">
                                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 0%;"
                                                             aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
                                                             data-rating="{{ $i }}"></div>
                                                    </div>
                                                    <div class="rating-count ms-2" data-rating="{{ $i }}">0</div>
                                                </div>
                                            @endfor
                                        </div>
                                    </div>
                                </div>

                                <!-- Danh sách đánh giá -->
                                <div id="reviews-container">
                                    <div class="alert text-center py-4">
                                        <i class="fas fa-tag fa-2x mb-3 d-block"></i>
                                        {{-- <h5 class="mb-2">Vui lòng chọn biến thể sản phẩm</h5> --}}
                                        <p class="mb-0">Hãy chọn biến thể sản phẩm bên trên để xem đánh giá từ khách hàng</p>
                                    </div>
                                </div>

                                <!-- Phân trang đánh giá -->
                                <div class="d-flex justify-content-center mt-4">
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination" id="reviews-pagination">
                                            <!-- Phân trang sẽ được thêm bằng JavaScript -->
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>

                        <!-- Comments Tab -->
                        <div class="tab-pane fade" id="comments" role="tabpanel" aria-labelledby="comments-tab">
                            <div class="product-comments">
                                <!-- Form bình luận -->
                                <div class="comment-form mb-4">
                                    <h5 class="mb-3">Viết bình luận</h5>
                                    <form id="comment-form">
                                        <div class="mb-3">
                                            <textarea class="form-control" id="comment-content" rows="3" placeholder="Nhập bình luận của bạn..."></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Gửi bình luận</button>
                                    </form>
                                </div>

                                <!-- Danh sách bình luận -->
                                <div id="comments-container">
                                    <div class="text-center py-4">
                                        <p class="text-muted">Chưa có bình luận nào</p>
                                    </div>
                                </div>

                                <!-- Phân trang bình luận -->
                                <div class="d-flex justify-content-center mt-4">
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination" id="comments-pagination">
                                            <!-- Phân trang sẽ được thêm bằng JavaScript -->
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <style>
            .product-tabs-section {
                background-color: #fff;
            }

            .product-tabs {
                background: #fff;
                border-radius: 8px;
                box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            }

            .nav-tabs {
                border: none;
                padding: 0 20px;
                background-color: #f8f9fa;
                border-bottom: 1px solid #eee;
                display: flex;
                justify-content: center;
            }

            .nav-tabs .nav-item {
                margin: 0;
            }

            .nav-tabs .nav-link {
                border: none;
                color: #666;
                font-weight: 500;
                padding: 15px 25px;
                position: relative;
                background: transparent;
                transition: all 0.3s ease;
                min-width: 160px;
                text-align: center;
            }

            .nav-tabs .nav-link:hover {
                color: #333;
                border: none;
            }

            .nav-tabs .nav-link.active {
                color: #333;
                background: transparent;
                border: none;
                font-weight: 600;
            }

            .nav-tabs .nav-link.active::after {
                content: '';
                position: absolute;
                bottom: 0;
                left: 0;
                width: 100%;
                height: 2px;
                background-color: #333;
            }

            .tab-content {
                padding: 30px;
            }

            .tab-pane {
                color: #666;
                line-height: 1.6;
            }

            /* Rating Stars */
            .rating-stars {
                color: #ffc107;
                font-size: 20px;
            }

            /* Progress Bars */
            .rating-bars .progress {
                height: 8px;
                border-radius: 4px;
                background-color: #eee;
            }

            .rating-bars .progress-bar {
                border-radius: 4px;
            }

            .rating-bar-item {
                margin-bottom: 12px;
            }

            .rating-label {
                min-width: 60px;
                color: #666;
            }

            .rating-count {
                min-width: 40px;
                text-align: right;
                color: #666;
            }

            /* Comments Form */
            .comment-form textarea {
                border: 1px solid #e0e0e0;
                border-radius: 8px;
                padding: 15px;
                resize: vertical;
            }

            .comment-form textarea:focus {
                border-color: #007bff;
                box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
            }

            .comment-form .btn-primary {
                background-color: #007bff;
                border: none;
                padding: 10px 25px;
                border-radius: 5px;
                font-weight: 500;
                transition: all 0.3s ease;
            }

            .comment-form .btn-primary:hover {
                background-color: #0056b3;
                transform: translateY(-1px);
            }

            /* Card Styling */
            .card {
                border: none;
                box-shadow: 0 2px 4px rgba(0,0,0,0.05);
                border-radius: 8px;
            }

            .card-body {
                padding: 20px;
            }

            /* Form Select */
            .form-select {
                border: 1px solid #e0e0e0;
                border-radius: 5px;
                padding: 8px 12px;
                color: #333;
            }

            .form-select:focus {
                border-color: #007bff;
                box-shadow: none;
            }

            /* Buy Now Button Styling */
            .btn-buy-now {
                background-color: #ff4500;
                color: white;
                border: none;
                margin-left: 10px;
                padding: 10px 20px;
                border-radius: 5px;
                font-weight: 500;
                transition: all 0.3s ease;
            }

            .btn-buy-now:hover {
                background-color: #e03e00;
                transform: translateY(-1px);
            }

            /* Active Variant Button */
            .variant-option.active {
                background-color: #007bff;
                color: white;
                border-color: #007bff;
            }

            /* Responsive */
            @media (max-width: 768px) {
                .nav-tabs {
                    padding: 0 10px;
                }

                .nav-tabs .nav-link {
                    padding: 12px 15px;
                    font-size: 14px;
                }

                .tab-content {
                    padding: 20px;
                }

                .group-btn {
                    flex-direction: column;
                    align-items: stretch;
                }

                .btn-add-to-cart, .btn-buy-now {
                    margin-left: 0;
                    margin-top: 10px;
                    width: 100%;
                }
            }

            @media (max-width: 576px) {
                .nav-tabs {
                    display: flex;
                    overflow-x: auto;
                    white-space: nowrap;
                    -webkit-overflow-scrolling: touch;
                }

                .nav-tabs::-webkit-scrollbar {
                    display: none;
                }
            }
        </style>

        <script>
            $(document).ready(function() {
                // Xử lý chuyển tab
                $('.nav-link').on('click', function (e) {
                    e.preventDefault();
                    $(this).tab('show');
                });

                // Lưu tab đang active vào localStorage
                $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
                    localStorage.setItem('activeTab', $(e.target).attr('href'));
                });

                // Khôi phục tab active từ localStorage
                var activeTab = localStorage.getItem('activeTab');
                if (activeTab) {
                    $('.nav-tabs a[href="' + activeTab + '"]').tab('show');
                }
            });
        </script>

        <!-- JavaScript để xử lý chọn thuộc tính -->
        <script>
           document.addEventListener("DOMContentLoaded", function () {
            let selectedAttributes = {};
            let defaultMinPrice = {{ $detailproduct->variants->min('price') ?? 0 }};
            let defaultMaxPrice = {{ $detailproduct->variants->max('price') ?? 0 }};
            const variantButtons = document.querySelectorAll('.variant-option');
            const totalGroups = document.querySelectorAll('.variant-group').length;
            const variantData = @json($variantData);
            const defaultAttributes = @json($defaultAttributes);
            const defaultVariant = @json($defaultVariant);

            // Biến để kiểm soát trạng thái nhấn nút (tránh lặp sự kiện)
            let isProcessing = false;

            function setDefaultPrice() {
                let salePriceEl = document.getElementById("product-sale-price");
                let originalPriceEl = document.getElementById("product-original-price");
                let stockWrapper = document.getElementById("product-stock");

                originalPriceEl.style.display = "none";
                salePriceEl.innerText = new Intl.NumberFormat('vi-VN').format(defaultMinPrice) + " - " + new Intl.NumberFormat('vi-VN').format(defaultMaxPrice) + "₫";
                stockWrapper.innerText = "";
            }

            function updateProductInfo(price, salePrice, stock) {
                let originalPriceEl = document.getElementById("product-original-price");
                let salePriceEl = document.getElementById("product-sale-price");
                let stockEl = document.getElementById("product-stock");
                let discountBadge = document.getElementById("discount-badge");

                if (salePrice > 0 && salePrice < price) {
                    originalPriceEl.style.display = "inline";
                    originalPriceEl.innerText = new Intl.NumberFormat('vi-VN').format(price) + '₫';
                    salePriceEl.innerText = new Intl.NumberFormat('vi-VN').format(salePrice) + '₫';
                    discountBadge.style.display = "inline";
                } else {
                    originalPriceEl.style.display = "none";
                    salePriceEl.innerText = new Intl.NumberFormat('vi-VN').format(price) + '₫';
                    discountBadge.style.display = "none";
                }

                stockEl.innerText = stock > 0 ? stock : "Hết hàng";
                document.getElementById("selectedPrice").value = price;
                document.getElementById("selectedSalePrice").value = salePrice;
                document.getElementById("selectedStock").value = stock;

                // Debug: Kiểm tra giá trị stock và quantity
                const quantityInput = document.getElementById('quantity');
                console.log("updateProductInfo - Stock:", stock, "Quantity before adjustment:", quantityInput.value);

                // Đặt lại quantity về 1 và giới hạn theo stock
                quantityInput.value = 1;
                let currentValue = parseInt(quantityInput.value) || 1;
                if (currentValue > stock) {
                    quantityInput.value = stock;
                    console.log("Adjusted Quantity to Stock in updateProductInfo:", stock);
                }

                updateQuantityLimit(stock);
            }

            function findMatchingVariant() {
                let selectedCount = Object.keys(selectedAttributes).length;
                if (selectedCount === totalGroups) {
                    let matchedVariant = null;
                    for (let key in variantData) {
                        let variantAttributes = JSON.parse(key);
                        let allMatched = Object.keys(selectedAttributes).every(attrName => {
                            return variantAttributes[attrName] === selectedAttributes[attrName];
                        });
                        if (allMatched) {
                            matchedVariant = variantData[key];
                            break;
                        }
                    }

                    if (matchedVariant) {
                        let price = matchedVariant.price;
                        let salePrice = matchedVariant.price_sale;
                        let stock = matchedVariant.stock;
                        updateProductInfo(price, salePrice, stock);

                        // Cập nhật đánh giá cho biến thể đã chọn
                        loadReviews(matchedVariant.id);

                        // Hiển thị thông tin biến thể đã chọn trong tab đánh giá
                        updateSelectedVariantInfo(matchedVariant.id);
                    } else {
                        setDefaultPrice();
                    }
                } else {
                    setDefaultPrice();
                }
            }

            function updateQuantityLimit(stock) {
                const quantityInput = document.getElementById('quantity');
                if (stock > 0) {
                    quantityInput.max = stock;
                    if (parseInt(quantityInput.value) > stock) {
                        quantityInput.value = stock;
                        console.log("Adjusted Quantity to Stock in updateQuantityLimit:", stock);
                    }
                    if (parseInt(quantityInput.value) < 1) {
                        quantityInput.value = 1;
                    }
                } else {
                    quantityInput.max = 1;
                    quantityInput.value = 1;
                }
                validateQuantity();
            }

            function validateQuantity() {
                const quantityInput = document.getElementById('quantity');
                const stock = parseInt(document.getElementById('selectedStock').value) || 0;
                let currentValue = parseInt(quantityInput.value) || 1;

                console.log("validateQuantity - Stock:", stock, "Quantity:", currentValue);

                if (currentValue > stock) {
                    quantityInput.value = stock;
                    console.log("Adjusted Quantity to Stock in validateQuantity:", stock);
                } else if (currentValue < 1) {
                    quantityInput.value = 1;
                }
            }

            // Chọn biến thể mặc định khi tải trang
            function selectDefaultVariant() {
                if (defaultVariant && defaultAttributes) {
                    selectedAttributes = { ...defaultAttributes };
                    document.getElementById('selectedAttributes').value = JSON.stringify(selectedAttributes);

                    // Đánh dấu các nút thuộc tính mặc định là active
                    Object.keys(defaultAttributes).forEach(attrName => {
                        const button = document.querySelector(`.variant-option[data-attribute="${attrName}"][data-value="${defaultAttributes[attrName]}"]`);
                        if (button) {
                            button.classList.add('active');
                        }
                    });

                    // Cập nhật thông tin sản phẩm
                    updateProductInfo(defaultVariant.price, defaultVariant.price_sale, defaultVariant.stock);

                    // Cập nhật đánh giá và thông tin biến thể
                    loadReviews(defaultVariant.id);
                    updateSelectedVariantInfo(defaultVariant.id);
                } else {
                    setDefaultPrice();
                }
            }

            // Gọi hàm chọn biến thể mặc định khi tải trang
            selectDefaultVariant();

            window.selectAttribute = function (button) {
                let attrName = button.getAttribute('data-attribute');
                let attrValue = button.getAttribute('data-value');

                let groupButtons = button.closest('.variant-group').querySelectorAll('.variant-option');
                groupButtons.forEach(btn => btn.classList.remove('active'));

                button.classList.add('active');
                selectedAttributes[attrName] = attrValue;
                document.getElementById('selectedAttributes').value = JSON.stringify(selectedAttributes);

                findMatchingVariant();
            };

            // Xử lý nút tăng/giảm
            $(document).on('click', '.btn-decrease, .btn-increase', function(e) {
                e.preventDefault();
                const action = $(this).data('action');
                const quantityInput = document.getElementById('quantity');
                const stock = parseInt(document.getElementById('selectedStock').value) || 0;
                let quantity = parseInt(quantityInput.value.replace(/\D/g, '')) || 1;

                if (action === 'increase') {
                    if (quantity >= stock) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Số lượng không hợp lệ!',
                            text: `Số lượng tồn kho chỉ còn ${stock} sản phẩm. Số lượng đã được điều chỉnh về mức tối đa có thể.`,
                            confirmButtonText: 'Đã hiểu'
                        });
                        quantity = stock;
                    } else {
                        quantity += 1;
                    }
                } else if (action === 'decrease' && quantity > 1) {
                    quantity -= 1;
                }

                // Giới hạn số lượng và cập nhật giao diện
                quantity = Math.max(1, Math.min(stock, quantity));
                quantityInput.value = quantity;
            });

            // Xử lý khi nhập tay vào input
            document.getElementById('quantity').addEventListener('input', function() {
                const stock = parseInt(document.getElementById('selectedStock').value) || 0;
                let newQuantity = parseInt(this.value.replace(/\D/g, '')) || 1;

                if (newQuantity > stock) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Số lượng không hợp lệ!',
                        text: `Số lượng tồn kho chỉ còn ${stock} sản phẩm. Số lượng đã được điều chỉnh về mức tối đa có thể.`,
                        confirmButtonText: 'Đã hiểu'
                    });
                    newQuantity = stock;
                }

                // Giới hạn số lượng và cập nhật giao diện
                newQuantity = Math.max(1, Math.min(stock, newQuantity));
                this.value = newQuantity;
            });

            // Xử lý đánh giá sản phẩm
            let currentPage = 1;
            const reviewsPerPage = 5;

            function updateSelectedVariantInfo(variantId) {
                const variantInfoElement = document.getElementById('selected-variant-info');

                if (Object.keys(selectedAttributes).length > 0) {
                    let attributeText = '';
                    Object.keys(selectedAttributes).forEach((attrName, index) => {
                        if (index > 0) attributeText += ', ';
                        attributeText += `${attrName}: ${selectedAttributes[attrName]}`;
                    });

                    variantInfoElement.innerHTML = `
                        <span class="badge bg-primary text-white p-2">
                            <i class="fas fa-check-circle me-1"></i>
                            Đang xem đánh giá cho biến thể: ${attributeText}
                        </span>
                    `;
                } else {
                    variantInfoElement.innerHTML = `
                        <span class="badge bg-light text-dark p-2">
                            <i class="fas fa-info-circle me-1"></i>
                            Vui lòng chọn biến thể sản phẩm bên trên để xem đánh giá
                        </span>
                    `;
                }
            }

            function loadReviews(variantId, page = 1) {
                if (!variantId) {
                    document.getElementById('reviews-container').innerHTML = `
                        <div class="alert alert-info text-center py-4">
                            <i class="fas fa-tag fa-2x mb-3 d-block"></i>
                            <h5 class="mb-2">Vui lòng chọn biến thể sản phẩm</h5>
                            <p class="mb-0">Hãy chọn biến thể sản phẩm bên trên để xem đánh giá từ khách hàng</p>
                        </div>
                    `;
                    return;
                }

                document.getElementById('reviews-container').innerHTML = `
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Đang tải đánh giá...</span>
                        </div>
                    </div>
                `;

                fetch(`/api/products/{{ $detailproduct->id }}/variants/${variantId}/reviews?page=${page}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log("Review data:", data);

                        if (data.summary) {
                            updateReviewSummary(data.summary);
                        } else {
                            resetReviewSummary();
                        }

                        if (data.success && data.reviews && data.reviews.length > 0) {
                            displayReviews(data.reviews);
                            if (data.pagination) {
                                updatePagination(data.pagination);
                            }
                        } else {
                            document.getElementById('reviews-container').innerHTML = `
                                <div class="alert alert-light border text-center py-4">
                                    <i class="fas fa-star-half-alt text-warning fa-2x mb-3"></i>
                                    <h5 class="mb-2">Chưa có đánh giá</h5>
                                    <p class="text-muted mb-0">Chưa có đánh giá nào cho biến thể này. Hãy đặt hàng và là người đầu tiên đánh giá!</p>
                                </div>
                            `;


                            // Ẩn phân trang

                            document.getElementById('reviews-pagination').innerHTML = '';
                        }
                    })
                    .catch(error => {
                        console.error('Error loading reviews:', error);
                        document.getElementById('reviews-container').innerHTML = `
                            <div class="alert alert-danger text-center py-4">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <p class="mb-0">Có lỗi xảy ra khi tải đánh giá. Vui lòng thử lại sau.</p>
                                <small class="d-block mt-2 text-muted">${error.message}</small>
                            </div>
                        `;
                        document.getElementById('reviews-pagination').innerHTML = '';
                    });
            }

            function resetReviewSummary() {
                document.getElementById('average-rating').textContent = '0.0';
                document.getElementById('total-reviews').textContent = '0';


                // Đặt lại các thanh tiến trình

                for (let i = 5; i >= 1; i--) {
                    const progressBar = document.querySelector(`.progress-bar[data-rating="${i}"]`);
                    const ratingCount = document.querySelector(`.rating-count[data-rating="${i}"]`);

                    if (progressBar) progressBar.style.width = '0%';
                    if (ratingCount) ratingCount.textContent = '0';
                }
            }

            function updateReviewSummary(summary) {
                if (!summary) {
                    resetReviewSummary();
                    return;
                }

                const averageRating = parseFloat(summary.average_rating) || 0;
                document.getElementById('average-rating').textContent = averageRating.toFixed(1);

                const totalReviews = parseInt(summary.total_reviews) || 0;
                document.getElementById('total-reviews').textContent = totalReviews.toString();

                const ratingStars = document.querySelectorAll('.rating-stars i');
                const fullStars = Math.floor(averageRating);
                const hasHalfStar = averageRating % 1 >= 0.5;

                ratingStars.forEach((star, index) => {

                    // Reset classes first
                    star.className = '';

                    if (index < fullStars) {
                        star.className = 'fas fa-star';
                    } else if (index === fullStars && hasHalfStar) {
                        star.className = 'fas fa-star-half-alt';
                    } else {
                        star.className = 'far fa-star';
                    }
                });

                ratingStars.forEach(star => {
                    star.style.color = '#ffc107';
                });

                const ratingCounts = summary.rating_counts || {};

                for (let i = 5; i >= 1; i--) {
                    const count = parseInt(ratingCounts[i]) || 0;
                    const percentage = totalReviews > 0 ? (count / totalReviews) * 100 : 0;

                    const progressBar = document.querySelector(`.progress-bar[data-rating="${i}"]`);
                    const ratingCount = document.querySelector(`.rating-count[data-rating="${i}"]`);

                    if (progressBar) {
                        progressBar.style.width = `${percentage}%`;
                        progressBar.setAttribute('aria-valuenow', percentage);
                    }

                    if (ratingCount) {
                        ratingCount.textContent = count;
                    }
                }
            }

            function displayReviews(reviews) {
                if (!reviews || !Array.isArray(reviews) || reviews.length === 0) {
                    document.getElementById('reviews-container').innerHTML = `
                        <div class="alert alert-light border text-center py-4">
                            <i class="fas fa-star-half-alt text-warning fa-2x mb-3"></i>
                            <h5 class="mb-2">Chưa có đánh giá</h5>
                            <p class="text-muted mb-0">Chưa có đánh giá nào cho biến thể này. Hãy đặt hàng và là người đầu tiên đánh giá!</p>
                        </div>
                    `;
                    return;
                }

                let reviewsHtml = '<div class="reviews-list">';

                reviews.forEach(review => {

                    if (!review) return; // Skip if review is null or undefined


                    let starsHtml = '';
                    for (let i = 1; i <= 5; i++) {
                        if (i <= review.rating) {
                            starsHtml += '<i class="fas fa-star text-warning"></i>';
                        } else {
                            starsHtml += '<i class="far fa-star text-warning"></i>';
                        }
                    }

                    const reviewDate = review.created_at ? new Date(review.created_at) : new Date();
                    const formattedDate = reviewDate.toLocaleDateString('vi-VN', {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    });

                    const userName = review.user && review.user.name ? review.user.name : 'Người dùng ẩn danh';
                    const userAvatar = review.user && review.user.avatar ? review.user.avatar : '/images/default-avatar.png';

                    const reviewContent = review.review || 'Không có nội dung đánh giá';

                    let imagesHtml = '';
                    if (review.images && Array.isArray(review.images) && review.images.length > 0) {
                        imagesHtml += '<div class="review-images d-flex flex-wrap gap-2 mt-3 mb-2">';
                        review.images.forEach(image => {
                            if (image) {
                                imagesHtml += `
                                    <a href="${image}" target="_blank" class="review-image-link">
                                        <img src="${image}" alt="Review image" class="img-thumbnail" style="width: 80px; height: 80px; object-fit: cover;">
                                    </a>
                                `;
                            }
                        });
                        imagesHtml += '</div>';
                    }

                    let videoHtml = '';
                    if (review.video) {
                        videoHtml = `
                            <div class="review-video mt-3 mb-2">
                                <video controls class="rounded" style="max-width: 100%; max-height: 300px;">
                                    <source src="${review.video}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        `;
                    }

                    reviewsHtml += `
                        <div class="review-item card mb-4">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="review-avatar me-3">
                                            <img src="${userAvatar}" alt="${userName}" class="rounded-circle" width="50" height="50" style="object-fit: cover;">
                                        </div>
                                        <div>
                                            <h6 class="mb-1 fw-bold">${userName}</h6>
                                            <div class="review-rating">${starsHtml}</div>
                                            <div class="review-date text-muted small">${formattedDate}</div>
                                        </div>
                                    </div>
                                    <div class="review-badge">
                                        <span class="badge bg-success">Đã mua hàng</span>
                                    </div>
                                </div>

                            </div>


                                <div class="review-content mt-3">
                                    <p class="mb-2">${reviewContent}</p>
                                    ${imagesHtml}
                                    ${videoHtml}

                            </div>

                            ${review.responses && review.responses.length > 0 ? `

                                    <div class="review-responses mt-3 pt-3 border-top">
                                        <h6 class="mb-2 text-secondary"><i class="fas fa-reply me-2"></i>Phản hồi</h6>
                                        ${review.responses.map(response => {
                                            if (!response) return '';
                                            const responseDate = response.created_at ? new Date(response.created_at).toLocaleDateString('vi-VN') : '';
                                            const responseName = response.user && response.user.name ? response.user.name : 'Cửa hàng';
                                            return `
                                                <div class="review-response mb-2 p-3 bg-light rounded">
                                                    <div class="d-flex justify-content-between mb-2">
                                                        <div class="d-flex align-items-center">
                                                            <strong class="me-2">${responseName}</strong>
                                                            ${response.user && response.user.is_admin ? '<span class="badge bg-primary">Quản trị viên</span>' : ''}
                                                        </div>
                                                        <small class="text-muted">${responseDate}</small>
                                                    </div>
                                                    <div>${response.response || ''}</div>
                                                </div>
                                            `;
                                        }).join('')}
                                    </div>
                                ` : ''}
                            </div>
                        </div>
                    `;
                });

                reviewsHtml += '</div>';
                document.getElementById('reviews-container').innerHTML = reviewsHtml;
            }

            function updatePagination(pagination) {
                const paginationElement = document.getElementById('reviews-pagination');

                if (!pagination || pagination.total_pages <= 1) {
                    paginationElement.innerHTML = '';
                    return;
                }

                let paginationHtml = '';

                paginationHtml += `
                    <li class="page-item ${pagination.current_page === 1 ? 'disabled' : ''}">
                        <a class="page-link" href="#" data-page="${pagination.current_page - 1}" aria-label="Previous">
                            <span aria-hidden="true">«</span>
                        </a>
                    </li>
                `;

                for (let i = 1; i <= pagination.total_pages; i++) {
                    if (
                        i === 1 ||
                        i === pagination.total_pages ||
                        (i >= pagination.current_page - 2 && i <= pagination.current_page + 2)
                    ) {
                        paginationHtml += `
                            <li class="page-item ${i === pagination.current_page ? 'active' : ''}">
                                <a class="page-link" href="#" data-page="${i}">${i}</a>
                            </li>
                        `;
                    } else if (
                        i === pagination.current_page - 3 ||
                        i === pagination.current_page + 3
                    ) {
                        paginationHtml += `
                            <li class="page-item disabled">
                                <a class="page-link" href="#">...</a>
                            </li>
                        `;
                    }
                }

                paginationHtml += `
                    <li class="page-item ${pagination.current_page === pagination.total_pages ? 'disabled' : ''}">
                        <a class="page-link" href="#" data-page="${pagination.current_page + 1}" aria-label="Next">
                            <span aria-hidden="true">»</span>
                        </a>
                    </li>
                `;

                paginationElement.innerHTML = paginationHtml;

                document.querySelectorAll('#reviews-pagination .page-link').forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        const page = parseInt(this.getAttribute('data-page'));
                        if (page && page !== currentPage) {
                            currentPage = page;
                            const variantId = document.getElementById('variant-filter')?.value || defaultVariant?.id;
                            loadReviews(variantId, page);
                        }
                    });
                });
            }

            document.addEventListener('DOMContentLoaded', function() {

                // Automatically load reviews if a variant is pre-selected
                // This will be triggered by the selectAttribute function when a user selects a variant

                // Add tab switch handling for reviews tab to ensure correct display

                const reviewsTab = document.getElementById('reviews-tab');
                if (reviewsTab) {
                    reviewsTab.addEventListener('click', function() {
                        if (Object.keys(selectedAttributes).length === totalGroups) {
                            for (let key in variantData) {
                                let variantAttributes = JSON.parse(key);
                                let allMatched = Object.keys(selectedAttributes).every(attrName => {
                                    return variantAttributes[attrName] === selectedAttributes[attrName];
                                });
                                if (allMatched) {
                                    const variantId = variantData[key].id;
                                    loadReviews(variantId, currentPage);
                                    updateSelectedVariantInfo(variantId);
                                    break;
                                }
                            }
                        }
                    });
                }
            });
        });
        </script>
        <script>
            // Thêm hàm addToCart vào cuối file
            function addToCart(event) {
                event.preventDefault();

                // Kiểm tra xem đã chọn biến thể chưa
                const selectedAttributesInput = document.getElementById('selectedAttributes');
                if (!selectedAttributesInput.value) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Vui lòng chọn biến thể',
                        text: 'Bạn cần chọn đầy đủ thuộc tính sản phẩm trước khi thêm vào giỏ hàng',
                        confirmButtonText: 'Đã hiểu'
                    });
                    return;
                }

                // Lấy form data
                const form = document.getElementById('variantForm');
                const formData = new FormData(form);

                // Gửi request Ajax
                $.ajax({
                    url: form.action,
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            // Hiển thị thông báo thành công đơn giản
                            Swal.fire({
                                icon: 'success',
                                title: 'Thêm vào giỏ hàng thành công!',
                                text: 'Sản phẩm đã được thêm vào giỏ hàng của bạn',
                                confirmButtonText: 'Đã hiểu'
                            });

                            // Cập nhật số lượng giỏ hàng trong header
                            if (response.cartCount !== undefined) {
                                const cartCountElement = document.querySelector('.cart-count');
                                if (cartCountElement) {
                                    cartCountElement.textContent = response.cartCount;
                                }

                                // Sử dụng hàm toàn cục để cập nhật số lượng
                                if (typeof updateCartCount === 'function') {
                                    updateCartCount(response.cartCount);
                                }

                                // Tạo sự kiện cập nhật giỏ hàng để menu có thể lắng nghe
                                $(document).trigger('cartUpdated', { cartCount: response.cartCount });
                            }

                            // Cập nhật dropdown giỏ hàng
                            if (response.cartHtml) {
                                const cartDropdown = document.querySelector('.dropdown-menu[aria-labelledby="cartDropdown"]');
                                if (cartDropdown) {
                                    cartDropdown.innerHTML = response.cartHtml;
                                }
                            }
                        } else {
                            // Hiển thị thông báo lỗi
                            Swal.fire({
                                icon: 'error',
                                title: 'Có lỗi xảy ra!',
                                text: response.message || 'Không thể thêm sản phẩm vào giỏ hàng',
                                confirmButtonText: 'Đã hiểu'
                            });
                        }
                    },
                    error: function(xhr) {
                        // Xử lý lỗi
                        let errorMessage = 'Đã có lỗi xảy ra';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Có lỗi xảy ra!',
                            text: errorMessage,
                            confirmButtonText: 'Đã hiểu'
                        });
                    }
                });
            }

            // Thêm hàm để xử lý xóa sản phẩm khỏi giỏ hàng
            function removeFromCart(event, key) {
                event.preventDefault();
                const form = event.target.closest('form');

                $.ajax({
                    url: form.action,
                    method: 'POST',
                    data: new FormData(form),
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            // Cập nhật số lượng giỏ hàng trong header
                            if (response.cartCount !== undefined) {
                                const cartCountElement = document.querySelector('.cart-count');
                                if (cartCountElement) {
                                    cartCountElement.textContent = response.cartCount;
                                }

                                // Sử dụng hàm toàn cục để cập nhật số lượng
                                if (typeof updateCartCount === 'function') {
                                    updateCartCount(response.cartCount);
                                }

                                // Tạo sự kiện cập nhật giỏ hàng để menu có thể lắng nghe
                                $(document).trigger('cartUpdated', { cartCount: response.cartCount });
                            }

                            // Cập nhật dropdown giỏ hàng
                            if (response.cartHtml) {
                                const cartDropdown = document.querySelector('.dropdown-menu[aria-labelledby="cartDropdown"]');
                                if (cartDropdown) {
                                    cartDropdown.innerHTML = response.cartHtml;
                                }
                            }
                        }
                    }
                });
            }
        </script>
    </div>
</body>

@endsection
