<h2>Cảm ơn bạn đã đặt hàng tại {{ config('app.name') }}!</h2>
<p>Thông tin đơn hàng của bạn:</p>
<ul>
    <li>Mã đơn hàng: {{ $order->id }}</li>
    <li>Tổng tiền: {{ number_format($order->total, 0, ',', '.') }} đ</li>
    <li>Thời gian đặt: {{ $order->created_at }}</li>
</ul>
<p>Chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất.</p>
