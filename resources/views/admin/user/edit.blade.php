@extends('admin.layouts.main')

@section('content')
<div class="container mt-4">
    <div class="card shadow-lg">
        <div class="card-header">
            <h4 class="mb-0"><i class="fas fa-user-edit"></i> Chỉnh Sửa Thông Tin Người Dùng</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.update.user', $user->id) }}" method="POST">
                @csrf

                <!-- Hiển thị thông báo -->
                @if (session('success'))
                <div class="alert alert-success">
                    <ul>
                        <li>{{ session('success') }}</li>
                    </ul>
                </div>
                @endif

                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Thông tin người dùng -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>ID</label>
                            <input type="text" class="form-control" value="{{ $user->id }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Họ và Tên</label>
                            <input type="text" class="form-control" value="{{ $user->name }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" value="{{ $user->email }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Số Điện Thoại</label>
                            <input type="text" class="form-control" value="{{ $user->phone }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Địa Chỉ</label>
                            <input type="text" class="form-control" value="{{ $user->address }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Giới Tính</label>
                            <input type="text" class="form-control" value="{{ ucfirst($user->gender) }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Mật Khẩu</label>
                            <input type="text" class="form-control" value="********" readonly>
                        </div>
                    </div>
                </div>

                <hr>

                <!-- Chỉnh sửa Trạng thái tài khoản -->
                <div class="form-group">
                    <label>Trạng Thái Tài Khoản</label>
                    <div class="d-flex gap-3">
                        <div class="form-check">
                            <input type="radio" name="status" value="1" class="form-check-input"
                                {{ $user->status == 1 ? "checked" : "" }}>
                            <label class="form-check-label">Hoạt Động</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="status" value="0" class="form-check-input"
                                {{ $user->status == 0 ? "checked" : "" }}>
                            <label class="form-check-label">Bị Khóa</label>
                        </div>
                    </div>
                </div>

                <!-- Chỉnh sửa Vai trò -->
                <div class="form-group">
                    <label>Vai Trò</label>
                    <div class="d-flex gap-3">
                        <div class="form-check">
                            <input type="radio" name="is_admin" value="1" class="form-check-input"
                                {{ $user->is_admin == 1 ? "checked" : "" }}>
                            <label class="form-check-label">Admin</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="is_admin" value="0" class="form-check-input"
                                {{ $user->is_admin == 0 ? "checked" : "" }}>
                            <label class="form-check-label">User</label>
                        </div>
                    </div>
                </div>

                <!-- Nút cập nhật -->
                <div class="text-center mt-3">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Cập Nhật</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection