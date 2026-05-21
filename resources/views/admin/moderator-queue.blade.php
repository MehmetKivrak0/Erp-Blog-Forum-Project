@extends('layouts.app')

@section('title', 'Modernized Moderation Hub | DevConnect')

@section('body-class', 'bg-[#F8FAFC] dark:bg-slate-950 h-full overflow-hidden text-slate-800 dark:text-slate-200')

@push('styles')
    <style>
        .scrollbar-hide::-webkit-scrollbar {
          display: none;
        }
        .scrollbar-hide {
          -ms-overflow-style: none;
          scrollbar-width: none;
        }
        .moderation-card {
          transition: all 0.2s ease;
          border: 1px solid rgba(226, 232, 240, 0.8);
        }
        .moderation-card:hover {
          box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.02);
          border-color: #e2e8f0;
        }
        .dark .moderation-card {
          border-color: #1e293b;
        }
        .dark .moderation-card:hover {
          border-color: #334155;
        }
        .active-nav-bg {
          background-color: white;
          box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }
        .dark .active-nav-bg {
          background-color: #1e293b;
          color: white !important;
        }
    </style>
@endpush

@section('content')
<div class="flex h-full">
    <!-- BEGIN: Sidebar -->
    <aside class="w-64 bg-white dark:bg-slate-900 border-r border-slate-200 dark:border-slate-800 flex flex-col shrink-0" data-purpose="sidebar-navigation">
        <div class="p-6">
            <a href="{{ route('home') }}" class="text-indigo-900 dark:text-white font-bold text-xl tracking-tight hover:opacity-90">DevConnect</a>
            <p class="text-xs text-slate-400 mt-1 font-medium">Moderator Console</p>
        </div>
        <nav class="flex-1 px-4 space-y-1">
            <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-slate-900 dark:hover:text-white hover:bg-slate-50 dark:hover:bg-slate-800 rounded-xl transition-all duration-200 group" href="{{ route('admin.dashboard') }}">
                <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                <span class="text-sm font-medium">Admin Overview</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 text-indigo-600 dark:text-indigo-400 active-nav-bg rounded-xl transition-all duration-200 group" href="{{ route('admin.moderator') }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04M12 21.355r-.015.015V21a14.663 14.663 0 007.618-4.016l.382.382" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                <span class="text-sm font-semibold">Moderator Hub</span>
                <div class="ml-auto w-1.5 h-1.5 rounded-full bg-indigo-600"></div>
            </a>
            <div class="pt-4 pb-2 px-4">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Resources</span>
            </div>
            <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-slate-900 dark:hover:text-white hover:bg-slate-50 dark:hover:bg-slate-800 rounded-xl transition-all duration-200" href="{{ route('home') }}">
                <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                <span class="text-sm font-medium">Dev Portal</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-slate-900 dark:hover:text-white hover:bg-slate-50 dark:hover:bg-slate-800 rounded-xl transition-all duration-200" href="{{ route('admin.dashboard') }}#user-directory-section">
                <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                <span class="text-sm font-medium">User Directory</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-slate-900 dark:hover:text-white hover:bg-slate-50 dark:hover:bg-slate-800 rounded-xl transition-all duration-200" href="{{ route('admin.moderator') }}">
                <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                <span class="text-sm font-medium">Content Queue</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-slate-900 dark:hover:text-white hover:bg-slate-50 dark:hover:bg-slate-800 rounded-xl transition-all duration-200" href="{{ route('admin.monitor') }}">
                <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04M12 21.355r-.015.015V21a14.663 14.663 0 007.618-4.016l.382.382" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                <span class="text-sm font-medium">System Health</span>
            </a>
        </nav>
        <div class="p-4 mt-auto">
            <div class="bg-indigo-50 dark:bg-slate-800 rounded-2xl p-4">
                <p class="text-indigo-900 dark:text-indigo-400 text-xs font-bold uppercase tracking-wider mb-1">Moderator Tip</p>
                <p class="text-indigo-700 dark:text-slate-300 text-xs leading-relaxed">Use bulk actions to process multiple flags at once.</p>
            </div>
        </div>
    </aside>
    <!-- END: Sidebar -->

    <!-- Main Content -->
    <main class="flex-1 flex flex-col min-w-0 overflow-hidden">
        <!-- BEGIN: Top Navigation Bar -->
        <header class="h-16 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between px-8 shrink-0">
            <div class="flex-1 max-w-2xl relative group">
                <span class="absolute inset-y-0 left-3 flex items-center text-slate-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                </span>
                <input id="queue-search" class="w-full pl-10 pr-4 py-2 bg-slate-100 dark:bg-slate-950 border-none rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 transition-all outline-none text-slate-900 dark:text-white" placeholder="Search across all technical communities..." type="text"/>
            </div>
            <div class="flex items-center gap-5 ml-4">
                <!-- Theme Toggle Button -->
                <button id="theme-toggle" class="p-2 text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-full">
                    <!-- Sun SVG -->
                    <svg id="theme-icon-sun" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m0-12.728l.707.707m12.728 12.728l.707.707M12 7a5 5 0 100 10 5 5 0 000-10z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                    <!-- Moon SVG -->
                    <svg id="theme-icon-moon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                </button>
                <!-- Notifications Bell -->
                <div class="relative">
                    <button id="notifications-btn" class="p-2 text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-full relative">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                        <span id="notifications-badge" class="absolute top-2 right-2.5 w-2 h-2 bg-red-500 border-2 border-white dark:border-slate-900 rounded-full"></span>
                    </button>
                    <!-- Notifications Dropdown -->
                    <div id="notifications-dropdown" class="hidden absolute right-0 mt-2 w-80 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl shadow-xl z-50 p-4 text-left">
                        <div class="flex justify-between items-center border-b border-slate-100 dark:border-slate-800 pb-2 mb-2">
                            <h4 class="text-sm font-bold text-slate-900 dark:text-white">Admin Alerts</h4>
                            <button id="clear-notifications" class="text-indigo-600 dark:text-indigo-400 text-xs hover:underline">Clear all</button>
                        </div>
                        <div class="space-y-3 max-h-60 overflow-y-auto">
                            <div class="flex gap-3 p-2 rounded hover:bg-slate-50 dark:hover:bg-slate-800">
                                <svg class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                                <div>
                                    <p class="text-xs font-semibold text-slate-900 dark:text-white">New user report on thread #105</p>
                                    <p class="text-[10px] text-slate-400">2 mins ago</p>
                                </div>
                            </div>
                            <div class="flex gap-3 p-2 rounded hover:bg-slate-50 dark:hover:bg-slate-800">
                                <svg class="w-5 h-5 text-indigo-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                                <div>
                                    <p class="text-xs font-semibold text-slate-900 dark:text-white">Sarah requested Moderator role</p>
                                    <p class="text-[10px] text-slate-400">1 hour ago</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Profile Image -->
                <a href="{{ route('profile') }}" class="h-8 w-8 rounded-full overflow-hidden border border-slate-200 block hover:opacity-85 transition-opacity">
                    <img alt="Moderator Avatar" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuC4BSKHxEVrmmMO5YAj_-aoy66gRq52Du8kjRu7uL7ufHg0unUycb2-5pnkcunV1LuNRws4d4s-TDHv9DTT1FlxbbtDPDyk3Q7mu5J2ajQ7e4qKDJ_Cq-xhL24gsccj3ba6xNsBVRkpxhMfJrNjiU4XKumWt7_jlJxD1G30XX1qXdk5HUyryLvqPBhmkG4PMc19HrwKxuD4HEBnShxKOUR6UpnLq8kzkMpyf9laMh9PEoCzr15UAekxHJHf1u8M12cNKneHsOxzi-8"/>
                </a>
            </div>
        </header>
        <!-- END: Top Navigation Bar -->

        <!-- Scrollable Main Content Area -->
        <div class="flex-1 overflow-y-auto p-8 scrollbar-hide bg-[#F8FAFC] dark:bg-slate-950">
            <!-- BEGIN: Header Section -->
            <div class="flex items-start justify-between mb-8">
                <div>
                    <h2 class="text-3xl font-bold text-slate-900 dark:text-white tracking-tight">Moderation Queue</h2>
                    <p class="text-slate-500 dark:text-slate-400 mt-1">Review and manage pending submissions across all communities.</p>
                </div>
                <button id="publish-bulletin-btn" class="bg-indigo-900 text-white px-5 py-2.5 rounded-xl font-medium shadow-lg shadow-indigo-900/20 hover:bg-indigo-800 transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                    Publish Bulletin
                </button>
            </div>
            <!-- END: Header Section -->

            <!-- BEGIN: Stats Summary Section -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10" data-purpose="stats-dashboard">
                <!-- Total Pending Card -->
                <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl moderation-card flex flex-col justify-between">
                    <div class="flex justify-between items-start">
                        <span class="text-sm font-semibold text-slate-500 dark:text-slate-400">Total Pending:</span>
                        <div class="w-16 h-8 flex items-end gap-1">
                            <!-- Simple Sparkline SVG -->
                            <svg class="w-full h-full" viewBox="0 0 100 40">
                                <path d="M0 35 Q 20 5, 40 30 T 80 10 T 100 25" fill="none" stroke="#4F46E5" stroke-linecap="round" stroke-width="3"></path>
                            </svg>
                        </div>
                    </div>
                    <div id="stats-pending-count" class="mt-2 text-3xl font-bold text-slate-900 dark:text-white">14</div>
                </div>
                <!-- Response Time Card -->
                <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl moderation-card flex flex-col justify-between">
                    <div class="flex justify-between items-start">
                        <span class="text-sm font-semibold text-slate-500 dark:text-slate-400">Avg. Response Time:</span>
                        <div class="p-2 bg-indigo-50 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                        </div>
                    </div>
                    <div class="mt-2 text-3xl font-bold text-slate-900 dark:text-white">3h</div>
                </div>
                <!-- Flags Today Card -->
                <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl moderation-card flex flex-col justify-between">
                    <div class="flex justify-between items-start">
                        <span class="text-sm font-semibold text-slate-500 dark:text-slate-400">Flags Today:</span>
                        <div class="flex items-center gap-2">
                            <div class="flex items-end gap-0.5 h-6 w-12">
                                <div class="w-2 bg-slate-200 dark:bg-slate-800 h-2 rounded-t-sm"></div>
                                <div class="w-2 bg-indigo-200 dark:bg-indigo-900 h-4 rounded-t-sm"></div>
                                <div class="w-2 bg-slate-200 dark:bg-slate-800 h-3 rounded-t-sm"></div>
                                <div class="w-2 bg-indigo-600 h-6 rounded-t-sm"></div>
                            </div>
                            <div class="p-2 bg-slate-50 dark:bg-slate-800 text-slate-500 dark:text-slate-400 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                            </div>
                        </div>
                    </div>
                    <div id="stats-flags-count" class="mt-2 text-3xl font-bold text-slate-900 dark:text-white">5</div>
                </div>
            </div>
            <!-- END: Stats Summary Section -->

            <!-- BEGIN: Queue Container -->
            <div class="bg-white dark:bg-slate-900 rounded-[2rem] shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden mb-10">
                <!-- Filter & Action Header -->
                <div class="px-8 py-5 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between bg-white dark:bg-slate-900 sticky top-0 z-10">
                    <div class="flex items-center gap-8">
                        <button id="tab-pending" class="relative py-2 text-sm font-bold text-indigo-600 dark:text-indigo-400">
                            Pending (<span id="tab-pending-badge">14</span>)
                            <span class="tab-indicator absolute bottom-0 left-0 w-full h-0.5 bg-indigo-600 dark:bg-indigo-400"></span>
                        </button>
                        <button id="tab-flagged" class="relative py-2 text-sm font-medium text-slate-500 hover:text-slate-800 dark:hover:text-white transition-colors">
                            Flagged (<span id="tab-flagged-badge">5</span>)
                            <span class="tab-indicator absolute bottom-0 left-0 w-full h-0.5 bg-indigo-600 dark:bg-indigo-400 hidden"></span>
                        </button>
                        <button id="tab-resolved" class="relative py-2 text-sm font-medium text-slate-500 hover:text-slate-800 dark:hover:text-white transition-colors">
                            Resolved
                            <span class="tab-indicator absolute bottom-0 left-0 w-full h-0.5 bg-indigo-600 dark:bg-indigo-400 hidden"></span>
                        </button>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="relative">
                            <span class="absolute inset-y-0 left-3 flex items-center text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                            </span>
                            <input id="sub-search" class="pl-9 pr-4 py-1.5 border border-slate-200 dark:border-slate-700 bg-transparent rounded-lg text-xs focus:ring-1 focus:ring-indigo-500 outline-none w-48 text-slate-900 dark:text-white" placeholder="Search queue..." type="text"/>
                        </div>
                        
                        <!-- Bulk Actions dropdown wrapper -->
                        <div class="relative">
                            <button id="bulk-actions-btn" class="flex items-center gap-2 px-3 py-1.5 border border-slate-200 dark:border-slate-700 rounded-lg text-xs font-medium text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-750">
                                Bulk Actions
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                            </button>
                            <!-- Dropdown Menu -->
                            <div id="bulk-actions-dropdown" class="hidden absolute right-0 mt-2 w-44 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg shadow-xl z-50 py-1 text-left">
                                <button onclick="handleBulkAction('approve')" class="w-full text-left px-4 py-2 text-xs font-semibold text-green-700 hover:bg-slate-50 dark:hover:bg-slate-800">Approve Selected</button>
                                <button onclick="handleBulkAction('reject')" class="w-full text-left px-4 py-2 text-xs font-semibold text-red-700 hover:bg-slate-50 dark:hover:bg-slate-800">Reject Selected</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- BEGIN: Moderation List Items -->
                <div id="queue-list" class="divide-y divide-slate-100 dark:divide-slate-800 px-6 py-2 min-h-[300px]">
                    <!-- Rendered Dynamically in JS -->
                </div>
                <!-- END: Moderation List Items -->

                <!-- BEGIN: Pagination Footer -->
                <div class="px-8 py-5 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between bg-slate-50/50 dark:bg-slate-900/40">
                    <p class="text-xs font-medium text-slate-500">Showing <span class="text-slate-900 dark:text-white" id="showing-range">1-5</span> of <span class="text-slate-900 dark:text-white" id="total-count-label">5</span> items</p>
                    <div class="flex items-center gap-2">
                        <button onclick="showToast('You are on the first page')" class="p-1.5 border border-slate-200 dark:border-slate-700 rounded-lg text-slate-400 hover:bg-white dark:hover:bg-slate-800 hover:text-slate-700 dark:hover:text-white transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                        </button>
                        <button onclick="showToast('Loading next page...')" class="p-1.5 border border-slate-200 dark:border-slate-700 rounded-lg text-slate-400 hover:bg-white dark:hover:bg-slate-800 hover:text-slate-700 dark:hover:text-white transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                        </button>
                    </div>
                </div>
                <!-- END: Pagination Footer -->
            </div>
            <!-- END: Queue Container -->
        </div>
    </main>
</div>

<!-- Bulletin Publisher Dialog Modal -->
<div id="bulletin-modal" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl w-full max-w-lg p-6 shadow-2xl relative text-left">
        <button id="close-bulletin-modal" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 dark:hover:text-white">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
        </button>
        <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Publish Moderator Bulletin</h3>
        <div class="space-y-4">
            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Bulletin Title</label>
                <input id="bulletin-title" class="w-full px-3 py-2 border border-slate-200 dark:border-slate-700 rounded-lg bg-transparent text-sm focus:ring-1 focus:ring-indigo-500 text-slate-900 dark:text-white" type="text" placeholder="Community Code of Conduct updates..."/>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Target Community</label>
                <select id="bulletin-community" class="w-full px-3 py-2 border border-slate-200 dark:border-slate-700 rounded-lg bg-transparent text-sm focus:ring-1 focus:ring-indigo-500 text-slate-900 dark:text-white dark:bg-slate-900">
                    <option value="all">All Communities</option>
                    <option value="rust">Rust Developers</option>
                    <option value="react">React Specialists</option>
                    <option value="node">Node API Scalers</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Bulletin Message</label>
                <textarea id="bulletin-text" rows="5" class="w-full px-3 py-2 border border-slate-200 dark:border-slate-700 rounded-lg bg-transparent text-sm focus:ring-1 focus:ring-indigo-500 text-slate-900 dark:text-white" placeholder="Write bulletin notes..."></textarea>
            </div>
            <div class="flex items-center gap-2">
                <input id="bulletin-pin" type="checkbox" class="rounded text-indigo-600 focus:ring-indigo-500 border-slate-300"/>
                <label for="bulletin-pin" class="text-xs text-slate-500 dark:text-slate-400">Pin this bulletin to feed header</label>
            </div>
            <div class="flex justify-end gap-3 pt-2">
                <button id="cancel-bulletin" class="px-4 py-2 border border-slate-200 dark:border-slate-700 rounded-lg text-sm font-semibold hover:bg-slate-50 dark:hover:bg-slate-800 text-slate-700 dark:text-white">Cancel</button>
                <button id="submit-bulletin" class="px-4 py-2 bg-indigo-900 text-white rounded-lg text-sm font-semibold hover:bg-indigo-800">Publish</button>
            </div>
        </div>
    </div>
</div>

<!-- Reject Reason Dialog Modal -->
<div id="reject-modal" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl w-full max-w-md p-6 shadow-2xl relative text-left">
        <button id="close-reject-modal" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 dark:hover:text-white">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
        </button>
        <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Reject Submission</h3>
        <p class="text-xs text-slate-500 dark:text-slate-400 mb-4">Please select a reason for rejecting this content submission.</p>
        
        <div class="space-y-3">
            <label class="flex items-center gap-3 p-3 border border-slate-100 dark:border-slate-800 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800/40 cursor-pointer">
                <input type="radio" name="reject-reason" value="Spam Link / Self Promotion" checked class="text-indigo-600 focus:ring-indigo-500 border-slate-300"/>
                <span class="text-xs font-semibold">Spam / Unrelated Self Promotion</span>
            </label>
            <label class="flex items-center gap-3 p-3 border border-slate-100 dark:border-slate-800 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800/40 cursor-pointer">
                <input type="radio" name="reject-reason" value="Off-Topic Content" class="text-indigo-600 focus:ring-indigo-500 border-slate-300"/>
                <span class="text-xs font-semibold">Off-Topic / Does not belong here</span>
            </label>
            <label class="flex items-center gap-3 p-3 border border-slate-100 dark:border-slate-800 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800/40 cursor-pointer">
                <input type="radio" name="reject-reason" value="Incomplete or Broken Code Snippets" class="text-indigo-600 focus:ring-indigo-500 border-slate-300"/>
                <span class="text-xs font-semibold">Broken / Incomplete Code Snippets</span>
            </label>
            <label class="flex items-center gap-3 p-3 border border-slate-100 dark:border-slate-800 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800/40 cursor-pointer">
                <input type="radio" name="reject-reason" value="Toxic Behaviour / Harassment" class="text-indigo-600 focus:ring-indigo-500 border-slate-300"/>
                <span class="text-xs font-semibold">Toxic Behavior / Community Guideline Breach</span>
            </label>
            <div class="flex justify-end gap-3 pt-3">
                <button id="cancel-rejection" class="px-4 py-2 border border-slate-200 dark:border-slate-700 rounded-lg text-sm font-semibold hover:bg-slate-50 dark:hover:bg-slate-800 text-slate-700 dark:text-white">Cancel</button>
                <button id="confirm-rejection-btn" class="px-4 py-2 bg-red-600 text-white rounded-lg text-sm font-semibold hover:bg-red-700">Confirm Rejection</button>
            </div>
        </div>
    </div>
</div>

<!-- Item Details Modal View -->
<div id="detail-modal" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl w-full max-w-2xl p-6 shadow-2xl relative text-left">
        <button id="close-detail-modal" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 dark:hover:text-white">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
        </button>
        <div id="detail-modal-content" class="space-y-4">
            <!-- Rendered Dynamically in JS -->
        </div>
    </div>
</div>

<!-- Toast Container -->
<div id="toast-container" class="fixed bottom-5 right-5 z-50 space-y-2"></div>
@endsection

@push('scripts')
<script>
    // Mock Data Objects
    let queueItems = [
        {
            id: 1,
            author: 'j_dev88',
            avatar: 'https://lh3.googleusercontent.com/aida-public/AB6AXuB0wnBplr9Q0XBFjFbPprpzKiqpKGrCXPGXuOaNY4Ov62pNAc8ZPtoqIoQIbKcQp-dlgvonMCR982z8h7YsYRzxtpvWMFrzoQoNCy-uHYO3ekL9MMh_oov2wC7Skj4zm8LNLjqdAVW11kaFICT5XupAQI-7GvREwK7RLyEDgt6AgAAj2Ktn7MwiJ2t4Ps5DONsI91Kc1Y_En-XrOH9lX315ASxKjNd8cT6wCuF-XFTjX05TqSF_KQIKzT7P7AuSMCMDfpH-FEDcbwc',
            type: 'ARTICLE',
            title: 'Mastering Rust Lifetimes: A Deep Dive',
            excerpt: "Rust's ownership model is powerful but lifetimes can be tricky for newcomers...",
            body: "Lifetimes are the compiler's way of ensuring that all references are valid and don't point to freed memory. In this article, we explore generic lifetime annotations, subtyping, and common lifetime patterns...",
            priority: 'Medium',
            time: '30 mins ago',
            status: 'pending'
        },
        {
            id: 2,
            author: 'alice_coder',
            avatar: 'https://lh3.googleusercontent.com/aida-public/AB6AXuD-Rmszuse5dv0qrw7_IpCPvvvRALpK42jEaKxdhn8EzwTxhQffOcOBbOkrET4X4Og1XnqILv9uw5WsTOPuA2e-I_zC6IkIKOLSGF5PKtJhs6tQq802TSx0JeHPx5DIMEHmsh5YG1F7Ph0gXbS4hRenPkvg7S3u6RO8Vs0HQU0pRbEo1mjJchqXT8lUhqgmHpPYRtyhO9sq7HjMmF6iv4lTOpzMQNclGwoKkZkSkt3fNW_p6-x6RJHxOmJNgQBPbuRt1X7zYLNNXso',
            type: 'FORUM POST',
            title: 'Best practices for React 19 concurrent mode?',
            excerpt: "I'm having issues with selective hydration in the new beta releases...",
            body: "When enabling concurrent rendering and server-side components in React 19, selective hydration causes mismatch warnings on nested dynamic containers. Here is the reproduction stack...",
            priority: 'High',
            time: '2 hours ago',
            status: 'pending'
        },
        {
            id: 3,
            author: 'bob_kubi',
            avatar: 'https://lh3.googleusercontent.com/aida-public/AB6AXuCF8h-GwME2Gl8GYC4BeqiQRFSZQGEjkmKkRQh3LTwVXZEcIpaplVbI0g1d7mV0FuSy-PMqf0GZ0Dp6WbmqYEzx7qbJF45GT_1J6iORRhQtasx0FP7urAHrw70vq0FbTfJjBzYM8Gz2zxg19ferjS7E-WdIphbT9OKgOMNr5BcXvjIK57Ph6-wsmgQhEk2wafTRumETn8i-r5Z8-cGzAam3hBO3crL6Rnu41j59jqihKDtmZz146VD5geDqmUBnDvrN9HTjPDsrV_M',
            type: 'ARTICLE',
            title: 'Why Clean Code is a Myth',
            excerpt: 'Controversial opinion: your perfectionism is killing the product...',
            body: "We focus too much on abstractions and DRY patterns that make the code unreadable. Sometimes duplication is cheaper than the wrong abstraction. Let's look at real-world examples...",
            priority: 'Medium',
            time: '5 hours ago',
            status: 'pending'
        },
        {
            id: 4,
            author: 'dev_dan',
            avatar: 'https://lh3.googleusercontent.com/aida-public/AB6AXuAZnlSW5qpwkQsb1yiGL07DnIpy4Wz8ZODYKnvZjMu7lt1vqP2N619I2aRl288YQyoroQh6_h0-a_fmoF5svBgKc7RWbXS7OPpRQbOEPtXOxELEItaJbOLrCaRsnd0pcBJM2qdybRC2XhfLwp4hob_MY-HvB2eyLs38p6EbLcI-M9XzJpKllxF-IZ-ajkZjDPEpxBbrmlpdHI2797Cha6oq8aw_Yl3a_0hjuR27m-PEuBbY5rGHHlUorAtEO0MnDPC8cv2mAVEkWzA',
            type: 'ARTICLE',
            title: 'Vite vs Webpack in 2024',
            excerpt: 'A comprehensive benchmark of build tools for modern SPAs...',
            body: "Vite uses ES modules during development and Rollup for production. Webpack compiles everything upfront. We measure cold starts, hot module replacement latency, and final asset size...",
            priority: 'Low',
            time: '1 day ago',
            status: 'pending'
        },
        {
            id: 5,
            author: 'bob_kubi',
            avatar: 'https://lh3.googleusercontent.com/aida-public/AB6AXuC7ijxosd5neyUqOETb3AEUyXgxLw4QgE021wtmPiF-MoOmj81bqMQGW2_fAB35EbVGUHXmMoQhbk954wXyEu9MHQQNvc_MFw5oBYDBoK7vLQSYs7UxHyF-CSXvP4rLMad9bes0WmXFW4HRW9pdsQiR1LMBEycIjpHidZwZF3sKLi8JAJML5V73G8H8b_mq7ZxJT1rszWGlDokyhAKsckHfqG2VAUboG8wQYF3thF4bf4xg4hp-PPyY9Aifnky1VzV2tpbSQL59vnM',
            type: 'FORUM POST',
            title: 'Why Clean Code is a Myth',
            excerpt: 'Controversial opinion: your perfectionism is killing the product...',
            body: "Duplicate forum thread containing the same content as the article above, possibly cross-posted.",
            priority: 'Low',
            time: '2 hours ago',
            status: 'pending'
        }
    ];

    let flaggedItems = [
        {
            id: 101,
            author: 'spam_bot9',
            avatar: 'https://lh3.googleusercontent.com/aida-public/AB6AXuAZnlSW5qpwkQsb1yiGL07DnIpy4Wz8ZODYKnvZjMu7lt1vqP2N619I2aRl288YQyoroQh6_h0-a_fmoF5svBgKc7RWbXS7OPpRQbOEPtXOxELEItaJbOLrCaRsnd0pcBJM2qdybRC2XhfLwp4hob_MY-HvB2eyLs38p6EbLcI-M9XzJpKllxF-IZ-ajkZjDPEpxBbrmlpdHI2797Cha6oq8aw_Yl3a_0hjuR27m-PEuBbY5rGHHlUorAtEO0MnDPC8cv2mAVEkWzA',
            type: 'REPLY',
            title: 'Reported comment in React 19 thread',
            excerpt: 'Get rich quick scheme click link here www.scamsite.com...',
            body: 'Click here to earn $5000 daily from home! Free registration!',
            reason: 'Spam Link Promotion',
            priority: 'High',
            time: '10 mins ago',
            status: 'flagged'
        },
        {
            id: 102,
            author: 'toxic_coder',
            avatar: 'https://lh3.googleusercontent.com/aida-public/AB6AXuCF8h-GwME2Gl8GYC4BeqiQRFSZQGEjkmKkRQh3LTwVXZEcIpaplVbI0g1d7mV0FuSy-PMqf0GZ0Dp6WbmqYEzx7qbJF45GT_1J6iORRhQtasx0FP7urAHrw70vq0FbTfJjBzYM8Gz2zxg19ferjS7E-WdIphbT9OKgOMNr5BcXvjIK57Ph6-wsmgQhEk2wafTRumETn8i-r5Z8-cGzAam3hBO3crL6Rnu41j59jqihKDtmZz146VD5geDqmUBnDvrN9HTjPDsrV_M',
            type: 'FORUM POST',
            title: 'Why your framework is garbage and you are too',
            excerpt: 'If you use this framework you lack basic logical reasoning skills...',
            body: 'I hate this framework and anyone who defends it is completely incompetent. Go back to boot camp...',
            reason: 'Harassment & Abuse',
            priority: 'High',
            time: '3 hours ago',
            status: 'flagged'
        }
    ];

    let resolvedItems = [
        {
            id: 201,
            author: 'l33t_haxor',
            avatar: 'https://lh3.googleusercontent.com/aida-public/AB6AXuCF8h-GwME2Gl8GYC4BeqiQRFSZQGEjkmKkRQh3LTwVXZEcIpaplVbI0g1d7mV0FuSy-PMqf0GZ0Dp6WbmqYEzx7qbJF45GT_1J6iORRhQtasx0FP7urAHrw70vq0FbTfJjBzYM8Gz2zxg19ferjS7E-WdIphbT9OKgOMNr5BcXvjIK57Ph6-wsmgQhEk2wafTRumETn8i-r5Z8-cGzAam3hBO3crL6Rnu41j59jqihKDtmZz146VD5geDqmUBnDvrN9HTjPDsrV_M',
            type: 'ARTICLE',
            title: 'Securing API Gateways against OAuth vulnerabilities',
            excerpt: 'Best methodologies to harden OAuth flows and configure proxy routes...',
            body: 'An in depth analysis of OAuth2.1 flow security, including authorization code leaks, PKCE execution parameters, and request-response header validations...',
            resolution: 'Approved',
            moderator: 'sarah_ops',
            time: 'Yesterday',
            status: 'resolved'
        }
    ];

    let activeTab = 'pending';
    let expandedItemIds = [1]; // Expand Rust Lifetimes by default

    // DOM Elements
    const listContainer = document.getElementById('queue-list');
    const tabPending = document.getElementById('tab-pending');
    const tabFlagged = document.getElementById('tab-flagged');
    const tabResolved = document.getElementById('tab-resolved');
    const tabPendingBadge = document.getElementById('tab-pending-badge');
    const tabFlaggedBadge = document.getElementById('tab-flagged-badge');
    const showingRange = document.getElementById('showing-range');
    const totalCountLabel = document.getElementById('total-count-label');
    const statsPendingCount = document.getElementById('stats-pending-count');
    const statsFlagsCount = document.getElementById('stats-flags-count');
    const mainSearch = document.getElementById('queue-search');
    const subSearch = document.getElementById('sub-search');

    // Theme Switcher Logic
    const themeToggle = document.getElementById('theme-toggle');
    const sunIcon = document.getElementById('theme-icon-sun');
    const moonIcon = document.getElementById('theme-icon-moon');
    const html = document.documentElement;

    function updateThemeIcon() {
        if (html.classList.contains('dark')) {
            sunIcon.classList.remove('hidden');
            moonIcon.classList.add('hidden');
        } else {
            sunIcon.classList.add('hidden');
            moonIcon.classList.remove('hidden');
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
        toast.className = `flex items-center gap-3 px-4 py-3 rounded-xl shadow-lg border text-sm font-bold transform translate-y-2 opacity-0 transition-all duration-300 z-50 ${
            type === 'success' 
                ? 'bg-green-50 dark:bg-green-950/40 text-green-700 dark:text-green-400 border-green-200 dark:border-green-800' 
                : 'bg-red-50 dark:bg-red-950/40 text-red-700 dark:text-red-400 border-red-200 dark:border-red-800'
        }`;
        
        const text = document.createElement('span');
        text.textContent = message;
        
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

    // Render Lists
    function renderQueue() {
        listContainer.innerHTML = '';
        let items = [];
        if (activeTab === 'pending') items = queueItems;
        else if (activeTab === 'flagged') items = flaggedItems;
        else items = resolvedItems;

        // Apply filters
        const q = (mainSearch.value || subSearch.value || '').toLowerCase().trim();
        if (q !== '') {
            items = items.filter(i => 
                i.author.toLowerCase().includes(q) ||
                i.title.toLowerCase().includes(q) ||
                (i.excerpt && i.excerpt.toLowerCase().includes(q))
            );
        }

        // Update counts
        tabPendingBadge.textContent = queueItems.length;
        tabFlaggedBadge.textContent = flaggedItems.length;
        statsPendingCount.textContent = queueItems.length;
        statsFlagsCount.textContent = flaggedItems.length;

        showingRange.textContent = items.length === 0 ? '0' : `1-${items.length}`;
        totalCountLabel.textContent = items.length;

        if (items.length === 0) {
            listContainer.innerHTML = `<div class="p-8 text-center text-sm text-slate-400">No moderation tasks available.</div>`;
            return;
        }

        items.forEach(item => {
            const isExpanded = expandedItemIds.includes(item.id);
            const rowDiv = document.createElement('div');
            rowDiv.className = "transition-all duration-200";

            if (isExpanded && activeTab !== 'resolved') {
                // Style A: Detailed Expanded Card
                rowDiv.innerHTML = `
                    <div class="moderation-card bg-slate-50/40 dark:bg-slate-900/60 rounded-2xl p-4 my-2 flex items-center gap-4 border border-slate-100 dark:border-slate-800">
                        <input class="row-checkbox w-4 h-4 text-indigo-600 border-slate-300 dark:border-slate-700 rounded focus:ring-indigo-500" type="checkbox" data-id="${item.id}"/>
                        <div class="w-10 h-10 rounded-full bg-slate-200 dark:bg-slate-800 overflow-hidden shrink-0">
                            <img alt="User Avatar" class="w-full h-full object-cover" src="${item.avatar || 'https://lh3.googleusercontent.com/aida-public/AB6AXuCktVN-BTw7MJKQJW4Bvuvr-BCEM2JLujP12z1jQVIPv5hjnYfKL8epeWoDDyhqm92R74e1-muufnh-PE65GxJPQ-tyR8q7Unfl6K9oOw8mrCMd91EE85uVfhpiZfx1M_WlFP3zhLXCNLHcNrOKWCbN6_KhzzAl52kZjsWJOaF98hikd91snT1DbjK93P2ZOF33FXelpMeUDxLYRT-Ui8eVJgjYy4lfMi_Y1dDERiG7Zx4svVVbfGHKVgug-TTZMbTXqlmzn9s2Y6Q'}"/>
                        </div>
                        <div class="flex-1 min-w-0" onclick="toggleExpand(${item.id})">
                            <div class="flex items-center gap-3 mb-1">
                                <span class="text-sm font-bold text-slate-900 dark:text-white">${item.author}</span>
                                <span class="text-[10px] font-bold bg-indigo-100 dark:bg-indigo-950 text-indigo-700 dark:text-indigo-300 px-2 py-0.5 rounded tracking-widest uppercase">${item.type}</span>
                                ${item.reason ? `<span class="text-[10px] font-bold bg-red-100 dark:bg-red-950/60 text-red-700 dark:text-red-400 px-2 py-0.5 rounded tracking-normal uppercase">Flag: ${item.reason}</span>` : ''}
                            </div>
                            <div class="flex flex-col">
                                <h4 class="text-sm font-semibold text-slate-900 dark:text-white hover:text-indigo-600 dark:hover:text-indigo-400 cursor-pointer">${item.title}</h4>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">${item.excerpt}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 ml-auto shrink-0">
                            <button onclick="viewDetail(${item.id})" class="px-4 py-1.5 text-xs font-semibold text-slate-600 dark:text-slate-300 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700">View Detail</button>
                            <button onclick="approveItem(${item.id})" class="px-4 py-1.5 text-xs font-semibold text-green-700 dark:text-green-400 bg-green-50 dark:bg-green-950/40 border border-green-100 dark:border-green-800 rounded-lg hover:bg-green-100">Approve</button>
                            <button onclick="triggerReject(${item.id})" class="px-4 py-1.5 text-xs font-semibold text-red-700 dark:text-red-400 bg-red-50 dark:bg-red-950/40 border border-red-100 dark:border-red-800 rounded-lg hover:bg-red-100">Reject</button>
                        </div>
                    </div>
                `;
            } else if (activeTab === 'resolved') {
                // Resolved view cards
                rowDiv.innerHTML = `
                    <div class="group hover:bg-slate-50/50 dark:hover:bg-slate-900/40 transition-colors p-4 flex items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-slate-900 dark:text-white leading-tight">${item.author}</span>
                                <span class="text-[9px] font-bold text-indigo-500/70 tracking-tighter uppercase">${item.type}</span>
                            </div>
                            <div class="max-w-md ml-4">
                                <h4 class="text-sm font-semibold text-slate-900 dark:text-white truncate">${item.title}</h4>
                                <p class="text-xs text-slate-400 mt-0.5">Moderator: <span class="font-medium text-slate-600 dark:text-slate-300">${item.moderator || 'system'}</span></p>
                            </div>
                        </div>
                        <div class="flex items-center gap-6">
                            <span class="px-3 py-1 rounded-full text-[10px] font-bold ${
                                item.resolution.includes('Approved') 
                                    ? 'bg-green-100 dark:bg-green-950/40 text-green-700 dark:text-green-400' 
                                    : 'bg-red-100 dark:bg-red-950/40 text-red-700 dark:text-red-400'
                            }">
                                ${item.resolution}
                            </span>
                            <span class="text-xs font-medium text-slate-400 whitespace-nowrap">${item.time}</span>
                        </div>
                    </div>
                `;
            } else {
                // Style B: Summary State row
                let priorityBg = 'bg-slate-100 text-slate-700';
                let dotBg = 'bg-slate-500';
                if (item.priority === 'High') { priorityBg = 'bg-red-100 text-red-700'; dotBg = 'bg-red-500'; }
                else if (item.priority === 'Medium') { priorityBg = 'bg-orange-100 text-orange-700'; dotBg = 'bg-orange-500'; }
                else if (item.priority === 'Low') { priorityBg = 'bg-emerald-100 text-emerald-700'; dotBg = 'bg-emerald-500'; }

                rowDiv.innerHTML = `
                    <div class="group hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors p-4 flex items-center gap-4 cursor-pointer" onclick="toggleExpand(${item.id})">
                        <input class="row-checkbox w-4 h-4 text-indigo-600 border-slate-300 dark:border-slate-700 rounded focus:ring-indigo-500" type="checkbox" data-id="${item.id}" onclick="event.stopPropagation()"/>
                        <div class="w-10 h-10 rounded-full bg-slate-200 dark:bg-slate-800 overflow-hidden shrink-0">
                            <img alt="User Avatar" class="w-full h-full object-cover" src="${item.avatar || 'https://lh3.googleusercontent.com/aida-public/AB6AXuCktVN-BTw7MJKQJW4Bvuvr-BCEM2JLujP12z1jQVIPv5hjnYfKL8epeWoDDyhqm92R74e1-muufnh-PE65GxJPQ-tyR8q7Unfl6K9oOw8mrCMd91EE85uVfhpiZfx1M_WlFP3zhLXCNLHcNrOKWCbN6_KhzzAl52kZjsWJOaF98hikd91snT1DbjK93P2ZOF33FXelpMeUDxLYRT-Ui8eVJgjYy4lfMi_Y1dDERiG7Zx4svVVbfGHKVgug-TTZMbTXqlmzn9s2Y6Q'}"/>
                        </div>
                        <div class="flex-1 min-w-0 flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-slate-900 dark:text-white leading-tight">${item.author}</span>
                                    <span class="text-[9px] font-bold text-indigo-500/70 tracking-tighter uppercase">${item.type}</span>
                                </div>
                                <div class="max-w-md">
                                    <h4 class="text-sm font-semibold text-slate-900 dark:text-white truncate">${item.title}</h4>
                                    <p class="text-xs text-slate-500 dark:text-slate-400 truncate mt-0.5">${item.excerpt}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-6">
                                <span class="flex items-center gap-1.5 px-3 py-1 rounded-full ${priorityBg} text-[10px] font-bold">
                                    <span class="w-1.5 h-1.5 rounded-full ${dotBg}"></span>
                                    ${item.priority}
                                </span>
                                <span class="text-xs font-medium text-slate-400 whitespace-nowrap">${item.time}</span>
                            </div>
                        </div>
                    </div>
                `;
            }
            listContainer.appendChild(rowDiv);
        });
    }

    // Toggle expansion of rows
    function toggleExpand(id) {
        if (expandedItemIds.includes(id)) {
            expandedItemIds = expandedItemIds.filter(x => x !== id);
        } else {
            expandedItemIds.push(id);
        }
        renderQueue();
    }

    // Approve submissions
    function approveItem(id) {
        let found = queueItems.find(x => x.id === id);
        let listName = 'queueItems';
        if (!found) {
            found = flaggedItems.find(x => x.id === id);
            listName = 'flaggedItems';
        }

        if (found) {
            // Remove from source array
            if (listName === 'queueItems') {
                queueItems = queueItems.filter(x => x.id !== id);
            } else {
                flaggedItems = flaggedItems.filter(x => x.id !== id);
            }
            
            // Add to resolved array
            resolvedItems.unshift({
                id: found.id,
                author: found.author,
                avatar: found.avatar,
                type: found.type,
                title: found.title,
                resolution: 'Approved',
                moderator: 'sarah_ops',
                time: 'Just now',
                status: 'resolved'
            });

            showToast(`"${found.title}" approved successfully`, 'success');
            renderQueue();
        }
    }

    // Reject submissions modal flow
    let activeRejectId = null;
    const rejectModal = document.getElementById('reject-modal');
    const confirmRejectionBtn = document.getElementById('confirm-rejection-btn');

    function triggerReject(id) {
        activeRejectId = id;
        rejectModal.classList.remove('hidden');
    }

    document.getElementById('cancel-rejection').addEventListener('click', () => {
        rejectModal.classList.add('hidden');
    });
    document.getElementById('close-reject-modal').addEventListener('click', () => {
        rejectModal.classList.add('hidden');
    });

    confirmRejectionBtn.addEventListener('click', () => {
        if (!activeRejectId) return;
        
        const selectedReason = document.querySelector('input[name="reject-reason"]:checked').value;
        let found = queueItems.find(x => x.id === activeRejectId);
        let listName = 'queueItems';
        if (!found) {
            found = flaggedItems.find(x => x.id === activeRejectId);
            listName = 'flaggedItems';
        }

        if (found) {
            // Remove from source
            if (listName === 'queueItems') {
                queueItems = queueItems.filter(x => x.id !== activeRejectId);
            } else {
                flaggedItems = flaggedItems.filter(x => x.id !== activeRejectId);
            }

            // Push to resolved
            resolvedItems.unshift({
                id: found.id,
                author: found.author,
                avatar: found.avatar,
                type: found.type,
                title: found.title,
                resolution: `Rejected (${selectedReason})`,
                moderator: 'sarah_ops',
                time: 'Just now',
                status: 'resolved'
            });

            showToast(`"${found.title}" rejected: ${selectedReason}`, 'error');
            rejectModal.classList.add('hidden');
            renderQueue();
        }
    });

    // View detail modal flow
    const detailModal = document.getElementById('detail-modal');
    const detailModalContent = document.getElementById('detail-modal-content');

    function viewDetail(id) {
        let found = queueItems.find(x => x.id === id) || flaggedItems.find(x => x.id === id) || resolvedItems.find(x => x.id === id);
        if (!found) return;

        detailModalContent.innerHTML = `
            <div class="flex items-center gap-4 border-b border-slate-100 dark:border-slate-800 pb-4">
                <img class="w-12 h-12 rounded-full object-cover" src="${found.avatar || 'https://lh3.googleusercontent.com/aida-public/AB6AXuCktVN-BTw7MJKQJW4Bvuvr-BCEM2JLujP12z1jQVIPv5hjnYfKL8epeWoDDyhqm92R74e1-muufnh-PE65GxJPQ-tyR8q7Unfl6K9oOw8mrCMd91EE85uVfhpiZfx1M_WlFP3zhLXCNLHcNrOKWCbN6_KhzzAl52kZjsWJOaF98hikd91snT1DbjK93P2ZOF33FXelpMeUDxLYRT-Ui8eVJgjYy4lfMi_Y1dDERiG7Zx4svVVbfGHKVgug-TTZMbTXqlmzn9s2Y6Q'}" alt="Avatar"/>
                <div>
                    <h4 class="text-md font-bold text-slate-900 dark:text-white">${found.author}</h4>
                    <p class="text-xs text-slate-400">Content Type: <span class="font-bold text-indigo-600 dark:text-indigo-400 uppercase">${found.type}</span></p>
                </div>
                <div class="ml-auto flex flex-col items-end">
                    <span class="text-xs text-slate-400">${found.time}</span>
                    ${found.priority ? `<span class="mt-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 dark:bg-slate-800">${found.priority} Priority</span>` : ''}
                </div>
            </div>
            <div class="py-2 space-y-3">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white leading-snug">${found.title}</h3>
                <div class="bg-slate-50 dark:bg-slate-950 p-4 rounded-xl border border-slate-100 dark:border-slate-800 text-xs font-mono overflow-x-auto max-h-60 leading-relaxed text-slate-700 dark:text-slate-300">
                    ${found.body || found.excerpt}
                </div>
            </div>
            ${found.status !== 'resolved' ? `
                <div class="flex justify-end gap-3 pt-4 border-t border-slate-100 dark:border-slate-800">
                    <button onclick="closeDetail(); approveItem(${found.id})" class="px-5 py-2 bg-green-600 text-white rounded-xl text-xs font-semibold hover:bg-green-700">Approve Submission</button>
                    <button onclick="closeDetail(); triggerReject(${found.id})" class="px-5 py-2 bg-red-600 text-white rounded-xl text-xs font-semibold hover:bg-red-700">Reject Submission</button>
                </div>
            ` : ''}
        `;
        detailModal.classList.remove('hidden');
    }

    function closeDetail() {
        detailModal.classList.add('hidden');
    }
    document.getElementById('close-detail-modal').addEventListener('click', closeDetail);

    // Tab Switching
    function setTab(tab) {
        activeTab = tab;
        // Styles
        [tabPending, tabFlagged, tabResolved].forEach(t => {
            t.classList.remove('text-indigo-600', 'dark:text-indigo-400', 'font-bold');
            t.classList.add('text-slate-500', 'font-medium');
            t.querySelector('.tab-indicator').classList.add('hidden');
        });

        let target = tabPending;
        if (tab === 'flagged') target = tabFlagged;
        if (tab === 'resolved') target = tabResolved;

        target.classList.remove('text-slate-500', 'font-medium');
        target.classList.add('text-indigo-600', 'dark:text-indigo-400', 'font-bold');
        target.querySelector('.tab-indicator').classList.remove('hidden');

        renderQueue();
    }

    tabPending.addEventListener('click', () => setTab('pending'));
    tabFlagged.addEventListener('click', () => setTab('flagged'));
    tabResolved.addEventListener('click', () => setTab('resolved'));

    // Search Filtering Listeners
    mainSearch.addEventListener('input', renderQueue);
    subSearch.addEventListener('input', renderQueue);

    // Bulk action dropdown toggle
    const bulkBtn = document.getElementById('bulk-actions-btn');
    const bulkDropdown = document.getElementById('bulk-actions-dropdown');
    bulkBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        bulkDropdown.classList.toggle('hidden');
    });
    document.addEventListener('click', () => {
        bulkDropdown.classList.add('hidden');
    });

    function handleBulkAction(action) {
        const checkboxes = document.querySelectorAll('.row-checkbox:checked');
        const ids = Array.from(checkboxes).map(c => parseInt(c.getAttribute('data-id')));
        
        if (ids.length === 0) {
            showToast('No items selected for bulk actions', 'error');
            return;
        }

        let processedCount = 0;
        ids.forEach(id => {
            let found = queueItems.find(x => x.id === id);
            let listName = 'queueItems';
            if (!found) {
                found = flaggedItems.find(x => x.id === id);
                listName = 'flaggedItems';
            }

            if (found) {
                processedCount++;
                if (listName === 'queueItems') {
                    queueItems = queueItems.filter(x => x.id !== id);
                } else {
                    flaggedItems = flaggedItems.filter(x => x.id !== id);
                }

                resolvedItems.unshift({
                    id: found.id,
                    author: found.author,
                    avatar: found.avatar,
                    type: found.type,
                    title: found.title,
                    resolution: action === 'approve' ? 'Approved (Bulk)' : 'Rejected (Bulk)',
                    moderator: 'sarah_ops',
                    time: 'Just now',
                    status: 'resolved'
                });
            }
        });

        showToast(`Bulk action processed: ${action === 'approve' ? 'Approved' : 'Rejected'} ${processedCount} items`, 'success');
        renderQueue();
    }

    // Bulletin Modal toggles
    const bulletinBtn = document.getElementById('publish-bulletin-btn');
    const bulletinModal = document.getElementById('bulletin-modal');
    const closeBulletin = document.getElementById('close-bulletin-modal');
    const cancelBulletin = document.getElementById('cancel-bulletin');
    const submitBulletin = document.getElementById('submit-bulletin');

    bulletinBtn.addEventListener('click', () => {
        bulletinModal.classList.remove('hidden');
    });
    closeBulletin.addEventListener('click', () => bulletinModal.classList.add('hidden'));
    cancelBulletin.addEventListener('click', () => bulletinModal.classList.add('hidden'));

    submitBulletin.addEventListener('click', () => {
        const title = document.getElementById('bulletin-title').value.trim();
        const text = document.getElementById('bulletin-text').value.trim();
        if (title === '' || text === '') {
            showToast('Title and Message are required', 'error');
            return;
        }

        showToast(`Bulletin published: "${title}"`, 'success');
        bulletinModal.classList.add('hidden');
        document.getElementById('bulletin-title').value = '';
        document.getElementById('bulletin-text').value = '';
    });

    // Notifications bell
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
        notificationsDropdown.querySelector('.space-y-3').innerHTML = '<p class="text-xs text-slate-400 text-center py-4">No alarms active.</p>';
        showToast('All messages cleared');
    });

    // Expose functions globally for inline event attributes (onclick, etc.)
    window.showToast = showToast;
    window.handleBulkAction = handleBulkAction;
    window.toggleExpand = toggleExpand;
    window.viewDetail = viewDetail;
    window.approveItem = approveItem;
    window.triggerReject = triggerReject;
    window.closeDetail = closeDetail;

    // Initial Render
    renderQueue();
</script>
@endpush
