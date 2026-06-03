@extends('layouts.app')

@section('title', 'DevConnect - ' . $topic->title)
@section('body-class', 'bg-background text-on-surface font-body-md selection:bg-primary-container selection:text-on-primary-container min-h-screen flex flex-col')

@push('styles')
    <style>
        .code-block {
            background-color: #1e293b;
            color: #e2e8f0;
            padding: 1.25rem;
            border-radius: 0.5rem;
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
            font-size: 0.875rem;
            line-height: 1.5;
            overflow-x: auto;
        }
        .code-keyword { color: #818cf8; }
        .code-string { color: #34d399; }
        .code-comment { color: #94a3b8; }
    </style>
@endpush

@section('content')
<!-- Header Navigation -->
<x-navigation active="discussions" />
<main class="flex-grow mt-16 pt-stack-lg pb-24 px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto">
    <!-- Thread Header -->
    <div class="mb-stack-lg relative overflow-hidden rounded-xl border border-outline-variant bg-white p-8">
        <div class="absolute top-0 right-0 w-full h-full opacity-5 pointer-events-none" style="background-image: url('https://lh3.googleusercontent.com/aida/ADBb0uj8LJ9OR-xxsV8FHCY0MpAbXz3F5eqlD7PNy53-tJCTmjouI3XGFYrpd09YqjkPvP8KJUbihsgC56zMtPcqjCpH6Q822arAdRDI8UI21P8mtm5nhs52U6mGpEPj2Ls1t7BYT6Xmi67VmqYnWg5uRVRwvaLXVvYSwnTBfaGQdBtbTasPZvoKnkkekX5FZuUag9GxVCiJzDHJjfVMjT9kpsRG8ojHf7mn2MyNNWXEwI1y9SbT76xvEz31LlQ'); background-size: cover; background-position: center;"></div>
        <div class="relative z-10">
            <div class="flex gap-2 mb-stack-sm">
                <span class="px-3 py-1 bg-primary-fixed text-primary font-label-sm text-label-sm rounded-full">{{ $topic->category?->name ?? 'General' }}</span>
            </div>
            <h1 class="font-headline-xl text-headline-xl md:text-headline-xl mb-4 text-on-surface max-w-4xl">
                {{ $topic->title }}
            </h1>
            <div class="flex items-center gap-3 text-on-surface-variant">
                <a href="{{ route('profile', $topic->user_id) }}">
                    <img alt="{{ $topic->user?->name ?? 'User' }} profile" class="w-10 h-10 rounded-full border border-outline-variant object-cover" src="https://lh3.googleusercontent.com/aida/ADBb0ugBP2tSik5MFhuWgvgVUCGkxdJWCNaj9ffO0pT34K5MCS9Si4Yxj7oCLUeX1fbmXK9YdXQJ70Dys4iYvLdpR3LW2iHdeHEv_Rw8G1vOwHAkIJKwTyzha-Ebfnwh9zpuM_W7gFw1vmZ6zO-axiFlDkeTqwuD1guH6x00xri9J7A2AH7_WI9_XPABJu1qdofrhMacQkQFjaVz3PpgRDUv6F3yxJ6EDXLf8pENVDM94pwWelJtV_y8ggTZHg"/>
                </a>
                <div>
                    <a href="{{ route('profile', $topic->user_id) }}" class="font-label-md text-label-md text-on-surface hover:underline text-decoration-none">{{ $topic->user?->name ?? 'Anonim' }}</a>
                    <p class="font-label-sm text-label-sm">Posted {{ $topic->created_at->diffForHumans() }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="flex flex-col md:flex-row gap-gutter">
        <!-- Main Content Area -->
        <div class="flex-1 space-y-gutter">
            <!-- Original Post Card -->
            <div class="flex gap-gutter bg-white p-gutter rounded-xl border border-outline-variant">
                <!-- Voting Widget -->
                @php
                    $topicVote = $topic->userVoteValue(auth()->user());
                    $isBookmarked = $topic->isBookmarkedBy(auth()->user());
                @endphp
                <div class="flex flex-col items-center gap-2" 
                     data-id="{{ $topic->id }}" 
                     data-type="topic" 
                     data-vote-url="{{ route('forum.topic.vote', $topic->id) }}"
                     data-bookmark-url="{{ route('forum.topic.bookmark', $topic->id) }}"
                     data-user-vote="{{ $topicVote ?? 0 }}">
                    <button type="button" onclick="vote(this, 'up')" class="w-10 h-10 flex items-center justify-center rounded-lg hover:bg-surface-hover transition-colors {{ $topicVote === 1 ? 'text-primary' : 'text-outline hover:text-primary' }}">
                        <span class="material-symbols-outlined text-3xl" style="{{ $topicVote === 1 ? "font-variation-settings: 'FILL' 1;" : '' }}">expand_less</span>
                    </button>
                    <span class="font-headline-md text-headline-md text-primary font-bold">{{ $topic->score }}</span>
                    <button type="button" onclick="vote(this, 'down')" class="w-10 h-10 flex items-center justify-center rounded-lg hover:bg-surface-hover transition-colors {{ $topicVote === -1 ? 'text-error' : 'text-outline hover:text-error' }}">
                        <span class="material-symbols-outlined text-3xl" style="{{ $topicVote === -1 ? "font-variation-settings: 'FILL' 1;" : '' }}">expand_more</span>
                    </button>
                    <button type="button" onclick="toggleBookmark(this)" class="mt-4 p-2 transition-colors {{ $isBookmarked ? 'text-primary' : 'text-outline hover:text-primary' }}" title="Bookmark this thread">
                        <span class="material-symbols-outlined" style="{{ $isBookmarked ? "font-variation-settings: 'FILL' 1;" : '' }}">bookmark</span>
                    </button>
                </div>
                <!-- Post Body -->
                <div class="flex-1 flex flex-col justify-between">
                    <div class="prose prose-slate max-w-none text-body-lg font-body-lg text-on-surface-variant leading-relaxed mb-6">
                        {!! nl2br(e($topic->content)) !!}
                    </div>
                    
                    <div class="flex items-center justify-end gap-2 border-t border-outline-variant pt-4">
                        @can('update', $topic)
                            <a href="{{ route('forum.edit', $topic->id) }}" class="px-3.5 py-1.5 bg-surface-container text-on-surface-variant hover:bg-surface-container-high rounded-lg font-label-md text-label-md transition-colors flex items-center gap-1.5 text-decoration-none border border-outline-variant">
                                <span class="material-symbols-outlined text-[18px]">edit</span>
                                <span>Edit</span>
                            </a>
                        @endcan
                        @can('delete', $topic)
                            <form action="{{ route('forum.destroy', $topic->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this topic?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3.5 py-1.5 bg-red-50 text-red-700 hover:bg-red-100 rounded-lg font-label-md text-label-md transition-colors flex items-center gap-1.5 border border-red-200">
                                    <span class="material-symbols-outlined text-[18px]">delete</span>
                                    <span>Delete</span>
                                </button>
                            </form>
                        @endcan
                    </div>
                </div>
            </div>
            <!-- Answers Header -->
            <div class="flex items-center justify-between border-b border-outline-variant pb-stack-sm">
                <h2 class="font-headline-lg text-headline-lg">{{ $topic->comments->count() }} Answers</h2>
                <div class="flex items-center gap-2">
                    <span class="text-label-md font-label-md text-on-surface-variant">Sort by:</span>
                    <select class="bg-transparent border-none focus:ring-0 text-primary font-label-md text-label-md cursor-pointer">
                        <option>Highest Score</option>
                        <option>Latest</option>
                    </select>
                </div>
            </div>
            @php
                $sortedComments = $topic->comments->sortByDesc(function ($comment) use ($topic) {
                    if ($comment->id === $topic->solution_comment_id) {
                        return 1000000000;
                    }
                    return $comment->score;
                });
                $canManageSolution = auth()->check() && (
                    auth()->id() === $topic->user_id || 
                    in_array(auth()->user()->role?->value ?? auth()->user()->role, ['admin', 'moderator', 'developer'])
                );
            @endphp
            @forelse($sortedComments as $index => $reply)
                @php
                    $replyVote = $reply->userVoteValue(auth()->user());
                @endphp
                @if($topic->solution_comment_id === $reply->id)
                    <!-- Accepted Answer -->
                    <div class="relative bg-white p-gutter rounded-xl border-2 border-emerald-100 shadow-sm ring-1 ring-emerald-500/20" data-comment-id="{{ $reply->id }}">
                        <div class="absolute top-4 right-4 flex items-center gap-1.5">
                            @if($canManageSolution)
                                <button type="button" onclick="toggleSolution({{ $reply->id }})" class="flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-700 rounded-full border border-emerald-200 hover:bg-emerald-100 transition-colors" title="Unmark as solution">
                                    <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                                    <span class="font-label-sm text-label-sm font-bold">Verified Solution</span>
                                </button>
                            @else
                                <div class="flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-700 rounded-full border border-emerald-100">
                                    <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                                    <span class="font-label-sm text-label-sm font-bold">Verified Solution</span>
                                </div>
                            @endif
                        </div>
                        <div class="flex gap-gutter">
                            <div class="flex flex-col items-center gap-2"
                                 data-id="{{ $reply->id }}" 
                                 data-type="reply" 
                                 data-vote-url="{{ route('forum.reply.vote', $reply->id) }}"
                                 data-user-vote="{{ $replyVote ?? 0 }}">
                                <button type="button" onclick="vote(this, 'up')" class="w-10 h-10 flex items-center justify-center rounded-lg hover:bg-surface-hover transition-colors {{ $replyVote === 1 ? 'text-primary' : 'text-outline hover:text-primary' }}">
                                    <span class="material-symbols-outlined text-3xl" style="{{ $replyVote === 1 ? "font-variation-settings: 'FILL' 1;" : '' }}">expand_less</span>
                                </button>
                                <span class="font-headline-md text-headline-md text-on-surface font-bold">{{ $reply->score }}</span>
                                <button type="button" onclick="vote(this, 'down')" class="w-10 h-10 flex items-center justify-center rounded-lg hover:bg-surface-hover transition-colors {{ $replyVote === -1 ? 'text-error' : 'text-outline hover:text-error' }}">
                                    <span class="material-symbols-outlined text-3xl" style="{{ $replyVote === -1 ? "font-variation-settings: 'FILL' 1;" : '' }}">expand_more</span>
                                </button>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-4">
                                    <div class="w-8 h-8 rounded-full bg-primary-container flex items-center justify-center text-on-primary-container font-bold text-xs">
                                        {{ strtoupper(substr($reply->user?->name ?? 'A', 0, 2)) }}
                                    </div>
                                    <span class="font-label-md text-label-md text-on-surface">{{ $reply->user?->name ?? 'Anonim' }}</span>
                                    <span class="text-on-surface-variant text-label-sm font-label-sm">• {{ $reply->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="prose prose-slate max-w-none text-body-md font-body-md text-on-surface-variant mr-24">
                                    {!! nl2br(e($reply->content)) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Standard Answer -->
                    <div class="relative bg-white p-gutter rounded-xl border border-outline-variant" data-comment-id="{{ $reply->id }}">
                        @if($canManageSolution)
                            <div class="absolute top-4 right-4">
                                <button type="button" onclick="toggleSolution({{ $reply->id }})" class="flex items-center gap-1.5 px-3 py-1 bg-surface-container text-outline hover:text-emerald-700 hover:bg-emerald-50 rounded-full border border-outline hover:border-emerald-200 transition-colors" title="Mark as solution">
                                    <span class="material-symbols-outlined text-sm">check_circle</span>
                                    <span class="font-label-sm text-label-sm font-bold">Mark as Solution</span>
                                </button>
                            </div>
                        @endif
                        <div class="flex gap-gutter">
                            <div class="flex flex-col items-center gap-2"
                                 data-id="{{ $reply->id }}" 
                                 data-type="reply" 
                                 data-vote-url="{{ route('forum.reply.vote', $reply->id) }}"
                                 data-user-vote="{{ $replyVote ?? 0 }}">
                                <button type="button" onclick="vote(this, 'up')" class="w-10 h-10 flex items-center justify-center rounded-lg hover:bg-surface-hover transition-colors {{ $replyVote === 1 ? 'text-primary' : 'text-outline hover:text-primary' }}">
                                    <span class="material-symbols-outlined text-3xl" style="{{ $replyVote === 1 ? "font-variation-settings: 'FILL' 1;" : '' }}">expand_less</span>
                                </button>
                                <span class="font-headline-md text-headline-md text-on-surface font-bold">{{ $reply->score }}</span>
                                <button type="button" onclick="vote(this, 'down')" class="w-10 h-10 flex items-center justify-center rounded-lg hover:bg-surface-hover transition-colors {{ $replyVote === -1 ? 'text-error' : 'text-outline hover:text-error' }}">
                                    <span class="material-symbols-outlined text-3xl" style="{{ $replyVote === -1 ? "font-variation-settings: 'FILL' 1;" : '' }}">expand_more</span>
                                </button>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-4">
                                    <div class="w-8 h-8 rounded-full bg-secondary-container flex items-center justify-center text-on-secondary-container font-bold text-xs">
                                        {{ strtoupper(substr($reply->user?->name ?? 'A', 0, 2)) }}
                                    </div>
                                    <span class="font-label-md text-label-md text-on-surface">{{ $reply->user?->name ?? 'Anonim' }}</span>
                                    <span class="text-on-surface-variant text-label-sm font-label-sm">• {{ $reply->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="prose prose-slate max-w-none text-body-md font-body-md text-on-surface-variant mr-32">
                                    {!! nl2br(e($reply->content)) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @empty
                <p class="text-on-surface-variant text-sm text-center py-4">Henüz yanıt yazılmamış. İlk yanıtı siz yazın!</p>
            @endforelse
            <!-- Write a Reply Section -->
            @if($topic->is_locked)
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-6 flex items-start gap-4 text-amber-900 shadow-sm mb-gutter">
                    <span class="material-symbols-outlined text-[32px] text-amber-700 mt-1">lock</span>
                    <div>
                        <h4 class="font-headline-sm text-headline-sm font-bold">This topic is locked</h4>
                        <p class="font-body-md text-body-md text-amber-800/90 mt-1">This discussion has been locked by a moderator or administrator. You cannot post new replies to this thread.</p>
                    </div>
                </div>
            @else
                <form action="{{ route('forum.reply', $topic->id) }}" method="POST" class="bg-white p-gutter rounded-xl border border-outline-variant shadow-sm">
                    @csrf
                    <h3 class="font-headline-md text-headline-md mb-gutter">Write a Reply</h3>
                    <div class="border border-outline-variant rounded-lg overflow-hidden">
                        <div class="bg-surface-container border-b border-outline-variant px-4 py-2 flex items-center gap-2">
                            <button type="button" onclick="insertFormat('**', '**')" class="p-1.5 hover:bg-surface-variant rounded text-on-surface-variant" title="Bold">
                                <span class="material-symbols-outlined">format_bold</span>
                            </button>
                            <button type="button" onclick="insertFormat('*', '*')" class="p-1.5 hover:bg-surface-variant rounded text-on-surface-variant" title="Italic">
                                <span class="material-symbols-outlined">format_italic</span>
                            </button>
                            <button type="button" onclick="insertFormat('```\n', '\n```')" class="p-1.5 hover:bg-surface-variant rounded text-on-surface-variant" title="Code">
                                <span class="material-symbols-outlined">code</span>
                            </button>
                            <button type="button" onclick="insertFormat('![', '](url)')" class="p-1.5 hover:bg-surface-variant rounded text-on-surface-variant" title="Image">
                                <span class="material-symbols-outlined">image</span>
                            </button>
                            <button type="button" onclick="insertFormat('[', '](url)')" class="p-1.5 hover:bg-surface-variant rounded text-on-surface-variant" title="Link">
                                <span class="material-symbols-outlined">link</span>
                            </button>
                        </div>
                        <textarea name="reply" id="reply-textarea" class="w-full min-h-[200px] p-4 border-none focus:ring-0 text-body-md font-body-md resize-y" placeholder="Type your response here..." required></textarea>
                    </div>
                    <div class="mt-gutter flex justify-end gap-stack-md">
                        <button type="button" class="px-6 py-2 text-primary font-label-md text-label-md hover:bg-primary-fixed rounded-lg transition-all">Save as Draft</button>
                        <button type="submit" class="px-8 py-2 bg-primary text-on-primary font-label-md text-label-md rounded-lg shadow-lg hover:shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all">Post Reply</button>
                    </div>
                </form>
            @endif
        </div>
        <!-- Sidebar -->
        <aside class="hidden lg:block w-80 space-y-gutter">
            <!-- Thread Stats -->
            <div class="bg-white p-stack-lg rounded-xl border border-outline-variant">
                <h4 class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider mb-4">Thread Statistics</h4>
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-on-surface-variant text-label-md">Status</span>
                        @if($topic->comments->count() > 0)
                            <span class="text-emerald-600 font-bold text-label-md">Solved</span>
                        @else
                            <span class="text-amber-600 font-bold text-label-md">Open</span>
                        @endif
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-on-surface-variant text-label-md">Replies</span>
                        <span class="text-on-surface font-bold text-label-md">{{ $topic->comments->count() }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-on-surface-variant text-label-md">Participants</span>
                        <span class="text-on-surface font-bold text-label-md">{{ $topic->comments->pluck('user_id')->push($topic->user_id)->unique()->count() }}</span>
                    </div>
                </div>
            </div>
            <!-- Related Discussions -->
            <div class="bg-white p-stack-lg rounded-xl border border-outline-variant">
                <h4 class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider mb-4">Related Discussions</h4>
                <div class="space-y-6">
                    @forelse($relatedTopics as $related)
                        <a class="block group text-decoration-none" href="{{ route('forum.thread', $related->id) }}">
                            <p class="text-body-md font-semibold text-on-surface group-hover:text-primary transition-colors line-clamp-2">{{ $related->title }}</p>
                            <span class="text-label-sm text-on-surface-variant">{{ $related->comments_count }} replies • {{ $related->created_at->diffForHumans() }}</span>
                        </a>
                    @empty
                        <p class="text-on-surface-variant text-sm">Benzer tartışma bulunamadı.</p>
                    @endforelse
                </div>
            </div>
            <!-- Community Guidelines -->
            <div class="bg-surface-container p-stack-lg rounded-xl border border-outline-variant">
                <div class="flex items-center gap-2 mb-2">
                    <span class="material-symbols-outlined text-primary">info</span>
                    <h4 class="font-label-md text-label-md font-bold">Community Tips</h4>
                </div>
                <p class="text-label-sm text-on-surface-variant">Be respectful and provide clear code examples when suggesting solutions. Help our community grow!</p>
            </div>
        </aside>
    </div>
</main>
<!-- Footer -->
<x-footer class="bg-surface-container border-t border-outline-variant" />
@endsection

@push('scripts')
<script>
window.isAuthenticated = {{ auth()->check() ? 'true' : 'false' }};

// Dynamic Upvoting / Downvoting Logic
function vote(button, direction) {
    if (!window.isAuthenticated) {
        window.location.href = "{{ route('login') }}";
        return;
    }

    const container = button.closest('[data-vote-url]');
    if (!container) return;

    const voteUrl = container.getAttribute('data-vote-url');
    const currentVote = parseInt(container.getAttribute('data-user-vote') || '0');
    const scoreEl = container.querySelector('span.font-bold');
    const currentScore = parseInt(scoreEl.textContent);

    let newVote = 0;
    if (direction === 'up') {
        newVote = (currentVote === 1) ? 0 : 1;
    } else if (direction === 'down') {
        newVote = (currentVote === -1) ? 0 : -1;
    }

    // Optimistic UI updates
    const scoreDiff = newVote - currentVote;
    const optimisticScore = currentScore + scoreDiff;
    scoreEl.textContent = optimisticScore;
    container.setAttribute('data-user-vote', newVote);

    const upBtn = container.querySelector('button[onclick*="\'up\'"]');
    const downBtn = container.querySelector('button[onclick*="\'down\'"]');

    // Update buttons UI
    if (newVote === 1) {
        upBtn.classList.add('text-primary');
        upBtn.classList.remove('text-outline');
        upBtn.querySelector('span').style.fontVariationSettings = "'FILL' 1";

        downBtn.classList.add('text-outline');
        downBtn.classList.remove('text-error');
        downBtn.querySelector('span').style.fontVariationSettings = "'FILL' 0";
    } else if (newVote === -1) {
        upBtn.classList.add('text-outline');
        upBtn.classList.remove('text-primary');
        upBtn.querySelector('span').style.fontVariationSettings = "'FILL' 0";

        downBtn.classList.add('text-error');
        downBtn.classList.remove('text-outline');
        downBtn.querySelector('span').style.fontVariationSettings = "'FILL' 1";
    } else {
        upBtn.classList.add('text-outline');
        upBtn.classList.remove('text-primary');
        upBtn.querySelector('span').style.fontVariationSettings = "'FILL' 0";

        downBtn.classList.add('text-outline');
        downBtn.classList.remove('text-error');
        downBtn.querySelector('span').style.fontVariationSettings = "'FILL' 0";
    }

    // Ajax request
    fetch(voteUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        },
        body: JSON.stringify({ value: newVote })
    })
    .then(response => {
        if (!response.ok) throw new Error('Network response was not ok');
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Keep the server response values
            scoreEl.textContent = data.score;
            container.setAttribute('data-user-vote', data.user_vote === null ? 0 : data.user_vote);
        } else {
            throw new Error('Vote failed');
        }
    })
    .catch(error => {
        console.error('Error voting:', error);
        // Revert UI to original state
        scoreEl.textContent = currentScore;
        container.setAttribute('data-user-vote', currentVote);
        
        // Revert buttons classes/styles
        if (currentVote === 1) {
            upBtn.classList.add('text-primary');
            upBtn.classList.remove('text-outline');
            upBtn.querySelector('span').style.fontVariationSettings = "'FILL' 1";

            downBtn.classList.add('text-outline');
            downBtn.classList.remove('text-error');
            downBtn.querySelector('span').style.fontVariationSettings = "'FILL' 0";
        } else if (currentVote === -1) {
            upBtn.classList.add('text-outline');
            upBtn.classList.remove('text-primary');
            upBtn.querySelector('span').style.fontVariationSettings = "'FILL' 0";

            downBtn.classList.add('text-error');
            downBtn.classList.remove('text-outline');
            downBtn.querySelector('span').style.fontVariationSettings = "'FILL' 1";
        } else {
            upBtn.classList.add('text-outline');
            upBtn.classList.remove('text-primary');
            upBtn.querySelector('span').style.fontVariationSettings = "'FILL' 0";

            downBtn.classList.add('text-outline');
            downBtn.classList.remove('text-error');
            downBtn.querySelector('span').style.fontVariationSettings = "'FILL' 0";
        }
    });
}

// Toggle Bookmark
function toggleBookmark(button) {
    if (!window.isAuthenticated) {
        window.location.href = "{{ route('login') }}";
        return;
    }

    const container = button.closest('[data-bookmark-url]');
    if (!container) return;

    const bookmarkUrl = container.getAttribute('data-bookmark-url');
    const icon = button.querySelector('span');
    const wasBookmarked = button.classList.contains('text-primary');

    // Optimistic UI updates
    if (wasBookmarked) {
        button.classList.remove('text-primary');
        button.classList.add('text-outline');
        icon.style.fontVariationSettings = "'FILL' 0";
    } else {
        button.classList.add('text-primary');
        button.classList.remove('text-outline');
        icon.style.fontVariationSettings = "'FILL' 1";
    }

    fetch(bookmarkUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) throw new Error('Network response was not ok');
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Apply final server-returned state
            if (data.bookmarked) {
                button.classList.add('text-primary');
                button.classList.remove('text-outline');
                icon.style.fontVariationSettings = "'FILL' 1";
            } else {
                button.classList.remove('text-primary');
                button.classList.add('text-outline');
                icon.style.fontVariationSettings = "'FILL' 0";
            }
        } else {
            throw new Error('Bookmark failed');
        }
    })
    .catch(error => {
        console.error('Error bookmarking:', error);
        // Revert
        if (wasBookmarked) {
            button.classList.add('text-primary');
            button.classList.remove('text-outline');
            icon.style.fontVariationSettings = "'FILL' 1";
        } else {
            button.classList.remove('text-primary');
            button.classList.add('text-outline');
            icon.style.fontVariationSettings = "'FILL' 0";
        }
    });
}

// Toggle Solution
function toggleSolution(commentId) {
    if (!window.isAuthenticated) {
        window.location.href = "{{ route('login') }}";
        return;
    }

    const solutionUrl = "{{ route('forum.topic.solution', $topic->id) }}";

    fetch(solutionUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        },
        body: JSON.stringify({ comment_id: commentId })
    })
    .then(response => {
        if (!response.ok) throw new Error('Network response was not ok');
        return response.json();
    })
    .then(data => {
        if (data.success) {
            window.location.reload();
        } else {
            throw new Error('Solution toggle failed');
        }
    })
    .catch(error => {
        console.error('Error toggling solution:', error);
        alert('Çözüm işaretleme işlemi sırasında bir hata oluştu.');
    });
}

// Code Copy Function
function copyCode(button) {
    const codeBlock = button.closest('.code-block');
    // Get text content excluding the copy button itself
    const text = codeBlock.innerText.replace('content_copy', '').trim();
    navigator.clipboard.writeText(text).then(() => {
        const icon = button.querySelector('.material-symbols-outlined');
        icon.textContent = 'check';
        setTimeout(() => {
            icon.textContent = 'content_copy';
        }, 2000);
    });
}

// Markdown formatting helper
const textarea = document.getElementById('reply-textarea');
if (textarea) {
    window.insertFormat = function(before, after = '') {
        const start = textarea.selectionStart;
        const end = textarea.selectionEnd;
        const text = textarea.value;
        const selected = text.substring(start, end);
        const replacement = before + selected + after;
        textarea.value = text.substring(0, start) + replacement + text.substring(end);
        textarea.focus();
        textarea.setSelectionRange(start + before.length, start + before.length + selected.length);
    }
}
</script>
@endpush
