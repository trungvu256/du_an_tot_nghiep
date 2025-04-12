@extends('admin.layouts.main')

@section('content')
    <div class="container mt-4">

        {{-- Tiêu đề --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold"> Danh sách đơn hàng</h4>
        </div>

        {{-- Thông báo --}}
        {{-- @if (session('success'))
            <div id="successAlert" class="alert alert-success alert-dismissible fade show text-center" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div id="successAlert" class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif --}}

        @php
            $status = request('status');
            $payment_status = request('payment_status');
        @endphp

        {{-- Form lọc đơn hàng --}}
        {{-- <div class="row mb-3">
            <div class="col-md-6">
                <form action="{{ route('admin.order') }}" method="GET" class="d-flex gap-2">
                    <select name="status" class="form-select">
                        <option value="">Tất cả trạng thái</option>
                        <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Chờ xử lý</option>
                        <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Chờ lấy hàng</option>
                        <option value="2" {{ request('status') == '2' ? 'selected' : '' }}>Đang giao</option>
                        <option value="3" {{ request('status') == '3' ? 'selected' : '' }}>Đã giao</option>
                        <option value="4" {{ request('status') == '4' ? 'selected' : '' }}>Hoàn tất</option>
                        <option value="5" {{ request('status') == '5' ? 'selected' : '' }}>Trả hàng</option>
                        <option value="6" {{ request('status') == '6' ? 'selected' : '' }}>Đã hủy</option>
                    </select>
                    <button type="submit" class="btn btn-primary">Lọc</button>
                    <a href="{{ route('admin.order') }}" class="btn btn-secondary">Xóa bộ lọc</a>
                </form>
            </div>
        </div> --}}

        <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap">
            {{-- Tabs chuyển trạng thái --}}
            <ul class="nav nav-tabs flex-grow-1">
                <li class="nav-item">
                    <a class="px-1 nav-link {{ is_null($status) && is_null($payment_status) ? 'active' : '' }}"
                        href="{{ route('admin.order') }}">
                        🛒 Tất cả
                    </a>
                </li>
                <li class="nav-item">
                    <a class="px-1 nav-link {{ $status == 0 ? 'active' : '' }}"
                        href="{{ route('admin.order', ['status' => 0]) }}">
                        ⏳ Chờ xử lý
                    </a>
                </li>
                <li class="nav-item">
                    <a class="px-1 nav-link {{ $status == 1 ? 'active' : '' }}"
                        href="{{ route('admin.order', ['status' => 1]) }}">
                        📦 Chờ lấy hàng
                    </a>
                </li>
                <li class="nav-item">
                    <a class="px-1 nav-link {{ $status == 2 ? 'active' : '' }}"
                        href="{{ route('admin.order', ['status' => 2]) }}">
                        🚚 Đang giao
                    </a>
                </li>
                <li class="nav-item">
                    <a class="px-1 nav-link {{ $status == 3 ? 'active' : '' }}"
                        href="{{ route('admin.order', ['status' => 3]) }}">
                        ✅ Đã giao
                    </a>
                </li>
                <li class="nav-item">
                    <a class="px-1 nav-link {{ $status == 4 ? 'active' : '' }}"
                        href="{{ route('admin.order', ['status' => 4]) }}">
                        🏁 Hoàn tất
                    </a>
                </li>
                <li class="nav-item">
                    <a class="px-1 nav-link {{ $status == 5 ? 'active' : '' }}"
                        href="{{ route('admin.order', ['status' => 5]) }}">
                        ❌ Đã hủy
                    </a>
                </li>
                <li class="nav-item">
                    <a class="px-1 nav-link {{ $status == 6 ? 'active' : '' }}"
                        href="{{ route('admin.order', ['status' => 6]) }}">
                         ↩️ Trả hàng
                    </a>
                </li>
                {{-- <li class="nav-item">
                    <a class="px-1 nav-link {{ $payment_status === '0' && is_null($status) ? 'active' : '' }}"
                        href="{{ route('admin.order', ['payment_status' => 0]) }}">
                        💰 Chưa thanh toán
                    </a>
                </li> --}}
            </ul>
        </div>

        <div class="row d-flex justify-content-between">
            {{-- Thanh tìm kiếm --}}
            <div class="col-6 mb-3">
                <form action="{{ route('admin.order') }}" method="GET" class="d-flex">
                    <input type="text" name="query" class="form-control rounded-pill shadow-sm me-2 px-4 py-0"
                        placeholder="🔍 Nhập mã đơn hoặc SĐT khách hàng" value="{{ request('query') }}"
                        aria-label="Tìm kiếm đơn hàng">
                    <input type="submit" class="btn btn-outline-primary rounded-pill px-3 py-0" value="Tìm kiếm">
                </form>
            </div>

            {{-- Form cập nhật trạng thái --}}
            <form action="{{ route('orders.updateStatus') }}" method="POST" id="bulk-update-form" class="col-4">
                @csrf
                <div class="d-flex align-items-center ms-auto">
                    <div class="input-group input-group-sm">
                        {{-- Dropdown và nút cập nhật --}}
                        <select name="status" class="form-control form-select-sm me-2 rounded-pill text-center" id="statusSelect"
                            data-current-status="{{ $status }}" style="width: 180px;">
                            <option value="0" {{ $status == 0 ? 'selected' : '' }}>-- Chờ xử lý --</option>
                            <option value="1" {{ $status == 1 ? 'selected' : '' }}>-- Chờ lấy hàng --</option>
                            <option value="2" {{ $status == 2 ? 'selected' : '' }}>-- Đang giao --</option>
                            <option value="3" {{ $status == 3 ? 'selected' : '' }}>-- Đã giao --</option>
                            <option value="4" {{ $status == 4 ? 'selected' : '' }}>-- Hoàn tất --</option>
                            <option value="5" {{ $status == 5 ? 'selected' : '' }}>-- Trả hàng --</option>
                            <option value="6" {{ $status == 6 ? 'selected' : '' }}>-- Đã hủy --</option>
                        </select>
                        <input type="hidden" name="order_ids" id="selected-orders">
                        <button type="submit" class="btn btn-primary btn-sm px-4 rounded-pill">Cập nhật</button>
                    </div>
                </div>
            </form>
        </div>

        {{-- Bảng danh sách đơn hàng --}}
        <div class="card mt-2 shadow-sm">
            <div class="card-body">
                <table class="table table-hover text-center align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th>
                                <input type="checkbox" id="select-all">
                            </th>
                            <th>Mã đơn hàng</th>
                            <th>Khách hàng</th>
                            <th>Thành tiền</th>
                            <th>Trạng thái thanh toán</th>
                            <th>Trạng thái đơn hàng</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            <tr>
                                <td>
                                    <input type="checkbox" name="order_ids[]" value="{{ $order->id }}" class="order-checkbox">
                                </td>
                                <td>{{ $order->order_code }}</td>
                                <td>{{ $order->user->name ?? '---' }}</td>
                                <td>{{ number_format($order->total_price, 0, ',', '.') }} VNĐ</td>
                                <td>
                                    @if ($order->payment_status == 1)
                                        <span class="badge bg-success">🟢 Đã thanh toán</span>
                                    @elseif ($order->payment_status == 2)
                                        <span class="badge bg-info">🔵 Thanh toán khi nhận hàng</span>
                                    @endif
                                </td>
                                <td>
                                    @switch($order->status)
                                        @case(0)
                                            <span class="badge bg-warning">⏳ Chờ xử lý</span>
                                            @break
                                        @case(1)
                                            <span class="badge bg-info">📦 Chờ lấy hàng</span>
                                            @break
                                        @case(2)
                                            <span class="badge bg-secondary">🚚 Đang giao</span>
                                            @break
                                        @case(3)
                                            <span class="badge bg-success">✅ Đã giao</span>
                                            @break
                                        @case(4)
                                            <span class="badge bg-dark">🏁 Hoàn tất</span>
                                            @break
                                        @case(5)
                                            <span class="badge bg-danger">❌ Đã hủy</span>
                                            @break
                                        @case(6)
                                            <span class="badge bg-secondary">↩️ Trả hàng</span>
                                            @break
                                        @default
                                            <span class="badge bg-secondary">Không xác định</span>
                                    @endswitch
                                </td>
                                <td>
                                    <a href="{{ route('admin.show.order', $order->id) }}" class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i>
                                    </a>
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
                    {{ $orders->appends(['status' => request('status')])->links() }}
                </div>
            </div>
        </div>
    </div>


    {{-- Script xử lý checkbox và cập nhật trạng thái --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const checkboxes = document.querySelectorAll(".order-checkbox");
            const selectAll = document.getElementById("select-all");
            const selectedOrdersInput = document.getElementById("selected-orders");
            const statusSelect = document.getElementById("statusSelect");
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
                const validTransitions = {
                    0: [1, 6], // Chờ xử lý => Chờ lấy hàng, Đã hủy
                    1: [2, 6], // Chờ lấy hàng => Đang giao, Đã hủy
                    2: [3, 5], // Đang giao => Đã giao, Trả hàng
                    3: [4, 5], // Đã giao => Hoàn tất, Trả hàng
                    4: [], // Hoàn tất => Không chuyển tiếp
                    5: [6], // Trả hàng => Đã hủy
                    6: [] // Đã hủy => Không chuyển tiếp
                };

                const currentStatus = parseInt(statusSelect.dataset
                    .currentStatus); // Giả sử gán data-current-status trên thẻ <select>

                statusSelect.querySelectorAll('option').forEach(option => {
                    const optionValue = parseInt(option.value);

                    // Cho phép giữ nguyên trạng thái hiện tại
                    const isCurrent = optionValue === currentStatus;

                    // Cho phép nếu trạng thái nằm trong danh sách chuyển tiếp hợp lệ
                    const isValidTransition = validTransitions[currentStatus]?.includes(optionValue);

                    // Disable nếu không hợp lệ
                    option.disabled = !(isCurrent || isValidTransition);
                });
            }

            // Sự kiện khi chọn tất cả
            selectAll.addEventListener('click', function() {
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
            form.addEventListener('submit', function(event) {
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
@section('scripts')
@include('alert')
@endsection
