<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post; 
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Show the form for creating a new post.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created post in storage.
     */
    public function store(Request $request)
    {
        
        $request->validate([
            'content' => 'required|string|max:5000',
            
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);

        
        if (!session('user')) {
            return redirect()->route('login')->with('error', 'You must be logged in to post.');
        }

        $imagePath = null;
        
        
        if ($request->hasFile('image')) {
            // Store the file in 'public/images/posts'
            $imagePath = $request->file('image')->store('images/posts', 'public');
        }

        
        Post::create([
            'user_id' => session('user')->id,
            'content' => $request->content,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('home')->with('success', 'Post created successfully!');
    }

    /**
     * Remove the specified post from storage.
     */
    public function destroy(Post $post)
    {
        
        if ($post->user_id !== session('user')->id) {
            return back()->with('error', 'You are not authorized to delete this post.');
        }  

        if ($post->image_path) {
            Storage::disk('public')->delete($post->image_path);
        }

        $post->delete();

        return redirect()->route('home')->with('success', 'Post deleted successfully.');
    }
}