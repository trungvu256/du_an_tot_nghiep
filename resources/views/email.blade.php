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
            <li><strong>Mã đơn hàng:</strong> {{ $order->order_code }}</li>
            <li><strong>Tổng tiền:</strong> {{ number_format($order->total_price, 0, ',', '.') }} VNĐ</li>
            <li><strong>Thời gian:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</li>
        </ul>
        <h3>Chi tiết sản phẩm:</h3>
        @foreach($order->items as $item)
            <div class="item" style="border-bottom:1px solid #eee; padding-bottom:10px; margin-bottom:10px;">
                <p>
                    <strong>{{ $item->product->name ?? $item->product_name }}</strong>
                    @if(isset($item->productVariant) && $item->productVariant->product_variant_attributes)
                        <br>
                        @foreach($item->productVariant->product_variant_attributes as $attr)
                            <span style="font-size: 0.95em; color: #555;">
                                {{ $attr->attribute->name }}: {{ $attr->attributeValue->value }}
                            </span>
                        @endforeach
                    @endif
                </p>
                {{-- @if(isset($item->product->image))
                    <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" width="60" style="border-radius:4px;">
                @endif --}}
                <p>
                    Giá: {{ number_format($item->price, 0, ',', '.') }} VNĐ<br>
                    Số lượng: {{ $item->quantity }}<br>
                    <strong>Thành tiền: {{ number_format($item->price * $item->quantity, 0, ',', '.') }} VNĐ</strong>
                </p>
            </div>
        @endforeach
        <p>Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi</p>
        <div class="footer">
            <p>Trân trọng,<br>Nước hoa Ethereal Noir</p>
        </div>
    </div>
</body>
</html>