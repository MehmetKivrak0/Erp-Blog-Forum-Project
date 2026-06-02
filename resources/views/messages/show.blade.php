@extends('layouts.app')

@section('title', 'DevConnect | Mesaj - ' . $otherUser->name)
@section('body-class', 'bg-background-light text-on-surface font-body-md text-body-md min-h-screen flex flex-col')

@section('content')
<x-navigation class="bg-background-light border-b border-border-light fixed top-0 w-full z-10" />
<main class="flex-grow pt-24 pb-24 max-w-container-md mx-auto px-margin-mobile md:px-margin-desktop w-full h-[calc(100vh-64px)] flex flex-col">
    <div class="bg-white border border-border-light rounded-xl overflow-hidden shadow-sm flex flex-col flex-1">
        <!-- Header -->
        <div class="border-b border-border-light p-stack-md flex items-center gap-stack-md bg-surface-container-lowest">
            <a href="{{ route('messages.index') }}" class="text-secondary hover:text-primary transition-colors">
                <span class="material-symbols-outlined">arrow_back</span>
            </a>
            <div class="w-10 h-10 rounded-full bg-secondary-container flex items-center justify-center text-primary font-bold overflow-hidden">
                {{ strtoupper(substr($otherUser->name, 0, 1)) }}
            </div>
            <div>
                <a href="{{ route('profile', ['id' => $otherUser->id]) }}" class="font-headline-sm text-headline-sm text-on-surface hover:underline">{{ $otherUser->name }}</a>
            </div>
        </div>

        <!-- Messages Area -->
        <div class="flex-1 p-stack-md overflow-y-auto bg-surface-container-lowest/50 flex flex-col gap-stack-sm" id="messages-container">
            @forelse($messages as $message)
                @php
                    $isMine = $message->sender_id === $user->id;
                @endphp
                <div class="flex {{ $isMine ? 'justify-end' : 'justify-start' }}">
                    <div class="max-w-[75%] rounded-2xl px-4 py-2 {{ $isMine ? 'bg-primary text-white rounded-br-sm' : 'bg-surface-container text-on-surface border border-border-light rounded-bl-sm' }}">
                        <p class="whitespace-pre-wrap break-words">{{ $message->body }}</p>
                        <div class="text-[10px] mt-1 text-right {{ $isMine ? 'text-primary-container/80' : 'text-secondary' }}">
                            {{ $message->created_at->format('H:i') }}
                            @if($isMine)
                                <span class="material-symbols-outlined text-[12px] align-middle ml-1">
                                    {{ $message->read_at ? 'done_all' : 'check' }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center text-on-surface-variant py-8 my-auto">
                    <span class="material-symbols-outlined text-[48px] text-secondary/50 mb-2">waving_hand</span>
                    <p>Sohbete başlamak için bir mesaj gönderin.</p>
                </div>
            @endforelse
        </div>

        <!-- Input Area -->
        <div class="border-t border-border-light p-stack-sm bg-white">
            <form action="{{ route('messages.store', $conversation->id) }}" method="POST" class="flex gap-2">
                @csrf
                <input type="text" name="body" class="flex-1 bg-surface-container-lowest border border-border-light rounded-full px-4 py-2 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors" placeholder="Bir mesaj yazın..." required autocomplete="off" autofocus>
                <button type="submit" class="w-10 h-10 rounded-full bg-primary hover:bg-primary-container text-white flex items-center justify-center transition-colors shrink-0">
                    <span class="material-symbols-outlined text-[20px] ml-1">send</span>
                </button>
            </form>
        </div>
    </div>
</main>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('messages-container');
        if (container) {
            container.scrollTop = container.scrollHeight;
        }
    });
</script>
@endpush
@endsection
