@extends('layouts.app')

@section('title', 'Community Discussions | DevConnect')
@section('body-class', 'bg-surface text-on-surface min-h-screen flex flex-col')

@section('content')
<!-- TopNavBar -->
<x-navigation active="discussions" class="bg-surface-container-lowest border-b border-border-light" />

<header class="bg-surface-container-low border-b border-border-light py-12">
    <div class="max-w-container-max mx-auto px-margin-desktop text-center md:text-left flex flex-col md:flex-row justify-between items-center gap-4">
        <div>
            <h1 class="text-headline-xl font-headline-xl text-on-surface">Community Discussions</h1>
            <p class="text-body-lg font-body-lg text-on-surface-variant mt-2 max-w-2xl">Ask questions, share knowledge, and connect with other developers in the community.</p>
        </div>
        @auth
        <a href="{{ route('blog.create') }}" class="bg-primary text-on-primary px-6 py-3 rounded-lg font-bold hover:opacity-90 transition-all text-decoration-none flex items-center gap-2">
            <span class="material-symbols-outlined">add_circle</span>
            New Topic
        </a>
        @endauth
    </div>
</header>

<main class="flex-grow max-w-container-max mx-auto px-margin-desktop py-stack-lg w-full">
    <!-- Category Filtering -->
    <div class="flex items-center gap-stack-sm overflow-x-auto pb-4 scrollbar-hide mb-stack-lg">
        <a href="{{ route('forum.index') }}" 
           class="whitespace-nowrap px-stack-md py-2 rounded-full text-label-md font-label-md {{ !request('category') ? 'bg-primary text-on-primary font-bold' : 'bg-surface-container-highest text-on-surface-variant hover:bg-secondary-container font-medium' }} transition-colors text-decoration-none">
            All Categories
        </a>
        @foreach($categories as $category)
            <a href="{{ route('forum.index', ['category' => $category->slug]) }}" 
               class="whitespace-nowrap px-stack-md py-2 rounded-full text-label-md font-label-md {{ request('category') === $category->slug ? 'bg-primary text-on-primary font-bold' : 'bg-surface-container-highest text-on-surface-variant hover:bg-secondary-container font-medium' }} transition-colors text-decoration-none">
                {{ $category->name }}
            </a>
        @endforeach
    </div>

    <!-- Discussions List -->
    <div class="space-y-4">
        @forelse($topics as $topic)
            <div class="bg-surface-container-lowest border border-border-light p-6 rounded-xl hover:shadow-md transition-all duration-200 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div class="flex items-start gap-4">
                    <img alt="User avatar" class="w-10 h-10 rounded-full border border-border-light object-cover mt-1" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDvJbJyU0-zx7RUYmkBEu7k0RxVCyA3-jgOxVAZWSZW5iTwUktVZCwvb48KN0M_pZAeRqRvBhJL4EkgKsWoF06oBBYlsqKvWwXldCMXthPEiRcEWlGRG3RxzjzHWaz3WKX618qm8FQdg7XLWY8RPWWp_0uptR7OoaA0RZcMpDQigkVr2KJJNY-quXycu6-PQ7si2V24SMrQnolu1Mh0mrNAz0CRdK6CuyykacXaFs0nhm7DRNlkPHM2YcmaWRn4yKI26J_Z6KjqxoE"/>
                    <div>
                        <h3 class="text-headline-md font-headline-md text-on-surface hover:text-primary transition-colors">
                            <a href="{{ route('forum.thread', $topic->id) }}" class="text-decoration-none">{{ $topic->title }}</a>
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
                <p class="text-on-surface-variant text-body-lg">Henüz açılmış bir tartışma konusu bulunmuyor.</p>
            </div>
        @endforelse
    </div>
</main>

<x-footer class="bg-surface-container-low border-t border-border-light mt-stack-lg" />
@endsection
