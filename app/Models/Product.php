<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $dates = ['delete_at'];
    protected $fillable = [
        'product_code',
        'name',
        'slug',
        'description',
        'price',
        'price_sale',
        'image',
        'gender',
        'brand',
        'longevity',
        'concentration',
        'origin',
        'style',
        'fragrance_group',
        'stock_quantity',
        'category_id',
        'created_at',
        'updated_at',
    ];
    /**
     * Get all of the comments for the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    // public function images()
    // {
    //     return $this->hasMany(Images::class, 'product_id', 'id');
    // }
    /**
     * Get the user that owns the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function images()
    {
        return $this->hasMany(Images::class, 'product_id');
    }
    public function variants() {
        return $this->hasMany(Variant::class);
    }
    

}
