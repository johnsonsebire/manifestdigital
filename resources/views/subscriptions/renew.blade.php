<x-layouts.app :title="'Renew Subscription - ' . $subscription->service->title">
    <div class="p-6 max-w-5xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <a href="{{ route('customer.subscriptions.show', $subscription) }}" class="text-sm text-primary-600 hover:text-primary-700 mb-2 inline-flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Subscription
            </a>
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Renew Subscription</h1>
            <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">
                Extend your {{ $service->title }} subscription
            </p>
        </div>

        @if(session('error'))
            <div class="bg-red-50 dark:bg-red-900/20 border-l-4 border-red-400 p-4 mb-6">
                <p class="text-red-700 dark:text-red-400">{{ session('error') }}</p>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Subscription Info -->
                <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Current Subscription</h2>
                    
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h3 class="text-base font-medium text-zinc-900 dark:text-white">{{ $service->title }}</h3>
                            <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">
                                Current Period: {{ $subscription->start_date->format('M d, Y') }} - {{ $subscription->expires_at->format('M d, Y') }}
                            </p>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $subscription->status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' : 'bg-gray-100 text-gray-800' }}">
                            {{ ucfirst($subscription->status) }}
                        </span>
                    </div>

                    @if($isEarlyRenewal)
                        <div class="bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-400 p-4 mb-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200">Early Renewal</h3>
                                    <div class="mt-2 text-sm text-blue-700 dark:text-blue-300">
                                        <p>Your subscription expires in {{ abs($daysUntilExpiry) }} days. Renewing now will extend from your current expiration date.</p>
                                        @if($earlyRenewalDiscount > 0)
                                            <p class="mt-1 font-medium">🎉 You'll receive a {{ $earlyRenewalDiscount }}% early renewal discount!</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="bg-yellow-50 dark:bg-yellow-900/20 border-l-4 border-yellow-400 p-4 mb-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-yellow-800 dark:text-yellow-200">Subscription Expired</h3>
                                    <div class="mt-2 text-sm text-yellow-700 dark:text-yellow-300">
                                        <p>Your subscription expired {{ abs($daysUntilExpiry) }} days ago. Renewing now will start a new subscription period immediately.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="grid grid-cols-2 gap-4 mt-4">
                        <div>
                            <div class="text-xs text-zinc-500 dark:text-zinc-400">Billing Interval</div>
                            <div class="text-sm font-medium text-zinc-900 dark:text-white mt-1">
                                {{ ucfirst(str_replace('_', ' ', $service->billing_interval)) }}
                            </div>
                        </div>
                        <div>
                            <div class="text-xs text-zinc-500 dark:text-zinc-400">New Expiration Date</div>
                            <div class="text-sm font-medium text-green-600 mt-1">
                                {{ $newExpirationDate->format('M d, Y') }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Renewal Form -->
                <form method="POST" action="{{ route('renewal.store', $subscription) }}" class="space-y-6">
                    @csrf

                    <!-- Payment Method Selection -->
                    <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                        <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Payment Method</h2>
                        
                        <div class="space-y-3">
                            <!-- Paystack -->
                            <label class="relative flex items-start p-4 border rounded-lg cursor-pointer hover:bg-zinc-50 dark:hover:bg-zinc-700/50 transition-colors {{ old('payment_method', 'paystack') === 'paystack' ? 'border-primary-500 bg-primary-50 dark:bg-primary-900/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                <input type="radio" 
                                       name="payment_method" 
                                       value="paystack" 
                                       class="mt-1 h-4 w-4 text-primary-600 focus:ring-primary-500"
                                       {{ old('payment_method', 'paystack') === 'paystack' ? 'checked' : '' }}
                                       required>
                                <div class="ml-3">
                                    <span class="block text-sm font-medium text-zinc-900 dark:text-white">Card Payment (Paystack)</span>
                                    <span class="block text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                                        Pay securely with your debit/credit card. Instant confirmation.
                                    </span>
                                </div>
                            </label>

                            <!-- Bank Transfer -->
                            <label class="relative flex items-start p-4 border rounded-lg cursor-pointer hover:bg-zinc-50 dark:hover:bg-zinc-700/50 transition-colors {{ old('payment_method') === 'bank_transfer' ? 'border-primary-500 bg-primary-50 dark:bg-primary-900/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                                <input type="radio" 
                                       name="payment_method" 
                                       value="bank_transfer" 
                                       class="mt-1 h-4 w-4 text-primary-600 focus:ring-primary-500"
                                       {{ old('payment_method') === 'bank_transfer' ? 'checked' : '' }}
                                       required>
                                <div class="ml-3">
                                    <span class="block text-sm font-medium text-zinc-900 dark:text-white">Bank Transfer</span>
                                    <span class="block text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                                        Transfer to our bank account. Confirmation may take 1-2 business days.
                                    </span>
                                </div>
                            </label>
                        </div>

                        @error('payment_method')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Terms and Conditions -->
                    <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                        <label class="flex items-start">
                            <input type="checkbox" 
                                   name="terms_accepted" 
                                   value="1"
                                   class="mt-1 h-4 w-4 text-primary-600 focus:ring-primary-500 border-zinc-300 dark:border-zinc-600 rounded"
                                   {{ old('terms_accepted') ? 'checked' : '' }}
                                   required>
                            <span class="ml-3 text-sm text-zinc-700 dark:text-zinc-300">
                                I agree to the renewal terms and understand that:
                                <ul class="list-disc list-inside mt-2 space-y-1 text-zinc-600 dark:text-zinc-400">
                                    <li>My subscription will be extended for one {{ str_replace('_', ' ', $service->billing_interval) }}</li>
                                    <li>I will be charged {!! $currencyService->formatAmount($finalPrice, $subscription->currency) !!}</li>
                                    <li>The new expiration date will be {{ $newExpirationDate->format('F d, Y') }}</li>
                                    @if($subscription->auto_renew)
                                        <li>Auto-renewal is enabled and will continue unless disabled</li>
                                    @endif
                                </ul>
                            </span>
                        </label>

                        @error('terms_accepted')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="flex items-center justify-between pt-4">
                        <a href="{{ route('customer.subscriptions.show', $subscription) }}" 
                           class="inline-flex items-center px-4 py-2 border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 font-medium rounded-md hover:bg-zinc-50 dark:hover:bg-zinc-700 transition-colors">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-md transition-colors text-lg">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Proceed to Payment
                        </button>
                    </div>
                </form>
            </div>

            <!-- Sidebar - Order Summary -->
            <div class="space-y-6">
                <!-- Pricing Breakdown -->
                <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Order Summary</h2>
                    
                    <div class="space-y-3 mb-4">
                        <div class="flex justify-between text-sm">
                            <span class="text-zinc-600 dark:text-zinc-400">Base Price</span>
                            <span class="text-zinc-900 dark:text-white font-medium">
                                {!! $currencyService->formatAmount($basePrice, $subscription->currency) !!}
                            </span>
                        </div>

                        @if($serviceDiscountPercentage > 0)
                            <div class="flex justify-between text-sm">
                                <span class="text-zinc-600 dark:text-zinc-400">
                                    Renewal Discount ({{ $serviceDiscountPercentage }}%)
                                </span>
                                <span class="text-green-600 font-medium">
                                    -{!! $currencyService->formatAmount($serviceDiscountAmount, $subscription->currency) !!}
                                </span>
                            </div>
                        @endif

                        @if($earlyRenewalDiscount > 0)
                            <div class="flex justify-between text-sm">
                                <span class="text-zinc-600 dark:text-zinc-400">
                                    Early Renewal Bonus ({{ $earlyRenewalDiscount }}%)
                                </span>
                                <span class="text-green-600 font-medium">
                                    -{!! $currencyService->formatAmount($renewalPrice - $earlyRenewalPrice, $subscription->currency) !!}
                                </span>
                            </div>
                        @endif

                        <div class="border-t border-zinc-200 dark:border-zinc-700 pt-3 mt-3">
                            <div class="flex justify-between">
                                <span class="text-base font-semibold text-zinc-900 dark:text-white">Total</span>
                                <span class="text-lg font-bold text-green-600">
                                    {!! $currencyService->formatAmount($finalPrice, $subscription->currency) !!}
                                </span>
                            </div>
                        </div>
                    </div>

                    @if($earlyRenewalDiscount > 0)
                        <div class="bg-green-50 dark:bg-green-900/20 rounded p-3 text-sm">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <p class="text-green-700 dark:text-green-300">
                                    You're saving {!! $currencyService->formatAmount($basePrice - $finalPrice, $subscription->currency) !!} by renewing early!
                                </p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Benefits -->
                <div class="bg-primary-50 dark:bg-primary-900/20 rounded-lg shadow p-6">
                    <h3 class="text-sm font-medium text-primary-900 dark:text-primary-100 mb-3">What's Included</h3>
                    <ul class="space-y-2 text-sm text-primary-700 dark:text-primary-300">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Uninterrupted access to {{ $service->title }}</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Extended until {{ $newExpirationDate->format('M d, Y') }}</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Priority customer support</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>All future updates included</span>
                        </li>
                    </ul>
                </div>

                <!-- Help -->
                <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                    <h3 class="text-sm font-medium text-zinc-900 dark:text-white mb-2">Need Help?</h3>
                    <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-3">
                        Have questions about renewing your subscription?
                    </p>
                    <a href="#" class="text-sm font-medium text-primary-600 hover:text-primary-700 dark:text-primary-400">
                        Contact Support →
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
