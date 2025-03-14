@extends('admin.layouts.main')

@section('content')
    <div class="container">
        <h2>Chi tiết đơn hàng #{{ $order->id }}</h2>
        <hr>

        <h4>Thông tin khách hàng</h4>
        <table class="table table-bordered">
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
                <th>Trạng thái</th>
                <td>
                    @switch($order->status)
                        @case(0) <span class="badge bg-warning">Chờ xử lý</span> @break
                        @case(1) <span class="badge bg-info">Đã xác nhận</span> @break
                        @case(2) <span class="badge bg-secondary">Đang chuẩn bị hàng</span> @break
                        @case(3) <span class="badge bg-primary">Đang giao</span> @break
                        @case(4) <span class="badge bg-success">Đã giao</span> @break
                        @case(5) <span class="badge bg-dark">Hoàn tất (Đã nhận hàng)</span> @break
                        @case(6) <span class="badge bg-danger">Đã hủy</span> @break
                        @case(7) <span class="badge bg-warning">Hoàn trả</span> @break
                    @endswitch
                </td>
            </tr>
        </table>

        <h4>Sản phẩm trong đơn</h4>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Giá</th>
                    <th>Tổng</th>
                </tr>
            </thead>
            <tbody>
                @if ($order->orderDetails && count($order->orderDetails) > 0)
                    @foreach ($order->orderDetails as $detail)
                        <tr>
                            <td>
                                @if ($detail->product && $detail->product->image)
                                    <img src="{{ asset('storage/' . $detail->product->image) }}" width="50" alt="{{ $detail->product->name }}">
                                @else
                                    <span class="text-danger">Không có ảnh</span>
                                @endif
                            </td>
                            <td>{{ $detail->product->name }}</td>
                            <td>{{ $detail->qty }}</td>
                            <td>{{ number_format($detail->price, 0, ',', '.') }} VNĐ</td>
                            <td>{{ number_format($detail->qty * $detail->price, 0, ',', '.') }} VNĐ</td>
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
        @if ($order->status < 3) 
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
    @else
        <!-- Nếu đơn đã giao -->
        <h4>Thông tin vận chuyển</h4>
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
    @endif
    <script>
        document.getElementById('shipOrderButton').addEventListener('click', function () {
            let orderId = this.getAttribute('data-order-id');
    
            fetch(`/admin/shipping/ship-order/${orderId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    shipping_provider: 'GHTK', // Có thể thay bằng dữ liệu động
                    tracking_number: 'TRK' + Math.floor(Math.random() * 1000000000) // Giả lập mã vận đơn
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
@endsection
