@include('components.header')

<div style="max-width: 400px; margin: 50px auto; padding: 30px; border: 1px solid var(--color-border); border-radius: 12px; background-color: var(--color-bg-card); box-shadow: 0 4px 10px rgba(0,0,0,0.5);">
    <h2 style="text-align: center; color: var(--color-text-light); margin-bottom: 25px;">Login to <span class="gradient-text">TeamTwo</span></h2>

    {{-- Session Messages (Success/Error from redirects) --}}
    @if(session('success'))
        <div class="success-alert">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="error-alert">{{ session('error') }}</div>
    @endif
    
    <form method="POST" action="{{ url('/login') }}">
        @csrf
        
        <div style="margin-bottom: 20px;">
            <label for="email" style="display: block; margin-bottom: 8px; font-weight: 600;"><i class="fas fa-at"></i> Email:</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required 
                   style="width: 100%;">
            @error('email')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div style="margin-bottom: 30px;">
            <label for="password" style="display: block; margin-bottom: 8px; font-weight: 600;"><i class="fas fa-lock"></i> Password:</label>
            <input type="password" id="password" name="password" required
                   style="width: 100%;">
            @error('password')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn-login-register" style="width: 100%;">
            <i class="fas fa-sign-in-alt"></i> Login
        </button>

        <p style="margin-top: 25px; font-size: 0.95em; text-align: center; color: var(--color-text-secondary);">
            Don't have an account? <a href="{{ route('register') }}" style="color: var(--color-blue); font-weight: 600; text-decoration: underline;">Register here</a>
        </p>
    </form>
</div>

@include('components.footer')