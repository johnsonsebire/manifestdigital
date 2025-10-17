<x-layouts.app :title="'Edit Category: ' . $category->title">
    <div class="p-6 max-w-4xl mx-auto">
        <header class="mb-6">
            <a href="{{ route('admin.categories.index') }}" 
                class="text-sm text-primary-600 hover:text-primary-700 dark:text-primary-400 mb-2 inline-block"
                wire:navigate>
                ← Back to Categories
            </a>
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Edit Category</h1>
            <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">Update category information</p>
        </header>

        <div class="bg-white dark:bg-zinc-800 shadow rounded-lg">
            <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                        Title <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                        name="title" 
                        id="title" 
                        value="{{ old('title', $category->title) }}"
                        required
                        class="w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('title') border-red-500 @enderror">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Slug -->
                <div>
                    <label for="slug" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                        Slug <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                        name="slug" 
                        id="slug" 
                        value="{{ old('slug', $category->slug) }}"
                        required
                        class="w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('slug') border-red-500 @enderror">
                    @error('slug')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Parent Category -->
                <div>
                    <label for="parent_id" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                        Parent Category
                    </label>
                    <select name="parent_id" 
                        id="parent_id"
                        class="w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('parent_id') border-red-500 @enderror">
                        <option value="">None (Top Level Category)</option>
                        @foreach($parentCategories as $parent)
                            <option value="{{ $parent->id }}" {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>
                                {{ $parent->title }}
                            </option>
                        @endforeach
                    </select>
                    <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Select a parent to create a subcategory</p>
                    @error('parent_id')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                        Description
                    </label>
                    <textarea name="description" 
                        id="description" 
                        rows="4"
                        class="w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('description') border-red-500 @enderror">{{ old('description', $category->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Order -->
                <div>
                    <label for="order" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                        Display Order
                    </label>
                    <input type="number" 
                        name="order" 
                        id="order" 
                        value="{{ old('order', $category->order) }}"
                        min="0"
                        class="w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('order') border-red-500 @enderror">
                    <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Lower numbers appear first</p>
                    @error('order')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Visible -->
                <div class="flex items-center">
                    <input type="checkbox" 
                        name="visible" 
                        id="visible" 
                        value="1"
                        {{ old('visible', $category->visible) ? 'checked' : '' }}
                        class="h-4 w-4 rounded border-zinc-300 text-primary-600 focus:ring-primary-500">
                    <label for="visible" class="ml-2 block text-sm text-zinc-700 dark:text-zinc-300">
                        Make this category visible to customers
                    </label>
                </div>

                <!-- Actions -->
                <div class="flex gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-700">
                    <button type="submit" 
                        class="px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        Update Category
                    </button>
                    <a href="{{ route('admin.categories.index') }}" 
                        class="px-4 py-2 bg-zinc-200 dark:bg-zinc-700 text-zinc-700 dark:text-zinc-300 rounded-md hover:bg-zinc-300 dark:hover:bg-zinc-600"
                        wire:navigate>
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
