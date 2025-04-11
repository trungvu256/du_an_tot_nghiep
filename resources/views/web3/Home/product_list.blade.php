{{-- resources/views/web3/Home/product_list.blade.php --}}
@foreach ($list_product as $product)
    <div class="card-product grid style-1 card-product-size" data-availability="In stock" data-brand="{{ $product->brand->name ?? '' }}">
        <div class="card-product-wrapper">
        <a href="{{ route('web3.shop.detail', ['id' => $product->id]) }}" class="product-img">

                <img class="img-product" src="{{ asset($product->image) }}" alt="{{ $product->name }}">
                <img class="img-hover" src="{{ asset($product->image_hover) }}" alt="{{ $product->name }}">
            </a>
            @if($product->discount)
                <div class="on-sale-wrap"><span class="on-sale-item">{{ $product->discount }}% Off</span></div>
            @endif
            <ul class="list-product-btn">
                <!-- Các nút giỏ hàng, wishlist, quick view -->
            </ul>
        </div>
        <div class="card-product-info">
            <a href="{{ route('web3.shop.detail', $product->id) }}" class="name-product link fw-medium text-md">{{ $product->name }}</a>
            <p class="price-wrap fw-medium">
                <span class="price-new text-primary">{{ number_format($product->price, 0, ',', '.') }}đ</span>
                @if($product->old_price)
                    <span class="price-old">{{ number_format($product->old_price, 0, ',', '.') }}đ</span>
                @endif
            </p>
        </div>
    </div>
@endforeach

{{-- Phân trang --}}
<div class="mt-4">
    {{ $list_product->links() }}
</div>
