<?php
    $posts = App\Models\Post::with(['user', 'likers', 'comments.user'])->latest()->get();
    $currentUserId = session('user')->id;
?>
@include('components.header')

@if(session('success'))
    <div class="success-alert">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="error-alert">{{ session('error') }}</div>
@endif

<h1 style="margin-bottom: 25px;">Welcome back, <span class="gradient-text">{{ $user->name }}</span>!</h1>

<div style="margin-top: 30px; border-top: 1px solid var(--color-border); padding-top: 20px;">
    <h2 style="margin-bottom: 20px;"><i class="fas fa-globe-americas"></i> Global Feed</h2>

    @forelse ($posts as $post)
        <div style="border: 1px solid var(--color-border); padding: 20px; margin-bottom: 30px; border-radius: 12px; background-color: var(--color-bg-card); box-shadow: 0 4px 8px rgba(0,0,0,0.4);">
            
            {{-- Post Header --}}
            <div style="font-size: 0.95em; color: var(--color-text-secondary); margin-bottom: 15px; border-bottom: 1px solid var(--color-border); padding-bottom: 10px; display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <i class="fas fa-user-circle"></i> Posted by <span style="color: var(--color-blue);">{{ $post->user->name }}</span> <span style="margin-left: 10px; font-size: 0.9em;">on {{ $post->created_at->format('M d, Y H:i') }}</span>
                </div>
                {{-- Post Actions --}}
                @if ($post->user_id === $currentUserId)
                    <form method="POST" action="{{ route('posts.destroy', $post->id) }}" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Delete this post?')" 
                                class="btn-delete" title="Delete Post" style="font-size: 0.9em;">
                            <i class="fas fa-trash-alt"></i> Remove
                        </button>
                    </form>
                @endif
            </div>

            {{-- Post Image --}}
            @if ($post->image_path)
            <img src="{{ asset('storage/' . $post->image_path) }}" alt="Post Image" style="max-width: 100%; height: auto; border-radius: 8px; margin-bottom: 15px;">
            @endif

            {{-- Post Content --}}
            <p style="white-space: pre-wrap; margin-bottom: 20px; font-size: 1.1em;">{{ $post->content }}</p>

            {{-- REACTIONS SECTION --}}
            <div style="margin-bottom: 20px; font-size: 1em; color: var(--color-text-secondary); display: flex; align-items: center;">
                
                {{-- Check if the current user has liked the post --}}
                @php
                    $isLiked = $post->likers->contains($currentUserId);
                @endphp
                
                <span style="font-weight: 600; margin-right: 20px; color: var(--color-blue);">
                    <i class="fas fa-heart"></i> {{ $post->likers->count() }} {{ Str::plural('Reaction', $post->likers->count()) }}
                </span>
                
                @if ($isLiked)
                    {{-- UNLIKE FORM --}}
                    <form method="POST" action="{{ route('likes.destroy', $post->id) }}" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-unlike" style="background: none; border: none; cursor: pointer; font-weight: 600;">
                            👍 Remove Reaction
                        </button>
                    </form>
                @else
                    {{-- LIKE FORM --}}
                    <form method="POST" action="{{ route('likes.store', $post->id) }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn-like" style="background: none; border: none; cursor: pointer; font-weight: 600;">
                            👍 React
                        </button>
                    </form>
                @endif
            </div>

            {{-- COMMENTS SECTION --}}
            <div style="border-top: 1px solid var(--color-border); padding-top: 15px;">
                <h4 style="margin-bottom: 15px; color: var(--color-text-light);"><i class="fas fa-comments"></i> Comments ({{ $post->comments->count() }})</h4>

                @forelse ($post->comments as $comment)
                    <div style="padding: 10px 15px; border-left: 3px solid var(--color-purple); margin-bottom: 10px; background-color: var(--color-bg-comment); border-radius: 6px;">
                        <div style="font-size: 0.9em; margin-bottom: 5px;">
                            <span style="font-weight: bold; color: var(--color-blue);">{{ $comment->user->name }}:</span>
                            <span style="color: var(--color-text-secondary); margin-left: 10px;">{{ $comment->created_at->diffForHumans() }}</span>
                            
                            @if ($comment->user_id === $currentUserId)
                                {{-- Delete Comment Button --}}
                                <form method="POST" action="{{ route('comments.destroy', $comment->id) }}" style="display: inline; margin-left: 10px;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Delete this comment?')" 
                                            class="btn-delete" style="font-size: 0.85em;">
                                            🗑️ Remove
                                    </button>
                                </form>
                            @endif
                        </div>
                        <p style="margin: 0;">{{ $comment->content }}</p>
                    </div>
                @empty
                    <p style="font-style: italic; color: var(--color-text-secondary);">💭 No comments yet. Be the first to share your thoughts!</p>
                @endforelse

                {{-- Add Comment Form --}}
                <form method="POST" action="{{ route('comments.store', $post->id) }}" style="margin-top: 20px; display: flex;">
                    @csrf
                    <input type="text" name="content" placeholder="💬 Write a comment..." required
                           style="flex-grow: 1; margin-right: 10px; padding: 10px;">
                    <button type="submit" class="btn-primary" style="background-image: linear-gradient(90deg, var(--color-purple), var(--color-blue)); color: white; padding: 10px 15px;">
                        📤 Send
                    </button>
                </form>
            </div>

        </div>
    @empty
        <p style="font-size: 1.1em; text-align: center; padding: 40px; border: 1px dashed var(--color-border); border-radius: 8px;">
            📝 No posts yet. Be the first to post to the **TeamTwo** feed!
        </p>
    @endforelse
</div>

@include('components.footer')