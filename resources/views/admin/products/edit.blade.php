@extends('web.layouts.master')
@section('content')
    <h3>
       Cập nhật
    </h3>

    <form action="{{route('admin.update', $product->id)}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">Name</label>
          <input type="text" class="form-control" name="name" value="{{old('name') ?? $product->name}}">
          @error('name')
            <span>{{ $message}}</span>
          @enderror
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Description</label>
            <input type="text" class="form-control" name="description" value="{{old('description') ?? $product->description}}">
            
          </div>
          <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Price</label>
            <input type="text" class="form-control" name="price" value="{{old('price') ?? $product->price}}">
            @error('price')
            <span>{{ $message}}</span>
          @enderror
          </div>
          <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Price_sale</label>
            <input type="text" class="form-control" name="price_sale" value="{{old('price_sale') ?? $product->price_sale}}">
            
          </div>
          <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Img</label><br>
            <img src="{{ Storage::url($product->img)}}" alt="" width="80">
            <input type="file" class="form-control" name="img">
            
          </div>

          <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">content</label>
            <input type="text" class="form-control" name="content" value="{{old('content') ?? $product->content}}">
            
          </div>
          <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Slug</label>
            <input type="text" class="form-control" name="slug" value="{{old('slug') ?? $product->slug}}">
            
          </div>
          <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Views</label>
            <input type="text" class="form-control" name="views" value="{{old('views') ?? $product->views}}">
            
          </div>

          <div class="mb-3">
            <label for="" class="form-lable">Category Name</label>
            <select name="category_id" class="form-control">
                @foreach ($categories as $cate)
                    <option value="{{ $cate->id }}" {{ $cate->id == old('category_id', $product->category_id) ? 'selected' : '' }}>
                        {{ $cate->name }}
                    </option>
                @endforeach
            </select>            
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
      </form>
@endsection