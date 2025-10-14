<x-layouts.app :title="__('Form Submissions')">
    <div class="p-6">
        <header class="mb-6">
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Form Submissions</h1>
            <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">View and manage form submissions</p>
        </header>
        
        @if(session('success'))
            <div class="mb-6 rounded-md bg-green-50 dark:bg-green-900/20 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800 dark:text-green-200">
                            {{ session('success') }}
                        </p>
                    </div>
                </div>
            </div>
        @endif
        
        @if($submissions->isEmpty())
            <div class="bg-white dark:bg-zinc-800 shadow-md border border-zinc-100 dark:border-zinc-700 rounded-lg overflow-hidden">
                <div class="flex flex-col items-center justify-center py-12">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-zinc-900 dark:text-zinc-200">No submissions yet</h3>
                    <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">There are no form submissions to display.</p>
                </div>
            </div>
        @else
            <div class="bg-white dark:bg-zinc-800 shadow-md border border-zinc-100 dark:border-zinc-700 rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                        <thead class="bg-zinc-50 dark:bg-zinc-700">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">ID</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">Form</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">Submitted By</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">IP Address</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">Submitted At</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        
                        <tbody class="bg-white dark:bg-zinc-800 divide-y divide-zinc-200 dark:divide-zinc-700">
                            @foreach($submissions as $submission)
                                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-700/50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">
                                        {{ $submission->id }}
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-900 dark:text-white">
                                        <a href="{{ route('admin.forms.show', $submission->form_id) }}" class="text-primary-600 hover:underline" wire:navigate>
                                            {{ $submission->form->title }}
                                        </a>
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">
                                        {{ $submission->user_id ? $submission->user->name : 'Guest' }}
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-zinc-100 text-zinc-800 dark:bg-zinc-700 dark:text-zinc-300 font-mono">
                                            {{ $submission->ip_address }}
                                        </span>
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">
                                        {{ $submission->created_at->format('M d, Y H:i') }}
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-2 rtl:space-x-reverse">
                                            <a href="{{ route('admin.form-submissions.show', $submission->id) }}" wire:navigate
                                                class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                            </a>
                                            
                                            @can('delete-form-submissions')
                                            <button type="button" x-data x-on:click="$dispatch('open-modal', 'delete-submission-{{ $submission->id }}')"
                                                class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                </svg>
                                            </button>
                                            
                                            <!-- Delete Modal -->
                                            <x-modal name="delete-submission-{{ $submission->id }}" title="Delete Submission">
                                                <div class="p-6">
                                                    <p class="mb-6">Are you sure you want to delete this submission? This action cannot be undone.</p>
                                                    
                                                    <div class="flex justify-end gap-4">
                                                        <button type="button" x-data x-on:click="$dispatch('close')"
                                                            class="inline-flex items-center px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md shadow-sm text-sm font-medium text-zinc-700 dark:text-zinc-200 bg-white dark:bg-zinc-800 hover:bg-zinc-50 dark:hover:bg-zinc-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-zinc-500">
                                                            Cancel
                                                        </button>
                                                        
                                                        <form action="{{ route('admin.form-submissions.destroy', $submission->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                                Delete Submission
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </x-modal>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="px-4 py-3 border-t border-zinc-200 dark:border-zinc-700">
                    {{ $submissions->links() }}
                </div>
            </div>
        @endif
    </div>
</x-layouts.app>