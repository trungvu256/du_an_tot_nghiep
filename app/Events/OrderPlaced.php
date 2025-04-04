<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderPlaced implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $orders;

    public function __construct($orders)
    {
        // dd($orders);
        $this->orders = $orders;
    }

    public function broadcastOn()
    {
        return new Channel('orders');
    }

    public function broadcastWith()
    {
        // dd($this->orders->items);
        // Lấy thông tin sản phẩm từ đơn hàng (giả sử đơn hàng có ít nhất 1 sản phẩm)
        $firstItem = $this->orders->items->first();
        $productName = $firstItem && $firstItem->product ? $firstItem->product->name : 'Sản phẩm không xác định';
        $detailproduct = $firstItem->detailproduct??null; 
        $productImage = $firstItem && $firstItem->product ? $firstItem->product->image : asset('default-image.jpg');
        if ($productImage && !filter_var($productImage, FILTER_VALIDATE_URL)) {
            $productImage = asset('storage/' . $productImage);
        } elseif (!$productImage) {
            $productImage = asset('default-image.jpg'); // Ảnh mặc định nếu không có ảnh
        }
        // dd($detailproduct->id);
        // hiện chi tiết sản phẩm
        $productUrl = $detailproduct ? route('web.shop-detail', ['id' => $detailproduct->id]) : '#';
        // dd($productUrl);
        // dd($productImage);

        // Che 6 số đầu của số điện thoại
        $phone = $this->orders->phone;
        $maskedPhone = $phone ? '******' . substr($phone, -4) : 'Không có số điện thoại';

        return [
            'order_id' => $this->orders->id,
            'created_at' => $this->orders->created_at->toDateTimeString(),
            'message' => "{$maskedPhone} đã vừa mua {$productName}",
            'product_image' => $productImage,
            'product_url' =>$productUrl
        ];
    }
}