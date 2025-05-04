@extends('web3.layout.master2')

@section('content')
    <div id="wrapper" style="width: 90%; margin: 0 auto;">
        <div class="tf-breadcrumb space-t">
            <div class="container">
                <ul class="breadcrumb-list">
                    <li class="item-breadcrumb">
                        <a href="{{ route('web.home') }}" class="text">Trang chủ</a>
                    </li>
                    <li class="item-breadcrumb dot">
                        <span></span>
                    </li>
                    <li class="item-breadcrumb">
                        <a href="{{ route('web.shop') }}" class="text">Nước Hoa</a>
                    </li>
                </ul>
            </div>
        </div>

        <section class="flat-spacing-2 pt-0">

            <div class="container">
                <div class="row d-flex">
                    <div class="col-xl-3">
                        <form id="filter-form" method="GET" onsubmit="return false;">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    {{-- Bộ lọc áp dụng --}}
                                    <div class="mb-4">
                                        <h5 class="fw-bold text-uppercase mb-3">BỘ LỌC</h5>
                                        <div id="applied-filters" class="d-flex flex-wrap gap-2"></div>
                                        <button id="remove-all" class="btn btn-sm btn-outline-danger mt-2"
                                            style="display: none;">
                                            <i class="icon icon-close"></i> Bỏ hết
                                        </button>
                                    </div>

                                    {{-- Thương hiệu --}}
                                    <div class="mb-4 p-3 border rounded">
                                        <h6 class="fw-semibold text-uppercase mb-3">Thương hiệu</h6>

                                        <!-- Ô tìm kiếm -->
                                        <div class="input-group mb-3">
                                            <input type="text" id="brand-search" class="form-control"
                                                placeholder="Tìm Thương hiệu">
                                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                                        </div>

                                        <!-- Danh sách cuộn riêng biệt -->
                                        <div id="brand-list" style="max-height: 150px; overflow-y: auto;">
                                            @foreach ($brands as $brand)
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="brand[]"
                                                        id="brand_{{ $brand->id }}" value="{{ $brand->id }}"
                                                        {{ in_array($brand->id, (array) request()->input('brand', [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="brand_{{ $brand->id }}">
                                                        {{ $brand->name }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    {{-- Giá sản phẩm --}}
                                    <div class="mb-4 p-3 border rounded">
                                        <h6 class="fw-semibold text-uppercase mb-3">Giá sản phẩm</h6>

                                        <!-- Vùng cuộn bắt đầu từ đây -->
                                        <div style="max-height: 150px; overflow-y: auto;">
                                            @php
                                                $priceOptions = [
                                                    '0-100000' => 'Giá dưới 100.000VNĐ',
                                                    '100000-200000' => '100.000VNĐ - 200.000VNĐ',
                                                    '200000-300000' => '200.000VNĐ - 300.000VNĐ',
                                                    '300000-500000' => '300.000VNĐ - 500.000VNĐ',
                                                    '500000-1000000' => '500.000VNĐ - 1.000.000VNĐ',
                                                    '1000000-99999999' => 'Giá trên 1.000.000VNĐ',
                                                ];
                                            @endphp

                                            @foreach ($priceOptions as $range => $label)
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="price_range[]"
                                                        id="price_{{ $range }}" value="{{ $range }}"
                                                        {{ in_array($range, (array) request()->input('price_range', [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="price_{{ $range }}">
                                                        {{ $label }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                        <!-- Kết thúc vùng cuộn -->
                                    </div>

                                    {{-- Danh mục --}}
                                    <div class="mb-4 p-3 border rounded">
                                        <h6 class="fw-semibold text-uppercase mb-3">Danh mục</h6>

                                        <!-- Ô tìm kiếm -->
                                        <div class="input-group mb-3">
                                            <input type="text" id="cate-search" class="form-control"
                                                placeholder="Tìm danh mục">
                                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                                        </div>

                                        <!-- Danh sách cuộn riêng biệt -->
                                        <div id="cate-list" style="max-height: 150px; overflow-y: auto;">
                                            @foreach ($categories as $cate)
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="cate[]"
                                                        id="cate_{{ $cate->id }}" value="{{ $cate->id }}"
                                                        {{ in_array($cate->id, (array) request()->input('cate', [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="cate_{{ $cate->id }}">
                                                        {{ $cate->name }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-xl-9">
                        <div class="tf-shop-control">
                            <div class="tf-group-filter d-flex align-items-center flex-wrap">
                                <button id="filterShop"
                                    class="tf-btn-filter btn btn-outline-secondary d-flex d-xl-none me-3">
                                    <span class="icon icon-filter"></span><span class="text">Bộ lọc</span>
                                </button>
                                @if ($selectedCategory)
                                    <h5 class="mb-0 me-3">{{ $selectedCategory->name }}</h5>
                                @elseif($selectedBrand)
                                    <h5 class="mb-0 me-3">{{ $selectedBrand->name }}</h5>
                                @else
                                    <h5 class="mb-0 me-3">TẤT CẢ SẢN PHẨM</h5>
                                @endif

                                <div class="sort-options d-flex align-items-center">
                                    <span class="fw-bold me-2">Sắp xếp theo:</span>
                                    <div class="d-flex gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="sort" id="sort-new"
                                                value="new" {{ request()->sort == 'new' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="sort-new">Hàng mới</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="sort"
                                                id="sort-price-low-high" value="price-low-high"
                                                {{ request()->sort == 'price-low-high' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="sort-price-low-high">Giá thấp đến
                                                cao</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="sort"
                                                id="sort-price-high-low" value="price-high-low"
                                                {{ request()->sort == 'price-high-low' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="sort-price-high-low">Giá cao xuống
                                                thấp</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="wrapper-control-shop">
                            <div class="meta-filter-shop d-flex align-items-center mb-3">
                                <div id="product-count" class="count-text me-3">
                                    {{ $list_product->total() }} sản phẩm
                                </div>
                            </div>

                            <div class="d-flex flex-wrap gap-2" id="gridLayout">
                                @include('web3.Home.product_list')
                            </div>

                        </div>
                    </div>
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            document.querySelectorAll('.box-nav-menu .has-sub .toggle-sub').forEach(function(toggle) {
                                toggle.addEventListener('click', function(e) {
                                    e.preventDefault();
                                    const parent = this.closest('.has-sub');
                                    parent.classList.toggle('open');
                                    const submenu = parent.querySelector('.submenu');
                                    if (submenu.style.display === "none" || submenu.style.display === "") {
                                        submenu.style.display = "block";
                                    } else {
                                        submenu.style.display = "none";
                                    }
                                });
                            });
                        });
                    </script>
                    <style>
                        .box-nav-menu .item-link {
                            display: block;
                            padding: 8px 12px;
                            color: #000;
                            text-decoration: none;
                            font-weight: 500;
                        }

                        .box-nav-menu .item-link:hover {
                            color: #007bff;
                        }

                        .box-nav-menu .has-sub>.item-link {
                            cursor: pointer;
                            position: relative;
                        }

                        .box-nav-menu .submenu {
                            margin-top: 5px;
                            margin-left: 10px;
                        }

                        .box-nav-menu .submenu a {
                            padding: 6px 12px;
                            font-size: 14px;
                            display: block;
                            color: #333;
                        }

                        .box-nav-menu .submenu a:hover {
                            color: #007bff;
                        }

                        .icon-arr-down {
                            float: right;
                            transition: transform 0.3s ease;
                        }

                        .has-sub.open .icon-arr-down {
                            transform: rotate(180deg);
                        }
                    </style>

                </div>
            </div>
    </div>
    </section>
    <style>
        /* --- Tổng thể bộ lọc --- */
        #filter-form {
            font-size: 14px;
            color: #333;
        }

        #filter-form h5 {
            font-size: 15px;
            color: #111;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }

        /* --- Scroll đẹp cho danh sách lọc --- */
        .filter-scroll {
            max-height: 220px;
            overflow-y: auto;
            padding-right: 5px;
        }

        .filter-scroll::-webkit-scrollbar {
            width: 6px;
        }

        .filter-scroll::-webkit-scrollbar-thumb {
            background-color: #ccc;
            border-radius: 4px;
        }

        .filter-scroll::-webkit-scrollbar-track {
            background-color: transparent;
        }

        /* --- Form-check (checkbox, radio) --- */
        .form-check {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-check-label {
            margin-left: 4px;
            font-weight: 500;
        }

        /* --- Input tìm kiếm thương hiệu --- */
        #brand-search {
            border-radius: 6px 0 0 6px;
        }

        .input-group-text {
            background-color: #f8f9fa;
            border-radius: 0 6px 6px 0;
            cursor: pointer;
        }

        /* --- Button "Bỏ hết" --- */
        #remove-all {
            font-size: 13px;
            padding: 6px 10px;
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: all 0.3s ease;
        }

        #remove-all:hover {
            background-color: #dc3545;
            color: #fff;
        }

        /* --- Nhãn đã chọn --- */
        #applied-filters .filter-tag {
            background-color: #f1f3f5;
            color: #000;
            padding: 4px 10px;
            border-radius: 50px;
            font-size: 13px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border: 1px solid #dee2e6;
        }

        #applied-filters .filter-tag .remove {
            color: #888;
            cursor: pointer;
            font-size: 13px;
        }

        /* --- Responsive cho filter button --- */
        .tf-btn-filter {
            border-radius: 6px;
            padding: 6px 12px;
            font-weight: 500;
            gap: 6px;
        }
    </style>
    <div class="flat-spacing-5 line-top flat-wrap-iconbox">
        <div class="container">
            <div dir="ltr" class="swiper tf-swiper wow fadeInUp"
                data-swiper='{
                "slidesPerView": 1,
                "spaceBetween": 12,
                "speed": 800,
                "observer": true,
                "observeParents": true,
                "pagination": { "el": ".sw-pagination-iconbox", "clickable": true },
                "breakpoints": {
                    "575": { "slidesPerView": 2, "spaceBetween": 24},
                    "768": { "slidesPerView": 3, "spaceBetween": 24},
                    "1200": { "slidesPerView": 3, "spaceBetween": 100},
                    "1440": { "slidesPerView": 3, "spaceBetween": 205}
                }
            }'>
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="tf-icon-box style-2">
                            <svg width="48" height="48">
                                <path d="M0 0h48v48H0z" fill="none" />
                                <path
                                    d="M38 8H10a2 2 0 0 0-2 2v28c0 1.1.9 2 2 2h28a2 2 0 0 0 2-2V10a2 2 0 0 0-2-2zm-4 26H14v-4h20v4zm0-8H14v-4h20v4zm0-8H14v-4h20v4z" />
                            </svg>
                            <div class="content">
                                <div class="title">Free Shipping</div>
                                <p class="desc text-grey-2">Miễn phí vận chuyển cho đơn hàng từ 150.000VNĐ</p>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="tf-icon-box style-2">
                            <svg width="48" height="48">
                                <path d="M0 0h48v48H0z" fill="none" />
                                <path
                                    d="M24 4C12.95 4 4 12.95 4 24s8.95 20 20 20 20-8.95 20-20S35.05 4 24 4zm2 34.14V32h-4v6.14C15.64 37.32 10.68 32.36 9.86 26H16v-4H9.86c.82-6.36 5.78-11.32 12.14-12.14V16h4V9.86c6.36.82 11.32 5.78 12.14 12.14H32v4h6.14c-.82 6.36-5.78 11.32-12.14 12.14z" />
                            </svg>
                            <div class="content">
                                <div class="title">Hỗ trợ 24/7</div>
                                <p class="desc text-grey-2">Luôn sẵn sàng hỗ trợ khách hàng</p>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="tf-icon-box style-2">
                            <svg width="48" height="48">
                                <path d="M0 0h48v48H0z" fill="none" />
                                <path
                                    d="M42 14H24v-4h14a2 2 0 0 1 2 2v26a2 2 0 0 1-2 2H10a2 2 0 0 1-2-2V12a2 2 0 0 1 2-2h14v4H10v26h28V14zm-16 8v4h-8v-4h8zm0 8v4h-8v-4h8z" />
                            </svg>
                            <div class="content">
                                <div class="title">Đảm bảo chính hãng</div>
                                <p class="desc text-grey-2">100% sản phẩm chính hãng, có hóa đơn</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="sw-pagination-iconbox"></div>
            </div>
        </div>
    </div>
    </div>
@endsection

@section('styles')
    <style>
        .filter-scroll {
            max-height: 200px;
            overflow-y: auto;
            padding-right: 10px;
        }

        .filter-scroll::-webkit-scrollbar {
            width: 8px;
        }

        .filter-scroll::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .filter-scroll::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }

        .filter-scroll::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        #applied-filters {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .filter-tag {
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 15px;
            padding: 5px 10px;
            font-size: 14px;
            display: flex;
            align-items: center;
            color: #333;
        }

        .filter-tag .remove-filter {
            margin-left: 8px;
            cursor: pointer;
            color: #ff0000;
            font-weight: bold;
        }

        .tf-shop-control {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .tf-group-filter h2 {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }

        .card-product {
            border: none;
            transition: all 0.3s ease;
        }

        .card-product-wrapper {
            position: relative;
            overflow: hidden;
        }

        .product-img {
            display: block;
        }

        .img-product,
        .img-hover {
            width: 100%;
            height: 200px;
            object-fit: cover;
            transition: opacity 0.3s ease;
        }

        .card-product:hover .img-product {
            opacity: 0;
        }

        .card-product:hover .img-hover {
            opacity: 1;
        }

        .on-sale-wrap {
            position: absolute;
            top: 10px;
            left: 10px;
        }

        .on-sale-item {
            background-color: #ff0000;
            color: #fff;
            padding: 5px 10px;
            font-size: 12px;
            border-radius: 3px;
        }

        .card-product-info {
            text-align: left;
            padding-top: 10px;
        }

        .name-product {
            display: block;
            color: #333;
            text-decoration: none;
            margin-bottom: 5px;
            font-size: 16px;
        }

        .price-wrap {
            font-size: 14px;
        }

        .price-new {
            color: #e74c3c;
            font-weight: bold;
        }

        .price-old {
            text-decoration: line-through;
            color: #999;
            margin-left: 5px;
        }

        .loading-overlay {
            position: relative;
            min-height: 100px;
        }

        .loading-overlay::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 40px;
            height: 40px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        let debounceTimer;
    
        // Lấy dữ liệu lọc từ form
        function getFilterData() {
            const data = {};
    
            // Lọc theo thương hiệu
            const brands = $('input[name="brand[]"]:checked').map(function() {
                return $(this).val();
            }).get();
            if (brands.length > 0) data['brand[]'] = brands;
    
            // Lọc theo danh mục
            const categories = $('input[name="cate[]"]:checked').map(function() {
                return $(this).val();
            }).get();
            if (categories.length > 0) data['cate[]'] = categories;
    
            // Lọc theo khoảng giá
            const priceRanges = $('input[name="price_range[]"]:checked').map(function() {
                return $(this).val();
            }).get();
            if (priceRanges.length > 0) data['price_range[]'] = priceRanges;
    
            // Lọc theo sắp xếp
            const sort = $('input[name="sort"]:checked').val();
            if (sort) data.sort = sort;
    
            return data;
        }
    
        // Gửi AJAX để lấy sản phẩm
        function fetchFilteredProducts(url = null) {
            const data = getFilterData();
    
            $.ajax({
                url: url || '{{ route("web.shop") }}',
                method: 'GET',
                data: data,
                beforeSend: function() {
                    $('#gridLayout').addClass('loading-overlay').html('<div class="text-center py-5">Đang tải...</div>');
                },
                success: function(response) {
                    $('#gridLayout').removeClass('loading-overlay').html(response);
                    updateProductCount();
                    updateAppliedFilters();
                },
                error: function(xhr) {
                    $('#gridLayout').removeClass('loading-overlay').html(
                        `<p class="text-center text-danger py-3">Lỗi khi tải dữ liệu: ${xhr.status} - ${xhr.responseText}</p>`
                    );
                }
            });
        }
    
        function debounceFetchFilteredProducts(url = null) {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => fetchFilteredProducts(url), 300);
        }
    
        // Hiển thị tổng số sản phẩm
        function updateProductCount() {
            const count = $('#gridLayout .card-product').length;
            $('#product-count').text(`${count} sản phẩm`);
        }
    
        // Hiển thị tag filter đang áp dụng
        function updateAppliedFilters() {
            const data = getFilterData();
            let filterHtml = '';
    
            if (data['brand[]']) {
                data['brand[]'].forEach(val => {
                    const name = $(`#brand_${val}`).next().text().trim();
                    filterHtml += `<span class="filter-tag">${name}<span class="remove-filter" data-type="brand[]" data-value="${val}">×</span></span>`;
                });
            }
    
            if (data['cate[]']) {
                data['cate[]'].forEach(val => {
                    const name = $(`#cate_${val}`).next().text().trim();
                    filterHtml += `<span class="filter-tag">${name}<span class="remove-filter" data-type="cate[]" data-value="${val}">×</span></span>`;
                });
            }
    
            if (data['price_range[]']) {
                data['price_range[]'].forEach(val => {
                    const name = $(`#price_${val}`).next().text().trim();
                    filterHtml += `<span class="filter-tag">${name}<span class="remove-filter" data-type="price_range[]" data-value="${val}">×</span></span>`;
                });
            }
    
            $('#applied-filters').html(filterHtml);
            $('#remove-all').toggle(!!filterHtml);
        }
    
        // Sự kiện: khi chọn bộ lọc
        $('input[name="cate[]"], input[name="brand[]"], input[name="price_range[]"], input[name="sort"]').on('change', function() {
            debounceFetchFilteredProducts();
        });
    
        // Sự kiện: tìm kiếm danh mục
        $('#cate-search').on('input', function() {
            const text = $(this).val().toLowerCase();
            $('#cate-list .form-check').each(function() {
                const name = $(this).find('label').text().toLowerCase();
                $(this).toggle(name.includes(text));
            });
        });
    
        // Sự kiện: tìm kiếm thương hiệu
        $('#brand-search').on('input', function() {
            const text = $(this).val().toLowerCase();
            $('#brand-list .form-check').each(function() {
                const name = $(this).find('label').text().toLowerCase();
                $(this).toggle(name.includes(text));
            });
        });
    
        // Sự kiện: xóa từng tag lọc
        $(document).on('click', '.remove-filter', function() {
            const type = $(this).data('type');
            const value = $(this).data('value');
            $(`input[name="${type}"][value="${value}"]`).prop('checked', false).trigger('change');
        });
    
        // Sự kiện: xóa toàn bộ lọc
        $('#remove-all').on('click', function() {
            $('input[name="cate[]"], input[name="brand[]"], input[name="price_range[]"], input[name="sort"]').prop('checked', false);
            $('#cate-search, #brand-search').val('');
            $('#cate-list .form-check, #brand-list .form-check').show();
            debounceFetchFilteredProducts();
        });
    
        // Sự kiện: phân trang
        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            const url = $(this).attr('href');
            debounceFetchFilteredProducts(url);
        });
    
        updateAppliedFilters();
    });
    </script>
    
@endsection
@section('scripts')
    @include('alert')
@endsection
