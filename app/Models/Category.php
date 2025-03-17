<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'name',
        'parent_id',
        'image'
    ];

    protected $dates = ['deleted_at'];
    public function products() {
        return $this->hasMany(Product::class);
    }

    public function parent() {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children() {
        return $this->hasMany(Category::class, 'parent_id');
    }
    protected static function boot() {
        parent::boot();
        static::creating(function ($category) {
            if ($category->parent_id == 0) {
                $category->parent_id = null;
            }
        });
    }

    public function scopeByLevel($query, $level)
    {
        if ($level == 0) {
            return $query->whereNull('parent_id');
        } elseif ($level == 1) {
            return $query->where('parent_id', '!=', null);
        } else {
            // Xử lý các cấp độ tiếp theo nếu cần
            return $query->where('parent_id', '!=', null)
                         ->whereHas('parent', function ($q) use ($level) {
                             $q->where('parent_id', '!=', null);
                         });
        }
    }
}
