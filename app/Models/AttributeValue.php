<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    use HasFactory;

    protected $fillable = ['attribute_id', 'value'];

    // Một giá trị thuộc về một thuộc tính
    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    // Liên kết nhiều-nhiều với ProductVariant thông qua bảng trung gian variant_attribute_values
    // public function productVariants()
    // {
    //     return $this->belongsToMany(ProductVariant::class, 'variant_attribute_values', 'attribute_value_id', 'variant_id')
    //                 ->withTimestamps();
    // }
    public function variants()
    {
        return $this->belongsToMany(ProductVariant::class, 'product_variant_attributes');
    }
    public function productVariants()
    {
        return $this->hasManyThrough(
            ProductVariant::class,
            ProductVariantAttribute::class,
            'attribute_value_id', // Liên kết với bảng product_variant_attributes
            'id', // Liên kết với bảng product_variants
            'id', // Khóa chính của bảng attribute_values
            'product_variant_id' // Liên kết với bảng product_variant_attributes
        );
    }
}
