@extends('layouts.admin')

@section('title', 'Subscription Analytics')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-zinc-900 dark:text-white">Subscription Analytics</h1>
            <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">
                Comprehensive insights into subscription performance and revenue
            </p>
        </div>
        <div class="flex items-center gap-4">
            <!-- Date Range Filter -->
            <form method="GET" class="flex items-center gap-2">
                <label for="range" class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Time Range:</label>
                <select name="range" id="range" onchange="this.form.submit()" 
                        class="rounded-lg border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white focus:border-primary-500 focus:ring-primary-500">
                    <option value="7" {{ $dateRange == '7' ? 'selected' : '' }}>Last 7 Days</option>
                    <option value="30" {{ $dateRange == '30' ? 'selected' : '' }}>Last 30 Days</option>
                    <option value="60" {{ $dateRange == '60' ? 'selected' : '' }}>Last 60 Days</option>
                    <option value="90" {{ $dateRange == '90' ? 'selected' : '' }}>Last 90 Days</option>
                    <option value="365" {{ $dateRange == '365' ? 'selected' : '' }}>Last Year</option>
                </select>
            </form>

            <!-- Export Button -->
            <a href="{{ route('admin.subscriptions.analytics.export', ['range' => $dateRange]) }}" 
               class="inline-flex items-center px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Export CSV
            </a>
        </div>
    </div>

    <!-- Overview Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Subscriptions -->
        <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>
            <h3 class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Total Subscriptions</h3>
            <p class="text-3xl font-bold text-zinc-900 dark:text-white mt-2">{{ number_format($analytics['overview']['total']) }}</p>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-2">
                <span class="text-green-600 dark:text-green-400">{{ $analytics['overview']['active'] }}</span> active
            </p>
        </div>

        <!-- Active Subscriptions -->
        <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <h3 class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Active Rate</h3>
            <p class="text-3xl font-bold text-zinc-900 dark:text-white mt-2">{{ $analytics['overview']['active_percentage'] }}%</p>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-2">
                {{ number_format($analytics['overview']['active']) }} of {{ number_format($analytics['overview']['total']) }}
            </p>
        </div>

        <!-- Expiring Soon -->
        <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900/30 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <h3 class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Expiring Soon</h3>
            <p class="text-3xl font-bold text-zinc-900 dark:text-white mt-2">{{ number_format($analytics['overview']['expiring_soon']) }}</p>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-2">
                Next 30 days
            </p>
        </div>

        <!-- New This Month -->
        <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
            </div>
            <h3 class="text-sm font-medium text-zinc-600 dark:text-zinc-400">New This Month</h3>
            <p class="text-3xl font-bold text-zinc-900 dark:text-white mt-2">{{ number_format($analytics['overview']['new_this_month']) }}</p>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-2">
                {{ now()->format('F Y') }}
            </p>
        </div>
    </div>

    <!-- Revenue Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- MRR -->
        <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-lg border border-emerald-600 p-6 text-white">
            <h3 class="text-sm font-medium opacity-90">Monthly Recurring Revenue</h3>
            <p class="text-3xl font-bold mt-2">${{ number_format($analytics['revenue']['mrr'], 2) }}</p>
            <p class="text-sm opacity-75 mt-2">MRR</p>
        </div>

        <!-- ARR -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg border border-blue-600 p-6 text-white">
            <h3 class="text-sm font-medium opacity-90">Annual Recurring Revenue</h3>
            <p class="text-3xl font-bold mt-2">${{ number_format($analytics['revenue']['arr'], 2) }}</p>
            <p class="text-sm opacity-75 mt-2">ARR</p>
        </div>

        <!-- Projected Revenue -->
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg border border-purple-600 p-6 text-white">
            <h3 class="text-sm font-medium opacity-90">Projected Revenue</h3>
            <p class="text-3xl font-bold mt-2">${{ number_format($analytics['revenue']['projected_revenue'], 2) }}</p>
            <p class="text-sm opacity-75 mt-2">Next 90 days</p>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Growth Trends Chart -->
        <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 p-6">
            <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Growth Trends</h3>
            <canvas id="growthChart"></canvas>
        </div>

        <!-- Status Distribution Chart -->
        <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 p-6">
            <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Status Distribution</h3>
            <canvas id="statusChart"></canvas>
        </div>
    </div>

    <!-- Expiration Timeline Chart -->
    <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 p-6 mb-8">
        <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Expiration Timeline (Next 90 Days)</h3>
        <canvas id="expirationChart"></canvas>
    </div>

    <!-- Renewal Metrics & Customer Insights -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Renewal Metrics -->
        <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 p-6">
            <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Renewal Metrics</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-zinc-600 dark:text-zinc-400">Renewal Rate</span>
                    <span class="text-lg font-semibold text-zinc-900 dark:text-white">{{ $analytics['renewal']['renewal_rate'] }}%</span>
                </div>
                <div class="w-full bg-zinc-200 dark:bg-zinc-700 rounded-full h-2">
                    <div class="bg-green-500 h-2 rounded-full" style="width: {{ $analytics['renewal']['renewal_rate'] }}%"></div>
                </div>
                
                <div class="grid grid-cols-2 gap-4 mt-6">
                    <div>
                        <p class="text-sm text-zinc-600 dark:text-zinc-400">Renewals</p>
                        <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ number_format($analytics['renewal']['renewals']) }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-zinc-600 dark:text-zinc-400">Cancellations</p>
                        <p class="text-2xl font-bold text-red-600 dark:text-red-400">{{ number_format($analytics['renewal']['cancellations']) }}</p>
                    </div>
                </div>

                <div class="mt-4 pt-4 border-t border-zinc-200 dark:border-zinc-700">
                    <p class="text-sm text-zinc-600 dark:text-zinc-400">Avg. Renewal Timing</p>
                    <p class="text-lg font-semibold text-zinc-900 dark:text-white">{{ $analytics['renewal']['avg_renewal_timing'] }} days before expiration</p>
                </div>
            </div>
        </div>

        <!-- Customer Insights -->
        <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 p-6">
            <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Customer Insights</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-zinc-600 dark:text-zinc-400">Customers with Subscriptions</span>
                    <span class="text-lg font-semibold text-zinc-900 dark:text-white">{{ number_format($analytics['customer']['customers_with_subscriptions']) }}</span>
                </div>
                
                <div class="flex items-center justify-between">
                    <span class="text-sm text-zinc-600 dark:text-zinc-400">Total Customers</span>
                    <span class="text-lg font-semibold text-zinc-900 dark:text-white">{{ number_format($analytics['customer']['total_customers']) }}</span>
                </div>

                <div class="flex items-center justify-between">
                    <span class="text-sm text-zinc-600 dark:text-zinc-400">Avg. Subscriptions per Customer</span>
                    <span class="text-lg font-semibold text-zinc-900 dark:text-white">{{ $analytics['customer']['avg_subscriptions_per_customer'] }}</span>
                </div>

                <div class="mt-6 pt-4 border-t border-zinc-200 dark:border-zinc-700">
                    <p class="text-sm text-zinc-600 dark:text-zinc-400">Churn Rate (30 days)</p>
                    <div class="flex items-center gap-3 mt-2">
                        <p class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $analytics['customer']['churn_rate'] }}%</p>
                        @if($analytics['customer']['churn_rate'] < 5)
                            <span class="px-2 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-xs rounded-full">Excellent</span>
                        @elseif($analytics['customer']['churn_rate'] < 10)
                            <span class="px-2 py-1 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400 text-xs rounded-full">Good</span>
                        @else
                            <span class="px-2 py-1 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 text-xs rounded-full">Needs Attention</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Services -->
    <div class="bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700 p-6">
        <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Top Services by Subscriptions</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                <thead>
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Service</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Active Subscriptions</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Percentage</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    @php $totalSubs = array_sum(array_column($analytics['top_services'], 'subscription_count')); @endphp
                    @foreach($analytics['top_services'] as $service)
                        <tr>
                            <td class="px-4 py-3 text-sm font-medium text-zinc-900 dark:text-white">{{ $service['name'] }}</td>
                            <td class="px-4 py-3 text-sm text-right text-zinc-600 dark:text-zinc-400">{{ number_format($service['subscription_count']) }}</td>
                            <td class="px-4 py-3 text-sm text-right text-zinc-600 dark:text-zinc-400">
                                {{ $totalSubs > 0 ? round(($service['subscription_count'] / $totalSubs) * 100, 1) : 0 }}%
                            </td>
                        </tr>
                    @endforeach
                    @if(count($analytics['top_services']) === 0)
                        <tr>
                            <td colspan="3" class="px-4 py-6 text-center text-sm text-zinc-500 dark:text-zinc-400">
                                No services found
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Growth Trends Chart
    const growthCtx = document.getElementById('growthChart').getContext('2d');
    new Chart(growthCtx, {
        type: 'line',
        data: {
            labels: @json(array_column($analytics['growth_trends'], 'month')),
            datasets: [{
                label: 'New Subscriptions',
                data: @json(array_column($analytics['growth_trends'], 'new')),
                borderColor: 'rgb(34, 197, 94)',
                backgroundColor: 'rgba(34, 197, 94, 0.1)',
                tension: 0.4
            }, {
                label: 'Cancelled',
                data: @json(array_column($analytics['growth_trends'], 'cancelled')),
                borderColor: 'rgb(239, 68, 68)',
                backgroundColor: 'rgba(239, 68, 68, 0.1)',
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });

    // Status Distribution Chart
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    const statusData = @json($analytics['status_distribution']);
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: Object.keys(statusData).map(s => s.charAt(0).toUpperCase() + s.slice(1)),
            datasets: [{
                data: Object.values(statusData),
                backgroundColor: [
                    'rgb(34, 197, 94)',
                    'rgb(59, 130, 246)',
                    'rgb(234, 179, 8)',
                    'rgb(239, 68, 68)',
                    'rgb(168, 85, 247)'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Expiration Timeline Chart
    const expirationCtx = document.getElementById('expirationChart').getContext('2d');
    new Chart(expirationCtx, {
        type: 'bar',
        data: {
            labels: @json(array_column($analytics['expiration_timeline'], 'label')),
            datasets: [{
                label: 'Subscriptions Expiring',
                data: @json(array_column($analytics['expiration_timeline'], 'count')),
                backgroundColor: 'rgb(249, 115, 22)',
                borderColor: 'rgb(249, 115, 22)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });
</script>
@endpush
@endsection
