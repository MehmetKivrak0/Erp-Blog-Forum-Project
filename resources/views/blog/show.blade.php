@extends('layouts.app')

@section('title', 'Blog Post Detail | DevConnect')
@section('body-class', 'bg-surface font-body-md text-on-surface transition-colors duration-300 min-h-screen flex flex-col')

@push('styles')
    <style>
        .syntax-comment { color: #6a737d; }
        .syntax-keyword { color: #d73a49; }
        .syntax-string { color: #032f62; }
        .syntax-function { color: #6f42c1; }
    </style>
@endpush

@section('content')
<!-- TopNavBar -->
<x-navigation active="articles" class="bg-surface dark:bg-background-dark border-b border-outline-variant dark:border-border-dark sticky top-0" />
<main class="flex-grow max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop py-stack-lg">
    <!-- Hero Section -->
    <div class="relative w-full h-[32rem] rounded-xl overflow-hidden mb-stack-lg shadow-xl">
        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/40 to-transparent z-10"></div>
        <img class="absolute inset-0 w-full h-full object-cover" alt="{{ $post->title }}" src="{{ $post->cover_image ?? 'https://lh3.googleusercontent.com/aida/ADBb0uj8LJ9OR-xxsV8FHCY0MpAbXz3F5eqlD7PNy53-tJCTmjouI3XGFYrpd09YqjkPvP8KJUbihsgC56zMtPcqjCpH6Q822arAdRDI8UI21P8mtm5nhs52U6mGpEPj2Ls1t7BYT6Xmi67VmqYnWg5uRVRwvaLXVvYSwnTBfaGQdBtbTasPZvoKnkkekX5FZuUag9GxVCiJzDHJjfVMjT9kpsRG8ojHf7mn2MyNNWXEwI1y9SbT76xvEz31LlQ' }}"/>
        <div class="absolute bottom-0 left-0 p-stack-lg z-20 max-w-3xl">
            <div class="flex gap-2 mb-4">
                <span class="px-3 py-1 bg-primary text-on-primary text-label-sm rounded-full">{{ $post->category?->name ?? 'Web Development' }}</span>
                <span class="px-3 py-1 bg-surface-container-lowest/20 backdrop-blur-md text-white text-label-sm rounded-full border border-white/20">Featured</span>
            </div>
            <h1 class="font-headline-xl text-headline-xl text-white mb-4 leading-tight">{{ $post->title }}</h1>
            <div class="flex items-center gap-4 text-white/90">
                <a href="{{ route('profile') }}" class="block">
                    <img alt="{{ $post->user?->name }}" class="w-10 h-10 rounded-full border-2 border-white/50" src="https://lh3.googleusercontent.com/aida/ADBb0ugBP2tSik5MFhuWgvgVUCGkxdJWCNaj9ffO0pT34K5MCS9Si4Yxj7oCLUeX1fbmXK9YdXQJ70Dys4iYvLdpR3LW2iHdeHEv_Rw8G1vOwHAkIJKwTyzha-Ebfnwh9zpuM_W7gFw1vmZ6zO-axiFlDkeTqwuD1guH6x00xri9J7A2AH7_WI9_XPABJu1qdofrhMacQkQFjaVz3PpgRDUv6F3yxJ6EDXLf8pENVDM94pwWelJtV_y8ggTZHg"/>
                </a>
                <div>
                    <a href="{{ route('profile') }}" class="font-label-md text-label-md text-white hover:underline text-decoration-none">{{ $post->user?->name ?? 'Anonim' }}</a>
                    <p class="text-label-sm opacity-80">Software Engineer • 5 min read • {{ $post->created_at->format('M d, Y') }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-gutter">
        <!-- Main Content Area -->
        <article class="lg:col-span-8 bg-surface-container-lowest p-stack-lg md:p-12 rounded-xl border border-outline-variant shadow-sm">
            <div class="prose max-w-none prose-slate">
                {!! nl2br(e($post->content)) !!}
            </div>
            <!-- Tags -->
            <div class="mt-stack-lg pt-stack-lg border-t border-outline-variant flex flex-wrap gap-2">
                <span class="px-4 py-1.5 bg-secondary-container text-on-secondary-container font-label-md rounded-lg hover:bg-secondary-fixed transition-colors cursor-pointer">#Backend</span>
                <span class="px-4 py-1.5 bg-secondary-container text-on-secondary-container font-label-md rounded-lg hover:bg-secondary-fixed transition-colors cursor-pointer">#SystemsDesign</span>
                <span class="px-4 py-1.5 bg-secondary-container text-on-secondary-container font-label-md rounded-lg hover:bg-secondary-fixed transition-colors cursor-pointer">#Scalability</span>
                <span class="px-4 py-1.5 bg-secondary-container text-on-secondary-container font-label-md rounded-lg hover:bg-secondary-fixed transition-colors cursor-pointer">#Architecture</span>
            </div>
            <!-- Comments Section -->
            <section class="mt-stack-lg pt-stack-lg">
                <h2 class="font-headline-lg text-headline-lg mb-stack-md">Discussion ({{ $post->comments->count() }})</h2>
                <!-- Comment Input -->
                <form action="{{ route('blog.comment', $post->id) }}" method="POST" class="bg-surface-container p-stack-md rounded-xl border border-outline-variant mb-stack-lg">
                    @csrf
                    <div class="flex gap-4 mb-4">
                        <img alt="Your Avatar" class="w-10 h-10 rounded-full" src="https://lh3.googleusercontent.com/aida/ADBb0ugBP2tSik5MFhuWgvgVUCGkxdJWCNaj9ffO0pT34K5MCS9Si4Yxj7oCLUeX1fbmXK9YdXQJ70Dys4iYvLdpR3LW2iHdeHEv_Rw8G1vOwHAkIJKwTyzha-Ebfnwh9zpuM_W7gFw1vmZ6zO-axiFlDkeTqwuD1guH6x00xri9J7A2AH7_WI9_XPABJu1qdofrhMacQkQFjaVz3PpgRDUv6F3yxJ6EDXLf8pENVDM94pwWelJtV_y8ggTZHg"/>
                        <textarea name="comment" class="w-full bg-surface-container-lowest border border-outline-variant rounded-lg p-3 text-body-md focus:ring-2 focus:ring-primary focus:border-primary resize-none min-h-[100px] transition-all" placeholder="Share your thoughts..." required></textarea>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="bg-primary text-on-primary px-6 py-2 rounded-lg font-label-md hover:opacity-90 active:scale-95 transition-all">Post Comment</button>
                    </div>
                </form>
                <!-- Threaded Comments -->
                <div class="space-y-stack-md">
                    @forelse($post->comments as $comment)
                        <!-- Comment -->
                        <div class="flex gap-4">
                            <img alt="Avatar" class="w-10 h-10 rounded-full flex-shrink-0" src="https://lh3.googleusercontent.com/aida/ADBb0ugBP2tSik5MFhuWgvgVUCGkxdJWCNaj9ffO0pT34K5MCS9Si4Yxj7oCLUeX1fbmXK9YdXQJ70Dys4iYvLdpR3LW2iHdeHEv_Rw8G1vOwHAkIJKwTyzha-Ebfnwh9zpuM_W7gFw1vmZ6zO-axiFlDkeTqwuD1guH6x00xri9J7A2AH7_WI9_XPABJu1qdofrhMacQkQFjaVz3PpgRDUv6F3yxJ6EDXLf8pENVDM94pwWelJtV_y8ggTZHg"/>
                            <div class="flex-grow">
                                <div class="bg-surface-container-low p-4 rounded-xl border border-outline-variant">
                                    <div class="flex justify-between items-center mb-1">
                                        <span class="font-label-md text-on-surface">{{ $comment->user?->name ?? 'Anonim' }}</span>
                                        <span class="text-label-sm text-on-surface-variant">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-body-md text-on-surface-variant">{{ $comment->content }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-on-surface-variant text-sm">Henüz yorum yapılmamış. İlk yorumu siz yazın!</p>
                    @endforelse
                </div>
            </section>
        </article>
        <!-- Sidebar -->
        <aside class="lg:col-span-4 space-y-stack-lg">
            <!-- Table of Contents -->
            <div class="sticky top-20 bg-surface-container-lowest p-stack-md rounded-xl border border-outline-variant">
                <h4 class="font-headline-md text-headline-md mb-stack-md flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary" data-icon="list">list</span>
                    Table of Contents
                </h4>
                <ul class="space-y-stack-sm text-on-surface-variant font-label-md">
                    <li><a class="block py-1 hover:text-primary border-l-2 border-transparent hover:border-primary pl-3 transition-all text-decoration-none" href="#foundations-of-scale">The Foundations of Scale</a></li>
                    <li><a class="block py-1 hover:text-primary border-l-2 border-transparent hover:border-primary pl-3 transition-all text-decoration-none" href="#gossip-protocol-in-go">Gossip Protocol in Go</a></li>
                    <li><a class="block py-1 hover:text-primary border-l-2 border-transparent hover:border-primary pl-3 transition-all text-decoration-none" href="#addressing-consistency">Addressing Consistency</a></li>
                </ul>
            </div>
            <!-- Related Posts -->
            <div class="bg-surface-container-lowest p-stack-md rounded-xl border border-outline-variant">
                <h4 class="font-headline-md text-headline-md mb-stack-md">Related Articles</h4>
                <div class="space-y-4">
                    @forelse($relatedPosts as $related)
                        <a href="{{ route('blog.show', $related->id) }}" class="flex gap-3 group cursor-pointer text-decoration-none">
                            <div class="w-16 h-16 rounded-lg overflow-hidden flex-shrink-0">
                                <img class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300" alt="{{ $related->title }}" src="{{ $related->cover_image ?? 'https://lh3.googleusercontent.com/aida/ADBb0uj8LJ9OR-xxsV8FHCY0MpAbXz3F5eqlD7PNy53-tJCTmjouI3XGFYrpd09YqjkPvP8KJUbihsgC56zMtPcqjCpH6Q822arAdRDI8UI21P8mtm5nhs52U6mGpEPj2Ls1t7BYT6Xmi67VmqYnWg5uRVRwvaLXVvYSwnTBfaGQdBtbTasPZvoKnkkekX5FZuUag9GxVCiJzDHJjfVMjT9kpsRG8ojHf7mn2MyNNWXEwI1y9SbT76xvEz31LlQ' }}"/>
                            </div>
                            <div>
                                <p class="font-label-md text-on-surface group-hover:text-primary transition-colors leading-tight">{{ $related->title }}</p>
                                <p class="text-[12px] text-on-surface-variant mt-1">{{ $related->created_at->format('M d') }} • 5 min read</p>
                            </div>
                        </a>
                    @empty
                        <p class="text-on-surface-variant text-sm">Benzer yazı bulunamadı.</p>
                    @endforelse
                </div>
                <a href="{{ route('home') }}" class="w-full text-center block mt-stack-md py-2 text-label-md text-primary border border-primary/20 rounded-lg hover:bg-primary/5 transition-colors text-decoration-none">View All Articles</a>
            </div>      </div>
            <!-- Ad/Promo Space -->
            <div class="relative overflow-hidden bg-primary-container p-6 rounded-xl text-on-primary-container shadow-lg border border-primary">
                <div class="relative z-10">
                    <h5 class="font-headline-md mb-2">Join the Community</h5>
                    <p class="text-label-md opacity-90 mb-4">Get the latest technical deep dives delivered straight to your inbox.</p>
                    <button class="bg-white text-primary w-full py-2 rounded-lg font-bold shadow-sm hover:bg-opacity-95 transition-colors">Subscribe Now</button>
                </div>
                <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
            </div>
        </aside>
    </div>
</main>
<!-- Footer -->
<x-footer class="bg-surface border-t border-outline-variant dark:border-border-dark mt-stack-lg" />
@endsection

@push('scripts')
<script>
function copyCode(button) {
    const codeBlock = button.closest('.bg-slate-900').querySelector('code');
    const text = codeBlock.textContent;
    navigator.clipboard.writeText(text).then(() => {
        const icon = button.querySelector('.material-symbols-outlined');
        icon.textContent = 'check';
        setTimeout(() => {
            icon.textContent = 'content_copy';
        }, 2000);
    });
}
</script>
@endpush
