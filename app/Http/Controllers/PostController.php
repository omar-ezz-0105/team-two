<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post; // Import the Post Model
use Illuminate\Support\Facades\Storage; // Import Storage facade for file handling

class PostController extends Controller
{
    /**
     * Show the form for creating a new post.
     */
    public function create()
    {
        // Protected by 'auth.manual' middleware in web.php
        return view('posts.create');
    }

    /**
     * Store a newly created post in storage.
     */
    public function store(Request $request)
    {
        // 1. Validation
        $request->validate([
            'content' => 'required|string|max:5000',
            // Image is optional but must be a valid file if present
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
        ]);

        // Ensure user is logged in (middleware protects the route, but this is a safeguard)
        if (!session('user')) {
            return redirect()->route('login')->with('error', 'You must be logged in to post.');
        }

        $imagePath = null;
        
        // 2. Handle Image Upload
        if ($request->hasFile('image')) {
            // Store the file in 'public/images/posts' and get the path
            $imagePath = $request->file('image')->store('images/posts', 'public');
        }

        // 3. Create the Post in the Database
        Post::create([
            'user_id' => session('user')->id,
            'content' => $request->content,
            'image_path' => $imagePath, // Save the path to the DB
        ]);

        return redirect()->route('home')->with('success', 'Post created successfully!');
    }

    /**
     * Remove the specified post from storage.
     */
    public function destroy(Post $post)
    {
        // 1. Authorization Check: Ensure the logged-in user owns the post
        if ($post->user_id !== session('user')->id) {
            return back()->with('error', 'You are not authorized to delete this post.');
        }

        // 2. Delete the associated image file from storage
        if ($post->image_path) {
            Storage::disk('public')->delete($post->image_path);
        }

        // 3. Delete the post from the database
        $post->delete();

        return redirect()->route('home')->with('success', 'Post deleted successfully.');
    }
}