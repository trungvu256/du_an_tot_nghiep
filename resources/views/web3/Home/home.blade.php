@extends('web3.layout.master')
@section('content')
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
    @foreach ($categories as $category)
    <section class="text-center">
        <div class="container-2" style="margin-top: 40px;">
            <div class="flat-animate-tab overflow-visible">
                <div class="flat-title-tab-categories text-center wow fadeInUp">
                   
                    <div class="tab-slide">
                        <ul class="menu-tab-fill style-primary justify-content-center" role="tablist">
                            <li class="item-slide-effect"></li>
                            <li class="nav-tab-item active" role="presentation">
                                <a href="{{ route('web.shop', ['category_id' => $category->id]) }}" class="display-xs tab-link active" >{{ $category->name }}</a>
                            </li>
                            {{-- <li class="nav-tab-item" role="presentation">
                                <a href="#mens" class="display-xs tab-link" data-bs-toggle="tab">Nữ</a>
                            </li> --}}
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
                                    @foreach ($category->products as $product)
                                    @php
                                    $minPrice = $product->variants->isNotEmpty()
                                        ? $product->variants->min('price')
                                        : $product->price;
                                    $maxPrice = $product->variants->isNotEmpty()
                                        ? $product->variants->max('price')
                                        : $product->price;
                                @endphp

                                    <div class="swiper-slide">
                                        <div class="card-product style-1 card-product-size">
                                            <div class="card-product-wrapper">
                                                <a href="{{ route('web.shop-detail', ['id' => $product->id]) }}" class="product-img">
                                                    <img class="img-product lazyload"
                                                        data-src="{{ asset('storage/' . $product->image) }}"
                                                        src="{{ asset('storage/' . $product->image) }}"
                                                        alt="image-product" />
                                                    <img class="img-hover lazyload"
                                                        data-src="{{ asset('storage/' . $product->image) }}"
                                                        src="{{ asset('storage/' . $product->image) }}"
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
                                                        <a href="{{ route('web.shop-detail', ['id' => $product->id]) }}"
                                                            class="hover-tooltip tooltip-left box-icon quickview">
                                                            <span class="icon icon-view"></span>
                                                            <span class="tooltip">Chi tiết</span>
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
                                                <a href="{{ route('web.shop-detail', ['id' => $product->id]) }}"
                                                    class="name-product link fw-medium text-md">{{($product->name) }}</a>
                                                <p class="price-wrap fw-medium">
                                                    <span class="price-new text-primary">{{ number_format($minPrice) }}₫
                                                        @if ($minPrice !== $maxPrice)
                                                            - {{ number_format($maxPrice) }}₫
                                                        @endif</span>
                                                    {{-- <span class="price-old text-dark ">$100.00</span> --}}
                                                </p>

                                            </div>
                                        </div>
                                    </div>

                                    @endforeach



                                </div>
                             
                                <div class="d-flex d-xl-none sw-dot-default sw-pagination-women justify-content-center">
                                    
                                </div>
                            </div> 

                            <div class="d-none d-xl-flex swiper-button-next nav-swiper nav-next-women"></div>
                            <div class="d-none d-xl-flex swiper-button-prev nav-swiper nav-prev-women"></div>
                        </div>
                    </div>
                    <a 
                    href="{{ route('web.shop', ['category_id' => $category->id]) }}" 
                    class="btn btn-primary mt-3"
                >
                    Xem tất cả
                </a>
                   
                </div>
            </div>
        
        </div>
        
    </section>
    @endforeach
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
                            <a href="#hot" class="tab-link active display-md" data-bs-toggle="tab">Sản Phẩm Mới</a>
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
                                    @foreach ($productNews as $product)
                                    @php
                                    $minPrice = $product->variants->isNotEmpty()
                                        ? $product->variants->min('price')
                                        : $product->price;
                                    $maxPrice = $product->variants->isNotEmpty()
                                        ? $product->variants->max('price')
                                        : $product->price;
                                @endphp
                                    <div class="swiper-slide">
                                        <div class="card-product style-1 card-product-size">
                                            
                                            <div class="card-product-wrapper">
                                                <a href="{{ route('web.shop-detail', ['id' => $product->id]) }}" class="product-img">
                                                    <img class="img-product lazyload"
                                                        data-src="{{ asset('storage/' . $product->image) }}"
                                                        src="{{ asset('storage/' . $product->image) }}"
                                                        alt="image-product" />
                                                    <img class="img-hover lazyload"
                                                        data-src="{{ asset('storage/' . $product->image) }}"
                                                        src="{{ asset('storage/' . $product->image) }}"
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
                                                <a href="{{ route('web.shop-detail', ['id' => $product->id]) }}"
                                                    class="name-product link fw-medium text-md">{{($product->name) }}</a>
                                                <p class="price-wrap fw-medium">
                                                    <span class="price-new text-primary">{{ number_format($minPrice) }}₫
                                                        @if ($minPrice !== $maxPrice)
                                                            - {{ number_format($maxPrice) }}₫
                                                        @endif</span>
                                                    {{-- <span class="price-old text-dark ">$100.00</span> --}}
                                                </p>

                                            </div>
                                        </div>
                                    </div>

                                    @endforeach
                                </div>
                                <div class="d-flex d-xl-none sw-dot-default sw-pagination-hot justify-content-center">
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
                            data-src="{{ asset('/images/Banner/featured_coll_2_1_img.jpg') }}" alt="" class="lazyload">
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
                            data-src="{{ asset('/images/Banner/featured_coll_2_2_img.jpg') }}" alt="" class="lazyload">
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
                                            "Tôi thực sự yêu thích hương nước hoa này! Mùi hương nhẹ nhàng nhưng cuốn
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
                                            "Mùi hương tinh tế, không quá nồng nhưng đủ để gây ấn tượng. Thiết kế chai
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

@endsection