@extends('layouts.app')

@section('title', 'Developer - Support Tickets | DevConnect')
@section('body-class', 'bg-background text-on-background font-body-md min-h-screen flex flex-col')

@section('content')
<x-navigation />
<main class="flex-grow max-w-container-max mx-auto w-full px-margin-desktop py-stack-lg">
    <div class="flex justify-between items-center mb-stack-md">
        <div>
            <h1 class="text-headline-lg font-headline-lg text-on-surface">Support Tickets (Developer)</h1>
            <p class="text-body-md text-on-surface-variant">Manage and review user support requests from developer panel.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 rounded-lg text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white border border-outline-variant rounded-xl overflow-hidden shadow-sm">
        @if($tickets->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-surface-container-low border-b border-outline-variant">
                            <th class="p-4 text-label-md font-label-md text-on-surface-variant">ID</th>
                            <th class="p-4 text-label-md font-label-md text-on-surface-variant">User</th>
                            <th class="p-4 text-label-md font-label-md text-on-surface-variant">Subject</th>
                            <th class="p-4 text-label-md font-label-md text-on-surface-variant">Priority</th>
                            <th class="p-4 text-label-md font-label-md text-on-surface-variant">Status</th>
                            <th class="p-4 text-label-md font-label-md text-on-surface-variant">Created</th>
                            <th class="p-4 text-label-md font-label-md text-on-surface-variant">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant">
                        @foreach($tickets as $ticket)
                            <tr class="hover:bg-surface-container-lowest transition-colors">
                                <td class="p-4 text-body-md text-on-surface">#{{ $ticket->id }}</td>
                                <td class="p-4 text-body-md text-on-surface font-semibold">{{ $ticket->user->name }}</td>
                                <td class="p-4 text-body-md text-on-surface font-semibold">{{ $ticket->subject }}</td>
                                <td class="p-4">
                                    @php
                                        $pColor = match($ticket->priority) {
                                            'high' => 'text-error bg-error-container',
                                            'low' => 'text-emerald-700 bg-emerald-100',
                                            default => 'text-amber-700 bg-amber-100',
                                        };
                                    @endphp
                                    <span class="px-2 py-1 rounded-full text-label-sm font-label-sm {{ $pColor }}">
                                        {{ ucfirst($ticket->priority) }}
                                    </span>
                                </td>
                                <td class="p-4">
                                    @php
                                        $sColor = match($ticket->status) {
                                            'resolved', 'closed' => 'text-emerald-700 bg-emerald-100',
                                            'in_progress' => 'text-primary bg-primary-container',
                                            default => 'text-on-surface-variant bg-surface-container-low',
                                        };
                                    @endphp
                                    <span class="px-2 py-1 rounded-full text-label-sm font-label-sm {{ $sColor }}">
                                        {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                    </span>
                                </td>
                                <td class="p-4 text-body-md text-on-surface-variant">{{ $ticket->created_at->format('M d, Y H:i') }}</td>
                                <td class="p-4">
                                    <a href="{{ route('developer.tickets.show', $ticket) }}" class="text-primary hover:underline font-semibold flex items-center gap-1">
                                        Manage
                                        <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-outline-variant bg-surface-container-low">
                {{ $tickets->links() }}
            </div>
        @else
            <div class="p-12 text-center text-on-surface-variant">
                <span class="material-symbols-outlined text-[48px] text-outline mb-4">inbox</span>
                <p class="text-body-lg">No support tickets found.</p>
            </div>
        @endif
    </div>
</main>
@endsection
