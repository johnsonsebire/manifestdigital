<x-layouts.app title="Add Customer">
    <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <flux:breadcrumbs>
                <flux:breadcrumbs.item href="{{ route('admin.customers.index') }}">Customers</flux:breadcrumbs.item>
                <flux:breadcrumbs.item>Add Customer</flux:breadcrumbs.item>
            </flux:breadcrumbs>
            <h1 class="mt-2 text-2xl font-semibold text-zinc-900 dark:text-white">Add New Customer</h1>
            <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">Create a registered customer account</p>
        </div>

        <!-- Form -->
        <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
            <form action="{{ route('admin.customers.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <div>
                    <flux:label for="name">Full Name *</flux:label>
                    <flux:input 
                        type="text" 
                        name="name" 
                        id="name"
                        value="{{ old('name') }}"
                        required
                    />
                    <flux:error name="name" />
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <flux:label for="email">Email Address *</flux:label>
                        <flux:input 
                            type="email" 
                            name="email" 
                            id="email"
                            value="{{ old('email') }}"
                            required
                        />
                        <flux:error name="email" />
                    </div>
                    
                    <div>
                        <flux:label for="phone">Phone Number</flux:label>
                        <flux:input 
                            type="text" 
                            name="phone" 
                            id="phone"
                            value="{{ old('phone') }}"
                        />
                        <flux:error name="phone" />
                    </div>
                </div>
                
                <div>
                    <flux:label for="company">Company Name</flux:label>
                    <flux:input 
                        type="text" 
                        name="company" 
                        id="company"
                        value="{{ old('company') }}"
                    />
                    <flux:error name="company" />
                </div>
                
                <div>
                    <flux:label for="address">Address</flux:label>
                    <flux:textarea 
                        name="address" 
                        id="address"
                        rows="3"
                    >{{ old('address') }}</flux:textarea>
                    <flux:error name="address" />
                </div>
                
                <div>
                    <flux:label for="password">Password *</flux:label>
                    <flux:input 
                        type="password" 
                        name="password" 
                        id="password"
                        required
                    />
                    <flux:error name="password" />
                    <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">
                        Minimum 8 characters. The customer can change this after logging in.
                    </p>
                </div>
                
                <div class="flex gap-2">
                    <flux:button type="submit" variant="primary">Create Customer</flux:button>
                    <a href="{{ route('admin.customers.index') }}">
                        <flux:button type="button" variant="ghost">Cancel</flux:button>
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
