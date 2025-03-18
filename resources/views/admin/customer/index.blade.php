@extends('admin.layouts.main')

@section('content')
<div class="container">
    <h2 class="mb-4 text-primary"><i class="bi bi-people"></i> Danh sách nhóm khách hàng</h2>

    <!-- Hiển thị thông báo -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm p-4">
        <table class="table table-hover table-bordered text-center">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th><i class="bi bi-list-stars"></i> Tên nhóm</th>
                   <th> Số lượng</th>
                    <th><i class="bi bi-info-circle"></i> Mô tả</th>
                    <th><i class="bi bi-tools"></i> Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customerGroups as $group)
                    <tr>
                        <td>{{ $group->id }}</td>
                        <td>
                            <a href="{{ route('customer.show_customers', $group->id) }}" class="text-primary fw-bold d-inline-flex align-items-center">
                                <i class="bi bi-people-fill me-1"></i> {{ $group->name }}
                            </a>
                        </td>
                        
                        <td>{{ $group->users_count }}</td>
                        <td>{{ $group->description }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <!-- Chỉnh sửa -->
                                <a href="{{ route('customer.edit', $group->id) }}" class="btn btn-warning btn-sm d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                    <i class="bi bi-pencil-square fs-5"></i>
                                </a>
                            
                                <!-- Xóa nhóm -->
                                <form action="{{ route('customer.destroy', $group->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa nhóm này không?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                        <i class="bi bi-trash-fill fs-5"></i>
                                    </button>
                                </form>
                            
                                <!-- Thêm khách hàng vào nhóm -->
<a href="{{ route('customer.assign_customers', $group->id) }}" class="btn btn-info btn-sm d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                    <i class="bi bi-person-plus-fill fs-5"></i>
                                </a>
                            </div>
                            
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Nút thêm nhóm khách hàng -->
    <a href="{{ route('customer.create') }}" class="btn btn-primary mt-3">
        <i class="bi bi-plus-circle-fill"></i> Thêm nhóm khách hàng
    </a>
</div>

<!-- Bootstrap Icons -->
@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
@endpush

@endsection