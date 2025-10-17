<x-layouts.app title="Invoices">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-zinc-900 dark:text-white">Invoices</h1>
                <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">Manage customer invoices and payments</p>
            </div>
            <div>
                <a href="{{ route('admin.invoices.create') }}">
                    <flux:button variant="primary">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Create Manual Invoice
                    </flux:button>
                </a>
            </div>
        </div>

        <!-- Filters -->
        <div class="mb-6 bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
            <form method="GET" action="{{ route('admin.invoices.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Search -->
                <div>
                    <flux:input 
                        type="text" 
                        name="search" 
                        placeholder="Search invoice number..." 
                        value="{{ request('search') }}"
                    />
                </div>

                <!-- Status Filter -->
                <div>
                    <flux:select name="status">
                        <option value="">All Statuses</option>
                        <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="sent" {{ request('status') === 'sent' ? 'selected' : '' }}>Sent</option>
                        <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="partial" {{ request('status') === 'partial' ? 'selected' : '' }}>Partial</option>
                        <option value="overdue" {{ request('status') === 'overdue' ? 'selected' : '' }}>Overdue</option>
                        <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </flux:select>
                </div>

                <!-- Date Range -->
                <div>
                    <flux:input 
                        type="date" 
                        name="from_date" 
                        placeholder="From date" 
                        value="{{ request('from_date') }}"
                    />
                </div>

                <div>
                    <flux:input 
                        type="date" 
                        name="to_date" 
                        placeholder="To date" 
                        value="{{ request('to_date') }}"
                    />
                </div>

                <!-- Actions -->
                <div class="md:col-span-4 flex gap-2">
                    <flux:button type="submit" variant="primary">Apply Filters</flux:button>
                    <flux:button type="button" variant="ghost" onclick="window.location.href='{{ route('admin.invoices.index') }}'">
                        Clear
                    </flux:button>
                </div>
            </form>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                <div class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Total Invoices</div>
                <div class="mt-2 text-3xl font-bold text-zinc-900 dark:text-white">{{ $invoices->total() }}</div>
            </div>
            
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                <div class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Pending</div>
                <div class="mt-2 text-3xl font-bold text-amber-600 dark:text-amber-400">
                    {{ $invoices->where('status', 'sent')->count() }}
                </div>
            </div>
            
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                <div class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Overdue</div>
                <div class="mt-2 text-3xl font-bold text-red-600 dark:text-red-400">
                    {{ $invoices->where('status', 'overdue')->count() }}
                </div>
            </div>
            
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                <div class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Paid</div>
                <div class="mt-2 text-3xl font-bold text-green-600 dark:text-green-400">
                    {{ $invoices->where('status', 'paid')->count() }}
                </div>
            </div>
        </div>

        <!-- Invoices Table -->
        <div class="bg-white dark:bg-zinc-800 rounded-lg shadow overflow-hidden">
            @if($invoices->count() > 0)
                <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                    <thead class="bg-zinc-50 dark:bg-zinc-900">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                Invoice #
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                Customer
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                Order
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                Date
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                Due Date
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                Amount
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                Balance
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-zinc-800 divide-y divide-zinc-200 dark:divide-zinc-700">
                        @foreach($invoices as $invoice)
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-700/50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('admin.invoices.show', $invoice) }}" 
                                       class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                                        {{ $invoice->invoice_number }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-zinc-900 dark:text-white">{{ $invoice->customer->name }}</div>
                                    <div class="text-xs text-zinc-500 dark:text-zinc-400">{{ $invoice->customer->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('admin.orders.show', $invoice->order) }}" 
                                       class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                                        #{{ $invoice->order->id }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-900 dark:text-white">
                                    {{ $invoice->invoice_date->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-zinc-900 dark:text-white">{{ $invoice->due_date->format('M d, Y') }}</div>
                                    @if($invoice->isOverdue())
                                        <div class="text-xs text-red-600 dark:text-red-400">
                                            {{ $invoice->days_overdue }} days overdue
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-zinc-900 dark:text-white">
                                    ${{ number_format($invoice->total_amount, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-zinc-900 dark:text-white">
                                    ${{ number_format($invoice->balance_due, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <flux:badge :color="$invoice->status_color" size="sm">
                                        {{ ucfirst($invoice->status) }}
                                    </flux:badge>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.invoices.show', $invoice) }}" 
                                           class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                                            View
                                        </a>
                                        @if($invoice->status !== 'paid' && $invoice->status !== 'cancelled')
                                            <a href="{{ route('admin.invoices.edit', $invoice) }}" 
                                               class="text-amber-600 dark:text-amber-400 hover:text-amber-800 dark:hover:text-amber-300">
                                                Edit
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-zinc-200 dark:border-zinc-700">
                    {{ $invoices->links() }}
                </div>
            @else
                <div class="px-6 py-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-zinc-900 dark:text-white">No invoices</h3>
                    <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                        No invoices match your current filters.
                    </p>
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>
