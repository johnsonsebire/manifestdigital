<x-layouts.app :title="'Request Cancellation - ' . $subscription->service->title">
    <div class="p-6 max-w-3xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <a href="{{ route('customer.subscriptions.show', $subscription) }}" class="text-sm text-primary-600 hover:text-primary-700 mb-2 inline-flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Subscription
            </a>
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Request Cancellation</h1>
            <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">
                We're sorry to see you go. Please help us improve by sharing why you're cancelling.
            </p>
        </div>

        @if(session('error'))
            <div class="bg-red-50 dark:bg-red-900/20 border-l-4 border-red-400 p-4 mb-6">
                <p class="text-red-700 dark:text-red-400">{{ session('error') }}</p>
            </div>
        @endif

        <!-- Subscription Info Card -->
        <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6 mb-6">
            <div class="flex items-start justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">{{ $subscription->service->title }}</h3>
                    <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                        Billing Amount: {!! $currencyService->formatAmount($subscription->billing_amount, $subscription->currency) !!} / {{ str_replace('_', ' ', $subscription->billing_interval) }}
                    </p>
                    <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                        Expires: {{ $subscription->expires_at->format('F d, Y') }} 
                        ({{ $subscription->expires_at->diffInDays(now()) }} days from now)
                    </p>
                </div>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300">
                    {{ ucfirst($subscription->status) }}
                </span>
            </div>
        </div>

        <!-- Cancellation Form -->
        <form method="POST" action="{{ route('customer.subscriptions.submit-cancellation', $subscription) }}" class="space-y-6">
            @csrf

            <!-- Cancellation Type -->
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Cancellation Type</h2>
                
                <div class="space-y-3">
                    <label class="relative flex items-start p-4 border rounded-lg cursor-pointer hover:bg-zinc-50 dark:hover:bg-zinc-700/50 transition-colors {{ old('cancellation_type') === 'immediate' ? 'border-primary-500 bg-primary-50 dark:bg-primary-900/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                        <input type="radio" 
                               name="cancellation_type" 
                               value="immediate" 
                               class="mt-1 h-4 w-4 text-primary-600 focus:ring-primary-500"
                               {{ old('cancellation_type') === 'immediate' ? 'checked' : '' }}
                               required>
                        <div class="ml-3">
                            <span class="block text-sm font-medium text-zinc-900 dark:text-white">Immediate Cancellation</span>
                            <span class="block text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                                Cancel immediately and receive a pro-rated refund for the unused portion of your subscription.
                            </span>
                        </div>
                    </label>

                    <label class="relative flex items-start p-4 border rounded-lg cursor-pointer hover:bg-zinc-50 dark:hover:bg-zinc-700/50 transition-colors {{ old('cancellation_type', 'end_of_period') === 'end_of_period' ? 'border-primary-500 bg-primary-50 dark:bg-primary-900/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                        <input type="radio" 
                               name="cancellation_type" 
                               value="end_of_period" 
                               class="mt-1 h-4 w-4 text-primary-600 focus:ring-primary-500"
                               {{ old('cancellation_type', 'end_of_period') === 'end_of_period' ? 'checked' : '' }}
                               required>
                        <div class="ml-3">
                            <span class="block text-sm font-medium text-zinc-900 dark:text-white">Cancel at Period End</span>
                            <span class="block text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                                Continue using the service until {{ $subscription->expires_at->format('F d, Y') }}, then cancel. No refund will be issued.
                            </span>
                        </div>
                    </label>
                </div>

                @error('cancellation_type')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Cancellation Reason -->
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Why are you cancelling?</h2>
                
                <div class="space-y-2">
                    @php
                        $reasons = [
                            'too_expensive' => 'Too expensive',
                            'not_using' => 'Not using the service enough',
                            'missing_features' => 'Missing features I need',
                            'switching_competitor' => 'Switching to a competitor',
                            'technical_issues' => 'Experiencing technical issues',
                            'poor_support' => 'Dissatisfied with customer support',
                            'temporary_pause' => 'Need to pause temporarily',
                            'other' => 'Other reason',
                        ];
                    @endphp

                    @foreach($reasons as $value => $label)
                        <label class="flex items-center p-3 border rounded cursor-pointer hover:bg-zinc-50 dark:hover:bg-zinc-700/50 transition-colors {{ old('reason') === $value ? 'border-primary-500 bg-primary-50 dark:bg-primary-900/20' : 'border-zinc-200 dark:border-zinc-700' }}">
                            <input type="radio" 
                                   name="reason" 
                                   value="{{ $value }}" 
                                   class="h-4 w-4 text-primary-600 focus:ring-primary-500"
                                   {{ old('reason') === $value ? 'checked' : '' }}
                                   required>
                            <span class="ml-3 text-sm text-zinc-900 dark:text-white">{{ $label }}</span>
                        </label>
                    @endforeach
                </div>

                @error('reason')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Additional Feedback -->
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                <label for="feedback" class="block text-sm font-medium text-zinc-900 dark:text-white mb-2">
                    Additional Feedback (Optional)
                </label>
                <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-3">
                    Please share any additional details that might help us improve our service.
                </p>
                <textarea id="feedback"
                          name="feedback"
                          rows="4"
                          class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 dark:bg-zinc-700 dark:text-white"
                          placeholder="What could we have done better?">{{ old('feedback') }}</textarea>
                
                @error('feedback')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Offer Alternatives -->
            <div class="bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-400 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200">Before you go...</h3>
                        <div class="mt-2 text-sm text-blue-700 dark:text-blue-300">
                            <p class="mb-2">We'd love to help you get more value from your subscription. Here are some options:</p>
                            <ul class="list-disc list-inside space-y-1 ml-2">
                                <li>Contact support to discuss your concerns</li>
                                <li>Request a temporary pause instead of cancellation</li>
                                <li>Explore different billing intervals that might work better for you</li>
                            </ul>
                        </div>
                        <div class="mt-3">
                            <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-500 dark:text-blue-400">
                                Talk to our team →
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Important Notice -->
            <div class="bg-yellow-50 dark:bg-yellow-900/20 border-l-4 border-yellow-400 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-yellow-800 dark:text-yellow-200">Important Notice</h3>
                        <div class="mt-2 text-sm text-yellow-700 dark:text-yellow-300">
                            <p>Your cancellation request will be reviewed by our team. You will receive an email confirmation once it has been processed. This typically takes 1-2 business days.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-between pt-4 border-t border-zinc-200 dark:border-zinc-700">
                <a href="{{ route('customer.subscriptions.show', $subscription) }}" 
                   class="inline-flex items-center px-4 py-2 border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 font-medium rounded-md hover:bg-zinc-50 dark:hover:bg-zinc-700 transition-colors">
                    Cancel Request
                </a>
                <button type="submit" 
                        class="inline-flex items-center px-6 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-md transition-colors">
                    Submit Cancellation Request
                </button>
            </div>
        </form>

        <!-- FAQ Section -->
        <div class="mt-8 bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Frequently Asked Questions</h2>
            
            <div class="space-y-4">
                <div>
                    <h3 class="text-sm font-medium text-zinc-900 dark:text-white">When will my cancellation take effect?</h3>
                    <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                        If you choose immediate cancellation, it will take effect within 1-2 business days after our team reviews your request. 
                        If you choose to cancel at period end, your subscription will remain active until {{ $subscription->expires_at->format('F d, Y') }}.
                    </p>
                </div>

                <div>
                    <h3 class="text-sm font-medium text-zinc-900 dark:text-white">Will I receive a refund?</h3>
                    <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                        If you choose immediate cancellation, you'll receive a pro-rated refund for the unused portion of your subscription. 
                        If you choose to cancel at period end, no refund will be issued as you'll continue using the service until expiration.
                    </p>
                </div>

                <div>
                    <h3 class="text-sm font-medium text-zinc-900 dark:text-white">Can I reactivate my subscription later?</h3>
                    <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                        Yes! You can reactivate your subscription at any time by purchasing the service again. 
                        Your previous data and settings may be retained depending on our retention policy.
                    </p>
                </div>

                <div>
                    <h3 class="text-sm font-medium text-zinc-900 dark:text-white">What happens to my data after cancellation?</h3>
                    <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                        Your data will be retained for 90 days after cancellation, during which you can reactivate without losing any information. 
                        After 90 days, your data will be permanently deleted in accordance with our privacy policy.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
