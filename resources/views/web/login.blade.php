@extends('web2.layout.master')

@section('content')
<div class="breadcrumbs">
    <div class="container">
        <ol class="breadcrumb breadcrumb1 animated wow slideInLeft" data-wow-delay=".5s">
            <li><a href="/"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>Trang Chủ</a></li>
            <li class="active fw-bold">/ Đăng Nhập</li>
        </ol>
    </div>
</div>

<div class="login py-5">
    <div class="container d-flex justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-lg border-0 rounded-4 p-4">
                <h3 class="text-center mb-4 fw-bold text-primary">Đăng Nhập</h3>

                @if ($errors->any())
                <div class="alert alert-danger fw-bold">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('login.store.web') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold">📧 Địa chỉ Email</label>
                        <input type="email" name="email" class="form-control rounded-3 shadow-sm fw-bold"
                            placeholder="Nhập email của bạn" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label fw-bold">🔑 Mật khẩu</label>
                        <input type="password" name="password" class="form-control rounded-3 shadow-sm fw-bold"
                            placeholder="Nhập mật khẩu" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 rounded-3 fw-bold shadow-sm"
                        style="transition: 0.3s;">
                        Đăng Nhập
                    </button>
                </form>

                <hr>

                <div class="text-center fw-bold">
                    <p class="mb-2">Dành cho người dùng mới?
                        <a href="{{ route('web.register') }}" class="text-primary fw-bold text-decoration-none">Đăng ký
                            ngay</a>
                    </p>
                    <p>
                        <a href="{{ route('web.forget') }}" class="text-danger text-decoration-none">🔄 Quên mật
                            khẩu?</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection