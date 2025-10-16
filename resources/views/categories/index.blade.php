<x-layouts.frontend title="Service Categories | Manifest Digital">
    {{-- Hero Section --}}
    <section class="bg-gradient-to-br from-purple-900 via-purple-800 to-indigo-900 text-white py-20">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto text-center">
                <h1 class="text-4xl md:text-5xl font-bold mb-6">
                    Service Categories
                </h1>
                <p class="text-xl text-purple-100">
                    Browse our services by category to find exactly what you need for your project.
                </p>
            </div>
        </div>
    </section>

    {{-- Categories Grid --}}
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($categories as $category)
                    <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                        {{-- Category Header --}}
                        <div class="bg-gradient-to-br from-purple-500 to-indigo-600 p-8 text-white">
                            <h2 class="text-2xl font-bold mb-2">{{ $category->title }}</h2>
                            @if($category->description)
                                <p class="text-purple-100 text-sm">{{ $category->description }}</p>
                            @endif
                        </div>

                        {{-- Category Body --}}
                        <div class="p-6">
                            {{-- Service Count --}}
                            <div class="flex items-center gap-2 text-gray-600 mb-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                                <span class="font-semibold">{{ $category->services_count }} {{ Str::plural('service', $category->services_count) }}</span>
                            </div>

                            {{-- Sub-categories --}}
                            @if($category->children->isNotEmpty())
                                <div class="mb-4">
                                    <h3 class="text-sm font-semibold text-gray-700 mb-2">Sub-categories:</h3>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($category->children->take(5) as $child)
                                            <a href="{{ route('categories.show', $child->slug) }}" class="text-xs bg-gray-100 hover:bg-purple-100 text-gray-700 hover:text-purple-700 px-3 py-1 rounded-full transition-colors">
                                                {{ $child->title }}
                                            </a>
                                        @endforeach
                                        @if($category->children->count() > 5)
                                            <span class="text-xs text-gray-500 px-3 py-1">
                                                +{{ $category->children->count() - 5 }} more
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            {{-- View Category Button --}}
                            <a href="{{ route('categories.show', $category->slug) }}" class="block w-full text-center bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-200">
                                Browse Services
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($categories->isEmpty())
                <div class="bg-white rounded-lg shadow-md p-12 text-center">
                    <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">No categories available</h3>
                    <p class="text-gray-500">Check back soon for our service offerings.</p>
                </div>
            @endif
        </div>
    </section>
</x-layouts.frontend>
