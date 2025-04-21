@extends('web3.layout.master2')
@section('content')
    <!-- Section blog -->
    <section class="s-blog-grid-v2 sec-blog">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="sidebar-blog d-lg-grid d-none sidebar-content-wrap type-left">
                        <div class="sb-item">
                            <p class="sb-title text-xl fw-medium">Categories</p>
                            <div class="sb-content">
                                <ul class="category-blog-list">
                                    <li>
                                        <a href="blog-single.html" class="text-md link">
                                            Accessories
                                        </a>
                                    </li>
                                    <li>
                                        <a href="blog-single.html" class="text-md link">
                                            Bags
                                        </a>
                                    </li>
                                    <li>
                                        <a href="blog-single.html" class="text-md link">
                                            Lifestyle
                                        </a>
                                    </li>
                                    <li>
                                        <a href="blog-single.html" class="text-md link">
                                            Designs
                                        </a>
                                    </li>
                                    <li>
                                        <a href="blog-single.html" class="text-md link">
                                            Tricks & Tips
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="sb-item">
                            <p class="sb-title text-xl fw-medium">Bài viết mới</p>
                            <div class="sb-content">
                                <ul class="recent-blog-list">
                                    @foreach ($blogs as $blog)
                                        <li class="hover-img">
                                            <div class="image">
                                                <a href="blog-single.html" class="img-style d-block">
                                                    <img src="{{ asset('blog/' . $blog->image) }}"
                                                        data-src="{{ asset('blog/' . $blog->image) }}" alt=""
                                                        class="lazyload">
                                                </a>
                                            </div>
                                            <div class="post-content">
                                                <a href="blog-single.html"
                                                    class="link text-md fw-medium">{{ $blog->title }}</a>
                                                <p class="entry_date">
                                                    {{ $blog->created_at->format('d/m/Y') }}
                                                </p>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="sb-item">
                            <p class="sb-title text-xl fw-medium">Tags</p>
                            <div class="sb-content entry-tag">
                                <ul class="tag-blog-list style-list">
                                    <li>
                                        <a href="#" class="type-life">
                                            Lifestyle
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="type-design">
                                            Designs
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="type-bag">
                                            Bags
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="type-trick">
                                            Tricks & Tips
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="sb-item">
                            <div class="sb-banner hover-img">
                                <div class="image img-style">
                                    <img src="images/blog/sb-banner.jpg" data-src="images/blog/sb-banner.jpg" alt="banner"
                                        class="lazyload">
                                </div>
                                <div class="banner-content">
                                    <p class="title">
                                        Elevate <br> Your Style
                                    </p>
                                    <a href="#" class="tf-btn btn-white hover-primary">Shop Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="s-blog-list-grid grid-2">
                        @foreach ($mostViewedBlogs as $blog)
                            <div class="blog-post-item hover-img">
                                <div class="entry_image">
                                    <a href="blog-single.html" class="img-style">
                                        <img src="{{ asset('blog/' . $blog->image) }}"
                                            data-src="{{ asset('blog/' . $blog->image) }}" alt="" class="lazyload">
                                    </a>
                                </div>
                                <div class="blog-content">
                                    <a href="blog-single.html" class="entry_title d-block text-xl fw-medium link">
                                        {{ $blog->title }}
                                    </a>
                                    <p class="entry_sub text-md text-main">
                                        {{ $blog->preview }}
                                    </p>
                                    <ul class="entry-meta">
                                        <li class="entry_author">
                                            <p class="entry_name">
                                                Đăng bởi : <span class="fw-medium">  {{ $blog->author }} </span>
                                            </p>
                                        </li>
                                        <li class="br-line"></li>
                                        <li class="entry_date">
                                            <p class="text-md">
                                                Ngày đăng : <span class="fw-medium">  {{ $blog->created_at->format('d/m/Y') }} </span>
                                            </p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        @endforeach
                        {{$mostViewedBlogs->links()}}
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- Section blog -->
@endsection
