@extends('web2.layout.master')
@section('content')


<!-- Navbar Start -->
<style>
.feature-box {
    transition: all 0.3s ease-in-out;
    background: #f8f9fa;
    cursor: pointer;
}

.feature-box:hover {
    background: white;
    color: white;
    transform: translateY(-5px);
}

.feature-box:hover h1 {
    color: white;
}
</style>
<style>
body {
    background-color: #f8f9fa;
    font-family: 'Arial', sans-serif;
    color: #333;
}

.title-link {

    color: #333;
    /* Màu mặc định */
    transition: color 0.3s ease-in-out;
    /* Hiệu ứng mượt */
}

.title-link:hover {
    color: rgb(254, 115, 84);
    /* Đổi sang màu cam khi hover */
    text-decoration: none;
    /* Đảm bảo không có gạch chân */
}

.custom-width {
    width: 80%;
    /* Hoặc 100% nếu muốn full */
    max-width: 600px;
    /* Giới hạn chiều rộng */
    margin: 0 auto;
    /* Căn giữa */
}

.title {

    font-size: 17px;
    font-weight: bold;
    color: #222;
    margin-bottom: 10px;
    margin-top: 10px;
}

.description {
    font-size: 15px;
    color: #222;
    line-height: 1.5;
    margin-bottom: 15px;
}
</style>
<div class="container-fluid mb-5">
    <div class="row border-top px-xl-5">

        <div class="container-fluid">

            <div id="header-carousel" class="containerfluid carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active" style="height: 550px;">
                        <img class="img-fluid" src="{{ asset('/images/Banner/slider_2.jpg') }}" alt="Image">
                        <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">

                        </div>
                    </div>
                    <div class="carousel-item" style="height: 550px;">
                        <img class="img-fluid" src="{{ asset('/images/Banner/slider_1.jpg') }}" alt="Image">

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
            <div class="d-flex align-items-center border rounded shadow-sm p-4 feature-box">
                <h1 class="fa fa-check text-primary m-0 mr-3"></h1>
                <h5 class="font-weight-semi-bold m-0">Sản phẩm chất lượng</h5>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="d-flex align-items-center border rounded shadow-sm p-4 feature-box">
                <h1 class="fa fa-shipping-fast text-primary m-0 mr-3"></h1>
                <h5 class="font-weight-semi-bold m-0">Miễn phí vận chuyển</h5>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="d-flex align-items-center border rounded shadow-sm p-4 feature-box">
                <h1 class="fas fa-exchange-alt text-primary m-0 mr-3"></h1>
                <h5 class="font-weight-semi-bold m-0">Đổi trả trong 14 ngày</h5>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="d-flex align-items-center border rounded shadow-sm p-4 feature-box">
                <h1 class="fa fa-phone-volume text-primary m-0 mr-3"></h1>
                <h5 class="font-weight-semi-bold m-0">Hỗ trợ 24/7</h5>
            </div>
        </div>
    </div>
</div>




<!-- Featured End -->


<!-- Categories Start -->
<div class="container-fluid pt-5">
    <div class="text-center mb-5">
        <h3 class="text-3xl font-normal tracking-wide text-black uppercase">
            BỘ SƯU TẬP MỚI
        </h3>
    </div>



    <div class="container" style="max-width: 1400px; margin: 0 auto; padding: 0 5px;">
        <div class="row justify-content-center px-xl-5 pb-3">
            @foreach ($products as $product)
            <div class="col-lg-3 col-md-4 col-sm-6 col-6 mb-4">
                <div class="card product-item border-0 shadow-sm rounded">
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                        <img class="img-fluid w-100" style="height: 250px; object-fit: contain;"
                            src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}">
                    </div>
                    <div class="card-body text-center p-3">
                        <h6 class="text-truncate mb-2">{{ $product->name }}</h6>
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
                    <div class="card-footer bg-light border-top d-flex justify-content-between p-2">
                        <a href="{{ route('web.shop-detail', ['id' => $product->id]) }}"
                            class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('user.cart') }}" class="btn btn-outline-success btn-sm">
                            <i class="fas fa-shopping-cart"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>


</div>
<!-- Categories End -->
<!-- BST NEW -->
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
    font-size: 12px;

}

.view-details:hover {
    color: gold;
    /* Đổi màu thành vàng khi hover */
    text-decoration: none;
}
</style>
<div class="container-fluid pt-5">
    <div class="container" style="max-width: 1400px; margin: 0 auto; padding: 0 40px;">
        <img src="{{ asset('/images/Banner/banner00.jpg') }}" alt="Perfume Image" class="perfume-image responsive-img">


        <!-- Text section -->
        <div class="text-center mb-5" style="margin-top: 20px;">
            <h9 class="text-5xl font-black tracking-wide text-black uppercase">
                BST SCENT OF SLAY – Nổi quy tụ những nét hương sáng tạo giúp bạn nâng tầm phong cách và tính riêng.
                Với dòng sản phẩm mới, <span class="font-bold">ARMAF mang đến cho bạn “sát khí” của riêng mình,</span>
                nổi bật mọi khoảnh khắc để trở thành spotlight cho bản tủy tột cùng sáng tạo.
                Đừng để mùi hương, đây là khí chất để bạn kể câu chuyện riêng về hành trình chinh phục mọi ánh nhìn.
            </h9>
            <br>
            <a href="#" class="view-details">Xem chi tiết →</a>
        </div>

        <!-- View Details link -->

    </div>
</div>



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
        <div class="text-center mb-5">
            <h3 class="text-3xl font-normal tracking-wide text-black uppercase">
                SẢN PHẨM HOT
            </h3>
        </div>
        <div class="container" style="max-width: 1400px; margin: 0 auto; padding: 0 20px;">


            <div class="row justify-content-center px-xl-5 pb-3">
                @foreach ($list_product as $product)
                <div class="col-lg-3 col-md-4 col-sm-6 col-6 mb-4">
                    <div class="card product-item border-0 shadow-sm rounded">
                        <div
                            class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                            <img class="img-fluid w-100" style="height: 250px; object-fit: contain;"
                                src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}">
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
                <h2 class="section-title px-5">
                    <span class="px-2">
                        <i class="fas fa-newspaper" style="color:rgb(29, 21, 35);"></i> Bài viết
                    </span>
                </h2>
            </div>

            <div class="row">
                <!-- Card 1 -->
                @if(isset($blogs) && $blogs->count() > 0)
                @foreach ($blogs as $blog)
                <div class="col-12 col-md-4 mb-4 custom-width">

                    <div class="perfume-card spring-bg">
                        <a href="{{route('web.detaiWebBlog.blog', $blog->id)}}">
                            <img src="{{ asset('blog/' . $blog->image) }}" alt="{{ $blog->title }}" class="img-fluid">
                        </a>

                        <!-- <div class="logo">{{ $blog->author }}</div> -->
                        <div class="title">
                            <a href="{{route('web.detaiWebBlog.blog', $blog->id)}}" class="title-link">
                                {{ Str::limit($blog->title, 100, '...') }}
                            </a>
                        </div>

                        <!-- <div class="subtitle">{{ Str::limit($blog->preview, 10, '...') }}</div> -->
                        <div class="description">
                            {{ Str::limit(strip_tags($blog->content), 76, '...') }}
                        </div>
                        <!-- <a href="{{route('web.detaiWebBlog.blog', $blog->id)}}" class="details-btn">Xem chi tiết</a> -->
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

    <!-- Products End -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">


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