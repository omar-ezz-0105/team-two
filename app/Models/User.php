<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    // User -> hasMany -> Post
    public function posts() { return $this->hasMany(Post::class); }
    
    // User -> hasMany -> Comment
    public function comments() { return $this->hasMany(Comment::class); }

    // User -> belongsToMany -> Post (for Likes, will use 'likes' pivot table)
    public function likes()
    {
        // The relationship should ONLY include 'created_at' as we defined in the pivot table SQL
        return $this->belongsToMany(Post::class, 'likes', 'user_id', 'post_id')->withPivot('created_at');
    }
}
