<x-layouts.app :title="$subscription->service->title . ' - Subscription Details'">
    <div class="p-6">
        <!-- Header -->
        <div class="mb-6 flex items-center justify-between">
            <div>
                <a href="{{ route('customer.subscriptions.index') }}" class="text-sm text-primary-600 hover:text-primary-700 mb-2 inline-flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Back to Subscriptions
                </a>
                <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $subscription->service->title }}</h1>
                <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">Subscription #{{ $subscription->id }}</p>
            </div>
            <div class="flex gap-2">
                @if($subscription->status === 'active' && $daysRemaining <= 60 && $daysRemaining > 0)
                    <a href="{{ route('renewal.index', $subscription) }}" 
                       class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-md transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Renew Subscription
                    </a>
                @endif
                @if($subscription->status === 'active')
                    <a href="{{ route('customer.subscriptions.request-cancellation', $subscription) }}" 
                       class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-md transition-colors">
                        Request Cancellation
                    </a>
                @endif
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-50 dark:bg-green-900/20 border-l-4 border-green-400 p-4 mb-6">
                <p class="text-green-700 dark:text-green-400">{{ session('success') }}</p>
            </div>
        @endif

        <!-- Status Banner -->
        @php
            $statusConfig = [
                'active' => ['bg' => 'bg-green-50 dark:bg-green-900/20', 'border' => 'border-green-400', 'text' => 'text-green-700 dark:text-green-300'],
                'trial' => ['bg' => 'bg-blue-50 dark:bg-blue-900/20', 'border' => 'border-blue-400', 'text' => 'text-blue-700 dark:text-blue-300'],
                'expired' => ['bg' => 'bg-gray-50 dark:bg-gray-900/20', 'border' => 'border-gray-400', 'text' => 'text-gray-700 dark:text-gray-300'],
                'cancelled' => ['bg' => 'bg-red-50 dark:bg-red-900/20', 'border' => 'border-red-400', 'text' => 'text-red-700 dark:text-red-300'],
            ];
            $config = $statusConfig[$subscription->status] ?? $statusConfig['active'];
        @endphp
        
        <div class="{{ $config['bg'] }} border-l-4 {{ $config['border'] }} p-4 mb-6">
            <div class="flex items-center">
                <div class="flex-1">
                    <p class="{{ $config['text'] }} font-medium">
                        Status: {{ ucfirst($subscription->status) }}
                    </p>
                    @if($subscription->status === 'active' && $daysRemaining <= 30 && $daysRemaining > 0)
                        <p class="text-yellow-700 dark:text-yellow-300 text-sm mt-1">
                            ⚠️ This subscription expires in {{ $daysRemaining }} {{ Str::plural('day', $daysRemaining) }}
                        </p>
                    @elseif($subscription->status === 'active')
                        <p class="{{ $config['text'] }} text-sm mt-1">
                            Expires on {{ $subscription->expires_at->format('F d, Y') }} ({{ $daysRemaining }} days from now)
                        </p>
                    @elseif($subscription->status === 'expired')
                        <p class="{{ $config['text'] }} text-sm mt-1">
                            Expired {{ $subscription->expires_at->diffForHumans() }}
                        </p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Metrics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-4">
                <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Billing Amount</div>
                <div class="mt-1 text-2xl font-semibold text-zinc-900 dark:text-white">
                    {!! $currencyService->formatAmount($subscription->billing_amount, $subscription->currency) !!}
                </div>
                <div class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">
                    per {{ str_replace('_', ' ', $subscription->billing_interval) }}
                </div>
            </div>
            
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-4">
                <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Total Paid</div>
                <div class="mt-1 text-2xl font-semibold text-green-600">
                    {!! $currencyService->formatAmount($metrics['total_paid'], $subscription->currency) !!}
                </div>
                <div class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">
                    lifetime value
                </div>
            </div>
            
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-4">
                <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Days Active</div>
                <div class="mt-1 text-2xl font-semibold text-blue-600">{{ $metrics['days_active'] }}</div>
                <div class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">
                    since {{ $subscription->start_date->format('M d, Y') }}
                </div>
            </div>
            
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-4">
                <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400">
                    @if($subscription->status === 'active')
                        Days Remaining
                    @else
                        Days Since Expiry
                    @endif
                </div>
                <div class="mt-1 text-2xl font-semibold {{ $metrics['days_remaining'] < 0 ? 'text-gray-600' : ($metrics['days_remaining'] <= 7 ? 'text-red-600' : 'text-purple-600') }}">
                    {{ abs($metrics['days_remaining']) }}
                </div>
                <div class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">
                    {{ $subscription->expires_at->format('M d, Y') }}
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Subscription Details -->
                <div class="bg-white dark:bg-zinc-800 rounded-lg shadow overflow-hidden">
                    <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700">
                        <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Subscription Details</h2>
                    </div>
                    <div class="p-6">
                        <dl class="grid grid-cols-1 gap-4">
                            <div>
                                <dt class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Service</dt>
                                <dd class="mt-1 text-sm text-zinc-900 dark:text-white">{{ $subscription->service->title }}</dd>
                            </div>
                            
                            <div>
                                <dt class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Original Order</dt>
                                <dd class="mt-1 text-sm">
                                    <a href="{{ route('customer.orders.show', $subscription->order) }}" 
                                       class="text-primary-600 hover:text-primary-700">
                                        Order #{{ $subscription->order->order_number }}
                                    </a>
                                </dd>
                            </div>
                            
                            <div>
                                <dt class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Order Items</dt>
                                <dd class="mt-1 text-sm text-zinc-900 dark:text-white">
                                    <ul class="list-disc list-inside space-y-1">
                                        @foreach($subscription->order->items as $item)
                                            <li>{{ $item->name }} ({{ $item->quantity }}x)</li>
                                        @endforeach
                                    </ul>
                                </dd>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <dt class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Start Date</dt>
                                    <dd class="mt-1 text-sm text-zinc-900 dark:text-white">{{ $subscription->start_date->format('M d, Y') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Expiration Date</dt>
                                    <dd class="mt-1 text-sm {{ $daysRemaining <= 7 && $daysRemaining > 0 ? 'text-red-600 font-medium' : 'text-zinc-900 dark:text-white' }}">
                                        {{ $subscription->expires_at->format('M d, Y') }}
                                    </dd>
                                </div>
                            </div>
                            
                            @if($subscription->cancelled_at)
                                <div>
                                    <dt class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Cancelled On</dt>
                                    <dd class="mt-1 text-sm text-zinc-900 dark:text-white">{{ $subscription->cancelled_at->format('M d, Y') }}</dd>
                                </div>
                            @endif
                            
                            @if($subscription->cancellation_reason)
                                <div>
                                    <dt class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Cancellation Reason</dt>
                                    <dd class="mt-1 text-sm text-zinc-900 dark:text-white">{{ $subscription->cancellation_reason }}</dd>
                                </div>
                            @endif
                        </dl>
                    </div>
                </div>

                <!-- Auto-Renewal Settings -->
                @if($subscription->status === 'active')
                    <div class="bg-white dark:bg-zinc-800 rounded-lg shadow overflow-hidden">
                        <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700">
                            <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Auto-Renewal Settings</h2>
                        </div>
                        <div class="p-6">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h3 class="text-sm font-medium text-zinc-900 dark:text-white">Automatic Renewal</h3>
                                    <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                                        @if($subscription->auto_renew)
                                            Your subscription will automatically renew on {{ $subscription->expires_at->format('F d, Y') }}.
                                            We'll charge your payment method and extend your subscription for another {{ str_replace('_', ' ', $subscription->billing_interval) }}.
                                        @else
                                            Automatic renewal is currently disabled. Your subscription will expire on {{ $subscription->expires_at->format('F d, Y') }} unless you manually renew it.
                                        @endif
                                    </p>
                                </div>
                                <form method="POST" action="{{ route('customer.subscriptions.toggle-auto-renewal', $subscription) }}" class="ml-4">
                                    @csrf
                                    <button type="submit" 
                                            class="inline-flex items-center px-4 py-2 {{ $subscription->auto_renew ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700' }} text-white font-medium rounded-md transition-colors">
                                        {{ $subscription->auto_renew ? 'Disable' : 'Enable' }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Timeline -->
                <div class="bg-white dark:bg-zinc-800 rounded-lg shadow overflow-hidden">
                    <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700">
                        <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Timeline</h2>
                    </div>
                    <div class="p-6">
                        <div class="flow-root">
                            <ul class="-mb-8">
                                @foreach($timeline as $index => $event)
                                    <li>
                                        <div class="relative pb-8">
                                            @if($index < count($timeline) - 1)
                                                <span class="absolute top-4 left-4 -ml-px h-full w-0.5 {{ $event['future'] ? 'bg-zinc-200 dark:bg-zinc-700' : 'bg-primary-200 dark:bg-primary-800' }}" aria-hidden="true"></span>
                                            @endif
                                            <div class="relative flex space-x-3">
                                                <div>
                                                    @php
                                                        $iconColors = [
                                                            'started' => 'bg-green-500',
                                                            'renewed' => 'bg-blue-500',
                                                            'expiring' => 'bg-yellow-500',
                                                            'auto-renewal' => 'bg-purple-500',
                                                            'cancelled' => 'bg-red-500',
                                                            'expired' => 'bg-gray-500',
                                                        ];
                                                        $iconColor = $iconColors[$event['type']] ?? 'bg-zinc-500';
                                                        
                                                        if ($event['future']) {
                                                            $iconColor = 'bg-zinc-300 dark:bg-zinc-600';
                                                        }
                                                    @endphp
                                                    <span class="h-8 w-8 rounded-full {{ $iconColor }} flex items-center justify-center ring-8 ring-white dark:ring-zinc-800">
                                                        @if($event['type'] === 'started')
                                                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                            </svg>
                                                        @elseif($event['type'] === 'renewed')
                                                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"/>
                                                            </svg>
                                                        @elseif($event['type'] === 'expiring' || $event['type'] === 'expired')
                                                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                                            </svg>
                                                        @elseif($event['type'] === 'cancelled')
                                                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293z" clip-rule="evenodd"/>
                                                            </svg>
                                                        @else
                                                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"/>
                                                            </svg>
                                                        @endif
                                                    </span>
                                                </div>
                                                <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                    <div>
                                                        <p class="text-sm {{ $event['future'] ? 'text-zinc-500 dark:text-zinc-400' : 'text-zinc-900 dark:text-white' }}">
                                                            {{ $event['description'] }}
                                                        </p>
                                                    </div>
                                                    <div class="text-right text-sm whitespace-nowrap {{ $event['future'] ? 'text-zinc-400 dark:text-zinc-500' : 'text-zinc-500 dark:text-zinc-400' }}">
                                                        <time datetime="{{ $event['date']->toIso8601String() }}">
                                                            {{ $event['date']->format('M d, Y') }}
                                                        </time>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Quick Actions -->
                <div class="bg-white dark:bg-zinc-800 rounded-lg shadow overflow-hidden">
                    <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700">
                        <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Quick Actions</h2>
                    </div>
                    <div class="p-6 space-y-3">
                        @if($subscription->status === 'active' && $daysRemaining <= 60 && $daysRemaining > 0)
                            <a href="{{ route('renewal.index', $subscription) }}" 
                               class="w-full flex items-center justify-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-md transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                Renew Now
                            </a>
                        @endif
                        
                        <a href="{{ route('customer.orders.show', $subscription->order) }}" 
                           class="w-full flex items-center justify-center px-4 py-2 bg-zinc-600 hover:bg-zinc-700 text-white font-medium rounded-md transition-colors">
                            View Original Order
                        </a>
                        
                        @if($subscription->status === 'active')
                            <a href="{{ route('customer.subscriptions.request-cancellation', $subscription) }}" 
                               class="w-full flex items-center justify-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-md transition-colors">
                                Request Cancellation
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Support -->
                <div class="bg-primary-50 dark:bg-primary-900/20 rounded-lg shadow p-6">
                    <h3 class="text-sm font-medium text-primary-900 dark:text-primary-100">Need Help?</h3>
                    <p class="mt-2 text-sm text-primary-700 dark:text-primary-300">
                        Have questions about your subscription? Our support team is here to help.
                    </p>
                    <a href="#" class="mt-4 inline-flex items-center text-sm font-medium text-primary-600 hover:text-primary-700 dark:text-primary-400">
                        Contact Support
                        <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
