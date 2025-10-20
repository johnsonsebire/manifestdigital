<x-layouts.app :title="'Cancel Subscription'">
    <div class="p-6 max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center gap-3 mb-2">
                <a href="{{ route('admin.subscriptions.show', $subscription) }}" class="text-zinc-500 hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Cancel Subscription</h1>
            </div>
            <p class="text-sm text-zinc-600 dark:text-zinc-400 ml-8">
                Subscription ID: <code class="font-mono bg-zinc-100 dark:bg-zinc-800 px-2 py-1 rounded">{{ $subscription->uuid }}</code>
            </p>
        </div>

        <!-- Warning -->
        <div class="bg-red-50 dark:bg-red-900/20 border-l-4 border-red-400 p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800 dark:text-red-200">Warning: Subscription Cancellation</h3>
                    <div class="mt-2 text-sm text-red-700 dark:text-red-300">
                        <p>You are about to cancel this subscription. Please review the subscription details carefully before proceeding.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Current Subscription Info -->
        <div class="bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-400 p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200">Current Subscription Details</h3>
                    <div class="mt-2 text-sm text-blue-700 dark:text-blue-300">
                        <ul class="list-disc list-inside space-y-1">
                            <li><strong>Service:</strong> {{ $subscription->service->title }}</li>
                            <li><strong>Customer:</strong> {{ $subscription->customer->name }} ({{ $subscription->customer->email }})</li>
                            <li><strong>Current Status:</strong> {{ ucfirst($subscription->status) }}</li>
                            <li><strong>Expiration Date:</strong> {{ $subscription->expires_at->format('M d, Y') }}</li>
                            <li><strong>Billing Amount:</strong> {{ $subscription->billing_amount }} {{ strtoupper($subscription->currency) }} per {{ str_replace('_', ' ', $subscription->billing_interval) }}</li>
                            @if($subscription->auto_renew)
                                <li><strong>Auto-Renewal:</strong> <span class="text-green-600 dark:text-green-400">Enabled</span></li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cancellation Form -->
        <div class="bg-white dark:bg-zinc-800 shadow rounded-lg p-6">
            <form method="POST" action="{{ route('admin.subscriptions.process-cancel', $subscription) }}">
                @csrf

                <!-- Cancellation Type -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-3">
                        Cancellation Type <span class="text-red-500">*</span>
                    </label>
                    <div class="space-y-3">
                        <label class="flex items-start p-4 border rounded-lg cursor-pointer hover:bg-zinc-50 dark:hover:bg-zinc-700/50 transition-colors {{ old('cancellation_type') === 'end_of_period' || !old('cancellation_type') ? 'border-primary-500 bg-primary-50 dark:bg-primary-900/20' : 'border-zinc-300 dark:border-zinc-600' }}">
                            <input type="radio" 
                                   name="cancellation_type" 
                                   value="end_of_period" 
                                   class="mt-1 text-primary-600 focus:ring-primary-500"
                                   {{ old('cancellation_type') === 'end_of_period' || !old('cancellation_type') ? 'checked' : '' }}
                                   onchange="updateCancellationPreview()">
                            <div class="ml-3">
                                <div class="text-sm font-medium text-zinc-900 dark:text-white">
                                    Cancel at End of Period (Recommended)
                                </div>
                                <div class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">
                                    The subscription will remain active until {{ $subscription->expires_at->format('M d, Y') }}. 
                                    The customer retains access until the current period ends. No refund will be issued.
                                </div>
                            </div>
                        </label>

                        <label class="flex items-start p-4 border rounded-lg cursor-pointer hover:bg-zinc-50 dark:hover:bg-zinc-700/50 transition-colors {{ old('cancellation_type') === 'immediate' ? 'border-red-500 bg-red-50 dark:bg-red-900/20' : 'border-zinc-300 dark:border-zinc-600' }}">
                            <input type="radio" 
                                   name="cancellation_type" 
                                   value="immediate" 
                                   class="mt-1 text-red-600 focus:ring-red-500"
                                   {{ old('cancellation_type') === 'immediate' ? 'checked' : '' }}
                                   onchange="updateCancellationPreview()">
                            <div class="ml-3">
                                <div class="text-sm font-medium text-zinc-900 dark:text-white">
                                    Cancel Immediately
                                </div>
                                <div class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">
                                    The subscription will be cancelled immediately and the customer will lose access right away. 
                                    Consider issuing a partial refund for unused time.
                                </div>
                                @php
                                    $daysRemaining = now()->diffInDays($subscription->expires_at, false);
                                    $totalDays = $subscription->starts_at->diffInDays($subscription->expires_at);
                                    $proRatedAmount = $daysRemaining > 0 ? ($subscription->billing_amount / $totalDays) * $daysRemaining : 0;
                                @endphp
                                @if($daysRemaining > 0)
                                    <div class="mt-2 text-xs text-yellow-700 dark:text-yellow-300 bg-yellow-100 dark:bg-yellow-900/30 p-2 rounded">
                                        💡 Pro-rated refund suggestion: {{ number_format($proRatedAmount, 2) }} {{ strtoupper($subscription->currency) }} 
                                        ({{ $daysRemaining }} days remaining out of {{ $totalDays }} days)
                                    </div>
                                @endif
                            </div>
                        </label>
                    </div>
                    @error('cancellation_type')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Refund Amount -->
                <div class="mb-6" id="refund-section">
                    <label for="refund_amount" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Refund Amount (Optional)
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-zinc-500 dark:text-zinc-400 sm:text-sm">{{ strtoupper($subscription->currency) }}</span>
                        </div>
                        <input type="number" 
                               name="refund_amount" 
                               id="refund_amount" 
                               step="0.01"
                               min="0"
                               max="{{ $subscription->billing_amount }}"
                               value="{{ old('refund_amount', $daysRemaining > 0 ? number_format($proRatedAmount, 2, '.', '') : '0.00') }}"
                               class="pl-16 w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500">
                    </div>
                    <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">
                        Enter the refund amount to be issued to the customer. Maximum: {{ $subscription->billing_amount }} {{ strtoupper($subscription->currency) }}
                    </p>
                    @error('refund_amount')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Cancellation Reason -->
                <div class="mb-6">
                    <label for="cancellation_reason" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Cancellation Reason <span class="text-red-500">*</span>
                    </label>
                    <textarea name="cancellation_reason" 
                              id="cancellation_reason" 
                              rows="4"
                              required
                              placeholder="Enter the reason for cancellation (required for internal records and customer communication)..."
                              class="w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500">{{ old('cancellation_reason') }}</textarea>
                    <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">
                        This reason will be stored in the subscription record and may be included in the cancellation notification email.
                    </p>
                    @error('cancellation_reason')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Send Notification -->
                <div class="mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" 
                               name="send_notification" 
                               value="1"
                               {{ old('send_notification', true) ? 'checked' : '' }}
                               class="rounded border-zinc-300 text-primary-600 focus:ring-primary-500">
                        <span class="ml-2 text-sm text-zinc-700 dark:text-zinc-300">
                            Send cancellation notification email to customer
                        </span>
                    </label>
                    <p class="mt-1 ml-6 text-xs text-zinc-500 dark:text-zinc-400">
                        The customer will receive an email confirming the cancellation with details about access termination and any refund.
                    </p>
                </div>

                <!-- Cancellation Preview -->
                <div class="mb-6 p-4 bg-zinc-50 dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-700">
                    <h3 class="text-sm font-semibold text-zinc-900 dark:text-white mb-3">Cancellation Summary</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-zinc-600 dark:text-zinc-400">Cancellation Type:</span>
                            <span class="font-medium text-zinc-900 dark:text-white" id="summary-type">End of Period</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-zinc-600 dark:text-zinc-400">Current Expiration:</span>
                            <span class="font-medium text-zinc-900 dark:text-white">{{ $subscription->expires_at->format('M d, Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-zinc-600 dark:text-zinc-400">Access Ends:</span>
                            <span class="font-medium text-zinc-900 dark:text-white" id="summary-access-end">
                                {{ $subscription->expires_at->format('M d, Y') }}
                            </span>
                        </div>
                        @if($subscription->service->grace_period_days > 0)
                            <div class="flex justify-between">
                                <span class="text-zinc-600 dark:text-zinc-400">Grace Period:</span>
                                <span class="font-medium text-zinc-900 dark:text-white">
                                    {{ $subscription->service->grace_period_days }} days
                                </span>
                            </div>
                        @endif
                        <div class="flex justify-between pt-2 border-t border-zinc-300 dark:border-zinc-600">
                            <span class="text-zinc-600 dark:text-zinc-400">Refund Amount:</span>
                            <span class="font-semibold text-zinc-900 dark:text-white" id="summary-refund">
                                <span id="summary-refund-value">{{ $daysRemaining > 0 ? number_format($proRatedAmount, 2) : '0.00' }}</span> {{ strtoupper($subscription->currency) }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-zinc-600 dark:text-zinc-400">Auto-Renewal:</span>
                            <span class="font-medium text-red-600 dark:text-red-400">Will be Disabled</span>
                        </div>
                    </div>
                </div>

                <!-- Confirmation Checkbox -->
                <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                    <label class="flex items-start">
                        <input type="checkbox" 
                               name="confirm_cancellation" 
                               id="confirm_cancellation"
                               required
                               class="mt-1 rounded border-red-300 text-red-600 focus:ring-red-500">
                        <span class="ml-3 text-sm text-red-900 dark:text-red-200">
                            <strong>I understand that this action will cancel the subscription.</strong> 
                            The customer will be notified and lose access according to the cancellation type selected above.
                        </span>
                    </label>
                </div>

                <!-- Actions -->
                <div class="flex gap-3">
                    <button type="submit" 
                            class="flex-1 inline-flex justify-center items-center px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                            id="cancel-button"
                            disabled>
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Cancel Subscription
                    </button>
                    <a href="{{ route('admin.subscriptions.show', $subscription) }}" 
                       class="flex-1 inline-flex justify-center items-center px-6 py-3 bg-zinc-200 dark:bg-zinc-700 text-zinc-700 dark:text-zinc-300 font-medium rounded-lg hover:bg-zinc-300 dark:hover:bg-zinc-600 transition-colors">
                        Keep Subscription
                    </a>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function updateCancellationPreview() {
            const immediateRadio = document.querySelector('input[name="cancellation_type"][value="immediate"]');
            const summaryType = document.getElementById('summary-type');
            const summaryAccessEnd = document.getElementById('summary-access-end');
            
            if (immediateRadio.checked) {
                summaryType.textContent = 'Immediate';
                summaryAccessEnd.textContent = 'Today';
                summaryAccessEnd.classList.add('text-red-600', 'dark:text-red-400');
            } else {
                summaryType.textContent = 'End of Period';
                summaryAccessEnd.textContent = '{{ $subscription->expires_at->format('M d, Y') }}';
                summaryAccessEnd.classList.remove('text-red-600', 'dark:text-red-400');
            }
        }

        // Update refund display when amount changes
        document.getElementById('refund_amount').addEventListener('input', function() {
            const amount = parseFloat(this.value) || 0;
            document.getElementById('summary-refund-value').textContent = amount.toFixed(2);
        });

        // Enable/disable submit button based on confirmation checkbox
        document.getElementById('confirm_cancellation').addEventListener('change', function() {
            document.getElementById('cancel-button').disabled = !this.checked;
        });

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateCancellationPreview();
        });
    </script>
    @endpush
</x-layouts.app>
