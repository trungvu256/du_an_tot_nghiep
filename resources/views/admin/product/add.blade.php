@extends('admin.layout.master')
@section('content')
    <form action="{{ route('admin.store.product') }}" method="POST" enctype="multipart/form-data">
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
                <label>Name Product</label>
                <input type="text" name="name" class="form-control" placeholder="Enter Name Product">
            </div>
            <div class="form-group">
                <label>Category</label>
                <select name="category_id" class="form-control" id="">
                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>     
                    @endforeach
                        
                </select>
            </div>
          
            <div class="form-group">
                <label>Cover Image</label>
                <input type="file" name="img" class="form-control" >
            </div>
            <div class="form-group">
                <label>Additional Image</label>
                <input type="file" name="images[]" multiple class="form-control" >
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" class="form-control ckeditor" id="" cols="6" rows="6"></textarea>
            </div>
            <div class="form-group">
                <label>Content</label>
                <textarea name="content" class="form-control ckeditor" id="" cols="6" rows="6"></textarea>
            </div>
            <div class="form-group">
                <label>Price Product</label>
                <input type="text" name="price" class="form-control" placeholder="Enter Price Product">
            </div>
            <div class="form-group">
                <label>Price Discount Product</label>
                <input type="text" name="price_sale" class="form-control" placeholder="Enter Discount Product">
            </div>     
            <div class="from-group">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>

        </div>
        <!-- /.card-body -->
    </form>
@endsection