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
                    </ul>
                </div>
                <div class="new-products animated wow slideInUp" data-wow-delay=".5s">
                    <h3>New Products</h3>

                    <div class="new-products-grids">

                    </div>
                </div>
            </div>
            <div class="col-md-8 products-right">
                <div class="products-right-grid">
                    <div class="products-right-grids animated wow slideInRight" data-wow-delay=".5s">
                        <div class="sorting">
                          <form action="">
                              @csrf
                            <select id="sort" name="sort" class="form-control">

                            </select>
                          </form>
                        </div>

                        <div class="clearfix"> </div>
                    </div>
                  <script>
                      $(document).ready(function(){
                          $("#sort").on('change',function(){
                                var url = $(this).val();
                                if(url) {
                                    window.location = url;
                                }
                                return false;
                          });
                      });
                  </script>
                </div>
                <div class="products-right-grids-bottom" id="load">
                    <div class="clearfix"> </div>
                </div>
            </div>
            <div class="clearfix"> </div>
        </div>
    </div>

@endsection
