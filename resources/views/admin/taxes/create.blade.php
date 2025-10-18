<x-layouts.app title="Create New Tax">
    <div class="p-6">
        <header class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Create New Tax</h1>
                <nav class="mt-2">
                    <ol class="flex space-x-2 text-sm text-zinc-500 dark:text-zinc-400">
                        <li><a href="{{ route('admin.taxes.index') }}" class="hover:text-zinc-700 dark:hover:text-zinc-200">Tax Management</a></li>
                        <li>/</li>
                        <li class="text-zinc-700 dark:text-zinc-300">Create</li>
                    </ol>
                </nav>
            </div>
            <a href="{{ route('admin.taxes.index') }}" 
               class="inline-flex items-center px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md shadow-sm text-sm font-medium text-zinc-700 dark:text-zinc-200 bg-white dark:bg-zinc-800 hover:bg-zinc-50 dark:hover:bg-zinc-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 me-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                Back to Taxes
            </a>
        </header>

        <div class="max-w-4xl">
            <div class="bg-white dark:bg-zinc-800 shadow rounded-lg">
                <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700">
                    <h3 class="text-lg leading-6 font-medium text-zinc-900 dark:text-white">Tax Information</h3>
                    <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Configure the basic details for your new tax.</p>
                </div>
                <div class="px-6 py-6">
                    <form action="{{ route('admin.taxes.store') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                                    Tax Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name') }}" 
                                       required
                                       class="w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('name') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">e.g., Value Added Tax, Service Tax</p>
                            </div>
                            
                            <div>
                                <label for="code" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                                    Tax Code <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="code" 
                                       name="code" 
                                       value="{{ old('code') }}" 
                                       required
                                       class="w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('code') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror">
                                @error('code')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">e.g., VAT, GST, NHIL</p>
                            </div>
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Description</label>
                            <textarea id="description" 
                                      name="description" 
                                      rows="3"
                                      class="w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('description') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="type" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                                    Tax Type <span class="text-red-500">*</span>
                                </label>
                                <select id="type" 
                                        name="type" 
                                        required
                                        class="w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('type') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror">
                                    <option value="">Select Type</option>
                                    <option value="percentage" {{ old('type') === 'percentage' ? 'selected' : '' }}>Percentage</option>
                                    <option value="fixed" {{ old('type') === 'fixed' ? 'selected' : '' }}>Fixed Amount</option>
                                </select>
                                @error('type')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="rate" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                                    Rate/Amount <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="number" 
                                           id="rate" 
                                           name="rate" 
                                           value="{{ old('rate') }}" 
                                           step="0.01" 
                                           min="0" 
                                           required
                                           class="w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500 pr-12 @error('rate') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror">
                                    <span class="absolute inset-y-0 right-0 flex items-center pr-3 text-zinc-500 dark:text-zinc-400" id="rate-suffix">%</span>
                                </div>
                                @error('rate')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">For percentage: enter value like 15 for 15%</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="sort_order" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Sort Order</label>
                                <input type="number" 
                                       id="sort_order" 
                                       name="sort_order" 
                                       value="{{ old('sort_order', 0) }}" 
                                       min="0"
                                       class="w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('sort_order') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror">
                                @error('sort_order')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Lower numbers appear first</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Options</label>
                                <div class="space-y-3">
                                    <div class="flex items-center">
                                        <input type="checkbox" 
                                               id="is_active" 
                                               name="is_active" 
                                               value="1" 
                                               {{ old('is_active', true) ? 'checked' : '' }}
                                               class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-zinc-300 dark:border-zinc-600 rounded">
                                        <label for="is_active" class="ml-2 block text-sm text-zinc-900 dark:text-white">
                                            Active
                                        </label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" 
                                               id="is_default" 
                                               name="is_default" 
                                               value="1" 
                                               {{ old('is_default') ? 'checked' : '' }}
                                               class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-zinc-300 dark:border-zinc-600 rounded">
                                        <label for="is_default" class="ml-2 block text-sm text-zinc-900 dark:text-white">
                                            Default Tax (applies automatically)
                                        </label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" 
                                               id="is_inclusive" 
                                               name="is_inclusive" 
                                               value="1" 
                                               {{ old('is_inclusive') ? 'checked' : '' }}
                                               class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-zinc-300 dark:border-zinc-600 rounded">
                                        <label for="is_inclusive" class="ml-2 block text-sm text-zinc-900 dark:text-white">
                                                    Tax Inclusive (already included in price)
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end space-x-3 px-6 py-4 bg-zinc-50 dark:bg-zinc-700 border-t border-zinc-200 dark:border-zinc-600">
                            <a href="{{ route('admin.taxes.index') }}" 
                               class="px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md shadow-sm text-sm font-medium text-zinc-700 dark:text-zinc-200 bg-white dark:bg-zinc-800 hover:bg-zinc-50 dark:hover:bg-zinc-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 me-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z" />
                                </svg>
                                Create Tax
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Help Sidebar -->
            <div class="mt-6 max-w-4xl">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Configuration Tips -->
                    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-6">
                        <div class="flex items-center mb-4">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <h3 class="text-lg font-medium text-blue-900 dark:text-blue-100">Configuration Tips</h3>
                        </div>
                        <ul class="space-y-2 text-sm text-blue-800 dark:text-blue-200">
                            <li><strong>Tax Code:</strong> Use standard codes like VAT, GST, NHIL for easy identification.</li>
                            <li><strong>Default Taxes:</strong> Will be automatically applied to new invoices.</li>
                            <li><strong>Tax Inclusive:</strong> Check this if the tax is already included in your product prices.</li>
                            <li><strong>Sort Order:</strong> Controls the order taxes appear in lists and calculations.</li>
                        </ul>
                    </div>

                    <!-- Ghana Tax Examples -->
                    <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg p-6">
                        <div class="flex items-center mb-4">
                            <svg class="w-5 h-5 text-amber-600 dark:text-amber-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                            </svg>
                            <h3 class="text-lg font-medium text-amber-900 dark:text-amber-100">Ghana Tax Examples</h3>
                        </div>
                        <ul class="space-y-2 text-sm text-amber-800 dark:text-amber-200">
                            <li><strong>VAT:</strong> 15% (Percentage)</li>
                            <li><strong>NHIL:</strong> 2.5% (Percentage)</li>
                            <li><strong>COVID Levy:</strong> 1% (Percentage)</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Update suffix based on tax type
        const typeSelect = document.getElementById('type');
        const rateSuffix = document.getElementById('rate-suffix');
        
        if (typeSelect && rateSuffix) {
            typeSelect.addEventListener('change', function() {
                const type = this.value;
                
                if (type === 'percentage') {
                    rateSuffix.textContent = '%';
                } else if (type === 'fixed') {
                    rateSuffix.textContent = 'GHS';
                } else {
                    rateSuffix.textContent = '';
                }
            });
        }
        
        // Auto-generate code from name if empty
        const nameInput = document.getElementById('name');
        const codeInput = document.getElementById('code');
        
        if (nameInput && codeInput) {
            nameInput.addEventListener('input', function() {
                const name = this.value;
                
                if (codeInput.value === '') {
                    let code = name.toUpperCase()
                                  .replace(/[^A-Z0-9\s]/g, '')
                                  .replace(/\s+/g, '')
                                  .substring(0, 10);
                    codeInput.value = code;
                }
            });
        }
    });
    </script>
    @endpush
</x-layouts.app>