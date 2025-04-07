@extends('web3.layout.master2')
@section('content')

<body>
    <div id="wrapper">
        <!-- Breadcrumb -->
        <div class="tf-breadcrumb mb-0">
            <div class="container">
                <ul class="breadcrumb-list">
                    <li class="item-breadcrumb">
                        <a href="index-2.html" class="text">Home</a>
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
                                <div class="thumbs-slider">
                                    <div dir="ltr" class="swiper tf-product-media-thumbs other-image-zoom"
                                        data-preview="4" data-direction="vertical">
                                        <div class="swiper-wrapper stagger-wrap">
                                            <!-- black -->
                                            <div class="swiper-slide stagger-item" data-color="black" data-size="small">
                                                <div class="item">
                                                    <img class="lazyload"
                                                        data-src="images/products/fashion/women-black-1.jpg"
                                                        src="images/products/fashion/women-black-1.jpg"
                                                        alt="img-product">
                                                </div>
                                            </div>
                                            <div class="swiper-slide stagger-item" data-color="black"
                                                data-size="medium">
                                                <div class="item">
                                                    <img class="lazyload"
                                                        data-src="images/products/fashion/women-black-2.jpg"
                                                        src="images/products/fashion/women-black-2.jpg"
                                                        alt="img-product">
                                                </div>
                                            </div>
                                            <div class="swiper-slide stagger-item" data-color="black" data-size="large">
                                                <div class="item">
                                                    <img class="lazyload"
                                                        data-src="images/products/fashion/women-black-3.jpg"
                                                        src="images/products/fashion/women-black-3.jpg"
                                                        alt="img-product">
                                                </div>
                                            </div>
                                            <div class="swiper-slide stagger-item" data-color="black"
                                                data-size="extra large">
                                                <div class="item">
                                                    <img class="lazyload"
                                                        data-src="images/products/fashion/women-black-4.jpg"
                                                        src="images/products/fashion/women-black-4.jpg"
                                                        alt="img-product">
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                    <div class="flat-wrap-media-product">
                                        <div dir="ltr" class="swiper tf-product-media-main" id="gallery-swiper-started">
                                            <div class="swiper-wrapper">
                                                <!-- black -->
                                                <div class="swiper-slide" data-color="black" data-size="small">
                                                    <a href="images/products/fashion/women-black-1.jpg" target="_blank"
                                                        class="item" data-pswp-width="552px" data-pswp-height="827px">
                                                        <img class="tf-image-zoom lazyload"
                                                            data-zoom="images/products/fashion/women-black-1.jpg"
                                                            data-src="images/products/fashion/women-black-1.jpg"
                                                            src="images/products/fashion/women-black-1.jpg"
                                                            alt="img-product">
                                                    </a>
                                                </div>
                                                <div class="swiper-slide" data-color="black" data-size="medium">
                                                    <a href="images/products/fashion/women-black-2.jpg" target="_blank"
                                                        class="item" data-pswp-width="552px" data-pswp-height="827px">
                                                        <img class="tf-image-zoom lazyload"
                                                            data-zoom="images/products/fashion/women-black-2.jpg"
                                                            data-src="images/products/fashion/women-black-2.jpg"
                                                            src="images/products/fashion/women-black-2.jpg"
                                                            alt="img-product">
                                                    </a>
                                                </div>
                                                <div class="swiper-slide" data-color="black" data-size="large">
                                                    <a href="images/products/fashion/women-black-3.jpg" target="_blank"
                                                        class="item" data-pswp-width="552px" data-pswp-height="827px">
                                                        <img class="tf-image-zoom lazyload"
                                                            data-zoom="images/products/fashion/women-black-3.jpg"
                                                            data-src="images/products/fashion/women-black-3.jpg"
                                                            src="images/products/fashion/women-black-3.jpg"
                                                            alt="img-product">
                                                    </a>
                                                </div>
                                                <div class="swiper-slide" data-color="black" data-size="extra large">
                                                    <a href="images/products/fashion/women-black-4.jpg" target="_blank"
                                                        class="item" data-pswp-width="552px" data-pswp-height="827px">
                                                        <img class="tf-image-zoom lazyload"
                                                            data-zoom="images/products/fashion/women-black-4.jpg"
                                                            data-src="images/products/fashion/women-black-4.jpg"
                                                            src="images/products/fashion/women-black-4.jpg"
                                                            alt="img-product">
                                                    </a>
                                                </div>
                                                <!-- yellow -->
                                            </div>
                                        </div>
                                        <div class="swiper-button-next nav-swiper thumbs-next"></div>
                                        <div class="swiper-button-prev nav-swiper thumbs-prev"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Product Images -->
                        <!-- Product Info -->
                        <div class="col-md-6">
                            <div class="tf-product-info-wrap position-relative">
                                <div class="tf-zoom-main"></div>
                                <div class="tf-product-info-list other-image-zoom">
                                    <!-- Thông tin chính sản phẩm -->
                                    <div class="tf-product-info-heading">
                                        <h5 class="product-info-name fw-medium">Quần Linen pha</h5>
                                        <div class="product-info-rate">
                                            <div class="list-star">
                                                <i class="icon icon-star"></i>
                                                <i class="icon icon-star"></i>
                                                <i class="icon icon-star"></i>
                                                <i class="icon icon-star"></i>
                                                <i class="icon icon-star"></i>
                                            </div>
                                            <span class="count-review">(Chưa có đánh giá)</span>
                                        </div>
                                        <!-- tes thử làm giống bên web2 nhưng vẫn phải giữ class của web3 -->
                                        <div class="product-info-price">
                                            @php
                                            $minPriceSale = $detailproduct->variants->where('price_sale', '>',
                                            0)->min('price_sale');
                                            $minPrice = $minPriceSale ?? $detailproduct->variants->min('price');
                                            $maxPrice = $detailproduct->variants->max('price');
                                            $hasSale = $minPriceSale !== null;
                                            $discountPercent = $hasSale ? round((($detailproduct->variants->max('price')
                                            - $minPriceSale) / $detailproduct->variants->max('price')) * 100) : 0;
                                            @endphp
                                            <div class="display-sm price-new {{ $hasSale ? 'price-on-sale' : '' }}">
                                                {{ number_format($minPrice, 0, ',', '.') }}₫
                                                @if($minPrice != $maxPrice)
                                                - {{ number_format($maxPrice, 0, ',', '.') }}₫
                                                @endif
                                            </div>
                                            @if($hasSale)
                                            <div class="display-sm price-old">
                                                {{ number_format($detailproduct->variants->max('price'), 0, ',', '.') }}₫
                                            </div>
                                            <span class="badge-sale">Giảm {{ $discountPercent }}%</span>
                                            @endif
                                        </div>


                                    </div>

                                    <!-- Chọn biến thể sản phẩm -->
                                    <div class="tf-product-info-variant">
                                        <div class="variant-picker-item variant-color">
                                            <div class="variant-picker-label">
                                                Thương hiệu:
                                                <span class="variant-picker-label-value value-currentColor">Đen</span>
                                            </div>

                                        </div>
                                        <div class="variant-picker-item variant-color">
                                            <div class="variant-picker-label">
                                                Loại sản phẩm:
                                                <span class="variant-picker-label-value value-currentColor">Đen</span>
                                            </div>

                                        </div>
                                        <div class="variant-picker-item variant-color">
                                            <div class="variant-picker-label">
                                                Tồn kho:
                                                <span class="variant-picker-label-value value-currentColor">Đen</span>
                                            </div>

                                        </div>

                                        <div class="variant-picker-item variant-size">
                                            <div class="variant-picker-label">
                                                Thể tích:
                                                <span class="variant-picker-label-value value-currentSize">Nhỏ</span>
                                                <a href="#sizeGuide" data-bs-toggle="modal" class="size-guide link">Bảng
                                                    kích thước</a>
                                            </div>
                                            <div class="variant-picker-values">
                                                <span class="size-btn active" data-size="small">S</span>
                                                <span class="size-btn" data-size="medium">M</span>
                                                <span class="size-btn" data-size="large">L</span>
                                                <span class="size-btn" data-size="extra large">XL</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Số lượng và nút hành động -->
                                    <div class="tf-product-total-quantity">
                                        <div class="group-btn">
                                            <div class="wg-quantity">
                                                <button class="btn-quantity btn-decrease">-</button>
                                                <input class="quantity-product" type="text" name="number" value="1">
                                                <button class="btn-quantity btn-increase">+</button>
                                            </div>
                                            <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                                class="tf-btn hover-primary btn-add-to-cart">Thêm vào giỏ</a>
                                        </div>
                                        <a href="#" class="tf-btn btn-primary w-100 animate-btn">Mua ngay</a>
                                        <a href="checkout.html" class="more-choose-payment link">Xem thêm phương
                                            thức
                                            thanh toán</a>
                                    </div>

                                    <!-- Các hành động phụ: yêu thích, so sánh, hỏi đáp, chia sẻ -->
                                    <!-- <div class="tf-product-info-extra-link">
                                        <a href="javascript:void(0);" class="product-extra-icon link btn-add-wishlist">
                                            <i class="icon add icon-heart"></i><span class="add">Thêm vào yêu
                                                thích</span>
                                            <i class="icon added icon-trash"></i><span class="added">Xóa khỏi yêu
                                                thích</span>
                                        </a>
                                        <a href="#compare" data-bs-toggle="modal" class="product-extra-icon link">
                                            <i class="icon icon-compare2"></i>So sánh
                                        </a>
                                        <a href="#askQuestion" data-bs-toggle="modal" class="product-extra-icon link">
                                            <i class="icon icon-ask"></i>Đặt câu hỏi
                                        </a>
                                        <a href="#shareSocial" data-bs-toggle="modal" class="product-extra-icon link">
                                            <i class="icon icon-share"></i>Chia sẻ
                                        </a>
                                    </div> -->

                                    <!-- Các biểu tượng thanh toán bảo mật -->


                                    <!-- Giao hàng & trả hàng -->

                                </div>
                            </div>
                        </div>

                        <!-- Sản phẩm thường được mua kèm -->
                        <div class="product-bought-together">
                            <h6 class="title">Thường được mua cùng nhau</h6>
                            <div class="bought-together-list">
                                <!-- Danh sách sản phẩm mua kèm -->
                                <!-- Mỗi sản phẩm sẽ được lặp lại dưới đây -->
                                <!-- Ví dụ: -->
                                <div class="bought-together-item">
                                    <img src="images/product/product2.jpg" alt="Sản phẩm kèm">
                                    <p class="product-name">Áo sơ mi trắng</p>
                                    <p class="product-price">$40.00</p>
                                    <input type="checkbox" checked> Chọn
                                </div>
                                <!-- ... -->
                            </div>
                            <div class="bought-together-total">
                                <p>Tổng cộng: <span class="fw-bold">$170.00</span></p>
                                <a href="#" class="tf-btn btn-primary">Thêm tất cả vào giỏ</a>
                            </div>
                        </div>

                        <!-- /Product Info -->

                    </div>
                </div>
            </div>
            <div class="tf-sticky-btn-atc">
                <div class="container">
                    <div class="tf-height-observer w-100 d-flex align-items-center">
                        <!-- Sản phẩm hiển thị thu gọn bên trái -->
                        <div class="tf-sticky-atc-product d-flex align-items-center">
                            <div class="tf-sticky-atc-img">
                                <img class="lazyload" data-src="images/products/fashion/women-black-1.jpg" alt=""
                                    src="images/products/fashion/women-black-1.jpg">
                            </div>
                            <div class="tf-sticky-atc-title fw-5 d-xl-block d-none">Áo thun tay dài</div>
                        </div>

                        <!-- Thông tin chọn biến thể và số lượng bên phải -->
                        <div class="tf-sticky-atc-infos">
                            <form>
                                <!-- Chọn màu / size / giá -->
                                <div class="tf-sticky-atc-variant-price text-center tf-select">
                                    <select>
                                        <option selected="selected">Đen / Nhỏ - $130.00</option>
                                        <option>Đen / Trung bình - $130.00</option>
                                        <option>Đen / Lớn - $130.00</option>
                                        <option>Xanh / Nhỏ - $130.00</option>
                                        <option>Xanh / Trung bình - $130.00</option>
                                        <option>Xanh / Lớn - $130.00</option>
                                        <option>Xanh / Rộng - $130.00</option>
                                        <option>Trắng / Nhỏ - $130.00</option>
                                        <option>Trắng / Trung bình - $130.00</option>
                                        <option>Trắng / Lớn - $130.00</option>
                                    </select>
                                </div>

                                <!-- Số lượng và nút thêm vào giỏ -->
                                <div class="tf-sticky-atc-btns">
                                    <div class="tf-product-info-quantity">
                                        <div class="wg-quantity">
                                            <button class="btn-quantity minus-btn">-</button>
                                            <input class="quantity-product font-4" type="text" name="number" value="1">
                                            <button class="btn-quantity plus-btn">+</button>
                                        </div>
                                    </div>
                                    <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                        class="tf-btn animate-btn d-inline-flex justify-content-center">
                                        Thêm vào giỏ
                                    </a>
                                </div>
                            </form>
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
                        <span>Mô tả</span>
                        <span class="icon icon-arrow-down"></span>
                    </div>
                    <div id="description" class="collapse">
                        <div class="accordion-body widget-desc">
                            <div class="item">
                                <p class="fw-medium title">Composition</p>
                                <ul>
                                    <li>Viscose 55%, Linen 45%</li>
                                    <li>We exclude the weight of minor components</li>
                                </ul>
                            </div>
                            <p class="item">Additional material information</p>
                            <div class="item">
                                <p class="title">The total weight of this product contains:</p>
                                <ul>
                                    <li>55% LivaEco™ viscose</li>
                                    <li>Viscose 55%</li>
                                </ul>
                            </div>
                            <ul class="item">
                                <li>We exclude the weight of minor components such as, but not exclusively: threads,
                                    buttons, zippers, embellishments and prints.</li>
                                <li>The total weight of the product is calculated by adding the weight of all layers and
                                    main components together. Based on that, we calculate how much of that weight is
                                    made out by each material. For sets & multipacks all pieces are counted together as
                                    one product in calculations.</li>
                                <li>Materials in this product explained</li>
                                <li>LinenLinen is a natural bast fibre derived from flax plants.</li>
                                <li>LivaEco™ viscoseLivaEco™ viscose is a branded viscose fibre, made from wood pulp.
                                </li>
                                <li> ViscoseViscose is a regenerated cellulose fibre commonly made from wood, but the
                                    raw material could also consist of other cellulosic materials.</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="widget-accordion wd-product-descriptions">
                    <div class="accordion-title collapsed" data-bs-target="#material" data-bs-toggle="collapse"
                        aria-expanded="true" aria-controls="material" role="button">
                        <span>Bình luận</span>
                        <span class="icon icon-arrow-down"></span>
                    </div>
                    <div id="material" class="collapse">
                        <div class="accordion-body widget-material">
                            <div class="item">
                                <p class="fw-medium title">Materials Care</p>
                                <ul>
                                    <li>Content: 100% LENZING™ ECOVERO™ Viscose</li>
                                    <li>Care: Hand wash</li>
                                    <li>Imported</li>
                                    <li>Machine wash max. 30ºC. Short spin.</li>
                                    <li>Iron maximum 110ºC.</li>
                                    <li>Do not bleach/bleach.</li>
                                    <li>Do not dry clean.</li>
                                    <li>Tumble dry, medium hear.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
        <!-- /Product Description -->
        <!-- People Also Bought -->
        <section>
            <div class="container">
                <div class="flat-title wow fadeInUp">
                    <h4 class="title">Sản phẩm liên quan</h4>
                </div>
                <div class="hover-sw-nav  wow fadeInUp">
                    <div dir="ltr" class="swiper tf-swiper wrap-sw-over" data-swiper='{
                        "slidesPerView": 2,
                        "spaceBetween": 12,
                        "speed": 800,
                        "observer": true,
                        "observeParents": true,
                        "slidesPerGroup": 2,
                        "navigation": {
                            "clickable": true,
                            "nextEl": ".nav-next-bought",
                            "prevEl": ".nav-prev-bought"
                        },
                        "pagination": { "el": ".sw-pagination-bought", "clickable": true },
                        "breakpoints": {
                        "768": { "slidesPerView": 3, "spaceBetween": 12, "slidesPerGroup": 3 },
                        "1200": { "slidesPerView": 4, "spaceBetween": 24, "slidesPerGroup": 4}
                        }
                    }'>
                        <div class="swiper-wrapper">
                            <!-- item 1 -->
                            <div class="swiper-slide">
                                <div class="card-product style-2 card-product-size">
                                    <div class="card-product-wrapper">
                                        <a href="product-detail.html" class="product-img">
                                            <img class="img-product lazyload"
                                                data-src="images/products/fashion/product-10.jpg"
                                                src="images/products/fashion/product-10.jpg" alt="image-product">
                                            <img class="img-hover lazyload"
                                                data-src="images/products/fashion/product-20.jpg"
                                                src="images/products/fashion/product-20.jpg" alt="image-product">
                                        </a>
                                        <ul class="list-product-btn">
                                            <li>
                                                <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                                    class="box-icon hover-tooltip">
                                                    <span class="icon icon-cart2"></span>
                                                    <span class="tooltip">Add to Cart</span>
                                                </a>
                                            </li>
                                            <li class="wishlist">
                                                <a href="javascript:void(0);" class="box-icon hover-tooltip">
                                                    <span class="icon icon-heart2"></span>
                                                    <span class="tooltip">Add to Wishlist</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#quickView" data-bs-toggle="modal"
                                                    class="box-icon quickview hover-tooltip">
                                                    <span class="icon icon-view"></span>
                                                    <span class="tooltip">Quick View</span>
                                                </a>
                                            </li>
                                            <li class="compare">
                                                <a href="#compare" data-bs-toggle="modal" aria-controls="compare"
                                                    class="box-icon hover-tooltip">
                                                    <span class="icon icon-compare"></span>
                                                    <span class="tooltip">Add to Compare</span>
                                                </a>
                                            </li>
                                        </ul>
                                        <ul class="size-box">
                                            <li class="size-item text-xs text-white">XS</li>
                                            <li class="size-item text-xs text-white">S</li>
                                            <li class="size-item text-xs text-white">M</li>
                                            <li class="size-item text-xs text-white">L</li>
                                            <li class="size-item text-xs text-white">XL</li>
                                            <li class="size-item text-xs text-white">2XL</li>
                                        </ul>
                                        <div class="on-sale-wrap flex-column">
                                            <span class="on-sale-item">20% Off</span>
                                            <span class="on-sale-item trending">Trending</span>
                                        </div>
                                    </div>
                                    <div class="card-product-info">
                                        <a href="product-detail.html" class="name-product link fw-medium text-md">Loose
                                            Fit Tee</a>
                                        <p class="price-wrap fw-medium">
                                            <span class="price-new text-primary">$230.00</span>
                                            <span class=" price-old">$249.00</span>
                                        </p>
                                        <ul class="list-color-product">
                                            <li class="list-color-item color-swatch hover-tooltip tooltip-bot active">
                                                <span class="tooltip color-filter">Blue</span>
                                                <span class="swatch-value bg-light-blue-2"></span>
                                                <img class=" lazyload" data-src="images/products/fashion/product-10.jpg"
                                                    src="images/products/fashion/product-10.jpg" alt="image-product">
                                            </li>
                                            <li class="list-color-item color-swatch hover-tooltip line tooltip-bot">
                                                <span class="tooltip color-filter">White</span>
                                                <span class="swatch-value bg-white"></span>
                                                <img class=" lazyload" data-src="images/products/fashion/product-4.jpg"
                                                    src="images/products/fashion/product-4.jpg" alt="image-product">
                                            </li>
                                            <li class="list-color-item color-swatch hover-tooltip tooltip-bot">
                                                <span class="tooltip color-filter">Pink</span>
                                                <span class="swatch-value bg-light-pink-9"></span>
                                                <img class=" lazyload" data-src="images/products/fashion/product-30.jpg"
                                                    src="images/products/fashion/product-30.jpg" alt="image-product">
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="d-flex d-xl-none sw-dot-default sw-pagination-bought justify-content-center"></div>
                    </div>
                    <div class="d-none d-xl-flex swiper-button-next nav-swiper nav-next-bought"></div>
                    <div class="d-none d-xl-flex swiper-button-prev nav-swiper nav-prev-bought"></div>
                </div>
            </div>
        </section>
        <!-- People Also Bought -->
        <!-- Recently Viewed -->
        <section class="flat-spacing">
            <div class="container">
                <div class="flat-title wow fadeInUp">
                    <h4 class="title">Đã xem gần đây</h4>
                </div>
                <div class="hover-sw-nav  wow fadeInUp">
                    <div dir="ltr" class="swiper tf-swiper wrap-sw-over" data-swiper='{
                        "slidesPerView": 2,
                        "spaceBetween": 12,
                        "speed": 800,
                        "observer": true,
                        "observeParents": true,
                        "slidesPerGroup": 2,
                        "navigation": {
                            "clickable": true,
                            "nextEl": ".nav-next-viewed",
                            "prevEl": ".nav-prev-viewed"
                        },
                        "pagination": { "el": ".sw-pagination-viewed", "clickable": true },
                        "breakpoints": {
                        "768": { "slidesPerView": 3, "spaceBetween": 12, "slidesPerGroup": 3 },
                        "1200": { "slidesPerView": 4, "spaceBetween": 24, "slidesPerGroup": 4}
                        }
                    }'>
                        <div class="swiper-wrapper">
                            <!-- item 1 -->
                            <div class="swiper-slide">
                                <div class="card-product style-2 card-product-size">
                                    <div class="card-product-wrapper">
                                        <a href="product-detail.html" class="product-img">
                                            <img class="img-product lazyload"
                                                data-src="images/products/fashion/product-5.jpg"
                                                src="images/products/fashion/product-5.jpg" alt="image-product">
                                            <img class="img-hover lazyload"
                                                data-src="images/products/fashion/product-20.jpg"
                                                src="images/products/fashion/product-20.jpg" alt="image-product">
                                        </a>
                                        <ul class="list-product-btn">
                                            <li>
                                                <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                                    class="box-icon hover-tooltip">
                                                    <span class="icon icon-cart2"></span>
                                                    <span class="tooltip">Add to Cart</span>
                                                </a>
                                            </li>
                                            <li class="wishlist">
                                                <a href="javascript:void(0);" class="box-icon hover-tooltip">
                                                    <span class="icon icon-heart2"></span>
                                                    <span class="tooltip">Add to Wishlist</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#quickView" data-bs-toggle="modal"
                                                    class="box-icon quickview hover-tooltip">
                                                    <span class="icon icon-view"></span>
                                                    <span class="tooltip">Quick View</span>
                                                </a>
                                            </li>
                                            <li class="compare">
                                                <a href="#compare" data-bs-toggle="modal" aria-controls="compare"
                                                    class="box-icon hover-tooltip">
                                                    <span class="icon icon-compare"></span>
                                                    <span class="tooltip">Add to Compare</span>
                                                </a>
                                            </li>
                                        </ul>
                                        <ul class="size-box">
                                            <li class="size-item text-xs text-white">XS</li>
                                            <li class="size-item text-xs text-white">S</li>
                                            <li class="size-item text-xs text-white">M</li>
                                            <li class="size-item text-xs text-white">L</li>
                                            <li class="size-item text-xs text-white">XL</li>
                                            <li class="size-item text-xs text-white">2XL</li>
                                        </ul>
                                        <div class="on-sale-wrap">
                                            <span class="on-sale-item">20% Off</span>
                                        </div>
                                    </div>
                                    <div class="card-product-info">
                                        <a href="product-detail.html"
                                            class="name-product link fw-medium text-md">Turtleneck T-shirt</a>
                                        <p class="price-wrap fw-medium">
                                            <span class="price-new text-primary">$130.00</span>
                                            <span class=" price-old">$150.00</span>
                                        </p>
                                        <ul class="list-color-product">
                                            <li class="list-color-item color-swatch hover-tooltip tooltip-bot active">
                                                <span class="tooltip color-filter">Grey</span>
                                                <span class="swatch-value bg-grey-4"></span>
                                                <img class=" lazyload" data-src="images/products/fashion/product-5.jpg"
                                                    src="images/products/fashion/product-5.jpg" alt="image-product">
                                            </li>
                                            <li class="list-color-item color-swatch hover-tooltip tooltip-bot">
                                                <span class="tooltip color-filter">Black</span>
                                                <span class="swatch-value bg-dark"></span>
                                                <img class=" lazyload" data-src="images/products/fashion/product-22.jpg"
                                                    src="images/products/fashion/product-22.jpg" alt="image-product">
                                            </li>
                                            <li class="list-color-item color-swatch hover-tooltip tooltip-bot">
                                                <span class="tooltip color-filter">Orange</span>
                                                <span class="swatch-value bg-light-orange"></span>
                                                <img class=" lazyload" data-src="images/products/fashion/product-18.jpg"
                                                    src="images/products/fashion/product-18.jpg" alt="image-product">
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- item 2 -->

                        </div>
                        <div class="d-flex d-xl-none sw-dot-default sw-pagination-viewed justify-content-center"></div>
                    </div>
                    <div class="d-none d-xl-flex swiper-button-next nav-swiper nav-next-viewed"></div>
                    <div class="d-none d-xl-flex swiper-button-prev nav-swiper nav-prev-viewed"></div>
                </div>
            </div>
        </section>
    </div>
</body>

@endsection