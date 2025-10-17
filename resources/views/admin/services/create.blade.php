<x-layouts.app title="Create Service">
    <div class="p-6 max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center space-x-2 text-sm text-zinc-600 dark:text-zinc-400 mb-2">
                <a href="{{ route('admin.services.index') }}" class="hover:text-primary-600" wire:navigate>Services</a>
                <span>/</span>
                <span>Create New Service</span>
            </div>
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Create New Service</h1>
        </div>

        <!-- Form -->
        <form action="{{ route('admin.services.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Basic Information Card -->
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6 space-y-4">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Basic Information</h2>

                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Title <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="title" 
                        name="title"
                        value="{{ old('title') }}"
                        class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md bg-white dark:bg-zinc-900 text-zinc-900 dark:text-white focus:ring-primary-500 focus:border-primary-500 @error('title') border-red-500 @enderror"
                        required
                    >
                    @error('title')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Short Description -->
                <div>
                    <label for="short_description" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Short Description <span class="text-red-500">*</span>
                    </label>
                    <textarea 
                        id="short_description" 
                        name="short_description"
                        rows="3"
                        class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md bg-white dark:bg-zinc-900 text-zinc-900 dark:text-white focus:ring-primary-500 focus:border-primary-500 @error('short_description') border-red-500 @enderror"
                        required
                    >{{ old('short_description') }}</textarea>
                    @error('short_description')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Long Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                        Long Description
                    </label>
                    <textarea 
                        id="description" 
                        name="description"
                        rows="6"
                        class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md bg-white dark:bg-zinc-900 text-zinc-900 dark:text-white focus:ring-primary-500 focus:border-primary-500 @error('description') border-red-500 @enderror"
                    >{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Pricing & Type Card -->
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6 space-y-4">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Pricing & Type</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Type -->
                    <div>
                        <label for="type" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                            Service Type <span class="text-red-500">*</span>
                        </label>
                        <select 
                            id="type" 
                            name="type"
                            class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md bg-white dark:bg-zinc-900 text-zinc-900 dark:text-white focus:ring-primary-500 focus:border-primary-500 @error('type') border-red-500 @enderror"
                            required
                        >
                            <option value="">Select Type</option>
                            <option value="package" {{ old('type') === 'package' ? 'selected' : '' }}>Package</option>
                            <option value="subscription" {{ old('type') === 'subscription' ? 'selected' : '' }}>Subscription</option>
                            <option value="custom" {{ old('type') === 'custom' ? 'selected' : '' }}>Custom</option>
                            <option value="one_time" {{ old('type') === 'one_time' ? 'selected' : '' }}>One Time</option>
                            <option value="ai_enhanced" {{ old('type') === 'ai_enhanced' ? 'selected' : '' }}>AI Enhanced</option>
                            <option value="consulting" {{ old('type') === 'consulting' ? 'selected' : '' }}>Consulting</option>
                            <option value="add_on" {{ old('type') === 'add_on' ? 'selected' : '' }}>Add-on</option>
                        </select>
                        @error('type')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Base Price -->
                    <div>
                        <label for="base_price" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                            Base Price <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="number" 
                            id="base_price" 
                            name="base_price"
                            value="{{ old('base_price') }}"
                            step="0.01"
                            min="0"
                            class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md bg-white dark:bg-zinc-900 text-zinc-900 dark:text-white focus:ring-primary-500 focus:border-primary-500 @error('base_price') border-red-500 @enderror"
                            required
                        >
                        @error('base_price')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Sale Price (Optional) -->
                    <div>
                        <label for="sale_price" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                            Sale Price (Optional)
                        </label>
                        <input 
                            type="number" 
                            id="sale_price" 
                            name="sale_price"
                            value="{{ old('sale_price') }}"
                            step="0.01"
                            min="0"
                            class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md bg-white dark:bg-zinc-900 text-zinc-900 dark:text-white focus:ring-primary-500 focus:border-primary-500 @error('sale_price') border-red-500 @enderror"
                        >
                        @error('sale_price')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">Must be less than base price</p>
                    </div>
                </div>
            </div>

            <!-- Categories Card -->
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6 space-y-4">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Categories</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    @forelse($categories as $category)
                        <label class="flex items-center space-x-2 p-3 border border-zinc-300 dark:border-zinc-600 rounded-md hover:bg-zinc-50 dark:hover:bg-zinc-700 cursor-pointer">
                            <input 
                                type="checkbox" 
                                name="categories[]" 
                                value="{{ $category->id }}"
                                {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}
                                class="rounded border-zinc-300 text-primary-600 focus:ring-primary-500"
                            >
                            <span class="text-sm text-zinc-900 dark:text-white">{{ $category->title }}</span>
                        </label>
                    @empty
                        <p class="text-sm text-zinc-500 dark:text-zinc-400 col-span-2">No categories available. <a href="{{ route('admin.categories.create') }}" class="text-primary-600 hover:underline">Create one</a></p>
                    @endforelse
                </div>
                @error('categories')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Availability Card -->
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6 space-y-4">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Availability & Visibility</h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Available -->
                    <div>
                        <label class="flex items-center space-x-2">
                            <input 
                                type="checkbox" 
                                name="is_available" 
                                value="1"
                                {{ old('is_available', true) ? 'checked' : '' }}
                                class="rounded border-zinc-300 text-primary-600 focus:ring-primary-500"
                            >
                            <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Available for Purchase</span>
                        </label>
                        <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">Customers can order this service</p>
                    </div>

                    <!-- Visible -->
                    <div>
                        <label class="flex items-center space-x-2">
                            <input 
                                type="checkbox" 
                                name="is_visible" 
                                value="1"
                                {{ old('is_visible', true) ? 'checked' : '' }}
                                class="rounded border-zinc-300 text-primary-600 focus:ring-primary-500"
                            >
                            <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Visible in Catalog</span>
                        </label>
                        <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">Show in public service listings</p>
                    </div>

                    <!-- Featured -->
                    <div>
                        <label class="flex items-center space-x-2">
                            <input 
                                type="checkbox" 
                                name="is_featured" 
                                value="1"
                                {{ old('is_featured', false) ? 'checked' : '' }}
                                class="rounded border-zinc-300 text-primary-600 focus:ring-primary-500"
                            >
                            <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Featured Service</span>
                        </label>
                        <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">Highlight on homepage</p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end space-x-3">
                <a href="{{ route('admin.services.index') }}" 
                    class="px-4 py-2 border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 rounded-md hover:bg-zinc-50 dark:hover:bg-zinc-700"
                    wire:navigate>
                    Cancel
                </a>
                <button 
                    type="submit"
                    class="px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700 focus:ring-2 focus:ring-primary-500 focus:ring-offset-2"
                >
                    Create Service
                </button>
            </div>
        </form>
    </div>
</x-layouts.app>
