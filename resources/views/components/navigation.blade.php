@props([
    'brand' => 'DevConnect',
    'active' => '',
    'search' => true
])

<header {{ $attributes->merge(['class' => 'sticky top-0 z-50 bg-surface-container-lowest border-b border-border-light w-full']) }}>
    <div class="flex justify-between items-center w-full px-margin-desktop max-w-container-max mx-auto h-16">
        <!-- Brand -->
        <a href="{{ route('home') }}" class="text-headline-lg font-headline-lg font-bold text-primary hover:opacity-90 text-decoration-none">{{ $brand }}</a>
        
        <!-- Navigation -->
        <nav class="hidden md:flex gap-gutter items-center">
            <a class="{{ $active === 'feed' ? 'text-primary border-b-2 border-primary pb-1 font-bold' : 'text-on-surface-variant font-medium hover:text-primary transition-colors duration-150 ease-in-out' }} text-label-md font-label-md text-decoration-none" href="{{ route('home') }}">Feed</a>
            <a class="{{ $active === 'discussions' ? 'text-primary border-b-2 border-primary pb-1 font-bold' : 'text-on-surface-variant font-medium hover:text-primary transition-colors duration-150 ease-in-out' }} text-label-md font-label-md text-decoration-none" href="{{ route('forum.index') }}">Discussions</a>
            <a class="{{ $active === 'articles' ? 'text-primary border-b-2 border-primary pb-1 font-bold' : 'text-on-surface-variant font-medium hover:text-primary transition-colors duration-150 ease-in-out' }} text-label-md font-label-md text-decoration-none" href="{{ route('blog.index') }}">Articles</a>
            <a class="{{ $active === 'support' ? 'text-primary border-b-2 border-primary pb-1 font-bold' : 'text-on-surface-variant font-medium hover:text-primary transition-colors duration-150 ease-in-out' }} text-label-md font-label-md text-decoration-none" href="{{ route('support.index') }}">Support</a>
        </nav>
        
        <!-- Actions -->
        <div class="flex items-center gap-stack-md">
            @if($search)
            <form action="{{ route('forum.index') }}" method="GET" class="hidden md:flex items-center bg-surface-container-low px-stack-md py-stack-sm rounded-lg border border-outline-variant/10">
                <span class="material-symbols-outlined text-outline mr-2" data-icon="search">search</span>
                <input name="search" value="{{ request('search') }}" class="bg-transparent border-none focus:ring-0 text-body-md font-body-md w-48 lg:w-64 text-on-surface" placeholder="Search discussions..." type="text"/>
            </form>
            @endif
            @auth
                @php
                    $unreadMessages = \App\Models\Message::whereHas('conversation', function($q) {
                        $q->where('user_one_id', auth()->id())->orWhere('user_two_id', auth()->id());
                    })->where('sender_id', '!=', auth()->id())->whereNull('read_at')->count();
                    
                    $recentConversations = \App\Models\Conversation::with(['userOne', 'userTwo', 'messages' => function($q) {
                            $q->latest()->limit(1);
                        }])
                        ->where('user_one_id', auth()->id())
                        ->orWhere('user_two_id', auth()->id())
                        ->get()
                        ->sortByDesc(function($conv) {
                            return $conv->messages->first()?->created_at ?? $conv->created_at;
                        })->take(5);
                @endphp
                
                <div class="relative" id="notifications-wrapper">
                    <button type="button" id="notification-btn" onclick="document.getElementById('notification-dropdown').classList.toggle('hidden')" class="relative text-on-surface-variant p-2 hover:bg-surface-hover rounded-full inline-flex items-center justify-center mr-1 cursor-pointer focus:outline-none" title="Messages & Notifications">
                        <span class="material-symbols-outlined" data-icon="notifications">notifications</span>
                        @if($unreadMessages > 0)
                            <span id="notification-badge" class="absolute top-1 right-1 bg-error text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full min-w-[16px] text-center leading-none">{{ $unreadMessages }}</span>
                        @endif
                    </button>

                    <!-- Dropdown -->
                    <div id="notification-dropdown" class="hidden absolute right-0 mt-2 w-80 bg-white border border-border-light rounded-xl shadow-xl z-[100] overflow-hidden flex flex-col">
                        <div class="px-4 py-3 border-b border-border-light bg-surface-container-lowest flex justify-between items-center">
                            <span class="font-bold text-on-surface text-label-md">Notifications & Messages</span>
                            <a href="{{ route('messages.index') }}" class="text-primary hover:underline text-[12px] font-semibold">Tümünü Gör</a>
                        </div>
                        <div class="overflow-y-auto max-h-96 flex flex-col" id="notification-list">
                            @forelse($recentConversations as $conv)
                                @php
                                    $other = $conv->user_one_id === auth()->id() ? $conv->userTwo : $conv->userOne;
                                    $lastMsg = $conv->messages->first();
                                    $isUnread = $lastMsg && $lastMsg->sender_id !== auth()->id() && is_null($lastMsg->read_at);
                                @endphp
                                <a id="nav-conv-{{ $conv->id }}" href="{{ route('messages.show', $other->id) }}" class="flex items-start gap-3 p-3 border-b border-border-light/50 hover:bg-surface-hover transition-colors {{ $isUnread ? 'bg-primary-container/10' : '' }}">
                                    <div class="relative w-10 h-10 rounded-full overflow-hidden flex-shrink-0">
                                        <img src="{{ $other->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($other->name).'&color=7F9CF5&background=EBF4FF' }}" class="w-full h-full object-cover">
                                        @if($isUnread)
                                            <span class="absolute top-0 right-0 w-2.5 h-2.5 bg-primary rounded-full border-2 border-white"></span>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex justify-between items-baseline mb-0.5">
                                            <span class="font-semibold text-[14px] text-on-surface truncate">{{ $other->name }}</span>
                                            @if($lastMsg)
                                                <span class="text-[11px] text-on-surface-variant flex-shrink-0">{{ $lastMsg->created_at->diffForHumans(null, true, true) }}</span>
                                            @endif
                                        </div>
                                        @if($lastMsg)
                                            <p class="text-[13px] truncate {{ $isUnread ? 'text-on-surface font-semibold' : 'text-on-surface-variant' }}">
                                                {{ $lastMsg->sender_id === auth()->id() ? 'Siz: ' : '' }}{{ $lastMsg->body }}
                                            </p>
                                        @else
                                            <p class="text-[13px] text-on-surface-variant italic">Henüz mesaj yok</p>
                                        @endif
                                    </div>
                                </a>
                            @empty
                                <div class="p-6 text-center text-on-surface-variant flex flex-col items-center" id="notification-empty">
                                    <span class="material-symbols-outlined text-[32px] mb-2 opacity-50">notifications_off</span>
                                    <span class="text-[14px]">Hiç bildiriminiz yok</span>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <script>
                    document.addEventListener('click', function(event) {
                        const wrapper = document.getElementById('notifications-wrapper');
                        const dropdown = document.getElementById('notification-dropdown');
                        if (wrapper && dropdown && !wrapper.contains(event.target)) {
                            dropdown.classList.add('hidden');
                        }
                    });

                    document.addEventListener('DOMContentLoaded', function() {
                        const currentUserId = {{ auth()->id() }};
                        if (window.Echo) {
                            window.Echo.private(`App.Models.User.${currentUserId}`)
                                .listen('MessageSent', (e) => {
                                    // Sadece bize gelen mesajları bildirim olarak göster (gönderen biz değilsek)
                                    if (e.message.sender_id !== currentUserId) {
                                        
                                        // 1. Zildeki rakamı güncelle
                                        let badge = document.getElementById('notification-badge');
                                        if (!badge) {
                                            const btn = document.getElementById('notification-btn');
                                            badge = document.createElement('span');
                                            badge.id = 'notification-badge';
                                            badge.className = 'absolute top-1 right-1 bg-error text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full min-w-[16px] text-center leading-none';
                                            badge.innerText = '1';
                                            btn.appendChild(badge);
                                        } else {
                                            badge.innerText = parseInt(badge.innerText) + 1;
                                        }

                                        // 2. Dropdown listesinin içine ekle veya güncelle
                                        const listContainer = document.getElementById('notification-list');
                                        const emptyState = document.getElementById('notification-empty');
                                        if (emptyState) emptyState.remove();

                                        // Eski conversation HTML'ini bul (varsa) ve sil ki en üste ekleyelim
                                        const existingConv = document.getElementById(`nav-conv-${e.message.conversation_id}`);
                                        if (existingConv) {
                                            existingConv.remove();
                                        }

                                        // Yeni HTML
                                        const html = `
                                            <a id="nav-conv-${e.message.conversation_id}" href="/messages/${e.user.id}" class="flex items-start gap-3 p-3 border-b border-border-light/50 hover:bg-surface-hover transition-colors bg-primary-container/10">
                                                <div class="relative w-10 h-10 rounded-full overflow-hidden flex-shrink-0">
                                                    <img src="${e.user.avatar}" class="w-full h-full object-cover">
                                                    <span class="absolute top-0 right-0 w-2.5 h-2.5 bg-primary rounded-full border-2 border-white"></span>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <div class="flex justify-between items-baseline mb-0.5">
                                                        <span class="font-semibold text-[14px] text-on-surface truncate">${e.user.name}</span>
                                                        <span class="text-[11px] text-on-surface-variant flex-shrink-0">şimdi</span>
                                                    </div>
                                                    <p class="text-[13px] truncate text-on-surface font-semibold">
                                                        ${escapeHtml(e.message.body)}
                                                    </p>
                                                </div>
                                            </a>
                                        `;

                                        listContainer.insertAdjacentHTML('afterbegin', html);
                                        
                                        // Max 5 items göster
                                        if (listContainer.children.length > 5) {
                                            listContainer.lastElementChild.remove();
                                        }
                                    }
                                });
                        }

                        function escapeHtml(unsafe) {
                            return unsafe
                                .replace(/&/g, "&amp;")
                                .replace(/</g, "&lt;")
                                .replace(/>/g, "&gt;")
                                .replace(/"/g, "&quot;")
                                .replace(/'/g, "&#039;");
                        }
                    });
                </script>

                @php
                    $userRole = auth()->user()->role?->value ?? 'user';
                    $panelConfig = match($userRole) {
                        'admin'     => ['label' => '⚙ Admin Panel',     'route' => 'admin.dashboard', 'cls' => 'bg-red-600 hover:bg-red-700 text-white'],
                        'moderator' => ['label' => '🛡 Moderatör Hub',  'route' => 'admin.moderator', 'cls' => 'bg-indigo-600 hover:bg-indigo-700 text-white'],
                        'developer' => ['label' => '🖥 Sistem Monitör', 'route' => 'admin.monitor',  'cls' => 'bg-emerald-600 hover:bg-emerald-700 text-white'],
                        default     => null,
                    };
                @endphp

                <a href="{{ route('profile') }}" class="h-8 w-8 rounded-full bg-secondary-container overflow-hidden block hover:ring-2 hover:ring-primary/20 flex-shrink-0" title="{{ auth()->user()->name }}">
                    <img alt="User profile avatar" class="w-full h-full object-cover" src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&color=7F9CF5&background=EBF4FF&size=64' }}"/>
                </a>

                @if($panelConfig)
                    {{-- Privileged role: show panel shortcut, hide Create Post --}}
                    <a href="{{ route($panelConfig['route']) }}"
                       class="hidden lg:inline-flex items-center gap-1.5 px-stack-md py-stack-sm rounded-lg text-label-md font-label-md font-bold transition-all text-decoration-none shadow-sm {{ $panelConfig['cls'] }}">
                        {{ $panelConfig['label'] }}
                    </a>
                @else
                    {{-- Regular user: show Create Post --}}
                    <a href="{{ route('blog.create') }}"
                       class="hidden lg:block bg-primary text-on-primary px-stack-md py-stack-sm rounded-lg text-label-md font-label-md font-bold hover:opacity-90 transition-all text-decoration-none">
                        Create Post
                    </a>
                @endif

                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="hidden md:flex items-center text-on-surface-variant hover:text-primary transition-colors text-label-md font-label-md bg-transparent border-none cursor-pointer p-2 hover:bg-surface-hover rounded-lg gap-1">
                        <span class="material-symbols-outlined text-[20px]" data-icon="logout">logout</span>
                        <span>Logout</span>
                    </button>
                </form>
            @endauth
            
            @guest
                <a href="{{ route('login') }}" class="text-on-surface-variant font-medium hover:text-primary transition-colors duration-150 ease-in-out text-label-md font-label-md text-decoration-none px-stack-md py-stack-sm">Sign In</a>
                <a href="{{ route('register') }}" class="bg-primary text-on-primary px-stack-md py-stack-sm rounded-lg text-label-md font-label-md font-bold hover:opacity-90 transition-all text-decoration-none">Register</a>
            @endguest
        </div>
    </div>
</header>
