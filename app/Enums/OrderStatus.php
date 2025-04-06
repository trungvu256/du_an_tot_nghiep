<?php

namespace App\Enums;

enum OrderStatus: int
{
    case PENDING = 0;        // Chờ xử lý
    case READY_FOR_PICKUP = 1; // Chờ lấy hàng
    case SHIPPING = 2;       // Đang giao
    case DELIVERED = 3;      // Đã giao
    case COMPLETED = 4;      // Hoàn tất
    case RETURNED = 5;       // Trả hàng
    case CANCELED = 6;       // Đã hủy

    public function label(): string
    {
        return match($this) {
            self::PENDING => 'Chờ xử lý',
            self::READY_FOR_PICKUP => 'Chờ lấy hàng',
            self::SHIPPING => 'Đang giao',
            self::DELIVERED => 'Đã giao',
            self::COMPLETED => 'Hoàn tất',
            self::RETURNED => 'Trả hàng',
            self::CANCELED => 'Đã hủy',
        };
    }
}