@extends('web3.layout.master2')
@section('content')

<body>
    <div id="wrapper">

    </div>
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
        <section class="flat-spacing-2">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="my-account-container">
                            <div class="sidebar-account-wrap sidebar-content-wrap sticky-top d-lg-block d-none">
                                <ul class="my-account-nav">
                                    <li>
                                        <a href="account-page.html"
                                            class="text-sm link fw-medium my-account-nav-item active">Dashboard</a>
                                    </li>
                                    <li>
                                        <a href="account-orders.html"
                                            class="text-sm link fw-medium my-account-nav-item ">My
                                            Orders</a>
                                    </li>
                                    <li>
                                        <a href="wish-list.html" class="text-sm link fw-medium my-account-nav-item ">My
                                            Wishlist</a>
                                    </li>
                                    <li>
                                        <a href="account-addresses.html"
                                            class="text-sm link fw-medium my-account-nav-item ">Addresses</a>
                                    </li>
                                    <li>
                                        <a href="index-2.html" class="text-sm link fw-medium my-account-nav-item">Log
                                            Out</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="my-acount-content account-dashboard">
                                <div class="box-account-title">
                                    <p class="hello-name display-sm fw-medium">
                                        Hello Vincent Pham!
                                        <span>(not <span class="name">Vincent Pham</span>?</span>
                                        <a href="index-2.html" class="text-decoration-underline link">Log Out</a>
                                        <span>)</span>
                                    </p>
                                    <p class="notice text-sm">
                                        Today is a great day to check your account page. You can check <a href="#"
                                            class="text-primary text-decoration-underline">your last orders</a> or
                                        have a look to <a href="#" class="text-primary text-decoration-underline">your
                                            wishlist</a> . Or maybe you can start to shop
                                        <a href="#" class="text-primary text-decoration-underline">our latest
                                            offers</a> ?
                                    </p>
                                </div>
                                <div class="content-account">
                                    <ul class="box-check-list flex-sm-nowrap">
                                        <li>
                                            <a href="account-orders.html" class="box-check text-center">
                                                <div class="icon">
                                                    <i class="icon-order"></i>
                                                    <span class="count-number text-sm text-white fw-medium">1</span>
                                                </div>
                                                <div class="text">
                                                    <div class=" link name-type text-xl fw-medium">Orders</div>
                                                    <p class="sub-type text-sm">Check the history of all your orders
                                                    </p>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="wish-list.html" class="box-check text-center">
                                                <div class="icon">
                                                    <i class="icon-heart"></i>
                                                    <span class="count-number text-sm text-white fw-medium">1</span>
                                                </div>
                                                <div class="text">
                                                    <div class="link name-type text-xl fw-medium">Wishlist</div>
                                                    <p class="sub-type text-sm">Check your wishlist</p>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="banner-account">
                                        <div class="image">
                                            <img src="images/banner/account-1.jpg"
                                                data-src="images/banner/account-1.jpg" alt="" class="lazyload">
                                        </div>
                                        <div class="banner-content-right">
                                            <div class="banner-title">
                                                <p class="display-md fw-medium">
                                                    Free Shipping
                                                </p>
                                                <p class="text-md">
                                                    for all orders over $300.00
                                                </p>
                                            </div>
                                            <div class="banner-btn">
                                                <a href="shop-default.html" class="tf-btn animate-btn">
                                                    Shop Now
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="banner-account banner-acc-countdown bg-linear d-flex align-items-center">
                                        <div class="banner-content-left">
                                            <div class="banner-title">
                                                <p class="sub text-md fw-medium">
                                                    SUMMER SALE
                                                </p>
                                                <p class="display-xl fw-medium">
                                                    50% OFF
                                                </p>
                                                <p class="sub text-md fw-medium">
                                                    WITH PROMOTE CODE: 12D34E
                                                </p>
                                            </div>
                                            <div class="banner-btn">
                                                <a href="shop-default.html"
                                                    class="tf-btn btn-white animate-btn animate-dark">
                                                    Shop Now
                                                </a>
                                            </div>
                                        </div>
                                        <div class="banner-countdown">
                                            <div class="wg-countdown-2">
                                                <span class="js-countdown" data-timer="46556"
                                                    data-labels="Days,Hours,Mins,Secs"></span>
                                            </div>
                                        </div>
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


    </div>

    <body>
        @endsection