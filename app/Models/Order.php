<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;


    protected $table = 'orders';

    // Order Status Constants
    const STATUS_PENDING = 0;    // Chờ xử lý
    const STATUS_PREPARING = 1;  // Chuẩn bị hàng
    const STATUS_DELIVERING = 2; // Đang giao
    const STATUS_DELIVERED = 3;  // Đã giao
    const STATUS_COMPLETED = 4;  // Hoàn tất
    const STATUS_CANCELED = 5;   // Đã hủy
    const STATUS_RETURNED = 6;   // Đã trả hàng

    // Payment Status Constants
    const PAYMENT_PAID = 1;      // Đã thanh toán
    const PAYMENT_COD = 2;       // Thanh toán khi nhận hàng
    const PAYMENT_REFUNDED = 3;  // Đã hoàn tiền
    const PAYMENT_Fail = 0;

    // Payment Method Constants
    const PAYMENT_METHOD_COD = 0;    // Thanh toán khi nhận hàng (COD)
    const PAYMENT_METHOD_VNPAY = 1;  // Thanh toán qua VNPAY

    // Return Status Constants
    const RETURN_NONE = 0;      // Không có yêu cầu trả hàng
    const RETURN_REQUESTED = 1;  // Đang yêu cầu trả hàng
    const RETURN_APPROVED = 2;   // Đã duyệt trả hàng
    const RETURN_DECLINED = 3;   // Từ chối trả hàng
    const RETURN_COMPLETED = 4;  // Hoàn tất trả hàng

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
        'order_code',
        'payment_method'
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
        'payment_deadline' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

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

    public function isPaid()
    {
        return $this->payment_status === self::PAYMENT_PAID;
    }

    public function isPending()
    {
        return $this->payment_status === self::PAYMENT_COD;
    }

    public function isCodPayment()
    {
        return $this->payment_status === self::PAYMENT_COD;
    }

    public function isVnPayPayment()
    {
        return $this->payment_method === self::PAYMENT_METHOD_VNPAY;
    }

    public function isRefunded()
    {
        return $this->payment_status === self::PAYMENT_REFUNDED;
    }

    public function getPaymentStatusText()
    {
        switch($this->payment_status) {
            case self::PAYMENT_PAID:
                return 'Đã thanh toán';
            case self::PAYMENT_COD:
                return 'Thanh toán khi nhận hàng';
            case self::PAYMENT_REFUNDED:
                return 'Đã hoàn tiền';
            default:
                return 'Không xác định';
        }
    }

    public function getStatusText()
    {
        switch($this->status) {
            case self::STATUS_PENDING:
                return 'Chờ xử lý';
            case self::STATUS_PREPARING:
                return 'Chuẩn bị hàng';
            case self::STATUS_DELIVERING:
                return 'Đang giao';
            case self::STATUS_DELIVERED:
                return 'Đã giao';
            case self::STATUS_COMPLETED:
                return 'Hoàn tất';
            case self::STATUS_CANCELED:
                return 'Đã hủy';
            case self::STATUS_RETURNED:
                return 'Đã trả hàng';
            default:
                return 'Không xác định';
        }
    }

    public function getReturnStatusText()
    {
        switch($this->return_status) {
            case self::RETURN_NONE:
                return 'Không có yêu cầu';
            case self::RETURN_REQUESTED:
                return 'Đang yêu cầu';
            case self::RETURN_APPROVED:
                return 'Đã duyệt';
            case self::RETURN_DECLINED:
                return 'Từ chối';
            case self::RETURN_COMPLETED:
                return 'Hoàn tất';
            default:
                return 'Không xác định';
        }
    }

    public function getPaymentMethodText()
    {
        switch($this->payment_method) {
            case self::PAYMENT_METHOD_COD:
                return 'Thanh toán khi nhận hàng';
            case self::PAYMENT_METHOD_VNPAY:
                return 'Thanh toán qua VNPAY';
            default:
                return 'Không xác định';
        }
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
