<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'variant_name', 'price', 'sku', 'stock', 'status'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Thiết lập quan hệ Many-to-Many với bảng attribute_values thông qua bảng trung gian
    public function attributeValue()
    {
        return $this->belongsToMany(AttributeValue::class, 'variant_attribute_values', 'variant_id', 'attribute_value_id')
                    ->withTimestamps();
    }
}
