<?php

namespace App\Notifications;

use App\Models\SupportTicket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class TicketStatusUpdated extends Notification implements ShouldQueue
{
    use Queueable;

    public $ticket;
    public $status;

    /**
     * Create a new notification instance.
     */
    public function __construct(SupportTicket $ticket, string $status)
    {
        $this->ticket = $ticket;
        $this->status = $status;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'ticket_status_updated',
            'message' => "Destek biletinizin durumu güncellendi: " . trans("tickets.status.{$this->status}"),
            'ticket_id' => $this->ticket->id,
            'url' => route('support.show', $this->ticket->id),
            'status' => $this->status,
        ];
    }
}
