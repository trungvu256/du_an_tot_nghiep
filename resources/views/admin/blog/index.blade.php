@extends('admin.main')
@section('content')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Author</th>
                <th>Image</th>
                <th>Preview</th>
                <th>Content</th>
                <th>Slug </th>
                {{-- <th>Views</th> --}}
                <th>Action</th>
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
                    <td>{{ $blog->preview }}</td>
                    <td>{{ $blog->content }}</td>
                    <td>{{ $blog->slug }}</td>
                    {{-- <td>{{$blog->views}}</td>
                --}}
                    <td>
                        <a href="{{ route('admin.edit.blog', $blog->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('admin.delete.blog', $blog->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn muốn xóa')"><i
                                    class="bi bi-x-square"></i>Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $blogs->links() }}
@endsection
