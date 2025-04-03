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


        {{-- Thanh trạng thái --}}
        @php
            $status = request('status');
            $payment_status = request('payment_status');
        @endphp

        {{-- Form cập nhật trạng thái --}}


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
                            <tr onclick="window.location='{{ route('donhang.show', $order->id) }}';"
                                style="cursor: pointer;">
                                <td>
                                    <input type="checkbox" name="order_ids[]" value="{{ $order->id }}"
                                        class="order-checkbox">
                                </td>
                                <td>WD{{ $order->id }}</td>
                                <td>{{ $order->created_at ? $order->created_at->format('d/m/Y H:i') : '---' }}</td>
                                <td>{{ $order->user->name ?? '---' }}</td>
                                <td>{{ number_format($order->total_price, 0, ',', '.') }}₫</td>
                                <td>
                                    @if ($order->payment_status == 0)
                                        <span class="badge bg-warning text-dark">🟡 Chưa thanh toán</span>
                                        <div class="mt-1">
                                            <a href="{{ route('order.continuePayment', $order->id) }}"
                                                class="btn btn-sm btn-primary">
                                                Thanh toán ngay
                                            </a>
                                        </div>
                                    @elseif ($order->payment_status == 1)
                                        <span class="badge bg-success">🟢 Đã thanh toán bằng vnpay</span>
                                    @elseif ($order->payment_status == 2)
                                        <span class="badge bg-success">🟢 Thanh toán khi nhận hàng</span>
                                    @else
                                        <span class="badge bg-danger">🔴 Thất bại</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($order->status == 0)
                                        <span class="badge bg-secondary">⏳ Chờ xác nhận</span>
                                        <a href="{{ route('order.cancel', $order->id) }}" class="btn btn-danger btn-sm mt-2" onclick="return confirm('Bạn chắc chắn muốn hủy đơn hàng này?')">Hủy đơn</a>
                                    @elseif ($order->status == 1)
                                        <span class="badge bg-info">📦 Chờ lấy hàng</span>
                                        <a href="{{ route('order.cancel', $order->id) }}" class="btn btn-danger btn-sm mt-2" onclick="return confirm('Bạn chắc chắn muốn hủy đơn hàng này?')">Hủy đơn</a>
                                    @elseif ($order->status == 2)
                                        <span class="badge bg-primary">🚚 Chờ giao hàng</span>
                                    @elseif ($order->status == 3)
                                        <span class="badge bg-warning">✅ Đang giao</span>
                                        <a href="{{ route('order.received', $order->id) }}" class="btn btn-success btn-sm mt-2" onclick="return confirm('Bạn đã nhận được hàng?')">Đã nhận được hàng</a>
                                    @elseif ($order->status == 4)
                                        <span class="badge bg-success">🚛 Trả hàng</span>
                                        <a href="{{ route('order.returned', $order->id) }}" class="btn btn-warning btn-sm mt-2" onclick="return confirm('Bạn chắc chắn muốn xác nhận đã trả hàng?')">Xác nhận đã trả hàng</a>
                                    @elseif ($order->status == 5)
                                        <span class="badge bg-dark">❌ Đã hủy</span>
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
        document.addEventListener("DOMContentLoaded", function() {
            // Lắng nghe sự kiện real-time từ Pusher
            window.Echo.channel('orders')
                .listen('OrderPlaced', (e) => {
                    console.log('Sự kiện OrderPlaced nhận được:', e); // Log để debug

                    const toastEl = document.getElementById('orderToast');
                    const messageEl = document.getElementById('orderMessage');
                    const linkEl = document.getElementById('orderLink');

                    // Hiển thị thông báo khi đơn hàng được tạo
                    let message =
                        `Đơn hàng mới WD${e.order_id} từ ${e.user_name}, tổng tiền: ${e.total_price}, lúc ${e.created_at}`;

                    messageEl.innerHTML = message;
                    linkEl.href = `{{ route('admin.show.order', '') }}/${e.order_id}`;

                    const toast = new bootstrap.Toast(toastEl);
                    toast.show();
                });
        });
    </script>
@endsection
