@extends('layouts.app')

@section('title', 'DevConnect | Community Dashboard')
@section('body-class', 'bg-surface text-on-surface min-h-screen flex flex-col')

@section('content')
<!-- TopNavBar -->
<x-navigation active="feed" class="bg-surface-container-lowest border-b border-border-light" />
<main class="flex-grow max-w-container-max mx-auto px-margin-desktop py-stack-lg w-full">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-gutter">
        <!-- Left Column (Main Feed) -->
        <section class="lg:col-span-3 space-y-stack-lg">
            <!-- Category Filtering -->
            <div class="flex items-center gap-stack-sm overflow-x-auto pb-2 scrollbar-hide">
                <button class="whitespace-nowrap px-stack-md py-2 bg-primary text-on-primary rounded-full text-label-md font-label-md font-bold">All Topics</button>
                @foreach($categories as $category)
                    <button class="whitespace-nowrap px-stack-md py-2 bg-surface-container-highest text-on-surface-variant hover:bg-secondary-container transition-colors rounded-full text-label-md font-label-md font-medium">{{ $category->name }}</button>
                @endforeach
            </div>
            <!-- Trending Blog Posts Feed -->
            <div class="space-y-stack-md">
                @forelse($posts as $post)
                    <article class="group bg-surface-container-lowest border border-border-light rounded-xl overflow-hidden flex flex-col md:flex-row hover:shadow-lg transition-all duration-300">
                        <div class="md:w-64 h-48 md:h-auto overflow-hidden">
                            <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="{{ $post->cover_image ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuAdA8VWix3PUFWD42jCNKrnd6Fm7xOddh4qbiygSrLeJkL1empJw8g_bIXbtYNxIaYawkVyyZDf3yJV4sVUx51kJRErlV0yqvGliG7sA1wkS9TdBXI5jGIIQtEZRJZ7DzQcsXU3OizgTeEs7Y2ffT3TvC9uUQxlRSJeuZDtP3cj6YxysWpi1yfT6V7EH5K0VqltlmSvFtR_1-Xc1ost1I-tn9f-9XZex_lFzBmkt-LnEX9UAcUi7edIfPvQKQABik_4ob9cTFYAatQ' }}"/>
                        </div>
                        <div class="p-stack-md flex flex-col justify-between flex-1">
                            <div>
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="bg-primary-fixed text-on-primary-fixed-variant px-2 py-0.5 rounded text-label-sm font-label-sm">{{ $post->category?->name ?? 'Web Development' }}</span>
                                    <span class="text-outline text-label-sm font-label-sm">5 min read</span>
                                </div>
                                <h3 class="text-headline-md font-headline-md text-on-surface group-hover:text-primary transition-colors">
                                    <a href="{{ route('blog.show', $post->id) }}">{{ $post->title }}</a>
                                </h3>
                                <p class="text-body-md font-body-md text-on-surface-variant line-clamp-2 mt-2">{{ Str::limit(strip_tags($post->content), 150) }}</p>
                            </div>
                            <div class="flex items-center justify-between mt-4">
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
                    <p class="text-on-surface-variant text-center py-8">Henüz yayınlanmış bir blog yazısı bulunmuyor.</p>
                @endforelse
            </div>
        </section>
        <!-- Right Column (Sidebar) -->
        <aside class="space-y-stack-lg">
            <!-- Action Button -->
            <a href="{{ route('blog.create') }}" class="w-full bg-primary text-on-primary py-4 rounded-xl font-bold shadow-md hover:opacity-90 transition-all flex items-center justify-center gap-2">
                <span class="material-symbols-outlined" data-icon="add_circle">add_circle</span>
                Create Post
            </a>
            <!-- New Topics -->
            <div class="bg-surface-container-low border border-border-light rounded-xl p-stack-md">
                <div class="flex items-center justify-between mb-stack-md">
                    <h4 class="text-headline-md font-headline-md text-on-surface">New Topics</h4>
                    <span class="material-symbols-outlined text-outline" data-icon="forum">forum</span>
                </div>
                <ul class="space-y-4">
                    @forelse($topics as $topic)
                        <li class="group cursor-pointer">
                            <p class="text-label-md font-label-md font-bold text-on-surface group-hover:text-primary transition-colors">
                                <a href="{{ route('forum.thread', $topic->id) }}">{{ $topic->title }}</a>
                            </p>
                            <div class="flex items-center mt-2 gap-stack-sm">
                                <span class="text-label-sm font-label-sm text-outline">{{ $topic->comments_count }} replies</span>
                            </div>
                        </li>
                    @empty
                        <li class="text-on-surface-variant text-sm">Henüz yeni bir konu açılmadı.</li>
                    @endforelse
                </ul>
            </div>
            <!-- Recent Comments -->
            <div class="bg-surface-container-low border border-border-light rounded-xl p-stack-md">
                <h4 class="text-headline-md font-headline-md text-on-surface mb-stack-md">Recent Activity</h4>
                <div class="space-y-stack-md">
                    @forelse($recentActivities as $activity)
                        <div class="flex gap-3">
                            <img alt="User" class="w-6 h-6 rounded-full" src="https://lh3.googleusercontent.com/aida-public/AB6AXuC4g1_3C_3dfx7Ws7jLqzZ5JcjElh2KEtQhhiLz_0T3Ykh2ZZHqdz4ZBfbGezFbI2WEsz7yHasazuAPlMNVy-qJCTmrxZYJQwh9AQFvZ7-I6v5ppO6-4vZRpIC-zDuKdg9T3ocrR1Xx9R3kLeiURj0_7J26YeIDRkD-yy3cKwmTwXyyVQJqRXBc7CzhMDRY3TfbL-G7UtzR2r5Nvf6YDjdZHjB4m7KHxNtsyGdEe7_cKQBK1vqrurpXgbwo31G2jI3zxM2JyjGpUWU"/>
                            <div>
                                <p class="text-label-md font-label-md text-on-surface-variant">
                                    <span class="font-bold text-on-surface">{{ $activity->user?->name ?? 'Anonim' }}</span> 
                                    commented on 
                                    <span class="text-primary font-medium">
                                        @if($activity->commentable_type === \App\Models\Post::class)
                                            <a href="{{ route('blog.show', $activity->commentable_id) }}">{{ Str::limit($activity->commentable?->title, 30) }}</a>
                                        @else
                                            <a href="{{ route('forum.thread', $activity->commentable_id) }}">{{ Str::limit($activity->commentable?->title, 30) }}</a>
                                        @endif
                                    </span>
                                </p>
                                <p class="text-label-sm font-label-sm text-outline">{{ $activity->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-on-surface-variant text-sm">Henüz bir aktivite yok.</p>
                    @endforelse
                </div>
            </div>
        </aside>
    </div>
</main>
<!-- Footer / Blog Statistics Widget -->
<section class="bg-surface-container-low border-t border-border-light mt-stack-lg py-stack-lg">
    <div class="max-w-container-max mx-auto px-margin-desktop">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-gutter text-center">
            <div class="p-stack-md rounded-xl bg-surface-container-lowest border border-border-light">
                <p class="text-label-md font-label-md text-outline uppercase tracking-wider">Total Members</p>
                <p class="text-headline-xl font-headline-xl text-primary mt-1">{{ number_format($stats['total_members']) }}</p>
                <div class="h-1 w-12 bg-primary-fixed mx-auto mt-2 rounded-full"></div>
            </div>
            <div class="p-stack-md rounded-xl bg-surface-container-lowest border border-border-light">
                <p class="text-label-md font-label-md text-outline uppercase tracking-wider">Active Discussions</p>
                <p class="text-headline-xl font-headline-xl text-primary mt-1">{{ number_format($stats['active_discussions']) }}</p>
                <div class="h-1 w-12 bg-primary-fixed mx-auto mt-2 rounded-full"></div>
            </div>
            <div class="p-stack-md rounded-xl bg-surface-container-lowest border border-border-light">
                <p class="text-label-md font-label-md text-outline uppercase tracking-wider">Articles Published</p>
                <p class="text-headline-xl font-headline-xl text-primary mt-1">{{ number_format($stats['articles_published']) }}</p>
                <div class="h-1 w-12 bg-primary-fixed mx-auto mt-2 rounded-full"></div>
            </div>
            <div class="p-stack-md rounded-xl bg-surface-container-lowest border border-border-light">
                <p class="text-label-md font-label-md text-outline uppercase tracking-wider">Solution Rate</p>
                <p class="text-headline-xl font-headline-xl text-primary mt-1">{{ $stats['solution_rate'] }}%</p>
                <div class="h-1 w-12 bg-primary-fixed mx-auto mt-2 rounded-full"></div>
            </div>
        </div>
    </div>
</section>
<x-footer class="bg-surface-container-low border-t-0 mt-0" />
@endsection
