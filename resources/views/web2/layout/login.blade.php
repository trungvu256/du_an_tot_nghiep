<div class="navbar-nav mr-5 py-0">
    <!-- Đổi từ ml-auto sang mr-auto -->
    <div class="dropdown d-inline">
        <a href="#" class="btn border dropdown-toggle" data-toggle="dropdown">
            <i class="fas fa-user" style="font-size: 24px;"></i>
        </a>
        <div class="dropdown-menu">
            @auth
            <a class="dropdown-item" href="{{ route('profile') }}">Thông tin cá nhân</a>
            <a class="dropdown-item" href="{{ route('web.logout') }}">Đăng xuất</a>
            @else
            <a class="dropdown-item" href="{{ route('web.login') }}">Đăng nhập</a>
            <a class="dropdown-item" href="{{ route('web.register') }}">Đăng ký</a>
            @endauth
        </div>
    </div>
</div>