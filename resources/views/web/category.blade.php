@extends('web.layouts.master')
@section('content')
<div class="breadcrumbs">
    <div class="container">
        <ol class="breadcrumb breadcrumb1 animated wow slideInLeft" data-wow-delay=".5s">
            <li><a href="/"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>Home</a></li>
            <li class="active">Products</li>
        </ol>
    </div>
</div>
<div class="products">
    <div class="container">
        <div class="col-md-4 products-left">       
            <div class="categories animated wow slideInUp" data-wow-delay=".5s">
                <h3>Categories</h3>
                <ul class="cate">    
                    @foreach ($categories as $item)
                    <li><a href="{{ route('web.category',$item->slug) }}">{{ $item->name }}</a></li>
                    <ul>
                        @foreach ($categories_2 as $item2)
                         @if ($item2->parent_id == $item->id)
                         <li><a href="{{ route('web.category',$item2->slug) }}">{{ $item2->name }}</a></li>
                            <ul>
                                @foreach ($categories_3 as $item3)
                                @if ($item3->parent_id == $item2->id)
                                <li><a href="{{ route('web.category',$item3->slug) }}">{{ $item3->name }}</a></li>
                                @endif                      
                               @endforeach     
                            </ul>
                         @endif
                        
                        @endforeach               
                    </ul>
                    @endforeach                  
                </ul>
            </div>
            <div class="new-products animated wow slideInUp" data-wow-delay=".5s">
                <h3>New Products</h3>

                <div class="new-products-grids">
                    @foreach($products as $product)
                    <div class="new-products-grid">
                        <div class="new-products-grid-left">
                            <a href="{{ route('web.product.single',$product->slug) }}"><img src="cover/{{$product->img}}" alt=" " class="img-responsive" /></a>
                        </div>
                      
                            <div class="new-products-grid-right">
                            <h4><a href="{{ route('web.product.single',$product->slug) }}">{{$product->name}}</a></h4>
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
                            <div class="simpleCart_shelfItem new-products-grid-right-add-cart">
                                <p> <span class="item_price">{{number_format($product->price)}} VND</span><a class="item_add add_to_cart"  data-url={{ route('add_Cart', $product->id) }} href="#">add to cart </a></p>
                            </div>
                        </div>
                    
                        <div class="clearfix"> </div>
                    </div>
                       @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-8 products-right">
            <div class="products-right-grid">
                <div class="products-right-grids animated wow slideInRight" data-wow-delay=".5s">
                    <div class="sorting">
                        <select id="country" onchange="change_country(this.value)" class="frm-field required sect">
                            <option value="null">Default sorting</option>
                            <option value="null">Sort by popularity</option> 
                            <option value="null">Sort by average rating</option>					
                            <option value="null">Sort by price</option>								
                        </select>
                    </div>
                    <div class="sorting-left">
                         <h4 style="color: red">{{ $category->name }}</h4>
                    </div>
                    <div class="clearfix"> </div>
                </div>
              
            </div>
            <div class="products-right-grids-bottom">
                @foreach ($products_all as $item)
                <div class="col-md-4 products-right-grids-bottom-grid">
                    <div class="new-collections-grid1 products-right-grid1 animated wow slideInUp" data-wow-delay=".5s">
                        <div class="new-collections-grid1-image">
                            <a href="{{ route('web.product.single',$item->slug) }}" class="product-image"><img src="cover/{{ $item->img }}" alt=" " class="img-responsive"></a>
                            <div class="new-collections-grid1-image-pos products-right-grids-pos">
                                <a href="{{ route('web.product.single',$item->slug) }}">View Detail</a>
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
                        <h4><a href="{{ route('web.product.single',$item->slug) }}">{{ $product->name }}</a></h4>
                       
                        <div class="simpleCart_shelfItem products-right-grid1-add-cart">
                            <p><i>{{ number_format($product->price) }}VND</i> <span class="item_price">{{ number_format($product->price_sale) }}VND</span><a class="item_add add_to_cart" data-url={{ route('add_Cart', $product->id) }} href="#">add to cart </a></p>
                        </div>
                    </div>             
                </div> 
                @endforeach
                 
                <div class="clearfix"> </div>
            </div>   
        </div>
        <div class="clearfix"> </div>
    </div>
</div>
@endsection

