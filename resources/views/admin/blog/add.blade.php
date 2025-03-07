@extends('admin.main')
@section('content')

<form action="{{route('admin.store.blog')}}" method="post" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
        <label for="author">Tác giả</label>
        <input type="text" name="author" class="form-control" value="{{ old('author') }}">
        @error('author')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="mb-3">
        <label for="title">Tiêu đề</label>
        <input type="text" name="title" class="form-control" value="{{ old('title') }}">
        @error('title')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="mb-3">
        <label for="image">Ảnh</label>
        <input type="file" name="image" class="form-control">
        @error('image')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="mb-3">
        <label for="preview">Mô tả ngắn</label>
        <textarea name="preview" id="preview" class="form-control">{{ old('preview') }}</textarea>
        @error('preview')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="mb-3">
        <label for="content">Nội dung</label>
        <textarea name="content" id="content" class="form-control">{{ old('content') }}</textarea>
        @error('content')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="mb-3">
        <label for="slug">Slug</label>
        <input type="text" name="slug" class="form-control" value="{{ old('slug') }}" required>
        @error('slug')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <button class="btn btn-primary">Submit</button>
</form>

<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#content'), {
            ckfinder: {
                uploadUrl: "{{ route('admin.upload.image') }}?_token={{ csrf_token() }}"
            }
        })
        .catch(error => {
            console.error(error);
        });
</script>
@endsection
