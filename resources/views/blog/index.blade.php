@extends('layouts.app')

@section('title', 'Articles & Insights | DevConnect')
@section('body-class', 'bg-surface text-on-surface min-h-screen flex flex-col')

@section('content')
<!-- TopNavBar -->
<x-navigation active="articles" class="bg-surface-container-lowest border-b border-border-light" />

<header class="bg-surface-container-low border-b border-border-light py-12">
    <div class="max-w-container-max mx-auto px-margin-desktop text-center md:text-left">
        <h1 class="text-headline-xl font-headline-xl text-on-surface">Articles & Insights</h1>
        <p class="text-body-lg font-body-lg text-on-surface-variant mt-2 max-w-2xl">Discover deep dives, tutorials, and latest articles written by developers for developers.</p>
    </div>
</header>

<main class="flex-grow max-w-container-max mx-auto px-margin-desktop py-stack-lg w-full">
    <!-- Category Filtering -->
    <div class="flex items-center gap-stack-sm overflow-x-auto pb-4 scrollbar-hide mb-stack-lg">
        <a href="{{ route('blog.index') }}" 
           class="whitespace-nowrap px-stack-md py-2 rounded-full text-label-md font-label-md {{ !request('category') ? 'bg-primary text-on-primary font-bold' : 'bg-surface-container-highest text-on-surface-variant hover:bg-secondary-container font-medium' }} transition-colors text-decoration-none">
            All Topics
        </a>
        @foreach($categories as $category)
            <a href="{{ route('blog.index', ['category' => $category->slug]) }}" 
               class="whitespace-nowrap px-stack-md py-2 rounded-full text-label-md font-label-md {{ request('category') === $category->slug ? 'bg-primary text-on-primary font-bold' : 'bg-surface-container-highest text-on-surface-variant hover:bg-secondary-container font-medium' }} transition-colors text-decoration-none">
                {{ $category->name }}
            </a>
        @endforeach
    </div>

    <!-- Articles Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-gutter">
        @forelse($posts as $post)
            <article class="group bg-surface-container-lowest border border-border-light rounded-xl overflow-hidden flex flex-col hover:shadow-lg transition-all duration-300">
                <div class="h-48 overflow-hidden relative">
                    <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="{{ $post->title }}" src="{{ $post->cover_image ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuAdA8VWix3PUFWD42jCNKrnd6Fm7xOddh4qbiygSrLeJkL1empJw8g_bIXbtYNxIaYawkVyyZDf3yJV4sVUx51kJRErlV0yqvGliG7sA1wkS9TdBXI5jGIIQtEZRJZ7DzQcsXU3OizgTeEs7Y2ffT3TvC9uUQxlRSJeuZDtP3cj6YxysWpi1yfT6V7EH5K0VqltlmSvFtR_1-Xc1ost1I-tn9f-9XZex_lFzBmkt-LnEX9UAcUi7edIfPvQKQABik_4ob9cTFYAatQ' }}"/>
                </div>
                <div class="p-stack-md flex flex-col justify-between flex-grow">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <span class="bg-primary-fixed text-on-primary-fixed-variant px-2 py-0.5 rounded text-label-sm font-label-sm">{{ $post->category?->name ?? 'Web Development' }}</span>
                            <span class="text-outline text-label-sm font-label-sm">5 min read</span>
                        </div>
                        <h3 class="text-headline-md font-headline-md text-on-surface group-hover:text-primary transition-colors line-clamp-2">
                            <a href="{{ route('blog.show', $post->id) }}">{{ $post->title }}</a>
                        </h3>
                        <p class="text-body-md font-body-md text-on-surface-variant line-clamp-3 mt-2">{{ Str::limit(strip_tags($post->content), 120) }}</p>
                    </div>
                    <div class="flex items-center justify-between mt-4 border-t border-border-light pt-4">
                        <div class="flex items-center gap-3">
                            <img alt="Author avatar" class="w-8 h-8 rounded-full" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDvJbJyU0-zx7RUYmkBEu7k0RxVCyA3-jgOxVAZWSZW5iTwUktVZCwvb48KN0M_pZAeRqRvBhJL4EkgKsWoF06oBBYlsqKvWwXldCMXthPEiRcEWlGRG3RxzjzHWaz3WKX618qm8FQdg7XLWY8RPWWp_0uptR7OoaA0RZcMpDQigkVr2KJJNY-quXycu6-PQ7si2V24SMrQnolu1Mh0mrNAz0CRdK6CuyykacXaFs0nhm7DRNlkPHM2YcmaWRn4yKI26J_Z6KjqxoE"/>
                            <div>
                                <p class="text-label-md font-label-md font-bold text-on-surface">{{ $post->user?->name ?? 'Anonim' }}</p>
                                <p class="text-label-sm font-label-sm text-outline">{{ $post->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                        <button class="material-symbols-outlined text-outline hover:text-primary" data-icon="bookmark">bookmark</button>
                    </div>
                </div>
            </article>
        @empty
            <div class="col-span-full text-center py-12">
                <p class="text-on-surface-variant text-body-lg">Henüz yayınlanmış bir blog yazısı bulunmuyor.</p>
            </div>
        @endforelse
    </div>
</main>

<x-footer class="bg-surface-container-low border-t border-border-light mt-stack-lg" />
@endsection
