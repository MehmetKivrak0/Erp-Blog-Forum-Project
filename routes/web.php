<?php

use Illuminate\Support\Facades\Route;

// Main / Home
Route::get('/', function () {
    return view('home');
})->name('home');

// Auth
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function () {
    // Placeholder post route for login
    return redirect()->route('home');
});

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', function () {
    // Placeholder post route for registration
    return redirect()->route('home');
});

// Blog
Route::get('/blog/create', function () {
    return view('blog.create');
})->name('blog.create');

Route::post('/blog/create', function () {
    // Placeholder post route for creating a blog
    return redirect()->route('blog.show', 1);
})->name('blog.create.post');

Route::get('/blog/{id}', function ($id) {
    return view('blog.show', ['id' => $id]);
})->name('blog.show');

Route::post('/blog/{id}/comment', function ($id) {
    // Placeholder post route for submitting blog comment
    return redirect()->route('blog.show', $id);
})->name('blog.comment');

// Forum
Route::get('/forum/{id}', function ($id) {
    return view('forum.show', ['id' => $id]);
})->name('forum.thread');

Route::post('/forum/{id}/reply', function ($id) {
    // Placeholder post route for submitting forum reply
    return redirect()->route('forum.thread', $id);
})->name('forum.reply');

// Profile
Route::get('/profile', function () {
    return view('profile.show');
})->name('profile');

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

// Admin Section
Route::prefix('admin')->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/moderator-queue', function () {
        return view('admin.moderator-queue');
    })->name('admin.moderator');

    Route::get('/system-monitor', function () {
        return view('admin.system-monitor');
    })->name('admin.monitor');
});

