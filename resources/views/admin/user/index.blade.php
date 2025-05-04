@extends('admin.layouts.main')

@section('styles')
<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

<style>
    .avatar-md {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border: 2px solid #e0e0e0;
    }

    .bg-pink {
        background-color: #e83e8c;
        color: white;
    }

    .bg-purple {
        background-color: #6f42c1;
        color: white;
    }

    .gap-2 {
        gap: 0.5rem;
    }

    .btn-rounded {
        border-radius: 50px;
    }
</style>
@endsection

@section('content')
<div class="content-wrapper-scroll">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-sm-12 col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="card-title">
                            <h4 class="mb-0"><i class="fa-solid fa-users me-2"></i>Quản lý Người Dùng</h4>
                        </div>
                        <div>
                            <a href="{{ route('admin.create.user') }}" class="btn btn-primary btn-rounded d-flex align-items-center">
                                <i class="bi bi-plus-circle me-2"></i> Thêm mới
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Tìm kiếm và bộ lọc -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <form action="{{ route('admin.user') }}" method="GET" id="filter-form">
                                    <div class="d-flex flex-wrap gap-2">
                                        <div class="input-group" style="max-width: 400px;">
                                            <input type="text" class="form-control" placeholder="Tìm kiếm theo tên hoặc email..." name="search" value="{{ request()->search ?? '' }}">
                                            <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
                                        </div>
                                        <select class="form-select filter-select" name="role" style="max-width: 200px;">
                                            <option value="">-- Vai trò --</option>
                                            <option value="1" {{ request()->role == '1' ? 'selected' : '' }}>Quản trị viên</option>
                                            <option value="0" {{ request()->role == '0' ? 'selected' : '' }}>Người dùng</option>
                                        </select>
                                        <select class="form-select filter-select" name="status" style="max-width: 200px;">
                                            <option value="">-- Trạng thái --</option>
                                            <option value="1" {{ request()->status == '1' ? 'selected' : '' }}>Hoạt động</option>
                                            <option value="0" {{ request()->status == '0' ? 'selected' : '' }}>Đã khóa</option>
                                        </select>
                                        {{-- <button type="submit" class="btn btn-primary"><i class="bi bi-filter me-1"></i> Lọc</button> --}}
                                        <a href="{{ route('admin.user') }}" class="btn btn-outline-secondary"><i class="bi bi-x-circle me-1"></i> Xóa bộ lọc</a>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-bordered">
                                <thead class="table-light">
                                    <tr class="align-middle text-center">
                                        <th class="text-nowrap" width="5%"><i class="fas fa-id-badge me-1"></i> ID</th>
                                        <th class="text-nowrap" width="7%"><i class="fas fa-image me-1"></i> Ảnh</th>
                                        <th class="text-nowrap"><i class="fas fa-user me-1"></i> Họ và tên</th>
                                        <th class="text-nowrap"><i class="fas fa-envelope me-1"></i> Email</th>
                                        <th class="text-nowrap" width="8%"><i class="fas fa-venus-mars me-1"></i> Giới tính</th>
                                        <th class="text-nowrap"><i class="fas fa-phone me-1"></i> Số điện thoại</th>
                                        <th class="text-nowrap"><i class="fas fa-map-marker-alt me-1"></i> Địa chỉ</th>
                                        <th class="text-nowrap" width="10%"><i class="fas fa-user-shield me-1"></i> Vai trò</th>
                                        <th class="text-nowrap" width="9%"><i class="fas fa-toggle-on me-1"></i> Trạng thái</th>
                                        <th class="text-nowrap" width="15%"><i class="fas fa-cogs me-1"></i> Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                    <tr>
                                        <td class="text-center">{{ $user->id }}</td>
                                        <td class="text-center">
                                            <div class="avatar-wrapper">
                                                <img src="{{ asset('storage/' . $user->avatar) }}" class="rounded-circle avatar-md" alt="{{ $user->name }}" onerror="this.src='{{ asset('images/default-avatar.png') }}'">
                                            </div>
                                        </td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td class="text-center">
                                            @if ($user->gender == 'Male')
                                                <span class="badge bg-primary"><i class="fas fa-mars me-1"></i> Nam</span>
                                            @elseif ($user->gender == 'Female')
                                                <span class="badge bg-pink"><i class="fas fa-venus me-1"></i> Nữ</span>
                                            @elseif ($user->gender == 'Other')
                                                <span class="badge bg-purple"><i class="fas fa-genderless me-1"></i> Khác</span>
                                            @else
                                                <span class="badge bg-secondary"><i class="fas fa-question me-1"></i> Không xác định</span>
                                            @endif
                                        </td>
                                        <td>{{ $user->phone ?? 'N/A' }}</td>
                                        <td>{{ Str::limit($user->address, 30) ?? 'N/A' }}</td>
                                        <td class="text-center">
                                            <span class="badge {{ $user->is_admin == 1 ? 'bg-info' : 'bg-secondary' }}">
                                                <i class="fas {{ $user->is_admin == 1 ? 'fa-user-shield' : 'fa-user' }} me-1"></i>
                                                {{ $user->is_admin == 1 ? 'Quản trị viên' : 'Người dùng' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @if($user->status == 1)
                                                <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i> Hoạt động</span>
                                            @else
                                                <span class="badge bg-danger"><i class="fas fa-ban me-1"></i> Đã khóa</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center align-items-center gap-2">
                                                <a href="{{ route('admin.edit.user', $user->id) }}"
                                                    class="btn btn-warning btn-sm d-flex align-items-center">
                                                    <i class="fas fa-edit me-1"></i> Sửa
                                                </a>

                                                @if($user->status == 0)
                                                    <form action="{{ route('admin.unban.user', $user->id) }}" method="GET"
                                                        class="d-inline unlock-form">
                                                        <button type="submit" class="btn btn-success btn-sm unlock-btn">
                                                            <i class="fas fa-unlock me-1"></i> Mở khóa
                                                        </button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('admin.delete.user', $user->id) }}" method="GET"
                                                        class="d-inline delete-form">
                                                        <button type="submit" class="btn btn-danger btn-sm delete-btn">
                                                            <i class="fas fa-lock me-1"></i> Khóa
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center mt-4">
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Bootstrap 5 JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Bổ sung xử lý Ajax cho form tìm kiếm và lọc
document.addEventListener('DOMContentLoaded', function() {
    // Xử lý khi thay đổi các select để tự động submit form
    document.querySelectorAll('.filter-select').forEach(select => {
        select.addEventListener('change', function() {
            document.getElementById('filter-form').submit();
        });
    });
});

document.querySelectorAll('.delete-btn').forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();
        const form = this.closest('.delete-form');
        Swal.fire({
            title: 'Bạn có chắc chắn muốn khoá tài khoản này?',
            text: 'Người dùng sẽ không thể đăng nhập vào hệ thống',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Có, khóa tài khoản',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});

document.querySelectorAll('.unlock-btn').forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();
        const form = this.closest('.unlock-form');
        Swal.fire({
            title: 'Bạn có chắc chắn muốn mở khóa tài khoản này?',
            text: 'Người dùng sẽ có thể đăng nhập vào hệ thống',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Có, mở khóa',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>

@include('alert')
@endsection
