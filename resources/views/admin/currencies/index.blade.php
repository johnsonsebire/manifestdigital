<x-layouts.app title="Currencies - Admin">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Currency Management</h1>
        
        <div class="flex gap-3">
            <a href="{{ route('admin.currencies.create') }}" 
               class="px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                Add Currency
            </a>
            
            <form method="POST" action="{{ route('admin.currencies.update-rates') }}" style="display: inline;">
                @csrf
                <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Update Rates
                </button>
            </form>
        </div>
    </div>

    <div class="space-y-6">
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg dark:bg-green-900/50 dark:border-green-800 dark:text-green-200">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg dark:bg-red-900/50 dark:border-red-800 dark:text-red-200">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Code</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Symbol</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Exchange Rate</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Base Currency</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Last Updated</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($currencies as $currency)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-mono font-semibold text-gray-900 dark:text-white">{{ $currency->code }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-white">{{ $currency->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-semibold text-gray-900 dark:text-white">{{ $currency->symbol }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($currency->is_base_currency)
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Base</span>
                                @else
                                    <span class="font-mono text-gray-900 dark:text-white">{{ number_format($currency->exchange_rate_to_usd, 6) }}</span>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">per USD</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($currency->is_base_currency)
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">Base</span>
                                @else
                                    <span class="text-sm text-gray-500 dark:text-gray-400">No</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($currency->is_active)
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">Active</span>
                                @else
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">Inactive</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($currency->exchange_rate_updated_at)
                                    <span class="text-sm text-gray-900 dark:text-white">{{ $currency->exchange_rate_updated_at->format('M j, Y g:i A') }}</span>
                                @else
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Never</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.currencies.show', $currency) }}" 
                                       class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.currencies.edit', $currency) }}" 
                                       class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    @unless($currency->is_base_currency)
                                        <form method="POST" action="{{ route('admin.currencies.destroy', $currency) }}" style="display: inline;" 
                                              onsubmit="return confirm('Are you sure you want to delete this currency?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endunless
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-400 dark:text-gray-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                                    </svg>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">No currencies found</h3>
                                    <p class="mt-2 text-gray-600 dark:text-gray-400">Get started by adding your first currency.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if($currencies->hasPages())
                <div class="bg-white dark:bg-gray-800 px-6 py-3 border-t border-gray-200 dark:border-gray-700">
                    {{ $currencies->links() }}
                </div>
            @endif
        </div>

        <!-- Currency Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <div class="text-center">
                    <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $currencies->where('is_active', true)->count() }}</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Active Currencies</div>
                </div>
            </div>
            
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <div class="text-center">
                    <div class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $currencies->where('is_base_currency', true)->count() }}</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Base Currencies</div>
                </div>
            </div>
            
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <div class="text-center">
                    <div class="text-2xl font-bold text-orange-600 dark:text-orange-400">
                        {{ $currencies->whereNotNull('exchange_rate_updated_at')->where('exchange_rate_updated_at', '>', now()->subDay())->count() }}
                    </div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Updated Today</div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>