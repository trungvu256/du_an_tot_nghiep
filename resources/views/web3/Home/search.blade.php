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
                    <a href="{{ route('web.shop') }}" class="text">Kết quả tím kiếm</a>
                </li>
            </ul>
        </div>
    </div>
<div class="container py-4 ">
    <div class="card">
        <div class="card-body">
    <h6 class="text-muted text-center">Có {{ $products->total() }} kết quả tìm kiếm phù hợp</h6>
    <br>

    @if ($products->count() > 0)
    <div class="row row-cols-1 row-cols-md-5 no-gutters custom-no-gap">
       
        @foreach ($products as $product)
            @php
                $minPrice = $product->variants->min('price');
                $maxPrice = $product->variants->max('price');
            @endphp
 
            <div class="col d-flex justify-content-center mb-4">
                <div class="swiper-slide">
                    
                    <div class="card-product style-1 card-product-size">
                        <div class="card-product-wrapper">
                            <a href="{{ route('web.shop-detail', ['id' => $product->id]) }}" class="product-img">
                                <img class="img-product lazyload"
                                     data-src="{{ asset('storage/' . $product->image) }}"
                                     src="{{ asset('storage/' . $product->image) }}"
                                     alt="{{ $product->name }}" />
                                <img class="img-hover lazyload"
                                     data-src="{{ asset('storage/' . $product->image) }}"
                                     src="{{ asset('storage/' . $product->image) }}"
                                     alt="{{ $product->name }}" />
                            </a>
                            <ul class="list-product-btn">
                                {{-- <li>
                                    <a href="{{ route('web.shop-detail', ['id' => $product->id]) }}" data-bs-toggle="offcanvas"
                                       class="hover-tooltip tooltip-left box-icon">
                                        <span class="icon icon-cart2"></span>
                                        <span class="tooltip">Add to Cart</span>
                                    </a>
                                </li> --}}
                                {{-- <li class="wishlist">
                                    <a href="javascript:void(0);"
                                       class="hover-tooltip tooltip-left box-icon">
                                        <span class="icon icon-heart2"></span>
                                        <span class="tooltip">Add to Wishlist</span>
                                    </a>
                                </li> --}}
                                {{-- <li>
                                    <a href="{{ route('web.shop-detail', ['id' => $product->id]) }}"
                                       class="hover-tooltip tooltip-left box-icon quickview">
                                        <span class="icon icon-view"></span>
                                        <span class="tooltip">Chi tiết</span>
                                    </a>
</li> --}}
                                {{-- <li class="compare">
                                    <a href="#compare" data-bs-toggle="modal"
                                       class="hover-tooltip tooltip-left box-icon">
                                        <span class="icon icon-compare"></span>
                                        <span class="tooltip">Add to Compare</span>
                                    </a>
                                </li> --}}
                            </ul>
                            <div class="on-sale-wrap">
                                {{-- <span class="on-sale-item">20% Off</span> --}}
                            </div>
                        </div>
                        <div class="card-product-info">
                            <a href="{{ route('web.shop-detail', ['id' => $product->id]) }}"
                               class="name-product link fw-medium text-md">{{ $product->name }}</a>
                            <p class="price-wrap fw-medium">
                                <span class="price-new text-primary">
                                    {{ number_format($minPrice) }}₫
                                    @if ($minPrice != $maxPrice)
                                        - {{ number_format($maxPrice) }}₫
                                    @endif
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
              
        @endforeach
    </div>

    <div class="mt-4">
        {{ $products->withQueryString()->links() }}
    </div>
@else
    <p>Không tìm thấy sản phẩm nào phù hợp.</p>
@endif
</div>
</div>
</div>
@endsection