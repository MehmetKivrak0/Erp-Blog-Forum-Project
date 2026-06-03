<?php

namespace App\Forum\Services;

use App\Core\Services\BaseService;
use App\Forum\Interfaces\ForumRepositoryInterface;
use App\Models\ForumTopic;
use Illuminate\Database\Eloquent\Collection;
use App\Forum\DTOs\CreateTopicDTO;
use App\Forum\DTOs\UpdateTopicDTO;
use App\Events\ForumTopicCreated;
use App\Exceptions\Forum\Exceptions\TopicCreationFailedException;

class ForumService extends BaseService
{
    /**
     * Dependency Injection ile ForumRepositoryInterface sözleşmesini alıyoruz.
     */
    public function __construct(
        protected ForumRepositoryInterface $repository
    ) {
    }

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
    public function getAllTopics(?string $categorySlug = null, ?string $search = null): Collection
    {
        return $this->repository->getAllTopics($categorySlug, $search);
    }

    public function createTopic(CreateTopicDTO $dto): ForumTopic
    {
        try {
            $topic = $this->executeSafe(function () use ($dto) {
                $topicData = [
                    'user_id' => $dto->userId,
                    'category_id' => $dto->categoryId,
                    'title' => $dto->title,
                    'content' => $dto->content,
                    'is_pinned' => $dto->isPinned,
                    'is_locked' => $dto->isLocked,
                ];
                return $this->repository->create($topicData);
            }, 'Forum konusu veritabanına kaydedilirken hata oluştu.');

            event(new ForumTopicCreated($topic));

            return $topic;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Forum topic creation exception: ' . $e->getMessage(), [
                'exception' => $e
            ]);
            throw new TopicCreationFailedException('Forum konusu oluşturulurken sistemsel bir hata oluştu.', 0, $e);
        }
    }

    /**
     * Forum konusunu günceller.
     */
    public function updateTopic(UpdateTopicDTO $dto): ForumTopic
    {
        return $this->executeSafe(function () use ($dto) {
            $payload = $dto->toArray();
            $this->repository->update($dto->topicId, $payload);
            return $this->repository->findById($dto->topicId);
        }, 'Forum konusu güncellenirken bir hata oluştu.');
    }

    /**
     * Forum konusunu siler.
     */
    public function deleteTopic(int $id): bool
    {
        return $this->executeSafe(function () use ($id) {
            return $this->repository->deleteById($id);
        }, 'Forum konusu silinirken bir hata oluştu.');
    }
}
