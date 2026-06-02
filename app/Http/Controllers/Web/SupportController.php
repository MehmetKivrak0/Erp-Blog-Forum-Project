<?php

namespace App\Http\Controllers\Web;

use App\Core\Controllers\BaseController;
use App\Models\SupportTicket;
use App\Support\DTOs\CreateTicketDTO;
use App\Support\DTOs\CreateTicketReplyDTO;
use App\Support\Services\SupportService;
use Illuminate\Http\Request;

class SupportController extends BaseController
{
    public function __construct(
        protected SupportService $supportService
    ) {
    }

    public function index()
    {
        $tickets = SupportTicket::where('user_id', auth()->id())->latest()->paginate(10);
        return view('support.index', compact('tickets'));
    }

    public function create()
    {
        return view('support.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'category' => 'required|string',
            'priority' => 'required|string|in:low,medium,high',
            'attachment' => 'nullable|file|max:10240', // 10MB
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('tickets', 'public');
        }

        $dto = new CreateTicketDTO(
            userId: auth()->id(),
            subject: $request->subject,
            message: $request->message,
            category: $request->category,
            priority: $request->priority,
            attachmentPath: $attachmentPath
        );

        $this->supportService->createTicket($dto);

        return redirect()->route('support.index')->with('success', 'Destek talebiniz başarıyla oluşturuldu.');
    }

    public function show(SupportTicket $ticket)
    {
        // Yetki kontrolü (sadece kendi bileti)
        if ($ticket->user_id !== auth()->id()) {
            abort(403);
        }

        $ticket->load('replies.user');

        return view('support.show', compact('ticket'));
    }

    public function reply(Request $request, SupportTicket $ticket)
    {
        // Yetki kontrolü
        if ($ticket->user_id !== auth()->id()) {
            abort(403);
        }

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

        // Update status if it was closed
        if ($ticket->status === 'closed') {
            $this->supportService->updateStatus($ticket, 'open');
        }

        return redirect()->route('support.show', $ticket->id)->with('success', 'Yanıtınız gönderildi.');
    }
}
