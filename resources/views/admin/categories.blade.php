@extends('layouts.app')

@section('title', 'Category Management | Admin')
@section('body-class', 'bg-background text-on-surface min-h-screen flex flex-col')

@section('content')
<!-- Header -->
<header class="bg-surface sticky top-0 z-50 border-b border-outline-variant h-16">
    <div class="flex justify-between items-center w-full px-margin-desktop max-w-container-max mx-auto h-full">
        <div class="flex items-center gap-gutter">
            <span class="material-symbols-outlined text-[24px] text-primary">category</span>
            <h1 class="font-headline-sm text-headline-sm text-on-surface">Category Management</h1>
        </div>
        <div class="flex items-center gap-stack-md">
            <!-- User Menu -->
            <div class="flex items-center gap-stack-sm text-on-surface-variant">
                <div class="w-8 h-8 rounded-full bg-primary text-on-primary flex items-center justify-center font-label-md font-bold">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <span class="font-label-md text-label-md hidden md:block">{{ auth()->user()->name }}</span>
            </div>
        </div>
    </div>
</header>

<main class="flex-grow w-full max-w-container-max mx-auto px-margin-desktop py-stack-lg flex gap-gutter">
    
    <!-- Sidebar Navigation -->
    <aside class="w-64 flex-shrink-0 hidden lg:block">
        <nav class="flex-1 space-y-1">
            @if(in_array(auth()->user()->role->value, ['admin']))
            <a class="flex items-center px-3 py-2 text-on-surface-variant hover:bg-surface-container hover:text-on-surface rounded-md transition-colors" href="{{ route('admin.dashboard') }}">
                <span class="material-symbols-outlined mr-3">dashboard</span>
                Admin Overview
            </a>
            @endif
            @if(in_array(auth()->user()->role->value, ['admin', 'moderator']))
            <a class="flex items-center px-3 py-2 text-on-surface-variant hover:bg-surface-container hover:text-on-surface rounded-md transition-colors" href="{{ route('admin.moderator') }}">
                <span class="material-symbols-outlined mr-3">admin_panel_settings</span>
                Moderator Hub
            </a>
            <a class="flex items-center px-3 py-2 bg-secondary-container text-on-secondary-container rounded-md font-medium" href="{{ route('admin.categories.index') }}">
                <span class="material-symbols-outlined mr-3">category</span>
                Category Management
            </a>
            @endif
            @if(in_array(auth()->user()->role->value, ['admin']))
            <a class="flex items-center px-3 py-2 text-on-surface-variant hover:bg-surface-container hover:text-on-surface rounded-md transition-colors" href="#">
                <span class="material-symbols-outlined mr-3">group</span>
                User Directory
            </a>
            @endif
            @if(in_array(auth()->user()->role->value, ['admin', 'developer']))
            <a class="flex items-center px-3 py-2 text-on-surface-variant hover:bg-surface-container hover:text-on-surface rounded-md transition-colors" href="{{ route('admin.monitor') }}">
                <span class="material-symbols-outlined mr-3">monitor_heart</span>
                System Health
            </a>
            @endif
        </nav>
    </aside>

    <!-- Main Content Area -->
    <section class="flex-grow space-y-stack-lg">

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6 shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6 shadow-sm">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6 shadow-sm">
                <ul class="list-disc ml-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Tabs -->
        <div class="flex gap-stack-md border-b border-outline-variant mb-stack-lg">
            <a href="{{ route('admin.categories.index', ['type' => 'blog']) }}" class="pb-2 px-1 font-title-md text-decoration-none {{ $type === 'blog' ? 'border-b-2 border-primary text-primary font-bold' : 'text-on-surface-variant hover:text-on-surface font-medium' }}">
                Blog Categories
            </a>
            <a href="{{ route('admin.categories.index', ['type' => 'forum']) }}" class="pb-2 px-1 font-title-md text-decoration-none {{ $type === 'forum' ? 'border-b-2 border-primary text-primary font-bold' : 'text-on-surface-variant hover:text-on-surface font-medium' }}">
                Forum Categories
            </a>
        </div>

        @if($type === 'blog')
        <!-- Blog Categories Section -->
        <div>
            <h2 class="text-headline-md font-headline-md text-on-surface mb-stack-md flex items-center gap-2">
                <span class="material-symbols-outlined text-blue-600">article</span>
                Blog Categories
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-stack-lg">
                <!-- Blog Categories List -->
                <div class="md:col-span-2 bg-surface border border-outline-variant rounded-xl overflow-hidden shadow-sm">
                    <div class="p-4 border-b border-outline-variant bg-surface-container-lowest">
                        <h2 class="font-title-md text-title-md text-on-surface">Existing Blog Categories</h2>
                    </div>
                    <div class="p-0">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-surface-container-low text-on-surface-variant font-label-md">
                                    <th class="p-3 border-b border-outline-variant font-medium">Name</th>
                                    <th class="p-3 border-b border-outline-variant font-medium">Posts</th>
                                    <th class="p-3 border-b border-outline-variant font-medium text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($blogCategories as $category)
                                <tr class="border-b border-outline-variant hover:bg-surface-container-lowest transition-colors">
                                    <td class="p-3 font-body-md text-on-surface">{{ $category->name }}</td>
                                    <td class="p-3 font-body-sm text-on-surface-variant">
                                        {{ $category->posts_count }} Posts
                                    </td>
                                    <td class="p-3 text-right">
                                        <button type="button" onclick="editCategory({{ $category->id }}, '{{ $category->name }}', 'blog')" class="text-secondary hover:text-primary mr-2" title="Edit">
                                            <span class="material-symbols-outlined text-[20px]">edit</span>
                                        </button>
                                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this category?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-error hover:text-error/80" title="Delete">
                                                <span class="material-symbols-outlined text-[20px]">delete</span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="p-6 text-center text-on-surface-variant font-body-md">
                                        No blog categories found.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($blogCategories->hasPages())
                    <div class="p-4 border-t border-outline-variant bg-surface-container-lowest">
                        {{ $blogCategories->withQueryString()->links() }}
                    </div>
                    @endif
                </div>

                <!-- Blog Create/Edit Form -->
                <div class="bg-surface border border-outline-variant rounded-xl shadow-sm self-start">
                    <div class="p-4 border-b border-outline-variant bg-surface-container-lowest flex justify-between items-center">
                        <h2 id="form-title-blog" class="font-title-md text-title-md text-on-surface">Add Blog Category</h2>
                        <button type="button" id="cancel-edit-btn-blog" onclick="resetForm('blog')" class="hidden text-xs text-error hover:underline">Cancel Edit</button>
                    </div>
                    <div class="p-4">
                        <form id="category-form-blog" action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <input type="hidden" name="_method" id="form-method-blog" value="POST">
                            <input type="hidden" name="type" value="blog">
                            
                            <div>
                                <label class="block font-label-md text-on-surface mb-1">Category Name</label>
                                <input type="text" name="name" id="category-name-blog" required class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg p-2 focus:ring-1 focus:ring-primary focus:border-primary text-body-md" placeholder="e.g. Technology">
                            </div>

                            <button type="submit" id="submit-btn-blog" class="w-full bg-primary text-on-primary py-2 rounded-lg font-label-md hover:opacity-90 transition-opacity">
                                Add Category
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if($type === 'forum')
        <!-- Forum Categories Section -->
        <div>
            <h2 class="text-headline-md font-headline-md text-on-surface mb-stack-md flex items-center gap-2">
                <span class="material-symbols-outlined text-purple-600">forum</span>
                Forum Categories
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-stack-lg">
                <!-- Forum Categories List -->
                <div class="md:col-span-2 bg-surface border border-outline-variant rounded-xl overflow-hidden shadow-sm">
                    <div class="p-4 border-b border-outline-variant bg-surface-container-lowest">
                        <h2 class="font-title-md text-title-md text-on-surface">Existing Forum Categories</h2>
                    </div>
                    <div class="p-0">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-surface-container-low text-on-surface-variant font-label-md">
                                    <th class="p-3 border-b border-outline-variant font-medium">Name</th>
                                    <th class="p-3 border-b border-outline-variant font-medium">Topics</th>
                                    <th class="p-3 border-b border-outline-variant font-medium text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($forumCategories as $category)
                                <tr class="border-b border-outline-variant hover:bg-surface-container-lowest transition-colors">
                                    <td class="p-3 font-body-md text-on-surface">{{ $category->name }}</td>
                                    <td class="p-3 font-body-sm text-on-surface-variant">
                                        {{ $category->forum_topics_count }} Topics
                                    </td>
                                    <td class="p-3 text-right">
                                        <button type="button" onclick="editCategory({{ $category->id }}, '{{ $category->name }}', 'forum')" class="text-secondary hover:text-primary mr-2" title="Edit">
                                            <span class="material-symbols-outlined text-[20px]">edit</span>
                                        </button>
                                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this category?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-error hover:text-error/80" title="Delete">
                                                <span class="material-symbols-outlined text-[20px]">delete</span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="p-6 text-center text-on-surface-variant font-body-md">
                                        No forum categories found.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($forumCategories->hasPages())
                    <div class="p-4 border-t border-outline-variant bg-surface-container-lowest">
                        {{ $forumCategories->withQueryString()->links() }}
                    </div>
                    @endif
                </div>

                <!-- Forum Create/Edit Form -->
                <div class="bg-surface border border-outline-variant rounded-xl shadow-sm self-start">
                    <div class="p-4 border-b border-outline-variant bg-surface-container-lowest flex justify-between items-center">
                        <h2 id="form-title-forum" class="font-title-md text-title-md text-on-surface">Add Forum Category</h2>
                        <button type="button" id="cancel-edit-btn-forum" onclick="resetForm('forum')" class="hidden text-xs text-error hover:underline">Cancel Edit</button>
                    </div>
                    <div class="p-4">
                        <form id="category-form-forum" action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <input type="hidden" name="_method" id="form-method-forum" value="POST">
                            <input type="hidden" name="type" value="forum">
                            
                            <div>
                                <label class="block font-label-md text-on-surface mb-1">Category Name</label>
                                <input type="text" name="name" id="category-name-forum" required class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg p-2 focus:ring-1 focus:ring-primary focus:border-primary text-body-md" placeholder="e.g. Help">
                            </div>

                            <button type="submit" id="submit-btn-forum" class="w-full bg-primary text-on-primary py-2 rounded-lg font-label-md hover:opacity-90 transition-opacity">
                                Add Category
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endif

    </section>
</main>

<script>
    function editCategory(id, name, type) {
        const form = document.getElementById(`category-form-${type}`);
        const formTitle = document.getElementById(`form-title-${type}`);
        const submitBtn = document.getElementById(`submit-btn-${type}`);
        const methodInput = document.getElementById(`form-method-${type}`);
        const cancelBtn = document.getElementById(`cancel-edit-btn-${type}`);
        const nameInput = document.getElementById(`category-name-${type}`);

        // Update form action to update route
        form.action = `/admin/categories/${id}`;
        
        // Change to PUT method
        methodInput.value = 'PUT';

        // Fill inputs
        nameInput.value = name;

        // Update UI
        formTitle.innerText = 'Edit Category';
        submitBtn.innerText = 'Save Changes';
        cancelBtn.classList.remove('hidden');
    }

    function resetForm(type) {
        const form = document.getElementById(`category-form-${type}`);
        const formTitle = document.getElementById(`form-title-${type}`);
        const submitBtn = document.getElementById(`submit-btn-${type}`);
        const methodInput = document.getElementById(`form-method-${type}`);
        const cancelBtn = document.getElementById(`cancel-edit-btn-${type}`);
        const nameInput = document.getElementById(`category-name-${type}`);

        // Reset to store route
        form.action = `{{ route('admin.categories.store') }}`;
        
        // Change to POST method
        methodInput.value = 'POST';

        // Clear inputs
        nameInput.value = '';

        // Update UI
        formTitle.innerText = type === 'blog' ? 'Add Blog Category' : 'Add Forum Category';
        submitBtn.innerText = 'Add Category';
        cancelBtn.classList.add('hidden');
    }
</script>
@endsection
