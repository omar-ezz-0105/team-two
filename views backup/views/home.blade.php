<?php
    // Fetch ALL posts, and eager load the relationships needed:
    // 1. user (the post creator)
    // 2. likers (all users who liked the post)
    // 3. comments (all comments)
    // 4. comments.user (the user who made the comment)
    $posts = App\Models\Post::with(['user', 'likers', 'comments.user'])->latest()->get();
    $currentUserId = session('user')->id;
?>
@include('components.header')

@if(session('success'))
    <div style="color: green; padding: 10px; border: 1px solid green; margin-bottom: 15px;">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div style="color: red; padding: 10px; border: 1px solid red; margin-bottom: 15px;">{{ session('error') }}</div>
@endif

<h1>Welcome back, {{ $user->name }}!</h1>

<div style="margin-top: 30px; border-top: 1px solid #eee; padding-top: 20px;">
    <h2>Global Feed</h2>

    @forelse ($posts as $post)
        <div style="border: 1px solid #ddd; padding: 15px; margin-bottom: 30px; border-radius: 8px; background-color: #fff;">
            
            {{-- Post Header --}}
            <div style="font-size: 0.9em; color: #555; margin-bottom: 10px; border-bottom: 1px solid #eee; padding-bottom: 5px;">
                Posted by **{{ $post->user->name }}** on {{ $post->created_at->format('M d, Y H:i') }}
            </div>

            {{-- Post Image --}}
            @if ($post->image_path)
                <img src="{{ asset('storage/' . $post->image_path) }}" alt="Post Image" style="max-width: 100%; height: auto; margin-bottom: 15px; border-radius: 4px;">
            @endif

            {{-- Post Content --}}
            <p style="white-space: pre-wrap; margin-bottom: 15px;">{{ $post->content }}</p>

            {{-- LIKES SECTION --}}
            <div style="margin-bottom: 15px; font-size: 0.9em; color: #555;">
                
                {{-- Check if the current user has liked the post --}}
                @php
                    $isLiked = $post->likers->contains($currentUserId);
                @endphp
                
                <span style="font-weight: bold; margin-right: 15px;">
                    {{ $post->likers->count() }} {{ Str::plural('Like', $post->likers->count()) }}
                </span>
                
                @if ($isLiked)
                    {{-- UNLIKE FORM --}}
                    <form method="POST" action="{{ route('likes.destroy', $post->id) }}" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background: none; border: none; color: #f44336; cursor: pointer; font-weight: bold;">
                            Unlike
                        </button>
                    </form>
                @else
                    {{-- LIKE FORM --}}
                    <form method="POST" action="{{ route('likes.store', $post->id) }}" style="display: inline;">
                        @csrf
                        <button type="submit" style="background: none; border: none; color: #007bff; cursor: pointer; font-weight: bold;">
                            Like
                        </button>
                    </form>
                @endif
                
                {{-- Delete Button (Original) --}}
                @if ($post->user_id === $currentUserId)
                    <form method="POST" action="{{ route('posts.destroy', $post->id) }}" style="display: inline; margin-left: 15px;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Delete this post?')" 
                                style="background: none; border: none; color: #f44336; cursor: pointer; text-decoration: underline;">
                            Delete Post
                        </button>
                    </form>
                @endif
            </div>

            {{-- COMMENTS SECTION --}}
            <div style="border-top: 1px solid #eee; padding-top: 15px;">
                <h4 style="margin-bottom: 10px;">Comments</h4>

                @forelse ($post->comments as $comment)
                    <div style="padding: 8px 10px; border-left: 3px solid #007bff; margin-bottom: 8px; background-color: #f9f9f9;">
                        <span style="font-weight: bold; color: #333;">{{ $comment->user->name }}:</span>
                        {{ $comment->content }} 
                        
                        @if ($comment->user_id === $currentUserId)
                            {{-- Delete Comment Button --}}
                            <form method="POST" action="{{ route('comments.destroy', $comment->id) }}" style="display: inline; margin-left: 10px;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Delete this comment?')" 
                                        style="background: none; border: none; color: #f44336; cursor: pointer; font-size: 0.8em;">
                                    (Delete)
                                </button>
                            </form>
                        @endif
                    </div>
                @empty
                    <p style="font-style: italic; color: #777;">No comments yet.</p>
                @endforelse

                {{-- Add Comment Form --}}
                <form method="POST" action="{{ route('comments.store', $post->id) }}" style="margin-top: 15px;">
                    @csrf
                    <input type="text" name="content" placeholder="Write a comment..." required
                           style="width: calc(100% - 70px); padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                    <button type="submit" style="padding: 8px 10px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;">
                        Send
                    </button>
                </form>
            </div>

        </div>
    @empty
        <p>No posts yet. Be the first to post!</p>
    @endforelse
</div>

@include('components.footer')