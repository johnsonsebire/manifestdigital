<x-layouts.frontend title="Our Services | Manifest Digital">
    @push('styles')
        @vite('resources/css/services.css')
    @endpush

    {{-- Hero Section --}}
    <section class="services-hero">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto text-center">
                <h1 class="text-4xl md:text-5xl font-bold mb-6">
                    Our Services & Solutions
                </h1>
                <p class="text-xl text-orange-100 mb-8">
                    Discover our comprehensive range of web development, mobile apps, AI solutions, and consulting services tailored to your needs.
                </p>

                {{-- Search Bar --}}
                <form method="GET" action="{{ route('services.index') }}" style="position: relative; max-width: 48rem; margin: 0 auto;">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}"
                        placeholder="Search services..."
                    >
                    <button type="submit">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </section>

    {{-- Filters and Content Section --}}
    <section class="services-content">
        <div class="services-layout">
            {{-- Sidebar Filters --}}
            <aside class="services-sidebar">
                <h3>Filter Services</h3>

                {{-- Category Filter --}}
                <div class="filter-section">
                    <h4>Categories</h4>
                    <div class="category-links">
                        <a href="{{ route('services.index') }}" 
                           class="category-link {{ !request('category') ? 'active' : '' }}">
                            All Services
                        </a>
                        @foreach($categories as $category)
                            <a href="{{ route('services.index', ['category' => $category->slug]) }}" 
                               class="category-link {{ request('category') == $category->slug ? 'active' : '' }}">
                                {{ $category->title }}
                                <span class="category-count">{{ $category->services_count }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                        {{-- Service Type Filter --}}
                <div class="filter-section">
                    <h4>Service Type</h4>
                    <form method="GET" action="{{ route('services.index') }}" id="typeFilterForm">
                        @if(request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        <div class="checkbox-filters">
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
                                <div class="checkbox-item">
                                    <input 
                                        type="checkbox" 
                                        name="type[]" 
                                        value="{{ $value }}"
                                        {{ in_array($value, $selectedTypes) ? 'checked' : '' }}
                                        onchange="document.getElementById('typeFilterForm').submit()"
                                        id="type_{{ $value }}"
                                    >
                                    <label for="type_{{ $value }}">{{ $label }}</label>
                                </div>
                            @endforeach
                        </div>
                    </form>
                </div>

                {{-- Sort Options --}}
                <div class="filter-section">
                    <h4>Sort By</h4>
                    <form method="GET" action="{{ route('services.index') }}">
                        @if(request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        @foreach((array) request('type', []) as $type)
                            <input type="hidden" name="type[]" value="{{ $type }}">
                        @endforeach
                        <select name="sort" onchange="this.form.submit()" class="sort-dropdown">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                            <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                        </select>
                    </form>
                </div>
            </aside>

            {{-- Services Main Content --}}
            <div class="services-main">
                @if($services->isEmpty())
                    <div class="no-services">
                        <div class="no-services-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3>No services found</h3>
                        <p>Try adjusting your filters or search query.</p>
                        <a href="{{ route('services.index') }}">
                            Clear all filters
                        </a>
                    </div>
                @else
                    {{-- Results Count --}}
                    <div class="services-header">
                        <div class="services-count">
                            Showing {{ $services->firstItem() }}-{{ $services->lastItem() }} of {{ $services->total() }} services
                        </div>
                    </div>

                    {{-- Services Grid --}}
                    <div class="services-grid">
                            @foreach($services as $service)
                            <div class="service-card">
                                {{-- Service Image/Icon --}}
                                @if($service->image_url)
                                    <img src="{{ $service->image_url }}" alt="{{ $service->title }}" class="service-image">
                                @else
                                    <div style="height: 200px; background: linear-gradient(135deg, #FF4900 0%, #FF6B35 100%); display: flex; align-items: center; justify-content: center;">
                                        <svg style="width: 64px; height: 64px; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                        </svg>
                                    </div>
                                @endif

                                {{-- Service Info --}}
                                <div class="service-content">
                                    {{-- Type Badge --}}
                                    <span class="service-category">
                                        {{ ucfirst(str_replace('_', ' ', $service->type)) }}
                                    </span>

                                    <h3 class="service-title">{{ $service->title }}</h3>
                                    <p class="service-description">{{ $service->description }}</p>

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

                                        {{-- Price and CTA --}}
                                    <div class="service-footer">
                                        <div class="service-price">
                                            @if($service->sale_price)
                                                <span class="service-price-label">Sale Price</span>
                                                ${{ number_format($service->sale_price, 2) }}
                                                <span style="font-size: 0.9rem; color: #9CA3AF; text-decoration: line-through; margin-left: 8px;">
                                                    ${{ number_format($service->base_price, 2) }}
                                                </span>
                                            @else
                                                <span class="service-price-label">Starting at</span>
                                                ${{ number_format($service->base_price, 2) }}
                                            @endif
                                        </div>

                                        <a href="{{ route('services.show', $service->slug) }}" class="service-btn">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                    </div>

                    {{-- Pagination --}}
                    <div style="display: flex; justify-content: center; margin-top: 2rem;">
                        {{ $services->links() }}
                    </div>
                @endif
            </div>
        </div>
    </section>
</x-layouts.frontend>
