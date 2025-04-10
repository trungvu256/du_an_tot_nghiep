<!DOCTYPE html>
<html lang="en">
   
    
<head>
    <meta charset="utf-8">
    <title>Ethereal Noir Shop</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">
    <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- CSRF token -->
    <meta name="register-url" content="{{ route('web.register.store') }}"> <!-- URL đăng ký -->
    <meta name="login-url" content="{{ route('web.login') }}">
    <meta name="login-url" content="{{ route('logout') }}"> <!-- URL đăng nhập -->
    @include('web3.layout.css')
    @include('web3.layout.header')
</head>

<body>
    @yield('content')
    @include('web3.layout.footer')


    
    @include('web3.layout.tab')
    @include('web3.layout.js')
</body>

</html>