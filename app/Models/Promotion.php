<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'discount_value',
        'status',
        'start_date',
        'end_date',
        'type',
        'min_order_value',
        'max_value',
        'quantity'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function userPromotions()
    {
        return $this->hasMany(UserPromotion::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_promotions');
    }

    public function isValid($total)
    {
        return $this->status === 'active' &&
               now()->between($this->start_date, $this->end_date) &&
               ($this->min_order_value === null || $total >= $this->min_order_value);
    }
}
