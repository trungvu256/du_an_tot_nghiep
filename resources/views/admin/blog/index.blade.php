
@extends('admin.layout.master')
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
                <th scope="col">Author</th>
                <th scope="col">Title</th>
                <th scope="col">Image</th>
                <th scope="col">Preview</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($blogs as $blog)
            <tr>
                <td>{{ $blog->id }}</td>
                <td>{{ $blog->author }}</td>
                <td>{{ $blog->title }}</td>
                <td><img src="blog/{{ $blog->image }}" width="70px" alt=""></td>
                <td>{!! $blog->preview !!}</td>
                <td>
                    <a href="{{ route('admin.edit.blog',$blog->id) }}" class="btn btn-warning">Edit</a>
                    <a href="{{ route('admin.delete.blog',$blog->id) }}" class="btn btn-success">Delete</a>
                </td>
            </tr>
            @endforeach
            
        </tbody>
          
    </table>
@endsection

