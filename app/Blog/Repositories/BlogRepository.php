<?php

namespace App\Blog\Repositories;

use App\Blog\Interfaces\BlogRepositoryInterface;
use App\Core\Repositories\BaseRepository;
use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;
use App\Core\Enums\PostStatus;

class BlogRepository extends BaseRepository implements BlogRepositoryInterface
{
    /**
     * BlogRepository constructor.
     * Post modelini enjekte edip parent sınıfa gönderiyoruz.
     */
    public function __construct(Post $model)
    {
        parent::__construct($model);
    }

    /**
     * Sadece durumu "YAYINDA (PUBLISHED)" olan blog yazılarını getirir.
     */
    public function getPublishedPosts(?string $categorySlug = null): Collection
    {
        $query = $this->model
            ->where('status', PostStatus::PUBLISHED)
            ->with(['user', 'category']);

        if ($categorySlug) {
            $query->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        return $query->latest()->get();
    }

    /**
     * Blog yazısının detaylarını yazarı, kategorisi ve yorumlarıyla getirir.
     */
    public function getPostDetails(int $id): ?Post
    {
        return $this->model
            ->with(['user', 'category', 'comments.user'])
            ->find($id);
    }
}
