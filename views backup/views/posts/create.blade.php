@include('components.header')

<h1 style="text-align: center; margin-bottom: 20px;">Create a New Post</h1>

<div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px;">
    
    <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
        @csrf
        
        {{-- Post Content --}}
        <div style="margin-bottom: 20px;">
            <label for="content" style="display: block; margin-bottom: 5px; font-weight: bold;">What's on your mind?</label>
            <textarea id="content" name="content" rows="4" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">{{ old('content') }}</textarea>
            @error('content')
                <div style="color: red; font-size: 0.9em;">{{ $message }}</div>
            @enderror
        </div>

        {{-- Image Upload --}}
        <div style="margin-bottom: 20px;">
            <label for="image" style="display: block; margin-bottom: 5px; font-weight: bold;">Upload Image (Optional):</label>
            <input type="file" id="image" name="image" accept="image/*" style="padding: 10px; border: 1px solid #ddd; border-radius: 4px; display: block;">
            @error('image')
                <div style="color: red; font-size: 0.9em; margin-top: 5px;">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" style="width: 100%; padding: 10px; background-color: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 1.1em;">
            Post
        </button>
    </form>
</div>

@include('components.footer')