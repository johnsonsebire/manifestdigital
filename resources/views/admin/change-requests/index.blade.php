<x-layouts.app :title="__('Order Change Requests')">
    <div class="p-6 space-y-6">
        <!-- Header -->
        <header class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Order Change Requests</h1>
                <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">Manage customer requests to modify their orders</p>
            </div>
        </header>

        <!-- Filters -->
        <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-4">
            <form method="GET" action="{{ route('admin.change-requests.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Status Filter -->
                <div>
                    <label for="status" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Status
                    </label>
                    <select name="status" id="status"
                        class="w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500">
                        <option value="">All Statuses</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                        <option value="applied" {{ request('status') === 'applied' ? 'selected' : '' }}>Applied</option>
                    </select>
                </div>

                <!-- Type Filter -->
                <div>
                    <label for="type" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Type
                    </label>
                    <select name="type" id="type"
                        class="w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500">
                        <option value="">All Types</option>
                        <option value="add_service" {{ request('type') === 'add_service' ? 'selected' : '' }}>Add Service</option>
                        <option value="remove_service" {{ request('type') === 'remove_service' ? 'selected' : '' }}>Remove Service</option>
                        <option value="modify_service" {{ request('type') === 'modify_service' ? 'selected' : '' }}>Modify Service</option>
                        <option value="multiple_changes" {{ request('type') === 'multiple_changes' ? 'selected' : '' }}>Multiple Changes</option>
                    </select>
                </div>

                <!-- Buttons -->
                <div class="flex items-end gap-2">
                    <button type="submit"
                        class="px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                        Apply Filters
                    </button>
                    <a href="{{ route('admin.change-requests.index') }}"
                        class="px-4 py-2 bg-zinc-200 dark:bg-zinc-700 text-zinc-700 dark:text-zinc-300 rounded-md hover:bg-zinc-300 dark:hover:bg-zinc-600 focus:outline-none focus:ring-2 focus:ring-zinc-500 focus:ring-offset-2">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Change Requests Table -->
        <div class="bg-white dark:bg-zinc-800 rounded-lg shadow overflow-hidden">
            @if($changeRequests->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                        <thead class="bg-zinc-50 dark:bg-zinc-900">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                    Request ID
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                    Order
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                    Customer
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                    Type
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                    Current Amount
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                    Proposed Amount
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                    Requested
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-zinc-800 divide-y divide-zinc-200 dark:divide-zinc-700">
                            @foreach($changeRequests as $request)
                                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-700/50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-zinc-900 dark:text-white">
                                        #{{ $request->id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('admin.orders.show', $request->order) }}" 
                                            class="text-sm text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300">
                                            {{ $request->order->uuid }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-zinc-900 dark:text-white">{{ $request->order->customer->name ?? 'N/A' }}</div>
                                        <div class="text-sm text-zinc-500 dark:text-zinc-400">{{ $request->order->customer->email ?? '' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm text-zinc-900 dark:text-white">
                                            {{ str_replace('_', ' ', ucfirst($request->type)) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-900 dark:text-white">
                                        GHS {{ number_format($request->order->total_amount, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold">
                                        <span class="{{ $request->proposed_amount > $request->order->total_amount ? 'text-red-600 dark:text-red-400' : 'text-green-600 dark:text-green-400' }}">
                                            GHS {{ number_format($request->proposed_amount, 2) }}
                                        </span>
                                        <span class="text-xs text-zinc-500 dark:text-zinc-400 ml-1">
                                            ({{ $request->proposed_amount > $request->order->total_amount ? '+' : '' }}{{ number_format($request->proposed_amount - $request->order->total_amount, 2) }})
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $statusColors = [
                                                'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
                                                'approved' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                                                'rejected' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
                                                'applied' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
                                            ];
                                        @endphp
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColors[$request->status] ?? 'bg-zinc-100 text-zinc-800 dark:bg-zinc-900/30 dark:text-zinc-400' }}">
                                            {{ ucfirst($request->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">
                                        {{ $request->created_at->format('M d, Y') }}
                                        <div class="text-xs">{{ $request->created_at->format('h:i A') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('admin.change-requests.show', $request) }}" 
                                            class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300">
                                            View Details
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-zinc-200 dark:border-zinc-700">
                    {{ $changeRequests->links() }}
                </div>
            @else
                <div class="p-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-zinc-400 dark:text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-zinc-900 dark:text-white">No change requests</h3>
                    <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                        @if(request()->hasAny(['status', 'type']))
                            No change requests found matching your filters.
                        @else
                            There are no order change requests at the moment.
                        @endif
                    </p>
                    @if(request()->hasAny(['status', 'type']))
                        <div class="mt-6">
                            <a href="{{ route('admin.change-requests.index') }}"
                                class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                Clear Filters
                            </a>
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <!-- Summary Stats -->
        @if($changeRequests->total() > 0)
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-4">
                    <div class="text-sm text-zinc-500 dark:text-zinc-400">Total Requests</div>
                    <div class="mt-1 text-2xl font-semibold text-zinc-900 dark:text-white">{{ $changeRequests->total() }}</div>
                </div>
                <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-4">
                    <div class="text-sm text-zinc-500 dark:text-zinc-400">Pending Review</div>
                    <div class="mt-1 text-2xl font-semibold text-yellow-600 dark:text-yellow-400">
                        {{ \App\Models\OrderChangeRequest::pending()->count() }}
                    </div>
                </div>
                <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-4">
                    <div class="text-sm text-zinc-500 dark:text-zinc-400">Approved</div>
                    <div class="mt-1 text-2xl font-semibold text-green-600 dark:text-green-400">
                        {{ \App\Models\OrderChangeRequest::where('status', 'approved')->count() }}
                    </div>
                </div>
                <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-4">
                    <div class="text-sm text-zinc-500 dark:text-zinc-400">Applied</div>
                    <div class="mt-1 text-2xl font-semibold text-blue-600 dark:text-blue-400">
                        {{ \App\Models\OrderChangeRequest::where('status', 'applied')->count() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-layouts.app>
