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
    public function attributeValues()
    {
        return $this->belongsToMany(AttributeValue::class, 'variant_attribute_values', 'product_variant_id', 'attribute_value_id')
                    ->withTimestamps();
    }
    public function attributes()
    {
        return $this->hasMany(ProductVariantAttribute::class, 'product_variant_id');
    }

    public function productVariantAttributes()
{
    return $this->belongsToMany(ProductVariantAttribute::class, 'product_variant_attribute')
                ->withTimestamps();
}

}
