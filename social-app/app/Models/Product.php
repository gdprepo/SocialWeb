<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image',
        'images',
        'hashtags',
        'price',
        'user_id'
    ];

    public function posts()
    {
        return $this->belongsToMany('App\Models\Post');
    }
}
