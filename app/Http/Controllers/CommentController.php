<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;

class CommentController extends Controller
{
    /**
     * Store a new comment.
     */
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string|max:500',
        ]);

        
        Comment::create([
            'user_id' => session('user')->id,
            'post_id' => $post->id,
            'content' => $request->content,
        ]);

        return back()->with('success', 'Comment added.');
    }

    /**
     * Remove the specified comment.
     */
    public function destroy(Comment $comment)
    {
        if ($comment->user_id !== session('user')->id) {
            return back()->with('error', 'You are not authorized to delete this comment.');
        }

        $comment->delete();
        return back()->with('success', 'Comment deleted.');
    }
}