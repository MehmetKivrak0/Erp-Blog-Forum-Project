<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
{
    // Sözleşme ile sınıfı birbirine bağlıyoruz (Mimarinin kalbi)
    $this->app->bind(
        \App\Blog\Interfaces\BlogRepositoryInterface::class,
        \App\Blog\Repositories\BlogRepository::class
    );
}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
