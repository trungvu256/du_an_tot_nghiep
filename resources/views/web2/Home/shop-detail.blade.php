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

                <div class="d-flex mb-3">
                    @php
                        $minPriceSale = $detailproduct->variants->where('price_sale', '>', 0)->min('price_sale');
                        $minPrice = $minPriceSale ?? $detailproduct->variants->min('price'); // Lấy price_sale nếu có, nếu không lấy price
                        $maxPrice = $detailproduct->variants->max('price');
                    @endphp

                    <h4 id="product-price" class="font-weight-semi-bold mb-4">
                        <i class="fas fa-money-bill-wave text-success"></i>
                        <span id="product-original-price" class="text-muted"
                            style="text-decoration: line-through; display: none;"></span>
                        <span id="product-sale-price">
                            {{ number_format($minPrice, 0, ',', '.') }} - {{ number_format($maxPrice, 0, ',', '.') }}₫
                        </span>
                    </h4>
                </div>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

                <div class="mb-4">
                    <p class="text-dark font-weight-medium mb-0 mr-3"></p>{!! $detailproduct->description !!}
                </div>
                <div class="mb-4">
                    <p class="text-dark font-weight-medium mb-0 mr-3">Thương hiệu: {{ $brands->name }}</p>
                </div>
                <div class="mb-4">
                    <p class="text-dark font-weight-medium mb-0 mr-3">Loại sản phẩm: {{ $category->name }}</p>
                </div>
                <style>
                    .variant-group {
                        display: flex;
                        align-items: center;
                        flex-wrap: wrap;
                        margin-bottom: 10px;
                    }

                    .variant-group h5 {
                        margin-right: 15px;
                        white-space: nowrap;
                    }

                    .variant-option {
                        min-width: 80px;
                    }

                    .variant-option.active {
                        background-color: black;
                        color: white;
                        border-color: black;
                    }
                </style>

                <div class="mb-4">
                    <p id="product-stock-wrapper" style="display: none;">
                        <strong>Tồn kho:</strong> <span id="product-stock"></span>
                    </p>
                </div>

                <!-- Form chọn thuộc tính -->
                {{-- <form id="variantForm" class="d-flex flex-column">
                    @foreach ($attributes as $attrName => $values)
                        <div class="variant-group">
                            <h5>{{ $attrName }}:</h5>
                            @foreach ($values as $value)
                                @php
                                    // Tìm variant tương ứng với thuộc tính này
                                    $matchedVariant = null;
                                    foreach ($detailproduct->variants as $variant) {
                                        foreach ($variant->attributes as $attr) {
                                            if ($attr->attributeValue->value == $value) {
                                                $matchedVariant = $variant;
                                                break 2;
                                            }
                                        }
                                    }
                                @endphp
                                <button type="button" class="btn btn-outline-dark m-1 variant-option"
                                    data-attribute="{{ $attrName }}" data-value="{{ $value }}"
                                    data-price="{{ $matchedVariant->price ?? 'Không có giá' }}"
                                    data-sale-price="{{ $variant->price_sale > 0 ? $variant->price_sale : $variant->price }}"
                                    data-stock="{{ $matchedVariant->stock_quantity ?? 0 }}"
                                    onclick="selectAttribute(this)">
                                    <strong>{{ $value }}</strong>
                                </button>
                            @endforeach
                        </div>
                    @endforeach
                </form> --}}

                <!-- Hiển thị giá và tồn kho -->
                <div class="mb-4">
                    <p id="product-stock-wrapper" style="display: none;">
                        <strong>Tồn kho:</strong> <span id="product-stock"></span>
                    </p>
                </div>
                {{-- <div class="d-flex mb-3">
                    @php
                        $minPriceSale = $detailproduct->variants->where('price_sale', '>', 0)->min('price_sale');
                        $minPrice = $minPriceSale ?? $detailproduct->variants->min('price'); // Lấy price_sale nếu có, nếu không lấy price
                        $maxPrice = $detailproduct->variants->max('price');
                    @endphp

                    <h4 id="product-price" class="font-weight-semi-bold mb-4">
                        <i class="fas fa-money-bill-wave text-success"></i>
                        <span id="product-original-price" class="text-muted"
                            style="text-decoration: line-through; display: none;"></span>
                        <span id="product-sale-price">
                            {{ number_format($minPrice, 0, ',', '.') }} - {{ number_format($maxPrice, 0, ',', '.') }}₫
                        </span>
                    </h4>



                </div> --}}

                <script>
                    function selectAttribute(button) {
                        // Bỏ chọn tất cả các nút khác trong nhóm
                        let attributeGroup = button.closest('.variant-group');
                        let buttons = attributeGroup.querySelectorAll('.variant-option');
                        buttons.forEach(btn => {
                            btn.classList.remove('btn-dark');
                            btn.classList.add('btn-outline-dark');
                        });
                
                        // Đánh dấu nút được chọn
                        button.classList.add('btn-dark');
                        button.classList.remove('btn-outline-dark');
                
                        // Lấy giá trị từ thuộc tính data của nút bấm
                        let price = parseInt(button.getAttribute('data-price')) || 0; // Giá gốc
                        let salePrice = parseInt(button.getAttribute('data-sale-price')) || 0; // Giá khuyến mãi
                        let stock = button.getAttribute('data-stock');
                
                        // Kiểm tra xem dữ liệu có lấy đúng không
                        console.log("Giá gốc:", price, "Giá KM:", salePrice, "Tồn kho:", stock);
                
                        // Lấy các phần tử HTML cần cập nhật giá
                        let originalPriceEl = document.getElementById('product-original-price');
                        let salePriceEl = document.getElementById('product-sale-price');
                
                        // Kiểm tra nếu có giá khuyến mãi hợp lệ
                        if (salePrice > 0 && salePrice < price) {
                            originalPriceEl.style.display = 'inline'; // Hiện giá gốc
                            originalPriceEl.innerText = new Intl.NumberFormat('vi-VN').format(price) + '₫';
                            salePriceEl.innerText = new Intl.NumberFormat('vi-VN').format(salePrice) + '₫';
                        } else {
                            // Nếu không có giá khuyến mãi, chỉ hiển thị giá gốc
                            originalPriceEl.style.display = 'none'; // Ẩn giá gốc
                            salePriceEl.innerText = new Intl.NumberFormat('vi-VN').format(price) + '₫';
                        }
                
                        // Hiển thị tồn kho
                        let stockWrapper = document.getElementById('product-stock-wrapper');
                        let stockText = document.getElementById('product-stock');
                        stockWrapper.style.display = "block";
                        stockText.innerText = stock;
                    }
                </script>
                
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        let selectedAttributes = {};
                        let productId = {{ $detailproduct->id }};
                        let defaultMinPrice = {{ $minPrice }};
                        let defaultMaxPrice = {{ $maxPrice }};
                
                        function setDefaultPrice() {
                            document.getElementById("product-original-price").style.display = "none";
                            document.getElementById("product-sale-price").innerText =
                                new Intl.NumberFormat('vi-VN').format(defaultMinPrice) + " - " +
                                new Intl.NumberFormat('vi-VN').format(defaultMaxPrice) + "₫";
                        }
                
                        function updateProductInfo(variant) {
                            let originalPriceEl = document.getElementById("product-original-price");
                            let salePriceEl = document.getElementById("product-sale-price");
                
                            let price = variant.price;
                            let sale_price = variant.price_sale;
                
                            if (sale_price > 0 && sale_price < price) {
                                originalPriceEl.style.display = "inline";
                                originalPriceEl.innerText = new Intl.NumberFormat('vi-VN').format(price) + '₫';
                                salePriceEl.innerText = new Intl.NumberFormat('vi-VN').format(sale_price) + '₫';
                            } else {
                                originalPriceEl.style.display = "none";
                                salePriceEl.innerText = new Intl.NumberFormat('vi-VN').format(price) + '₫';
                            }
                
                            document.getElementById("product-stock-wrapper").style.display = "block";
                            document.getElementById("product-stock").innerText = variant.stock_quantity;
                        }
                
                        function getVariantData() {
                            let queryParams = new URLSearchParams(selectedAttributes).toString();
                
                            fetch(`/get-product-variant/${productId}?${queryParams}`)
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        updateProductInfo(data.variant);
                                    } else {
                                        console.error("Không tìm thấy biến thể phù hợp!");
                                        setDefaultPrice();
                                    }
                                });
                        }
                
                        setDefaultPrice();
                
                        // Lắng nghe sự kiện chọn thuộc tính
                        document.querySelectorAll('.variant-option').forEach(button => {
                            button.addEventListener('click', function() {
                                let attrName = this.getAttribute('data-attribute');
                                let attrValue = this.getAttribute('data-value');
                
                                let groupButtons = this.closest('.variant-group').querySelectorAll('.variant-option');
                                groupButtons.forEach(btn => btn.classList.remove('active', 'btn-dark'));
                                this.classList.add('active', 'btn-dark');
                
                                selectedAttributes[attrName] = attrValue;
                                document.getElementById('selectedAttributes').value = JSON.stringify(selectedAttributes);
                
                                getVariantData();
                            });
                        });
                    });
                </script>
                
                



                <script>
                    document.querySelectorAll('input[name="size"]').forEach(radio => {
                        radio.addEventListener('change', function() {
                            let price = this.getAttribute('data-price');
                            // Lấy các phần tử HTML cần cập nhật giá
                            let salePriceEl = document.getElementById('product-sale-price');
                            let originalPriceEl = document.getElementById('product-original-price');

                            // Giả sử 'price' là giá gốc, 'salePrice' là giá khuyến mãi lấy từ dữ liệu sản phẩm
                            if (salePrice > 0 && salePrice < price) {
                                // Có giá khuyến mãi, hiển thị cả hai giá
                                originalPriceEl.style.display = 'inline'; // Hiện giá gốc
                                originalPriceEl.innerText = new Intl.NumberFormat('vi-VN').format(price) + '₫';

                                salePriceEl.innerText = new Intl.NumberFormat('vi-VN').format(salePrice) + '₫';
                            } else {
                                // Không có khuyến mãi, chỉ hiển thị giá gốc
                                originalPriceEl.style.display = 'none'; // Ẩn giá gốc
                                salePriceEl.innerText = new Intl.NumberFormat('vi-VN').format(price) + '₫';
                            }

                        });
                    });
                </script>

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

<form id="variantForm" class="d-flex flex-column" method="POST" action="{{ route('cart.create', $detailproduct->id) }}">
    @csrf

    <!-- Thông tin sản phẩm -->
    <input type="hidden" name="product_id" value="{{ $detailproduct->id }}">
    <input type="hidden" name="name" value="{{ $detailproduct->name }}">
    <input type="hidden" name="image" value="{{ $detailproduct->image }}">
    <input type="hidden" name="price" id="selectedPrice" value="{{ $detailproduct->variants->min('price') }}">
    <input type="hidden" name="price_sale" id="selectedSalePrice">
    <input type="hidden" name="stock_quantity" id="selectedStock">
    <input type="hidden" id="selectedAttributes" name="attributes">

    <!-- Chọn thuộc tính -->
    @foreach ($attributes as $attrName => $values)
        @if (!empty($values) && is_array($values))
            <div class="variant-group mb-3">
                <h5 class="mb-2">{{ $attrName }}:</h5>
                @foreach ($values as $value)
                    @php
                        // Tìm variant có thuộc tính tương ứng
                        $matchedVariant = $detailproduct->variants->first(function ($variant) use ($value) {
                            return $variant->attributes->contains(function ($attr) use ($value) {
                                return $attr->attributeValue->value == $value;
                            });
                        });
                    @endphp

                    <button type="button" class="btn btn-outline-dark m-1 variant-option"
                        data-attribute="{{ $attrName }}" 
                        data-value="{{ $value }}"
                        data-price="{{ $matchedVariant->price ?? 0 }}"
                        data-sale-price="{{ $matchedVariant->price_sale > 0 ? $matchedVariant->price_sale : $matchedVariant->price }}"
                        data-stock="{{ $matchedVariant->stock_quantity ?? 0 }}"
                        onclick="selectAttribute(this)">
                        <strong>{{ $value }}</strong>
                    </button>
                @endforeach
            </div>
        @endif
    @endforeach

    <!-- Chọn số lượng -->
    <div class="form-group mb-3">
        <label for="quantity">Số lượng:</label>
        <input type="number" id="quantity" name="quantity" value="1" min="1" class="form-control" required>
    </div>

    <!-- Nút thêm vào giỏ -->
    <button type="submit" class="btn btn-primary px-3 mt-3">
        <i class="fas fa-shopping-cart"></i>
        Thêm vào giỏ
    </button>
</form>




<script>
    function updateQuantity(change) {
        // Lấy giá trị hiện tại của số lượng
        var quantityInput = document.getElementById('quantity');
        var currentQuantity = parseInt(quantityInput.value);

        // Cập nhật số lượng
        var newQuantity = currentQuantity + change;

        // Kiểm tra nếu số lượng nhỏ hơn 1, thì giữ nguyên số lượng
        if (newQuantity < 1) {
            newQuantity = 1;
        }

        // Cập nhật lại giá trị vào input
        quantityInput.value = newQuantity;
    }

    document.getElementById('quantity').addEventListener('input', function() {
        let quantity = this.value;
        console.log('Số lượng hiện tại: ' + quantity); // Bạn có thể thực hiện logic kiểm tra ở đây (ví dụ: kiểm tra số lượng tồn kho)
    });
</script>


                {{-- <a href="{{ route('user.checkout') }}"> <button class="btn btn-primary px-3"><i
                        class="fa fa-shopping-cart mr-1"></i> Mua ngay</button></a> --}}

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
                                <div
                                    class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                                    <img class="img-fluid w-100 product-image" style="height: 250px; object-fit: contain;"
                                        src="{{ asset('storage/' . $relatedProduct->image) }}"
                                        alt="{{ $relatedProduct->name }}">

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
                                <div
                                    class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                                    <img class="img-fluid w-100 product-image" style="height: 250px; object-fit: contain;"
                                        src="{{ asset('storage/' . $similarProduct->image) }}"
                                        alt="{{ $similarProduct->name }}">
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
                                <div
                                    class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                                    <img class="img-fluid w-100 product-image" style="height: 250px; object-fit: contain;"
                                        src="{{ asset('storage/' . $viewedProduct->image) }}"
                                        alt="{{ $viewedProduct->name }}">
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
