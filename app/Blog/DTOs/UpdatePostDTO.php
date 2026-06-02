<?php

namespace App\Blog\DTOs;

use App\Core\Enums\PostStatus;

class UpdatePostDTO
{
    /**
     * Sadece değişecek alanlar gönderileceği için (veya hiçbiri değişmeyebileceği için)
     * postId hariç diğer tüm değişkenleri opsiyonel (? veya null) yapıyoruz.
     */
    public function __construct(
        public readonly int $postId,
        public readonly ?int $categoryId = null,
        public readonly ?string $title = null,
        public readonly ?string $slug = null,
        public readonly ?string $content = null,
        public readonly ?PostStatus $status = null,
        public readonly ?string $coverImage = null
    ) {}
    
    /**
     * Sadece null olmayan (doldurulmuş) verileri veritabanı dizisine çeviren yardımcı fonksiyon.
     */
    public function toArray(): array
    {
        $data = [];
        
        if ($this->categoryId !== null) $data['category_id'] = $this->categoryId;
        if ($this->title !== null)      $data['title']       = $this->title;
        if ($this->slug !== null)       $data['slug']        = $this->slug;
        if ($this->content !== null)    $data['content']     = $this->content;
        if ($this->status !== null)     $data['status']      = $this->status->value;
        if ($this->coverImage !== null) $data['cover_image'] = $this->coverImage;
        
        return $data;
    }

    public static function fromRequest(\App\Http\Requests\UpdatePostRequest $request, int $postId): self
    {
        $status = null;
        if ($request->has('status')) {
            $status = PostStatus::tryFrom($request->validated('status'));
        }

        $coverImage = null;
        if ($request->hasFile('cover_image')) {
            $coverImage = $request->file('cover_image')->store('posts/covers', 'public');
        }

        $title = $request->validated('title');
        $slug = $title ? \Illuminate\Support\Str::slug($title) : null;

        return new self(
            postId: $postId,
            categoryId: $request->has('category_id') ? (int) $request->validated('category_id') : null,
            title: $title,
            slug: $slug,
            content: $request->validated('content'),
            status: $status,
            coverImage: $coverImage
        );
    }
}