<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\BlogController;
use App\Http\Controllers\Web\ForumController;
use App\Http\Controllers\Web\AuthController;

// Main / Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Newsletter
Route::post('/newsletter/subscribe', [\App\Http\Controllers\NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

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
    
    // Profile & User related routes
    Route::get('/profile/{id?}', [\App\Http\Controllers\Web\ProfileController::class, 'show'])->name('profile');
    Route::post('/profile/images', [\App\Http\Controllers\Web\ProfileController::class, 'updateImages'])->name('profile.images');

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

    // Messages
    Route::get('/messages', [\App\Http\Controllers\Web\MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{id}', [\App\Http\Controllers\Web\MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{conversationId}', [\App\Http\Controllers\Web\MessageController::class, 'store'])->name('messages.store');
});

// Blog (Açık)
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{post}', [BlogController::class, 'show'])->name('blog.show');

// Forum (Açık)
Route::get('/forum', [ForumController::class, 'index'])->name('forum.index');
Route::get('/forum/{topic}', [ForumController::class, 'show'])->name('forum.thread');

// Support (Açık form artık yok, sadece kayıtlı kullanıcılar)
Route::middleware('auth')->prefix('support')->name('support.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Web\SupportController::class, 'index'])->name('index');
    Route::get('/create', [\App\Http\Controllers\Web\SupportController::class, 'create'])->name('create');
    Route::post('/', [\App\Http\Controllers\Web\SupportController::class, 'store'])->name('store');
    Route::get('/{ticket}', [\App\Http\Controllers\Web\SupportController::class, 'show'])->name('show');
    Route::post('/{ticket}/reply', [\App\Http\Controllers\Web\SupportController::class, 'reply'])->name('reply');
});

use App\Http\Controllers\Web\AdminController;

// Admin Section
Route::middleware(['auth'])->prefix('admin')->group(function () {
    // Sadece Admin
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/metrics', [AdminController::class, 'metrics'])->name('admin.metrics');
        Route::get('/export-report', [AdminController::class, 'exportReport'])->name('admin.export.report');
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

        // Removed Ticket Management from admin/moderator as per user request
    });

    // Sadece Developer
    Route::middleware(['role:developer'])->prefix('developer')->name('developer.')->group(function () {
        Route::get('/tickets', [\App\Http\Controllers\Web\Developer\TicketController::class, 'index'])->name('tickets.index');
        Route::get('/tickets/{ticket}', [\App\Http\Controllers\Web\Developer\TicketController::class, 'show'])->name('tickets.show');
        Route::post('/tickets/{ticket}/reply', [\App\Http\Controllers\Web\Developer\TicketController::class, 'reply'])->name('tickets.reply');
        Route::put('/tickets/{ticket}/status', [\App\Http\Controllers\Web\Developer\TicketController::class, 'updateStatus'])->name('tickets.status');
    });

    // Admin ve Developer
    Route::middleware(['role:admin,developer'])->group(function () {
        Route::get('/system-monitor', [AdminController::class, 'systemMonitor'])->name('admin.monitor');
        Route::post('/maintenance/toggle', [AdminController::class, 'toggleMaintenance'])->name('admin.maintenance.toggle');
    });
});

