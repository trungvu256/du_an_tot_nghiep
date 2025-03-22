<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * Quan hệ: Một thuộc tính có nhiều giá trị (AttributeValue)
     */
    public function values()
    {
        return $this->hasMany(AttributeValue::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function attribute()
    {
        return $this->belongsTo(AttributeValue::class, 'attribute_id');
    }
    public function attributeValues()
    {
        return $this->hasMany(AttributeValue::class, 'attribute_id');
    }
}
