@extends('layouts.app')

@section('title', 'DevConnect | Messages')
@section('body-class', 'bg-background-light text-on-surface font-body-md text-body-md min-h-screen flex flex-col')

@section('content')
<x-navigation class="bg-background-light border-b border-border-light fixed top-0 w-full z-10" />
<main class="flex-grow pt-24 pb-24 max-w-container-md mx-auto px-margin-mobile md:px-margin-desktop">
    <div class="bg-white border border-border-light rounded-xl overflow-hidden shadow-sm">
        <div class="border-b border-border-light p-stack-md flex justify-between items-center bg-surface-container-lowest">
            <h1 class="font-headline-md text-headline-md text-on-surface flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">mail</span>
                My Messages
            </h1>
        </div>
        <div class="divide-y divide-border-light">
            @forelse($conversations as $conversation)
                @php
                    $otherUser = $conversation->user_one_id === $user->id ? $conversation->userTwo : $conversation->userOne;
                    $lastMessage = $conversation->messages->first();
                    $unread = $lastMessage && $lastMessage->sender_id !== $user->id && !$lastMessage->read_at;
                @endphp
                <a href="{{ route('messages.show', $otherUser->id) }}" class="flex items-center gap-stack-md p-stack-md hover:bg-surface-hover transition-colors {{ $unread ? 'bg-primary-container/10' : '' }}">
                    <div class="w-12 h-12 rounded-full bg-secondary-container flex items-center justify-center text-primary font-bold overflow-hidden">
                        {{ strtoupper(substr($otherUser->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-baseline mb-1">
                            <h3 class="font-semibold text-on-surface truncate {{ $unread ? 'font-bold' : '' }}">{{ $otherUser->name }}</h3>
                            @if($lastMessage)
                                <span class="text-label-sm text-secondary shrink-0 ml-2">{{ $lastMessage->created_at->diffForHumans() }}</span>
                            @endif
                        </div>
                        @if($lastMessage)
                            <p class="text-body-sm text-on-surface-variant truncate {{ $unread ? 'font-semibold text-on-surface' : '' }}">
                                {{ $lastMessage->sender_id === $user->id ? 'Sen: ' : '' }}{{ $lastMessage->body }}
                            </p>
                        @else
                            <p class="text-body-sm text-on-surface-variant italic truncate">Henüz mesaj yok</p>
                        @endif
                    </div>
                </a>
            @empty
                <div class="p-12 text-center text-on-surface-variant">
                    <span class="material-symbols-outlined text-[48px] text-secondary/50 mb-4">chat_bubble_outline</span>
                    <p class="font-headline-sm">Gelen kutunuz boş.</p>
                    <p class="text-body-sm mt-2">Mesaj başlatmak için bir kullanıcının profiline gidebilirsiniz.</p>
                </div>
            @endforelse
        </div>
    </div>
</main>
<x-footer class="bg-surface-container-lowest border-t border-border-light mt-stack-lg" />
@endsection
