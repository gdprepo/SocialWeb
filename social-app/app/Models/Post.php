<?php

namespace App\Models;

use App\Notifications\PostLiked;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'image',
        'images',
        'location',
        'hashtags',
        'comments',
        'user_id'
    ];

    public $post;


    public function likes()
    {
        return $this->hasMany('App\Models\Like');
    }

    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }

    public function isLikedByLoggedInUser()
    {
        return $this->likes->where('user_id', auth()->user()->id)->isEmpty() ? false : true;
    }
}
