@extends('web2.layout.master')

@section('content')



<!-- Navbar Start -->

<!-- Navbar End -->
<style>
.responsive-img {
    width: 100%;
    /* Hình ảnh luôn chiếm toàn bộ chiều rộng của phần tử cha */
    height: auto;
    /* Giữ nguyên tỷ lệ khung hình, tránh méo ảnh */
    max-width: 100%;
    /* Không cho phép hình ảnh lớn hơn kích thước gốc */
    object-fit: cover;
    /* Đảm bảo ảnh không bị méo khi thu phóng */
    display: block;
    /* Loại bỏ khoảng trắng dư thừa xung quanh ảnh */
}

.view-details {
    text-decoration: none;
    /* Bỏ gạch chân */
    color: black;
    /* Màu chữ mặc định là đen */
    font-weight: 200;
    /* Làm chữ đậm nhẹ */
    transition: color 0.3s ease-in-out;
    /* Hiệu ứng chuyển đổi màu mượt mà */

    /* Làm chữ đậm nhẹ */
    font-size: 14px;

}

.view-details:hover {
    color: gold;
    /* Đổi màu thành vàng khi hover */
    text-decoration: none;
}
</style>
<style>
/* Tooltip (Chữ hiển thị khi hover) */
.tooltip-text {
    position: absolute;
    bottom: 120%;
    left: 50%;
    transform: translateX(-50%);
    background-color: black;
    color: white;
    font-size: 12px;
    padding: 5px 8px;
    border-radius: 5px;
    white-space: nowrap;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s ease-in-out, transform 0.3s ease-in-out;
}

/* Hiển thị tooltip khi hover vào icon */
.cart-icon:hover .tooltip-text {
    opacity: 1;
    visibility: visible;
    transform: translateX(-50%) translateY(-5px);
}

.product-img {
    position: relative;
    overflow: hidden;
    width: 100% !important;
    height: 250px !important;
}

.product-img img {
    width: 100% !important;
    height: 100% !important;
    object-fit: cover !important;
    transition: transform 0.4s ease-in-out !important;
}

.product-item:hover .product-img img {
    transform: scale(0.92) !important;
}

/* Hiệu ứng icon */
.product-overlay {
    position: absolute;
    bottom: -50px;
    /* Ẩn ban đầu */
    left: 47%;
    transform: translateX(-50%);
    display: flex;

    /* Giảm khoảng cách giữa các icon */
    opacity: 0;
    transition: all 0.4s ease-in-out;
}

.product-item:hover .product-overlay {
    bottom: 10px;
    /* Khi hover, icon trượt lên */
    opacity: 1;
}

/* Tạo hộp riêng cho từng icon */
.icon-box {
    width: 28px;
    /* Giảm kích thước icon box */
    height: 28px;
    /* Giảm kích thước icon box */
    background: white;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 4px;
    /* Bo góc nhẹ hơn */
    transition: background 0.3s ease-in-out, transform 0.2s ease-in-out;
    box-shadow: 0px 3px 5px rgba(0, 0, 0, 0.15);
    /* Giảm độ sâu */
}

/* Khi hover đổi nền thành xám */
.icon-box:hover {
    background: #e0e0e0;
    transform: scale(1.05);
    /* Nhẹ nhàng hơn */
}

/* Định dạng icon bên trong */
.icon-link {
    color: black !important;
    /* Đổi màu icon thành đen */
    font-size: 12px;
    /* Giảm kích thước icon */
    text-decoration: none;
    /* Bỏ gạch chân */
}
</style>
<!-- <style>
.text-primary {
    color: #007bff !important;
    /* Hoặc mã màu xanh bạn muốn */
}
</style> -->
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
<div class="container-fluid py-5" style="margin-top: 5px;">
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
                <div class="text-primaryy mr-2">
                    <small class="fas fa-star"></small>
                    <small class="fas fa-star"></small>
                    <small class="fas fa-star"></small>
                    <small class="fas fa-star-half-alt"></small>
                    <small class="far fa-star"></small>
                </div>
                <small class="pt-1">(50 Reviews)</small>
            </div>
            <div class="mb-4">
                <p class="text-dark font-weight-medium mb-0 mr-3">
                    Mã sản phẩm: <span class="text-primary" style="color:blue !important;">{!!
                        $detailproduct->product_code !!}</span>
                </p>
            </div>
            <div class="mb-4">
                <p class="text-dark font-weight-medium mb-0 mr-3">
                    Thương hiệu: <span class="text-primary" style="color:blue !important;">{!!
                        $brands ? $brands->name : 'Không có thương hiệu'
                        !!}</span>
                </p>
            </div>
            <div class="mb-4">
                <p class="text-dark font-weight-medium mb-0 mr-3">
                    Loại sản phẩm:
                    <span class="text-primary" style="color:blue !important;">
                        {!! $category ? $category->name : 'Không có danh mục' !!}
                    </span>


                </p>
            </div>

            <!-- <div class="mb-4">
                <p class="text-dark font-weight-medium mb-0 mr-3">
                    Số lượng kho: <span class="text-primary" style="color:blue !important;">{!!
                        $detailproduct->description !!}</span>
                </p>
            </div> -->



            <!-- Giá sản phẩm -->
            <!-- Giá sản phẩm -->
            <h3 class="fw-semibold text-primaryy mb-4">
                Giá: <span id="product-price" class="fs-4 text-danger fw-bold">
                    {{ number_format($detailproduct->variants->first()->price ?? $detailproduct->price) }}₫
                </span>
            </h3>

            <!-- <h3 class="fw-semibold text-primaryy mb-4">
                Số lượng kho: <span id="stock-info" class="fs-4 text-primary fw-bold">
                    {{ $detailproduct->variants->first()->stock ?? 'Không có thông tin' }} sản phẩm
                </span>
            </h3> -->

            <!-- Lựa chọn biến thể -->
            <div class="d-flex mb-3">
                <p class="text-dark font-weight-medium mb-0 mr-3">Lựa chọn:</p>
                <form id="variantForm">
                    @foreach ($detailproduct->variants as $key => $variant)
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input variant-radio" id="size-{{ $key }}" name="size"
                            data-price="{{ $variant->price }}" data-stock="{{ $variant->stock }}"
                            {{ $key == 0 ? 'checked' : '' }}> <!-- Chọn mặc định biến thể đầu tiên -->
                        <label class="custom-control-label" for="size-{{ $key }}">
                            {{ $variant->size }}ml
                        </label>
                    </div>
                    @endforeach
                </form>
            </div>



            <!-- Script cập nhật giá -->
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script>
            $(document).ready(function() {
                $('input[name="size"]').on('change', function() {
                    var selectedPrice = $(this).data('price');
                    $('#product-price').text(selectedPrice.toLocaleString('vi-VN'));
                });
            });
            </script>

            <div class="d-flex align-items-center mb-4 pt-2" style="width: 100%;">
                <div class="input-group quantity mr-3"
                    style="width: 130px; border: 1px solid black; border-radius: 4px;">
                    <div class="input-group-prepend">
                        <button class="btn btn-light btn-minus" style="border: none; pointer-events: none;">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <input type="text" class="form-control text-center" value="1"
                        style="border: none; background: white; pointer-events: none;">
                    <div class="input-group-append">
                        <button class="btn btn-light btn-plus" style="border: none; pointer-events: none;">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>
                <a href="{{ route('user.cart') }}" class="flex-grow-1">
                    <button class="btn px-4 w-100"
                        style="background: white; color: black; border: 1px solid black; border-radius: 4px; font-weight: bold; transition: 0.3s;">
                        THÊM VÀO GIỎ
                    </button>
                </a>
            </div>
            <a href="{{ route('user.checkout') }}" class="w-100 mt-2">
                <button class="btn btn-dark px-5 py-2 w-100"
                    style="font-weight: bold; transition: 0.3s;border: 1px solid black; border-radius: 4px;">
                    MUA NGAY
                </button>
            </a>

            <style>
            .btn:hover {
                background: black !important;
                color: white !important;
            }

            .btn-dark:hover {
                opacity: 0.8 !important;
            }
            </style>




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
            <div class="nav nav-tabs justify-content-center mb-4">
                <a class="nav-item nav-link active" data-toggle="tab" href="#tab-pane-1"
                    style="color: black !important; font-size: 1.1rem; font-weight: 500;">
                    Mô tả sản phẩm
                </a>
            </div>

        </div>
    </div>
</div>
<!-- Shop Detail End -->


<!-- Products Start -->
<div class="container-fluid py-5">
    <div class=" mb-5" style="margin-left: 50px;">
        <h3 class=" text-3xl font-normal tracking-wide text-black uppercase" style="font-size:25px;">
            Sản phẩm có thể yêu thích
        </h3>
    </div>

    @if ($relatedProducts->isNotEmpty())
    <div class="container" style="max-width: 1400px; margin: 0 auto; padding: 0 5px; margin-left: 0px;">
        <div class="row px-xl-5 pb-3">
            @foreach ($relatedProducts as $relatedProduct)
            <div class="col-lg-3 col-md-4 col-sm-6 col-6 mb-4">
                <div class="card product-item border-0 shadow-sm rounded position-relative">
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                        <img class="img-fluid w-100 product-image" style="height: 250px; object-fit: contain;"
                            src="{{ asset('storage/'.$relatedProduct->image) }}" alt="{{ $relatedProduct->name }}">

                        <!-- Thêm div chứa từng icon riêng biệt -->
                        <div class="product-overlay">
                            <div class="icon-box cart-icon">
                                <a href="{{ route('web.shop-detail', ['id' => $relatedProduct->id]) }}"
                                    class="icon-link">
                                    <i class="fas fa-eye"></i>
                                    <span class="tooltip-text">Xem chi tiết</span>
                                </a>
                            </div>
                            <div class="icon-box cart-icon">
                                <a href="{{ route('user.cart') }}" class="icon-link">
                                    <i class="fas fa-shopping-cart"></i>
                                    <span class="tooltip-text">Thêm vào giỏ</span>
                                </a>
                            </div>

                        </div>
                    </div>
                    <div class="card-body text-center p-3">
                        <h6 class="text-truncate mb-2">{{ $relatedProduct->name }}</h6>
                        <div class="d-flex justify-content-center align-items-center">
                            @if ($detailproduct->variants->count() > 0)
                            @php
                            $minPrice = $relatedProduct->variants->min('price');
                            $maxPrice = $relatedProduct->variants->max('price');
                            @endphp
                            <h7 class="fw-bold mb-4 d-flex align-items-center">
                                <span class="fs-5 text-dark">{{ number_format($minPrice) }}₫</span>
                                <span class="mx-2">-</span>
                                <span class="fs-5 text-dark">{{ number_format($maxPrice) }}₫</span>
                            </h7>
                            @else
                            <h7 class="fw-bold mb-4 text-dark">
                                <span class="fs-5">{{ number_format($detailproduct->price) }}₫</span>
                            </h7>
                            @endif
                        </div>


                    </div>
                </div>
            </div>
            @endforeach
        </div>


    </div>
    @else
    <div class="col-12">
        <p class="text-center text-muted">Không có sản phẩm liên quan</p>
    </div>
    @endif
</div>

{{-- sản phẩm cùng phân khúc --}}
<div class="container-fluid py-5">
    <div class="mb-5" style="margin-left: 50px;">
        <h3 class="text-3xl font-normal tracking-wide text-black uppercase" style="font-size:25px;">
            Sản phẩm cùng phân khúc
        </h3>
    </div>

    @if ($similarProducts->isNotEmpty())
    <div class="container" style="max-width: 1400px; margin: 0 auto; padding: 0 5px; margin-left: 0px;">
        <div class="row px-xl-5 pb-3">
            @foreach ($similarProducts as $similarProduct)
            <div class="col-lg-3 col-md-4 col-sm-6 col-6 mb-4">
                <div class="card product-item border-0 shadow-sm rounded position-relative">
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                        <img class="img-fluid w-100 product-image" style="height: 250px; object-fit: contain;"
                            src="{{ asset('storage/'.$similarProduct->image) }}" alt="{{ $similarProduct->name }}">
                        <div class="product-overlay">
                            <div class="icon-box cart-icon">
                                <a href="{{ route('web.shop-detail', ['id' => $similarProduct->id]) }}"
                                    class="icon-link">
                                    <i class="fas fa-eye"></i>
                                    <span class="tooltip-text">Xem chi tiết</span>
                                </a>
                            </div>
                            <div class="icon-box cart-icon">
                                <a href="{{ route('user.cart') }}" class="icon-link">
                                    <i class="fas fa-shopping-cart"></i>
                                    <span class="tooltip-text">Thêm vào giỏ</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body text-center p-3">
                        <h6 class="text-truncate mb-2">{{ $similarProduct->name }}</h6>
                        <div class="d-flex justify-content-center align-items-center">
                            @if ($similarProduct->variants->count() > 0)
                            @php
                            $minPrice = $similarProduct->variants->min('price');
                            $maxPrice = $similarProduct->variants->max('price');
                            @endphp
                            <h7 class="fw-bold mb-4 d-flex align-items-center">
                                <span class="fs-5 text-dark">{{ number_format($minPrice) }}₫</span>
                                <span class="mx-2">-</span>
                                <span class="fs-5 text-dark">{{ number_format($maxPrice) }}₫</span>
                            </h7>
                            @else
                            <h7 class="fw-bold mb-4 text-dark">
                                <span class="fs-5">{{ number_format($similarProduct->price) }}₫</span>
                            </h7>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

    </div>
    @else
    <div class="col-12">
        <p class="text-center text-muted">Không có sản phẩm liên quan</p>
    </div>
    @endif
</div>

{{-- sản phẩm đã xem --}}

<div class="container-fluid py-5">
    <div class="mb-5" style="margin-left: 50px;">
        <h3 class="text-3xl font-normal tracking-wide text-black uppercase" style="font-size:25px;">
            Sản phẩm đã xem
        </h3>
    </div>

    @if ($viewedProducts->isNotEmpty())
    <div class="container" style="max-width: 1400px; margin: 0 auto; padding: 0 5px; margin-left: 0px;">
        <div class="row px-xl-5 pb-3">
            @foreach ($viewedProducts as $viewedProduct)
            <div class="col-lg-3 col-md-4 col-sm-6 col-6 mb-4">
                <div class="card product-item border-0 shadow-sm rounded position-relative">
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                        <img class="img-fluid w-100 product-image" style="height: 250px; object-fit: contain;"
                            src="{{ asset('storage/'.$viewedProduct->image) }}" alt="{{ $viewedProduct->name }}">
                        <div class="product-overlay">
                            <div class="icon-box cart-icon">
                                <a href="{{ route('web.shop-detail', ['id' => $viewedProduct->id]) }}"
                                    class="icon-link">
                                    <i class="fas fa-eye"></i>
                                    <span class="tooltip-text">Xem chi tiết</span>
                                </a>
                            </div>
                            <div class="icon-box cart-icon">
                                <a href="{{ route('user.cart') }}" class="icon-link">
                                    <i class="fas fa-shopping-cart"></i>
                                    <span class="tooltip-text">Thêm vào giỏ</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body text-center p-3">
                        <h6 class="text-truncate mb-2">{{ $viewedProduct->name }}</h6>
                        <div class="d-flex justify-content-center align-items-center">
                            @if ($viewedProduct->variants->count() > 0)
                            @php
                            $minPrice = $viewedProduct->variants->min('price');
                            $maxPrice = $viewedProduct->variants->max('price');
                            @endphp
                            <h7 class="fw-bold mb-4 d-flex align-items-center">
                                <span class="fs-5 text-dark">{{ number_format($minPrice) }}₫</span>
                                <span class="mx-2">-</span>
                                <span class="fs-5 text-dark">{{ number_format($maxPrice) }}₫</span>
                            </h7>
                            @else
                            <h7 class="fw-bold mb-4 text-dark">
                                <span class="fs-5">{{ number_format($viewedProduct->price) }}₫</span>
                            </h7>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
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