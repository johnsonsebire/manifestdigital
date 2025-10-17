<x-layouts.frontend title="Shopping Cart | Manifest Digital">
    {{-- Hero Section --}}
    <section class="bg-gradient-to-br from-purple-900 via-purple-800 to-indigo-900 text-white py-16">
        <div class="container mx-auto px-4">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Shopping Cart</h1>
            <p class="text-xl text-purple-100">Review your items before checkout</p>
        </div>
    </section>

    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
            <p>{{ session('error') }}</p>
        </div>
    @endif

    @if(session('warning'))
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4" role="alert">
            <p>{{ session('warning') }}</p>
        </div>
    @endif

    {{-- Price Change Warnings --}}
    @if(!$validation['valid'])
        <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 mb-6">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-yellow-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <div>
                    <h3 class="font-bold text-yellow-800 mb-2">Price Changes Detected</h3>
                    <ul class="list-disc list-inside text-yellow-700">
                        @foreach($validation['errors'] as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    {{-- Main Cart Section --}}
    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4">
            @if($cart['count'] === 0)
                {{-- Empty Cart --}}
                <div class="bg-white rounded-lg shadow-md p-12 text-center max-w-2xl mx-auto">
                    <svg class="w-24 h-24 mx-auto text-gray-400 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Your cart is empty</h2>
                    <p class="text-gray-600 mb-8">Looks like you haven't added anything to your cart yet.</p>
                    <a href="{{ route('services.index') }}" class="inline-block bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-8 rounded-lg transition-colors duration-200">
                        Browse Services
                    </a>
                </div>
            @else
                {{-- Cart with Items --}}
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    {{-- Cart Items Column --}}
                    <div class="lg:col-span-2 space-y-4">
                        @foreach($cart['items'] as $index => $item)
                            @php
                                $cartKey = $item['variant_id'] ? "s{$item['service_id']}_v{$item['variant_id']}" : "s{$item['service_id']}";
                            @endphp
                            <div class="bg-white rounded-lg shadow-md p-6 cart-item" data-cart-key="{{ $cartKey }}">
                                <div class="flex items-start gap-6">
                                    {{-- Item Image --}}
                                    <div class="w-24 h-24 rounded-lg bg-gradient-to-br from-purple-500 to-indigo-600 flex-shrink-0 flex items-center justify-center">
                                        @if($item['image_url'])
                                            <img src="{{ $item['image_url'] }}" alt="{{ $item['service_title'] }}" class="w-full h-full object-cover rounded-lg">
                                        @else
                                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                            </svg>
                                        @endif
                                    </div>

                                    {{-- Item Details --}}
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-start justify-between mb-2">
                                            <div>
                                                <h3 class="text-lg font-bold text-gray-900">
                                                    <a href="{{ route('services.show', $item['service_slug']) }}" class="hover:text-purple-600">
                                                        {{ $item['service_title'] }}
                                                    </a>
                                                </h3>
                                                @if($item['variant_name'])
                                                    <p class="text-sm text-gray-600">Variant: {{ $item['variant_name'] }}</p>
                                                @endif
                                            </div>
                                            <button onclick="removeFromCart('{{ $cartKey }}')" class="text-red-600 hover:text-red-700">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>

                                        <div class="flex items-center justify-between">
                                            {{-- Quantity Control --}}
                                            <div class="flex items-center gap-2">
                                                <label class="text-sm text-gray-600">Quantity:</label>
                                                <div class="flex items-center border border-gray-300 rounded-lg">
                                                    <button onclick="updateQuantity('{{ $cartKey }}', {{ $item['quantity'] - 1 }})" class="px-3 py-1 hover:bg-gray-100">-</button>
                                                    <input type="number" value="{{ $item['quantity'] }}" min="1" max="100" 
                                                           onchange="updateQuantity('{{ $cartKey }}', this.value)"
                                                           class="w-16 text-center border-x border-gray-300 py-1 focus:outline-none">
                                                    <button onclick="updateQuantity('{{ $cartKey }}', {{ $item['quantity'] + 1 }})" class="px-3 py-1 hover:bg-gray-100">+</button>
                                                </div>
                                            </div>

                                            {{-- Price --}}
                                            <div class="text-right">
                                                <p class="text-sm text-gray-600">${{ number_format($item['price'], 2) }} each</p>
                                                <p class="text-xl font-bold text-purple-600">${{ number_format($item['price'] * $item['quantity'], 2) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        {{-- Clear Cart Button --}}
                        <div class="pt-4">
                            <button onclick="clearCart()" class="text-red-600 hover:text-red-700 font-semibold">
                                <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Clear Cart
                            </button>
                        </div>
                    </div>

                    {{-- Order Summary Sidebar --}}
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-lg shadow-md p-6 sticky top-24">
                            <h2 class="text-2xl font-bold text-gray-900 mb-6">Order Summary</h2>

                            <div class="space-y-4 mb-6">
                                <div class="flex justify-between text-gray-700">
                                    <span>Subtotal ({{ $cart['count'] }} items)</span>
                                    <span id="subtotalAmount" class="font-semibold">{{ $cart['formatted_subtotal'] }}</span>
                                </div>
                                <div class="flex justify-between text-gray-700">
                                    <span>Tax</span>
                                    <span>Calculated at checkout</span>
                                </div>
                                <div class="border-t border-gray-200 pt-4">
                                    <div class="flex justify-between text-xl font-bold text-gray-900">
                                        <span>Total</span>
                                        <span id="totalAmount" class="text-purple-600">{{ $cart['formatted_subtotal'] }}</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Checkout Button --}}
                            <a href="{{ route('checkout.index') }}" class="block w-full bg-purple-600 hover:bg-purple-700 text-white text-center font-bold py-4 px-6 rounded-lg mb-3 transition-colors duration-200">
                                Proceed to Checkout
                            </a>

                            <a href="{{ route('services.index') }}" class="block w-full text-center border-2 border-purple-600 text-purple-600 hover:bg-purple-50 font-bold py-4 px-6 rounded-lg transition-colors duration-200">
                                Continue Shopping
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>

    {{-- Cart JavaScript --}}
    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        // Update cart item quantity
        function updateQuantity(cartKey, quantity) {
            quantity = parseInt(quantity);
            if (quantity < 1) {
                removeFromCart(cartKey);
                return;
            }

            fetch(`/cart/update/${cartKey}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ quantity })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload(); // Reload to update totals
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to update cart');
            });
        }

        // Remove item from cart
        function removeFromCart(cartKey) {
            if (!confirm('Remove this item from cart?')) return;

            fetch(`/cart/remove/${cartKey}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to remove item');
            });
        }

        // Clear entire cart
        function clearCart() {
            if (!confirm('Remove all items from cart?')) return;

            fetch('/cart/clear', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to clear cart');
            });
        }
    </script>
</x-layouts.frontend>
