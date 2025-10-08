<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

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

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            
            session(['user' => $user]);
            
            return redirect('/')->with('success', 'Login successful!');
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        session()->forget('user');
        return redirect()->route('login')->with('success', 'Logged out successfully.');
    }


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

        // Hashing passwords
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        session(['user' => $user]);
        
        return redirect('/')->with('success', 'Registration successful! Welcome to the Social App.');
    }
}