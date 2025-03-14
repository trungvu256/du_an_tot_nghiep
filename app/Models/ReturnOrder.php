<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnOrder extends Model
{
    use HasFactory;

    protected $table = 'returns';

    protected $fillable = [
        'order_id',
        'user_id',
        'reason',
        'status',
        'refund_method',
        'refund_amount',
        'requested_at',
        'processed_at',
        'admin_id'
    ];

    // Liên kết với bảng orders
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    // Liên kết với user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Liên kết với admin (người xử lý trả hàng)
    public function admin()
{
    return $this->belongsTo(User::class, 'admin_id');
}

}
