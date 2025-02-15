@extends('web.layouts.master')
@section('content')
    <div class="breadcrumbs">
        <div class="container">
            <ol class="breadcrumb breadcrumb1 animated wow slideInLeft" data-wow-delay=".5s">
                <li><a href="/"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>Home</a></li>
                <li class="active">Single Page</li>
            </ol>
        </div>
    </div>
    <div class="single">
        <div class="container">
            <div class="col-md-4 products-left">
                <div class="filter-price animated wow slideInUp" data-wow-delay=".5s">
                    <h3>Filter By Price</h3>
                    <ul class="dropdown-menu1">
                        <li><a href="">
                                <div id="slider-range"></div>
                                <input type="text" id="amount" style="border: 0" />
                            </a></li>
                    </ul>
                    <script type='text/javascript'>
                        //<![CDATA[ 
                        $(window).load(function() {
                            $("#slider-range").slider({
                                range: true,
                                min: 0,
                                max: 100000,
                                values: [10000, 60000],
                                slide: function(event, ui) {
                                    $("#amount").val("$" + ui.values[0] + " - $" + ui.values[1]);
                                }
                            });
                            $("#amount").val("$" + $("#slider-range").slider("values", 0) + " - $" + $("#slider-range").slider(
                                "values", 1));


                        }); //]]>
                    </script>
                    <script type="text/javascript" src="template/web/js/jquery-ui.min.js"></script>
                    <!---->
                </div>
                <div class="categories animated wow slideInUp" data-wow-delay=".5s">
                    <h3>Categories</h3>
                    <ul class="cate">
                        @foreach ($categories as $item)
                            <li><a href="{{ route('web.category', $item->slug) }}">{{ $item->name }}</a></li>
                            <ul>
                                @foreach ($categories_2 as $item2)
                                    @if ($item2->parent_id == $item->id)
                                        <li><a href="{{ route('web.category', $item2->slug) }}">{{ $item2->name }}</a>
                                        </li>
                                        <ul>
                                            @foreach ($categories_3 as $item3)
                                                @if ($item3->parent_id == $item2->id)
                                                    <li><a
                                                            href="{{ route('web.category', $item3->slug) }}">{{ $item3->name }}</a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    @endif

                                @endforeach
                            </ul>
                        @endforeach
                    </ul>
                </div>
                <div class="men-position animated wow slideInUp" data-wow-delay=".5s">
                    <a href="single.html"><img src="template/web/images/29.jpg" alt=" " class="img-responsive" /></a>
                    <div class="men-position-pos">
                        <h4>Summer collection</h4>
                        <h5><span>55%</span> Flat Discount</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-8 single-right">
                <div class="col-md-5 single-right-left animated wow slideInUp" data-wow-delay=".5s">
                    <div class="flexslider">
                        <ul class="slides">
                            @foreach ($product->images as $value)
                                <li data-thumb="images/{{ $value->image }}">
                                    <div class="thumb-image"> <img src="images/{{ $value->image }}"
                                            data-imagezoom="true" class="img-responsive"> </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <!-- flixslider -->
                    <script defer src="template/web/js/jquery.flexslider.js"></script>
                    <link rel="stylesheet" href="template/web/css/flexslider.css" type="text/css" media="screen" />
                    <script>
                        // Can also be used with $(document).ready()
                        $(window).load(function() {
                            $('.flexslider').flexslider({
                                animation: "slide",
                                controlNav: "thumbnails"
                            });
                        });
                    </script>
                    <!-- flixslider -->
                </div>
                <div class="col-md-7 single-right-left simpleCart_shelfItem animated wow slideInRight" data-wow-delay=".5s">
                    <h3>{{ $product->name }}</h3>
                    <h4><span class="item_price">{{ number_format($product->price_sale) }}</span> -
                        <del>{{ number_format($product->price) }} VND</del>
                    </h4>
                    <div class="rating1">
                        <span class="starRating">
                            <input id="rating5" type="radio" name="rating" value="5">
                            <label for="rating5">5</label>
                            <input id="rating4" type="radio" name="rating" value="4">
                            <label for="rating4">4</label>
                            <input id="rating3" type="radio" name="rating" value="3" checked>
                            <label for="rating3">3</label>
                            <input id="rating2" type="radio" name="rating" value="2">
                            <label for="rating2">2</label>
                            <input id="rating1" type="radio" name="rating" value="1">
                            <label for="rating1">1</label>
                        </span>
                    </div>
                    <div class="description">
                        <h5><i>Description</i></h5>
                        <p>{!! $product->description !!}</p>
                    </div>
                    <div class="color-quality">
                        <div class="color-quality-left">
                             <h4>Views: {{ $product->views }}</h4>
                        </div>
        
                        <div class="clearfix"> </div>
                    </div>
                    <div class="occasional">
                        <h5>Category : {{ $product->category->name }}</h5>

                        <div class="clearfix"> </div>
                    </div>
                    <div class="occasion-cart">
                        <a class="item_add add_to_cart" data-url={{ route('add_Cart', $product->id) }} href="#">add to
                            cart </a>
                    </div>
                    <div class="social">
                        <div class="social-left">
                            <p>Share On :</p>
                        </div>
                        <div class="social-right">
                            <ul class="social-icons">
                                <li><a href="#" class="facebook"></a></li>
                                <li><a href="#" class="twitter"></a></li>
                                <li><a href="#" class="g"></a></li>
                                <li><a href="#" class="instagram"></a></li>
                            </ul>
                        </div>
                        <div class="clearfix"> </div>
                    </div>
                </div>
                <div class="clearfix"> </div>
                <div class="bootstrap-tab animated wow slideInUp" data-wow-delay=".5s">
                    <div class="bs-example bs-example-tabs" role="tabpanel" data-example-id="togglable-tabs">
                        <ul id="myTab" class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#home" id="home-tab" role="tab"
                                    data-toggle="tab" aria-controls="home" aria-expanded="true">Description</a></li>
                            <li role="presentation"><a href="#profile" role="tab" id="profile-tab" data-toggle="tab"
                                    aria-controls="profile">Reviews(2)</a></li>

                        </ul>
                        <div id="myTabContent" class="tab-content">
                            <div role="tabpanel" class="tab-pane fade in active bootstrap-tab-text" id="home"
                                aria-labelledby="home-tab">
                                <h5>Product Description</h5>
                                <p><span>{!! $product->content !!}</span></p>
                            </div>
                            <div role="tabpanel" class="tab-pane fade bootstrap-tab-text" id="profile"
                                aria-labelledby="profile-tab">
                                <div class="bootstrap-tab-text-grids">
                                    <div class="bootstrap-tab-text-grid">
                                        <div class="bootstrap-tab-text-grid-left">
                                            <img src="template/web/images/4.png" alt=" " class="img-responsive" />
                                        </div>
                                        <div class="bootstrap-tab-text-grid-right">
                                            <ul>


                                            </ul>
                                            <p>Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis
                                                suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem
                                                vel eum iure reprehenderit.</p>
                                        </div>
                                        <div class="clearfix"> </div>
                                    </div>

                                    <div class="add-review">
                                        <h4>add a review</h4>
                                        <form action="javascript:void(0)">
                                            <input type="hidden" name="name" id="name" value="VuPham">
                                            <input type="hidden" name="id_blog" id="id_blog" value="0">
                                            <input type="hidden" name="id_product" id="id_product"
                                                value="{{ $product->id }}">
                                            <textarea name="comment" id="comment"></textarea>
                                            <button type="submit" class="btn btn-primary">Send</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"> </div>
        </div>
    </div>
    <div class="single-related-products">
        <div class="container">
            <h3 class="animated wow slideInUp" data-wow-delay=".5s">Related Products</h3>
            <div class="new-collections-grids">
                @foreach ($products_related as $item)
                    <div class="col-md-3 new-collections-grid">
                        <div class="new-collections-grid1 animated wow slideInLeft" data-wow-delay=".5s">
                            <div class="new-collections-grid1-image">
                                <a href="{{ route('web.product.single', $item->slug) }}" class="product-image"><img
                                        src="cover/{{ $item->img }}" alt=" " class="img-responsive"></a>
                                <div class="new-collections-grid1-image-pos">
                                    <a href="{{ route('web.product.single', $item->slug) }}"> View Detail</a>
                                </div>
                                <div class="new-collections-grid1-right">
                                    <div class="rating">
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
                                        <div class="rating-left">
                                            <img src="template/web/images/1.png" alt=" " class="img-responsive">
                                        </div>
                                        <div class="clearfix"> </div>
                                    </div>
                                </div>
                            </div>
                            <h4><a href="{{ route('web.product.single', $item->slug) }}">{{ $item->name }}</a></h4>

                            <div class="new-collections-grid1-left simpleCart_shelfItem">
                                <p><i>{{ $item->price }}</i> <span
                                        class="item_price">{{ $item->price_sale }}</span>
                                  
                                </p>
                                <p>  <a class="item_add add_to_cart" data-url={{ route('add_Cart', $product->id) }}
                                    href="#">add to cart </a></p>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="clearfix"> </div>
            </div>
        </div>
    </div>

@endsection
