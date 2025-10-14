<x-layouts.app :title="__('Form Details')">
    <div class="p-6">
        <header class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $form->name }}</h1>
                <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">
                    Form details and fields
                </p>
            </div>
            
            <div class="flex space-x-2">
                @can('update-forms')
                <a href="{{ route('admin.forms.edit', $form->id) }}" wire:navigate class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 me-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                    </svg>
                    Edit Form
                </a>
                @endcan
                
                @can('view-form-submissions')
                <a href="{{ route('admin.form-submissions.form', $form->id) }}" wire:navigate class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 me-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V19.5a2.25 2.25 0 0 0 2.25 2.25h.75m0 0h4.5m-4.5 0v-1.5c0-.415.336-.75.75-.75h3a.75.75 0 0 1 .75.75v1.5m-4.5 0h4.5" />
                    </svg>
                    View Submissions
                </a>
                @endcan
            </div>
        </header>
        
        <div class="mt-8">
            <h2 class="text-lg font-medium text-zinc-900 dark:text-white mb-4">Form Details</h2>
            <div class="bg-white dark:bg-zinc-800 shadow rounded-lg overflow-hidden">
                <div class="px-4 py-5 sm:p-6">
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                        <div>
                            <dt class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Form Name</dt>
                            <dd class="mt-1 text-sm text-zinc-900 dark:text-white">{{ $form->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Description</dt>
                            <dd class="mt-1 text-sm text-zinc-900 dark:text-white">{{ $form->description ?: 'No description' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Slug</dt>
                            <dd class="mt-1 text-sm text-zinc-900 dark:text-white">{{ $form->slug }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Created</dt>
                            <dd class="mt-1 text-sm text-zinc-900 dark:text-white">{{ $form->created_at->format('M d, Y H:i') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Last Updated</dt>
                            <dd class="mt-1 text-sm text-zinc-900 dark:text-white">{{ $form->updated_at->format('M d, Y H:i') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Submission Count</dt>
                            <dd class="mt-1 text-sm text-zinc-900 dark:text-white">{{ $form->submissions_count ?? 0 }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
        
        <div class="mt-8">
            <h2 class="text-lg font-medium text-zinc-900 dark:text-white mb-4">Form Fields</h2>
            @if($form->fields->count() > 0)
                <div class="bg-white dark:bg-zinc-800 shadow rounded-lg overflow-hidden">
                    <ul class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        @foreach($form->fields as $field)
                            <li class="px-4 py-4 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-sm font-medium text-zinc-900 dark:text-white">{{ $field->label }}</h3>
                                        <div class="mt-1 flex items-center">
                                            <span class="px-2 inline-flex text-xs leading-5 font-medium rounded-full bg-zinc-100 text-zinc-800 dark:bg-zinc-700 dark:text-zinc-200">
                                                {{ ucfirst($field->type) }}
                                            </span>
                                            @if($field->required)
                                                <span class="ml-2 px-2 inline-flex text-xs leading-5 font-medium rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                                    Required
                                                </span>
                                            @endif
                                        </div>
                                        @if($field->help_text)
                                            <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">
                                                {{ $field->help_text }}
                                            </p>
                                        @endif
                                    </div>
                                    <div class="text-sm text-zinc-500 dark:text-zinc-400">
                                        {{ $field->name }}
                                    </div>
                                </div>
                                @if($field->options)
                                    <div class="mt-2 text-xs text-zinc-500 dark:text-zinc-400">
                                        <span class="font-medium">Options:</span> 
                                        @if(is_array($field->options))
                                            {{ implode(', ', $field->options) }}
                                        @else
                                            {{ $field->options }}
                                        @endif
                                    </div>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            @else
                <div class="bg-white dark:bg-zinc-800 shadow rounded-lg overflow-hidden p-6 text-center">
                    <p class="text-zinc-600 dark:text-zinc-400">No fields have been added to this form yet.</p>
                    @can('update-forms')
                        <div class="mt-4">
                            <a href="{{ route('admin.forms.edit', $form->id) }}" wire:navigate class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 me-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                Add Fields
                            </a>
                        </div>
                    @endcan
                </div>
            @endif
        </div>
        
        <div class="mt-8">
            <h2 class="text-lg font-medium text-zinc-900 dark:text-white mb-4">Embed Code</h2>
            <div class="bg-white dark:bg-zinc-800 shadow rounded-lg overflow-hidden">
                <div class="px-4 py-5 sm:p-6">
                    <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-4">
                        Use the shortcode below to embed this form in your content:
                    </p>
                    <div class="bg-zinc-100 dark:bg-zinc-700 rounded-md p-3 font-mono text-sm">
                        [form id="{{ $form->id }}"]
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>