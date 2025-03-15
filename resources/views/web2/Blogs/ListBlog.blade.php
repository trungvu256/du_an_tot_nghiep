@extends('web2.layout.master')

@section('content')
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
