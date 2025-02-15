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
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Role</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <th scope="row">{{ $user->id }}</th>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->is_admin == 1 ? "Admin" : "User" }}</td>
                    <td>
                        <a href="{{ route('admin.edit.user',$user->id) }}" class="btn btn-warning">Edit</a>
                        <a href="{{ route('admin.delete.user',$user->id) }}" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
   
    
@endsection
