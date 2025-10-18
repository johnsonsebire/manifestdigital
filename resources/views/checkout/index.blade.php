<x-layouts.frontend title="Checkout | Manifest Digital">
    @push('styles')
        @vite('resources/css/checkout.css')
    @endpush

    {{-- Hero Section --}}
    <section class="checkout-hero">
        <div class="container">
            <h1>Checkout</h1>
            <p class="subtitle">Complete your order</p>
        </div>
    </section>

    {{-- Main Checkout Section --}}
    <div class="checkout-container">
    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="alert alert-success" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error" role="alert">
            <p>{{ session('error') }}</p>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-error" role="alert">
            <h3>Please fix the following errors:</h3>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

        <form action="{{ route('checkout.store') }}" method="POST" id="checkoutForm" class="checkout-form">
            @csrf
            
            <div class="checkout-layout">
                {{-- Checkout Form Column --}}
                <div class="checkout-main">
                    {{-- Customer Information --}}
                    <div class="checkout-form-section">
                        <div class="checkout-section-header">
                            <h2>Customer Information</h2>
                            <p>Enter your details for order processing</p>
                        </div>

                            @if($user)
                                {{-- Authenticated User --}}
                                <div class="alert alert-success">
                                    <p>
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
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="customer_name" class="form-label form-label-required">Full Name</label>
                                        <input 
                                            type="text" 
                                            id="customer_name" 
                                            name="customer_name" 
                                            value="{{ old('customer_name') }}"
                                            required
                                            class="form-input"
                                        >
                                        @error('customer_name')
                                            <span class="form-error">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="customer_email" class="form-label form-label-required">Email Address</label>
                                        <input 
                                            type="email" 
                                            id="customer_email" 
                                            name="customer_email" 
                                            value="{{ old('customer_email') }}"
                                            required
                                            class="form-input"
                                        >
                                        @error('customer_email')
                                            <span class="form-error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="alert alert-info">
                                        <p>
                                            Already have an account? 
                                            <a href="{{ route('login') }}" class="font-semibold underline hover:text-blue-900">Log in</a> 
                                            for a faster checkout experience.
                                        </p>
                                    </div>
                                </div>
                            @endif

                            {{-- Phone and Address (for all users) --}}
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="customer_phone" class="form-label">Phone Number</label>
                                    <input 
                                        type="tel" 
                                        id="customer_phone" 
                                        name="customer_phone" 
                                        value="{{ old('customer_phone') }}"
                                        class="form-input"
                                    >
                                    @error('customer_phone')
                                        <span class="form-error">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="customer_address" class="form-label">Address</label>
                                    <input 
                                        type="text" 
                                        id="customer_address" 
                                        name="customer_address" 
                                        value="{{ old('customer_address') }}"
                                        class="form-input"
                                    >
                                    @error('customer_address')
                                        <span class="form-error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Payment Method --}}
                        <div class="checkout-form-section">
                            <div class="checkout-section-header">
                                <h2>Payment Method</h2>
                                <p>Choose how you would like to pay</p>
                            </div>

                            <div class="payment-methods">
                                @php
                                    $paymentMethods = [
                                        'paystack' => ['name' => 'Paystack', 'description' => 'Pay with card via Paystack', 'icon' => '💳'],
                                        'stripe' => ['name' => 'Stripe', 'description' => 'Pay with card via Stripe', 'icon' => '💳'],
                                        'paypal' => ['name' => 'PayPal', 'description' => 'Pay with your PayPal account', 'icon' => '🅿️'],
                                        'bank_transfer' => ['name' => 'Bank Transfer', 'description' => 'Manual bank transfer', 'icon' => '🏦'],
                                    ];
                                @endphp

                                @foreach($paymentMethods as $method => $details)
                                    <label class="payment-method-option {{ old('payment_method', 'paystack') === $method ? 'selected' : '' }}">
                                        <input 
                                            type="radio" 
                                            name="payment_method" 
                                            value="{{ $method }}" 
                                            {{ old('payment_method', 'paystack') === $method ? 'checked' : '' }}
                                            required
                                            class="payment-method-radio"
                                        >
                                        <div class="payment-method-icon">{{ $details['icon'] }}</div>
                                        <div class="payment-method-details">
                                            <h3 class="payment-method-name">{{ $details['name'] }}</h3>
                                            <p class="payment-method-description">{{ $details['description'] }}</p>
                                        </div>
                                    </label>
                                @endforeach
                            </div>

                            @error('payment_method')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Order Notes (Optional) --}}
                        <div class="checkout-form-section">
                            <div class="checkout-section-header">
                                <h2>Order Notes</h2>
                                <p>Any special requirements or notes about your order (optional)</p>
                            </div>
                            <div class="form-group">
                                <textarea 
                                    name="notes" 
                                    rows="4" 
                                    placeholder="Any special requirements or notes about your order..."
                                    class="form-textarea"
                                >{{ old('notes') }}</textarea>
                            </div>
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
                <div class="order-summary">
                    <h3>Order Summary</h3>

                            {{-- Cart Items --}}
                            <div class="order-items">
                                @foreach($cart['items'] as $item)
                                    <div class="order-item">
                                        <div class="order-item-image-container">
                                            @if($item['image_url'])
                                                <img src="{{ $item['image_url'] }}" alt="{{ $item['service_title'] }}" class="order-item-image">
                                            @else
                                                <div class="order-item-image order-item-image-placeholder">
                                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="order-item-details">
                                            <h4 class="order-item-name">{{ $item['service_title'] }}</h4>
                                            @if($item['variant_name'])
                                                <p class="order-item-variant">{{ $item['variant_name'] }}</p>
                                            @endif
                                            <p class="order-item-quantity">Qty: {{ $item['quantity'] }}</p>
                                        </div>
                                        <div class="order-item-price">${{ number_format($item['price'] * $item['quantity'], 2) }}</div>
                                    </div>
                                @endforeach
                            </div>

                            {{-- Totals --}}
                            <div class="order-summary-row">
                                <span class="order-summary-label">Subtotal ({{ $cart['count'] }} items)</span>
                                <span class="order-summary-value">{{ $cart['formatted_subtotal'] }}</span>
                            </div>
                            <div class="order-summary-row">
                                <span class="order-summary-label">Tax</span>
                                <span class="order-summary-value">$0.00</span>
                            </div>
                            
                            <div class="order-summary-divider"></div>
                            
                            <div class="order-total">
                                <div class="order-summary-row">
                                    <span class="order-summary-label">Total</span>
                                    <span class="order-summary-value">{{ $cart['formatted_subtotal'] }}</span>
                                </div>
                            </div>

                            {{-- Place Order Button --}}
                            <div class="checkout-actions">
                                <button 
                                    type="submit" 
                                    class="btn-place-order">
                                    Place Order
                                </button>
                            </div>

                            <div style="text-align: center; margin-top: 16px;">
                                <a href="{{ route('cart.index') }}" class="btn-back">
                                    ← Back to Cart
                                </a>
                            </div>

                            {{-- Security Badges --}}
                            <div class="security-badges">
                                <div class="security-badge">
                                    <svg class="security-badge-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                    <span>SSL Secure</span>
                                </div>
                                <div class="security-badge">
                                    <svg class="security-badge-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                    <span>Money-back</span>
                                </div>
                            </div>
                </div>
            </div>
        </form>
    </div>

    {{-- Checkout JavaScript --}}
    <script>
        // Handle payment method selection visual feedback
        document.addEventListener('DOMContentLoaded', function() {
            const paymentOptions = document.querySelectorAll('.payment-method-option');
            const radioInputs = document.querySelectorAll('input[name="payment_method"]');

            radioInputs.forEach(radio => {
                radio.addEventListener('change', function() {
                    // Remove selected class from all options
                    paymentOptions.forEach(option => {
                        option.classList.remove('selected');
                    });
                    
                    // Add selected class to the chosen option
                    if (this.checked) {
                        this.closest('.payment-method-option').classList.add('selected');
                    }
                });
            });

            // Form validation feedback
            const form = document.getElementById('checkoutForm');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const submitButton = form.querySelector('.btn-place-order');
                    if (submitButton) {
                        submitButton.textContent = 'Processing...';
                        submitButton.disabled = true;
                    }
                });
            }
        });
    </script>
</x-layouts.frontend>
