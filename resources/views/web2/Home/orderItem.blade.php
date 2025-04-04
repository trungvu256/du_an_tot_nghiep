@extends('web2.layout.master')
@section('content')
    <div class="container">
        <h2 class="my-4 text-center text-primary">Chi tiết đơn hàng #{{ $order->id }}</h2>
        <hr class="my-3">

        <!-- Thông tin khách hàng -->
        <h4 class="my-3 text-secondary">Thông tin khách hàng</h4>
        <table class="table table-striped table-bordered">
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
                <td class="fw-bold text-success">
                    {{ number_format($order->total_price, 0, ',', '.') }} VNĐ
                </td>
            </tr>
            <tr>
                <th>Trạng thái đơn hàng</th>
                <td>
                    @switch($order->status)
                        @case(0) <span class="badge bg-warning">⏳ Chờ xác nhận</span> @break
                        @case(1) <span class="badge bg-info">📦 Chờ lấy hàng</span> @break
                        @case(2) <span class="badge bg-secondary">🚚 chờ giao hàng</span> @break
                        @case(3) <span class="badge bg-primary">✅ đã giao</span> @break
                        @case(4) <span class="badge bg-success">🚛 trả hàng</span> @break
                        @case(5) <span class="badge bg-dark">❌ Đã hủy</span> @break
                    @endswitch
                </td>
            </tr>
            <tr>
                <th>Trạng thái thanh toán</th>
                <td>
                    @switch($order->payment_status)
                        @case(0) <span class="badge bg-warning">Chưa thanh toán</span> @break
                        @case(1) <span class="badge bg-info">Đã thanh toán bằng vnpay</span> @break
                        @case(2) <span class="badge bg-secondary">Thanh toán khi nhận hàng</span> @break
                    @endswitch
                </td>
            </tr>
        </table>

        <!-- Sản phẩm trong đơn -->
        <h4 class="my-3 text-secondary">Sản phẩm trong đơn</h4>
        <table class="table table-striped table-bordered">
            <thead>
                <tr class="table-primary">
                    <th>Ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Giá</th>
                </tr>
            </thead>
            <tbody>
                @php 
                    $totalOrderPrice = 0; 
                @endphp
                @if ($order->orderItems && count($order->orderItems) > 0)
                    @foreach ($order->orderItems as $detail)
                        @php
                            // Lấy giá của biến thể, nếu có
                            $variantPrice = $detail->variant ? $detail->variant->price : $detail->price;
                            $itemTotal = $variantPrice * $detail->quantity;
                            $totalOrderPrice += $itemTotal;
                        @endphp
                        <tr>
                            <td>
                                @if ($detail->product && $detail->product->image)
                                    <img src="{{ asset('storage/' . $detail->product->image) }}" width="50" alt="{{ $detail->product->name }}">
                                @else
                                    <span class="text-danger">Không có ảnh</span>
                                @endif
                            </td>
                            <td>{{ $detail->product->name }}</td>
                            <td>{{ $detail->quantity }}</td>
                            <td>
                                {{-- Hiển thị giá giống giỏ hàng --}}
                                {{ number_format($itemTotal, 0, ',', '.') }} VNĐ
                                <br>
                                <small>({{ number_format($variantPrice, 0, ',', '.') }} x {{ $detail->quantity }})</small>
                            </td>
                        </tr>
                    @endforeach
                    {{-- Hiển thị tổng giá đơn hàng --}}
                    <tr>
                        <td colspan="3" class="text-end fw-bold">Tổng cộng:</td>
                        <td class="fw-bold text-danger">{{ number_format($totalOrderPrice, 0, ',', '.') }} VNĐ</td>
                    </tr>
                @else
                    <tr>
                        <td colspan="4" class="text-center text-muted">Không có sản phẩm nào trong đơn hàng</td>
                    </tr>
                @endif
            </tbody>
            
            
            
            
        </table>

        <!-- Thông tin vận chuyển -->
        <h4 class="my-3 text-secondary">Thông tin vận chuyển</h4>
        <table class="table table-striped table-bordered">
            <tr>
                <th>Đơn vị vận chuyển</th>
                <td>{{ $order->shipping_provider ?? 'Chưa có' }}</td>
            </tr>
            <tr>
                <th>Mã vận đơn</th>
                <td>{{ $order->tracking_number ?? 'Chưa có' }}</td>
            </tr>
        </table>
    </div>
@endsection
