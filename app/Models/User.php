<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Order;
use App\Models\Wallet;


class User extends Authenticatable
{

    use HasApiTokens, HasFactory, Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
       'first_name', // Thêm Họ
        'last_name',  // Thêm Tên
        'name',
        'email',
        'password',
        'is_admin',
        'provider_id',
        'status',
        'gender',
        'phone',
        'address',
        'avatar',
        'bank_account'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



    /**
     * Get all of the comments for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function wallet() {
        return $this->hasOne(Wallet::class);
    }

    public function customerGroups()
    {
        return $this->belongsToMany(CustomerGroup::class, 'customer_group_user', 'user_id', 'customer_group_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function promotions()
{
    return $this->belongsToMany(Promotion::class, 'user_promotions')
                ->withPivot('is_used')
                ->withTimestamps();
}
}
