@if($list_product->isNotEmpty())
    @foreach ($list_product as $product)
            <div class="card-product grid style-1 card-product-size" data-availability="In stock" data-brand="{{ $product->brand->name ?? '' }}">
                <div class="card-product-wrapper" style="width:200px">
                    <a href="{{ route('web.shop-detail', ['id' => $product->id]) }}" class="product-img">
                        <img class="img-product" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width:100%; height: 100%;">
                        <img class="img-hover" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" >
                    </a>
                   
                    @if($product->discount)
                        <div class="on-sale-wrap">
                            <span class="on-sale-item">{{ $product->discount }}</span>
                        </div>
                    @endif
                    <ul class="list-product-btn">
                        <!-- Thêm nút giỏ hàng, wishlist, quick view nếu cần -->
                        <li>
                            <a href="">Th</a>
                        </li>
                    </ul>
                </div>
                <div class="card-product-info">
                    <a href="{{ route('web.shop-detail', ['id' => $product->id]) }}" class="name-product link fw-medium text-md">{{ $product->name }}</a>
                    <p class="price-wrap fw-medium">
                        @if($product->variants->isNotEmpty())
                            <span class="price-new text-primary">
                                {{ number_format($product->variants->min('price'), 0, ',', '.') }}đ
                            </span>
                            @if($product->variants->count() > 1)
                                <span class="price-old text-muted">
                                    - {{ number_format($product->variants->max('price'), 0, ',', '.') }}đ
                                </span>
                            @endif
                        @else
                            <span class="price-new text-primary">Liên hệ</span>
                        @endif
                    </p>
                </div>
            </div>
    @endforeach
    <div class="mt-4 d-flex justify-content-center">
        {{ $list_product->appends(request()->query())->links() }}
    </div>
@else
    <div class="alert alert-danger alert-dismissible fade show" style="width: 100%">
        <p class="text-muted">Không có sản phẩm trong danh mục này.</p>
    </div>
@endif