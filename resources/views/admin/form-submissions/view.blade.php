<x-layouts.app :title="__('Submission Details')">
    <flux:section padded>
        <header class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Submission Details</h1>
                <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">
                    Form: {{ $submission->form->name }}
                </p>
            </div>
            
            <div>
                <flux:button color="secondary" :href="route('admin.form-submissions.form', $submission->form_id)" wire:navigate>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 me-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                    </svg>
                    Back to Submissions
                </flux:button>
            </div>
        </header>
        
        <div class="bg-white dark:bg-zinc-800 shadow sm:rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                    <div class="col-span-2">
                        <dt class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Submission ID</dt>
                        <dd class="mt-1 text-sm text-zinc-900 dark:text-white">{{ $submission->id }}</dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Submitted At</dt>
                        <dd class="mt-1 text-sm text-zinc-900 dark:text-white">{{ $submission->created_at->format('M d, Y H:i:s') }}</dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-zinc-500 dark:text-zinc-400">IP Address</dt>
                        <dd class="mt-1 text-sm text-zinc-900 dark:text-white">{{ $submission->ip_address ?? 'Not recorded' }}</dd>
                    </div>
                    
                    <div class="col-span-2">
                        <dt class="text-sm font-medium text-zinc-500 dark:text-zinc-400">User Agent</dt>
                        <dd class="mt-1 text-sm text-zinc-900 dark:text-white overflow-auto max-w-full">
                            <code class="text-xs">{{ $submission->user_agent ?? 'Not recorded' }}</code>
                        </dd>
                    </div>
                    
                    <div class="col-span-2">
                        <dt class="text-sm font-medium text-zinc-500 dark:text-zinc-400 mb-2">Form Data</dt>
                        <dd class="bg-zinc-50 dark:bg-zinc-700 rounded-lg p-4">
                            <dl class="grid grid-cols-1 gap-y-4 sm:grid-cols-1">
                                @foreach($submission->form->fields as $field)
                                    <div>
                                        <dt class="text-sm font-medium text-zinc-500 dark:text-zinc-400">{{ $field->label }}</dt>
                                        <dd class="mt-1 text-sm text-zinc-900 dark:text-white">
                                            @if(isset($submission->data[$field->name]))
                                                @if(is_array($submission->data[$field->name]))
                                                    <ul class="list-disc pl-5">
                                                        @foreach($submission->data[$field->name] as $value)
                                                            <li>{{ $value }}</li>
                                                        @endforeach
                                                    </ul>
                                                @elseif($field->type === 'textarea')
                                                    <div class="whitespace-pre-line">{{ $submission->data[$field->name] }}</div>
                                                @else
                                                    {{ $submission->data[$field->name] }}
                                                @endif
                                            @else
                                                <span class="text-zinc-400 dark:text-zinc-500">Not provided</span>
                                            @endif
                                        </dd>
                                    </div>
                                @endforeach
                            </dl>
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
        
        @can('delete-form-submissions')
        <div class="mt-6 flex justify-end">
            <form action="{{ route('admin.form-submissions.destroy', $submission->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this submission? This action cannot be undone.');">
                @csrf
                @method('DELETE')
                <flux:button color="danger" type="submit">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 me-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                    </svg>
                    Delete Submission
                </flux:button>
            </form>
        </div>
        @endcan
    </flux:section>
</x-layouts.app>