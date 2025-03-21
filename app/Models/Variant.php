<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'variant_name', 'price', 'sku', 'stock', 'status'
    ];

    /**
     * Liên kết với sản phẩm
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Liên kết với bảng attribute_values thông qua bảng trung gian variant_attribute_value
     */
    public function attributeValues()
    {
        return $this->belongsToMany(AttributeValue::class, 'variant_attribute_value')
                    ->withPivot('attribute_id')
                    ->withTimestamps();
    }
}
