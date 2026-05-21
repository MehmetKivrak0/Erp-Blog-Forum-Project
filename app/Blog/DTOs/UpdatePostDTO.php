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
        public readonly ?PostStatus $status = null
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
        
        return $data;
    }
}