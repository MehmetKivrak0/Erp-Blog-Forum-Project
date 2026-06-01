@extends('layouts.app')

@section('title', 'Edit Topic | DevConnect')
@section('body-class', 'bg-background text-on-surface min-h-screen flex flex-col')

@section('content')
<!-- TopNavBar -->
<header class="bg-surface sticky top-0 z-50 border-b border-outline-variant h-16">
    <div class="flex justify-between items-center w-full px-margin-desktop max-w-container-max mx-auto h-full">
        <div class="flex items-center gap-gutter">
            <a class="flex items-center gap-stack-sm text-on-surface-variant hover:text-primary transition-colors font-label-md text-label-md text-decoration-none" href="{{ route('forum.thread', $topic->id) }}">
                <span class="material-symbols-outlined text-[20px]">arrow_back</span>
                <span>Back to Topic</span>
            </a>
            <div class="h-4 w-px bg-outline-variant"></div>
            <div class="flex items-center gap-stack-sm text-on-surface-variant opacity-70">
                <span class="material-symbols-outlined text-[18px]">edit</span>
                <span class="font-label-sm text-label-sm">Editing topic</span>
            </div>
        </div>
        <div class="flex items-center gap-stack-md">
            <a href="{{ route('forum.thread', $topic->id) }}" class="px-stack-md py-2 font-label-md text-label-md text-secondary hover:bg-surface-container transition-colors rounded-lg text-decoration-none">Cancel</a>
            <button type="submit" form="edit-topic-form" class="px-stack-lg py-2 bg-primary text-on-primary font-label-md text-label-md rounded-lg shadow-sm hover:opacity-90 active:scale-95 transition-all">Save Changes</button>
        </div>
    </div>
</header>
<main class="flex-grow w-full max-w-container-max mx-auto px-margin-desktop py-stack-lg">
    <form id="edit-topic-form" action="{{ route('forum.update', $topic->id) }}" method="POST" class="flex gap-gutter w-full">
        @csrf
        @method('PUT')
        <!-- Main Writing Canvas -->
        <article class="flex-grow max-w-[840px]">
            <!-- Title Input -->
            <div class="mb-stack-md">
                <input autofocus="" name="title" class="w-full bg-transparent border-none focus:ring-0 p-0 font-headline-xl text-headline-xl text-on-surface placeholder:text-outline-variant outline-none border-b border-transparent focus:border-outline-variant pb-2" placeholder="Topic Title" type="text" value="{{ old('title', $topic->title) }}" required/>
            </div>
            <!-- Rich Text Editor Toolbar -->
            <div class="sticky top-[4.1rem] z-40 bg-surface/90 backdrop-blur-md border border-outline-variant rounded-lg p-2 flex items-center gap-1 mb-stack-md shadow-sm">
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
                <textarea name="content" class="w-full min-h-[500px] bg-transparent border-none focus:ring-0 p-0 font-body-lg text-body-lg text-on-surface placeholder:text-outline-variant resize-none leading-relaxed outline-none" placeholder="Describe your topic or question here..." required>{{ old('content', $topic->content) }}</textarea>
            </div>
        </article>
        <!-- Sidebar Settings -->
        <aside class="w-80 flex-shrink-0 flex flex-col gap-stack-lg">
            <!-- Topic Settings Card -->
            <section class="bg-surface border border-outline-variant rounded-xl p-stack-md">
                <h3 class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider mb-stack-md">Topic Settings</h3>
                <div class="flex flex-col gap-stack-md">
                    @php
                        $user = auth()->user();
                        $userRole = is_object($user->role) ? $user->role->value : $user->role;
                        $isStaff = in_array($userRole, ['admin', 'developer', 'moderator']);
                    @endphp

                    @if($isStaff)
                        <label class="flex items-center justify-between cursor-pointer group">
                            <span class="font-body-md text-body-md text-on-surface">Pin Topic</span>
                            <div class="relative w-10 h-6 bg-outline-variant rounded-full transition-colors has-[:checked]:bg-primary">
                                <input name="is_pinned" value="1" {{ $topic->is_pinned ? 'checked' : '' }} class="sr-only peer" type="checkbox"/>
                                <div class="absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition-transform peer-checked:translate-x-4"></div>
                            </div>
                        </label>
                        <label class="flex items-center justify-between cursor-pointer group">
                            <span class="font-body-md text-body-md text-on-surface">Lock Topic</span>
                            <div class="relative w-10 h-6 bg-outline-variant rounded-full transition-colors has-[:checked]:bg-primary">
                                <input name="is_locked" value="1" {{ $topic->is_locked ? 'checked' : '' }} class="sr-only peer" type="checkbox"/>
                                <div class="absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition-transform peer-checked:translate-x-4"></div>
                            </div>
                        </label>
                    @endif

                    <div class="flex flex-col gap-2">
                        <span class="font-body-md text-body-md text-on-surface">Category</span>
                        <select name="category_id" class="w-full px-3 py-2 bg-surface-container-low border border-outline-variant rounded-lg focus:ring-1 focus:ring-primary focus:border-primary text-body-md font-body-md text-on-surface" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $topic->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </section>
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
