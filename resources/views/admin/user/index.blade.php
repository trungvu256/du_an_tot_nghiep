@extends('admin.layouts.main')
@section('content')
<div class="container mt-4">
    @if (session('success'))
    <div class="alert alert-success">
        <ul>
            <li>{{ session('success') }}</li>
        </ul>
    </div>
    @endif
    <div class="card">
        <div class="card-header">
            <h4 class="mb-0"><i class="fa-solid fa-user"></i> Quản lý Người Dùng</h4>


        </div>
        <div class="card-body">
            <table class="table table-bordered text-center align-middle">
                <thead class="table-light">
                    <tr class="align-middle">
                        <th class="text-nowrap"><i class="fas fa-id-badge"></i> ID</th>
                        <th class="text-nowrap"><i class="fas fa-image"></i> Ảnh đại diện</th>
                        <th class="text-nowrap"><i class="fas fa-user"></i> Họ và tên</th>
                        <th class="text-nowrap"><i class="fas fa-envelope"></i> Email</th>
                        <th class="text-nowrap"><i class="fas fa-venus-mars"></i> Giới tính</th>
                        <th class="text-nowrap"><i class="fas fa-phone"></i> Số điện thoại</th>
                        <th class="text-nowrap"><i class="fas fa-map-marker-alt"></i> Địa chỉ</th>
                        <th class="text-nowrap"><i class="fas fa-user-shield"></i> Vai trò</th>
                        <th class="text-nowrap"><i class="fas fa-toggle-on"></i> Trạng thái</th>
                        <th class="text-nowrap"><i class="fas fa-cogs"></i> Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>
                            <img src="{{ asset('storage/' . $user->avatar) }}" class="rounded-circle" width="50"
                                height="50">
                        </td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if ($user->gender == 'Male')
                            Nam
                            @elseif ($user->gender == 'Female')
                            Nữ
                            @elseif ($user->gender == 'Other')
                            Khác
                            @else
                            Không xác định
                            @endif
                        </td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->address }}</td>
                        <td>
                            <span class="badge {{ $user->is_admin == 1 ? 'bg-light text-dark' : 'bg-secondary' }}">
                                <i class="fas {{ $user->is_admin == 1 ? 'fa-user-shield' : 'fa-user' }}"></i>
                                {{ $user->is_admin == 1 ? 'Quản trị viên' : 'Người dùng' }}
                            </span>
                        </td>
                        <td>
                            @if($user->status == 1)
                            <span class="badge bg-success"><i class="fas fa-check-circle"></i> Hoạt động</span>
                            @else
                            <span class="badge bg-danger"><i class="fas fa-ban"></i> Đã khóa</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.edit.user', $user->id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Chỉnh sửa
                            </a>
                            @if($user->status == 0)
                            <a href="{{ route('admin.delete.user', $user->id) }}" class="btn btn-danger btn-sm"
                                onclick="return confirm('Bạn có chắc chắn muốn khóa người dùng này không?')">
                                <i class="fas fa-lock"></i> Khóa
                            </a>
                            @else
                            <a href="{{ route('admin.unban.user', $user->id) }}" class="btn btn-success btn-sm"
                                onclick="return confirm('Bạn có muốn bỏ khóa người dùng này không?')">
                                <i class="fas fa-unlock"></i> Bỏ khóa
                            </a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center mt-3">
                {{ $users->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
@endsection