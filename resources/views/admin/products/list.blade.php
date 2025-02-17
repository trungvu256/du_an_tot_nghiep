@extends('web.layouts.master')
@section('content')

@if(session('message'))
    <script>
        if (confirm("{{ session('message') }}")) {
            console.log("User clicked OK");
        } else {
            console.log("User clicked Cancel");
        }
    </script>
@endif


<div>
    <h3>Danh sách sản phẩm</h3>
    <table class="table">
        <a href="{{route('admin.create')}}" class="btn btn-primary ">Thêm +</a>
        <thead>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Content</th>
            <th>Price</th>
            <th>Price_sale</th>
            <th>Img</th>
            <th>Brand</th>
            <th>Slug</th>
            <th>created_at</th>
            <th>updated_at</th>
            <th>views</th>
            <th>Action </th>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{$product->id}}</td>
                    <td>{{$product->name}}</td>
                    <td>{{$product->description}}</td>
                    <td>{{$product->content}}</td>
                    <td>{{$product->price}}vnđ</td>
                    <td>{{$product->price_sale}}vnđ</td>
                    <td>
                        <img src="{{ Storage::url($product->img)}}" alt="" width="80">
                    </td>
                    <td>{{$product->category_name}}</td>
                    <td>{{$product->slug}}</td>
                    <td>{{$product->created_at}}</td>
                    <td>{{$product->updated_at}}</td>
                    <td>{{$product->views}}</td>
                    <td>
                       <div class="d-flex ">
                        <a href="{{route('admin.edit', $product->id)}}" class="btn btn-warning"><i class="bi bi-pencil-square"></i></a>
                        <form action="{{route('admin.destroy', $product->id)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn muốn xóa')"><i class="bi bi-x-square"></i></button>
                        </form>
                       </div>
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection