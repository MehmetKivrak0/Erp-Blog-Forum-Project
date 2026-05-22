@extends('layouts.app')

@section('title', 'DevNexus Console - System Health')
@section('body-class', 'bg-background dark:bg-background-dark text-on-surface dark:text-inverse-on-surface font-body-md overflow-x-hidden')

@push('styles')
    <style>
        .material-symbols-outlined {
            display: inline-block;
            line-height: 1;
            vertical-align: middle;
        }
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #1e293b;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #475569;
            border-radius: 10px;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(8px);
            border: 1px solid #e2e8f0;
        }
        .dark .glass-card {
            background: rgba(15, 23, 42, 0.6);
            border-color: #1e293b;
        }
    </style>
@endpush

@section('content')
<!-- TopNavBar -->
<header class="flex justify-between items-center w-full px-margin-desktop h-16 fixed top-0 z-50 bg-surface dark:bg-background-dark border-b border-border-light dark:border-border-dark flat no shadows">
    <div class="flex items-center gap-stack-md">
        <a href="{{ route('home') }}" class="font-headline-md text-headline-md font-bold text-primary dark:text-primary-fixed-dim hover:opacity-90">DevNexus Console</a>
        <div class="hidden md:flex items-center bg-surface-container-low dark:bg-slate-900 border border-border-light dark:border-slate-800 rounded-lg px-3 py-1.5">
            <span class="material-symbols-outlined text-outline mr-2" data-icon="search">search</span>
            <input id="logs-search" class="bg-transparent border-none focus:ring-0 text-label-md w-64 text-on-surface dark:text-white" placeholder="Search logs, nodes, or metrics..." type="text"/>
        </div>
    </div>
    <div class="flex items-center gap-stack-md">
        <!-- Theme Toggle -->
        <button id="theme-toggle" class="p-2 rounded-full hover:bg-surface-hover dark:hover:bg-surface-container-high transition-colors duration-150 scale-95 active:opacity-80 transition-all" title="Toggle Theme">
            <span class="material-symbols-outlined text-on-surface-variant dark:text-outline" id="theme-icon">dark_mode</span>
        </button>
        <!-- Notifications -->
        <div class="relative">
            <button id="notifications-btn" class="p-2 rounded-full hover:bg-surface-hover dark:hover:bg-surface-container-high transition-colors duration-150 scale-95 active:opacity-80 transition-all relative">
                <span class="material-symbols-outlined text-on-surface-variant dark:text-outline" data-icon="notifications">notifications</span>
                <span id="notifications-badge" class="absolute top-2 right-2 w-2 h-2 bg-error rounded-full"></span>
            </button>
            <!-- Notifications Dropdown -->
            <div id="notifications-dropdown" class="hidden absolute right-0 mt-2 w-80 bg-surface dark:bg-slate-900 border border-outline-variant dark:border-slate-800 rounded-xl shadow-xl z-50 p-4 text-left">
                <div class="flex justify-between items-center border-b border-outline-variant dark:border-slate-800 pb-2 mb-2">
                    <h4 class="text-label-md font-bold text-on-background dark:text-white">Admin Alerts</h4>
                    <button id="clear-notifications" class="text-primary dark:text-primary-fixed-dim text-[12px] hover:underline">Clear all</button>
                </div>
                <div class="space-y-3 max-h-60 overflow-y-auto">
                    <div class="flex gap-3 p-2 rounded hover:bg-surface-hover dark:hover:bg-surface-container-high">
                        <span class="material-symbols-outlined text-error text-[20px] mt-0.5">report</span>
                        <div>
                            <p class="text-label-md text-on-background dark:text-white">New user report on thread #105</p>
                            <p class="text-[10px] text-outline">2 mins ago</p>
                        </div>
                    </div>
                    <div class="flex gap-3 p-2 rounded hover:bg-surface-hover dark:hover:bg-surface-container-high">
                        <span class="material-symbols-outlined text-primary text-[20px] mt-0.5">group</span>
                        <div>
                            <p class="text-label-md text-on-background dark:text-white">Sarah requested Moderator role</p>
                            <p class="text-[10px] text-outline">1 hour ago</p>
                        </div>
                    </div>
                    <div class="flex gap-3 p-2 rounded hover:bg-surface-hover dark:hover:bg-surface-container-high">
                        <span class="material-symbols-outlined text-[#15803d] text-[20px] mt-0.5">check_circle</span>
                        <div>
                            <p class="text-label-md text-on-background dark:text-white">CPU utilization stable under load</p>
                            <p class="text-[10px] text-outline">4 hours ago</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Settings -->
        <button onclick="showToast('System configuration settings opened')" class="p-2 rounded-full hover:bg-surface-hover dark:hover:bg-surface-container-high transition-colors duration-150 scale-95 active:opacity-80 transition-all">
            <span class="material-symbols-outlined text-on-surface-variant dark:text-outline" data-icon="settings">settings</span>
        </button>
        <!-- Profile -->
        <a href="{{ route('profile') }}" class="h-8 w-8 rounded-full overflow-hidden border border-border-light block hover:opacity-85 transition-opacity">
            <img alt="Administrator Profile" data-alt="A professional headshot of a software engineer..." src="https://lh3.googleusercontent.com/aida-public/AB6AXuDj9QxodKtbsHY_j15sN76x9nY7Wh7ocYodVGXO8Zh3FhNTqtYp8NjI_l6yp2woEIHGqk3RCt_BPczXWSxGGYn9qbWGltVHGm4DDfLLUPj3vkxfiZXotwtVJLzzg4AffUiwGvtPEFSbIRWqWKne2NyLHTyR-lKyMXqG-sO1QKzOhiepr8Y5AuQwf2-vtZVIZe0bSBh77r12hq1ia8F77ost5uWV-US57CwloA1ABTy0NUx4CZuVLIDYpGMpqv8sZ6zR5drZgzSkXT8"/>
        </a>
    </div>
</header>

<!-- SideNavBar -->
<aside class="flex flex-col h-full p-stack-md pt-20 gap-stack-sm fixed left-0 top-0 h-full w-64 bg-surface-container-low dark:bg-slate-900/60 border-r border-border-light dark:border-border-dark flat no shadows">
    <div class="px-2 mb-4">
        <h2 class="font-headline-sm text-headline-sm font-bold text-primary dark:text-primary-fixed-dim">Management</h2>
        <p class="font-label-md text-label-md text-on-surface-variant dark:text-outline opacity-70">Tech Community Platform</p>
    </div>
    <nav class="flex-1 space-y-1">
        <a class="flex items-center px-3 py-2 text-on-surface-variant dark:text-outline hover:text-on-surface dark:hover:text-on-surface hover:bg-surface-container-highest dark:hover:bg-surface-container-high transition-all duration-200 translate-x-1 active:scale-98" href="{{ route('admin.dashboard') }}">
            <span class="material-symbols-outlined mr-3" data-icon="dashboard">dashboard</span>
            <span class="font-label-md text-label-md">Admin Overview</span>
        </a>
        <a class="flex items-center px-3 py-2 text-on-surface-variant dark:text-outline hover:text-on-surface dark:hover:text-on-surface hover:bg-surface-container-highest dark:hover:bg-surface-container-high transition-all duration-200 translate-x-1 active:scale-98" href="{{ route('admin.moderator') }}">
            <span class="material-symbols-outlined mr-3" data-icon="gavel">gavel</span>
            <span class="font-label-md text-label-md">Moderator Hub</span>
        </a>
        <a class="flex items-center px-3 py-2 text-on-surface-variant dark:text-outline hover:text-on-surface dark:hover:text-on-surface hover:bg-surface-container-highest dark:hover:bg-surface-container-high transition-all duration-200 translate-x-1 active:scale-98" href="{{ route('home') }}">
            <span class="material-symbols-outlined mr-3" data-icon="terminal">terminal</span>
            <span class="font-label-md text-label-md">Dev Portal</span>
        </a>
        <a class="flex items-center px-3 py-2 text-on-surface-variant dark:text-outline hover:text-on-surface dark:hover:text-on-surface hover:bg-surface-container-highest dark:hover:bg-surface-container-high transition-all duration-200 translate-x-1 active:scale-98" href="{{ route('admin.dashboard') }}#user-directory-section">
            <span class="material-symbols-outlined mr-3" data-icon="group">group</span>
            <span class="font-label-md text-label-md">User Directory</span>
        </a>
        <a class="flex items-center px-3 py-2 text-on-surface-variant dark:text-outline hover:text-on-surface dark:hover:text-on-surface hover:bg-surface-container-highest dark:hover:bg-surface-container-high transition-all duration-200 translate-x-1 active:scale-98" href="{{ route('admin.moderator') }}">
            <span class="material-symbols-outlined mr-3" data-icon="playlist_add_check">playlist_add_check</span>
            <span class="font-label-md text-label-md">Content Queue</span>
        </a>
        <a class="flex items-center px-3 py-2 bg-primary-fixed dark:bg-primary-container text-on-primary-fixed dark:text-on-primary-container font-bold rounded-lg translate-x-1 active:scale-98 transition-transform" href="{{ route('admin.monitor') }}">
            <span class="material-symbols-outlined mr-3" data-icon="monitoring">monitoring</span>
            <span class="font-label-md text-label-md">System Health</span>
        </a>
    </nav>
    <div class="mt-auto pt-4 border-t border-border-light dark:border-border-dark space-y-1">
        <button id="deploy-btn-sidebar" class="w-full mb-4 py-2 px-4 bg-primary text-on-primary font-label-md rounded-lg hover:opacity-90 transition-opacity flex items-center justify-center gap-2">
            <span class="material-symbols-outlined text-[18px]">rocket_launch</span>
            Deploy Update
        </button>
        <a class="flex items-center px-3 py-2 text-on-surface-variant dark:text-outline hover:bg-surface-container-highest transition-all" href="{{ route('support') }}">
            <span class="material-symbols-outlined mr-3" data-icon="help">help</span>
            <span class="font-label-md text-label-md">Help Center</span>
        </a>
        <a class="flex items-center px-3 py-2 text-on-surface-variant dark:text-outline hover:bg-surface-container-highest transition-all" href="{{ route('support') }}">
            <span class="material-symbols-outlined mr-3" data-icon="description">description</span>
            <span class="font-label-md text-label-md">Documentation</span>
        </a>
    </div>
</aside>

<!-- Main Content Canvas -->
<main class="ml-64 pt-16 min-h-screen">
    <div class="p-margin-desktop max-w-container-max mx-auto space-y-stack-lg">
        <!-- Page Header -->
        <div class="flex justify-between items-end">
            <div>
                <h1 class="font-headline-xl text-headline-xl text-on-surface dark:text-white">System Health</h1>
                <p class="text-on-surface-variant dark:text-outline mt-2">Real-time infrastructure monitoring and node status.</p>
            </div>
            <div class="flex gap-stack-sm items-center">
                <span id="maintenance-banner" class="{{ $isMaintenanceActive ? '' : 'hidden' }} px-3 py-1 rounded-full bg-amber-500 text-white font-label-sm flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span>
                    MAINTENANCE ACTIVE
                </span>
                <span class="px-3 py-1 rounded-full bg-primary-container dark:bg-indigo-950 text-on-primary-container dark:text-indigo-300 font-label-sm flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-on-primary-container dark:bg-indigo-400 animate-pulse"></span>
                    LIVE MONITORING
                </span>
                <span class="px-3 py-1 rounded-full bg-surface-container-highest dark:bg-slate-800 text-on-surface dark:text-white font-label-sm">
                    Uptime: 99.998%
                </span>
            </div>
        </div>

        <!-- Dashboard Grid -->
        <div class="grid grid-cols-12 gap-gutter">
            <!-- Health-Check Suite Dashboard (Span 8) -->
            <div class="col-span-12 lg:col-span-8 space-y-gutter">
                <div class="grid grid-cols-3 gap-gutter">
                    <!-- API Card -->
                    <div class="bg-surface dark:bg-slate-900/60 p-stack-md border border-border-light dark:border-slate-800 rounded-xl flex flex-col gap-stack-sm hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start">
                            <span class="material-symbols-outlined text-primary dark:text-primary-fixed-dim" data-icon="api">api</span>
                            <span class="text-green-600 dark:text-green-400 font-bold font-label-sm">HEALTHY</span>
                        </div>
                        <h3 class="font-headline-sm text-headline-sm dark:text-white">Core API</h3>
                        <div class="mt-auto">
                            <p class="text-label-sm text-on-surface-variant dark:text-outline">Latency</p>
                            <p id="latency-val" class="font-mono text-headline-md dark:text-white">42ms</p>
                        </div>
                    </div>
                    <!-- Database Card -->
                    <div class="bg-surface dark:bg-slate-900/60 p-stack-md border border-border-light dark:border-slate-800 rounded-xl flex flex-col gap-stack-sm hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start">
                            <span class="material-symbols-outlined text-primary dark:text-primary-fixed-dim" data-icon="database">database</span>
                            <span class="text-green-600 dark:text-green-400 font-bold font-label-sm">OPERATIONAL</span>
                        </div>
                        <h3 class="font-headline-sm text-headline-sm dark:text-white">Database</h3>
                        <div class="mt-auto">
                            <p class="text-label-sm text-on-surface-variant dark:text-outline">Active Conn</p>
                            <p id="db-conn-val" class="font-mono text-headline-md dark:text-white">1,204</p>
                        </div>
                    </div>
                    <!-- CDN Card -->
                    <div class="bg-surface dark:bg-slate-900/60 p-stack-md border border-border-light dark:border-slate-800 rounded-xl flex flex-col gap-stack-sm hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start">
                            <span class="material-symbols-outlined text-primary dark:text-primary-fixed-dim" data-icon="cloud_done">cloud_done</span>
                            <span class="text-amber-500 font-bold font-label-sm">DEGRADED</span>
                        </div>
                        <h3 class="font-headline-sm text-headline-sm dark:text-white">Global CDN</h3>
                        <div class="mt-auto">
                            <p class="text-label-sm text-on-surface-variant dark:text-outline">Cache Hit Rate</p>
                            <p id="cdn-cache-val" class="font-mono text-headline-md dark:text-white">84.2%</p>
                        </div>
                    </div>
                </div>

                <!-- Dynamic Logs Terminal Simulation -->
                <div class="bg-inverse-surface text-surface rounded-xl overflow-hidden shadow-xl border border-border-dark dark:border-slate-800">
                    <div class="bg-slate-800 px-4 py-2 flex items-center justify-between border-b border-slate-700">
                        <div class="flex items-center gap-2">
                            <div class="flex gap-1.5">
                                <div class="w-3 h-3 rounded-full bg-red-500"></div>
                                <div class="w-3 h-3 rounded-full bg-amber-500"></div>
                                <div class="w-3 h-3 rounded-full bg-green-500"></div>
                            </div>
                            <span class="ml-4 font-mono text-label-sm opacity-80 text-white">root@devnexus-console:~/_dynamic_logs</span>
                        </div>
                        <div class="flex items-center gap-4">
                            <button id="download-logs" title="Download log dump" class="hover:opacity-100 opacity-60 flex items-center">
                                <span class="material-symbols-outlined text-label-md cursor-pointer text-white" data-icon="download">download</span>
                            </button>
                            <button id="clear-logs" title="Clear console output" class="hover:opacity-100 opacity-60 flex items-center">
                                <span class="material-symbols-outlined text-label-md cursor-pointer text-white" data-icon="delete">delete</span>
                            </button>
                        </div>
                    </div>
                    <div id="terminal-body" class="p-4 font-mono text-label-md h-96 overflow-y-auto custom-scrollbar leading-relaxed bg-slate-950 text-slate-300">
                        <div class="log-row text-slate-400">[2026-05-21 09:22:01] <span class="text-green-400">INFO</span>: Initializing node clusters in region us-east-1...</div>
                        <div class="log-row text-slate-400">[2026-05-21 09:22:05] <span class="text-green-400">INFO</span>: Successfully established handshake with Database cluster.</div>
                        <div class="log-row text-slate-400">[2026-05-21 09:22:12] <span class="text-amber-400">WARN</span>: High memory pressure detected on worker-node-04. Initiating garbage collection.</div>
                        <div class="log-row text-slate-400">[2026-05-21 09:22:15] <span class="text-green-400">INFO</span>: GC completed. Reclaimed 452MB.</div>
                        <div class="log-row text-slate-400">[2026-05-21 09:23:44] <span class="text-green-400">INFO</span>: GET /api/v1/user/profile - 200 OK - 12ms</div>
                        <div class="log-row text-slate-400">[2026-05-21 09:23:45] <span class="text-green-400">INFO</span>: POST /api/v1/auth/login - 201 Created - 48ms</div>
                        <div class="log-row text-slate-400">[2026-05-21 09:24:02] <span class="text-red-400">ERROR</span>: Connection timeout from upstream CDN node 142.250.x.x. Retrying...</div>
                        <div class="log-row text-slate-400">[2026-05-21 09:24:08] <span class="text-amber-400">WARN</span>: Upstream CDN degraded performance. Routing traffic to secondary edge nodes.</div>
                        <div class="log-row text-slate-400">[2026-05-21 09:25:00] <span class="text-green-400">INFO</span>: System health-check suite completed. All core services 100% reachable.</div>
                        <!-- Inserted logs appear here -->
                        <div class="text-slate-200 mt-2 flex items-center prompt-row">
                            <span class="mr-2">admin@nexus:~$</span>
                            <span class="w-2 h-5 bg-primary-container animate-pulse"></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar Widgets (Span 4) -->
            <div class="col-span-12 lg:col-span-4 space-y-gutter">
                <!-- Debug/Maintenance Mode Card -->
                <div class="bg-surface-container dark:bg-slate-900/60 p-stack-lg border border-border-light dark:border-slate-800 rounded-xl">
                    <div class="flex items-center gap-stack-sm mb-4">
                        <span class="material-symbols-outlined text-tertiary" data-icon="construction">construction</span>
                        <h2 class="font-headline-md text-headline-md dark:text-white">Maintenance</h2>
                    </div>
                    <p class="text-on-surface-variant dark:text-outline font-body-md mb-6">Enable Maintenance Mode to restrict public access while performing critical system updates.</p>
                    
                    <div class="flex items-center justify-between p-4 bg-surface dark:bg-slate-950/40 rounded-lg border border-border-light dark:border-slate-800">
                        <div>
                            <p class="font-label-md font-bold text-on-surface dark:text-white">Debug Mode</p>
                            <p class="text-label-sm text-on-surface-variant dark:text-outline">Detailed logging enabled</p>
                        </div>
                        <div class="relative inline-flex items-center cursor-pointer">
                            <input checked="" id="debug-toggle" class="sr-only peer" type="checkbox"/>
                            <div class="w-11 h-6 bg-slate-300 dark:bg-slate-800 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                        </div>
                    </div>
                    
                    <button id="maintenance-toggle-btn" class="w-full mt-4 py-3 px-4 border {{ $isMaintenanceActive ? 'border-rose-500 bg-rose-500 text-white hover:bg-rose-600' : 'border-tertiary text-tertiary dark:text-amber-500 dark:border-amber-500 hover:bg-tertiary hover:text-white dark:hover:bg-amber-500 dark:hover:text-black' }} font-bold font-label-md rounded-lg transition-all flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined" data-icon="{{ $isMaintenanceActive ? 'lock' : 'lock_open' }}">{{ $isMaintenanceActive ? 'lock' : 'lock_open' }}</span>
                        <span id="maintenance-btn-text">{{ $isMaintenanceActive ? 'EXIT MAINTENANCE MODE' : 'ENTER MAINTENANCE MODE' }}</span>
                    </button>
                </div>

                <!-- Resource Utilization (High Density) -->
                <div class="bg-surface dark:bg-slate-900/60 p-stack-lg border border-border-light dark:border-slate-800 rounded-xl">
                    <h2 class="font-headline-md text-headline-md dark:text-white mb-6">Resource Allocation</h2>
                    <div class="space-y-stack-lg">
                        <div class="space-y-2">
                            <div class="flex justify-between text-label-md">
                                <span class="text-on-surface-variant dark:text-outline">CPU Usage</span>
                                <span id="cpu-percent" class="font-mono text-primary dark:text-primary-fixed-dim">24.8%</span>
                            </div>
                            <div class="w-full bg-surface-container-highest dark:bg-slate-800 rounded-full h-2">
                                <div id="cpu-bar" class="bg-primary h-2 rounded-full transition-all duration-1000" style="width: 24.8%"></div>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <div class="flex justify-between text-label-md">
                                <span class="text-on-surface-variant dark:text-outline">RAM Utilization</span>
                                <span id="ram-val" class="font-mono text-primary dark:text-primary-fixed-dim">6.2 GB / 16 GB</span>
                            </div>
                            <div class="w-full bg-surface-container-highest dark:bg-slate-800 rounded-full h-2">
                                <div id="ram-bar" class="bg-primary h-2 rounded-full transition-all duration-1000" style="width: 38.7%"></div>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <div class="flex justify-between text-label-md">
                                <span class="text-on-surface-variant dark:text-outline">Storage (SSD)</span>
                                <span class="font-mono text-primary dark:text-primary-fixed-dim">1.2 TB / 2.0 TB</span>
                            </div>
                            <div class="w-full bg-surface-container-highest dark:bg-slate-800 rounded-full h-2">
                                <div class="bg-primary h-2 rounded-full" style="width: 60%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Active Incidents Small Card -->
                <div class="bg-error-container dark:bg-red-950/20 p-stack-md border border-error rounded-xl">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="material-symbols-outlined text-error" data-icon="report">report</span>
                        <h3 class="font-label-md font-bold text-on-error-container dark:text-red-400">ACTIVE INCIDENTS (1)</h3>
                    </div>
                    <p class="text-label-sm text-on-error-container dark:text-red-400 opacity-90">CDN Latency spike detected in South East Asia region. Investigating routing tables.</p>
                    <button onclick="showToast('Incident log #4490 retrieved')" class="mt-3 text-label-sm font-bold text-error dark:text-red-400 underline decoration-2 underline-offset-4">View Incident Report</button>
                </div>
            </div>
        </div>

        <!-- Asymmetric Bottom Section: Regional Performance -->
        <div class="bg-surface dark:bg-slate-900/60 border border-border-light dark:border-slate-800 rounded-2xl p-stack-lg">
            <div class="flex justify-between items-center mb-6">
                <h2 class="font-headline-lg text-headline-lg dark:text-white">Global Node Topology</h2>
                <div class="flex gap-4">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-green-500"></span>
                        <span class="text-label-sm dark:text-white">Nominal</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-amber-500"></span>
                        <span class="text-label-sm dark:text-white">Heavy Load</span>
                    </div>
                </div>
            </div>
            <div class="h-64 bg-surface-container-low dark:bg-slate-950/60 rounded-xl relative overflow-hidden flex items-center justify-center">
                <img alt="Infrastructure Map" class="w-full h-full object-cover opacity-50" data-alt="A stylized, technical world map featuring glowing interconnected nodes..." src="https://lh3.googleusercontent.com/aida-public/AB6AXuDJ1HUBT9Ato2zyAcrdAKDLuDH6zwgPGbr1JCfXmMfrtVJ9TDP6sunV9bpZCIEUc8zEJpuKBmvYMquKa9-L7YLkYA7BU__jT-Cl2CiNp9wIAAodRFPWW8uVwAwSeSXrrEXETl2OEtk-VwtHj8l26B0W0j5dsyZRE11G67ue9XawrABq8I2VSp0PNhNIqqNcmgWdv0SBRuZPD3SRsc688Nljg4Ht3u3WRp4MD6WmJHUPU1zHuVXJyv1_27Lep2KAD4vUtoABfwelmSM"/>
                
                <!-- Overlay regions hotspots -->
                <button onclick="showToast('NY Edge: Latency 8ms - Load 12%', 'success')" class="absolute top-[35%] left-[28%] w-4 h-4 rounded-full bg-green-500 animate-ping opacity-75" title="NY Cluster"></button>
                <button onclick="showToast('London Edge: Latency 14ms - Load 22%', 'success')" class="absolute top-[30%] left-[45%] w-4 h-4 rounded-full bg-green-500 animate-ping opacity-75" title="London Cluster"></button>
                <button onclick="showToast('Tokyo Edge: Latency 7ms - Load 48%', 'success')" class="absolute top-[38%] left-[78%] w-4 h-4 rounded-full bg-green-500 animate-ping opacity-75" title="Tokyo Cluster"></button>
                <button onclick="showToast('Singapore Edge: Latency 182ms - Load 88% - Routing Spikes!', 'error')" class="absolute top-[52%] left-[72%] w-4 h-4 rounded-full bg-amber-500 animate-ping opacity-75" title="Singapore Cluster"></button>

                <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                    <div class="bg-surface/80 dark:bg-slate-900/80 backdrop-blur-md px-6 py-3 rounded-lg border border-border-light dark:border-slate-800 shadow-lg flex flex-col items-center">
                        <span class="material-symbols-outlined text-primary dark:text-primary-fixed-dim text-4xl" data-icon="public">public</span>
                        <p class="mt-2 font-headline-md dark:text-white">148 Active Edges</p>
                        <p class="text-label-sm text-on-surface-variant dark:text-outline">Across 22 Availability Zones</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Deploy Modal -->
<div id="deploy-modal" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-surface dark:bg-slate-900 border border-outline-variant dark:border-slate-800 rounded-2xl w-full max-w-md p-6 shadow-2xl relative">
        <button id="close-deploy-modal" class="absolute top-4 right-4 text-on-surface-variant hover:text-on-surface dark:text-outline dark:hover:text-white">
            <span class="material-symbols-outlined">close</span>
        </button>
        <h3 class="font-headline-md text-headline-md font-bold text-on-background dark:text-white mb-4">Deploy System Update</h3>
        <p class="text-body-md text-on-surface-variant dark:text-outline mb-6">Are you sure you want to trigger a production deployment of the latest release version?</p>
        
        <div id="deploy-actions" class="flex justify-end gap-3">
            <button id="cancel-deploy" class="px-4 py-2 border border-outline dark:border-slate-700 rounded-lg text-on-background dark:text-white hover:bg-surface-hover dark:hover:bg-slate-800">Cancel</button>
            <button id="confirm-deploy" class="px-4 py-2 bg-primary text-on-primary rounded-lg text-label-md font-bold hover:opacity-90">Confirm Deploy</button>
        </div>

        <div id="deploy-progress" class="hidden space-y-4 mt-4">
            <div class="h-2 w-full bg-surface-container dark:bg-slate-800 rounded-full overflow-hidden">
                <div id="deploy-progress-bar" class="h-full bg-primary w-0 transition-all duration-300"></div>
            </div>
            <p id="deploy-status" class="text-label-md text-primary dark:text-primary-fixed-dim font-bold">Checking system state...</p>
            <ul id="deploy-steps" class="text-label-sm text-on-surface-variant dark:text-outline space-y-1 pl-4 list-disc">
                <!-- Appended dynamically -->
            </ul>
        </div>
    </div>
</div>

<!-- Maintenance Confirm Modal -->
<div id="maintenance-modal" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-surface dark:bg-slate-900 border border-outline-variant dark:border-slate-800 rounded-2xl w-full max-w-md p-6 shadow-2xl relative">
        <button id="close-maintenance-modal" class="absolute top-4 right-4 text-on-surface-variant hover:text-on-surface dark:text-outline dark:hover:text-white">
            <span class="material-symbols-outlined">close</span>
        </button>
        <h3 class="font-headline-md text-headline-md font-bold text-on-background dark:text-white mb-4">Toggle Maintenance Mode</h3>
        <p class="text-body-md text-on-surface-variant dark:text-outline mb-6">Changing the site maintenance status will restrict/grant public portal access immediately. Proceed?</p>
        
        <div class="flex justify-end gap-3">
            <button id="cancel-maintenance" class="px-4 py-2 border border-outline dark:border-slate-700 rounded-lg text-on-background dark:text-white hover:bg-surface-hover dark:hover:bg-slate-800">Cancel</button>
            <button id="confirm-maintenance" class="px-4 py-2 bg-primary text-on-primary rounded-lg text-label-md font-bold hover:opacity-90">Confirm Toggle</button>
        </div>
    </div>
</div>

<!-- FAB Panel overlay -->
<div id="fab-overlay" class="hidden fixed inset-0 bg-black/50 backdrop-blur-xs z-40 flex items-end justify-end p-margin-desktop">
    <div class="bg-surface dark:bg-slate-900 border border-outline-variant dark:border-slate-800 rounded-2xl p-6 shadow-2xl w-80 mb-20 animate-bounce-short">
        <h3 class="font-headline-sm text-label-md font-bold text-on-background dark:text-white mb-4">Add Monitoring Node</h3>
        <div class="space-y-3">
            <div>
                <label class="block text-label-sm text-on-surface-variant dark:text-outline mb-1">Node Identifier</label>
                <input id="node-id-input" class="w-full px-3 py-1.5 border border-outline-variant dark:border-slate-700 bg-transparent rounded text-[13px] dark:text-white" type="text" placeholder="edge-ap-south-02"/>
            </div>
            <div>
                <label class="block text-label-sm text-on-surface-variant dark:text-outline mb-1">Target IP Address</label>
                <input id="node-ip-input" class="w-full px-3 py-1.5 border border-outline-variant dark:border-slate-700 bg-transparent rounded text-[13px] dark:text-white" type="text" placeholder="103.24.81.12"/>
            </div>
            <button id="add-node-submit" class="w-full bg-primary text-on-primary py-2 rounded text-label-sm font-bold hover:opacity-90 mt-2">Activate Node</button>
        </div>
    </div>
</div>

<!-- FAB Add Button -->
<button id="fab-add-btn" class="fixed bottom-margin-desktop right-margin-desktop w-14 h-14 bg-primary text-on-primary rounded-full shadow-xl flex items-center justify-center hover:scale-105 active:scale-95 transition-all z-50">
    <span class="material-symbols-outlined" data-icon="add">add</span>
</button>

<!-- Toast container -->
<div id="toast-container" class="fixed bottom-5 right-5 z-50 space-y-2"></div>
@endsection

@push('scripts')
<script>
    // Theme Switcher Logic
    const themeToggle = document.getElementById('theme-toggle');
    const themeIcon = document.getElementById('theme-icon');
    const html = document.documentElement;

    function updateThemeIcon() {
        if (html.classList.contains('dark')) {
            themeIcon.textContent = 'light_mode';
        } else {
            themeIcon.textContent = 'dark_mode';
        }
    }
    updateThemeIcon();

    themeToggle.addEventListener('click', () => {
        if (html.classList.contains('dark')) {
            html.classList.remove('dark');
            localStorage.setItem('theme', 'light');
            showToast('Switched to light mode', 'success');
        } else {
            html.classList.add('dark');
            localStorage.setItem('theme', 'dark');
            showToast('Switched to dark mode', 'success');
        }
        updateThemeIcon();
    });

    // Toast Notification System
    function showToast(message, type = 'success') {
        const container = document.getElementById('toast-container');
        const toast = document.createElement('div');
        toast.className = `flex items-center gap-3 px-4 py-3 rounded-xl shadow-lg border text-label-md font-bold transform translate-y-2 opacity-0 transition-all duration-300 ${
            type === 'success' 
                ? 'bg-green-50 dark:bg-green-950/40 text-green-700 dark:text-green-400 border-green-200 dark:border-green-800' 
                : 'bg-red-50 dark:bg-red-950/40 text-red-700 dark:text-red-400 border-red-200 dark:border-red-800'
        }`;
        
        const icon = document.createElement('span');
        icon.className = 'material-symbols-outlined';
        icon.textContent = type === 'success' ? 'check_circle' : 'error';
        
        const text = document.createElement('span');
        text.textContent = message;
        
        toast.appendChild(icon);
        toast.appendChild(text);
        container.appendChild(toast);
        
        setTimeout(() => {
            toast.classList.remove('translate-y-2', 'opacity-0');
        }, 10);
        
        setTimeout(() => {
            toast.classList.add('translate-y-2', 'opacity-0');
            setTimeout(() => {
                toast.remove();
            }, 300);
        }, 3000);
    }
    window.showToast = showToast;

    // Top Navigation / Logs Search Bar Live Search
    const logsSearch = document.getElementById('logs-search');
    logsSearch.addEventListener('input', () => {
        const query = logsSearch.value.toLowerCase().trim();
        const rows = document.querySelectorAll('.log-row');
        rows.forEach(row => {
            if (row.textContent.toLowerCase().includes(query)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Alert & notification list toggling
    const notificationsBtn = document.getElementById('notifications-btn');
    const notificationsDropdown = document.getElementById('notifications-dropdown');
    const notificationsBadge = document.getElementById('notifications-badge');
    const clearNotifications = document.getElementById('clear-notifications');

    notificationsBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        notificationsDropdown.classList.toggle('hidden');
        if (notificationsBadge) notificationsBadge.classList.add('hidden');
    });

    document.addEventListener('click', () => {
        notificationsDropdown.classList.add('hidden');
    });

    clearNotifications.addEventListener('click', (e) => {
        e.stopPropagation();
        const alertsContainer = notificationsDropdown.querySelector('.space-y-3');
        alertsContainer.innerHTML = '<p class="text-label-sm text-outline text-center py-4">No remaining warnings.</p>';
        showToast('All notifications cleared');
    });

    // Dynamic Live Terminal Logs Simulation
    const terminalBody = document.getElementById('terminal-body');
    const promptRow = terminalBody.querySelector('.prompt-row');

    const logMessages = [
        { type: 'INFO', msg: 'Core cache tables flushed successfully.' },
        { type: 'INFO', msg: 'GET /api/v1/discussions - 200 OK - 22ms' },
        { type: 'WARN', msg: 'Slow query logged on comments table (elapsed: 140ms).' },
        { type: 'INFO', msg: 'Heartbeat signal acknowledged by node-eu-west-03.' },
        { type: 'INFO', msg: 'POST /api/v1/posts/create - 201 Created - 54ms' },
        { type: 'ERROR', msg: 'Worker instance-02 thread pool exhausted. Restarting thread...' },
        { type: 'INFO', msg: 'Worker thread pool restarted successfully.' }
    ];

    setInterval(() => {
        // Skip log insertion if user is actively searching
        if (logsSearch.value.trim() !== '') return;

        const date = new Date().toISOString().replace('T', ' ').substring(0, 19);
        const randomItem = logMessages[Math.floor(Math.random() * logMessages.length)];
        
        let typeColor = 'text-green-400';
        if (randomItem.type === 'WARN') typeColor = 'text-amber-400';
        if (randomItem.type === 'ERROR') typeColor = 'text-red-400';

        const logDiv = document.createElement('div');
        logDiv.className = 'log-row text-slate-400 opacity-0 transition-opacity duration-300';
        logDiv.innerHTML = `[${date}] <span class="${typeColor}">${randomItem.type}</span>: ${randomItem.msg}`;
        
        // Insert right before prompt row
        terminalBody.insertBefore(logDiv, promptRow);
        
        // Fade in
        setTimeout(() => {
            logDiv.classList.remove('opacity-0');
        }, 10);

        // Keep last 40 logs only
        const rows = terminalBody.querySelectorAll('.log-row');
        if (rows.length > 40) {
            rows[0].remove();
        }

        // Scroll to bottom
        terminalBody.scrollTop = terminalBody.scrollHeight;
    }, 4000);

    // Terminal Buttons Action
    document.getElementById('clear-logs').addEventListener('click', () => {
        const rows = terminalBody.querySelectorAll('.log-row');
        rows.forEach(r => r.remove());
        showToast('Console history cleared');
    });

    document.getElementById('download-logs').addEventListener('click', () => {
        showToast('Downloading system log dump (syslog-2026-05.log)...');
    });

    // Debug Mode Toggle
    const debugToggle = document.getElementById('debug-toggle');
    debugToggle.addEventListener('change', () => {
        if (debugToggle.checked) {
            showToast('Debug mode activated. Logs will show verbose outputs.');
        } else {
            showToast('Debug mode deactivated. Verbose outputs suppressed.', 'error');
        }
    });

    // Maintenance Mode Toggle & Banner Logic
    const maintenanceBtn = document.getElementById('maintenance-toggle-btn');
    const maintenanceBtnText = document.getElementById('maintenance-btn-text');
    const maintenanceIcon = maintenanceBtn.querySelector('.material-symbols-outlined');
    const maintenanceModal = document.getElementById('maintenance-modal');
    const cancelMaintenance = document.getElementById('cancel-maintenance');
    const confirmMaintenance = document.getElementById('confirm-maintenance');
    const closeMaintenanceModal = document.getElementById('close-maintenance-modal');
    const maintenanceBanner = document.getElementById('maintenance-banner');

    let isMaintenanceActive = @json($isMaintenanceActive);

    maintenanceBtn.addEventListener('click', () => {
        maintenanceModal.classList.remove('hidden');
    });

    closeMaintenanceModal.addEventListener('click', () => {
        maintenanceModal.classList.add('hidden');
    });

    cancelMaintenance.addEventListener('click', () => {
        maintenanceModal.classList.add('hidden');
    });

    confirmMaintenance.addEventListener('click', () => {
        maintenanceModal.classList.add('hidden');

        fetch('/admin/maintenance/toggle', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            if (data.success) {
                isMaintenanceActive = data.maintenance_active;

                if (isMaintenanceActive) {
                    maintenanceBtnText.textContent = 'EXIT MAINTENANCE MODE';
                    maintenanceIcon.textContent = 'lock';
                    maintenanceIcon.setAttribute('data-icon', 'lock');
                    maintenanceBtn.className = 'w-full mt-4 py-3 px-4 border border-rose-500 bg-rose-500 text-white font-bold font-label-md rounded-lg hover:bg-rose-600 transition-all flex items-center justify-center gap-2';
                    maintenanceBanner.classList.remove('hidden');
                    showToast(data.message || 'Portal has been put in MAINTENANCE MODE', 'error');
                } else {
                    maintenanceBtnText.textContent = 'ENTER MAINTENANCE MODE';
                    maintenanceIcon.textContent = 'lock_open';
                    maintenanceIcon.setAttribute('data-icon', 'lock_open');
                    maintenanceBtn.className = 'w-full mt-4 py-3 px-4 border border-tertiary text-tertiary dark:text-amber-500 dark:border-amber-500 font-bold font-label-md rounded-lg hover:bg-tertiary hover:text-white dark:hover:bg-amber-500 dark:hover:text-black transition-all flex items-center justify-center gap-2';
                    maintenanceBanner.classList.add('hidden');
                    showToast(data.message || 'Portal is now publicly ONLINE', 'success');
                }
            } else {
                showToast(data.message || 'Failed to toggle maintenance mode', 'error');
            }
        })
        .catch(error => {
            console.error(error);
            showToast('An error occurred while toggling maintenance mode', 'error');
        });
    });

    // Resource metrics fluctuation simulation
    const cpuPercent = document.getElementById('cpu-percent');
    const cpuBar = document.getElementById('cpu-bar');
    const ramVal = document.getElementById('ram-val');
    const ramBar = document.getElementById('ram-bar');
    const latencyVal = document.getElementById('latency-val');
    const dbConnVal = document.getElementById('db-conn-val');
    const cdnCacheVal = document.getElementById('cdn-cache-val');

    setInterval(() => {
        // CPU fluctuation
        const randomCpu = (20 + Math.random() * 15).toFixed(1);
        cpuPercent.textContent = randomCpu + '%';
        cpuBar.style.width = randomCpu + '%';

        // RAM fluctuation
        const randomRam = (6.0 + Math.random() * 0.5).toFixed(1);
        const ramPercent = ((randomRam / 16) * 100).toFixed(1);
        ramVal.textContent = randomRam + ' GB / 16 GB';
        ramBar.style.width = ramPercent + '%';

        // Latency
        const randomLatency = Math.floor(38 + Math.random() * 8);
        latencyVal.textContent = randomLatency + 'ms';

        // DB Connections
        const randomDb = Math.floor(1190 + Math.random() * 30);
        dbConnVal.textContent = randomDb.toLocaleString();

        // Cache hit
        const randomCdn = (83.8 + Math.random() * 1.0).toFixed(1);
        cdnCacheVal.textContent = randomCdn + '%';
    }, 3000);

    // Deploy Modal Dialog Simulation
    const deployBtn = document.getElementById('deploy-btn-sidebar');
    const deployModal = document.getElementById('deploy-modal');
    const closeDeployModal = document.getElementById('close-deploy-modal');
    const cancelDeploy = document.getElementById('cancel-deploy');
    const confirmDeploy = document.getElementById('confirm-deploy');
    const deployActions = document.getElementById('deploy-actions');
    const deployProgress = document.getElementById('deploy-progress');
    const deployProgressBar = document.getElementById('deploy-progress-bar');
    const deployStatus = document.getElementById('deploy-status');
    const deploySteps = document.getElementById('deploy-steps');

    deployBtn.addEventListener('click', () => {
        deployModal.classList.remove('hidden');
        deployActions.classList.remove('hidden');
        deployProgress.classList.add('hidden');
        deployProgressBar.style.width = '0%';
        deployStatus.textContent = 'Preparing production deployment...';
        deploySteps.innerHTML = '';
    });

    closeDeployModal.addEventListener('click', () => {
        deployModal.classList.add('hidden');
    });

    cancelDeploy.addEventListener('click', () => {
        deployModal.classList.add('hidden');
    });

    confirmDeploy.addEventListener('click', () => {
        deployActions.classList.add('hidden');
        deployProgress.classList.remove('hidden');
        
        const steps = [
            { percentage: 25, text: 'Checked staging environment builds (OK).', status: 'Compiling core assets...' },
            { percentage: 55, text: 'Tailwind CSS classes compiled and optimized.', status: 'Applying database migrations...' },
            { percentage: 80, text: 'Migrations successfully executed.', status: 'Restarting queue and worker nodes...' },
            { percentage: 100, text: 'Server containers healthy and listening.', status: 'Deployment complete!' }
        ];
        
        let currentStep = 0;
        
        function runStep() {
            if (currentStep < steps.length) {
                const step = steps[currentStep];
                setTimeout(() => {
                    deployProgressBar.style.width = step.percentage + '%';
                    deployStatus.textContent = step.status;
                    const li = document.createElement('li');
                    li.textContent = step.text;
                    deploySteps.appendChild(li);
                    currentStep++;
                    runStep();
                }, 1000);
            } else {
                setTimeout(() => {
                    showToast('Production deployment successfully completed!', 'success');
                    deployModal.classList.add('hidden');
                }, 800);
            }
        }
        
        runStep();
    });

    // FAB Button Interaction (Add Monitor Node)
    const fabBtn = document.getElementById('fab-add-btn');
    const fabOverlay = document.getElementById('fab-overlay');
    const nodeIdInput = document.getElementById('node-id-input');
    const nodeIpInput = document.getElementById('node-ip-input');
    const addNodeSubmit = document.getElementById('add-node-submit');

    fabBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        fabOverlay.classList.toggle('hidden');
    });

    fabOverlay.addEventListener('click', (e) => {
        if (e.target === fabOverlay) {
            fabOverlay.classList.add('hidden');
        }
    });

    addNodeSubmit.addEventListener('click', () => {
        const nodeId = nodeIdInput.value.trim();
        const nodeIp = nodeIpInput.value.trim();
        if (nodeId === '' || nodeIp === '') {
            showToast('Identifier and IP Address are required', 'error');
            return;
        }

        showToast(`Node ${nodeId} (${nodeIp}) initialized and checking health...`, 'success');
        nodeIdInput.value = '';
        nodeIpInput.value = '';
        fabOverlay.classList.add('hidden');
    });
</script>
@endpush
