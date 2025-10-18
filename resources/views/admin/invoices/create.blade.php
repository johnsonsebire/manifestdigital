<x-layouts.app title="Create Invoice">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <flux:breadcrumbs>
                <flux:breadcrumbs.item href="{{ route('admin.invoices.index') }}">Invoices</flux:breadcrumbs.item>
                <flux:breadcrumbs.item>{{ $order ? 'Create Invoice' : 'Create Manual Invoice' }}</flux:breadcrumbs.item>
            </flux:breadcrumbs>
            
            <h1 class="mt-2 text-2xl font-semibold text-zinc-900 dark:text-white">
                {{ $order ? 'Create Invoice' : 'Create Manual Invoice' }}
            </h1>
            <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                {{ $order ? "Generate an invoice for Order #{$order->id}" : 'Create an invoice for a registered customer or new client' }}
            </p>
        </div>

        @if($order)
        <!-- Order Summary -->
        <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6 mb-6">
            <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Order Details</h2>
            
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="text-zinc-600 dark:text-zinc-400">Order #:</span>
                    <span class="ml-2 font-medium text-zinc-900 dark:text-white">{{ $order ? $order->id : 'N/A' }}</span>
                </div>
                <div>
                    <span class="text-zinc-600 dark:text-zinc-400">Customer:</span>
                    <span class="ml-2 font-medium text-zinc-900 dark:text-white">{{ $order ? $order->customer->name : 'N/A' }}</span>
                </div>
                <div>
                    <span class="text-zinc-600 dark:text-zinc-400">Order Total:</span>
                    <span class="ml-2 font-medium text-zinc-900 dark:text-white">${{ number_format($order ? $order->total : 0, 2) }}</span>
                </div>
                <div>
                    <span class="text-zinc-600 dark:text-zinc-400">Order Date:</span>
                    <span class="ml-2 font-medium text-zinc-900 dark:text-white">{{ $order ? $order->placed_at->format('M d, Y') : 'N/A' }}</span>
                </div>
            </div>
        </div>
        @endif

        <!-- Invoice Form -->
        <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
            <form action="{{ $order ? route('admin.orders.invoices.store', $order) : route('admin.invoices.store') }}" method="POST" class="space-y-6">
                @csrf
                
                @if(!$order)
                <!-- Client Selection for Manual Invoices -->
            <div class="border-b border-zinc-200 dark:border-zinc-700 pb-6 mb-6">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Client Information</h2>
                
                <div class="mb-4">
                    <flux:label>Client Type</flux:label>
                    <div class="space-y-2 mt-2">
                        <label class="flex items-center">
                            <input 
                                type="radio" 
                                name="client_type" 
                                value="registered" 
                                {{ old('client_type', 'registered') == 'registered' ? 'checked' : '' }}
                                class="w-4 h-4 text-blue-600 bg-zinc-100 border-zinc-300 focus:ring-blue-500"
                            />
                            <span class="ml-2 text-sm text-zinc-900 dark:text-white">Registered Customer</span>
                        </label>
                        <label class="flex items-center">
                            <input 
                                type="radio" 
                                name="client_type" 
                                value="manual" 
                                {{ old('client_type') == 'manual' ? 'checked' : '' }}
                                class="w-4 h-4 text-blue-600 bg-zinc-100 border-zinc-300 focus:ring-blue-500"
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
                        <option value="">Choose a customer</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                {{ $customer->name }} ({{ $customer->email }})
                            </option>
                        @endforeach
                    </flux:select>
                    <flux:error name="customer_id" />
                </div>

                <!-- Manual Client Information -->
                <div id="manual-client-section" class="{{ old('client_type') == 'manual' ? '' : 'hidden' }}">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <flux:label for="client_name">Client Name</flux:label>
                            <flux:input 
                                type="text" 
                                name="client_name" 
                                id="client_name"
                                value="{{ old('client_name') }}"
                            />
                            <flux:error name="client_name" />
                        </div>
                        <div>
                            <flux:label for="client_email">Email Address</flux:label>
                            <flux:input 
                                type="email" 
                                name="client_email" 
                                id="client_email"
                                value="{{ old('client_email') }}"
                            />
                            <flux:error name="client_email" />
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4 mt-4">
                        <div>
                            <flux:label for="client_phone">Phone Number</flux:label>
                            <flux:input 
                                type="text" 
                                name="client_phone" 
                                id="client_phone"
                                value="{{ old('client_phone') }}"
                            />
                            <flux:error name="client_phone" />
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
                    
                    <div class="mt-4">
                        <flux:label for="client_address">Address</flux:label>
                        <flux:textarea 
                            name="client_address" 
                            id="client_address"
                            rows="3"
                        >{{ old('client_address') }}</flux:textarea>
                        <flux:error name="client_address" />
                    </div>
                </div>
            </div>

            <!-- Invoice Information (Date & Currency) -->
            <div class="border-b border-zinc-200 dark:border-zinc-700 pb-6 mb-6">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Invoice Information</h2>
                
                <div class="grid grid-cols-2 gap-4">
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

                <!-- Currency Selection -->
                <div class="mt-4">
                    <flux:label for="currency_id">Invoice Currency</flux:label>
                    <flux:select name="currency_id" id="currency_id" required>
                        <option value="">Select Currency</option>
                        @foreach($currencies as $currency)
                            <option value="{{ $currency->id }}" 
                                    data-code="{{ $currency->code }}"
                                    data-symbol="{{ $currency->symbol }}"
                                    data-exchange-rate="{{ $currency->exchange_rate }}"
                                    {{ old('currency_id', $currencies->where('is_base_currency', true)->first()?->id) == $currency->id ? 'selected' : '' }}>
                                {{ $currency->name }} ({{ $currency->code }}) - {{ $currency->symbol }}
                            </option>
                        @endforeach
                    </flux:select>
                    <flux:error name="currency_id" />
                    <flux:description>
                        Select the currency for this invoice. Exchange rates will be applied automatically.
                    </flux:description>
                </div>
            </div>

            <!-- Invoice Items for Manual Invoices -->
            <div class="border-b border-zinc-200 dark:border-zinc-700 pb-6 mb-6">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Invoice Items</h2>
                
                <div id="invoice-items">
                    <div class="invoice-item border border-zinc-200 dark:border-zinc-700 rounded-lg p-4 mb-4">
                        <div class="grid grid-cols-12 gap-4">
                            <div class="col-span-5">
                                <flux:label for="items[0][description]">Description</flux:label>
                                <flux:input 
                                    type="text" 
                                    name="items[0][description]" 
                                    placeholder="Service or product description"
                                    value="{{ old('items.0.description') }}"
                                    required
                                />
                            </div>
                            <div class="col-span-2">
                                <flux:label for="items[0][quantity]">Quantity</flux:label>
                                <flux:input 
                                    type="number" 
                                    name="items[0][quantity]" 
                                    step="0.01"
                                    min="1"
                                    value="{{ old('items.0.quantity', '1') }}"
                                    class="item-quantity"
                                    required
                                />
                            </div>
                            <div class="col-span-2">
                                <flux:label for="items[0][unit_price]">Unit Price</flux:label>
                                <flux:input 
                                    type="number" 
                                    name="items[0][unit_price]" 
                                    step="0.01"
                                    min="0"
                                    value="{{ old('items.0.unit_price') }}"
                                    class="item-price"
                                    required
                                />
                            </div>
                            <div class="col-span-2">
                                <flux:label>Total</flux:label>
                                <div class="flex items-center h-10 px-3 bg-zinc-50 dark:bg-zinc-900 rounded-md text-sm">
                                    <span class="item-total">$0.00</span>
                                </div>
                            </div>
                            <div class="col-span-1 flex items-end">
                                <button type="button" class="remove-item text-red-600 hover:text-red-800 p-2 hidden">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-between items-center mt-4">
                    <button type="button" id="add-item-btn" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                        + Add Item
                    </button>
                    <div class="text-right">
                        <div class="text-sm text-zinc-600 dark:text-zinc-400">Subtotal:</div>
                        <div class="text-lg font-semibold text-zinc-900 dark:text-white" id="items-subtotal">$0.00</div>
                        <input type="hidden" name="subtotal" id="subtotal-input" value="0">
                    </div>
                </div>
            </div>
            @endif

            <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Additional Invoice Details</h2>
            
                <!-- Tax Selection -->
                <div>
                    <flux:label>Applicable Taxes</flux:label>
                    <div class="space-y-2 border border-zinc-200 dark:border-zinc-700 rounded-lg p-4" id="tax-selection">
                        <div class="text-sm text-zinc-600 dark:text-zinc-400" id="tax-loading">
                            Please select a currency to see applicable taxes.
                        </div>
                    </div>
                    <flux:error name="taxes" />
                    <flux:description>
                        Select the taxes that should be applied to this invoice. Regional taxes are automatically determined based on the selected currency.
                    </flux:description>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <flux:label for="discount_amount">Discount Amount</flux:label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-zinc-500" id="discount-currency">$</span>
                            <flux:input 
                                type="number" 
                                name="discount_amount" 
                                id="discount_amount"
                                step="0.01"
                                min="0"
                                value="{{ old('discount_amount', '0') }}"
                                class="pl-8"
                            />
                        </div>
                        <flux:error name="discount_amount" />
                    </div>
                    
                    <div>
                        <flux:label for="additional_fees">Additional Fees</flux:label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-zinc-500" id="fees-currency">$</span>
                            <flux:input 
                                type="number" 
                                name="additional_fees" 
                                id="additional_fees"
                                step="0.01"
                                min="0"
                                value="{{ old('additional_fees', '0') }}"
                                class="pl-8"
                            />
                        </div>
                        <flux:error name="additional_fees" />
                        <flux:description>
                            Any additional fees like processing charges, service fees, etc.
                        </flux:description>
                    </div>
                </div>
                
                <div>
                    <flux:label for="notes">Notes (Optional)</flux:label>
                    <flux:textarea 
                        name="notes" 
                        id="notes"
                        rows="4"
                        placeholder="Add any additional notes or payment instructions"
                    >{{ old('notes') }}</flux:textarea>
                    <flux:error name="notes" />
                </div>
                
                <!-- Amount Calculation Preview -->
                <div class="bg-zinc-50 dark:bg-zinc-900 rounded-lg p-4">
                    <h3 class="text-sm font-medium text-zinc-900 dark:text-white mb-3">Invoice Summary</h3>
                    
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-zinc-600 dark:text-zinc-400">Subtotal:</span>
                            <span class="font-medium text-zinc-900 dark:text-white" id="subtotal-preview">
                                @if($order)
                                    ${{ number_format($order->total, 2) }}
                                @else
                                    $0.00
                                @endif
                            </span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-zinc-600 dark:text-zinc-400">Additional Fees:</span>
                            <span class="font-medium text-zinc-900 dark:text-white" id="fees-preview">$0.00</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-zinc-600 dark:text-zinc-400">Discount:</span>
                            <span class="font-medium text-zinc-900 dark:text-white" id="discount-preview">$0.00</span>
                        </div>
                        
                        <div id="tax-breakdown" class="space-y-1">
                            <!-- Tax breakdown will be populated dynamically -->
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-zinc-600 dark:text-zinc-400">Total Tax:</span>
                            <span class="font-medium text-zinc-900 dark:text-white" id="tax-total-preview">$0.00</span>
                        </div>
                        
                        <div class="flex justify-between pt-2 border-t border-zinc-200 dark:border-zinc-700 font-semibold">
                            <span class="text-zinc-900 dark:text-white">Total:</span>
                            <span class="text-zinc-900 dark:text-white" id="total-preview">
                                ${{ number_format($order ? $order->total : 0, 2) }}
                            </span>
                        </div>
                        
                        <div class="text-xs text-zinc-500 dark:text-zinc-400 pt-1" id="exchange-rate-info">
                            <!-- Exchange rate information will be shown here -->
                        </div>
                    </div>
                </div>
                
                <div class="flex gap-2">
                    <flux:button type="submit" variant="primary">Create Invoice</flux:button>
                    @if($order)
                        <a href="{{ route('admin.orders.show', $order) }}">
                            <flux:button type="button" variant="ghost">Cancel</flux:button>
                        </a>
                    @else
                        <a href="{{ route('admin.invoices.index') }}">
                            <flux:button type="button" variant="ghost">Cancel</flux:button>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        console.log('Script loading...');
        
        // Initialize variables
        const baseSubtotal = {{ $order ? $order->total : 0 }};
        const isOrderBased = {{ $order ? 'true' : 'false' }};
        
        console.log('Variables initialized:', { baseSubtotal, isOrderBased });
        
        // DOM elements - will be initialized in DOMContentLoaded
        let currentCurrency = null;
        let currentExchangeRate = 1;
        let applicableTaxes = [];
        let selectedTaxes = [];
        let manualSubtotal = 0;
        
        // Core DOM elements
        let currencySelect, taxSelection, taxLoading, discountInput, feesInput;
        let subtotalPreview, discountPreview, feesPreview, taxBreakdown, taxTotalPreview, totalPreview;
        let exchangeRateInfo, discountCurrencySymbol, feesCurrencySymbol;
        
        // Manual invoice elements
        let clientTypeRadios, registeredSection, manualSection, addItemBtn, itemsSubtotal, subtotalInput;
        
        // Utility functions
        function formatAmount(amount) {
            if (typeof amount !== 'number' || isNaN(amount)) {
                amount = 0;
            }
            
            // Get currency symbol based on current currency
            const currencySymbols = {
                'USD': '$',
                'GHS': '₵',
                'EUR': '€',
                'GBP': '£'
            };
            
            const symbol = currencySymbols[currentCurrency] || '$';
            return symbol + amount.toFixed(2);
        }
        
        // Initialize when DOM is ready
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded, initializing...');
            initializeElements();
            
            if (!isOrderBased) {
                console.log('Setting up manual invoice functionality...');
                setupManualInvoice();
                
                // Initialize client type state based on default selection
                const selectedClientType = document.querySelector('input[name="client_type"]:checked');
                if (selectedClientType) {
                    console.log('Initializing client type to:', selectedClientType.value);
                    handleClientTypeChange(selectedClientType.value);
                }
            }
            
            if (currencySelect && currencySelect.value) {
                loadApplicableTaxes(currencySelect.value);
            }
        });
        
        function initializeElements() {
            // Core elements
            currencySelect = document.getElementById('currency_id');
            taxSelection = document.getElementById('tax-selection');
            taxLoading = document.getElementById('tax-loading');
            discountInput = document.getElementById('discount_amount');
            feesInput = document.getElementById('additional_fees');
            
            // Preview elements
            subtotalPreview = document.getElementById('subtotal-preview');
            discountPreview = document.getElementById('discount-preview');
            feesPreview = document.getElementById('fees-preview');
            taxBreakdown = document.getElementById('tax-breakdown');
            taxTotalPreview = document.getElementById('tax-total-preview');
            totalPreview = document.getElementById('total-preview');
            exchangeRateInfo = document.getElementById('exchange-rate-info');
            discountCurrencySymbol = document.getElementById('discount-currency');
            feesCurrencySymbol = document.getElementById('fees-currency');
            
            // Manual invoice elements
            clientTypeRadios = document.querySelectorAll('input[name="client_type"]');
            registeredSection = document.getElementById('registered-customer-section');
            manualSection = document.getElementById('manual-client-section');
            addItemBtn = document.getElementById('add-item-btn');
            itemsSubtotal = document.getElementById('items-subtotal');
            subtotalInput = document.getElementById('subtotal-input');
            
            console.log('Elements initialized:', {
                currencySelect: !!currencySelect,
                clientTypeRadios: clientTypeRadios ? clientTypeRadios.length : 0,
                registeredSection: !!registeredSection,
                manualSection: !!manualSection
            });
            
            // Add event listeners
            if (currencySelect) {
                currencySelect.addEventListener('change', handleCurrencyChange);
            }
            if (discountInput) {
                discountInput.addEventListener('input', updatePreview);
            }
            if (feesInput) {
                feesInput.addEventListener('input', updatePreview);
            }
        }
        
        function setupManualInvoice() {
            console.log('Setting up manual invoice with radios:', clientTypeRadios.length);
            
            clientTypeRadios.forEach((radio, index) => {
                console.log(`Radio ${index}: value=${radio.value}, checked=${radio.checked}`);
                radio.addEventListener('change', function() {
                    console.log('Radio changed to:', this.value);
                    handleClientTypeChange(this.value);
                });
            });
            
            if (addItemBtn) {
                addItemBtn.addEventListener('click', addInvoiceItem);
            }
            
            // CRITICAL FIX: Initialize existing items with event listeners
            initializeExistingItems();
            
            updateItemCalculations();
        }
        
        function initializeExistingItems() {
            console.log('Initializing existing items...');
            
            const itemsContainer = document.getElementById('invoice-items');
            if (!itemsContainer) {
                console.log('No items container found');
                return;
            }
            
            const existingItems = itemsContainer.querySelectorAll('.invoice-item');
            console.log(`Found ${existingItems.length} existing items`);
            
            existingItems.forEach((item, index) => {
                console.log(`Attaching listeners to existing item ${index}`);
                attachItemEventListeners(item);
            });
            
            console.log('Existing items initialization complete');
        }
        
        function handleClientTypeChange(value) {
            console.log('Handling client type change to:', value);
            
            // Get manual client form fields
            const manualFields = document.querySelectorAll('#manual-client-section input, #manual-client-section textarea');
            
            if (value === 'registered') {
                if (registeredSection) registeredSection.classList.remove('hidden');
                if (manualSection) manualSection.classList.add('hidden');
                
                // Disable and clear manual client fields when registered is selected
                manualFields.forEach(field => {
                    field.disabled = true;
                    field.value = '';
                });
                
                console.log('Switched to registered customer');
            } else if (value === 'manual') {
                if (registeredSection) registeredSection.classList.add('hidden');
                if (manualSection) manualSection.classList.remove('hidden');
                
                // Enable manual client fields when manual is selected
                manualFields.forEach(field => {
                    field.disabled = false;
                });
                
                console.log('Switched to manual client');
            }
        }
        
        function handleCurrencyChange() {
            const selectedOption = currencySelect.options[currencySelect.selectedIndex];
            if (selectedOption.value) {
                currentCurrency = selectedOption.getAttribute('data-code');
                currentExchangeRate = parseFloat(selectedOption.getAttribute('data-exchange-rate'));
                const symbol = selectedOption.getAttribute('data-symbol');
                
                if (discountCurrencySymbol) discountCurrencySymbol.textContent = symbol;
                if (feesCurrencySymbol) feesCurrencySymbol.textContent = symbol;
                
                // Update item calculations to reflect new currency immediately
                updateItemCalculations();
                
                loadApplicableTaxes(selectedOption.value);
                updatePreview();
            } else {
                currentCurrency = null;
                currentExchangeRate = 1;
                if (discountCurrencySymbol) discountCurrencySymbol.textContent = '$';
                if (feesCurrencySymbol) feesCurrencySymbol.textContent = '$';
                
                // Update item calculations to show default currency
                updateItemCalculations();
                
                showTaxLoading();
                updatePreview();
            }
        }
        
        function loadApplicableTaxes(currencyId) {
            if (!taxSelection) return;
            
            showTaxLoading();
            
            const requestData = { currency_id: currencyId };
            if (isOrderBased && {{ $order ? $order->id : 'null' }} !== null) {
                requestData.order_id = {{ $order ? $order->id : 'null' }};
            }
            
            fetch('{{ route("admin.invoices.get-applicable-taxes") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(requestData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    applicableTaxes = data.taxes;
                    renderTaxSelection();
                    updatePreview();
                } else {
                    showError('Error loading taxes: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showError('Error loading applicable taxes');
            });
        }
        
        function renderTaxSelection() {
            if (!taxSelection) return;
            
            if (applicableTaxes.length === 0) {
                taxSelection.innerHTML = '<div class="text-sm text-zinc-600 dark:text-zinc-400">No taxes applicable for this currency.</div>';
                return;
            }
            
            let html = '';
            applicableTaxes.forEach(tax => {
                const checked = tax.is_default ? 'checked' : '';
                const rateDisplay = tax.type === 'percentage' ? `${tax.rate}%` : `${tax.rate} ${currentCurrency || 'USD'}`;
                
                html += `
                    <label class="flex items-center space-x-3 cursor-pointer">
                        <input type="checkbox" 
                               name="taxes[]" 
                               value="${tax.id}" 
                               data-tax-id="${tax.id}"
                               data-tax-rate="${tax.rate}"
                               data-tax-type="${tax.type}"
                               data-tax-code="${tax.code}"
                               data-tax-name="${tax.name}"
                               ${checked}
                               class="tax-checkbox rounded border-zinc-300 text-blue-600 focus:ring-blue-500">
                        <div class="flex-1">
                            <div class="text-sm font-medium text-zinc-900 dark:text-white">
                                ${tax.name} (${tax.code})
                            </div>
                            <div class="text-xs text-zinc-600 dark:text-zinc-400">
                                ${rateDisplay} ${tax.is_default ? '• Default' : ''}
                            </div>
                        </div>
                    </label>
                `;
            });
            
            taxSelection.innerHTML = html;
            
            document.querySelectorAll('.tax-checkbox').forEach(checkbox => {
                checkbox.addEventListener('change', updateSelectedTaxes);
                if (checkbox.checked) {
                    updateSelectedTaxes();
                }
            });
        }
        
        function updateSelectedTaxes() {
            selectedTaxes = [];
            document.querySelectorAll('.tax-checkbox:checked').forEach(checkbox => {
                selectedTaxes.push({
                    id: checkbox.getAttribute('data-tax-id'),
                    name: checkbox.getAttribute('data-tax-name'),
                    code: checkbox.getAttribute('data-tax-code'),
                    rate: parseFloat(checkbox.getAttribute('data-tax-rate')),
                    type: checkbox.getAttribute('data-tax-type')
                });
            });
            updatePreview();
        }
        
        function updatePreview() {
            if (!subtotalPreview) return;
            
            const discount = parseFloat(discountInput ? discountInput.value : 0) || 0;
            const additionalFees = parseFloat(feesInput ? feesInput.value : 0) || 0;
            
            const currentSubtotal = isOrderBased ? baseSubtotal * currentExchangeRate : manualSubtotal;
            const subtotalAfterDiscount = currentSubtotal - discount;
            const subtotalWithFees = subtotalAfterDiscount + additionalFees;
            
            let totalTaxAmount = 0;
            let taxBreakdownHtml = '';
            
            selectedTaxes.forEach(tax => {
                let taxAmount = 0;
                if (tax.type === 'percentage') {
                    taxAmount = subtotalWithFees * (tax.rate / 100);
                } else {
                    taxAmount = tax.rate;
                }
                
                totalTaxAmount += taxAmount;
                
                const taxAmountFormatted = formatAmount(taxAmount);
                const rateDisplay = tax.type === 'percentage' ? `${tax.rate}%` : formatAmount(tax.rate);
                
                taxBreakdownHtml += `
                    <div class="flex justify-between text-xs">
                        <span class="text-zinc-600 dark:text-zinc-400">${tax.name} (${rateDisplay}):</span>
                        <span class="text-zinc-900 dark:text-white">${taxAmountFormatted}</span>
                    </div>
                `;
            });
            
            const finalTotal = subtotalWithFees + totalTaxAmount;
            
            if (subtotalPreview) subtotalPreview.textContent = formatAmount(currentSubtotal);
            if (feesPreview) feesPreview.textContent = formatAmount(additionalFees);
            if (discountPreview) discountPreview.textContent = formatAmount(discount);
            if (taxBreakdown) taxBreakdown.innerHTML = taxBreakdownHtml;
            if (taxTotalPreview) taxTotalPreview.textContent = formatAmount(totalTaxAmount);
            if (totalPreview) totalPreview.textContent = formatAmount(finalTotal);
            
            if (exchangeRateInfo && currentCurrency && currentCurrency !== 'USD' && currentExchangeRate !== 1) {
                exchangeRateInfo.textContent = `Exchange rate: 1 USD = ${currentExchangeRate} ${currentCurrency}`;
            } else if (exchangeRateInfo) {
                exchangeRateInfo.textContent = '';
            }
        }
        
        function formatAmount(amount) {
            const symbol = currentCurrency ? document.querySelector(`#currency_id option[data-code="${currentCurrency}"]`)?.getAttribute('data-symbol') : '$';
            return (symbol || '$') + amount.toFixed(2);
        }
        
        function showTaxLoading() {
            if (taxSelection) {
                taxSelection.innerHTML = '<div class="text-sm text-zinc-600 dark:text-zinc-400">Loading applicable taxes...</div>';
            }
        }
        
        function showError(message) {
            if (taxSelection) {
                taxSelection.innerHTML = `<div class="text-sm text-red-600 dark:text-red-400">${message}</div>`;
            }
        }
        
        // Item management functions
        function addInvoiceItem() {
            console.log('Adding new invoice item...');
            
            const itemsContainer = document.getElementById('invoice-items');
            if (!itemsContainer) {
                console.error('Items container not found!');
                return;
            }
            
            const itemCount = itemsContainer.children.length;
            console.log('Current item count:', itemCount);
            
            const itemHtml = `
                <div class="invoice-item border border-zinc-200 dark:border-zinc-700 rounded-lg p-4 mb-4">
                    <div class="grid grid-cols-12 gap-4">
                        <div class="col-span-5">
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Description</label>
                            <input type="text" 
                                   name="items[${itemCount}][description]" 
                                   placeholder="Service or product description"
                                   class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-zinc-700 dark:text-white"
                                   required />
                        </div>
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Quantity</label>
                            <input type="number" 
                                   name="items[${itemCount}][quantity]" 
                                   step="0.01"
                                   min="1"
                                   value="1"
                                   class="item-quantity w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-zinc-700 dark:text-white"
                                   required />
                        </div>
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Unit Price</label>
                            <input type="number" 
                                   name="items[${itemCount}][unit_price]" 
                                   step="0.01"
                                   min="0"
                                   class="item-price w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-zinc-700 dark:text-white"
                                   required />
                        </div>
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Total</label>
                            <div class="flex items-center h-10 px-3 bg-zinc-50 dark:bg-zinc-900 rounded-md text-sm">
                                <span class="item-total font-medium">$0.00</span>
                            </div>
                        </div>
                        <div class="col-span-1 flex items-end">
                            <button type="button" class="remove-item text-red-600 hover:text-red-800 p-2 rounded-md hover:bg-red-50 dark:hover:bg-red-900/20" title="Remove item">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            `;
            
            itemsContainer.insertAdjacentHTML('beforeend', itemHtml);
            
            // Add event listeners to the new item
            const newItem = itemsContainer.lastElementChild;
            attachItemEventListeners(newItem);
            
            // Update calculations and button visibility
            updateItemCalculations();
            updateRemoveButtons();
            
            console.log('New item added, total items:', itemsContainer.children.length);
        }
        
        function attachItemEventListeners(itemElement) {
            // Try both approaches: class-based (for dynamically added items) and input name-based (for pre-existing items)
            let quantityInput = itemElement.querySelector('.item-quantity');
            let priceInput = itemElement.querySelector('.item-price');
            
            // If class-based approach fails, try all quantity/price inputs in this item
            if (!quantityInput) {
                quantityInput = itemElement.querySelector('input[name*="[quantity]"]');
            }
            if (!priceInput) {
                priceInput = itemElement.querySelector('input[name*="[unit_price]"]');
            }
            
            const removeButton = itemElement.querySelector('.remove-item');
            
            if (quantityInput) {
                quantityInput.addEventListener('input', updateItemCalculations);
                console.log('Attached quantity listener to item');
            }
            if (priceInput) {
                priceInput.addEventListener('input', updateItemCalculations);
                console.log('Attached price listener to item');
            }
            if (removeButton) {
                removeButton.addEventListener('click', function() {
                    removeInvoiceItem(itemElement);
                });
            }
        }
        
        function removeInvoiceItem(itemElement) {
            console.log('Removing invoice item...');
            itemElement.remove();
            updateItemCalculations();
            updateRemoveButtons();
            console.log('Item removed');
        }
        
        function updateRemoveButtons() {
            const itemsContainer = document.getElementById('invoice-items');
            if (!itemsContainer) return;
            
            const removeButtons = itemsContainer.querySelectorAll('.remove-item');
            const itemCount = itemsContainer.children.length;
            
            removeButtons.forEach(btn => {
                if (itemCount > 1) {
                    btn.style.display = 'block';
                } else {
                    btn.style.display = 'none';
                }
            });
        }
        
        function updateItemCalculations() {
            console.log('Updating item calculations...');
            
            const itemsContainer = document.getElementById('invoice-items');
            if (!itemsContainer) {
                console.log('No items container found');
                return;
            }
            
            let subtotal = 0;
            const items = itemsContainer.querySelectorAll('.invoice-item');
            
            console.log('Processing', items.length, 'items');
            
            items.forEach((item, index) => {
                // Try both approaches: class-based (for dynamically added items) and name-based (for pre-existing items)
                let quantityInput = item.querySelector('.item-quantity');
                let priceInput = item.querySelector('.item-price');
                
                // For Flux components, we need to look inside the class containers for the actual input
                if (quantityInput && !quantityInput.value) {
                    quantityInput = quantityInput.querySelector('input') || quantityInput;
                }
                if (priceInput && !priceInput.value) {
                    priceInput = priceInput.querySelector('input') || priceInput;
                }
                
                // If class-based approach fails, try name-based approach
                if (!quantityInput || quantityInput.value === undefined) {
                    quantityInput = item.querySelector(`input[name="items[${index}][quantity]"]`);
                }
                if (!priceInput || priceInput.value === undefined) {
                    priceInput = item.querySelector(`input[name="items[${index}][unit_price]"]`);
                }
                
                const totalSpan = item.querySelector('.item-total');
                
                if (!quantityInput || !priceInput || !totalSpan) {
                    console.warn('Missing input elements in item', index);
                    return;
                }
                
                const quantity = parseFloat(quantityInput.value) || 0;
                const unitPrice = parseFloat(priceInput.value) || 0;
                const total = quantity * unitPrice;
                
                // Update item total display
                totalSpan.textContent = formatAmount(total);
                subtotal += total;
                
                console.log(`Item ${index}: qty=${quantity}, price=${unitPrice}, total=${total}`);
            });
            
            // Update manual subtotal
            manualSubtotal = subtotal;
            
            // Update subtotal displays
            const itemsSubtotalElement = document.getElementById('items-subtotal');
            if (itemsSubtotalElement) {
                itemsSubtotalElement.textContent = formatAmount(subtotal);
            }
            
            // Update hidden subtotal input for form submission
            const subtotalInput = document.getElementById('subtotal-input');
            if (subtotalInput) {
                subtotalInput.value = subtotal.toFixed(2);
            }
            
            console.log('Total subtotal:', subtotal);
            
            // Update the main preview calculations
            updatePreview();
        }
        
        console.log('Script loaded successfully');
    </script>
    @endpush
</x-layouts.app>
