@extends('web3.layout.master2')
@section('content')
<!-- Blog Single -->
<section class="s-blog-single line-bottom-container">
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="heading blog-post-item">
                    <p class="entry_title display-sm fw-medium mb-3">
                        {{$blog->title}}
                    </p>
                    <ul class="entry-meta mb-4">
                        <li class="entry_author">
                            <div class="avatar">
                                <i class="bi bi-person-circle"></i>
                            </div>
                            <p class="entry_name">
                                Đăng bởi : <span class="fw-medium"> {{$blog->author}} </span>
                            </p>
                        </li>
                        <li class="br-line"></li>
                        <li class="entry_author">
                            <div class="avatar">
                                <i class="bi bi-clock"></i>
                            </div>
                            <p class="text-md">
                                Ngày đăng : <span class="fw-medium"> {{$blog->created_at}} </span>
                            </p>
                        </li>
                    </ul>
                    <div class="blog-image mb-4">
                        <img src="{{ asset('blog/' . $blog->image) }}" alt="{{ $blog->title }}"
                            class="img-fluid rounded">
                    </div>
                    <div class="content">
                        {!! $blog->content !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /Blog Single -->

<!-- Latest Tip -->
<section class="flat-spacing-25">
    <div class="container">
        <div class="flat-title mb_2 wow fadeInUp">
            <h4 class="title">Những bài viết khác</h4>
        </div>
        <div dir="ltr" class="swiper tf-swiper" data-swiper='{
                    "slidesPerView": 1,
                    "spaceBetween": 12,
                    "speed": 800,
                    "observer": true,
                    "observeParents": true,
                    "slidesPerGroup": 1,
                    "navigation": {
                        "clickable": true,
                        "nextEl": ".nav-next-new",
                        "prevEl": ".nav-prev-new"
                    },
                    "pagination": { "el": ".sw-pagination-new", "clickable": true },
                    "breakpoints": {
                    "577": { "slidesPerView": 2, "spaceBetween": 12, "slidesPerGroup": 2 },
                    "1200": { "slidesPerView": 3, "spaceBetween": 24, "slidesPerGroup": 3}
                    }
                }'>
            <div class="swiper-wrapper">
                @foreach ($blogs->take(3) as $blog)
                <div class="swiper-slide">
                    <div class="blog-post-item hover-img">
                        <div class="entry_image">
                            <a href="{{ route('web.detaiWebBlog.blog', $blog->id) }}" class="img-style">
                                <img src="{{ asset('blog/' . $blog->image) }}" alt="{{ $blog->title }}"
                                    class="lazyload">
                            </a>
                        </div>
                        <div class="blog-content">
                            <a href="{{ route('web.detaiWebBlog.blog', $blog->id) }}"
                                class="entry_title d-block text-xl fw-medium link">
                                {{$blog->title}}
                            </a>
                            <p class="entry_sub text-md text-main">
                                {{$blog->preview}}
                            </p>
                            <ul class="entry-meta">
                                <li class="entry_author">
                                    <div class="avatar">
                                        <i class="bi bi-person-circle"></i>
                                    </div>
                                    <p class="entry_name">
                                        Đăng bởi : <span class="fw-medium"> {{$blog->author}} </span>
                                    </p>
                                </li>
                                <li class="br-line"></li>
                                <li class="entry_date">
                                    <p class="text-md">
                                        <i class="bi bi-clock"></i> Ngày đăng : <span class="fw-medium">
                                            {{$blog->created_at->format('d/m/y')}} </span>
                                    </p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="d-flex d-xl-none sw-dot-default sw-pagination-new justify-content-center"></div>
        </div>
    </div>
</section>
<!-- /Latest Tip -->
@endsection