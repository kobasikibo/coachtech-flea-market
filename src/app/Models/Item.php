<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'brand',
        'description',
        'image_path',
        'condition',
        'price',
        'user_id'
    ];

    // リレーション：商品のカテゴリー
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    // リレーション：商品を「いいね」したユーザ
    public function likedByUsers()
    {
        return $this->belongsToMany(User::class, 'likes')->withTimestamps();
    }
}