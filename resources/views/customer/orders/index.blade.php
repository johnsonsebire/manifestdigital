<x-layouts.app :title="__('My Orders')">
    <div class="p-6">
        <header class="mb-6">
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">My Orders</h1>
            <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">Track and manage your service orders</p>
        </header>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-4">
                <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Total Orders</div>
                <div class="mt-1 text-2xl font-semibold text-zinc-900 dark:text-white">{{ $stats['total'] }}</div>
            </div>
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-4">
                <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Pending</div>
                <div class="mt-1 text-2xl font-semibold text-yellow-600">{{ $stats['pending'] }}</div>
            </div>
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-4">
                <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Active</div>
                <div class="mt-1 text-2xl font-semibold text-blue-600">{{ $stats['active'] }}</div>
            </div>
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-4">
                <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Completed</div>
                <div class="mt-1 text-2xl font-semibold text-green-600">{{ $stats['completed'] }}</div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white dark:bg-zinc-800 shadow rounded-lg p-4 mb-6">
            <form method="GET" action="{{ route('customer.orders.index') }}" class="flex gap-4 items-end">
                <div class="flex-1">
                    <label for="status" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                        Filter by Status
                    </label>
                    <select name="status" 
                        id="status"
                        class="w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500">
                        <option value="">All Statuses</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="initiated" {{ request('status') === 'initiated' ? 'selected' : '' }}>Payment Initiated</option>
                        <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <button type="submit" 
                    class="px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    Apply
                </button>
                <a href="{{ route('customer.orders.index') }}" 
                    class="px-4 py-2 bg-zinc-200 dark:bg-zinc-700 text-zinc-700 dark:text-zinc-300 rounded-md hover:bg-zinc-300 dark:hover:bg-zinc-600">
                    Clear
                </a>
            </form>
        </div>

        <!-- Orders List -->
        <div class="space-y-4">
            @forelse($orders as $order)
                <div class="bg-white dark:bg-zinc-800 rounded-lg shadow overflow-hidden hover:shadow-md transition-shadow">
                    <div class="p-6">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">
                                        Order #{{ $order->order_number }}
                                    </h3>
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300',
                                            'initiated' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300',
                                            'paid' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
                                            'processing' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300',
                                            'completed' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
                                            'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                                        ];
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$order->status] ?? 'bg-zinc-100 text-zinc-800' }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>
                                
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-3">
                                    Placed on {{ $order->created_at->format('F d, Y \a\t h:i A') }}
                                </p>

                                <!-- Order Items Summary -->
                                <div class="space-y-2">
                                    @foreach($order->items->take(3) as $item)
                                        <div class="flex items-center gap-2 text-sm">
                                            <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-primary-100 dark:bg-primary-900/30 text-primary-800 dark:text-primary-300 text-xs font-medium">
                                                {{ $item->quantity }}
                                            </span>
                                            <span class="text-zinc-900 dark:text-white">{{ $item->service->title }}</span>
                                        </div>
                                    @endforeach
                                    @if($order->items->count() > 3)
                                        <p class="text-sm text-zinc-500 dark:text-zinc-400 ml-8">
                                            +{{ $order->items->count() - 3 }} more {{ Str::plural('item', $order->items->count() - 3) }}
                                        </p>
                                    @endif
                                </div>

                                <!-- Project Link -->
                                @if($order->project)
                                    <div class="mt-4 pt-4 border-t border-zinc-200 dark:border-zinc-700">
                                        <a href="{{ route('customer.projects.show', $order->project) }}" 
                                            class="inline-flex items-center text-sm text-primary-600 hover:text-primary-700 dark:text-primary-400"
                                            wire:navigate>
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            View Project
                                        </a>
                                    </div>
                                @endif
                            </div>

                            <div class="text-right ml-4">
                                <div class="text-sm text-zinc-500 dark:text-zinc-400 mb-1">Total Amount</div>
                                <div class="text-2xl font-bold text-zinc-900 dark:text-white">
                                    ₦{{ number_format($order->total_amount, 2) }}
                                </div>
                                <a href="{{ route('customer.orders.show', $order) }}" 
                                    class="mt-4 inline-flex items-center px-4 py-2 border border-primary-600 rounded-md text-sm font-medium text-primary-600 hover:bg-primary-50 dark:hover:bg-primary-900/20"
                                    wire:navigate>
                                    View Details
                                    <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-zinc-900 dark:text-white">No orders yet</h3>
                    <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">Start by browsing our services and placing your first order.</p>
                    <a href="{{ route('services.index') }}" 
                        class="mt-6 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700"
                        wire:navigate>
                        Browse Services
                    </a>
                </div>
            @endforelse
        </div>

        @if($orders->hasPages())
            <div class="mt-6">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</x-layouts.app>
