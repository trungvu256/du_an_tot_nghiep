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

               
                <form id="variantForm" class="d-flex flex-column" method="POST" action="{{ route('cart.create', $detailproduct->id) }}">
                    @csrf
                    
                    <!-- Thông tin sản phẩm -->
                    <input type="hidden" name="product_id" value="{{ $detailproduct->id }}">
                    <input type="hidden" name="name" value="{{ $detailproduct->name }}">
                    <input type="hidden" name="image" value="{{ $detailproduct->image }}">
                    <input type="hidden" name="price" id="selectedPrice" value="{{ $detailproduct->variants->min('price') ?? 0 }}">
                    <input type="hidden" name="price_sale" id="selectedSalePrice">
                    <input type="hidden" name="stock_quantity" id="selectedStock">
                    <input type="hidden" id="selectedAttributes" name="attributes">
                
                    <!-- Chọn thuộc tính -->
                    @php
                        // Tạo mảng $attributes từ $detailproduct->variants nếu chưa có
                        if (!isset($attributes) || empty($attributes)) {
                            $attributes = [];
                            if ($detailproduct->variants->isNotEmpty()) {
                                foreach ($detailproduct->variants as $variant) {
                                    foreach ($variant->product_variant_attributes as $attr) {
                                        $attrName = $attr->attribute->name;
                                        $attrValue = $attr->attributeValue->value;
                                        if (!isset($attributes[$attrName])) {
                                            $attributes[$attrName] = [];
                                        }
                                        if (!in_array($attrValue, $attributes[$attrName])) {
                                            $attributes[$attrName][] = $attrValue;
                                        }
                                    }
                                }
                            }
                        }
                
                        // Tạo mảng để lưu các tổ hợp thuộc tính và thông tin biến thể
                        $variantData = [];
                        if ($detailproduct->variants->isNotEmpty()) {
                            foreach ($detailproduct->variants as $variant) {
                                $attributesCombo = [];
                                foreach ($variant->product_variant_attributes as $attr) {
                                    $attrName = $attr->attribute->name;
                                    $attrValue = $attr->attributeValue->value;
                                    $attributesCombo[$attrName] = $attrValue;
                                }
                                $variantKey = json_encode($attributesCombo);
                                $variantData[$variantKey] = [
                                    'price' => $variant->price,
                                    'price_sale' => $variant->price_sale ?? 0,
                                    'stock' => $variant->stock_quantity,
                                ];
                            }
                        }
                        // Debug dữ liệu
                        // dd($attributes, $variantData);
                    @endphp
                
                    @if (empty($attributes))
                        <p>Không có thuộc tính nào để chọn.</p>
                    @else
                        @foreach ($attributes as $attrName => $values)
                            @if (!empty($values) && is_array($values))
                                <div class="variant-group mb-3">
                                    <h5 class="mb-2">{{ $attrName }}:</h5>
                                    @foreach ($values as $value)
                                        <button type="button" class="btn btn-outline-dark m-1 variant-option"
                                            data-attribute="{{ $attrName }}" 
                                            data-value="{{ $value }}"
                                            onclick="selectAttribute(this)">
                                            <strong>{{ $value }}</strong>
                                        </button>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    @endif
                
                    <!-- Hiển thị giá và tồn kho -->
                    <div class="mb-4">
                        {{-- <p>
                            <strong>Giá: </strong>
                            <span id="product-original-price" style="text-decoration: line-through; color: red; display: none;"></span>
                            <span id="product-sale-price"></span>
                        </p> --}}
                        <p id="product-stock-wrapper" style="display: none;">
                            <strong>Tồn kho:</strong> <span id="product-stock"></span>
                        </p>
                    </div>
                
                    <!-- Chọn số lượng -->
                    <!-- Chọn số lượng -->
<div class="form-group mb-3">
    <label for="quantity">Số lượng:</label>
    <div class="input-group">
        <button type="button" class="btn btn-outline-secondary" onclick="decreaseQuantity()">-</button>
        <input type="number" id="quantity" name="quantity" value="1" min="1" class="form-control text-center" required>
        <button type="button" class="btn btn-outline-secondary" onclick="increaseQuantity()">+</button>
    </div>
    <small id="quantity-error" class="text-danger" style="display: none;">Số lượng phải từ 1 đến số lượng tồn kho</small>
</div>
                    <!-- Nút thêm vào giỏ -->
                    <button type="submit" class="btn btn-primary px-3 mt-3">
                        <i class="fas fa-shopping-cart"></i>
                        Thêm vào giỏ
                    </button>
                </form>
                

                <script>
                    // Thêm các hàm mới vào script
function updateQuantityLimit(stock) {
    const quantityInput = document.getElementById('quantity');
    if (stock > 0) {
        quantityInput.max = stock;
        if (parseInt(quantityInput.value) > stock) {
            quantityInput.value = stock;
        }
        if (parseInt(quantityInput.value) < 1) {
            quantityInput.value = 1;
        }
    } else {
        quantityInput.max = 1;
        quantityInput.value = 1;
    }
    validateQuantity();
}

function validateQuantity() {
    const quantityInput = document.getElementById('quantity');
    const stock = parseInt(document.getElementById('selectedStock').value) || 0;
    const errorMsg = document.getElementById('quantity-error');
    let currentValue = parseInt(quantityInput.value) || 1;
    
    if (currentValue > stock) {
        quantityInput.value = stock;
        errorMsg.style.display = 'block';
    } else if (currentValue < 1) {
        quantityInput.value = 1;
        errorMsg.style.display = 'block';
    } else {
        errorMsg.style.display = 'none';
    }
}

function increaseQuantity() {
    const quantityInput = document.getElementById('quantity');
    const stock = parseInt(document.getElementById('selectedStock').value) || 0;
    let currentValue = parseInt(quantityInput.value);
    
    if (currentValue < stock) {
        quantityInput.value = currentValue + 1;
    }
    validateQuantity();
}

function decreaseQuantity() {
    const quantityInput = document.getElementById('quantity');
    let currentValue = parseInt(quantityInput.value);
    
    if (currentValue > 1) {
        quantityInput.value = currentValue - 1;
    }
    validateQuantity();
}

// Cập nhật hàm updateProductInfo hiện có
function updateProductInfo(price, salePrice, stock) {
    let originalPriceEl = document.getElementById("product-original-price");
    let salePriceEl = document.getElementById("product-sale-price");
    let stockEl = document.getElementById("product-stock");
    let stockWrapper = document.getElementById("product-stock-wrapper");

    if (salePrice > 0 && salePrice < price) {
        originalPriceEl.style.display = "inline";
        originalPriceEl.innerText = new Intl.NumberFormat('vi-VN').format(price) + '₫';
        salePriceEl.innerText = new Intl.NumberFormat('vi-VN').format(salePrice) + '₫';
    } else {
        originalPriceEl.style.display = "none";
        salePriceEl.innerText = new Intl.NumberFormat('vi-VN').format(price) + '₫';
    }

    stockWrapper.style.display = "block";
    stockEl.innerText = stock > 0 ? `Còn ${stock} sản phẩm` : "Hết hàng";

    document.getElementById("selectedPrice").value = price;
    document.getElementById("selectedSalePrice").value = salePrice;
    document.getElementById("selectedStock").value = stock;
    
    // Cập nhật giới hạn số lượng
    updateQuantityLimit(stock);
}

// Validate khi người dùng nhập tay
document.getElementById('quantity').addEventListener('input', function(e) {
    const quantityInput = this;
    const stock = parseInt(document.getElementById('selectedStock').value) || 0;
    let value = parseInt(quantityInput.value);
    
    // Ngăn nhập số âm hoặc vượt quá stock ngay lập tức
    if (isNaN(value) || value < 1) {
        quantityInput.value = 1;
    } else if (value > stock) {
        quantityInput.value = stock;
    }
    validateQuantity();
});
                </script>
                <script>
                document.addEventListener("DOMContentLoaded", function () {
                    let selectedAttributes = {}; // Lưu các thuộc tính đã chọn
                    let defaultMinPrice = {{ $detailproduct->variants->min('price') ?? 0 }};
                    let defaultMaxPrice = {{ $detailproduct->variants->max('price') ?? 0 }};
                    const variantButtons = document.querySelectorAll('.variant-option');
                    const totalGroups = document.querySelectorAll('.variant-group').length;
                
                    // Lưu toàn bộ dữ liệu biến thể từ PHP
                    const variantData = @json($variantData);
                
                    // Đặt giá mặc định
                    function setDefaultPrice() {
                        let salePriceEl = document.getElementById("product-sale-price");
                        let originalPriceEl = document.getElementById("product-original-price");
                        let stockWrapper = document.getElementById("product-stock-wrapper");
                
                        originalPriceEl.style.display = "none";
                        if (defaultMinPrice > 0 && defaultMaxPrice > 0) {
                            salePriceEl.innerText = 
                                new Intl.NumberFormat('vi-VN').format(defaultMinPrice) + " - " +
                                new Intl.NumberFormat('vi-VN').format(defaultMaxPrice) + "₫";
                        } else {
                            salePriceEl.innerText = "Chưa có giá";
                        }
                        stockWrapper.style.display = "none";
                    }
                
                    // Cập nhật thông tin giá và tồn kho
                    function updateProductInfo(price, salePrice, stock) {
                        let originalPriceEl = document.getElementById("product-original-price");
                        let salePriceEl = document.getElementById("product-sale-price");
                        let stockEl = document.getElementById("product-stock");
                        let stockWrapper = document.getElementById("product-stock-wrapper");
                
                        if (salePrice > 0 && salePrice < price) {
                            originalPriceEl.style.display = "inline";
                            originalPriceEl.innerText = new Intl.NumberFormat('vi-VN').format(price) + '₫';
                            salePriceEl.innerText = new Intl.NumberFormat('vi-VN').format(salePrice) + '₫';
                        } else {
                            originalPriceEl.style.display = "none";
                            salePriceEl.innerText = new Intl.NumberFormat('vi-VN').format(price) + '₫';
                        }
                
                        stockWrapper.style.display = "block";
                        stockEl.innerText = stock > 0 ? `Còn ${stock} sản phẩm` : "Hết hàng";
                
                        document.getElementById("selectedPrice").value = price;
                        document.getElementById("selectedSalePrice").value = salePrice;
                        document.getElementById("selectedStock").value = stock;
                    }
                
                    // Tìm biến thể khớp với tổ hợp thuộc tính đã chọn
                    function findMatchingVariant() {
                        let selectedCount = Object.keys(selectedAttributes).length;
                
                        if (selectedCount === totalGroups) {
                            // Tìm biến thể khớp với tổ hợp thuộc tính đã chọn
                            let matchedVariant = null;
                            for (let key in variantData) {
                                let variantAttributes = JSON.parse(key);
                                let allMatched = Object.keys(selectedAttributes).every(attrName => {
                                    return variantAttributes[attrName] === selectedAttributes[attrName];
                                });
                                if (allMatched) {
                                    matchedVariant = variantData[key];
                                    break;
                                }
                            }
                
                            if (matchedVariant) {
                                let price = matchedVariant.price;
                                let salePrice = matchedVariant.price_sale;
                                let stock = matchedVariant.stock;
                                console.log('Matched Variant:', { price, salePrice, stock }); // Debug
                                updateProductInfo(price, salePrice, stock);
                            } else {
                                console.log('No matching variant found for:', selectedAttributes); // Debug
                                setDefaultPrice();
                            }
                        } else {
                            setDefaultPrice();
                        }
                    }
                
                    // Khởi tạo giá mặc định
                    setDefaultPrice();
                
                    // Hàm chọn thuộc tính
                    window.selectAttribute = function(button) {
                        let attrName = button.getAttribute('data-attribute');
                        let attrValue = button.getAttribute('data-value');
                
                        // Bỏ chọn các nút khác trong cùng nhóm
                        let groupButtons = button.closest('.variant-group').querySelectorAll('.variant-option');
                        groupButtons.forEach(btn => btn.classList.remove('active', 'btn-dark'));
                
                        // Đánh dấu nút được chọn
                        button.classList.add('active', 'btn-dark');
                
                        // Lưu lựa chọn
                        selectedAttributes[attrName] = attrValue;
                        document.getElementById('selectedAttributes').value = JSON.stringify(selectedAttributes);
                
                        // Tìm và cập nhật thông tin biến thể
                        console.log('Selected Attributes:', selectedAttributes); // Debug
                        findMatchingVariant();
                    };
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
