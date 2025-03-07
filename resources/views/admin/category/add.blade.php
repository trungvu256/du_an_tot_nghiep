@extends('admin.layouts.main')
@section('content')

<form action="{{ route('admin.store.cate') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if (session('success'))
    <div class="alert alert-success">
        <ul>
            <li>{{ session('success') }}</li>
        </ul>
    </div>
    @endif
    <div class="card-body">
        <div class="form-group">
            <label>Name Category</label>
            <input type="text" name="name" class="form-control" placeholder="Enter category name">
            @error('name')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label>Parent Category</label>
            <select name="parent_id" class="form-control">
                <option value="0">No Parent (Main Category)</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @if ($category->children->count() > 0)
                        @foreach ($category->children as $child)
                            <option value="{{ $child->id }}">-- {{ $child->name }}</option>
                        @endforeach
                    @endif
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label class="form-label">Images Category</label>
            <div class="upload-box" onclick="document.getElementById('imageInput').click();">
                <input type="file" id="imageInput" name="image" accept="image/*">
                <i class="bi bi-cloud-upload fs-1 text-secondary"></i>
            </div>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
</form>

@endsection
<?php
function showCategories($categories, $parent_id = 0, $char = '')
{
    foreach ($categories as $key => $item) {
        if ($item->parent_id == $parent_id) {
            echo '<option value="' . $item->id . '">' . $char . $item->name . '</option>';
            unset($categories[$key]);
            showCategories($categories, $item->id, $char . '--');
        }
    }
}
?>