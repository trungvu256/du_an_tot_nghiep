@extends('web2.layout.master')

@section('content')
<div class="container-fluid">
    <div class="row border-top px-xl-5">
        <div class="col-lg-3 d-none d-lg-block">
            <a class="btn shadow-none d-flex align-items-center justify-content-between bg-primary text-white w-100"
                data-toggle="collapse" href="#navbar-vertical" style="height: 65px; margin-top: -1px; padding: 0 30px;">
                <h6 class="m-0">Categories</h6>
                <i class="fa fa-angle-down text-dark"></i>
            </a>
            <nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 border border-top-0 border-bottom-0 bg-light"
                id="navbar-vertical" style="width: calc(100% - 30px); z-index: 1;">
                <div class="navbar-nav w-100 overflow-hidden" style="height: 410px">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link" data-toggle="dropdown">Dresses <i
                                class="fa fa-angle-down float-right mt-1"></i></a>
                        <div class="dropdown-menu position-absolute bg-secondary border-0 rounded-0 w-100 m-0">
                            <a href="" class="dropdown-item">Men's Dresses</a>
                            <a href="" class="dropdown-item">Women's Dresses</a>
                            <a href="" class="dropdown-item">Baby's Dresses</a>
                        </div>
                    </div>
                    <a href="" class="nav-item nav-link">Shirts</a>
                    <a href="" class="nav-item nav-link">Jeans</a>
                    <a href="" class="nav-item nav-link">Swimwear</a>
                    <a href="" class="nav-item nav-link">Sleepwear</a>
                    <a href="" class="nav-item nav-link">Sportswear</a>
                    <a href="" class="nav-item nav-link">Jumpsuits</a>
                    <a href="" class="nav-item nav-link">Blazers</a>
                    <a href="" class="nav-item nav-link">Jackets</a>
                    <a href="" class="nav-item nav-link">Shoes</a>
                </div>
            </nav>
        </div>
        <div class="col-lg-9">
            <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0">
                <a href="" class="text-decoration-none d-block d-lg-none">
                    <h1 class="m-0 display-5 font-weight-semi-bold"><span
                            class="text-primary font-weight-bold border px-3 mr-1">E</span>Shopper</h1>
                </a>
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                    @include('web2.layout.menu')


                    <div class="navbar-nav ml-auto py-0">


                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>
<!-- Navbar End -->


<div class="container mt-4">

    <div class="row">
        <!-- Cột bên trái: Thông tin tài khoản -->
        <div class="col-md-3">
            <div class="card p-3">
                <div class="text-center">
                    <img src="{{ Auth::user()->avatar ? asset('storage/avatars/' . Auth::user()->avatar) : asset('images/anhlogin.jpg') }}"
                    width="50" height="50" class="rounded-circle border" style="object-fit: cover;">
                
                    <p>Xin chào</p>
                    <h5 class="mt-2"><strong>{{ Auth::user()->name }}</strong></h5>
                    <p class="text-muted">Member</p>
                </div>

                <hr>
                <ul class="list-unstyled">
                    <li class="mb-2"><i class="fas fa-user-circle"></i> <a href="#"
                            class="text-decoration-none text-dark">Thông tin tài khoản</a></li>
                    <li class="mb-2"><i class="fas fa-box"></i> <a href="#" class="text-decoration-none text-dark">Đơn
                            hàng đã mua</a></li>
                    <li class="mb-2"><i class="fas fa-star"></i> <a href="#" class="text-decoration-none text-dark">Bình
                            luận đánh giá</a></li>
                    <li class="mb-2"><i class="fas fa-heart"></i> <a href="#" class="text-decoration-none text-dark">Sản
                            phẩm yêu thích</a></li>
                    <li class="mb-2"><i class="fas fa-sign-out-alt"></i> <a href="{{ route('web.logout') }}"
                            class="text-decoration-none text-danger">Thoát</a></li>
                </ul>
            </div>
        </div>

        <!-- Cột bên phải: Chỉnh sửa thông tin -->
        <div class="col-md-9">
            <div class="card p-4">
                <h4 class="text-center">THÔNG TIN TÀI KHOẢN</h4>
                <div class="text-center">
                   <img src="{{ Auth::user()->avatar ? asset('storage/avatars/' . Auth::user()->avatar) : asset('images/anhlogin.jpg') }}"
                        width="120" height="120" class="rounded-circle border" style="object-fit: cover;">

                </div>

                <form class="mt-4">
                    <div class="row">
                        <div class="col-md-6">
                            <label><strong>Họ & Tên (*)</strong></label>
                            <input type="text" class="form-control" value="{{ Auth::user()->name }}" disabled>
                        </div>
                        <div class="col-md-6">
                            <label><strong>Số điện thoại (*)</strong></label>
                            <input type="text" class="form-control" value="{{ Auth::user()->phone }}" disabled>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label><strong>Email</strong></label>
                            <div class="input-group">
                                <input type="text" class="form-control" value="{{ Auth::user()->email }}" disabled>
                                <button class="btn btn-outline-secondary">Xác thực</button>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <label><strong>Địa chỉ (*)</strong></label>
                        <textarea class="form-control" rows="2" disabled>{{ Auth::user()->address }}</textarea>
                    </div>

                    <div class="text-center mt-4">
                        <a href="{{ route('profile.edit') }}" class="btn btn-warning px-4">Chỉnh sửa thông tin</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection