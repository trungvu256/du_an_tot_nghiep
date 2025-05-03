<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
        'comment',
        'variant_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(ProductCommentReply::class, 'product_comment_id');
    }
   public function variant () {
    return $this->belongsTo(ProductVariant::class, 'variant_id');
   }
}
