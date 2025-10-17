<x-layouts.app title="Settings">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-zinc-900 dark:text-white">Settings</h1>
            <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">Manage your company and invoice settings</p>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <!-- Settings Tabs -->
        <div class="mb-6">
            <div class="border-b border-zinc-200 dark:border-zinc-700">
                <nav class="-mb-px flex space-x-8">
                    <button 
                        onclick="showTab('company')" 
                        id="company-tab"
                        class="tab-button border-b-2 border-blue-500 py-4 px-1 text-sm font-medium text-blue-600 dark:text-blue-400"
                    >
                        Company Information
                    </button>
                    <button 
                        onclick="showTab('invoice')" 
                        id="invoice-tab"
                        class="tab-button border-b-2 border-transparent py-4 px-1 text-sm font-medium text-zinc-500 hover:text-zinc-700 hover:border-zinc-300 dark:text-zinc-400 dark:hover:text-zinc-300"
                    >
                        Invoice Settings
                    </button>
                </nav>
            </div>
        </div>

        <!-- Company Settings Form -->
        <div id="company-content" class="tab-content">
            <form method="POST" action="{{ route('admin.settings.company.update') }}" class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                @csrf
                <div class="space-y-6">
                    <div>
                        <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-4">Company Information</h3>
                        <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-6">
                            This information will appear on your invoices and other documents.
                        </p>
                    </div>

                    <!-- Company Name -->
                    <div>
                        <label for="company_name" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                            Company Name <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="company_name" 
                            id="company_name" 
                            value="{{ old('company_name', $companySettings['company_name']->value ?? '') }}"
                            required
                            class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-700 dark:text-white"
                        >
                        @error('company_name')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div>
                        <label for="company_address" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                            Street Address
                        </label>
                        <input 
                            type="text" 
                            name="company_address" 
                            id="company_address" 
                            value="{{ old('company_address', $companySettings['company_address']->value ?? '') }}"
                            placeholder="123 Business Street"
                            class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-700 dark:text-white"
                        >
                    </div>

                    <!-- City, State, ZIP -->
                    <div>
                        <label for="company_city_state_zip" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                            City, State, ZIP
                        </label>
                        <input 
                            type="text" 
                            name="company_city_state_zip" 
                            id="company_city_state_zip" 
                            value="{{ old('company_city_state_zip', $companySettings['company_city_state_zip']->value ?? '') }}"
                            placeholder="City, State 12345"
                            class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-700 dark:text-white"
                        >
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="company_email" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                            Email Address <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="email" 
                            name="company_email" 
                            id="company_email" 
                            value="{{ old('company_email', $companySettings['company_email']->value ?? '') }}"
                            required
                            placeholder="contact@company.com"
                            class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-700 dark:text-white"
                        >
                        @error('company_email')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="company_phone" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                            Phone Number
                        </label>
                        <input 
                            type="text" 
                            name="company_phone" 
                            id="company_phone" 
                            value="{{ old('company_phone', $companySettings['company_phone']->value ?? '') }}"
                            placeholder="(123) 456-7890"
                            class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-700 dark:text-white"
                        >
                    </div>

                    <!-- Website -->
                    <div>
                        <label for="company_website" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                            Website
                        </label>
                        <input 
                            type="text" 
                            name="company_website" 
                            id="company_website" 
                            value="{{ old('company_website', $companySettings['company_website']->value ?? '') }}"
                            placeholder="www.yourcompany.com"
                            class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-700 dark:text-white"
                        >
                    </div>

                    <!-- Tax ID -->
                    <div>
                        <label for="company_tax_id" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                            Tax ID / EIN
                        </label>
                        <input 
                            type="text" 
                            name="company_tax_id" 
                            id="company_tax_id" 
                            value="{{ old('company_tax_id', $companySettings['company_tax_id']->value ?? '') }}"
                            placeholder="12-3456789"
                            class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-700 dark:text-white"
                        >
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end pt-4 border-t border-zinc-200 dark:border-zinc-700">
                        <button 
                            type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-500/50 transition"
                        >
                            Save Company Settings
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Invoice Settings Form -->
        <div id="invoice-content" class="tab-content hidden">
            <form method="POST" action="{{ route('admin.settings.invoice.update') }}" class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
                @csrf
                <div class="space-y-6">
                    <div>
                        <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-4">Invoice Settings</h3>
                        <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-6">
                            Customize how your invoices look and what information they display.
                        </p>
                    </div>

                    <!-- Invoice Prefix -->
                    <div>
                        <label for="invoice_prefix" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                            Invoice Number Prefix <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="invoice_prefix" 
                            id="invoice_prefix" 
                            value="{{ old('invoice_prefix', $invoiceSettings['invoice_prefix']->value ?? 'INV') }}"
                            required
                            maxlength="10"
                            placeholder="INV"
                            class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-700 dark:text-white"
                        >
                        <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">
                            This prefix will be added before invoice numbers (e.g., INV-001)
                        </p>
                        @error('invoice_prefix')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Invoice Footer Note -->
                    <div>
                        <label for="invoice_footer_note" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                            Footer Note
                        </label>
                        <textarea 
                            name="invoice_footer_note" 
                            id="invoice_footer_note" 
                            rows="3"
                            placeholder="If you have any questions about this invoice, please contact us..."
                            class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-700 dark:text-white"
                        >{{ old('invoice_footer_note', $invoiceSettings['invoice_footer_note']->value ?? '') }}</textarea>
                        <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">
                            This note will appear at the bottom of all invoices
                        </p>
                    </div>

                    <!-- Invoice Terms -->
                    <div>
                        <label for="invoice_terms" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                            Payment Terms
                        </label>
                        <textarea 
                            name="invoice_terms" 
                            id="invoice_terms" 
                            rows="3"
                            placeholder="Payment is due within 30 days. Thank you for your business!"
                            class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-700 dark:text-white"
                        >{{ old('invoice_terms', $invoiceSettings['invoice_terms']->value ?? '') }}</textarea>
                        <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">
                            Payment terms and conditions for your invoices
                        </p>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end pt-4 border-t border-zinc-200 dark:border-zinc-700">
                        <button 
                            type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-500/50 transition"
                        >
                            Save Invoice Settings
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });
            
            // Remove active state from all tabs
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('border-blue-500', 'text-blue-600', 'dark:text-blue-400');
                button.classList.add('border-transparent', 'text-zinc-500', 'dark:text-zinc-400');
            });
            
            // Show selected tab content
            document.getElementById(tabName + '-content').classList.remove('hidden');
            
            // Add active state to selected tab
            const activeButton = document.getElementById(tabName + '-tab');
            activeButton.classList.add('border-blue-500', 'text-blue-600', 'dark:text-blue-400');
            activeButton.classList.remove('border-transparent', 'text-zinc-500', 'dark:text-zinc-400');
        }
    </script>
</x-layouts.app>
