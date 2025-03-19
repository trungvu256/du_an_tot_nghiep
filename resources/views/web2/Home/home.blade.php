@extends('web2.layout.master')
@section('content')

<style>
body {
    background-color: #ffffff;
    font-family: 'Arial', sans-serif;
}

.perfume-card {
    background-color: #ffffff;
    border: 1px solid #000000;
    border-radius: 15px;
    box-shadow: 3px 3px 15px rgba(0, 0, 0, 0.2);
    padding: 25px;
    text-align: center;
    height: 100%;
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
}

.perfume-card:hover {
    transform: scale(1.05);
    box-shadow: 3px 3px 20px rgba(0, 0, 0, 0.3);
}

.perfume-card img {
    max-width: 100%;
    height: auto;
    margin-bottom: 20px;
    border-radius: 10px;
    border: 2px solid #000000;
}

.logo {
    font-family: 'Times New Roman', Times, serif;
    font-size: 26px;
    color: #000000;
    font-weight: bold;
    margin-bottom: 12px;
}

.title {
    font-family: 'Dancing Script', cursive;
    font-size: 30px;
    color: #000000;
    font-weight: bold;
    margin-bottom: 12px;
}

.subtitle {
    font-family: 'Montserrat', sans-serif;
    font-size: 18px;
    font-weight: bold;
    color: #000000;
    margin-bottom: 15px;
}

.description {
    font-family: 'Montserrat', sans-serif;
    font-size: 14px;
    color: #000000;
    line-height: 1.6;
    margin-bottom: 20px;
}

.details-btn {
    display: inline-block;
    padding: 12px 25px;
    background-color: #000000;
    color: #ffffff;
    text-decoration: none;
    border-radius: 8px;
    font-family: 'Montserrat', sans-serif;
    font-size: 14px;
    font-weight: bold;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.details-btn:hover {
    background-color: #333333;
    transform: translateY(-2px);
    color: #ffffff;
}

.spring-bg {
    background: url('spring-bg.jpg') center center/cover no-repeat;
    border-radius: 15px;
}

.wood-bg {
    background: url('wood-bg.jpg') center center/cover no-repeat;
    border-radius: 15px;
}

.valentine-bg {
    background: url('valentine-bg.jpg') center center/cover no-repeat;
    border-radius: 15px;
}

.section-title {
    font-family: 'Montserrat', sans-serif;
    font-size: 32px;
    color: #000000;
    font-weight: bold;
}
</style>
<!-- Navbar Start -->
<div class="container-fluid mb-5">
    <div class="row border-top px-xl-5">

        <div class="container-fluid">
            <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0">
                <a href="/" class="text-decoration-none d-block d-lg-none">
                    <h1 class="m-0 display-5 font-weight-semi-bold"><span
                            class="text-primary font-weight-bold border px-3 mr-1">Ethereal</span>Noir</h1>
                </a>
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                    {{-- @include('web2.layout.menu') --}}

                    <div class="navbar-nav ml-auto py-0">

                    </div>
                    <div class="navbar-nav ml-auto py-0">

                    </div>
                </div>
            </nav>
            <div id="header-carousel" class="containerfluid carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active" style="height: 550px;">
                        <img class="img-fluid" src="{{ asset('/images/Banner/banner02.png') }}" alt="Image">
                        <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                            <div class="p-3" style="max-width: 700px;">
                                <h4 class="text-light text-uppercase font-weight-medium mb-3">10% Off Your First Order
                                </h4>
                                <h3 class="display-4 text-white font-weight-semi-bold mb-4">Fashionable Dress</h3>
                                <a href="" class="btn btn-light py-2 px-3">Shop Now</a>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item" style="height: 550px;">
                        <img class="img-fluid" src="{{ asset('/images/Banner/banner01.jpg') }}" alt="Image">
                        <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                            <div class="p-3" style="max-width: 700px;">
                                <h4 class="text-light text-uppercase font-weight-medium mb-3">10% Off Your First Order
                                </h4>
                                <h3 class="display-4 text-white font-weight-semi-bold mb-4">Reasonable Price</h3>
                                <a href="" class="btn btn-light py-2 px-3">Shop Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#header-carousel" data-slide="prev">
                    <div class="btn btn-dark" style="width: 45px; height: 45px;">
                        <span class="carousel-control-prev-icon mb-n2"></span>
                    </div>
                </a>
                <a class="carousel-control-next" href="#header-carousel" data-slide="next">
                    <div class="btn btn-dark" style="width: 45px; height: 45px;">
                        <span class="carousel-control-next-icon mb-n2"></span>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
<!-- Navbar End -->


<!-- Featured Start -->
<div class="container-fluid pt-5">
    <div class="row px-xl-5 pb-3">
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                <h1 class="fa fa-check text-primary m-0 mr-3"></h1>
                <h5 class="font-weight-semi-bold m-0">Quality Product</h5>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                <h1 class="fa fa-shipping-fast text-primary m-0 mr-2"></h1>
                <h5 class="font-weight-semi-bold m-0">Free Shipping</h5>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                <h1 class="fas fa-exchange-alt text-primary m-0 mr-3"></h1>
                <h5 class="font-weight-semi-bold m-0">14-Day Return</h5>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                <h1 class="fa fa-phone-volume text-primary m-0 mr-3"></h1>
                <h5 class="font-weight-semi-bold m-0">24/7 Support</h5>
            </div>
        </div>
    </div>
</div>
<!-- Featured End -->


<!-- Categories Start -->
<div class="container-fluid pt-5">
    <div class="text-center mb-4">
        <h2 class="section-title px-5"><span class="px-2">Sản phẩm</span></h2>
    </div>
    <div class="row px-xl-5 pb-3">
        @foreach ($products as $product)
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card product-item border-0 shadow-sm rounded">
                <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                    <img class="img-fluid w-100" src="{{ asset('storage/'.$product->image) }}"
                        alt="{{ $product->name }}">
                </div>
                <div class="card-body text-center p-3">
                    <h6 class="text-truncate mb-3">{{ $product->name }}</h6>
                    <div class="d-flex justify-content-center align-items-center">
                        @php
                            $minPrice = $product->variants->min('price');
                            $maxPrice = $product->variants->max('price');
                        @endphp
                    
                        <h6 class="text-danger font-weight-bold">
                            {{ number_format($minPrice) }}₫
                            @if ($minPrice !== $maxPrice)
                                - {{ number_format($maxPrice) }}₫
                            @endif
                        </h6>
                    </div>
                    
                </div>
                <div class="card-footer bg-light border-top d-flex justify-content-between">
                    <a href="{{ route('web.shop-detail', ['id' => $product->id]) }}"
                        class="btn btn-outline-primary btn-sm">
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
</div>
<!-- Categories End -->






< <!-- JavaScript để xử lý hiệu ứng hover -->


    <!-- Thêm vào phần <head> nếu cần -->


    <!-- Offer Start -->
    <div class="container-fluid offer pt-5">
        <div class="row px-xl-5">
            <div class="col-md-6 pb-4">
                <div class="position-relative bg-secondary text-center text-md-right text-white mb-2 py-5 px-5">
                    <img src="" alt="" style="width: 100%; height: auto; display: block;">

                    <div class="position-relative" style="z-index: 1;">
                        <h class="text-uppercase text-primary mb-3">20% off the all order</h5>
                            <h1 class="mb-4 font-weight-semi-bold">Spring Collection</h1>
                            <a href="" class="btn btn-outline-primary py-md-2 px-md-3">Mua ngay</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 pb-4">
                <div class="position-relative bg-secondary text-center text-md-right text-white mb-2 py-5 px-5">
                    <img src="" alt="" style="width: 100%; height: auto; display: block;">

                    <div class="position-relative" style="z-index: 1;">
                        <h class="text-uppercase text-primary mb-3">20% off the all order</h5>
                            <h1 class="mb-4 font-weight-semi-bold">Spring Collection</h1>
                            <a href="" class="btn btn-outline-primary py-md-2 px-md-3">Mua ngay
                            </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- Offer End -->


    <!-- Products Start -->
    <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">Sản phẩm mới</span></h2>
        </div>

        <div class="row px-xl-5 pb-3">
            @foreach ($list_product as $product)
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="card product-item border-0 shadow-sm rounded">
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                        <img class="img-fluid w-100" src="{{ asset('storage/'.$product->image) }}"
                            alt="{{ $product->name }}">
                    </div>
                    <div class="card-body text-center p-3">
                        <h6 class="text-truncate mb-3">{{ $product->name }}</h6>
                        <div class="d-flex justify-content-center align-items-center">
                            @php
                                $minPrice = $product->variants->min('price');
                                $maxPrice = $product->variants->max('price');
                            @endphp
                        
                            <h6 class="text-danger font-weight-bold">
                                {{ number_format($minPrice) }}₫
                                @if ($minPrice !== $maxPrice)
                                    - {{ number_format($maxPrice) }}₫
                                @endif
                            </h6>
                        </div>
                        
                    </div>
                    <div class="card-footer bg-light border-top d-flex justify-content-between">
                        <a href="{{ route('web.shop-detail', ['id' => $product->id]) }}"
                            class="btn btn-outline-primary btn-sm">
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
    </div>

    <!-- Products End -->


    <!-- Subscribe Start -->
    <div class="container-fluid bg-secondary my-5">
        <div class="row justify-content-md-center py-5 px-xl-5">
            <div class="col-md-6 col-12 py-5">
                <div class="text-center mb-2 pb-2">
                    <h2 class="section-title px-5 mb-3"><span class="bg-secondary px-2">Đăng ký
                            nhận tin</span></h2>
                    <p>Bạn có muốn nhận khuyến mãi đặc biệt?</p>
                </div>
                <form action="">
                    <div class="input-group">
                        <input type="text" class="form-control border-white p-4" placeholder="Nhập địa chỉ email">
                        <div class="input-group-append">
                            <button class="btn btn-primary px-4">Đăng ký</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Subscribe End -->


    <!-- Products Start -->
    <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">Sản phẩm HOT</span></h2>
        </div>

        <div class="row px-xl-5 pb-3">
            @foreach ($list_product_new as $product)
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="card product-item border-0 shadow-sm rounded">
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                        <img class="img-fluid w-100" src="{{ asset('storage/'.$product->image) }}"
                            alt="{{ $product->name }}">
                    </div>
                    <div class="card-body text-center p-3">
                        <h6 class="text-truncate mb-3">{{ $product->name }}</h6>
                        <div class="d-flex justify-content-center align-items-center">
                            @php
                                $minPrice = $product->variants->min('price');
                                $maxPrice = $product->variants->max('price');
                            @endphp
                        
                            <h6 class="text-danger font-weight-bold">
                                {{ number_format($minPrice) }}₫
                                @if ($minPrice !== $maxPrice)
                                    - {{ number_format($maxPrice) }}₫
                                @endif
                            </h6>
                        </div>
                        
                    </div>
                    <div class="card-footer bg-light border-top d-flex justify-content-between">
                        <a href="{{ route('web.shop-detail', ['id' => $product->id]) }}"
                            class="btn btn-outline-primary btn-sm">
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
    </div>

    <!-- Products End -->
    <!-- bài viết -->






    <body>

        <div class="container py-5">
            <div class="text-center mb-4">
                <h2 class="section-title px-5"><span class="px-2">Bài viết</span></h2>
            </div>
            <div class="row">
                <!-- Card 1 -->
                @if(isset($blogs) && $blogs->count() > 0)
                @foreach ($blogs as $blog)
                <div class="col-12 col-md-4 mb-4">
                    <div class="perfume-card spring-bg">
                        <img src="{{ asset('blog/' . $blog->image) }}" alt="{{ $blog->title }}" class="img-fluid">
                        <div class="logo">{{ $blog->author }}</div>
                        <div class="title">{{ Str::limit($blog->title, 10, '...') }}</div>
                        <div class="subtitle">{{ Str::limit($blog->preview, 10, '...') }}</div>
                        <div class="description">
                            {{ Str::limit(strip_tags($blog->content), 50, '...') }}
                        </div>
                        <a href="{{route('web.detaiWebBlog.blog', $blog->id)}}" class="details-btn">Xem chi tiết</a>
                    </div>
                </div>
                @endforeach
                @else
                <p>Không có bài viết nào.</p>
                @endif




            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js">
        </script>
    </body>

    </html>

    </div>
    <!-- Products End -->


    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const overlays = document.querySelectorAll(".hover-overlay");
        overlays.forEach(overlay => {
            const productImg = overlay.closest(".product-img");
            productImg.addEventListener("mouseenter", () => {
                overlay.classList.add("opacity-100");
            });
            productImg.addEventListener("mouseleave", () => {
                overlay.classList.remove("opacity-100");
            });
        });
    });
    </script>
    <!-- Vendor End -->

    @endsection