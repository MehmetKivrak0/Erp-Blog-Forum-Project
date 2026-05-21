<?php

namespace App\Blog\Interfaces;

use App\Core\Interfaces\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

interface BlogRepositoryInterface extends EloquentRepositoryInterface
{
    /**
     * Sadece durumu "YAYINDA (PUBLISHED)" olan blog yazılarını getirir.
     */
    public function getPublishedPosts(): Collection;
}