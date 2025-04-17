@extends('admin.layouts.main')
@section('content')
<div class="content-wrapper-scroll">
    <div class="content-wrapper p-4">
        <div class="card border-0 rounded shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="card-title mb-3">Chỉnh sửa bài viết</div>
                <a href="{{ route('admin.blog') }}" class="btn btn-sm rounded-pill btn-secondary">
                    <i class="bi bi-arrow-left me-2"></i> Trở về
                </a>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.update.blog', $blogs_edit->id) }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="author" class="form-label fw-bold">Tác giả</label>
                                <input type="text" name="author" class="form-control rounded-pill" value="{{ old('author', $blogs_edit->author) }}">
                                @error('author')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="title" class="form-label fw-bold">Tiêu đề</label>
                                <input type="text" name="title" class="form-control rounded-pill" value="{{ old('title', $blogs_edit->title) }}">
                                @error('title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label fw-bold">Ảnh</label>
                        <input type="file" name="image" class="form-control rounded-pill">
                        @if ($blogs_edit->image)
                            <div class="mt-2">
                                <img src="{{ asset('blog/'.$blogs_edit->image) }}" alt="Ảnh bài viết" class="img-thumbnail" style="width: 150px; height: 150px; object-fit: cover;">
                            </div>
                        @endif
                        @error('image')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="preview" class="form-label fw-bold">Mô tả ngắn</label>
                        <textarea name="preview" id="preview" class="form-control rounded-3" rows="3">{{ old('preview', $blogs_edit->preview) }}</textarea>
                        @error('preview')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label fw-bold">Nội dung</label>
                        <textarea name="content" id="content" class="form-control rounded-3">{{ old('content', $blogs_edit->content) }}</textarea>
                        @error('content')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="slug" class="form-label fw-bold">Slug</label>
                        <input type="text" name="slug" class="form-control rounded-pill" value="{{ old('slug', $blogs_edit->slug) }}" required>
                        @error('slug')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary rounded-pill px-4">
                            <i class="bi bi-check-circle me-2"></i>Cập nhật bài viết
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

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

@section('scripts')
    @include('alert')
@endsection
