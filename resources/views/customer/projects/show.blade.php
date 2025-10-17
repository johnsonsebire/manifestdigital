<x-layouts.app :title="$project->title">
    <div class="p-6 max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <a href="{{ route('customer.projects.index') }}" 
                class="text-sm text-primary-600 hover:text-primary-700 dark:text-primary-400 mb-2 inline-block"
                wire:navigate>
                ← Back to My Projects
            </a>
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $project->title }}</h1>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                        Order <a href="{{ route('customer.orders.show', $project->order) }}" class="text-primary-600 hover:text-primary-700" wire:navigate>#{{ $project->order->order_number }}</a>
                    </p>
                </div>
                
                <div>
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
            </div>

            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400 mb-2">Total Tasks</div>
                <div class="text-3xl font-bold text-zinc-900 dark:text-white">{{ $tasks->count() }}</div>
                <div class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                    {{ $tasks->where('status', 'completed')->count() }} completed
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400 mb-2">Milestones</div>
                <div class="text-3xl font-bold text-zinc-900 dark:text-white">{{ $milestones->count() }}</div>
                <div class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                    {{ $milestones->where('status', 'completed')->count() }} achieved
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400 mb-2">Team Members</div>
                <div class="text-3xl font-bold text-zinc-900 dark:text-white">{{ $team->count() }}</div>
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

                <!-- Milestones -->
                @if($milestones->count() > 0)
                    <div class="bg-white dark:bg-zinc-800 rounded-lg shadow overflow-hidden">
                        <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700">
                            <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Milestones</h2>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                @foreach($milestones as $milestone)
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
                        </div>
                    </div>
                @endif

                <!-- Tasks -->
                @if($tasks->count() > 0)
                    <div class="bg-white dark:bg-zinc-800 rounded-lg shadow overflow-hidden">
                        <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700">
                            <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Tasks</h2>
                        </div>
                        <div class="p-6">
                            <div class="space-y-3">
                                @foreach($tasks as $task)
                                    <div class="flex items-start space-x-3 p-3 rounded-lg hover:bg-zinc-50 dark:hover:bg-zinc-700">
                                        <div class="flex-shrink-0 mt-0.5">
                                            @if($task->status === 'completed')
                                                <div class="w-5 h-5 rounded-full bg-green-500 flex items-center justify-center">
                                                    <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                            @else
                                                <div class="w-5 h-5 rounded-full border-2 border-zinc-300 dark:border-zinc-600"></div>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-zinc-900 dark:text-white {{ $task->status === 'completed' ? 'line-through' : '' }}">
                                                {{ $task->title }}
                                            </p>
                                            @if($task->description)
                                                <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">{{ Str::limit($task->description, 80) }}</p>
                                            @endif
                                            <div class="flex items-center gap-3 mt-1">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium 
                                                    {{ $task->priority === 'high' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300' : '' }}
                                                    {{ $task->priority === 'medium' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300' : '' }}
                                                    {{ $task->priority === 'low' ? 'bg-zinc-100 text-zinc-800 dark:bg-zinc-700 dark:text-zinc-300' : '' }}">
                                                    {{ ucfirst($task->priority) }} Priority
                                                </span>
                                                @if($task->due_date)
                                                    <span class="text-xs text-zinc-500 dark:text-zinc-400">
                                                        Due: {{ $task->due_date->format('M d, Y') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Project Files -->
                @if($files->count() > 0)
                    <div class="bg-white dark:bg-zinc-800 rounded-lg shadow overflow-hidden">
                        <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700">
                            <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Files</h2>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($files as $file)
                                    <div class="flex items-center space-x-3 p-4 border border-zinc-200 dark:border-zinc-700 rounded-lg">
                                        <div class="flex-shrink-0">
                                            <svg class="w-8 h-8 text-zinc-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-zinc-900 dark:text-white truncate">{{ $file->filename }}</p>
                                            <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                                {{ round($file->filesize / 1024, 2) }} KB • {{ $file->created_at->format('M d, Y') }}
                                            </p>
                                        </div>
                                        <div>
                                            <a href="{{ Storage::url($file->filepath) }}" 
                                                download
                                                class="text-primary-600 hover:text-primary-700 dark:text-primary-400 text-sm">
                                                Download
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
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
                    </div>
                </div>

                <!-- Team Members -->
                @if($team->count() > 0)
                    <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                        <h3 class="text-sm font-medium text-zinc-500 dark:text-zinc-400 mb-4">Team Members</h3>
                        <div class="space-y-3">
                            @foreach($team as $member)
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
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Recent Messages -->
                @if($messages->count() > 0)
                    <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                        <h3 class="text-sm font-medium text-zinc-500 dark:text-zinc-400 mb-4">Recent Messages</h3>
                        <div class="space-y-4">
                            @foreach($messages->take(3) as $message)
                                <div class="text-sm">
                                    <div class="flex items-center space-x-2 mb-1">
                                        <span class="font-medium text-zinc-900 dark:text-white">{{ $message->user->name }}</span>
                                        <span class="text-zinc-400 dark:text-zinc-600">•</span>
                                        <span class="text-zinc-500 dark:text-zinc-400 text-xs">{{ $message->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-zinc-600 dark:text-zinc-400">{{ Str::limit($message->content, 80) }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Contact Support -->
                <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-6">
                    <h3 class="text-sm font-medium text-blue-900 dark:text-blue-300 mb-2">Questions about your project?</h3>
                    <p class="text-sm text-blue-800 dark:text-blue-400 mb-4">
                        Our team is here to help you every step of the way.
                    </p>
                    <a href="mailto:support@manifestghana.com" 
                        class="inline-flex items-center text-sm font-medium text-blue-900 dark:text-blue-300 hover:text-blue-700 dark:hover:text-blue-200">
                        Contact Support
                        <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
