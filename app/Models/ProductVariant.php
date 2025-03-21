<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id', 'parent_id', 'size', 'concentration', 'special_edition',
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
    return $this->hasMany(AttributeValue::class, 'attribute_id'); 
}

}
