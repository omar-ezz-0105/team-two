<?php

namespace App\Http\Controllers;

use App\Models\Post;

class LikeController extends Controller
{
    /**
     * Store a new like (attach user to post's likers).
     */
    public function store(Post $post)
    {
        $userId = session('user')->id;
        
        $post->likers()->syncWithoutDetaching([$userId]);

        return back()->with('success', 'Post liked!');
    }

    /**
     * Remove an existing like (detach user from post's likers).
     */
    public function destroy(Post $post)
    {
        $userId = session('user')->id;
        
        $post->likers()->detach($userId);

        return back()->with('success', 'Post unliked!');
    }
}