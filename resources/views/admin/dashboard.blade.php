@extends('layouts.app')

@section('title', 'DevNexus Console - Admin Overview')
@section('body-class', 'bg-background dark:bg-background-dark text-on-background dark:text-inverse-on-surface min-h-screen')

@push('styles')
    <style>
        .material-symbols-outlined {
            vertical-align: middle;
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
    <div class="flex items-center gap-4">
        <a href="{{ route('home') }}" class="font-headline-md text-headline-md font-bold text-primary dark:text-primary-fixed-dim hover:opacity-90">DevNexus Console</a>
        <div class="hidden md:flex ml-8 gap-6">
            <a href="{{ route('admin.dashboard') }}" class="font-label-md text-label-md text-primary dark:text-primary-fixed-dim font-bold cursor-pointer">Dashboard</a>
            <a href="{{ route('home') }}" class="font-label-md text-label-md text-on-surface-variant dark:text-outline hover:bg-surface-hover dark:hover:bg-surface-container-high transition-colors duration-150 p-2 rounded cursor-pointer">Community</a>
            <button onclick="showToast('Redirecting to Analytics portal...')" class="font-label-md text-label-md text-on-surface-variant dark:text-outline hover:bg-surface-hover dark:hover:bg-surface-container-high transition-colors duration-150 p-2 rounded cursor-pointer text-left">Analytics</button>
        </div>
    </div>
    <div class="flex items-center gap-gutter">
        <div class="relative hidden lg:block">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline">search</span>
            <input id="top-search" class="pl-10 pr-4 py-2 bg-surface-container-low border border-outline-variant rounded-lg text-body-md w-64 focus:outline-none focus:border-primary dark:bg-slate-900 dark:border-slate-700" placeholder="Search resources..." type="text"/>
        </div>
        <div class="flex items-center gap-4">
            <!-- Theme Toggle -->
            <button id="theme-toggle" class="hover:bg-surface-hover dark:hover:bg-surface-container-high transition-colors duration-150 p-2 rounded-full" title="Toggle Theme">
                <span class="material-symbols-outlined text-on-surface-variant" id="theme-icon">dark_mode</span>
            </button>
            <!-- Notifications -->
            <div class="relative">
                <button id="notifications-btn" class="hover:bg-surface-hover dark:hover:bg-surface-container-high transition-colors duration-150 p-2 rounded-full relative">
                    <span class="material-symbols-outlined text-on-surface-variant" data-icon="notifications">notifications</span>
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
            <!-- Settings Menu -->
            <button onclick="showToast('Settings configuration opened')" class="hover:bg-surface-hover dark:hover:bg-surface-container-high transition-colors duration-150 p-2 rounded-full">
                <span class="material-symbols-outlined text-on-surface-variant" data-icon="settings">settings</span>
            </button>
            <!-- Profile Avatar -->
            <a href="{{ route('profile') }}">
                <img alt="Administrator Profile" class="w-8 h-8 rounded-full border border-outline-variant hover:opacity-85 transition-opacity" data-alt="A professional high-resolution close-up portrait of a technology executive in a modern office setting. The individual has a confident, friendly expression and is dressed in professional business casual attire." src="https://lh3.googleusercontent.com/aida-public/AB6AXuBQzpw_OL2J82BbhovrLwlfdtexqLXPPDFZ0jgMaMaTyWCZ_aaYdkB2ffGiLzxlmSObw0XC6ndpXYqXgGvIlXZXM9NWX4JqYroJAGH9D7Ml99k8aQTK8nbsmEua6W1jWLh0IpxxMakKxNoMigzFH7Z7CtII1qaylSa_w63VBn5P55SeYSIUvr_5oya-gcYq60drVq8QaXYWSboCezuHeoR_QQ1dpnRvpHuRSMtJTGeXQv_ciDguTpKZpYAklSx0KwGWMW7nit50amE"/>
            </a>
        </div>
    </div>
</header>

<div class="flex pt-16">
    <!-- SideNavBar -->
    <aside class="flex flex-col h-screen p-stack-md pt-10 gap-stack-sm bg-surface-container-low dark:bg-slate-900/60 fixed left-0 top-16 w-64 border-r border-border-light dark:border-border-dark flat no shadows">
        <div class="mb-6 px-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-primary-container rounded-lg flex items-center justify-center">
                    <span class="material-symbols-outlined text-on-primary-container" style="font-variation-settings: 'FILL' 1;">terminal</span>
                </div>
                <div>
                    <p class="font-headline-sm text-headline-sm font-bold text-primary dark:text-primary-fixed-dim">Management</p>
                    <p class="font-label-sm text-label-sm text-on-surface-variant dark:text-outline">Tech Community Platform</p>
                </div>
            </div>
        </div>
        <nav class="flex-1 flex flex-col gap-1">
            <!-- Admin Overview Active -->
            <a class="flex items-center gap-3 px-4 py-3 bg-primary-fixed dark:bg-primary-container text-on-primary-fixed dark:text-on-primary-container font-bold rounded-lg translate-x-1 active:scale-98 transition-transform" href="{{ route('admin.dashboard') }}">
                <span class="material-symbols-outlined" data-icon="dashboard">dashboard</span>
                <span class="font-label-md text-label-md">Admin Overview</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant dark:text-outline hover:text-on-surface dark:hover:text-on-surface hover:bg-surface-container-highest dark:hover:bg-surface-container-high transition-all duration-200 rounded-lg" href="{{ route('admin.moderator') }}">
                <span class="material-symbols-outlined" data-icon="gavel">gavel</span>
                <span class="font-label-md text-label-md">Moderator Hub</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant dark:text-outline hover:text-on-surface dark:hover:text-on-surface hover:bg-surface-container-highest dark:hover:bg-surface-container-high transition-all duration-200 rounded-lg" href="{{ route('home') }}">
                <span class="material-symbols-outlined" data-icon="terminal">terminal</span>
                <span class="font-label-md text-label-md">Dev Portal</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant dark:text-outline hover:text-on-surface dark:hover:text-on-surface hover:bg-surface-container-highest dark:hover:bg-surface-container-high transition-all duration-200 rounded-lg" href="#user-directory-section">
                <span class="material-symbols-outlined" data-icon="group">group</span>
                <span class="font-label-md text-label-md">User Directory</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant dark:text-outline hover:text-on-surface dark:hover:text-on-surface hover:bg-surface-container-highest dark:hover:bg-surface-container-high transition-all duration-200 rounded-lg" href="{{ route('admin.moderator') }}">
                <span class="material-symbols-outlined" data-icon="playlist_add_check">playlist_add_check</span>
                <span class="font-label-md text-label-md">Content Queue</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant dark:text-outline hover:text-on-surface dark:hover:text-on-surface hover:bg-surface-container-highest dark:hover:bg-surface-container-high transition-all duration-200 rounded-lg" href="{{ route('admin.monitor') }}">
                <span class="material-symbols-outlined" data-icon="monitoring">monitoring</span>
                <span class="font-label-md text-label-md">System Health</span>
            </a>
        </nav>
        <button id="deploy-btn-sidebar" class="bg-primary text-on-primary py-3 rounded-lg font-bold flex items-center justify-center gap-2 mb-4 hover:opacity-90 transition-opacity">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">rocket_launch</span>
            Deploy Update
        </button>
        <div class="border-t border-outline-variant dark:border-slate-800 pt-4 flex flex-col gap-1">
            <a class="flex items-center gap-3 px-4 py-2 text-on-surface-variant dark:text-outline hover:text-on-surface dark:hover:text-on-surface transition-all duration-200" href="{{ route('support') }}">
                <span class="material-symbols-outlined" data-icon="help">help</span>
                <span class="font-label-md text-label-md">Help Center</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-2 text-on-surface-variant dark:text-outline hover:text-on-surface dark:hover:text-on-surface transition-all duration-200" href="{{ route('support') }}">
                <span class="material-symbols-outlined" data-icon="description">description</span>
                <span class="font-label-md text-label-md">Documentation</span>
            </a>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="flex-1 ml-64 p-margin-desktop bg-surface dark:bg-background-dark min-h-screen transition-colors duration-200">
        <div class="max-w-[1280px] mx-auto">
            <!-- Header Section -->
            <div class="mb-stack-lg flex justify-between items-end">
                <div>
                    <h1 class="font-headline-xl text-headline-xl text-on-background dark:text-white mb-1">Admin Overview</h1>
                    <p class="font-body-lg text-body-lg text-on-surface-variant dark:text-outline">Real-time platform performance and community moderation status.</p>
                </div>
                <div class="flex gap-stack-sm">
                    <!-- Calendar dropdown button -->
                    <div class="relative">
                        <button id="timeframe-btn" class="px-4 py-2 bg-surface dark:bg-slate-900 border border-outline dark:border-slate-700 rounded-lg font-label-md text-label-md flex items-center gap-2 hover:bg-surface-hover dark:hover:bg-slate-800 text-on-background dark:text-white">
                            <span class="material-symbols-outlined text-[18px]">calendar_today</span>
                            <span id="timeframe-text">Last 30 Days</span>
                        </button>
                        <!-- Dropdown Menu -->
                        <div id="timeframe-dropdown" class="hidden absolute right-0 mt-2 w-48 bg-surface dark:bg-slate-900 border border-outline-variant dark:border-slate-800 rounded-xl shadow-xl z-50 p-2 text-left">
                            <button class="w-full text-left px-3 py-2 text-label-md rounded-lg hover:bg-surface-hover dark:hover:bg-surface-container-high dark:text-white transition-colors" data-time="7">Last 7 Days</button>
                            <button class="w-full text-left px-3 py-2 text-label-md rounded-lg hover:bg-surface-hover dark:hover:bg-surface-container-high dark:text-white transition-colors" data-time="30">Last 30 Days</button>
                            <button class="w-full text-left px-3 py-2 text-label-md rounded-lg hover:bg-surface-hover dark:hover:bg-surface-container-high dark:text-white transition-colors" data-time="90">Last 90 Days</button>
                        </div>
                    </div>
                    <!-- Export Report -->
                    <button id="export-btn" class="px-4 py-2 bg-primary text-on-primary rounded-lg font-label-md text-label-md flex items-center gap-2 hover:opacity-90">
                        <span class="material-symbols-outlined text-[18px]">download</span>
                        Export Report
                    </button>
                </div>
            </div>

            <!-- Bento Grid Metrics -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-gutter mb-stack-lg">
                <!-- Metric Card 1 -->
                <div class="glass-card p-6 rounded-xl flex flex-col justify-between group hover:border-primary transition-colors cursor-pointer">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-2 bg-primary-fixed text-primary rounded-lg dark:bg-indigo-950 dark:text-indigo-400">
                            <span class="material-symbols-outlined" data-icon="group">group</span>
                        </div>
                        <span class="text-success text-label-sm font-bold flex items-center gap-1 text-[#15803d] dark:text-green-400">
                            <span class="material-symbols-outlined text-[14px]">trending_up</span>
                            +12%
                        </span>
                    </div>
                    <div>
                        <p class="font-label-md text-label-md text-on-surface-variant dark:text-outline">Total Users</p>
                        <h3 id="stat-total-users" class="font-headline-lg text-headline-lg font-bold text-on-background dark:text-white">12,482</h3>
                    </div>
                </div>
                <!-- Metric Card 2 -->
                <div onclick="window.location.href='{{ route('admin.moderator') }}'" class="glass-card p-6 rounded-xl flex flex-col justify-between group hover:border-error transition-colors cursor-pointer">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-2 bg-error-container text-error rounded-lg dark:bg-red-950 dark:text-red-400">
                            <span class="material-symbols-outlined" data-icon="report">report</span>
                        </div>
                        <span class="text-label-sm font-bold text-on-surface-variant dark:text-outline">Active Now</span>
                    </div>
                    <div>
                        <p class="font-label-md text-label-md text-on-surface-variant dark:text-outline">Pending Reports</p>
                        <h3 class="font-headline-lg text-headline-lg font-bold text-on-background dark:text-white">14</h3>
                    </div>
                </div>
                <!-- Metric Card 3 -->
                <div class="glass-card p-6 rounded-xl flex flex-col justify-between group hover:border-secondary transition-colors cursor-pointer">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-2 bg-secondary-container text-secondary rounded-lg dark:bg-slate-800 dark:text-slate-300">
                            <span class="material-symbols-outlined" data-icon="forum">forum</span>
                        </div>
                        <span class="text-label-sm font-bold text-on-surface-variant dark:text-outline">Per Hour</span>
                    </div>
                    <div>
                        <p class="font-label-md text-label-md text-on-surface-variant dark:text-outline">Active Discussions</p>
                        <h3 id="stat-active-disc" class="font-headline-lg text-headline-lg font-bold text-on-background dark:text-white">1,054</h3>
                    </div>
                </div>
                <!-- Metric Card 4 -->
                <div onclick="window.location.href='{{ route('admin.monitor') }}'" class="glass-card p-6 rounded-xl flex flex-col justify-between group hover:border-tertiary transition-colors cursor-pointer">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-2 bg-tertiary-fixed text-tertiary rounded-lg dark:bg-amber-950/40 dark:text-amber-500">
                            <span class="material-symbols-outlined" data-icon="check_circle">check_circle</span>
                        </div>
                        <span class="text-label-sm font-bold text-primary dark:text-primary-fixed-dim">High Target</span>
                    </div>
                    <div>
                        <p class="font-label-md text-label-md text-on-surface-variant dark:text-outline">Solution Rate</p>
                        <h3 id="stat-sol-rate" class="font-headline-lg text-headline-lg font-bold text-on-background dark:text-white">94%</h3>
                    </div>
                </div>
            </div>

            <!-- User Management Table Section -->
            <div id="user-directory-section" class="glass-card rounded-xl overflow-hidden border border-border-light dark:border-border-dark scroll-mt-20">
                <div class="p-6 border-b border-border-light dark:border-border-dark flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <h2 class="font-headline-md text-headline-md text-on-background dark:text-white">User Directory</h2>
                    <div class="flex w-full sm:w-auto gap-2">
                        <div class="relative flex-1">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[20px]">search</span>
                            <input id="user-search" class="pl-10 pr-4 py-2 border border-outline-variant dark:border-slate-700 rounded-lg text-body-md w-full sm:w-64 bg-transparent text-on-background dark:text-white focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary" placeholder="Filter by username or email..." type="text"/>
                        </div>
                        <div class="relative">
                            <button id="filter-btn" class="p-2 border border-outline-variant dark:border-slate-700 rounded-lg hover:bg-surface-container dark:hover:bg-slate-800 text-on-surface-variant dark:text-outline">
                                <span class="material-symbols-outlined">filter_list</span>
                            </button>
                            <!-- Filter dropdown -->
                            <div id="filter-dropdown" class="hidden absolute right-0 mt-2 w-48 bg-surface dark:bg-slate-900 border border-outline-variant dark:border-slate-800 rounded-xl shadow-xl z-50 p-2 text-left">
                                <p class="text-label-sm text-outline px-3 py-1 uppercase font-semibold text-[10px]">Filter by Role</p>
                                <button class="w-full text-left px-3 py-2 text-label-md rounded-lg hover:bg-surface-hover dark:hover:bg-surface-container-high dark:text-white transition-colors font-medium" data-role="all">All Roles</button>
                                <button class="w-full text-left px-3 py-2 text-label-md rounded-lg hover:bg-surface-hover dark:hover:bg-surface-container-high dark:text-white transition-colors font-medium" data-role="Premium Member">Premium Member</button>
                                <button class="w-full text-left px-3 py-2 text-label-md rounded-lg hover:bg-surface-hover dark:hover:bg-surface-container-high dark:text-white transition-colors font-medium" data-role="Moderator">Moderator</button>
                                <button class="w-full text-left px-3 py-2 text-label-md rounded-lg hover:bg-surface-hover dark:hover:bg-surface-container-high dark:text-white transition-colors font-medium" data-role="Developer">Developer</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-surface-container-low dark:bg-slate-900/40">
                            <tr>
                                <th class="px-6 py-4 font-label-md text-label-md text-on-surface-variant dark:text-outline uppercase tracking-wider">User</th>
                                <th class="px-6 py-4 font-label-md text-label-md text-on-surface-variant dark:text-outline uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 font-label-md text-label-md text-on-surface-variant dark:text-outline uppercase tracking-wider">Role</th>
                                <th class="px-6 py-4 font-label-md text-label-md text-on-surface-variant dark:text-outline uppercase tracking-wider">Activity</th>
                                <th class="px-6 py-4 font-label-md text-label-md text-on-surface-variant dark:text-outline uppercase tracking-wider text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border-light dark:divide-border-dark" id="user-table-body">
                            <!-- User Row 1 -->
                            <tr class="hover:bg-surface-hover dark:hover:bg-slate-800/45 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <img alt="User Avatar" class="w-8 h-8 rounded-full" data-alt="A detailed professional headshot of a young software developer with glasses, wearing a charcoal hoodie..." src="https://lh3.googleusercontent.com/aida-public/AB6AXuCktVN-BTw7MJKQJW4Bvuvr-BCEM2JLujP12z1jQVIPv5hjnYfKL8epeWoDDyhqm92R74e1-muufnh-PE65GxJPQ-tyR8q7Unfl6K9oOw8mrCMd91EE85uVfhpiZfx1M_WlFP3zhLXCNLHcNrOKWCbN6_KhzzAl52kZjsWJOaF98hikd91snT1DbjK93P2ZOF33FXelpMeUDxLYRT-Ui8eVJgjYy4lfMi_Y1dDERiG7Zx4svVVbfGHKVgug-TTZMbTXqlmzn9s2Y6Q"/>
                                        <div>
                                            <p class="font-label-md text-label-md text-on-background dark:text-white">alex_coder92</p>
                                            <p class="text-[12px] text-on-surface-variant dark:text-outline">alex@devnexus.io</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 bg-green-100 dark:bg-green-950/40 text-green-700 dark:text-green-400 rounded-full text-[12px] font-bold">Active</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="font-label-sm text-label-sm text-on-surface dark:text-white">Premium Member</span>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="font-label-sm text-label-sm text-on-surface-variant dark:text-outline">Joined 2d ago</p>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2 items-center">
                                        <button class="permission-toggle-btn px-3 py-1.5 bg-surface dark:bg-slate-900 border border-outline-variant dark:border-slate-700 text-primary dark:text-primary-fixed-dim rounded-lg text-label-sm font-bold hover:bg-primary-fixed dark:hover:bg-slate-800 transition-colors">Grant Permission</button>
                                        <div class="relative">
                                            <button class="more-actions-btn p-1.5 text-on-surface-variant dark:text-outline hover:text-on-surface dark:hover:text-white">
                                                <span class="material-symbols-outlined">more_vert</span>
                                            </button>
                                            <!-- Actions Dropdown -->
                                            <div class="more-actions-dropdown hidden absolute right-0 mt-1 w-32 bg-surface dark:bg-slate-900 border border-outline-variant dark:border-slate-800 rounded-lg shadow-lg z-50 py-1 text-left">
                                                <a href="{{ route('profile') }}" class="block px-3 py-1.5 text-[12px] dark:text-white hover:bg-surface-hover dark:hover:bg-slate-800">View Profile</a>
                                                <button class="edit-role-btn w-full text-left px-3 py-1.5 text-[12px] dark:text-white hover:bg-surface-hover dark:hover:bg-slate-800">Edit Role</button>
                                                <button class="suspend-btn w-full text-left px-3 py-1.5 text-[12px] text-error hover:bg-red-50 dark:hover:bg-red-950/20">Suspend</button>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <!-- User Row 2 -->
                            <tr class="hover:bg-surface-hover dark:hover:bg-slate-800/45 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <img alt="User Avatar" class="w-8 h-8 rounded-full" data-alt="A cinematic, high-quality headshot of a senior female cloud architect with an intelligent and serene expression..." src="https://lh3.googleusercontent.com/aida-public/AB6AXuDXrs6FOeJAuMQ5yAnL2LEuA8F3USqB7nZuw8efjoka8EKhdarWQbJP00TUM6GnUU_G-kVHptLY-xsK9guDT8vCIrmYxDLtYq49BydHXzHMMjtsE-q5RI3I1UrXYRdAA74ar0kzHtkHgVIUIDgF-cnAxwQU9gmjsak3O_pCyaXBv9X2ALbXzyGE7TPPVEz91qgoXnlqTulqCqaPVO-uyJG7U84Lq2T5N1dHjClgjCrXtYIfGgUbgCL1dXRCO3HFq7XqFxocc9bG-JE"/>
                                        <div>
                                            <p class="font-label-md text-label-md text-on-background dark:text-white">sarah_ops</p>
                                            <p class="text-[12px] text-on-surface-variant dark:text-outline">sarah.j@techcloud.com</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 bg-green-100 dark:bg-green-950/40 text-green-700 dark:text-green-400 rounded-full text-[12px] font-bold">Active</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="font-label-sm text-label-sm text-on-surface dark:text-white">Moderator</span>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="font-label-sm text-label-sm text-on-surface-variant dark:text-outline">Joined 1y ago</p>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2 items-center">
                                        <button class="permission-toggle-btn px-3 py-1.5 bg-error-container text-error rounded-lg text-label-sm font-bold hover:opacity-80 transition-colors">Revoke Permission</button>
                                        <div class="relative">
                                            <button class="more-actions-btn p-1.5 text-on-surface-variant dark:text-outline hover:text-on-surface dark:hover:text-white">
                                                <span class="material-symbols-outlined">more_vert</span>
                                            </button>
                                            <!-- Actions Dropdown -->
                                            <div class="more-actions-dropdown hidden absolute right-0 mt-1 w-32 bg-surface dark:bg-slate-900 border border-outline-variant dark:border-slate-800 rounded-lg shadow-lg z-50 py-1 text-left">
                                                <a href="{{ route('profile') }}" class="block px-3 py-1.5 text-[12px] dark:text-white hover:bg-surface-hover dark:hover:bg-slate-800">View Profile</a>
                                                <button class="edit-role-btn w-full text-left px-3 py-1.5 text-[12px] dark:text-white hover:bg-surface-hover dark:hover:bg-slate-800">Edit Role</button>
                                                <button class="suspend-btn w-full text-left px-3 py-1.5 text-[12px] text-error hover:bg-red-50 dark:hover:bg-red-950/20">Suspend</button>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <!-- User Row 3 -->
                            <tr class="hover:bg-surface-hover dark:hover:bg-slate-800/45 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <img alt="User Avatar" class="w-8 h-8 rounded-full" data-alt="A professional studio portrait of a diverse male developer in his 30s with a creative and approachable look..." src="https://lh3.googleusercontent.com/aida-public/AB6AXuA8i2MPF-ImrKLq_lTy2rXtgpLvZCVK0RgBs5TdP1lKQoM6VqhgUZV1zQfOBWAoDtBg-V_9Mjj4Grl5DSp4tcNdejZjJ0Gd_sqOE9RAiTaRAc8NbV5t6JId9Io04V0dqTOgvPjIEZDRxVsbcozH2zHWUi21FxhM3z5D-JzcynozZOIZx1_d8wCpSnzoSSj_C9oCNb2ZtqNBBIWwEWyrY4mgJ_ufOTfmyzy-gspnfLYd14SyOC7DDGjOU_APYiraJTeJad8o_ZdBGSk"/>
                                        <div>
                                            <p class="font-label-md text-label-md text-on-background dark:text-white">m_ross_dev</p>
                                            <p class="text-[12px] text-on-surface-variant dark:text-outline">mike@ross.dev</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 bg-surface-container-highest dark:bg-slate-800 text-on-surface-variant dark:text-outline rounded-full text-[12px] font-bold">Inactive</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="font-label-sm text-label-sm text-on-surface dark:text-white">Developer</span>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="font-label-sm text-label-sm text-on-surface-variant dark:text-outline">Joined 5m ago</p>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2 items-center">
                                        <button class="permission-toggle-btn px-3 py-1.5 bg-surface dark:bg-slate-900 border border-outline-variant dark:border-slate-700 text-primary dark:text-primary-fixed-dim rounded-lg text-label-sm font-bold hover:bg-primary-fixed dark:hover:bg-slate-800 transition-colors">Grant Permission</button>
                                        <div class="relative">
                                            <button class="more-actions-btn p-1.5 text-on-surface-variant dark:text-outline hover:text-on-surface dark:hover:text-white">
                                                <span class="material-symbols-outlined">more_vert</span>
                                            </button>
                                            <!-- Actions Dropdown -->
                                            <div class="more-actions-dropdown hidden absolute right-0 mt-1 w-32 bg-surface dark:bg-slate-900 border border-outline-variant dark:border-slate-800 rounded-lg shadow-lg z-50 py-1 text-left">
                                                <a href="{{ route('profile') }}" class="block px-3 py-1.5 text-[12px] dark:text-white hover:bg-surface-hover dark:hover:bg-slate-800">View Profile</a>
                                                <button class="edit-role-btn w-full text-left px-3 py-1.5 text-[12px] dark:text-white hover:bg-surface-hover dark:hover:bg-slate-800">Edit Role</button>
                                                <button class="suspend-btn w-full text-left px-3 py-1.5 text-[12px] text-error hover:bg-red-50 dark:hover:bg-red-950/20">Suspend</button>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t border-border-light dark:border-border-dark flex justify-between items-center bg-surface-container-lowest dark:bg-slate-900/20">
                    <p class="text-label-sm text-on-surface-variant dark:text-outline">Showing <span id="showing-count">3</span> of 12,482 users</p>
                    <div class="flex gap-2">
                        <button onclick="showToast('You are on the first page')" class="p-2 border border-outline-variant dark:border-slate-700 rounded-lg disabled:opacity-50" disabled="">
                            <span class="material-symbols-outlined">chevron_left</span>
                        </button>
                        <button onclick="showToast('Loading next page...')" class="p-2 border border-outline-variant dark:border-slate-700 rounded-lg hover:bg-surface-container dark:hover:bg-slate-800">
                            <span class="material-symbols-outlined">chevron_right</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Deploy Modal -->
<div id="deploy-modal" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-surface dark:bg-slate-900 border border-outline-variant dark:border-slate-800 rounded-2xl w-full max-w-md p-6 shadow-2xl relative">
        <button id="close-deploy-modal" class="absolute top-4 right-4 text-on-surface-variant hover:text-on-surface dark:text-outline dark:hover:text-white">
            <span class="material-symbols-outlined">close</span>
        </button>
        <h3 class="font-headline-md text-headline-md font-bold text-on-background dark:text-white mb-4">Deploy System Update</h3>
        <p class="text-body-md text-on-surface-variant dark:text-outline mb-6">Are you sure you want to trigger a production deployment of the latest release version?</p>
        
        <div id="deploy-actions" class="flex justify-end gap-3">
            <button id="cancel-deploy" class="px-4 py-2 border border-outline dark:border-slate-700 rounded-lg text-label-md font-bold text-on-background dark:text-white hover:bg-surface-hover dark:hover:bg-slate-800">Cancel</button>
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

    // Top search bar mock
    const topSearch = document.getElementById('top-search');
    topSearch.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            showToast(`Searching for resources matching: "${topSearch.value}"`);
        }
    });

    // User Table Live Search Filter
    const userSearch = document.getElementById('user-search');
    const tableBody = document.getElementById('user-table-body');
    const rows = tableBody.querySelectorAll('tr');
    const showingCount = document.getElementById('showing-count');

    function filterTable() {
        const query = userSearch.value.toLowerCase().trim();
        let visibleCount = 0;
        rows.forEach(row => {
            const username = row.querySelector('.font-label-md').textContent.toLowerCase();
            const email = row.querySelector('.text-\\[12px\\]').textContent.toLowerCase();
            if (username.includes(query) || email.includes(query)) {
                row.classList.remove('hidden');
                visibleCount++;
            } else {
                row.classList.add('hidden');
            }
        });
        showingCount.textContent = visibleCount;
    }
    userSearch.addEventListener('input', filterTable);

    // Role Dropdown Filtering
    const filterBtn = document.getElementById('filter-btn');
    const filterDropdown = document.getElementById('filter-dropdown');
    
    filterBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        filterDropdown.classList.toggle('hidden');
    });

    document.addEventListener('click', () => {
        filterDropdown.classList.add('hidden');
    });

    filterDropdown.querySelectorAll('[data-role]').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const role = btn.getAttribute('data-role');
            let visibleCount = 0;
            rows.forEach(row => {
                const rowRole = row.querySelector('td:nth-child(3) span').textContent.trim();
                if (role === 'all' || rowRole === role) {
                    row.classList.remove('hidden');
                    visibleCount++;
                } else {
                    row.classList.add('hidden');
                }
            });
            showingCount.textContent = visibleCount;
            showToast(`Filtered by role: ${role}`);
        });
    });

    // Timeframe selector counters anim
    const timeframeBtn = document.getElementById('timeframe-btn');
    const timeframeDropdown = document.getElementById('timeframe-dropdown');
    const timeframeText = document.getElementById('timeframe-text');

    timeframeBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        timeframeDropdown.classList.toggle('hidden');
    });

    document.addEventListener('click', () => {
        if (timeframeDropdown) timeframeDropdown.classList.add('hidden');
    });

    timeframeDropdown.querySelectorAll('[data-time]').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const days = btn.getAttribute('data-time');
            timeframeText.textContent = `Last ${days} Days`;
            
            const totalUsersEl = document.getElementById('stat-total-users');
            const activeDiscEl = document.getElementById('stat-active-disc');
            const solRateEl = document.getElementById('stat-sol-rate');
            
            if (days === '7') {
                animateValue(totalUsersEl, parseInt(totalUsersEl.textContent.replace(/,/g, '')), 11520, 800);
                animateValue(activeDiscEl, parseInt(activeDiscEl.textContent.replace(/,/g, '')), 842, 800);
                solRateEl.textContent = '91%';
            } else if (days === '30') {
                animateValue(totalUsersEl, parseInt(totalUsersEl.textContent.replace(/,/g, '')), 12482, 800);
                animateValue(activeDiscEl, parseInt(activeDiscEl.textContent.replace(/,/g, '')), 1054, 800);
                solRateEl.textContent = '94%';
            } else {
                animateValue(totalUsersEl, parseInt(totalUsersEl.textContent.replace(/,/g, '')), 14890, 800);
                animateValue(activeDiscEl, parseInt(activeDiscEl.textContent.replace(/,/g, '')), 2840, 800);
                solRateEl.textContent = '96%';
            }
            showToast(`Metric view adjusted to: Last ${days} days`);
        });
    });

    function animateValue(obj, start, end, duration) {
        if (start === end) return;
        let startTimestamp = null;
        const step = (timestamp) => {
            if (!startTimestamp) startTimestamp = timestamp;
            const progress = Math.min((timestamp - startTimestamp) / duration, 1);
            const val = Math.floor(progress * (end - start) + start);
            obj.textContent = val.toLocaleString();
            if (progress < 1) {
                window.requestAnimationFrame(step);
            }
        };
        window.requestAnimationFrame(step);
    }

    // Export report spinner simulation
    const exportBtn = document.getElementById('export-btn');
    exportBtn.addEventListener('click', () => {
        const originalContent = exportBtn.innerHTML;
        exportBtn.disabled = true;
        exportBtn.innerHTML = `
            <svg class="animate-spin h-5 w-5 text-white mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Generating...
        `;
        setTimeout(() => {
            exportBtn.innerHTML = originalContent;
            exportBtn.disabled = false;
            showToast('Report generated and exported successfully!', 'success');
        }, 1500);
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

    // Action button toggles inside directory table
    document.querySelectorAll('.permission-toggle-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const row = btn.closest('tr');
            const username = row.querySelector('.font-label-md').textContent.trim();
            const isRevoke = btn.textContent.includes('Revoke');
            if (isRevoke) {
                btn.textContent = 'Grant Permission';
                btn.className = 'permission-toggle-btn px-3 py-1.5 bg-surface dark:bg-slate-900 border border-outline-variant dark:border-slate-700 text-primary dark:text-primary-fixed-dim rounded-lg text-label-sm font-bold hover:bg-primary-fixed dark:hover:bg-slate-800 transition-colors';
                showToast(`Revoked specialized roles/permissions from: ${username}`, 'error');
            } else {
                btn.textContent = 'Revoke Permission';
                btn.className = 'permission-toggle-btn px-3 py-1.5 bg-error-container text-error rounded-lg text-label-sm font-bold hover:opacity-80 transition-colors';
                showToast(`Successfully granted administrative permissions to: ${username}`, 'success');
            }
        });
    });

    // More actions click handling
    document.querySelectorAll('.more-actions-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.stopPropagation();
            const dropdown = btn.nextElementSibling;
            document.querySelectorAll('.more-actions-dropdown').forEach(d => {
                if (d !== dropdown) d.classList.add('hidden');
            });
            dropdown.classList.toggle('hidden');
        });
    });

    document.addEventListener('click', () => {
        document.querySelectorAll('.more-actions-dropdown').forEach(d => d.classList.add('hidden'));
    });

    document.querySelectorAll('.suspend-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const row = btn.closest('tr');
            const username = row.querySelector('.font-label-md').textContent.trim();
            showToast(`Account suspended: ${username}`, 'error');
        });
    });

    document.querySelectorAll('.edit-role-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const row = btn.closest('tr');
            const username = row.querySelector('.font-label-md').textContent.trim();
            showToast(`Role modification opened for: ${username}`);
        });
    });

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
</script>
@endpush
