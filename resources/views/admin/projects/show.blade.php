<x-layouts.app :title="$project->title">
    <div class="p-6 max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <a href="{{ route('admin.projects.index') }}" 
                class="text-sm text-primary-600 hover:text-primary-700 dark:text-primary-400 mb-2 inline-block"
                wire:navigate>
                ← Back to Projects
            </a>
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $project->title }}</h1>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                        Order <a href="{{ route('admin.orders.show', $project->order) }}" class="text-primary-600 hover:text-primary-700" wire:navigate>#{{ $project->order->order_number }}</a>
                        • Customer: {{ $project->order->customer->name }}
                    </p>
                </div>
                
                <div class="flex items-center gap-3">
                    @php
                        $statusColors = [
                            'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300',
                            'active' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
                            'on_hold' => 'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-300',
                            'completed' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300',
                            'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                        ];
                    @endphp
                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium {{ $statusColors[$project->status] ?? 'bg-zinc-100 text-zinc-800' }}">
                        {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                    </span>
                    <a href="{{ route('admin.projects.edit', $project) }}" 
                        class="inline-flex items-center px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700"
                        wire:navigate>
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit Project
                    </a>
                </div>
            </div>
        </div>

        <!-- Progress Overview -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400 mb-2">Overall Progress</div>
                <div class="flex items-end justify-between">
                    <div class="text-3xl font-bold text-zinc-900 dark:text-white">{{ $project->completion_percentage }}%</div>
                    <div class="w-16 h-2 bg-zinc-200 dark:bg-zinc-700 rounded-full">
                        <div class="bg-primary-600 h-2 rounded-full" style="width: {{ $project->completion_percentage }}%"></div>
                    </div>
                </div>
                <form method="POST" action="{{ route('admin.projects.progress.update', $project) }}" class="mt-3">
                    @csrf
                    @method('PATCH')
                    <div class="flex gap-2">
                        <input 
                            type="number" 
                            name="completion_percentage" 
                            value="{{ $project->completion_percentage }}"
                            min="0"
                            max="100"
                            class="flex-1 px-3 py-1 text-sm border border-zinc-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-900 text-zinc-900 dark:text-white"
                        >
                        <button type="submit" class="px-3 py-1 text-sm bg-primary-600 text-white rounded hover:bg-primary-700">
                            Update
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400 mb-2">Total Tasks</div>
                <div class="text-3xl font-bold text-zinc-900 dark:text-white">{{ $project->tasks->count() }}</div>
                <div class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                    {{ $project->tasks->where('status', 'completed')->count() }} completed
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400 mb-2">Milestones</div>
                <div class="text-3xl font-bold text-zinc-900 dark:text-white">{{ $project->milestones->count() }}</div>
                <div class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                    {{ $project->milestones->where('status', 'completed')->count() }} achieved
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400 mb-2">Team Members</div>
                <div class="text-3xl font-bold text-zinc-900 dark:text-white">{{ $project->team->count() }}</div>
                <div class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                    Working on project
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Description -->
                @if($project->description)
                    <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                        <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Description</h2>
                        <div class="prose dark:prose-invert max-w-none text-zinc-600 dark:text-zinc-400">
                            {{ $project->description }}
                        </div>
                    </div>
                @endif

                <!-- Order Items -->
                <div class="bg-white dark:bg-zinc-800 rounded-lg shadow overflow-hidden">
                    <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700">
                        <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Order Items</h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            @foreach($project->order->items as $item)
                                <div class="flex justify-between items-start pb-4 border-b border-zinc-200 dark:border-zinc-700 last:border-0 last:pb-0">
                                    <div class="flex-1">
                                        <h3 class="font-medium text-zinc-900 dark:text-white">
                                            {{ $item->service->title }}
                                        </h3>
                                        <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                                            Quantity: {{ $item->quantity }}
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <div class="font-medium text-zinc-900 dark:text-white">
                                            ₦{{ number_format($item->subtotal, 2) }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Milestones -->
                <div class="bg-white dark:bg-zinc-800 rounded-lg shadow overflow-hidden">
                    <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700 flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Milestones</h2>
                        <button class="text-sm text-primary-600 hover:text-primary-700 dark:text-primary-400">
                            + Add Milestone
                        </button>
                    </div>
                    <div class="p-6">
                        @if($project->milestones->count() > 0)
                            <div class="space-y-4">
                                @foreach($project->milestones as $milestone)
                                    <div class="border border-zinc-200 dark:border-zinc-700 rounded-lg p-4">
                                        <div class="flex items-start justify-between">
                                            <div class="flex-1">
                                                <div class="flex items-center">
                                                    <h3 class="font-medium text-zinc-900 dark:text-white">{{ $milestone->title }}</h3>
                                                    <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium 
                                                        {{ $milestone->status === 'completed' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' : '' }}
                                                        {{ $milestone->status === 'in_progress' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300' : '' }}
                                                        {{ $milestone->status === 'pending' ? 'bg-zinc-100 text-zinc-800 dark:bg-zinc-700 dark:text-zinc-300' : '' }}">
                                                        {{ ucfirst(str_replace('_', ' ', $milestone->status)) }}
                                                    </span>
                                                </div>
                                                @if($milestone->description)
                                                    <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">{{ $milestone->description }}</p>
                                                @endif
                                                <div class="flex items-center gap-4 mt-2 text-sm text-zinc-500 dark:text-zinc-400">
                                                    @if($milestone->start_date)
                                                        <span>Start: {{ $milestone->start_date->format('M d, Y') }}</span>
                                                    @endif
                                                    @if($milestone->end_date)
                                                        <span>Due: {{ $milestone->end_date->format('M d, Y') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">No milestones added yet.</p>
                        @endif
                    </div>
                </div>

                <!-- Tasks -->
                <div class="bg-white dark:bg-zinc-800 rounded-lg shadow overflow-hidden" x-data="{ showAddTask: false, editingTask: null }">
                    <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700 flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Tasks</h2>
                        <button 
                            @click="showAddTask = !showAddTask"
                            class="text-sm text-primary-600 hover:text-primary-700 dark:text-primary-400">
                            <span x-show="!showAddTask">+ Add Task</span>
                            <span x-show="showAddTask">× Cancel</span>
                        </button>
                    </div>

                    <!-- Add Task Form -->
                    <div x-show="showAddTask" x-collapse class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-900">
                        <form method="POST" action="{{ route('admin.projects.tasks.store', $project) }}" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Task Title*</label>
                                <input 
                                    type="text" 
                                    name="title" 
                                    required
                                    class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-primary-500"
                                    placeholder="Enter task title">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Description</label>
                                <textarea 
                                    name="description" 
                                    rows="2"
                                    class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-primary-500"
                                    placeholder="Task description (optional)"></textarea>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Priority*</label>
                                    <select 
                                        name="priority" 
                                        required
                                        class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-primary-500">
                                        <option value="low">Low</option>
                                        <option value="medium" selected>Medium</option>
                                        <option value="high">High</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Status*</label>
                                    <select 
                                        name="status" 
                                        required
                                        class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-primary-500">
                                        <option value="pending" selected>Pending</option>
                                        <option value="in_progress">In Progress</option>
                                        <option value="completed">Completed</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Assign To</label>
                                    <select 
                                        name="assigned_to"
                                        class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-primary-500">
                                        <option value="">Unassigned</option>
                                        @foreach($project->team as $member)
                                            <option value="{{ $member->id }}">{{ $member->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Due Date</label>
                                    <input 
                                        type="date" 
                                        name="due_date"
                                        class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-primary-500">
                                </div>
                            </div>

                            <div class="flex justify-end gap-2">
                                <button 
                                    type="button" 
                                    @click="showAddTask = false"
                                    class="px-4 py-2 text-sm text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-700 rounded-md">
                                    Cancel
                                </button>
                                <button 
                                    type="submit"
                                    class="px-4 py-2 text-sm bg-primary-600 text-white rounded-md hover:bg-primary-700">
                                    Add Task
                                </button>
                            </div>
                        </form>
                    </div>
                    
                    <div class="p-6">
                        @if($project->tasks->count() > 0)
                            <div class="space-y-3">
                                @foreach($project->tasks as $task)
                                    <div 
                                        class="flex items-start space-x-3 p-3 rounded-lg hover:bg-zinc-50 dark:hover:bg-zinc-700 group"
                                        x-data="{ showEditForm: false }">
                                        
                                        <!-- Quick Toggle Checkbox -->
                                        <form method="POST" action="{{ route('admin.projects.tasks.toggle', [$project, $task]) }}" class="flex-shrink-0 mt-0.5">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="focus:outline-none">
                                                @if($task->status === 'completed')
                                                    <div class="w-5 h-5 rounded-full bg-green-500 flex items-center justify-center hover:bg-green-600 transition">
                                                        <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                        </svg>
                                                    </div>
                                                @else
                                                    <div class="w-5 h-5 rounded-full border-2 border-zinc-300 dark:border-zinc-600 hover:border-primary-500 dark:hover:border-primary-400 transition"></div>
                                                @endif
                                            </button>
                                        </form>

                                        <div class="flex-1 min-w-0">
                                            <!-- Task Display -->
                                            <div x-show="!showEditForm">
                                                <div class="flex items-start justify-between">
                                                    <div class="flex-1">
                                                        <p class="text-sm font-medium text-zinc-900 dark:text-white {{ $task->status === 'completed' ? 'line-through' : '' }}">
                                                            {{ $task->title }}
                                                        </p>
                                                        @if($task->description)
                                                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">{{ Str::limit($task->description, 80) }}</p>
                                                        @endif
                                                        <div class="flex items-center gap-3 mt-1 flex-wrap">
                                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium 
                                                                {{ $task->priority === 'high' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300' : '' }}
                                                                {{ $task->priority === 'medium' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300' : '' }}
                                                                {{ $task->priority === 'low' ? 'bg-zinc-100 text-zinc-800 dark:bg-zinc-700 dark:text-zinc-300' : '' }}">
                                                                {{ ucfirst($task->priority) }} Priority
                                                            </span>
                                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium 
                                                                {{ $task->status === 'completed' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' : '' }}
                                                                {{ $task->status === 'in_progress' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300' : '' }}
                                                                {{ $task->status === 'pending' ? 'bg-zinc-100 text-zinc-800 dark:bg-zinc-700 dark:text-zinc-300' : '' }}">
                                                                {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                                            </span>
                                                            @if($task->assignedTo)
                                                                <span class="text-xs text-zinc-500 dark:text-zinc-400">
                                                                    Assigned to: {{ $task->assignedTo->name }}
                                                                </span>
                                                            @endif
                                                            @if($task->due_date)
                                                                <span class="text-xs text-zinc-500 dark:text-zinc-400">
                                                                    Due: {{ $task->due_date->format('M d, Y') }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- Action Buttons (visible on hover) -->
                                                    <div class="flex items-center gap-2 opacity-0 group-hover:opacity-100 transition">
                                                        <button 
                                                            @click="showEditForm = true"
                                                            class="text-xs text-primary-600 hover:text-primary-700 dark:text-primary-400">
                                                            Edit
                                                        </button>
                                                        <form method="POST" action="{{ route('admin.projects.tasks.destroy', [$project, $task]) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this task?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-xs text-red-600 hover:text-red-700 dark:text-red-400">
                                                                Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Edit Form -->
                                            <div x-show="showEditForm" x-collapse>
                                                <form method="POST" action="{{ route('admin.projects.tasks.update', [$project, $task]) }}" class="space-y-3 bg-zinc-50 dark:bg-zinc-900 p-3 rounded-md -mx-3">
                                                    @csrf
                                                    @method('PUT')
                                                    
                                                    <div>
                                                        <input 
                                                            type="text" 
                                                            name="title" 
                                                            value="{{ $task->title }}"
                                                            required
                                                            class="w-full px-3 py-1.5 text-sm border border-zinc-300 dark:border-zinc-600 rounded-md bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white">
                                                    </div>
                                                    
                                                    <div>
                                                        <textarea 
                                                            name="description" 
                                                            rows="2"
                                                            class="w-full px-3 py-1.5 text-sm border border-zinc-300 dark:border-zinc-600 rounded-md bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white">{{ $task->description }}</textarea>
                                                    </div>

                                                    <div class="grid grid-cols-2 gap-2">
                                                        <select 
                                                            name="priority" 
                                                            required
                                                            class="px-3 py-1.5 text-sm border border-zinc-300 dark:border-zinc-600 rounded-md bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white">
                                                            <option value="low" {{ $task->priority === 'low' ? 'selected' : '' }}>Low</option>
                                                            <option value="medium" {{ $task->priority === 'medium' ? 'selected' : '' }}>Medium</option>
                                                            <option value="high" {{ $task->priority === 'high' ? 'selected' : '' }}>High</option>
                                                        </select>
                                                        
                                                        <select 
                                                            name="status" 
                                                            required
                                                            class="px-3 py-1.5 text-sm border border-zinc-300 dark:border-zinc-600 rounded-md bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white">
                                                            <option value="pending" {{ $task->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                            <option value="in_progress" {{ $task->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                                            <option value="completed" {{ $task->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                                        </select>
                                                    </div>

                                                    <div class="grid grid-cols-2 gap-2">
                                                        <select 
                                                            name="assigned_to"
                                                            class="px-3 py-1.5 text-sm border border-zinc-300 dark:border-zinc-600 rounded-md bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white">
                                                            <option value="">Unassigned</option>
                                                            @foreach($project->team as $member)
                                                                <option value="{{ $member->id }}" {{ $task->assigned_to === $member->id ? 'selected' : '' }}>
                                                                    {{ $member->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        
                                                        <input 
                                                            type="date" 
                                                            name="due_date"
                                                            value="{{ $task->due_date?->format('Y-m-d') }}"
                                                            class="px-3 py-1.5 text-sm border border-zinc-300 dark:border-zinc-600 rounded-md bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white">
                                                    </div>

                                                    <div class="flex justify-end gap-2">
                                                        <button 
                                                            type="button" 
                                                            @click="showEditForm = false"
                                                            class="px-3 py-1.5 text-xs text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-700 rounded-md">
                                                            Cancel
                                                        </button>
                                                        <button 
                                                            type="submit"
                                                            class="px-3 py-1.5 text-xs bg-primary-600 text-white rounded-md hover:bg-primary-700">
                                                            Save Changes
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">No tasks added yet.</p>
                        @endif
                    </div>
                </div>

                <!-- Activity Log -->
                <div class="bg-white dark:bg-zinc-800 rounded-lg shadow overflow-hidden">
                    <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700">
                        <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Activity Log</h2>
                    </div>
                    <div class="p-6">
                        @if($project->activities->count() > 0)
                            <div class="flow-root">
                                <ul role="list" class="-mb-8">
                                    @foreach($project->activities->take(10) as $index => $activity)
                                        <li>
                                            <div class="relative pb-8">
                                                @if(!$loop->last)
                                                    <span class="absolute left-4 top-4 -ml-px h-full w-0.5 bg-zinc-200 dark:bg-zinc-700" aria-hidden="true"></span>
                                                @endif
                                                <div class="relative flex space-x-3">
                                                    <div>
                                                        <span class="h-8 w-8 rounded-full bg-primary-500 flex items-center justify-center ring-8 ring-white dark:ring-zinc-800">
                                                            <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                            </svg>
                                                        </span>
                                                    </div>
                                                    <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                                                        <div>
                                                            <p class="text-sm text-zinc-900 dark:text-white">
                                                                {{ $activity->description }}
                                                            </p>
                                                        </div>
                                                        <div class="whitespace-nowrap text-right text-sm text-zinc-500 dark:text-zinc-400">
                                                            <time datetime="{{ $activity->created_at->toIso8601String() }}">
                                                                {{ $activity->created_at->diffForHumans() }}
                                                            </time>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @else
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">No activity recorded yet.</p>
                        @endif
                    </div>
                </div>

                <!-- Project Messages -->
                <div class="bg-white dark:bg-zinc-800 rounded-lg shadow overflow-hidden" x-data="{ showMessageForm: false, editingMessage: null, showInternalOnly: false }">
                    <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700">
                        <div class="flex items-center justify-between mb-3">
                            <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">
                                Project Messages ({{ $project->messages->count() }})
                            </h2>
                            <button 
                                @click="showMessageForm = !showMessageForm"
                                class="text-sm text-primary-600 hover:text-primary-700 dark:text-primary-400">
                                <span x-show="!showMessageForm">+ New Message</span>
                                <span x-show="showMessageForm">× Cancel</span>
                            </button>
                        </div>
                        
                        <!-- Filter Toggle -->
                        <div class="flex items-center gap-2">
                            <label class="inline-flex items-center cursor-pointer">
                                <input 
                                    type="checkbox" 
                                    x-model="showInternalOnly"
                                    class="rounded border-zinc-300 text-primary-600 shadow-sm focus:ring-primary-500 dark:border-zinc-600 dark:bg-zinc-900">
                                <span class="ml-2 text-sm text-zinc-600 dark:text-zinc-400">Show internal notes only</span>
                            </label>
                        </div>
                    </div>

                    <!-- Message Form -->
                    <div x-show="showMessageForm" x-collapse class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-900">
                        <form method="POST" action="{{ route('admin.projects.messages.store', $project) }}" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Message*</label>
                                <textarea 
                                    name="body" 
                                    rows="4"
                                    required
                                    class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-primary-500"
                                    placeholder="Type your message here..."></textarea>
                            </div>

                            <div class="flex items-center gap-4">
                                <label class="inline-flex items-center cursor-pointer">
                                    <input 
                                        type="checkbox" 
                                        name="is_internal" 
                                        value="1"
                                        class="rounded border-zinc-300 text-primary-600 shadow-sm focus:ring-primary-500 dark:border-zinc-600 dark:bg-zinc-900">
                                    <span class="ml-2 text-sm text-zinc-700 dark:text-zinc-300">
                                        Internal note (not visible to customer)
                                    </span>
                                </label>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                                    Attach Files (optional)
                                </label>
                                <input 
                                    type="file" 
                                    name="files[]" 
                                    multiple
                                    class="w-full text-sm text-zinc-900 dark:text-white file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 dark:file:bg-primary-900/30 dark:file:text-primary-400">
                                <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">Max 50MB per file</p>
                            </div>

                            <div class="flex justify-end gap-2">
                                <button 
                                    type="button" 
                                    @click="showMessageForm = false"
                                    class="px-4 py-2 text-sm text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-700 rounded-md">
                                    Cancel
                                </button>
                                <button 
                                    type="submit"
                                    class="px-4 py-2 text-sm bg-primary-600 text-white rounded-md hover:bg-primary-700">
                                    Post Message
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Messages List -->
                    <div class="p-6">
                        @if($project->messages->count() > 0)
                            <div class="space-y-4">
                                @foreach($project->messages->sortByDesc('created_at') as $message)
                                    <div 
                                        x-show="!showInternalOnly || {{ $message->is_internal ? 'true' : 'false' }}"
                                        class="border border-zinc-200 dark:border-zinc-700 rounded-lg p-4 {{ $message->is_internal ? 'bg-amber-50 dark:bg-amber-900/10 border-amber-200 dark:border-amber-800' : '' }}"
                                        x-data="{ showEditForm: false }">
                                        
                                        <!-- Message Header -->
                                        <div class="flex items-start justify-between mb-2">
                                            <div class="flex items-center gap-2">
                                                <div class="w-8 h-8 rounded-full bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center">
                                                    <span class="text-sm font-medium text-primary-700 dark:text-primary-400">
                                                        {{ substr($message->sender->name, 0, 1) }}
                                                    </span>
                                                </div>
                                                <div>
                                                    <div class="text-sm font-medium text-zinc-900 dark:text-white">
                                                        {{ $message->sender->name }}
                                                    </div>
                                                    <div class="text-xs text-zinc-500 dark:text-zinc-400">
                                                        {{ $message->created_at->diffForHumans() }}
                                                        @if(isset($message->metadata['edited_at']))
                                                            <span class="ml-1">(edited)</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                @if($message->is_internal)
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300">
                                                        Internal Note
                                                    </span>
                                                @endif
                                            </div>

                                            <!-- Action Buttons -->
                                            @if($message->sender_id === auth()->id())
                                                <div class="flex items-center gap-2">
                                                    <button 
                                                        @click="showEditForm = !showEditForm"
                                                        class="text-xs text-primary-600 hover:text-primary-700 dark:text-primary-400">
                                                        Edit
                                                    </button>
                                                    <form method="POST" action="{{ route('admin.projects.messages.destroy', [$project, $message]) }}" class="inline" onsubmit="return confirm('Delete this message?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-xs text-red-600 hover:text-red-700 dark:text-red-400">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Message Body -->
                                        <div x-show="!showEditForm">
                                            <div class="text-sm text-zinc-700 dark:text-zinc-300 whitespace-pre-wrap">{{ $message->body }}</div>

                                            <!-- File Attachments -->
                                            @if($message->files->count() > 0)
                                                <div class="mt-3 space-y-2">
                                                    <div class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Attachments:</div>
                                                    @foreach($message->files as $file)
                                                        <a 
                                                            href="{{ route('files.download', $file) }}"
                                                            class="inline-flex items-center gap-2 px-3 py-1.5 text-xs bg-white dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-600 rounded-md hover:bg-zinc-50 dark:hover:bg-zinc-700">
                                                            <svg class="w-4 h-4 text-zinc-400" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                                                            </svg>
                                                            <span>{{ $file->original_name }}</span>
                                                            <span class="text-zinc-400">({{ $file->formatted_size }})</span>
                                                        </a>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Edit Form -->
                                        <div x-show="showEditForm" x-collapse>
                                            <form method="POST" action="{{ route('admin.projects.messages.update', [$project, $message]) }}" class="space-y-3 bg-zinc-50 dark:bg-zinc-900 p-3 rounded-md -mx-3 -mb-3">
                                                @csrf
                                                @method('PUT')
                                                <textarea 
                                                    name="body" 
                                                    rows="3"
                                                    required
                                                    class="w-full px-3 py-2 text-sm border border-zinc-300 dark:border-zinc-600 rounded-md bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white">{{ $message->body }}</textarea>
                                                <div class="flex justify-end gap-2">
                                                    <button 
                                                        type="button" 
                                                        @click="showEditForm = false"
                                                        class="px-3 py-1.5 text-xs text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-700 rounded-md">
                                                        Cancel
                                                    </button>
                                                    <button 
                                                        type="submit"
                                                        class="px-3 py-1.5 text-xs bg-primary-600 text-white rounded-md hover:bg-primary-700">
                                                        Save Changes
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-zinc-900 dark:text-white">No messages yet</h3>
                                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Start a conversation with the team.</p>
                                <button 
                                    @click="showMessageForm = true"
                                    class="mt-4 inline-flex items-center px-4 py-2 text-sm bg-primary-600 text-white rounded-md hover:bg-primary-700">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    Post First Message
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Project Details -->
                <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                    <h3 class="text-sm font-medium text-zinc-500 dark:text-zinc-400 mb-4">Project Details</h3>
                    <div class="space-y-3 text-sm">
                        <div>
                            <div class="text-zinc-500 dark:text-zinc-400">Start Date</div>
                            <div class="text-zinc-900 dark:text-white mt-1">
                                {{ $project->start_date ? $project->start_date->format('M d, Y') : 'Not set' }}
                            </div>
                        </div>
                        <div>
                            <div class="text-zinc-500 dark:text-zinc-400">End Date</div>
                            <div class="text-zinc-900 dark:text-white mt-1">
                                {{ $project->end_date ? $project->end_date->format('M d, Y') : 'Not set' }}
                            </div>
                        </div>
                        <div>
                            <div class="text-zinc-500 dark:text-zinc-400">Budget</div>
                            <div class="text-zinc-900 dark:text-white mt-1">
                                {{ $project->budget ? '₦' . number_format($project->budget, 2) : 'Not set' }}
                            </div>
                        </div>
                        <div>
                            <div class="text-zinc-500 dark:text-zinc-400">Order Total</div>
                            <div class="text-zinc-900 dark:text-white mt-1">
                                ₦{{ number_format($project->order->total_amount, 2) }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Team Members -->
                <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Team Members</h3>
                        @if($availableStaff->count() > 0)
                            <button type="button" 
                                onclick="document.getElementById('addTeamMemberForm').classList.toggle('hidden')"
                                class="text-sm text-primary-600 hover:text-primary-700 dark:text-primary-400">
                                + Add
                            </button>
                        @endif
                    </div>

                    <!-- Add Team Member Form -->
                    @if($availableStaff->count() > 0)
                        <div id="addTeamMemberForm" class="hidden mb-4 p-4 bg-zinc-50 dark:bg-zinc-900 rounded-lg">
                            <form method="POST" action="{{ route('admin.projects.team.add', $project) }}">
                                @csrf
                                <div class="space-y-3">
                                    <div>
                                        <label class="block text-xs font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                                            Staff Member
                                        </label>
                                        <select name="user_id" required class="w-full px-3 py-2 text-sm border border-zinc-300 dark:border-zinc-600 rounded-md bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white">
                                            <option value="">Select staff...</option>
                                            @foreach($availableStaff as $staff)
                                                <option value="{{ $staff->id }}">{{ $staff->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                                            Role
                                        </label>
                                        <select name="role" required class="w-full px-3 py-2 text-sm border border-zinc-300 dark:border-zinc-600 rounded-md bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white">
                                            <option value="manager">Manager</option>
                                            <option value="developer">Developer</option>
                                            <option value="designer">Designer</option>
                                            <option value="tester">Tester</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="w-full px-3 py-2 text-sm bg-primary-600 text-white rounded-md hover:bg-primary-700">
                                        Add Member
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endif

                    <div class="space-y-3">
                        @forelse($project->team as $member)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 rounded-full bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center">
                                            <span class="text-sm font-medium text-primary-600 dark:text-primary-400">
                                                {{ substr($member->user->name, 0, 2) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ $member->user->name }}</p>
                                        <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ ucfirst($member->role) }}</p>
                                    </div>
                                </div>
                                <form method="POST" action="{{ route('admin.projects.team.remove', [$project, $member->id]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-700 dark:text-red-400" onclick="return confirm('Remove this team member?')">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        @empty
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">No team members assigned yet.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Project Files -->
                <div class="bg-white dark:bg-zinc-800 rounded-lg shadow" x-data="{ showUploadForm: false, editingFile: null }">
                    <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700 flex items-center justify-between">
                        <h3 class="text-sm font-medium text-zinc-500 dark:text-zinc-400">
                            Project Files ({{ $project->files->count() }})
                        </h3>
                        <button 
                            @click="showUploadForm = !showUploadForm"
                            class="text-sm text-primary-600 hover:text-primary-700 dark:text-primary-400">
                            <span x-show="!showUploadForm">+ Upload File</span>
                            <span x-show="showUploadForm">× Cancel</span>
                        </button>
                    </div>

                    <!-- Upload Form -->
                    <div x-show="showUploadForm" x-collapse class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-900">
                        <form method="POST" action="{{ route('admin.projects.files.store', $project) }}" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                                    Select File*
                                </label>
                                <input 
                                    type="file" 
                                    name="file" 
                                    required
                                    class="w-full text-sm text-zinc-900 dark:text-white file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 dark:file:bg-primary-900/30 dark:file:text-primary-400">
                                <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">Max file size: 50MB</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                                    Description (optional)
                                </label>
                                <textarea 
                                    name="description" 
                                    rows="2"
                                    class="w-full px-3 py-2 text-sm border border-zinc-300 dark:border-zinc-600 rounded-md bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-primary-500"
                                    placeholder="Add a description for this file"></textarea>
                            </div>

                            <div class="flex justify-end gap-2">
                                <button 
                                    type="button" 
                                    @click="showUploadForm = false"
                                    class="px-4 py-2 text-sm text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-700 rounded-md">
                                    Cancel
                                </button>
                                <button 
                                    type="submit"
                                    class="px-4 py-2 text-sm bg-primary-600 text-white rounded-md hover:bg-primary-700">
                                    Upload File
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="p-6">
                        @if($project->files->count() > 0)
                            <div class="space-y-3">
                                @foreach($project->files as $file)
                                    <div class="group border border-zinc-200 dark:border-zinc-700 rounded-lg p-4 hover:border-primary-300 dark:hover:border-primary-700 transition">
                                        <div class="flex items-start gap-3">
                                            <!-- File Icon -->
                                            <div class="flex-shrink-0">
                                                @if($file->isImage())
                                                    <div class="w-10 h-10 rounded bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                                                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                                                        </svg>
                                                    </div>
                                                @else
                                                    <div class="w-10 h-10 rounded bg-zinc-100 dark:bg-zinc-700 flex items-center justify-center">
                                                        <svg class="w-5 h-5 text-zinc-600 dark:text-zinc-400" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- File Info -->
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-start justify-between">
                                                    <div class="flex-1 min-w-0">
                                                        <h4 class="text-sm font-medium text-zinc-900 dark:text-white truncate">
                                                            {{ $file->original_name }}
                                                        </h4>
                                                        <div class="flex items-center gap-2 mt-1 text-xs text-zinc-500 dark:text-zinc-400">
                                                            <span>{{ $file->formatted_size }}</span>
                                                            <span>•</span>
                                                            <span>{{ $file->extension }}</span>
                                                            <span>•</span>
                                                            <span>{{ $file->created_at->format('M d, Y') }}</span>
                                                        </div>
                                                        @if($file->description)
                                                            <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-2">{{ $file->description }}</p>
                                                        @endif
                                                        <div class="text-xs text-zinc-500 dark:text-zinc-400 mt-2">
                                                            Uploaded by {{ $file->uploader->name }}
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- Action Buttons -->
                                                    <div class="flex items-center gap-2 ml-4 opacity-0 group-hover:opacity-100 transition">
                                                        <a 
                                                            href="{{ route('files.download', $file) }}"
                                                            class="inline-flex items-center px-2 py-1 text-xs text-primary-600 hover:text-primary-700 dark:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-900/30 rounded">
                                                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                            </svg>
                                                            Download
                                                        </a>
                                                        <button 
                                                            @click="editingFile = editingFile === {{ $file->id }} ? null : {{ $file->id }}"
                                                            class="inline-flex items-center px-2 py-1 text-xs text-yellow-600 hover:text-yellow-700 dark:text-yellow-400 hover:bg-yellow-50 dark:hover:bg-yellow-900/30 rounded">
                                                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                            </svg>
                                                            Edit
                                                        </button>
                                                        <form method="POST" action="{{ route('admin.projects.files.destroy', [$project, $file]) }}" class="inline" onsubmit="return confirm('Delete this file? This cannot be undone.');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button 
                                                                type="submit"
                                                                class="inline-flex items-center px-2 py-1 text-xs text-red-600 hover:text-red-700 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/30 rounded">
                                                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                </svg>
                                                                Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>

                                                <!-- Edit Description Form -->
                                                <div x-show="editingFile === {{ $file->id }}" x-collapse class="mt-3">
                                                    <form method="POST" action="{{ route('admin.projects.files.update-description', [$project, $file]) }}" class="bg-zinc-50 dark:bg-zinc-900 p-3 rounded-md">
                                                        @csrf
                                                        @method('PATCH')
                                                        <div class="space-y-2">
                                                            <textarea 
                                                                name="description" 
                                                                rows="2"
                                                                class="w-full px-3 py-2 text-sm border border-zinc-300 dark:border-zinc-600 rounded-md bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white"
                                                                placeholder="Add or update description">{{ $file->description }}</textarea>
                                                            <div class="flex justify-end gap-2">
                                                                <button 
                                                                    type="button" 
                                                                    @click="editingFile = null"
                                                                    class="px-3 py-1.5 text-xs text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-700 rounded-md">
                                                                    Cancel
                                                                </button>
                                                                <button 
                                                                    type="submit"
                                                                    class="px-3 py-1.5 text-xs bg-primary-600 text-white rounded-md hover:bg-primary-700">
                                                                    Save Description
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-zinc-900 dark:text-white">No files uploaded</h3>
                                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Upload your first file to get started.</p>
                                <button 
                                    @click="showUploadForm = true"
                                    class="mt-4 inline-flex items-center px-4 py-2 text-sm bg-primary-600 text-white rounded-md hover:bg-primary-700">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                    Upload File
                                </button>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                    <h3 class="text-sm font-medium text-zinc-500 dark:text-zinc-400 mb-4">Quick Actions</h3>
                    <div class="space-y-2">
                        <a href="{{ route('admin.projects.edit', $project) }}" 
                            class="flex items-center text-sm text-zinc-700 dark:text-zinc-300 hover:text-primary-600 dark:hover:text-primary-400"
                            wire:navigate>
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit Project Details
                        </a>
                        <a href="{{ route('customer.orders.show', $project->order) }}" 
                            class="flex items-center text-sm text-zinc-700 dark:text-zinc-300 hover:text-primary-600 dark:hover:text-primary-400"
                            wire:navigate>
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            View Related Order
                        </a>
                        @if($project->status !== 'cancelled')
                            <form method="POST" action="{{ route('admin.projects.destroy', $project) }}" onsubmit="return confirm('Are you sure? This will permanently delete the project.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="flex items-center text-sm text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 w-full text-left">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Delete Project
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
