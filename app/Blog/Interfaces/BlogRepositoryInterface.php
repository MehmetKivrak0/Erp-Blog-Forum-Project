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
     * Blog yazısının detaylarını yazarı, kategorisi ve yorumlarıyla getirir.
     */
    public function getPostDetails(int $id): ?Post;
}