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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="{{ asset('website/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('website/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('website/css/style.min.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Include CSS của bạn -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

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
            height: 100px;
            /* Điều chỉnh độ cao theo menu */
            background: white;
            padding: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .search-bar {
            flex-wrap: wrap;
            /* Cho phép xuống hàng khi quá hẹp */
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

        .search-bar {
            max-width: 100%;
            padding: 10px 0;
        }


        .search-bar .search-container {
            position: relative;
            max-width: 600px;
            margin-bottom: 0.5rem;
            /* Khoảng cách với gợi ý */
        }

        .search-bar .search-input {
            /* Ghi đè thêm nếu cần */
            border-radius: 50px;
            /* Thay vì .rounded-pill */
            padding-right: 60px;
            /* Chừa chỗ cho nút search */
        }

        .search-bar .search-button {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #333;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        .search-bar .search-hints {
            font-size: 0.875rem;
            /* Tương đương .text-muted nhỏ */
            color: #666;
            margin-left: 0.5rem;
        }
    </style>
    <style>
        .icon-menu {
            position: relative;
            /* Đảm bảo nó không bị cố định */
            right: 55px;
            /* Dịch chuyển cả block sang phải */
        }

        .col-lg-3.text-start {
            width: auto !important;
            flex: unset !important;
            padding-left: 0px !important;
        }
    </style>
    <!-- HEADER -->
    <div class="container-fluid bg-white">
        <div class="row d-flex justify-content-between align-items-center py-2">
            <!-- Logo -->
            <div class="col-lg-3 text-start">
                <a href="/" class="text-decoration-none">
                    <h1 class="m-0 display-5 font-weight-semi-bold" style="font-family: 'Montserrat', sans-serif;">
                        <span class="text-primary font-weight-bold px-3 mr-1">Ethereal</span>Noir
                    </h1>
                </a>

            </div>

            <!-- MENU NAV -->
            <div class="col-lg-6">
                <nav class="navbar navbar-expand-lg  py-3 py-lg-0 px-0">
                    <a href="" class="text-decoration-none d-block d-lg-none">
                        <h1 class="m-0 display-5 font-weight-semi-bold"><span
                                class="text-primary font-weight-bold border px-3 mr-1">E</span>Shopper</h1>
                    </a>
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto py-0">
                            <a class="me-2 nav-link text-nowrap {{ request()->routeIs('web.home') ? 'active' : '' }}"
                                href="{{ route('web.home') }}" style="font-size: large">TRANG CHỦ</a>
                            <a class="me-2 nav-link text-nowrap {{ request()->routeIs('web.shop') ? 'active' : '' }}"
                                href="{{ route('web.shop') }}" style="font-size: large">SẢN PHẨM</a>
                            <div class="me-2 nav-item dropdown ml-0">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown"
                                    style="font-size: large">DANH MỤC</a>
                                <div class="dropdown-menu rounded-0 m-0">
                                    @foreach ($categories as $cate)
                                        <a href="{{ route('web.shopByCate', $cate->id) }}" class="dropdown-item"
                                            style="font-size: large">{{ $cate->name }}</a>
                                    @endforeach
                                </div>
                            </div>
                            <a class="me-2 nav-link text-nowrap {{ request()->routeIs('web.listBlog.blog') ? 'active' : '' }}"
                                href="{{ route('web.listBlog.blog') }}" style="font-size: large">BÀI VIẾT</a>
                            <a class="nav-link text-nowrap {{ request()->routeIs('user.contact') ? 'active' : '' }}"
                                href="{{ route('user.contact') }}" style="font-size: large">LIÊN HỆ</a>
                        </div>
                        {{-- <div class="navbar-nav ml-auto py-0">
                            <a href="" class="nav-item nav-link">Login</a>
                            <a href="" class="nav-item nav-link">Register</a>
                        </div> --}}
                    </div>
                </nav>

            </div>

            <div class="col-lg-3">
                <div class="icon-menu">
                    <!-- Icon tìm kiếm -->
                    <i class="fas fa-search fa-lg cursor-pointer" id="searchIcon"></i>
                    <!-- Icon người dùng -->
                    <div class="dropdown">
                        @auth
                            <a class="nav-link dropdown-toggle p-0 text-dark" href="#" id="guestDropdown"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user fa-lg"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="{{ route('profile') }}">Thông tin cá nhân</a></li>
                                <li><a class="dropdown-item" href="{{ route('wallet.index') }}">Ví điện tử</a></li>

                                <li><a href="">Chat với Admin</a></li>



                                <li><a class="dropdown-item" href="{{ route('checkout.order') }}">Lịch sử mua hàng</a>
                                </li>
                                <li><a class="dropdown-item" href="{{ route('web.logout') }}">Đăng xuất</a></li>
                            </ul>
                        @else
                            <a class="nav-link dropdown-toggle p-0 text-dark" href="#" id="guestDropdown"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
                    <!-- Icon giỏ hàng -->
                    <div class="cart-icon dropdown">
                        <a href="#" class="text-dark dropdown-toggle" id="cartDropdown"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-shopping-cart fa-lg"></i>
                            <span

                                class="cart-badge">{{ session('cart')? collect(session('cart'))->sum(function ($item) {return (int) $item['quantity'];}): 0 }}</span>


                        </a>

                        <!-- Dropdown danh sách sản phẩm trong giỏ hàng -->
                        <ul class="dropdown-menu dropdown-menu-end p-2" aria-labelledby="cartDropdown"
                            style="width: 300px;">
                            @php $cart = session('cart', []); @endphp
                            @if (count($cart) > 0)
                                @foreach ($cart as $item)
                                    <li class="d-flex align-items-center justify-content-between">
                                        <div class="d-flex">
                                            <img src="{{ asset('storage/' . $item['image']) }}"
                                                alt="{{ $item['name'] }}" width="50" class="me-2">
                                            <div>
                                                <strong>{{ $item['name'] }}</strong>
                                                <br>
                                                <small>{{ $item['quantity'] }} x
                                                    {{ number_format($item['price'], 0, ',', '.') }} VNĐ</small>
                                            </div>
                                        </div>

                                        <button type="button" class="btn btn-sm btn-danger btn-remove-item"
                                            data-id="{{ $item['id'] }}">
                                            <i class="fa fa-times"></i>
                                        </button>

                                    </li>
                                    <hr>
                                @endforeach
                                <li class="text-center">
                                    <strong>Tổng:
                                        {{ number_format(collect($cart)->sum(fn($i) => (int) $i['quantity'] * (float) $i['price']), 0, ',', '.') }}
                                        VNĐ</strong>

                                </li>
                                <li class="text-center mt-2">
                                    <a href="{{ route('cart.viewCart') }}" class="btn btn-primary btn-sm w-100">Xem
                                        giỏ hàng</a>
                                </li>
                            @else
                                <li class="text-center text-muted">Giỏ hàng trống</li>
                            @endif
                        </ul>
                    </div>


                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).on('click', '.btn-remove-item', function(e) {
            e.preventDefault();
            let id = $(this).data('id');

            $.ajax({
                url: '{{ route('cart.removess', ':id') }}'.replace(':id', id),
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(res) {
                    // Reload dropdown hoặc xoá trực tiếp DOM
                    location.reload();
                },
                error: function(err) {
                    alert("Xóa thất bại!");
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.form-remove-item').on('submit', function(e) {
                e.preventDefault(); // Ngăn reload trang

                const form = $(this);
                const url = form.attr('action');

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: form.serialize(), // Lấy CSRF token
                    success: function() {
                        // Sau khi xóa thành công, reload lại giỏ hàng header và danh sách sản phẩm
                        updateHeaderCart();
                        updateCartTable();
                    },
                    error: function() {
                        alert('Xóa sản phẩm thất bại');
                    }
                });
            });

            function updateHeaderCart() {
                $.get('{{ route('cart.showHeaderCart') }}', function(html) {
                    $('#header-cart').html(html); // phần hiển thị giỏ hàng ở header
                });
            }

            function updateCartTable() {
                $.get('{{ route('cart.index') }}', function(html) {
                    $('#cart-table').html($(html).find('#cart-table').html()); // reload lại danh sách cart
                });
            }
        });
    </script>


    <!-- Thanh tìm kiếm -->




            </div>
        </div>
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
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap" rel="stylesheet">
