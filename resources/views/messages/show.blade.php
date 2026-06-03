@extends('layouts.app')

@section('title', 'DevConnect | Chat - ' . $otherUser->name)
@section('body-class', 'bg-surface text-on-surface min-h-screen flex flex-col')

@section('content')
<x-navigation active="messages" />

<main class="flex-grow pt-20 pb-0 max-w-4xl mx-auto px-4 md:px-8 w-full h-[calc(100vh-64px)] flex flex-col mb-4">
    <div class="bg-white border border-border-light rounded-2xl shadow-sm flex flex-col flex-1 mt-4 overflow-hidden">
        
        <!-- Minimal Header -->
        <div class="border-b border-border-light px-6 py-4 flex items-center bg-surface-container-lowest">
            <a href="{{ route('messages.index') }}" class="mr-4 text-secondary hover:text-primary transition-colors">
                <span class="material-symbols-outlined">arrow_back</span>
            </a>
            
            <div class="w-10 h-10 rounded-full overflow-hidden mr-3">
                <img alt="{{ $otherUser->name }}" class="w-full h-full object-cover" src="{{ $otherUser->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($otherUser->name).'&color=7F9CF5&background=EBF4FF' }}"/>
            </div>
            
            <div class="flex-1">
                <a href="{{ route('profile', ['id' => $otherUser->id]) }}" class="font-bold text-on-surface hover:text-primary transition-colors block leading-tight">{{ $otherUser->name }}</a>
                <span class="text-[12px] text-primary flex items-center gap-1 mt-0.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-primary animate-pulse"></span>
                    Online
                </span>
            </div>

            <button class="text-secondary hover:text-primary transition-colors">
                <span class="material-symbols-outlined">more_vert</span>
            </button>
        </div>

        <!-- Messages Area -->
        <div class="flex-1 p-6 overflow-y-auto bg-[#f8fafc] flex flex-col gap-4" id="messages-container">
            @forelse($messages as $message)
                @php
                    $isMine = $message->sender_id === $user->id;
                @endphp
                
                <div class="flex w-full {{ $isMine ? 'justify-end' : 'justify-start' }} message-item" data-id="{{ $message->id }}">
                    @if(!$isMine)
                        <div class="w-8 h-8 rounded-full overflow-hidden flex-shrink-0 mr-3 mt-auto">
                            <img alt="{{ $otherUser->name }}" class="w-full h-full object-cover" src="{{ $otherUser->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($otherUser->name).'&color=7F9CF5&background=EBF4FF' }}"/>
                        </div>
                    @endif
                    
                    <div class="max-w-[75%] flex flex-col {{ $isMine ? 'items-end' : 'items-start' }}">
                        <div class="px-4 py-2.5 shadow-sm text-[15px] {{ $isMine ? 'bg-primary text-white rounded-2xl rounded-br-sm' : 'bg-white text-slate-800 rounded-2xl rounded-bl-sm border border-slate-100' }}">
                            <p class="whitespace-pre-wrap break-words leading-snug">{{ $message->body }}</p>
                        </div>
                        <div class="text-[11px] mt-1 text-slate-400 flex items-center gap-1 px-1">
                            {{ $message->created_at->format('H:i') }}
                            @if($isMine)
                                <span class="material-symbols-outlined text-[13px] {{ $message->read_at ? 'text-primary' : '' }}">
                                    {{ $message->read_at ? 'done_all' : 'check' }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="m-auto text-center py-10" id="empty-state">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-primary/10 text-primary mb-4">
                        <span class="material-symbols-outlined text-[32px]">waving_hand</span>
                    </div>
                    <h4 class="text-lg font-bold text-slate-800 mb-1">Sohbete Başlayın</h4>
                    <p class="text-slate-500 text-sm">İlk mesajı siz gönderin ve iletişime geçin.</p>
                </div>
            @endforelse
        </div>

        <!-- Minimal Input Area -->
        <div class="p-4 bg-white border-t border-border-light">
            <form id="chat-form" action="{{ route('messages.store', $conversation->id) }}" method="POST" class="flex gap-2 items-center">
                @csrf
                <button type="button" class="text-slate-400 hover:text-primary p-2 transition-colors shrink-0">
                    <span class="material-symbols-outlined">attach_file</span>
                </button>
                
                <div class="flex-1 bg-slate-100 rounded-full flex items-center px-4 py-1">
                    <input type="text" id="chat-input" name="body" class="w-full bg-transparent border-none focus:outline-none focus:ring-0 text-slate-700 py-2" placeholder="Mesajınızı yazın..." required autocomplete="off" autofocus>
                    <button type="button" class="text-slate-400 hover:text-slate-600 transition-colors">
                        <span class="material-symbols-outlined text-[20px]">mood</span>
                    </button>
                </div>
                
                <button type="submit" id="submit-btn" class="w-11 h-11 rounded-full bg-primary hover:bg-primary-container text-white flex items-center justify-center transition-colors shrink-0 shadow-sm ml-1">
                    <span class="material-symbols-outlined text-[18px] ml-1">send</span>
                </button>
            </form>
        </div>
    </div>
</main>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('messages-container');
        const form = document.getElementById('chat-form');
        const input = document.getElementById('chat-input');
        const emptyState = document.getElementById('empty-state');
        const currentUserId = {{ $user->id }};
        const conversationId = {{ $conversation->id }};
        const submitBtn = document.getElementById('submit-btn');

        function scrollToBottom() {
            if (container) {
                container.scrollTop = container.scrollHeight;
            }
        }
        scrollToBottom();

        if (window.Echo) {
            window.Echo.private(`chat.${conversationId}`)
                .listen('MessageSent', (e) => {
                    if (e.message.sender_id !== currentUserId) {
                        appendMessage(e.message, e.user, false);
                    }
                });
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const body = input.value.trim();
            if (!body) return;

            const formData = new FormData(form);
            
            submitBtn.style.opacity = '0.5';
            submitBtn.disabled = true;

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    input.value = '';
                    appendMessage(data.message, {id: currentUserId}, true);
                }
            })
            .catch(error => console.error('Error sending message:', error))
            .finally(() => {
                submitBtn.style.opacity = '1';
                submitBtn.disabled = false;
                input.focus();
            });
        });

        function appendMessage(message, user, isMine) {
            if (emptyState) {
                emptyState.remove();
            }

            const justify = isMine ? 'justify-end' : 'justify-start';
            const alignItems = isMine ? 'items-end' : 'items-start';
            const bubbleClasses = isMine 
                ? 'bg-primary text-white rounded-2xl rounded-br-sm' 
                : 'bg-white text-slate-800 rounded-2xl rounded-bl-sm border border-slate-100';
            
            const checkIcon = isMine ? `<span class="material-symbols-outlined text-[13px]">check</span>` : '';
            
            const avatarHtml = !isMine ? `
                <div class="w-8 h-8 rounded-full overflow-hidden flex-shrink-0 mr-3 mt-auto">
                    <img alt="Avatar" class="w-full h-full object-cover" src="${user.avatar || 'https://ui-avatars.com/api/?name='+encodeURIComponent(user.name)+'&color=7F9CF5&background=EBF4FF'}"/>
                </div>
            ` : '';

            const html = `
                <div class="flex w-full ${justify} message-item">
                    ${avatarHtml}
                    <div class="max-w-[75%] flex flex-col ${alignItems} animate-[fadeIn_0.2s_ease-out]">
                        <div class="px-4 py-2.5 shadow-sm text-[15px] ${bubbleClasses}">
                            <p class="whitespace-pre-wrap break-words leading-snug">${escapeHtml(message.body)}</p>
                        </div>
                        <div class="text-[11px] mt-1 text-slate-400 flex items-center gap-1 px-1">
                            ${message.created_at}
                            ${checkIcon}
                        </div>
                    </div>
                </div>
            `;

            container.insertAdjacentHTML('beforeend', html);
            scrollToBottom();
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
<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(5px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush
@endsection
