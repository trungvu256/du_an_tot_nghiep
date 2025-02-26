<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $table = 'blogs';
    protected $fillable = ['author', 'title', 'image', 'preview', 'content', 'slug', 'views'];

    public function comment() {
        return $this->hasMany(Comment::class, 'id_blog');
    }
}
