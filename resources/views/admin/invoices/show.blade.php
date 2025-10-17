<x-layouts.app title="Invoice {{ $invoice->invoice_number }}">
    <div class="max-w-5xl mx-auto">
        <!-- Header -->
        <div class="mb-6 flex items-center justify-between">
            <div>
                <flux:breadcrumbs>
                    <flux:breadcrumbs.item href="{{ route('admin.invoices.index') }}">Invoices</flux:breadcrumbs.item>
                    <flux:breadcrumbs.item>{{ $invoice->invoice_number }}</flux:breadcrumbs.item>
                </flux:breadcrumbs>
                <h1 class="mt-2 text-2xl font-semibold text-zinc-900 dark:text-white">{{ $invoice->invoice_number }}</h1>
            </div>
            
            <div class="flex items-center gap-2">
                @if($invoice->status === 'draft')
                    <form action="{{ route('admin.invoices.send', $invoice) }}" method="POST">
                        @csrf
                        <flux:button type="submit" variant="primary">Send Invoice</flux:button>
                    </form>
                @endif
                
                @if($invoice->status !== 'paid' && $invoice->status !== 'cancelled')
                    <a href="{{ route('admin.invoices.edit', $invoice) }}">
                        <flux:button variant="ghost">Edit</flux:button>
                    </a>
                @endif
                
                <a href="{{ route('admin.invoices.pdf', $invoice) }}">
                    <flux:button variant="ghost">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Download PDF
                    </flux:button>
                </a>
            </div>
        </div>

        <!-- Invoice Details -->
        <div class="bg-white dark:bg-zinc-800 rounded-lg shadow overflow-hidden mb-6">
            <div class="p-8">
                <!-- Header Info -->
                <div class="grid grid-cols-2 gap-8 mb-8">
                    <div>
                        <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">From:</h2>
                        <div class="text-sm text-zinc-600 dark:text-zinc-400">
                            <div class="font-medium text-zinc-900 dark:text-white">Your Company Name</div>
                            <div>123 Business Street</div>
                            <div>City, State 12345</div>
                            <div>contact@company.com</div>
                        </div>
                    </div>
                    
                    <div>
                        <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Bill To:</h2>
                        <div class="text-sm text-zinc-600 dark:text-zinc-400">
                            <div class="font-medium text-zinc-900 dark:text-white">{{ $invoice->customer->name }}</div>
                            <div>{{ $invoice->customer->email }}</div>
                            @if($invoice->customer->phone)
                                <div>{{ $invoice->customer->phone }}</div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Invoice Meta -->
                <div class="grid grid-cols-2 gap-8 mb-8 pb-8 border-b border-zinc-200 dark:border-zinc-700">
                    <div>
                        <div class="text-sm text-zinc-600 dark:text-zinc-400 mb-1">Invoice Number:</div>
                        <div class="text-lg font-semibold text-zinc-900 dark:text-white">{{ $invoice->invoice_number }}</div>
                    </div>
                    
                    <div>
                        <div class="text-sm text-zinc-600 dark:text-zinc-400 mb-1">Status:</div>
                        <flux:badge :color="$invoice->status_color">{{ ucfirst($invoice->status) }}</flux:badge>
                    </div>
                    
                    <div>
                        <div class="text-sm text-zinc-600 dark:text-zinc-400 mb-1">Invoice Date:</div>
                        <div class="text-sm font-medium text-zinc-900 dark:text-white">{{ $invoice->invoice_date->format('F d, Y') }}</div>
                    </div>
                    
                    <div>
                        <div class="text-sm text-zinc-600 dark:text-zinc-400 mb-1">Due Date:</div>
                        <div class="text-sm font-medium text-zinc-900 dark:text-white">
                            {{ $invoice->due_date->format('F d, Y') }}
                            @if($invoice->isOverdue())
                                <span class="text-red-600 dark:text-red-400">({{ $invoice->days_overdue }} days overdue)</span>
                            @endif
                        </div>
                    </div>
                    
                    @if($invoice->order_id)
                        <div>
                            <div class="text-sm text-zinc-600 dark:text-zinc-400 mb-1">Related Order:</div>
                            <a href="{{ route('admin.orders.show', $invoice->order) }}" 
                               class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                                Order #{{ $invoice->order->id }}
                            </a>
                        </div>
                    @else
                        <div>
                            <div class="text-sm text-zinc-600 dark:text-zinc-400 mb-1">Invoice Type:</div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200">
                                Manual Invoice
                            </span>
                        </div>
                    @endif
                </div>

                <!-- Line Items -->
                <div class="mb-8">
                    <table class="min-w-full">
                        <thead class="border-b-2 border-zinc-200 dark:border-zinc-700">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                    Description
                                </th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                    Quantity
                                </th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                    Unit Price
                                </th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                    Total
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                            @if($invoice->order_id)
                                @foreach($invoice->order->items as $item)
                                    <tr>
                                        <td class="px-4 py-4 text-sm text-zinc-900 dark:text-white">
                                            <div class="font-medium">{{ $item->service->name }}</div>
                                            @if($item->service->description)
                                                <div class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">{{ $item->service->description }}</div>
                                            @endif
                                        </td>
                                        <td class="px-4 py-4 text-sm text-right text-zinc-900 dark:text-white">
                                            {{ $item->quantity }}
                                        </td>
                                        <td class="px-4 py-4 text-sm text-right text-zinc-900 dark:text-white">
                                            ${{ number_format($item->unit_price, 2) }}
                                        </td>
                                        <td class="px-4 py-4 text-sm text-right font-medium text-zinc-900 dark:text-white">
                                            ${{ number_format($item->total_price, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                @foreach($invoice->metadata['items'] ?? [] as $item)
                                    <tr>
                                        <td class="px-4 py-4 text-sm text-zinc-900 dark:text-white">
                                            <div class="font-medium">{{ $item['description'] }}</div>
                                        </td>
                                        <td class="px-4 py-4 text-sm text-right text-zinc-900 dark:text-white">
                                            {{ $item['quantity'] }}
                                        </td>
                                        <td class="px-4 py-4 text-sm text-right text-zinc-900 dark:text-white">
                                            ${{ number_format($item['unit_price'], 2) }}
                                        </td>
                                        <td class="px-4 py-4 text-sm text-right font-medium text-zinc-900 dark:text-white">
                                            ${{ number_format($item['quantity'] * $item['unit_price'], 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>

                <!-- Totals -->
                <div class="flex justify-end">
                    <div class="w-80">
                        <div class="flex justify-between py-2 text-sm">
                            <span class="text-zinc-600 dark:text-zinc-400">Subtotal:</span>
                            <span class="font-medium text-zinc-900 dark:text-white">${{ number_format($invoice->subtotal, 2) }}</span>
                        </div>
                        
                        @if($invoice->discount_amount > 0)
                            <div class="flex justify-between py-2 text-sm">
                                <span class="text-zinc-600 dark:text-zinc-400">Discount:</span>
                                <span class="font-medium text-green-600 dark:text-green-400">-${{ number_format($invoice->discount_amount, 2) }}</span>
                            </div>
                        @endif
                        
                        <div class="flex justify-between py-2 text-sm">
                            <span class="text-zinc-600 dark:text-zinc-400">Tax ({{ number_format($invoice->tax_rate, 2) }}%):</span>
                            <span class="font-medium text-zinc-900 dark:text-white">${{ number_format($invoice->tax_amount, 2) }}</span>
                        </div>
                        
                        <div class="flex justify-between py-3 text-base font-semibold border-t-2 border-zinc-200 dark:border-zinc-700">
                            <span class="text-zinc-900 dark:text-white">Total:</span>
                            <span class="text-zinc-900 dark:text-white">${{ number_format($invoice->total_amount, 2) }}</span>
                        </div>
                        
                        @if($invoice->amount_paid > 0)
                            <div class="flex justify-between py-2 text-sm">
                                <span class="text-zinc-600 dark:text-zinc-400">Amount Paid:</span>
                                <span class="font-medium text-green-600 dark:text-green-400">${{ number_format($invoice->amount_paid, 2) }}</span>
                            </div>
                            
                            <div class="flex justify-between py-3 text-base font-semibold border-t border-zinc-200 dark:border-zinc-700">
                                <span class="text-zinc-900 dark:text-white">Balance Due:</span>
                                <span class="text-zinc-900 dark:text-white">${{ number_format($invoice->balance_due, 2) }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                @if($invoice->notes)
                    <div class="mt-8 pt-8 border-t border-zinc-200 dark:border-zinc-700">
                        <h3 class="text-sm font-medium text-zinc-900 dark:text-white mb-2">Notes:</h3>
                        <p class="text-sm text-zinc-600 dark:text-zinc-400">{{ $invoice->notes }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Payment Recording -->
        @if($invoice->status !== 'paid' && $invoice->status !== 'cancelled' && $invoice->balance_due > 0)
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6 mb-6">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Record Payment</h2>
                
                <form action="{{ route('admin.invoices.payment', $invoice) }}" method="POST" class="grid grid-cols-2 gap-4">
                    @csrf
                    
                    <div>
                        <flux:label>Amount</flux:label>
                        <flux:input 
                            type="number" 
                            name="amount" 
                            step="0.01" 
                            max="{{ $invoice->balance_due }}"
                            placeholder="0.00"
                            required
                        />
                        <flux:error name="amount" />
                    </div>
                    
                    <div>
                        <flux:label>Payment Method</flux:label>
                        <flux:select name="payment_method" required>
                            <option value="">Select method</option>
                            <option value="cash">Cash</option>
                            <option value="check">Check</option>
                            <option value="credit_card">Credit Card</option>
                            <option value="bank_transfer">Bank Transfer</option>
                            <option value="paypal">PayPal</option>
                            <option value="other">Other</option>
                        </flux:select>
                        <flux:error name="payment_method" />
                    </div>
                    
                    <div>
                        <flux:label>Payment Date</flux:label>
                        <flux:input 
                            type="date" 
                            name="payment_date" 
                            value="{{ date('Y-m-d') }}"
                            required
                        />
                        <flux:error name="payment_date" />
                    </div>
                    
                    <div>
                        <flux:label>Transaction ID (Optional)</flux:label>
                        <flux:input 
                            type="text" 
                            name="transaction_id" 
                            placeholder="Transaction reference"
                        />
                    </div>
                    
                    <div class="col-span-2">
                        <flux:label>Notes (Optional)</flux:label>
                        <flux:textarea 
                            name="notes" 
                            rows="2"
                            placeholder="Additional payment notes"
                        />
                    </div>
                    
                    <div class="col-span-2 flex gap-2">
                        <flux:button type="submit" variant="primary">Record Payment</flux:button>
                        
                        <form action="{{ route('admin.invoices.mark-paid', $invoice) }}" method="POST">
                            @csrf
                            <flux:button type="submit" variant="ghost">Mark as Fully Paid</flux:button>
                        </form>
                    </div>
                </form>
            </div>
        @endif

        <!-- Payment History -->
        @if(isset($invoice->metadata['payments']) && count($invoice->metadata['payments']) > 0)
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6 mb-6">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Payment History</h2>
                
                <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase">Date</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase">Amount</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase">Method</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase">Transaction ID</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase">Notes</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        @foreach($invoice->metadata['payments'] as $payment)
                            <tr>
                                <td class="px-4 py-3 text-sm text-zinc-900 dark:text-white">
                                    {{ \Carbon\Carbon::parse($payment['date'])->format('M d, Y') }}
                                </td>
                                <td class="px-4 py-3 text-sm font-medium text-green-600 dark:text-green-400">
                                    ${{ number_format($payment['amount'], 2) }}
                                </td>
                                <td class="px-4 py-3 text-sm text-zinc-900 dark:text-white">
                                    {{ ucfirst(str_replace('_', ' ', $payment['payment_method'] ?? 'N/A')) }}
                                </td>
                                <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-400">
                                    {{ $payment['transaction_id'] ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-400">
                                    {{ $payment['notes'] ?? '-' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <!-- Actions -->
        @if($invoice->status !== 'paid' && $invoice->status !== 'cancelled')
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Actions</h2>
                
                <div class="flex gap-2">
                    <form action="{{ route('admin.invoices.cancel', $invoice) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this invoice?')">
                        @csrf
                        <flux:button type="submit" variant="danger">Cancel Invoice</flux:button>
                    </form>
                </div>
            </div>
        @endif
    </div>
</x-layouts.app>
