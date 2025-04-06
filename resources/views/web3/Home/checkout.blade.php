@extends('web3.layout.master2')
@section('content')

<body>
    <div id="wrapper">
        <!-- Breadcrumb -->

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
                        <span class="text">Checkout</span>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /Breadcrumb -->
        <!-- Title Page -->
        <section class="page-title">
            <div class="container">
                <div class="box-title text-center justify-items-center">
                    <h4 class="title">Checkout</h4>
                </div>
            </div>
        </section>
        <!-- /Title Page -->

        <!-- Cart Section -->
        <div class="flat-spacing-25">
            <div class="container">
                <div class="row">
                    <div class="col-xl-8">
                        <form class="tf-checkout-cart-main">
                            <div class="box-ip-checkout">
                                <div class="title text-xl fw-medium">Checkout</div>
                                <div class="grid-2 mb_16">
                                    <div class="tf-field style-2 style-3">
                                        <input class="tf-field-input tf-input" id="firstname" placeholder=" "
                                            type="text" name="firstname">
                                        <label class="tf-field-label" for="firstname">First name</label>
                                    </div>
                                    <div class="tf-field style-2 style-3">
                                        <input class="tf-field-input tf-input" id="lastname" placeholder=" " type="text"
                                            name="lastname">
                                        <label class="tf-field-label" for="lastname">Last name</label>
                                    </div>
                                </div>
                                <fieldset class="tf-field style-2 style-3 mb_16">
                                    <input class="tf-field-input tf-input" id="country" type="text" name="country"
                                        placeholder="">
                                    <label class="tf-field-label" for="country">Country</label>
                                </fieldset>
                                <fieldset class="tf-field style-2 style-3 mb_16">
                                    <input class="tf-field-input tf-input" id="address" type="text" name="address"
                                        placeholder="">
                                    <label class="tf-field-label" for="address">Address</label>
                                </fieldset>
                                <fieldset class="mb_16">
                                    <input type="text" class="style-2" name="apartment"
                                        placeholder="Apartment, suite, etc (optional)">
                                </fieldset>
                                <div class="grid-3 mb_16">
                                    <fieldset class="tf-field style-2 style-3">
                                        <input class="tf-field-input tf-input" id="city" type="text" name="city"
                                            placeholder="">
                                        <label class="tf-field-label" for="city">City</label>
                                    </fieldset>
                                    <div class="tf-select select-square">
                                        <select name="State" id="state">
                                            <option value="">State</option>
                                            <option value="alabama">Alabama</option>
                                            <option value="alaska">Alaska</option>
                                            <option value="california">California</option>
                                            <option value="hawaii">Hawaii</option>
                                            <option value="texas">Texas</option>
                                            <option value="georgia">Georgia</option>
                                        </select>
                                    </div>
                                    <fieldset class="tf-field style-2 style-3">
                                        <input class="tf-field-input tf-input" id="code" type="text" name="zipcode"
                                            placeholder="">
                                        <label class="tf-field-label" for="code">Zipcode/Postal</label>
                                    </fieldset>
                                </div>
                                <fieldset class="tf-field style-2 style-3 mb_16">
                                    <input class="tf-field-input tf-input" id="phone" type="text" name="phone"
                                        placeholder="">
                                    <label class="tf-field-label" for="phone">Phone</label>
                                </fieldset>
                            </div>
                            <div class="box-ip-contact">
                                <div class="title">
                                    <div class="text-xl fw-medium">Contact Information</div>
                                    <a href="#login" class="text-sm link">Log in</a>
                                </div>
                                <input class="style-2" id="email/phone" placeholder="Email or phone number" type="text"
                                    name="email/phone">
                            </div>
                            <div class="box-ip-shipping">
                                <div class="title text-xl fw-medium">Shipping Method</div>
                                <fieldset class="mb_16">
                                    <label for="freeship" class="check-ship">
                                        <input type="radio" id="freeship" class="tf-check-rounded" name="checkshipping">
                                        <span class="text text-sm">
                                            <span>Free Shipping (Estimate in 7/10 - 10/10/2025)</span>
                                            <span class="price">$00.00</span>
                                        </span>
                                    </label>
                                </fieldset>
                                <fieldset>
                                    <label for="expship" class="check-ship">
                                        <input type="radio" id="expship" class="tf-check-rounded" name="checkshipping"
                                            checked>
                                        <span class="text text-sm">
                                            <span>Express Shipping (Estimate in 4/10 - 5/10/2025)</span>
                                            <span class="price">$10.00</span>
                                        </span>
                                    </label>
                                </fieldset>
                            </div>
                            <div class="box-ip-payment">
                                <div class="title">
                                    <div class="text-lg fw-medium mb_4">Payment</div>
                                    <p class="text-sm text-main">All transactions are secure and encrypted.</p>
                                </div>
                                <fieldset class="mb_12">
                                    <label for="bank-transfer" class="check-payment">
                                        <input type="checkbox" id="bank-transfer" class="tf-check-rounded"
                                            name="bank-transfer">
                                        <span class="text-payment text-sm">Direct bank transfer</span>
                                    </label>
                                </fieldset>
                                <p class="mb_16 text-main">Make your payment directly into our bank account. Please use
                                    your Order ID as the payment reference.Your order will not be shipped until the
                                    funds have cleared in our account.</p>
                                <div class="payment-method-box" id="payment-method-box">
                                    <div class="payment-item mb_16">
                                        <label for="delivery" class="payment-header collapsed" data-bs-toggle="collapse"
                                            data-bs-target="#delivery-payment" aria-controls="delivery-payment">
                                            <input type="radio" name="payment-method" class="tf-check-rounded"
                                                id="delivery">
                                            <span class="pay-title text-sm">Cash on delivery</span>
                                        </label>
                                        <div id="delivery-payment" class="collapse"
                                            data-bs-parent="#payment-method-box"></div>
                                    </div>
                                    <div class="payment-item mb_16">
                                        <label for="credit-card" class="payment-header" data-bs-toggle="collapse"
                                            data-bs-target="#credit-card-payment" aria-controls="credit-card-payment">
                                            <input type="radio" name="payment-method" class="tf-check-rounded"
                                                id="credit-card" checked>
                                            <span class="pay-title text-sm">Credit Card</span>
                                        </label>
                                        <div id="credit-card-payment" class="collapse show"
                                            data-bs-parent="#payment-method-box">
                                            <div class="payment-body">
                                                <fieldset class="ip-card mb_16">
                                                    <input type="text" class="style-2" placeholder="Card number">
                                                    <img class="card-logo" width="41" height="12"
                                                        src="images/payment/visa-2.png" alt="card">
                                                </fieldset>
                                                <div class="grid-2 mb_16">
                                                    <input type="text" class="style-2"
                                                        placeholder="Expiration date (MM/YY)">
                                                    <input type="text" class="style-2" placeholder="Sercurity code">
                                                </div>
                                                <fieldset class="mb_16">
                                                    <input type="text" class="style-2" placeholder="Name on card">
                                                </fieldset>
                                                <div class="cb-ship">
                                                    <input type="checkbox" checked class="tf-check" id="checkShip">
                                                    <label for="checkShip" class="text-sm text-main">Use shipping
                                                        address as billing address</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="payment-item paypal-payment mb_16">
                                        <label for="paypal" class="payment-header collapsed" data-bs-toggle="collapse"
                                            data-bs-target="#paypal-payment" aria-controls="paypal-payment">
                                            <input type="radio" name="payment-method" class="tf-check-rounded"
                                                id="paypal">
                                            <span class="pay-title text-sm">PayPal<img class="card-logo" width="78"
                                                    height="20" src="images/payment/paypal-2.png" alt="apple"></span>
                                        </label>
                                        <div id="paypal-payment" class="collapse" data-bs-parent="#payment-method-box">
                                        </div>
                                    </div>
                                </div>
                                <p class="text-dark-6 text-sm">Your personal data will be used to process your order,
                                    support your experience throughout this website, and for other purposes described in
                                    our <a href="privacy-policy.html"
                                        class="fw-medium text-decoration-underline link text-sm">privacy policy.</a></p>

                            </div>
                        </form>
                    </div>
                    <div class="col-xl-4">
                        <div class="tf-page-cart-sidebar">
                            <form action="https://vineta-html.vercel.app/thank-you.html" class="cart-box order-box">
                                <div class="title text-lg fw-medium">In your cart</div>
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
                                    <li class="order-item">
                                        <figure class="img-product">
                                            <img src="images/products/fashion/order-3.jpg" alt="product">
                                            <span class="quantity">1</span>
                                        </figure>
                                        <div class="content">
                                            <div class="info">
                                                <p class="name text-sm fw-medium">Loose Fit Tee</p>
                                                <span class="variant">White / L</span>
                                            </div>
                                            <span class="price text-sm fw-medium">$130.00</span>
                                        </div>
                                    </li>
                                </ul>
                                <ul class="list-total">
                                    <li class="total-item text-sm d-flex justify-content-between">
                                        <span>Subtotal:</span>
                                        <span class="price-sub fw-medium">$480.00 USD</span>
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
                                    <span class="total-price-order">$490.00 USD</span>
                                </div>
                                <div class="btn-order">
                                    <button type="submit" class="tf-btn btn-dark2 animate-btn w-100">Place
                                        order</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Cart Section -->
    </div>
</body>
@endsection