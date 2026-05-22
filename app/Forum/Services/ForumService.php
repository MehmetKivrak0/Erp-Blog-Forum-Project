<?php

namespace App\Forum\Services;

use App\Core\Services\BaseService;
use App\Forum\Interfaces\ForumRepositoryInterface;
use App\Models\ForumTopic;
use Illuminate\Database\Eloquent\Collection;

class ForumService extends BaseService
{
    /**
     * Dependency Injection ile ForumRepositoryInterface sözleşmesini alıyoruz.
     */
    public function __construct(
        protected ForumRepositoryInterface $repository
    ) {}

    /**
     * En son açılan forum konularını getirir.
     */
    public function getRecentTopics(int $limit): Collection
    {
        return $this->repository->getRecentTopics($limit);
    }

    /**
     * ID değerine göre forum konusunu ve tüm detaylarını getirir.
     */
    public function getTopicDetails(int $id): ?ForumTopic
    {
        return $this->repository->getTopicDetails($id);
    }

    /**
     * Tüm forum konularını getirir.
     */
    public function getAllTopics(?string $categorySlug = null): Collection
    {
        return $this->repository->getAllTopics($categorySlug);
    }
}
