@if($orders->isEmpty())
    <div class="text-muted">Không có đơn hàng nào đã hoàn tất.</div>
@else
@forelse ($orders as $order)
<div class="border p-3 mb-3">
    <strong>Mã đơn:</strong> #{{ $order->code }}<br>
    <strong>Tổng tiền:</strong> {{ number_format($order->total, 0, ',', '.') }}VNĐ<br>
</div>
@empty
<p>Không có đơn hàng nào.</p>
@endforelse
@endif
