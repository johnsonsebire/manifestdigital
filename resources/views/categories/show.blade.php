<x-layouts.frontend :title="$category->title . ' Services | Manifest Digital'">
    {{-- Hero Section with Category Title --}}
    <section class="bg-gradient-to-br from-purple-900 via-purple-800 to-indigo-900 text-white py-16">
        <div class="container mx-auto px-4">
            {{-- Breadcrumbs --}}
            <nav class="mb-6">
                <ol class="flex items-center flex-wrap space-x-2 text-sm text-purple-200">
                    <li><a href="{{ route('home') }}" class="hover:text-white">Home</a></li>
                    <li>/</li>
                    <li><a href="{{ route('categories.index') }}" class="hover:text-white">Categories</a></li>
                    @foreach($breadcrumbs as $breadcrumb)
                        <li>/</li>
                        <li>
                            @if($loop->last)
                                <span class="text-white font-semibold">{{ $breadcrumb['title'] }}</span>
                            @else
                                <a href="{{ $breadcrumb['url'] }}" class="hover:text-white">{{ $breadcrumb['title'] }}</a>
                            @endif
                        </li>
                    @endforeach
                </ol>
            </nav>

            <div class="max-w-4xl">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">{{ $category->title }}</h1>
                @if($category->description)
                    <p class="text-xl text-purple-100 mb-6">{{ $category->description }}</p>
                @endif

                {{-- Sub-categories Navigation --}}
                @if($subCategories->isNotEmpty())
                    <div class="flex flex-wrap gap-3">
                        @foreach($subCategories as $subCategory)
                            <a href="{{ route('categories.show', $subCategory->slug) }}" class="bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white px-4 py-2 rounded-lg transition-colors duration-200">
                                {{ $subCategory->title }}
                                <span class="text-purple-200 text-sm">({{ $subCategory->services_count }})</span>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </section>

    {{-- Services in Category --}}
    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4">
            @if($services->isEmpty())
                {{-- Empty State --}}
                <div class="bg-white rounded-lg shadow-md p-12 text-center max-w-2xl mx-auto">
                    <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">No services in this category yet</h3>
                    <p class="text-gray-500 mb-6">We're constantly adding new services. Check back soon or explore other categories.</p>
                    <div class="flex gap-4 justify-center">
                        <a href="{{ route('categories.index') }}" class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors">
                            Browse All Categories
                        </a>
                        <a href="{{ route('services.index') }}" class="border-2 border-purple-600 text-purple-600 hover:bg-purple-50 font-semibold py-3 px-6 rounded-lg transition-colors">
                            View All Services
                        </a>
                    </div>
                </div>
            @else
                {{-- Results Header --}}
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-2xl font-bold text-gray-900">
                        {{ $services->total() }} {{ Str::plural('Service', $services->total()) }} Found
                    </h2>
                    <a href="{{ route('services.index') }}" class="text-purple-600 hover:text-purple-700 font-semibold">
                        View All Services →
                    </a>
                </div>

                {{-- Services Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
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

                                {{-- Categories (if service belongs to multiple) --}}
                                @if($service->categories->count() > 1)
                                    <div class="flex flex-wrap gap-2 mb-4">
                                        @foreach($service->categories->where('id', '!=', $category->id)->take(2) as $otherCategory)
                                            <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">
                                                {{ $otherCategory->title }}
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
    </section>

    {{-- Sub-categories Section (if has children) --}}
    @if($subCategories->isNotEmpty())
        <section class="py-12 bg-white">
            <div class="container mx-auto px-4">
                <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Explore Sub-Categories</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($subCategories as $subCategory)
                        <a href="{{ route('categories.show', $subCategory->slug) }}" class="group bg-gray-50 hover:bg-purple-50 rounded-lg p-6 transition-colors duration-200">
                            <h3 class="text-lg font-bold text-gray-900 group-hover:text-purple-600 mb-2">
                                {{ $subCategory->title }}
                            </h3>
                            <p class="text-sm text-gray-600 mb-3">
                                {{ $subCategory->services_count }} {{ Str::plural('service', $subCategory->services_count) }}
                            </p>
                            <span class="text-purple-600 font-semibold text-sm group-hover:underline">
                                Browse →
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</x-layouts.frontend>
