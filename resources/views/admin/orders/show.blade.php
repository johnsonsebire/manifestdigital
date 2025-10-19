<x-layouts.app :title="'Order #' . $order->order_number">
    <div class="p-6 max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <a href="{{ route('admin.orders.index') }}" 
                    class="text-sm text-primary-600 hover:text-primary-700 dark:text-primary-400 mb-2 inline-block"
                    wire:navigate>
                    ← Back to Orders
                </a>
                <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Order #{{ $order->order_number }}</h1>
                <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                    Placed on {{ $order->created_at->format('F d, Y \a\t h:i A') }}
                </p>
            </div>
            
            <div class="flex items-center gap-3">
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
                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium {{ $statusColors[$order->status] ?? 'bg-zinc-100 text-zinc-800' }}">
                    {{ ucfirst($order->status) }}
                </span>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-50 dark:bg-green-900/20 border-l-4 border-green-400 p-4 mb-6">
                <p class="text-green-700 dark:text-green-400">{{ session('success') }}</p>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 dark:bg-red-900/20 border-l-4 border-red-400 p-4 mb-6">
                <p class="text-red-700 dark:text-red-400">{{ session('error') }}</p>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Order Items -->
                <div class="bg-white dark:bg-zinc-800 rounded-lg shadow overflow-hidden">
                    <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700">
                        <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Order Items</h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            @foreach($order->items as $item)
                                <div class="flex justify-between items-start pb-4 border-b border-zinc-200 dark:border-zinc-700 last:border-0 last:pb-0">
                                    <div class="flex-1">
                                        <h3 class="font-medium text-zinc-900 dark:text-white">
                                            {{ $item->service->title }}
                                        </h3>
                                        @if($item->service->categories->isNotEmpty())
                                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                                                {{ $item->service->categories->pluck('name')->join(', ') }}
                                            </p>
                                        @endif
                                        @if($item->variant)
                                            <p class="text-sm text-zinc-600 dark:text-zinc-300 mt-1">
                                                Variant: {{ $item->variant->name }}
                                            </p>
                                        @endif
                                        @if($item->customizations)
                                            <div class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">
                                                <p class="font-medium">Customizations:</p>
                                                <ul class="list-disc list-inside ml-2">
                                                    @foreach($item->customizations as $key => $value)
                                                        <li>{{ ucfirst(str_replace('_', ' ', $key)) }}: {{ $value }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="text-right ml-4">
                                        <div class="text-sm text-zinc-500 dark:text-zinc-400">
                                            Qty: {{ $item->quantity }}
                                        </div>
                                        <div class="font-medium text-zinc-900 dark:text-white">
                                            ₦{{ number_format($item->price, 2) }}
                                        </div>
                                        <div class="text-sm text-zinc-500 dark:text-zinc-400">
                                            Subtotal: ₦{{ number_format($item->subtotal, 2) }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Order Totals -->
                        <div class="mt-6 pt-6 border-t border-zinc-200 dark:border-zinc-700">
                            <div class="space-y-2">
                                <div class="flex justify-between text-sm">
                                    <span class="text-zinc-600 dark:text-zinc-400">Subtotal</span>
                                    <span class="text-zinc-900 dark:text-white">₦{{ number_format($order->subtotal, 2) }}</span>
                                </div>
                                @if($order->discount_amount > 0)
                                    <div class="flex justify-between text-sm">
                                        <span class="text-zinc-600 dark:text-zinc-400">Discount</span>
                                        <span class="text-green-600">-₦{{ number_format($order->discount_amount, 2) }}</span>
                                    </div>
                                @endif
                                @if($order->tax_amount > 0)
                                    <div class="flex justify-between text-sm">
                                        <span class="text-zinc-600 dark:text-zinc-400">Tax</span>
                                        <span class="text-zinc-900 dark:text-white">₦{{ number_format($order->tax_amount, 2) }}</span>
                                    </div>
                                @endif
                                <div class="flex justify-between text-lg font-semibold pt-2 border-t border-zinc-200 dark:border-zinc-700">
                                    <span class="text-zinc-900 dark:text-white">Total</span>
                                    <span class="text-zinc-900 dark:text-white">₦{{ number_format($order->total, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Information -->
                @if($order->payments->count() > 0)
                    <div class="bg-white dark:bg-zinc-800 rounded-lg shadow overflow-hidden">
                        <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700">
                            <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Payment Information</h2>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                @foreach($order->payments as $payment)
                                    <div class="border border-zinc-200 dark:border-zinc-700 rounded-lg p-4">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <div class="font-medium text-zinc-900 dark:text-white">
                                                    {{ ucfirst($payment->gateway) }}
                                                </div>
                                                <div class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                                                    Reference: {{ $payment->reference }}
                                                </div>
                                                <div class="text-sm text-zinc-500 dark:text-zinc-400">
                                                    {{ $payment->created_at->format('M d, Y h:i A') }}
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <div class="font-medium text-zinc-900 dark:text-white">
                                                    ₦{{ number_format($payment->amount, 2) }}
                                                </div>
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium 
                                                    {{ $payment->status === 'successful' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' : '' }}
                                                    {{ $payment->status === 'failed' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300' : '' }}
                                                    {{ $payment->status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300' : '' }}">
                                                    {{ ucfirst($payment->status) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Activity Timeline -->
                <div class="bg-white dark:bg-zinc-800 rounded-lg shadow overflow-hidden">
                    <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700">
                        <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Activity Timeline</h2>
                    </div>
                    <div class="p-6">
                        <div class="flow-root">
                            <ul role="list" class="-mb-8">
                                @foreach($activities as $index => $activity)
                                    <li>
                                        <div class="relative pb-8">
                                            @if(!$loop->last)
                                                <span class="absolute left-4 top-4 -ml-px h-full w-0.5 bg-zinc-200 dark:bg-zinc-700" aria-hidden="true"></span>
                                            @endif
                                            <div class="relative flex space-x-3">
                                                <div>
                                                    <span class="h-8 w-8 rounded-full bg-primary-500 flex items-center justify-center ring-8 ring-white dark:ring-zinc-800">
                                                        <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                        </svg>
                                                    </span>
                                                </div>
                                                <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                                                    <div>
                                                        <p class="text-sm text-zinc-900 dark:text-white">
                                                            {{ $activity->description }}
                                                        </p>
                                                        @if($activity->user)
                                                            <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                                                by {{ $activity->user->name }}
                                                            </p>
                                                        @endif
                                                    </div>
                                                    <div class="whitespace-nowrap text-right text-sm text-zinc-500 dark:text-zinc-400">
                                                        <time datetime="{{ $activity->created_at->toIso8601String() }}">
                                                            {{ $activity->created_at->diffForHumans() }}
                                                        </time>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Customer Information -->
                <div class="bg-white dark:bg-zinc-800 rounded-lg shadow overflow-hidden">
                    <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700">
                        <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Customer</h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3">
                            <div>
                                <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Name</div>
                                <div class="mt-1 text-sm text-zinc-900 dark:text-white">
                                    {{ $order->getCustomerDisplayName() }}
                                </div>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Email</div>
                                <div class="mt-1 text-sm text-zinc-900 dark:text-white">
                                    {{ $order->customer ? $order->customer->email : ($order->customer_email ?? 'N/A') }}
                                </div>
                            </div>
                            @if($order->customer?->phone || $order->customer_phone)
                                <div>
                                    <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Phone</div>
                                    <div class="mt-1 text-sm text-zinc-900 dark:text-white">
                                        {{ $order->customer?->phone ?? $order->customer_phone }}
                                    </div>
                                </div>
                            @endif
                            @if($order->customer_address)
                                <div>
                                    <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Address</div>
                                    <div class="mt-1 text-sm text-zinc-900 dark:text-white">{{ $order->customer_address }}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Project Information -->
                @if($order->project)
                    <div class="bg-white dark:bg-zinc-800 rounded-lg shadow overflow-hidden">
                        <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700">
                            <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Related Project</h2>
                        </div>
                        <div class="p-6">
                            <div class="space-y-3">
                                <div>
                                    <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Title</div>
                                    <div class="mt-1 text-sm text-zinc-900 dark:text-white">{{ $order->project->title }}</div>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Status</div>
                                    <div class="mt-1">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                                            {{ ucfirst($order->project->status) }}
                                        </span>
                                    </div>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Progress</div>
                                    <div class="mt-2">
                                        <div class="flex items-center">
                                            <div class="flex-1 bg-zinc-200 dark:bg-zinc-700 rounded-full h-2">
                                                <div class="bg-primary-600 h-2 rounded-full" style="width: {{ $order->project->completion_percentage }}%"></div>
                                            </div>
                                            <span class="ml-2 text-sm text-zinc-600 dark:text-zinc-400">{{ $order->project->completion_percentage }}%</span>
                                        </div>
                                    </div>
                                </div>
                                <a href="#" 
                                    class="block w-full text-center px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700 text-sm">
                                    View Project
                                </a>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Order Actions -->
                @can('manage-orders')
                    <div class="bg-white dark:bg-zinc-800 rounded-lg shadow overflow-hidden">
                        <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700">
                            <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Actions</h2>
                        </div>
                        <div class="p-6 space-y-3">
                            @if($order->invoice)
                                <a href="{{ route('admin.invoices.show', $order->invoice) }}" 
                                    class="block w-full px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm font-medium text-center">
                                    View Invoice
                                </a>
                            @elseif(in_array($order->status, ['paid', 'approved']))
                                <a href="{{ route('admin.orders.invoices.create', $order) }}" 
                                    class="block w-full px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm font-medium text-center">
                                    Generate Invoice
                                </a>
                            @endif

                            @if($order->status === 'paid')
                                <form action="{{ route('admin.orders.approve', $order) }}" method="POST">
                                    @csrf
                                    <button type="submit" 
                                        onclick="return confirm('Approve this order and create a project?')"
                                        class="w-full px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 text-sm font-medium">
                                        Approve Order
                                    </button>
                                </form>
                            @endif

                            @if($order->status === 'initiated')
                                <button type="button"
                                    onclick="document.getElementById('mark-paid-modal').classList.remove('hidden')"
                                    class="w-full px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm font-medium">
                                    Mark as Paid
                                </button>
                            @endif

                            @if($order->status === 'processing')
                                <form action="{{ route('admin.orders.complete', $order) }}" method="POST">
                                    @csrf
                                    <button type="submit" 
                                        onclick="return confirm('Mark this order as completed?')"
                                        class="w-full px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 text-sm font-medium">
                                        Mark Completed
                                    </button>
                                </form>
                            @endif

                            @if(in_array($order->status, ['pending', 'initiated', 'paid', 'processing']))
                                <button type="button"
                                    onclick="document.getElementById('reject-modal').classList.remove('hidden')"
                                    class="w-full px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 text-sm font-medium">
                                    Cancel Order
                                </button>
                            @endif
                        </div>
                    </div>
                @endcan
            </div>
        </div>
    </div>

    <!-- Mark as Paid Modal -->
    <div id="mark-paid-modal" class="hidden fixed inset-0 bg-zinc-500 bg-opacity-75 flex items-center justify-center z-50">
        <div class="bg-white dark:bg-zinc-800 rounded-lg p-6 max-w-md w-full mx-4">
            <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Mark Order as Paid</h3>
            <form action="{{ route('admin.orders.mark-paid', $order) }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="reference" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                            Payment Reference <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                            name="reference" 
                            id="reference" 
                            required
                            class="w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500">
                    </div>
                    <div>
                        <label for="notes" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                            Notes
                        </label>
                        <textarea name="notes" 
                            id="notes" 
                            rows="3"
                            class="w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500"></textarea>
                    </div>
                    <div class="flex gap-3">
                        <button type="submit" 
                            class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Confirm Payment
                        </button>
                        <button type="button" 
                            onclick="document.getElementById('mark-paid-modal').classList.add('hidden')"
                            class="flex-1 px-4 py-2 bg-zinc-200 dark:bg-zinc-700 text-zinc-700 dark:text-zinc-300 rounded-md hover:bg-zinc-300 dark:hover:bg-zinc-600">
                            Cancel
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Reject/Cancel Modal -->
    <div id="reject-modal" class="hidden fixed inset-0 bg-zinc-500 bg-opacity-75 flex items-center justify-center z-50">
        <div class="bg-white dark:bg-zinc-800 rounded-lg p-6 max-w-md w-full mx-4">
            <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Cancel Order</h3>
            <form action="{{ route('admin.orders.reject', $order) }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="reason" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                            Cancellation Reason <span class="text-red-500">*</span>
                        </label>
                        <textarea name="reason" 
                            id="reason" 
                            rows="4"
                            required
                            class="w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500"></textarea>
                    </div>
                    <div class="flex gap-3">
                        <button type="submit" 
                            class="flex-1 px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                            Cancel Order
                        </button>
                        <button type="button" 
                            onclick="document.getElementById('reject-modal').classList.add('hidden')"
                            class="flex-1 px-4 py-2 bg-zinc-200 dark:bg-zinc-700 text-zinc-700 dark:text-zinc-300 rounded-md hover:bg-zinc-300 dark:hover:bg-zinc-600">
                            Close
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
