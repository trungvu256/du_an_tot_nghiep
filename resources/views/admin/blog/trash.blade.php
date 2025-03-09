@extends('admin.layouts.main')
@section('content')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <a href="{{route('admin.blog')}}"><i class="bi bi-skip-backward"></i></a>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Author</th>
                <th>Image</th>
                <th>Preview</th>
                <th>Content</th>
                <th>Slug</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($trashedBlogs as $blog)
                <tr>
                    <td>{{ $blog->id }}</td>
                    <td>{{ $blog->author }}</td>
                    <td>
                        <img src="/blog/{{ $blog->image }}" alt="" width="70px">
                    </td>
                    <td>{{ Str::limit($blog->preview, 50, '...') }}</td>
                    <td>{{ Str::limit($blog->content, 100, '...') }}</td>
                    <td>{{ $blog->slug }}</td>
                    <td>
                        <a href="{{ route('admin.restore.blog', $blog->id) }}" class="btn btn-success"><i class="bi bi-arrow-clockwise"></i></a>
                        <form action="{{ route('admin.forceDelete.blog', $blog->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn muốn xóa?')">
                                <i class="bi bi-x-circle"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $trashedBlogs->links() }}
@endsection
