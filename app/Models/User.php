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
    protected $fillable = 
        ['name', 'email', 'group_id'];

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
        return $this->hasMany(Order::class, 'id_customer', 'id');
    }

    public function wallet() {
        return $this->hasOne(Wallet::class);
    }

    public function customerGroups()
    {
        return $this->belongsToMany(CustomerGroup::class, 'customer_group_user', 'user_id', 'customer_group_id');
    }

    public function group()
    {
        return $this->belongsTo(CustomerGroup::class);
    }

    public static function addUsersToGroup($groupId, $userIds)
    {
        return self::whereIn('id', $userIds)->update(['group_id' => $groupId]);
    }
}
