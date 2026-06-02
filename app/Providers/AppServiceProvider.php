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
        // Interface ile Repository'i birbirine bağlıyoruz
        $this->app->bind(
            \App\Blog\Interfaces\BlogRepositoryInterface::class,
            \App\Blog\Repositories\BlogRepository::class
        );

        $this->app->bind(
            \App\Forum\Interfaces\ForumRepositoryInterface::class,
            \App\Forum\Repositories\ForumRepository::class
        );

        $this->app->bind(
            \App\Auth\Interfaces\UserRepositoryInterface::class,
            \App\Auth\Repositories\UserRepository::class
        );
    }
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Database\Eloquent\Relations\Relation::enforceMorphMap([
            'post' => \App\Models\Post::class,
            'forum_topic' => \App\Models\ForumTopic::class,
        ]);

        \Illuminate\Support\Facades\Event::listen(
            \Illuminate\Auth\Events\Login::class,
            \App\Listeners\UpdateUserStreak::class,
        );

        \App\Models\Post::observe(\App\Observers\PostObserver::class);
        \App\Models\ForumTopic::observe(\App\Observers\ForumTopicObserver::class);
        \App\Models\Comment::observe(\App\Observers\CommentObserver::class);
    }
}
