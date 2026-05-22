<?php

namespace App\Forum\Repositories;

use App\Forum\Interfaces\ForumRepositoryInterface;
use App\Core\Repositories\BaseRepository;
use App\Models\ForumTopic;
use Illuminate\Database\Eloquent\Collection;

class ForumRepository extends BaseRepository implements ForumRepositoryInterface
{
    /**
     * ForumRepository constructor.
     */
    public function __construct(ForumTopic $model)
    {
        parent::__construct($model);
    }

    /**
     * En son açılan forum konularını getirir.
     */
    public function getRecentTopics(int $limit): Collection
    {
        return $this->model
            ->with(['user', 'category'])
            ->withCount('comments')
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Konu detayını yazarı, kategorisi ve yorumlarıyla birlikte getirir.
     */
    public function getTopicDetails(int $id): ?ForumTopic
    {
        return $this->model
            ->with(['user', 'category', 'comments.user'])
            ->find($id);
    }

    /**
     * Tüm forum konularını getirir.
     */
    public function getAllTopics(?string $categorySlug = null): Collection
    {
        $query = $this->model
            ->with(['user', 'category'])
            ->withCount('comments');

        if ($categorySlug) {
            $query->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        return $query->latest()->get();
    }
}
