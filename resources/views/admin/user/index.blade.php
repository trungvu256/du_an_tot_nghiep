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
            <th>ID</th>
            <th>Avatar</th>
            <th>Name</th>
            <th>Email</th>
            <th>Gender</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Role</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>
                <img src="{{ asset('storage/' . $user->avatar) }}" class="img-thumbnail" width="50" height="50">
            </td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ ucfirst($user->gender) }}</td>
            <td>{{ $user->phone }}</td>
            <td>{{ $user->address }}</td>
            <td>{{ $user->is_admin == 1 ? 'Admin' : 'User' }}</td>
            <td>
                @if($user->status == 1)
                <span class="badge badge-success">Hoạt động</span>
                @else
                <span class="badge badge-danger">Đã khóa</span>
                @endif
            </td>
            <td>
                <a href="{{ route('admin.edit.user', $user->id) }}" class="btn btn-warning">Edit</a>
                @if($user->status == 0)
                <a href="{{ route('admin.delete.user', $user->id) }}" class="btn btn-danger"
                    onclick="return confirm('Bạn có chắc chắn muốn khóa người dùng này không?')">
                    khóa
                </a>
                @else
                <a href="{{ route('admin.unban.user', $user->id) }}" class="btn btn-success"
                    onclick="return confirm('Bạn có muốn bỏ khóa người dùng này không?')">
                    Bỏ khóa
                </a>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
