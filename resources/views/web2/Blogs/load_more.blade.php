@foreach($blogs as $blog)
<div class="row mb-4 p-3 border rounded shadow-sm bg-white">
    <div class="col-md-4">
        <img src="{{ asset('blog/' . $blog->image) }}" alt="{{ $blog->title }}" class="img-fluid rounded"
            style="max-height: 200px; object-fit: cover;">
    </div>
    <div class="col-md-8">
        <h5 class="fw-bold">{{ strtoupper($blog->title) }}</h5>
        <p class="text-muted">{{ \Carbon\Carbon::parse($blog->created_at)->format('l, d-m-Y') }}</p>
        <p>{!! Str::limit($blog->preview, 150, '...') !!}</p>
        <a href="{{ route('web.detaiWebBlog.blog', $blog->id) }}" class="btn btn-outline-primary btn-sm">Xem chi
            tiết</a>
    </div>
</div>
@endforeach