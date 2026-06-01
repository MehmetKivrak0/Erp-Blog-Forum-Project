<?php

namespace App\Blog\Services;

use App\Core\Services\BaseService;
use App\Blog\Interfaces\BlogRepositoryInterface;
use App\Blog\DTOs\CreatePostDTO;
use App\Blog\DTOs\UpdatePostDTO;
use App\Models\Post;

class BlogService extends BaseService
{
    /**
     * Sınıf başlarken BlogRepositoryInterface sözleşmesini zorunlu olarak içeri alıyoruz (Dependency Injection).
     */
    public function __construct(
        protected BlogRepositoryInterface $repository
    ) {}

    /**
     * Tüm yayınlanmış blog yazılarını getirir.
     */
    public function getPublishedPosts(?string $categorySlug = null)
    {
        return $this->repository->getPublishedPosts($categorySlug);
    }

    /**
     * Tüm yayınlanmış blog yazılarını sayfalı olarak getirir.
     */
    public function getPublishedPostsPaginated(?string $categorySlug = null, int $perPage = 5): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return $this->repository->getPublishedPostsPaginated($categorySlug, $perPage);
    }

    /**
     * ID'ye göre blog detaylarını getirir.
     */
    public function getPostDetails(int $id): ?Post
    {
        return $this->repository->getPostDetails($id);
    }

    /**
     * Yeni bir blog yazısı oluşturma iş mantığı.
     */
    public function createPost(CreatePostDTO $dto): Post
    {
        // BaseService'teki o sihirli "executeSafe" (Transaction / Ya hep ya hiç) fonksiyonunu çağırıyoruz
        return $this->executeSafe(function () use ($dto) {
            
            // 1. İşlem: DTO'dan gelen güvenli veriyi veritabanı dizisine çeviriyoruz
            $postData = [
                'user_id'     => $dto->userId,
                'category_id' => $dto->categoryId,
                'title'       => $dto->title,
                'slug'        => $dto->slug,
                'content'     => $dto->content,
                'status'      => $dto->status->value,
                'cover_image' => $dto->coverImage,
            ];

            // 2. İşlem: Veritabanına kaydetmesi için Repository'e işi devrediyoruz
            return $this->repository->create($postData);

        }, 'Blog yazısı oluşturulurken sistemsel bir hata meydana geldi.');
    }

    /**
     * Blog yazısını günceller.
     */
    public function updatePost(UpdatePostDTO $dto): Post
    {
        return $this->executeSafe(function () use ($dto) {
            $payload = $dto->toArray();
            $this->repository->update($dto->postId, $payload);
            return $this->repository->findById($dto->postId);
        }, 'Blog yazısı güncellenirken bir hata oluştu.');
    }

    /**
     * Blog yazısını siler.
     */
    public function deletePost(int $id): bool
    {
        return $this->executeSafe(function () use ($id) {
            return $this->repository->deleteById($id);
        }, 'Blog yazısı silinirken bir hata oluştu.');
    }
}