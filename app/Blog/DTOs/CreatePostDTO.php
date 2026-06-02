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
        public readonly PostStatus $status = PostStatus::PENDING,
        public readonly ?string $coverImage = null
    ) {}

    public static function fromRequest(\App\Http\Requests\StorePostRequest $request): self
    {
        $status = $request->validated('status') 
            ? PostStatus::tryFrom($request->validated('status')) ?? PostStatus::PENDING
            : PostStatus::PENDING;

        // Cover image'i al ve eğer yüklenmişse dosya yolunu al (şimdilik basit halini yazıyoruz)
        $coverImage = null;
        if ($request->hasFile('cover_image')) {
            $coverImage = $request->file('cover_image')->store('posts/covers', 'public');
        }

        return new self(
            userId: auth()->id(),
            categoryId: (int) $request->validated('category_id'),
            title: $request->validated('title'),
            slug: \Illuminate\Support\Str::slug($request->validated('title')),
            content: $request->validated('content'),
            status: $status,
            coverImage: $coverImage
        );
    }
}