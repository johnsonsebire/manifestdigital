@props([
    'title' => 'Transparent Pricing, Exceptional Value',
    'subtitle' => 'Choose the perfect plan for your organization. Scale up or down anytime—no contracts, no surprises.',
    'decorativeImages' => [
        'leftStripes' => 'images/decorative/mem_dots_f_tri.svg',
        'rightShape' => 'images/decorative/cta_left_mem_dots_f_circle2.svg'
    ],
    'animateOnScroll' => true
])

<div class="relative bg-white py-24" x-data="pricingComponent()" x-init="loadPricing()">
    <!-- Decorative Background Elements -->
    @if(!empty($decorativeImages['leftStripes']))
    <div class="absolute left-0 top-0 -translate-x-1/2 -translate-y-1/4 opacity-20">
        <img src="{{ asset($decorativeImages['leftStripes']) }}" alt="Decorative stripes" class="w-32 h-32">
    </div>
    @endif
    
    @if(!empty($decorativeImages['rightShape']))
    <div class="absolute right-0 bottom-0 translate-x-1/3 translate-y-1/4 opacity-20">
        <img src="{{ asset($decorativeImages['rightShape']) }}" alt="Decorative shape" class="w-40 h-40">
    </div>
    @endif

    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <!-- Header -->
        <div class="mx-auto max-w-4xl text-center {{ $animateOnScroll ? 'animate-on-scroll' : '' }}">
            <h2 class="text-base font-semibold leading-7 text-indigo-600">Pricing</h2>
            <h3 class="mt-2 text-4xl font-bold tracking-tight text-gray-900 sm:text-5xl">
                {{ $title }}
            </h3>
            <p class="mt-6 text-lg leading-8 text-gray-600">
                {{ $subtitle }}
            </p>
        </div>

        <!-- Currency Selector & Loading -->
        <div class="mx-auto max-w-2xl text-center mt-12">
            <!-- Loading State -->
            <div x-show="loading" class="text-center py-12">
                <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-indigo-600"></div>
                <p class="mt-2 text-gray-600">Loading pricing...</p>
            </div>

            <!-- Currency Selector -->
            <div x-show="!loading && currencyData" class="mb-8">
                <div class="flex items-center justify-center space-x-4">
                    <span class="text-sm text-gray-600">Viewing prices in:</span>
                    <div class="relative inline-block">
                        <select x-model="selectedCurrency" @change="switchCurrency()" 
                                class="appearance-none bg-white border border-gray-300 rounded-md px-4 py-2 pr-8 text-sm font-medium text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <template x-for="currency in availableCurrencies" :key="currency.code">
                                <option :value="currency.code" x-text="`${currency.name} (${currency.symbol})`"></option>
                            </template>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                    <div x-show="hasRegionalPricing" class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full">
                        Regional Pricing Available
                    </div>
                </div>
            </div>
        </div>

        <!-- Pricing Categories Tabs -->
        <div x-show="!loading && pricingCategories" class="mt-12">
            <!-- Tab Navigation -->
            <div class="flex justify-center mb-12">
                <nav class="flex space-x-8 bg-gray-100 rounded-lg p-1" aria-label="Pricing categories">
                    <template x-for="(category, key) in pricingCategories" :key="key">
                        <button @click="activeCategory = key"
                                class="px-4 py-2 text-sm font-medium rounded-md transition-colors duration-200"
                                :class="activeCategory === key ? 'bg-white text-indigo-600 shadow-sm' : 'text-gray-500 hover:text-gray-700'"
                                x-text="category.title">
                        </button>
                    </template>
                </nav>
            </div>

            <!-- Pricing Plans -->
            <template x-for="(category, key) in pricingCategories" :key="key">
                <div x-show="activeCategory === key" class="grid grid-cols-1 gap-8 lg:grid-cols-3">
                    <template x-for="plan in category.plans" :key="plan.name">
                        <div class="relative rounded-3xl p-8 ring-1 ring-gray-200 transition-all duration-300 hover:shadow-lg"
                             :class="plan.hasAccent ? 'ring-2 ring-indigo-600' : 'hover:ring-gray-300'">
                            
                            <!-- Popular Badge -->
                            <div x-show="plan.isPopular" 
                                 class="absolute -top-4 left-1/2 -translate-x-1/2">
                                <span class="inline-flex items-center rounded-full bg-indigo-600 px-4 py-1 text-xs font-medium text-white">
                                    Most Popular
                                </span>
                            </div>

                            <!-- Plan Header -->
                            <div class="text-center">
                                <h3 class="text-lg font-semibold leading-8 text-gray-900" x-text="plan.name"></h3>
                                <p class="mt-4 text-sm leading-6 text-gray-600" x-text="plan.tagline"></p>
                                
                                <!-- Price -->
                                <div class="mt-6">
                                    <div class="flex items-baseline justify-center">
                                        <span class="text-4xl font-bold tracking-tight text-gray-900" 
                                              x-text="plan.price.currency + plan.price.amount"></span>
                                        <span class="text-sm font-semibold leading-6 text-gray-600" 
                                              x-text="plan.price.period"></span>
                                    </div>
                                    <div x-show="plan.price.is_regional && plan.price.savings > 0" 
                                         class="mt-2 text-sm text-green-600">
                                        <span x-text="`Save ${plan.price.savings} with regional pricing`"></span>
                                    </div>
                                </div>

                                <!-- CTA Button -->
                                <a :href="plan.ctaUrl" 
                                   class="mt-8 block w-full rounded-md px-3 py-2 text-center text-sm font-semibold transition-colors duration-200"
                                   :class="plan.hasAccent || plan.isPopular ? 
                                          'bg-indigo-600 text-white hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600' : 
                                          'bg-white text-indigo-600 ring-1 ring-inset ring-indigo-200 hover:ring-indigo-300'"
                                   x-text="plan.ctaText">
                                </a>

                                <!-- Cancel Text -->
                                <p class="mt-3 text-xs leading-5 text-gray-500" x-text="plan.cancelText"></p>
                            </div>

                            <!-- Features List -->
                            <ul class="mt-8 space-y-3">
                                <template x-for="feature in plan.features" :key="feature">
                                    <li class="flex">
                                        <svg class="h-6 w-5 flex-none text-indigo-600" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                                        </svg>
                                        <span class="ml-3 text-sm leading-6 text-gray-600" x-text="feature"></span>
                                    </li>
                                </template>
                            </ul>
                        </div>
                    </template>
                </div>
            </template>
        </div>

        <!-- Error State -->
        <div x-show="error" class="text-center py-12">
            <div class="text-red-600 mb-4">
                <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <p class="text-gray-600" x-text="error"></p>
            <button @click="loadPricing()" class="mt-4 text-indigo-600 hover:text-indigo-500">
                Try Again
            </button>
        </div>
    </div>
</div>

<script>
function pricingComponent() {
    return {
        loading: true,
        error: null,
        pricingCategories: {},
        currencyData: null,
        hasRegionalPricing: false,
        availableCurrencies: [
            { code: 'USD', name: 'US Dollar', symbol: '$' },
            { code: 'GHS', name: 'Ghana Cedi', symbol: 'GH₵' }
        ],
        selectedCurrency: 'GHS', // Default to GHS
        activeCategory: 'websites', // Default active tab
        
        async loadPricing() {
            this.loading = true;
            this.error = null;
            
            try {
                const response = await fetch('/api/pricing');
                if (!response.ok) {
                    throw new Error('Failed to load pricing data');
                }
                
                const data = await response.json();
                this.pricingCategories = data.categories;
                this.currencyData = data.currency;
                this.hasRegionalPricing = data.hasRegionalPricing;
                this.selectedCurrency = data.currency.code;
                
                // Set first available category as active if current one doesn't exist
                if (!this.pricingCategories[this.activeCategory]) {
                    this.activeCategory = Object.keys(this.pricingCategories)[0];
                }
                
            } catch (error) {
                console.error('Error loading pricing:', error);
                this.error = 'Failed to load pricing. Please try again.';
            } finally {
                this.loading = false;
            }
        },
        
        async switchCurrency() {
            if (this.selectedCurrency === this.currencyData?.code) {
                return;
            }
            
            try {
                // Switch currency in session
                const response = await fetch('/api/currency/switch', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        currency: this.selectedCurrency
                    })
                });
                
                if (response.ok) {
                    // Reload pricing with new currency
                    await this.loadPricing();
                }
            } catch (error) {
                console.error('Error switching currency:', error);
                // Revert selection
                this.selectedCurrency = this.currencyData?.code || 'USD';
            }
        }
    }
}
</script>