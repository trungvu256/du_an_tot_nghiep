<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $fillable = [
        'user_id', 'full_name', 'phone', 'province', 'district', 'ward', 'address_detail', 'is_default'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFullAddressAttribute()
    {
        return "{$this->address_detail}, {$this->ward}, {$this->district}, {$this->province}";
    }
    
}
