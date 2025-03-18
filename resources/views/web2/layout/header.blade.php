<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Ethereal Noir Shop</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('website/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('website/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('website/css/style.min.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container-fluid">
        <!-- Top Bar -->


        <!-- Header -->
        <div class="row align-items-center py-3 px-xl-5">
            <!-- Logo -->
            <div class="col-lg-3 d-none d-lg-block">
                <a href="#" class="text-decoration-none">
                    <h1 class="m-0 display-5 font-weight-semi-bold">
                        <span class="text-primary font-weight-bold border px-3 mr-1">Ethereal</span>Noir
                    </h1>
                </a>
            </div>

            <!-- Search Bar -->
            <div class="col-lg-6 col-8">
                <form action="#">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search for products">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Wishlist & Cart -->
            <!-- Wishlist & Cart -->
            <div class="col-lg-3 col-4 text-right d-flex align-items-center justify-content-end ms-4">
                <!-- Bọc phần tài khoản & lịch sử mua hàng vào 1 div để giữ bố cục -->
                <div class="d-flex align-items-center justify-content-end w-100 gap-4">
                    <!-- Thêm gap-4 để giãn cách -->

                    <!-- Tài khoản -->
                    <div class="dropdown">
                        @auth
                        <a class="nav-link dropdown-toggle p-0 text-dark" href="#" id="userDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user fa-lg"></i> <!-- Icon người dùng -->
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="{{ route('profile') }}"><i
                                        class="fas fa-user me-2"></i>Thông tin cá nhân</a></li>
                            <li><a class="dropdown-item" href="{{ route('wallet.show') }}"><i
                                        class="fas fa-wallet me-2"></i>Ví điện tử</a></li>
                            <li><a class="dropdown-item" href="{{ route('profile') }}"><i
                                        class="fas fa-history me-2"></i>Lịch sử mua hàng</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item text-danger" href="{{ route('web.logout') }}"><i
                                        class="fas fa-sign-out-alt me-2"></i>Đăng xuất</a></li>
                        </ul>
                        @else
                        <a class="nav-link dropdown-toggle p-0 text-dark" href="#" id="guestDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user fa-lg"></i> <!-- Icon người dùng -->
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="guestDropdown">
                            <li><a class="dropdown-item" href="{{ route('web.login') }}"><i
                                        class="fas fa-sign-in-alt me-2"></i>Đăng nhập</a></li>
                            <li><a class="dropdown-item" href="{{ route('web.register') }}"><i
                                        class="fas fa-user-plus me-2"></i>Đăng ký</a></li>
                        </ul>
                        @endauth
                    </div>

                    <!-- Giỏ hàng -->
                    <div class="position-relative">
                        <a href="#" class="text-dark">
                            <i class="fas fa-shopping-cart fa-lg"></i>
                            <span
                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                0
                            </span>
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</body>

</html>