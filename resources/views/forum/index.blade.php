@extends('layouts.app')

@section('title', 'Community Discussions | DevConnect')
@section('body-class', 'bg-surface text-on-surface min-h-screen flex flex-col')

@section('content')
<!-- TopNavBar -->
<x-navigation active="discussions" />

<header class="bg-surface-container-low border-b border-border-light py-12">
    <div class="max-w-container-max mx-auto px-margin-desktop text-center md:text-left flex flex-col md:flex-row justify-between items-center gap-4">
        <div>
            <h1 class="text-headline-xl font-headline-xl text-on-surface">Community Discussions</h1>
            <p class="text-body-lg font-body-lg text-on-surface-variant mt-2 max-w-2xl">Ask questions, share knowledge, and connect with other developers in the community.</p>
        </div>
        @auth
        <div class="flex items-center gap-3">
            @if(in_array(auth()->user()->role->value, ['admin', 'moderator']))
            <a href="{{ route('admin.moderator') }}" class="bg-surface-container-highest text-on-surface-variant px-6 py-3 rounded-lg font-bold hover:bg-secondary-container hover:text-on-secondary-container transition-all text-decoration-none flex items-center gap-2 border border-outline-variant">
                <span class="material-symbols-outlined">gavel</span>
                Moderator Hub
            </a>
            @else
            <a href="{{ route('forum.create') }}" class="bg-primary text-on-primary px-6 py-3 rounded-lg font-bold hover:opacity-90 transition-all text-decoration-none flex items-center gap-2">
                <span class="material-symbols-outlined">add_circle</span>
                New Topic
            </a>
            @endif
        </div>
        @endauth
    </div>
</header>

<main class="flex-grow max-w-container-max mx-auto px-margin-desktop py-stack-lg w-full">
    <!-- Category Filtering -->
    <div class="flex items-center gap-stack-sm overflow-x-auto pb-4 scrollbar-hide mb-stack-lg">
        <a href="{{ route('forum.index', ['search' => request('search')]) }}" 
           class="whitespace-nowrap px-stack-md py-2 rounded-full text-label-md font-label-md {{ !request('category') ? 'bg-primary text-on-primary font-bold' : 'bg-surface-container-highest text-on-surface-variant hover:bg-secondary-container font-medium' }} transition-colors text-decoration-none">
            All Categories
        </a>
        @foreach($categories as $category)
            <a href="{{ route('forum.index', ['category' => $category->slug, 'search' => request('search')]) }}" 
               class="whitespace-nowrap px-stack-md py-2 rounded-full text-label-md font-label-md {{ request('category') === $category->slug ? 'bg-primary text-on-primary font-bold' : 'bg-surface-container-highest text-on-surface-variant hover:bg-secondary-container font-medium' }} transition-colors text-decoration-none">
                {{ $category->name }}
            </a>
        @endforeach
    </div>

    @if(request('search'))
        <div class="mb-stack-lg flex items-center justify-between bg-surface-container-low p-4 rounded-lg border border-outline-variant/20">
            <p class="text-body-md text-on-surface">Showing results for: <span class="font-bold">"{{ request('search') }}"</span></p>
            <a href="{{ route('forum.index', ['category' => request('category')]) }}" class="text-error hover:underline text-label-sm font-bold flex items-center gap-1 text-decoration-none">
                <span class="material-symbols-outlined text-[16px]">close</span> Clear Search
            </a>
        </div>
    @endif

    <!-- Discussions List -->
    <div class="space-y-4">
        @forelse($topics as $topic)
            <div class="bg-surface-container-lowest border border-border-light p-6 rounded-xl hover:shadow-md transition-all duration-200 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div class="flex items-start gap-4">
                    <img alt="User avatar" class="w-10 h-10 rounded-full border border-border-light object-cover mt-1" src="{{ $topic->user?->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($topic->user?->name ?? 'Anonim').'&color=7F9CF5&background=EBF4FF' }}"/>
                    <div>
                        <h3 class="text-headline-md font-headline-md text-on-surface hover:text-primary transition-colors flex items-center gap-2 flex-wrap">
                            <a href="{{ route('forum.thread', $topic->id) }}" class="text-decoration-none">{{ $topic->title }}</a>
                            @if($topic->solution_comment_id)
                                <span class="flex items-center gap-0.5 bg-emerald-50 text-emerald-700 px-2 py-0.5 rounded-full text-label-sm font-bold border border-emerald-100" title="This topic has a verified solution">
                                    <span class="material-symbols-outlined text-[14px]" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                                    <span>Solved</span>
                                </span>
                            @endif
                        </h3>
                        <div class="flex flex-wrap items-center gap-3 mt-1 text-label-sm font-label-sm text-on-surface-variant">
                            <span class="bg-secondary-container text-on-secondary-container px-2 py-0.5 rounded-full">{{ $topic->category?->name ?? 'General' }}</span>
                            <span>Posted by <span class="font-bold text-on-surface">{{ $topic->user?->name ?? 'Anonim' }}</span></span>
                            <span>•</span>
                            <span>{{ $topic->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-6 border-t md:border-t-0 pt-4 md:pt-0 w-full md:w-auto justify-between md:justify-end">
                    <div class="text-center">
                        <p class="text-headline-sm font-headline-sm text-on-surface font-bold">{{ $topic->comments_count }}</p>
                        <p class="text-label-sm text-outline uppercase tracking-wider">Replies</p>
                    </div>
                    <a href="{{ route('forum.thread', $topic->id) }}" class="material-symbols-outlined text-outline hover:text-primary text-decoration-none">arrow_forward_ios</a>
                </div>
            </div>
        @empty
            <div class="text-center py-12">
                @if(request('search'))
                    <p class="text-on-surface-variant text-body-lg">"{{ request('search') }}" aramasına uygun tartışma konusu bulunamadı.</p>
                @else
                    <p class="text-on-surface-variant text-body-lg">Henüz açılmış bir tartışma konusu bulunmuyor.</p>
                @endif
            </div>
        @endforelse
    </div>
</main>

<x-footer class="bg-surface-container-low border-t border-border-light mt-stack-lg" />
@endsection
