<!DOCTYPE html>
<html>
<head>
    <title>Thông báo đơn hàng</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #f4f4f4; padding: 10px; text-align: center; }
        .item { margin: 10px 0; }
        .footer { margin-top: 20px; font-size: 0.9em; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Thông báo đơn hàng</h1>
        </div>
        <p>Xin chào {{ $order->user->name ?? 'Khách hàng' }},</p>
        <p>Chúng tôi đã nhận được đơn hàng của bạn:</p>
        <ul>
            <li><strong>Mã đơn hàng:</strong> {{ $order->id }}</li>
            <li><strong>Tổng tiền:</strong> {{ number_format($order->total_price, 0, ',', '.') }} VNĐ</li>
            <li><strong>Thời gian:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</li>
        </ul>
        <h3>Chi tiết sản phẩm:</h3>
        @foreach($order->items as $item)
            <div class="item">
                <p>{{ $item->product_name }} - {{ number_format($item->price, 0, ',', '.') }} VNĐ (x{{ $item->quantity }})</p>
            </div>
        @endforeach
        <p>Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi</p>
        <div class="footer">
            <p>Trân trọng,<br>Nước hoa Ethereal Noir</p>
        </div>
    </div>
</body>
</html>