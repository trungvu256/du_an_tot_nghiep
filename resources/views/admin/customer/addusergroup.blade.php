@extends('admin.layouts.main')

@section('content')
<div class="container">
    <h2 class="mb-4">Thêm khách hàng vào nhóm: <span class="text-primary">{{ $group->name }}</span></h2>

    <div class="card shadow-sm p-4">
        <form action="{{ route('customer.store_assigned_customers', $group->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="users" class="form-label fw-bold">Chọn khách hàng</label>
                <select class="form-select select2" id="users" name="users[]" multiple required>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">
                            {{ $user->name }} ({{ $user->email }}) - 
                            Tổng mua: {{ number_format($user->orders_sum_total_price, 2) }} VNĐ, 
                            Số đơn hàng: {{ $user->orders_count }}
                        </option>
                    @endforeach
                </select>
            </div>
        
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-user-plus"></i> Thêm vào nhóm
                </button>
                <a href="{{ route('customer.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Hủy
                </a>
            </div>
        </form>
        

        <!-- Phân trang -->
        <div class="mt-4">
            {{ $users->links('pagination::bootstrap-4') }} <!-- Sử dụng phân trang Bootstrap -->
        </div>
    </div>
</div>

<!-- Nhúng Select2 và tùy chỉnh giao diện -->
@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">
    <style>
        .select2-container .select2-selection--multiple {
            height: auto !important;
            border-radius: 8px;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #007bff;
            color: white;
            border-radius: 5px;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Chọn khách hàng...",
                allowClear: true
            });
        });
    </script>
@endpush

@endsection