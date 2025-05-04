<style>
.logo-header {
    display: block;

    margin: 0px !important;
}

.logo {
    width: 270px !important;


}
</style>

<div>
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
        <header id="header" class="header-default header-search header-absolute-2 header-uppercase">
            <div class="header-top">
                <div class="container">
                    <div class="row wrapper-header align-items-center">
                        <div class="col-md-4 col-3 d-xl-none">
                            <a href="#mobileMenu" class="mobile-menu" data-bs-toggle="offcanvas"
                                aria-controls="mobileMenu">
                                <i class="icon icon-categories1"></i>
                            </a>
                        </div>
                        <div class="col-xl-3 col-md-4 col-6">
                            <a href="{{ route('web.home') }}" class="logo-header">
                                <img src="{{ asset('/images/Banner/logo7.jpg') }}" alt="logo" class="logo logo-dark">
                                <img src="{{ asset('/images/Banner/logo7.jpg') }}" alt="logo" class="logo logo-white">
                            </a>
                        </div>


                        <div class="col-xl-5 d-none d-xl-block text-center">
                            <div class="tf-form-search">
                                <form class="form-search" action="{{ route('product.search') }}" method="GET"
                                    action="/search">
                                    <input type="text" name="searchInput" placeholder="Tìm kiếm sản phẩm..." required>
                                    <button type="submit" class="btn-search">
                                        <i class="icon icon-search"></i>
                                    </button>
                                </form>

                            </div>

                        </div>

                        <div class="col-xl-4 col-md-4 col-3">
                            <ul class="nav-icon d-flex justify-content-end align-items-center">
                                {{-- <li class="nav-wishlist">
                                        <a href="wish-list.html" class="nav-icon-item">

                                            <i class="icon icon-heart"></i>
                                            <span class="text d-none d-xl-block">chat</span>
                                        </a>
                                    </li> --}}
                              
                                <li class="nav-account">
                                    <a href="#login" data-bs-toggle="offcanvas" class="nav-icon-item">
                                        <i class="icon icon-user"></i>
                                        @if (Auth::check())
                                        {{-- Người dùng đã đăng nhập --}}
                                        <span class="text d-none d-xl-block">{{ Auth::user()->name }}</span>
                                        @else
                                        <span class="text d-none d-xl-block">Đăng nhập</span>
                                        @endif
                                    </a>
                                </li>
                                <li class="nav-cart dropdown position-relative" id="header-cart">
                                    <a href="#" class="nav-icon-item position-relative" id="cartDropdown"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="position-relative">
                                            <i class="icon icon-cart"></i>
                                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger cart-count"
                                            style="font-size: 10px">
                                          {{ session('cart') ? collect(session('cart'))->sum(fn($item) => (int) $item['quantity']) : 0 }}
                                      </span>
                                        </span>
                                        <span class="text d-none d-xl-block">Giỏ hàng</span>
                                    </a>

                                    <!-- Dropdown danh sách sản phẩm trong giỏ hàng -->
                                    <ul class="dropdown-menu dropdown-menu-end p-2 cart-dropdown" aria-labelledby="cartDropdown" style="width: 300px;">
                                        @php $cart = session('cart', []); @endphp
                                        @include('web3.layout.partials.cart_dropdown')
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>

            <div class="header-bottom d-none d-xl-block">
                <div class="container">
                    <nav class="box-navigation text-center">
                        <ul class="box-nav-menu">
                            <li class="menu-item">
                                <a href="{{ route('web.home') }}" class="item-link">Trang chủ</a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('web.shop') }}" class="item-link">Nước hoa</a>
                            </li>
                            <li class="menu-item" style="position: relative;">
                                <a href="#" class="item-link">Thương hiệu <i class="icon icon-arr-down"></i></a>

                                <div class="sub-menu mega-menu mega-shop" style="position: absolute;
                                            top: 100%;
                                            left: 0;
                                            background: #fff;
                                            padding: 20px;
                                            border-radius: 15px;
                                            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
                                            display: inline-block;
                                            min-width: 200px;
                                            max-width: 100%;
                                            z-index: 1000;">

                                    <ul class="menu-list" style="display: grid;
                                               grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
                                               gap: 10px;
                                               list-style: none;
                                               padding: 0;
                                               margin: 0;">
                                        @foreach ($brands as $brand)
                                        <li style="margin-bottom: 5px;">
                                            <a href="{{ route('web.shop', ['brand_id' => $brand->id]) }}"
                                                class="menu-link-text link"
                                                style="font-size: 16px; color: #000; text-decoration: none; display: block;">
                                                {{ $brand->name }}
                                            </a>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </li>
                            <li class="menu-item" style="position: relative;">
                                <a href="#" class="item-link">Danh mục <i class="icon icon-arr-down"></i></a>

                                <div class="sub-menu mega-menu mega-shop" style="position: absolute;
                                            top: 100%;
                                            left: 0;
                                            background: #fff;
                                            padding: 20px;
                                            border-radius: 15px;
                                            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
                                            display: inline-block;
                                            min-width: 200px;
                                            max-width: 100%;
                                            z-index: 1000;">

                                    <ul class="menu-list" style="display: grid;
                                               grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
                                               gap: 10px;
                                               list-style: none;
                                               padding: 0;
                                               margin: 0;">
                                        @foreach ($categories as $category)
                                        <li style="margin-bottom: 5px;">
                                            <a href="{{ route('web.shop', ['cate_id' => $category->id]) }}"
                                                class="menu-link-text link"
                                                style="font-size: 16px; color: #000; text-decoration: none;">
                                                <h7>{{ $category->name }}</h7>
                                            </a>
                                        </li>
                                        @endforeach
                                        @php
                                        $latestProduct = $productNews->first();
                                        @endphp

                                        {{-- @if ($latestProduct)
                                        <li style="margin-bottom: 5px;">
                                            <a href="{{ route('web.shop', ['type' => 'new']) }}"
                                                style="font-size: 16px">
                                                Sản phẩm mới
                                            </a>
                                        </li>
                                        @endif --}}
                                    </ul>
                                </div>
                            </li>


                            <li class="menu-item position-relative">
                                <a href="{{ route('web.contact.page')}}" class="item-link">Liên hệ</a>
                            </li>
                            <li class="menu-item position-relative">
                                <a href="{{route('web.listBlog.blog')}}" class="item-link">Bài viết</a>

                            </li>

                        </ul>
                    </nav>
                </div>
            </div>

        </header>
    </div>
</div>

@push('scripts')


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@endpush