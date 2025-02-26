<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'comment', 'id_blog', 'id_product', 'id_hidden'];

    public function blog() {
        return $this->belongsTo(Blog::class, 'id_blog');
    }
    public function product() {
        return $this->belongsTo(Product::class, 'id_product');
    }
}
