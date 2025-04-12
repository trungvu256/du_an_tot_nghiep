@extends('web3.layout.master2')

@section('content')
<div id="wrapper">
    {{-- Breadcrumb --}}
    <div class="tf-breadcrumb space-t">
        <div class="container">
            <ul class="breadcrumb-list">
                <li class="item-breadcrumb">
                    <a href="{{ route('web3.home') }}" class="text">Trang chủ</a>
                </li>
                <li class="item-breadcrumb dot">
                    <span></span>
                </li>
                <li class="item-breadcrumb">
                    <a href="{{ route('web3.shop') }}" class="text">Nước Hoa</a>
                </li>
            </ul>
        </div>
    </div>

    <section class="flat-spacing-2 pt-0">
    <div class="container">
        <div class="row">
            <div class="col-xl-3">
                <form id="filter-form" method="GET">
                    <!-- Danh mục -->
                    <h5 class="mb-3">Danh mục</h5>
                    <ul class="collapse-body list-categories current-scrollbar mb-4">
                        @foreach($categories as $category)
                            <li class="cate-item">
                                <a href="{{ route('web.shopByCate', ['cate_id' => $category->id]) }}">
                                    <span>{{ $category->name }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>

                    <!-- Giá -->
                    <h5 class="mb-3">Khoảng giá</h5>
                    @php
                        $priceOptions = [
                            '0-500000' => 'Dưới 500K',
                            '500000-1000000' => '500K - 1 triệu',
                            '1000000-2000000' => '1 triệu - 2 triệu',
                            '2000000-99999999' => 'Trên 2 triệu'
                        ];
                    @endphp
                    <div class="mb-4">
                        @foreach($priceOptions as $range => $label)
                            <div class="check-item">
                                <input type="checkbox" name="price_range[]" value="{{ $range }}"
                                    {{ in_array($range, (array) request()->price_range) ? 'checked' : '' }}>
                                <label>{{ $label }}</label>
                            </div>
                        @endforeach
                    </div>

                    <!-- Thương hiệu -->
                    <h5 class="mb-3">Thương hiệu</h5>
                    <ul class="collapse-body filter-group-check current-scrollbar mb-4">
                        @foreach($brands as $brand)
                            <li class="list-item">
                                <input type="checkbox" name="brand[]" class="tf-check" id="brand_{{ $brand->id }}"
                                    value="{{ $brand->id }}"
                                    {{ in_array($brand->id, (array) request()->brand) ? 'checked' : '' }}>
                                <label for="brand_{{ $brand->id }}" class="label">
                                    <span>{{ $brand->name }}</span>
                                </label>
                            </li>
                        @endforeach
                    </ul>

                    <!-- Dung tích -->
                    <h5 class="mb-3">Dung tích</h5>
                    <div class="collapse-body filter-size-box flat-check-list mb-4">
                        @foreach($capacities as $value)
                            <div class="check-item size-item size-check">
                                <input type="checkbox" name="capacity[]" id="capacity_{{ $loop->index }}" value="{{ $value->value }}"
                                    {{ in_array($value->value, (array) request()->capacity) ? 'checked' : '' }}>
                                <label for="capacity_{{ $loop->index }}">{{ $value->value }}</label>
                            </div>
                        @endforeach
                    </div>

                    <!-- Nồng độ -->
                    <h5 class="mb-3">Nồng độ</h5>
                    <div class="collapse-body filter-size-box flat-check-list mb-4">
                        @foreach($concentrations as $value)
                            <div class="check-item">
                                <input type="checkbox" name="concentration[]" id="concentration_{{ $loop->index }}" value="{{ $value->value }}"
                                    {{ in_array($value->value, (array) request()->concentration) ? 'checked' : '' }}>
                                <label for="concentration_{{ $loop->index }}">{{ $value->value }}</label>
                            </div>
                        @endforeach
                    </div>

                    <!-- Nút Reset -->
                    <div class="mt-4">
                        <a href="{{ url()->current() }}" class="btn btn-secondary w-100">Reset bộ lọc</a>
                    </div>
                </form>
       

                    </div>
                    <div class="col-xl-9">
                        <div class="tf-shop-control">
                            <div class="tf-group-filter">
                                <button id="filterShop" class="tf-btn-filter d-flex d-xl-none">
                                    <span class="icon icon-filter"></span><span class="text">Filter</span>
                                </button>
                                <div class="tf-dropdown-sort" data-bs-toggle="dropdown">
                                    <div class="btn-select">
                                        <span class="text-sort-value">Bán chạy nhất</span>
                                        <span class="icon icon-arr-down"></span>
                                    </div>
                                    <div class="dropdown-menu">
                                        <div class="select-item active" data-sort-value="best-selling">
                                            <span class="text-value-item">Bán chạy nhất</span>
                                        </div>
                                        <div class="select-item" data-sort-value="a-z">
                                            <span class="text-value-item">A-Z</span>
                                        </div>
                                        <div class="select-item" data-sort-value="z-a">
                                            <span class="text-value-item">Z-A</span>
                                        </div>
                                        <div class="select-item" data-sort-value="price-low-high">
                                            <span class="text-value-item">Giá thấp đến cao</span>
                                        </div>
                                        <div class="select-item" data-sort-value="price-high-low">
                                            <span class="text-value-item">Giá cao xuống thấp</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <ul class="tf-control-layout">



                                <li class="tf-view-layout-switch sw-layout-4" data-value-layout="tf-col-4">
                                    <div class="item icon-grid-4">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                </li>

                            </ul>
                        </div>
                        <div class="wrapper-control-shop">
                            <div class="meta-filter-shop">
                                <div id="product-count-grid" class="count-text"></div>
                                <div id="product-count-list" class="count-text"></div>
                                <div id="applied-filters"></div>
                                <button id="remove-all" class="remove-all-filters" style="display: none;"><i
                                        class="icon icon-close"></i> Xóa tất cả bộ lọc</button>
                            </div>

                            <div class="wrapper-shop tf-grid-layout tf-col-3" id="gridLayout">
                            <div class="wrapper-shop tf-grid-layout tf-col-3" id="gridLayout">
    @include('web3.Home.product_list')
</div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    {{-- Icon box dịch vụ --}}
    <div class="flat-spacing-5 line-top flat-wrap-iconbox">
        <div class="container">
            <div dir="ltr" class="swiper tf-swiper wow fadeInUp" data-swiper='{
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
                            <svg width="48" height="48" ...>...</svg>
                            <div class="content">
                                <div class="title">Free Shipping</div>
                                <p class="desc text-grey-2">Miễn phí vận chuyển cho đơn hàng từ 150.000đ</p>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="tf-icon-box style-2">
                            <svg width="48" height="48" ...>...</svg>
                            <div class="content">
                                <div class="title">Hỗ trợ 24/7</div>
                                <p class="desc text-grey-2">Luôn sẵn sàng hỗ trợ khách hàng</p>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="tf-icon-box style-2">
                            <svg width="48" height="48" ...>...</svg>
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

        <!-- /Section Product -->
        <div class="flat-spacing-5 line-top flat-wrap-iconbox">
            <div class="container">
                <div dir="ltr" class="swiper tf-swiper wow fadeInUp" data-swiper='{
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
                                <svg width="48" height="48" viewBox="0 0 48 48" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M38.9421 14.922L24.328 6.48452C24.2283 6.42685 24.1151 6.39648 23.9999 6.39648C23.8847 6.39648 23.7715 6.42685 23.6717 6.48452L9.05762 14.922C8.95781 14.9795 8.87492 15.0623 8.81731 15.1621C8.75971 15.2618 8.72941 15.375 8.72949 15.4901V32.3651C8.72946 32.4804 8.75977 32.5936 8.81737 32.6934C8.87497 32.7932 8.95783 32.876 9.05762 32.9336L23.6717 41.3711C23.7715 41.4286 23.8847 41.4589 23.9999 41.4589C24.115 41.4589 24.2282 41.4286 24.328 41.3711L38.9421 32.9336C39.0419 32.876 39.1248 32.7932 39.1824 32.6934C39.24 32.5936 39.2703 32.4804 39.2702 32.3651V15.4901C39.2703 15.375 39.24 15.2618 39.1824 15.1621C39.1248 15.0623 39.0419 14.9795 38.9421 14.922ZM23.9999 7.81052L37.3015 15.4901L23.9999 23.1698L10.6982 15.4901L23.9999 7.81052ZM10.042 16.6268L23.3436 24.3064V39.666L10.042 31.9875V16.6268ZM37.9577 31.9875L24.6561 39.666V24.3064L37.9577 16.6268V31.9875Z"
                                        fill="#ABABAB" />
                                </svg>
                                <div class="content">
                                    <div class="title">Free Shipping</div>
                                    <p class="desc text-grey-2">Enjoy free shipping on all orders over $150</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="tf-icon-box style-2">
                                <svg width="48" height="48" viewBox="0 0 48 48" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M24.3943 15.1144C24.3216 15.0724 24.239 15.0503 24.155 15.0503C24.071 15.0503 23.9885 15.0724 23.9158 15.1144L16.6187 19.3274C16.5459 19.3694 16.4855 19.4298 16.4435 19.5025C16.4015 19.5753 16.3794 19.6578 16.3794 19.7418V28.1677C16.3794 28.2517 16.4015 28.3342 16.4435 28.407C16.4855 28.4797 16.5459 28.5401 16.6187 28.5821L23.9158 32.7952C23.9885 32.8372 24.071 32.8593 24.155 32.8593C24.239 32.8593 24.3216 32.8372 24.3943 32.7952L31.6915 28.5821C31.7642 28.5401 31.8246 28.4797 31.8666 28.407C31.9086 28.3342 31.9307 28.2517 31.9307 28.1677V19.7418C31.9307 19.6578 31.9086 19.5753 31.8666 19.5025C31.8246 19.4298 31.7642 19.3694 31.6915 19.3274L24.3943 15.1144ZM24.155 16.0813L30.4951 19.7418L24.155 23.4022L17.815 19.7418L24.155 16.0813ZM17.3365 20.5706L23.6765 24.231V31.5523L17.3365 27.8918V20.5706ZM24.6336 31.5519V24.2306L30.9737 20.5702V27.8915L24.6336 31.5519ZM8.18376 25.8952C8.19119 25.9576 8.18624 26.0209 8.1692 26.0815C8.15215 26.142 8.12334 26.1986 8.08442 26.2479C8.04549 26.2973 7.99722 26.3386 7.94235 26.3693C7.88748 26.4 7.8271 26.4196 7.76465 26.427C7.74577 26.4292 7.72678 26.4304 7.70777 26.4304C7.59071 26.4302 7.47776 26.3872 7.39031 26.3093C7.30286 26.2315 7.24697 26.1243 7.23322 26.0081C7.15459 25.3417 7.11519 24.6712 7.11523 24.0002C7.11592 21.0265 7.90177 18.1056 9.39334 15.533C10.8849 12.9604 13.0293 10.8272 15.6097 9.34915C18.1901 7.87109 21.115 7.10055 24.0887 7.11545C27.0624 7.13034 29.9795 7.93015 32.5449 9.43399C34.624 10.6583 36.4184 12.3116 37.8086 14.2836L37.7701 8.77077C37.7697 8.70793 37.7816 8.64561 37.8052 8.58738C37.8289 8.52916 37.8637 8.47615 37.9078 8.4314C37.9969 8.34102 38.1183 8.28974 38.2452 8.28883C38.3721 8.28793 38.4942 8.33747 38.5846 8.42657C38.6749 8.51567 38.7262 8.63702 38.7271 8.76393L38.7772 15.9456C38.7777 16.0087 38.7656 16.0713 38.7418 16.1297C38.7179 16.1882 38.6828 16.2413 38.6383 16.2861C38.5938 16.3309 38.5409 16.3664 38.4826 16.3907C38.4244 16.4149 38.3619 16.4274 38.2987 16.4274C38.2942 16.4274 38.2895 16.4274 38.2851 16.4274L31.6136 16.235C31.5505 16.2336 31.4883 16.2197 31.4306 16.1942C31.3729 16.1687 31.3208 16.132 31.2774 16.0863C31.2339 16.0405 31.1999 15.9866 31.1773 15.9277C31.1548 15.8688 31.1441 15.806 31.1459 15.7429C31.1477 15.6799 31.162 15.6178 31.1879 15.5602C31.2137 15.5027 31.2508 15.4508 31.2968 15.4077C31.3428 15.3645 31.3969 15.3308 31.4559 15.3086C31.515 15.2865 31.5779 15.2762 31.6409 15.2784L37.4378 15.4456C35.9942 13.19 34.0074 11.3329 31.6595 10.0447C29.3117 8.75649 26.678 8.07835 24 8.07247C15.2174 8.07247 8.07227 15.2176 8.07227 24.0002C8.0723 24.6335 8.10953 25.2663 8.18376 25.8952ZM40.8848 24.0002C40.8838 26.9002 40.1361 29.751 38.7138 32.2783C37.2915 34.8055 35.2425 36.924 32.7641 38.4297C30.2857 39.9355 27.4613 40.7777 24.563 40.8754C21.6647 40.973 18.79 40.3228 16.2158 38.9874C14.2573 37.9639 12.5166 36.569 11.0908 34.8806L10.8796 39.7981C10.8744 39.9212 10.8217 40.0376 10.7327 40.123C10.6437 40.2083 10.5252 40.256 10.402 40.2561C10.3951 40.2561 10.3883 40.2561 10.381 40.2556C10.2542 40.2501 10.1348 40.1945 10.049 40.101C9.9632 40.0075 9.91806 39.8838 9.92351 39.757L10.1901 33.5439C10.1951 33.4201 10.248 33.3031 10.3376 33.2177C10.4273 33.1322 10.5466 33.0849 10.6705 33.0859L17.54 33.1193C17.6029 33.1195 17.6651 33.132 17.7231 33.1562C17.7811 33.1804 17.8337 33.2158 17.8781 33.2603C17.9224 33.3048 17.9575 33.3577 17.9814 33.4158C18.0053 33.4739 18.0176 33.5362 18.0174 33.599C18.0173 33.6618 18.0048 33.724 17.9806 33.782C17.9564 33.84 17.921 33.8927 17.8765 33.937C17.8319 33.9814 17.7791 34.0165 17.721 34.0404C17.6629 34.0643 17.6006 34.0765 17.5378 34.0764H17.5355L11.6419 34.0479C13.1384 35.8813 15.0231 37.3598 17.1602 38.3766C19.2973 39.3934 21.6334 39.9233 24 39.9279C32.7826 39.9279 39.9277 32.7828 39.9277 24.0002C39.9277 23.8733 39.9781 23.7516 40.0679 23.6618C40.1576 23.5721 40.2793 23.5217 40.4062 23.5217C40.5332 23.5217 40.6549 23.5721 40.7446 23.6618C40.8344 23.7516 40.8848 23.8733 40.8848 24.0002Z"
                                        fill="#ABABAB" />
                                </svg>
                                <div class="content">
                                    <div class="title">Gift Package</div>
                                    <p class="desc text-grey-2">Hassle-free returns for a worry-free shopping
                                        experience.</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="tf-icon-box style-2">
                                <svg width="48" height="48" viewBox="0 0 48 48" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M18.2486 37.718C18.2484 38.0955 18.5544 38.4017 18.932 38.4017C19.0615 38.4018 19.1884 38.365 19.2978 38.2957L29.2659 31.9856H38.0487C39.9538 31.9836 41.4977 30.4398 41.4999 28.5346V13.0492C41.4977 11.1441 39.9538 9.60027 38.0487 9.59814H9.95096C8.04595 9.60034 6.50213 11.1442 6.5 13.0492V28.5345C6.5022 30.4395 8.04595 31.9833 9.95096 31.9855H18.2498L18.2486 37.718ZM9.95096 30.6184C8.80064 30.6171 7.86847 29.6849 7.86719 28.5346V13.0492C7.86854 11.8989 8.80064 10.9667 9.95096 10.9654H38.0487C39.1991 10.9667 40.1313 11.8988 40.1327 13.0492V28.5345C40.1314 29.6848 39.1993 30.617 38.049 30.6183H29.0678C28.9384 30.6183 28.8115 30.6551 28.7021 30.7243L19.6162 36.476L19.6176 31.3021C19.6176 30.9247 19.3115 30.6186 18.934 30.6186L9.95096 30.6184Z"
                                        fill="#ABABAB" />
                                </svg>
                                <div class="content">
                                    <div class="title">Free Returns</div>
                                    <p class="desc text-grey-2">Shop with confidence, covered by our one-year warranty.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex d-xl-none sw-dot-default sw-pagination-iconbox justify-content-center"></div>
                </div>
            </div>
        </div>
    </div>
</body>


@endsection
<script>
    $(document).ready(function () {
    function fetchFilteredProducts(url = null) {
        const formData = new FormData();

        // Lấy dữ liệu từ các filter
        $('.filter-group-check input:checked').each(function () {
            formData.append($(this).attr('name') + '[]', $(this).val());
        });

        // Lấy sort nếu có
        const sort = $('.text-sort-value').data('sort-value');
        if (sort) {
            formData.append('sort', sort);
        }

        $.ajax({
            url: url || '{{ route('web3.shop') }}',
            method: 'GET',
            data: Object.fromEntries(formData.entries()),
            beforeSend: function () {
                $('#gridLayout').html('<p>Đang tải...</p>');
            },
            success: function (data) {
                $('#gridLayout').html(data);
            },
            error: function () {
                alert('Có lỗi xảy ra, vui lòng thử lại.');
            }
        });
    }

    // Gọi khi nhấn vào các filter
    $('.filter-group-check input, .flat-check-list input').on('change', function () {
        fetchFilteredProducts();
    });

    // Gọi khi click chuyển trang
    $(document).on('click', '.pagination a', function (e) {
        e.preventDefault();
        const url = $(this).attr('href');
        fetchFilteredProducts(url);
    });

    // Sort
    $('.select-item').on('click', function () {
        const value = $(this).data('sort-value');
        $('.text-sort-value').data('sort-value', value).text($(this).text());
        fetchFilteredProducts();
    });
});

</script>
