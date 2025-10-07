<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TeamTwo - Social Platform</title>
    {{-- Font Awesome CDN for Icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLMDJdZ6Mv0uU8Y+478gA3K9wE+kU1n3z9o1sB70M0zPz/V5/W6P2rG5N8W/gQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* Base Colors & Palette */
        :root {
            --color-dark: #121212;
            --color-black: #000000;
            --color-blue: #0077ff;
            --color-purple: #9300ff;
            --color-text-light: #e0e0e0;
            --color-text-secondary: #aaaaaa;
            --color-success: #4CAF50;
            --color-danger: #f44336;
            --color-bg-card: #1e1e1e;
            --color-bg-comment: #2a2a2a;
            --color-border: #333333;
        }

        /* Gradient Mix */
        .gradient-text {
            background: linear-gradient(90deg, var(--color-blue), var(--color-purple));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Global Styles */
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            margin: 0; 
            background-color: var(--color-dark); /* Dark background */
            color: var(--color-text-light);
            line-height: 1.6;
        }

        /* Header Styles */
        .header { 
            background-color: var(--color-black); 
            padding: 12px 20px; 
            border-bottom: 1px solid var(--color-border); 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            position: sticky; 
            top: 0; 
            z-index: 1000;
        }
        .header a { 
            text-decoration: none; 
            color: var(--color-text-light); 
            margin-left: 15px;
            padding: 5px 8px;
            transition: color 0.3s, background-color 0.3s;
            border-radius: 4px;
        }
        .header a:hover {
            color: var(--color-blue);
            background-color: #2a2a2a;
        }
        .header .logo { 
            font-size: 1.8em; 
            font-weight: 700;
        }
        .header nav {
            display: flex;
            align-items: center;
        }

        /* Main Content Wrapper */
        .main-content { 
            padding: 20px; 
            max-width: 1000px; 
            margin: 20px auto; 
            /* background-color: var(--color-bg-card); Removed for body background */
            border-radius: 12px; 
        }

        /* Utility Styles (Buttons, Forms, Alerts) */
        .logout-form button, .nav-button { 
            background: none; 
            border: none; 
            color: var(--color-danger); 
            cursor: pointer; 
            text-decoration: none; 
            padding: 5px 8px; 
            margin-left: 15px; 
            font-size: 1em;
            transition: color 0.3s;
        }
        .logout-form button:hover, .nav-button:hover {
            color: var(--color-text-light);
        }
        
        button[type="submit"], .btn-primary, .btn-secondary {
            padding: 10px 15px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: opacity 0.3s, transform 0.2s;
        }
        button[type="submit"]:hover, .btn-primary:hover, .btn-secondary:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        /* Specific Button Styles */
        .btn-post {
            background-image: linear-gradient(45deg, var(--color-blue), var(--color-purple));
            color: var(--color-text-light) !important;
        }
        .btn-like {
            color: var(--color-blue) !important;
        }
        .btn-unlike {
            color: var(--color-danger) !important;
        }
        .btn-delete {
            color: var(--color-danger) !important;
            text-decoration: none !important;
        }
        .btn-login-register {
            background-color: var(--color-blue);
            color: white;
        }

        /* Form elements */
        input[type="text"], input[type="email"], input[type="password"], textarea {
            background-color: #2a2a2a;
            border: 1px solid var(--color-border) !important;
            color: var(--color-text-light) !important;
            padding: 10px;
            border-radius: 6px;
        }
        .error-message {
            color: var(--color-danger); 
            font-size: 0.9em; 
            margin-top: 5px;
        }
        .success-alert {
            background-color: #1a3a1a; 
            color: var(--color-success); 
            padding: 12px; 
            border: 1px solid var(--color-success); 
            border-radius: 6px; 
            margin-bottom: 20px;
        }
        .error-alert {
            background-color: #3a1a1a; 
            color: var(--color-danger); 
            padding: 12px; 
            border: 1px solid var(--color-danger); 
            border-radius: 6px; 
            margin-bottom: 20px;
        }

        /* Mobile Responsiveness */
        @media (max-width: 600px) {
            .header {
                flex-direction: column;
                padding: 10px;
            }
            .header nav {
                margin-top: 10px;
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
            }
            .header a, .logout-form button {
                margin: 5px 8px;
            }
            .main-content {
                padding: 10px;
                margin: 10px auto;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <a href="{{ url('/') }}" class="logo gradient-text">
            <i class="fas fa-users-line"></i> TeamTwo
        </a>
        <nav>
            @if(session('user'))
                {{-- Show links for logged-in users --}}
                <a href="{{ route('home') }}" title="Home Feed"><i class="fas fa-home"></i> Home</a>
                <a href="{{ route('posts.create') }}" title="Create Post"><i class="fas fa-plus-square"></i> Post</a>
                <form class="logout-form" method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" title="Logout" class="nav-button">
                        <i class="fas fa-sign-out-alt"></i> Logout ({{ session('user')->name }})
                    </button>
                </form>
            @else
                {{-- Show links for logged-out users --}}
                <a href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i> Login</a>
                <a href="{{ route('register') }}"><i class="fas fa-user-plus"></i> Register</a> 
            @endif
        </nav>
    </div>
    <div class="main-content">