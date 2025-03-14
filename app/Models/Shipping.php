<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    use HasFactory;
    protected $table = 'shipments';

    protected $fillable = [
        'order_id',
        'tracking_number',
        'carrier',
        'status',
        'fee',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
