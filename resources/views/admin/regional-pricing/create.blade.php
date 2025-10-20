<x-layouts.app title="Create Regional Pricing - Admin">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Create Regional Pricing</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Set up region-specific pricing for a service in a particular currency.</p>
            </div>
            
            <div>
                <a href="{{ route('admin.regional-pricing.index') }}" 
                   class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 dark:bg-gray-600 dark:text-white dark:hover:bg-gray-700">
                    Back to List
                </a>
            </div>
        </div>

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg dark:bg-red-900/50 dark:border-red-800 dark:text-red-200 mb-6">
                <h4 class="font-medium mb-2">Please correct the following errors:</h4>
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Create Form -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <form action="{{ route('admin.regional-pricing.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Service Selection -->
                    <div>
                        <label for="service_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Service <span class="text-red-500">*</span>
                        </label>
                        <select name="service_id" id="service_id" 
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white @error('service_id') border-red-500 @enderror" 
                                required>
                            <option value="">Select a service</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}" 
                                        data-price="{{ $service->price }}"
                                        {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                    {{ $service->title }} (Base: ${{ number_format($service->price, 2) }})
                                </option>
                            @endforeach
                        </select>
                        @error('service_id')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Currency Selection -->
                    <div>
                        <label for="currency_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Currency <span class="text-red-500">*</span>
                        </label>
                        <select name="currency_id" id="currency_id" 
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white @error('currency_id') border-red-500 @enderror" 
                                required>
                            <option value="">Select a currency</option>
                            @foreach($currencies as $currency)
                                <option value="{{ $currency->id }}" 
                                        data-code="{{ $currency->code }}"
                                        data-symbol="{{ $currency->symbol }}"
                                        data-rate="{{ $currency->exchange_rate_to_usd }}"
                                        {{ old('currency_id') == $currency->id ? 'selected' : '' }}>
                                    {{ $currency->code }} ({{ $currency->symbol }}) - {{ $currency->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('currency_id')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Region -->
                    <div>
                        <label for="region" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Region</label>
                        <input type="text" name="region" id="region" 
                               value="{{ old('region') }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white @error('region') border-red-500 @enderror"
                               placeholder="e.g., West Africa, Europe, Global">
                        @error('region')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Country Code -->
                    <div>
                        <label for="country_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Country Code</label>
                        <input type="text" name="country_code" id="country_code" 
                               value="{{ old('country_code') }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white @error('country_code') border-red-500 @enderror"
                               placeholder="e.g., GH, NG, US"
                               maxlength="3">
                        @error('country_code')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Pricing Configuration -->
                <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Pricing Configuration</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Custom Price -->
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Regional Price <span class="text-red-500">*</span>
                            </label>
                            <div class="flex shadow-sm rounded-md overflow-hidden border border-gray-300 dark:border-gray-600 focus-within:ring-1 focus-within:ring-primary-500 focus-within:border-primary-500 @error('price') border-red-500 @enderror">
                                <div class="flex items-center justify-center w-16 bg-gray-50 dark:bg-gray-600 border-r border-gray-200 dark:border-gray-500">
                                    <span id="currency-symbol" class="text-gray-600 dark:text-gray-300 text-sm font-medium">$</span>
                                </div>
                                <input type="number" name="price" id="price" 
                                       value="{{ old('price') }}"
                                       step="0.01" min="0"
                                       class="flex-1 px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white border-0 focus:outline-none focus:ring-0 !rounded-l-none !rounded-r-md"
                                       placeholder="0.00" required>
                            </div>
                            @error('price')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Markup Percentage -->
                        <div>
                            <label for="markup_percentage" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Markup/Discount %
                            </label>
                            <input type="number" name="markup_percentage" id="markup_percentage" 
                                   value="{{ old('markup_percentage', 0) }}"
                                   step="0.01"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white @error('markup_percentage') border-red-500 @enderror"
                                   placeholder="0.00">
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                Positive for markup, negative for discount (e.g., -20 for 20% off)
                            </p>
                            @error('markup_percentage')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Price Preview -->
                    <div id="price-preview" class="mt-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hidden">
                        <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Price Preview</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm">
                            <div>
                                <span class="text-gray-500 dark:text-gray-400">Original:</span>
                                <span id="original-price" class="font-medium">-</span>
                            </div>
                            <div>
                                <span class="text-gray-500 dark:text-gray-400">Regional:</span>
                                <span id="regional-price" class="font-medium text-green-600 dark:text-green-400">-</span>
                            </div>
                            <div>
                                <span class="text-gray-500 dark:text-gray-400">Difference:</span>
                                <span id="price-difference" class="font-medium">-</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status -->
                <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                    <div class="flex items-center">
                        <input type="checkbox" name="is_active" id="is_active" 
                               {{ old('is_active', true) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50">
                        <label for="is_active" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                            Active (Enable this regional pricing)
                        </label>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="border-t border-gray-200 dark:border-gray-700 pt-6 flex justify-end space-x-3">
                    <a href="{{ route('admin.regional-pricing.index') }}" 
                       class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 dark:bg-gray-600 dark:text-white dark:hover:bg-gray-700">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        Create Regional Pricing
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const serviceSelect = document.getElementById('service_id');
            const currencySelect = document.getElementById('currency_id');
            const priceInput = document.getElementById('price');
            const markupInput = document.getElementById('markup_percentage');
            const currencySymbol = document.getElementById('currency-symbol');
            const pricePreview = document.getElementById('price-preview');

            function updateCurrencySymbol() {
                const selectedCurrency = currencySelect.options[currencySelect.selectedIndex];
                if (selectedCurrency.value) {
                    currencySymbol.textContent = selectedCurrency.dataset.symbol || '$';
                } else {
                    currencySymbol.textContent = '$';
                }
            }

            function updatePricePreview() {
                const selectedService = serviceSelect.options[serviceSelect.selectedIndex];
                const selectedCurrency = currencySelect.options[currencySelect.selectedIndex];
                
                if (selectedService.value && selectedCurrency.value && priceInput.value) {
                    const basePrice = parseFloat(selectedService.dataset.price);
                    const regionalPrice = parseFloat(priceInput.value);
                    const exchangeRate = parseFloat(selectedCurrency.dataset.rate);
                    const currencySymbol = selectedCurrency.dataset.symbol;
                    
                    // Convert base price to selected currency
                    const convertedBasePrice = basePrice / exchangeRate;
                    const difference = regionalPrice - convertedBasePrice;
                    const percentageDiff = ((difference / convertedBasePrice) * 100).toFixed(2);
                    
                    document.getElementById('original-price').textContent = 
                        `${currencySymbol}${convertedBasePrice.toFixed(2)}`;
                    document.getElementById('regional-price').textContent = 
                        `${currencySymbol}${regionalPrice.toFixed(2)}`;
                    
                    const diffElement = document.getElementById('price-difference');
                    if (difference > 0) {
                        diffElement.textContent = `+${currencySymbol}${difference.toFixed(2)} (+${percentageDiff}%)`;
                        diffElement.className = 'font-medium text-red-600 dark:text-red-400';
                    } else if (difference < 0) {
                        diffElement.textContent = `${currencySymbol}${difference.toFixed(2)} (${percentageDiff}%)`;
                        diffElement.className = 'font-medium text-green-600 dark:text-green-400';
                    } else {
                        diffElement.textContent = 'No difference';
                        diffElement.className = 'font-medium text-gray-600 dark:text-gray-400';
                    }
                    
                    pricePreview.classList.remove('hidden');
                } else {
                    pricePreview.classList.add('hidden');
                }
            }

            currencySelect.addEventListener('change', function() {
                updateCurrencySymbol();
                updatePricePreview();
            });

            serviceSelect.addEventListener('change', updatePricePreview);
            priceInput.addEventListener('input', updatePricePreview);
            markupInput.addEventListener('input', updatePricePreview);

            // Initialize
            updateCurrencySymbol();
        });
    </script>
    @endpush
</x-layouts.app>