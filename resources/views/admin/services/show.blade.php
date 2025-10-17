<x-layouts.app title="{{ $service->title }}">
    <div class="p-6 max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center space-x-2 text-sm text-zinc-600 dark:text-zinc-400 mb-2">
                <a href="{{ route('admin.services.index') }}" class="hover:text-primary-600" wire:navigate>Services</a>
                <span>/</span>
                <span>{{ $service->title }}</span>
            </div>
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $service->title }}</h1>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Service Details</p>
                </div>
                <div class="flex space-x-3">
                    @can('edit-forms')
                        <a href="{{ route('admin.services.edit', $service) }}" 
                            class="inline-flex items-center px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700"
                            wire:navigate>
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit Service
                        </a>
                    @endcan
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Basic Information -->
                <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Basic Information</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Title</label>
                            <p class="text-zinc-900 dark:text-white">{{ $service->title }}</p>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Slug</label>
                            <p class="text-zinc-900 dark:text-white font-mono text-sm">{{ $service->slug }}</p>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-zinc-500 dark:text-zinc-400">UUID</label>
                            <p class="text-zinc-900 dark:text-white font-mono text-sm">{{ $service->uuid }}</p>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Type</label>
                            <p class="text-zinc-900 dark:text-white">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                                    {{ ucfirst(str_replace('_', ' ', $service->type)) }}
                                </span>
                            </p>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Short Description</label>
                            <p class="text-zinc-900 dark:text-white">{{ $service->short_description ?? 'N/A' }}</p>
                        </div>

                        @if($service->long_description)
                        <div>
                            <label class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Long Description</label>
                            <p class="text-zinc-900 dark:text-white whitespace-pre-wrap">{{ $service->long_description }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Categories -->
                @if($service->categories->count() > 0)
                <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Categories</h2>
                    
                    <div class="flex flex-wrap gap-2">
                        @foreach($service->categories as $category)
                            <a href="{{ route('admin.categories.show', $category) }}" 
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-zinc-100 text-zinc-800 dark:bg-zinc-700 dark:text-zinc-200 hover:bg-zinc-200 dark:hover:bg-zinc-600"
                                wire:navigate>
                                {{ $category->title }}
                            </a>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Variants -->
                @if($service->variants->count() > 0)
                <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Service Variants</h2>
                    
                    <div class="space-y-3">
                        @foreach($service->variants as $variant)
                            <div class="border border-zinc-200 dark:border-zinc-700 rounded-lg p-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="font-medium text-zinc-900 dark:text-white">{{ $variant->name }}</h3>
                                        @if($variant->description)
                                            <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">{{ $variant->description }}</p>
                                        @endif
                                    </div>
                                    <div class="text-right">
                                        <p class="text-lg font-semibold text-zinc-900 dark:text-white">
                                            {{ $service->currency ?? 'USD' }} {{ number_format($variant->price, 2) }}
                                        </p>
                                        @if(!$variant->is_available)
                                            <span class="text-xs text-red-600 dark:text-red-400">Not Available</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Pricing Card -->
                <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Pricing</h2>
                    
                    <div class="space-y-3">
                        <div>
                            <label class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Base Price</label>
                            <p class="text-2xl font-bold text-zinc-900 dark:text-white">
                                {{ $service->currency ?? 'USD' }} {{ number_format($service->price, 2) }}
                            </p>
                        </div>

                        @if($service->billing_interval)
                        <div>
                            <label class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Billing Interval</label>
                            <p class="text-zinc-900 dark:text-white">{{ ucfirst($service->billing_interval) }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Status Card -->
                <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Status</h2>
                    
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-zinc-600 dark:text-zinc-400">Available</span>
                            @if($service->available)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300">
                                    Yes
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300">
                                    No
                                </span>
                            @endif
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-sm text-zinc-600 dark:text-zinc-400">Visible</span>
                            @if($service->visible)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300">
                                    Yes
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300">
                                    No
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Meta Information -->
                <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Information</h2>
                    
                    <div class="space-y-3 text-sm">
                        @if($service->creator)
                        <div>
                            <label class="text-zinc-500 dark:text-zinc-400">Created By</label>
                            <p class="text-zinc-900 dark:text-white">{{ $service->creator->name }}</p>
                        </div>
                        @endif

                        <div>
                            <label class="text-zinc-500 dark:text-zinc-400">Created At</label>
                            <p class="text-zinc-900 dark:text-white">{{ $service->created_at->format('M d, Y H:i') }}</p>
                        </div>

                        <div>
                            <label class="text-zinc-500 dark:text-zinc-400">Updated At</label>
                            <p class="text-zinc-900 dark:text-white">{{ $service->updated_at->format('M d, Y H:i') }}</p>
                        </div>

                        <div>
                            <label class="text-zinc-500 dark:text-zinc-400">Variants Count</label>
                            <p class="text-zinc-900 dark:text-white">{{ $service->variants->count() }}</p>
                        </div>
                    </div>
                </div>

                <!-- Actions Card -->
                @can('delete-forms')
                <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Danger Zone</h2>
                    
                    <form action="{{ route('admin.services.destroy', $service) }}" method="POST" 
                        onsubmit="return confirm('Are you sure you want to delete this service? This action cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                            class="w-full px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                            Delete Service
                        </button>
                    </form>
                </div>
                @endcan
            </div>
        </div>
    </div>
</x-layouts.app>
