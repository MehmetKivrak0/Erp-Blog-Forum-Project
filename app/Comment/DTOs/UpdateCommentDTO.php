<?php

namespace App\Comment\DTOs;

readonly class UpdateCommentDTO
{
    public function __construct(
        public string $content
    ) {
    }
}
