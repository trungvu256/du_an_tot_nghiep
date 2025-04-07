@extends('web3.layout.master')
@section('content')

<body>


    <div id="wrapper">
        <!-- Slider -->
        <section class="tf-slideshow slider-sportwear slider-default">
            <div class="swiper tf-sw-slideshow slider-effect-fade" data-preview="1" data-tablet="1" data-mobile="1"
                data-centered="false" data-space="0" data-space-mb="0" data-loop="true" data-auto-play="true"
                data-effect="fade">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="slider-wrap">
                            <div class="image">
                                <img src="{{ asset('/images/Banner/slider_1.jpg') }}"
                                    data-src="{{ asset('/images/Banner/slider_1.jpg') }}" alt="slider" class="lazyload">
                            </div>
                            <div class="box-content">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-xxl-4 col-md-6 col-12">
                                            <div class="content-slider">
                                                <div class="box-title-slider">
                                                    <h2
                                                        class="heading display-xl text-white fw-medium fade-item fade-item-1">
                                                        Khơi Dậy Mọi Giác Quan
                                                    </h2>
                                                    <p class="sub text-md text-white fade-item fade-item-2">
                                                        Khám phá các dòng nước hoa cao cấp, tinh tế và quyến rũ cho mọi
                                                        phong cách và dịp đặc biệt.
                                                    </p>
                                                </div>
                                                <div class="box-btn-slider fade-item fade-item-3">
                                                    <a href="shop-default.html" class="tf-btn btn-white hover-primary">
                                                        Khám Phá Bộ Sưu Tập
                                                        <i class="icon icon-arr-right"></i>
                                                    </a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="slider-wrap ">
                            <div class="image">
                                <img src="{{ asset('/images/Banner/slider_2.jpg') }}"
                                    data-src="{{ asset('/images/Banner/slider_2.jpg') }}" alt="slider" class="lazyload">
                            </div>
                            <div class="box-content">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-xxl-4 col-md-6 col-12">
                                            <div class="content-slider">
                                                <div class="box-title-slider">
                                                    <h2
                                                        class="heading display-xl text-white fw-medium fade-item fade-item-1">
                                                        Khơi Dậy Mọi Giác Quan
                                                    </h2>
                                                    <p class="sub text-md text-white fade-item fade-item-2">
                                                        Khám phá các dòng nước hoa cao cấp, tinh tế và quyến rũ cho mọi
                                                        phong cách và dịp đặc biệt.
                                                    </p>
                                                </div>
                                                <div class="box-btn-slider fade-item fade-item-3">
                                                    <a href="shop-default.html" class="tf-btn btn-white hover-primary">
                                                        Khám Phá Bộ Sưu Tập
                                                        <i class="icon icon-arr-right"></i>
                                                    </a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="wrap-pagination">
                    <div class="container">
                        <div class="sw-dots style-white border-red sw-pagination-slider justify-content-center"></div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /Slider -->
        <!-- Icon box -->
        <div class="flat-spacing-4 pb-0">
            <div class="container">
                <div dir="ltr" class="swiper tf-swiper" data-swiper='{
                "slidesPerView": 1,
                "spaceBetween": 10,
                "speed": 800,
                "observer": true,
                "observeParents": true,
                "slidesPerGroup": 1,
                "pagination": { "el": ".sw-pagination-iconbox", "clickable": true },
                "breakpoints": {
                    "575": { "slidesPerView":2, "spaceBetween": 12}, 
                    "991": { "slidesPerView": 3, "spaceBetween": 24}
                }
            }'>
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="tf-icon-box style-lg wow fadeInLeft">
                                <svg width="65" height="64" viewBox="0 0 65 64" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M52.4944 21.674C52.4839 21.4218 52.4098 21.1763 52.279 20.9605C52.1482 20.7446 51.9649 20.5653 51.7461 20.4393L33.2492 9.75421C33.0217 9.62286 32.7636 9.55371 32.5009 9.55371C32.2382 9.55371 31.9802 9.62286 31.7527 9.75421L13.2483 20.4393C13.021 20.5705 12.8322 20.7592 12.7009 20.9864C12.5695 21.2136 12.5003 21.4714 12.5 21.7338V42.266C12.5003 42.5285 12.5695 42.7862 12.7009 43.0134C12.8322 43.2406 13.021 43.4293 13.2483 43.5605L31.7527 54.2456C31.9802 54.377 32.2382 54.4461 32.5009 54.4461C32.7636 54.4461 33.0217 54.377 33.2492 54.2456L51.7536 43.5605C51.9809 43.4293 52.1697 43.2406 52.301 43.0134C52.4323 42.7862 52.5016 42.5285 52.5019 42.266V21.7338C52.5019 21.7338 52.4944 21.6964 52.4944 21.674ZM32.5009 12.7772L48.0123 21.7563L32.5009 30.6905L16.9895 21.7114L32.5009 12.7772ZM15.493 24.3228L31.0044 33.2794V50.3622L15.493 41.3831V24.3228ZM33.9975 50.3622V33.2794L49.5088 24.3003V41.4055L33.9975 50.3622Z"
                                        fill="black" />
                                </svg>

                                <div class="content">
                                    <div class="title">FREE SHIPPING</div>
                                    <p class="desc">Enjoy free shipping on all orders</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="tf-icon-box style-lg wow fadeInLeft">
                                <svg width="64" height="64" viewBox="0 0 64 64" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M34.5392 14.5393C26.0761 14.5393 19.0059 20.5928 17.4169 28.5939L14.098 24.4449L12 26.1238L17.3726 32.8395C17.6345 33.1659 18.024 33.3432 18.4216 33.3432C18.6244 33.3432 18.8298 33.2975 19.022 33.2022L27.0808 29.1727L25.8787 26.7699L19.9568 29.7302C21.0555 22.6599 27.1654 17.2256 34.5392 17.2256C42.6854 17.2256 49.3138 23.8539 49.3138 32.0001C49.3138 40.1463 42.6854 46.7746 34.5392 46.7746V49.4609C44.1668 49.4609 52 41.6277 52 32.0001C52 22.3725 44.1668 14.5393 34.5392 14.5393Z"
                                        fill="black" />
                                </svg>

                                <div class="content">
                                    <div class="title">EASY RETURNS</div>
                                    <p class="desc">Within 14 days for a return</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="tf-icon-box style-lg wow fadeInLeft">
                                <svg width="64" height="64" viewBox="0 0 64 64" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M49.8573 26.1742C49.3295 24.5398 49.5545 22.0864 48.1827 20.1921C46.8 18.2829 44.3952 17.7403 43.0373 16.7471C41.6938 15.7645 40.4438 13.6261 38.1837 12.8886C35.9873 12.1719 33.7414 13.1445 32 13.1445C30.2588 13.1445 28.013 12.1717 25.8163 12.8885C23.5566 13.6259 22.3056 15.7647 20.9629 16.7469C19.6065 17.7389 17.1999 18.283 15.8175 20.1919C14.4468 22.0846 14.6695 24.5436 14.1427 26.1741C13.6413 27.7259 12 29.5883 12 32.0002C12 34.4135 13.6394 36.2688 14.1427 37.8262C14.6705 39.4606 14.4455 41.9139 15.8173 43.8082C17.1999 45.7175 19.6046 46.2601 20.9627 47.2533C22.306 48.2358 23.5562 50.3743 25.8163 51.1117C28.0112 51.828 30.2606 50.8559 32 50.8559C33.737 50.8559 35.9916 51.827 38.1837 51.1118C40.4434 50.3745 41.6937 48.2361 43.0371 47.2535C44.3935 46.2615 46.8001 45.7174 48.1825 43.8085C49.5533 41.9157 49.3304 39.4569 49.8573 37.8263C50.3587 36.2744 52 34.412 52 32.0002C52 29.587 50.361 27.7323 49.8573 26.1742ZM46.8838 36.8653C46.2686 38.7696 46.4298 40.9008 45.6516 41.9753C44.863 43.0642 42.7913 43.5615 41.1926 44.7309C39.6114 45.8872 38.5032 47.7203 37.2143 48.1408C35.9949 48.5388 34.0077 47.7307 32.0001 47.7307C29.9777 47.7307 28.011 48.5405 26.7858 48.1408C25.497 47.7203 24.3904 45.8885 22.8075 44.7308C21.2183 43.5685 19.1347 43.061 18.3484 41.9752C17.5727 40.9042 17.7278 38.7583 17.1163 36.8654C16.517 35.0108 15.125 33.4049 15.125 32.0002C15.125 30.594 16.5157 28.9937 17.1162 27.135C17.7314 25.2308 17.5702 23.0995 18.3484 22.025C19.1365 20.9369 21.2098 20.4379 22.8075 19.2695C24.3937 18.1094 25.4949 16.2807 26.7856 15.8596C28.004 15.4621 29.9977 16.2696 31.9999 16.2696C34.0259 16.2696 35.9877 15.4593 37.2142 15.8596C38.5028 16.28 39.6104 18.1125 41.1926 19.2696C42.7816 20.4318 44.8653 20.9394 45.6516 22.0251C46.4274 23.0963 46.2715 25.24 46.8837 27.1349V27.1349C47.483 28.9896 48.875 30.5954 48.875 32.0002C48.875 33.4064 47.4843 35.0067 46.8838 36.8653ZM39.1987 26.9849C39.8089 27.5952 39.8089 28.5845 39.1987 29.1946L31.3779 37.0154C30.7677 37.6257 29.7783 37.6256 29.1681 37.0154L24.8014 32.6487C24.1912 32.0385 24.1911 31.0492 24.8013 30.439C25.4116 29.8289 26.401 29.8288 27.011 30.439L30.273 33.7009L36.9888 26.985C37.5991 26.3748 38.5884 26.3748 39.1987 26.9849Z"
                                        fill="black" />
                                </svg>
                                <div class="content">
                                    <div class="title">24/7 Support</div>
                                    <p class="desc">Outstanding premium support</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex d-lg-none sw-dot-default sw-pagination-iconbox justify-content-center">
                    </div>
                </div>
            </div>
        </div>
        <!-- /Icon box -->
        <!-- Grid Collection đã xóa -->

        <!-- /Grid Collection -->
        <!-- Trending -->
        <section>
            <div class="container-2" style="margin-top: 40px;">
                <div class="flat-animate-tab overflow-visible">
                    <div class="flat-title-tab-categories text-center wow fadeInUp">
                        <h4 class="title">Sản phẩm</h4>
                        <div class="tab-slide">
                            <ul class="menu-tab-fill style-primary justify-content-center" role="tablist">
                                <li class="item-slide-effect"></li>
                                <li class="nav-tab-item active" role="presentation">
                                    <a href="#womens" class="display-xs tab-link active" data-bs-toggle="tab">Nam</a>
                                </li>
                                <li class="nav-tab-item" role="presentation">
                                    <a href="#mens" class="display-xs tab-link" data-bs-toggle="tab">Nữ</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane active show" id="womens" role="tabpanel">
                            <div class="fl-control-sw pos2">
                                <div dir="ltr" class="swiper tf-swiper wrap-sw-over" data-swiper='{
                                    "slidesPerView": 2,
                                    "spaceBetween": 12,
                                    "speed": 1000,
                                    "observer": true,
                                    "observeParents": true,
                                    "slidesPerGroup": 2,
                                    "navigation": {
                                        "clickable": true,
                                        "nextEl": ".nav-next-women",
                                        "prevEl": ".nav-prev-women"
                                    },
                                    "pagination": { "el": ".sw-pagination-women", "clickable": true },
                                    "breakpoints": {
                                    "768": { "slidesPerView": 3, "spaceBetween": 12, "slidesPerGroup": 3 },
                                    "1200": { "slidesPerView": 4, "spaceBetween": 24, "slidesPerGroup": 4}
                                    }
                                }'>
                                    <div class="swiper-wrapper">
                                        <!-- item 1 -->
                                        <div class="swiper-slide">
                                            <div class="card-product style-1 card-product-size">
                                                <div class="card-product-wrapper">
                                                    <a href="product-detail.html" class="product-img">
                                                        <img class="img-product lazyload"
                                                            data-src="{{ asset('/images/Banner/sp1.jpg') }}"
                                                            src="{{ asset('/images/Banner/sp1.jpg') }}"
                                                            alt="image-product" />
                                                        <img class="img-hover lazyload"
                                                            data-src="{{ asset('/images/Banner/sp1.jpg') }}"
                                                            src="{{ asset('/images/Banner/sp1.jpg') }}"
                                                            alt="image-product" />
                                                    </a>
                                                    <ul class="list-product-btn">
                                                        <li>
                                                            <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                                                class="hover-tooltip tooltip-left box-icon">
                                                                <span class="icon icon-cart2"></span>
                                                                <span class="tooltip">Add to Cart</span>
                                                            </a>
                                                        </li>
                                                        <li class="wishlist">
                                                            <a href="javascript:void(0);"
                                                                class="hover-tooltip tooltip-left box-icon">
                                                                <span class="icon icon-heart2"></span>
                                                                <span class="tooltip">Add to Wishlist</span>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#quickView" data-bs-toggle="modal"
                                                                class="hover-tooltip tooltip-left box-icon quickview">
                                                                <span class="icon icon-view"></span>
                                                                <span class="tooltip">Quick View</span>
                                                            </a>
                                                        </li>
                                                        <li class="compare">
                                                            <a href="#compare" data-bs-toggle="modal"
                                                                aria-controls="compare"
                                                                class="hover-tooltip tooltip-left box-icon">
                                                                <span class="icon icon-compare"></span>
                                                                <span class="tooltip">Add to Compare</span>
                                                            </a>
                                                        </li>
                                                    </ul>

                                                    <div class="on-sale-wrap"><span class="on-sale-item">20% Off</span>
                                                    </div>
                                                </div>
                                                <div class="card-product-info">
                                                    <a href="product-detail.html"
                                                        class="name-product link fw-medium text-md">Sport T-Shirt</a>
                                                    <p class="price-wrap fw-medium">
                                                        <span class="price-new text-primary">$80.00</span>
                                                        <span class="price-old text-dark ">$100.00</span>
                                                    </p>

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div
                                        class="d-flex d-xl-none sw-dot-default sw-pagination-women justify-content-center">
                                    </div>
                                </div>
                                <div class="d-none d-xl-flex swiper-button-next nav-swiper nav-next-women"></div>
                                <div class="d-none d-xl-flex swiper-button-prev nav-swiper nav-prev-women"></div>
                            </div>
                        </div>
                        <div class="tab-pane" id="mens" role="tabpanel">
                            <div class="hover-sw-nav ">
                                <div dir="ltr" class="swiper tf-swiper wrap-sw-over" data-swiper='{
                                    "slidesPerView": 2,
                                    "spaceBetween": 12,
                                    "speed": 1000,
                                    "observer": true,
                                    "observeParents": true,
                                    "slidesPerGroup": 2,
                                    "navigation": {
                                        "clickable": true,
                                        "nextEl": ".nav-next-men",
                                        "prevEl": ".nav-prev-men"
                                    },
                                    "pagination": { "el": ".sw-pagination-men", "clickable": true },
                                    "breakpoints": {
                                    "768": { "slidesPerView": 3, "spaceBetween": 12, "slidesPerGroup": 3 },
                                    "1200": { "slidesPerView": 4, "spaceBetween": 24, "slidesPerGroup": 4}
                                    }
                                }'>
                                    <div class="swiper-wrapper">
                                        <!-- item 1 -->
                                        <div class="swiper-slide">
                                            <div class="card-product style-1 card-product-size">
                                                <div class="card-product-wrapper">
                                                    <a href="product-detail.html" class="product-img">
                                                        <img class="img-product lazyload"
                                                            data-src="{{ asset('/images/Banner/sp01.jpg') }}"
                                                            src="{{ asset('/images/Banner/sp01.jpg') }}"
                                                            alt="image-product">
                                                        <img class="img-hover lazyload"
                                                            data-src="{{ asset('/images/Banner/sp01.jpg') }}"
                                                            src="{{ asset('/images/Banner/sp01.jpg') }}"
                                                            alt="image-product">
                                                    </a>
                                                    <ul class="list-product-btn">
                                                        <li>
                                                            <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                                                class="hover-tooltip tooltip-left box-icon">
                                                                <span class="icon icon-cart2"></span>
                                                                <span class="tooltip">Add to Cart</span>
                                                            </a>
                                                        </li>
                                                        <li class="wishlist">
                                                            <a href="javascript:void(0);"
                                                                class="hover-tooltip tooltip-left box-icon">
                                                                <span class="icon icon-heart2"></span>
                                                                <span class="tooltip">Add to Wishlist</span>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#quickView" data-bs-toggle="modal"
                                                                class="hover-tooltip tooltip-left box-icon quickview">
                                                                <span class="icon icon-view"></span>
                                                                <span class="tooltip">Quick View</span>
                                                            </a>
                                                        </li>
                                                        <li class="compare">
                                                            <a href="#compare" data-bs-toggle="modal"
                                                                aria-controls="compare"
                                                                class="hover-tooltip tooltip-left box-icon">
                                                                <span class="icon icon-compare"></span>
                                                                <span class="tooltip">Add to Compare</span>
                                                            </a>
                                                        </li>
                                                    </ul>

                                                    <div class="on-sale-wrap"><span class="on-sale-item">20% Off</span>
                                                    </div>
                                                </div>
                                                <div class="card-product-info">
                                                    <a href="product-detail.html"
                                                        class="name-product link fw-medium text-md">Fitness Club Cut Off
                                                        Tank</a>
                                                    <p class="price-wrap fw-medium">
                                                        <span class="price-new text-primary">$125.00</span>
                                                        <span class="price-old text-dark ">$150.00</span>
                                                    </p>

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div
                                        class="d-flex d-xl-none sw-dot-default sw-pagination-men justify-content-center">
                                    </div>
                                </div>
                                <div class="d-none d-xl-flex swiper-button-next nav-swiper nav-next-men"></div>
                                <div class="d-none d-xl-flex swiper-button-prev nav-swiper nav-prev-men"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /Trending -->
        <!-- Banner Collection-->
        <section class="s-banner-colection banner-cls-sportwear style-abs-2 flat-spacing-3">
            <div class="container">
                <div class="banner-content">
                    <a href="shop-default.html" class="image d-block">
                        <img src="{{ asset('/images/Banner/banner00.jpg') }}" alt="images/banner/sportwear.jpg"
                            class="lazyload">
                    </a>
                    <div class="box-content">
                        <div class="box-title-banner wow fadeInUp">
                            <h4 class="title display-md fw-medium">
                                Tôn Vinh Phong Cách Của Bạn
                            </h4>
                            <p class="sub text-md">
                                Khám phá những mùi hương mới nhất <br> được thiết kế để khơi gợi cảm xúc và sự cuốn hút.
                            </p>
                        </div>
                        <div class="box-btn-banner wow fadeInUp">
                            <a href="shop-default.html" class="tf-btn animate-btn">Mua Ngay</a>
                        </div>
                    </div>

                </div>
            </div>
        </section>
        <!-- /Banner Collection-->
        <!-- Best Product -->
        <div>
            <div class="container-2">
                <div class="flat-animate-tab overflow-visible">
                    <div class="flat-title-tab-2 text-center wow fadeInUp">
                        <ul class="menu-tab-fill-lg justify-content-sm-center" role="tablist">
                            <li class="nav-tab-item" role="presentation">
                                <a href="#hot" class="tab-link active display-md" data-bs-toggle="tab">Sản Phẩm Bán
                                    Chạy</a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane active show" id="hot" role="tabpanel">
                            <div class="hover-sw-nav ">
                                <div dir="ltr" class="swiper tf-swiper wrap-sw-over" data-swiper='{
                                    "slidesPerView": 2,
                                    "spaceBetween": 12,
                                    "speed": 1000,
                                    "observer": true,
                                    "observeParents": true,
                                    "slidesPerGroup": 2,
                                    "navigation": {
                                        "clickable": true,
                                        "nextEl": ".nav-next-hot",
                                        "prevEl": ".nav-prev-hot"
                                    },
                                    "pagination": { "el": ".sw-pagination-hot", "clickable": true },
                                    "breakpoints": {
                                    "768": { "slidesPerView": 3, "spaceBetween": 12, "slidesPerGroup": 3 },
                                    "1200": { "slidesPerView": 4, "spaceBetween": 24, "slidesPerGroup": 4}
                                    }
                                }'>
                                    <div class="swiper-wrapper">
                                        <!-- item 1 -->
                                        <div class="swiper-slide">
                                            <div class="card-product style-1 card-product-size">
                                                <div class="card-product-wrapper">
                                                    <a href="product-detail.html" class="product-img">
                                                        <img class="img-product lazyload"
                                                            data-src="{{ asset('/images/Banner/sp01.jpg') }}"
                                                            src="{{ asset('/images/Banner/sp01.jpg') }}"
                                                            alt="image-product">
                                                        <img class="img-hover lazyload"
                                                            data-src="{{ asset('/images/Banner/sp01.jpg') }}"
                                                            src="{{ asset('/images/Banner/sp01.jpg') }}"
                                                            alt="image-product">
                                                    </a>
                                                    <ul class="list-product-btn">
                                                        <li>
                                                            <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                                                class="hover-tooltip tooltip-left box-icon">
                                                                <span class="icon icon-cart2"></span>
                                                                <span class="tooltip">Add to Cart</span>
                                                            </a>
                                                        </li>
                                                        <li class="wishlist">
                                                            <a href="javascript:void(0);"
                                                                class="hover-tooltip tooltip-left box-icon">
                                                                <span class="icon icon-heart2"></span>
                                                                <span class="tooltip">Add to Wishlist</span>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#quickView" data-bs-toggle="modal"
                                                                class="hover-tooltip tooltip-left box-icon quickview">
                                                                <span class="icon icon-view"></span>
                                                                <span class="tooltip">Quick View</span>
                                                            </a>
                                                        </li>
                                                        <li class="compare">
                                                            <a href="#compare" data-bs-toggle="modal"
                                                                aria-controls="compare"
                                                                class="hover-tooltip tooltip-left box-icon">
                                                                <span class="icon icon-compare"></span>
                                                                <span class="tooltip">Add to Compare</span>
                                                            </a>
                                                        </li>
                                                    </ul>

                                                    <div class="on-sale-wrap"><span class="on-sale-item">20% Off</span>
                                                    </div>
                                                </div>
                                                <div class="card-product-info">
                                                    <a href="product-detail.html"
                                                        class="name-product link fw-medium text-md">Fitness Club Cut Off
                                                        Tank</a>
                                                    <p class="price-wrap fw-medium">
                                                        <span class="price-new text-primary">$125.00</span>
                                                        <span class="price-old text-dark ">$150.00</span>
                                                    </p>

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div
                                        class="d-flex d-xl-none sw-dot-default sw-pagination-hot justify-content-center">
                                    </div>
                                </div>
                                <div class="d-none d-xl-flex swiper-button-next nav-swiper nav-next-hot"></div>
                                <div class="d-none d-xl-flex swiper-button-prev nav-swiper nav-prev-hot"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- /Best Product -->
        <!-- Offer -->
        <section class="flat-spacing-3">
            <div class="container">
                <div class="tf-grid-layout md-col-2">
                    <div class="wg-offer hover-img">
                        <a href="shop-default.html" class="image d-block img-style">
                            <img src="{{ asset('/images/Banner/featured_coll_2_1_img.jpg') }}"
                                data-src="{{ asset('/images/Banner/featured_coll_2_1_img.jpg') }}" alt=""
                                class="lazyload">
                        </a>
                        <div class="content text-center wow fadeInUp">
                            <div class="box-title">
                                <h6><a href="shop-default.html" class="link">New Arrivals</a></h6>
                                <p class="text-md text-main">
                                    Discover the latest trends in activewear and upgrade <br class="d-none d-xl-block">
                                    your fitness wardrobe.
                                </p>
                            </div>
                            <div class="box-btn">
                                <a href="shop-default.html" class="tf-btn btn-out-line-dark-2">Shop Now</a>
                            </div>
                        </div>
                    </div>
                    <div class="wg-offer hover-img">
                        <a href="shop-default.html" class="image d-block img-style">
                            <img src="{{ asset('/images/Banner/featured_coll_2_2_img.jpg') }}"
                                data-src="{{ asset('/images/Banner/featured_coll_2_2_img.jpg') }}" alt=""
                                class="lazyload">
                        </a>
                        <div class="content text-center wow fadeInUp">
                            <div class="box-title">
                                <h6><a href="shop-default.html" class="link">Limited Time Offer</a></h6>
                                <p class="text-md text-main">
                                    Get up to 30% off selected sportwear items. Don’t miss
                                    <br class="d-none d-xl-block">
                                    out on these deals!
                                </p>
                            </div>
                            <div class="box-btn">
                                <a href="shop-default.html" class="tf-btn btn-out-line-dark-2">
                                    Shop Now
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /Offer -->
        <!-- Brand -->

        <!-- /Brand -->
        <!-- Testimonial -->
        <div class="flat-spacing-3">
            <div class="container">
                <div class="wrapper-thumbs-tes-4 flat-thumbs-tes">
                    <div class="box-left">
                        <div dir="ltr" class="swiper tf-thumb-tes" data-space-lg="24" data-space="12">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide hover-img">
                                    <div class="img-sw-thumb img-style">
                                        <img class="lazyload" data-src="{{ asset('/images/Banner/bv.jpg') }}"
                                            src="{{ asset('/images/Banner/bv.jpg') }}" alt="img">
                                    </div>
                                </div>
                                <div class="swiper-slide hover-img">
                                    <div class="img-sw-thumb img-style">
                                        <img class="lazyload" data-src="{{ asset('/images/Banner/bv.jpg') }}"
                                            src="{{ asset('/images/Banner/bv.jpg') }}" alt="img">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-right">
                        <div dir="ltr" class="swiper tf-tes-main" data-space-lg="24" data-space="12">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="box-testimonial-main wow fadeInUp">
                                        <div class="box-content">
                                            <span class="text-primary quote icon-quote4"></span>
                                            <div class="list-star-default">
                                                <i class="text-yellow-2 icon-star"></i>
                                                <i class="text-yellow-2 icon-star"></i>
                                                <i class="text-yellow-2 icon-star"></i>
                                                <i class="text-yellow-2 icon-star"></i>
                                                <i class="text-yellow-2 icon-star"></i>
                                            </div>
                                            <div class="text-md fw-medium text-uppercase">Sang Trọng Và Tinh Tế</div>
                                            <p class="text-review display-xs">
                                                "Tôi thực sự yêu thích hương nước hoa này! Mùi hương nhẹ nhàng nhưng
                                                cuốn
                                                hút, lưu hương lâu và mang lại cảm giác tự tin suốt cả ngày."
                                            </p>
                                        </div>

                                        <div class="box-author">
                                            <div class="img d-md-none">
                                                <img src="{{ asset('/images/Banner/bv.jpg') }}" alt="author">
                                            </div>
                                            <div class="info">
                                                <div class="name text-md fw-medium">Vincent</div>
                                                <a href="product-detail.html" class="meta link">
                                                    <span class="text-main">Đã mua sản phẩm:</span>
                                                    <span class="fw-medium">Nước Hoa Luxe Intense</span></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="box-testimonial-main wow fadeInUp">
                                        <div class="box-content">
                                            <span class="text-primary quote icon-quote4"></span>
                                            <div class="list-star-default">
                                                <i class="text-yellow-2 icon-star"></i>
                                                <i class="text-yellow-2 icon-star"></i>
                                                <i class="text-yellow-2 icon-star"></i>
                                                <i class="text-yellow-2 icon-star"></i>
                                                <i class="text-yellow-2 icon-star"></i>
                                            </div>
                                            <div class="text-md fw-medium text-uppercase">Hương Thơm Hoàn Hảo</div>
                                            <p class="text-review display-xs">
                                                "Mùi hương tinh tế, không quá nồng nhưng đủ để gây ấn tượng. Thiết kế
                                                chai
                                                đẹp và sang trọng nữa!"
                                            </p>
                                        </div>

                                        <div class="box-author">
                                            <div class="img d-md-none">
                                                <img src="{{ asset('/images/Banner/bv.jpg') }}" alt="author">
                                            </div>
                                            <div class="info">
                                                <div class="name text-md fw-medium">Henry</div>
                                                <a href="product-detail.html" class="meta link">
                                                    <span class="text-main">Đã mua sản phẩm:</span>
                                                    <span class="fw-medium">Mystique Eau de Parfum</span></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="box-nav-swiper d-md-none">
                                <div class="swiper-button-prev nav-swiper size-30 style-line nav-prev-tes"></div>
                                <div class="swiper-button-next nav-swiper size-30 style-line nav-next-tes"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- /Testimonial -->
        <!-- Shop Gram -->

        <!-- /Shop Gram -->
    </div>
</body>
@endsection