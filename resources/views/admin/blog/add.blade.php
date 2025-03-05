@extends('admin.main')
@section('content')

<form action="{{route('admin.store.blog')}}" method="post" enctype="multipart/form-data">
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>  
            @endforeach
        </ul>
    </div>
    @endif

    @csrf
    <div class="mb-3">
        <label for="author">Author</label>
        <input type="text" name="author" class="form-control">
    </div>

    <div class="mb-3">
        <label for="title">Title</label>
        <input type="text" name="title" class="form-control">
    </div>

    <div class="mb-3">
        <label for="image">Image</label>
        <input type="file" name="image" class="form-control">
    </div>

    <div class="mb-3">
        <label for="preview">Preview</label>
        <textarea name="preview" id="preview" class="form-control"></textarea>
    </div>

    <div class="mb-3">
        <label for="content">Content</label>
        <textarea name="content" id="content" class="form-control"></textarea>
    </div>

    <div class="mb-3">
        <label for="slug">Slug</label>
        <input type="text" name="slug" class="form-control" required>
    </div>

    <button class="btn btn-primary">Submit</button>
</form>

@endsection

@section('scripts')
<script src="https://cdn.ckeditor.com/4.25.1/full/ckeditor.js"></script>
<script>
    CKEDITOR.replace('preview');
    CKEDITOR.replace('content');
</script>
@endsection
