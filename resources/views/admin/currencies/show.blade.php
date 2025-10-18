<x-layouts.app title="{{ $currency->name }} - Admin">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $currency->name }} ({{ $currency->code }})</h1>
        
        <div class="flex gap-3">
            <a href="{{ route('admin.currencies.edit', $currency) }}" 
               class="px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                Edit Currency
            </a>
            <a href="{{ route('admin.currencies.index') }}" 
               class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                Back to Currencies
            </a>
        </div>
    </div>

    <div class="space-y-6">
        <!-- Currency Details -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Currency Information</h2>
                
                <div class="space-y-4">
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Code:</span>
                        <span class="font-mono font-semibold text-gray-900 dark:text-white">{{ $currency->code }}</span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Name:</span>
                        <span class="font-semibold text-gray-900 dark:text-white">{{ $currency->name }}</span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Symbol:</span>
                        <span class="font-semibold text-lg text-gray-900 dark:text-white">{{ $currency->symbol }}</span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Decimal Places:</span>
                        <span class="text-gray-900 dark:text-white">{{ $currency->decimal_places }}</span>
                    </div>
                    
                    @if($currency->format)
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Format:</span>
                        <span class="font-mono text-sm text-gray-900 dark:text-white">{{ $currency->format }}</span>
                    </div>
                    @endif
                    
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Status:</span>
                        @if($currency->is_active)
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">Active</span>
                        @else
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">Inactive</span>
                        @endif
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Base Currency:</span>
                        @if($currency->is_base_currency)
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">Yes</span>
                        @else
                            <span class="text-gray-900 dark:text-white">No</span>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Exchange Rate Information</h2>
                
                <div class="space-y-4">
                    @if($currency->is_base_currency)
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 text-green-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                            </svg>
                            <p class="text-lg font-semibold text-green-600 dark:text-green-400">Base Currency</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">All other currencies are calculated relative to this one</p>
                        </div>
                    @else
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Rate to USD:</span>
                            <span class="font-mono font-semibold text-gray-900 dark:text-white">{{ number_format($currency->exchange_rate_to_usd, 6) }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Last Updated:</span>
                            @if($currency->exchange_rate_updated_at)
                                <div class="text-right">
                                    <div class="font-semibold text-gray-900 dark:text-white">{{ $currency->exchange_rate_updated_at->format('M j, Y') }}</div>
                                    <div class="text-sm text-gray-600 dark:text-gray-400">{{ $currency->exchange_rate_updated_at->format('g:i A') }}</div>
                                    <div class="text-xs text-gray-500">{{ $currency->exchange_rate_updated_at->diffForHumans() }}</div>
                                </div>
                            @else
                                <span class="text-gray-500">Never</span>
                            @endif
                        </div>
                        
                        <!-- Rate Update Warning -->
                        @if($currency->needsRateUpdate())
                            <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 px-4 py-3 rounded-lg dark:bg-yellow-900/50 dark:border-yellow-800 dark:text-yellow-200">
                                <strong>Rate Update Needed:</strong> This currency's exchange rate is older than 24 hours.
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>

        <!-- Sample Formatting -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Sample Formatting</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <div class="text-sm text-gray-600 dark:text-gray-400">$100 USD</div>
                    <div class="text-lg font-semibold text-gray-900 dark:text-white">{{ $currency->formatAmount(100 * ($currency->is_base_currency ? 1 : $currency->exchange_rate_to_usd)) }}</div>
                </div>
                <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <div class="text-sm text-gray-600 dark:text-gray-400">$250 USD</div>
                    <div class="text-lg font-semibold text-gray-900 dark:text-white">{{ $currency->formatAmount(250 * ($currency->is_base_currency ? 1 : $currency->exchange_rate_to_usd)) }}</div>
                </div>
                <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <div class="text-sm text-gray-600 dark:text-gray-400">$1,000 USD</div>
                    <div class="text-lg font-semibold text-gray-900 dark:text-white">{{ $currency->formatAmount(1000 * ($currency->is_base_currency ? 1 : $currency->exchange_rate_to_usd)) }}</div>
                </div>
            </div>
        </div>

        <!-- Countries Using This Currency -->
        @if($currency->countries->isNotEmpty())
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Countries Using {{ $currency->code }}</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($currency->countries as $country)
                    <div class="flex items-center space-x-3 p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <div class="font-mono text-sm bg-gray-200 dark:bg-gray-600 px-2 py-1 rounded">{{ $country->code }}</div>
                        <div>
                            <div class="font-semibold text-gray-900 dark:text-white">{{ $country->name }}</div>
                            @if($country->region)
                                <div class="text-sm text-gray-600 dark:text-gray-400">{{ $country->region }}</div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Regional Pricing -->
        @if($currency->regionalPricing->isNotEmpty())
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Regional Pricing Using {{ $currency->code }}</h2>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Service</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Country/Region</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Price</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Original Price</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Markup</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($currency->regionalPricing as $pricing)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-white">{{ $pricing->service->title ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-white">
                                    @if($pricing->country_code)
                                        {{ $pricing->country->name ?? $pricing->country_code }}
                                    @elseif($pricing->region)
                                        {{ $pricing->region }}
                                    @else
                                        Global
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-white">{{ $pricing->formatted_price }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-white">{{ $currency->formatAmount($pricing->original_price) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($pricing->markup_percentage > 0)
                                        <span class="text-red-600 dark:text-red-400">+{{ $pricing->markup_percentage }}%</span>
                                    @elseif($pricing->markup_percentage < 0)
                                        <span class="text-green-600 dark:text-green-400">{{ $pricing->markup_percentage }}%</span>
                                    @else
                                        <span class="text-gray-500">0%</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</x-layouts.app>