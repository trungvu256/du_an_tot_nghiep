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
        'name',
        'content',
        'price',
        'img',
        'price_sale',
        'category_id',
        'slug',
        'description',
        'views'
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
