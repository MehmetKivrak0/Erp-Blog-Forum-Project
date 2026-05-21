@extends('layouts.app')

@section('title', 'DevConnect | User Profile')
@section('body-class', 'bg-background-light text-on-surface font-body-md text-body-md selection:bg-primary-fixed selection:text-on-primary-fixed')

@push('styles')
    <style>
        .bento-card {
            transition: all 0.2s ease-in-out;
        }
        .bento-card:hover {
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            border-color: #4f46e5;
        }
    </style>
@endpush

@section('content')
<x-navigation class="bg-background-light border-b border-border-light fixed top-0 w-full" />
<main class="pt-16 pb-24 max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
    <div class="relative mt-stack-lg rounded-xl overflow-hidden shadow-sm border border-border-light">
        <div class="h-48 md:h-64 w-full relative">
            <img alt="Cover Image" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAlbuAY3AfkzwDRbVZ3unr6npf6HHDBbL6rqUak-BpoHFgMTXgoH5z8fBAyG6AXWCjldpjr2KjxVsNwDB0_7PhLdiZswh_M3cIRs5Bl_0XvAMSUm-UdfG0j6Bv7KIpBQiOVqS_LVNzEnuGg_vrS5iD-3LH5-muPO2HQdMhiopRubd49yw_uflWHLkrAlCQL2lp56dxeQKch2P6Qlq3L1Q8o5S12_okEROT0RRgRxizB4GWSuvz91nt7Nq2dJy8bYIzqkcIoh1OK4rY"/>
            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
        </div>
        <div class="bg-white p-stack-md relative pt-0 md:pt-0">
            <div class="flex flex-col md:flex-row items-end md:items-center -mt-12 md:-mt-16 gap-stack-md md:gap-stack-lg px-stack-md">
                <div class="relative h-24 w-24 md:h-32 md:32 rounded-full border-4 border-white shadow-lg overflow-hidden bg-white">
                    <img alt="User avatar" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDcQI3n2rB_Jp7OAtHKUbNMje3QoI2y8qx1YQW7lxxNq9qX1nPDp0nwdqTFGbITlU681ssyqK0hl1lYtobuGTXhPb83_WusjWymT0XAGOie7HaDrlPxYqobPQyZAjqwk1XZV-iJuNSFYfoMIqaO1JzTCWTbY_nA93qTh9Lgs6EJqKrICyn_4fjmlXlxMpEDDsq0wFfZu1sDX1HA301hCdQfEZuxZLD3qeY5BPUnWEQM_z5vvVzZMYueKbC3y2dlL0uPFe999KptTa4"/>
                </div>
                <div class="flex-1 pb-stack-sm text-center md:text-left mt-2 md:mt-16">
                    <h1 class="font-headline-xl text-headline-xl text-on-surface">@dev_explorer</h1>
                    <div class="flex flex-wrap justify-center md:justify-start gap-2 mt-stack-sm">
                        <span class="bg-primary-container text-on-primary-container px-3 py-1 rounded-full text-label-sm flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px]">star</span>
                            Core Contributor
                        </span>
                        <span class="bg-secondary-container text-on-secondary-container px-3 py-1 rounded-full text-label-sm flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px]">experiment</span>
                            Beta Tester
                        </span>
                    </div>
                </div>
                <div class="flex gap-stack-sm md:mt-16 pb-stack-sm">
                    <button class="bg-primary hover:bg-primary-container text-white px-6 py-2 rounded-lg font-label-md transition-all flex items-center gap-2 shadow-sm">
                        <span class="material-symbols-outlined text-[18px]">mail</span>
                        Direct Message
                    </button>
                    <button class="border border-border-light hover:bg-surface-hover p-2 rounded-lg transition-all">
                        <span class="material-symbols-outlined text-secondary">more_horiz</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-12 gap-gutter mt-stack-lg">
        <div class="md:col-span-4 space-y-stack-md">
            <div class="bento-card bg-white border border-border-light p-stack-md rounded-xl">
                <div class="flex items-center justify-between mb-stack-md">
                    <h3 class="font-headline-md text-headline-md flex items-center gap-2 text-on-surface">
                        <span class="material-symbols-outlined text-error" style="font-variation-settings: 'FILL' 1;">local_fire_department</span>
                        Streak
                    </h3>
                    <span class="text-label-md text-secondary">Active</span>
                </div>
                <div class="text-center py-stack-md">
                    <div class="text-4xl font-bold text-on-surface">15 Day Streak</div>
                    <p class="text-label-md text-secondary mt-1">Keep it going, Explorer!</p>
                </div>
                <div class="grid grid-cols-7 gap-1 mt-stack-md">
                    <div class="h-1.5 rounded-full bg-error"></div>
                    <div class="h-1.5 rounded-full bg-error"></div>
                    <div class="h-1.5 rounded-full bg-error"></div>
                    <div class="h-1.5 rounded-full bg-error"></div>
                    <div class="h-1.5 rounded-full bg-error"></div>
                    <div class="h-1.5 rounded-full bg-error"></div>
                    <div class="h-1.5 rounded-full bg-surface-container-highest"></div>
                </div>
            </div>
            <div class="bento-card bg-white border border-border-light p-stack-md rounded-xl">
                <h3 class="font-headline-md text-headline-md mb-stack-md text-on-surface">Achievements</h3>
                <div class="grid grid-cols-3 gap-stack-sm">
                    <div class="flex flex-col items-center p-stack-sm group">
                        <div class="w-12 h-12 rounded-full bg-secondary-container flex items-center justify-center text-primary group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-[24px]" style="font-variation-settings: 'FILL' 1;">emoji_events</span>
                        </div>
                        <span class="text-label-sm mt-2 text-center text-on-surface">First Post</span>
                    </div>
                    <div class="flex flex-col items-center p-stack-sm group">
                        <div class="w-12 h-12 rounded-full bg-secondary-container flex items-center justify-center text-primary group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-[24px]" style="font-variation-settings: 'FILL' 1;">code</span>
                        </div>
                        <span class="text-label-sm mt-2 text-center text-on-surface">Code Reviewer</span>
                    </div>
                    <div class="flex flex-col items-center p-stack-sm group">
                        <div class="w-12 h-12 rounded-full bg-secondary-container flex items-center justify-center text-primary group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-[24px]" style="font-variation-settings: 'FILL' 1;">bug_report</span>
                        </div>
                        <span class="text-label-sm mt-2 text-center text-on-surface">Bug Hunter</span>
                    </div>
                </div>
                <button class="w-full mt-stack-md text-label-md text-primary font-semibold py-2 hover:bg-primary-fixed/30 rounded-lg transition-colors">View All 12 Medals</button>
            </div>
        </div>
        <div class="md:col-span-8">
            <div class="bg-white border border-border-light rounded-xl overflow-hidden h-full flex flex-col">
                <div class="border-b border-border-light">
                    <nav class="flex px-stack-md" role="tablist">
                        <button role="tab" aria-selected="true" data-tab="activities" class="tab-btn px-stack-md py-4 font-label-md text-primary border-b-2 border-primary transition-colors" id="tab-btn-activities">Recent Activities</button>
                        <button role="tab" aria-selected="false" data-tab="forum" class="tab-btn px-stack-md py-4 font-label-md text-secondary hover:text-primary border-b-2 border-transparent transition-colors" id="tab-btn-forum">My Forum Topics</button>
                        <button role="tab" aria-selected="false" data-tab="moderation" class="tab-btn px-stack-md py-4 font-label-md text-secondary hover:text-primary border-b-2 border-transparent transition-colors" id="tab-btn-moderation">Warnings/Moderation Log</button>
                    </nav>
                </div>
                <div class="p-stack-md flex-1 overflow-y-auto">
                    <!-- Tab: Recent Activities -->
                    <div id="tab-activities" role="tabpanel">
                        <div class="space-y-stack-md">
                            <div class="flex gap-stack-md items-start p-stack-md hover:bg-surface-hover rounded-lg transition-all group">
                                <div class="mt-1 material-symbols-outlined text-secondary group-hover:text-primary">chat_bubble</div>
                                <div class="flex-1">
                                    <div class="flex justify-between items-center">
                                        <p class="text-on-surface font-semibold">Commented on "Optimizing Rust Web Servers"</p>
                                        <span class="text-label-sm text-secondary">2h ago</span>
                                    </div>
                                    <p class="text-on-surface-variant mt-1 italic">"Have you considered using Actix with Tokio for better throughput? I saw a 15% increase in my latest project..."</p>
                                </div>
                            </div>
                            <div class="flex gap-stack-md items-start p-stack-md hover:bg-surface-hover rounded-lg transition-all group border-t border-border-light/50 pt-stack-md">
                                <div class="mt-1 material-symbols-outlined text-secondary group-hover:text-primary">thumb_up</div>
                                <div class="flex-1">
                                    <div class="flex justify-between items-center">
                                        <p class="text-on-surface font-semibold">Upvoted a post by @rust_ninja</p>
                                        <span class="text-label-sm text-secondary">5h ago</span>
                                    </div>
                                    <p class="text-on-surface-variant mt-1">Topic: "State of WASM in 2026"</p>
                                </div>
                            </div>
                            <div class="flex gap-stack-md items-start p-stack-md hover:bg-surface-hover rounded-lg transition-all group border-t border-border-light/50 pt-stack-md">
                                <div class="mt-1 material-symbols-outlined text-secondary group-hover:text-primary">article</div>
                                <div class="flex-1">
                                    <div class="flex justify-between items-center">
                                        <p class="text-on-surface font-semibold">Published a new article</p>
                                        <span class="text-label-sm text-secondary">1d ago</span>
                                    </div>
                                    <h4 class="text-primary font-bold mt-1">A Comprehensive Guide to TypeScript Decorators</h4>
                                    <div class="flex gap-stack-sm mt-stack-sm">
                                        <span class="bg-secondary-container/30 text-on-secondary-container px-2 py-0.5 rounded text-[12px]">TypeScript</span>
                                        <span class="bg-secondary-container/30 text-on-secondary-container px-2 py-0.5 rounded text-[12px]">Architecture</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex gap-stack-md items-start p-stack-md hover:bg-surface-hover rounded-lg transition-all group border-t border-border-light/50 pt-stack-md">
                                <div class="mt-1 material-symbols-outlined text-secondary group-hover:text-primary">fact_check</div>
                                <div class="flex-1">
                                    <div class="flex justify-between items-center">
                                        <p class="text-on-surface font-semibold">Completed Code Review</p>
                                        <span class="text-label-sm text-secondary">2d ago</span>
                                    </div>
                                    <p class="text-on-surface-variant mt-1">Reviewed PR #442: "Implement GraphQL Subscription Support"</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Tab: My Forum Topics -->
                    <div id="tab-forum" role="tabpanel" class="hidden">
                        <div class="space-y-stack-sm">
                            <div class="flex items-start gap-stack-md p-stack-md hover:bg-surface-hover rounded-lg transition-all group">
                                <span class="material-symbols-outlined text-secondary group-hover:text-primary mt-1">forum</span>
                                <div class="flex-1">
                                    <div class="flex justify-between items-center">
                                        <p class="text-on-surface font-semibold">Horizontal Scaling for Node.js APIs</p>
                                        <span class="text-label-sm text-secondary">3d ago</span>
                                    </div>
                                    <p class="text-on-surface-variant text-label-sm mt-1">12 replies &bull; 348 views</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-stack-md p-stack-md hover:bg-surface-hover rounded-lg transition-all group border-t border-border-light/50">
                                <span class="material-symbols-outlined text-secondary group-hover:text-primary mt-1">forum</span>
                                <div class="flex-1">
                                    <div class="flex justify-between items-center">
                                        <p class="text-on-surface font-semibold">Best practices for distributed caching with Redis</p>
                                        <span class="text-label-sm text-secondary">1w ago</span>
                                    </div>
                                    <p class="text-on-surface-variant text-label-sm mt-1">7 replies &bull; 201 views</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Tab: Warnings / Moderation Log -->
                    <div id="tab-moderation" role="tabpanel" class="hidden">
                        <div class="flex flex-col items-center justify-center py-12 text-center space-y-4 text-on-surface-variant">
                            <span class="material-symbols-outlined text-[48px] text-emerald-500">verified_user</span>
                            <p class="font-headline-md text-headline-md text-on-surface">Temiz Kayıt</p>
                            <p class="text-body-md">Hesabınıza ait herhangi bir uyarı veya moderasyon kaydı bulunmamaktadır.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<x-footer class="bg-surface-container-lowest border-t border-border-light mt-stack-lg" />
@endsection

@push('scripts')
<script>
    (function () {
        const tabs = document.querySelectorAll('.tab-btn');
        const panels = {
            activities: document.getElementById('tab-activities'),
            forum:      document.getElementById('tab-forum'),
            moderation: document.getElementById('tab-moderation'),
        };

        tabs.forEach(function (btn) {
            btn.addEventListener('click', function () {
                const target = btn.getAttribute('data-tab');

                // Deactivate all tabs
                tabs.forEach(function (t) {
                    t.classList.remove('text-primary', 'border-primary');
                    t.classList.add('text-secondary', 'border-transparent');
                    t.setAttribute('aria-selected', 'false');
                });

                // Hide all panels
                Object.values(panels).forEach(function (p) { p.classList.add('hidden'); });

                // Activate clicked tab
                btn.classList.add('text-primary', 'border-primary');
                btn.classList.remove('text-secondary', 'border-transparent');
                btn.setAttribute('aria-selected', 'true');

                // Show target panel
                if (panels[target]) {
                    panels[target].classList.remove('hidden');
                }
            });
        });
    })();
</script>
@endpush
