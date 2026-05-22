<?php

namespace App\Comment\DTOs;

class CreateCommentDTO
{
    public function __construct(
        public readonly int $userId,
        public readonly int $commentableId,
        public readonly string $commentableType, // Örn: "App\Models\Post" veya "App\Models\ForumTopic"
        public readonly string $content
    ) {
    }
}