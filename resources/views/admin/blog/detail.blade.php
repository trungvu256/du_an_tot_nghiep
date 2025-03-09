@extends('admin.layouts.main')

@section('content')
    <div class="container">
        <h2>{{ $blog->title }}</h2>
        <p><strong>Author:</strong> {{ $blog->author }}</p>
        <p><strong>Slug:</strong> {{ $blog->slug }}</p>

        <img src="{{ asset('blog/' . $blog->image) }}" alt="{{ $blog->title }}" width="200px">

        <p><strong>Preview:</strong></p>
        <div>{!! $blog->preview !!}</div>
        <p><strong>Content:</strong></p>

        <div>{!! $blog->content !!}</div>

        <a href="{{ route('admin.edit.blog', $blog->id) }}" class="btn btn-warning"><i class="bi bi-pencil-square"></i></a>

        <a href="{{ route('admin.blog') }}" class="btn btn-secondary">Back</a>
    </div>
@endsection
