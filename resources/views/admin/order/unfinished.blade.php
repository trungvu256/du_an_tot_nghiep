@extends('admin.layouts.main')

@section('content')
<div class="container mt-4">
    <h4 class="fw-bold">⏳ Đơn hàng chưa hoàn tất</h4>

    {{-- Bảng danh sách --}}
    <div class="card mt-3 shadow-sm">
        <div class="card-body">
            <table class="table table-hover text-center align-middle">
                <thead class="table-light">
                    <tr>
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
                        <tr>
                            <td><a href="{{ route('admin.show.order', $order->id) }}">WD{{ $order->id }}</a></td>
                            <td>{{ $order->created_at ? $order->created_at->format('d/m/Y H:i') : '---' }}</td>
                            <td>{{ $order->user->name ?? '---' }}</td>
                            <td>{{ number_format($order->total_price, 0, ',', '.') }}₫</td>
                            <td>
                                @if ($order->payment_status == 0)
                                    <span class="badge bg-warning text-dark">🟡 Chưa thanh toán</span>
                                @else
                                    <span class="badge bg-success">🟢 Đã thanh toán</span>
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
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Phân trang --}}
            <div class="d-flex justify-content-end">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
