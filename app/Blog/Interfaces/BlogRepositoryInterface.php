<?php

namespace App\Blog\Interfaces;

use App\Core\Interfaces\EloquentRepositoryInterface;
use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;

interface BlogRepositoryInterface extends EloquentRepositoryInterface
{
    /**
     * Sadece durumu "YAYINDA (PUBLISHED)" olan blog yazılarını getirir.
     */
    public function getPublishedPosts(?string $categorySlug = null): Collection;

    /**
     * Sadece durumu "YAYINDA (PUBLISHED)" olan blog yazılarını sayfalı olarak getirir.
     */
    public function getPublishedPostsPaginated(?string $categorySlug = null, int $perPage = 5): \Illuminate\Contracts\Pagination\LengthAwarePaginator;

    /**
     * Blog yazısının detaylarını yazarı, kategorisi ve yorumlarıyla getirir.
     */
    public function getPostDetails(int $id): ?Post;
}