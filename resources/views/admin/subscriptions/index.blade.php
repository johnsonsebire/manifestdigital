<x-layouts.app :title="__('Subscription Management')">
    <div class="p-6">
        <header class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Subscription Management</h1>
                <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">Monitor and manage customer subscriptions</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.subscriptions.analytics.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    Analytics
                </a>
                <a href="{{ route('admin.subscriptions.export', request()->query()) }}" 
                   class="inline-flex items-center px-4 py-2 bg-zinc-600 hover:bg-zinc-700 text-white font-medium rounded-lg transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Export CSV
                </a>
            </div>
        </header>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-8 gap-4 mb-6">
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-4">
                <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Total</div>
                <div class="mt-1 text-2xl font-semibold text-zinc-900 dark:text-white">{{ $stats['total'] }}</div>
            </div>
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-4">
                <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Active</div>
                <div class="mt-1 text-2xl font-semibold text-green-600">{{ $stats['active'] }}</div>
            </div>
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-4">
                <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Trial</div>
                <div class="mt-1 text-2xl font-semibold text-blue-600">{{ $stats['trial'] }}</div>
            </div>
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-4">
                <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Expired</div>
                <div class="mt-1 text-2xl font-semibold text-gray-600">{{ $stats['expired'] }}</div>
            </div>
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-4">
                <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Cancelled</div>
                <div class="mt-1 text-2xl font-semibold text-red-600">{{ $stats['cancelled'] }}</div>
            </div>
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-4">
                <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Expiring Soon</div>
                <div class="mt-1 text-2xl font-semibold text-yellow-600">{{ $stats['expiring_soon'] }}</div>
            </div>
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <div class="text-sm text-zinc-600 dark:text-zinc-400">MRR</div>
                        <div class="mt-1 text-xl font-semibold text-emerald-600">{!! $currencyService->formatAmount($stats['total_mrr'] ?? 0, $userCurrency->code) !!}</div>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <div class="text-sm text-zinc-600 dark:text-zinc-400">ARR</div>
                        <div class="mt-1 text-xl font-semibold text-blue-600">{!! $currencyService->formatAmount($stats['total_arr'] ?? 0, $userCurrency->code) !!}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white dark:bg-zinc-800 shadow rounded-lg p-4 mb-6">
            <form method="GET" action="{{ route('admin.subscriptions.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <!-- Search -->
                    <div>
                        <label for="search" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                            Search
                        </label>
                        <input type="text" 
                            name="search" 
                            id="search" 
                            value="{{ request('search') }}"
                            placeholder="Subscription ID, customer..."
                            class="w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500">
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                            Status
                        </label>
                        <select name="status" 
                            id="status"
                            class="w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            <option value="">All Statuses</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="trial" {{ request('status') === 'trial' ? 'selected' : '' }}>Trial</option>
                            <option value="expired" {{ request('status') === 'expired' ? 'selected' : '' }}>Expired</option>
                            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Suspended</option>
                        </select>
                    </div>

                    <!-- Service Filter -->
                    <div>
                        <label for="service_id" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                            Service
                        </label>
                        <select name="service_id" 
                            id="service_id"
                            class="w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            <option value="">All Services</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}" {{ request('service_id') == $service->id ? 'selected' : '' }}>
                                    {{ $service->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Expiring Within -->
                    <div>
                        <label for="expiring_within" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                            Expiring Within
                        </label>
                        <select name="expiring_within" 
                            id="expiring_within"
                            class="w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            <option value="">Any Time</option>
                            <option value="7" {{ request('expiring_within') == '7' ? 'selected' : '' }}>7 Days</option>
                            <option value="15" {{ request('expiring_within') == '15' ? 'selected' : '' }}>15 Days</option>
                            <option value="30" {{ request('expiring_within') == '30' ? 'selected' : '' }}>30 Days</option>
                            <option value="60" {{ request('expiring_within') == '60' ? 'selected' : '' }}>60 Days</option>
                            <option value="90" {{ request('expiring_within') == '90' ? 'selected' : '' }}>90 Days</option>
                        </select>
                    </div>

                    <!-- Auto Renewal -->
                    <div>
                        <label for="auto_renew" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                            Auto-Renewal
                        </label>
                        <select name="auto_renew" 
                            id="auto_renew"
                            class="w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            <option value="">All</option>
                            <option value="1" {{ request('auto_renew') === '1' ? 'selected' : '' }}>Enabled</option>
                            <option value="0" {{ request('auto_renew') === '0' ? 'selected' : '' }}>Disabled</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Start Date -->
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                            Start Date From
                        </label>
                        <input type="date" 
                            name="start_date" 
                            id="start_date" 
                            value="{{ request('start_date') }}"
                            class="w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500">
                    </div>

                    <!-- End Date -->
                    <div>
                        <label for="end_date" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                            Expires Before
                        </label>
                        <input type="date" 
                            name="end_date" 
                            id="end_date" 
                            value="{{ request('end_date') }}"
                            class="w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500">
                    </div>

                    <!-- Sort By -->
                    <div>
                        <label for="sort_by" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                            Sort By
                        </label>
                        <select name="sort_by" 
                            id="sort_by"
                            class="w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            <option value="created_at" {{ request('sort_by') === 'created_at' ? 'selected' : '' }}>Date Created</option>
                            <option value="expires_at" {{ request('sort_by') === 'expires_at' ? 'selected' : '' }}>Expiration Date</option>
                            <option value="billing_amount" {{ request('sort_by') === 'billing_amount' ? 'selected' : '' }}>Billing Amount</option>
                        </select>
                    </div>

                    <!-- Sort Direction -->
                    <div>
                        <label for="sort_direction" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                            Sort Order
                        </label>
                        <select name="sort_direction" 
                            id="sort_direction"
                            class="w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            <option value="desc" {{ request('sort_direction') === 'desc' ? 'selected' : '' }}>Newest First</option>
                            <option value="asc" {{ request('sort_direction') === 'asc' ? 'selected' : '' }}>Oldest First</option>
                        </select>
                    </div>
                </div>

                <div class="flex gap-2">
                    <button type="submit" 
                        class="px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        Apply Filters
                    </button>
                    <a href="{{ route('admin.subscriptions.index') }}" 
                        class="px-4 py-2 bg-zinc-200 dark:bg-zinc-700 text-zinc-700 dark:text-zinc-300 rounded-md hover:bg-zinc-300 dark:hover:bg-zinc-600">
                        Clear
                    </a>
                </div>
            </form>
        </div>

        <!-- Subscriptions Table -->
        <div class="bg-white dark:bg-zinc-800 shadow rounded-lg overflow-hidden">
            @if(session('success'))
                <div class="bg-green-50 dark:bg-green-900/20 border-l-4 border-green-400 p-4">
                    <p class="text-green-700 dark:text-green-400">{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 dark:bg-red-900/20 border-l-4 border-red-400 p-4">
                    <p class="text-red-700 dark:text-red-400">{{ session('error') }}</p>
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                    <thead class="bg-zinc-50 dark:bg-zinc-900">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                <input type="checkbox" id="select-all" class="rounded border-zinc-300 text-primary-600 focus:ring-primary-500">
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                Subscription
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                Customer
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                Service
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                Billing
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                Expiration
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                Auto-Renew
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-zinc-800 divide-y divide-zinc-200 dark:divide-zinc-700">
                        @forelse($subscriptions as $subscription)
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-700/50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="checkbox" name="subscription_ids[]" value="{{ $subscription->id }}" class="subscription-checkbox rounded border-zinc-300 text-primary-600 focus:ring-primary-500">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-zinc-900 dark:text-white">
                                        {{ substr($subscription->uuid, 0, 8) }}...
                                    </div>
                                    <div class="text-sm text-zinc-500 dark:text-zinc-400">
                                        {{ $subscription->created_at->format('M d, Y') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-zinc-900 dark:text-white">
                                        {{ $subscription->customer->name ?? 'N/A' }}
                                    </div>
                                    <div class="text-sm text-zinc-500 dark:text-zinc-400">
                                        {{ $subscription->customer->email ?? 'N/A' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-zinc-900 dark:text-white">
                                        {{ $subscription->service->title ?? 'N/A' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusColors = [
                                            'active' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                                            'trial' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
                                            'expired' => 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400',
                                            'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
                                            'suspended' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
                                        ];
                                        $statusColor = $statusColors[$subscription->status] ?? 'bg-zinc-100 text-zinc-800 dark:bg-zinc-900/30 dark:text-zinc-400';
                                    @endphp
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColor }}">
                                        {{ ucfirst($subscription->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-zinc-900 dark:text-white">
                                        {!! $currencyService->formatAmount($subscription->billing_amount, $subscription->currency) !!}
                                    </div>
                                    <div class="text-sm text-zinc-500 dark:text-zinc-400">
                                        {{ ucfirst(str_replace('_', ' ', $subscription->billing_interval)) }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $daysRemaining = now()->diffInDays($subscription->expires_at, false);
                                        $textColor = $daysRemaining < 0 ? 'text-red-600' 
                                                   : ($daysRemaining <= 7 ? 'text-yellow-600' 
                                                   : ($daysRemaining <= 30 ? 'text-orange-600' 
                                                   : 'text-zinc-600 dark:text-zinc-400'));
                                    @endphp
                                    <div class="text-sm {{ $textColor }}">
                                        {{ $subscription->expires_at->format('M d, Y') }}
                                    </div>
                                    <div class="text-xs text-zinc-500 dark:text-zinc-400">
                                        @if($daysRemaining < 0)
                                            Expired {{ abs($daysRemaining) }} days ago
                                        @elseif($daysRemaining == 0)
                                            Expires today
                                        @else
                                            {{ $daysRemaining }} days remaining
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($subscription->auto_renew)
                                        <svg class="w-5 h-5 text-green-600 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5 text-gray-400 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                        </svg>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('admin.subscriptions.show', $subscription) }}" 
                                           class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300">
                                            View
                                        </a>
                                        @if(in_array($subscription->status, ['active', 'expired']))
                                            <a href="{{ route('admin.subscriptions.renew', $subscription) }}" 
                                               class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300">
                                                Renew
                                            </a>
                                        @endif
                                        @if(in_array($subscription->status, ['active', 'trial']))
                                            <a href="{{ route('admin.subscriptions.cancel', $subscription) }}" 
                                               class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                                Cancel
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-6 py-12 text-center text-sm text-zinc-500 dark:text-zinc-400">
                                    No subscriptions found matching your criteria.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($subscriptions->hasPages())
                <div class="bg-white dark:bg-zinc-800 px-4 py-3 border-t border-zinc-200 dark:border-zinc-700 sm:px-6">
                    {{ $subscriptions->links() }}
                </div>
            @endif
        </div>

        <!-- Bulk Actions -->
        <div id="bulk-actions" class="hidden fixed bottom-0 left-0 right-0 bg-white dark:bg-zinc-800 border-t border-zinc-200 dark:border-zinc-700 shadow-lg p-4">
            <div class="max-w-7xl mx-auto flex items-center justify-between">
                <div class="text-sm text-zinc-600 dark:text-zinc-400">
                    <span id="selected-count">0</span> subscriptions selected
                </div>
                <div class="flex gap-2">
                    <button type="button" onclick="bulkAction('send_reminders')" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Send Reminders
                    </button>
                    <button type="button" onclick="bulkExport()" 
                            class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                        Export Selected
                    </button>
                    <button type="button" onclick="clearSelection()" 
                            class="px-4 py-2 bg-zinc-200 dark:bg-zinc-700 text-zinc-700 dark:text-zinc-300 rounded-md hover:bg-zinc-300 dark:hover:bg-zinc-600">
                        Clear Selection
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Select all checkbox
        document.getElementById('select-all').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.subscription-checkbox');
            checkboxes.forEach(checkbox => checkbox.checked = this.checked);
            updateBulkActions();
        });

        // Individual checkbox
        document.querySelectorAll('.subscription-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', updateBulkActions);
        });

        function updateBulkActions() {
            const checkedBoxes = document.querySelectorAll('.subscription-checkbox:checked');
            const bulkActionsDiv = document.getElementById('bulk-actions');
            const selectedCount = document.getElementById('selected-count');
            
            if (checkedBoxes.length > 0) {
                bulkActionsDiv.classList.remove('hidden');
                selectedCount.textContent = checkedBoxes.length;
            } else {
                bulkActionsDiv.classList.add('hidden');
            }
        }

        function bulkAction(action) {
            const checkedBoxes = document.querySelectorAll('.subscription-checkbox:checked');
            const ids = Array.from(checkedBoxes).map(cb => cb.value);
            
            if (ids.length === 0) {
                alert('Please select subscriptions first');
                return;
            }

            if (confirm(`Are you sure you want to ${action.replace('_', ' ')} for ${ids.length} subscription(s)?`)) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("admin.subscriptions.bulk-action") }}';
                
                // Add CSRF token
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = '{{ csrf_token() }}';
                form.appendChild(csrfInput);
                
                // Add action
                const actionInput = document.createElement('input');
                actionInput.type = 'hidden';
                actionInput.name = 'action';
                actionInput.value = action;
                form.appendChild(actionInput);
                
                // Add subscription IDs
                ids.forEach(id => {
                    const idInput = document.createElement('input');
                    idInput.type = 'hidden';
                    idInput.name = 'subscription_ids[]';
                    idInput.value = id;
                    form.appendChild(idInput);
                });
                
                document.body.appendChild(form);
                form.submit();
            }
        }

        function bulkExport() {
            bulkAction('export');
        }

        function clearSelection() {
            document.querySelectorAll('.subscription-checkbox').forEach(cb => cb.checked = false);
            document.getElementById('select-all').checked = false;
            updateBulkActions();
        }
    </script>
    @endpush
</x-layouts.app>
