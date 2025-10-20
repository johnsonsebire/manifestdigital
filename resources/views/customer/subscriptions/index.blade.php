<x-layouts.app :title="__('My Subscriptions')">
    <div class="p-6">
        <header class="mb-6">
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">My Subscriptions</h1>
            <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">Manage your active subscriptions and renewals</p>
        </header>

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

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-4">
                <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Active Subscriptions</div>
                <div class="mt-1 text-2xl font-semibold text-green-600">{{ $metrics['total_active'] }}</div>
            </div>
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-4">
                <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Expiring Soon</div>
                <div class="mt-1 text-2xl font-semibold text-yellow-600">{{ $metrics['expiring_soon'] }}</div>
            </div>
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-4">
                <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Monthly Cost</div>
                <div class="mt-1 text-2xl font-semibold text-blue-600">{!! $currencyService->formatAmount($metrics['monthly_cost'], $userCurrency->code) !!}</div>
            </div>
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-4">
                <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Yearly Cost</div>
                <div class="mt-1 text-2xl font-semibold text-purple-600">{!! $currencyService->formatAmount($metrics['yearly_cost'], $userCurrency->code) !!}</div>
            </div>
        </div>

        <!-- Active Subscriptions -->
        @if($activeSubscriptions->count() > 0)
            <div class="mb-8">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Active Subscriptions</h2>
                <div class="space-y-4">
                    @foreach($activeSubscriptions as $subscription)
                        <div class="bg-white dark:bg-zinc-800 rounded-lg shadow overflow-hidden hover:shadow-md transition-shadow">
                            <div class="p-6">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-3 mb-2">
                                            <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">
                                                {{ $subscription->service->title }}
                                            </h3>
                                            @php
                                                $statusColors = [
                                                    'active' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
                                                    'trial' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300',
                                                ];
                                            @endphp
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$subscription->status] ?? 'bg-zinc-100 text-zinc-800' }}">
                                                {{ ucfirst($subscription->status) }}
                                            </span>
                                            @php
                                                $daysRemaining = now()->diffInDays($subscription->expires_at, false);
                                            @endphp
                                            @if($daysRemaining <= 30 && $daysRemaining > 0)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                                    </svg>
                                                    {{ $daysRemaining }} days left
                                                </span>
                                            @endif
                                        </div>
                                        
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                                            <div>
                                                <div class="text-xs text-zinc-500 dark:text-zinc-400">Billing Amount</div>
                                                <div class="text-sm font-medium text-zinc-900 dark:text-white">
                                                    {!! $currencyService->formatAmount($subscription->billing_amount, $subscription->currency) !!}
                                                    <span class="text-xs text-zinc-500">/ {{ str_replace('_', ' ', $subscription->billing_interval) }}</span>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="text-xs text-zinc-500 dark:text-zinc-400">Expires On</div>
                                                <div class="text-sm font-medium {{ $daysRemaining <= 7 ? 'text-red-600' : 'text-zinc-900 dark:text-white' }}">
                                                    {{ $subscription->expires_at->format('M d, Y') }}
                                                </div>
                                            </div>
                                            <div>
                                                <div class="text-xs text-zinc-500 dark:text-zinc-400">Auto-Renewal</div>
                                                <div class="text-sm font-medium">
                                                    @if($subscription->auto_renew)
                                                        <span class="text-green-600 dark:text-green-400 flex items-center">
                                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                            </svg>
                                                            Enabled
                                                        </span>
                                                    @else
                                                        <span class="text-gray-600 dark:text-gray-400 flex items-center">
                                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293z" clip-rule="evenodd"/>
                                                            </svg>
                                                            Disabled
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4 flex flex-wrap gap-2">
                                    <a href="{{ route('customer.subscriptions.show', $subscription) }}" 
                                       class="inline-flex items-center px-3 py-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-md transition-colors">
                                        View Details
                                    </a>
                                    
                                    @if($daysRemaining <= 60 && $daysRemaining > 0)
                                        <a href="{{ route('renewal.index', $subscription) }}" 
                                           class="inline-flex items-center px-3 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-md transition-colors">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                            </svg>
                                            Renew Now
                                        </a>
                                    @endif
                                    
                                    <form method="POST" action="{{ route('customer.subscriptions.toggle-auto-renewal', $subscription) }}" class="inline">
                                        @csrf
                                        <button type="submit" 
                                                class="inline-flex items-center px-3 py-2 bg-zinc-600 hover:bg-zinc-700 text-white text-sm font-medium rounded-md transition-colors">
                                            {{ $subscription->auto_renew ? 'Disable' : 'Enable' }} Auto-Renewal
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-8 text-center mb-8">
                <svg class="mx-auto h-12 w-12 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-zinc-900 dark:text-white">No Active Subscriptions</h3>
                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">You don't have any active subscriptions at the moment.</p>
                <div class="mt-6">
                    <a href="{{ route('services') }}" class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-md transition-colors">
                        Browse Services
                    </a>
                </div>
            </div>
        @endif

        <!-- Expiring Soon Section -->
        @if($expiringSoon->count() > 0)
            <div class="bg-yellow-50 dark:bg-yellow-900/20 border-l-4 border-yellow-400 p-4 mb-8">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-yellow-800 dark:text-yellow-200">
                            {{ $expiringSoon->count() }} {{ Str::plural('subscription', $expiringSoon->count()) }} expiring within 30 days
                        </h3>
                        <div class="mt-2 text-sm text-yellow-700 dark:text-yellow-300">
                            <p>Don't let your services expire! Renew now to continue enjoying uninterrupted access.</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Expired Subscriptions -->
        @if($expiredSubscriptions->count() > 0)
            <div class="mb-8">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Expired Subscriptions</h2>
                <div class="space-y-4">
                    @foreach($expiredSubscriptions as $subscription)
                        <div class="bg-white dark:bg-zinc-800 rounded-lg shadow overflow-hidden opacity-75">
                            <div class="p-6">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-3 mb-2">
                                            <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">
                                                {{ $subscription->service->title }}
                                            </h3>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-300">
                                                Expired
                                            </span>
                                        </div>
                                        
                                        <p class="text-sm text-zinc-600 dark:text-zinc-400">
                                            Expired on {{ $subscription->expires_at->format('F d, Y') }}
                                            ({{ $subscription->expires_at->diffForHumans() }})
                                        </p>
                                    </div>
                                </div>

                                <div class="mt-4 flex gap-2">
                                    <a href="{{ route('customer.subscriptions.show', $subscription) }}" 
                                       class="inline-flex items-center px-3 py-2 bg-zinc-600 hover:bg-zinc-700 text-white text-sm font-medium rounded-md transition-colors">
                                        View Details
                                    </a>
                                    <a href="{{ route('renewal.index', $subscription) }}" 
                                       class="inline-flex items-center px-3 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-md transition-colors">
                                        Reactivate
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Cancelled Subscriptions -->
        @if($cancelledSubscriptions->count() > 0)
            <div>
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Cancelled Subscriptions</h2>
                <div class="space-y-4">
                    @foreach($cancelledSubscriptions as $subscription)
                        <div class="bg-white dark:bg-zinc-800 rounded-lg shadow overflow-hidden opacity-60">
                            <div class="p-6">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-3 mb-2">
                                            <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">
                                                {{ $subscription->service->title }}
                                            </h3>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300">
                                                Cancelled
                                            </span>
                                        </div>
                                        
                                        <p class="text-sm text-zinc-600 dark:text-zinc-400">
                                            Cancelled on {{ $subscription->cancelled_at->format('F d, Y') }}
                                        </p>
                                        
                                        @if($subscription->cancellation_reason)
                                            <p class="text-sm text-zinc-500 dark:text-zinc-500 mt-2 italic">
                                                "{{ Str::limit($subscription->cancellation_reason, 100) }}"
                                            </p>
                                        @endif
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <a href="{{ route('customer.subscriptions.show', $subscription) }}" 
                                       class="inline-flex items-center px-3 py-2 bg-zinc-600 hover:bg-zinc-700 text-white text-sm font-medium rounded-md transition-colors">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-layouts.app>
