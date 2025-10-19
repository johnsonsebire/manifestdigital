<x-layouts.app :title="$category->title">
    <div class="p-6 max-w-7xl mx-auto">
        <header class="flex items-center justify-between mb-6">
            <div>
                <a href="{{ route('admin.categories.index') }}" 
                    class="text-sm text-primary-600 hover:text-primary-700 dark:text-primary-400 mb-2 inline-block"
                    wire:navigate>
                    ← Back to Categories
                </a>
                <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $category->title }}</h1>
                @if($category->parent)
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                        Parent: <a href="{{ route('admin.categories.show', $category->parent) }}" class="text-primary-600 hover:underline" wire:navigate>{{ $category->parent->title }}</a>
                    </p>
                @endif
            </div>
            
            <div class="flex gap-2">
                @can('edit-forms')
                <a href="{{ route('admin.categories.edit', $category) }}" 
                    class="px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700"
                    wire:navigate>
                    Edit Category
                </a>
                @endcan
            </div>
        </header>

        @if(session('success'))
            <div class="bg-green-50 dark:bg-green-900/20 border-l-4 border-green-400 p-4 mb-6">
                <p class="text-green-700 dark:text-green-400">{{ session('success') }}</p>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Category Details -->
                <div class="bg-white dark:bg-zinc-800 rounded-lg shadow overflow-hidden">
                    <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700">
                        <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Category Details</h2>
                    </div>
                    <div class="p-6 space-y-4">
                        @if($category->description)
                            <div>
                                <h3 class="text-sm font-medium text-zinc-500 dark:text-zinc-400 mb-1">Description</h3>
                                <p class="text-sm text-zinc-900 dark:text-white">{{ $category->description }}</p>
                            </div>
                        @endif
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <h3 class="text-sm font-medium text-zinc-500 dark:text-zinc-400 mb-1">Slug</h3>
                                <code class="text-sm bg-zinc-100 dark:bg-zinc-700 px-2 py-1 rounded">{{ $category->slug }}</code>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-zinc-500 dark:text-zinc-400 mb-1">Display Order</h3>
                                <p class="text-sm text-zinc-900 dark:text-white">{{ $category->order }}</p>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-zinc-500 dark:text-zinc-400 mb-1">Visibility</h3>
                                @if($category->visible)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300">
                                        Visible
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-zinc-100 text-zinc-800 dark:bg-zinc-700 dark:text-zinc-300">
                                        Hidden
                                    </span>
                                @endif
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-zinc-500 dark:text-zinc-400 mb-1">UUID</h3>
                                <code class="text-xs bg-zinc-100 dark:bg-zinc-700 px-2 py-1 rounded">{{ $category->uuid }}</code>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Subcategories -->
                @if($category->children->count() > 0)
                    <div class="bg-white dark:bg-zinc-800 rounded-lg shadow overflow-hidden">
                        <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700">
                            <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Subcategories ({{ $category->children->count() }})</h2>
                        </div>
                        <div class="divide-y divide-zinc-200 dark:divide-zinc-700">
                            @foreach($category->children as $child)
                                <div class="px-6 py-4 hover:bg-zinc-50 dark:hover:bg-zinc-700/50">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h3 class="font-medium text-zinc-900 dark:text-white">{{ $child->title }}</h3>
                                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                                                {{ $child->services->count() }} {{ Str::plural('service', $child->services->count()) }}
                                            </p>
                                        </div>
                                        <a href="{{ route('admin.categories.show', $child) }}" 
                                            class="text-primary-600 hover:text-primary-700 text-sm"
                                            wire:navigate>
                                            View →
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Services -->
                @if($category->services->count() > 0)
                    <div class="bg-white dark:bg-zinc-800 rounded-lg shadow overflow-hidden">
                        <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700">
                            <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Services ({{ $category->services->count() }})</h2>
                        </div>
                        <div class="divide-y divide-zinc-200 dark:divide-zinc-700">
                            @foreach($category->services as $service)
                                <div class="px-6 py-4 hover:bg-zinc-50 dark:hover:bg-zinc-700/50">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h3 class="font-medium text-zinc-900 dark:text-white">{{ $service->title }}</h3>
                                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                                                {!! $currencyService->formatAmount($service->price ?? 0, $userCurrency->code) !!}
                                                @if($service->billing_interval)
                                                    / {{ $service->billing_interval }}
                                                @endif
                                            </p>
                                        </div>
                                        <a href="{{ route('admin.services.show', $service) }}" 
                                            class="text-primary-600 hover:text-primary-700 text-sm"
                                            wire:navigate>
                                            View →
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Stats -->
                <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                    <h3 class="text-sm font-medium text-zinc-500 dark:text-zinc-400 mb-4">Statistics</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-zinc-600 dark:text-zinc-400">Total Services</span>
                            <span class="text-lg font-semibold text-zinc-900 dark:text-white">{{ $category->services->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-zinc-600 dark:text-zinc-400">Subcategories</span>
                            <span class="text-lg font-semibold text-zinc-900 dark:text-white">{{ $category->children->count() }}</span>
                        </div>
                    </div>
                </div>

                <!-- Timestamps -->
                <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                    <h3 class="text-sm font-medium text-zinc-500 dark:text-zinc-400 mb-4">Metadata</h3>
                    <div class="space-y-3 text-sm">
                        <div>
                            <span class="text-zinc-500 dark:text-zinc-400">Created</span>
                            <p class="text-zinc-900 dark:text-white mt-1">{{ $category->created_at->format('M d, Y h:i A') }}</p>
                        </div>
                        <div>
                            <span class="text-zinc-500 dark:text-zinc-400">Last Updated</span>
                            <p class="text-zinc-900 dark:text-white mt-1">{{ $category->updated_at->format('M d, Y h:i A') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
