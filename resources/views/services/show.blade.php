<x-layouts.frontend :title="$service->title . ' | Manifest Digital'">
    {{-- Hero Section with Service Title --}}
    <section class="bg-gradient-to-br from-purple-900 via-purple-800 to-indigo-900 text-white py-16">
        <div class="container mx-auto px-4">
            {{-- Breadcrumbs --}}
            <nav class="mb-6">
                <ol class="flex items-center space-x-2 text-sm text-purple-200">
                    <li><a href="{{ route('home') }}" class="hover:text-white">Home</a></li>
                    <li>/</li>
                    <li><a href="{{ route('services.index') }}" class="hover:text-white">Services</a></li>
                    @if($service->categories->isNotEmpty())
                        <li>/</li>
                        <li><a href="{{ route('categories.show', $service->categories->first()->slug) }}" class="hover:text-white">{{ $service->categories->first()->title }}</a></li>
                    @endif
                    <li>/</li>
                    <li class="text-white font-semibold">{{ $service->title }}</li>
                </ol>
            </nav>

            <div class="max-w-4xl">
                {{-- Service Type Badge --}}
                <span class="inline-block px-4 py-2 text-sm font-semibold rounded-full bg-purple-100 text-purple-700 mb-4">
                    {{ ucfirst(str_replace('_', ' ', $service->type)) }}
                </span>

                <h1 class="text-4xl md:text-5xl font-bold mb-4">{{ $service->title }}</h1>
                <p class="text-xl text-purple-100 mb-6">{{ $service->description }}</p>

                {{-- Price Display --}}
                <div class="flex items-center gap-4 mb-6">
                    <span class="text-4xl font-bold text-white">${{ number_format($service->price, 2) }}</span>
                </div>

                {{-- Quick CTA --}}
                <div class="flex gap-4">
                    <button 
                        onclick="scrollToOrder()"
                        class="bg-white text-purple-700 font-bold py-3 px-8 rounded-lg hover:bg-purple-50 transition-colors duration-200">
                        Order Now
                    </button>
                    <a href="{{ route('contact') }}" class="border-2 border-white text-white font-bold py-3 px-8 rounded-lg hover:bg-white hover:text-purple-700 transition-colors duration-200">
                        Contact Us
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Main Content Section --}}
    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Main Content Column --}}
                <div class="lg:col-span-2">
                    {{-- Service Details --}}
                    <div class="bg-white rounded-lg shadow-md p-8 mb-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Service Details</h2>
                        <div class="prose max-w-none text-gray-700">
                            {!! nl2br(e($service->full_description ?? $service->description)) !!}
                        </div>
                    </div>

                    {{-- Features Section --}}
                    @if(isset($service->metadata['features']) && is_array($service->metadata['features']))
                        <div class="bg-white rounded-lg shadow-md p-8 mb-8">
                            <h2 class="text-2xl font-bold text-gray-900 mb-6">What's Included</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($service->metadata['features'] as $feature)
                                    <div class="flex items-start gap-3">
                                        <svg class="w-6 h-6 text-green-500 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        <span class="text-gray-700">{{ $feature }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Service Variants --}}
                    @if($service->variants->isNotEmpty())
                        <div class="bg-white rounded-lg shadow-md p-8 mb-8">
                            <h2 class="text-2xl font-bold text-gray-900 mb-6">Available Options</h2>
                            <div class="space-y-4">
                                @foreach($service->variants as $variant)
                                    @if($variant->available)
                                        <div class="border border-gray-200 rounded-lg p-6 hover:border-purple-500 transition-colors cursor-pointer variant-option" data-variant-id="{{ $variant->id }}" data-variant-price="{{ $variant->price }}">
                                            <div class="flex justify-between items-start mb-3">
                                                <h3 class="text-lg font-bold text-gray-900">{{ $variant->name }}</h3>
                                                <div class="text-right">
                                                    <span class="text-xl font-bold text-gray-900">${{ number_format($variant->price, 2) }}</span>
                                                </div>
                                            </div>
                                            @if($variant->description)
                                                <p class="text-gray-600 mb-3">{{ $variant->description }}</p>
                                            @endif
                                            @if(isset($variant->features) && is_array($variant->features))
                                                <ul class="space-y-2">
                                                    @foreach($variant->features as $feature)
                                                        <li class="flex items-center gap-2 text-sm text-gray-700">
                                                            <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                            </svg>
                                                            {{ $feature }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Related Services --}}
                    @if($relatedServices->isNotEmpty())
                        <div class="bg-white rounded-lg shadow-md p-8">
                            <h2 class="text-2xl font-bold text-gray-900 mb-6">Related Services</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @foreach($relatedServices as $related)
                                    <a href="{{ route('services.show', $related->slug) }}" class="border border-gray-200 rounded-lg p-4 hover:border-purple-500 hover:shadow-md transition-all duration-200">
                                        <h3 class="font-bold text-gray-900 mb-2">{{ $related->title }}</h3>
                                        <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $related->description }}</p>
                                        <div class="flex items-center justify-between">
                                            <span class="text-lg font-bold text-purple-600">
                                                ${{ number_format($related->price, 2) }}
                                            </span>
                                            <span class="text-sm text-purple-600 font-semibold">View Details →</span>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Sidebar (Order Form) --}}
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-md p-6 sticky top-24" id="orderForm">
                        <h3 class="text-xl font-bold text-gray-900 mb-6">Order This Service</h3>

                        {{-- Selected Price Display --}}
                        <div class="bg-purple-50 rounded-lg p-4 mb-6">
                            <div class="text-sm text-gray-600 mb-1">Total Price</div>
                            <div class="text-3xl font-bold text-purple-600" id="displayPrice">
                                ${{ number_format($service->price, 2) }}
                            </div>
                        </div>

                        {{-- Variant Selection (if applicable) --}}
                        @if($service->variants->isNotEmpty())
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Select Option</label>
                                <select id="variantSelect" class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500">
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
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Quantity</label>
                            <input 
                                type="number" 
                                id="quantity" 
                                value="1" 
                                min="1" 
                                class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500"
                            >
                        </div>

                        {{-- Add to Cart Button --}}
                        <button 
                            onclick="addToCart()"
                            class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-4 px-6 rounded-lg mb-3 transition-colors duration-200">
                            Add to Cart
                        </button>

                        {{-- Request Quote Button --}}
                        <a 
                            href="{{ route('request-quote') }}" 
                            class="block w-full text-center border-2 border-purple-600 text-purple-600 hover:bg-purple-50 font-bold py-4 px-6 rounded-lg transition-colors duration-200">
                            Request Custom Quote
                        </a>

                        {{-- Service Info --}}
                        <div class="mt-6 pt-6 border-t border-gray-200 space-y-3 text-sm text-gray-600">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Professional team</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Money-back guarantee</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>24/7 support</span>
                            </div>
                        </div>
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
                    // Show success message
                    alert('✓ Added to cart successfully!\n\nGo to cart to checkout.');
                    
                    // Optional: Update cart count in navbar if you have one
                    // updateCartCount(data.cart.count);
                    
                    // Optional: Redirect to cart
                    if (confirm('View cart now?')) {
                        window.location.href = '/cart';
                    }
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                button.disabled = false;
                button.textContent = originalText;
                console.error('Error:', error);
                alert('Failed to add to cart. Please try again.');
            });
        }
    </script>
</x-layouts.frontend>
