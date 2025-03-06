@extends('admin.main')
@section('content')
<form action="{{ route('admin.update.cate',$categoryedit->id) }}" method="POST">
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
            <input type="text" value="{{ $categoryedit->name }}" name="name" class="form-control" placeholder="Enter category name">
            @error('name')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label> Category</label>
            <select name="parent_id" class="form-control" id="">
                <option value="0">Category</option>
                @foreach($categories as $category)
                <option
                    value="{{ $category->id }}"
                    {{ isset($categoryedit) && $categoryedit->parent_id == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
                @endforeach
            </select>
            @error('parent_id')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="from-group">
            <button type="submit" class="btn btn-primary">Edit</button>
        </div>

    </div>
    <!-- /.card-body -->
</form>
@endsection