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
<x-navigation active="discussions" class="bg-background border-b border-outline-variant fixed top-0 w-full" />
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
                <a href="{{ route('profile') }}">
                    <img alt="{{ $topic->user?->name ?? 'User' }} profile" class="w-10 h-10 rounded-full border border-outline-variant object-cover" src="https://lh3.googleusercontent.com/aida/ADBb0ugBP2tSik5MFhuWgvgVUCGkxdJWCNaj9ffO0pT34K5MCS9Si4Yxj7oCLUeX1fbmXK9YdXQJ70Dys4iYvLdpR3LW2iHdeHEv_Rw8G1vOwHAkIJKwTyzha-Ebfnwh9zpuM_W7gFw1vmZ6zO-axiFlDkeTqwuD1guH6x00xri9J7A2AH7_WI9_XPABJu1qdofrhMacQkQFjaVz3PpgRDUv6F3yxJ6EDXLf8pENVDM94pwWelJtV_y8ggTZHg"/>
                </a>
                <div>
                    <a href="{{ route('profile') }}" class="font-label-md text-label-md text-on-surface hover:underline text-decoration-none">{{ $topic->user?->name ?? 'Anonim' }}</a>
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
                <div class="flex flex-col items-center gap-2">
                    <button type="button" onclick="vote(this, 'up')" class="w-10 h-10 flex items-center justify-center rounded-lg hover:bg-surface-hover text-outline hover:text-primary transition-colors">
                        <span class="material-symbols-outlined text-3xl">expand_less</span>
                    </button>
                    <span class="font-headline-md text-headline-md text-primary font-bold">42</span>
                    <button type="button" onclick="vote(this, 'down')" class="w-10 h-10 flex items-center justify-center rounded-lg hover:bg-surface-hover text-outline hover:text-error transition-colors">
                        <span class="material-symbols-outlined text-3xl">expand_more</span>
                    </button>
                    <button type="button" onclick="toggleBookmark(this)" class="mt-4 p-2 text-outline hover:text-primary transition-colors" title="Bookmark this thread">
                        <span class="material-symbols-outlined">bookmark</span>
                    </button>
                </div>
                <!-- Post Body -->
                <div class="flex-1">
                    <div class="prose prose-slate max-w-none text-body-lg font-body-lg text-on-surface-variant leading-relaxed">
                        {!! nl2br(e($topic->content)) !!}
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
            @forelse($topic->comments as $index => $reply)
                @if($index === 0)
                    <!-- Accepted Answer -->
                    <div class="relative bg-white p-gutter rounded-xl border-2 border-emerald-100 shadow-sm ring-1 ring-emerald-500/20">
                        <div class="absolute top-4 right-4 flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-700 rounded-full border border-emerald-100">
                            <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                            <span class="font-label-sm text-label-sm font-bold">Verified Solution</span>
                        </div>
                        <div class="flex gap-gutter">
                            <div class="flex flex-col items-center gap-2">
                                <button type="button" onclick="vote(this, 'up')" class="w-10 h-10 flex items-center justify-center rounded-lg hover:bg-surface-hover text-primary">
                                    <span class="material-symbols-outlined text-3xl" style="font-variation-settings: 'FILL' 1;">expand_less</span>
                                </button>
                                <span class="font-headline-md text-headline-md text-on-surface font-bold">89</span>
                                <button type="button" onclick="vote(this, 'down')" class="w-10 h-10 flex items-center justify-center rounded-lg hover:bg-surface-hover text-outline">
                                    <span class="material-symbols-outlined text-3xl">expand_more</span>
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
                                <div class="prose prose-slate max-w-none text-body-md font-body-md text-on-surface-variant">
                                    {!! nl2br(e($reply->content)) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Standard Answer -->
                    <div class="bg-white p-gutter rounded-xl border border-outline-variant">
                        <div class="flex gap-gutter">
                            <div class="flex flex-col items-center gap-2">
                                <button type="button" onclick="vote(this, 'up')" class="w-10 h-10 flex items-center justify-center rounded-lg hover:bg-surface-hover text-outline">
                                    <span class="material-symbols-outlined text-3xl">expand_less</span>
                                </button>
                                <span class="font-headline-md text-headline-md text-on-surface font-bold">{{ 12 + $index }}</span>
                                <button type="button" onclick="vote(this, 'down')" class="w-10 h-10 flex items-center justify-center rounded-lg hover:bg-surface-hover text-outline">
                                    <span class="material-symbols-outlined text-3xl">expand_more</span>
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
                                <div class="prose prose-slate max-w-none text-body-md font-body-md text-on-surface-variant">
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
// Dynamic Upvoting / Downvoting Logic
function vote(button, direction) {
    const scoreEl = button.closest('.flex-col').querySelector('span.font-bold');
    let currentScore = parseInt(scoreEl.textContent);
    
    const isUpvoted = button.classList.contains('text-primary') || (button.querySelector('span').style.fontVariationSettings && button.querySelector('span').style.fontVariationSettings.includes("'FILL' 1"));
    const isDownvoted = button.classList.contains('text-error');
    
    if (direction === 'up') {
        if (isUpvoted) {
            // Cancel upvote
            currentScore -= 1;
            button.classList.remove('text-primary');
            button.querySelector('span').style.fontVariationSettings = "'FILL' 0";
        } else {
            // Apply upvote
            currentScore += isDownvoted ? 2 : 1;
            button.classList.add('text-primary');
            button.querySelector('span').style.fontVariationSettings = "'FILL' 1";
            
            // Clear downvote if exists
            const downBtn = button.closest('.flex-col').querySelector('button[onclick*="\'down\'"]');
            downBtn.classList.remove('text-error');
        }
    } else if (direction === 'down') {
        if (isDownvoted) {
            // Cancel downvote
            currentScore += 1;
            button.classList.remove('text-error');
        } else {
            // Apply downvote
            currentScore -= isUpvoted ? 2 : 1;
            button.classList.add('text-error');
            
            // Clear upvote if exists
            const upBtn = button.closest('.flex-col').querySelector('button[onclick*="\'up\'"]');
            upBtn.classList.remove('text-primary');
            upBtn.querySelector('span').style.fontVariationSettings = "'FILL' 0";
        }
    }
    scoreEl.textContent = currentScore;
}

// Toggle Bookmark
function toggleBookmark(button) {
    const icon = button.querySelector('span');
    const isFilled = icon.style.fontVariationSettings && icon.style.fontVariationSettings.includes("'FILL' 1");
    if (isFilled) {
        icon.style.fontVariationSettings = "'FILL' 0";
        button.classList.remove('text-primary');
    } else {
        icon.style.fontVariationSettings = "'FILL' 1";
        button.classList.add('text-primary');
    }
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
