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
                <tbody id="unfinished-orders">
                    @foreach ($orders as $order)
                        @if($order->status == 3)
                        <tr>
                            <td><a href="{{ route('admin.show.order', $order->id) }}">{{ $order->order_code }}</a></td>
                            <td>{{ $order->created_at ? $order->created_at->format('d/m/Y H:i') : '---' }}</td>
                            <td>{{ $order->user->name ?? '---' }}</td>
                            <td>{{ number_format($order->total_price, 0, ',', '.') }} VNĐ</td>
                            <td>
                                @if ($order->payment_status == 1)
                                    <span class="badge bg-success">🟢 Đã thanh toán</span>
                                @else
                                    <span class="badge bg-info">🔵 Thanh toán khi nhận hàng</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-success">✅ Đã giao</span>
                            </td>
                        </tr>
                        @endif
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function refreshUnfinishedOrders() {
        $.ajax({
            url: "{{ route('admin.orders.unfinished') }}",
            type: "GET",
            success: function (data) {
                $("#unfinished-orders").html($(data).find("#unfinished-orders").html());
            }
        });
    }

    // Cập nhật trạng thái đơn hàng sang hoàn tất
    $(document).on("click", ".update-order-status", function () {
        let orderId = $(this).data("id");
        let newStatus = 4; // Trạng thái hoàn tất

        $.ajax({
            url: "/admin/orders/update-status/" + orderId,
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                status: newStatus
            },
            success: function () {
                // Refresh lại danh sách sau khi cập nhật
                refreshUnfinishedOrders();
            }
        });
    });
</script>

@endsection
