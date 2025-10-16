<x-layouts.app :title="__('Dashboard')">
    @if($type === 'admin')
        {{-- Admin Dashboard with Form Submission Metrics --}}
        <div class="flex h-full w-full flex-1 flex-col gap-6">
            {{-- Page Header --}}
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Dashboard</h1>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Overview of form submissions and activity</p>
                </div>
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    {{ now()->format('l, F j, Y') }}
                </div>
            </div>

            {{-- Metrics Cards --}}
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                {{-- Total Submissions --}}
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Submissions</p>
                            <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($metrics['total']) }}</p>
                        </div>
                        <div class="p-3 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Today's Submissions --}}
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Today</p>
                            <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($metrics['today']) }}</p>
                        </div>
                        <div class="p-3 bg-green-100 dark:bg-green-900/30 rounded-lg">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- This Week --}}
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">This Week</p>
                            <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($metrics['this_week']) }}</p>
                        </div>
                        <div class="p-3 bg-purple-100 dark:bg-purple-900/30 rounded-lg">
                            <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- This Month --}}
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">This Month</p>
                            <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($metrics['this_month']) }}</p>
                            @if($metrics['monthly_change'] != 0)
                                <p class="mt-1 text-xs {{ $metrics['monthly_change'] > 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                    {{ $metrics['monthly_change'] > 0 ? '+' : '' }}{{ $metrics['monthly_change'] }}% from last month
                                </p>
                            @endif
                        </div>
                        <div class="p-3 bg-orange-100 dark:bg-orange-900/30 rounded-lg">
                            <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Additional Stats Row --}}
            <div class="grid gap-4 md:grid-cols-2">
                {{-- Forms Overview --}}
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Forms Overview</h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Total Forms</span>
                            <span class="text-lg font-semibold text-gray-900 dark:text-white">{{ number_format($metrics['total_forms']) }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Active Forms</span>
                            <span class="text-lg font-semibold text-green-600 dark:text-green-400">{{ number_format($metrics['active_forms']) }}</span>
                        </div>
                        <div class="flex items-center justify-between pt-3 border-t border-gray-200 dark:border-gray-700">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Avg. Submissions/Form</span>
                            <span class="text-lg font-semibold text-gray-900 dark:text-white">
                                {{ $metrics['total_forms'] > 0 ? number_format($metrics['total'] / $metrics['total_forms'], 1) : '0' }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Top Forms --}}
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Top Forms by Submissions</h3>
                    @if($topForms->count() > 0)
                        <div class="space-y-3">
                            @foreach($topForms as $form)
                                <div class="flex items-center justify-between">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $form->name }}</p>
                                    </div>
                                    <span class="ml-2 px-2.5 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 text-xs font-semibold rounded-full">
                                        {{ number_format($form->submissions_count) }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-gray-500 dark:text-gray-400 text-center py-4">No forms created yet</p>
                    @endif
                </div>
            </div>

            {{-- Recent Submissions --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Submissions</h3>
                        @can('view-form-submissions')
                            <a href="{{ route('admin.form-submissions.index') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                                View All →
                            </a>
                        @endcan
                    </div>
                </div>
                <div class="overflow-x-auto">
                    @if($recentSubmissions->count() > 0)
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-900/50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Form</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Submitted</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($recentSubmissions as $submission)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $submission->form->name ?? 'N/A' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $submission->created_at->diffForHumans() }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300">
                                                Received
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            @can('view-form-submissions')
                                                <a href="{{ route('admin.form-submissions.show', $submission->id) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300">
                                                    View
                                                </a>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="px-6 py-12 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No submissions yet</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Get started by creating a form.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @else
        {{-- Regular User Dashboard --}}
        <div class="flex h-full w-full flex-1 items-center justify-center">
            <div class="text-center">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Welcome to your Dashboard</h1>
                <p class="mt-4 text-gray-600 dark:text-gray-400">{{ $message ?? 'Your personalized content will appear here.' }}</p>
            </div>
        </div>
    @endif
</x-layouts.app>
