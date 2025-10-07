<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Social Media App</title>
    <style>
        body { font-family: sans-serif; margin: 0; background-color: #f0f2f5; }
        .header { background-color: #fff; padding: 10px 20px; border-bottom: 1px solid #ddd; display: flex; justify-content: space-between; align-items: center; }
        .header a { text-decoration: none; color: #333; margin-left: 20px; }
        .header .logo { font-size: 1.5em; font-weight: bold; color: #4CAF50; }
        .main-content { padding: 20px; max-width: 900px; margin: 20px auto; background-color: #fff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .logout-form button { background: none; border: none; color: #f44336; cursor: pointer; text-decoration: underline; padding: 0; margin-left: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <a href="{{ url('/') }}" class="logo">SocialApp</a>
        <nav>
            @if(session('user'))
                {{-- Show links for logged-in users --}}
                <a href="{{ route('home') }}">Home Feed</a>
                <a href="{{ route('posts.create') }}">Create Post</a>
                <form class="logout-form" method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit">Logout ({{ session('user')->name }})</button>
                </form>
            @else
                {{-- Show links for logged-out users --}}
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}">Register</a> 
            @endif
        </nav>
    </div>
    <div class="main-content">