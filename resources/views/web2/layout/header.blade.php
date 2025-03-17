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
        <div class="row bg-secondary py-2 px-xl-5">
            <div class="col-lg-6 d-none d-lg-block">
                <div class="d-inline-flex align-items-center">
                    <a class="text-dark" href="#">FAQs</a>
                    <span class="text-muted px-2">|</span>
                    <a class="text-dark" href="#">Help</a>
                    <span class="text-muted px-2">|</span>
                    <a class="text-dark" href="#">Support</a>
                </div>
            </div>
            <div class="col-lg-6 text-center text-lg-right">
                <div class="d-inline-flex align-items-center">
                    <a class="text-dark px-2" href="#"><i class="fab fa-facebook-f"></i></a>
                    <a class="text-dark px-2" href="#"><i class="fab fa-twitter"></i></a>
                    <a class="text-dark px-2" href="#"><i class="fab fa-linkedin-in"></i></a>
                    <a class="text-dark px-2" href="#"><i class="fab fa-instagram"></i></a>
                    <a class="text-dark pl-2" href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </div>

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
            <div class="col-lg-3 col-4 text-right d-flex align-items-center justify-content-end ms-4">
                <!-- Bọc phần tài khoản & lịch sử mua hàng vào 1 div để giữ bố cục -->
                <div class="d-flex flex-column align-items-start me-4">
                    <!-- Dropdown tài khoản -->
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown"
                            role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            @auth
                                <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('default-avatar.png') }}"
                                    class="rounded-circle" width="40" height="40" alt="Avatar">
                                <span class="ml-2">Chào, {{ Auth::user()->name }}!</span>
                            @else
                                <img src="default-avatar.png" class="rounded-circle" width="40" height="40" alt="Avatar">
                            @endauth
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                            @auth
                                <a class="dropdown-item" href="{{ route('profile') }}">Thông tin cá nhân</a>
                                <a class="dropdown-item" href="{{ route('wallet.show') }}">Ví điện tử</a>
                                <a class="dropdown-item" href="{{ route('profile') }}">Lịch sử mua hàng</a>
                                <a class="dropdown-item" href="{{ route('web.logout') }}">Đăng xuất</a>
                            @else
                                <a class="dropdown-item" href="{{ route('web.login') }}">Đăng nhập</a>
                                <a class="dropdown-item" href="{{ route('web.register') }}">Đăng ký</a>
                            @endauth
                        </div>
                        <div>

                        </div>
                    </div>

                    <!-- Lịch sử mua hàng (nằm ngay dưới tài khoản) -->
                </div>

                <!-- Giỏ hàng đặt bên phải -->
                <div class="position-relative">
                    <a href="#" class="text-dark">
                        <i class="fas fa-shopping-cart fa-lg"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            0
                            <!-- Thay số này bằng số lượng sản phẩm trong giỏ -->
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
