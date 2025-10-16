<x-layouts.app :title="__('Forms Management')">
    <!-- Initialize JavaScript functions FIRST before any buttons are rendered -->
    <script>
        // Immediately invoked function to ensure functions are available globally
        (function() {
            'use strict';
            
            console.log('[Forms Page] Initializing form action handlers...');
            
            // Wait for toast to be available with retry mechanism
            function waitForToast(callback, maxAttempts = 50) {
                let attempts = 0;
                const checkToast = setInterval(() => {
                    attempts++;
                    if (window.toast) {
                        clearInterval(checkToast);
                        console.log('[Forms Page] Toast manager found after', attempts, 'attempts');
                        callback();
                    } else if (attempts >= maxAttempts) {
                        clearInterval(checkToast);
                        console.warn('[Forms Page] Toast manager not found after', maxAttempts, 'attempts');
                        callback(); // Continue anyway with fallback alerts
                    }
                }, 100); // Check every 100ms
            }
            
            // Make the clipboard function available globally
            window.copyToClipboard = function(text) {
                console.log('[copyToClipboard] Called with:', text);
                console.log('[copyToClipboard] Toast available:', !!window.toast);
                
                if (!navigator.clipboard) {
                    console.error('[copyToClipboard] Clipboard API not available');
                    if (window.toast) {
                        window.toast.error('Clipboard not supported in this browser');
                    } else {
                        alert('Clipboard not supported in this browser');
                    }
                    return;
                }
                
                navigator.clipboard.writeText(text).then(() => {
                    console.log('[copyToClipboard] Successfully copied:', text);
                    // Show toast notification
                    if (window.toast) {
                        console.log('[copyToClipboard] Showing success toast');
                        window.toast.success('Shortcode copied to clipboard');
                    } else {
                        console.warn('[copyToClipboard] Toast not available, using alert');
                        alert('Shortcode copied to clipboard!');
                    }
                }).catch(err => {
                    console.error('[copyToClipboard] Failed:', err);
                    // Show error notification
                    if (window.toast) {
                        window.toast.error('Failed to copy to clipboard');
                    } else {
                        alert('Failed to copy to clipboard: ' + err.message);
                    }
                });
            };
            
            // Handle form deletion with feedback
            window.handleFormDelete = function(event, formTitle) {
                console.log('[handleFormDelete] Called for:', formTitle);
                console.log('[handleFormDelete] Toast available:', !!window.toast);
                
                // Show processing toast
                if (window.toast) {
                    window.toast.info('Deleting form: ' + formTitle + '...');
                } else {
                    console.log('[handleFormDelete] Toast not available yet');
                }
                
                // Allow the form to submit normally
                return true;
            };
            
            // Initialize once DOM and toast are ready
            waitForToast(() => {
                console.log('[Forms Page] Handlers initialized successfully');
                console.log('[Forms Page] copyToClipboard type:', typeof window.copyToClipboard);
                console.log('[Forms Page] handleFormDelete type:', typeof window.handleFormDelete);
                console.log('[Forms Page] Toast status:', window.toast ? 'Available' : 'Not available');
            });
        })();
    </script>
    </script>
    
    <div class="p-6">
        <header class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Forms Management</h1>
                <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">Create and manage forms for your website</p>
            </div>
            
            @can('create-forms')
            <a href="{{ route('admin.forms.create') }}" wire:navigate
                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 me-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Create New Form
            </a>
            @endcan
        </header>
        
        <div class="bg-white dark:bg-zinc-800 shadow rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                    <thead class="bg-zinc-50 dark:bg-zinc-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">ID</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">Title</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">Slug</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">Submissions</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">Last Updated</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                
                <tbody class="bg-white dark:bg-zinc-800 divide-y divide-zinc-200 dark:divide-zinc-700">
                    @forelse($forms as $form)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-700/50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">
                                {{ $form->id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-900 dark:text-white">
                                {{ $form->title }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-zinc-100 text-zinc-800 dark:bg-zinc-700 dark:text-zinc-300 font-mono">
                                    {{ $form->slug }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">
                                <a href="{{ route('admin.form-submissions.index', ['form_id' => $form->id]) }}" class="text-primary-600 hover:underline" wire:navigate>
                                    {{ $form->submissions_count ?? 0 }} submissions
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">
                                @if($form->is_active)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300">
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-zinc-100 text-zinc-800 dark:bg-zinc-700 dark:text-zinc-300">
                                        Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">
                                {{ $form->updated_at->format('M d, Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-2 rtl:space-x-reverse">
                                    @can('edit-forms')
                                    <a href="{{ route('admin.forms.edit', $form->id) }}" wire:navigate 
                                        class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                                        title="Edit Form">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                        </svg>
                                    </a>
                                    @endcan
                                    
                                    <a href="{{ route('admin.forms.show', $form->id) }}" wire:navigate
                                        class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                                        title="View Form Details">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </a>
                                    
                                    @can('delete-forms')
                                    <button type="button" 
                                        x-data="" 
                                        @click="$dispatch('modal-show', { name: 'delete-form-{{ $form->id }}' })"
                                        class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                        title="Delete Form">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                    </button>
                                    
                                    <!-- Delete Modal -->
                                    <x-modal name="delete-form-{{ $form->id }}" title="Delete Form" class="modal-fixed-width">
                                        <div class="modal-content-wrapper" style="max-width: 26rem; box-sizing: border-box;">
                                            <p class="mb-6 text-zinc-700 dark:text-zinc-300 modal-text">
                                                Are you sure you want to delete the form <strong class="font-semibold">"{{ $form->title }}"</strong>? 
                                                This will also delete all submissions associated with this form.
                                            </p>
                                            
                                            <div class="flex justify-end gap-4 flex-wrap">
                                                <button type="button" 
                                                    x-data="" 
                                                    @click="$dispatch('modal-close', { name: 'delete-form-{{ $form->id }}' })"
                                                    class="inline-flex items-center px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md shadow-sm text-sm font-medium text-zinc-700 dark:text-zinc-200 bg-white dark:bg-zinc-800 hover:bg-zinc-50 dark:hover:bg-zinc-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-zinc-500 whitespace-nowrap">
                                                    Cancel
                                                </button>
                                                
                                                <form action="{{ route('admin.forms.destroy', $form->id) }}" method="POST" onsubmit="handleFormDelete(event, '{{ $form->title }}')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 whitespace-nowrap">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                        </svg>
                                                        Delete Form
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </x-modal>
                                    @endcan
                                    
                                    <button type="button" 
                                        onclick="event.preventDefault(); console.log('Copy button clicked'); if(typeof copyToClipboard === 'function') { copyToClipboard('[form id={{ $form->id }}]'); } else { console.error('copyToClipboard function not found'); alert('Copy function not available'); }"
                                        class="inline-flex items-center px-2.5 py-1.5 border border-zinc-300 dark:border-zinc-600 rounded text-xs font-medium text-zinc-700 dark:text-zinc-200 bg-white dark:bg-zinc-800 hover:bg-zinc-50 dark:hover:bg-zinc-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-zinc-500"
                                        title="Copy Shortcode">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75L22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3l-4.5 16.5" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-8">
                                <div class="flex flex-col items-center justify-center space-y-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V19.5a2.25 2.25 0 002.25 2.25h.75m0-3h-3a2.25 2.25 0 00-2.25 2.25v.75m0-3h3m-3 3h3m1.5-12C13.806 7.5 15 8.694 15 10.125v.75M4.125 12h.75v.75H4.125v-.75z" />
                                    </svg>
                                    <p class="font-medium text-zinc-500 dark:text-zinc-400">No forms found</p>
                                    @can('create-forms')
                                    <a href="{{ route('admin.forms.create') }}" wire:navigate 
                                        class="mt-2 inline-flex items-center px-3 py-1.5 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                        Create your first form
                                    </a>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            
            <div class="px-4 py-3 border-t border-zinc-200 dark:border-zinc-700">
                {{ $forms->links() }}
            </div>
        </div>
        
        <div class="bg-white dark:bg-zinc-800 shadow rounded-lg overflow-hidden mt-6">
            <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700">
                <h3 class="text-lg font-medium text-zinc-900 dark:text-white">Using Form Shortcodes</h3>
            </div>
            <div class="px-6 py-4">
                <p class="mb-2">You can embed forms on any page using shortcodes. Click the <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 inline" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75L22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3l-4.5 16.5" /></svg> button next to a form to copy its shortcode.</p>
                <p class="mb-2">Example: <code class="bg-zinc-100 dark:bg-zinc-700 px-2 py-0.5 rounded">[form id=1]</code></p>
                <p class="font-medium mt-4 mb-2">Custom Options:</p>
                <ul class="list-disc ml-6 space-y-1">
                    <li><code class="bg-zinc-100 dark:bg-zinc-700 px-2 py-0.5 rounded">[form id=1 title="Custom Form Title"]</code> - Displays the form with a custom title</li>
                    <li><code class="bg-zinc-100 dark:bg-zinc-700 px-2 py-0.5 rounded">[form id=1 button_text="Submit Request"]</code> - Customizes the submit button text</li>
                    <li><code class="bg-zinc-100 dark:bg-zinc-700 px-2 py-0.5 rounded">[form id=1 class="my-custom-class"]</code> - Adds custom CSS classes to the form</li>
                </ul>
            </div>
        </div>
    </div>
</x-layouts.app>