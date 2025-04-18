@extends('web3.layout.master2')
@section('content')
    <div class="container mt-4">
        <div class="row">
            <!-- Cột bên trái: Thông tin tài khoản -->
            <div class="col-md-2"></div>
            <div class="col-md-3">
                <div class="card p-3 mb-3">
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
                        <li class="mb-2"><i class="fas fa-box"></i> <a href="#"
                                class="text-decoration-none text-dark">Đơn
                                hàng đã mua</a></li>
                        <li class="mb-2"><i class="fas fa-star"></i> <a href="#"
                                class="text-decoration-none text-dark">Bình
                                luận đánh giá</a></li>
                        <li class="mb-2"><i class="fas fa-heart"></i> <a href="#"
                                class="text-decoration-none text-dark">Sản
                                phẩm yêu thích</a></li>
                        <li class="mb-2"><i class="fas fa-sign-out-alt"></i> <a href="{{ route('web.logout') }}"
                                class="text-decoration-none text-danger">Thoát</a></li>
                    </ul>
                </div>
            </div>

            <!-- Cột bên phải: Chỉnh sửa thông tin -->
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header">
                        <h4 class="text-center">THÔNG TIN TÀI KHOẢN</h4>
                        <div class="text-center">
                            <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('images/anhlogin.jpg') }}"
                                width="120" height="120" class="rounded-circle border" style="object-fit: cover;">

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3 pb-3 px-3" style="border-bottom:1px solid #ebebeb; font-weight:600">
                            <div class="col-5">Họ & tên : </div>
                            <div class="col-7">{{ Auth::user()->name }}</div>
                        </div>
                        <div class="row mb-3 pb-3 px-3" style="border-bottom:1px solid #ebebeb; font-weight:600">
                            <div class="col-5">Email : </div>
                            <div class="col-7">{{ Auth::user()->email }}</div>
                        </div>
                        <div class="row mb-3 pb-3 px-3" style="border-bottom:1px solid #ebebeb; font-weight:600">
                            <div class="col-5">Giới tính : </div>
                            <div class="col-7">{{ Auth::user()->gender = 'male' ? 'Nam' : 'Nữ' }}</div>
                        </div>
                        <div class="row mb-3 pb-3 px-3" style="border-bottom:1px solid #ebebeb; font-weight:600">
                            <div class="col-5">Số điện thoại : </div>
                            <div class="col-7">{{ Auth::user()->phone }}</div>
                        </div>
                        <div class="row mb-3 pb-3 px-3" style="border-bottom:1px solid #ebebeb; font-weight:600">
                            <div class="col-5">Địa chỉ : </div>
                            <div class="col-7">{{ Auth::user()->address }}</div>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ route('profile.edit') }}" class="btn btn-warning px-4">Chỉnh sửa thông tin</a>
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
@endsection
