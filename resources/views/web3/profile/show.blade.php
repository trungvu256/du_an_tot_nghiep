
@extends('web3.layout.master2')
@section('content')
<div class="container mt-4">
    <div class="row">
        <!-- Cột bên trái: Thông tin tài khoản -->
        <div class="col-md-3">
            <div class="card p-3">
                <div class="text-center">
                    <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('images/anhlogin.jpg') }}"
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
                    <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('images/anhlogin.jpg') }}"
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
                        <div class="col-md-7">
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