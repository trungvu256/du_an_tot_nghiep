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
            <th>#</th>
            <th>Name</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($categories as $category)
        <tr>
            <td>{{ $category['id'] }}</td>
            <td>{{ $category['name'] }}</td>
            <td>
                <a href="{{ url('admin/category/edit/' . $category['id']) }}" class="btn btn-warning">Edit</a>
                <a href="{{ url('admin/category/delete/' . $category['id']) }}" class="btn btn-danger">Delete</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection