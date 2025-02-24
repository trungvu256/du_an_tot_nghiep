@extends('admin.layout.master')
@section('content')
    <form action="{{ route('admin.store.blog') }}" method="POST" enctype="multipart/form-data">
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
                <label>Name Author</label>
                <input type="text" name="author" class="form-control" placeholder="Enter Name Author">
            </div>
            <div class="form-group">
                <label>Title</label>
                <input type="text" name="title" class="form-control" placeholder="Enter Title">
            </div>
          
            <div class="form-group">
                <label>Cover Image</label>
                <input type="file" name="image" class="form-control" >
            </div>
        
            <div class="form-group">
                <label>Preview</label>
                <textarea name="preview" class="form-control ckeditor" id="" cols="6" rows="6"></textarea>
            </div>
            <div class="form-group">
                <label>Content</label>
                <textarea name="content" class="form-control ckeditor" id="" cols="6" rows="6"></textarea>
            </div>    
            <div class="from-group">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>

        </div>
        <!-- /.card-body -->
    </form>
@endsection