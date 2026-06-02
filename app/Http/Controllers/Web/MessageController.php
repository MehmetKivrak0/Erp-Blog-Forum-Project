<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;

class MessageController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $conversations = Conversation::with(['userOne', 'userTwo', 'messages' => function($q) {
                $q->latest()->limit(1);
            }])
            ->where('user_one_id', $user->id)
            ->orWhere('user_two_id', $user->id)
            ->get()
            ->sortByDesc(function($conv) {
                return $conv->messages->first()?->created_at ?? $conv->created_at;
            });

        return view('messages.index', compact('conversations', 'user'));
    }

    public function show($id)
    {
        $user = auth()->user();
        $otherUser = User::findOrFail($id);

        if ($user->id === $otherUser->id) {
            return redirect()->route('profile.show')->with('error', 'Kendinize mesaj gönderemezsiniz.');
        }

        $conversation = Conversation::where(function ($query) use ($user, $otherUser) {
            $query->where('user_one_id', $user->id)->where('user_two_id', $otherUser->id);
        })->orWhere(function ($query) use ($user, $otherUser) {
            $query->where('user_one_id', $otherUser->id)->where('user_two_id', $user->id);
        })->first();

        if (!$conversation) {
            $conversation = Conversation::create([
                'user_one_id' => $user->id,
                'user_two_id' => $otherUser->id,
            ]);
        }

        $messages = $conversation->messages()->with('sender')->oldest()->get();

        // Mark as read
        $conversation->messages()
            ->where('sender_id', '!=', $user->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return view('messages.show', compact('conversation', 'messages', 'otherUser', 'user'));
    }

    public function store(Request $request, $conversationId)
    {
        $request->validate(['body' => 'required|string']);

        $conversation = Conversation::findOrFail($conversationId);
        
        $user = auth()->user();
        if ($conversation->user_one_id !== $user->id && $conversation->user_two_id !== $user->id) {
            abort(403);
        }

        $conversation->messages()->create([
            'sender_id' => $user->id,
            'body' => $request->body,
        ]);

        return back();
    }
}
