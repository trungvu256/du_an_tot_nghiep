@extends('web2.layout.master')

@section('content')
<div class="container-fluid">
    <div class="row border-top px-xl-5">
        <div class="col-lg-3 d-none d-lg-block">
            <a class="btn shadow-none d-flex align-items-center justify-content-between bg-primary text-white w-100"
                data-toggle="collapse" href="#navbar-vertical" style="height: 65px; margin-top: -1px; padding: 0 30px;">
                <h6 class="m-0">Categories</h6>
                <i class="fa fa-angle-down text-dark"></i>
            </a>
            <nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 border border-top-0 border-bottom-0 bg-light"
                id="navbar-vertical" style="width: calc(100% - 30px); z-index: 1;">
                <div class="navbar-nav w-100 overflow-hidden" style="height: 410px">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link" data-toggle="dropdown">Dresses <i
                                class="fa fa-angle-down float-right mt-1"></i></a>
                        <div class="dropdown-menu position-absolute bg-secondary border-0 rounded-0 w-100 m-0">
                            <a href="" class="dropdown-item">Men's Dresses</a>
                            <a href="" class="dropdown-item">Women's Dresses</a>
                            <a href="" class="dropdown-item">Baby's Dresses</a>
                        </div>
                    </div>
                    <a href="" class="nav-item nav-link">Shirts</a>
                    <a href="" class="nav-item nav-link">Jeans</a>
                    <a href="" class="nav-item nav-link">Swimwear</a>
                    <a href="" class="nav-item nav-link">Sleepwear</a>
                    <a href="" class="nav-item nav-link">Sportswear</a>
                    <a href="" class="nav-item nav-link">Jumpsuits</a>
                    <a href="" class="nav-item nav-link">Blazers</a>
                    <a href="" class="nav-item nav-link">Jackets</a>
                    <a href="" class="nav-item nav-link">Shoes</a>
                </div>
            </nav>
        </div>
        <div class="col-lg-9">
            <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0">
                <a href="" class="text-decoration-none d-block d-lg-none">
                    <h1 class="m-0 display-5 font-weight-semi-bold"><span
                            class="text-primary font-weight-bold border px-3 mr-1">E</span>Shopper</h1>
                </a>
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                    @include('web2.layout.menu')


                    <div class="navbar-nav ml-auto py-0">


                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>
<!-- Navbar End -->
<div class="container mt-4">
    <div class="row">
        <!-- Danh sách bài viết -->
        <div class="col-lg-9">
            <div id="blog-list">
                @include('web2.Blogs.load_more')
            </div>
            <div class="text-center mt-3">
                @if ($blogs->hasMorePages())
                <button id="load-more-btn" class="btn btn-primary"
                    data-page="{{ $blogs->currentPage() + 1 }}">
                    Xem thêm {{ $blogs->total() - $blogs->perPage() }}
                </button>
                @endif
            </div>
        </div>

        <!-- Cột bên phải: Xem nhiều nhất -->
        <div class="col-lg-3">
            <div class="bg-black text-white p-2 text-center rounded-top">
                <h6 class="mb-0">XEM NHIỀU NHẤT</h6>
            </div>
            <div class="list-group">
                @foreach($mostViewedBlogs as $blog)
                <a href="{{ route('web.detaiWebBlog.blog', $blog->id) }}"
                    class="list-group-item list-group-item-action d-flex">
                    <img src="{{ asset('blog/' . $blog->image) }}" alt="{{ $blog->title }}"
                        class="me-2 rounded" style="width: 50px; height: 50px; object-fit: cover;">
                    <span class="small">{{ $blog->title }}</span>
                </a>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- AJAX Load More -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).on('click', '#load-more-btn', function() {
        let page = $(this).data('page');

        $.ajax({
            url: '?page=' + page,
            type: "GET",
            success: function(data) {
                $('#blog-list').append(data);

                let nextPage = page + 1;
                $('#load-more-btn').data('page', nextPage);

                if (!$('.pagination').length) {
                    $('#load-more-btn').remove();
                }
            }
        });
    });
</script>

@endsection
