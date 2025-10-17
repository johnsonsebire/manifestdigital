<x-layouts.app title="Notifications">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-zinc-900 dark:text-white">Notifications</h1>
                <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">Stay updated on your orders, projects, and messages</p>
            </div>
            
            @if(auth()->user()->unreadNotifications()->count() > 0)
                <form action="{{ route('notifications.mark-all-read') }}" method="POST">
                    @csrf
                    <flux:button type="submit" variant="ghost">Mark all as read</flux:button>
                </form>
            @endif
        </div>

        <!-- Notifications List -->
        <div class="bg-white dark:bg-zinc-800 rounded-lg shadow">
            @forelse($notifications as $notification)
                <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700 last:border-0 {{ $notification->read_at ? 'opacity-60' : '' }}">
                    <div class="flex items-start gap-4">
                        <!-- Icon -->
                        <div class="flex-shrink-0 mt-1">
                            @if(isset($notification->data['invoice_id']))
                                <div class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-full">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                            @elseif(isset($notification->data['project_id']))
                                <div class="p-2 bg-green-100 dark:bg-green-900/30 rounded-full">
                                    <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                            @elseif(isset($notification->data['order_id']))
                                <div class="p-2 bg-amber-100 dark:bg-amber-900/30 rounded-full">
                                    <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                    </svg>
                                </div>
                            @else
                                <div class="p-2 bg-zinc-100 dark:bg-zinc-700 rounded-full">
                                    <svg class="w-5 h-5 text-zinc-600 dark:text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Content -->
                        <div class="flex-1 min-w-0">
                            <p class="text-sm {{ $notification->read_at ? 'text-zinc-600 dark:text-zinc-400' : 'text-zinc-900 dark:text-white font-medium' }}">
                                {{ $notification->data['message'] ?? 'New notification' }}
                            </p>
                            
                            <!-- Additional details -->
                            @if(isset($notification->data['invoice_number']))
                                <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">
                                    Invoice: {{ $notification->data['invoice_number'] }}
                                </p>
                            @endif
                            
                            @if(isset($notification->data['order_id']))
                                <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">
                                    Order #{{ $notification->data['order_id'] }}
                                </p>
                            @endif
                            
                            @if(isset($notification->data['project_title']))
                                <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">
                                    Project: {{ $notification->data['project_title'] }}
                                </p>
                            @endif
                            
                            <p class="mt-2 text-xs text-zinc-500 dark:text-zinc-400">
                                {{ $notification->created_at->diffForHumans() }}
                                @if($notification->read_at)
                                    <span class="mx-1">•</span>
                                    <span>Read</span>
                                @endif
                            </p>
                        </div>

                        <!-- Actions -->
                        <div class="flex-shrink-0 flex items-center gap-2">
                            @if(!$notification->read_at)
                                <form action="{{ route('notifications.mark-read', $notification) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300" title="Mark as read">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </button>
                                </form>
                            @endif
                            
                            <form action="{{ route('notifications.destroy', $notification) }}" method="POST" onsubmit="return confirm('Delete this notification?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300" title="Delete">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="px-6 py-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-zinc-900 dark:text-white">No notifications</h3>
                    <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                        You're all caught up!
                    </p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($notifications->hasPages())
            <div class="mt-6">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>
</x-layouts.app>
