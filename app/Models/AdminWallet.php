<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminWallet extends Model
{
    protected $fillable = ['balance'];

    public static function adjustBalance($amount)
    {
        $wallet = self::first();
        $wallet->balance += $amount;
        $wallet->save();
    }
}


