<x-layouts.app :title="__('Service Management')">
    <div class="p-6">
        <header class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Service Management</h1>
                <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">Manage your service offerings</p>
            </div>
            
            @can('create-forms')
            <a href="{{ route('admin.services.create') }}" 
                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                wire:navigate>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 me-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Create Service
            </a>
            @endcan
        </header>

        <!-- Filters -->
        <div class="bg-white dark:bg-zinc-800 shadow rounded-lg p-4 mb-6">
            <form method="GET" action="{{ route('admin.services.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="search" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Search</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Search services..."
                            class="w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500">
                    </div>
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Category</label>
                        <select name="category_id" id="category_id" class="w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="available" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Availability</label>
                        <select name="available" id="available" class="w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            <option value="">All</option>
                            <option value="1" {{ request('available') === '1' ? 'selected' : '' }}>Available</option>
                            <option value="0" {{ request('available') === '0' ? 'selected' : '' }}>Unavailable</option>
                        </select>
                    </div>
                    <div>
                        <label for="visible" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Visibility</label>
                        <select name="visible" id="visible" class="w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            <option value="">All</option>
                            <option value="1" {{ request('visible') === '1' ? 'selected' : '' }}>Visible</option>
                            <option value="0" {{ request('visible') === '0' ? 'selected' : '' }}>Hidden</option>
                        </select>
                    </div>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700">Apply Filters</button>
                    <a href="{{ route('admin.services.index') }}" class="px-4 py-2 bg-zinc-200 dark:bg-zinc-700 text-zinc-700 dark:text-zinc-300 rounded-md hover:bg-zinc-300 dark:hover:bg-zinc-600">Clear</a>
                </div>
            </form>
        </div>

        <!-- Services Table -->
        <div class="bg-white dark:bg-zinc-800 shadow rounded-lg overflow-hidden">
            @if(session('success'))
                <div class="bg-green-50 dark:bg-green-900/20 border-l-4 border-green-400 p-4 mb-4">
                    <p class="text-green-700 dark:text-green-400">{{ session('success') }}</p>
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-50 dark:bg-red-900/20 border-l-4 border-red-400 p-4 mb-4">
                    <p class="text-red-700 dark:text-red-400">{{ session('error') }}</p>
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                    <thead class="bg-zinc-50 dark:bg-zinc-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">Service</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">Categories</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">Price</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">Variants</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-zinc-800 divide-y divide-zinc-200 dark:divide-zinc-700">
                        @forelse($services as $service)
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-700/50">
                                <td class="px-6 py-4 text-sm text-zinc-900 dark:text-white">
                                    <div class="font-medium">{{ $service->title }}</div>
                                    @if($service->short_description)
                                        <div class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">{{ Str::limit($service->short_description, 60) }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">
                                    @if($service->categories->count() > 0)
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($service->categories->take(2) as $category)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-primary-100 text-primary-800 dark:bg-primary-900/30 dark:text-primary-300">
                                                    {{ $category->title }}
                                                </span>
                                            @endforeach
                                            @if($service->categories->count() > 2)
                                                <span class="text-xs text-zinc-400">+{{ $service->categories->count() - 2 }}</span>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-zinc-400">—</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-900 dark:text-white font-medium">
                                    ₦{{ number_format($service->price, 2) }}
                                    @if($service->billing_interval)
                                        <span class="text-xs text-zinc-500 dark:text-zinc-400">/ {{ $service->billing_interval }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">
                                    {{ $service->variants_count }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <div class="flex flex-col gap-1">
                                        @if($service->available)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300">Available</span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300">Unavailable</span>
                                        @endif
                                        @if($service->visible)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">Visible</span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-zinc-100 text-zinc-800 dark:bg-zinc-700 dark:text-zinc-300">Hidden</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-3">
                                    <a href="{{ route('admin.services.show', $service) }}" class="text-primary-600 hover:text-primary-900 dark:text-primary-400" wire:navigate>View</a>
                                    @can('edit-forms')
                                    <a href="{{ route('admin.services.edit', $service) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400" wire:navigate>Edit</a>
                                    @endcan
                                    @can('delete-forms')
                                    <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400">Delete</button>
                                    </form>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-zinc-500 dark:text-zinc-400">
                                    <svg class="mx-auto h-12 w-12 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                    </svg>
                                    <p class="mt-4 text-sm">No services found</p>
                                    @can('create-forms')
                                    <a href="{{ route('admin.services.create') }}" class="mt-2 inline-block text-primary-600 hover:text-primary-700" wire:navigate>Create your first service</a>
                                    @endcan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($services->hasPages())
                <div class="px-6 py-4 border-t border-zinc-200 dark:border-zinc-700">
                    {{ $services->links() }}
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>
