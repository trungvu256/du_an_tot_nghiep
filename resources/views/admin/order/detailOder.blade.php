@extends('admin.layouts.main')

@section('content')
    <div class="container">
        <h2>Chi tiết đơn hàng #{{ $order->id }}</h2>
        <hr>
        {{-- Thông báo --}}
        @if (session('success'))
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
        @endif
        <h4>Thông tin khách hàng</h4>
        <table class="table table-bordered">
            <tr>
                <th>Họ và tên</th>
                <td>{{ $order->name }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $order->email }}</td>
            </tr>
            <tr>
                <th>Số điện thoại</th>
                <td>{{ $order->phone }}</td>
            </tr>
            <tr>
                <th>Địa chỉ</th>
                <td>{{ $order->address }}</td>
            </tr>
            <tr>
                <th>Tổng tiền</th>
                <td>{{ number_format($order->total_price, 0, ',', '.') }} VNĐ</td>
            </tr>
            <tr>
                <th>cập nhật Trạng thái</th>
                <td>
                    @php
                        $isFinalStatus = in_array($order->status, [4, 5]);
                    @endphp

                    <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST" id="bulk-update-form">
                        @csrf
                        <div class="d-flex align-items-center ms-auto">
                            <div class="input-group input-group-sm">
                                {{-- Dropdown và nút cập nhật --}}
                                <select name="status" class="form-select form-select-sm" id="statusSelect"
                                    data-current-status="{{ $order->status }}">
                                    <option value="0" {{ $order->status == 0 ? 'selected' : '' }}>-- Chờ xử lý --
                                    </option>
                                    <option value="1" {{ $order->status == 1 ? 'selected' : '' }}>-- Chờ lấy hàng --
                                    </option>
                                    <option value="2" {{ $order->status == 2 ? 'selected' : '' }}>-- Đang giao --
                                    </option>
                                    <option value="3" {{ $order->status == 3 ? 'selected' : '' }}>-- Đã giao --
                                    </option>
                                    <option value="4" {{ $order->status == 4 ? 'selected' : '' }}>-- Hoàn tất --
                                    </option>
                                    <option value="5" {{ $order->status == 5 ? 'selected' : '' }}>-- Trả hàng --
                                    </option>
                                    <option value="6" {{ $order->status == 6 ? 'selected' : '' }}>-- Đã hủy --
                                    </option>
                                </select>
                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                <button type="submit" class="btn btn-primary btn-sm px-4">Cập nhật</button>
                            </div>
                        </div>
                    </form>

                </td>
            </tr>

            <tr>
                <th>Trạng thái</th>
                <td>
                    @switch($order->status)
                        @case(0)
                            <span class="badge bg-warning">Chờ xử lý</span>
                        @break

                        @case(1)
                            <span class="badge bg-info">Chờ lấy hàng</span>
                        @break

                        @case(2)
                            <span class="badge bg-secondary">Chờ lấy hàng</span>
                        @break

                        @case(3)
                            <span class="badge bg-primary">Đã giao</span>
                        @break

                        @case(4)
                            <span class="badge bg-success">Hoàn tất</span>
                        @break

                        @case(5)
                            <span class="badge bg-dark">Trả hàng</span>
                        @break

                        @case(6)
                            <span class="badge bg-danger">Hủy</span>
                        @break
                    @endswitch
                </td>
            </tr>
            <tr>
                <th>Trạng thái thanh toán</th>
                <td>
                    @switch($order->payment_status)
                        @case(0)
                            <span class="badge bg-warning">Chưa thanh toán</span>
                        @break

                        @case(1)
                            <span class="badge bg-info">Đã thanh toán bằng vnpay</span>
                        @break

                        @case(2)
                            <span class="badge bg-secondary">Thanh toán khi nhận hàng</span>
                        @break
                    @endswitch
                </td>
            </tr>
        </table>

        <h4>Sản phẩm trong đơn</h4>
        <table class="table table-striped text-center align-middle">
            <thead>
                <tr>
                    <th>Ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Giá</th>
                </tr>
            </thead>
            <tbody>
                @if ($order->orderItems && count($order->orderItems) > 0)
                    @foreach ($order->orderItems as $detail)
                        <tr>
                            <td>
                                @if ($detail->product && $detail->product->image)
                                    <img src="{{ asset('storage/' . $detail->product->image) }}" width="50"
                                        alt="{{ $detail->product->name }}">
                                @else
                                    <span class="text-danger">Không có ảnh</span>
                                @endif
                            </td>
                            <td>{{ $detail->product->name }}</td>
                            <td>{{ $detail->quantity }}</td>
                            <td>{{ number_format($detail->price, 0, ',', '.') }} VNĐ</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="text-center">Không có sản phẩm nào trong đơn hàng</td>
                    </tr>
                @endif
            </tbody>
        </table>

        {{-- Form đẩy đơn cho đơn vị vận chuyển --}}
        {{-- @if ($order->status < 3)
            <!-- Nếu đơn chưa được giao -->
            <h4>Giao hàng</h4>
            <form action="{{ route('admin.order.ship', $order->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="shipping_provider" class="form-label">Chọn đơn vị vận chuyển:</label>
                    <select class="form-control" id="shipping_provider" name="shipping_provider" required>
                        <option value="">-- Chọn đơn vị --</option>
                        <option value="ghtk">Giao Hàng Tiết Kiệm (GHTK)</option>
                        <option value="ghn">Giao Hàng Nhanh (GHN)</option>
                        <option value="vnpost">VNPost</option>
                    </select>
                </div>
                <button id="shipOrderButton" data-order-id="{{ $order->id }}">Đẩy Đơn Hàng</button>
            </form>
        @else --}}
            <!-- Nếu đơn đã giao -->
            {{-- <h4>Thông tin vận chuyển</h4>
            <table class="table table-bordered">
                <tr>
                    <th>Đơn vị vận chuyển</th>
                    <td>{{ $order->shipping_provider ?? 'Chưa có' }}</td>
                </tr>
                <tr>
                    <th>Mã vận đơn</th>
                    <td>{{ $order->tracking_number ?? 'Chưa có' }}</td>
                </tr>
            </table>
        @endif --}}
    {{-- </div> --}}
    <script>
        document.getElementById('shipOrderButton').addEventListener('click', function() {
            let orderId = this.getAttribute('data-order-id');

            fetch(`/admin/shipping/ship-order/${orderId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        shipping_provider: 'GHTK', // Có thể thay bằng dữ liệu động
                        tracking_number: 'TRK' + Math.floor(Math.random() *
                            1000000000) // Giả lập mã vận đơn
                    })
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    location.reload(); // Cập nhật lại giao diện
                })
                .catch(error => console.error('Lỗi:', error));
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const statusSelect = document.getElementById('statusSelect');

            if (statusSelect) { // Kiểm tra xem phần tử có tồn tại không
                const currentStatus = parseInt(statusSelect.dataset.currentStatus);

                // Định nghĩa các trạng thái có thể chuyển tiếp từ mỗi trạng thái hiện tại
                const validTransitions = {
                    0: [1, 6],
                    1: [2, 6],
                    2: [3, 5],
                    3: [4, 5],
                    4: [],
                    5: [6],
                    6: []
                };

                // Duyệt qua các option trong dropdown và kiểm tra xem chúng có hợp lệ không
                statusSelect.querySelectorAll('option').forEach(option => {
                    const optionValue = parseInt(option.value);

                    // Đảm bảo không disable option hiện tại
                    const isCurrent = optionValue === currentStatus;

                    // Kiểm tra xem trạng thái mới có hợp lệ không
                    const isValidTransition = validTransitions[currentStatus]?.includes(optionValue);

                    // Disable những option không hợp lệ
                    option.disabled = !(isCurrent || isValidTransition);
                });
            }
        });
    </script>
@endsection
