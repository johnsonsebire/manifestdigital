<x-layouts.frontend title="Our Services | Manifest Digital">
    {{-- Hero Section --}}
    <section class="bg-gradient-to-br from-purple-900 via-purple-800 to-indigo-900 text-white py-20">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto text-center">
                <h1 class="text-4xl md:text-5xl font-bold mb-6">
                    Our Services & Solutions
                </h1>
                <p class="text-xl text-purple-100 mb-8">
                    Discover our comprehensive range of web development, mobile apps, AI solutions, and consulting services tailored to your needs.
                </p>

                {{-- Search Bar --}}
                <form method="GET" action="{{ route('services.index') }}" class="relative max-w-2xl mx-auto">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}"
                        placeholder="Search services..." 
                        class="w-full px-6 py-4 pr-12 rounded-full text-gray-900 focus:outline-none focus:ring-4 focus:ring-purple-300"
                    >
                    <button type="submit" class="absolute right-4 top-1/2 transform -translate-y-1/2">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </section>

    {{-- Filters and Content Section --}}
    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="flex flex-col lg:flex-row gap-8">
                {{-- Sidebar Filters --}}
                <aside class="lg:w-1/4">
                    <div class="bg-white rounded-lg shadow-md p-6 sticky top-24">
                        <h3 class="text-lg font-bold mb-4">Filter Services</h3>

                        {{-- Category Filter --}}
                        <div class="mb-6">
                            <h4 class="font-semibold mb-3 text-gray-700">Categories</h4>
                            <div class="space-y-2">
                                <a href="{{ route('services.index') }}" 
                                   class="block px-3 py-2 rounded hover:bg-purple-50 {{ !request('category') ? 'bg-purple-100 text-purple-700' : 'text-gray-700' }}">
                                    All Services
                                </a>
                                @foreach($categories as $category)
                                    <a href="{{ route('services.index', ['category' => $category->slug]) }}" 
                                       class="block px-3 py-2 rounded hover:bg-purple-50 {{ request('category') == $category->slug ? 'bg-purple-100 text-purple-700' : 'text-gray-700' }}">
                                        {{ $category->title }}
                                        <span class="text-xs text-gray-500">({{ $category->services_count }})</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        {{-- Service Type Filter --}}
                        <div class="mb-6">
                            <h4 class="font-semibold mb-3 text-gray-700">Service Type</h4>
                            <form method="GET" action="{{ route('services.index') }}" id="typeFilterForm">
                                @if(request('category'))
                                    <input type="hidden" name="category" value="{{ request('category') }}">
                                @endif
                                <div class="space-y-2">
                                    @php
                                        $types = [
                                            'package' => 'Packages',
                                            'subscription' => 'Subscriptions',
                                            'custom' => 'Custom Projects',
                                            'one_time' => 'One-Time Services',
                                            'ai_enhanced' => 'AI-Enhanced',
                                            'consulting' => 'Consulting',
                                            'add_on' => 'Add-Ons',
                                        ];
                                        $selectedTypes = (array) request('type', []);
                                    @endphp
                                    @foreach($types as $value => $label)
                                        <label class="flex items-center">
                                            <input 
                                                type="checkbox" 
                                                name="type[]" 
                                                value="{{ $value }}"
                                                {{ in_array($value, $selectedTypes) ? 'checked' : '' }}
                                                onchange="document.getElementById('typeFilterForm').submit()"
                                                class="rounded text-purple-600 focus:ring-purple-500"
                                            >
                                            <span class="ml-2 text-sm text-gray-700">{{ $label }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </form>
                        </div>

                        {{-- Sort Options --}}
                        <div>
                            <h4 class="font-semibold mb-3 text-gray-700">Sort By</h4>
                            <form method="GET" action="{{ route('services.index') }}">
                                @if(request('category'))
                                    <input type="hidden" name="category" value="{{ request('category') }}">
                                @endif
                                @foreach((array) request('type', []) as $type)
                                    <input type="hidden" name="type[]" value="{{ $type }}">
                                @endforeach
                                <select name="sort" onchange="this.form.submit()" class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500">
                                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                                    <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                                </select>
                            </form>
                        </div>
                    </div>
                </aside>

                {{-- Services Grid --}}
                <div class="lg:w-3/4">
                    @if($services->isEmpty())
                        <div class="bg-white rounded-lg shadow-md p-12 text-center">
                            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="text-xl font-semibold text-gray-700 mb-2">No services found</h3>
                            <p class="text-gray-500 mb-4">Try adjusting your filters or search query.</p>
                            <a href="{{ route('services.index') }}" class="text-purple-600 hover:text-purple-700 font-semibold">
                                Clear all filters
                            </a>
                        </div>
                    @else
                        {{-- Results Count --}}
                        <div class="mb-6 flex items-center justify-between">
                            <p class="text-gray-600">
                                Showing {{ $services->firstItem() }}-{{ $services->lastItem() }} of {{ $services->total() }} services
                            </p>
                        </div>

                        {{-- Services Grid --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mb-8">
                            @foreach($services as $service)
                                <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                                    {{-- Service Image/Icon --}}
                                    <div class="h-48 bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center">
                                        @if($service->image_url)
                                            <img src="{{ $service->image_url }}" alt="{{ $service->title }}" class="w-full h-full object-cover">
                                        @else
                                            <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                            </svg>
                                        @endif
                                    </div>

                                    {{-- Service Info --}}
                                    <div class="p-6">
                                        {{-- Type Badge --}}
                                        <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-700 mb-3">
                                            {{ ucfirst(str_replace('_', ' ', $service->type)) }}
                                        </span>

                                        <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $service->title }}</h3>
                                        <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ $service->description }}</p>

                                        {{-- Categories --}}
                                        @if($service->categories->isNotEmpty())
                                            <div class="flex flex-wrap gap-2 mb-4">
                                                @foreach($service->categories->take(2) as $category)
                                                    <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">
                                                        {{ $category->title }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @endif

                                        {{-- Price --}}
                                        <div class="mb-4">
                                            @if($service->sale_price)
                                                <div class="flex items-center gap-2">
                                                    <span class="text-2xl font-bold text-purple-600">${{ number_format($service->sale_price, 2) }}</span>
                                                    <span class="text-sm text-gray-500 line-through">${{ number_format($service->base_price, 2) }}</span>
                                                </div>
                                            @else
                                                <span class="text-2xl font-bold text-gray-900">${{ number_format($service->base_price, 2) }}</span>
                                            @endif
                                        </div>

                                        {{-- CTA Button --}}
                                        <a href="{{ route('services.show', $service->slug) }}" class="block w-full text-center bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-200">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Pagination --}}
                        <div class="flex justify-center">
                            {{ $services->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</x-layouts.frontend>
