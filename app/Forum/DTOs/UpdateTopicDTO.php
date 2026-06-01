<?php

namespace App\Forum\DTOs;

class UpdateTopicDTO
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public readonly int $topicId,
        public readonly ?int $categoryId = null,
        public readonly ?string $title = null,
        public readonly ?string $content = null,
        public readonly ?bool $isPinned = null,
        public readonly ?bool $isLocked = null
    ) {}

    /**
     * Convert the non-null properties to a database payload array.
     */
    public function toArray(): array
    {
        $data = [];

        if ($this->categoryId !== null) $data['category_id'] = $this->categoryId;
        if ($this->title !== null)      $data['title']       = $this->title;
        if ($this->content !== null)    $data['content']     = $this->content;
        if ($this->isPinned !== null)   $data['is_pinned']   = $this->isPinned;
        if ($this->isLocked !== null)   $data['is_locked']   = $this->isLocked;

        return $data;
    }
}
