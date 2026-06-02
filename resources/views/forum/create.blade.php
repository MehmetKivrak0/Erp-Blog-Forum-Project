@extends('layouts.app')

@section('title', 'Create New Topic | DevConnect')
@section('body-class', 'bg-background text-on-surface min-h-screen flex flex-col')

@section('content')
<!-- TopNavBar -->
<header class="bg-surface sticky top-0 z-50 border-b border-outline-variant h-16">
    <div class="flex justify-between items-center w-full px-margin-desktop max-w-container-max mx-auto h-full">
        <div class="flex items-center gap-gutter">
            <a class="flex items-center gap-stack-sm text-on-surface-variant hover:text-primary transition-colors font-label-md text-label-md text-decoration-none" href="{{ route('forum.index') }}">
                <span class="material-symbols-outlined text-[20px]">arrow_back</span>
                <span>Back to Forum</span>
            </a>
        </div>
        <div class="flex items-center gap-stack-md">
            @php
                $forumUserRole = auth()->user()?->role?->value ?? 'user';
                $isForumStaff  = in_array($forumUserRole, ['admin','moderator','developer']);
            @endphp
            <button type="submit" form="create-topic-form" class="px-stack-lg py-2 bg-primary text-on-primary font-label-md text-label-md rounded-lg shadow-sm hover:opacity-90 active:scale-95 transition-all">
                {{ $isForumStaff ? 'Yayınla' : 'İncelemeye Gönder' }}
            </button>
        </div>
    </div>
</header>
<main class="flex-grow w-full max-w-container-max mx-auto px-margin-desktop py-stack-lg">
    <form id="create-topic-form" action="{{ route('forum.create.post') }}" method="POST" class="flex gap-gutter w-full">
        @csrf
        <!-- Main Writing Canvas -->
        <article class="flex-grow max-w-[840px]">
            <!-- Title Input -->
            <div class="mb-stack-md">
                <input autofocus="" name="title" class="w-full bg-white border border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary rounded-lg px-4 py-3 font-headline-xl text-headline-xl text-on-surface placeholder:text-secondary outline-none transition-all shadow-sm" placeholder="Topic Title" type="text" required/>
            </div>
            <!-- Rich Text Editor Toolbar -->
            <div class="sticky top-[4.1rem] z-40 bg-white border border-outline-variant border-b-0 rounded-t-lg p-2 flex items-center gap-1 shadow-sm">
                <button type="button" onclick="insertFormat('**', '**')" class="p-2 hover:bg-surface-container-highest rounded text-on-surface-variant transition-colors" title="Bold"><span class="material-symbols-outlined">format_bold</span></button>
                <button type="button" onclick="insertFormat('*', '*')" class="p-2 hover:bg-surface-container-highest rounded text-on-surface-variant transition-colors" title="Italic"><span class="material-symbols-outlined">format_italic</span></button>
                <button type="button" onclick="insertFormat('[', '](url)')" class="p-2 hover:bg-surface-container-highest rounded text-on-surface-variant transition-colors" title="Link"><span class="material-symbols-outlined">link</span></button>
                <div class="w-px h-6 bg-outline-variant mx-1"></div>
                <button type="button" onclick="insertFormat('# ')" class="p-2 hover:bg-surface-container-highest rounded text-on-surface-variant transition-colors" title="Headline"><span class="material-symbols-outlined">format_h1</span></button>
                <button type="button" onclick="insertFormat('> ')" class="p-2 hover:bg-surface-container-highest rounded text-on-surface-variant transition-colors" title="Quote"><span class="material-symbols-outlined">format_quote</span></button>
                <button type="button" onclick="insertFormat('```\n', '\n```')" class="p-2 hover:bg-surface-container-highest rounded text-on-surface-variant transition-colors" title="Code Block"><span class="material-symbols-outlined">code</span></button>
                <div class="w-px h-6 bg-outline-variant mx-1"></div>
                <button type="button" onclick="insertFormat('![', '](url)')" class="p-2 hover:bg-surface-container-highest rounded text-on-surface-variant transition-colors" title="Image"><span class="material-symbols-outlined">image</span></button>
                <button type="button" onclick="insertFormat('- ')" class="p-2 hover:bg-surface-container-highest rounded text-on-surface-variant transition-colors" title="List"><span class="material-symbols-outlined">format_list_bulleted</span></button>
            </div>
            <!-- Main Content Area -->
            <div class="relative">
                <textarea name="content" oninput="this.style.height = ''; this.style.height = this.scrollHeight + 'px'" style="min-height: 300px;" class="w-full bg-white border border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary rounded-b-lg p-4 font-body-lg text-body-lg text-on-surface placeholder:text-secondary resize-none leading-relaxed outline-none transition-shadow shadow-sm overflow-hidden" placeholder="Describe your topic or question here..." required></textarea>
            </div>
        </article>
        <!-- Sidebar Settings -->
        <aside class="w-80 flex-shrink-0 flex flex-col gap-stack-lg">
            <!-- Topic Settings Card -->
            <section class="bg-surface border border-outline-variant rounded-xl p-stack-md">
                <h3 class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider mb-stack-md">Topic Settings</h3>
                <div class="flex flex-col gap-stack-md">
                    <label class="flex items-center justify-between cursor-pointer group">
                        <span class="font-body-md text-body-md text-on-surface">Pin Topic</span>
                        <div class="relative w-10 h-6 bg-outline-variant rounded-full transition-colors has-[:checked]:bg-primary">
                            <input name="is_pinned" value="1" class="sr-only peer" type="checkbox"/>
                            <div class="absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition-transform peer-checked:translate-x-4"></div>
                        </div>
                    </label>
                    <label class="flex items-center justify-between cursor-pointer group">
                        <span class="font-body-md text-body-md text-on-surface">Lock Topic</span>
                        <div class="relative w-10 h-6 bg-outline-variant rounded-full transition-colors has-[:checked]:bg-primary">
                            <input name="is_locked" value="1" class="sr-only peer" type="checkbox"/>
                            <div class="absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition-transform peer-checked:translate-x-4"></div>
                        </div>
                    </label>
                    <div class="flex flex-col gap-2">
                        <span class="font-body-md text-body-md text-on-surface">Category</span>
                        <select name="category_id" class="w-full px-3 py-2 bg-surface-container-low border border-outline-variant rounded-lg focus:ring-1 focus:ring-primary focus:border-primary text-body-md font-body-md text-on-surface" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </section>
            <!-- Moderator Review Notice (regular users only) -->
            @php
                $forumUserRole2 = auth()->user()?->role?->value ?? 'user';
                $showReviewNote = !in_array($forumUserRole2, ['admin','moderator','developer']);
            @endphp
            @if($showReviewNote)
            <section class="bg-amber-50 border border-amber-200 rounded-xl p-stack-md">
                <div class="flex items-start gap-3">
                    <span class="material-symbols-outlined text-amber-600 text-[22px] mt-0.5">pending_actions</span>
                    <div>
                        <h4 class="font-label-md text-label-md text-amber-800 font-semibold mb-1">Moderatör Onayı</h4>
                        <p class="text-label-sm text-amber-700 leading-relaxed">
                            Gönderdiğiniz konu moderatör veya admin tarafından incelendikten sonra forumda görünür olacaktır.
                        </p>
                    </div>
                </div>
            </section>
            @endif
        </aside>
    </form>
</main>
<!-- Footer -->
<x-footer class="bg-surface-container-lowest border-t border-outline-variant mt-stack-lg" />
@endsection

@push('scripts')
<script>
// Editor Formatting Helpers
const textarea = document.querySelector('textarea[name="content"]');
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
