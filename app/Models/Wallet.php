<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'balance'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(WalletTransaction::class);
    }

    // Nạp tiền vào ví
    public function addBalance($amount, $description = 'Nạp tiền vào ví')
    {
        $this->balance += $amount;
        $this->save();

        // Ghi lại giao dịch
        $this->transactions()->create([
            'amount' => $amount,
            'type' => 'deposit',
            'description' => $description,
        ]);
    }

    // Trừ tiền khỏi ví
    public function deductBalance($amount, $description = 'Thanh toán')
    {
        if ($this->balance >= $amount) {
            $this->balance -= $amount;
            $this->save();

            // Ghi lại giao dịch
            $this->transactions()->create([
                'amount' => -$amount,
                'type' => 'withdraw',
                'description' => $description,
            ]);

            return true;
        }

        return false;
    }
}
