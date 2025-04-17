<?php

namespace App\Enums;

class PaymentStatus
{
    const paid = 1;           // Đã thanh toán
    const cod = 2;           // Thanh toán khi nhận hàng
    const refunded = 3;      // Đã hoàn tiền

    public static function all()
    {
        return [
            self::paid,
            self::cod,
            self::refunded,
        ];
    }
}
