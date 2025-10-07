@include('components.header')

<div style="max-width: 400px; margin: 50px auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px;">
    <h2 style="text-align: center;">Login to Social Media App</h2>

    {{-- Session Messages (Success/Error from redirects) --}}
    @if(session('success'))
        <div style="color: green; margin-bottom: 10px;">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div style="color: red; margin-bottom: 10px;">{{ session('error') }}</div>
    @endif
    
    <form method="POST" action="{{ url('/login') }}">
        @csrf
        
        <div style="margin-bottom: 15px;">
            <label for="email" style="display: block; margin-bottom: 5px;">Email:</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required 
                   style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
            @error('email')
                <div style="color: red; font-size: 0.9em;">{{ $message }}</div>
            @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label for="password" style="display: block; margin-bottom: 5px;">Password:</label>
            <input type="password" id="password" name="password" required
                   style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
            @error('password')
                <div style="color: red; font-size: 0.9em;">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" style="width: 100%; padding: 10px; background-color: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer;">
            Login
        </button>

        <p style="margin-top: 20px; font-size: 0.9em; text-align: center;">
            Don't have an account? <a href="{{ route('register') }}">Register here</a>
        </p>
    </form>
    
    {{-- You must create a test user with a HASHED password for this to work. --}}
</div>

@include('components.footer')