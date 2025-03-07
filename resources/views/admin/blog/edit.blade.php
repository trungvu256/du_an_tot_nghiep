@extends('admin.layouts.main')
@section('content')

<form action="{{route('admin.store.blog', $blogs_edit->id)}}" method="post" enctype="multipart/form-data">
    @csrf

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="mb-3">
        <label for="author">Author</label>
        <input type="text" name="author" class="form-control" value="{{$blogs_edit->author}}">
    </div>

    <div class="mb-3">
        <label for="title">Title</label>
        <input type="text" name="title" class="form-control" value="{{$blogs_edit->title}}">
    </div>

    <div class="mb-3">
        <label for="image">Image</label>
        <input type="file" name="image" class="form-control">
        <br>
        @if ($blogs_edit->image)
            <img src="{{ asset('blog/'.$blogs_edit->image) }}" alt="" width="100">
        @endif
    </div>

    <div class="mb-3">
        <label for="preview">Preview</label>
        <textarea name="preview" id="preview" class="form-control">{{$blogs_edit->preview}}</textarea>
    </div>

    <div class="mb-3">
        <label for="content">Content</label>
        <textarea name="content" id="content" class="form-control">{{$blogs_edit->content}}</textarea>
    </div>

    <div class="mb-3">
        <label for="slug">Slug</label>
        <input type="text" name="slug" class="form-control" required value="{{$blogs_edit->slug}}">
    </div>

    <button class="btn btn-primary">Submit</button>
</form>
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('preview');
    CKEDITOR.replace('content');
</script>

@endsection
