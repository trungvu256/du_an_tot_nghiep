@extends('admin.main')
@section('content')
<table class="table">
    @if (session('success'))
    <div class="alert alert-success">
        <ul>
            <li>{{ session('success') }}</li>
        </ul>
    </div>
    @endif
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Image</th>
            <th scope="col">Price</th>
            <th scope="col">Category</th>

            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($products as $product)
        <tr>
            <th scope="row">{{ $product->id }}</th>
            <td>{{ $product->name }}</td>
            <td><img src="/cover/{{ $product->img }}" width="70px" alt=""></td>
            <td>{{ $product->price }}</td>
            <td>{{ $product->category->name }}</td>
            <td>
                <a href="{{ route('admin.edit.product',$product->id) }}" class="btn btn-warning">Edit</a>
                <form action="{{route('admin.delete.product', $product->id)}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn muốn xóa')"><i class="bi bi-x-square"></i>Delete</button>
                </form>
            </td>
        </tr>
        @endforeach

    </tbody>
</table>

{!! $products->links() !!}
@endsection