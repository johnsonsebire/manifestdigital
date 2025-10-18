<x-layouts.frontend title="Shopping Cart | Manifest Digital">
    @push('styles')
        @vite('resources/css/cart.css')
    @endpush

    {{-- Hero Section --}}
    <section class="cart-hero">
        <div class="container">
            <h1>Shopping Cart</h1>
            <p class="subtitle">Review your items before checkout</p>
        </div>
    </section>

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

    @if(session('warning'))
        <div class="alert alert-warning" role="alert">
            <p>{{ session('warning') }}</p>
        </div>
    @endif

    {{-- Price Change Warnings --}}
    @if(!$validation['valid'])
        <div class="price-warning">
            <div class="warning-content">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <div>
                    <h3>Price Changes Detected</h3>
                    <ul>
                        @foreach($validation['errors'] as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    {{-- Main Cart Section --}}
    <div class="cart-container">
        @if($cart['count'] === 0)
            {{-- Empty Cart --}}
            <div class="empty-cart">
                <div class="empty-cart-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <h2>Your cart is empty</h2>
                <p>Looks like you haven't added anything to your cart yet.</p>
                <a href="{{ route('services.index') }}" class="empty-cart-cta">
                    Browse Services
                </a>
            </div>
        @else
            {{-- Cart with Items --}}
            <div class="cart-layout">
                {{-- Cart Items Column --}}
                <div class="cart-items-section">
                    <div class="cart-section-header">
                        <h2>Your Items</h2>
                        <span class="cart-items-count">{{ $cart['count'] }} items</span>
                    </div>
                    <div class="cart-items-list">
                        @foreach($cart['items'] as $index => $item)
                            @php
                                $cartKey = $item['variant_id'] ? "s{$item['service_id']}_v{$item['variant_id']}" : "s{$item['service_id']}";
                            @endphp
                            <div class="cart-item" data-cart-key="{{ $cartKey }}">
                                <div class="cart-item-content">
                                    {{-- Item Image --}}
                                    <div class="cart-item-image">
                                        @if($item['image_url'])
                                            <img src="{{ $item['image_url'] }}" alt="{{ $item['service_title'] }}">
                                        @else
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                            </svg>
                                        @endif
                                    </div>

                                    {{-- Item Details --}}
                                    <div class="cart-item-details">
                                        <div class="cart-item-header">
                                            <div class="cart-item-info">
                                                <h3 class="cart-item-title">
                                                    <a href="{{ route('services.show', $item['service_slug']) }}">
                                                        {{ $item['service_title'] }}
                                                    </a>
                                                </h3>
                                                @if($item['variant_name'])
                                                    <p class="cart-item-variant">Variant: {{ $item['variant_name'] }}</p>
                                                @endif
                                            </div>
                                            <button onclick="removeFromCart('{{ $cartKey }}')" 
                                                    class="cart-item-remove"
                                                    data-cart-key="{{ $cartKey }}">
                                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>

                                        <div class="cart-item-controls">
                                            {{-- Quantity Control --}}
                                            <div class="cart-quantity-controls">
                                                <label class="cart-quantity-label">Quantity:</label>
                                                <div class="quantity-selector">
                                                    <button onclick="decreaseQuantity('{{ $cartKey }}')" class="quantity-btn">-</button>
                                                    <input type="number" value="{{ $item['quantity'] }}" min="1" max="100" 
                                                           onchange="updateQuantity('{{ $cartKey }}', this.value)"
                                                           data-cart-key="{{ $cartKey }}"
                                                           class="quantity-input">
                                                    <button onclick="increaseQuantity('{{ $cartKey }}')" class="quantity-btn">+</button>
                                                </div>
                                            </div>

                                            {{-- Price --}}
                                            <div class="cart-item-pricing">
                                                <p class="cart-item-unit-price">${{ number_format($item['price'], 2) }} each</p>
                                                <p class="cart-item-total-price">${{ number_format($item['price'] * $item['quantity'], 2) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    {{-- Clear Cart Button --}}
                    <div class="cart-actions">
                        <button onclick="clearCart()" class="clear-cart-btn">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Clear Cart
                        </button>
                    </div>
                </div>

                {{-- Order Summary Sidebar --}}
                <div class="cart-summary">
                    <h3>Order Summary</h3>

                    <div class="summary-row">
                        <span class="summary-row-label">Subtotal ({{ $cart['count'] }} items)</span>
                        <span id="subtotalAmount" class="summary-row-value" data-subtotal>{{ $cart['formatted_subtotal'] }}</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-row-label">Tax</span>
                        <span class="summary-row-value">Calculated at checkout</span>
                    </div>
                    <div class="summary-divider"></div>
                    <div class="summary-total">
                        <div class="summary-row">
                            <span class="summary-row-label">Total</span>
                            <span id="totalAmount" class="summary-row-value" data-total>{{ $cart['formatted_subtotal'] }}</span>
                        </div>
                    </div>

                    {{-- Checkout Buttons --}}
                    <div class="cart-summary-actions">
                        <a href="{{ route('checkout.index') }}" class="checkout-btn">
                            Proceed to Checkout
                        </a>

                        <a href="{{ route('services.index') }}" class="continue-shopping-btn">
                            Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>

    {{-- Cart JavaScript --}}
    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        // Increase quantity by 1
        function increaseQuantity(cartKey) {
            const quantityInput = document.querySelector(`input[data-cart-key="${cartKey}"]`);
            if (quantityInput) {
                const currentQuantity = parseInt(quantityInput.value);
                updateQuantity(cartKey, currentQuantity + 1);
            }
        }

        // Decrease quantity by 1
        function decreaseQuantity(cartKey) {
            const quantityInput = document.querySelector(`input[data-cart-key="${cartKey}"]`);
            if (quantityInput) {
                const currentQuantity = parseInt(quantityInput.value);
                if (currentQuantity > 1) {
                    updateQuantity(cartKey, currentQuantity - 1);
                } else {
                    // Show confirmation only when removing the last item
                    removeFromCart(cartKey);
                }
            }
        }

        // Update cart item quantity
        function updateQuantity(cartKey, quantity) {
            quantity = parseInt(quantity);
            if (quantity < 1) {
                removeFromCart(cartKey);
                return;
            }

            // Show loading state
            const quantityInput = document.querySelector(`input[data-cart-key="${cartKey}"]`);
            const cartItem = quantityInput?.closest('.cart-item');
            if (cartItem) {
                cartItem.style.opacity = '0.6';
                cartItem.style.pointerEvents = 'none';
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
                    // Update quantity display
                    updateCartItemQuantity(cartKey, quantity);
                    // Update line total for this item
                    updateCartItemTotal(cartKey, data.cart.items);
                    // Update pricing
                    updateCartTotals(data.cart);
                    // Show success message
                    showCartMessage('Quantity updated successfully', 'success');
                } else {
                    // Reset UI and show error
                    if (cartItem) {
                        cartItem.style.opacity = '1';
                        cartItem.style.pointerEvents = 'auto';
                    }
                    showCartMessage(data.message || 'Failed to update quantity', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                if (cartItem) {
                    cartItem.style.opacity = '1';
                    cartItem.style.pointerEvents = 'auto';
                }
                showCartMessage('Failed to update cart', 'error');
            });
        }

        // Remove item from cart
        function removeFromCart(cartKey) {
            if (!confirm('Remove this item from cart?')) return;

            const cartItem = document.querySelector(`[data-cart-key="${cartKey}"]`)?.closest('.cart-item');
            if (cartItem) {
                cartItem.style.opacity = '0.6';
                cartItem.style.pointerEvents = 'none';
            }

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
                    // Remove item from DOM
                    if (cartItem) {
                        cartItem.style.transform = 'translateX(-100%)';
                        cartItem.style.opacity = '0';
                        setTimeout(() => cartItem.remove(), 300);
                    }
                    // Update totals
                    updateCartTotals(data.cart);
                    // Show success message
                    showCartMessage('Item removed from cart', 'success');
                    
                    // Check if cart is empty
                    if (data.cart.items.length === 0) {
                        setTimeout(() => location.reload(), 1000);
                    }
                } else {
                    if (cartItem) {
                        cartItem.style.opacity = '1';
                        cartItem.style.pointerEvents = 'auto';
                    }
                    showCartMessage(data.message || 'Failed to remove item', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                if (cartItem) {
                    cartItem.style.opacity = '1';
                    cartItem.style.pointerEvents = 'auto';
                }
                showCartMessage('Failed to remove item', 'error');
            });
        }

        // Clear entire cart
        function clearCart() {
            if (!confirm('Remove all items from cart?')) return;

            const cartContainer = document.querySelector('.cart-items-section');
            if (cartContainer) {
                cartContainer.style.opacity = '0.6';
                cartContainer.style.pointerEvents = 'none';
            }

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
                    showCartMessage('Cart cleared successfully', 'success');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    if (cartContainer) {
                        cartContainer.style.opacity = '1';
                        cartContainer.style.pointerEvents = 'auto';
                    }
                    showCartMessage(data.message || 'Failed to clear cart', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                if (cartContainer) {
                    cartContainer.style.opacity = '1';
                    cartContainer.style.pointerEvents = 'auto';
                }
                showCartMessage('Failed to clear cart', 'error');
            });
        }

        // Helper function to update cart item quantity in DOM
        function updateCartItemQuantity(cartKey, newQuantity) {
            const quantityInput = document.querySelector(`input[data-cart-key="${cartKey}"]`);
            if (quantityInput) {
                quantityInput.value = newQuantity;
                const cartItem = quantityInput.closest('.cart-item');
                if (cartItem) {
                    cartItem.style.opacity = '1';
                    cartItem.style.pointerEvents = 'auto';
                }
            }
        }

        // Helper function to update individual cart item total
        function updateCartItemTotal(cartKey, cartItems) {
            const cartItem = cartItems.find(item => item.cart_key === cartKey);
            if (cartItem) {
                const totalPriceElement = document.querySelector(`input[data-cart-key="${cartKey}"]`)?.closest('.cart-item')?.querySelector('.cart-item-total-price');
                if (totalPriceElement) {
                    totalPriceElement.textContent = `$${(cartItem.price * cartItem.quantity).toFixed(2)}`;
                }
            }
        }

        // Helper function to update cart totals
        function updateCartTotals(cartData) {
            // Update subtotal
            const subtotalElement = document.querySelector('.summary-row-value[data-subtotal]');
            if (subtotalElement && cartData.formatted_subtotal) {
                subtotalElement.textContent = cartData.formatted_subtotal;
            }

            // Update total (if exists)
            const totalElement = document.querySelector('.summary-row-value[data-total]');
            if (totalElement && cartData.formatted_subtotal) {
                totalElement.textContent = cartData.formatted_subtotal; // For now, total = subtotal
            }

            // Update item counts (both header and summary)
            if (cartData.items) {
                const totalItems = cartData.items.reduce((sum, item) => sum + item.quantity, 0);
                
                // Update header count: "X items"
                const headerCountElement = document.querySelector('.cart-items-count');
                if (headerCountElement) {
                    headerCountElement.textContent = `${totalItems} item${totalItems !== 1 ? 's' : ''}`;
                }
                
                // Update subtotal label: "Subtotal (X items)"
                const subtotalLabelElement = document.querySelector('.summary-row-label');
                if (subtotalLabelElement) {
                    subtotalLabelElement.textContent = `Subtotal (${totalItems} item${totalItems !== 1 ? 's' : ''})`;
                }
            }
        }

        // Helper function to show cart messages
        function showCartMessage(message, type = 'success') {
            // Remove existing messages
            const existingMessage = document.querySelector('.cart-message');
            if (existingMessage) {
                existingMessage.remove();
            }

            // Create new message
            const messageDiv = document.createElement('div');
            messageDiv.className = `cart-message alert alert-${type}`;
            messageDiv.textContent = message;
            messageDiv.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 1000;
                padding: 12px 20px;
                border-radius: 8px;
                font-family: 'Anybody', sans-serif;
                font-weight: 600;
                color: white;
                background: ${type === 'success' ? '#10B981' : '#EF4444'};
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
                transform: translateX(100%);
                transition: transform 0.3s ease;
            `;

            document.body.appendChild(messageDiv);

            // Animate in
            setTimeout(() => {
                messageDiv.style.transform = 'translateX(0)';
            }, 100);

            // Auto remove after 3 seconds
            setTimeout(() => {
                messageDiv.style.transform = 'translateX(100%)';
                setTimeout(() => messageDiv.remove(), 300);
            }, 3000);
        }
    </script>
</x-layouts.frontend>
