<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommentController;

Route::prefix('v1')->group(function () {
    
    // Herkese Açık Rotalar
    Route::get('/posts', [BlogController::class, 'index']);
    Route::get('/posts/{post}', [BlogController::class, 'show']); // Tek bir yazının detayı
    
    // Yorum ve Blog Ekleme, Güncelleme, Silme işlemleri (Oturum açmış kullanıcılar)
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/comments', [CommentController::class, 'store']);
        Route::put('/comments/{comment}', [CommentController::class, 'update']);
        Route::delete('/comments/{comment}', [CommentController::class, 'destroy']);
        
        // Blog Ekleme, Güncelleme ve Silme işlemleri
        Route::apiResource('posts', BlogController::class)->only(['store', 'update', 'destroy']);
    });
    
});