<x-layouts.app title="Regional Pricing Details - Admin">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Regional Pricing Details</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">View detailed information about this regional pricing configuration.</p>
            </div>
            
            <div class="flex gap-3">
                <a href="{{ route('admin.regional-pricing.edit', $regionalPricing) }}" 
                   class="px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    Edit Pricing
                </a>
                <a href="{{ route('admin.regional-pricing.index') }}" 
                   class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 dark:bg-gray-600 dark:text-white dark:hover:bg-gray-700">
                    Back to List
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg dark:bg-green-900/50 dark:border-green-800 dark:text-green-200 mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Basic Information -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Basic Information</h3>
                <dl class="space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Service</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $regionalPricing->service->title }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Service Type</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $regionalPricing->service->type ?? 'N/A' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Currency</dt>
                        <dd class="mt-1">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                {{ $regionalPricing->currency->code }} {{ $regionalPricing->currency->symbol }} - {{ $regionalPricing->currency->name }}
                            </span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Region</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $regionalPricing->region ?: 'Global' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Country Code</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $regionalPricing->country_code ?: 'Not specified' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</dt>
                        <dd class="mt-1">
                            @if($regionalPricing->is_active)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                    Active
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                    Inactive
                                </span>
                            @endif
                        </dd>
                    </div>
                </dl>
            </div>

            <!-- Pricing Information -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Pricing Details</h3>
                <dl class="space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Original Price (Service Base)</dt>
                        <dd class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">
                            ${{ number_format($regionalPricing->original_price ?? $regionalPricing->service->price, 2) }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Regional Price</dt>
                        <dd class="mt-1 text-lg font-bold text-green-600 dark:text-green-400">
                            {{ $regionalPricing->formatted_price }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Markup/Discount</dt>
                        <dd class="mt-1">
                            @if($regionalPricing->markup_percentage < 0)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                    {{ $regionalPricing->markup_percentage }}% (Discount)
                                </span>
                            @elseif($regionalPricing->markup_percentage > 0)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200">
                                    +{{ $regionalPricing->markup_percentage }}% (Markup)
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">
                                    No markup/discount
                                </span>
                            @endif
                        </dd>
                    </div>
                    @if($regionalPricing->savings > 0)
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Customer Savings</dt>
                        <dd class="mt-1">
                            <div class="text-lg font-semibold text-green-600 dark:text-green-400">
                                {{ $regionalPricing->currency->formatAmount($regionalPricing->savings) }}
                            </div>
                            <div class="text-sm text-green-500 dark:text-green-400">
                                {{ $regionalPricing->savings_percentage }}% off
                            </div>
                        </dd>
                    </div>
                    @endif
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Conversion Rate</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ number_format($regionalPricing->conversion_rate, 4) }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Additional Information -->
        <div class="mt-6 bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Additional Information</h3>
            <dl class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Created</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $regionalPricing->created_at->format('M d, Y H:i') }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Last Updated</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $regionalPricing->updated_at->format('M d, Y H:i') }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Regional Pricing ID</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">#{{ $regionalPricing->id }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Service ID</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">#{{ $regionalPricing->service_id }}</dd>
                </div>
            </dl>
        </div>

        <!-- Actions -->
        <div class="mt-6 flex justify-end space-x-3">
            <a href="{{ route('admin.regional-pricing.edit', $regionalPricing) }}" 
               class="px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                Edit This Pricing
            </a>
            <form action="{{ route('admin.regional-pricing.destroy', $regionalPricing) }}" method="POST" class="inline" 
                  onsubmit="return confirm('Are you sure you want to delete this regional pricing? This action cannot be undone.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    Delete Pricing
                </button>
            </form>
        </div>
    </div>
</x-layouts.app>