<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    use HasFactory;

    protected $fillable = ['attribute_id', 'value']; // Đảm bảo dùng 'value', không phải 'name'

    public function attribute()
    {
        return $this->belongsTo(Attribute::class, 'attribute_id');
    }
}
