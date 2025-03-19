@extends('web2.layout.master')

@section('content')

<!-- Navbar End -->
<div class="container mt-4">
    <!-- Nội dung bài viết -->
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <h2 class="fw-bold text-uppercase text-center">{{ $blog->title }}</h2>
            <hr class="w-25 mx-auto mb-4">
            <p class="text-muted text-center">
                Đăng ngày: {{ \Carbon\Carbon::parse($blog->created_at)->format('d/m/Y') }}
            </p>
            <div class="content">
                {!! $blog->content !!}
            </div>
        </div>
    </div>

    <!-- Tin tức khác -->
    <h3 class="fw-bold mt-5">TIN TỨC KHÁC</h3>
    <hr class="mb-4">

    <div id="blog-list" class="row">
        @include('web2.Blogs.load_more')
    </div>

    <div class="text-center mt-3">
        @if ($blogs->hasMorePages())
        <button id="load-more-btn" class="btn btn-primary" data-page="{{ $blogs->currentPage() + 1 }}">
            Xem thêm {{ $blogs->total() - $blogs->perPage() }}
        </button>
        @endif
    </div>
</div>

<!-- Style -->
<style>
.container {
    max-width: 900px;
    margin: auto;
}

.content {
    text-align: justify;
}

h2,
h3 {
    text-align: center;
}

hr {
    border: 2px solid #e91e63;
    width: 50px;
    margin: 10px auto;
}

.card {
    border-radius: 10px;
    overflow: hidden;
}

.card img {
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
}

.card-body {
    padding: 15px;
}
</style>

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