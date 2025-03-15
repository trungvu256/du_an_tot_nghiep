<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',           // Loại giảm giá: 'percentage' hoặc 'fixed'
        'discount_value', // Giá trị giảm giá
        'start_date',     // Ngày bắt đầu
        'end_date',       // Ngày kết thúc
    ];

    /**
     * Định dạng các trường kiểu ngày.
     *
     * @var array
     */
    protected $dates = [
        'start_date',
        'end_date',
    ];

    /**
     * Quan hệ với bảng `catalogues` thông qua bảng trung gian `catalogue_discounts`.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'discounted_products');
    }

    public function catelogues()
    {
        return $this->belongsToMany(Catalogue::class, 'catelogue_discounts', 'discount_id', 'catalogue_id');
    }
}


