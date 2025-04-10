@extends('web2.layout.master')

@section('content')

<!-- Navbar End -->


<!-- Shop Start -->
<div class="container-fluid pt-5">
    <div class="row px-xl-5">
        <!-- Shop Product Start -->
        <div class="col-lg-12 col-md-12">
            <div class="row pb-3">
                <div class="col-12 pb-1">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <form action="">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search by name">
                                <div class="input-group-append">
                                    <span class="input-group-text bg-transparent text-primary">
                                        <i class="fa fa-search"></i>
                                    </span>
                                </div>
                            </div>
                        </form>
                        <div class="dropdown ml-4">
                            <button class="btn border dropdown-toggle" type="button" id="triggerId"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Sort by
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="triggerId">
                                <a class="dropdown-item" href="#">Latest</a>
                                <a class="dropdown-item" href="#">Popularity</a>
                                <a class="dropdown-item" href="#">Best Rating</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center px-xl-5 pb-3">
                        @foreach ($list_product as $product)
                        <div class="col-lg-3 col-md-4 col-sm-6 col-6 mb-4">
                            <div class="card product-item border-0 shadow-sm rounded position-relative">
                                <div
                                    class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                                    <a href="{{ route('web.shop-detail', ['id' => $product->id]) }}" class="icon-link">
                                        <img class="img-fluid w-100 product-image" style="height: 250px; object-fit: contain;"
                                            src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                                    </a>
                                    <!-- Thêm div chứa từng icon riêng biệt -->
                                    <div class="product-overlay">
                                        <div class="icon-box cart-icon">
                                            <form action="{{ route('cart.create', ['id' => $product->id]) }}" method="post">
                                                @csrf
                                                <input type="hidden" name="quantity" value="1">
                                                <input type="hidden" name="name" value="{{ $product->name }}">
                                                <input type="hidden" name="price"
                                                    value="{{ $product->variants->min('price') }}">
                                                <input type="hidden" name="image" value="{{ $product->image }}">
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="fas fa-shopping-cart"></i>
                                                    Thêm vào giỏ hàng
                                                </button>
                                            </form>
    
                                        </div>
    
                                    </div>
                                </div>
                                <div class="card-body text-center p-3">
                                    <a href="{{ route('web.shop-detail', ['id' => $product->id]) }}" class="icon-link"
                                        style="text-decoration-color: #0ab39c;">
                                        <h4 class="text-truncate mb-2" style="color: #0ab39c">
                                            {{ mb_substr($product->name, 0, 20, 'UTF-8') }}</h4>
                                    </a>
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
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-12 pb-1">
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center mb-3">
                            {{ $list_product->links() }}
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Shop Product End -->
        {{-- {{ $list_product->links() }} --}}
    </div>
</div>
<!-- Shop End -->
<script>
$(function () {
    // Gọi lọc mỗi khi checkbox thay đổi
    $('.filter-checkbox').on('change', function () {
        filterProducts();
    });

    // Gọi lại khi reset
    $('#reset-filter').on('click', function () {
        $('#filter-form input[type="checkbox"]').prop('checked', false);
        filterProducts();
    });

    function filterProducts() {
        let formData = $('#filter-form').serialize();

        $.ajax({
            url: '{{ route("web.shop") }}',
            type: 'GET',
            data: formData,
            success: function (response) {
                $('#product-list').html(response);
            }
        });
    }
});
</script>

<style>
    .custom-btn {
        display: inline-block;
        padding: 12px 24px;
        border: 1px solid black;
        background-color: white;
        color: black;
        font-weight: normal;
        text-transform: uppercase;
        text-align: center;
        text-decoration: none;
        transition: all 0.3s ease;
        font-size: small;
    }
    
    .custom-btn:hover {
        background-color: black;
        color: white;
        text-decoration: none;
    }
    </style>
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
@endsection
