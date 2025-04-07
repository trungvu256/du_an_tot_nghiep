@extends('web3.layout.master2')
@section('content')

<body>
    <div id="wrapper">
        <!-- Breadcrumb -->
        <div class="tf-breadcrumb">
            <div class="container">
                <ul class="breadcrumb-list">
                    <li class="item-breadcrumb">
                        <a href="index-2.html" class="text">Trang chủ</a>
                    </li>
                    <li class="item-breadcrumb dot">
                        <span></span>
                    </li>
                    <li class="item-breadcrumb">
                        <span class="text">Giỏ hàng</span>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /Breadcrumb -->
        <!-- Title Page -->
        <section class="page-title">
            <div class="container">
                <div class="box-title text-center justify-items-center">
                    <h4 class="title">Giỏ Hàng</h4>
                </div>
            </div>
        </section>
        <!-- /Title Page -->
        <!-- khu vực đổ ra -->
        <!-- Cart Section -->
        <div class="flat-spacing-2 pt-0">
            <div class="container">
                <div class="row">
                    <div class="col-xl-8">
                        <div class="tf-page-cart-main">
                            <form class="form-cart">
                                <table class="table-page-cart">
                                    <thead>
                                        <tr>
                                            <th>Sản phẩm</th>
                                            <th>Giá</th>
                                            <th>Số lượng</th>
                                            <th>Tổng tiền</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="tf-cart-item file-delete">
                                            <td class="tf-cart-item_product">
                                                <a href="product-detail.html" class="img-box">
                                                    <img src="images/products/fashion/product-1.jpg" alt="img-product">
                                                </a>
                                                <div class="cart-info">
                                                    <a href="product-detail.html"
                                                        class="name text-md link fw-medium">Tên sản phẩm</a>
                                                    <div class="variants">Biến thể sản phẩm</div>
                                                    <span class="remove-cart link remove">Xóa</span>
                                                </div>
                                            </td>
                                            <td class="tf-cart-item_price text-center" data-cart-title="Price">
                                                <span class="cart-price price-on-sale text-md fw-medium">$130.00</span>
                                            </td>
                                            <td class="tf-cart-item_quantity" data-cart-title="Quantity">
                                                <div class="wg-quantity">
                                                    <span class="btn-quantity btn-decrease">-</span>
                                                    <input class="quantity-product" type="text" name="number" value="1">
                                                    <span class="btn-quantity btn-increase">+</span>
                                                </div>
                                            </td>
                                            <td class="tf-cart-item_total text-center" data-cart-title="Total">
                                                <div class="cart-total total-price text-md fw-medium">$130.00</div>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>

                                <div class="box-ip-discount">
                                    <input type="text" placeholder="Mã giảm giá">
                                    <button type="button" class="tf-btn radius-6 btn-out-line-dark-2">Áp dụng</button>
                                </div>

                            </form>
                            <div class="fl-iconbox wow fadeInUp">
                                <div dir="ltr" class="swiper tf-swiper sw-auto" data-swiper='{
                                    "slidesPerView": 1,
                                    "spaceBetween": 12,
                                    "speed": 800,
                                    "observer": true,
                                    "observeParents": true,
                                    "slidesPerGroup": 1,
                                    "pagination": { "el": ".sw-pagination-iconbox", "clickable": true },
                                    "breakpoints": {
                                        "575": { "slidesPerView": 2, "spaceBetween": 12, "slidesPerGroup": 2}, 
                                        "768": { "slidesPerView": 3, "spaceBetween": 24, "slidesPerGroup": 3},
                                        "1200": { "slidesPerView": "auto", "spaceBetween": 24}
                                    }
                                }'>
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <div
                                                class="tf-icon-box justify-content-center justify-content-sm-start style-3">
                                                <div class="box-icon">
                                                    <i class="icon icon-shipping"></i>
                                                </div>
                                                <div class="content">
                                                    <div class="title text-uppercase">Free Shipping</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div
                                                class="tf-icon-box justify-content-center justify-content-sm-start style-3">
                                                <div class="box-icon">
                                                    <i class="icon icon-gift"></i>
                                                </div>
                                                <div class="content">
                                                    <div class="title text-uppercase">Gift Package</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div
                                                class="tf-icon-box justify-content-center justify-content-sm-start style-3">
                                                <div class="box-icon">
                                                    <i class="icon icon-return"></i>
                                                </div>
                                                <div class="content">
                                                    <div class="title text-uppercase">Ease Returns</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div
                                                class="tf-icon-box justify-content-center justify-content-sm-start style-3">
                                                <div class="box-icon">
                                                    <i class="icon icon-support"></i>
                                                </div>
                                                <div class="content">
                                                    <div class="title text-uppercase text-nowrap">ONE YEAR WARRANTY
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div
                                    class="d-flex d-xl-none sw-dot-default sw-pagination-iconbox justify-content-center">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="tf-page-cart-sidebar">
                            <!-- <form class="cart-box shipping-cart-box">
                                <div class="text-lg title fw-medium">Shipping estimates</div>
                                <fieldset class="field">
                                    <label for="country" class="text-sm">Country</label>
                                    <input type="text" id="country" placeholder="United State">
                                </fieldset>
                                <fieldset class="field">
                                    <label for="state" class="text-sm">State/Province</label>
                                    <input type="text" id="state" placeholder="State/Province">
                                </fieldset>
                                <fieldset class="field">
                                    <label for="code" class="text-sm">Zipcode</label>
                                    <input type="text" id="code" placeholder="41000">
                                </fieldset>
                                <button type="button" class="tf-btn btn-dark2 animate-btn w-100">Estimate</button>
                            </form> -->
                            <form action="https://vineta-html.vercel.app/checkout.html"
                                class="cart-box checkout-cart-box">
                                <div class="cart-head">
                                    <div class="total-discount text-xl fw-medium">
                                        <span>Total:</span>
                                        <span class="total">$130.00 USD</span>
                                    </div>
                                    <p class="text-sm text-dark-4">Taxes and shipping calculated at checkout</p>
                                </div>
                                <div class="check-agree">
                                    <input type="checkbox" class="tf-check" id="check-agree">
                                    <label for="check-agree" class="label text-dark-4">I agree with <a
                                            href="term-and-condition.html"
                                            class="text-dark-4 fw-medium text-underline link">term and
                                            conditions</a></label>
                                </div>
                                <div class="checkout-btn">
                                    <button type="submit" class="tf-btn btn-dark2 animate-btn w-100">Thanh toán</button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Cart Section -->
        <!-- You May Also Like -->
        <section class="flat-spacing pt-0">
            <div class="container">
                <div class="flat-title wow fadeInUp">
                    <h4 class="title">Sản phẩm liên quan</h4>
                </div>
                <div class="fl-control-sw pos2">
                    <div dir="ltr" class="swiper tf-swiper wrap-sw-over" data-swiper='{
                            "slidesPerView": 2,
                            "spaceBetween": 12,
                            "speed": 800,
                            "observer": true,
                            "observeParents": true,
                            "slidesPerGroup": 2,
                            "navigation": {
                                "clickable": true,
                                "nextEl": ".nav-next-also",
                                "prevEl": ".nav-prev-also"
                            },
                            "pagination": { "el": ".sw-pagination-also", "clickable": true },
                            "breakpoints": {
                            "768": { "slidesPerView": 3, "spaceBetween": 12, "slidesPerGroup": 3 },
                            "1200": { "slidesPerView": 4, "spaceBetween": 24, "slidesPerGroup": 4}
                            }
                        }'>
                        <div class="swiper-wrapper">
                            <!-- item 1 -->
                            <div class="swiper-slide">
                                <div class="card-product style-2">
                                    <div class="card-product-wrapper">
                                        <a href="product-detail.html" class="product-img">
                                            <img class="img-product lazyload"
                                                data-src="images/products/fashion/product-36.jpg"
                                                src="images/products/fashion/product-36.jpg" alt="image-product">
                                            <img class="img-hover lazyload"
                                                data-src="images/products/fashion/product-4.jpg"
                                                src="images/products/fashion/product-4.jpg" alt="image-product">
                                        </a>
                                        <ul class="list-product-btn">
                                            <li>
                                                <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                                    class="hover-tooltip box-icon">
                                                    <span class="icon icon-cart2"></span>
                                                    <span class="tooltip">Add to Cart</span>
                                                </a>
                                            </li>
                                            <li class="wishlist">
                                                <a href="javascript:void(0);" class="hover-tooltip box-icon">
                                                    <span class="icon icon-heart2"></span>
                                                    <span class="tooltip">Add to Wishlist</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#quickView" data-bs-toggle="modal"
                                                    class="hover-tooltip box-icon quickview">
                                                    <span class="icon icon-view"></span>
                                                    <span class="tooltip">Quick View</span>
                                                </a>
                                            </li>
                                            <li class="compare">
                                                <a href="#compare" data-bs-toggle="modal"
                                                    class="hover-tooltip box-icon">
                                                    <span class="icon icon-compare"></span>
                                                    <span class="tooltip">Add to Compare</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-product-info">
                                        <a href="product-detail.html" class="name-product link fw-medium text-md">Loose
                                            Fit Tee</a>
                                        <p class="price-wrap fw-medium">
                                            <span class="price-new text-primary">$120.00</span>
                                            <span class="price-old">$150.00</span>
                                        </p>
                                        <ul class="list-color-product">
                                            <li class="list-color-item hover-tooltip tooltip-bot color-swatch active">
                                                <span class="tooltip color-filter">Beige</span>
                                                <span class="swatch-value bg-beige"></span>
                                                <img class=" lazyload" data-src="images/products/fashion/product-36.jpg"
                                                    src="images/products/fashion/product-36.jpg" alt="image-product">
                                            </li>
                                            <li class="list-color-item color-swatch hover-tooltip tooltip-bot">
                                                <span class="tooltip color-filter">Black</span>
                                                <span class="swatch-value bg-dark"></span>
                                                <img class=" lazyload" data-src="images/products/fashion/product-9.jpg"
                                                    src="images/products/fashion/product-9.jpg" alt="image-product">
                                            </li>
                                            <li class="list-color-item color-swatch hover-tooltip tooltip-bot line">
                                                <span class="tooltip color-filter">White</span>
                                                <span class="swatch-value bg-white"></span>
                                                <img class=" lazyload" data-src="images/products/fashion/product-4.jpg"
                                                    src="images/products/fashion/product-4.jpg" alt="image-product">
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="d-flex d-xl-none sw-dot-default sw-pagination-also justify-content-center"></div>
                    </div>
                    <div class="d-none d-xl-flex swiper-button-next nav-swiper nav-next-also"></div>
                    <div class="d-none d-xl-flex swiper-button-prev nav-swiper nav-prev-also"></div>
                </div>
            </div>
        </section>
    </div>
</body>
@endsection