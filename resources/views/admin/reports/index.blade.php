<x-layouts.app :title="__('Reports & Analytics')">
    <div class="p-6 space-y-6">
        <!-- Header -->
        <header class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Reports & Analytics</h1>
                <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">Comprehensive business insights and performance metrics</p>
            </div>
            
            <!-- Period Filter -->
            <div class="flex gap-3">
                <form method="GET" action="{{ route('admin.reports.index') }}" class="flex gap-2">
                    <select name="period" 
                        class="rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500"
                        onchange="this.form.submit()">
                        <option value="day" {{ $selected_period === 'day' ? 'selected' : '' }}>Daily</option>
                        <option value="week" {{ $selected_period === 'week' ? 'selected' : '' }}>Weekly</option>
                        <option value="month" {{ $selected_period === 'month' ? 'selected' : '' }}>Monthly</option>
                        <option value="year" {{ $selected_period === 'year' ? 'selected' : '' }}>Yearly</option>
                    </select>
                    
                    <select name="periods" 
                        class="rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500"
                        onchange="this.form.submit()">
                        <option value="6" {{ $selected_periods == 6 ? 'selected' : '' }}>Last 6</option>
                        <option value="12" {{ $selected_periods == 12 ? 'selected' : '' }}>Last 12</option>
                        <option value="24" {{ $selected_periods == 24 ? 'selected' : '' }}>Last 24</option>
                    </select>
                </form>
            </div>
        </header>

        <!-- Summary Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Orders Card -->
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Total Orders</p>
                        <p class="mt-2 text-3xl font-semibold text-zinc-900 dark:text-white">{{ number_format($summary['orders']['total']) }}</p>
                        <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">
                            {{ $summary['orders']['this_month'] }} this month
                        </p>
                    </div>
                    <div class="p-3 bg-blue-100 dark:bg-blue-900/30 rounded-full">
                        <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </div>
                </div>
                <div class="mt-4 flex justify-between text-xs">
                    <span class="text-yellow-600 dark:text-yellow-400">{{ $summary['orders']['pending'] }} pending</span>
                    <span class="text-green-600 dark:text-green-400">{{ $summary['orders']['completed'] }} completed</span>
                </div>
            </div>

            <!-- Revenue Card -->
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Total Revenue</p>
                        <p class="mt-2 text-3xl font-semibold text-zinc-900 dark:text-white">GHS {{ number_format($summary['revenue']['total'], 2) }}</p>
                        <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">
                            GHS {{ number_format($summary['revenue']['this_month'], 2) }} this month
                        </p>
                    </div>
                    <div class="p-3 bg-green-100 dark:bg-green-900/30 rounded-full">
                        <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="mt-4 text-xs text-zinc-600 dark:text-zinc-400">
                    YTD: GHS {{ number_format($summary['revenue']['this_year'], 2) }}
                </div>
            </div>

            <!-- Projects Card -->
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Projects</p>
                        <p class="mt-2 text-3xl font-semibold text-zinc-900 dark:text-white">{{ number_format($summary['projects']['total']) }}</p>
                        <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">
                            {{ $summary['projects']['active'] }} active
                        </p>
                    </div>
                    <div class="p-3 bg-purple-100 dark:bg-purple-900/30 rounded-full">
                        <svg class="w-8 h-8 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                </div>
                <div class="mt-4 flex justify-between text-xs">
                    <span class="text-green-600 dark:text-green-400">{{ $summary['projects']['completed'] }} completed</span>
                    <span class="text-orange-600 dark:text-orange-400">{{ $summary['projects']['on_hold'] }} on hold</span>
                </div>
            </div>

            <!-- Invoices Card -->
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Invoices</p>
                        <p class="mt-2 text-3xl font-semibold text-zinc-900 dark:text-white">{{ number_format($summary['invoices']['total']) }}</p>
                        <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">
                            {{ $summary['invoices']['paid'] }} paid
                        </p>
                    </div>
                    <div class="p-3 bg-amber-100 dark:bg-amber-900/30 rounded-full">
                        <svg class="w-8 h-8 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                </div>
                <div class="mt-4 flex justify-between text-xs">
                    <span class="text-red-600 dark:text-red-400">{{ $summary['invoices']['overdue'] }} overdue</span>
                    <span class="text-zinc-600 dark:text-zinc-400">GHS {{ number_format($summary['invoices']['outstanding'], 2) }} due</span>
                </div>
            </div>
        </div>

        <!-- Revenue & Orders Charts -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Revenue Trend -->
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Revenue Trend</h3>
                <canvas id="revenueChart" height="300"></canvas>
            </div>

            <!-- Order Status Distribution -->
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Order Status Distribution</h3>
                <canvas id="orderStatusChart" height="300"></canvas>
            </div>
        </div>

        <!-- Project & Invoice Analytics -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Project Metrics -->
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Project Metrics</h3>
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <p class="text-sm text-zinc-600 dark:text-zinc-400">Completion Rate</p>
                        <p class="text-2xl font-bold text-green-600">{{ $projects['completion_rate'] }}%</p>
                    </div>
                    <div>
                        <p class="text-sm text-zinc-600 dark:text-zinc-400">Avg Duration</p>
                        <p class="text-2xl font-bold text-blue-600">{{ $projects['avg_duration_days'] }} days</p>
                    </div>
                </div>
                <canvas id="projectStatusChart" height="200"></canvas>
            </div>

            <!-- Invoice Analytics -->
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Invoice Analytics</h3>
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <p class="text-sm text-zinc-600 dark:text-zinc-400">Collection Rate</p>
                        <p class="text-2xl font-bold text-green-600">{{ $invoices['collection_rate'] }}%</p>
                    </div>
                    <div>
                        <p class="text-sm text-zinc-600 dark:text-zinc-400">Outstanding</p>
                        <p class="text-2xl font-bold text-amber-600">GHS {{ number_format($invoices['total_outstanding'], 2) }}</p>
                    </div>
                </div>
                <canvas id="invoiceStatusChart" height="200"></canvas>
            </div>
        </div>

        <!-- Form Submissions & Top Performers -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Form Submissions -->
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Form Submissions (Last 30 Days)</h3>
                <canvas id="formSubmissionsChart" height="250"></canvas>
            </div>

            <!-- Top Services -->
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Top Services by Revenue</h3>
                <div class="space-y-3">
                    @forelse($top_services as $service)
                        <div class="flex items-center justify-between p-3 bg-zinc-50 dark:bg-zinc-700/50 rounded-lg">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-900 dark:text-white">{{ $service['service_name'] }}</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">{{ $service['times_ordered'] }} orders • {{ $service['total_quantity'] }} units</p>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-green-600 dark:text-green-400">GHS {{ number_format($service['total_revenue'], 2) }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-zinc-500 dark:text-zinc-400">No service data available</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Top Customers -->
        <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Top Customers by Revenue</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                    <thead class="bg-zinc-50 dark:bg-zinc-900">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Orders</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Total Revenue</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-zinc-800 divide-y divide-zinc-200 dark:divide-zinc-700">
                        @forelse($top_customers as $customer)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-zinc-900 dark:text-white">
                                    {{ $customer['customer_name'] }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-600 dark:text-zinc-400">
                                    {{ $customer['customer_email'] }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-zinc-900 dark:text-white">
                                    {{ $customer['order_count'] }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-semibold text-green-600 dark:text-green-400">
                                    GHS {{ number_format($customer['total_revenue'], 2) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-zinc-500 dark:text-zinc-400">
                                    No customer data available
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        // Chart.js global configuration
        Chart.defaults.color = document.documentElement.classList.contains('dark') ? '#9ca3af' : '#4b5563';
        Chart.defaults.borderColor = document.documentElement.classList.contains('dark') ? '#374151' : '#e5e7eb';

        // Revenue Chart
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: @json($revenue['labels']),
                datasets: [{
                    label: 'Revenue (GHS)',
                    data: @json($revenue['revenue']),
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'GHS ' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });

        // Order Status Distribution
        const orderStatusCtx = document.getElementById('orderStatusChart').getContext('2d');
        new Chart(orderStatusCtx, {
            type: 'doughnut',
            data: {
                labels: @json($order_status['labels']),
                datasets: [{
                    data: @json($order_status['data']),
                    backgroundColor: @json($order_status['colors'])
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right'
                    }
                }
            }
        });

        // Project Status Chart
        const projectStatusCtx = document.getElementById('projectStatusChart').getContext('2d');
        new Chart(projectStatusCtx, {
            type: 'bar',
            data: {
                labels: @json($projects['status_distribution']['labels']),
                datasets: [{
                    label: 'Projects',
                    data: @json($projects['status_distribution']['data']),
                    backgroundColor: ['#eab308', '#3b82f6', '#8b5cf6', '#f97316', '#10b981']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Invoice Status Chart
        const invoiceStatusCtx = document.getElementById('invoiceStatusChart').getContext('2d');
        new Chart(invoiceStatusCtx, {
            type: 'pie',
            data: {
                labels: @json($invoices['status_distribution']['labels']),
                datasets: [{
                    data: @json($invoices['status_distribution']['data']),
                    backgroundColor: ['#6b7280', '#3b82f6', '#10b981', '#f59e0b', '#ef4444']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right'
                    }
                }
            }
        });

        // Form Submissions Chart
        const formSubmissionsCtx = document.getElementById('formSubmissionsChart').getContext('2d');
        new Chart(formSubmissionsCtx, {
            type: 'line',
            data: {
                labels: @json($forms['daily_submissions']['labels']),
                datasets: [{
                    label: 'Submissions',
                    data: @json($forms['daily_submissions']['data']),
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    </script>
    @endpush
</x-layouts.app>
