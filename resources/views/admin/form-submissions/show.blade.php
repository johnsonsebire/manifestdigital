<x-layouts.app title="View Submission - {{ $submission->form->name }}">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                    Submission Details
                </h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">
                    Form: {{ $submission->form->name }}
                </p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.form-submissions.index', $submission->form_id) }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Submissions
                </a>
                <form action="{{ route('admin.form-submissions.destroy', $submission->id) }}" 
                      method="POST" 
                      onsubmit="return confirm('Are you sure you want to delete this submission?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Delete
                    </button>
                </form>
            </div>
        </div>

        <!-- Submission Info Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Submission Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Submitted At</p>
                    <p class="text-base font-medium text-gray-900 dark:text-white">
                        {{ $submission->submitted_at ? $submission->submitted_at->format('M d, Y \a\t h:i A') : ($submission->created_at ? $submission->created_at->format('M d, Y \a\t h:i A') : 'N/A') }}
                    </p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">IP Address</p>
                    <p class="text-base font-medium text-gray-900 dark:text-white">
                        {{ $submission->ip_address ?? 'N/A' }}
                    </p>
                </div>
                <div class="md:col-span-2">
                    <p class="text-sm text-gray-600 dark:text-gray-400">User Agent</p>
                    <p class="text-base font-medium text-gray-900 dark:text-white break-all">
                        {{ $submission->user_agent ?? 'N/A' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Submission Data Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Submitted Data</h2>
            
            @if($submission->data && count($submission->data) > 0)
                <div class="space-y-4">
                    @foreach($submission->data as $key => $value)
                        <div class="border-b border-gray-200 dark:border-gray-700 pb-4 last:border-0 last:pb-0">
                            <dt class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">
                                {{ ucwords(str_replace('_', ' ', $key)) }}
                            </dt>
                            <dd class="text-base text-gray-900 dark:text-white">
                                @if(is_array($value))
                                    <ul class="list-disc list-inside">
                                        @foreach($value as $item)
                                            <li>{{ $item }}</li>
                                        @endforeach
                                    </ul>
                                @elseif(filter_var($value, FILTER_VALIDATE_URL))
                                    <a href="{{ $value }}" target="_blank" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 underline">
                                        {{ $value }}
                                    </a>
                                @elseif(filter_var($value, FILTER_VALIDATE_EMAIL))
                                    <a href="mailto:{{ $value }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 underline">
                                        {{ $value }}
                                    </a>
                                @elseif(strlen($value) > 100)
                                    <div class="whitespace-pre-wrap">{{ $value }}</div>
                                @else
                                    {{ $value ?: 'N/A' }}
                                @endif
                            </dd>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 dark:text-gray-400 italic">No data available for this submission.</p>
            @endif
        </div>

        <!-- Export/Print Actions -->
        <div class="mt-6 flex gap-3">
            <button onclick="window.print()" 
                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Print
            </button>
        </div>
    </div>

    @push('styles')
    <style>
        @media print {
            .no-print, nav, header, footer, button, a {
                display: none !important;
            }
        }
    </style>
    @endpush
</x-layouts.app>
