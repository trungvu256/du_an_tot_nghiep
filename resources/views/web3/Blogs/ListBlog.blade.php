@extends('web3.layout.master2')
@section('content')
<!-- Section blog -->
<!-- Breadcrumb -->
<div class="tf-breadcrumb">
    <div class="container">
        <ul class="breadcrumb-list">
            <li class="item-breadcrumb">
                <a href="/" class="text">Trang chủ</a>
            </li>
            <li class="item-breadcrumb dot">
                <span></span>
            </li>
            <li class="item-breadcrumb">
                <span class="text">Bài viết</span>
            </li>
        </ul>
    </div>
</div>
<!-- /Breadcrumb -->
<!-- Title Page -->
<section class="page-title">
    <div class="container">
        <div class="box-title text-center">
            <h4 class="title">Bài viết</h4>
        </div>
    </div>
</section>
<!-- /Title Page -->
<section class="s-blog-grid-v2 sec-blog">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="sidebar-blog d-lg-grid d-none sidebar-content-wrap type-left">
                    <div class="sb-item">
                        <p class="sb-title text-xl fw-medium">Bài viết mới</p>
                        <div class="sb-content">
                            <ul class="recent-blog-list">
                                @foreach ($latestBlogs as $blog)
                                <li class="hover-img">
                                    <div class="image">
                                        <a href="{{ route('web.detaiWebBlog.blog', $blog->id) }}" class="img-style d-block">
                                            <img src="{{ asset('blog/' . $blog->image) }}" alt="{{ $blog->title }}" class="lazyload">
                                        </a>
                                    </div>
                                    <div class="post-content">
                                        <a href="{{ route('web.detaiWebBlog.blog', $blog->id) }}" class="link text-md fw-medium">{{ $blog->title }}</a>
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
                        <div class="sb-banner hover-img">
                            <div class="image img-style">
                                <img src="{{ asset('/images/Banner/featured_coll_2_2_img.jpg') }}" alt="banner" class="lazyload">
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
                    @foreach ($blogs as $blog)
                    <div class="blog-post-item hover-img">
                        <div class="entry_image">
                            <a href="{{ route('web.detaiWebBlog.blog', $blog->id) }}" class="img-style">
                                <img src="{{ asset('blog/' . $blog->image) }}" alt="{{ $blog->title }}" class="lazyload">
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
                                        <i class="bi bi-person-circle"></i> Đăng bởi : <span class="fw-medium">{{ $blog->author }}</span>
                                    </p>
                                </li>
                                <li class="br-line"></li>
                                <li class="entry_date">
                                    <p class="text-md">
                                        <i class="bi bi-clock"></i> Ngày đăng : <span class="fw-medium">{{ $blog->created_at->format('d/m/Y') }}</span>
                                    </p>
                                </li>
                            </ul>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="pagination-wrapper mt-4">
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            {{-- Previous Page Link --}}
                            @if ($blogs->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link">
                                        <i class="bi bi-chevron-left"></i>
                                    </span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $blogs->previousPageUrl() }}" rel="prev">
                                        <i class="bi bi-chevron-left"></i>
                                    </a>
                                </li>
                            @endif

                            {{-- First Page --}}
                            <li class="page-item {{ $blogs->currentPage() == 1 ? 'active' : '' }}">
                                <a class="page-link" href="{{ $blogs->url(1) }}">1</a>
                            </li>

                            {{-- Pages Before Current Page --}}
                            @if ($blogs->currentPage() > 3)
                                <li class="page-item disabled">
                                    <span class="page-link">...</span>
                                </li>
                            @endif

                            @for ($i = max(2, $blogs->currentPage() - 1); $i <= min($blogs->lastPage() - 1, $blogs->currentPage() + 1); $i++)
                                <li class="page-item {{ $i == $blogs->currentPage() ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $blogs->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor

                            {{-- Pages After Current Page --}}
                            @if ($blogs->currentPage() < $blogs->lastPage() - 2)
                                <li class="page-item disabled">
                                    <span class="page-link">...</span>
                                </li>
                            @endif

                            {{-- Last Page --}}
                            @if ($blogs->lastPage() > 1)
                                <li class="page-item {{ $blogs->currentPage() == $blogs->lastPage() ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $blogs->url($blogs->lastPage()) }}">{{ $blogs->lastPage() }}</a>
                                </li>
                            @endif

                            {{-- Next Page Link --}}
                            @if ($blogs->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $blogs->nextPageUrl() }}" rel="next">
                                        <i class="bi bi-chevron-right"></i>
                                    </a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <span class="page-link">
                                        <i class="bi bi-chevron-right"></i>
                                    </span>
                                </li>
                            @endif
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.pagination-wrapper {
    margin-top: 2rem;
}

.pagination {
    margin-bottom: 0;
}

.page-item {
    margin: 0 4px;
}

.page-link {
    color: #333;
    border: 1px solid #ddd;
    padding: 8px 16px;
    border-radius: 4px;
    transition: all 0.3s ease;
}

.page-link:hover {
    background-color: #f8f9fa;
    border-color: #ddd;
    color: #333;
}

.page-item.active .page-link {
    background-color: #007bff;
    border-color: #007bff;
    color: #fff;
}

.page-item.disabled .page-link {
    color: #6c757d;
    pointer-events: none;
    background-color: #fff;
    border-color: #ddd;
}

.page-link i {
    font-size: 0.8rem;
}
</style>
<!-- Section blog -->
@endsection