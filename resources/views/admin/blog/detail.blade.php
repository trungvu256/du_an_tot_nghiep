@extends('admin.layouts.main')

@section('content')
<div class="container">
    <!-- Ảnh banner -->
    <div class="text-center mb-4">
        <img src="{{ asset('blog/' . $blog->image) }}" alt="{{ $blog->title }}"
            class="img-fluid rounded shadow" style="max-width: 100%; height: auto;">
    </div>

    <!-- Tiêu đề và thông tin -->
    <h1 class="text-center font-weight-bold text-uppercase mb-3">{{ $blog->title }}</h1>
    <p class="text-center text-muted">✍️ <strong>{{ $blog->author }}</strong> | 🕒 {{ $blog->created_at->format('d/m/Y') }} | 👁️ {{ rand(100, 999) }} lượt đọc</p>

    <!-- Mô tả ngắn -->
    <div class="bg-light p-3 rounded">
        <h5 class="font-weight-bold">📌 Giới thiệu</h5>
        <p>{!! $blog->preview !!}</p>
    </div>

    <!-- Nội dung bài viết với hiệu ứng Xem thêm -->
    <div class="mt-4 border rounded p-4" style="background-color: #fafafa;">
        <h4 class="mb-3 font-weight-bold">📖 Nội dung bài viết</h4>
        <div id="content" style="max-height: 300px; overflow: hidden; transition: max-height 0.3s;">
            {!! $blog->content !!}
        </div>
        <div class="text-center mt-3">
            <button id="toggleBtn" class="btn btn-primary">Xem thêm ⬇️</button>
        </div>
    </div>

    <!-- Nút điều hướng -->
    <div class="mt-4 d-flex justify-content-between">
        <a href="{{ route('admin.edit.blog', $blog->id) }}" class="btn btn-warning">
            <i class="bi bi-pencil-square"></i> Chỉnh sửa
        </a>
        <a href="{{ route('admin.blog') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Quay lại
        </a>
    </div>
</div>

<script>
    document.getElementById("toggleBtn").addEventListener("click", function () {
        var content = document.getElementById("content");
        if (content.style.maxHeight === "300px") {
            content.style.maxHeight = "none";
            this.innerHTML = "Thu gọn ⬆️";
        } else {
            content.style.maxHeight = "300px";
            this.innerHTML = "Xem thêm ⬇️";
        }
    });
</script>

@endsection
