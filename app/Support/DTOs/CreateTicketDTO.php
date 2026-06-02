<?php

namespace App\Support\DTOs;

class CreateTicketDTO
{
    public function __construct(
        public int $userId,
        public string $subject,
        public string $message,
        public string $category,
        public string $priority,
        public ?string $attachmentPath = null
    ) {
    }
}
