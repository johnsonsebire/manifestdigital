<x-layouts.app :title="__('Form Submissions')">
    <flux:section padded>
        <header class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $form->name }} - Submissions</h1>
                <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">
                    Viewing all submissions for this form
                </p>
            </div>
            
            <div>
                <flux:button color="secondary" :href="route('admin.forms.view', $form->id)" wire:navigate>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 me-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                    </svg>
                    Back to Form
                </flux:button>
            </div>
        </header>
        
        @if($submissions->count() > 0)
            <div class="bg-white dark:bg-zinc-800 shadow overflow-hidden sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                        <thead class="bg-zinc-50 dark:bg-zinc-700">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">
                                    Submitted At
                                </th>
                                @foreach($form->fields as $field)
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">
                                        {{ $field->label }}
                                    </th>
                                @endforeach
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-zinc-800 divide-y divide-zinc-200 dark:divide-zinc-700">
                            @foreach($submissions as $submission)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">
                                        {{ $submission->created_at->format('M d, Y H:i') }}
                                    </td>
                                    
                                    @foreach($form->fields as $field)
                                        <td class="px-6 py-4 text-sm text-zinc-500 dark:text-zinc-400">
                                            @if(isset($submission->data[$field->name]))
                                                @if(is_array($submission->data[$field->name]))
                                                    {{ implode(', ', $submission->data[$field->name]) }}
                                                @else
                                                    {{ Str::limit($submission->data[$field->name], 50) }}
                                                @endif
                                            @else
                                                <span class="text-zinc-400 dark:text-zinc-500">Not provided</span>
                                            @endif
                                        </td>
                                    @endforeach
                                    
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-2">
                                            @can('view-form-submissions')
                                            <flux:button color="secondary" size="xs" :href="route('admin.form-submissions.view', $submission->id)" wire:navigate>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                </svg>
                                                <span class="sr-only">View</span>
                                            </flux:button>
                                            @endcan
                                            
                                            @can('delete-form-submissions')
                                            <form action="{{ route('admin.form-submissions.destroy', $submission->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this submission?');">
                                                @csrf
                                                @method('DELETE')
                                                <flux:button color="danger" size="xs" type="submit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                    </svg>
                                                    <span class="sr-only">Delete</span>
                                                </flux:button>
                                            </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="mt-4">
                {{ $submissions->links() }}
            </div>
        @else
            <div class="bg-white dark:bg-zinc-800 shadow rounded-lg overflow-hidden p-6 text-center">
                <p class="text-zinc-600 dark:text-zinc-400">No submissions have been received for this form yet.</p>
            </div>
        @endif
    </flux:section>
</x-layouts.app>