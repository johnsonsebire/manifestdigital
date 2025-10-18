<x-layouts.app title="Regional Tax Configuration">
    <div class="p-6">
        <header class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Regional Tax Configuration</h1>
                <nav class="flex mt-2" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('admin.taxes.index') }}" class="inline-flex items-center text-sm font-medium text-zinc-700 hover:text-blue-600 dark:text-zinc-400 dark:hover:text-white">
                                Tax Management
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-3 h-3 text-zinc-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                                </svg>
                                <span class="ml-1 text-sm font-medium text-zinc-500 md:ml-2 dark:text-zinc-400">Regional Configuration</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>
            
            <div class="flex gap-3">
                <button type="button" 
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                        onclick="openAddModal()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 me-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Add Regional Tax
                </button>
                
                <a href="{{ route('admin.taxes.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md shadow-sm text-sm font-medium text-zinc-700 dark:text-zinc-200 bg-white dark:bg-zinc-800 hover:bg-zinc-50 dark:hover:bg-zinc-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 me-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                    </svg>
                    Back to Taxes
                </a>
            </div>
        </header>

        <!-- Success/Error Messages -->
        <div class="space-y-4 mb-6">
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg dark:bg-green-900/50 dark:border-green-800 dark:text-green-200">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg dark:bg-red-900/50 dark:border-red-800 dark:text-red-200">
                    {{ session('error') }}
                </div>
            @endif
        </div>

        <!-- Regional Tax Configurations -->
        <div class="bg-white dark:bg-zinc-800 shadow rounded-lg overflow-hidden">
            @if($regionalTaxes->count() > 0)
                <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg leading-6 font-medium text-zinc-900 dark:text-white">
                            Regional Tax Configurations ({{ $regionalTaxes->count() }})
                        </h3>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                            {{ $regionalTaxes->where('is_applicable', true)->count() }} Active
                        </span>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                        <thead class="bg-zinc-50 dark:bg-zinc-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">Tax</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">Country</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">Currency</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">Rate Override</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">Priority</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-300 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-zinc-800 divide-y divide-zinc-200 dark:divide-zinc-700">
                            @foreach($regionalTaxes as $regionalTax)
                                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-700/50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-zinc-900 dark:text-white">{{ $regionalTax->tax->name }}</div>
                                        <div class="text-sm text-zinc-500 dark:text-zinc-400">
                                            <code class="px-1 py-0.5 text-xs bg-zinc-100 dark:bg-zinc-700 rounded">{{ $regionalTax->tax->code }}</code>
                                            - Default: {{ number_format($regionalTax->tax->rate, 2) }}%
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($regionalTax->country_code)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-zinc-100 text-zinc-800 dark:bg-zinc-700 dark:text-zinc-300">
                                                {{ $regionalTax->country_code }}
                                            </span>
                                        @else
                                            <span class="text-sm text-zinc-500 dark:text-zinc-400 italic">All Countries</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($regionalTax->currency)
                                            <div class="text-sm font-medium text-zinc-900 dark:text-white">{{ $regionalTax->currency->code }}</div>
                                            <div class="text-sm text-zinc-500 dark:text-zinc-400">{{ $regionalTax->currency->name }}</div>
                                        @else
                                            <span class="text-sm text-zinc-500 dark:text-zinc-400 italic">All Currencies</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($regionalTax->rate_override !== null)
                                            <div class="text-sm font-medium text-amber-600 dark:text-amber-400">
                                                {{ number_format($regionalTax->rate_override, 2) }}%
                                            </div>
                                            <div class="text-xs text-zinc-500 dark:text-zinc-400">
                                                Override from {{ number_format($regionalTax->tax->rate, 2) }}%
                                            </div>
                                        @else
                                            <span class="text-sm text-zinc-500 dark:text-zinc-400 italic">Use default rate</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                                            {{ $regionalTax->priority }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($regionalTax->is_applicable)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300">Active</span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-3">
                                        <button type="button" 
                                                class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300"
                                                onclick="editRegionalTax({{ json_encode($regionalTax) }})"
                                                title="Edit Regional Tax">
                                            Edit
                                        </button>
                                        <form action="{{ route('admin.taxes.regional.destroy', $regionalTax) }}" 
                                              method="POST" 
                                              class="inline"
                                              onsubmit="return confirm('Are you sure you want to delete this regional tax configuration?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
                                                    title="Delete Regional Tax">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <!-- Empty State -->
                <div class="px-6 py-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-zinc-400 dark:text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <h3 class="mt-4 text-sm font-medium text-zinc-900 dark:text-white">No Regional Configurations</h3>
                    <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">Configure different tax rates for specific countries or currencies.</p>
                    <div class="mt-6">
                        <button type="button" 
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                                onclick="openAddModal()">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 me-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Add First Regional Configuration
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Backdrop -->
    <div id="modalBackdrop" class="fixed inset-0 bg-zinc-600 bg-opacity-50 overflow-y-auto h-full w-full z-40 hidden"></div>

    <!-- Add/Edit Regional Tax Modal -->
    <div id="regionalTaxModal" class="fixed inset-0 z-50 overflow-y-auto hidden">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="inline-block align-bottom bg-white dark:bg-zinc-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form id="regionalTaxForm" action="{{ route('admin.taxes.regional.store') }}" method="POST">
                    @csrf
                    <div class="bg-white dark:bg-zinc-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="w-full">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-lg leading-6 font-medium text-zinc-900 dark:text-white" id="modalTitle">
                                        Add Regional Tax Configuration
                                    </h3>
                                    <button type="button" 
                                            class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300"
                                            onclick="closeModal()">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="tax_id" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                                            Tax <span class="text-red-500">*</span>
                                        </label>
                                        <select id="tax_id" 
                                                name="tax_id" 
                                                required
                                                class="w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                            <option value="">Select Tax</option>
                                            @foreach($taxes as $tax)
                                                <option value="{{ $tax->id }}">
                                                    {{ $tax->name }} ({{ $tax->code }}) - {{ number_format($tax->rate, 2) }}%
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div>
                                        <label for="priority" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                                            Priority <span class="text-red-500">*</span>
                                        </label>
                                        <input type="number" 
                                               id="priority" 
                                               name="priority" 
                                               value="10" 
                                               min="0" 
                                               required
                                               class="w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                        <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Higher numbers = higher priority</p>
                                    </div>

                                    <div>
                                        <label for="country_code" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Country Code</label>
                                        <input type="text" 
                                               id="country_code" 
                                               name="country_code" 
                                               maxlength="2" 
                                               placeholder="e.g., GH, US"
                                               class="w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                        <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Leave empty for all countries</p>
                                    </div>

                                    <div>
                                        <label for="currency_id" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Currency</label>
                                        <select id="currency_id" 
                                                name="currency_id"
                                                class="w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                            <option value="">All Currencies</option>
                                            @foreach($currencies as $currency)
                                                <option value="{{ $currency->id }}">
                                                    {{ $currency->code }} - {{ $currency->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div>
                                        <label for="rate_override" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Rate Override (%)</label>
                                        <input type="number" 
                                               id="rate_override" 
                                               name="rate_override" 
                                               step="0.01" 
                                               min="0"
                                               class="w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                        <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Leave empty to use default rate</p>
                                    </div>

                                    <div>
                                        <label for="is_inclusive" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Tax Inclusive Override</label>
                                        <select id="is_inclusive" 
                                                name="is_inclusive"
                                                class="w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                            <option value="">Use Default Setting</option>
                                            <option value="1">Inclusive</option>
                                            <option value="0">Exclusive</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <div class="flex items-center">
                                        <input type="checkbox" 
                                               id="is_applicable" 
                                               name="is_applicable" 
                                               value="1" 
                                               checked
                                               class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-zinc-300 dark:border-zinc-600 rounded">
                                        <label for="is_applicable" class="ml-2 block text-sm text-zinc-900 dark:text-white">
                                            Active
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-zinc-50 dark:bg-zinc-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" 
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary-600 text-base font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:ml-3 sm:w-auto sm:text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 me-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z" />
                            </svg>
                            Save Configuration
                        </button>
                        <button type="button" 
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-zinc-300 dark:border-zinc-600 shadow-sm px-4 py-2 bg-white dark:bg-zinc-800 text-base font-medium text-zinc-700 dark:text-zinc-200 hover:bg-zinc-50 dark:hover:bg-zinc-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                                onclick="closeModal()">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function openAddModal() {
            document.getElementById('modalTitle').textContent = 'Add Regional Tax Configuration';
            document.getElementById('regionalTaxForm').action = '{{ route('admin.taxes.regional.store') }}';
            
            // Remove any existing method input
            const methodInput = document.querySelector('input[name="_method"]');
            if (methodInput) {
                methodInput.remove();
            }
            
            // Reset form
            document.getElementById('regionalTaxForm').reset();
            document.getElementById('is_applicable').checked = true;
            
            showModal();
        }

        function editRegionalTax(regionalTax) {
            document.getElementById('modalTitle').textContent = 'Edit Regional Tax Configuration';
            
            // Update form action and add method
            const form = document.getElementById('regionalTaxForm');
            form.action = '{{ route('admin.taxes.regional.store') }}'.replace('taxes/regional', 'taxes/regional/' + regionalTax.id);
            
            // Remove existing method input and add PUT method
            const existingMethod = form.querySelector('input[name="_method"]');
            if (existingMethod) {
                existingMethod.remove();
            }
            
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'PUT';
            form.appendChild(methodInput);
            
            // Populate form fields
            document.getElementById('tax_id').value = regionalTax.tax_id;
            document.getElementById('country_code').value = regionalTax.country_code || '';
            document.getElementById('currency_id').value = regionalTax.currency_id || '';
            document.getElementById('rate_override').value = regionalTax.rate_override || '';
            document.getElementById('is_inclusive').value = regionalTax.is_inclusive !== null ? regionalTax.is_inclusive : '';
            document.getElementById('priority').value = regionalTax.priority;
            document.getElementById('is_applicable').checked = regionalTax.is_applicable;
            
            showModal();
        }

        function showModal() {
            document.getElementById('modalBackdrop').classList.remove('hidden');
            document.getElementById('regionalTaxModal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function closeModal() {
            document.getElementById('modalBackdrop').classList.add('hidden');
            document.getElementById('regionalTaxModal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        // Close modal when clicking backdrop
        document.getElementById('modalBackdrop').addEventListener('click', closeModal);

        // Close modal with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeModal();
            }
        });
    </script>
    @endpush
</x-layouts.app>