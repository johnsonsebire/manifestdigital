<x-layouts.app title="Create New Project">
    <div class="p-6 max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <a href="{{ route('admin.projects.index') }}" 
                class="text-sm text-primary-600 hover:text-primary-700 dark:text-primary-400 mb-2 inline-block"
                wire:navigate>
                ← Back to Projects
            </a>
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Create New Project</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Initialize a new project from an order</p>
        </div>

        <!-- Create Form -->
        <div class="bg-white dark:bg-zinc-800 rounded-lg shadow">
            <form method="POST" action="{{ route('admin.projects.store') }}">
                @csrf

                <div class="p-6 space-y-6">
                    <!-- Order Selection -->
                    <div>
                        <label for="order_id" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                            Select Order <span class="text-red-500">*</span>
                        </label>
                        <select 
                            id="order_id" 
                            name="order_id"
                            required
                            class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md bg-white dark:bg-zinc-900 text-zinc-900 dark:text-white focus:ring-primary-500 focus:border-primary-500 @error('order_id') border-red-500 @enderror"
                        >
                            <option value="">Choose an order...</option>
                            @forelse($orders as $order)
                                <option value="{{ $order->id }}" {{ old('order_id') == $order->id ? 'selected' : '' }}>
                                    #{{ $order->order_number }} - {{ $order->getCustomerDisplayName() }} ({{ $order->items->count() }} items, {!! $currencyService->formatAmount($order->total ?? 0, $userCurrency->code) !!})
                                </option>
                            @empty
                                <option value="" disabled>No orders available (all orders have projects or are cancelled)</option>
                            @endforelse
                        </select>
                        @error('order_id')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                            Only orders without existing projects are shown
                        </p>
                    </div>

                    <!-- Project Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                            Project Title <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="title" 
                            name="title" 
                            value="{{ old('title') }}"
                            required
                            placeholder="e.g., Website Development for ABC Corp"
                            class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md bg-white dark:bg-zinc-900 text-zinc-900 dark:text-white focus:ring-primary-500 focus:border-primary-500 @error('title') border-red-500 @enderror"
                        >
                        @error('title')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Project Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                            Description
                        </label>
                        <textarea 
                            id="description" 
                            name="description" 
                            rows="4"
                            placeholder="Detailed project description, scope, and deliverables..."
                            class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md bg-white dark:bg-zinc-900 text-zinc-900 dark:text-white focus:ring-primary-500 focus:border-primary-500 @error('description') border-red-500 @enderror"
                        >{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Date Range -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Start Date -->
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                                Start Date
                            </label>
                            <input 
                                type="date" 
                                id="start_date" 
                                name="start_date" 
                                value="{{ old('start_date') }}"
                                class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md bg-white dark:bg-zinc-900 text-zinc-900 dark:text-white focus:ring-primary-500 focus:border-primary-500 @error('start_date') border-red-500 @enderror"
                            >
                            @error('start_date')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- End Date -->
                        <div>
                            <label for="end_date" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                                End Date
                            </label>
                            <input 
                                type="date" 
                                id="end_date" 
                                name="end_date" 
                                value="{{ old('end_date') }}"
                                class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md bg-white dark:bg-zinc-900 text-zinc-900 dark:text-white focus:ring-primary-500 focus:border-primary-500 @error('end_date') border-red-500 @enderror"
                            >
                            @error('end_date')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Budget and Status -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Budget -->
                        <div>
                            <label for="budget" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                                Budget (₦)
                            </label>
                            <input 
                                type="number" 
                                id="budget" 
                                name="budget" 
                                value="{{ old('budget') }}"
                                min="0"
                                step="0.01"
                                placeholder="0.00"
                                class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md bg-white dark:bg-zinc-900 text-zinc-900 dark:text-white focus:ring-primary-500 focus:border-primary-500 @error('budget') border-red-500 @enderror"
                            >
                            @error('budget')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Initial Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                                Initial Status <span class="text-red-500">*</span>
                            </label>
                            <select 
                                id="status" 
                                name="status"
                                required
                                class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md bg-white dark:bg-zinc-900 text-zinc-900 dark:text-white focus:ring-primary-500 focus:border-primary-500 @error('status') border-red-500 @enderror"
                            >
                                <option value="planning" {{ old('status', 'planning') === 'planning' ? 'selected' : '' }}>Planning</option>
                                <option value="in_progress" {{ old('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="on_hold" {{ old('status') === 'on_hold' ? 'selected' : '' }}>On Hold</option>
                                <option value="complete" {{ old('status') === 'complete' ? 'selected' : '' }}>Complete</option>
                                <option value="archived" {{ old('status') === 'archived' ? 'selected' : '' }}>Archived</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="px-6 py-4 bg-zinc-50 dark:bg-zinc-900 border-t border-zinc-200 dark:border-zinc-700 flex items-center justify-between rounded-b-lg">
                    <a href="{{ route('admin.projects.index') }}" 
                        class="text-sm text-zinc-600 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-white"
                        wire:navigate>
                        Cancel
                    </a>
                    <button 
                        type="submit"
                        class="inline-flex items-center px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                    >
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Create Project
                    </button>
                </div>
            </form>
        </div>

        <!-- Help Text -->
        <div class="mt-6 bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-blue-800 dark:text-blue-300">
                        Project Creation Tips
                    </h3>
                    <div class="mt-2 text-sm text-blue-700 dark:text-blue-400">
                        <ul class="list-disc list-inside space-y-1">
                            <li>Choose an order that has been paid or is in processing status</li>
                            <li>The project title should clearly describe the deliverables</li>
                            <li>Set realistic start and end dates based on the project scope</li>
                            <li>Budget can be the same as order amount or adjusted based on actual project cost</li>
                            <li>After creation, you can add team members, tasks, and milestones</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
