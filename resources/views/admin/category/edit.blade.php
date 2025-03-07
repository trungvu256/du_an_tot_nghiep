@extends('admin.layouts.main')

@section('content')
<form action="{{ route('admin.update.cate', $categoryedit->id) }}" method="POST" enctype="multipart/form-data">
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
            <label for="name">Name Category</label>
            <input type="text" id="name" name="name" value="{{ old('name', $categoryedit->name) }}" class="form-control" placeholder="Enter category name">
            @error('name')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="parent_id">Category</label>
            <select name="parent_id" id="parent_id" class="form-control">
                <option value="0">-- Select Parent Category --</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ $categoryedit->parent_id == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Current Image</label>
            <div>
                <img id="currentImage" src="{{ asset('category/' . $categoryedit->image) }}" alt="Category Image" width="150" class="img-thumbnail">
            </div>
        </div>

        <div class="form-group">
            <label for="image">Change Image</label>
            <input type="file" id="image" name="image" class="form-control-file">
        </div>

        <div class="form-group mt-3">
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
    </div>
</form>
@endsection