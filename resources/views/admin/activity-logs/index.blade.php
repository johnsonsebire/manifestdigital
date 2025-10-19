@extends('components.layouts.admin')

@section('title', 'Activity Logs')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Activity Logs</h1>
            <p class="mt-2 text-sm text-gray-700">
                Track all system activities and user actions
            </p>
        </div>
        <div class="mt-4 flex space-x-3 sm:mt-0 sm:ml-4">
            <a href="{{ route('admin.activity-logs.export', request()->query()) }}" 
               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Export CSV
            </a>
            <button type="button" onclick="openCleanupModal()" 
                    class="inline-flex items-center px-4 py-2 border border-red-300 rounded-md shadow-sm text-sm font-medium text-red-700 bg-white hover:bg-red-50">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
                Cleanup Old Logs
            </button>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Activities</dt>
                            <dd class="text-lg font-medium text-gray-900" id="total-activities">{{ number_format(\Spatie\Activitylog\Models\Activity::count()) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Today</dt>
                            <dd class="text-lg font-medium text-gray-900" id="activities-today">{{ number_format(\Spatie\Activitylog\Models\Activity::whereDate('created_at', today())->count()) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a1 1 0 011-1h6a1 1 0 011 1v4h.5a.5.5 0 01.5.5v1a.5.5 0 01-.5.5H15v9a2 2 0 01-2 2H9a2 2 0 01-2-2V9H4.5a.5.5 0 01-.5-.5v-1a.5.5 0 01.5-.5H8z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">This Week</dt>
                            <dd class="text-lg font-medium text-gray-900" id="activities-week">{{ number_format(\Spatie\Activitylog\Models\Activity::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count()) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-purple-500 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2v0a2 2 0 01-2-2v-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">This Month</dt>
                            <dd class="text-lg font-medium text-gray-900" id="activities-month">{{ number_format(\Spatie\Activitylog\Models\Activity::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count()) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <form method="GET" action="{{ route('admin.activity-logs.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <!-- Log Name Filter -->
                    <div>
                        <label for="log_name" class="block text-sm font-medium text-gray-700">Model Type</label>
                        <select name="log_name" id="log_name" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                            <option value="">All Models</option>
                            @foreach($logNames as $logName)
                                <option value="{{ $logName }}" {{ request('log_name') === $logName ? 'selected' : '' }}>
                                    {{ ucfirst($logName) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Event Filter -->
                    <div>
                        <label for="event" class="block text-sm font-medium text-gray-700">Event</label>
                        <select name="event" id="event" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                            <option value="">All Events</option>
                            @foreach($events as $event)
                                <option value="{{ $event }}" {{ request('event') === $event ? 'selected' : '' }}>
                                    {{ ucfirst($event) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- User Filter -->
                    <div>
                        <label for="causer_id" class="block text-sm font-medium text-gray-700">User</label>
                        <select name="causer_id" id="causer_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                            <option value="">All Users</option>
                            @foreach($causers as $causer)
                                <option value="{{ $causer->id }}" {{ request('causer_id') == $causer->id ? 'selected' : '' }}>
                                    {{ $causer->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Search -->
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}" 
                               placeholder="Search descriptions..."
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <!-- Date From -->
                    <div>
                        <label for="date_from" class="block text-sm font-medium text-gray-700">Date From</label>
                        <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>

                    <!-- Date To -->
                    <div>
                        <label for="date_to" class="block text-sm font-medium text-gray-700">Date To</label>
                        <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="{{ route('admin.activity-logs.index') }}" 
                       class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Clear Filters
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                        Apply Filters
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Activity Table -->
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <ul role="list" class="divide-y divide-gray-200">
            @forelse($activities as $activity)
                <li>
                    <div class="px-4 py-4 flex items-center justify-between">
                        <div class="flex items-center min-w-0 flex-1">
                            <div class="flex-shrink-0">
                                @php
                                    $iconClass = match($activity->event) {
                                        'created' => 'bg-green-100 text-green-800',
                                        'updated' => 'bg-blue-100 text-blue-800',
                                        'deleted' => 'bg-red-100 text-red-800',
                                        default => 'bg-gray-100 text-gray-800',
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $iconClass }}">
                                    {{ ucfirst($activity->event) }}
                                </span>
                            </div>
                            <div class="ml-4 min-w-0 flex-1">
                                <div>
                                    <p class="text-sm font-medium text-gray-900 truncate">
                                        {{ $activity->description }}
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        {{ $activity->causer?->name ?? 'System' }}
                                        @if($activity->log_name)
                                            • {{ ucfirst($activity->log_name) }}
                                        @endif
                                        • {{ $activity->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="flex-shrink-0">
                            <a href="{{ route('admin.activity-logs.show', $activity) }}" 
                               class="text-blue-600 hover:text-blue-500 text-sm font-medium">
                                View Details
                            </a>
                        </div>
                    </div>
                </li>
            @empty
                <li class="px-4 py-8 text-center">
                    <div class="text-gray-500">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M34 40h10v-4a6 6 0 00-10.712-3.714M34 40H14m20 0v-4a9.971 9.971 0 00-.712-3.714M14 40H4v-4a6 6 0 0110.713-3.714M14 40v-4c0-1.313.253-2.566.713-3.714m0 0A10.003 10.003 0 0124 26c4.21 0 7.813 2.602 9.288 6.286M30 14a6 6 0 11-12 0 6 6 0 0112 0zm12 6a4 4 0 11-8 0 4 4 0 018 0zm-28 0a4 4 0 11-8 0 4 4 0 018 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No activity logs found</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Try adjusting your search filters or check back later.
                        </p>
                    </div>
                </li>
            @endforelse
        </ul>

        @if($activities->hasPages())
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                {{ $activities->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Cleanup Modal -->
<div id="cleanup-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mt-2">Cleanup Old Activity Logs</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    This action will permanently delete activity logs older than the specified number of days.
                </p>
                <form id="cleanup-form" method="POST" action="{{ route('admin.activity-logs.cleanup') }}" class="mt-4">
                    @csrf
                    <label for="days" class="block text-sm font-medium text-gray-700">Days to keep</label>
                    <input type="number" name="days" id="days" min="1" max="365" value="90" required
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm">
                </form>
            </div>
            <div class="items-center px-4 py-3">
                <button id="cleanup-confirm" 
                        class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-300">
                    Delete Old Logs
                </button>
                <button id="cleanup-cancel" 
                        class="mt-3 px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-300">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function openCleanupModal() {
    document.getElementById('cleanup-modal').classList.remove('hidden');
}

document.getElementById('cleanup-cancel').addEventListener('click', function() {
    document.getElementById('cleanup-modal').classList.add('hidden');
});

document.getElementById('cleanup-confirm').addEventListener('click', function() {
    document.getElementById('cleanup-form').submit();
});

// Close modal when clicking outside
document.getElementById('cleanup-modal').addEventListener('click', function(e) {
    if (e.target === this) {
        this.classList.add('hidden');
    }
});
</script>
@endpush