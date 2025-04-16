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
            <section class="flat-single-product">
                <div class="tf-main-product section-image-zoom">
                    <div class="container">
                        <div class="row">
                            <!-- Product Images -->
                            <div class="col-md-6">
                                <div class="tf-product-media-wrap sticky-top">
                                    <div class="product-media-container d-flex">
                                        <!-- Thumbnail Slider (bên trái) -->
                                        <div class="thumbs-slider me-3">
                                            <div dir="ltr" class="swiper tf-product-media-thumbs other-image-zoom"
                                                data-preview="4" data-direction="vertical">
                                                <div class="swiper-wrapper stagger-wrap">
                                                    @foreach ($description_images as $key => $image)
                                                        <div class="swiper-slide stagger-item"
                                                            data-color="{{ $key == 0 ? 'black' : ($key == 1 ? 'yellow' : 'grey') }}"
                                                            data-size="small">
                                                            <div class="item">
                                                                <img class="lazyload thumb-image"
                                                                    data-src="{{ asset('storage/' . $image->image) }}"
                                                                    src="{{ asset('storage/' . $image->image) }}"
                                                                    alt="img-product">
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Main Slider (bên phải) -->
                                        <div class="flat-wrap-media-product flex-grow-1">
                                            <div dir="ltr" class="swiper tf-product-media-main"
                                                id="gallery-swiper-started">
                                                <div class="swiper-wrapper">
                                                    @foreach ($description_images as $key => $image)
                                                        <div class="swiper-slide"
                                                            data-color="{{ $key == 0 ? 'black' : ($key == 1 ? 'yellow' : 'grey') }}"
                                                            data-size="small">
                                                            <a href="{{ asset('storage/' . $image->image) }}"
                                                                target="_blank" class="item" data-pswp-width="552px"
                                                                data-pswp-height="827px">
                                                                <img class="tf-image-zoom lazyload main-image"
                                                                    data-zoom="{{ asset('storage/' . $image->image) }}"
                                                                    data-src="{{ asset('storage/' . $image->image) }}"
                                                                    src="{{ asset('storage/' . $image->image) }}"
                                                                    alt="img-product">
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
                                    document.addEventListener('DOMContentLoaded', function() {
                                        // Khởi tạo Swiper cho thumbnail
                                        const thumbsSwiper = new Swiper('.tf-product-media-thumbs', {
                                            direction: 'vertical',
                                            spaceBetween: 10,
                                            slidesPerView: 4,
                                            freeMode: true,
                                            watchSlidesProgress: true,
                                        });

                                        // Khởi tạo Swiper cho hình ảnh chính
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

                                        // Hiệu ứng zoom (nếu cần thêm thư viện zoom)
                                        // Ví dụ: Nếu dùng Drift Zoom hoặc một thư viện tương tự
                                        document.querySelectorAll('.tf-image-zoom').forEach(image => {
                                            // Thêm logic zoom nếu cần (có thể dùng Drift Zoom hoặc CSS)
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
                                                <span class="count-review">({{ $product->reviews->count() }} Đánh
                                                    giá)</span>
                                            </div>
                                            <div class="product-info-price">
                                                @php
                                                    $minPriceSale = $detailproduct->variants
                                                        ->where('price_sale', '>', 0)
                                                        ->min('price_sale');
                                                    $minPrice = $minPriceSale ?? $detailproduct->variants->min('price');
                                                    $maxPrice = $detailproduct->variants->max('price');
                                                @endphp
                                                <div class="display-sm price-new price-on-sale" id="product-sale-price">
                                                    {{ number_format($minPrice, 0, ',', '.') }} -
                                                    {{ number_format($maxPrice, 0, ',', '.') }}₫
                                                </div>
                                                <div class="display-sm price-old" id="product-original-price"
                                                    style="display: none;"></div>
                                                <span class="badge-sale" id="discount-badge" style="display: none;">Giảm
                                                    20%</span>
                                            </div>
                                            <div class="mb-4">
                                                <p class="text-dark font-weight-medium mb-0 mr-3">Thương hiệu :
                                                    <strong>{{ $brand->name }}</strong></p>
                                            </div>
                                            <div class="mb-4">
                                                <p class="text-dark font-weight-medium mb-0 mr-3">Loại sản phẩm :
                                                    <strong>{{ $category->name }}</strong></p>
                                            </div>
                                            <div class="product-info-progress-sale">
                                                <div class="title-hurry-up">
                                                    <span class="text-primary fw-medium"></span> Còn lại trong kho <span
                                                        class="count" id="product-stock"></span> sản phẩm!
                                                </div>
                                                <div class="progress-sold">
                                                    <div class="value" style="width: 0%;" data-progress="70"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Chọn biến thể sản phẩm -->
                                        <form id="variantForm" class="d-flex flex-column" method="POST"
                                            action="{{ route('cart.create', $detailproduct->id) }}">
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
                                                    ];
                                                }
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
                                                                <button type="button"
                                                                    class="btn btn-outline-dark m-1 variant-option"
                                                                    data-attribute="{{ $attrName }}"
                                                                    data-value="{{ $value }}"
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
                                                        <button type="button" class="btn-quantity btn-decrease"
                                                            onclick="decreaseQuantity()">-</button>
                                                        <input type="number" id="quantity" name="quantity"
                                                            value="1" class="quantity-product">
                                                        <button type="button" class="btn-quantity btn-increase"
                                                            onclick="increaseQuantity()">+</button>
                                                    </div>
                                                    <button type="submit"
                                                        class="tf-btn hover-primary btn-add-to-cart">Thêm vào giỏ</button>
                                                </div>

                                            </div>
                                        </form>

                                        <!-- Các hành động phụ -->
                                        <div class="tf-product-info-extra-link">
                                            <a href="javascript:void(0);"
                                                class="product-extra-icon link btn-add-wishlist">
                                                <i class="icon add icon-heart"></i><span class="add">Thêm vào yêu
                                                    thích</span>
                                            </a>
                                            <a href="#compare" data-bs-toggle="modal" class="product-extra-icon link">
                                                <i class="icon icon-compare2"></i>So sánh
                                            </a>
                                            <a href="#askQuestion" data-bs-toggle="modal"
                                                class="product-extra-icon link">
                                                <i class="icon icon-ask"></i>Đặt câu hỏi
                                            </a>
                                            <a href="#shareSocial" data-bs-toggle="modal"
                                                class="product-extra-icon link">
                                                <i class="icon icon-share"></i>Chia sẻ
                                            </a>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- /Product Main -->
            <!-- Product Description -->
            <section class="flat-spacing pt-0">
                <div class="container">
                    <div class="widget-accordion wd-product-descriptions">
                        <div class="accordion-title collapsed" data-bs-target="#description" data-bs-toggle="collapse"
                            aria-expanded="true" aria-controls="description" role="button">
                            <span>Mô tả chi tiết</span>
                            <span class="icon icon-arrow-down"></span>
                        </div>
                        <div id="description" class="collapse">
                            <div class="accordion-body widget-desc">
                                <p>{!! $detailproduct->description !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- /Product Description -->

        </div>
    </body>


    <!-- JavaScript để xử lý chọn thuộc tính -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let selectedAttributes = {};
            let defaultMinPrice = {{ $detailproduct->variants->min('price') ?? 0 }};
            let defaultMaxPrice = {{ $detailproduct->variants->max('price') ?? 0 }};
            const variantButtons = document.querySelectorAll('.variant-option');
            const totalGroups = document.querySelectorAll('.variant-group').length;
            const variantData = @json($variantData);

            // Biến để kiểm soát trạng thái nhấn nút (tránh lặp sự kiện)
            let isProcessing = false;

            function setDefaultPrice() {
                let salePriceEl = document.getElementById("product-sale-price");
                let originalPriceEl = document.getElementById("product-original-price");
                let stockWrapper = document.getElementById("product-stock");

                originalPriceEl.style.display = "none";
                salePriceEl.innerText = new Intl.NumberFormat('vi-VN').format(defaultMinPrice) + " - " + new Intl
                    .NumberFormat('vi-VN').format(defaultMaxPrice) + "₫";
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
                console.log("updateProductInfo - Stock:", stock, "Quantity before adjustment:", quantityInput
                .value);

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

            setDefaultPrice();

            // Khởi tạo: Đảm bảo quantity không vượt quá stock ban đầu
            const initialStock = parseInt(document.getElementById('selectedStock').value) || 0;
            const quantityInput = document.getElementById('quantity');
            console.log("Initial - Stock:", initialStock, "Quantity:", quantityInput.value);
            if (parseInt(quantityInput.value) > initialStock) {
                quantityInput.value = initialStock;
                console.log("Adjusted Initial Quantity to Stock:", initialStock);
            }

            window.selectAttribute = function(button) {
                let attrName = button.getAttribute('data-attribute');
                let attrValue = button.getAttribute('data-value');

                let groupButtons = button.closest('.variant-group').querySelectorAll('.variant-option');
                groupButtons.forEach(btn => btn.classList.remove('active'));

                button.classList.add('active');
                selectedAttributes[attrName] = attrValue;
                document.getElementById('selectedAttributes').value = JSON.stringify(selectedAttributes);

                findMatchingVariant();
            };

            window.increaseQuantity = function() {
                // Ngăn gọi hàm nếu đang xử lý
                if (isProcessing) return;
                isProcessing = true;

                const quantityInput = document.getElementById('quantity');
                const stock = parseInt(document.getElementById('selectedStock').value) || 0;
                let currentValue = parseInt(quantityInput.value) || 1;

                console.log("increaseQuantity - Stock:", stock, "Quantity before increase:", currentValue);

                if (currentValue < stock) {
                    quantityInput.value = currentValue; // Chỉ tăng 1 đơn vị
                    console.log("Increased Quantity to:", quantityInput.value);
                } else {
                    quantityInput.value = stock;
                    console.log("Quantity set to Stock (max):", stock);
                }

                validateQuantity();

                // Đặt lại trạng thái sau khi xử lý
                setTimeout(() => {
                    isProcessing = false;
                }, 100);
            };

            window.decreaseQuantity = function() {
                // Ngăn gọi hàm nếu đang xử lý
                if (isProcessing) return;
                isProcessing = true;

                const quantityInput = document.getElementById('quantity');
                let currentValue = parseInt(quantityInput.value) || 1;

                console.log("decreaseQuantity - Quantity before decrease:", currentValue);

                if (currentValue > 1) {
                    quantityInput.value = currentValue; // Chỉ giảm 1 đơn vị
                    console.log("Decreased Quantity to:", quantityInput.value);
                }

                validateQuantity();

                // Đặt lại trạng thái sau khi xử lý
                setTimeout(() => {
                    isProcessing = false;
                }, 100);
            };

            document.getElementById('quantity').addEventListener('input', function(e) {
                const quantityInput = this;
                const stock = parseInt(document.getElementById('selectedStock').value) || 0;
                let value = parseInt(quantityInput.value);

                console.log("input event - Stock:", stock, "Input Quantity:", value);

                if (isNaN(value) || value < 1) {
                    quantityInput.value = 1;
                    console.log("Adjusted Quantity to 1 (min)");
                } else if (value > stock) {
                    quantityInput.value = stock;
                    console.log("Adjusted Quantity to Stock (max):", stock);
                }
                validateQuantity();
            });
        });
    </script>


@endsection
