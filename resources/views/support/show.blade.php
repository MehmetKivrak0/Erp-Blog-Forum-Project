@extends('layouts.app')

@section('title', 'Ticket #' . $ticket->id . ' | DevConnect')
@section('body-class', 'bg-background text-on-background font-body-md min-h-screen flex flex-col')

@section('content')
<x-navigation active="support" class="w-full bg-background border-b border-outline-variant sticky top-0" />
<main class="flex-grow max-w-container-max mx-auto w-full px-margin-desktop py-stack-lg grid grid-cols-1 lg:grid-cols-12 gap-gutter">
    
    <div class="lg:col-span-8 space-y-gutter">
        <!-- Ticket Header -->
        <div class="bg-white border border-outline-variant rounded-xl p-6 shadow-sm space-y-4">
            <div class="flex justify-between items-start gap-4">
                <h1 class="text-headline-md font-headline-md text-on-surface">{{ $ticket->subject }}</h1>
                <span class="px-3 py-1 rounded-full text-label-md font-label-md bg-surface-container-low text-on-surface-variant border border-outline-variant whitespace-nowrap">
                    {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                </span>
            </div>
            <div class="flex items-center gap-4 text-label-md text-on-surface-variant">
                <span>Created: {{ $ticket->created_at->format('M d, Y H:i') }}</span>
                <span>•</span>
                <span>Category: {{ ucfirst($ticket->category) }}</span>
            </div>
            <div class="p-4 bg-surface-container-lowest rounded-lg border border-outline-variant text-body-md text-on-surface whitespace-pre-wrap">{{ $ticket->message }}</div>
            
            @if($ticket->attachment_path)
            <div class="pt-4 border-t border-outline-variant">
                <a href="{{ Storage::url($ticket->attachment_path) }}" target="_blank" class="inline-flex items-center gap-2 text-primary hover:underline font-semibold">
                    <span class="material-symbols-outlined">attachment</span>
                    View Original Attachment
                </a>
            </div>
            @endif
        </div>

        <!-- Replies -->
        @if($ticket->replies->count() > 0)
        <h2 class="text-title-lg font-title-lg text-on-surface mt-stack-md">Discussion</h2>
        <div class="space-y-4">
            @foreach($ticket->replies as $reply)
                <div class="bg-white border border-outline-variant rounded-xl p-6 shadow-sm flex gap-4 {{ $reply->user->role === 'admin' || $reply->user->role === 'moderator' ? 'border-primary border-l-4' : '' }}">
                    <div class="flex-shrink-0">
                        @if($reply->user->profile_image)
                            <img src="{{ Storage::url($reply->user->profile_image) }}" alt="Avatar" class="w-10 h-10 rounded-full object-cover">
                        @else
                            <div class="w-10 h-10 rounded-full bg-surface-container-low flex items-center justify-center text-title-md font-bold text-on-surface border border-outline-variant">
                                {{ strtoupper(substr($reply->user->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    <div class="flex-grow space-y-2">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-on-surface">{{ $reply->user->name }}</span>
                                @if($reply->user->role === 'admin' || $reply->user->role === 'moderator')
                                    <span class="px-2 py-0.5 rounded-full text-[10px] uppercase font-bold bg-primary text-white">Staff</span>
                                @endif
                            </div>
                            <span class="text-label-sm text-on-surface-variant">{{ $reply->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="text-body-md text-on-surface whitespace-pre-wrap">{{ $reply->message }}</div>
                        @if($reply->attachment_path)
                        <div class="pt-2">
                            <a href="{{ Storage::url($reply->attachment_path) }}" target="_blank" class="inline-flex items-center gap-1 text-primary hover:underline text-label-md">
                                <span class="material-symbols-outlined text-[16px]">attachment</span> View Attachment
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        @endif

        <!-- Reply Form -->
        @if($ticket->status !== 'closed')
        <div class="bg-white border border-outline-variant rounded-xl p-6 shadow-sm mt-stack-md">
            <h3 class="text-title-md font-title-md text-on-surface mb-4">Add a Reply</h3>
            <form action="{{ route('support.reply', $ticket) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <textarea name="message" rows="4" class="w-full p-3 rounded border border-outline-variant bg-surface-container-lowest focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all resize-none text-on-surface" placeholder="Type your reply here..." required></textarea>
                </div>
                <div>
                    <label class="inline-flex items-center gap-2 cursor-pointer text-primary hover:underline text-label-md font-semibold">
                        <span class="material-symbols-outlined text-[20px]">attach_file</span> Add Attachment
                        <input type="file" name="attachment" class="hidden">
                    </label>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-primary text-white py-2 px-6 rounded-lg font-bold hover:bg-opacity-90 transition-all flex items-center gap-2">
                        <span class="material-symbols-outlined">send</span> Send Reply
                    </button>
                </div>
            </form>
        </div>
        @else
        <div class="mt-stack-md p-4 bg-surface-container-low border border-outline-variant rounded-xl text-center text-on-surface-variant">
            This ticket is closed. You cannot add new replies.
        </div>
        @endif

    </div>

    <!-- Sidebar Info -->
    <div class="lg:col-span-4 space-y-gutter">
        <div class="bg-surface-container-lowest border border-outline-variant p-6 rounded-xl space-y-4">
            <h3 class="text-title-md font-title-md text-on-surface border-b border-outline-variant pb-2">Ticket Details</h3>
            <div class="flex justify-between items-center text-body-md">
                <span class="text-on-surface-variant">Ticket ID</span>
                <span class="font-bold text-on-surface">#{{ $ticket->id }}</span>
            </div>
            <div class="flex justify-between items-center text-body-md">
                <span class="text-on-surface-variant">Priority</span>
                <span class="font-bold text-on-surface">{{ ucfirst($ticket->priority) }}</span>
            </div>
            <div class="flex justify-between items-center text-body-md">
                <span class="text-on-surface-variant">Status</span>
                <span class="font-bold text-on-surface">{{ ucfirst(str_replace('_', ' ', $ticket->status)) }}</span>
            </div>
            <div class="flex justify-between items-center text-body-md">
                <span class="text-on-surface-variant">Total Replies</span>
                <span class="font-bold text-on-surface">{{ $ticket->replies->count() }}</span>
            </div>
        </div>
    </div>
</main>
<x-footer class="w-full py-stack-lg mt-auto bg-surface-container-low border-t border-outline-variant" />
@endsection
