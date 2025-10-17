<x-layouts.frontend title="Checkout | Manifest Digital">
    {{-- Hero Section --}}
    <section class="bg-gradient-to-br from-purple-900 via-purple-800 to-indigo-900 text-white py-16">
        <div class="container mx-auto px-4">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Checkout</h1>
            <p class="text-xl text-purple-100">Complete your order</p>
        </div>
    </section>

    {{-- Main Checkout Section --}}
    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4">
            {{-- Alert Messages --}}
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                    <h3 class="font-bold mb-2">Please fix the following errors:</h3>
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('checkout.store') }}" method="POST" id="checkoutForm">
                @csrf
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    {{-- Checkout Form Column --}}
                    <div class="lg:col-span-2 space-y-6">
                        {{-- Customer Information --}}
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h2 class="text-2xl font-bold text-gray-900 mb-6">Customer Information</h2>

                            @if($user)
                                {{-- Authenticated User --}}
                                <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                                    <p class="text-green-800">
                                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Logged in as: <strong>{{ $user->name }} ({{ $user->email }})</strong>
                                    </p>
                                </div>

                                {{-- Hidden fields for authenticated users --}}
                                <input type="hidden" name="customer_name" value="{{ $user->name }}">
                                <input type="hidden" name="customer_email" value="{{ $user->email }}">
                            @else
                                {{-- Guest Checkout Fields --}}
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label for="customer_name" class="block text-sm font-semibold text-gray-700 mb-2">Full Name *</label>
                                        <input 
                                            type="text" 
                                            id="customer_name" 
                                            name="customer_name" 
                                            value="{{ old('customer_name') }}"
                                            required
                                            class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500"
                                        >
                                        @error('customer_name')
                                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="customer_email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address *</label>
                                        <input 
                                            type="email" 
                                            id="customer_email" 
                                            name="customer_email" 
                                            value="{{ old('customer_email') }}"
                                            required
                                            class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500"
                                        >
                                        @error('customer_email')
                                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                                    <p class="text-blue-800 text-sm">
                                        Already have an account? 
                                        <a href="{{ route('login') }}" class="font-semibold underline hover:text-blue-900">Log in</a> 
                                        for a faster checkout experience.
                                    </p>
                                </div>
                            @endif

                            {{-- Phone and Address (for all users) --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="customer_phone" class="block text-sm font-semibold text-gray-700 mb-2">Phone Number</label>
                                    <input 
                                        type="tel" 
                                        id="customer_phone" 
                                        name="customer_phone" 
                                        value="{{ old('customer_phone') }}"
                                        class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500"
                                    >
                                    @error('customer_phone')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="customer_address" class="block text-sm font-semibold text-gray-700 mb-2">Address</label>
                                    <input 
                                        type="text" 
                                        id="customer_address" 
                                        name="customer_address" 
                                        value="{{ old('customer_address') }}"
                                        class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500"
                                    >
                                    @error('customer_address')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Payment Method --}}
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h2 class="text-2xl font-bold text-gray-900 mb-6">Payment Method</h2>

                            <div class="space-y-3">
                                @php
                                    $paymentMethods = [
                                        'paystack' => ['name' => 'Paystack', 'description' => 'Pay with card via Paystack', 'icon' => '💳'],
                                        'stripe' => ['name' => 'Stripe', 'description' => 'Pay with card via Stripe', 'icon' => '💳'],
                                        'paypal' => ['name' => 'PayPal', 'description' => 'Pay with your PayPal account', 'icon' => '🅿️'],
                                        'bank_transfer' => ['name' => 'Bank Transfer', 'description' => 'Manual bank transfer', 'icon' => '🏦'],
                                    ];
                                @endphp

                                @foreach($paymentMethods as $method => $details)
                                    <label class="flex items-start p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-purple-500 transition-colors">
                                        <input 
                                            type="radio" 
                                            name="payment_method" 
                                            value="{{ $method }}" 
                                            {{ old('payment_method', 'paystack') === $method ? 'checked' : '' }}
                                            required
                                            class="mt-1 text-purple-600 focus:ring-purple-500"
                                        >
                                        <div class="ml-3 flex-1">
                                            <div class="flex items-center gap-2">
                                                <span class="text-2xl">{{ $details['icon'] }}</span>
                                                <span class="font-bold text-gray-900">{{ $details['name'] }}</span>
                                            </div>
                                            <p class="text-sm text-gray-600">{{ $details['description'] }}</p>
                                        </div>
                                    </label>
                                @endforeach
                            </div>

                            @error('payment_method')
                                <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Order Notes (Optional) --}}
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h2 class="text-2xl font-bold text-gray-900 mb-6">Order Notes (Optional)</h2>
                            <textarea 
                                name="notes" 
                                rows="4" 
                                placeholder="Any special requirements or notes about your order..."
                                class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500"
                            >{{ old('notes') }}</textarea>
                        </div>

                        {{-- Cart Items (Hidden for Validation) --}}
                        @foreach($cart['items'] as $index => $item)
                            <input type="hidden" name="items[{{ $index }}][service_id]" value="{{ $item['service_id'] }}">
                            <input type="hidden" name="items[{{ $index }}][variant_id]" value="{{ $item['variant_id'] }}">
                            <input type="hidden" name="items[{{ $index }}][quantity]" value="{{ $item['quantity'] }}">
                            <input type="hidden" name="items[{{ $index }}][price]" value="{{ $item['price'] }}">
                        @endforeach
                    </div>

                    {{-- Order Summary Sidebar --}}
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-lg shadow-md p-6 sticky top-24">
                            <h2 class="text-2xl font-bold text-gray-900 mb-6">Order Summary</h2>

                            {{-- Cart Items --}}
                            <div class="space-y-4 mb-6 max-h-96 overflow-y-auto">
                                @foreach($cart['items'] as $item)
                                    <div class="flex gap-3 pb-4 border-b border-gray-200">
                                        <div class="w-16 h-16 rounded bg-gradient-to-br from-purple-500 to-indigo-600 flex-shrink-0 flex items-center justify-center">
                                            @if($item['image_url'])
                                                <img src="{{ $item['image_url'] }}" alt="{{ $item['service_title'] }}" class="w-full h-full object-cover rounded">
                                            @else
                                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                                </svg>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h4 class="font-semibold text-gray-900 text-sm">{{ $item['service_title'] }}</h4>
                                            @if($item['variant_name'])
                                                <p class="text-xs text-gray-600">{{ $item['variant_name'] }}</p>
                                            @endif
                                            <div class="flex justify-between items-center mt-1">
                                                <span class="text-sm text-gray-600">Qty: {{ $item['quantity'] }}</span>
                                                <span class="font-bold text-purple-600">${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            {{-- Totals --}}
                            <div class="space-y-3 mb-6">
                                <div class="flex justify-between text-gray-700">
                                    <span>Subtotal ({{ $cart['count'] }} items)</span>
                                    <span class="font-semibold">{{ $cart['formatted_subtotal'] }}</span>
                                </div>
                                <div class="flex justify-between text-gray-700">
                                    <span>Tax</span>
                                    <span>$0.00</span>
                                </div>
                                <div class="border-t border-gray-200 pt-3">
                                    <div class="flex justify-between text-2xl font-bold">
                                        <span class="text-gray-900">Total</span>
                                        <span class="text-purple-600">{{ $cart['formatted_subtotal'] }}</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Place Order Button --}}
                            <button 
                                type="submit" 
                                class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-4 px-6 rounded-lg mb-3 transition-colors duration-200">
                                Place Order
                            </button>

                            <a href="{{ route('cart.index') }}" class="block text-center text-purple-600 hover:text-purple-700 font-semibold">
                                ← Back to Cart
                            </a>

                            {{-- Security Badges --}}
                            <div class="mt-6 pt-6 border-t border-gray-200 space-y-2 text-sm text-gray-600">
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                    <span>Secure SSL Encryption</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                    <span>Money-back Guarantee</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</x-layouts.frontend>
