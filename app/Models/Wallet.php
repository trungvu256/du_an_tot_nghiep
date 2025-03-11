<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'balance'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function addBalance($amount) {
        return $this->increment('blance', $amount);
    }
    public function deductBalance($amount)
    {
        $this->decrement('balance', $amount);
    }
}
