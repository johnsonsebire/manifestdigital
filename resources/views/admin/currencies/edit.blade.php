<x-layouts.app title="Edit {{ $currency->name }} - Admin">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Currency: {{ $currency->name }}</h1>
        
        <a href="{{ route('admin.currencies.index') }}" 
           class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors">
            Back to Currencies
        </a>
    </div>

    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-6 dark:bg-red-900/50 dark:border-red-800 dark:text-red-200">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="max-w-2xl bg-white dark:bg-gray-800 shadow rounded-lg p-6">
        <form method="POST" action="{{ route('admin.currencies.update', $currency) }}">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <!-- Currency Code -->
                <div>
                    <label for="code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Currency Code *
                    </label>
                    <input type="text" 
                           id="code" 
                           name="code" 
                           value="{{ old('code', $currency->code) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white {{ $currency->is_base_currency ? 'bg-gray-100 dark:bg-gray-600' : '' }}" 
                           placeholder="USD, EUR, GBP, etc."
                           required 
                           maxlength="3"
                           style="text-transform: uppercase;"
                           {{ $currency->is_base_currency ? 'readonly' : '' }}>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">3-letter ISO currency code</p>
                    @if($currency->is_base_currency)
                        <p class="text-sm text-amber-600 dark:text-amber-400 mt-1">Base currency code cannot be changed</p>
                    @endif
                    @error('code')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Currency Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Currency Name *
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name', $currency->name) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" 
                           placeholder="US Dollar, Euro, British Pound, etc."
                           required>
                    @error('name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Currency Symbol -->
                <div>
                    <label for="symbol" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Currency Symbol *
                    </label>
                    <input type="text" 
                           id="symbol" 
                           name="symbol" 
                           value="{{ old('symbol', $currency->symbol) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" 
                           placeholder="$, €, £, ₵, etc."
                           required
                           maxlength="10">
                    @error('symbol')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Exchange Rate -->
                <div>
                    <label for="exchange_rate_to_usd" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Exchange Rate to USD
                    </label>
                    <input type="number" 
                           id="exchange_rate_to_usd" 
                           name="exchange_rate_to_usd" 
                           value="{{ old('exchange_rate_to_usd', $currency->exchange_rate_to_usd) }}" 
                           step="0.000001" 
                           min="0.000001" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white {{ $currency->is_base_currency ? 'bg-gray-100 dark:bg-gray-600' : '' }}" 
                           placeholder="1.00"
                           {{ $currency->is_base_currency ? 'readonly' : '' }}>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">How many units of this currency equal 1 USD</p>
                    @if($currency->is_base_currency)
                        <p class="text-sm text-amber-600 dark:text-amber-400 mt-1">Base currency rate is always 1.00</p>
                    @endif
                    @error('exchange_rate_to_usd')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Decimal Places -->
                <div>
                    <label for="decimal_places" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Decimal Places
                    </label>
                    <select id="decimal_places" 
                            name="decimal_places" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option value="0" {{ old('decimal_places', $currency->decimal_places) == '0' ? 'selected' : '' }}>0 (No decimals)</option>
                        <option value="1" {{ old('decimal_places', $currency->decimal_places) == '1' ? 'selected' : '' }}>1 decimal place</option>
                        <option value="2" {{ old('decimal_places', $currency->decimal_places) == '2' ? 'selected' : '' }}>2 decimal places</option>
                        <option value="3" {{ old('decimal_places', $currency->decimal_places) == '3' ? 'selected' : '' }}>3 decimal places</option>
                        <option value="4" {{ old('decimal_places', $currency->decimal_places) == '4' ? 'selected' : '' }}>4 decimal places</option>
                        <option value="5" {{ old('decimal_places', $currency->decimal_places) == '5' ? 'selected' : '' }}>5 decimal places</option>
                        <option value="6" {{ old('decimal_places', $currency->decimal_places) == '6' ? 'selected' : '' }}>6 decimal places</option>
                    </select>
                    @error('decimal_places')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Format Template -->
                <div>
                    <label for="format" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Display Format (Optional)
                    </label>
                    <input type="text" 
                           id="format" 
                           name="format" 
                           value="{{ old('format', $currency->format) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" 
                           placeholder="$&#123;&#123;amount&#125;&#125;, &#123;&#123;amount&#125;&#125; USD, &#123;&#123;symbol&#125;&#125;&#123;&#123;amount&#125;&#125;, etc.">
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Use &#123;&#123;amount&#125;&#125; for the number and &#123;&#123;symbol&#125;&#125; for the currency symbol</p>
                    @error('format')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Active Status -->
                <div>
                    <div class="flex items-center">
                        <input type="checkbox" 
                               id="is_active" 
                               name="is_active" 
                               value="1" 
                               {{ old('is_active', $currency->is_active) ? 'checked' : '' }}
                               class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600">
                        <label for="is_active" class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                            Active Currency
                        </label>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Only active currencies are available for selection</p>
                    @if($currency->is_base_currency)
                        <p class="text-sm text-amber-600 dark:text-amber-400 mt-1">Base currency must remain active</p>
                    @endif
                    @error('is_active')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Exchange Rate Info -->
                @if($currency->exchange_rate_updated_at)
                <div class="bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded-lg dark:bg-blue-900/50 dark:border-blue-800 dark:text-blue-200">
                    <div class="text-sm">
                        <strong>Last Rate Update:</strong> {{ $currency->exchange_rate_updated_at->format('M j, Y g:i A') }}
                        <br>
                        <span class="text-blue-600 dark:text-blue-400">
                            ({{ $currency->exchange_rate_updated_at->diffForHumans() }})
                        </span>
                    </div>
                </div>
                @endif

                <!-- Submit Buttons -->
                <div class="flex gap-3 pt-4">
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition-colors">
                        Update Currency
                    </button>
                    <a href="{{ route('admin.currencies.index') }}" 
                       class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg transition-colors">
                        Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>
</x-layouts.app>