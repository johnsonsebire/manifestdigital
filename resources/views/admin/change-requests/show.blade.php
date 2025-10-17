<x-layouts.app :title="'Change Request #' . $changeRequest->id">
    <div class="p-6 space-y-6">
        <!-- Header -->
        <header class="flex justify-between items-center">
            <div>
                <a href="{{ route('admin.change-requests.index') }}" 
                    class="text-sm text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white mb-2 inline-flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Back to Change Requests
                </a>
                <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Change Request #{{ $changeRequest->id }}</h1>
                <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">
                    Submitted {{ $changeRequest->created_at->format('M d, Y \a\t h:i A') }}
                </p>
            </div>
            
            <!-- Status Badge -->
            <div>
                @php
                    $statusColors = [
                        'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
                        'approved' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                        'rejected' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
                        'applied' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
                    ];
                @endphp
                <span class="px-4 py-2 inline-flex text-sm leading-5 font-semibold rounded-full {{ $statusColors[$changeRequest->status] ?? 'bg-zinc-100 text-zinc-800' }}">
                    {{ ucfirst($changeRequest->status) }}
                </span>
            </div>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Change Details -->
                <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Change Details</h2>
                    
                    <!-- Type -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                            Change Type
                        </label>
                        <p class="text-sm text-zinc-900 dark:text-white">
                            {{ str_replace('_', ' ', ucfirst($changeRequest->type)) }}
                        </p>
                    </div>

                    <!-- Changes Requested -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                            Requested Changes
                        </label>
                        <div class="space-y-3">
                            @if(isset($changeRequest->new_snapshot['changes_requested']))
                                @foreach($changeRequest->new_snapshot['changes_requested'] as $change)
                                    <div class="border border-zinc-200 dark:border-zinc-700 rounded-lg p-4">
                                        <div class="flex items-start justify-between">
                                            <div class="flex-1">
                                                <div class="flex items-center gap-2 mb-2">
                                                    @php
                                                        $actionColors = [
                                                            'add' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                                                            'remove' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
                                                            'modify' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
                                                        ];
                                                    @endphp
                                                    <span class="px-2 py-1 text-xs font-semibold rounded {{ $actionColors[$change['action']] ?? 'bg-zinc-100 text-zinc-800' }}">
                                                        {{ ucfirst($change['action']) }}
                                                    </span>
                                                </div>
                                                
                                                @if($change['action'] === 'add')
                                                    <p class="text-sm text-zinc-900 dark:text-white font-medium">
                                                        {{ $change['service_name'] ?? 'Service' }}
                                                    </p>
                                                    <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">
                                                        Quantity: {{ $change['quantity'] ?? 1 }}
                                                    </p>
                                                @elseif($change['action'] === 'remove')
                                                    <p class="text-sm text-zinc-900 dark:text-white font-medium">
                                                        {{ $change['service_name'] ?? 'Service' }}
                                                    </p>
                                                @elseif($change['action'] === 'modify')
                                                    <p class="text-sm text-zinc-900 dark:text-white font-medium">
                                                        {{ $change['service_name'] ?? 'Service' }}
                                                    </p>
                                                    <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">
                                                        New Quantity: {{ $change['quantity'] ?? 'N/A' }}
                                                    </p>
                                                @endif
                                            </div>
                                            
                                            @if(isset($change['amount']))
                                                <div class="text-right">
                                                    <span class="text-sm font-semibold text-zinc-900 dark:text-white">
                                                        GHS {{ number_format($change['amount'], 2) }}
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-sm text-zinc-500 dark:text-zinc-400">No detailed changes recorded.</p>
                            @endif
                        </div>
                    </div>

                    <!-- Amount Comparison -->
                    <div class="bg-zinc-50 dark:bg-zinc-900/50 rounded-lg p-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                                    Current Amount
                                </label>
                                <p class="text-lg font-semibold text-zinc-900 dark:text-white">
                                    GHS {{ number_format($changeRequest->order->total_amount, 2) }}
                                </p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                                    Proposed Amount
                                </label>
                                <p class="text-lg font-semibold {{ $changeRequest->proposed_amount > $changeRequest->order->total_amount ? 'text-red-600 dark:text-red-400' : 'text-green-600 dark:text-green-400' }}">
                                    GHS {{ number_format($changeRequest->proposed_amount, 2) }}
                                </p>
                                <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                                    Difference: {{ $changeRequest->proposed_amount > $changeRequest->order->total_amount ? '+' : '' }}GHS {{ number_format(abs($changeRequest->proposed_amount - $changeRequest->order->total_amount), 2) }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Review Section -->
                @if($changeRequest->status !== 'pending')
                    <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                        <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Review Details</h2>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                                    Reviewed By
                                </label>
                                <p class="text-sm text-zinc-900 dark:text-white">
                                    {{ $changeRequest->reviewer->name ?? 'N/A' }}
                                </p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                                    Reviewed At
                                </label>
                                <p class="text-sm text-zinc-900 dark:text-white">
                                    {{ $changeRequest->reviewed_at?->format('M d, Y \a\t h:i A') ?? 'N/A' }}
                                </p>
                            </div>
                            
                            @if($changeRequest->review_notes)
                                <div>
                                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                                        Review Notes
                                    </label>
                                    <p class="text-sm text-zinc-900 dark:text-white whitespace-pre-wrap">{{ $changeRequest->review_notes }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Actions for Pending Requests -->
                @if($changeRequest->isPending())
                    @can('approve-change-requests')
                        <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                            <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Review Actions</h2>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <!-- Approve Form -->
                                <form method="POST" action="{{ route('admin.change-requests.approve', $changeRequest) }}" 
                                    class="space-y-4">
                                    @csrf
                                    <div>
                                        <label for="approve_notes" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                                            Approval Notes (Optional)
                                        </label>
                                        <textarea name="review_notes" id="approve_notes" rows="3"
                                            class="w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500"
                                            placeholder="Add any notes about this approval..."></textarea>
                                    </div>
                                    <button type="submit"
                                        class="w-full px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                        Approve Request
                                    </button>
                                </form>

                                <!-- Reject Form -->
                                <form method="POST" action="{{ route('admin.change-requests.reject', $changeRequest) }}" 
                                    class="space-y-4">
                                    @csrf
                                    <div>
                                        <label for="reject_notes" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                                            Rejection Reason <span class="text-red-500">*</span>
                                        </label>
                                        <textarea name="review_notes" id="reject_notes" rows="3" required
                                            class="w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-red-500 focus:ring-red-500"
                                            placeholder="Provide a reason for rejection..."></textarea>
                                    </div>
                                    <button type="submit"
                                        class="w-full px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                        Reject Request
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endcan
                @endif

                <!-- Apply Changes Button -->
                @if($changeRequest->isApproved() && $changeRequest->status !== 'applied')
                    @can('manage-orders')
                        <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                            <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Apply Changes to Order</h2>
                            <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-4">
                                This request has been approved. Click the button below to apply the changes to the order.
                            </p>
                            <form method="POST" action="{{ route('admin.change-requests.apply', $changeRequest) }}" 
                                onsubmit="return confirm('Are you sure you want to apply these changes to the order? This action cannot be undone.');">
                                @csrf
                                <button type="submit"
                                    class="w-full px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                                    Apply Changes to Order
                                </button>
                            </form>
                        </div>
                    @endcan
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Order Information -->
                <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Order Information</h2>
                    
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                                Order ID
                            </label>
                            <a href="{{ route('admin.orders.show', $changeRequest->order) }}" 
                                class="text-sm text-primary-600 hover:text-primary-900 dark:text-primary-400">
                                {{ $changeRequest->order->uuid }}
                            </a>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                                Order Status
                            </label>
                            <span class="text-sm text-zinc-900 dark:text-white">
                                {{ ucfirst($changeRequest->order->status) }}
                            </span>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                                Payment Status
                            </label>
                            <span class="text-sm text-zinc-900 dark:text-white">
                                {{ ucfirst($changeRequest->order->payment_status) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Customer Information -->
                <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Customer Information</h2>
                    
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                                Name
                            </label>
                            <p class="text-sm text-zinc-900 dark:text-white">
                                {{ $changeRequest->order->customer->name ?? 'N/A' }}
                            </p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                                Email
                            </label>
                            <p class="text-sm text-zinc-900 dark:text-white">
                                {{ $changeRequest->order->customer->email ?? 'N/A' }}
                            </p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                                Phone
                            </label>
                            <p class="text-sm text-zinc-900 dark:text-white">
                                {{ $changeRequest->order->customer->phone ?? 'N/A' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Requester Information -->
                <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Requested By</h2>
                    
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                                Name
                            </label>
                            <p class="text-sm text-zinc-900 dark:text-white">
                                {{ $changeRequest->requester->name ?? 'N/A' }}
                            </p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                                Email
                            </label>
                            <p class="text-sm text-zinc-900 dark:text-white">
                                {{ $changeRequest->requester->email ?? 'N/A' }}
                            </p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                                Submitted
                            </label>
                            <p class="text-sm text-zinc-900 dark:text-white">
                                {{ $changeRequest->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
