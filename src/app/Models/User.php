<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_image',
        'address_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // リレーション：ユーザの住所
    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    // リレーション：ユーザが「いいね」した商品
    public function likes()
    {
        return $this->belongsToMany(Item::class, 'likes');
    }
}