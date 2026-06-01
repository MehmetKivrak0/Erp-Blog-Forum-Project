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
    Route::post('/blog/{post}/comment', [BlogController::class, 'storeComment'])->name('blog.comment');
    Route::get('/blog/{post}/edit', [BlogController::class, 'edit'])->name('blog.edit');
    Route::put('/blog/{post}', [BlogController::class, 'update'])->name('blog.update');
    Route::delete('/blog/{post}', [BlogController::class, 'destroy'])->name('blog.destroy');

    // Forum (Korumalı)
    Route::post('/forum/{topic}/reply', [ForumController::class, 'storeReply'])->name('forum.reply');
    Route::get('/forum/create', [ForumController::class, 'create'])->name('forum.create');
    Route::post('/forum/create', [ForumController::class, 'store'])->name('forum.create.post');
    Route::get('/forum/{topic}/edit', [ForumController::class, 'edit'])->name('forum.edit');
    Route::put('/forum/{topic}', [ForumController::class, 'update'])->name('forum.update');
    Route::delete('/forum/{topic}', [ForumController::class, 'destroy'])->name('forum.destroy');
    Route::post('/forum/{topic}/vote', [ForumController::class, 'vote'])->name('forum.topic.vote');
    Route::post('/forum/replies/{comment}/vote', [ForumController::class, 'voteReply'])->name('forum.reply.vote');
    Route::post('/forum/{topic}/bookmark', [ForumController::class, 'bookmark'])->name('forum.topic.bookmark');
    Route::post('/forum/{topic}/solution', [ForumController::class, 'toggleSolution'])->name('forum.topic.solution');
});

// Blog (Açık)
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{post}', [BlogController::class, 'show'])->name('blog.show');

// Forum (Açık)
Route::get('/forum', [ForumController::class, 'index'])->name('forum.index');
Route::get('/forum/{topic}', [ForumController::class, 'show'])->name('forum.thread');

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
Route::middleware(['auth'])->prefix('admin')->group(function () {
    // Sadece Admin
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/metrics', [AdminController::class, 'metrics'])->name('admin.metrics');
        Route::post('/users/{id}/role', [AdminController::class, 'updateRole'])->name('admin.users.role');
        Route::post('/users/{id}/status', [AdminController::class, 'updateStatus'])->name('admin.users.status');
    });

    // Admin ve Moderatör
    Route::middleware(['role:admin,moderator'])->group(function () {
        Route::get('/moderator-queue', [AdminController::class, 'moderatorQueue'])->name('admin.moderator');
        
        // Category Management
        Route::get('/categories', [\App\Http\Controllers\Web\Admin\CategoryController::class, 'index'])->name('admin.categories.index');
        Route::post('/categories', [\App\Http\Controllers\Web\Admin\CategoryController::class, 'store'])->name('admin.categories.store');
        Route::put('/categories/{category}', [\App\Http\Controllers\Web\Admin\CategoryController::class, 'update'])->name('admin.categories.update');
        Route::delete('/categories/{category}', [\App\Http\Controllers\Web\Admin\CategoryController::class, 'destroy'])->name('admin.categories.destroy');

        Route::post('/posts/{id}/approve', [AdminController::class, 'approvePost'])->name('admin.posts.approve');
        Route::post('/posts/{id}/reject', [AdminController::class, 'rejectPost'])->name('admin.posts.reject');
        Route::post('/topics/{id}/approve', [AdminController::class, 'approveTopic'])->name('admin.topics.approve');
        Route::post('/topics/{id}/reject', [AdminController::class, 'rejectTopic'])->name('admin.topics.reject');
    });

    // Admin ve Developer
    Route::middleware(['role:admin,developer'])->group(function () {
        Route::get('/system-monitor', [AdminController::class, 'systemMonitor'])->name('admin.monitor');
        Route::post('/maintenance/toggle', [AdminController::class, 'toggleMaintenance'])->name('admin.maintenance.toggle');
    });
});

