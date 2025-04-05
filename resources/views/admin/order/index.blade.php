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
                        <option value="2">Đang giao</option>
                        <option value="3">Đã giao</option>
                        <option value="4">Hoàn tất</option>
                        <option value="5">Đã hủy</option>
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
                        @forelse ($orders as $order)
                            <tr onclick="window.location='{{ route('admin.show.order', $order->id) }}';" style="cursor: pointer;">
                                <td onclick="event.stopPropagation();">
                                    <input type="checkbox" name="order_ids[]" value="{{ $order->id }}" class="order-checkbox" data-status="{{ $order->status }}">
                                </td>
                                <td>WD{{ $order->id }}</td>
                                <td>{{ $order->created_at ? $order->created_at->format('d/m/Y H:i') : '---' }}</td>
                                <td>{{ $order->user->name ?? '---' }}</td>
                                <td>{{ number_format($order->total_price, 0, ',', '.') }}₫</td>
                                <td>
                                    @if ($order->payment_status == 0)
                                        <span class="badge bg-warning text-dark">🟡 Chưa thanh toán</span>
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
                                        <span class="badge bg-warning">🚛 Đang giao</span>
                                    @elseif ($order->status == 3)
                                        <span class="badge bg-success">✅ Đã giao</span>
                                    @elseif ($order->status == 4)
                                        <span class="badge bg-dark">🏁 Hoàn tất</span>
                                    @elseif ($order->status == 5)
                                        <span class="badge bg-danger">❌ Đã hủy</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Không có đơn hàng nào.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Phân trang --}}
                <div class="d-flex justify-content-end">
                    {{ $orders->appends(['status' => $status, 'payment_status' => $payment_status])->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- Script xử lý checkbox và cập nhật trạng thái --}}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const checkboxes = document.querySelectorAll(".order-checkbox");
            const selectAll = document.getElementById("select-all");
            const selectedOrdersInput = document.getElementById("selected-orders");
            const statusSelect = document.getElementById("bulk-status");
            const form = document.getElementById("bulk-update-form");

            // Cập nhật danh sách đơn hàng được chọn
            function updateSelectedOrders() {
                const selectedOrders = [];
                let maxStatus = -1;

                checkboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        selectedOrders.push(checkbox.value);
                        const orderStatus = parseInt(checkbox.dataset.status);
                        if (orderStatus > maxStatus) {
                            maxStatus = orderStatus;
                        }
                    }
                });

                selectedOrdersInput.value = selectedOrders.join(',');

                // Cập nhật các tùy chọn trạng thái trong dropdown
                statusSelect.querySelectorAll('option').forEach(option => {
                    const optionValue = parseInt(option.value);
                    option.disabled = (maxStatus >= 0 && optionValue <= maxStatus);
                });
            }

            // Sự kiện khi chọn tất cả
            selectAll.addEventListener('click', function () {
                checkboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                updateSelectedOrders();
            });

            // Sự kiện khi thay đổi checkbox
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateSelectedOrders);
            });

            // Kiểm tra khi submit form
            form.addEventListener('submit', function (event) {
                const selectedOrderIds = selectedOrdersInput.value.split(',').filter(id => id);

                if (selectedOrderIds.length === 0) {
                    alert('❌ Vui lòng chọn ít nhất một đơn hàng để cập nhật!');
                    event.preventDefault();
                    return;
                }

                const selectedStatus = parseInt(statusSelect.value);
                let invalidUpdate = false;

                checkboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        const currentStatus = parseInt(checkbox.dataset.status);
                        if (selectedStatus <= currentStatus) {
                            invalidUpdate = true;
                        }
                    }
                });

                if (invalidUpdate) {
                    alert('❌ Không thể cập nhật về trạng thái cũ hoặc thấp hơn!');
                    event.preventDefault();
                }
            });

            // Cập nhật ban đầu
            updateSelectedOrders();
        });
    </script>
@endsection