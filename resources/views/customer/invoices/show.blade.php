<x-layouts.app title="Invoice {{ $invoice->invoice_number }}">
    <div class="max-w-5xl mx-auto">
        <!-- Header -->
        <div class="mb-6 flex items-center justify-between">
            <div>
                <flux:breadcrumbs>
                    <flux:breadcrumbs.item href="{{ route('customer.invoices.index') }}">Invoices</flux:breadcrumbs.item>
                    <flux:breadcrumbs.item>{{ $invoice->invoice_number }}</flux:breadcrumbs.item>
                </flux:breadcrumbs>
                <h1 class="mt-2 text-2xl font-semibold text-zinc-900 dark:text-white">{{ $invoice->invoice_number }}</h1>
            </div>
            
            <div class="flex items-center gap-2">
                <a href="{{ route('customer.invoices.download', $invoice) }}">
                    <flux:button variant="primary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Download PDF
                    </flux:button>
                </a>
            </div>
        </div>

        <!-- Invoice Status Alert -->
        @if($invoice->isOverdue())
            <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
                <div class="flex">
                    <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800 dark:text-red-200">Payment Overdue</h3>
                        <p class="mt-1 text-sm text-red-700 dark:text-red-300">
                            This invoice is {{ $invoice->days_overdue }} days overdue. Please make payment as soon as possible.
                        </p>
                    </div>
                </div>
            </div>
        @elseif($invoice->status === 'sent' && $invoice->balance_due > 0)
            <div class="mb-6 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg p-4">
                <div class="flex">
                    <svg class="h-5 w-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-amber-800 dark:text-amber-200">Payment Due</h3>
                        <p class="mt-1 text-sm text-amber-700 dark:text-amber-300">
                            Payment of ${{ number_format($invoice->balance_due, 2) }} is due by {{ $invoice->due_date->format('F d, Y') }}.
                        </p>
                    </div>
                </div>
            </div>
        @elseif($invoice->status === 'paid')
            <div class="mb-6 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
                <div class="flex">
                    <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-green-800 dark:text-green-200">Paid</h3>
                        <p class="mt-1 text-sm text-green-700 dark:text-green-300">
                            This invoice has been paid in full on {{ $invoice->paid_at->format('F d, Y') }}.
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Invoice Details -->
        <div class="bg-white dark:bg-zinc-800 rounded-lg shadow overflow-hidden">
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
                        </div>
                    </div>
                    
                    <div>
                        <div class="text-sm text-zinc-600 dark:text-zinc-400 mb-1">Related Order:</div>
                        <a href="{{ route('customer.orders.show', $invoice->order) }}" 
                           class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                            Order #{{ $invoice->order->id }}
                        </a>
                    </div>
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
                            
                            <div class="flex justify-between py-3 text-lg font-bold border-t border-zinc-200 dark:border-zinc-700">
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
    </div>
</x-layouts.app>
