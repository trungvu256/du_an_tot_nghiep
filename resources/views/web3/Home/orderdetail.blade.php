@extends('web3.layout.master2')
@section('content')

<body>
    <div id="wrapper">
        <!-- Page Title -->
        <div class="flat-spacing pb-0">
            <div class="container">
                <div class="title-success-order text-center">
                    <img class="icon" src="images/section/success.svg" alt="">
                    <div class="box-title">
                        <h3 class="title">Cảm ơn bạn đã đặt hàng!</h3>
                        <p class="text-md text-main">Bạn thật tuyệt vời! Cảm ơn bạn đã mua hàng.</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Title -->
        <!-- Cart Section -->
        <div class="flat-spacing-29">
            <div class="container">
                <div class="row">
                    <div class="col-xl-8">
                        <div class="tf-main-success">
                            <div class="box-progress-order">
                                <div class="order-progress-item order-code text-center">
                                    <div class="title text-sm fw-medium">Mã đơn hàng</div>
                                    <div class="text-md fw-medium code">#1001</div>
                                </div>
                                <div class="order-progress-item order-date text-center">
                                    <div class="title text-sm fw-medium">Ngày đặt hàng</div>
                                    <div class="text-md fw-medium date">10 Oct 2025</div>
                                </div>
                                <div class="order-progress-item order-total text-center">
                                    <div class="title text-sm fw-medium">Tổng đơn hàng</div>
                                    <div class="text-md fw-medium total">$480.00</div>
                                </div>
                                <div class="order-progress-item payment-method text-center">
                                    <div class="title text-sm fw-medium">Phương thức thanh toán</div>
                                    <div class="text-md fw-medium metod">Direct bank transfer</div>
                                </div>
                            </div>

                            <div class="box-ship-address">
                                <div class="row justify-content-between">
                                    <div class="col-12 col-sm-5">
                                        <div class="ship-address-item">
                                            <div class="text-lg fw-medium title">Địa chỉ giao hàng</div>
                                            <ul class="list-address">
                                                <li class="text-sm text-main">Vineta Pham</li>
                                                <li class="text-sm text-main">15 Yarran st</li>
                                                <li class="text-sm text-main">Punchbowl, NSW</li>
                                                <li class="text-sm text-main">Australia</li>
                                                <li class="text-sm text-main">2196</li>
                                                <li class="text-sm text-main">vineta@gmail.com</li>
                                            </ul>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="tf-page-cart-sidebar sidebar-order-success">
                            <div class="cart-box order-box">
                                <div class="title text-lg fw-medium">Chi tiết đơn hàng</div>
                                <ul class="list-order-product">
                                    <li class="order-item">
                                        <figure class="img-product">
                                            <img src="images/products/fashion/order-1.jpg" alt="product">
                                            <span class="quantity">1</span>
                                        </figure>
                                        <div class="content">
                                            <div class="info">
                                                <p class="name text-sm fw-medium">Loose Fit Tee</p>
                                                <span class="variant">White / L</span>
                                            </div>
                                            <span class="price text-sm fw-medium">$120.00</span>
                                        </div>
                                    </li>
                                    <li class="order-item">
                                        <figure class="img-product">
                                            <img src="images/products/fashion/order-2.jpg" alt="product">
                                            <span class="quantity">1</span>
                                        </figure>
                                        <div class="content">
                                            <div class="info">
                                                <p class="name text-sm fw-medium">Bow-Tie T-Shirt</p>
                                                <span class="variant">Black / L</span>
                                            </div>
                                            <span class="price text-sm fw-medium">$120.00</span>
                                        </div>
                                    </li>

                                </ul>
                                <ul class="list-total">
                                    <li class="total-item text-sm d-flex justify-content-between">
                                        <span>Subtotal:</span>
                                        <span class="price-sub fw-medium">$370.00 USD</span>
                                    </li>
                                    <li class="total-item text-sm d-flex justify-content-between">
                                        <span>Discount:</span>
                                        <span class="price-discount fw-medium">-$48.00 USD</span>
                                    </li>
                                    <li class="total-item text-sm d-flex justify-content-between">
                                        <span>Shipping:</span>
                                        <span class="price-ship fw-medium">$10.00 USD</span>
                                    </li>
                                    <li class="total-item text-sm d-flex justify-content-between">
                                        <span>Tax:</span>
                                        <span class="price-tax fw-medium">$48.00 USD</span>
                                    </li>
                                </ul>
                                <div class="subtotal text-lg fw-medium d-flex justify-content-between">
                                    <span>Subtotal:</span>
                                    <span class="total-price-order">$380.00 USD</span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>



    </div>


</body>


@endsection