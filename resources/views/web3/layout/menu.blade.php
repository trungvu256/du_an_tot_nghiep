<style>
.logo-header {
    display: block;

    margin: 0px !important;
}

.logo {
    width: 270px !important;


}
</style>

<body>

    <!-- Scroll Top -->
    <button id="goTop">
        <span class="border-progress"></span>
        <span class="icon icon-arrow-right"></span>
    </button>

    <!-- preload -->
    <div class="preload preload-container">
        <div class="preload-logo">
            <div class="spinner"></div>
        </div>
    </div>
    <div id="wrapper">
        <header id="header" class="header-default">
            <div class="container">
                <div class="row wrapper-header align-items-center">
                    <div class="col-md-4 col-3 d-xl-none">
                        <a href="#mobileMenu" class="mobile-menu" data-bs-toggle="offcanvas" aria-controls="mobileMenu">
                            <i class="icon icon-categories1"></i>
                        </a>
                    </div>
                    <div class="col-xl-2 col-md-4 col-6">
                        <a href="index-2.html" class="logo-header">
                            <img src="{{ asset('/images/Banner/logo7.jpg') }}" alt="logo" class="logo">
                        </a>
                    </div>
                    <div class="col-xl-8 d-none d-xl-block">
                        <nav class="box-navigation text-center">
                            <ul class="box-nav-menu">
                                <li class="menu-item">

                                    <a href="#" class="item-link">Home<i class="icon icon-arr-down"></i></a>
    

                                </li>
                                <li class="menu-item">
                                    <a href="{{ route('web3.shop') }}" class="item-link">Shop<i
                                            class="icon icon-arr-down"></i></a>
                                    <div class="sub-menu mega-menu mega-shop">
                                        <div class="wrapper-sub-menu">
                                            <div class="mega-menu-item">
                                                <div class="menu-heading">SHOP LAYOUT</div>
                                                <ul class="menu-list">
                                                    <li><a href="shop-default.html" class="menu-link-text link">Default</a>
                                                    </li>
    
                                                </ul>
                                            </div>
    
                                        </div>
                                        <div class="wrapper-sub-collection">
                                            <div dir="ltr" class="swiper tf-swiper hover-sw-nav wow fadeInUp" data-swiper='{
                                                    "slidesPerView": 2,
                                                    "spaceBetween": 24,
                                                    "speed": 800,
                                                    "observer": true,
                                                    "observeParents": true,
                                                    "slidesPerGroup": 2,
                                                    "navigation": {
                                                        "clickable": true,
                                                        "nextEl": ".nav-next-cls-header",
                                                        "prevEl": ".nav-prev-cls-header"
                                                    },
                                                    "pagination": { "el": ".sw-pagination-cls-header", "clickable": true }
                                                }'>
                                                <div class="swiper-wrapper">
                                                    <div class="swiper-slide">
                                                        <div class="wg-cls style-abs asp-1 hover-img">
                                                            <a href="shop-default.html" class="image img-style d-block">
                                                                <img src="images/cls-categories/fashion/men-2.jpg"
                                                                    data-src="images/cls-categories/fashion/men-2.jpg"
                                                                    alt="" class="lazyload">
                                                            </a>
                                                            <div class="cls-btn text-center">
                                                                <a href="shop-default.html"
                                                                    class="tf-btn btn-cls btn-white hover-dark hover-icon-2">
                                                                    Men
                                                                    <i class="icon icon-arrow-top-left"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- item 2 -->
                                                    <div class="swiper-slide">
                                                        <div class="wg-cls style-abs asp-1 hover-img">
                                                            <a href="shop-default.html" class="image img-style d-block">
                                                                <img src="images/cls-categories/fashion/women.jpg"
                                                                    data-src="images/cls-categories/fashion/women.jpg"
                                                                    alt="" class="lazyload">
                                                            </a>
                                                            <div class="cls-btn text-center">
                                                                <a href="shop-default.html"
                                                                    class="tf-btn btn-cls btn-white hover-dark hover-icon-2">
                                                                    Women
                                                                    <i class="icon icon-arrow-top-left"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
    
                                                </div>
                                                <div
                                                    class="d-flex d-xl-none sw-dot-default sw-pagination-cls-header justify-content-center">
                                                </div>
                                                <div
                                                    class="d-none d-xl-flex swiper-button-next nav-swiper nav-next-cls-header">
                                                </div>
                                                <div
                                                    class="d-none d-xl-flex swiper-button-prev nav-swiper nav-prev-cls-header">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="menu-item" style="position: relative;">
                                    <a href="#" class="item-link">Sản phẩm <i class="icon icon-arr-down"></i></a>
                                    <div class="sub-menu mega-menu" style="min-width: 220px; padding: 10px; background: white; box-shadow: 0 2px 6px rgba(0,0,0,0.1); position: absolute; top: 100%; left: 0; z-index: 1000;">
                                        <!-- DANH MỤC SẢN PHẨM -->
                                        <div class="mega-menu-item" style="margin-bottom: 10px;">
                                            
                                            <ul class="menu-list">
                                                @foreach ($categories as $category)
                                                    <li style="margin-bottom: 5px;">
                                                        <a href="" class="menu-link-text link" style="font-size: 16px; color: #000; text-decoration: none;">
                                                            <h7>{{ $category->name }}</h7>
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        @php
                                        $latestProduct = $productNews->first();
                                    @endphp
                                    
                                    @if ($latestProduct)
                                        <a href="{{ route('web.shop', ['type' => 'new']) }}" style="font-size: 16px">
                                            Sản phẩm mới
                                        </a>
                                    @endif
                                    
                                    </div>
                                </li>
                                
                                
                                <li class="menu-item position-relative">
                                    <a href="#" class="item-link">Pages<i class="icon icon-arr-down"></i></a>
                                    <div class="sub-menu sub-menu-style-2">
                                        <ul class="menu-list">
                                            <li><a href="about-us.html" class="menu-link-text link">About</a></li>
                                            <li><a href="contact-us.html" class="menu-link-text link">Contact</a></li>
                                            <li><a href="store-location.html" class="menu-link-text link">Store
                                                    location</a></li>
                                            <li><a href="account-page.html" class="menu-link-text link">Login
                                                    register</a></li>
                                            <li><a href="faq.html" class="menu-link-text link">FAQ</a></li>
                                            <li><a href="cart-empty.html" class="menu-link-text link">Cart empty</a>
                                            </li>
                                            <li><a href="cart-drawer-v2.html" class="menu-link-text link">Cart drawer
                                                    v2</a></li>
                                            <li><a href="view-cart.html" class="menu-link-text link">View cart</a></li>
                                            <li><a href="before-you-leave.html" class="menu-link-text link">Before you
                                                    leave</a></li>
                                            <li><a href="cookies.html" class="menu-link-text link">Cookies</a></li>
                                            <li><a href="home-fashion-02.html" class="menu-link-text link">Sub navtab
                                                    products</a></li>
                                            <li><a href="404-3.html" class="menu-link-text link">404</a></li>
                                            <li><a href="coming-soon.html" class="menu-link-text link">Coming Soon!</a>
                                            </li>
                                        </ul>
                                        <div class="banner hover-img">
                                            <a href="blog-single.html" class="img-style">
                                                <img src="images/blog/banner-header.jpg" alt="banner">
                                            </a>
                                            <div class="content">
                                                <div class="title">
                                                    Unveiling the latest gear
                                                </div>
                                                <a href="blog-single.html" class="box-icon animate-btn"><i
                                                        class="icon icon-arrow-top-left"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="menu-item position-relative">
                                    <a href="#" class="item-link">Blog<i class="icon icon-arr-down"></i></a>
                                    <div class="sub-menu sub-menu-style-3">
                                        <ul class="menu-list">
                                            <li><a href="blog-list-01.html" class="menu-link-text link">Blog List 1</a>
                                            </li>
    
                                        </ul>
                                        <div class="wrapper-sub-blog">
                                            <div class="menu-heading">Recent Posts</div>
                                            <ul class="list-recent-blog">
                                                <li class="item">
                                                    <a href="blog-single.html" class="img-box">
                                                        <img src="images/blog/recent-1.jpg" alt="img-recent-blog">
                                                    </a>
                                                    <div class="content">
                                                        <a href="blog-single.html" class="fw-medium text-sm link title">The
                                                            Power of
                                                            Monochrome: Styling One Color</a>
                                                        <span class="text-xxs text-grey date-post">Sep 19 2024</span>
                                                    </div>
                                                </li>
                                                <li class="item">
                                                    <a href="blog-single.html" class="img-box">
                                                        <img src="images/blog/recent-2.jpg" alt="img-recent-blog">
                                                    </a>
                                                    <div class="content">
                                                        <a href="blog-single.html" class="fw-medium text-sm link title">10
                                                            Must-Have
                                                            Accessories for Every Season</a>
                                                        <span class="text-xxs text-grey date-post">Sep 19 2024</span>
                                                    </div>
                                                </li>
                                                <li class="item">
                                                    <a href="blog-single.html" class="img-box">
                                                        <img src="images/blog/recent-3.jpg" alt="img-recent-blog">
                                                    </a>
                                                    <div class="content">
                                                        <a href="blog-single.html" class="fw-medium text-sm link title">How
                                                            to Elevate Your
                                                            Look with Layering</a>
                                                        <span class="text-xxs text-grey date-post">Sep 19 2024</span>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
    
                                </li>
    
                            </ul>
                        </nav>
                    </div>
                    <div class="col-xl-2 col-md-4 col-3">
                        <ul class="nav-icon d-flex justify-content-end align-items-center">
                            <li class="nav-search">
                                <a href="#search" data-bs-toggle="offcanvas" class="nav-icon-item">
                                    <i class="icon icon-search"></i>
                                </a>
                            </li>
                            <li class="nav-account">
                                <a href="#login" data-bs-toggle="offcanvas" aria-controls="login" class="nav-icon-item">
                                    <i class="icon icon-user"></i>
                                </a>
                            </li>
                            <li class="nav-wishlist">
                                <a href="wish-list.html" class="nav-icon-item">
                                    <i class="icon icon-heart"></i>
                                    <span class="count-box">0</span>
                                </a>
                            </li>
                            <li class="nav-cart dropdown position-relative" id="header-cart">
                                <a href="#" class="nav-icon-item position-relative" id="cartDropdown"
                                   data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="position-relative">
                                        <i class="icon icon-cart"></i>
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                              style="font-size: 10px">
                                            {{ session('cart') ? collect(session('cart'))->sum(fn($item) => (int) $item['quantity']) : 0 }}
                                        </span>
                                    </span>
                                    {{-- <span class="text d-none d-xl-block">Giỏ hàng</span> --}}
                                </a>
                            
                                <!-- Dropdown danh sách sản phẩm trong giỏ hàng -->
                                <ul class="dropdown-menu dropdown-menu-end p-2" aria-labelledby="cartDropdown" style="width: 300px;">
                                    @php $cart = session('cart', []); @endphp
                            
                                    @if (count($cart) > 0)
                                    @foreach ($cart as $key => $item)
                                            <li class="d-flex align-items-center justify-content-between">
                                                <div class="d-flex">
                                                    <img src="{{ asset('storage/' . $item['image']) }}"
                                                         alt="{{ $item['name'] }}" width="50" class="me-2">
                                                    <div>
                                                        <strong>{{ $item['name'] }}</strong><br>
                                                        <small>{{ $item['quantity'] }} x {{ number_format($item['price'], 0, ',', '.') }} VNĐ</small>
                                                    </div>
                                                </div>
                                                <form action="{{ route('cart.removess', $key) }}" method="POST" class="form-remove-item">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-danger">x</button>
                                                </form>
                                                
                                            </li>
                                            <hr>
                                        @endforeach
                            
                                        <li class="text-center">
                                            <strong>
                                                Tổng:
                                                {{ number_format(collect($cart)->sum(fn($i) => (int) $i['quantity'] * (float) $i['price']), 0, ',', '.') }}
                                                VNĐ
                                            </strong>
                                        </li>
                                        <li class="text-center mt-2">
                                            <a href="{{ route('cart.viewCart') }}" class="btn btn-primary btn-sm w-100">Xem giỏ hàng</a>
                                        </li>
                                    @else
                                        <li class="text-center text-muted">Giỏ hàng trống</li>
                                    @endif
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>
    </div>



</body>