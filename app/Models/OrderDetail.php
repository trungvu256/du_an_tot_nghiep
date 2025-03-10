<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $table = 'order_details'; // Tên bảng

    protected $fillable = [
        'order_id', 
        'id_product', 
        'quantity', 
        'price'
    ];

    // Liên kết với Order
    public function order()
    {
        return $this->belongsTo(Order::class, 'id_order', 'id');
    }

    // Liên kết với Product
    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product', 'id');
    }
}
