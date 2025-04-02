<div class="app-menu navbar-menu">
    <div class="navbar-brand-box">
        <a href="{{ route('admin.dashboard') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset('template/admin/velzon/assets/images/logo04.JPG') }}" alt="" height="50">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('template/admin/velzon/assets/images/logo04.JPG') }}" alt="" height="150">
            </span>
        </a>
        <a href="{{ route('admin.dashboard') }}" class="logo logo-light">
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
                <li class="menu-title"><span data-key="t-menu">DANH SÁCH</span></li>


                <!-- Thống kê -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('admin.dashboard') }}">
                        <i class="ri-bar-chart-box-line"></i> <span>Thống kê</span>
                    </a>
                </li>

                <!-- Khách hàng -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#khachhang" data-bs-toggle="collapse" role="button">
                        <i class="ri-user-line"></i> <span>Khách hàng</span>
                    </a>
                    <div class="collapse menu-dropdown" id="khachhang" data-bs-parent="#accordionSidebar">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin.user') }}" class="nav-link">Khách hàng</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('customer.index')}}" class="nav-link">Nhóm khách hàng</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Đơn hàng -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#donhang" data-bs-toggle="collapse" role="button">
                        <i class="ri-shopping-bag-line"></i> <span>Đơn hàng</span>
                    </a>
                    <div class="collapse menu-dropdown" id="donhang" data-bs-parent="#accordionSidebar">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{route('admin.order')}}" class="nav-link">Danh sách đơn hàng</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.return.index')}}" class="nav-link">Trả hàng</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.orders.unfinished')}}" class="nav-link">Đơn chưa hoàn tất</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <!-- Vận chuyển -->

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#menuShipping" data-bs-toggle="collapse" role="button">
                        <i class="ri-truck-line"></i> <span>Vận chuyển</span>
                    </a>
                    <div class="collapse menu-dropdown" id="menuShipping">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin.shipping.overview') }}" class="nav-link">Tổng quan</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.shipping.orders') }}" class="nav-link">Vận đơn</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!--Danh mục -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#menuCata" data-bs-toggle="collapse" role="button">
                        <i class="bi bi-list-check"></i> <span>Danh mục</span>
                    </a>
                    <div class="collapse menu-dropdown" id="menuCata" data-bs-parent="#accordionSidebar">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('catalogues.index') }}" class="nav-link">Danh sách danh mục</a>
                            </li>
                        </ul>
                    </div>
                </li>
                {{-- <!-- Sản phẩm (Gộp cả danh mục) --> --}}

                <!--Product-->

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#menuProduct" data-bs-toggle="collapse" role="button">
                        <i class="ri-archive-line"></i> <span>Sản phẩm</span>
                    </a>
                    <div class="collapse menu-dropdown" id="menuProduct" data-bs-parent="#accordionSidebar">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin.product') }}" class="nav-link">Danh sách sản phẩm</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('variant.create')}}" class="nav-link">Các thuộc tính</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('product-comments.index') }}" class="nav-link">Bình luận</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('product-reviews.index') }}" class="nav-link">Đánh giá</a>
                            </li>
                            {{-- <li class="nav-item">
                                <a href="{{ route('attributes.index') }}" class="nav-link">Thuộc tính</a>
                            </li> --}}
                        </ul>
                    </div>
                </li>

                <!--Thương hiệu-->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#menuBrands" data-bs-toggle="collapse" role="button">
                        <i class="bi bi-tag"></i> <span>Thương hiệu</span>
                    </a>
                    <div class="collapse menu-dropdown" id="menuBrands" data-bs-parent="#accordionSidebar">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('brands.index') }}" class="nav-link">Danh sách thương hiệu</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Khuyến mại -->
                {{-- <li class="nav-item">
                    <a href="" class="nav-link menu-link">
                        <i class="ri-gift-line"></i> <span>Khuyến mại</span>
                    </a>
                </li> --}}

                <!--Ví Tiền-->
                {{-- <li class="nav-item">
                    <a href="{{ route('wallet.show') }}" class="nav-link menu-link">
                        <i class="ri-wallet-line"></i> <span>Sổ quỹ</span>
                    </a>
                </li> --}}


                <!-- Bài viết -->
                <li class="nav-item">
                    <a href="{{ route('admin.blog') }}" class="nav-link menu-link"><i class="ri-file-list-line"></i>
                        <span>Bài
                            viết</span></a>
                </li>


                <!-- Blog -->
                {{-- <li class="nav-item">
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
                </li> --}}

                {{-- <li class="nav-item">
                    <a class="nav-link menu-link" href="#menuBlog" data-bs-toggle="collapse" role="button">
                        <i class="ri-newspaper-line"></i> <span>Bài viết</span>
                    </a>
                    <div class="collapse menu-dropdown" id="menuBlog">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin.create.blog') }}" class="nav-link">Thêm mới bài viết</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.blog') }}" class="nav-link">Danh sách bài viết</a>
                            </li>
                        </ul>
                    </div>
                </li> --}}

                <!--Discount-->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#menuPromotions&Discounts" data-bs-toggle="collapse" role="button">
                        <i class="ri-ticket-line"></i> <span>Khuyến mại</span>
                    </a>
                    <div class="collapse menu-dropdown" id="menuPromotions&Discounts" data-bs-parent="#accordionSidebar">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('promotions.index') }}" class="nav-link">Mã Giảm Giá</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('discounts.index') }}" class="nav-link">Danh Mục & Sản Phẩm</a>
                            </li>
                        </ul>
                    </div>
                </li>


                {{-- <li class="nav-item">
                    <a class="nav-link menu-link" href="#menuPromotions&Discounts" data-bs-toggle="collapse" role="button">
                        <i class="ri-ticket-line"></i> <span>Khuyến mại</span>
                    </a>
                    <div class="collapse menu-dropdown" id="menuPromotions&Discounts">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('promotions.index') }}" class="nav-link">Mã Giảm Giá</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('discounts.index') }}" class="nav-link">Danh Mục & Sản Phẩm</a>
                            </li>
                        </ul>
                    </div>

                </li> --}}
            </ul>
        </div>
    </div>


    <div class="sidebar-background"></div>
</div>

<style>
.nav-link::after {
    content: none !important;
}

.nav-sm {
    list-style: none;
    padding-left: 0;
}
</style>

