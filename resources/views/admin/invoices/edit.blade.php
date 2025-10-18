<x-layouts.app title="Edit Invoice">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <flux:breadcrumbs>
                <flux:breadcrumbs.item href="{{ route('admin.invoices.index') }}">Invoices</flux:breadcrumbs.item>
                <flux:breadcrumbs.item href="{{ route('admin.invoices.show', $invoice) }}">{{ $invoice->invoice_number }}</flux:breadcrumbs.item>
                <flux:breadcrumbs.item>Edit</flux:breadcrumbs.item>
            </flux:breadcrumbs>
            <h1 class="mt-2 text-2xl font-semibold text-zinc-900 dark:text-white">Edit Invoice</h1>
            <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">Update invoice {{ $invoice->invoice_number }}</p>
        </div>

        <!-- Invoice Form -->
        <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
            <form action="{{ route('admin.invoices.update', $invoice) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <flux:label for="invoice_date">Invoice Date</flux:label>
                        <flux:input 
                            type="date" 
                            name="invoice_date" 
                            id="invoice_date"
                            value="{{ old('invoice_date', $invoice->invoice_date->format('Y-m-d')) }}"
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
                            value="{{ old('due_date', $invoice->due_date->format('Y-m-d')) }}"
                            required
                        />
                        <flux:error name="due_date" />
                    </div>
                </div>

                <!-- Currency Selection -->
                <div>
                    <flux:label for="currency_id">Invoice Currency</flux:label>
                    <flux:select name="currency_id" id="currency_id" required>
                        <option value="">Select Currency</option>
                        @foreach($currencies as $currency)
                            <option value="{{ $currency->id }}" 
                                    data-code="{{ $currency->code }}"
                                    data-symbol="{{ $currency->symbol }}"
                                    data-exchange-rate="{{ $currency->exchange_rate }}"
                                    {{ old('currency_id', $invoice->currency_id) == $currency->id ? 'selected' : '' }}>
                                {{ $currency->name }} ({{ $currency->code }}) - {{ $currency->symbol }}
                            </option>
                        @endforeach
                    </flux:select>
                    <flux:error name="currency_id" />
                    <flux:description>
                        Select the currency for this invoice. Exchange rates will be applied automatically.
                    </flux:description>
                </div>

                <!-- Tax Selection -->
                <div>
                    <flux:label>Applicable Taxes</flux:label>
                    <div class="space-y-2 border border-zinc-200 dark:border-zinc-700 rounded-lg p-4" id="tax-selection">
                        <div class="text-sm text-zinc-600 dark:text-zinc-400" id="tax-loading">
                            Loading applicable taxes...
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
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-zinc-500" id="discount-currency">{{ $invoice->currency->symbol ?? '$' }}</span>
                            <flux:input 
                                type="number" 
                                name="discount_amount" 
                                id="discount_amount"
                                step="0.01"
                                min="0"
                                value="{{ old('discount_amount', $invoice->discount_amount) }}"
                                class="pl-8"
                            />
                        </div>
                        <flux:error name="discount_amount" />
                    </div>
                    
                    <div>
                        <flux:label for="additional_fees">Additional Fees</flux:label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-zinc-500" id="fees-currency">{{ $invoice->currency->symbol ?? '$' }}</span>
                            <flux:input 
                                type="number" 
                                name="additional_fees" 
                                id="additional_fees"
                                step="0.01"
                                min="0"
                                value="{{ old('additional_fees', $invoice->additional_fees ?? 0) }}"
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
                    >{{ old('notes', $invoice->notes) }}</flux:textarea>
                    <flux:error name="notes" />
                </div>
                
                <!-- Amount Calculation Preview -->
                <div class="bg-zinc-50 dark:bg-zinc-900 rounded-lg p-4">
                    <h3 class="text-sm font-medium text-zinc-900 dark:text-white mb-3">Invoice Summary</h3>
                    
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-zinc-600 dark:text-zinc-400">Subtotal:</span>
                            <span class="font-medium text-zinc-900 dark:text-white" id="subtotal-preview">
                                {{ $invoice->currency->formatAmount($invoice->subtotal) }}
                            </span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-zinc-600 dark:text-zinc-400">Additional Fees:</span>
                            <span class="font-medium text-zinc-900 dark:text-white" id="fees-preview">
                                {{ $invoice->currency->formatAmount($invoice->additional_fees ?? 0) }}
                            </span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-zinc-600 dark:text-zinc-400">Discount:</span>
                            <span class="font-medium text-zinc-900 dark:text-white" id="discount-preview">
                                {{ $invoice->currency->formatAmount($invoice->discount_amount) }}
                            </span>
                        </div>
                        
                        <div id="tax-breakdown" class="space-y-1">
                            @foreach($invoice->taxes as $invoiceTax)
                                <div class="flex justify-between text-xs">
                                    <span class="text-zinc-600 dark:text-zinc-400">
                                        {{ $invoiceTax->tax->name }} 
                                        ({{ $invoiceTax->tax->type === 'percentage' ? $invoiceTax->tax->rate . '%' : $invoice->currency->formatAmount($invoiceTax->tax->rate) }}):
                                    </span>
                                    <span class="text-zinc-900 dark:text-white">
                                        {{ $invoice->currency->formatAmount($invoiceTax->tax_amount) }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-zinc-600 dark:text-zinc-400">Total Tax:</span>
                            <span class="font-medium text-zinc-900 dark:text-white" id="tax-total-preview">
                                {{ $invoice->currency->formatAmount($invoice->tax_amount) }}
                            </span>
                        </div>
                        
                        <div class="flex justify-between pt-2 border-t border-zinc-200 dark:border-zinc-700 font-semibold">
                            <span class="text-zinc-900 dark:text-white">Total:</span>
                            <span class="text-zinc-900 dark:text-white" id="total-preview">
                                {{ $invoice->currency->formatAmount($invoice->total_amount) }}
                            </span>
                        </div>
                        
                        <div class="text-xs text-zinc-500 dark:text-zinc-400 pt-1" id="exchange-rate-info">
                            @if($invoice->currency->code !== 'USD' && $invoice->currency->exchange_rate !== 1)
                                Exchange rate: 1 USD = {{ $invoice->currency->exchange_rate }} {{ $invoice->currency->code }}
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="flex gap-2">
                    <flux:button type="submit" variant="primary">Update Invoice</flux:button>
                    <a href="{{ route('admin.invoices.show', $invoice) }}">
                        <flux:button type="button" variant="ghost">Cancel</flux:button>
                    </a>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        // Initialize variables
        const baseSubtotal = {{ $invoice->subtotal }};
        let currentCurrency = '{{ $invoice->currency->code }}';
        let currentExchangeRate = {{ $invoice->currency->exchange_rate }};
        let applicableTaxes = [];
        let selectedTaxes = [];
        let existingTaxes = @json($invoice->taxes->map(function($invoiceTax) {
            return [
                'id' => $invoiceTax->tax_id,
                'name' => $invoiceTax->tax->name,
                'code' => $invoiceTax->tax->code,
                'rate' => $invoiceTax->tax->rate,
                'type' => $invoiceTax->tax->type
            ];
        }));
        
        // DOM elements
        const currencySelect = document.getElementById('currency_id');
        const taxSelection = document.getElementById('tax-selection');
        const taxLoading = document.getElementById('tax-loading');
        const discountInput = document.getElementById('discount_amount');
        const feesInput = document.getElementById('additional_fees');
        
        // Preview elements
        const subtotalPreview = document.getElementById('subtotal-preview');
        const discountPreview = document.getElementById('discount-preview');
        const feesPreview = document.getElementById('fees-preview');
        const taxBreakdown = document.getElementById('tax-breakdown');
        const taxTotalPreview = document.getElementById('tax-total-preview');
        const totalPreview = document.getElementById('total-preview');
        const exchangeRateInfo = document.getElementById('exchange-rate-info');
        const discountCurrencySymbol = document.getElementById('discount-currency');
        const feesCurrencySymbol = document.getElementById('fees-currency');
        
        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            if (currencySelect.value) {
                loadApplicableTaxes(currencySelect.value);
            }
        });
        
        // Currency change handler
        currencySelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption.value) {
                currentCurrency = selectedOption.getAttribute('data-code');
                currentExchangeRate = parseFloat(selectedOption.getAttribute('data-exchange-rate'));
                const symbol = selectedOption.getAttribute('data-symbol');
                
                // Update currency symbols
                discountCurrencySymbol.textContent = symbol;
                feesCurrencySymbol.textContent = symbol;
                
                // Load applicable taxes
                loadApplicableTaxes(selectedOption.value);
                
                // Update preview
                updatePreview();
            } else {
                currentCurrency = 'USD';
                currentExchangeRate = 1;
                discountCurrencySymbol.textContent = '$';
                feesCurrencySymbol.textContent = '$';
                showTaxLoading();
                updatePreview();
            }
        });
        
        // Input change handlers
        discountInput.addEventListener('input', updatePreview);
        feesInput.addEventListener('input', updatePreview);
        
        // Load applicable taxes for selected currency
        function loadApplicableTaxes(currencyId) {
            showTaxLoading();
            
            fetch('{{ route("admin.invoices.get-applicable-taxes") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    currency_id: currencyId,
                    invoice_id: {{ $invoice->id }}
                })
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
        
        // Render tax selection checkboxes
        function renderTaxSelection() {
            if (applicableTaxes.length === 0) {
                taxSelection.innerHTML = '<div class="text-sm text-zinc-600 dark:text-zinc-400">No taxes applicable for this currency.</div>';
                return;
            }
            
            let html = '';
            applicableTaxes.forEach(tax => {
                // Check if this tax was previously selected
                const wasSelected = existingTaxes.some(existingTax => existingTax.id === tax.id);
                const checked = wasSelected ? 'checked' : (tax.is_default ? 'checked' : '');
                const rateDisplay = tax.type === 'percentage' ? `${tax.rate}%` : `${tax.rate} ${currentCurrency}`;
                
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
            
            // Add event listeners to tax checkboxes
            document.querySelectorAll('.tax-checkbox').forEach(checkbox => {
                checkbox.addEventListener('change', updateSelectedTaxes);
                // Initialize selected taxes if checked
                if (checkbox.checked) {
                    updateSelectedTaxes();
                }
            });
        }
        
        // Update selected taxes array
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
        
        // Update preview calculations
        function updatePreview() {
            const discount = parseFloat(discountInput.value) || 0;
            const additionalFees = parseFloat(feesInput.value) || 0;
            
            // Calculate amounts in selected currency
            const subtotalAfterDiscount = baseSubtotal - discount;
            const subtotalWithFees = subtotalAfterDiscount + additionalFees;
            
            // Calculate taxes
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
            
            // Update preview display
            subtotalPreview.textContent = formatAmount(baseSubtotal);
            feesPreview.textContent = formatAmount(additionalFees);
            discountPreview.textContent = formatAmount(discount);
            taxBreakdown.innerHTML = taxBreakdownHtml;
            taxTotalPreview.textContent = formatAmount(totalTaxAmount);
            totalPreview.textContent = formatAmount(finalTotal);
            
            // Update exchange rate info
            if (currentCurrency && currentCurrency !== 'USD' && currentExchangeRate !== 1) {
                exchangeRateInfo.textContent = `Exchange rate: 1 USD = ${currentExchangeRate} ${currentCurrency}`;
            } else {
                exchangeRateInfo.textContent = '';
            }
        }
        
        // Format amount with current currency symbol
        function formatAmount(amount) {
            const symbol = currentCurrency ? document.querySelector(`#currency_id option[data-code="${currentCurrency}"]`).getAttribute('data-symbol') : '$';
            return symbol + amount.toFixed(2);
        }
        
        // Show loading state for taxes
        function showTaxLoading() {
            taxSelection.innerHTML = '<div class="text-sm text-zinc-600 dark:text-zinc-400" id="tax-loading">Loading applicable taxes...</div>';
        }
        
        // Show error message
        function showError(message) {
            taxSelection.innerHTML = `<div class="text-sm text-red-600 dark:text-red-400">${message}</div>`;
        }
    </script>
    @endpush
</x-layouts.app>
