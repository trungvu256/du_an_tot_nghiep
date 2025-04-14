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
                                <a href="home-sportwear.html" class="logo-header">
                                    <img src="{{ asset('/images/Banner/logo7.jpg') }}" alt="logo" class="logo logo-dark">
                                    <img src="{{ asset('/images/Banner/logo7.jpg') }}" alt="logo" class="logo logo-white">
                                </a>
                            </div>
    
    
                            <div class="col-xl-5 d-none d-xl-block text-center">
                                <div class="tf-form-search">
                                    <form class="form-search">
                                        <input type="text" placeholder="Search product" tabindex="0" aria-required="true"
                                            required="">
                                        <button type="submit" class="btn-search"><i class="icon icon-search"></i></button>
                                    </form>
                                    <div class="search-suggests-results">
                                        <div class="search-suggests-results-inner">
                                            <ul>
                                                <li>
                                                    <a class="search-result-item" href="product-detail.html">
                                                        <div class="img-box">
                                                            <img class="lazyload"
                                                                data-src="images/products/sport/t-shirt.jpg"
                                                                src="images/products/sport/t-shirt.jpg" alt="img">
                                                        </div>
                                                        <div class="box-content">
                                                            <p class="title link">Fitness Club Cut Off Tank</p>
                                                            <div class="price">
                                                                <span class="new-price">$100.00</span>
                                                                <span class="old-price">$130.00</span>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>
    
    
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
    
                            <div class="col-xl-4 col-md-4 col-3">
                                <ul class="nav-icon d-flex justify-content-end align-items-center">
                                    <li class="nav-account">
                                        <a href="#login" data-bs-toggle="offcanvas" class="nav-icon-item">
                                            <i class="icon icon-user"></i>
                                            <span class="text d-none d-xl-block">Login</span>
                                        </a>
                                    </li>
                                    <li class="nav-wishlist">
                                        <a href="wish-list.html" class="nav-icon-item">
                                            <i class="icon icon-heart"></i>
                                            <span class="text d-none d-xl-block">Wishlist</span>
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
                                            <span class="text d-none d-xl-block">Giỏ hàng</span>
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
    
                </div>
                <div class="header-bottom d-none d-xl-block">
                    <div class="container">
                        <nav class="box-navigation text-center">
                            <ul class="box-nav-menu">
                                <li class="menu-item">
                                    <a href="{{route('web.home')}}" class="item-link">Trang chủ</a>
    
                                </li>
                                <li class="menu-item" style="position: relative;">
                                    <a href="#" class="item-link">Thương hiệu <i class="icon icon-arr-down"></i></a>
                                
                                    <div class="sub-menu mega-menu mega-shop" 
                                         style="position: absolute;
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
                                        
                                        <ul class="menu-list"
                                            style="display: grid;
                                                   grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
                                                   gap: 10px;
                                                   list-style: none;
                                                   padding: 0;
                                                   margin: 0;">
                                           @foreach ($brands as $brand)
                                           <li>
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
                                    <a href="#" class="item-link">Nước hoa <i class="icon icon-arr-down"></i></a>
                                    <div class="sub-menu mega-menu" style="min-width: 220px; padding: 10px; background: white; box-shadow: 0 2px 6px rgba(0,0,0,0.1); position: absolute; top: 100%; left: 0; z-index: 1000;">
                                        <!-- DANH MỤC SẢN PHẨM -->
                                        <div class="mega-menu-item" style="margin-bottom: 10px;">
                                            <div style="font-weight: bold; font-size: 16px; padding-bottom: 5px;">Danh mục</div>
                                            <ul class="menu-list">
                                                @foreach ($categories as $category)
                                                    <li style="margin-bottom: 5px;">
                                                        <a href="{{ route('web.shop', ['cate_id' => $category->id]) }}" class="menu-link-text link" style="font-size: 16px; color: #000; text-decoration: none;">
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
                                    <a href="#" class="item-link">Liên hệ</a>
                                </li>
                                <li class="menu-item position-relative">
                                    <a href="" class="item-link">Bài viết</a>
    
                                </li>
    
                            </ul>
                        </nav>
                    </div>
                </div>
               
            </header>
        </div>
    </body>
    <script>
        // Xử lý sự kiện submit form xóa sản phẩm
        $(document).on('submit', '.form-remove-item', function(e) {
            e.preventDefault();
    
            const form = $(this);
            const url = form.data('url'); // Lấy route từ data-url thay vì action
            const token = form.find('input[name="_token"]').val();
    
            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    _token: token
                },
                success: function(response) {
                    if (response.success) {
                        updateHeaderCart(); // Cập nhật lại dropdown sau khi xóa
                    } else {
                        alert('Xóa sản phẩm không thành công');
                    }
                },
                error: function(xhr, status, error) {
                    console.log('Lỗi AJAX:', error);
                    alert('Xóa sản phẩm thất bại');
                }
            });
        });
    
        // Hàm cập nhật giỏ hàng trong dropdown
        function updateHeaderCart() {
            $.ajax({
                url: '{{ route("cart.showHeaderCart") }}',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    const $dropdown = $('#header-cart');
                    $dropdown.empty();
    
                    $('.badge.rounded-pill').text(response.totalQuantity || 0);
    
                    if (response.cart && response.cart.length > 0) {
                        let cartHtml = '';
    
                        response.cart.forEach(function(item, key) {
                            cartHtml += `
                                <li class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex">
                                        <img src="{{ asset('storage/') }}${item.image}" alt="${item.name}" width="50" class="me-2">
                                        <div>
                                            <strong>${item.name}</strong><br>
                                            <small>${item.quantity} x ${Number(item.price).toLocaleString('vi-VN')} VNĐ</small>
                                        </div>
                                    </div>
                                    <form data-url="/cart/remove/${key}" method="POST" class="form-remove-item">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button type="submit" class="btn btn-sm btn-danger">x</button>
                                    </form>
                                </li>
                                <hr>
                            `;
                        });
    
                        cartHtml += `
                            <li class="text-center">
                                <strong>Tổng: ${Number(response.total).toLocaleString('vi-VN')} VNĐ</strong>
                            </li>
                            <li class="text-center mt-2">
                                <a href="{{ route('cart.viewCart') }}" class="btn btn-primary btn-sm w-100">Xem giỏ hàng</a>
                            </li>
                        `;
    
                        $dropdown.html(cartHtml);
                    } else {
                        $dropdown.html('<li class="text-center text-muted">Giỏ hàng trống</li>');
                    }
                },
                error: function(xhr, status, error) {
                    console.log('Lỗi AJAX:', error);
                    alert('Không thể cập nhật giỏ hàng');
                }
            });
        }
    
        // Khởi tạo khi trang được tải
        $(document).ready(function() {
            updateHeaderCart();
        });
    </script>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    
    
    
    
    
    
    