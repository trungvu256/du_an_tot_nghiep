@extends('web3.layout.master2')
@section('content')

<body>
    <div id="wrapper">
        <!-- Breadcrumb -->
        <div class="tf-breadcrumb mb-0">
            <div class="container">
                <ul class="breadcrumb-list">
                    <li class="item-breadcrumb">
                        <a href="index-2.html" class="text">Trang chủ</a>
                    </li>
                    <li class="item-breadcrumb dot">
                        <span></span>
                    </li>
                    <li class="item-breadcrumb">
                        <span class="text">Chi tiết sản phẩm</span>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /Breadcrumb -->
        <!-- Product Main -->
        <section class="flat-single-product">
            <div class="tf-main-product section-image-zoom">
                <div class="container">
                    <div class="row">
                        <!-- Product Images -->
                        <div class="col-md-6">
                            <div class="tf-product-media-wrap sticky-top">
                                <div class="thumbs-slider">
                                    <div dir="ltr" class="swiper tf-product-media-thumbs other-image-zoom"
                                        data-preview="4" data-direction="vertical">
                                        <div class="swiper-wrapper stagger-wrap">
                                            <!-- black -->
                                            <div class="swiper-slide stagger-item" data-color="black" data-size="small">
                                                <div class="item">
                                                    <img class="lazyload"
                                                        data-src="images/products/fashion/women-black-1.jpg"
                                                        src="images/products/fashion/women-black-1.jpg"
                                                        alt="img-product">
                                                </div>
                                            </div>
                                            <div class="swiper-slide stagger-item" data-color="black"
                                                data-size="medium">
                                                <div class="item">
                                                    <img class="lazyload"
                                                        data-src="images/products/fashion/women-black-2.jpg"
                                                        src="images/products/fashion/women-black-2.jpg"
                                                        alt="img-product">
                                                </div>
                                            </div>
                                            <div class="swiper-slide stagger-item" data-color="black" data-size="large">
                                                <div class="item">
                                                    <img class="lazyload"
                                                        data-src="images/products/fashion/women-black-3.jpg"
                                                        src="images/products/fashion/women-black-3.jpg"
                                                        alt="img-product">
                                                </div>
                                            </div>
                                            <div class="swiper-slide stagger-item" data-color="black"
                                                data-size="extra large">
                                                <div class="item">
                                                    <img class="lazyload"
                                                        data-src="images/products/fashion/women-black-4.jpg"
                                                        src="images/products/fashion/women-black-4.jpg"
                                                        alt="img-product">
                                                </div>
                                            </div>
                                            <!-- yellow -->
                                            <div class="swiper-slide stagger-item" data-color="yellow"
                                                data-size="small">
                                                <div class="item">
                                                    <img class="lazyload"
                                                        data-src="images/products/fashion/women-yellow-1.jpg"
                                                        src="images/products/fashion/women-yellow-1.jpg"
                                                        alt="img-product">
                                                </div>
                                            </div>
                                            <div class="swiper-slide stagger-item" data-color="yellow"
                                                data-size="medium">
                                                <div class="item">
                                                    <img class="lazyload"
                                                        data-src="images/products/fashion/women-yellow-2.jpg"
                                                        src="images/products/fashion/women-yellow-2.jpg"
                                                        alt="img-product">
                                                </div>
                                            </div>
                                            <!-- grey -->
                                            <div class="swiper-slide stagger-item" data-color="grey" data-size="large">
                                                <div class="item">
                                                    <img class="lazyload"
                                                        data-src="images/products/fashion/women-grey-1.jpg"
                                                        src="images/products/fashion/women-grey-1.jpg"
                                                        alt="img-product">
                                                </div>
                                            </div>
                                            <div class="swiper-slide stagger-item" data-color="grey"
                                                data-size="extra large">
                                                <div class="item">
                                                    <img class="lazyload"
                                                        data-src="images/products/fashion/women-grey-2.jpg"
                                                        src="images/products/fashion/women-grey-2.jpg"
                                                        alt="img-product">
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="flat-wrap-media-product">
                                        <div dir="ltr" class="swiper tf-product-media-main" id="gallery-swiper-started">
                                            <div class="swiper-wrapper">
                                                <!-- black -->
                                                <div class="swiper-slide" data-color="black" data-size="small">
                                                    <a href="images/products/fashion/women-black-1.jpg" target="_blank"
                                                        class="item" data-pswp-width="552px" data-pswp-height="827px">
                                                        <img class="tf-image-zoom lazyload"
                                                            data-zoom="images/products/fashion/women-black-1.jpg"
                                                            data-src="images/products/fashion/women-black-1.jpg"
                                                            src="images/products/fashion/women-black-1.jpg"
                                                            alt="img-product">
                                                    </a>
                                                </div>
                                                <div class="swiper-slide" data-color="black" data-size="medium">
                                                    <a href="images/products/fashion/women-black-2.jpg" target="_blank"
                                                        class="item" data-pswp-width="552px" data-pswp-height="827px">
                                                        <img class="tf-image-zoom lazyload"
                                                            data-zoom="images/products/fashion/women-black-2.jpg"
                                                            data-src="images/products/fashion/women-black-2.jpg"
                                                            src="images/products/fashion/women-black-2.jpg"
                                                            alt="img-product">
                                                    </a>
                                                </div>
                                                <div class="swiper-slide" data-color="black" data-size="large">
                                                    <a href="images/products/fashion/women-black-3.jpg" target="_blank"
                                                        class="item" data-pswp-width="552px" data-pswp-height="827px">
                                                        <img class="tf-image-zoom lazyload"
                                                            data-zoom="images/products/fashion/women-black-3.jpg"
                                                            data-src="images/products/fashion/women-black-3.jpg"
                                                            src="images/products/fashion/women-black-3.jpg"
                                                            alt="img-product">
                                                    </a>
                                                </div>
                                                <div class="swiper-slide" data-color="black" data-size="extra large">
                                                    <a href="images/products/fashion/women-black-4.jpg" target="_blank"
                                                        class="item" data-pswp-width="552px" data-pswp-height="827px">
                                                        <img class="tf-image-zoom lazyload"
                                                            data-zoom="images/products/fashion/women-black-4.jpg"
                                                            data-src="images/products/fashion/women-black-4.jpg"
                                                            src="images/products/fashion/women-black-4.jpg"
                                                            alt="img-product">
                                                    </a>
                                                </div>
                                                <!-- yellow -->
                                                <div class="swiper-slide" data-color="yellow" data-size="small">
                                                    <a href="images/products/fashion/women-yellow-1.jpg" target="_blank"
                                                        class="item" data-pswp-width="552px" data-pswp-height="827px">
                                                        <img class="tf-image-zoom lazyload"
                                                            data-zoom="images/products/fashion/women-yellow-1.jpg"
                                                            data-src="images/products/fashion/women-yellow-1.jpg"
                                                            src="images/products/fashion/women-yellow-1.jpg"
                                                            alt="img-product">
                                                    </a>
                                                </div>
                                                <div class="swiper-slide" data-color="yellow" data-size="medium">
                                                    <a href="images/products/fashion/women-yellow-2.jpg" target="_blank"
                                                        class="item" data-pswp-width="552px" data-pswp-height="827px">
                                                        <img class="tf-image-zoom lazyload"
                                                            data-zoom="images/products/fashion/women-yellow-2.jpg"
                                                            data-src="images/products/fashion/women-yellow-2.jpg"
                                                            src="images/products/fashion/women-yellow-2.jpg"
                                                            alt="img-product">
                                                    </a>
                                                </div>
                                                <!-- grey -->
                                                <div class="swiper-slide" data-color="grey" data-size="large">
                                                    <a href="images/products/fashion/women-grey-1.jpg" target="_blank"
                                                        class="item" data-pswp-width="552px" data-pswp-height="827px">
                                                        <img class="tf-image-zoom lazyload"
                                                            data-zoom="images/products/fashion/women-grey-1.jpg"
                                                            data-src="images/products/fashion/women-grey-1.jpg"
                                                            src="images/products/fashion/women-grey-1.jpg"
                                                            alt="img-product">
                                                    </a>
                                                </div>
                                                <div class="swiper-slide" data-color="grey" data-size="extra large">
                                                    <a href="images/products/fashion/women-grey-2.jpg" target="_blank"
                                                        class="item" data-pswp-width="552px" data-pswp-height="827px">
                                                        <img class="tf-image-zoom lazyload"
                                                            data-zoom="images/products/fashion/women-grey-2.jpg"
                                                            data-src="images/products/fashion/women-grey-2.jpg"
                                                            src="images/products/fashion/women-grey-2.jpg"
                                                            alt="img-product">
                                                    </a>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="swiper-button-next nav-swiper thumbs-next"></div>
                                        <div class="swiper-button-prev nav-swiper thumbs-prev"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Product Images -->
                        <!-- Product Info -->
                        <div class="col-md-6">
                            <div class="tf-product-info-wrap position-relative">
                                <div class="tf-zoom-main"></div>
                                <div class="tf-product-info-list other-image-zoom">
                                    <!-- Thông tin chính sản phẩm -->
                                    <div class="tf-product-info-heading">
                                        <h5 class="product-info-name fw-medium">Quần Linen pha</h5>
                                        <div class="product-info-rate">
                                            <div class="list-star">
                                                <i class="icon icon-star"></i>
                                                <i class="icon icon-star"></i>
                                                <i class="icon icon-star"></i>
                                                <i class="icon icon-star"></i>
                                                <i class="icon icon-star"></i>
                                            </div>
                                            <span class="count-review">(Chưa có đánh giá)</span>
                                        </div>
                                        <div class="product-info-price">
                                            <div class="display-sm price-new price-on-sale">$130.00</div>
                                            <div class="display-sm price-old">$100.00</div>
                                            <span class="badge-sale">Giảm 20%</span>
                                        </div>
                                        <div class="product-info-sold">
                                            <svg class="icon" width="18" height="18">...</svg>
                                            <span class="text-dark">Đã bán 30 sản phẩm trong 24h qua</span>
                                        </div>
                                        <div class="product-info-progress-sale">
                                            <div class="title-hurry-up">
                                                <span class="text-primary fw-medium">NHANH TAY!</span> Chỉ còn <span
                                                    class="count">4</span> sản phẩm!
                                            </div>
                                            <div class="progress-sold">
                                                <div class="value" style="width: 0%;" data-progress="70"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Chọn biến thể sản phẩm -->
                                    <div class="tf-product-info-variant">
                                        <div class="variant-picker-item variant-color">
                                            <div class="variant-picker-label">
                                                Màu sắc:
                                                <span class="variant-picker-label-value value-currentColor">Đen</span>
                                            </div>
                                            <div class="variant-picker-values">
                                                <div class="hover-tooltip tooltip-bot color-btn active"
                                                    data-color="black">
                                                    <span class="check-color bg-dark-3"></span>
                                                    <span class="tooltip">Đen</span>
                                                </div>
                                                <div class="hover-tooltip tooltip-bot color-btn" data-color="yellow">
                                                    <span class="check-color bg-yellow"></span>
                                                    <span class="tooltip">Vàng</span>
                                                </div>
                                                <div class="hover-tooltip tooltip-bot color-btn" data-color="grey">
                                                    <span class="check-color bg-grey-2"></span>
                                                    <span class="tooltip">Xám</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="variant-picker-item variant-size">
                                            <div class="variant-picker-label">
                                                Kích cỡ:
                                                <span class="variant-picker-label-value value-currentSize">Nhỏ</span>
                                                <a href="#sizeGuide" data-bs-toggle="modal" class="size-guide link">Bảng
                                                    kích thước</a>
                                            </div>
                                            <div class="variant-picker-values">
                                                <span class="size-btn active" data-size="small">S</span>
                                                <span class="size-btn" data-size="medium">M</span>
                                                <span class="size-btn" data-size="large">L</span>
                                                <span class="size-btn" data-size="extra large">XL</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Số lượng và nút hành động -->
                                    <div class="tf-product-total-quantity">
                                        <div class="group-btn">
                                            <div class="wg-quantity">
                                                <button class="btn-quantity btn-decrease">-</button>
                                                <input class="quantity-product" type="text" name="number" value="1">
                                                <button class="btn-quantity btn-increase">+</button>
                                            </div>
                                            <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                                class="tf-btn hover-primary btn-add-to-cart">Thêm vào giỏ</a>
                                        </div>
                                        <a href="#" class="tf-btn btn-primary w-100 animate-btn">Mua ngay</a>
                                        <a href="checkout.html" class="more-choose-payment link">Xem thêm phương thức
                                            thanh toán</a>
                                    </div>

                                    <!-- Các hành động phụ: yêu thích, so sánh, hỏi đáp, chia sẻ -->
                                    <div class="tf-product-info-extra-link">
                                        <a href="javascript:void(0);" class="product-extra-icon link btn-add-wishlist">
                                            <i class="icon add icon-heart"></i><span class="add">Thêm vào yêu
                                                thích</span>
                                            <i class="icon added icon-trash"></i><span class="added">Xóa khỏi yêu
                                                thích</span>
                                        </a>
                                        <a href="#compare" data-bs-toggle="modal" class="product-extra-icon link">
                                            <i class="icon icon-compare2"></i>So sánh
                                        </a>
                                        <a href="#askQuestion" data-bs-toggle="modal" class="product-extra-icon link">
                                            <i class="icon icon-ask"></i>Đặt câu hỏi
                                        </a>
                                        <a href="#shareSocial" data-bs-toggle="modal" class="product-extra-icon link">
                                            <i class="icon icon-share"></i>Chia sẻ
                                        </a>
                                    </div>

                                    <!-- Các biểu tượng thanh toán bảo mật -->
                                    <div class="tf-product-info-trust-seal text-center">
                                        <p class="text-md text-dark-2 text-seal fw-medium">Thanh toán an toàn đảm bảo:
                                        </p>
                                        <ul class="list-card">
                                            <li class="card-item"><img src="images/payment/Visa.png" alt="Visa"></li>
                                            <li class="card-item"><img src="images/payment/DinersClub.png"
                                                    alt="Diners Club"></li>
                                            <li class="card-item"><img src="images/payment/Mastercard.png"
                                                    alt="Mastercard"></li>
                                            <li class="card-item"><img src="images/payment/Stripe.png" alt="Stripe">
                                            </li>
                                            <li class="card-item"><img src="images/payment/PayPal.png" alt="PayPal">
                                            </li>
                                            <li class="card-item"><img src="images/payment/GooglePay.png"
                                                    alt="Google Pay"></li>
                                            <li class="card-item"><img src="images/payment/ApplePay.png"
                                                    alt="Apple Pay"></li>
                                        </ul>
                                    </div>

                                    <!-- Giao hàng & trả hàng -->
                                    <div class="tf-product-info-delivery-return">
                                        <div class="product-delivery">
                                            <div class="icon icon-car2"></div>
                                            <p class="text-md">Thời gian giao hàng dự kiến: <span class="fw-medium">3-5
                                                    ngày quốc tế</span></p>
                                        </div>
                                        <div class="product-delivery">
                                            <div class="icon icon-shipping3"></div>
                                            <p class="text-md">Miễn phí giao hàng với <span class="fw-medium">đơn hàng
                                                    từ $150</span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sản phẩm thường được mua kèm -->
                        <div class="product-bought-together">
                            <h6 class="title">Thường được mua cùng nhau</h6>
                            <div class="bought-together-list">
                                <!-- Danh sách sản phẩm mua kèm -->
                                <!-- Mỗi sản phẩm sẽ được lặp lại dưới đây -->
                                <!-- Ví dụ: -->
                                <div class="bought-together-item">
                                    <img src="images/product/product2.jpg" alt="Sản phẩm kèm">
                                    <p class="product-name">Áo sơ mi trắng</p>
                                    <p class="product-price">$40.00</p>
                                    <input type="checkbox" checked> Chọn
                                </div>
                                <!-- ... -->
                            </div>
                            <div class="bought-together-total">
                                <p>Tổng cộng: <span class="fw-bold">$170.00</span></p>
                                <a href="#" class="tf-btn btn-primary">Thêm tất cả vào giỏ</a>
                            </div>
                        </div>

                        <!-- /Product Info -->

                    </div>
                </div>
            </div>
            <div class="tf-sticky-btn-atc">
                <div class="container">
                    <div class="tf-height-observer w-100 d-flex align-items-center">
                        <!-- Sản phẩm hiển thị thu gọn bên trái -->
                        <div class="tf-sticky-atc-product d-flex align-items-center">
                            <div class="tf-sticky-atc-img">
                                <img class="lazyload" data-src="images/products/fashion/women-black-1.jpg" alt=""
                                    src="images/products/fashion/women-black-1.jpg">
                            </div>
                            <div class="tf-sticky-atc-title fw-5 d-xl-block d-none">Áo thun tay dài</div>
                        </div>

                        <!-- Thông tin chọn biến thể và số lượng bên phải -->
                        <div class="tf-sticky-atc-infos">
                            <form>
                                <!-- Chọn màu / size / giá -->
                                <div class="tf-sticky-atc-variant-price text-center tf-select">
                                    <select>
                                        <option selected="selected">Đen / Nhỏ - $130.00</option>
                                        <option>Đen / Trung bình - $130.00</option>
                                        <option>Đen / Lớn - $130.00</option>
                                        <option>Xanh / Nhỏ - $130.00</option>
                                        <option>Xanh / Trung bình - $130.00</option>
                                        <option>Xanh / Lớn - $130.00</option>
                                        <option>Xanh / Rộng - $130.00</option>
                                        <option>Trắng / Nhỏ - $130.00</option>
                                        <option>Trắng / Trung bình - $130.00</option>
                                        <option>Trắng / Lớn - $130.00</option>
                                    </select>
                                </div>

                                <!-- Số lượng và nút thêm vào giỏ -->
                                <div class="tf-sticky-atc-btns">
                                    <div class="tf-product-info-quantity">
                                        <div class="wg-quantity">
                                            <button class="btn-quantity minus-btn">-</button>
                                            <input class="quantity-product font-4" type="text" name="number" value="1">
                                            <button class="btn-quantity plus-btn">+</button>
                                        </div>
                                    </div>
                                    <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                        class="tf-btn animate-btn d-inline-flex justify-content-center">
                                        Thêm vào giỏ
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </section>
        <!-- /Product Main -->
        <!-- Product Description -->
        <section class="flat-spacing pt-0">
            <div class="container">
                <div class="widget-accordion wd-product-descriptions">
                    <div class="accordion-title collapsed" data-bs-target="#description" data-bs-toggle="collapse"
                        aria-expanded="true" aria-controls="description" role="button">
                        <span>Descriptions</span>
                        <span class="icon icon-arrow-down"></span>
                    </div>
                    <div id="description" class="collapse">
                        <div class="accordion-body widget-desc">
                            <div class="item">
                                <p class="fw-medium title">Composition</p>
                                <ul>
                                    <li>Viscose 55%, Linen 45%</li>
                                    <li>We exclude the weight of minor components</li>
                                </ul>
                            </div>
                            <p class="item">Additional material information</p>
                            <div class="item">
                                <p class="title">The total weight of this product contains:</p>
                                <ul>
                                    <li>55% LivaEco™ viscose</li>
                                    <li>Viscose 55%</li>
                                </ul>
                            </div>
                            <ul class="item">
                                <li>We exclude the weight of minor components such as, but not exclusively: threads,
                                    buttons, zippers, embellishments and prints.</li>
                                <li>The total weight of the product is calculated by adding the weight of all layers and
                                    main components together. Based on that, we calculate how much of that weight is
                                    made out by each material. For sets & multipacks all pieces are counted together as
                                    one product in calculations.</li>
                                <li>Materials in this product explained</li>
                                <li>LinenLinen is a natural bast fibre derived from flax plants.</li>
                                <li>LivaEco™ viscoseLivaEco™ viscose is a branded viscose fibre, made from wood pulp.
                                </li>
                                <li> ViscoseViscose is a regenerated cellulose fibre commonly made from wood, but the
                                    raw material could also consist of other cellulosic materials.</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="widget-accordion wd-product-descriptions">
                    <div class="accordion-title collapsed" data-bs-target="#material" data-bs-toggle="collapse"
                        aria-expanded="true" aria-controls="material" role="button">
                        <span>Materials</span>
                        <span class="icon icon-arrow-down"></span>
                    </div>
                    <div id="material" class="collapse">
                        <div class="accordion-body widget-material">
                            <div class="item">
                                <p class="fw-medium title">Materials Care</p>
                                <ul>
                                    <li>Content: 100% LENZING™ ECOVERO™ Viscose</li>
                                    <li>Care: Hand wash</li>
                                    <li>Imported</li>
                                    <li>Machine wash max. 30ºC. Short spin.</li>
                                    <li>Iron maximum 110ºC.</li>
                                    <li>Do not bleach/bleach.</li>
                                    <li>Do not dry clean.</li>
                                    <li>Tumble dry, medium hear.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="widget-accordion wd-product-descriptions">
                    <div class="accordion-title collapsed" data-bs-target="#returnPolicies" data-bs-toggle="collapse"
                        aria-expanded="true" aria-controls="returnPolicies" role="button">
                        <span>Return Policies</span>
                        <span class="icon icon-arrow-down"></span>
                    </div>
                    <div id="returnPolicies" class="collapse">
                        <div class="accordion-body">
                            <ul class="list-policies">
                                <li>
                                    <svg viewBox="0 0 40 40" width="35px" height="35px" color="#222">
                                        <path fill="currentColor"
                                            d="M8.7 30.7h22.7c.3 0 .6-.2.7-.6l4-25.3c-.1-.4-.3-.7-.7-.8s-.7.2-.8.6L34 8.9l-3-1.1c-2.4-.9-5.1-.5-7.2 1-2.3 1.6-5.3 1.6-7.6 0-2.1-1.5-4.8-1.9-7.2-1L6 8.9l-.7-4.3c0-.4-.4-.7-.7-.6-.4.1-.6.4-.6.8l4 25.3c.1.3.3.6.7.6zm.8-21.6c2-.7 4.2-.4 6 .8 1.4 1 3 1.5 4.6 1.5s3.2-.5 4.6-1.5c1.7-1.2 4-1.6 6-.8l3.3 1.2-3 19.1H9.2l-3-19.1 3.3-1.2zM32 32H8c-.4 0-.7.3-.7.7s.3.7.7.7h24c.4 0 .7-.3.7-.7s-.3-.7-.7-.7zm0 2.7H8c-.4 0-.7.3-.7.7s.3.6.7.6h24c.4 0 .7-.3.7-.7s-.3-.6-.7-.6zm-17.9-8.9c-1 0-1.8-.3-2.4-.6l.1-2.1c.6.4 1.4.6 2 .6.8 0 1.2-.4 1.2-1.3s-.4-1.3-1.3-1.3h-1.3l.2-1.9h1.1c.6 0 1-.3 1-1.3 0-.8-.4-1.2-1.1-1.2s-1.2.2-1.9.4l-.2-1.9c.7-.4 1.5-.6 2.3-.6 2 0 3 1.3 3 2.9 0 1.2-.4 1.9-1.1 2.3 1 .4 1.3 1.4 1.3 2.5.3 1.8-.6 3.5-2.9 3.5zm4-5.5c0-3.9 1.2-5.5 3.2-5.5s3.2 1.6 3.2 5.5-1.2 5.5-3.2 5.5-3.2-1.6-3.2-5.5zm4.1 0c0-2-.1-3.5-.9-3.5s-1 1.5-1 3.5.1 3.5 1 3.5c.8 0 .9-1.5.9-3.5zm4.5-1.4c-.9 0-1.5-.8-1.5-2.1s.6-2.1 1.5-2.1 1.5.8 1.5 2.1-.5 2.1-1.5 2.1zm0-.8c.4 0 .7-.5.7-1.2s-.2-1.2-.7-1.2-.7.5-.7 1.2.3 1.2.7 1.2z">
                                        </path>
                                    </svg>
                                </li>
                                <li>
                                    <svg viewBox="0 0 40 40" width="35px" height="35px" color="#222">
                                        <path fill="currentColor"
                                            d="M36.7 31.1l-2.8-1.3-4.7-9.1 7.5-3.5c.4-.2.6-.6.4-1s-.6-.5-1-.4l-7.5 3.5-7.8-15c-.3-.5-1.1-.5-1.4 0l-7.8 15L4 15.9c-.4-.2-.8 0-1 .4s0 .8.4 1l7.5 3.5-4.7 9.1-2.8 1.3c-.4.2-.6.6-.4 1 .1.3.4.4.7.4.1 0 .2 0 .3-.1l1-.4-1.5 2.8c-.1.2-.1.5 0 .8.1.2.4.3.7.3h31.7c.3 0 .5-.1.7-.4.1-.2.1-.5 0-.8L35.1 32l1 .4c.1 0 .2.1.3.1.3 0 .6-.2.7-.4.1-.3 0-.8-.4-1zm-5.1-2.3l-9.8-4.6 6-2.8 3.8 7.4zM20 6.4L27.1 20 20 23.3 12.9 20 20 6.4zm-7.8 15l6 2.8-9.8 4.6 3.8-7.4zm22.4 13.1H5.4L7.2 31 20 25l12.8 6 1.8 3.5z">
                                        </path>
                                    </svg>
                                </li>
                                <li>
                                    <svg viewBox="0 0 40 40" width="35px" height="35px" color="#222">
                                        <path fill="currentColor"
                                            d="M5.9 5.9v28.2h28.2V5.9H5.9zM19.1 20l-8.3 8.3c-2-2.2-3.2-5.1-3.2-8.3s1.2-6.1 3.2-8.3l8.3 8.3zm-7.4-9.3c2.2-2 5.1-3.2 8.3-3.2s6.1 1.2 8.3 3.2L20 19.1l-8.3-8.4zM20 20.9l8.3 8.3c-2.2 2-5.1 3.2-8.3 3.2s-6.1-1.2-8.3-3.2l8.3-8.3zm.9-.9l8.3-8.3c2 2.2 3.2 5.1 3.2 8.3s-1.2 6.1-3.2 8.3L20.9 20zm8.4-10.2c-1.2-1.1-2.6-2-4.1-2.6h6.6l-2.5 2.6zm-18.6 0L8.2 7.2h6.6c-1.5.6-2.9 1.5-4.1 2.6zm-.9.9c-1.1 1.2-2 2.6-2.6 4.1V8.2l2.6 2.5zM7.2 25.2c.6 1.5 1.5 2.9 2.6 4.1l-2.6 2.6v-6.7zm3.5 5c1.2 1.1 2.6 2 4.1 2.6H8.2l2.5-2.6zm18.6 0l2.6 2.6h-6.6c1.4-.6 2.8-1.5 4-2.6zm.9-.9c1.1-1.2 2-2.6 2.6-4.1v6.6l-2.6-2.5zm2.6-14.5c-.6-1.5-1.5-2.9-2.6-4.1l2.6-2.6v6.7z">
                                        </path>
                                    </svg>
                                </li>
                                <li>
                                    <svg viewBox="0 0 40 40" width="35px" height="35px" color="#222">
                                        <path fill="currentColor"
                                            d="M35.1 33.6L33.2 6.2c0-.4-.3-.7-.7-.7H13.9c-.4 0-.7.3-.7.7s.3.7.7.7h18l.7 10.5H20.8c-8.8.2-15.9 7.5-15.9 16.4 0 .4.3.7.7.7h28.9c.2 0 .4-.1.5-.2s.2-.3.2-.5v-.2h-.1zm-28.8-.5C6.7 25.3 13 19 20.8 18.9h11.9l1 14.2H6.3zm11.2-6.8c0 1.2-1 2.1-2.1 2.1s-2.1-1-2.1-2.1 1-2.1 2.1-2.1 2.1 1 2.1 2.1zm6.3 0c0 1.2-1 2.1-2.1 2.1-1.2 0-2.1-1-2.1-2.1s1-2.1 2.1-2.1 2.1 1 2.1 2.1z">
                                        </path>
                                    </svg>
                                </li>
                                <li>
                                    <svg viewBox="0 0 40 40" width="35px" height="35px" color="#222">
                                        <path fill="currentColor"
                                            d="M20 33.8c7.6 0 13.8-6.2 13.8-13.8S27.6 6.2 20 6.2 6.2 12.4 6.2 20 12.4 33.8 20 33.8zm0-26.3c6.9 0 12.5 5.6 12.5 12.5S26.9 32.5 20 32.5 7.5 26.9 7.5 20 13.1 7.5 20 7.5zm-.4 15h.5c1.8 0 3-1.1 3-3.7 0-2.2-1.1-3.6-3.1-3.6h-2.6v10.6h2.2v-3.3zm0-5.2h.4c.6 0 .9.5.9 1.7 0 1.1-.3 1.7-.9 1.7h-.4v-3.4z">
                                        </path>
                                    </svg>
                                </li>
                                <li>
                                    <svg viewBox="0 0 40 40" width="35px" height="35px" color="#222">
                                        <path fill="currentColor"
                                            d="M30.2 29.3c2.2-2.5 3.6-5.7 3.6-9.3s-1.4-6.8-3.6-9.3l3.6-3.6c.3-.3.3-.7 0-.9-.3-.3-.7-.3-.9 0l-3.6 3.6c-2.5-2.2-5.7-3.6-9.3-3.6s-6.8 1.4-9.3 3.6L7.1 6.2c-.3-.3-.7-.3-.9 0-.3.3-.3.7 0 .9l3.6 3.6c-2.2 2.5-3.6 5.7-3.6 9.3s1.4 6.8 3.6 9.3l-3.6 3.6c-.3.3-.3.7 0 .9.1.1.3.2.5.2s.3-.1.5-.2l3.6-3.6c2.5 2.2 5.7 3.6 9.3 3.6s6.8-1.4 9.3-3.6l3.6 3.6c.1.1.3.2.5.2s.3-.1.5-.2c.3-.3.3-.7 0-.9l-3.8-3.6z">
                                        </path>
                                    </svg>
                                </li>
                                <li>
                                    <svg viewBox="0 0 40 40" width="35px" height="35px" color="#222">
                                        <path fill="currentColor"
                                            d="M34.1 34.1H5.9V5.9h28.2v28.2zM7.2 32.8h25.6V7.2H7.2v25.6zm13.5-18.3a.68.68 0 0 0-.7-.7.68.68 0 0 0-.7.7v10.9a.68.68 0 0 0 .7.7.68.68 0 0 0 .7-.7V14.5z">
                                        </path>
                                    </svg>
                                </li>
                            </ul>
                            <p class="text-center text-paragraph">LT01: 70% wool, 15% polyester, 10% polyamide, 5%
                                acrylic 900 Grms/mt</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /Product Description -->
        <!-- People Also Bought -->
        <section>
            <div class="container">
                <div class="flat-title wow fadeInUp">
                    <h4 class="title">People Also Bought</h4>
                </div>
                <div class="hover-sw-nav  wow fadeInUp">
                    <div dir="ltr" class="swiper tf-swiper wrap-sw-over" data-swiper='{
                        "slidesPerView": 2,
                        "spaceBetween": 12,
                        "speed": 800,
                        "observer": true,
                        "observeParents": true,
                        "slidesPerGroup": 2,
                        "navigation": {
                            "clickable": true,
                            "nextEl": ".nav-next-bought",
                            "prevEl": ".nav-prev-bought"
                        },
                        "pagination": { "el": ".sw-pagination-bought", "clickable": true },
                        "breakpoints": {
                        "768": { "slidesPerView": 3, "spaceBetween": 12, "slidesPerGroup": 3 },
                        "1200": { "slidesPerView": 4, "spaceBetween": 24, "slidesPerGroup": 4}
                        }
                    }'>
                        <div class="swiper-wrapper">
                            <!-- item 1 -->
                            <div class="swiper-slide">
                                <div class="card-product style-2 card-product-size">
                                    <div class="card-product-wrapper">
                                        <a href="product-detail.html" class="product-img">
                                            <img class="img-product lazyload"
                                                data-src="images/products/fashion/product-10.jpg"
                                                src="images/products/fashion/product-10.jpg" alt="image-product">
                                            <img class="img-hover lazyload"
                                                data-src="images/products/fashion/product-20.jpg"
                                                src="images/products/fashion/product-20.jpg" alt="image-product">
                                        </a>
                                        <ul class="list-product-btn">
                                            <li>
                                                <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                                    class="box-icon hover-tooltip">
                                                    <span class="icon icon-cart2"></span>
                                                    <span class="tooltip">Add to Cart</span>
                                                </a>
                                            </li>
                                            <li class="wishlist">
                                                <a href="javascript:void(0);" class="box-icon hover-tooltip">
                                                    <span class="icon icon-heart2"></span>
                                                    <span class="tooltip">Add to Wishlist</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#quickView" data-bs-toggle="modal"
                                                    class="box-icon quickview hover-tooltip">
                                                    <span class="icon icon-view"></span>
                                                    <span class="tooltip">Quick View</span>
                                                </a>
                                            </li>
                                            <li class="compare">
                                                <a href="#compare" data-bs-toggle="modal" aria-controls="compare"
                                                    class="box-icon hover-tooltip">
                                                    <span class="icon icon-compare"></span>
                                                    <span class="tooltip">Add to Compare</span>
                                                </a>
                                            </li>
                                        </ul>
                                        <ul class="size-box">
                                            <li class="size-item text-xs text-white">XS</li>
                                            <li class="size-item text-xs text-white">S</li>
                                            <li class="size-item text-xs text-white">M</li>
                                            <li class="size-item text-xs text-white">L</li>
                                            <li class="size-item text-xs text-white">XL</li>
                                            <li class="size-item text-xs text-white">2XL</li>
                                        </ul>
                                        <div class="on-sale-wrap flex-column">
                                            <span class="on-sale-item">20% Off</span>
                                            <span class="on-sale-item trending">Trending</span>
                                        </div>
                                    </div>
                                    <div class="card-product-info">
                                        <a href="product-detail.html" class="name-product link fw-medium text-md">Loose
                                            Fit Tee</a>
                                        <p class="price-wrap fw-medium">
                                            <span class="price-new text-primary">$230.00</span>
                                            <span class=" price-old">$249.00</span>
                                        </p>
                                        <ul class="list-color-product">
                                            <li class="list-color-item color-swatch hover-tooltip tooltip-bot active">
                                                <span class="tooltip color-filter">Blue</span>
                                                <span class="swatch-value bg-light-blue-2"></span>
                                                <img class=" lazyload" data-src="images/products/fashion/product-10.jpg"
                                                    src="images/products/fashion/product-10.jpg" alt="image-product">
                                            </li>
                                            <li class="list-color-item color-swatch hover-tooltip line tooltip-bot">
                                                <span class="tooltip color-filter">White</span>
                                                <span class="swatch-value bg-white"></span>
                                                <img class=" lazyload" data-src="images/products/fashion/product-4.jpg"
                                                    src="images/products/fashion/product-4.jpg" alt="image-product">
                                            </li>
                                            <li class="list-color-item color-swatch hover-tooltip tooltip-bot">
                                                <span class="tooltip color-filter">Pink</span>
                                                <span class="swatch-value bg-light-pink-9"></span>
                                                <img class=" lazyload" data-src="images/products/fashion/product-30.jpg"
                                                    src="images/products/fashion/product-30.jpg" alt="image-product">
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="d-flex d-xl-none sw-dot-default sw-pagination-bought justify-content-center"></div>
                    </div>
                    <div class="d-none d-xl-flex swiper-button-next nav-swiper nav-next-bought"></div>
                    <div class="d-none d-xl-flex swiper-button-prev nav-swiper nav-prev-bought"></div>
                </div>
            </div>
        </section>
        <!-- People Also Bought -->
        <!-- Recently Viewed -->
        <section class="flat-spacing">
            <div class="container">
                <div class="flat-title wow fadeInUp">
                    <h4 class="title">Recently Viewed</h4>
                </div>
                <div class="hover-sw-nav  wow fadeInUp">
                    <div dir="ltr" class="swiper tf-swiper wrap-sw-over" data-swiper='{
                        "slidesPerView": 2,
                        "spaceBetween": 12,
                        "speed": 800,
                        "observer": true,
                        "observeParents": true,
                        "slidesPerGroup": 2,
                        "navigation": {
                            "clickable": true,
                            "nextEl": ".nav-next-viewed",
                            "prevEl": ".nav-prev-viewed"
                        },
                        "pagination": { "el": ".sw-pagination-viewed", "clickable": true },
                        "breakpoints": {
                        "768": { "slidesPerView": 3, "spaceBetween": 12, "slidesPerGroup": 3 },
                        "1200": { "slidesPerView": 4, "spaceBetween": 24, "slidesPerGroup": 4}
                        }
                    }'>
                        <div class="swiper-wrapper">
                            <!-- item 1 -->
                            <div class="swiper-slide">
                                <div class="card-product style-2 card-product-size">
                                    <div class="card-product-wrapper">
                                        <a href="product-detail.html" class="product-img">
                                            <img class="img-product lazyload"
                                                data-src="images/products/fashion/product-5.jpg"
                                                src="images/products/fashion/product-5.jpg" alt="image-product">
                                            <img class="img-hover lazyload"
                                                data-src="images/products/fashion/product-20.jpg"
                                                src="images/products/fashion/product-20.jpg" alt="image-product">
                                        </a>
                                        <ul class="list-product-btn">
                                            <li>
                                                <a href="#shoppingCart" data-bs-toggle="offcanvas"
                                                    class="box-icon hover-tooltip">
                                                    <span class="icon icon-cart2"></span>
                                                    <span class="tooltip">Add to Cart</span>
                                                </a>
                                            </li>
                                            <li class="wishlist">
                                                <a href="javascript:void(0);" class="box-icon hover-tooltip">
                                                    <span class="icon icon-heart2"></span>
                                                    <span class="tooltip">Add to Wishlist</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#quickView" data-bs-toggle="modal"
                                                    class="box-icon quickview hover-tooltip">
                                                    <span class="icon icon-view"></span>
                                                    <span class="tooltip">Quick View</span>
                                                </a>
                                            </li>
                                            <li class="compare">
                                                <a href="#compare" data-bs-toggle="modal" aria-controls="compare"
                                                    class="box-icon hover-tooltip">
                                                    <span class="icon icon-compare"></span>
                                                    <span class="tooltip">Add to Compare</span>
                                                </a>
                                            </li>
                                        </ul>
                                        <ul class="size-box">
                                            <li class="size-item text-xs text-white">XS</li>
                                            <li class="size-item text-xs text-white">S</li>
                                            <li class="size-item text-xs text-white">M</li>
                                            <li class="size-item text-xs text-white">L</li>
                                            <li class="size-item text-xs text-white">XL</li>
                                            <li class="size-item text-xs text-white">2XL</li>
                                        </ul>
                                        <div class="on-sale-wrap">
                                            <span class="on-sale-item">20% Off</span>
                                        </div>
                                    </div>
                                    <div class="card-product-info">
                                        <a href="product-detail.html"
                                            class="name-product link fw-medium text-md">Turtleneck T-shirt</a>
                                        <p class="price-wrap fw-medium">
                                            <span class="price-new text-primary">$130.00</span>
                                            <span class=" price-old">$150.00</span>
                                        </p>
                                        <ul class="list-color-product">
                                            <li class="list-color-item color-swatch hover-tooltip tooltip-bot active">
                                                <span class="tooltip color-filter">Grey</span>
                                                <span class="swatch-value bg-grey-4"></span>
                                                <img class=" lazyload" data-src="images/products/fashion/product-5.jpg"
                                                    src="images/products/fashion/product-5.jpg" alt="image-product">
                                            </li>
                                            <li class="list-color-item color-swatch hover-tooltip tooltip-bot">
                                                <span class="tooltip color-filter">Black</span>
                                                <span class="swatch-value bg-dark"></span>
                                                <img class=" lazyload" data-src="images/products/fashion/product-22.jpg"
                                                    src="images/products/fashion/product-22.jpg" alt="image-product">
                                            </li>
                                            <li class="list-color-item color-swatch hover-tooltip tooltip-bot">
                                                <span class="tooltip color-filter">Orange</span>
                                                <span class="swatch-value bg-light-orange"></span>
                                                <img class=" lazyload" data-src="images/products/fashion/product-18.jpg"
                                                    src="images/products/fashion/product-18.jpg" alt="image-product">
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- item 2 -->

                        </div>
                        <div class="d-flex d-xl-none sw-dot-default sw-pagination-viewed justify-content-center"></div>
                    </div>
                    <div class="d-none d-xl-flex swiper-button-next nav-swiper nav-next-viewed"></div>
                    <div class="d-none d-xl-flex swiper-button-prev nav-swiper nav-prev-viewed"></div>
                </div>
            </div>
        </section>
    </div>
</body>

@endsection@endsection