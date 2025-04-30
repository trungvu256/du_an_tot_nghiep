@extends('web3.layout.master2')

@section('content')
    <style>
        .tf-breadcrumb {
            background: #f8f9fa;
            padding: 1rem 0;
            margin-bottom: 2rem;
        }

        .breadcrumb-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            align-items: center;
        }

        .item-breadcrumb {
            font-size: 0.9rem;
            color: #495057;
        }

        .item-breadcrumb a {
            text-decoration: none;
            color: #007bff;
        }

        .item-breadcrumb.dot span {
            margin: 0 0.5rem;
            color: #6c757d;
        }

        .user-info {
            background: #ffffff;
            border-radius: 0.5rem;
            padding: 1.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .user-info ul {
            padding: 0;
        }

        .user-info li {
            margin-bottom: 0.5rem;
        }

        .user-info-link {
            display: block;
            padding: 0.75rem;
            color: #343a40;
            text-decoration: none;
            border-radius: 0.25rem;
            transition: background 0.2s ease;
        }

        .user-info-link:hover {
            background: #f1f3f5;
            color: #007bff;
        }

        .btn-light.border-dark {
            transition: background 0.2s ease, color 0.2s ease;
        }

        .btn-light.border-dark:hover {
            background: #dc3545;
            color: #fff;
            border-color: #dc3545;
        }

        .form-container {
            background: #ffffff;
            border-radius: 0.5rem;
            padding: 2rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .form-control {
            border-radius: 0.25rem;
            padding: 0.75rem;
            border: 1px solid #ced4da;
            transition: border-color 0.2s ease;
        }

        .form-control:focus {
            border-color: #28a745;
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
        }

        .btn-primary, .btn-success {
            border-radius: 0.25rem;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            transition: background 0.2s ease;
        }

        .alert {
            border-radius: 0.25rem;
            padding: 0.75rem;
            font-size: 0.9rem;
        }

        .bi {
            margin-right: 0.5rem;
        }

        @media (max-width: 768px) {
            .user-info {
                margin-bottom: 1.5rem;
            }

            .form-container {
                padding: 1.5rem;
            }

            .btn-primary, .btn-success {
                padding: 0.5rem 1rem;
                font-size: 0.9rem;
            }
        }
        .btn-custom {
    background-color: black;
    color: white;
    font-weight: normal;
    padding: 0.5rem 1rem;
    border-radius: 4px;
    text-decoration: none;
}

.btn-custom:hover {
    font-weight: bold;
}

    </style>

    <div id="wrapper">
        <!-- Breadcrumb -->
        <div class="tf-breadcrumb">
            <div class="container">
                <ul class="breadcrumb-list">
                    <li class="item-breadcrumb">
                        <a href="/" class="text">Trang chủ</a>
                    </li>
                    <li class="item-breadcrumb dot">
                        <span></span>
                    </li>
                    <li class="item-breadcrumb">
                        <span class="text">Xác nhận mật khẩu</span>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /Breadcrumb -->

        <div class="container">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-md-3">
                    <div class="user-info">
                        <ul class="list-unstyled">
                            <li>
                                <a href="{{ route('profile') }}" class="user-info-link">
                                    <i class="bi bi-person"></i> Thông tin cá nhân
                                </a>
                            </li>
                            <hr>
                            <li>
                                <a href="{{ route('donhang.index') }}" class="user-info-link">
                                    <i class="bi bi-cart"></i> Đơn hàng của bạn
                                </a>
                            </li>
                            <hr>
                            <li>
                                <a href="{{ route('address.index') }}" class="user-info-link">
                                    <i class="bi bi-geo-alt"></i> Địa chỉ của bạn
                                </a>
                            </li>
                            <hr>
                            <li>
                                <a href="{{ route('web.logout') }}" class="btn btn-light border-dark text-dark btn-sm w-100 hover-logout">
                                    <i class="bi bi-box-arrow-right"></i> ĐĂNG XUẤT
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="col-md-9">
                    <div class="form-container text-center">
                        <h5 class="mb-3 ">Xác nhận mật khẩu</h5>
                        <p class="text-muted mb-4">Vui lòng nhập mật khẩu để tiếp tục chỉnh sửa thông tin.</p>

                        @if (session('error'))
                            <div id="successAlert" class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <form action="{{ route('profile.check_password') }}" method="POST" class="mx-auto" style="max-width: 400px;">
                            @csrf
                            <div class="mb-3">
                                <input type="password" id="password" class="form-control" name="password"
                                       placeholder="Nhập mật khẩu của bạn" required>
                            </div>
                            <div class="d-flex justify-content-center gap-3">
                            <a href="{{ route('profile') }}" 
   class="btn" 
   style="background-color: black; color: white; font-weight: normal;" 
   onmouseover="this.style.fontWeight='bold'" 
   onmouseout="this.style.fontWeight='normal'">
    Quay lại
</a>


<button type="submit"
    class="btn"
    style="background-color: white; color: black; border: 1px solid black;"
    onmouseover="this.style.backgroundColor='black'; this.style.color='white';"
    onmouseout="this.style.backgroundColor='white'; this.style.color='black';">
    Xác nhận
</button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection