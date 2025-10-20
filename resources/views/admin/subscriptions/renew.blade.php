<x-layouts.app :title="'Renew Subscription'">
    <div class="p-6 max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center gap-3 mb-2">
                <a href="{{ route('admin.subscriptions.show', $subscription) }}" class="text-zinc-500 hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Renew Subscription</h1>
            </div>
            <p class="text-sm text-zinc-600 dark:text-zinc-400 ml-8">
                Subscription ID: <code class="font-mono bg-zinc-100 dark:bg-zinc-800 px-2 py-1 rounded">{{ $subscription->uuid }}</code>
            </p>
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
                            <li><strong>Current Expiration:</strong> {{ $subscription->expires_at->format('M d, Y') }} 
                                ({{ now()->diffInDays($subscription->expires_at, false) }} days {{ now()->gt($subscription->expires_at) ? 'ago' : 'remaining' }})
                            </li>
                            <li><strong>Current Billing:</strong> {{ $subscription->billing_amount }} {{ strtoupper($subscription->currency) }} per {{ str_replace('_', ' ', $subscription->billing_interval) }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Renewal Form -->
        <div class="bg-white dark:bg-zinc-800 shadow rounded-lg p-6">
            <form method="POST" action="{{ route('admin.subscriptions.process-renewal', $subscription) }}">
                @csrf

                <!-- Renewal Period -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Renewal Period
                    </label>
                    <div class="space-y-3">
                        <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-zinc-50 dark:hover:bg-zinc-700/50 transition-colors {{ old('renewal_period') === 'service_default' || !old('renewal_period') ? 'border-primary-500 bg-primary-50 dark:bg-primary-900/20' : 'border-zinc-300 dark:border-zinc-600' }}">
                            <input type="radio" 
                                   name="renewal_period" 
                                   value="service_default" 
                                   class="text-primary-600 focus:ring-primary-500"
                                   {{ old('renewal_period') === 'service_default' || !old('renewal_period') ? 'checked' : '' }}
                                   onchange="toggleCustomMonths()">
                            <div class="ml-3">
                                <div class="text-sm font-medium text-zinc-900 dark:text-white">
                                    Use Service Default ({{ $subscription->service->subscription_duration_months }} months)
                                </div>
                                <div class="text-xs text-zinc-500 dark:text-zinc-400">
                                    Subscription will be extended by {{ $subscription->service->subscription_duration_months }} months from 
                                    {{ $subscription->status === 'expired' ? 'today' : 'current expiration date' }}
                                </div>
                            </div>
                        </label>

                        <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-zinc-50 dark:hover:bg-zinc-700/50 transition-colors {{ old('renewal_period') === 'custom' ? 'border-primary-500 bg-primary-50 dark:bg-primary-900/20' : 'border-zinc-300 dark:border-zinc-600' }}">
                            <input type="radio" 
                                   name="renewal_period" 
                                   value="custom" 
                                   class="text-primary-600 focus:ring-primary-500"
                                   {{ old('renewal_period') === 'custom' ? 'checked' : '' }}
                                   onchange="toggleCustomMonths()">
                            <div class="ml-3 flex-1">
                                <div class="text-sm font-medium text-zinc-900 dark:text-white mb-2">
                                    Custom Period
                                </div>
                                <input type="number" 
                                       name="custom_months" 
                                       id="custom_months"
                                       min="1"
                                       max="60"
                                       value="{{ old('custom_months', 12) }}"
                                       class="w-32 rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500 text-sm"
                                       {{ old('renewal_period') === 'custom' ? '' : 'disabled' }}>
                                <span class="ml-2 text-sm text-zinc-600 dark:text-zinc-400">months</span>
                            </div>
                        </label>
                    </div>
                    @error('renewal_period')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    @error('custom_months')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Renewal Price -->
                <div class="mb-6">
                    <label for="renewal_price" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Renewal Price <span class="text-red-500">*</span>
                    </label>
                    @php
                        $defaultPrice = $subscription->billing_amount;
                        $renewalDiscount = $subscription->service->renewal_discount_percentage ?? 0;
                        if ($renewalDiscount > 0) {
                            $defaultPrice = $subscription->billing_amount * (1 - $renewalDiscount / 100);
                        }
                    @endphp
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-zinc-500 dark:text-zinc-400 sm:text-sm">{{ strtoupper($subscription->currency) }}</span>
                        </div>
                        <input type="number" 
                               name="renewal_price" 
                               id="renewal_price" 
                               step="0.01"
                               min="0"
                               value="{{ old('renewal_price', number_format($defaultPrice, 2, '.', '')) }}"
                               required
                               class="pl-16 w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500">
                    </div>
                    @if($renewalDiscount > 0)
                        <p class="mt-2 text-sm text-green-600 dark:text-green-400">
                            💰 {{ $renewalDiscount }}% renewal discount applied (Original: {{ $subscription->billing_amount }} {{ strtoupper($subscription->currency) }})
                        </p>
                    @endif
                    <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">
                        This is the amount that will be charged for the renewal period.
                    </p>
                    @error('renewal_price')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Send Confirmation -->
                <div class="mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" 
                               name="send_confirmation" 
                               value="1"
                               {{ old('send_confirmation', true) ? 'checked' : '' }}
                               class="rounded border-zinc-300 text-primary-600 focus:ring-primary-500">
                        <span class="ml-2 text-sm text-zinc-700 dark:text-zinc-300">
                            Send renewal confirmation email to customer
                        </span>
                    </label>
                </div>

                <!-- Notes -->
                <div class="mb-6">
                    <label for="notes" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Internal Notes (Optional)
                    </label>
                    <textarea name="notes" 
                              id="notes" 
                              rows="3"
                              placeholder="Add any notes about this renewal..."
                              class="w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500">{{ old('notes') }}</textarea>
                    <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">
                        These notes are for internal use only and will not be visible to the customer.
                    </p>
                    @error('notes')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Renewal Preview -->
                <div class="mb-6 p-4 bg-zinc-50 dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-700">
                    <h3 class="text-sm font-semibold text-zinc-900 dark:text-white mb-3">Renewal Preview</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-zinc-600 dark:text-zinc-400">Current Expiration:</span>
                            <span class="font-medium text-zinc-900 dark:text-white">{{ $subscription->expires_at->format('M d, Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-zinc-600 dark:text-zinc-400">Renewal From:</span>
                            <span class="font-medium text-zinc-900 dark:text-white" id="renewal-from">
                                {{ $subscription->status === 'expired' ? now()->format('M d, Y') : $subscription->expires_at->format('M d, Y') }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-zinc-600 dark:text-zinc-400">Extension Period:</span>
                            <span class="font-medium text-zinc-900 dark:text-white" id="extension-period">
                                {{ $subscription->service->subscription_duration_months }} months
                            </span>
                        </div>
                        <div class="flex justify-between pt-2 border-t border-zinc-300 dark:border-zinc-600">
                            <span class="text-zinc-600 dark:text-zinc-400">New Expiration Date:</span>
                            <span class="font-semibold text-green-600 dark:text-green-400" id="new-expiration">
                                @php
                                    $baseDate = $subscription->status === 'expired' ? now() : $subscription->expires_at;
                                    $newExpiration = $baseDate->copy()->addMonths($subscription->service->subscription_duration_months);
                                @endphp
                                {{ $newExpiration->format('M d, Y') }}
                            </span>
                        </div>
                        <div class="flex justify-between pt-2 border-t border-zinc-300 dark:border-zinc-600">
                            <span class="text-zinc-600 dark:text-zinc-400">Renewal Amount:</span>
                            <span class="font-bold text-xl text-primary-600 dark:text-primary-400" id="renewal-amount">
                                <span id="renewal-amount-value">{{ number_format($defaultPrice, 2) }}</span> {{ strtoupper($subscription->currency) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex gap-3">
                    <button type="submit" 
                            class="flex-1 inline-flex justify-center items-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Process Renewal
                    </button>
                    <a href="{{ route('admin.subscriptions.show', $subscription) }}" 
                       class="flex-1 inline-flex justify-center items-center px-6 py-3 bg-zinc-200 dark:bg-zinc-700 text-zinc-700 dark:text-zinc-300 font-medium rounded-lg hover:bg-zinc-300 dark:hover:bg-zinc-600 transition-colors">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function toggleCustomMonths() {
            const customRadio = document.querySelector('input[name="renewal_period"][value="custom"]');
            const customMonthsInput = document.getElementById('custom_months');
            const serviceDefaultRadio = document.querySelector('input[name="renewal_period"][value="service_default"]');
            
            if (customRadio.checked) {
                customMonthsInput.disabled = false;
                customMonthsInput.focus();
            } else {
                customMonthsInput.disabled = true;
            }
            
            updatePreview();
        }

        function updatePreview() {
            const customRadio = document.querySelector('input[name="renewal_period"][value="custom"]');
            const customMonths = parseInt(document.getElementById('custom_months').value) || {{ $subscription->service->subscription_duration_months }};
            const serviceDefaultMonths = {{ $subscription->service->subscription_duration_months }};
            const months = customRadio.checked ? customMonths : serviceDefaultMonths;
            
            // Update extension period
            document.getElementById('extension-period').textContent = months + ' months';
            
            // Calculate new expiration date
            const baseDate = new Date('{{ $subscription->status === "expired" ? now()->toDateString() : $subscription->expires_at->toDateString() }}');
            const newDate = new Date(baseDate);
            newDate.setMonth(newDate.getMonth() + months);
            
            const options = { year: 'numeric', month: 'short', day: 'numeric' };
            document.getElementById('new-expiration').textContent = newDate.toLocaleDateString('en-US', options);
        }

        // Update preview when custom months changes
        document.getElementById('custom_months').addEventListener('input', updatePreview);
        
        // Update renewal amount display when price changes
        document.getElementById('renewal_price').addEventListener('input', function() {
            const amount = parseFloat(this.value) || 0;
            document.getElementById('renewal-amount-value').textContent = amount.toFixed(2);
        });
        
        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            toggleCustomMonths();
        });
    </script>
    @endpush
</x-layouts.app>
