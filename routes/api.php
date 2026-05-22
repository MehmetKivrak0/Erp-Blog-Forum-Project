<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommentController;

// Blog CRUD Rotaları (Dünya Standartlarında API Seti)
Route::get('/posts', [BlogController::class, 'index']);          // Listeleme
Route::post('/posts', [BlogController::class, 'store']);         // Ekleme
Route::put('/posts/{id}', [BlogController::class, 'update']);     // Güncelleme
Route::delete('/posts/{id}', [BlogController::class, 'destroy']);   // Silme
Route::post('/comments', [CommentController::class, 'store']);