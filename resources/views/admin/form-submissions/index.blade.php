<x-layouts.app :title="__('Form Submissions')">
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Form Submissions</h1>
                <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">
                    {{ isset($form) ? "Submissions for: {$form->title}" : "All form submissions" }}
                </p>
            </div>
            
            <div class="flex space-x-3">
                @can('export-form-submissions')
                    @if(isset($form))
                    <div class="flex space-x-2">
                        <flux:button color="secondary" :href="route('admin.form-submissions.export.excel', $form->id)">
                            Export Excel
                        </flux:button>
                        <flux:button color="secondary" :href="route('admin.form-submissions.export.pdf', $form->id)">
                            Export PDF
                        </flux:button>
                    </div>
                    @endif
                @endcan
                
                <flux:button color="zinc" :href="route('admin.forms.index')" wire:navigate>
                    Back to Forms
                </flux:button>
            </div>
        </div>
        
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 rounded-lg">
                {{ session('success') }}
            </div>
        @endif
        
        <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                    <thead class="bg-zinc-50 dark:bg-zinc-900">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">ID</th>
                            @if(!isset($form))
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Form</th>
                            @endif
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Submitted By</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">IP Address</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Submitted At</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-zinc-800 divide-y divide-zinc-200 dark:divide-zinc-700">
                    @forelse($submissions as $submission)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-700/50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-900 dark:text-zinc-100">
                                {{ $submission->id }}
                            </td>
                            
                            @if(!isset($form))
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <a href="{{ route('admin.forms.show', $submission->form_id) }}" class="text-blue-600 dark:text-blue-400 hover:underline" wire:navigate>
                                    {{ $submission->form->title }}
                                </a>
                            </td>
                            @endif
                            
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-900 dark:text-zinc-100">
                                {{ $submission->user_id ? $submission->user->name : 'Guest' }}
                            </td>
                            
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold font-mono rounded-full bg-zinc-100 dark:bg-zinc-700 text-zinc-800 dark:text-zinc-200">
                                    {{ $submission->ip_address }}
                                </span>
                            </td>
                            
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-900 dark:text-zinc-100">
                                {{ $submission->created_at->format('M d, Y H:i') }}
                            </td>
                            
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.form-submissions.show', $submission->id) }}" wire:navigate 
                                       class="inline-flex items-center px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs rounded transition">
                                        View
                                    </a>
                                    
                                    @can('delete-form-submissions')
                                    <button x-data="" @click="$dispatch('open-modal', 'delete-submission-{{ $submission->id }}')" 
                                            class="inline-flex items-center px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs rounded transition">
                                        Delete
                                    </button>
                                    
                                    <!-- Delete Modal -->
                                    <x-modal name="delete-submission-{{ $submission->id }}" title="Delete Submission">
                                        <div class="p-6">
                                            <p class="mb-6">Are you sure you want to delete this submission? This action cannot be undone.</p>
                                            
                                            <div class="flex justify-end gap-4">
                                                <button x-on:click="$dispatch('close')" 
                                                        class="px-4 py-2 bg-zinc-200 dark:bg-zinc-700 text-zinc-800 dark:text-zinc-200 rounded hover:bg-zinc-300 dark:hover:bg-zinc-600 transition">
                                                    Cancel
                                                </button>
                                                
                                                <form action="{{ route('admin.form-submissions.destroy', $submission->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded transition">
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
                    @empty
                        <tr>
                            <td colspan="{{ isset($form) ? '5' : '6' }}" class="px-6 py-8 text-center">
                                <div class="flex flex-col items-center justify-center space-y-2">
                                    <p class="font-medium text-zinc-500 dark:text-zinc-400">No submissions found</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
            
        @if($submissions->hasPages())
            <div class="px-4 py-3 border-t border-zinc-200 dark:border-zinc-700">
                {{ $submissions->links() }}
            </div>
        @endif
    </div>
    </div>
</x-layouts.app>