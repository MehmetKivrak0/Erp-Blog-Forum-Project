<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\BlogController;
use App\Http\Controllers\Web\ForumController;
use App\Http\Controllers\Web\AuthController;

// Main / Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Auth (Guest)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Auth (Korumalı)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile', [\App\Http\Controllers\Web\ProfileController::class, 'show'])->name('profile');
    
    // Blog (Korumalı)
    Route::get('/blog/create', [BlogController::class, 'create'])->name('blog.create');
    Route::post('/blog/create', [BlogController::class, 'store'])->name('blog.create.post');
    Route::post('/blog/{id}/comment', [BlogController::class, 'storeComment'])->name('blog.comment');
    
    // Forum (Korumalı)
    Route::post('/forum/{id}/reply', [ForumController::class, 'storeReply'])->name('forum.reply');
});

// Blog (Açık)
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{id}', [BlogController::class, 'show'])->name('blog.show');

// Forum (Açık)
Route::get('/forum', [ForumController::class, 'index'])->name('forum.index');
Route::get('/forum/{id}', [ForumController::class, 'show'])->name('forum.thread');

// Support
Route::get('/support', function () {
    return view('support');
})->name('support');

Route::post('/support', function (\Illuminate\Http\Request $request) {
    // Placeholder: validate and store ticket
    $request->validate([
        'subject' => 'required|string|max:255',
        'message' => 'required|string',
        'category' => 'required|string',
    ]);

    // In production this would persist the ticket and notify staff
    return redirect()->route('support')->with('success', 'Destek talebiniz başarıyla alındı. Ekibimiz 24 iş saati içinde size geri dönecektir.');
})->name('support.submit');

use App\Http\Controllers\Web\AdminController;

// Admin Section
Route::middleware(['auth', 'role:admin,moderator,developer'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/moderator-queue', [AdminController::class, 'moderatorQueue'])->name('admin.moderator');
    Route::get('/system-monitor', [AdminController::class, 'systemMonitor'])->name('admin.monitor');

    // Admin API Routes
    Route::post('/users/{id}/role', [AdminController::class, 'updateRole'])->name('admin.users.role');
    Route::post('/users/{id}/status', [AdminController::class, 'updateStatus'])->name('admin.users.status');
    Route::post('/posts/{id}/approve', [AdminController::class, 'approvePost'])->name('admin.posts.approve');
    Route::post('/posts/{id}/reject', [AdminController::class, 'rejectPost'])->name('admin.posts.reject');
    Route::post('/maintenance/toggle', [AdminController::class, 'toggleMaintenance'])->name('admin.maintenance.toggle');
});

