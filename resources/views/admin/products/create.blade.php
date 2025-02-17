@extends('web.layouts.master')
@section('content')
    <h3>
        Thêm mới
    </h3>

    <form action="" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">Name</label>
          <input type="text" class="form-control" name="name">
          @error('name')
            <span>{{ $message}}</span>
          @enderror
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Description</label>
            <input type="text" class="form-control" name="description">
            
          </div>
          <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Price</label>
            <input type="text" class="form-control" name="price">
            @error('price')
            <span>{{ $message}}</span>
          @enderror
          </div>
          <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Price_sale</label>
            <input type="text" class="form-control" name="price_sale">
            
          </div>
          <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Img</label>
            <input type="file" class="form-control" name="img">
            
          </div>

          <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">content</label>
            <input type="text" class="form-control" name="content">
            
          </div>
          <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Slug</label>
            <input type="text" class="form-control" name="slug">
            
          </div>
          <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Views</label>
            <input type="text" class="form-control" name="views">
            
          </div>

          <div class="mb-3">
            <label for="" class="form-lable">Category Name</label>
            <select name="category_id" id="" class="form-control">
                @foreach ($categories as $cate)
                    <option value="{{$cate->id}}">{{$cate->name}}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
@endsection