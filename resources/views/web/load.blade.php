@foreach ($products as $item)
<div class="col-md-4 products-right-grids-bottom-grid">
    <div class="new-collections-grid1 products-right-grid1 animated wow slideInUp"
        data-wow-delay=".5s">
        <div class="new-collections-grid1-image">
            <a href="{{ route('web.product.single', $item->slug) }}" class="product-image"><img
                    src="cover/{{ $item->img }}" alt=" " class="img-responsive"></a>
            <div class="new-collections-grid1-image-pos products-right-grids-pos">
                <a href="{{ route('web.product.single', $item->slug) }}">View Detail</a>
            </div>
            <div class="new-collections-grid1-right products-right-grids-pos-right">
                <div class="rating">
                    <div class="rating-left">
                        <img src="template/web/images/2.png" alt=" " class="img-responsive">
                    </div>
                    <div class="rating-left">
                        <img src="template/web/images/2.png" alt=" " class="img-responsive">
                    </div>
                    <div class="rating-left">
                        <img src="template/web/images/2.png" alt=" " class="img-responsive">
                    </div>
                    <div class="rating-left">
                        <img src="template/web/images/1.png" alt=" " class="img-responsive">
                    </div>
                    <div class="rating-left">
                        <img src="template/web/images/1.png" alt=" " class="img-responsive">
                    </div>
                    <div class="clearfix"> </div>
                </div>
            </div>
        </div>
        <h4><a href="{{ route('web.product.single', $item->slug) }}">{{ $item->name }}</a>
        </h4>

        <div class="simpleCart_shelfItem products-right-grid1-add-cart">
            <p><i>{{ number_format($item->price) }}VND</i> <span
                    class="item_price">{{ number_format($item->price_sale) }}VND</span><a
                    data-url={{ route('add_Cart', $item->id) }}
                    class="item_add add_to_cart" href="">add to cart </a></p>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
	function addToCart(e) {
		e.preventDefault();
		let url = $(this).data('url');
		$.ajax({
			type: "GET",
			url: url,       
			dataType: 'json',
			success: function(data) {
				if(data.code === 200) {
					swal("Added to cart !", "You clicked the button!", "success");                   }
			}
		});

	}
	$(document).ready(function() {
		$('.add_to_cart').on('click', addToCart);
	})
</script>
@endforeach
