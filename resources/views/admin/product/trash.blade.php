@extends('admin.main')
@section('content')

<a href="{{route('admin.product')}}" class="btn btn-danger"><i class="bi bi-arrow-left"></i>
</a>

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
            <th>#</th>
            <th>Tên sản phẩm</th>
            <th>Hình ảnh</th>
            <th>Danh mục</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($products as $product)
        <tr>
            <th>{{ $product->id }}</th>
            <td>{{ $product->name }}</td>
            <td><img src="/cover/{{ $product->img }}" width="70px" alt=""></td>
            <td>{{ $product->category->name }}</td>
            <td>
                <form action="{{ route('admin.restore.product', $product->id) }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-success"><i class="bi bi-arrow-clockwise"></i>
                    </button>
                </form>

                <form action="{{ route('admin.foreDelete.product', $product->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Xóa vĩnh viễn?')"><i class="bi bi-x-circle-fill"></i></button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{!! $products->links() !!}

@endsection
