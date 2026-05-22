<?php

namespace App\Forum\Interfaces;

use App\Core\Interfaces\EloquentRepositoryInterface;
use App\Models\ForumTopic;
use Illuminate\Database\Eloquent\Collection;

interface ForumRepositoryInterface extends EloquentRepositoryInterface
{
    /**
     * En son açılan forum konularını getirir.
     */
    public function getRecentTopics(int $limit): Collection;

    /**
     * Konu detayını yazarı ve yorumlarıyla birlikte getirir.
     */
    public function getTopicDetails(int $id): ?ForumTopic;

    /**
     * Tüm forum konularını getirir.
     */
    public function getAllTopics(?string $categorySlug = null): Collection;
}
