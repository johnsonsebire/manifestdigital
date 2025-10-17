<x-layouts.app title="Edit Project">
    <div class="p-6 max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <a href="{{ route('admin.projects.show', $project) }}" 
                class="text-sm text-primary-600 hover:text-primary-700 dark:text-primary-400 mb-2 inline-block"
                wire:navigate>
                ← Back to Project
            </a>
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Edit Project</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                Order <a href="{{ route('admin.orders.show', $project->order) }}" class="text-primary-600 hover:text-primary-700" wire:navigate>#{{ $project->order->order_number }}</a>
                • Customer: {{ $project->order->customer->name }}
            </p>
        </div>

        <!-- Edit Form -->
        <div class="bg-white dark:bg-zinc-800 rounded-lg shadow">
            <form method="POST" action="{{ route('admin.projects.update', $project) }}">
                @csrf
                @method('PATCH')

                <div class="p-6 space-y-6">
                    <!-- Project Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                            Project Title <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="title" 
                            name="title" 
                            value="{{ old('title', $project->title) }}"
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
                            rows="5"
                            placeholder="Detailed project description, scope, and deliverables..."
                            class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md bg-white dark:bg-zinc-900 text-zinc-900 dark:text-white focus:ring-primary-500 focus:border-primary-500 @error('description') border-red-500 @enderror"
                        >{{ old('description', $project->description) }}</textarea>
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
                                value="{{ old('start_date', $project->start_date?->format('Y-m-d')) }}"
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
                                value="{{ old('end_date', $project->end_date?->format('Y-m-d')) }}"
                                class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md bg-white dark:bg-zinc-900 text-zinc-900 dark:text-white focus:ring-primary-500 focus:border-primary-500 @error('end_date') border-red-500 @enderror"
                            >
                            @error('end_date')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Budget, Status, and Completion -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Budget -->
                        <div>
                            <label for="budget" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                                Budget (₦)
                            </label>
                            <input 
                                type="number" 
                                id="budget" 
                                name="budget" 
                                value="{{ old('budget', $project->budget) }}"
                                min="0"
                                step="0.01"
                                placeholder="0.00"
                                class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md bg-white dark:bg-zinc-900 text-zinc-900 dark:text-white focus:ring-primary-500 focus:border-primary-500 @error('budget') border-red-500 @enderror"
                            >
                            @error('budget')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                                Status <span class="text-red-500">*</span>
                            </label>
                            <select 
                                id="status" 
                                name="status"
                                required
                                class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md bg-white dark:bg-zinc-900 text-zinc-900 dark:text-white focus:ring-primary-500 focus:border-primary-500 @error('status') border-red-500 @enderror"
                            >
                                <option value="pending" {{ old('status', $project->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="active" {{ old('status', $project->status) === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="on_hold" {{ old('status', $project->status) === 'on_hold' ? 'selected' : '' }}>On Hold</option>
                                <option value="completed" {{ old('status', $project->status) === 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ old('status', $project->status) === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Completion Percentage -->
                        <div>
                            <label for="completion_percentage" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                                Completion (%)
                            </label>
                            <input 
                                type="number" 
                                id="completion_percentage" 
                                name="completion_percentage" 
                                value="{{ old('completion_percentage', $project->completion_percentage) }}"
                                min="0"
                                max="100"
                                placeholder="0"
                                class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md bg-white dark:bg-zinc-900 text-zinc-900 dark:text-white focus:ring-primary-500 focus:border-primary-500 @error('completion_percentage') border-red-500 @enderror"
                            >
                            @error('completion_percentage')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">
                                Set to 100% to auto-complete the project
                            </p>
                        </div>
                    </div>

                    <!-- Current Project Info -->
                    <div class="border-t border-zinc-200 dark:border-zinc-700 pt-6">
                        <h3 class="text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-4">Current Project Information</h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                            <div>
                                <div class="text-zinc-500 dark:text-zinc-400">Tasks</div>
                                <div class="text-zinc-900 dark:text-white font-medium mt-1">
                                    {{ $project->tasks->count() }} total
                                </div>
                                <div class="text-xs text-zinc-500 dark:text-zinc-400">
                                    {{ $project->tasks->where('status', 'completed')->count() }} completed
                                </div>
                            </div>
                            <div>
                                <div class="text-zinc-500 dark:text-zinc-400">Milestones</div>
                                <div class="text-zinc-900 dark:text-white font-medium mt-1">
                                    {{ $project->milestones->count() }} total
                                </div>
                                <div class="text-xs text-zinc-500 dark:text-zinc-400">
                                    {{ $project->milestones->where('status', 'completed')->count() }} achieved
                                </div>
                            </div>
                            <div>
                                <div class="text-zinc-500 dark:text-zinc-400">Team</div>
                                <div class="text-zinc-900 dark:text-white font-medium mt-1">
                                    {{ $project->team->count() }} members
                                </div>
                            </div>
                            <div>
                                <div class="text-zinc-500 dark:text-zinc-400">Files</div>
                                <div class="text-zinc-900 dark:text-white font-medium mt-1">
                                    {{ $project->files->count() }} files
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="px-6 py-4 bg-zinc-50 dark:bg-zinc-900 border-t border-zinc-200 dark:border-zinc-700 flex items-center justify-between rounded-b-lg">
                    <a href="{{ route('admin.projects.show', $project) }}" 
                        class="text-sm text-zinc-600 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-white"
                        wire:navigate>
                        Cancel
                    </a>
                    <div class="flex items-center gap-3">
                        @if($project->status !== 'active')
                            <button 
                                type="button"
                                onclick="if(confirm('Are you sure you want to delete this project? This action cannot be undone.')) { document.getElementById('deleteForm').submit(); }"
                                class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                            >
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Delete Project
                            </button>
                        @endif
                        <button 
                            type="submit"
                            class="inline-flex items-center px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                        >
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Update Project
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Delete Form (Hidden) -->
        @if($project->status !== 'active')
            <form id="deleteForm" method="POST" action="{{ route('admin.projects.destroy', $project) }}" class="hidden">
                @csrf
                @method('DELETE')
            </form>
        @endif

        <!-- Status Change Warning -->
        @if($project->status === 'active')
            <div class="mt-6 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-yellow-800 dark:text-yellow-300">
                            Active Project
                        </h3>
                        <div class="mt-2 text-sm text-yellow-700 dark:text-yellow-400">
                            <p>This project is currently active and cannot be deleted. Change the status to cancel or complete it before deletion.</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

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
                        Project Update Tips
                    </h3>
                    <div class="mt-2 text-sm text-blue-700 dark:text-blue-400">
                        <ul class="list-disc list-inside space-y-1">
                            <li>Status changes are logged in the activity timeline</li>
                            <li>Setting completion to 100% will automatically mark the project as completed</li>
                            <li>Changing status to "Completed" will notify the customer</li>
                            <li>Budget updates don't affect the original order amount</li>
                            <li>Use "On Hold" status for temporarily paused projects</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
