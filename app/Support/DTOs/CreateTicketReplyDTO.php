<?php

namespace App\Support\DTOs;

class CreateTicketReplyDTO
{
    public function __construct(
        public int $supportTicketId,
        public int $userId,
        public string $message,
        public ?string $attachmentPath = null
    ) {
    }
}
