<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
        'variant_id',
        'rating',
        'review',
        'images',
        'video',
        'order_id'
    ];

    protected $casts = [
        'images' => 'array'
    ];

    public static function boot()
{
    parent::boot();

    static::creating(function ($review) {
        $exists = static::where('product_id', $review->product_id)
            ->where('variant_id', $review->variant_id)
            ->where('user_id', $review->user_id)
            ->where('order_id', $review->order_id)
            ->exists();

        if ($exists) {
            throw new \Exception('Bạn đã đánh giá biến thể này trong đơn hàng này rồi.');
        }
    });
}


    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    public function responses()
    {
        return $this->hasMany(ReviewResponse::class, 'review_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
