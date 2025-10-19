<x-layouts.app title="{{ $customer->name }}">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <flux:breadcrumbs>
                <flux:breadcrumbs.item href="{{ route('admin.customers.index') }}">Customers</flux:breadcrumbs.item>
                <flux:breadcrumbs.item>{{ $customer->name }}</flux:breadcrumbs.item>
            </flux:breadcrumbs>
            
            <div class="mt-2 flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-semibold text-zinc-900 dark:text-white">{{ $customer->name }}</h1>
                    <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                        Customer since {{ $customer->created_at->format('M d, Y') }}
                    </p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('admin.customers.edit', $customer) }}">
                        <flux:button variant="primary">Edit Customer</flux:button>
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Customer Info -->
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Contact Information</h2>
                    
                    <div class="space-y-3 text-sm">
                        <div>
                            <span class="text-zinc-600 dark:text-zinc-400">Email:</span>
                            <div class="mt-1 font-medium text-zinc-900 dark:text-white">{{ $customer->email }}</div>
                        </div>
                        
                        @if($customer->phone)
                            <div>
                                <span class="text-zinc-600 dark:text-zinc-400">Phone:</span>
                                <div class="mt-1 font-medium text-zinc-900 dark:text-white">{{ $customer->phone }}</div>
                            </div>
                        @endif
                        
                        @if($customer->company)
                            <div>
                                <span class="text-zinc-600 dark:text-zinc-400">Company:</span>
                                <div class="mt-1 font-medium text-zinc-900 dark:text-white">{{ $customer->company }}</div>
                            </div>
                        @endif
                        
                        @if($customer->address)
                            <div>
                                <span class="text-zinc-600 dark:text-zinc-400">Address:</span>
                                <div class="mt-1 font-medium text-zinc-900 dark:text-white">{{ $customer->address }}</div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Quick Stats</h2>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-zinc-600 dark:text-zinc-400">Total Orders:</span>
                            <span class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $customer->orders->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-zinc-600 dark:text-zinc-400">Invoices:</span>
                            <span class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $customer->invoices->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-zinc-600 dark:text-zinc-400">Projects:</span>
                            <span class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $customer->projects->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Recent Orders -->
                <div class="bg-white dark:bg-zinc-800 rounded-lg shadow">
                    <div class="p-6 border-b border-zinc-200 dark:border-zinc-700">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Recent Orders</h2>
                            <a href="{{ route('admin.orders.index', ['customer' => $customer->id]) }}" class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                View All
                            </a>
                        </div>
                    </div>
                    <div class="p-6">
                        @if($customer->orders->count() > 0)
                            <div class="space-y-3">
                                @foreach($customer->orders->take(5) as $order)
                                    <div class="flex items-center justify-between py-3 border-b border-zinc-200 dark:border-zinc-700 last:border-0">
                                        <div>
                                            <a href="{{ route('admin.orders.show', $order) }}" class="text-sm font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                                Order #{{ $order->id }}
                                            </a>
                                            <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">
                                                {{ $order->placed_at->format('M d, Y') }}
                                            </p>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-sm font-semibold text-zinc-900 dark:text-white">
                                                {!! $currencyService->formatAmount($order->total ?? 0, $userCurrency->code) !!}
                                            </div>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                                @if($order->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                                @elseif($order->status === 'approved') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                                @elseif($order->status === 'in_progress') bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200
                                                @elseif($order->status === 'completed') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                                @elseif($order->status === 'rejected') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                                @endif">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-sm text-zinc-500 dark:text-zinc-400 text-center py-8">No orders yet</p>
                        @endif
                    </div>
                </div>

                <!-- Recent Projects -->
                <div class="bg-white dark:bg-zinc-800 rounded-lg shadow">
                    <div class="p-6 border-b border-zinc-200 dark:border-zinc-700">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Projects</h2>
                            <a href="{{ route('admin.projects.index', ['customer' => $customer->id]) }}" class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                View All
                            </a>
                        </div>
                    </div>
                    <div class="p-6">
                        @if($customer->projects->count() > 0)
                            <div class="space-y-3">
                                @foreach($customer->projects->take(5) as $project)
                                    <div class="flex items-center justify-between py-3 border-b border-zinc-200 dark:border-zinc-700 last:border-0">
                                        <div>
                                            <a href="{{ route('admin.projects.show', $project) }}" class="text-sm font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                                {{ $project->name }}
                                            </a>
                                            <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">
                                                {{ $project->created_at->format('M d, Y') }}
                                            </p>
                                        </div>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                            @if($project->status === 'planning') bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200
                                            @elseif($project->status === 'in_progress') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                            @elseif($project->status === 'on_hold') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                            @elseif($project->status === 'complete') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                            @elseif($project->status === 'archived') bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200
                                            @endif">
                                            {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-sm text-zinc-500 dark:text-zinc-400 text-center py-8">No projects yet</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
