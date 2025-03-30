<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariantAttribute extends Model
{
    protected $table = 'product_variant_attributes';

    protected $fillable = [
        'product_variant_id',
        'attribute_id',
        'attribute_value_id',
    ];

    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class, 'attribute_id'); // Đảm bảo tên cột đúng
    }
    public function attributeValue()
    {
        return $this->belongsTo(AttributeValue::class, 'attribute_value_id'); // Đảm bảo tên cột đúng
    }
    public function attributes()
{
    return $this->hasMany(ProductVariantAttribute::class, 'product_variant_id');
}

}

