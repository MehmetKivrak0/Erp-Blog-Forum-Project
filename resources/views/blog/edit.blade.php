@extends('layouts.app')

@section('title', 'Edit Post | DevConnect')
@section('body-class', 'bg-background text-on-surface min-h-screen flex flex-col')

@push('styles')
    <style>
        .border-dashed-custom {
            background-image: url("data:image/svg+xml,%3csvg width='100%25' height='100%25' xmlns='http://www.w3.org/2000/svg'%3e%3crect width='100%25' height='100%25' fill='none' stroke='%23777587' stroke-width='2' stroke-dasharray='8%2c 12' stroke-dashoffset='0' stroke-linecap='square'/%3e%3c/svg%3e");
        }
    </style>
@endpush

@section('content')
<!-- TopNavBar (Shell Fragment) -->
<header class="bg-surface sticky top-0 z-50 border-b border-outline-variant h-16">
    <div class="flex justify-between items-center w-full px-margin-desktop max-w-container-max mx-auto h-full">
        <div class="flex items-center gap-gutter">
            <a class="flex items-center gap-stack-sm text-on-surface-variant hover:text-primary transition-colors font-label-md text-label-md text-decoration-none" href="{{ route('blog.show', $post->id) }}">
                <span class="material-symbols-outlined text-[20px]">arrow_back</span>
                <span>Back to Post</span>
            </a>
            <div class="h-4 w-px bg-outline-variant"></div>
            <div class="flex items-center gap-stack-sm text-on-surface-variant opacity-70">
                <span class="material-symbols-outlined text-[18px]">edit</span>
                <span class="font-label-sm text-label-sm">Editing mode</span>
            </div>
        </div>
        <div class="flex items-center gap-stack-md">
            <a href="{{ route('blog.show', $post->id) }}" class="px-stack-md py-2 font-label-md text-label-md text-secondary hover:bg-surface-container transition-colors rounded-lg text-decoration-none">Cancel</a>
            <button type="submit" form="edit-post-form" class="px-stack-lg py-2 bg-primary text-on-primary font-label-md text-label-md rounded-lg shadow-sm hover:opacity-90 active:scale-95 transition-all">Save Changes</button>
        </div>
    </div>
</header>
<main class="flex-grow w-full max-w-container-max mx-auto px-margin-desktop py-stack-lg">
    <form id="edit-post-form" action="{{ route('blog.update', $post->id) }}" method="POST" enctype="multipart/form-data" class="flex gap-gutter w-full">
        @csrf
        @method('PUT')
        <!-- Main Writing Canvas -->
        <article class="flex-grow max-w-[840px]">
            <!-- Cover Image Upload -->
            <div onclick="document.getElementById('cover-image-input').click()" class="w-full h-64 border-dashed-custom rounded-xl flex flex-col items-center justify-center bg-surface-container-low hover:bg-surface-container-high transition-colors cursor-pointer group mb-stack-lg relative overflow-hidden">
                <input type="file" name="cover_image" class="hidden" id="cover-image-input" accept="image/*" onchange="previewImage(this)" />
                <div id="upload-placeholder" class="flex flex-col items-center justify-center hidden">
                    <div class="p-stack-md rounded-full bg-surface-container-highest text-primary mb-stack-sm group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-[32px]">add_a_photo</span>
                    </div>
                    <p class="font-headline-md text-headline-md text-on-surface">Upload Cover Image</p>
                    <p class="font-body-md text-body-md text-on-surface-variant mt-1">Recommended size: 1200x630px. Drag and drop here.</p>
                </div>
                <img id="image-preview" src="" class="absolute inset-0 w-full h-full object-cover" alt="Image preview" />
            </div>
            <!-- Title Input -->
            <div class="mb-stack-md">
                <input autofocus="" name="title" class="w-full bg-surface-container-lowest border border-outline-variant focus:border-primary focus:ring-2 focus:ring-primary/20 rounded-xl p-4 font-headline-xl text-headline-xl text-on-surface placeholder:text-outline-variant transition-all shadow-sm" placeholder="Post Title" type="text" value="{{ old('title', $post->title) }}" required/>
            </div>
            <!-- Tag Selection -->
            <div class="flex flex-wrap items-center gap-stack-sm mb-stack-lg">
                <span class="material-symbols-outlined text-outline text-[20px]">local_offer</span>
                <div class="flex flex-wrap items-center gap-stack-sm" id="tags-container">
                    <div class="relative flex items-center">
                        <input type="text" id="new-tag-input" class="hidden px-2 py-0.5 border border-outline-variant rounded-full font-label-sm text-label-sm bg-surface-container-low text-on-surface w-24 focus:outline-none focus:border-primary" placeholder="Press Enter" onkeydown="handleTagInputKey(event)" onblur="hideTagInput()" />
                        <button type="button" id="add-tag-btn" onclick="showTagInput()" class="px-3 py-1 border border-outline-variant text-on-surface-variant rounded-full font-label-sm text-label-sm hover:bg-surface-container transition-colors flex items-center gap-1">
                            <span class="material-symbols-outlined text-[16px]">add</span> Add Tag
                        </button>
                    </div>
                </div>
                <input type="hidden" name="tags" id="tags-hidden-input" value="" />
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
                <textarea id="content-textarea" name="content" class="w-full min-h-[600px] bg-surface-container-lowest border border-outline-variant focus:border-primary focus:ring-2 focus:ring-primary/20 rounded-xl p-6 font-body-lg text-body-lg text-on-surface placeholder:text-outline-variant resize-none overflow-hidden leading-relaxed transition-all shadow-sm" placeholder="Write your technical masterpiece here..." required>{{ old('content', $post->content) }}</textarea>
            </div>
        </article>
        <!-- Sidebar Settings -->
        <aside class="w-80 flex-shrink-0 flex flex-col gap-stack-lg">
            <!-- Post Settings Card -->
            <section class="bg-surface border border-outline-variant rounded-xl p-stack-md">
                <h3 class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider mb-stack-md">Post Settings</h3>
                <div class="flex flex-col gap-stack-md">
                    <label class="flex items-center justify-between cursor-pointer group">
                        <span class="font-body-md text-body-md text-on-surface">Allow comments</span>
                        <div class="relative w-10 h-6 bg-outline-variant rounded-full transition-colors has-[:checked]:bg-primary">
                            <input name="allow_comments" value="1" checked="" class="sr-only peer" type="checkbox"/>
                            <div class="absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition-transform peer-checked:translate-x-4"></div>
                        </div>
                    </label>
                    <div class="flex flex-col gap-2">
                        <span class="font-body-md text-body-md text-on-surface">Visibility</span>
                        <div class="grid grid-cols-2 gap-2">
                            <button type="button" onclick="setVisibility('public')" id="visibility-public-btn" class="px-3 py-2 rounded-lg bg-secondary-container text-on-secondary-container font-label-sm text-label-sm border border-transparent">Public</button>
                            <button type="button" onclick="setVisibility('private')" id="visibility-private-btn" class="px-3 py-2 rounded-lg bg-surface-container text-on-surface-variant font-label-sm text-label-sm border border-outline-variant hover:border-outline transition-colors">Private</button>
                        </div>
                        <input type="hidden" name="visibility" id="visibility-input" value="public" />
                    </div>
                    <div class="flex flex-col gap-2">
                        <span class="font-body-md text-body-md text-on-surface">Category</span>
                        <select name="category_id" class="w-full px-3 py-2 bg-surface-container-low border border-outline-variant rounded-lg focus:ring-1 focus:ring-primary focus:border-primary text-body-md font-body-md text-on-surface">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $post->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </section>
        </aside>
    </form>
</main>
<!-- Footer (Shell Fragment) -->
<x-footer class="bg-surface-container-lowest border-t border-outline-variant mt-stack-lg" />
@endsection

@push('scripts')
<script>
// Image Preview
function previewImage(input) {
    const file = input.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('image-preview');
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            document.getElementById('upload-placeholder').classList.add('hidden');
        }
        reader.readAsDataURL(file);
    }
}

// Tags Management
function updateTagsHiddenInput() {
    const tags = Array.from(document.querySelectorAll('#tags-container .tag-badge')).map(el => el.getAttribute('data-tag'));
    document.getElementById('tags-hidden-input').value = tags.join(',');
}
function removeTag(element) {
    element.closest('.tag-badge').remove();
    updateTagsHiddenInput();
}
function showTagInput() {
    const input = document.getElementById('new-tag-input');
    const btn = document.getElementById('add-tag-btn');
    input.classList.remove('hidden');
    btn.classList.add('hidden');
    input.focus();
}
function hideTagInput() {
    const input = document.getElementById('new-tag-input');
    const btn = document.getElementById('add-tag-btn');
    input.value = '';
    input.classList.add('hidden');
    btn.classList.remove('hidden');
}
function handleTagInputKey(event) {
    if (event.key === 'Enter') {
        event.preventDefault();
        const value = event.target.value.trim();
        if (value) {
            const existingTags = Array.from(document.querySelectorAll('#tags-container .tag-badge')).map(el => el.getAttribute('data-tag').toLowerCase());
            if (!existingTags.includes(value.toLowerCase())) {
                const badge = document.createElement('span');
                badge.className = 'tag-badge px-3 py-1 bg-primary-fixed text-on-primary-fixed-variant rounded-full font-label-sm text-label-sm flex items-center gap-1';
                badge.setAttribute('data-tag', value);
                badge.innerHTML = `${value} <span class="material-symbols-outlined text-[14px] cursor-pointer" onclick="removeTag(this)">close</span>`;
                
                const container = document.getElementById('tags-container');
                container.insertBefore(badge, container.lastElementChild);
                updateTagsHiddenInput();
            }
        }
        hideTagInput();
    } else if (event.key === 'Escape') {
        hideTagInput();
    }
}

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

// Visibility Selector
function setVisibility(type) {
    document.getElementById('visibility-input').value = type;
    const publicBtn = document.getElementById('visibility-public-btn');
    const privateBtn = document.getElementById('visibility-private-btn');
    if (type === 'public') {
        publicBtn.className = 'px-3 py-2 rounded-lg bg-secondary-container text-on-secondary-container font-label-sm text-label-sm border border-transparent';
        privateBtn.className = 'px-3 py-2 rounded-lg bg-surface-container text-on-surface-variant font-label-sm text-label-sm border border-outline-variant hover:border-outline transition-colors';
    } else {
        privateBtn.className = 'px-3 py-2 rounded-lg bg-secondary-container text-on-secondary-container font-label-sm text-label-sm border border-transparent';
        publicBtn.className = 'px-3 py-2 rounded-lg bg-surface-container text-on-surface-variant font-label-sm text-label-sm border border-outline-variant hover:border-outline transition-colors';
    }
}

// Auto-resize Textarea
const contentTextarea = document.getElementById('content-textarea');
if (contentTextarea) {
    // Initial resize on load
    contentTextarea.style.height = 'auto';
    contentTextarea.style.height = (contentTextarea.scrollHeight) + 'px';
    
    // Resize on input
    contentTextarea.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });
}

// Initialize Visibility State
setVisibility('{{ $post->status->value === 'draft' ? 'private' : 'public' }}');
</script>
@endpush
