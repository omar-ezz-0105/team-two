@include('components.header')

<h1 style="text-align: center; margin-bottom: 30px;"><i class="fas fa-feather-alt"></i> Create a New Post</h1>

<div style="max-width: 700px; margin: 0 auto; padding: 30px; border: 1px solid var(--color-border); border-radius: 12px; background-color: var(--color-bg-card); box-shadow: 0 4px 10px rgba(0,0,0,0.5);">
    
    <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
        @csrf
        
        {{-- Post Content --}}
        <div style="margin-bottom: 25px;">
            <label for="content" style="display: block; margin-bottom: 8px; font-weight: 600;"><i class="fas fa-comment-dots"></i> What's on your mind?</label>
            <textarea id="content" name="content" rows="6" required style="width: 100%;" placeholder="Share your thoughts... (max 255 characters)">{{ old('content') }}</textarea>
            @error('content')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        {{-- Image Upload --}}
        <div style="margin-bottom: 30px;">
            <label for="image" style="display: block; margin-bottom: 8px; font-weight: 600;"><i class="fas fa-image"></i> Upload Image (Optional):</label>
            <input type="file" id="image" name="image" accept="image/*" style="display: block; width: 100%;">
            @error('image')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn-post" style="width: 100%; font-size: 1.1em;">
            <i class="fas fa-paper-plane"></i> Post to TeamTwo
        </button>
    </form>
</div>

@include('components.footer')