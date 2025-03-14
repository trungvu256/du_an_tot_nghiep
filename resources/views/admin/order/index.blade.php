@extends('admin.layouts.main')

@section('content')
<div class="container mt-4">
    {{-- Thông báo --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Tiêu đề --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Danh sách đơn hàng</h4>
    </div>

    {{-- Bộ lọc trạng thái --}}
    @php
        $status = request('status'); // Lấy trạng thái từ URL
    @endphp
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link {{ $status === null ? 'active' : '' }}" href="{{ route('admin.order') }}">
                Tất cả
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $status == 0 ? 'active' : '' }}" href="{{ route('admin.order', ['status' => 0]) }}">
                Chưa xử lý giao hàng
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $status == 1 ? 'active' : '' }}" href="{{ route('admin.order', ['status' => 1]) }}">
                Chờ lấy hàng
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $status == 2 ? 'active' : '' }}" href="{{ route('admin.order', ['status' => 2]) }}">
                Đang giao hàng
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $status == 3 ? 'active' : '' }}" href="{{ route('admin.order', ['status' => 3]) }}">
                Chưa thanh toán
            </a>
        </li>
    </ul>

        {{-- Dropdown Lọc Trạng Thái --}}
        <form action="{{ route('orders.updateStatus',  $order->id) }}" method="POST">
            @csrf
            @method('POST') <!-- Hoặc PUT nếu muốn -->
            
            <label for="status" class="form-label">Cập nhật trạng thái giao hàng:</label>
            <select name="status" id="status" class="form-select">
                <option value="">-- Chọn trạng thái mới --</option>
                @foreach ([
                    'Chờ lấy hàng', 'Đã lấy hàng', 'Đang giao hàng', 'Chờ giao lại', 
                    'Đã giao hàng', 'Đang hoàn hàng', 'Chờ xác nhận hoàn hàng', 'Đã hoàn hàng', 'Đã hủy'] as $key => $label)
                    <option value="{{ $key }}" {{ $order->status == $key ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        
            <button type="submit" class="btn btn-success mt-2">Cập nhật</button>
        </form>
        
        

    {{-- Bảng danh sách đơn hàng --}}
    <div class="card mt-3">
        <div class="card-body">
            <table class="table table-hover text-center align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Mã đơn hàng</th>
                        <th>Ngày tạo</th>
                        <th>Khách hàng</th>
                        <th>Nguồn đơn</th>
                        <th>Thành tiền</th>
                        <th>Trạng thái thanh toán</th>
                        <th>Trạng thái xử lý</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td><a href="{{ route('admin.show.order', $order->id) }}">#{{ $order->id }}</a></td>
                            <td>{{ $order->created_at ? $order->created_at->format('d/m/Y H:i') : '---' }}</td>
                            <td>{{ $order->customer_name ?? '---' }}</td>
                            <td><span class="badge bg-secondary">Website</span></td>
                            <td>{{ number_format($order->total_amount, 0, ',', '.') }}₫</td>
                            <td>
                                @if ($order->payment_status == 0)
                                    <span class="badge bg-warning">Chưa thanh toán</span>
                                @elseif ($order->payment_status == 1)
                                    <span class="badge bg-success">Đã thanh toán</span>
                                @else
                                    <span class="badge bg-danger">Thất bại</span>
                                @endif
                            </td>
                            <td>
                                @if ($order->status == 0)
                                    <span class="badge bg-warning">Chưa xử lý giao hàng</span>
                                @elseif ($order->status == 1)
                                    <span class="badge bg-info">Chờ lấy hàng</span>
                                @elseif ($order->status == 2)
                                    <span class="badge bg-primary">Đang giao hàng</span>
                                @else
                                    <span class="badge bg-secondary">Khác</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Phân trang --}}
            <div class="d-flex justify-content-end">
                {{ $orders->appends(['status' => $status])->links() }}
            </div>
        </div>
    </div>
</div>
@endsection