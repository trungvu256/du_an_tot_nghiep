@extends('admin.main')
@section('content')

<a href="{{route('admin.cate')}}" class="btn btn-danger"><i class="bi bi-arrow-left"></i>
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
            <th>Tên danh mục</th>
            <th>Hình ảnh</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($categories as $category)
        <tr>
            <th>{{ $category->id }}</th>
            <td>{{ $category->name }}</td>
            <td><img src="{{ asset('category/' . $category->image) }}" width="70px" alt="">
            </td>
            <td>
                <form action="{{ route('admin.restore.cate', $category->id) }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-success" onclick="return confirm('Bạn muốn phục hồi')"><i class="bi bi-arrow-clockwise"></i>
                    </button>
                </form>

                <form action="{{ route('admin.foreDelete.cate', $category->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Xóa vĩnh viễn?')"><i class="bi bi-x-circle-fill"></i></button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{!! $categories->links() !!}

@endsection