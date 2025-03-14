<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;


    protected $table = 'orders';
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'id_user',
        'total_price',
        'status',
        'payment_status'       
    ];
    const STATUS_PENDING = 0; // Chờ xử lý
    const STATUS_CONFIRMED = 1; // Đã xác nhận
    const STATUS_PREPARING = 2; // Chuẩn bị hàng
    const STATUS_PICKED_UP = 8; // Đơn vị vận chuyển đã lấy hàng
    const STATUS_DELIVERING = 3; // Đang giao
    const STATUS_DELIVERED = 4; // Đã giao
    const STATUS_COMPLETED = 5; // Hoàn tất
    const STATUS_CANCELED = 6; // Đã hủy
    const STATUS_RETURNED = 7; // Hoàn trả
    // lk với User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    // lk với OrderDetail
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'id_order');
    }
    // Liên kết với product

    public function product() {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
