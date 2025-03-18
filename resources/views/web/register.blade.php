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
        <div class="breadcrumbs">
            <div class="container">
                <ol class="breadcrumb breadcrumb1 animated wow slideInLeft" data-wow-delay=".5s">
                    <li><a href="/"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>Trang Chủ</a></li>
                    <li class="active fw-bold">/ Đăng Ký</li>
                </ol>
            </div>
        </div>
        <div class="row justify-content-center mt-5">
            <div class="col-lg-6">
                <div class="card shadow-lg p-4 rounded-4 border-0">
                    <h3 class="text-center mb-4 text-primary fw-bold">Tạo Tài Khoản</h3>

                    <form id="form_register" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="first_name" class="form-label fw-semibold">Họ</label>
                                <input type="text" class="form-control rounded-3" id="first_name" name="first_name"
                                    placeholder="Nguyễn" required>
                            </div>
                            <div class="col-md-6">
                                <label for="last_name" class="form-label fw-semibold">Tên</label>
                                <input type="text" class="form-control rounded-3" id="last_name" name="last_name"
                                    placeholder="Văn A" required>
                            </div>
                            <div class="col-md-12">
                                <label for="name" class="form-label fw-semibold">Tên Đăng Nhập</label>
                                <input type="text" class="form-control rounded-3" id="name" name="name"
                                    placeholder="nguyenvana" required>
                            </div>
                            <div class="col-md-12">
                                <label for="email" class="form-label fw-semibold">Địa Chỉ Email</label>
                                <input type="email" class="form-control rounded-3" id="email" name="email"
                                    placeholder="example@mail.com" required>
                            </div>
                            <div class="col-md-6">
                                <label for="password" class="form-label fw-semibold">Mật Khẩu</label>
                                <input type="password" class="form-control rounded-3" id="password" name="password"
                                    placeholder="********" required>
                            </div>
                            <div class="col-md-6">
                                <label for="password_confirm" class="form-label fw-semibold">Xác Nhận Mật Khẩu</label>
                                <input type="password" class="form-control rounded-3" id="password_confirm"
                                    name="password_confirmation" placeholder="********" required>
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label fw-semibold">Số Điện Thoại</label>
                                <input type="text" class="form-control rounded-3" id="phone" name="phone"
                                    placeholder="0123 456 789">
                            </div>
                            <div class="col-md-6">
                                <label for="address" class="form-label fw-semibold">Địa Chỉ</label>
                                <input type="text" class="form-control rounded-3" id="address" name="address"
                                    placeholder="123 Đường ABC, TP.HCM">
                            </div>
                            <div class="col-md-6">
                                <label for="gender" class="form-label fw-semibold">Giới Tính</label>
                                <select class="form-select rounded-3" id="gender" name="gender" required>
                                    <option value="">Chọn Giới Tính</option>
                                    <option value="Male">Nam</option>
                                    <option value="Female">Nữ</option>
                                    <option value="Other">Khác</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="avatar" class="form-label fw-semibold">Ảnh Đại Diện</label>
                                <input type="file" class="form-control rounded-3" id="avatar" name="avatar"
                                    accept="image/*">
                            </div>
                            <div class="col-12">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="agree_terms" name="agree_terms"
                                        value="1" required>
                                    <label class="form-check-label text-muted" for="agree_terms">Tôi đồng ý với tất cả
                                        điều
                                        khoản</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" id="registerBtn"
                                    class="btn btn-primary w-100 rounded-3 fw-bold">Đăng
                                    Ký</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="container-fluid bg-secondary text-dark mt-5 pt-5">
            <div class="row px-xl-5 pt-5">
                <div class="col-lg-4 col-md-12 mb-5 pr-3 pr-xl-5">
                    <a href="" class="text-decoration-none">
                        <h1 class="mb-4 display-5 font-weight-semi-bold"><span
                                class="text-primary font-weight-bold border border-white px-3 mr-1">Ethereal</span>Noir
                        </h1>

                    </a>

                    <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>13 P.Trịnh Văn Bô, Xuân
                        Phương, Nam
                        Từ Liêm, Hà Nội</p>
                    <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i></p>
                    <p class="mb-0"><i class="fa fa-phone-alt text-primary mr-3"></i>+012 345 67890</p>
                </div>
                <div class="col-lg-8 col-md-12">
                    <div class="row">
                        <div class="col-md-4 mb-5">
                            <h5 class="font-weight-bold text-dark mb-4">Quick Links</h5>
                            <div class="d-flex flex-column justify-content-start">
                                <a class="text-dark mb-2" href="index.html"><i
                                        class="fa fa-angle-right mr-2"></i>Home</a>
                                <a class="text-dark mb-2" href="shop.html"><i class="fa fa-angle-right mr-2"></i>Our
                                    Shop</a>
                                <a class="text-dark mb-2" href="detail.html"><i class="fa fa-angle-right mr-2"></i>Shop
                                    Detail</a>
                                <a class="text-dark mb-2" href="cart.html"><i
                                        class="fa fa-angle-right mr-2"></i>Shopping
                                    Cart</a>
                                <a class="text-dark mb-2" href="checkout.html"><i
                                        class="fa fa-angle-right mr-2"></i>Checkout</a>
                                <a class="text-dark" href="contact.html"><i class="fa fa-angle-right mr-2"></i>Contact
                                    Us</a>
                            </div>
                        </div>
                        <div class="col-md-4 mb-5">
                            <h5 class="font-weight-bold text-dark mb-4">Quick Links</h5>
                            <div class="d-flex flex-column justify-content-start">
                                <a class="text-dark mb-2" href="index.html"><i
                                        class="fa fa-angle-right mr-2"></i>Home</a>
                                <a class="text-dark mb-2" href="shop.html"><i class="fa fa-angle-right mr-2"></i>Our
                                    Shop</a>
                                <a class="text-dark mb-2" href="detail.html"><i class="fa fa-angle-right mr-2"></i>Shop
                                    Detail</a>
                                <a class="text-dark mb-2" href="cart.html"><i
                                        class="fa fa-angle-right mr-2"></i>Shopping
                                    Cart</a>
                                <a class="text-dark mb-2" href="checkout.html"><i
                                        class="fa fa-angle-right mr-2"></i>Checkout</a>
                                <a class="text-dark" href="contact.html"><i class="fa fa-angle-right mr-2"></i>Contact
                                    Us</a>
                            </div>
                        </div>
                        <div class="col-md-4 mb-5">
                            <h5 class="font-weight-bold text-dark mb-4">Newsletter</h5>
                            <form action="">
                                <div class="form-group">
                                    <input type="text" class="form-control border-0 py-4" placeholder="Your Name"
                                        required="required" />
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control border-0 py-4" placeholder="Your Email"
                                        required="required" />
                                </div>
                                <div>
                                    <button class="btn btn-primary btn-block border-0 py-3" type="submit">Subscribe
                                        Now</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row border-top border-light mx-xl-5 py-4">
                <div class="col-md-6 px-xl-0">
                    <p class="mb-md-0 text-center text-md-left text-dark">
                        &copy; <a class="text-dark font-weight-semi-bold" href="#">Your Site Name</a>. All Rights
                        Reserved.
                        Designed
                        by
                        <a class="text-dark font-weight-semi-bold" href="https://htmlcodex.com">HTML Codex</a><br>
                        Distributed By <a href="https://themewagon.com" target="_blank">ThemeWagon</a>
                    </p>
                </div>
                <div class="col-md-6 px-xl-0 text-center text-md-right">
                    <img class="img-fluid" src="img/payments.png" alt="">
                </div>
            </div>
        </div>
        <!-- Footer End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>


        <!-- JavaScript Libraries -->
        <script src="{{ asset('website/js/main.js') }}"></script>
        <script src="{{ asset('website/lib/easing/easing.js') }}"></script>
        <script src="{{ asset('website/lib/easing/easing.min.js') }}"></script>
        <script src="{{ asset('website/lib/owlcarousel/assets/ajax-loader.gif') }}"></script>
        <script src="{{ asset('website/lib/owlcarousel/assets/owl.carousel.css') }}"></script>
        <script src="{{ asset('website/lib/owlcarousel/assets/owl.carousel.min.css') }}"></script>
        <script src="{{ asset('website/lib/owlcarousel/assets/owl.theme.default.css') }}"></script>
        <script src="{{ asset('website/lib/owlcarousel/assets/owl.theme.default.min.css') }}"></script>
        <script src="{{ asset('website/lib/owlcarousel/assets/owl.theme.green.css') }}"></script>
        <script src="{{ asset('website/lib/owlcarousel/assets/owl.theme.green.min.css') }}"></script>
        <script src="{{ asset('website/lib/owlcarousel/assets/owl.video.play.png') }}"></script>
        <script src="{{ asset('website/lib/owlcarousel/LICENSE') }}"></script>
        <script src="{{ asset('website/lib/owlcarousel/owl.carousel.js') }}"></script>
        <script src="{{ asset('website/lib/owlcarousel/owl.carousel.min.js') }}"></script>
        <script src="{{ asset('website/mail/contact.js') }}"></script>
        <script src="{{ asset('website/mail/jqBootstrapValidation.min.js') }}"></script>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>



        <!-- Contact Javascript File -->
        <script src="{{ asset('website/js/main.js') }}"></script>
        <script src="{{ asset('website/js/main.js') }}"></script>

        <!-- Template Javascript -->
        <script src="{{ asset('website/js/main.js') }}"></script>
</body>

</html>
</div>
</body>

</html>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    $('#form_register').submit(function(e) {
        e.preventDefault();

        let firstName = $('#first_name').val().trim();
        let lastName = $('#last_name').val().trim();
        let username = $('#name').val().trim();
        let email = $('#email').val().trim();
        let password = $('#password').val();
        let confirmPassword = $('#password_confirm').val();
        let phone = $('#phone').val().trim();
        let gender = $('#gender').val();
        let agreeTerms = $('#agree_terms').prop('checked');

        // Kiểm tra Họ và Tên
        if (firstName === '' || lastName === '') {
            Swal.fire("Lỗi", "Họ và Tên không được để trống!", "error");
            return;
        }

        // Kiểm tra tên đăng nhập
        if (username === '') {
            Swal.fire("Lỗi", "Tên đăng nhập không được để trống!", "error");
            return;
        }

        // Kiểm tra email hợp lệ
        let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            Swal.fire("Lỗi", "Email không hợp lệ!", "error");
            return;
        }

        // Kiểm tra mật khẩu dài ít nhất 6 ký tự
        if (password.length < 6) {
            Swal.fire("Lỗi", "Mật khẩu phải có ít nhất 6 ký tự!", "error");
            return;
        }

        // Kiểm tra mật khẩu trùng khớp
        if (password !== confirmPassword) {
            Swal.fire("Lỗi", "Mật khẩu không trùng khớp!", "error");
            return;
        }

        // Kiểm tra số điện thoại (Việt Nam - chỉ số từ 10-11 số bắt đầu bằng 0)
        let phoneRegex = /^(0[1-9][0-9]{8,9})$/;
        if (phone !== '' && !phoneRegex.test(phone)) {
            Swal.fire("Lỗi", "Số điện thoại không hợp lệ!", "error");
            return;
        }

        // Kiểm tra giới tính
        if (gender === '') {
            Swal.fire("Lỗi", "Vui lòng chọn giới tính!", "error");
            return;
        }

        // Kiểm tra điều khoản
        if (!agreeTerms) {
            Swal.fire("Lỗi", "Bạn phải đồng ý với các điều khoản!", "error");
            return;
        }

        // Nếu tất cả hợp lệ, gửi dữ liệu
        var formData = new FormData(this);
        formData.append('status', 1);
        formData.append('is_admin', 0);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "{{ route('web.register.store') }}",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                Swal.fire({
                    title: "Thành Công",
                    text: "Đăng ký thành công! Đang chuyển hướng đến đăng nhập...",
                    icon: "success",
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = "{{ route('web.login') }}";
                });
            },
            error: function(xhr) {
                if (xhr.status === 400 && xhr.responseJSON?.errors) {
                    let errorMessages = "";
                    $.each(xhr.responseJSON.errors, function(field, messages) {
                        messages.forEach(message => {
                            errorMessages += `<p>⚠️ ${message}</p>`;
                        });
                    });

                    Swal.fire({
                        title: "Lỗi!",
                        html: errorMessages,
                        icon: "error"
                    });
                } else {
                    Swal.fire("Lỗi", "Đăng ký thất bại! Vui lòng thử lại.", "error");
                }
            }
        });
    });
});
</script>