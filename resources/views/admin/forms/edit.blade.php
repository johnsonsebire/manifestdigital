<x-layouts.app :title="__('Edit Form')">
    <div class="p-6">
        <header class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Edit Form: {{ $form->name }}</h1>
                <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">Update form details and manage form fields</p>
            </div>
            
            <div>
                <a href="{{ route('admin.forms.show', $form->id) }}" wire:navigate class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 me-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                    </svg>
                    Back to Form
                </a>
            </div>
        </header>
        
        <!-- Form Details Section -->
        <div class="bg-white dark:bg-zinc-800 shadow-md border border-zinc-100 dark:border-zinc-700 rounded-lg overflow-hidden mb-8">
            <div class="p-6">
                <h2 class="text-lg font-medium text-zinc-900 dark:text-white mb-4">Form Details</h2>
                
                <form action="{{ route('admin.forms.update', $form->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Form Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $form->name) }}" required 
                                class="mt-1 block w-full border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="slug" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Slug</label>
                            <input type="text" name="slug" id="slug" value="{{ old('slug', $form->slug) }}" required 
                                class="mt-1 block w-full border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500">
                            @error('slug')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="description" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Description</label>
                            <textarea name="description" id="description" rows="3"
                                class="mt-1 block w-full border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500">{{ old('description', $form->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="submit_button_text" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Submit Button Text</label>
                            <input type="text" name="submit_button_text" id="submit_button_text" value="{{ old('submit_button_text', $form->submit_button_text) }}" 
                                class="mt-1 block w-full border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500">
                            @error('submit_button_text')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="success_message" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Success Message</label>
                            <textarea name="success_message" id="success_message" rows="2"
                                class="mt-1 block w-full border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500">{{ old('success_message', $form->success_message) }}</textarea>
                            @error('success_message')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            Update Form Details
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Form Fields Section -->
        <div class="bg-white dark:bg-zinc-800 shadow-md border border-zinc-100 dark:border-zinc-700 rounded-lg overflow-hidden">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg font-medium text-zinc-900 dark:text-white">Form Fields</h2>
                    
                    <button type="button" id="add-field-button" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 me-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Add New Field
                    </button>
                </div>
                
                <form id="fields-form" action="{{ route('admin.forms.update-fields', $form->id) }}" method="POST">
                    @csrf
                    
                    <div id="fields-container" class="space-y-6">
                        @if($form->fields->count() > 0)
                            @foreach($form->fields as $index => $field)
                                <div class="field-item bg-white dark:bg-zinc-700 border border-zinc-200 dark:border-zinc-600 p-4 rounded-lg relative shadow-sm">
                                    <button type="button" class="delete-field-button absolute top-2 right-2 text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                    
                                    <input type="hidden" name="fields[{{ $index }}][id]" value="{{ $field->id }}">
                                    
                                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                        <div>
                                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Field Label</label>
                                            <input type="text" name="fields[{{ $index }}][label]" value="{{ $field->label }}" required
                                                class="mt-1 block w-full border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500">
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Field Name</label>
                                            <input type="text" name="fields[{{ $index }}][name]" value="{{ $field->name }}" required
                                                class="mt-1 block w-full border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500">
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Field Type</label>
                                            <select name="fields[{{ $index }}][type]" class="field-type-select mt-1 block w-full border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500">
                                                <option value="text" {{ $field->type === 'text' ? 'selected' : '' }}>Text</option>
                                                <option value="email" {{ $field->type === 'email' ? 'selected' : '' }}>Email</option>
                                                <option value="tel" {{ $field->type === 'tel' ? 'selected' : '' }}>Phone</option>
                                                <option value="number" {{ $field->type === 'number' ? 'selected' : '' }}>Number</option>
                                                <option value="date" {{ $field->type === 'date' ? 'selected' : '' }}>Date</option>
                                                <option value="textarea" {{ $field->type === 'textarea' ? 'selected' : '' }}>Textarea</option>
                                                <option value="select" {{ $field->type === 'select' ? 'selected' : '' }}>Select Dropdown</option>
                                                <option value="checkbox" {{ $field->type === 'checkbox' ? 'selected' : '' }}>Checkbox</option>
                                                <option value="radio" {{ $field->type === 'radio' ? 'selected' : '' }}>Radio Buttons</option>
                                                <option value="file" {{ $field->type === 'file' ? 'selected' : '' }}>File Upload</option>
                                            </select>
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Required</label>
                                            <div class="mt-1">
                                                <label class="inline-flex items-center">
                                                    <input type="checkbox" name="fields[{{ $index }}][required]" value="1" {{ $field->required ? 'checked' : '' }}
                                                        class="rounded border-zinc-300 dark:border-zinc-600 text-primary-600 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 dark:bg-zinc-800">
                                                    <span class="ml-2 text-sm text-zinc-600 dark:text-zinc-400">This field is required</span>
                                                </label>
                                            </div>
                                        </div>
                                        
                                        <div class="md:col-span-2">
                                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Help Text</label>
                                            <input type="text" name="fields[{{ $index }}][help_text]" value="{{ $field->help_text }}"
                                                class="mt-1 block w-full border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500">
                                        </div>
                                        
                                        <div class="options-container md:col-span-2 {{ in_array($field->type, ['select', 'checkbox', 'radio']) ? '' : 'hidden' }}">
                                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Options</label>
                                            <textarea name="fields[{{ $index }}][options]" rows="3" placeholder="Enter options, one per line"
                                                class="mt-1 block w-full border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500">{{ is_array($field->options) ? implode("\n", $field->options) : $field->options }}</textarea>
                                            <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">Enter one option per line. For key-value pairs, use format "key: value".</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-8">
                                <p class="text-zinc-600 dark:text-zinc-400">No fields added yet. Click "Add New Field" to start building your form.</p>
                            </div>
                        @endif
                    </div>
                    
                    <div class="mt-6">
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            Save Form Fields
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Delete Form Section -->
        @can('delete-forms')
        <div class="mt-8 bg-white dark:bg-zinc-800 shadow-md border border-zinc-100 dark:border-zinc-700 rounded-lg overflow-hidden">
            <div class="p-6">
                <h2 class="text-lg font-medium text-zinc-900 dark:text-white mb-4">Danger Zone</h2>
                
                <div class="rounded-md bg-red-50 dark:bg-red-900/20 p-4">
                    <div class="flex">
                        <div>
                            <h3 class="text-sm font-medium text-red-800 dark:text-red-400">Delete this form</h3>
                            <div class="mt-2 text-sm text-red-700 dark:text-red-300">
                                <p>Once you delete a form, all of its data including submissions will be permanently removed. This action cannot be undone.</p>
                            </div>
                            <div class="mt-4">
                                <form action="{{ route('admin.forms.destroy', $form->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this form? This will also delete all submissions. This action cannot be undone.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        Delete this form
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endcan
    </div>
    
        <!-- Field Template for JavaScript to clone -->
    <template id="field-template">
        <div class="field-item bg-white dark:bg-zinc-700 border border-zinc-200 dark:border-zinc-600 p-4 rounded-lg relative shadow-sm">
            <button type="button" class="delete-field-button absolute top-2 right-2 text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                </svg>
            </button>
            
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Field Label</label>
                    <input type="text" name="new_fields[{INDEX}][label]" required
                        class="mt-1 block w-full border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Field Name</label>
                    <input type="text" name="new_fields[{INDEX}][name]" required
                        class="mt-1 block w-full border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Field Type</label>
                    <select name="new_fields[{INDEX}][type]" class="field-type-select mt-1 block w-full border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500">
                        <option value="text">Text</option>
                        <option value="email">Email</option>
                        <option value="tel">Phone</option>
                        <option value="number">Number</option>
                        <option value="date">Date</option>
                        <option value="textarea">Textarea</option>
                        <option value="select">Select Dropdown</option>
                        <option value="checkbox">Checkbox</option>
                        <option value="radio">Radio Buttons</option>
                        <option value="file">File Upload</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Required</label>
                    <div class="mt-1">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="new_fields[{INDEX}][required]" value="1"
                                class="rounded border-zinc-300 dark:border-zinc-600 text-primary-600 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 dark:bg-zinc-800">
                            <span class="ml-2 text-sm text-zinc-600 dark:text-zinc-400">This field is required</span>
                        </label>
                    </div>
                </div>
                
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Help Text</label>
                    <input type="text" name="new_fields[{INDEX}][help_text]"
                        class="mt-1 block w-full border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500">
                </div>
                
                <div class="options-container md:col-span-2 hidden">
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Options</label>
                    <textarea name="new_fields[{INDEX}][options]" rows="3" placeholder="Enter options, one per line"
                        class="mt-1 block w-full border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500"></textarea>
                    <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">Enter one option per line. For key-value pairs, use format "key: value".</p>
                </div>
            </div>
        </div>
    </template>    <script>
        // Create global variable to store newFieldIndex
        window.formFieldManager = {
            newFieldIndex: 1000,
            initialized: false
        };
        
        document.addEventListener('DOMContentLoaded', function() {
            // Prevent multiple initializations (for when Livewire refreshes the page)
            if (window.formFieldManager.initialized) return;
            window.formFieldManager.initialized = true;
            
            initializeFormFieldManager();
        });
        
        // Initialize the form field manager functionality
        function initializeFormFieldManager() {
            console.log('Initializing form field manager...');
            const fieldsContainer = document.getElementById('fields-container');
            const addFieldButton = document.getElementById('add-field-button');
            const fieldTemplate = document.getElementById('field-template');
            
            if (!fieldsContainer || !addFieldButton || !fieldTemplate) {
                console.error('Required elements not found');
                return;
            }
            
            // Create a new function for adding fields
            window.addNewField = function() {
                console.log('Adding new field...');
                
                // Clear "no fields" message if it exists
                const emptyMessage = fieldsContainer.querySelector('.text-center.py-8');
                if (emptyMessage) {
                    emptyMessage.remove();
                }
                
                try {
                    // Clone template
                    const newField = document.importNode(fieldTemplate.content, true);
                    
                    // Replace placeholder index in all form elements
                    const inputs = newField.querySelectorAll('input, select, textarea');
                    inputs.forEach(input => {
                        const name = input.getAttribute('name');
                        if (name) {
                            input.setAttribute('name', name.replace(/{INDEX}/g, window.formFieldManager.newFieldIndex));
                        }
                    });
                    
                    // Add to container directly from the cloned content
                    fieldsContainer.appendChild(newField);
                    
                    // Get the newly added field element
                    const fieldElement = fieldsContainer.lastElementChild;
                    
                    // Setup event listeners for the new field
                    setupFieldEvents(fieldElement);
                    
                    // Increment the index for next field
                    window.formFieldManager.newFieldIndex++;
                    
                    console.log('New field added successfully with index:', window.formFieldManager.newFieldIndex-1);
                } catch (error) {
                    console.error('Error adding new field:', error);
                    alert('Error adding new field. Please try again.');
                }
            };
            
            // Function to set up field event listeners
            function setupFieldEvents(field) {
                if (!field) return;
                
                // Delete field button
                const deleteButton = field.querySelector('.delete-field-button');
                if (deleteButton) {
                    deleteButton.addEventListener('click', function() {
                        if (confirm('Are you sure you want to remove this field?')) {
                            field.remove();
                            
                            // If no fields left, show message
                            if (fieldsContainer.querySelectorAll('.field-item').length === 0) {
                                fieldsContainer.innerHTML = '<div class="text-center py-8"><p class="text-zinc-600 dark:text-zinc-400">No fields added yet. Click "Add New Field" to start building your form.</p></div>';
                            }
                        }
                    });
                }
                
                // Field type select
                const typeSelect = field.querySelector('.field-type-select');
                const optionsContainer = field.querySelector('.options-container');
                
                if (typeSelect && optionsContainer) {
                    typeSelect.addEventListener('change', function() {
                        // Show options container only for select, checkbox and radio
                        if (['select', 'checkbox', 'radio'].includes(this.value)) {
                            optionsContainer.classList.remove('hidden');
                        } else {
                            optionsContainer.classList.add('hidden');
                        }
                    });
                }
            }
            
            // Add field button click - use inline onclick attribute for better compatibility
            addFieldButton.setAttribute('onclick', 'window.addNewField()');
            
            // Set up existing fields
            document.querySelectorAll('.field-item').forEach(setupFieldEvents);
            
            console.log('Form field management initialized successfully');
        }
    </script>
</x-layouts.app>