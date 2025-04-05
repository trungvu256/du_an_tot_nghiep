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
        .nav-tabs {
        display: flex;
        justify-content: center;
        width: 100%;
    }

    .nav-item {
        display: flex;
        justify-content: center;
    }

    .nav-link {
        text-align: center;
    }
    </style>
    <!-- Page Header Start -->
    {{-- <div class="container-fluid ">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Chi tiết sản phẩm</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="">Trang chủ</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Chi tiết sản phẩm</p>
            </div>
        </div>
    </div> --}}
    <!-- Page Header End -->

    @include('web2.sup.css')
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

                <h3 class="font-weight-semi-bold" style="color: #0ab39c">{{  $detailproduct->name }}</h3>


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

                {{-- <div class="mb-4">
                    <p class="text-dark font-weight-medium mb-0 mr-3"></p>{!! $detailproduct->description !!}
                </div> --}}
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


                <form id="variantForm" class="d-flex flex-column" method="POST"
                    action="{{ route('cart.create', $detailproduct->id) }}">
                    @csrf

                    <!-- Thông tin sản phẩm -->
                    <input type="hidden" name="product_id" value="{{ $detailproduct->id }}">
                    <input type="hidden" name="name" value="{{ $detailproduct->name }}">
                    <input type="hidden" name="image" value="{{ $detailproduct->image }}">
                    <input type="hidden" name="price" id="selectedPrice"
                        value="{{ $detailproduct->variants->min('price') ?? 0 }}">
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
                                            data-attribute="{{ $attrName }}" data-value="{{ $value }}" onclick="selectAttribute(this)">
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
                            <span id="product-original-price"
                                style="text-decoration: line-through; color: red; display: none;"></span>
                            <span id="product-sale-price"></span>
                        </p> --}}
                        <p id="product-stock-wrapper" style="display: none;">
                            <strong>Tồn kho:</strong> <span id="product-stock"></span>
                        </p>
                    </div>

                    <!-- Chọn số lượng -->
                    <!-- Chọn số lượng -->
                    <p>Số lượng :</p>
                    <div class="row">
                        <div class="form-group mb-3 col-3">
                            <div class="input-group">
                                <button type="button" class="btn btn-outline-secondary" onclick="decreaseQuantity()">-</button>
                                <input type="number" id="quantity" name="quantity" value="1" min="1"
                                    class="form-control text-center" required>
                                <button type="button" class="btn btn-outline-secondary" onclick="increaseQuantity()">+</button>
                            </div>
                            <small id="quantity-error" class="text-danger" style="display: none;">Số lượng phải từ 1 đến số
                                lượng tồn kho</small>
                        </div>
                        <!-- Nút thêm vào giỏ -->
                        <button type="submit" class="btn btn-primary col-3">
                            <i class="fas fa-shopping-cart"></i>
                             Thêm vào giỏ hàng
                        </button>
                    </div>
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
                    document.getElementById('quantity').addEventListener('input', function (e) {
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
                        window.selectAttribute = function (button) {
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

<div class="container">
        <div class="row px-xl-5 justify-content-center">
            <div class="col">
                <div class="product-tabs">
                    <!-- Tab links -->
                    <ul class="nav nav-tabs" id="product-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#tab-description">Mô tả chi tiết</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tab-comments">
                                Bình luận ({{ $product->comments->count() }})
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tab-reviews">
                                Đánh giá ({{ $product->reviews->count() }})
                            </a>
                        </li>
                    </ul>

                    <!-- Tab content -->
                    <div class="tab-content" id="product-tabs-content">
                        <!-- Mô tả chi tiết tab -->
                        <div class="tab-pane fade show active" id="tab-description" role="tabpanel">
                            <div class="product-description">
                                <!-- Hiển thị mô tả sản phẩm -->
                                <p>{!! $product->description !!}</p>
                            </div>
                        </div>

                        <!-- Tab bình luận -->
                        <div class="tab-pane fade" id="tab-comments" role="tabpanel">
                            <div class="comments-section">
                                @foreach ($product->comments as $comment)
                                    <div class="comment">
                                        <div class="comment-header">
                                            <div class="user-info">
                                                <div class="user-meta">
                                                    @if ($comment->user->image)
                                                        <img src="{{ asset('storage/' . $comment->user->image) }}"
                                                            alt="{{ $comment->user->name }}" class="user-avatar">
                                                    @else
                                                        <img src="{{ asset('path/to/default-image.png') }}"
                                                            alt="Default Avatar" class="user-avatar">
                                                    @endif
                                                    <div class="user-details">
                                                        <strong class="user-name">{{ $comment->user->name }}</strong>
                                                        <span class="comment-date">{{ $comment->created_at->format('d/m/Y H:i') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            @if ($comment->user_id == Auth::id())
                                                <div class="comment-actions">
                                                    <button class="action-btn edit-btn" onclick="toggleEditForm({{ $comment->id }})">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <form action="{{ route('client.deleteComment', [$product->id, $comment->id]) }}"
                                                        method="POST" class="delete-form" id="delete-comment-form-{{ $comment->id }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="action-btn delete-btn"
                                                                onclick="confirmDeleteComment({{ $comment->id }})">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="comment-content" id="comment-content-{{ $comment->id }}">
                                            <p>{{ $comment->comment }}</p>
                                        </div>
                                        <div id="edit-comment-form-{{ $comment->id }}" class="edit-form" style="display: none;">
                                            <form action="{{ route('client.updateComment', [$product->id, $comment->id]) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <textarea name="comment" class="form-control" required>{{ $comment->comment }}</textarea>
                                                <div class="form-actions">
                                                    <button type="submit" class="btn btn-primary">Lưu</button>
                                                    <button type="button" class="btn btn-secondary"
                                                            onclick="toggleEditForm({{ $comment->id }})">Hủy</button>
                                                </div>
                                            </form>
                                        </div>
                                        @if($comment->replies->count() > 0)
                                            <button class="replies-toggle" onclick="toggleReplies({{ $comment->id }})">
                                                <i class="fas fa-chevron-down"></i>
                                                Xem {{ $comment->replies->count() }} phản hồi
                                            </button>
                                        @endif
                                        <div class="replies" id="replies-{{ $comment->id }}">
                                            @foreach ($comment->replies as $reply)
                                                <div class="reply">
                                                    <div class="reply-header">
                                                        <div class="user-info">
                                                            <div class="user-meta">
                                                                @if ($reply->user->image)
                                                                    <img src="{{ asset('storage/' . $reply->user->image) }}"
                                                                        alt="{{ $reply->user->name }}" class="user-avatar">
                                                                @else
                                                                    <img src="{{ asset('path/to/default-image.png') }}"
                                                                        alt="Default Avatar" class="user-avatar">
                                                                @endif
                                                                <div class="user-details">
                                                                    <strong class="user-name">{{ $reply->user->name }}</strong>
                                                                    <span class="comment-date">{{ $reply->created_at->format('d/m/Y H:i') }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @if ($reply->user_id == Auth::id())
                                                            <div class="reply-actions">
                                                                <button class="action-btn edit-btn"
                                                                        onclick="toggleEditFormReply({{ $reply->id }})">
                                                                    <i class="fas fa-edit"></i>
                                                                </button>
                                                                <form action="{{ route('client.deleteReply', [$comment->id, $reply->id]) }}"
                                                                    method="POST" class="delete-form"
                                                                    id="delete-reply-form-{{ $reply->id }}">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="button" class="action-btn delete-btn"
                                                                            onclick="confirmDeleteReply({{ $reply->id }})">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="reply-content" id="reply-content-{{ $reply->id }}">
                                                        <p>{{ $reply->reply }}</p>
                                                    </div>
                                                    <div id="edit-reply-form-{{ $reply->id }}" class="edit-form" style="display: none;">
                                                        <form action="{{ route('client.updateReply', [$comment->id, $reply->id]) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <textarea name="reply" class="form-control" required>{{ $reply->reply }}</textarea>
                                                            <div class="form-actions">
                                                                <button type="submit" class="btn btn-primary">Lưu</button>
                                                                <button type="button" class="btn btn-secondary"
                                                                        onclick="toggleEditFormReply({{ $reply->id }})">Hủy</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            @endforeach
                                            @auth
                                                <form action="{{ route('client.storeReply', $comment->id) }}" method="POST" class="reply-form">
                                                    @csrf
                                                    <div class="input-group">
                                                        <textarea name="reply" class="form-control" required placeholder="Viết phản hồi..."></textarea>
                                                        <button type="submit" class="btn-send">
                                                            <img src="{{ asset('./images/send.png') }}" alt="Send">
                                                        </button>
                                                    </div>
                                                </form>
                                            @endauth
                                        </div>
                                    </div>
                                @endforeach
                                @auth
                                    <form action="{{ route('client.storeComment', $product->id) }}" method="POST" class="comment-form">
                                        @csrf
                                        <div class="input-group">
                                            <textarea name="comment" class="form-control" required placeholder="Viết bình luận của bạn..."></textarea>
                                            <button type="submit" class="btn-send">
                                                <img src="{{ asset('./images/send.png') }}" alt="Send">
                                            </button>
                                        </div>
                                    </form>
                                @endauth
                            </div>
                        </div>

                        <!-- Đánh giá tab -->
                        <div class="tab-pane fade" id="tab-reviews" role="tabpanel">
                            <div class="reviews-section">
                                <div class="review-stats">
                                    <div class="review-summary">
                                        <h2 class="review-count">{{ $product->reviews->count() }} đánh giá cho {{ $product->name }}</h2>
                                        <div class="average-rating">
                                            <div class="rating-number">{{ number_format($product->reviews->avg('rating'), 1) }}</div>
                                            <div class="rating-stars">
                                                @php
                                                    $avgRating = $product->reviews->avg('rating');
                                                @endphp
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= $avgRating)
                                                        <i class="fas fa-star"></i>
                                                    @else
                                                        <i class="far fa-star"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                    <div class="rating-breakdown">
                                        @for ($star = 5; $star >= 1; $star--)
                                            @php
                                                $count = $product->reviews->where('rating', $star)->count();
                                                $percentage = $product->reviews->count() > 0
                                                    ? ($count / $product->reviews->count()) * 100
                                                    : 0;
                                            @endphp
                                            <div class="rating-bar">
                                                <div class="rating-label">{{ $star }} <i class="fas fa-star"></i></div>
                                                <div class="progress">
                                                    <div class="progress-bar" role="progressbar"
                                                         style="width: {{ $percentage }}%;"
                                                         aria-valuenow="{{ $percentage }}"
                                                         aria-valuemin="0"
                                                         aria-valuemax="100">
                                                    </div>
                                                </div>
                                                <div class="rating-count">{{ $count }} đánh giá</div>
                                            </div>
                                        @endfor
                                    </div>
                                </div>
                                @if ($product->reviews->count() > 0)
                                    @foreach ($product->reviews as $review)
                                        <div class="review">
                                            <div class="review-header">
                                                <div class="user-info">
                                                    <strong>{{ $review->user->name }}</strong>
                                                    <span class="review-date">{{ $review->created_at->format('d/m/Y') }}</span>
                                                </div>
                                                @if($review->variant_info)
                                                    <div class="variant-info">
                                                        Phiên bản: {{ $review->variant_info }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="rating-section">
                                                <span class="rating">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($i <= $review->rating)
                                                            <i class="fas fa-star"></i>
                                                        @else
                                                            <i class="far fa-star"></i>
                                                        @endif
                                                    @endfor
                                                </span>
                                            </div>
                                            <div class="review-content">
                                                <p>{{ $review->review }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <p class="no-reviews">Chưa có đánh giá nào cho sản phẩm này</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- Shop Detail End -->


    <!-- Products Start -->
    <div class="container-fluid py-5">
        <div class=" mb-5" style="margin-left: 50px;">
            <h3 class=" text-3xl font-normal tracking-wide text-black uppercase" style="font-size:25px;">
                Sản phẩm liên quan
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
                                        src="{{ asset('storage/' . $relatedProduct->image) }}" alt="{{ $relatedProduct->name }}">

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
                                <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                                    <img class="img-fluid w-100 product-image" style="height: 250px; object-fit: contain;"
                                        src="{{ asset('storage/' . $similarProduct->image) }}" alt="{{ $similarProduct->name }}">
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
        document.addEventListener("DOMContentLoaded", function () {
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
    @include('web2.sup.js')
@endsection

<style>
    .rating {
        color: #ffd700;
        margin-left: 5px;
    }

    .rating .fas.fa-star {
        color: #ffd700;
    }

    .rating .far.fa-star {
        color: #ccc;
    }

    .review {
        background: #fff;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 15px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    .review-item {
        margin-bottom: 10px;
    }

    .review-item p {
        margin: 5px 0;
    }

    .review-item strong {
        color: #333;
    }

    .review-item em {
        color: #666;
        font-style: italic;
    }

    .response {
        margin-left: 20px;
        padding: 10px;
        background: #f8f9fa;
        border-left: 3px solid #ffd700;
        margin-top: 10px;
        border-radius: 4px;
    }

    .response p {
        margin: 5px 0;
        color: #555;
    }

    .response strong {
        color: #333;
    }

    .response span {
        font-size: 0.9em;
        color: #888;
    }

    .reviews-section {
        padding: 20px;
        max-width: 800px;
        margin: 0 auto;
    }

    .review-stats {
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 30px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    .review-summary {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 1px solid #eee;
    }

    .review-count {
        font-size: 1.2em;
        color: #333;
        margin: 0;
    }

    .average-rating {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .rating-number {
        font-size: 2em;
        font-weight: bold;
        color: #333;
    }

    .rating-stars {
        color: #ffd700;
        font-size: 1.2em;
    }

    .rating-breakdown {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .rating-bar {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .rating-label {
        min-width: 60px;
        color: #666;
    }

    .progress {
        flex-grow: 1;
        height: 8px;
        background-color: #eee;
        border-radius: 4px;
        overflow: hidden;
    }

    .progress-bar {
        background-color: #ffd700;
        height: 100%;
        transition: width 0.3s ease;
    }

    .rating-count {
        min-width: 100px;
        text-align: right;
        color: #666;
        font-size: 0.9em;
    }

    .review {
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 15px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    .review-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 10px;
    }

    .user-info {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .review-date {
        color: #666;
        font-size: 0.9em;
    }

    .variant-info {
        color: #666;
        font-size: 0.9em;
        font-style: italic;
    }

    .rating-section {
        margin: 10px 0;
    }

    .rating {
        color: #ffd700;
        font-size: 1.1em;
    }

    .review-content {
        color: #333;
        line-height: 1.6;
    }

    .no-reviews {
        text-align: center;
        color: #666;
        padding: 20px;
        font-style: italic;
    }

    @media (max-width: 768px) {
        .review-summary {
            flex-direction: column;
            gap: 15px;
            text-align: center;
        }

        .rating-bar {
            font-size: 0.9em;
        }

        .rating-count {
            min-width: 80px;
        }
    }
</style>

<script>
    function toggleEditForm(commentId) {
        var content = document.getElementById('comment-content-' + commentId);
        var form = document.getElementById('edit-comment-form-' + commentId);
        if (form.style.display === "none") {
            form.style.display = "block";
            content.style.display = "none";
        } else {
            form.style.display = "none";
            content.style.display = "block";
        }
    }

    function toggleEditFormReply(replyId) {
        var content = document.getElementById('reply-content-' + replyId);
        var form = document.getElementById('edit-reply-form-' + replyId);
        if (form.style.display === "none") {
            form.style.display = "block";
            content.style.display = "none";
        } else {
            form.style.display = "none";
            content.style.display = "block";
        }
    }

    function confirmDeleteComment(commentId) {
        if (confirm('Bạn có chắc chắn muốn xóa bình luận này?')) {
            document.getElementById('delete-comment-form-' + commentId).submit();
        }
    }

    function confirmDeleteReply(replyId) {
        if (confirm('Bạn có chắc chắn muốn xóa phản hồi này?')) {
            document.getElementById('delete-reply-form-' + replyId).submit();
        }
    }

    function toggleReplies(commentId) {
        const repliesSection = document.getElementById(`replies-${commentId}`);
        const toggleButton = repliesSection.previousElementSibling;
        const replyCount = repliesSection.querySelectorAll('.reply').length;

        if (repliesSection.classList.contains('show')) {
            repliesSection.classList.remove('show');
            toggleButton.classList.remove('active');
            toggleButton.innerHTML = `<i class="fas fa-chevron-down"></i> Xem ${replyCount} phản hồi`;
        } else {
            repliesSection.classList.add('show');
            toggleButton.classList.add('active');
            toggleButton.innerHTML = `<i class="fas fa-chevron-down"></i> Ẩn phản hồi`;
        }
    }
</script>

<style>
    /* Reset và style chung */
    .comments-section {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        background-color: #fff;
    }

    /* Style cho comment */
    .comment {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
    }

    .comment-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 10px;
    }

    .user-info {
        display: flex;
        flex-direction: column;
        align-items: flex-start;  /* Căn trái cho thông tin user */
        gap: 5px;
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
    }

    .user-meta {
        display: flex;
        align-items: center;
    }

    .user-details {
        display: flex;
        flex-direction: column;
        align-items: flex-start;  /* Căn trái cho tên và thời gian */
    }

    .user-name {
        font-weight: 500;
        color: #333;
        margin: 0;
        text-align: left;  /* Căn trái cho tên */
    }

    .comment-date {
        font-size: 0.85em;
        color: #666;
        text-align: left;  /* Căn trái cho thời gian */
        margin-top: 2px;
    }

    /* Actions (Edit/Delete buttons) */
    .comment-actions, .reply-actions {
        display: flex;
        gap: 8px;
    }

    .action-btn {
        background: none;
        border: none;
        padding: 5px;
        cursor: pointer;
        color: #666;
        transition: color 0.2s;
    }

    .action-btn:hover {
        color: #007bff;
    }

    .action-btn.delete-btn:hover {
        color: #dc3545;
    }

    /* Comment content */
    .comment-content, .reply-content {
        margin: 10px 0;
        color: #333;
        line-height: 1.5;
        text-align: left;  /* Căn trái cho nội dung */
    }

    /* Reply section */
    .replies {
        margin-left: 50px;
        margin-top: 10px;
    }

    .reply {
        background: #fff;
        border-left: 3px solid #007bff;
        padding: 10px 15px;
        margin-top: 10px;
        border-radius: 4px;
    }

    /* Cập nhật HTML cho comment */
    .comment-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }

    .user-meta {
        display: flex;
        align-items: center;
    }

    /* Rest of the existing styles... */
</style>

<style>
    /* Existing styles... */

    /* Forms */
    .edit-form {
        margin-top: 10px;
    }

    .edit-form textarea,
    .reply-form textarea,
    .comment-form textarea {
        width: 100%;
        min-height: 60px;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
        margin-bottom: 10px;
        resize: vertical;
    }

    .form-actions {
        display: flex;
        gap: 10px;
    }

    /* Input groups */
    .input-group {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-top: 15px;
        background: #fff;
        padding: 10px;
        border-radius: 4px;
        border: 1px solid #ddd;
    }

    .input-group textarea {
        flex-grow: 1;
        margin-bottom: 0;
        border: none;
        padding: 5px;
        min-height: 40px;
    }

    .input-group textarea:focus {
        outline: none;
    }

    .btn-send {
        background: none;
        border: none;
        padding: 0;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-send img {
        width: 24px;
        height: 24px;
        transition: transform 0.2s;
    }

    .btn-send:hover img {
        transform: scale(1.1);
    }

    /* Buttons */
    .btn {
        padding: 6px 12px;
        border-radius: 4px;
        font-size: 14px;
        cursor: pointer;
        border: 1px solid transparent;
    }

    .btn-primary {
        background-color: #007bff;
        color: white;
    }

    .btn-secondary {
        background-color: #6c757d;
        color: white;
    }

    .btn:hover {
        opacity: 0.9;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .replies {
            margin-left: 20px;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
        }

        .input-group {
            flex-direction: column;
        }

        .btn-send {
            align-self: flex-end;
        }

        .user-meta {
            flex-direction: column;
            align-items: flex-start;
        }

        .user-details {
            margin-top: 5px;
        }
    }
</style>

<style>
    /* Common styles for comments and replies */
    .comment, .reply {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
    }

    .comment-header, .reply-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 10px;
    }

    .user-info {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    .user-meta {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
    }

    .user-details {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    .user-name {
        font-weight: 500;
        color: #333;
        margin: 0;
    }

    .comment-date {
        font-size: 0.85em;
        color: #666;
        margin-top: 2px;
    }

    /* Actions styling */
    .comment-actions, .reply-actions {
        display: flex;
        gap: 8px;
        margin-left: auto;
    }

    .action-btn {
        background: none;
        border: none;
        padding: 5px;
        cursor: pointer;
        color: #666;
        transition: color 0.2s;
    }

    .action-btn:hover {
        color: #007bff;
    }

    .action-btn.delete-btn:hover {
        color: #dc3545;
    }

    /* Content styling */
    .comment-content, .reply-content {
        margin: 10px 0;
        color: #333;
        line-height: 1.5;
    }

    /* Reply specific styles */
    .reply {
        background: #fff;
        border-left: 3px solid #007bff;
        margin-left: 50px;
        margin-top: 10px;
    }

    /* Form styling */
    .edit-form {
        margin-top: 10px;
    }

    .edit-form textarea {
        width: 100%;
        min-height: 60px;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
        margin-bottom: 10px;
        resize: vertical;
    }

    .form-actions {
        display: flex;
        gap: 10px;
    }

    /* Input groups */
    .input-group {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-top: 15px;
        background: #fff;
        padding: 10px;
        border-radius: 4px;
        border: 1px solid #ddd;
    }

    .input-group textarea {
        flex-grow: 1;
        margin-bottom: 0;
        border: none;
        padding: 5px;
        min-height: 40px;
    }

    .input-group textarea:focus {
        outline: none;
    }

    /* Send button */
    .btn-send {
        background: none;
        border: none;
        padding: 0;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-send img {
        width: 24px;
        height: 24px;
        transition: transform 0.2s;
    }

    .btn-send:hover img {
        transform: scale(1.1);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .reply {
            margin-left: 20px;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
        }

        .user-meta {
            flex-direction: row;
            align-items: center;
        }

        .input-group {
            flex-direction: column;
        }

        .btn-send {
            align-self: flex-end;
        }
    }
</style>

<style>
    /* Update replies toggle styles */
    .replies-toggle {
        color: #333;
        background: none;
        border: none;
        padding: 5px 10px;
        margin-top: 10px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 0.9em;
        transition: all 0.3s ease;
        opacity: 0.8;
    }

    .replies-toggle:hover {
        opacity: 1;
        transform: translateY(-1px);
        text-decoration: none;
    }

    .replies-toggle i {
        transition: transform 0.3s ease;
        color: #333;
    }

    .replies-toggle.active {
        opacity: 1;
    }

    .replies-toggle.active i {
        transform: rotate(180deg);
    }

    /* Hide replies by default */
    .replies {
        max-height: 0;
        overflow: hidden;
        opacity: 0;
        transition: all 0.3s ease;
        margin-left: 50px;
    }

    /* Show replies when active */
    .replies.show {
        max-height: 2000px; /* Arbitrary large height */
        opacity: 1;
        margin-top: 10px;
    }

    @media (max-width: 768px) {
        .replies {
            margin-left: 20px;
        }
    }
</style>
