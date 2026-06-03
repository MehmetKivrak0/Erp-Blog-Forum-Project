<?php

namespace App\Http\Controllers\Web\Developer;

use App\Core\Controllers\BaseController;
use App\Models\SupportTicket;
use App\Support\DTOs\CreateTicketReplyDTO;
use App\Support\Services\SupportService;
use Illuminate\Http\Request;

class TicketController extends BaseController
{
    public function __construct(
        protected SupportService $supportService
    ) {
    }

    public function index(Request $request)
    {
        $query = SupportTicket::query()->with('user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        $tickets = $query->latest()->paginate(15);
        return view('developer.tickets.index', compact('tickets'));
    }

    public function show(SupportTicket $ticket)
    {
        $ticket->load('replies.user', 'user');
        return view('developer.tickets.show', compact('ticket'));
    }

    public function reply(Request $request, SupportTicket $ticket)
    {
        $request->validate([
            'message' => 'required|string',
            'attachment' => 'nullable|file|max:10240',
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('ticket_replies', 'public');
        }

        $dto = new CreateTicketReplyDTO(
            supportTicketId: $ticket->id,
            userId: auth()->id(),
            message: $request->message,
            attachmentPath: $attachmentPath
        );

        $this->supportService->addReply($dto);

        if ($ticket->status === 'open') {
            $this->supportService->updateStatus($ticket, 'in_progress');
        }

        return back()->with('success', 'Yanıt başarıyla eklendi.');
    }

    public function updateStatus(Request $request, SupportTicket $ticket)
    {
        $request->validate([
            'status' => 'required|string|in:open,in_progress,resolved,closed'
        ]);

        $this->supportService->updateStatus($ticket, $request->status);

        return back()->with('success', 'Bilet durumu güncellendi.');
    }
}
