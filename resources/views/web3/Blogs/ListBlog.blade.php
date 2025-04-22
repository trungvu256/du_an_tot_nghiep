@extends('web3.layout.master2')
@section('content')
    <!-- Section blog -->
    <section class="s-blog-grid-v2 sec-blog">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="sidebar-blog d-lg-grid d-none sidebar-content-wrap type-left">
                        
                        <div class="sb-item">
                            <p class="sb-title text-xl fw-medium">Bài viết mới</p>
                            <div class="sb-content">
                                <ul class="recent-blog-list">
                                    @foreach ($blogs as $blog)
                                        <li class="hover-img">
                                            <div class="image">
                                                <a href="{{ route('web.detaiWebBlog.blog', $blog->id) }}" class="img-style d-block">
                                                    <img src="{{ asset('blog/' . $blog->image) }}"
                                                        data-src="{{ asset('blog/' . $blog->image) }}" alt=""
                                                        class="lazyload">
                                                </a>
                                            </div>
                                            <div class="post-content">
                                                <a href="{{ route('web.detaiWebBlog.blog', $blog->id) }}"
                                                    class="link text-md fw-medium">{{ $blog->title }}</a>
                                                <p class="entry_date">
                                                    <i class="bi bi-clock"></i> {{ $blog->created_at->format('d/m/Y') }}
                                                </p>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="sb-item">
                            <p class="sb-title text-xl fw-medium">Thẻ</p>
                            <div class="sb-content entry-tag">
                                <ul class="tag-blog-list style-list">
                                    <li>
                                        <a href="#" class="type-life">
                                            phong cách sống
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="type-design">
                                            Thiết kế
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="type-bag">
                                            Mùi hương
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="type-trick">
                                            Mẹo vặt
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="sb-item">
                            <div class="sb-banner hover-img">
                                <div class="image img-style">
                                    <img src="{{ asset('/images/Banner/featured_coll_2_2_img.jpg') }}" data-src="{{ asset('/images/Banner/featured_coll_2_2_img.jpg') }}" alt="banner"
                                        class="lazyload">
                                </div>
                                <div class="banner-content">
                                    <a href="{{ route('web.shop') }}" class="tf-btn btn-white hover-primary">Mua ngay</a>
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
                                    <a href="{{ route('web.detaiWebBlog.blog', $blog->id) }}" class="img-style">
                                        <img src="{{ asset('blog/' . $blog->image) }}"
                                            data-src="{{ asset('blog/' . $blog->image) }}" alt="" class="lazyload">
                                    </a>
                                </div>
                                <div class="blog-content">
                                    <a href="{{ route('web.detaiWebBlog.blog', $blog->id) }}" class="entry_title d-block text-xl fw-medium link">
                                        {{ $blog->title }}
                                    </a>
                                    <p class="entry_sub text-md text-main">
                                        {{ $blog->preview }}
                                    </p>
                                    <ul class="entry-meta">
                                        <li class="entry_author">
                                            <p class="entry_name">
                                                <i class="bi bi-person-circle"></i> Đăng bởi : <span class="fw-medium">  {{ $blog->author }} </span>
                                            </p>
                                        </li>
                                        <li class="br-line"></li>
                                        <li class="entry_date">
                                            <p class="text-md">
                                                <i class="bi bi-clock"></i> Ngày đăng : <span class="fw-medium">  {{ $blog->created_at->format('d/m/Y') }} </span>
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
