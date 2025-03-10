@extends('admin.layouts.main')
@section('content')
<form action="{{ route('admin.update.user', $user->id) }}" method="POST">
    @csrf
    <div class="card-body">
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

        <!-- Hiển thị thông tin người dùng (Chỉ đọc) -->
        <div class="form-group">
            <label>ID</label>
            <input type="text" class="form-control" value="{{ $user->id }}" readonly>
        </div>

        <div class="form-group">
            <label>Name</label>
            <input type="text" class="form-control" value="{{ $user->name }}" readonly>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" class="form-control" value="{{ $user->email }}" readonly>
        </div>

        <div class="form-group">
            <label>Phone</label>
            <input type="text" class="form-control" value="{{ $user->phone }}" readonly>
        </div>

        <div class="form-group">
            <label>Address</label>
            <input type="text" class="form-control" value="{{ $user->address }}" readonly>
        </div>

        <div class="form-group">
            <label>Gender</label>
            <input type="text" class="form-control" value="{{ ucfirst($user->gender) }}" readonly>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="text" class="form-control" value="********" readonly>
        </div>

        <!-- Chỉnh sửa Trạng thái tài khoản -->
        <div class="form-group">
            <label for="">Trạng Thái Tài Khoản</label>
            <div class="form-check">
                <input type="radio" name="status" value="1" class="form-check-input" 
                       {{ $user->status == 1 ? "checked" : "" }}>
                <label class="form-check-label">Tài Khoản Đang Hoạt Động</label>
            </div>
            <div class="form-check">
                <input type="radio" name="status" value="0" class="form-check-input" 
                       {{ $user->status == 0 ? "checked" : "" }}>
                <label class="form-check-label">Tài khoản Đang Bị Khóa</label>
            </div>
        </div>

        <!-- Chỉnh sửa Vai trò -->
        <div class="form-group">
            <label for="">Role Admin</label>
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

        <button type="submit" class="btn btn-primary">Update</button>
    </div>
</form>
@endsection
