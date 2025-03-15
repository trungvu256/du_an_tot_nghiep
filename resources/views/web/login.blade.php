@extends('web.layouts.master')
@section('content')
    <div class="breadcrumbs">
        <div class="container">
            <ol class="breadcrumb breadcrumb1 animated wow slideInLeft" data-wow-delay=".5s">
                <li><a href="/"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>Trang Chủ</a></li>
                <li class="active">Trang Đăng Nhập</li>
            </ol>
        </div>
    </div>

    <div class="login">
        <div class="container">
            <h3 class="animated wow zoomIn" data-wow-delay=".5s">Đăng Nhập</h3>
            <div class="login-form-grids animated wow slideInUp" data-wow-delay=".5s">
                @if ($errors->any())
                    <div class="alert alert-warning">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('login.store.web') }}" method="POST">
                    @csrf
                    <input type="email" name="email" placeholder="Địa chỉ Email">
                    <input type="password" name="password" placeholder="Mật khẩu">
                    <input type="submit" value="Đăng Nhập">
                </form>
                
                <a class="btn btn-outline-dark" href="{{ route('login.google') }}" role="button" style="text-transform:none;margin-left: 130px;">
                    <img width="20px" style="margin-bottom:3px; margin-right:5px" alt="Google sign-in"
                        src="{{ asset('images/search.png') }}" />
                    Đăng nhập với Google
                </a>
            </div>
        </div>

        <h4 class="animated wow slideInUp" data-wow-delay=".5s">Dành cho người dùng mới</h4>
        <p class="animated wow slideInUp" data-wow-delay=".5s">
            <a href="{{ route('web.register') }}">Đăng ký ngay</a>
            (Hoặc) quay lại <a href="{{ route('web.forget') }}">Quên mật khẩu<span
                    class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></a>
        </p>
    </div>
@endsection
