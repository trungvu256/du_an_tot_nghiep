<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;
    protected $table = 'product_variants'; // Đảm bảo tên bảng đúng
    protected $fillable = [
        'product_id', 'size', 'concentration', 'special_edition',
        'price', 'price_sale', 'stock_quantity', 'sku', 'status'
    ];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function parent()
    {
        return $this->belongsTo(ProductVariant::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(ProductVariant::class, 'parent_id');
    }
    // public function attributeValues()
    // {
    //     return $this->belongsToMany(AttributeValue::class, 'variant_attribute_values', 'product_variant_id', 'attribute_value_id')
    //                 ->withTimestamps();
    // }
    public function attributes()
    {
        return $this->belongsToMany(
            Attribute::class,
            'product_variant_attributes', // Tên bảng trung gian
            'product_variant_id',         // Khóa ngoại trong bảng product_variant_attributes
            'attribute_id'                // Khóa ngoại trong bảng Attribute
        )->withPivot('attribute_value_id')->withTimestamps();
    }


    public function productVariantAttributes()
{
    return $this->belongsToMany(ProductVariantAttribute::class, 'product_variant_attribute')
                ->withTimestamps();
}
public function attributeValues()
{
    return $this->hasManyThrough(
        AttributeValue::class,
        ProductVariantAttribute::class,
        'product_variant_id', // Khóa ngoại trong bảng trung gian
        'id', // Khóa chính bảng AttributeValue
        'id', // Khóa chính bảng ProductVariant
        'attribute_value_id' // Khóa ngoại trong bảng trung gian
    );
}
public function product_variant_attributes()
    {
        return $this->hasMany(ProductVariantAttribute::class); // Giả sử bạn có mối quan hệ với bảng ProductVariantAttribute
    }
}
