<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash; // <--- RE-INTRODUCE HASH FACADE

class AuthController extends Controller
{
    // --- LOGIN METHODS ---

    public function showLogin()
    {
        if (session('user')) {
            return redirect('/');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // 1. Find the user by email
        $user = User::where('email', $request->email)->first();

        // 2. SECURE: Check if user exists AND if the submitted password matches the HASHED password
        if ($user && Hash::check($request->password, $user->password)) {
            
            // Success! Store the user model in the session.
            session(['user' => $user]);
            
            // Redirect to the home feed
            return redirect('/')->with('success', 'Login successful!');
        }

        // Failed login
        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ])->withInput();
    }
    
    // --- LOGOUT METHOD ---

    public function logout(Request $request)
    {
        session()->forget('user');
        return redirect()->route('login')->with('success', 'Logged out successfully.');
    }

    // --- REGISTRATION METHODS ---

    public function showRegistration()
    {
        if (session('user')) {
            return redirect('/');
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed', 
        ]);

        // SECURE: Encrypting the password before saving it to the database
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // <--- HASH THE PASSWORD
        ]);

        // Automatically log the new user in
        session(['user' => $user]);
        
        return redirect('/')->with('success', 'Registration successful! Welcome to the Social App.');
    }
}