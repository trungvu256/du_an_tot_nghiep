@extends('admin.layouts.main')

@section('title', 'Thêm Danh Mục')

{{-- @section('css')
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.0/dist/sweetalert2.min.css" rel="stylesheet">
@endsection --}}

@section('content')
<div class="content-wrapper-scroll">
    <div class="content-wrapper">

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="card-title">Thêm Mới Danh Mục</div>
                <a href="{{ route('catalogues.index') }}" class="btn btn-sm rounded-pill btn-secondary">
                    <i class="bi bi-arrow-left me-2"></i> Trở về
                </a>
            </div>
            {{-- @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
            @endforeach
            </ul>
        </div>
        @endif --}}

        <div class="card-body mt-4">
            <form action="{{ route('catalogues.store') }}" method="POST" enctype="multipart/form-data"
                id="catalogueForm">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="card-body">

                            <label for="name" class="form-label">Tên danh mục:</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
                            @error('name')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror

                        </div>

                        <div class="card-body">
                            <label for="parent_id" class="form-label">Danh mục cha:</label>
                            <select name="parent_id" id="parent_id" class="form-select">
                                <option value="">Chọn danh mục cha</option>
                                @foreach ($parentCatalogues as $parentCatalogue)
                                <option value="{{ $parentCatalogue->id }}"
                                    {{ old('parent_id') == $parentCatalogue->id ? 'selected' : '' }}>
                                    {{ $parentCatalogue->name }}
                                </option>
                                @if ($parentCatalogue->children->isNotEmpty())
                                @include('admin.catalogues.category_options', [
                                'categories' => $parentCatalogue->children,
                                'prefix' => '--- ',
                                ])
                                @endif
                                @endforeach
                            </select>
                            @error('parent_id')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="card-body">
                            <label for="image" class="form-label">Hình ảnh:</label>
                            <input type="file" name="image" id="image" class="form-control"
                                onchange="previewImage(event)">
                            <img id="imagePreview" src="{{ old('image') ? asset('storage/' . old('image')) : '' }}"
                                alt="Hình ảnh xem trước" class="mt-2"
                                style="display: {{ old('image') ? 'block' : 'none' }}; width: 100px;">

                            @error('image')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" id="submitButton" class="btn rounded-pill btn-primary mt-3">
                            Thêm danh mục
                        </button>
                    </div>

                    <div class="col-md-6">
                        <div class="card-body">

                            <label for="description" class="form-label">Mô tả:</label>
                            <textarea name="description" id="description"
                                class="form-control">{{ old('description') }}</textarea>
                            @error('description')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror

                        </div>

                        <div class="card-body">
                            <label class="form-label fw-bold">Trạng thái:</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="active" value="active"
                                    {{ old('status') == 'active' ? 'checked' : '' }}>
                                <label class="form-check-label" for="active">Kích hoạt</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="inactive"
                                    value="inactive" {{ old('status') == 'inactive' ? 'checked' : '' }}>
                                <label class="form-check-label" for="inactive">Không kích hoạt</label>
                            </div>
                            @error('status')
                            <div class="text-danger mt-2 small">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
</div>

<script>
function previewImage(event) {
    const imagePreview = document.getElementById('imagePreview');
    const file = event.target.files[0];

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            imagePreview.src = e.target.result;
            imagePreview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    } else {
        imagePreview.src = '';
        imagePreview.style.display = 'none';
    }
}
</script>
@include('alert')
@endsection
