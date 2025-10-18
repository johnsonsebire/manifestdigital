<x-layouts.frontend :title="$service->title . ' | Manifest Digital'">
    @push('styles')
        @vite('resources/css/service-detail.css')
    @endpush

    {{-- Hero Section with Service Title --}}
    <section class="service-hero">
        <div class="container">
            {{-- Breadcrumbs --}}
            <nav class="service-breadcrumbs">
                <a href="{{ route('home') }}">Home</a>
                <span>/</span>
                <a href="{{ route('services.index') }}">Services</a>
                @if($service->categories->isNotEmpty())
                    <span>/</span>
                    <a href="{{ route('categories.show', $service->categories->first()->slug) }}">{{ $service->categories->first()->title }}</a>
                @endif
                <span>/</span>
                <span class="current">{{ $service->title }}</span>
            </nav>

            <div class="service-hero-content">
                {{-- Service Type Badge --}}
                <span class="service-type-badge">
                    {{ ucfirst(str_replace('_', ' ', $service->type)) }}
                </span>

                <h1>{{ $service->title }}</h1>
                <p class="subtitle">{{ $service->description }}</p>

                {{-- Price Display --}}
                <div class="service-price-display">
                    <span class="service-price">${{ number_format($service->price, 2) }}</span>
                </div>

                {{-- Quick CTA --}}
                <div class="service-hero-actions">
                    <button 
                        onclick="scrollToOrder()"
                        class="btn-hero-primary">
                        Order Now
                    </button>
                    <a href="{{ route('contact') }}" class="btn-hero-secondary">
                        Contact Us
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Main Content Section --}}
    <section class="service-content">
        <div class="service-layout">
            {{-- Main Content Column --}}
            <div class="service-main">
                {{-- Service Details --}}
                <div class="service-card">
                    <h2>Service Details</h2>
                    <div class="service-description">
                        {!! nl2br(e($service->full_description ?? $service->description)) !!}
                    </div>
                </div>

                {{-- Features Section --}}
                @if(isset($service->metadata['features']) && is_array($service->metadata['features']))
                    <div class="service-card">
                        <h2>What's Included</h2>
                        <div class="features-grid">
                            @foreach($service->metadata['features'] as $feature)
                                <div class="feature-item">
                                    <svg class="feature-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="feature-text">{{ $feature }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Service Variants --}}
                @if($service->variants->isNotEmpty())
                    <div class="service-card">
                        <h2>Available Options</h2>
                        <div class="variants-list">
                            @foreach($service->variants as $variant)
                                @if($variant->available)
                                    <div class="variant-option" data-variant-id="{{ $variant->id }}" data-variant-price="{{ $variant->price }}">
                                        <div class="variant-header">
                                            <h3 class="variant-name">{{ $variant->name }}</h3>
                                            <div class="variant-price">${{ number_format($variant->price, 2) }}</div>
                                        </div>
                                        @if($variant->description)
                                            <p class="variant-description">{{ $variant->description }}</p>
                                        @endif
                                        @if(isset($variant->features) && is_array($variant->features))
                                            <div class="variant-features">
                                                @foreach($variant->features as $feature)
                                                    <div class="variant-feature">
                                                        <svg class="variant-feature-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                        </svg>
                                                        <span>{{ $feature }}</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Related Services --}}
                @if($relatedServices->isNotEmpty())
                    <div class="service-card">
                        <h2>Related Services</h2>
                        <div class="related-services-grid">
                            @foreach($relatedServices as $related)
                                <a href="{{ route('services.show', $related->slug) }}" class="related-service-card">
                                    <h3 class="related-service-title">{{ $related->title }}</h3>
                                    <p class="related-service-description">{{ $related->description }}</p>
                                    <div class="related-service-footer">
                                        <span class="related-service-price">
                                            ${{ number_format($related->price, 2) }}
                                        </span>
                                        <span class="related-service-link">View Details →</span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            {{-- Sidebar (Order Form) --}}
            <div class="order-sidebar" id="orderForm">
                <h3>Order This Service</h3>

                {{-- Selected Price Display --}}
                <div class="price-display">
                    <div class="price-label">Total Price</div>
                    <div class="price-amount" id="displayPrice">
                        ${{ number_format($service->price, 2) }}
                    </div>
                </div>

                {{-- Variant Selection (if applicable) --}}
                @if($service->variants->isNotEmpty())
                    <div class="form-group">
                        <label class="form-label">Select Option</label>
                        <select id="variantSelect" class="form-select">
                            <option value="">Base Service - ${{ number_format($service->price, 2) }}</option>
                            @foreach($service->variants as $variant)
                                @if($variant->available)
                                    <option value="{{ $variant->id }}" data-price="{{ $variant->price }}">
                                        {{ $variant->name }} - ${{ number_format($variant->price, 2) }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                @endif

                {{-- Quantity --}}
                <div class="form-group">
                    <label class="form-label">Quantity</label>
                    <input 
                        type="number" 
                        id="quantity" 
                        value="1" 
                        min="1" 
                        class="form-input"
                    >
                </div>

                {{-- Add to Cart Button --}}
                <button 
                    onclick="addToCart()"
                    class="btn-add-cart">
                    Add to Cart
                </button>

                {{-- Request Quote Button --}}
                <a 
                    href="{{ route('request-quote') }}" 
                    class="btn-quote">
                    Request Custom Quote
                </a>

                {{-- Service Info --}}
                <div class="service-info">
                    <div class="service-info-item">
                        <svg class="service-info-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Professional team</span>
                    </div>
                    <div class="service-info-item">
                        <svg class="service-info-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Money-back guarantee</span>
                    </div>
                    <div class="service-info-item">
                        <svg class="service-info-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>24/7 support</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- JavaScript for Dynamic Pricing and Cart --}}
    <script>
        // Scroll to order form
        function scrollToOrder() {
            document.getElementById('orderForm').scrollIntoView({ behavior: 'smooth', block: 'center' });
        }

        // Update price when variant selected
        const variantSelect = document.getElementById('variantSelect');
        const quantityInput = document.getElementById('quantity');
        const displayPrice = document.getElementById('displayPrice');
        const basePrice = {{ $service->price }};

        if (variantSelect) {
            variantSelect.addEventListener('change', updatePrice);
        }
        
        if (quantityInput) {
            quantityInput.addEventListener('input', updatePrice);
        }

        function updatePrice() {
            let price = basePrice;
            
            if (variantSelect && variantSelect.value) {
                const selectedOption = variantSelect.options[variantSelect.selectedIndex];
                price = parseFloat(selectedOption.dataset.price);
            }

            const quantity = parseInt(quantityInput.value) || 1;
            const totalPrice = price * quantity;

            displayPrice.textContent = '$' + totalPrice.toFixed(2);
        }

        // Add to cart function
        function addToCart() {
            const serviceId = {{ $service->id }};
            const variantId = variantSelect ? (variantSelect.value || null) : null;
            const quantity = parseInt(quantityInput.value) || 1;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

            // Show loading state
            const button = event.target;
            const originalText = button.textContent;
            button.disabled = true;
            button.textContent = 'Adding...';

            fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    service_id: serviceId,
                    variant_id: variantId,
                    quantity: quantity
                })
            })
            .then(response => response.json())
            .then(data => {
                button.disabled = false;
                button.textContent = originalText;

                if (data.success) {
                    // Show success message with cart options
                    showConfirm(
                        'Added to cart successfully!', 
                        'What would you like to do next?', 
                        {
                            confirmText: 'View Cart',
                            cancelText: 'Continue Shopping',
                            onConfirm: () => {
                                window.location.href = '/cart';
                            },
                            onCancel: () => {
                                // Just close modal and continue shopping
                                return true;
                            }
                        }
                    );
                    
                    // Optional: Update cart count in navbar if you have one
                    // updateCartCount(data.cart.count);
                } else {
                    showError('Error', data.message);
                }
            })
            .catch(error => {
                button.disabled = false;
                button.textContent = originalText;
                console.error('Error:', error);
                showError('Failed to add to cart', 'Please try again.');
            });
        }
    </script>
</x-layouts.frontend>
