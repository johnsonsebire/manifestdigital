@extends('components.layouts.admin')

@section('title', 'Activity Log Details')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center space-x-4">
        <a href="{{ route('admin.activity-logs.index') }}" 
           class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-700">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Back to Activity Logs
        </a>
    </div>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Activity Log Details
            </h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                Detailed information about this activity log entry.
            </p>
        </div>
        
        <div class="border-t border-gray-200">
            <dl>
                <!-- Description -->
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Description</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $activity->description }}
                    </dd>
                </div>

                <!-- Event -->
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Event</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        @php
                            $badgeClass = match($activity->event) {
                                'created' => 'bg-green-100 text-green-800',
                                'updated' => 'bg-blue-100 text-blue-800',
                                'deleted' => 'bg-red-100 text-red-800',
                                default => 'bg-gray-100 text-gray-800',
                            };
                        @endphp
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $badgeClass }}">
                            {{ ucfirst($activity->event) }}
                        </span>
                    </dd>
                </div>

                <!-- Log Name -->
                @if($activity->log_name)
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Model Type</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ ucfirst($activity->log_name) }}
                    </dd>
                </div>
                @endif

                <!-- Subject -->
                @if($activity->subject)
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Subject</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        <div class="space-y-1">
                            <div><span class="font-medium">Type:</span> {{ class_basename($activity->subject_type) }}</div>
                            <div><span class="font-medium">ID:</span> {{ $activity->subject_id }}</div>
                            @if($activity->subject && method_exists($activity->subject, 'getRouteKey'))
                                <div><span class="font-medium">Reference:</span> {{ $activity->subject->getRouteKey() }}</div>
                            @endif
                        </div>
                    </dd>
                </div>
                @endif

                <!-- Causer -->
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Performed By</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        @if($activity->causer)
                            <div class="flex items-center space-x-2">
                                <div class="flex-shrink-0 h-8 w-8">
                                    <div class="h-8 w-8 rounded-full bg-gray-300 flex items-center justify-center">
                                        <span class="text-sm font-medium text-gray-700">
                                            {{ substr($activity->causer->name, 0, 1) }}
                                        </span>
                                    </div>
                                </div>
                                <div>
                                    <div class="font-medium">{{ $activity->causer->name }}</div>
                                    <div class="text-gray-500">{{ $activity->causer->email }}</div>
                                </div>
                            </div>
                        @else
                            <span class="text-gray-500">System</span>
                        @endif
                    </dd>
                </div>

                <!-- Timestamp -->
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Date & Time</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        <div class="space-y-1">
                            <div>{{ $activity->created_at->format('F j, Y g:i:s A') }}</div>
                            <div class="text-gray-500">{{ $activity->created_at->diffForHumans() }}</div>
                        </div>
                    </dd>
                </div>

                <!-- Batch UUID -->
                @if($activity->batch_uuid)
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Batch UUID</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        <code class="text-xs bg-gray-100 px-2 py-1 rounded">{{ $activity->batch_uuid }}</code>
                    </dd>
                </div>
                @endif

                <!-- Properties -->
                @if($activity->properties && count($activity->properties) > 0)
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Properties</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        <!-- Old Values -->
                        @if(isset($activity->properties['old']) && !empty($activity->properties['old']))
                        <div class="mb-4">
                            <h4 class="text-sm font-medium text-gray-900 mb-2">Previous Values</h4>
                            <div class="bg-red-50 border border-red-200 rounded-md p-3">
                                <dl class="space-y-2">
                                    @foreach($activity->properties['old'] as $key => $value)
                                    <div class="flex">
                                        <dt class="text-xs font-medium text-red-800 w-1/3">{{ ucwords(str_replace('_', ' ', $key)) }}:</dt>
                                        <dd class="text-xs text-red-700 w-2/3 ml-2">
                                            @if(is_array($value) || is_object($value))
                                                <pre class="whitespace-pre-wrap">{{ json_encode($value, JSON_PRETTY_PRINT) }}</pre>
                                            @elseif(is_bool($value))
                                                {{ $value ? 'true' : 'false' }}
                                            @elseif(is_null($value))
                                                <span class="text-gray-400">null</span>
                                            @else
                                                {{ $value }}
                                            @endif
                                        </dd>
                                    </div>
                                    @endforeach
                                </dl>
                            </div>
                        </div>
                        @endif

                        <!-- New Values -->
                        @if(isset($activity->properties['attributes']) && !empty($activity->properties['attributes']))
                        <div class="mb-4">
                            <h4 class="text-sm font-medium text-gray-900 mb-2">New Values</h4>
                            <div class="bg-green-50 border border-green-200 rounded-md p-3">
                                <dl class="space-y-2">
                                    @foreach($activity->properties['attributes'] as $key => $value)
                                    <div class="flex">
                                        <dt class="text-xs font-medium text-green-800 w-1/3">{{ ucwords(str_replace('_', ' ', $key)) }}:</dt>
                                        <dd class="text-xs text-green-700 w-2/3 ml-2">
                                            @if(is_array($value) || is_object($value))
                                                <pre class="whitespace-pre-wrap">{{ json_encode($value, JSON_PRETTY_PRINT) }}</pre>
                                            @elseif(is_bool($value))
                                                {{ $value ? 'true' : 'false' }}
                                            @elseif(is_null($value))
                                                <span class="text-gray-400">null</span>
                                            @else
                                                {{ $value }}
                                            @endif
                                        </dd>
                                    </div>
                                    @endforeach
                                </dl>
                            </div>
                        </div>
                        @endif

                        <!-- Raw Properties -->
                        <div>
                            <h4 class="text-sm font-medium text-gray-900 mb-2">Raw Properties</h4>
                            <div class="bg-gray-50 border border-gray-200 rounded-md p-3">
                                <pre class="text-xs text-gray-700 whitespace-pre-wrap">{{ json_encode($activity->properties, JSON_PRETTY_PRINT) }}</pre>
                            </div>
                        </div>
                    </dd>
                </div>
                @endif
            </dl>
        </div>
    </div>

    <!-- Related Activities -->
    @if($activity->subject_type && $activity->subject_id)
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Related Activities
            </h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                Other activities related to this {{ class_basename($activity->subject_type) }}.
            </p>
        </div>
        
        <div class="border-t border-gray-200">
            <div id="related-activities" class="divide-y divide-gray-200">
                <!-- Will be loaded via AJAX -->
                <div class="px-4 py-3 text-center text-gray-500">
                    Loading related activities...
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@if($activity->subject_type && $activity->subject_id)
@push('scripts')
<script>
// Load related activities
fetch('/admin/activity-logs/timeline?subject_type={{ urlencode($activity->subject_type) }}&subject_id={{ $activity->subject_id }}')
    .then(response => response.json())
    .then(data => {
        const container = document.getElementById('related-activities');
        
        if (data.data && data.data.length > 0) {
            container.innerHTML = data.data.map(activity => `
                <div class="px-4 py-3 flex items-center justify-between">
                    <div class="flex items-center min-w-0 flex-1">
                        <div class="flex-shrink-0">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${getEventBadgeClass(activity.event)}">
                                ${activity.event.charAt(0).toUpperCase() + activity.event.slice(1)}
                            </span>
                        </div>
                        <div class="ml-4 min-w-0 flex-1">
                            <p class="text-sm font-medium text-gray-900 truncate">${activity.description}</p>
                            <p class="text-sm text-gray-500">
                                ${activity.causer ? activity.causer.name : 'System'} • ${formatDate(activity.created_at)}
                            </p>
                        </div>
                    </div>
                    <div class="flex-shrink-0">
                        <a href="/admin/activity-logs/${activity.id}" class="text-blue-600 hover:text-blue-500 text-sm font-medium">
                            View
                        </a>
                    </div>
                </div>
            `).join('');
        } else {
            container.innerHTML = '<div class="px-4 py-3 text-center text-gray-500">No related activities found.</div>';
        }
    })
    .catch(error => {
        console.error('Error loading related activities:', error);
        document.getElementById('related-activities').innerHTML = 
            '<div class="px-4 py-3 text-center text-red-500">Error loading related activities.</div>';
    });

function getEventBadgeClass(event) {
    switch(event) {
        case 'created': return 'bg-green-100 text-green-800';
        case 'updated': return 'bg-blue-100 text-blue-800';
        case 'deleted': return 'bg-red-100 text-red-800';
        default: return 'bg-gray-100 text-gray-800';
    }
}

function formatDate(dateString) {
    return new Date(dateString).toLocaleString();
}
</script>
@endpush
@endif