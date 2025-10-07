@include('components.header')

<div style="max-width: 400px; margin: 50px auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px;">
    <h2 style="text-align: center;">Register for Social Media App</h2>
    
    <form method="POST" action="{{ route('register') }}">
        @csrf
        
        {{-- Name Field --}}
        <div style="margin-bottom: 15px;">
            <label for="name" style="display: block; margin-bottom: 5px;">Name:</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                   style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
            @error('name')
                <div style="color: red; font-size: 0.9em;">{{ $message }}</div>
            @enderror
        </div>

        {{-- Email Field --}}
        <div style="margin-bottom: 15px;">
            <label for="email" style="display: block; margin-bottom: 5px;">Email:</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required 
                   style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
            @error('email')
                <div style="color: red; font-size: 0.9em;">{{ $message }}</div>
            @enderror
        </div>

        {{-- Password Field --}}
        <div style="margin-bottom: 15px;">
            <label for="password" style="display: block; margin-bottom: 5px;">Password:</label>
            <input type="password" id="password" name="password" required
                   style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
            @error('password')
                <div style="color: red; font-size: 0.9em;">{{ $message }}</div>
            @enderror
        </div>

        {{-- Confirm Password Field --}}
        <div style="margin-bottom: 20px;">
            <label for="password_confirmation" style="display: block; margin-bottom: 5px;">Confirm Password:</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required
                   style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
        </div>

        <button type="submit" style="width: 100%; padding: 10px; background-color: #2196F3; color: white; border: none; border-radius: 4px; cursor: pointer;">
            Register
        </button>
    </form>
    
    <p style="margin-top: 20px; font-size: 0.9em; text-align: center;">
        Already have an account? <a href="{{ route('login') }}">Login here</a>
    </p>
</div>

@include('components.footer')