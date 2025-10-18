<x-layouts.frontend>
    <div class="container mx-auto px-4 py-12">
        <div class="max-w-3xl mx-auto">
            {{-- Success Header --}}
            <div class="bg-gradient-to-r from-green-500 to-emerald-600 rounded-t-2xl p-8 text-white">
                <div class="flex items-center justify-center mb-4">
                    <div class="bg-white/20 backdrop-blur-sm rounded-full p-3">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                </div>
                <h1 class="text-3xl font-bold text-center mb-2">Bank Transfer Instructions</h1>
                <p class="text-center text-green-100">Order #{{ $order->uuid }}</p>
            </div>

            <div class="bg-white shadow-lg rounded-b-2xl p-8">
                {{-- Alert --}}
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">Important</h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <p>Please make your payment to the bank account details below. Your order will be processed once payment is confirmed.</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Bank Details --}}
                <div class="bg-gray-50 rounded-lg p-6 mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Bank Account Details</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="text-sm font-medium text-gray-600">Bank Name</label>
                            <p class="text-lg font-semibold text-gray-900">{{ $bankInfo['bank_name'] }}</p>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-600">Account Name</label>
                            <p class="text-lg font-semibold text-gray-900">{{ $bankInfo['account_name'] }}</p>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-600">Account Number</label>
                            <div class="flex items-center gap-3">
                                <p class="text-2xl font-bold text-gray-900" id="accountNumber">{{ $bankInfo['account_number'] }}</p>
                                <button 
                                    onclick="copyToClipboard('{{ $bankInfo['account_number'] }}')"
                                    class="text-indigo-600 hover:text-indigo-800 transition"
                                    title="Copy account number"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-600">Amount to Transfer</label>
                            <p class="text-2xl font-bold text-green-600">{{ $order->currency ?? 'NGN' }} {{ number_format($order->total, 2) }}</p>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-600">Payment Reference</label>
                            <div class="flex items-center gap-3">
                                <p class="text-lg font-mono text-gray-900">{{ $order->uuid }}</p>
                                <button 
                                    onclick="copyToClipboard('{{ $order->uuid }}')"
                                    class="text-indigo-600 hover:text-indigo-800 transition"
                                    title="Copy reference"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                    </svg>
                                </button>
                            </div>
                            <p class="text-sm text-gray-500 mt-1">{{ $bankInfo['note'] }}</p>
                        </div>
                    </div>
                </div>

                {{-- Order Summary --}}
                <div class="border-t pt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Order Summary</h3>
                    <div class="space-y-2">
                        @foreach($order->items as $item)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">{{ $item->snapshot['service_title'] ?? $item->service->title }} 
                                @if($item->variant)
                                    <span class="text-gray-400">({{ $item->snapshot['variant_name'] ?? $item->variant->name }})</span>
                                @endif
                                × {{ $item->quantity }}
                            </span>
                            <span class="font-medium text-gray-900">{{ $order->currency ?? 'NGN' }} {{ number_format($item->line_total, 2) }}</span>
                        </div>
                        @endforeach

                        <div class="border-t pt-2 mt-2">
                            <div class="flex justify-between font-semibold text-gray-900">
                                <span>Total</span>
                                <span>{{ $order->currency ?? 'NGN' }} {{ number_format($order->total, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- What happens next --}}
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mt-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-yellow-800">What happens next?</h3>
                            <div class="mt-2 text-sm text-yellow-700">
                                <ol class="list-decimal list-inside space-y-1">
                                    <li>Make the payment using the bank details above</li>
                                    <li>Use your order number as the payment reference</li>
                                    <li>Your order will be confirmed within 24 hours of payment verification</li>
                                    <li>You'll receive an email confirmation once payment is verified</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex flex-col sm:flex-row gap-4 mt-8">
                    @auth
                    <a href="{{ route('home') }}" class="flex-1 bg-indigo-600 text-white text-center px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition">
                        Go to Dashboard
                    </a>
                    @else
                    <a href="{{ route('register') }}" class="flex-1 bg-indigo-600 text-white text-center px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition">
                        Create Account to Track Order
                    </a>
                    @endauth
                    
                    <a href="{{ route('services.index') }}" class="flex-1 bg-gray-100 text-gray-700 text-center px-6 py-3 rounded-lg font-semibold hover:bg-gray-200 transition">
                        Browse More Services
                    </a>
                </div>

                {{-- Help Section --}}
                <div class="mt-8 text-center text-sm text-gray-600">
                    <p>Need help? <a href="{{ route('contact') }}" class="text-indigo-600 hover:text-indigo-800">Contact us</a> or <a href="#" class="text-indigo-600 hover:text-indigo-800">start live chat</a></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                // Show a temporary success message
                const toast = document.createElement('div');
                toast.className = 'fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
                toast.textContent = 'Copied to clipboard!';
                document.body.appendChild(toast);
                
                setTimeout(() => {
                    toast.remove();
                }, 2000);
            }).catch(function(err) {
                console.error('Failed to copy:', err);
                showError('Copy Failed', 'Failed to copy to clipboard');
            });
        }
    </script>
</x-layouts.frontend>
