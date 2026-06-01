<?php

namespace App\Forum\DTOs;

class CreateTopicDTO
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public readonly int $userId,
        public readonly int $categoryId,
        public readonly string $title,
        public readonly string $content,
        public readonly bool $isPinned = false,
        public readonly bool $isLocked = false
    ) {
    }
}
