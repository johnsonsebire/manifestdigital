<x-layouts.app :title="'Subscription Details'">
    <div class="p-6">
        <!-- Header -->
        <div class="flex justify-between items-start mb-6">
            <div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.subscriptions.index') }}" class="text-zinc-500 hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                    </a>
                    <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Subscription Details</h1>
                    @php
                        $statusColors = [
                            'active' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                            'trial' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
                            'expired' => 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400',
                            'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
                            'suspended' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
                        ];
                        $statusColor = $statusColors[$subscription->status] ?? 'bg-zinc-100 text-zinc-800';
                    @endphp
                    <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $statusColor }}">
                        {{ ucfirst($subscription->status) }}
                    </span>
                </div>
                <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">
                    Subscription ID: <code class="font-mono bg-zinc-100 dark:bg-zinc-800 px-2 py-1 rounded">{{ $subscription->uuid }}</code>
                </p>
            </div>
            <div class="flex gap-2">
                @if(in_array($subscription->status, ['active', 'expired']))
                    <a href="{{ route('admin.subscriptions.renew', $subscription) }}" 
                       class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Renew Subscription
                    </a>
                @endif
                @if(in_array($subscription->status, ['active', 'trial']))
                    <a href="{{ route('admin.subscriptions.cancel', $subscription) }}" 
                       class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Cancel Subscription
                    </a>
                @endif
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-50 dark:bg-green-900/20 border-l-4 border-green-400 p-4 mb-6">
                <p class="text-green-700 dark:text-green-400">{{ session('success') }}</p>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 dark:bg-red-900/20 border-l-4 border-red-400 p-4 mb-6">
                <p class="text-red-700 dark:text-red-400">{{ session('error') }}</p>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Overview Card -->
                <div class="bg-white dark:bg-zinc-800 shadow rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Subscription Overview</h2>
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400 mb-1">Service</div>
                            <div class="text-base text-zinc-900 dark:text-white">{{ $subscription->service->title ?? 'N/A' }}</div>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400 mb-1">Customer</div>
                            <div class="text-base text-zinc-900 dark:text-white">{{ $subscription->customer->name ?? 'N/A' }}</div>
                            <div class="text-sm text-zinc-500 dark:text-zinc-400">{{ $subscription->customer->email ?? 'N/A' }}</div>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400 mb-1">Start Date</div>
                            <div class="text-base text-zinc-900 dark:text-white">{{ $subscription->starts_at->format('M d, Y') }}</div>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400 mb-1">Expiration Date</div>
                            @php
                                $daysRemaining = now()->diffInDays($subscription->expires_at, false);
                                $textColor = $daysRemaining < 0 ? 'text-red-600' 
                                           : ($daysRemaining <= 7 ? 'text-yellow-600' 
                                           : 'text-zinc-900 dark:text-white');
                            @endphp
                            <div class="text-base {{ $textColor }} font-semibold">{{ $subscription->expires_at->format('M d, Y') }}</div>
                            <div class="text-sm text-zinc-500 dark:text-zinc-400">
                                @if($daysRemaining < 0)
                                    Expired {{ abs($daysRemaining) }} days ago
                                @elseif($daysRemaining == 0)
                                    Expires today
                                @else
                                    {{ $daysRemaining }} days remaining
                                @endif
                            </div>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400 mb-1">Billing Amount</div>
                            <div class="text-lg font-bold text-zinc-900 dark:text-white">
                                {!! $currencyService->formatAmount($subscription->billing_amount, $subscription->currency) !!}
                            </div>
                            <div class="text-sm text-zinc-500 dark:text-zinc-400">
                                per {{ str_replace('_', ' ', $subscription->billing_interval) }}
                            </div>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400 mb-1">Next Billing Date</div>
                            <div class="text-base text-zinc-900 dark:text-white">
                                {{ $subscription->next_billing_date?->format('M d, Y') ?? 'N/A' }}
                            </div>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400 mb-1">Auto-Renewal</div>
                            <div class="flex items-center">
                                @if($subscription->auto_renew)
                                    <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-green-600 font-medium">Enabled</span>
                                @else
                                    <svg class="w-5 h-5 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-gray-600 dark:text-gray-400 font-medium">Disabled</span>
                                @endif
                            </div>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400 mb-1">Renewal Count</div>
                            <div class="text-base text-zinc-900 dark:text-white">{{ $subscription->renewal_count ?? 0 }} times</div>
                        </div>
                    </div>

                    @if($subscription->cancellation_reason)
                        <div class="mt-6 pt-6 border-t border-zinc-200 dark:border-zinc-700">
                            <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400 mb-2">Cancellation Reason</div>
                            <div class="text-sm text-zinc-900 dark:text-white bg-red-50 dark:bg-red-900/20 p-3 rounded">
                                {{ $subscription->cancellation_reason }}
                            </div>
                            @if($subscription->cancelled_at)
                                <div class="text-xs text-zinc-500 dark:text-zinc-400 mt-2">
                                    Cancelled on {{ $subscription->cancelled_at->format('M d, Y H:i') }}
                                </div>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Metrics Card -->
                <div class="bg-white dark:bg-zinc-800 shadow rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Subscription Metrics</h2>
                    <div class="grid grid-cols-3 gap-6">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-blue-600">{{ $metrics['days_active'] }}</div>
                            <div class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Days Active</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-green-600">
                                {!! $currencyService->formatAmount($metrics['lifetime_value'], $subscription->currency) !!}
                            </div>
                            <div class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Lifetime Value</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-purple-600">{{ $metrics['renewal_count'] }}</div>
                            <div class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Renewals</div>
                        </div>
                    </div>
                </div>

                <!-- Timeline -->
                <div class="bg-white dark:bg-zinc-800 shadow rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Subscription Timeline</h2>
                    <div class="flow-root">
                        <ul class="-mb-8">
                            @foreach($timeline as $index => $event)
                                <li>
                                    <div class="relative pb-8">
                                        @if(!$loop->last)
                                            <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-zinc-200 dark:bg-zinc-700" aria-hidden="true"></span>
                                        @endif
                                        <div class="relative flex space-x-3">
                                            <div>
                                                @php
                                                    $iconColors = [
                                                        'blue' => 'bg-blue-500',
                                                        'green' => 'bg-green-500',
                                                        'yellow' => 'bg-yellow-500',
                                                        'red' => 'bg-red-500',
                                                        'gray' => 'bg-gray-500',
                                                    ];
                                                    $iconColor = $iconColors[$event['color']] ?? 'bg-zinc-500';
                                                @endphp
                                                <span class="h-8 w-8 rounded-full {{ $iconColor }} flex items-center justify-center ring-8 ring-white dark:ring-zinc-800">
                                                    <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        @if($event['icon'] === 'plus-circle')
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                        @elseif($event['icon'] === 'play-circle')
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                        @elseif($event['icon'] === 'bell')
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                                        @elseif($event['icon'] === 'refresh')
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                                        @elseif($event['icon'] === 'x-circle')
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                        @else
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                        @endif
                                                    </svg>
                                                </span>
                                            </div>
                                            <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                                                <div>
                                                    <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ $event['title'] }}</p>
                                                    <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $event['description'] }}</p>
                                                    @if(isset($event['metadata']))
                                                        <div class="mt-2 text-xs">
                                                            @if(isset($event['metadata']['status']))
                                                                <span class="px-2 py-1 bg-zinc-100 dark:bg-zinc-700 rounded">
                                                                    Status: {{ $event['metadata']['status'] }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="whitespace-nowrap text-right text-sm text-zinc-500 dark:text-zinc-400">
                                                    <time datetime="{{ $event['timestamp']->toIso8601String() }}">
                                                        {{ $event['timestamp']->format('M d, Y') }}
                                                    </time>
                                                    <div class="text-xs">{{ $event['timestamp']->format('H:i') }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Payment History -->
                <div class="bg-white dark:bg-zinc-800 shadow rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Payment History</h2>
                    @if(count($paymentHistory) > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase">Date</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase">Description</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase">Amount</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                                    @foreach($paymentHistory as $payment)
                                        <tr>
                                            <td class="px-4 py-3 text-sm text-zinc-900 dark:text-white">
                                                {{ $payment['date']->format('M d, Y') }}
                                            </td>
                                            <td class="px-4 py-3 text-sm text-zinc-900 dark:text-white">
                                                {{ $payment['description'] }}
                                            </td>
                                            <td class="px-4 py-3 text-sm font-semibold text-zinc-900 dark:text-white">
                                                {!! $currencyService->formatAmount($payment['amount'], $payment['currency']) !!}
                                            </td>
                                            <td class="px-4 py-3 text-sm">
                                                @php
                                                    $statusColor = $payment['status'] === 'paid' ? 'text-green-600' : 'text-yellow-600';
                                                @endphp
                                                <span class="{{ $statusColor }} capitalize">{{ $payment['status'] }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-sm text-zinc-500 dark:text-zinc-400 text-center py-4">No payment history available</p>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Order Information -->
                @if($subscription->order)
                    <div class="bg-white dark:bg-zinc-800 shadow rounded-lg p-6">
                        <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Order Information</h2>
                        <div class="space-y-3">
                            <div>
                                <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Order ID</div>
                                <a href="{{ route('admin.orders.show', $subscription->order) }}" class="text-sm text-primary-600 hover:text-primary-800 dark:text-primary-400">
                                    #{{ $subscription->order->id }}
                                </a>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Order Total</div>
                                <div class="text-sm text-zinc-900 dark:text-white">
                                    {!! $currencyService->formatAmount($subscription->order->total_amount, $subscription->order->currency) !!}
                                </div>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Payment Status</div>
                                <div class="text-sm text-zinc-900 dark:text-white capitalize">
                                    {{ $subscription->order->payment_status }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Reminder History -->
                <div class="bg-white dark:bg-zinc-800 shadow rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Reminder History</h2>
                    @if($subscription->reminderLogs->count() > 0)
                        <div class="space-y-3">
                            @foreach($subscription->reminderLogs->take(10) as $log)
                                <div class="border-l-2 {{ $log->status === 'sent' ? 'border-green-500' : 'border-red-500' }} pl-3">
                                    <div class="text-sm font-medium text-zinc-900 dark:text-white">
                                        {{ ucfirst(str_replace('_', ' ', $log->reminder_type)) }}
                                    </div>
                                    <div class="text-xs text-zinc-500 dark:text-zinc-400">
                                        {{ $log->sent_at->format('M d, Y H:i') }}
                                    </div>
                                    <div class="text-xs">
                                        <span class="{{ $log->status === 'sent' ? 'text-green-600' : 'text-red-600' }}">
                                            {{ ucfirst($log->status) }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-zinc-500 dark:text-zinc-400 text-center py-4">No reminders sent yet</p>
                    @endif
                </div>

                <!-- Quick Actions -->
                <div class="bg-white dark:bg-zinc-800 shadow rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Quick Actions</h2>
                    <div class="space-y-2">
                        <a href="mailto:{{ $subscription->customer->email }}" 
                           class="block w-full px-4 py-2 text-sm font-medium text-center text-zinc-700 dark:text-zinc-300 bg-zinc-100 dark:bg-zinc-700 rounded-lg hover:bg-zinc-200 dark:hover:bg-zinc-600">
                            Email Customer
                        </a>
                        <a href="{{ route('admin.customers.show', $subscription->customer) }}" 
                           class="block w-full px-4 py-2 text-sm font-medium text-center text-zinc-700 dark:text-zinc-300 bg-zinc-100 dark:bg-zinc-700 rounded-lg hover:bg-zinc-200 dark:hover:bg-zinc-600">
                            View Customer Profile
                        </a>
                        <a href="{{ route('admin.services.show', $subscription->service) }}" 
                           class="block w-full px-4 py-2 text-sm font-medium text-center text-zinc-700 dark:text-zinc-300 bg-zinc-100 dark:bg-zinc-700 rounded-lg hover:bg-zinc-200 dark:hover:bg-zinc-600">
                            View Service Details
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
