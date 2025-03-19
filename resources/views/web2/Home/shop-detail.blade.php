@extends('web2.layout.master')

@section('content')



    <!-- Navbar Start -->

    <!-- Navbar End -->


    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Chi tiết sản phẩm</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="">Trang chủ</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Chi tiết sản phẩm</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Shop Detail Start -->
    <div class="container-fluid py-5">
        <div class="row px-xl-5">

            <div class="col-lg-5 pb-5">
                <div id="product-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner border">
                        @foreach ($description_images as $key => $image)
                            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                <img class="w-100 h-100" src="{{ asset('storage/' . $image->image) }}" alt="Image">
                            </div>
                        @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#product-carousel" data-slide="prev">
                        <i class="fa fa-2x fa-angle-left text-dark"></i>
                    </a>
                    <a class="carousel-control-next" href="#product-carousel" data-slide="next">
                        <i class="fa fa-2x fa-angle-right text-dark"></i>
                    </a>
                </div>

            </div>

            <div class="col-lg-7 pb-5">

                <h3 class="font-weight-semi-bold">{{ $detailproduct->name }}</h3>


                <div class="d-flex mb-3">
                    <div class="text-primary mr-2">
                        <small class="fas fa-star"></small>
                        <small class="fas fa-star"></small>
                        <small class="fas fa-star"></small>
                        <small class="fas fa-star-half-alt"></small>
                        <small class="far fa-star"></small>
                    </div>
                    <small class="pt-1">(50 Reviews)</small>
                </div>
                @if ($detailproduct->variants->count() > 0)
                    @php
                        $minPrice = $detailproduct->variants->min('price');
                        $maxPrice = $detailproduct->variants->max('price');
                    @endphp
                    <h3 class="font-weight-semi-bold mb-4">{{ number_format($minPrice) }}₫ - {{ number_format($maxPrice) }}₫
                    </h3>
                @else
                    <h3 class="font-weight-semi-bold mb-4">{{ number_format($detailproduct->price) }}₫</h3>
                @endif
                <div class="mb-4">
                    <p class="text-dark font-weight-medium mb-0 mr-3">Mô tả:</p>{!! $detailproduct->description !!}
                </div>
                <div class="d-flex mb-3">
                    <p class="text-dark font-weight-medium mb-0 mr-3">ML:</p>
                    <form>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="size-1" name="size">
                            <label class="custom-control-label" for="size-1">30</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="size-2" name="size">
                            <label class="custom-control-label" for="size-2">40</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="size-3" name="size">
                            <label class="custom-control-label" for="size-3">50</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="size-4" name="size">
                            <label class="custom-control-label" for="size-4">60</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="size-5" name="size">
                            <label class="custom-control-label" for="size-5">70</label>
                        </div>
                    </form>
                </div>
                <!-- <div class="d-flex mb-4">
                    <p class="text-dark font-weight-medium mb-0 mr-3">Colors:</p>
                    <form>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="color-1" name="color">
                            <label class="custom-control-label" for="color-1">Black</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="color-2" name="color">
                            <label class="custom-control-label" for="color-2">White</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="color-3" name="color">
                            <label class="custom-control-label" for="color-3">Red</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="color-4" name="color">
                            <label class="custom-control-label" for="color-4">Blue</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="color-5" name="color">
                            <label class="custom-control-label" for="color-5">Green</label>
                        </div>
                    </form>
                </div> -->
                <div class="d-flex align-items-center mb-4 pt-2">
                    <div class="input-group quantity mr-3" style="width: 130px;">
                        <div class="input-group-btn">
                            <button class="btn btn-primary btn-minus">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                        <input type="text" class="form-control bg-secondary text-center" value="1">
                        <div class="input-group-btn">
                            <button class="btn btn-primary btn-plus">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <a href="{{ route('user.cart') }}"> <button class="btn btn-primary px-3"><i
                                class="fa fa-shopping-cart mr-1"></i> Thêm vào giỏ </button></a>


                </div>
                <a href="{{ route('user.checkout') }}"> <button class="btn btn-primary px-3"><i
                            class="fa fa-shopping-cart mr-1"></i> Mua ngay</button></a>

                <div class="d-flex pt-2">
                    <p class="text-dark font-weight-medium mb-0 mr-2">Share on:</p>
                    <div class="d-inline-flex">
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-pinterest"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row px-xl-5">
            <div class="col">
                <div class="nav nav-tabs justify-content-center border-secondary mb-4">
                    <a class="nav-item nav-link active" data-toggle="tab" href="#tab-pane-1">Mô tả chi tiết</a>
                    <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-2">Information</a>
                    <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-3">Reviews (0)</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Shop Detail End -->


    <!-- Products Start -->
    <div class="container-fluid py-5">
        <div class="mb-3 ml-5">
            <h2 class="mt-5">Sản phẩm có thể thích</h2>
        </div>

        @if ($relatedProducts->isNotEmpty())
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                    @foreach ($relatedProducts as $relatedProduct)
                        <div class="swiper-slide">
                            <div class="card product-item border-0 shadow-sm">
                                <div
                                    class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                                    <img class="img-fluid w-100" src="{{ asset('storage/' . $relatedProduct->image) }}"
                                        alt="{{ $relatedProduct->name }}">
                                </div>
                                <div class="card-body text-center p-3">
                                    <h6 class="text-truncate mb-3">{{ $relatedProduct->name }}</h6>
                                    @if ($detailproduct->variants->count() > 0)
                                        @php
                                            $minPrice = $detailproduct->variants->min('price');
                                            $maxPrice = $detailproduct->variants->max('price');
                                        @endphp
                                        <h3 class="font-weight-semi-bold mb-4">{{ number_format($minPrice) }}₫ -
                                            {{ number_format($maxPrice) }}₫</h3>
                                    @else
                                        <h3 class="font-weight-semi-bold mb-4">{{ number_format($detailproduct->price) }}₫
                                        </h3>
                                    @endif
                                </div>
                                <div class="card-footer bg-light border-top d-flex justify-content-center">
                                    <a href="{{ route('web.shop-detail', ['id' => $relatedProduct->id]) }}"
                                        class="btn btn-outline-primary btn-sm mr-2">
                                        <i class="fas fa-eye"></i> Xem chi tiết
                                    </a>
                                    <a href="{{ route('user.cart') }}" class="btn btn-outline-success btn-sm">
                                        <i class="fas fa-shopping-cart"></i> Mua ngay
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Navigation buttons -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>

                <!-- Pagination -->
                <div class="swiper-pagination"></div>
            </div>
        @else
            <div class="col-12">
                <p class="text-center text-muted">Không có sản phẩm liên quan</p>
            </div>
        @endif
    </div>

    {{-- sản phẩm cùng phân khúc --}}
    <div class="container-fluid py-5">
        <div class="mb-3 ml-5">
            <h2 class="mt-5">Sản phẩm cùng phân khúc</h2>
        </div>

        @if ($similarProducts->isNotEmpty())
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                    @foreach ($similarProducts as $relatedProduct)
                        <div class="swiper-slide">
                            <div class="card product-item border-0 shadow-sm">
                                <div
                                    class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                                    <img class="img-fluid w-100" src="{{ asset('storage/' . $relatedProduct->image) }}"
                                        alt="{{ $relatedProduct->name }}">
                                </div>
                                <div class="card-body text-center p-3">
                                    <h6 class="text-truncate mb-3">{{ $relatedProduct->name }}</h6>
                                    @if ($detailproduct->variants->count() > 0)
                                        @php
                                            $minPrice = $detailproduct->variants->min('price');
                                            $maxPrice = $detailproduct->variants->max('price');
                                        @endphp
                                        <h3 class="font-weight-semi-bold mb-4">{{ number_format($minPrice) }}₫ -
                                            {{ number_format($maxPrice) }}₫</h3>
                                    @else
                                        <h3 class="font-weight-semi-bold mb-4">{{ number_format($detailproduct->price) }}₫
                                        </h3>
                                    @endif
                                </div>
                                <div class="card-footer bg-light border-top d-flex justify-content-center">
                                    <a href="{{ route('web.shop-detail', ['id' => $relatedProduct->id]) }}"
                                        class="btn btn-outline-primary btn-sm mr-2">
                                        <i class="fas fa-eye"></i> Xem chi tiết
                                    </a>
                                    <a href="{{ route('user.cart') }}" class="btn btn-outline-success btn-sm">
                                        <i class="fas fa-shopping-cart"></i> Mua ngay
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Navigation buttons -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>

                <!-- Pagination -->
                <div class="swiper-pagination"></div>
            </div>
        @else
            <div class="col-12">
                <p class="text-center text-muted">Không có sản phẩm liên quan</p>
            </div>
        @endif
    </div>

    {{-- sản phẩm đã xem --}}

    <div class="container-fluid py-5">
        <div class="mb-3 ml-5">
            <h2 class="mt-5">Sản phẩm đã xem</h2>
        </div>

        @if ($viewedProducts->isNotEmpty())
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                    @foreach ($viewedProducts as $relatedProduct)
                        <div class="swiper-slide">
                            <div class="card product-item border-0 shadow-sm">
                                <div
                                    class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                                    <img class="img-fluid w-100" src="{{ asset('storage/' . $relatedProduct->image) }}"
                                        alt="{{ $relatedProduct->name }}">
                                </div>
                                <div class="card-body text-center p-3">
                                    <h6 class="text-truncate mb-3">{{ $relatedProduct->name }}</h6>
                                    @if ($detailproduct->variants->count() > 0)
                                        @php
                                            $minPrice = $detailproduct->variants->min('price');
                                            $maxPrice = $detailproduct->variants->max('price');
                                        @endphp
                                        <h3 class="font-weight-semi-bold mb-4">{{ number_format($minPrice) }}₫ -
                                            {{ number_format($maxPrice) }}₫</h3>
                                    @else
                                        <h3 class="font-weight-semi-bold mb-4">{{ number_format($detailproduct->price) }}₫
                                        </h3>
                                    @endif
                                </div>
                                <div class="card-footer bg-light border-top d-flex justify-content-center">
                                    <a href="{{ route('web.shop-detail', ['id' => $relatedProduct->id]) }}"
                                        class="btn btn-outline-primary btn-sm mr-2">
                                        <i class="fas fa-eye"></i> Xem chi tiết
                                    </a>
                                    <a href="{{ route('user.cart') }}" class="btn btn-outline-success btn-sm">
                                        <i class="fas fa-shopping-cart"></i> Mua ngay
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Navigation buttons -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>

                <!-- Pagination -->
                <div class="swiper-pagination"></div>
            </div>
        @else
            <div class="col-12">
                <p class="text-center text-muted">Không có sản phẩm liên quan</p>
            </div>
        @endif
    </div>

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css">

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>

    <script>
        var swiper = new Swiper(".mySwiper", {
            slidesPerView: 2,
            spaceBetween: 10,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            breakpoints: {
                768: {
                    slidesPerView: 3
                },
                1024: {
                    slidesPerView: 4
                }
            }
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var swiper = new Swiper(".mySwiper", {
                slidesPerView: 4, // Hiển thị 4 sản phẩm cùng lúc
                spaceBetween: 20, // Khoảng cách giữa các sản phẩm
                loop: true, // Vòng lặp slider
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },
                breakpoints: { // Responsive (hiển thị số sản phẩm khác nhau trên từng màn hình)
                    320: {
                        slidesPerView: 1
                    },
                    768: {
                        slidesPerView: 2
                    },
                    1024: {
                        slidesPerView: 3
                    },
                    1200: {
                        slidesPerView: 4
                    }
                }
            });
        });
    </script>

    <style>
        /* Tùy chỉnh nút điều hướng */
        .swiper-button-next,
        .swiper-button-prev {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.8);
            /* Nền trắng trong suốt */
            border-radius: 50%;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        /* Căn chỉnh vị trí nút */
        .swiper-button-next {
            right: -10px;
            /* Đẩy nút sang phải */
        }

        .swiper-button-prev {
            left: -10px;
            /* Đẩy nút sang trái */
        }

        /* Tùy chỉnh icon */
        .swiper-button-next::after,
        .swiper-button-prev::after {
            font-size: 18px;
            color: black;
            /* Đổi màu icon */
        }
    </style>
    <!-- Products End -->

@endsection
