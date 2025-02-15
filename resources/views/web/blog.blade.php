@extends('web.layouts.master')
@section('content')
<div class="breadcrumbs">
    <div class="container">
        <ol class="breadcrumb breadcrumb1 animated wow slideInLeft" data-wow-delay=".5s">
            <li><a href="/"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>Home</a></li>
            <li class="active">Blog Page</li>
        </ol>
    </div>
</div>
<br>
<br>
    <section class="shop-blog section mt-3">
        <div class="container">    
            <div class="row">
                @foreach ($blogs as $item)
                <div class="col-md-4">
                    <div class="shop-single-blog">
                        <img src="blog/{{ $item->image }}" width="320px" alt="#">
                        <div class="content">                   
                            <h5>{{ $item->title }}</h5>
                             <h6>Author: {{ $item->author }}</h6>
                             <h6>View: {{ $item->views }}</h6>
                            <p class="date">{{ $item->created_at }}</p>
                            <a href="{{ route('web.blog.detail',$item->slug) }}" class="more-btn">Continue Reading</a>
                        </div>
                    </div>
                </div>
                @endforeach 
            </div>
            {!! $blogs->links() !!}
        </div>
    </section>
    <br><br>
    
@endsection
