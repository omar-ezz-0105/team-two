<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;

// --- Authentication Routes (Public) ---
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegistration'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// --- Protected Routes (Social Media App features) ---
Route::middleware(['auth.manual'])->group(function () {
    
    // 1. Home Feed / Dashboard
    Route::get('/', function () {
        $user = session('user');
        // This closure is now replaced by the PostController index logic in a standard app, 
        // but for simplicity, we'll keep the view logic inside home.blade.php for now.
        return view('home', ['user' => $user]);
    })->name('home');

    // 2. Post Management
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    // ADD THIS DELETE ROUTE:
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
    // --- Comment Routes ---
    // The URL will be /posts/{post}/comments
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // --- Like/Unlike Routes ---
    // The URL will be /posts/{post}/likes
    Route::post('/posts/{post}/likes', [LikeController::class, 'store'])->name('likes.store');
    Route::delete('/posts/{post}/likes', [LikeController::class, 'destroy'])->name('likes.destroy');
});