@extends('admin.layouts.main')

@section('content')
    <div class="container">
        <h2>Chi tiết đơn hàng {{ $order->id }}</h2>
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
                <td>{{ number_format($order->total_price, 2) }} VNĐ</td>
            </tr>
            <tr>
                <th>Trạng thái</th>
                <td>
                    @switch($order->status)
                    @case(0)
                        <span class="badge bg-warning">Chờ xử lý</span>
                        @break
                    @case(1)
                        <span class="badge bg-info">Đã xác nhận</span>
                        @break
                    @case(2)
                        <span class="badge bg-secondary">Đang chuẩn bị hàng</span>
                        @break
                    @case(3)
                        <span class="badge bg-primary">Đang giao</span>
                        @break
                    @case(4)
                        <span class="badge bg-success">Đã giao</span>
                        @break
                    @case(5)
                        <span class="badge bg-dark">Hoàn tất (Đã nhận hàng)</span>
                        @break
                    @case(6)
                        <span class="badge bg-danger">Đã hủy</span>
                        @break
                    @case(7)
                        <span class="badge bg-warning">Hoàn trả</span>
                        @break
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
                            <td><td>
                                @if ($detail->product && $detail->product->image)
                                    <img src="{{ asset('storage/' . $detail->product->image) }}" width="50" alt="">
                                @else
                                    <span class="text-danger">Không có ảnh</span>
                                @endif
                            </td>
                            </td>
                            <td>{{ $detail->product->name }}</td>
                            <td>{{ $detail->quantity }}</td>
                            <td>{{ number_format($detail->product->price, 2) }} VNĐ</td>
                            <td>{{ number_format($detail->quantity * $detail->product->price, 2) }} VNĐ</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="text-center">Không có sản phẩm nào trong đơn hàng</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <a href="{{ route('admin.order') }}" class="btn btn-secondary">Quay lại</a>
    </div>
@endsection