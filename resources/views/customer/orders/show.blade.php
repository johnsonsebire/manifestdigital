<x-layouts.app :title="'Order #' . $order->order_number">
    <div class="p-6 max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <a href="{{ route('customer.orders.index') }}" 
                class="text-sm text-primary-600 hover:text-primary-700 dark:text-primary-400 mb-2 inline-block"
                wire:navigate>
                ← Back to My Orders
            </a>
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Order #{{ $order->order_number }}</h1>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                        Placed on {{ $order->created_at->format('F d, Y \a\t h:i A') }}
                    </p>
                </div>
                
                <div>
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
                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium {{ $statusColors[$order->status] ?? 'bg-zinc-100 text-zinc-800' }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
            </div>
        </div>

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
                                        <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                                            {{ $item->service->category->title ?? 'Uncategorized' }}
                                        </p>
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
                                    <span class="text-zinc-900 dark:text-white">₦{{ number_format($order->total_amount, 2) }}</span>
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
                                                    {{ ucfirst(str_replace('_', ' ', $payment->gateway)) }}
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
                        <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Order Timeline</h2>
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
                <!-- Related Project -->
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
                                <div>
                                    <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Tasks</div>
                                    <div class="mt-1 text-sm text-zinc-900 dark:text-white">
                                        {{ $order->project->tasks->where('status', 'completed')->count() }} / {{ $order->project->tasks->count() }} completed
                                    </div>
                                </div>
                                <a href="{{ route('customer.projects.show', $order->project) }}" 
                                    class="block w-full text-center px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700 text-sm mt-4"
                                    wire:navigate>
                                    View Project Details
                                </a>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Order Summary -->
                <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                    <h3 class="text-sm font-medium text-zinc-500 dark:text-zinc-400 mb-4">Order Summary</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-zinc-600 dark:text-zinc-400">Order Number</span>
                            <span class="text-zinc-900 dark:text-white font-mono">{{ $order->order_number }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-zinc-600 dark:text-zinc-400">Items</span>
                            <span class="text-zinc-900 dark:text-white">{{ $order->items->count() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-zinc-600 dark:text-zinc-400">Order Date</span>
                            <span class="text-zinc-900 dark:text-white">{{ $order->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Order Actions -->
                @if($order->status === 'approved')
                    <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                        <h3 class="text-sm font-medium text-zinc-500 dark:text-zinc-400 mb-4">Order Actions</h3>
                        <a href="{{ route('customer.orders.change-request.create', $order) }}" 
                            class="block w-full text-center px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700 text-sm"
                            wire:navigate>
                            <svg class="inline-block w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Request Change/Upgrade
                        </a>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-2">
                            Need to add or modify items in your order? Submit a change request for review.
                        </p>
                    </div>
                @endif

                <!-- Change Requests -->
                @if($order->changeRequests->count() > 0)
                    <div class="bg-white dark:bg-zinc-800 rounded-lg shadow overflow-hidden">
                        <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700">
                            <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Change Requests</h2>
                        </div>
                        <div class="p-6">
                            <div class="space-y-3">
                                @foreach($order->changeRequests->sortByDesc('created_at') as $changeRequest)
                                    <div class="border border-zinc-200 dark:border-zinc-700 rounded-lg p-4">
                                        <div class="flex items-start justify-between mb-2">
                                            <div>
                                                <div class="text-sm font-medium text-zinc-900 dark:text-white">
                                                    Request #{{ $changeRequest->id }}
                                                </div>
                                                <div class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">
                                                    {{ $changeRequest->created_at->format('M d, Y') }}
                                                </div>
                                            </div>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium 
                                                {{ $changeRequest->status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300' : '' }}
                                                {{ $changeRequest->status === 'approved' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' : '' }}
                                                {{ $changeRequest->status === 'rejected' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300' : '' }}
                                                {{ $changeRequest->status === 'applied' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300' : '' }}">
                                                {{ ucfirst($changeRequest->status) }}
                                            </span>
                                        </div>
                                        <div class="text-sm text-zinc-600 dark:text-zinc-400 mb-3">
                                            Type: {{ ucfirst(str_replace('_', ' ', $changeRequest->type)) }}
                                        </div>
                                        <a href="{{ route('customer.orders.change-request.show', [$order, $changeRequest]) }}" 
                                            class="text-sm text-primary-600 hover:text-primary-700 dark:text-primary-400"
                                            wire:navigate>
                                            View Details →
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Need Help? -->
                <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-6">
                    <h3 class="text-sm font-medium text-blue-900 dark:text-blue-300 mb-2">Need Help?</h3>
                    <p class="text-sm text-blue-800 dark:text-blue-400 mb-4">
                        Have questions about your order? Our support team is here to help.
                    </p>
                    <a href="mailto:support@manifestghana.com" 
                        class="inline-flex items-center text-sm font-medium text-blue-900 dark:text-blue-300 hover:text-blue-700 dark:hover:text-blue-200">
                        Contact Support
                        <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
