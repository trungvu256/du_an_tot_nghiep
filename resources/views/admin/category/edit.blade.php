@extends('admin.layout.master')
@section('content')
    <form action="{{ route('admin.update.cate',$categoryedit->id) }}" method="POST">
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
            </div>
            <div class="form-group">
                <label> Category</label>
                <select name="parent_id" class="form-control" id="">
                    <option value="0">Category</option>      
                    @foreach ($categories as $category)
                    <option {{ $category->id == $categoryedit->parent_id ? "selected" : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach         
                   
                </select>
            </div>
            <div class="form-group">
                <label for="">Active Category</label>
                <div class="form-check">
                    <input type="checkbox" name="active" {{ $categoryedit->active == 1 ? 'checked' : '' }} value="1" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Active</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" name="active" {{ $categoryedit->active == 0 ? 'checked' : '' }} value="0" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">No Active</label>
                </div>
            </div>
            <div class="from-group">
                <button type="submit" class="btn btn-primary">Edit</button>
            </div>

        </div>
        <!-- /.card-body -->
    </form>
@endsection
