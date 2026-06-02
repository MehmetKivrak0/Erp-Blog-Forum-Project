<?php

namespace App\Support\Services;

use App\Models\SupportTicket;
use App\Models\TicketReply;
use App\Support\DTOs\CreateTicketDTO;
use App\Support\DTOs\CreateTicketReplyDTO;
use Illuminate\Support\Facades\DB;

class SupportService
{
    /**
     * Create a new support ticket.
     *
     * @param CreateTicketDTO $dto
     * @return SupportTicket
     */
    public function createTicket(CreateTicketDTO $dto): SupportTicket
    {
        return SupportTicket::create([
            'user_id' => $dto->userId,
            'subject' => $dto->subject,
            'message' => $dto->message,
            'category' => $dto->category,
            'priority' => $dto->priority,
            'attachment_path' => $dto->attachmentPath,
        ]);
    }

    /**
     * Add a reply to an existing ticket.
     *
     * @param CreateTicketReplyDTO $dto
     * @return TicketReply
     */
    public function addReply(CreateTicketReplyDTO $dto): TicketReply
    {
        return DB::transaction(function () use ($dto) {
            $reply = TicketReply::create([
                'support_ticket_id' => $dto->supportTicketId,
                'user_id' => $dto->userId,
                'message' => $dto->message,
                'attachment_path' => $dto->attachmentPath,
            ]);

            // Update ticket status to open if it was closed or resolved, or if an admin replied?
            // Usually, if a user replies, status -> open. If admin replies -> in_progress/answered.
            // For now, let's just make sure it stays open/in_progress.
            
            return $reply;
        });
    }

    /**
     * Update the status of a ticket.
     *
     * @param SupportTicket $ticket
     * @param string $status
     * @return SupportTicket
     */
    public function updateStatus(SupportTicket $ticket, string $status): SupportTicket
    {
        $ticket->update(['status' => $status]);
        return $ticket;
    }
}
