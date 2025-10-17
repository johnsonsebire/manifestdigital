<x-layouts.app :title="__('Order Management')">
    <div class="p-6">
        <header class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Order Management</h1>
                <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">Manage and track customer orders</p>
            </div>
        </header>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-6 gap-4 mb-6">
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-4">
                <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Total Orders</div>
                <div class="mt-1 text-2xl font-semibold text-zinc-900 dark:text-white">{{ $stats['total'] }}</div>
            </div>
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-4">
                <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Pending</div>
                <div class="mt-1 text-2xl font-semibold text-yellow-600">{{ $stats['pending'] }}</div>
            </div>
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-4">
                <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Approved</div>
                <div class="mt-1 text-2xl font-semibold text-blue-600">{{ $stats['approved'] }}</div>
            </div>
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-4">
                <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400">In Progress</div>
                <div class="mt-1 text-2xl font-semibold text-purple-600">{{ $stats['in_progress'] }}</div>
            </div>
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-4">
                <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Completed</div>
                <div class="mt-1 text-2xl font-semibold text-green-600">{{ $stats['completed'] }}</div>
            </div>
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-4">
                <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Total Revenue</div>
                <div class="mt-1 text-2xl font-semibold text-emerald-600">GHS {{ number_format($stats['total_revenue'], 2) }}</div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white dark:bg-zinc-800 shadow rounded-lg p-4 mb-6">
            <form method="GET" action="{{ route('admin.orders.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <!-- Search -->
                    <div>
                        <label for="search" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                            Search
                        </label>
                        <input type="text" 
                            name="search" 
                            id="search" 
                            value="{{ request('search') }}"
                            placeholder="Order ID, customer..."
                            class="w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500">
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                            Status
                        </label>
                        <select name="status" 
                            id="status"
                            class="w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            <option value="">All Statuses</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>

                    <!-- Payment Status Filter -->
                    <div>
                        <label for="payment_status" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                            Payment Status
                        </label>
                        <select name="payment_status" 
                            id="payment_status"
                            class="w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            <option value="">All Payment Statuses</option>
                            <option value="unpaid" {{ request('payment_status') === 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                            <option value="partial" {{ request('payment_status') === 'partial' ? 'selected' : '' }}>Partial</option>
                            <option value="paid" {{ request('payment_status') === 'paid' ? 'selected' : '' }}>Paid</option>
                        </select>
                    </div>

                    <!-- Customer Filter -->
                    <div>
                        <label for="customer_id" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                            Customer
                        </label>
                        <select name="customer_id" 
                            id="customer_id"
                            class="w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            <option value="">All Customers</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" {{ request('customer_id') == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Sort By -->
                    <div>
                        <label for="sort_by" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                            Sort By
                        </label>
                        <select name="sort_by" 
                            id="sort_by"
                            class="w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            <option value="created_at" {{ request('sort_by') === 'created_at' ? 'selected' : '' }}>Date Created</option>
                            <option value="total" {{ request('sort_by') === 'total' ? 'selected' : '' }}>Total Amount</option>
                            <option value="customer_name" {{ request('sort_by') === 'customer_name' ? 'selected' : '' }}>Customer Name</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Date From -->
                    <div>
                        <label for="date_from" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                            From Date
                        </label>
                        <input type="date" 
                            name="date_from" 
                            id="date_from" 
                            value="{{ request('date_from') }}"
                            class="w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500">
                    </div>

                    <!-- Date To -->
                    <div>
                        <label for="date_to" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                            To Date
                        </label>
                        <input type="date" 
                            name="date_to" 
                            id="date_to" 
                            value="{{ request('date_to') }}"
                            class="w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500">
                    </div>

                    <!-- Sort Order -->
                    <div>
                        <label for="sort_order" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                            Sort Order
                        </label>
                        <select name="sort_order" 
                            id="sort_order"
                            class="w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            <option value="desc" {{ request('sort_order') === 'desc' ? 'selected' : '' }}>Newest First</option>
                            <option value="asc" {{ request('sort_order') === 'asc' ? 'selected' : '' }}>Oldest First</option>
                        </select>
                    </div>
                </div>

                <div class="flex gap-2">
                    <button type="submit" 
                        class="px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        Apply Filters
                    </button>
                    <a href="{{ route('admin.orders.index') }}" 
                        class="px-4 py-2 bg-zinc-200 dark:bg-zinc-700 text-zinc-700 dark:text-zinc-300 rounded-md hover:bg-zinc-300 dark:hover:bg-zinc-600">
                        Clear
                    </a>
                </div>
            </form>
        </div>

        <!-- Orders Table -->
        <div class="bg-white dark:bg-zinc-800 shadow rounded-lg overflow-hidden">
            @if(session('success'))
                <div class="bg-green-50 dark:bg-green-900/20 border-l-4 border-green-400 p-4 mb-4">
                    <p class="text-green-700 dark:text-green-400">{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 dark:bg-red-900/20 border-l-4 border-red-400 p-4 mb-4">
                    <p class="text-red-700 dark:text-red-400">{{ session('error') }}</p>
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                    <thead class="bg-zinc-50 dark:bg-zinc-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">Order #</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">Customer</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">Items</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">Total</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">Project</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">Date</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                
                <tbody class="bg-white dark:bg-zinc-800 divide-y divide-zinc-200 dark:divide-zinc-700">
                    @forelse($orders as $order)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-700/50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-zinc-900 dark:text-white">
                                {{ $order->order_number }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-900 dark:text-white">
                                <div>{{ $order->user->name }}</div>
                                <div class="text-xs text-zinc-500 dark:text-zinc-400">{{ $order->user->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">
                                {{ $order->items_count }} {{ Str::plural('item', $order->items_count) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-900 dark:text-white font-medium">
                                ₦{{ number_format($order->total_amount, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300',
                                        'initiated' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300',
                                        'paid' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
                                        'processing' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300',
                                        'completed' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
                                        'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                                        'refunded' => 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-300',
                                    ];
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$order->status] ?? 'bg-zinc-100 text-zinc-800' }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">
                                @if($order->project)
                                    <a href="#" class="text-primary-600 hover:underline">
                                        View Project
                                    </a>
                                @else
                                    <span class="text-zinc-400">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">
                                {{ $order->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <a href="{{ route('admin.orders.show', $order) }}" 
                                    class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300"
                                    wire:navigate>
                                    View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-zinc-500 dark:text-zinc-400">
                                <svg class="mx-auto h-12 w-12 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                <p class="mt-4 text-sm">No orders found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($orders->hasPages())
            <div class="px-6 py-4 border-t border-zinc-200 dark:border-zinc-700">
                {{ $orders->links() }}
            </div>
        @endif
        </div>
    </div>
</x-layouts.app>
