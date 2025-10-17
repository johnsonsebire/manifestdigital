<x-layouts.app title="Create Invoice">
    <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <flux:breadcrumbs>
                <flux:breadcrumbs.item href="{{ route('admin.invoices.index') }}">Invoices</flux:breadcrumbs.item>
                <flux:breadcrumbs.item>Create Invoice</flux:breadcrumbs.item>
            </flux:breadcrumbs>
            <h1 class="mt-2 text-2xl font-semibold text-zinc-900 dark:text-white">Create Invoice</h1>
            <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">Generate an invoice for Order #{{ $order->id }}</p>
        </div>

        <!-- Order Summary -->
        <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6 mb-6">
            <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Order Details</h2>
            
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="text-zinc-600 dark:text-zinc-400">Order #:</span>
                    <span class="ml-2 font-medium text-zinc-900 dark:text-white">{{ $order->id }}</span>
                </div>
                <div>
                    <span class="text-zinc-600 dark:text-zinc-400">Customer:</span>
                    <span class="ml-2 font-medium text-zinc-900 dark:text-white">{{ $order->customer->name }}</span>
                </div>
                <div>
                    <span class="text-zinc-600 dark:text-zinc-400">Order Total:</span>
                    <span class="ml-2 font-medium text-zinc-900 dark:text-white">${{ number_format($order->total, 2) }}</span>
                </div>
                <div>
                    <span class="text-zinc-600 dark:text-zinc-400">Order Date:</span>
                    <span class="ml-2 font-medium text-zinc-900 dark:text-white">{{ $order->placed_at->format('M d, Y') }}</span>
                </div>
            </div>
        </div>

        <!-- Invoice Form -->
        <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Invoice Information</h2>
            
            <form action="{{ route('admin.orders.invoices.store', $order) }}" method="POST" class="space-y-6">
                @csrf
                
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
                
                <div class="grid grid-cols-2 gap-4">
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
                            <span class="font-medium text-zinc-900 dark:text-white">${{ number_format($order->total, 2) }}</span>
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
                            <span class="text-zinc-900 dark:text-white" id="total-preview">${{ number_format($order->total, 2) }}</span>
                        </div>
                    </div>
                </div>
                
                <div class="flex gap-2">
                    <flux:button type="submit" variant="primary">Create Invoice</flux:button>
                    <a href="{{ route('admin.orders.show', $order) }}">
                        <flux:button type="button" variant="ghost">Cancel</flux:button>
                    </a>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        // Live calculation preview
        const subtotal = {{ $order->total }};
        const taxInput = document.getElementById('tax_rate');
        const discountInput = document.getElementById('discount_amount');
        const taxPreview = document.getElementById('tax-preview');
        const discountPreview = document.getElementById('discount-preview');
        const totalPreview = document.getElementById('total-preview');
        
        function updatePreview() {
            const taxRate = parseFloat(taxInput.value) || 0;
            const discount = parseFloat(discountInput.value) || 0;
            
            const taxAmount = subtotal * (taxRate / 100);
            const total = subtotal + taxAmount - discount;
            
            discountPreview.textContent = '$' + discount.toFixed(2);
            taxPreview.textContent = '$' + taxAmount.toFixed(2);
            totalPreview.textContent = '$' + total.toFixed(2);
        }
        
        taxInput.addEventListener('input', updatePreview);
        discountInput.addEventListener('input', updatePreview);
    </script>
    @endpush
</x-layouts.app>
