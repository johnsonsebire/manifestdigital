<x-app-layout>
    <flux:section padded>
        <flux:section.header class="flex justify-between items-center">
            <div>
                <flux:heading.h1>Form Submissions</flux:heading.h1>
                <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">
                    {{ isset($form) ? "Submissions for: {$form->title}" : "All form submissions" }}
                </p>
            </div>
            
            <div class="flex space-x-3">
                @can('export-form-submissions')
                    @if(isset($form))
                    <div class="flex space-x-2">
                        <flux:button color="secondary" :href="route('admin.form-submissions.export.excel', $form->id)">
                            <x-heroicon-m-document-arrow-down class="w-5 h-5 me-1" />
                            Export Excel
                        </flux:button>
                        <flux:button color="secondary" :href="route('admin.form-submissions.export.pdf', $form->id)">
                            <x-heroicon-m-document-arrow-down class="w-5 h-5 me-1" />
                            Export PDF
                        </flux:button>
                    </div>
                    @endif
                @endcan
                
                <flux:button color="zinc" :href="route('admin.forms.index')" wire:navigate>
                    <x-heroicon-m-arrow-left class="w-5 h-5 me-1" />
                    Back to Forms
                </flux:button>
            </div>
        </flux:section.header>
        
        @if(session('success'))
            <flux:alert class="mb-6" color="success" icon="check-circle" title="Success">
                {{ session('success') }}
            </flux:alert>
        @endif
        
        <flux:card>
            <flux:table>
                <x-slot:header>
                    <flux:table.head>ID</flux:table.head>
                    @if(!isset($form))
                    <flux:table.head>Form</flux:table.head>
                    @endif
                    <flux:table.head>Submitted By</flux:table.head>
                    <flux:table.head>IP Address</flux:table.head>
                    <flux:table.head>Submitted At</flux:table.head>
                    <flux:table.head>Actions</flux:table.head>
                </x-slot:header>
                
                <x-slot:body>
                    @forelse($submissions as $submission)
                        <flux:table.row>
                            <flux:table.cell>{{ $submission->id }}</flux:table.cell>
                            
                            @if(!isset($form))
                            <flux:table.cell>
                                <a href="{{ route('admin.forms.show', $submission->form_id) }}" class="text-primary-600 hover:underline" wire:navigate>
                                    {{ $submission->form->title }}
                                </a>
                            </flux:table.cell>
                            @endif
                            
                            <flux:table.cell>
                                {{ $submission->user_id ? $submission->user->name : 'Guest' }}
                            </flux:table.cell>
                            
                            <flux:table.cell>
                                <flux:badge color="zinc" class="font-mono">{{ $submission->ip_address }}</flux:badge>
                            </flux:table.cell>
                            
                            <flux:table.cell>{{ $submission->created_at->format('M d, Y H:i') }}</flux:table.cell>
                            
                            <flux:table.cell>
                                <div class="flex space-x-2 rtl:space-x-reverse">
                                    <flux:button size="sm" color="info" :href="route('admin.form-submissions.show', $submission->id)" wire:navigate>
                                        <x-heroicon-m-eye class="w-4 h-4" />
                                    </flux:button>
                                    
                                    @can('delete-form-submissions')
                                    <flux:button size="sm" color="danger" x-data="" @click="$dispatch('open-modal', 'delete-submission-{{ $submission->id }}')">
                                        <x-heroicon-m-trash class="w-4 h-4" />
                                    </flux:button>
                                    
                                    <!-- Delete Modal -->
                                    <x-modal name="delete-submission-{{ $submission->id }}" title="Delete Submission">
                                        <div class="p-6">
                                            <p class="mb-6">Are you sure you want to delete this submission? This action cannot be undone.</p>
                                            
                                            <div class="flex justify-end gap-4">
                                                <flux:button color="zinc" x-on:click="$dispatch('close')">
                                                    Cancel
                                                </flux:button>
                                                
                                                <form action="{{ route('admin.form-submissions.destroy', $submission->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <flux:button type="submit" color="danger">
                                                        Delete Submission
                                                    </flux:button>
                                                </form>
                                            </div>
                                        </div>
                                    </x-modal>
                                    @endcan
                                </div>
                            </flux:table.cell>
                        </flux:table.row>
                    @empty
                        <flux:table.row>
                            <flux:table.cell colspan="{{ isset($form) ? '5' : '6' }}" class="text-center py-8">
                                <div class="flex flex-col items-center justify-center space-y-2">
                                    <x-heroicon-o-inbox class="w-12 h-12 text-zinc-400" />
                                    <p class="font-medium text-zinc-500 dark:text-zinc-400">No submissions found</p>
                                </div>
                            </flux:table.cell>
                        </flux:table.row>
                    @endforelse
                </x-slot:body>
            </flux:table>
            
            @if($submissions->hasPages())
                <div class="px-4 py-3 border-t border-zinc-200 dark:border-zinc-700">
                    {{ $submissions->links() }}
                </div>
            @endif
        </flux:card>
    </flux:section>
</x-app-layout>