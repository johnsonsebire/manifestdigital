<x-layouts.app title="Renewal Successful">
    <div class="p-6 max-w-4xl mx-auto">
        <!-- Success Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 dark:bg-green-900/30 rounded-full mb-4">
                <svg class="w-10 h-10 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-zinc-900 dark:text-white mb-2">Renewal Successful!</h1>
            <p class="text-lg text-zinc-600 dark:text-zinc-400">
                Your subscription has been successfully renewed
            </p>
        </div>

        <!-- Order Details -->
        <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6 mb-6">
            <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Renewal Details</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <div class="text-sm text-zinc-500 dark:text-zinc-400 mb-1">Order Number</div>
                    <div class="text-base font-medium text-zinc-900 dark:text-white">{{ $order->order_number }}</div>
                </div>
                <div>
                    <div class="text-sm text-zinc-500 dark:text-zinc-400 mb-1">Payment Status</div>
                    <div>
                        @php
                            $statusColors = [
                                'paid' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
                                'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300',
                                'unpaid' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                            ];
                        @endphp
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$order->payment_status] ?? 'bg-gray-100 text-gray-800' }}">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </div>
                </div>
                <div>
                    <div class="text-sm text-zinc-500 dark:text-zinc-400 mb-1">Amount Paid</div>
                    <div class="text-base font-medium text-green-600">
                        {{ number_format($order->total, 2) }} {{ $subscription->currency }}
                    </div>
                </div>
                <div>
                    <div class="text-sm text-zinc-500 dark:text-zinc-400 mb-1">Payment Date</div>
                    <div class="text-base font-medium text-zinc-900 dark:text-white">{{ $order->placed_at->format('M d, Y') }}</div>
                </div>
            </div>
        </div>

        <!-- Subscription Status -->
        <div class="bg-green-50 dark:bg-green-900/20 border-l-4 border-green-400 p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-green-800 dark:text-green-200">Your Subscription is Active</h3>
                    <div class="mt-2 text-sm text-green-700 dark:text-green-300">
                        <p><strong>{{ $subscription->service->title }}</strong> has been renewed successfully!</p>
                        <p class="mt-1">New expiration date: <strong>{{ $subscription->expires_at->format('F d, Y') }}</strong></p>
                        @if($subscription->auto_renew)
                            <p class="mt-1">✓ Auto-renewal is enabled - your subscription will automatically renew before it expires.</p>
                        @else
                            <p class="mt-1">⚠ Auto-renewal is disabled - you'll need to manually renew before {{ $subscription->expires_at->format('F d, Y') }}.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Items -->
        <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6 mb-6">
            <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Renewal Items</h2>
            
            <div class="space-y-4">
                @foreach($order->items as $item)
                    <div class="flex items-start justify-between py-3 border-b border-zinc-200 dark:border-zinc-700 last:border-0">
                        <div class="flex-1">
                            <h3 class="text-sm font-medium text-zinc-900 dark:text-white">{{ $item->title }}</h3>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                                Quantity: {{ $item->quantity }} × {{ number_format($item->unit_price, 2) }} {{ $subscription->currency }}
                            </p>
                        </div>
                        <div class="text-right">
                            <div class="text-sm font-medium text-zinc-900 dark:text-white">
                                {{ number_format($item->line_total, 2) }} {{ $subscription->currency }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4 pt-4 border-t border-zinc-200 dark:border-zinc-700">
                <div class="flex justify-between items-center">
                    <span class="text-base font-semibold text-zinc-900 dark:text-white">Total</span>
                    <span class="text-lg font-bold text-green-600">
                        {{ number_format($order->total, 2) }} {{ $subscription->currency }}
                    </span>
                </div>
            </div>
        </div>

        <!-- What's Next -->
        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-6 mb-6">
            <h3 class="text-base font-semibold text-blue-900 dark:text-blue-100 mb-3">What's Next?</h3>
            <ul class="space-y-2 text-sm text-blue-800 dark:text-blue-200">
                <li class="flex items-start">
                    <svg class="w-5 h-5 mr-2 flex-shrink-0 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>You'll receive a confirmation email with your receipt shortly</span>
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 mr-2 flex-shrink-0 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>Your subscription is now active until {{ $subscription->expires_at->format('F d, Y') }}</span>
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 mr-2 flex-shrink-0 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>Continue enjoying uninterrupted access to {{ $subscription->service->title }}</span>
                </li>
                @if($subscription->auto_renew)
                    <li class="flex items-start">
                        <svg class="w-5 h-5 mr-2 flex-shrink-0 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>We'll remind you before your next automatic renewal</span>
                    </li>
                @else
                    <li class="flex items-start">
                        <svg class="w-5 h-5 mr-2 flex-shrink-0 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>We'll send you reminders before your subscription expires</span>
                    </li>
                @endif
            </ul>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('customer.subscriptions.show', $subscription) }}" 
               class="inline-flex items-center justify-center px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-md transition-colors">
                View Subscription Details
            </a>
            <a href="{{ route('customer.orders.show', $order) }}" 
               class="inline-flex items-center justify-center px-6 py-3 border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 font-medium rounded-md hover:bg-zinc-50 dark:hover:bg-zinc-700 transition-colors">
                View Order Receipt
            </a>
            <a href="{{ route('customer.subscriptions.index') }}" 
               class="inline-flex items-center justify-center px-6 py-3 border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 font-medium rounded-md hover:bg-zinc-50 dark:hover:bg-zinc-700 transition-colors">
                All Subscriptions
            </a>
        </div>

        <!-- Support -->
        <div class="mt-8 text-center">
            <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-2">
                Questions about your renewal?
            </p>
            <a href="#" class="text-sm font-medium text-primary-600 hover:text-primary-700 dark:text-primary-400">
                Contact Support →
            </a>
        </div>
    </div>
</x-layouts.app>
