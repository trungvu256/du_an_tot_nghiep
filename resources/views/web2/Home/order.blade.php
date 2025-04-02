@extends('web2.layout.master')

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
            <h4 class="fw-bold">📦 Danh sách đơn hàng</h4>
        </div>
        {{-- Thanh tìm kiếm --}}
        <div class="mb-3">
            <form action="{{ route('admin.order') }}" method="GET" class="d-flex">
                <input type="text" name="query" class="form-control rounded-pill shadow-sm me-2 px-3"
                    placeholder="🔍 Nhập mã đơn hoặc SĐT khách hàng" value="{{ request('query') }}">
                <button type="submit" class="btn btn-primary rounded-pill px-4">Tìm kiếm</button>
            </form>
        </div>

        {{-- Thanh trạng thái --}}
        @php
            $status = request('status');
            $payment_status = request('payment_status');
        @endphp

        {{-- Form cập nhật trạng thái --}}
        <form action="{{ route('orders.updateStatus') }}" method="POST" id="bulk-update-form">
            @csrf
            <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap">
                {{-- Tabs chuyển trạng thái --}}
                <ul class="nav nav-tabs flex-grow-1">
                    <li class="nav-item">
                        <a class="nav-link {{ is_null($status) && is_null($payment_status) ? 'active' : '' }}"
                            href="{{ route('admin.order') }}">
                            🛒 Tất cả
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $status == 0 && is_null($payment_status) ? 'active' : '' }}"
                            href="{{ route('admin.order', ['status' => 0]) }}">
                            ⏳ Chưa xử lý
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $status == 1 && is_null($payment_status) ? 'active' : '' }}"
                            href="{{ route('admin.order', ['status' => 1]) }}">
                            📦 Chờ lấy hàng
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $status == 2 && is_null($payment_status) ? 'active' : '' }}"
                            href="{{ route('admin.order', ['status' => 2]) }}">
                            🚚 Đang giao hàng
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ is_null($status) && $payment_status === '0' ? 'active' : '' }}"
                            href="{{ route('admin.order', ['payment_status' => 0]) }}">
                            💰 Chưa thanh toán
                        </a>
                    </li>
                </ul>
        
                {{-- Dropdown và nút cập nhật --}}
                <div class="d-flex align-items-center ms-auto mt-2 mt-md-0">
                    <select name="status" class="form-select form-select-sm me-2" id="bulk-status" style="width: 180px;">
                        <option value="0">Chờ xử lý</option>
                        <option value="1">Chờ lấy hàng</option>
                        <option value="2">Đơn vị vận chuyển đã lấy hàng</option>
                        <option value="3">Đang giao</option>
                        <option value="4">Đã giao</option>
                        <option value="5">Hoàn tất</option>
                        <option value="6">Đã hủy</option>
                    </select>
        
                    <input type="hidden" name="order_ids" id="selected-orders">
                    <button type="submit" class="btn btn-primary btn-sm px-3">Cập nhật</button>
                </div>
            </div>
        </form>

        {{-- Bảng danh sách đơn hàng --}}
        <div class="card mt-3 shadow-sm">
            <div class="card-body">
                <table class="table table-hover text-center align-middle">
                    <thead class="table-light">
                        <tr>
                            <th><input type="checkbox" id="select-all"></th>
                            <th>Mã đơn</th>
                            <th>Ngày tạo</th>
                            <th>Khách hàng</th>
                            <th>Thành tiền</th>
                            <th>Trạng thái thanh toán</th>
                            <th>Trạng thái xử lý</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr onclick="window.location='{{ route('admin.show.order', $order->id) }}';" style="cursor: pointer;">
                                <td>
                                    <input type="checkbox" name="order_ids[]" value="{{ $order->id }}" class="order-checkbox">
                                </td>
                                <td>WD{{ $order->id }}</td>
                                <td>{{ $order->created_at ? $order->created_at->format('d/m/Y H:i') : '---' }}</td>
                                <td>{{ $order->user->name ?? '---' }}</td>
                                <td>{{ number_format($order->total_price, 0, ',', '.') }}₫</td>
                                <td>
                                    @if ($order->payment_status == 0)
                                        <span class="badge bg-warning text-dark">🟡 Tiếp tục thanh toán</span>
                                        <div class="mt-1">
                                            <a href="{{ route('order.continuePayment', $order->id) }}" class="btn btn-sm btn-primary">
                                                Thanh toán ngay
                                            </a>
                                        </div>
                                    @elseif ($order->payment_status == 1)
                                        <span class="badge bg-success">🟢 Đã thanh toán</span>
                                    @else
                                        <span class="badge bg-danger">🔴 Thất bại</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($order->status == 0)
                                        <span class="badge bg-secondary">⏳ Chờ xử lý</span>
                                    @elseif ($order->status == 1)
                                        <span class="badge bg-info">📦 Chờ lấy hàng</span>
                                    @elseif ($order->status == 2)
                                        <span class="badge bg-primary">🚚 Đơn vị vận chuyển đã lấy hàng</span>
                                    @elseif ($order->status == 3)
                                        <span class="badge bg-warning">🚛 Đang giao</span>
                                    @elseif ($order->status == 4)
                                        <span class="badge bg-success">✅ Đã giao</span>
                                    @elseif ($order->status == 5)
                                        <span class="badge bg-dark">🏁 Hoàn tất</span>
                                    @elseif ($order->status == 6)
                                        <span class="badge bg-danger">❌ Đã hủy</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Phân trang --}}
                <div class="d-flex justify-content-end">
                    {{ $orders->appends(['status' => $status, 'payment_status' => $payment_status])->links() }}
                </div>
            </div>
        </div>
    </div>
    {{-- Script cập nhật danh sách đơn hàng được chọn --}}
    <script>
        document.getElementById('select-all').addEventListener('click', function() {
            let checkboxes = document.querySelectorAll('.order-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateSelectedOrders();
        });

        document.querySelectorAll('.order-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', updateSelectedOrders);
        });

        function updateSelectedOrders() {
            let selectedOrders = [];
            document.querySelectorAll('.order-checkbox:checked').forEach(checkbox => {
                selectedOrders.push(checkbox.value);
            });
            document.getElementById('selected-orders').value = selectedOrders.join(',');
        }
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const checkboxes = document.querySelectorAll(".order-checkbox");
            const selectedOrdersInput = document.getElementById("selected-orders");
            const form = document.getElementById("bulk-update-form");
        
            // Khi form submit, cập nhật danh sách đơn hàng đã chọn
            form.addEventListener("submit", function (event) {
                const selectedOrderIds = [];
        
                checkboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        selectedOrderIds.push(checkbox.value);
                    }
                });
        
                if (selectedOrderIds.length === 0) {
                    alert("❌ Vui lòng chọn ít nhất một đơn hàng để cập nhật!");
                    event.preventDefault(); // Ngăn chặn submit form
                    return;
                }
        
                // Cập nhật danh sách order_ids vào input ẩn
                selectedOrdersInput.value = selectedOrderIds.join(",");
            });
        });
    </script>
@endsection