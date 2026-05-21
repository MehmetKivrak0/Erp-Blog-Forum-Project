<?php

namespace App\Blog\Services;

use App\Core\Services\BaseService;
use App\Blog\Interfaces\BlogRepositoryInterface;
use App\Blog\DTOs\CreatePostDTO;
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
                'status'      => $dto->status->value, // Enum'ın veritabanındaki karşılığını (string) alıyoruz
            ];

            // 2. İşlem: Veritabanına kaydetmesi için Repository'e işi devrediyoruz
            return $this->repository->create($postData);

        }, 'Blog yazısı oluşturulurken sistemsel bir hata meydana geldi.');
    }
}