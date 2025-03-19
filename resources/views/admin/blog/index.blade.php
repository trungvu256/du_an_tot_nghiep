@extends('admin.layouts.main')
@section('content')
@if (session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif
<div class="d-flex align-items-center gap-2">
    <a href="{{ route('admin.create.blog') }}" class="btn btn-primary">
        + Thêm mới
    </a>
    <a href="{{ route('admin.trash.blog') }}" class="btn btn-warning d-flex align-items-center justify-content-center"
        style="width: 40px; height: 45px;">
        <i class="bi bi-trash-fill"></i>
    </a>
</div>



<table class="table">

    <thead>
        <tr>
            <th>ID</th>
            <th>Tác giả</th>
            <th>Hình ảnh</th>
            <th>Xem trước</th>
            <th>Hành động</th>

        </tr>
    </thead>
    <tbody>
        @foreach ($blogs as $blog)
        <tr>
            <td>{{ $blog->id }}</td>
            <td>{{ $blog->author }}</td>
            <td>
                <img src="/blog/{{ $blog->image }}" alt="" width="70px">
            </td>
            <td>{{ Str::limit($blog->preview, 50, '...') }}</td>
            <td>
                <a href="{{ route('admin.show.blog', $blog->id) }}" class="btn btn-primary"><i
                        class="bi bi-eye-fill"></i></a>
                <a href="{{ route('admin.edit.blog', $blog->id) }}" class="btn btn-warning"><i
                        class="bi bi-pencil-square"></i></a>
                <form action="{{ route('admin.delete.blog', $blog->id) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"
                        onclick="return confirm('Bạn muốn chuyển vào thùng rác?')">
                        <i class="bi bi-x-square"></i>
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $blogs->links() }}
@endsection