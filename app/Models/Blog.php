<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'blogs';
    protected $fillable = ['author', 'title', 'image', 'preview', 'content', 'slug', 'views'];

    public function comment() {
        return $this->hasMany(Comment::class, 'id_blog');
    }
}
