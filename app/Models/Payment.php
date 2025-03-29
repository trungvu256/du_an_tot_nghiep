<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model {
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'user_id',
        'money',
        'transaction_code',
        'note',
        'vnp_response_code',
        'code_vnpay',
        'code_bank',
        'time',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
