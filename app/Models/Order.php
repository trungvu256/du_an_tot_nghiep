<?php

namespace App\Models;

use App\Enums\OrderStatus;
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
        'user_id',
        'promotion_id',
        'total_price',
        'status',
        'payment_status',
        'return_status',
        'return_reason',
        'branch',
        'payment_deadline',
        'txn_ref',
        'region',
        'shipping_provider',
        'tracking_number',
        'order_code'
    ];
    const STATUS_PENDING = 0; // Chờ xử lý
    const STATUS_PREPARING = 1; // Chuẩn bị hàng
    const STATUS_DELIVERING = 2; // Đang giao
    const STATUS_DELIVERED = 3; // Đã giao
    const STATUS_COMPLETED = 4; // Hoàn tất
    const STATUS_CANCELED = 5; // Đã hủy
    const STATUS_RETURNED = 6; // Đã trả hàng


    //    Trạng thái trả hàng
    const RETURN_NONE = 0; // Không có yêu cầu trả hàng
    const RETURN_REQUESTED = 1; // Đang yêu cầu trả hàng
    const RETURN_APPROVED = 2; // Đã duyệt trả hàng
    const RETURN_DECLINED = 3; // Từ chối trả hàng
    const RETURN_COMPLETED = 4; // Hoàn tất trả hàng


    public function canTransitionTo(int $newStatus): bool
    {
        $transitions = [
            self::STATUS_PENDING => [self::STATUS_PREPARING, self::STATUS_CANCELED],
            self::STATUS_PREPARING => [self::STATUS_DELIVERING, self::STATUS_CANCELED],
            self::STATUS_DELIVERING => [self::STATUS_DELIVERED, self::RETURN_REQUESTED],
            self::STATUS_DELIVERED => [self::STATUS_COMPLETED, self::RETURN_REQUESTED],
            self::RETURN_REQUESTED => [self::STATUS_CANCELED],
        ];

        return in_array($newStatus, $transitions[$this->status] ?? []);
    }


    const STATUS_PAID = 'paid';

    protected $casts = [
        'total_price' => 'decimal:2', // Chuyển total_price thành số thập phân với 2 chữ số
        'payment_deadline' => 'datetime', // Chuyển payment_deadline thành đối tượng DateTime
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    // lk với User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // lk với OrderDetail
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'id_order');
    }
    // Liên kết với product

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
    public function returnOrder()
    {
        return $this->hasOne(ReturnOrder::class, 'order_id');
    }
    public function shippingInfo()
    {
        return $this->hasOne(Shipping::class); // Nếu bạn có bảng shipping riêng
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id'); // Liên kết với bảng order_items thông qua order_id
    }

    // hạn thanh toán
    public function isPaymentExpired()
    {
        return $this->payment_deadline && now()->greaterThan($this->payment_deadline);
    }

    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (empty($order->order_code)) {
                $order->order_code = self::generateOrderCode();
            }
        });
    }

    public static function generateOrderCode()
    {
        $prefix = 'DH';
        $random = strtoupper(substr(md5(uniqid(rand(), true)), 0, 6));
        return $prefix . $random;
    }
}
