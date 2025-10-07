<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'content', 'image_path'];

    // Post belongs to one User (creator)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Post -> hasMany -> Comment
    public function comments()
    {
        return $this->hasMany(Comment::class)->latest(); // Show newest comments first
    }

    // Post -> belongsToMany -> User (for Likes, using 'likes' pivot table)
    public function likers()
    {
        // The relationship should ONLY include 'created_at' as we defined in the pivot table SQL
        return $this->belongsToMany(User::class, 'likes', 'post_id', 'user_id')->withPivot('created_at');
    }
}