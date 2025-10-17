<x-layouts.app title="Create Manual Invoice">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <flux:breadcrumbs>
                <flux:breadcrumbs.item href="{{ route('admin.invoices.index') }}">Invoices</flux:breadcrumbs.item>
                <flux:breadcrumbs.item>Create Manual Invoice</flux:breadcrumbs.item>
            </flux:breadcrumbs>
            <h1 class="mt-2 text-2xl font-semibold text-zinc-900 dark:text-white">Create Manual Invoice</h1>
            <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">Create an invoice for a registered customer or new client</p>
        </div>

        <!-- Invoice Form -->
        <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
            <form action="{{ route('admin.invoices.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <!-- Client Selection -->
                <div class="border-b border-zinc-200 dark:border-zinc-700 pb-6">
                    <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Client Information</h2>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-zinc-900 dark:text-white mb-2">Client Type</label>
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input 
                                    type="radio" 
                                    name="client_type" 
                                    value="registered" 
                                    {{ old('client_type', 'registered') == 'registered' ? 'checked' : '' }}
                                    class="w-4 h-4 text-blue-600 bg-zinc-100 border-zinc-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-zinc-800 focus:ring-2 dark:bg-zinc-700 dark:border-zinc-600"
                                />
                                <span class="ml-2 text-sm text-zinc-900 dark:text-white">Registered Customer</span>
                            </label>
                            <label class="flex items-center">
                                <input 
                                    type="radio" 
                                    name="client_type" 
                                    value="manual" 
                                    {{ old('client_type') == 'manual' ? 'checked' : '' }}
                                    class="w-4 h-4 text-blue-600 bg-zinc-100 border-zinc-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-zinc-800 focus:ring-2 dark:bg-zinc-700 dark:border-zinc-600"
                                />
                                <span class="ml-2 text-sm text-zinc-900 dark:text-white">New/Non-Registered Client</span>
                            </label>
                        </div>
                        <flux:error name="client_type" />
                    </div>

                    <!-- Registered Customer Selection -->
                    <div id="registered-customer-section" class="{{ old('client_type', 'registered') == 'registered' ? '' : 'hidden' }}">
                        <flux:label for="customer_id">Select Customer</flux:label>
                        <flux:select name="customer_id" id="customer_id">
                            <option value="">-- Select a Customer --</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->name }} ({{ $customer->email }})
                                </option>
                            @endforeach
                        </flux:select>
                        <flux:error name="customer_id" />
                    </div>

                    <!-- Manual Client Fields -->
                    <div id="manual-client-section" class="{{ old('client_type') == 'manual' ? '' : 'hidden' }} space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <flux:label for="client_name">Client Name *</flux:label>
                                <flux:input 
                                    type="text" 
                                    name="client_name" 
                                    id="client_name"
                                    value="{{ old('client_name') }}"
                                />
                                <flux:error name="client_name" />
                            </div>
                            
                            <div>
                                <flux:label for="client_company">Company Name</flux:label>
                                <flux:input 
                                    type="text" 
                                    name="client_company" 
                                    id="client_company"
                                    value="{{ old('client_company') }}"
                                />
                                <flux:error name="client_company" />
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <flux:label for="client_email">Email *</flux:label>
                                <flux:input 
                                    type="email" 
                                    name="client_email" 
                                    id="client_email"
                                    value="{{ old('client_email') }}"
                                />
                                <flux:error name="client_email" />
                            </div>
                            
                            <div>
                                <flux:label for="client_phone">Phone</flux:label>
                                <flux:input 
                                    type="text" 
                                    name="client_phone" 
                                    id="client_phone"
                                    value="{{ old('client_phone') }}"
                                />
                                <flux:error name="client_phone" />
                            </div>
                        </div>
                        
                        <div>
                            <flux:label for="client_address">Address</flux:label>
                            <flux:textarea 
                                name="client_address" 
                                id="client_address"
                                rows="2"
                            >{{ old('client_address') }}</flux:textarea>
                            <flux:error name="client_address" />
                        </div>
                    </div>
                </div>

                <!-- Invoice Details -->
                <div class="border-b border-zinc-200 dark:border-zinc-700 pb-6">
                    <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Invoice Details</h2>
                    
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <flux:label for="invoice_date">Invoice Date</flux:label>
                            <flux:input 
                                type="date" 
                                name="invoice_date" 
                                id="invoice_date"
                                value="{{ old('invoice_date', date('Y-m-d')) }}"
                                required
                            />
                            <flux:error name="invoice_date" />
                        </div>
                        
                        <div>
                            <flux:label for="due_date">Due Date</flux:label>
                            <flux:input 
                                type="date" 
                                name="due_date" 
                                id="due_date"
                                value="{{ old('due_date', date('Y-m-d', strtotime('+30 days'))) }}"
                                required
                            />
                            <flux:error name="due_date" />
                        </div>
                    </div>
                </div>

                <!-- Line Items -->
                <div class="border-b border-zinc-200 dark:border-zinc-700 pb-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Line Items</h2>
                        <button type="button" onclick="addLineItem()" class="inline-flex items-center px-3 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-700 rounded-lg transition-colors">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Add Item
                        </button>
                    </div>
                    
                    <div id="line-items-container" class="space-y-3">
                        <!-- Initial line item -->
                        <div class="line-item grid grid-cols-12 gap-2 items-start">
                            <div class="col-span-5">
                                <label class="block text-sm font-medium text-zinc-900 dark:text-white mb-1">Description</label>
                                <input 
                                    type="text" 
                                    name="items[0][description]" 
                                    placeholder="Service or product description"
                                    class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-blue-500"
                                    required
                                />
                            </div>
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-zinc-900 dark:text-white mb-1">Quantity</label>
                                <input 
                                    type="number" 
                                    name="items[0][quantity]" 
                                    class="quantity-input w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-blue-500"
                                    step="1"
                                    min="1"
                                    value="1"
                                    required
                                />
                            </div>
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-zinc-900 dark:text-white mb-1">Unit Price</label>
                                <input 
                                    type="number" 
                                    name="items[0][unit_price]" 
                                    class="unit-price-input w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-blue-500"
                                    step="0.01"
                                    min="0"
                                    value="0.00"
                                    required
                                />
                            </div>
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-zinc-900 dark:text-white mb-1">Line Total</label>
                                <div class="h-10 flex items-center px-3 bg-zinc-50 dark:bg-zinc-900 rounded-lg border border-zinc-300 dark:border-zinc-600">
                                    <span class="line-total text-sm font-medium text-zinc-900 dark:text-white">$0.00</span>
                                </div>
                            </div>
                            <div class="col-span-1 flex items-end">
                                <button type="button" onclick="removeLineItem(this)" class="h-10 p-2 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Totals & Tax -->
                <div class="border-b border-zinc-200 dark:border-zinc-700 pb-6">
                    <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Totals</h2>
                    
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <flux:label for="tax_rate">Tax Rate (%)</flux:label>
                            <flux:input 
                                type="number" 
                                name="tax_rate" 
                                id="tax_rate"
                                step="0.01"
                                min="0"
                                max="100"
                                value="{{ old('tax_rate', '0') }}"
                                required
                            />
                            <flux:error name="tax_rate" />
                        </div>
                        
                        <div>
                            <flux:label for="discount_amount">Discount Amount ($)</flux:label>
                            <flux:input 
                                type="number" 
                                name="discount_amount" 
                                id="discount_amount"
                                step="0.01"
                                min="0"
                                value="{{ old('discount_amount', '0') }}"
                            />
                            <flux:error name="discount_amount" />
                        </div>
                    </div>
                    
                    <!-- Hidden subtotal field -->
                    <input type="hidden" name="subtotal" id="subtotal" value="0">
                    
                    <!-- Amount Calculation Preview -->
                    <div class="bg-zinc-50 dark:bg-zinc-900 rounded-lg p-4">
                        <h3 class="text-sm font-medium text-zinc-900 dark:text-white mb-3">Invoice Summary</h3>
                        
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-zinc-600 dark:text-zinc-400">Subtotal:</span>
                                <span class="font-medium text-zinc-900 dark:text-white" id="subtotal-preview">$0.00</span>
                            </div>
                            
                            <div class="flex justify-between">
                                <span class="text-zinc-600 dark:text-zinc-400">Discount:</span>
                                <span class="font-medium text-zinc-900 dark:text-white" id="discount-preview">$0.00</span>
                            </div>
                            
                            <div class="flex justify-between">
                                <span class="text-zinc-600 dark:text-zinc-400">Tax:</span>
                                <span class="font-medium text-zinc-900 dark:text-white" id="tax-preview">$0.00</span>
                            </div>
                            
                            <div class="flex justify-between pt-2 border-t border-zinc-200 dark:border-zinc-700 font-semibold">
                                <span class="text-zinc-900 dark:text-white">Total:</span>
                                <span class="text-zinc-900 dark:text-white" id="total-preview">$0.00</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notes -->
                <div class="pb-6">
                    <flux:label for="notes">Notes (Optional)</flux:label>
                    <flux:textarea 
                        name="notes" 
                        id="notes"
                        rows="4"
                        placeholder="Add any additional notes or payment instructions"
                    >{{ old('notes') }}</flux:textarea>
                    <flux:error name="notes" />
                </div>
                
                <div class="flex gap-2">
                    <flux:button type="submit" variant="primary">Create Invoice</flux:button>
                    <a href="{{ route('admin.invoices.index') }}">
                        <flux:button type="button" variant="ghost">Cancel</flux:button>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        let itemIndex = 1;

        // Client type toggle
        const clientTypeRadios = document.querySelectorAll('input[name="client_type"]');
        const registeredSection = document.getElementById('registered-customer-section');
        const manualSection = document.getElementById('manual-client-section');
        const customerSelect = document.getElementById('customer_id');

        clientTypeRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value === 'registered') {
                    registeredSection.classList.remove('hidden');
                    manualSection.classList.add('hidden');
                    // Enable customer select
                    if (customerSelect) {
                        customerSelect.disabled = false;
                    }
                } else {
                    registeredSection.classList.add('hidden');
                    manualSection.classList.remove('hidden');
                    // Disable and clear customer select
                    if (customerSelect) {
                        customerSelect.disabled = true;
                        customerSelect.value = '';
                    }
                }
            });
        });

        // Add line item
        function addLineItem() {
            const container = document.getElementById('line-items-container');
            const newItem = document.createElement('div');
            newItem.className = 'line-item grid grid-cols-12 gap-2 items-start';
            newItem.innerHTML = `
                <div class="col-span-5">
                    <label class="block text-sm font-medium text-zinc-900 dark:text-white mb-1">Description</label>
                    <input 
                        type="text" 
                        name="items[\${itemIndex}][description]" 
                        placeholder="Service or product description"
                        class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-blue-500"
                        required
                    />
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-zinc-900 dark:text-white mb-1">Quantity</label>
                    <input 
                        type="number" 
                        name="items[\${itemIndex}][quantity]" 
                        class="quantity-input w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-blue-500"
                        step="1"
                        min="1"
                        value="1"
                        required
                    />
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-zinc-900 dark:text-white mb-1">Unit Price</label>
                    <input 
                        type="number" 
                        name="items[\${itemIndex}][unit_price]" 
                        class="unit-price-input w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-blue-500"
                        step="0.01"
                        min="0"
                        value="0.00"
                        required
                    />
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-zinc-900 dark:text-white mb-1">Line Total</label>
                    <div class="h-10 flex items-center px-3 bg-zinc-50 dark:bg-zinc-900 rounded-lg border border-zinc-300 dark:border-zinc-600">
                        <span class="line-total text-sm font-medium text-zinc-900 dark:text-white">$0.00</span>
                    </div>
                </div>
                <div class="col-span-1 flex items-end">
                    <button type="button" onclick="removeLineItem(this)" class="h-10 p-2 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </div>
            `;
            container.appendChild(newItem);
            itemIndex++;
            
            // Attach event listeners to new inputs
            attachLineItemListeners(newItem);
        }

        // Remove line item
        function removeLineItem(button) {
            const items = document.querySelectorAll('.line-item');
            if (items.length > 1) {
                button.closest('.line-item').remove();
                updateTotals();
            } else {
                alert('At least one line item is required');
            }
        }

        // Attach listeners to line item inputs
        function attachLineItemListeners(lineItem) {
            const quantityInput = lineItem.querySelector('.quantity-input');
            const unitPriceInput = lineItem.querySelector('.unit-price-input');
            const lineTotal = lineItem.querySelector('.line-total');

            function updateLineTotal() {
                const quantity = parseFloat(quantityInput.value) || 0;
                const unitPrice = parseFloat(unitPriceInput.value) || 0;
                const total = quantity * unitPrice;
                lineTotal.textContent = '$' + total.toFixed(2);
                updateTotals();
            }

            quantityInput.addEventListener('input', updateLineTotal);
            unitPriceInput.addEventListener('input', updateLineTotal);
        }

        // Update invoice totals
        function updateTotals() {
            let subtotal = 0;
            
            // Calculate subtotal from all line items
            document.querySelectorAll('.line-item').forEach(item => {
                const quantity = parseFloat(item.querySelector('.quantity-input').value) || 0;
                const unitPrice = parseFloat(item.querySelector('.unit-price-input').value) || 0;
                subtotal += quantity * unitPrice;
            });
            
            const taxRate = parseFloat(document.getElementById('tax_rate').value) || 0;
            const discount = parseFloat(document.getElementById('discount_amount').value) || 0;
            
            const taxAmount = subtotal * (taxRate / 100);
            const total = subtotal + taxAmount - discount;
            
            // Update hidden field
            document.getElementById('subtotal').value = subtotal.toFixed(2);
            
            // Update preview
            document.getElementById('subtotal-preview').textContent = '$' + subtotal.toFixed(2);
            document.getElementById('discount-preview').textContent = '$' + discount.toFixed(2);
            document.getElementById('tax-preview').textContent = '$' + taxAmount.toFixed(2);
            document.getElementById('total-preview').textContent = '$' + total.toFixed(2);
        }

        // Initialize event listeners on page load
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Invoice form JavaScript loaded');
            document.querySelectorAll('.line-item').forEach(attachLineItemListeners);
            
            const taxRateInput = document.getElementById('tax_rate');
            const discountInput = document.getElementById('discount_amount');
            
            if (taxRateInput) {
                taxRateInput.addEventListener('input', updateTotals);
            }
            if (discountInput) {
                discountInput.addEventListener('input', updateTotals);
            }
            
            updateTotals();
        });
    </script>
</x-layouts.app>
