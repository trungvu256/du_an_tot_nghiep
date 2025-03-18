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

    <link href="{{ asset('website/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('website/css/style.min.css') }}" rel="stylesheet">

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
                <h1 class="m-0 font-weight-semi-bold">Ethereal Noir</h1>
            </div>

            <!-- MENU NAV -->
            <div class="col-lg-6">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item"><a class="nav-link active" href="{{ route('web.home') }}">Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('web.shop') }}">Shop</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('web.shop-detail') }}">Shop
                                    Detail</a></li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Pages</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('user.cart') }}">Shopping Cart</a></li>
                                    <li><a class="dropdown-item" href="{{ route('user.checkout') }}">Checkout</a></li>
                                </ul>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('user.contact') }}">Contact</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('web.listBlog.blog') }}">Blog</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>


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