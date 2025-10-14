<x-layouts.app :title="__('Form Details')">
    <div class="p-6">
        <header class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $form->title }}</h1>
                <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">{{ $form->description }}</p>
            </div>
            
            <div class="flex space-x-4">
                <a href="{{ route('admin.forms.edit', $form->id) }}" wire:navigate 
                   class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 me-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                    </svg>
                    Edit Form
                </a>
                <a href="{{ route('admin.forms.index') }}" wire:navigate
                   class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 me-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                    </svg>
                    Back to Forms
                </a>
            </div>
        </header>

        <!-- Form Details Section -->
        <div class="bg-white dark:bg-zinc-800 shadow-md border border-zinc-100 dark:border-zinc-700 rounded-lg overflow-hidden mb-8">
            <div class="p-6">
                <h2 class="text-lg font-medium text-zinc-900 dark:text-white mb-4">Form Information</h2>
                
                <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Internal Name</dt>
                        <dd class="mt-1 text-sm text-zinc-900 dark:text-white">{{ $form->name }}</dd>
                    </div>
                    
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Slug</dt>
                        <dd class="mt-1 text-sm text-zinc-900 dark:text-white">{{ $form->slug }}</dd>
                    </div>
                    
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Submit Button Text</dt>
                        <dd class="mt-1 text-sm text-zinc-900 dark:text-white">{{ $form->submit_button_text }}</dd>
                    </div>
                    
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Status</dt>
                        <dd class="mt-1 text-sm">
                            @if($form->is_active)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                                    Active
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100">
                                    Inactive
                                </span>
                            @endif
                        </dd>
                    </div>
                    
                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Success Message</dt>
                        <dd class="mt-1 text-sm text-zinc-900 dark:text-white">{{ $form->success_message }}</dd>
                    </div>
                    
                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Shortcode</dt>
                        <dd class="mt-1 text-sm">
                            <code class="inline-block px-2 py-1 font-mono text-sm rounded bg-zinc-100 text-zinc-800 dark:bg-zinc-700 dark:text-zinc-200">
                                {{ $form->shortcode }}
                            </code>
                        </dd>
                    </div>
                    
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Store Submissions</dt>
                        <dd class="mt-1 text-sm text-zinc-900 dark:text-white">
                            {{ $form->store_submissions ? 'Yes' : 'No' }}
                        </dd>
                    </div>
                    
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Requires Login</dt>
                        <dd class="mt-1 text-sm text-zinc-900 dark:text-white">
                            {{ $form->requires_login ? 'Yes' : 'No' }}
                        </dd>
                    </div>
                    
                    @if($form->send_notifications)
                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Notification Email</dt>
                        <dd class="mt-1 text-sm text-zinc-900 dark:text-white">
                            {{ $form->notification_email }}
                        </dd>
                    </div>
                    @endif
                    
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-zinc-500 dark:text-zinc-400">reCAPTCHA</dt>
                        <dd class="mt-1 text-sm text-zinc-900 dark:text-white">
                            @if($form->recaptcha_status === 'disabled')
                                Disabled
                            @else
                                Enabled ({{ strtoupper($form->recaptcha_status) }})
                            @endif
                        </dd>
                    </div>
                    
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Created</dt>
                        <dd class="mt-1 text-sm text-zinc-900 dark:text-white">
                            {{ $form->created_at->format('M d, Y') }}
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
        
        <!-- Form Fields Section -->
        <div class="bg-white dark:bg-zinc-800 shadow-md border border-zinc-100 dark:border-zinc-700 rounded-lg overflow-hidden mb-8">
            <div class="p-6">
                <h2 class="text-lg font-medium text-zinc-900 dark:text-white mb-4">Form Fields</h2>
                
                @if($form->fields->isEmpty())
                    <div class="text-center py-8">
                        <p class="text-zinc-600 dark:text-zinc-400">No fields have been added to this form yet.</p>
                        <a href="{{ route('admin.forms.edit', $form->id) }}" wire:navigate 
                           class="mt-4 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            Add Fields
                        </a>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                            <thead class="bg-zinc-50 dark:bg-zinc-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">Order</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">Label</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">Name</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">Type</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">Required</th>
                                </tr>
                            </thead>
                            
                            <tbody class="bg-white dark:bg-zinc-800 divide-y divide-zinc-200 dark:divide-zinc-700">
                                @foreach($form->fields as $field)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">
                                            {{ $field->order }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-900 dark:text-white">
                                            {{ $field->label }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">
                                            {{ $field->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100">
                                                {{ ucfirst($field->type) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">
                                            {{ $field->is_required ? 'Yes' : 'No' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Form Submissions Section -->
        <div class="bg-white dark:bg-zinc-800 shadow-md border border-zinc-100 dark:border-zinc-700 rounded-lg overflow-hidden">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-medium text-zinc-900 dark:text-white">Recent Submissions</h2>
                    
                    <div class="flex space-x-4">
                        <a href="{{ route('admin.form-submissions.index', ['form_id' => $form->id]) }}" wire:navigate
                           class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            View All Submissions
                        </a>
                    </div>
                </div>
                
                @if($form->submissions->isEmpty())
                    <div class="text-center py-8">
                        <p class="text-zinc-600 dark:text-zinc-400">No submissions yet.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                            <thead class="bg-zinc-50 dark:bg-zinc-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">ID</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">Submitted By</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">Date</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            
                            <tbody class="bg-white dark:bg-zinc-800 divide-y divide-zinc-200 dark:divide-zinc-700">
                                @foreach($form->submissions->take(5) as $submission)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">
                                            {{ $submission->id }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-900 dark:text-white">
                                            {{ $submission->user_id ? $submission->user->name : 'Guest' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">
                                            {{ $submission->created_at->format('M d, Y H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('admin.form-submissions.show', $submission->id) }}" wire:navigate
                                               class="text-primary-600 hover:text-primary-900 dark:hover:text-primary-400">
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.app>