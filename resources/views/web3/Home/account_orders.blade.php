@extends('web3.layout.master2')
@section('content')

<body>
    <div id="wrapper">


        <div class="main-content-account">

            <!-- Breadcrumb -->
            <div class="tf-breadcrumb">
                <div class="container">
                    <ul class="breadcrumb-list">
                        <li class="item-breadcrumb">
                            <a href="index-2.html" class="text">Home</a>
                        </li>
                        <li class="item-breadcrumb dot">
                            <span></span>
                        </li>
                        <li class="item-breadcrumb">
                            <span class="text">Account</span>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- /Breadcrumb -->

            <!-- Title Page -->
            <section class="s-title-page">
                <div class="container">
                    <h4 class="s-title letter-0 text-center">
                        My Account
                    </h4>
                </div>
            </section>
            <!-- /Title Page -->

            <!-- sidebar-account -->
            <div class="btn-sidebar-mb d-lg-none">
                <button data-bs-toggle="offcanvas" data-bs-target="#mbAccount">
                    <i class="icon icon-sidebar"></i>
                </button>
            </div>
            <!-- /sidebar-account -->

            <!-- Section-acount -->
            <section class="s-account flat-spacing-17">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="my-account-container">
                                <div class="sidebar-account-wrap sidebar-content-wrap sticky-top d-lg-block d-none">
                                    <ul class="my-account-nav">
                                        <li>
                                            <a href="account-page.html"
                                                class="text-sm link fw-medium my-account-nav-item">Dashboard</a>
                                        </li>
                                        <li>
                                            <a href="account-orders.html"
                                                class="text-sm link fw-medium my-account-nav-item active">My Orders</a>
                                        </li>
                                        <li>
                                            <a href="wish-list.html"
                                                class="text-sm link fw-medium my-account-nav-item ">My
                                                Wishlist</a>
                                        </li>
                                        <li>
                                            <a href="account-addresses.html"
                                                class="text-sm link fw-medium my-account-nav-item ">Addresses</a>
                                        </li>
                                        <li>
                                            <a href="index-2.html"
                                                class="text-sm link fw-medium my-account-nav-item ">Log
                                                Out</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="my-acount-content account-orders">
                                    <div class="account-no-orders-wrap">
                                        <img class="lazyload" data-src="images/section/account-no-order.png"
                                            src="images/section/account-no-order.png" alt="">
                                        <div class="display-sm fw-medium title">You haven’t placed any order yet</div>
                                        <div class="text text-sm">It’s time to make your first order</div>
                                        <a href="shop-fullwidth.html"
                                            class="tf-btn animate-btn d-inline-flex bg-dark-2 justify-content-center">Shop
                                            Now</a>
                                    </div>
                                    <div class="account-orders-wrap">
                                        <h5 class="title">
                                            Order History
                                        </h5>
                                        <div class="wrap-account-order">
                                            <table>
                                                <thead>
                                                    <tr>
                                                        <th class="text-md fw-medium">Order ID</th>
                                                        <th class="text-md fw-medium">Date</th>
                                                        <th class="text-md fw-medium">Status</th>
                                                        <th class="text-md fw-medium">Total</th>
                                                        <th class="text-md fw-medium">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="tf-order-item">
                                                        <td class="text-md">
                                                            #12345
                                                        </td>
                                                        <td class="text-md">
                                                            15 May 2024
                                                        </td>
                                                        <td class="text-md text-delivered">
                                                            Delivered
                                                        </td>
                                                        <td class="text-md">
                                                            $690 / 3 items
                                                        </td>
                                                        <td>
                                                            <a href="#order_detail" data-bs-toggle="modal"
                                                                class="view-detail">Detail</a>
                                                        </td>
                                                    </tr>
                                                    <tr class="tf-order-item">
                                                        <td class="text-md">
                                                            #12345
                                                        </td>
                                                        <td class="text-md">
                                                            15 May 2024
                                                        </td>
                                                        <td class="text-md text-delivered">
                                                            Delivered
                                                        </td>
                                                        <td class="text-md">
                                                            $690 / 3 items
                                                        </td>
                                                        <td>
                                                            <a href="#order_detail" data-bs-toggle="modal"
                                                                class="view-detail">Detail</a>
                                                        </td>
                                                    </tr>
                                                    <tr class="tf-order-item">
                                                        <td class="text-md">
                                                            #12345
                                                        </td>
                                                        <td class="text-md">
                                                            15 May 2024
                                                        </td>
                                                        <td class="text-md text-on-the-way">
                                                            On the way
                                                        </td>
                                                        <td class="text-md">
                                                            $690 / 3 items
                                                        </td>
                                                        <td>
                                                            <a href="#order_detail" data-bs-toggle="modal"
                                                                class="view-detail">Detail</a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- /Account -->
        </div>
        <div class="offcanvas offcanvas-start canvas-filter canvas-sidebar canvas-sidebar-account" id="mbAccount">
            <div class="canvas-wrapper">
                <div class="canvas-header">
                    <span class="title">SIDEBAR ACCOUNT</span>
                    <button class="icon-close icon-close-popup" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="canvas-body">
                    <div class="sidebar-account-wrap sidebar-mobile-append"></div>
                </div>
            </div>
        </div>
        <!-- End sidebar account -->

        <!-- order-detail -->
        <div class="modal fade modalCentered modal-order-detail" id="order_detail">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="header">
                        <div class="heading">Order Detail</div>
                        <span class="icon-close icon-close-popup" data-bs-dismiss="modal"></span>
                    </div>
                    <ul class="list-infor">
                        <li>#12345</li>
                        <li>15 May 2024</li>
                        <li>6 items</li>
                        <li class="text-delivered">Delivered</li>
                    </ul>
                    <div class="tb-order-detail">
                        <div class="top">
                            <div class="title item">Product</div>
                            <div class="title item d-md-block d-none">Quantity</div>
                            <div class="title item d-md-block d-none">Price</div>
                            <div class="title item d-md-block d-none">Total</div>
                        </div>
                        <div class="tb-content">
                            <div class="order-detail-item">
                                <div class="item">
                                    <div class="infor-content">
                                        <div class="image">
                                            <a href="product-detail.html">
                                                <img class="lazyload" data-src="images/products/fashion/product-1.jpg"
                                                    src="images/products/fashion/product-1.jpg" alt="img-product">
                                            </a>
                                        </div>
                                        <div>
                                            <a class="link" href="product-detail.html">Loose Fit Tee</a>
                                            <div class="size">White / L</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item" data-title="Quantity">
                                    2
                                </div>
                                <div class="item" data-title="Price">
                                    $130.00
                                </div>
                                <div class="item" data-title="Total">
                                    $260.00
                                </div>
                            </div>
                            <div class="order-detail-item">
                                <div class="item">
                                    <div class="infor-content">
                                        <div class="image">
                                            <a href="product-detail.html">
                                                <img class="lazyload" data-src="images/products/fashion/product-2.jpg"
                                                    src="images/products/fashion/product-2.jpg" alt="img-product">
                                            </a>
                                        </div>
                                        <div>
                                            <a class="link" href="product-detail.html">Loose Fit Tee</a>
                                            <div class="size">White / L</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item" data-title="Quantity">
                                    2
                                </div>
                                <div class="item" data-title="Price">
                                    $130.00
                                </div>
                                <div class="item" data-title="Total">
                                    $260.00
                                </div>
                            </div>
                            <div class="order-detail-item">
                                <div class="item">
                                    <div class="infor-content">
                                        <div class="image">
                                            <a href="product-detail.html">
                                                <img class="lazyload" data-src="images/products/fashion/product-3.jpg"
                                                    src="images/products/fashion/product-3.jpg" alt="img-product">
                                            </a>
                                        </div>
                                        <div>
                                            <a class="link" href="product-detail.html">Loose Fit Tee</a>
                                            <div class="size">White / L</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item" data-title="Quantity">
                                    2
                                </div>
                                <div class="item" data-title="Price">
                                    $130.00
                                </div>
                                <div class="item" data-title="Total">
                                    $260.00
                                </div>
                            </div>
                            <div class="order-detail-item subtotal">
                                <div class="item d-md-block d-none"></div>
                                <div class="item d-md-block d-none"></div>
                                <div class="item subtotal-text">
                                    Subtotal:
                                </div>
                                <div class="item subtotal-price">
                                    $720.00 USD
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bottom text-center">
                        Not happy with the order? You can <a href="return-and-refund.html"
                            class="fw-medium btn-underline">Request a free return</a> in <span class="fw-medium">14
                            days</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Main Content -->
    </div>

    <body>
        @endsection