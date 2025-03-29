<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model {
    use HasFactory;

    protected $fillable = [ 'transaction_id', 'user_id','wallet_id', 'amount', 'bank_code', 'status', 'response_code'];

    public function wallet() {
        return $this->belongsTo(Wallet::class);
    }

    public function payment() {
        return $this->belongsTo(Payment::class,'id', 'transaction_id','wallet_id');
    }
}
