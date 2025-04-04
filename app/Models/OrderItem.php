<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $table = 'order_items'; // Đảm bảo bảng này tồn tại
    protected $fillable = ['order_id', 'product_id', 'quantity', 'price'];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function detailproduct()
{
    return $this->belongsTo(Product::class, 'product_id'); // Điều chỉnh theo cấu trúc DB của bạn
}
public function productVariant()
{
    return $this->belongsTo(ProductVariant::class, 'product_id');
}
}
