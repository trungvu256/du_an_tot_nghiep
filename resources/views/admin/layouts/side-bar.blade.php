<div class="app-menu navbar-menu">
    <div class="navbar-brand-box">
        <a href="index.html" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset('template/admin/velzon/assets/images/logo04.JPG') }}" alt="" height="50">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('template/admin/velzon/assets/images/logo04.JPG') }}" alt="" height="150">
            </span>
        </a>
        <a href="index.html" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ asset('template/admin/velzon/assets/images/logo03.JPG') }}" alt="" height="60">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('template/admin/velzon/assets/images/logo03.JPG') }}" alt="" height="170">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">
            <div id="two-column-menu"></div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu">Menu</span></li>

                <!--dashboard-->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('admin.dashboard') }}" data-bs-toggle="" role="button">
                        <i class="ri-file-list-line"></i> <span>Dashboard</span>
                    </a>
                </li>

                <!-- User -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#menuUser" data-bs-toggle="collapse" role="button">
                        <i class="ri-user-line"></i> <span>User</span>
                    </a>
                    <div class="collapse menu-dropdown" id="menuUser">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin.user') }}" class="nav-link">List User</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Category -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#menuCategory" data-bs-toggle="collapse" role="button">
                        <i class="ri-dashboard-2-line"></i> <span>Category</span>
                    </a>
                    <div class="collapse menu-dropdown" id="menuCategory">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin.create.cate') }}" class="nav-link">Add Category</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.cate') }}" class="nav-link">List Category</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Product -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#menuProduct" data-bs-toggle="collapse" role="button">
                        <i class="ri-shopping-cart-line"></i> <span>Product</span>
                    </a>
                    <div class="collapse menu-dropdown" id="menuProduct">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin.add.product') }}" class="nav-link">Add Product</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.product') }}" class="nav-link">List Product</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Order -->
                <li class="nav-item">
                    <a href="{{ route('admin.order') }}" class="nav-link menu-link">
                        <i class="ri-shopping-bag-3-line"></i> <span>Đơn Hàng</span>
                    </a>
                </li>

                <!-- Ví Tiền -->
                <li class="nav-item">
                    <a href="{{ route('wallet.show') }}" class="nav-link menu-link">
                        <i class="ri-wallet-3-line"></i> <span>Ví Tiền</span>
                    </a>
                </li>


                <!-- Blog -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#menuBlog" data-bs-toggle="collapse" role="button">
                        <i class="ri-file-list-line"></i> <span>Blog</span>
                    </a>
                    <div class="collapse menu-dropdown" id="menuBlog">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin.create.blog') }}" class="nav-link">Add Blog</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.blog') }}" class="nav-link">List Blog</a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="sidebar-background"></div>
</div>