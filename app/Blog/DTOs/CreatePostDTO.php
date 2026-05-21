<?php

namespace App\Blog\DTOs;

use App\Core\Enums\PostStatus;

class CreatePostDTO
{
    /**
     * DTO'lar sadece veri taşır, içlerinde fonksiyon veya iş mantığı barındırmazlar.
     * PHP 8 ile gelen Constructor Property Promotion özelliğini kullanarak tertemiz bir sınıf yazıyoruz.
     */
    public function __construct(
        public readonly int $userId,
        public readonly int $categoryId,
        public readonly string $title,
        public readonly string $slug,
        public readonly string $content,
        public readonly PostStatus $status = PostStatus::PENDING
    ) {}
}