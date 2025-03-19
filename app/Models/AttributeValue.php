<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    use HasFactory;

    protected $fillable = ['attribute_id', 'value'];

    protected $casts = [
        'attribute_id' => 'integer',
        'value' => 'string',
    ];

    /**
     * Quan hệ: Một giá trị thuộc tính thuộc về một thuộc tính
     */
    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    /**
     * Quan hệ: Một giá trị thuộc tính có thể thuộc nhiều biến thể sản phẩm
     */
    public function productVariants()
    {
        return $this->belongsToMany(ProductVariant::class, 'product_variant_attributes')
            ->withTimestamps();
    }
}
