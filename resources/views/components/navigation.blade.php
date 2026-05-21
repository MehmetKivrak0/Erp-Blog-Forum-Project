@props([
    'brand' => 'DevConnect',
    'active' => '',
    'search' => true
])

<header {{ $attributes->merge(['class' => 'sticky top-0 z-50']) }}>
    <div class="flex justify-between items-center w-full px-margin-desktop max-w-container-max mx-auto h-16">
        <!-- Brand -->
        <a href="{{ route('home') }}" class="text-headline-lg font-headline-lg font-bold text-primary hover:opacity-90 text-decoration-none">{{ $brand }}</a>
        
        <!-- Navigation -->
        <nav class="hidden md:flex gap-gutter items-center">
            <a class="{{ $active === 'feed' ? 'text-primary border-b-2 border-primary pb-1 font-bold' : 'text-on-surface-variant font-medium hover:text-primary transition-colors duration-150 ease-in-out' }} text-label-md font-label-md text-decoration-none" href="{{ route('home') }}">Feed</a>
            <a class="{{ $active === 'discussions' ? 'text-primary border-b-2 border-primary pb-1 font-bold' : 'text-on-surface-variant font-medium hover:text-primary transition-colors duration-150 ease-in-out' }} text-label-md font-label-md text-decoration-none" href="{{ route('forum.thread', 1) }}">Discussions</a>
            <a class="{{ $active === 'articles' ? 'text-primary border-b-2 border-primary pb-1 font-bold' : 'text-on-surface-variant font-medium hover:text-primary transition-colors duration-150 ease-in-out' }} text-label-md font-label-md text-decoration-none" href="{{ route('blog.show', 1) }}">Articles</a>
            <a class="{{ $active === 'support' ? 'text-primary border-b-2 border-primary pb-1 font-bold' : 'text-on-surface-variant font-medium hover:text-primary transition-colors duration-150 ease-in-out' }} text-label-md font-label-md text-decoration-none" href="{{ route('support') }}">Support</a>
            <a class="{{ $active === 'admin' ? 'text-primary border-b-2 border-primary pb-1 font-bold' : 'text-on-surface-variant font-medium hover:text-primary transition-colors duration-150 ease-in-out' }} text-label-md font-label-md text-decoration-none" href="{{ route('admin.dashboard') }}">Admin</a>
        </nav>
        
        <!-- Actions -->
        <div class="flex items-center gap-stack-md">
            @if($search)
            <div class="hidden md:flex items-center bg-surface-container-low px-stack-md py-stack-sm rounded-lg border border-outline-variant/10">
                <span class="material-symbols-outlined text-outline mr-2" data-icon="search">search</span>
                <input class="bg-transparent border-none focus:ring-0 text-body-md font-body-md w-48 lg:w-64 text-on-surface" placeholder="Search discussions..." type="text"/>
            </div>
            @endif
            <button class="material-symbols-outlined text-on-surface-variant p-2 hover:bg-surface-hover rounded-full" data-icon="notifications">notifications</button>
            <a href="{{ route('profile') }}" class="h-8 w-8 rounded-full bg-secondary-container overflow-hidden block hover:ring-2 hover:ring-primary/20">
                <img alt="User profile avatar" data-alt="A clean, professional profile avatar of a developer..." src="https://lh3.googleusercontent.com/aida-public/AB6AXuAkzKorOL9nDgEXyPQl3RBQljjrIFhZiUvnH58Nzv-ihMltPDSAL7bpxXxMalD8zkR-PHWHqLLexUwUTkwyEginq6F8jHbUH_v12eyd9xZRjRb-bf9KBjfhoveeex06evduzsZepwRyqGxcIBGbnitSCwZzaHa7F1kS7n8EreV3YjSzr5PsMX5HFfS0ICco6pIdZwSda1hrxmhZPMhaGO3Uh4QwbwzWfDApmT4n3afU4kYeZ1zaFhQ09yCHYSn2ns-PWWBjGLZYCfE"/>
            </a>
            <a href="{{ route('blog.create') }}" class="hidden lg:block bg-primary text-on-primary px-stack-md py-stack-sm rounded-lg text-label-md font-label-md font-bold hover:opacity-90 transition-all text-decoration-none">Create Post</a>
        </div>
    </div>
</header>
