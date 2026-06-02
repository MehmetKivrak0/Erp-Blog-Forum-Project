<?php

namespace App\Comment\DTOs;

readonly class CreateCommentDTO
{
    public function __construct(
        public int $userId,
        public int $commentableId,
        public string $commentableType, // Örn: "post" veya "forum_topic"
        public string $content
    ) {
    }
}