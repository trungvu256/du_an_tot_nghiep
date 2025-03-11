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
