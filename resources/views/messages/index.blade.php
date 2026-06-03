@extends('layouts.app')

@section('title', 'DevConnect | Messages')
@section('body-class', 'bg-surface text-on-surface min-h-screen flex flex-col')

@section('content')
<x-navigation active="messages" />

<!-- Header Banner -->
<div class="relative pt-24 pb-12 bg-surface-container-low border-b border-border-light overflow-hidden">
    <!-- Abstract background elements -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-primary/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3"></div>
    <div class="absolute bottom-0 left-0 w-72 h-72 bg-secondary/10 rounded-full blur-3xl translate-y-1/3 -translate-x-1/4"></div>

    <div class="max-w-container-md mx-auto px-margin-mobile md:px-margin-desktop relative z-10">
        <div class="flex items-center gap-5">
            <div class="w-16 h-16 bg-gradient-to-br from-primary to-secondary rounded-2xl flex items-center justify-center text-white shadow-lg shadow-primary/20">
                <span class="material-symbols-outlined text-[32px]" style="font-variation-settings: 'FILL' 1;">mail</span>
            </div>
            <div>
                <h1 class="text-headline-xl font-headline-xl font-bold text-on-surface">Inbox</h1>
                <p class="text-body-lg text-on-surface-variant mt-1">Manage your private conversations</p>
            </div>
        </div>
    </div>
</div>

<main class="flex-grow py-stack-lg max-w-container-md mx-auto px-margin-mobile md:px-margin-desktop w-full">
    <div class="bg-surface-container-lowest border border-border-light rounded-2xl overflow-hidden shadow-sm">
        @if($conversations->count() > 0)
            <div class="divide-y divide-border-light">
                @foreach($conversations as $conversation)
                    @php
                        $otherUser = $conversation->user_one_id === $user->id ? $conversation->userTwo : $conversation->userOne;
                        $lastMessage = $conversation->messages->first();
                        $unread = $lastMessage && $lastMessage->sender_id !== $user->id && !$lastMessage->read_at;
                    @endphp
                    <a href="{{ route('messages.show', $otherUser->id) }}" class="flex items-center gap-5 p-5 hover:bg-surface-container-low transition-all duration-300 group relative overflow-hidden {{ $unread ? 'bg-primary/5' : '' }}">
                        @if($unread)
                            <!-- Unread Indicator Line -->
                            <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-primary"></div>
                        @endif

                        <div class="relative w-14 h-14 rounded-full overflow-hidden flex-shrink-0 border-2 {{ $unread ? 'border-primary shadow-md shadow-primary/20' : 'border-border-light group-hover:border-primary/50' }} transition-all">
                            <img alt="{{ $otherUser->name }}" class="w-full h-full object-cover" src="{{ $otherUser->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($otherUser->name).'&color=7F9CF5&background=EBF4FF' }}"/>
                            @if($unread)
                                <div class="absolute top-0 right-0 w-3.5 h-3.5 bg-error border-2 border-surface-container-lowest rounded-full"></div>
                            @endif
                        </div>

                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-baseline mb-1">
                                <h3 class="font-headline-sm text-headline-sm truncate {{ $unread ? 'font-bold text-primary' : 'text-on-surface group-hover:text-primary transition-colors' }}">
                                    {{ $otherUser->name }}
                                </h3>
                                @if($lastMessage)
                                    <span class="text-label-sm font-label-sm shrink-0 ml-4 {{ $unread ? 'text-primary font-bold' : 'text-on-surface-variant group-hover:text-on-surface transition-colors' }}">
                                        {{ $lastMessage->created_at->diffForHumans(null, true, true) }}
                                    </span>
                                @endif
                            </div>
                            
                            @if($lastMessage)
                                <div class="flex items-center gap-2">
                                    @if($lastMessage->sender_id === $user->id)
                                        <span class="material-symbols-outlined text-[16px] {{ $lastMessage->read_at ? 'text-primary' : 'text-on-surface-variant' }}">
                                            {{ $lastMessage->read_at ? 'done_all' : 'check' }}
                                        </span>
                                    @endif
                                    <p class="text-body-md truncate {{ $unread ? 'font-medium text-on-surface' : 'text-on-surface-variant' }}">
                                        {{ $lastMessage->body }}
                                    </p>
                                </div>
                            @else
                                <p class="text-body-md text-on-surface-variant italic truncate">Henüz mesaj yok.</p>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="py-24 px-8 text-center flex flex-col items-center">
                <div class="w-28 h-28 bg-surface-container-low rounded-full flex items-center justify-center mb-6 relative">
                    <div class="absolute inset-0 border-4 border-dashed border-border-light rounded-full animate-[spin_10s_linear_infinite]"></div>
                    <div class="absolute inset-2 bg-primary/10 rounded-full animate-pulse"></div>
                    <span class="material-symbols-outlined text-[56px] text-primary relative z-10" style="font-variation-settings: 'FILL' 1;">forum</span>
                </div>
                <h3 class="text-headline-lg font-headline-lg font-bold text-on-surface mb-3">Gelen kutunuz boş</h3>
                <p class="text-body-lg text-on-surface-variant max-w-md mx-auto mb-8">Yeni insanlarla tanışmak ve mesajlaşmak için topluluk üyelerinin profillerini ziyaret edebilirsiniz.</p>
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-primary text-on-primary rounded-full font-bold hover:shadow-lg hover:shadow-primary/30 hover:-translate-y-0.5 transition-all duration-300">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">explore</span>
                    Topluluğu Keşfet
                </a>
            </div>
        @endif
    </div>
</main>
<x-footer class="bg-surface-container-low border-t border-border-light mt-stack-lg" />
@endsection
