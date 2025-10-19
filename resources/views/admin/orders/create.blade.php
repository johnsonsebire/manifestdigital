<x-layouts.app :title="'Create New Order'">
    <div class="p-6 max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <a href="{{ route('admin.orders.index') }}" 
                    class="text-sm text-primary-600 hover:text-primary-700 dark:text-primary-400 mb-2 inline-block"
                    wire:navigate>
                    ← Back to Orders
                </a>
                <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Create New Order</h1>
                <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                    Create an order on behalf of a customer
                </p>
            </div>
        </div>

        <!-- Order Creation Form -->
        <div class="bg-white dark:bg-zinc-800 shadow rounded-lg">
            <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700">
                <h2 class="text-lg font-medium text-zinc-900 dark:text-white">Order Details</h2>
            </div>
            
            <form id="orderForm" action="{{ route('admin.orders.store') }}" method="POST" class="p-6">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                    <!-- Customer Information -->
                    <div class="bg-zinc-50 dark:bg-zinc-900 rounded-lg p-4">
                        <h3 class="text-base font-medium text-zinc-900 dark:text-white mb-4">Customer Information</h3>
                        
                        <!-- Customer Type Selection -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                                Customer Type <span class="text-red-500">*</span>
                            </label>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="radio" name="customer_type" value="registered" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-zinc-300 dark:border-zinc-600" {{ old('customer_type', 'registered') == 'registered' ? 'checked' : '' }}>
                                    <span class="ml-2 text-sm text-zinc-700 dark:text-zinc-300">Registered Customer</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="customer_type" value="manual" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-zinc-300 dark:border-zinc-600" {{ old('customer_type') == 'manual' ? 'checked' : '' }}>
                                    <span class="ml-2 text-sm text-zinc-700 dark:text-zinc-300">New Customer (Manual Entry)</span>
                                </label>
                            </div>
                            <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">
                                Choose "Registered Customer" to select from existing customers, or "New Customer" to create an order for someone not yet registered.
                            </p>
                            @error('customer_type')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Registered Customer Selection -->
                        <div id="registeredCustomerSection" class="mb-4">
                            <label for="customer_id" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                                Select Customer <span class="text-red-500">*</span>
                            </label>
                            <select name="customer_id" id="customer_id" class="w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('customer_id') border-red-500 @enderror">
                                <option value="">Select a customer...</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}" 
                                        data-name="{{ $customer->name }}"
                                        data-email="{{ $customer->email }}"
                                        data-phone="{{ $customer->phone }}"
                                        data-address="{{ $customer->address }}"
                                        {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->name }} ({{ $customer->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('customer_id')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Customer Details -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="customer_name" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                                    Customer Name <span class="text-red-500 manual-required">*</span>
                                </label>
                                <input type="text" name="customer_name" id="customer_name" class="w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('customer_name') border-red-500 @enderror" value="{{ old('customer_name') }}" placeholder="Enter customer name">
                                @error('customer_name')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="customer_email" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                                    Customer Email <span class="text-red-500 manual-required">*</span>
                                </label>
                                <input type="email" name="customer_email" id="customer_email" class="w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('customer_email') border-red-500 @enderror" value="{{ old('customer_email') }}" placeholder="Enter customer email">
                                @error('customer_email')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="customer_phone" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Customer Phone</label>
                                <input type="text" name="customer_phone" id="customer_phone" class="w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('customer_phone') border-red-500 @enderror" value="{{ old('customer_phone') }}" placeholder="Enter customer phone">
                                @error('customer_phone')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="customer_address" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Customer Address</label>
                                <textarea name="customer_address" id="customer_address" class="w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('customer_address') border-red-500 @enderror" rows="2" placeholder="Enter customer address">{{ old('customer_address') }}</textarea>
                                @error('customer_address')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Order Status -->
                    <div class="bg-zinc-50 dark:bg-zinc-900 rounded-lg p-4">
                        <h3 class="text-base font-medium text-zinc-900 dark:text-white mb-4">Order Status</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label for="status" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                                    Order Status <span class="text-red-500">*</span>
                                </label>
                                <select name="status" id="status" class="w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('status') border-red-500 @enderror" required>
                                    <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="initiated" {{ old('status') == 'initiated' ? 'selected' : '' }}>Initiated</option>
                                    <option value="paid" {{ old('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                                    <option value="processing" {{ old('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                                @error('status')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="payment_status" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                                    Payment Status <span class="text-red-500">*</span>
                                </label>
                                <select name="payment_status" id="payment_status" class="w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('payment_status') border-red-500 @enderror" required>
                                    <option value="unpaid" {{ old('payment_status', 'unpaid') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                                    <option value="pending" {{ old('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="paid" {{ old('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                                    <option value="partial" {{ old('payment_status') == 'partial' ? 'selected' : '' }}>Partial</option>
                                    <option value="refunded" {{ old('payment_status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
                                </select>
                                @error('payment_status')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="payment_method" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Payment Method</label>
                                <select name="payment_method" id="payment_method" class="w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('payment_method') border-red-500 @enderror">
                                    <option value="">Select payment method...</option>
                                    <option value="paystack" {{ old('payment_method') == 'paystack' ? 'selected' : '' }}>Paystack</option>
                                    <option value="stripe" {{ old('payment_method') == 'stripe' ? 'selected' : '' }}>Stripe</option>
                                    <option value="paypal" {{ old('payment_method') == 'paypal' ? 'selected' : '' }}>PayPal</option>
                                    <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                </select>
                                @error('payment_method')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg mb-6">
                    <div class="px-4 py-3 bg-zinc-50 dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-700 rounded-t-lg flex justify-between items-center">
                        <h3 class="text-base font-medium text-zinc-900 dark:text-white">Order Items</h3>
                        <button type="button" id="addItem" class="inline-flex items-center px-3 py-1.5 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-md transition-colors">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Add Item
                        </button>
                    </div>
                    <div class="p-4">
                        <div id="orderItems" class="space-y-4">
                            <!-- Dynamic order items will be added here -->
                        </div>
                        
                        @error('items')
                            <div class="mt-2 p-3 bg-red-50 dark:bg-red-900/50 border border-red-200 dark:border-red-800 rounded-md">
                                <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="notes" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Order Notes</label>
                        <textarea name="notes" id="notes" class="w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('notes') border-red-500 @enderror" rows="4" placeholder="Additional notes or special instructions...">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="bg-zinc-50 dark:bg-zinc-900 rounded-lg p-4">
                        <h3 class="text-base font-medium text-zinc-900 dark:text-white mb-4">Order Summary</h3>
                        
                        <div class="space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-zinc-600 dark:text-zinc-400">Subtotal:</span>
                                <span id="subtotalDisplay" class="font-medium text-zinc-900 dark:text-white">{{ $userCurrency->symbol }}0.00</span>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label for="discount" class="block text-xs font-medium text-zinc-600 dark:text-zinc-400 mb-1">Discount (₦)</label>
                                    <input type="number" name="discount" id="discount" class="w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500 text-sm @error('discount') border-red-500 @enderror" value="{{ old('discount', 0) }}" min="0" step="0.01">
                                    @error('discount')
                                        <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="tax" class="block text-xs font-medium text-zinc-600 dark:text-zinc-400 mb-1">Tax (₦)</label>
                                    <input type="number" name="tax" id="tax" class="w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500 text-sm @error('tax') border-red-500 @enderror" value="{{ old('tax', 0) }}" min="0" step="0.01">
                                    @error('tax')
                                        <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="pt-3 border-t border-zinc-200 dark:border-zinc-700">
                                <div class="flex justify-between text-lg font-semibold">
                                    <span class="text-zinc-900 dark:text-white">Total:</span>
                                    <span id="totalDisplay" class="text-zinc-900 dark:text-white">{{ $userCurrency->symbol }}0.00</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-700 border border-zinc-300 dark:border-zinc-600 rounded-md hover:bg-zinc-50 dark:hover:bg-zinc-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        Cancel
                    </a>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-primary-600 border border-transparent rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        <svg class="w-4 h-4 mr-1.5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Create Order
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Order Item Template -->
    <script type="text/html" id="orderItemTemplate">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-3 p-3 bg-zinc-50 dark:bg-zinc-900 rounded-lg order-item" data-index="INDEX_PLACEHOLDER">
            <div class="md:col-span-4">
                <label class="block text-xs font-medium text-zinc-600 dark:text-zinc-400 mb-1">Service <span class="text-red-500">*</span></label>
                <select name="items[INDEX_PLACEHOLDER][service_id]" class="w-full text-sm rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500 service-select" required>
                    <option value="">Select a service...</option>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}" data-price="{{ $service->price }}">
                            {{ $service->title }} ({!! $currencyService->formatAmount($service->price ?? 0, $userCurrency->code) !!})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="md:col-span-3">
                <label class="block text-xs font-medium text-zinc-600 dark:text-zinc-400 mb-1">Variant</label>
                <select name="items[INDEX_PLACEHOLDER][variant_id]" class="w-full text-sm rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500 variant-select">
                    <option value="">No variant</option>
                </select>
            </div>
            <div class="md:col-span-2">
                <label class="block text-xs font-medium text-zinc-600 dark:text-zinc-400 mb-1">Quantity <span class="text-red-500">*</span></label>
                <input type="number" name="items[INDEX_PLACEHOLDER][quantity]" class="w-full text-sm rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500 quantity-input" value="1" min="1" max="100" required>
            </div>
            <div class="md:col-span-2">
                <label class="block text-xs font-medium text-zinc-600 dark:text-zinc-400 mb-1">Unit Price (₦) <span class="text-red-500">*</span></label>
                <input type="number" name="items[INDEX_PLACEHOLDER][unit_price]" class="w-full text-sm rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500 price-input" value="0" min="0" step="0.01" required>
            </div>
            <div class="md:col-span-1 flex items-end">
                <button type="button" class="w-full px-2 py-1.5 text-sm text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 border border-red-300 dark:border-red-600 rounded-md hover:bg-red-50 dark:hover:bg-red-900/50 remove-item">
                    <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </button>
            </div>
        </div>
    </script>

    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        let itemIndex = 0;
        const services = @json($services);
        
        // Customer type handling
        const customerTypeRadios = document.querySelectorAll('input[name="customer_type"]');
        const registeredSection = document.getElementById('registeredCustomerSection');
        const customerSelect = document.getElementById('customer_id');
        const manualRequired = document.querySelectorAll('.manual-required');
        
        function toggleCustomerType() {
            const selectedType = document.querySelector('input[name="customer_type"]:checked').value;
            
            if (selectedType === 'registered') {
                registeredSection.style.display = 'block';
                customerSelect.required = true;
                
                // Hide manual required indicators
                manualRequired.forEach(element => {
                    element.style.display = 'none';
                });
                
                // Clear manual fields when switching to registered
                if (customerSelect.value) {
                    const selectedOption = customerSelect.options[customerSelect.selectedIndex];
                    document.getElementById('customer_name').value = selectedOption.dataset.name || '';
                    document.getElementById('customer_email').value = selectedOption.dataset.email || '';
                    document.getElementById('customer_phone').value = selectedOption.dataset.phone || '';
                    document.getElementById('customer_address').value = selectedOption.dataset.address || '';
                }
            } else {
                registeredSection.style.display = 'none';
                customerSelect.required = false;
                customerSelect.value = '';
                
                // Show manual required indicators
                manualRequired.forEach(element => {
                    element.style.display = 'inline';
                });
                
                // Clear fields for manual entry
                document.getElementById('customer_name').value = '';
                document.getElementById('customer_email').value = '';
                document.getElementById('customer_phone').value = '';
                document.getElementById('customer_address').value = '';
            }
        }
        
        // Initialize customer type on page load
        toggleCustomerType();
        
        // Listen for customer type changes
        customerTypeRadios.forEach(radio => {
            radio.addEventListener('change', toggleCustomerType);
        });

        // Auto-fill customer information for registered customers
        customerSelect.addEventListener('change', function() {
            if (document.querySelector('input[name="customer_type"]:checked').value === 'registered') {
                const selectedOption = this.options[this.selectedIndex];
                document.getElementById('customer_name').value = selectedOption.dataset.name || '';
                document.getElementById('customer_email').value = selectedOption.dataset.email || '';
                document.getElementById('customer_phone').value = selectedOption.dataset.phone || '';
                document.getElementById('customer_address').value = selectedOption.dataset.address || '';
            }
        });

        // Add first item on page load
        addOrderItem();

        // Add new order item
        document.getElementById('addItem').addEventListener('click', function() {
            addOrderItem();
        });

        // Remove order item
        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-item')) {
                e.target.closest('.order-item').remove();
                updateTotals();
            }
        });

        // Service selection change
        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('service-select')) {
                const serviceId = e.target.value;
                const orderItem = e.target.closest('.order-item');
                const variantSelect = orderItem.querySelector('.variant-select');
                const priceInput = orderItem.querySelector('.price-input');
                
                // Clear variants
                variantSelect.innerHTML = '<option value="">No variant</option>';
                
                if (serviceId) {
                    const service = services.find(s => s.id == serviceId);
                    if (service) {
                        // Set base price
                        priceInput.value = service.price;
                        
                        // Add variants if available
                        if (service.variants && service.variants.length > 0) {
                            service.variants.forEach(variant => {
                                const option = document.createElement('option');
                                option.value = variant.id;
                                option.dataset.price = variant.price;
                                option.textContent = `${variant.name} (₦${parseFloat(variant.price).toFixed(2)})`;
                                variantSelect.appendChild(option);
                            });
                        }
                    }
                } else {
                    priceInput.value = 0;
                }
                
                updateTotals();
            }
        });

        // Variant selection change
        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('variant-select')) {
                const variantOption = e.target.options[e.target.selectedIndex];
                const orderItem = e.target.closest('.order-item');
                const priceInput = orderItem.querySelector('.price-input');
                
                if (variantOption.dataset.price) {
                    priceInput.value = variantOption.dataset.price;
                } else {
                    // Revert to service base price
                    const serviceSelect = orderItem.querySelector('.service-select');
                    const serviceOption = serviceSelect.options[serviceSelect.selectedIndex];
                    priceInput.value = serviceOption.dataset.price || 0;
                }
                
                updateTotals();
            }
        });

        // Update totals when quantity or price changes
        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('quantity-input') || 
                e.target.classList.contains('price-input') || 
                e.target.id === 'discount' || 
                e.target.id === 'tax') {
                updateTotals();
            }
        });

        function addOrderItem() {
            const template = document.getElementById('orderItemTemplate').innerHTML;
            const itemHtml = template.replace(/INDEX_PLACEHOLDER/g, itemIndex);
            const orderItemsContainer = document.getElementById('orderItems');
            orderItemsContainer.insertAdjacentHTML('beforeend', itemHtml);
            itemIndex++;
        }

        function updateTotals() {
            let subtotal = 0;
            
            document.querySelectorAll('.order-item').forEach(function(item) {
                const quantity = parseFloat(item.querySelector('.quantity-input').value) || 0;
                const price = parseFloat(item.querySelector('.price-input').value) || 0;
                subtotal += quantity * price;
            });
            
            const discount = parseFloat(document.getElementById('discount').value) || 0;
            const tax = parseFloat(document.getElementById('tax').value) || 0;
            const total = subtotal - discount + tax;
            
            document.getElementById('subtotalDisplay').textContent = '₦' + subtotal.toFixed(2);
            document.getElementById('totalDisplay').textContent = '₦' + total.toFixed(2);
        }

        // Form validation
        document.getElementById('orderForm').addEventListener('submit', function(e) {
            const customerType = document.querySelector('input[name="customer_type"]:checked').value;
            
            // Validate customer information
            if (customerType === 'registered') {
                if (!customerSelect.value) {
                    e.preventDefault();
                    alert('Please select a registered customer.');
                    return false;
                }
            } else {
                const customerName = document.getElementById('customer_name').value.trim();
                const customerEmail = document.getElementById('customer_email').value.trim();
                
                if (!customerName || !customerEmail) {
                    e.preventDefault();
                    alert('Please fill in customer name and email for manual entry.');
                    return false;
                }
            }
            
            if (document.querySelectorAll('.order-item').length === 0) {
                e.preventDefault();
                alert('Please add at least one order item.');
                return false;
            }
            
            // Check if all required fields are filled
            let isValid = true;
            document.querySelectorAll('.order-item').forEach(function(item) {
                const serviceId = item.querySelector('.service-select').value;
                const quantity = item.querySelector('.quantity-input').value;
                const price = item.querySelector('.price-input').value;
                
                if (!serviceId || !quantity || !price || quantity <= 0 || price < 0) {
                    isValid = false;
                    return false;
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                alert('Please fill in all required fields for all order items.');
                return false;
            }
        });
    });
    </script>
    @endpush
</x-layouts.app>