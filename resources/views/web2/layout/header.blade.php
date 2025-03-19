<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Ethereal Noir Shop</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <!-- Styles & Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="{{ asset('website/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('website/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('website/css/style.min.css') }}" rel="stylesheet">
    <style>
    /* Định dạng chung cho các thẻ <a> */
    .nav-link {
        position: relative;
        font-size: 14px;
        font-family: 'Poppins', sans-serif;
        text-decoration: none;
        padding-bottom: 5px;
        transition: color 0.3s ease-in-out;
    }
    </style>


    <style>
    /* Màu sắc khi menu được chọn (active) */
    .nav-link.active {
        color: #D19C97 !important;
        /* Đổi thành màu xanh */
        font-weight: bold;
        position: relative;
    }

    /* Gạch chân khi active */
    </style>

    <style>
    /* Dropdown menu cải tiến */
    .dropdown-menu {
        min-width: 200px;
        background: white;
        border-radius: 10px;
        /* Bo góc */
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        /* Đổ bóng */
        transform: translateY(10px);
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease-in-out;
    }

    /* Hiển thị dropdown khi hover hoặc click */
    .dropdown:hover .dropdown-menu,
    .dropdown.show .dropdown-menu {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    /* Hiệu ứng hover từng item */
    .dropdown-item {
        font-size: 14px;
        font-weight: 500;
        transition: background-color 0.3s ease-in-out, color 0.3s ease-in-out;
    }

    /* Hover đẹp hơn */
    .dropdown-item:hover {

        color: #D19C97;
    }
    </style>

    <style>
    .icon-menu {
        max-width: 150px;
        display: flex;
        margin-left: 200px;
        align-items: center;
        justify-content: space-between;
    }

    .dropdown {
        margin-left: 30px;
    }
    </style>
    <style>
    /* Thanh tìm kiếm che menu */
    .search-bar {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 80px;
        /* Điều chỉnh độ cao theo menu */
        background: white;
        padding: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 1000;
    }

    .search-bar.show {
        display: flex;
    }

    /* Căn chỉnh menu ngang */
    .navbar-nav {
        margin-left: auto;
        margin-right: auto;
    }

    .navbar {
        padding: 15px 30px;
    }

    /* Icon giỏ hàng */
    .cart-icon {
        position: relative;
        margin-left: 15px;
    }

    .cart-badge {
        position: absolute;
        top: -5px;
        right: -5px;
        background: red;
        color: white;
        font-size: 12px;
        border-radius: 50%;
        padding: 2px 6px;
    }
    </style>

    <!-- HEADER -->
    <div class="container-fluid bg-white">
        <div class="row align-items-center py-3 px-xl-5">
            <!-- Logo -->
            <div class="col-lg-3 text-start">
                <a href="/" class="text-decoration-none">
                    <h1 class="m-0 display-5 font-weight-semi-bold" style="font-family: 'Montserrat', sans-serif;">
                        <span class="text-primary font-weight-bold px-3 mr-1">Ethereal</span>Noir
                    </h1>
                </a>

            </div>

            <!-- MENU NAV -->


            <div class="col-lg-6 ">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                        <ul class="navbar-nav position-relative" id="navbar-menu">
                            <li class="nav-item px-3">
                                <a class="nav-link {{ request()->routeIs('web.home') ? 'active' : '' }}"
                                    href="{{ route('web.home') }}">TRANG CHỦ</a>
                            </li>
                            <li class="nav-item px-2">
                                <a class="nav-link {{ request()->routeIs('web.shop') ? 'active' : '' }}"
                                    href="{{ route('web.shop') }}">SẢN PHẨM</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#"
                                    data-bs-toggle="dropdown">
                                    NƯỚC HOA

                                </a>
                                <ul class="dropdown-menu shadow border-0 rounded-3 p-2 animate-dropdown">
                                    <li><a class="dropdown-item py-2 px-3 rounded-2" href="#">Nước hoa nam</a></li>
                                    <li><a class="dropdown-item py-2 px-3 rounded-2" href="#">Nước hoa nữ</a></li>
                                </ul>
                            </li>



                            <li class="nav-item px-2">
                                <a class="nav-link {{ request()->routeIs('web.listBlog.blog') ? 'active' : '' }}"
                                    href="{{ route('web.listBlog.blog') }}">BÀI VIẾT</a>
                            </li>
                            <li class="nav-item px-2">
                                <a class="nav-link {{ request()->routeIs('user.contact') ? 'active' : '' }}"
                                    href="{{ route('user.contact') }}">LIÊN HỆ</a>
                            </li>
                        </ul>
                    </div>


                </nav>
            </div>


            <!-- ICONS -->
            <div class="col-lg-3">
                <div class="icon-menu">
                    <!-- Icon tìm kiếm -->
                    <i class="fas fa-search fa-lg cursor-pointer" id="searchIcon"></i>

                    <!-- Icon người dùng -->
                    <div class="dropdown">
                        @auth
                        <a class="nav-link dropdown-toggle p-0 text-dark" href="#" id="guestDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user fa-lg"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="{{ route('profile') }}">Thông tin cá nhân</a></li>
                            <li><a class="dropdown-item" href="{{ route('wallet.show') }}">Ví điện tử</a></li>
                            <li><a class="dropdown-item" href="{{ route('profile') }}">Lịch sử mua hàng</a></li>
                            <li><a class="dropdown-item" href="{{ route('web.logout') }}">Đăng xuất</a></li>
                        </ul>
                        @else
                        <a class="nav-link dropdown-toggle p-0 text-dark" href="#" id="guestDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user fa-lg"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="guestDropdown">
                            <li><a class="dropdown-item" href="{{ route('web.login') }}"><i
                                        class="fas fa-sign-in-alt me-2"></i>Đăng nhập</a></li>
                            <li><a class="dropdown-item" href="{{ route('web.register') }}"><i
                                        class="fas fa-user-plus me-2"></i>Đăng ký</a></li>
                        </ul>
                        @endauth
                    </div>

                    <!-- Icon giỏ hàng -->
                    <div class="cart-icon">
                        <a href="#" class="text-dark">
                            <i class="fas fa-shopping-cart fa-lg"></i>
                            <span class="cart-badge">0</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Thanh tìm kiếm -->
    <div class="search-bar" id="searchBar">
        <input type="text" class="form-control w-50" placeholder="Tìm kiếm...">
    </div>
    @yield('content')

    <script>
    // Xử lý mở/đóng thanh tìm kiếm
    document.getElementById("searchIcon").addEventListener("click", function(event) {
        event.stopPropagation();
        let searchBar = document.getElementById("searchBar");
        searchBar.classList.toggle("show");
    });

    // Ẩn thanh tìm kiếm khi bấm ra ngoài
    document.addEventListener("click", function(event) {
        let searchBar = document.getElementById("searchBar");
        let isClickInsideSearch = searchBar.contains(event.target);
        let isSearchIcon = event.target.id === "searchIcon";

        if (!isClickInsideSearch && !isSearchIcon) {
            searchBar.classList.remove("show");
        }
    });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    </body>

</html>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap" rel="stylesheet">