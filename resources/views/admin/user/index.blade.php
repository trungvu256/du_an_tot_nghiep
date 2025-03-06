@extends('admin.layouts.main')
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
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Role</th>
            <th scope="col">Status</th> <!-- Thêm cột này -->
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
        <tr>
            <th scope="row">{{ $user->id }}</th>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->is_admin == 1 ? 'Admin' : 'User' }}</td>
            <td>
                @if($user->status == 1)
                <span class="badge badge-success">Hoạt động</span>
                @else
                <span class="badge badge-danger">Đã chặn</span>
                @endif
            </td>
            <td>
                <a href="{{ route('admin.edit.user', $user->id) }}" class="btn btn-warning">Edit</a>

                @if($user->status == 0)
                <a href="{{ route('admin.delete.user', $user->id) }}" class="btn btn-danger"
                    onclick="return confirm('Bạn có chắc chắn muốn chặn người dùng này không?')">
                    Chặn
                </a>
                @else
                <span class="text-muted">Đã khóa</span>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $users->links() }}
@endsection
