<x-layouts.app title="Edit Customer">
    <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <flux:breadcrumbs>
                <flux:breadcrumbs.item href="{{ route('admin.customers.index') }}">Customers</flux:breadcrumbs.item>
                <flux:breadcrumbs.item href="{{ route('admin.customers.show', $customer) }}">{{ $customer->name }}</flux:breadcrumbs.item>
                <flux:breadcrumbs.item>Edit</flux:breadcrumbs.item>
            </flux:breadcrumbs>
            <h1 class="mt-2 text-2xl font-semibold text-zinc-900 dark:text-white">Edit Customer</h1>
            <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">Update customer account information</p>
        </div>

        <!-- Form -->
        <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
            <form action="{{ route('admin.customers.update', $customer) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                
                <div>
                    <flux:label for="name">Full Name *</flux:label>
                    <flux:input 
                        type="text" 
                        name="name" 
                        id="name"
                        value="{{ old('name', $customer->name) }}"
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
                            value="{{ old('email', $customer->email) }}"
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
                            value="{{ old('phone', $customer->phone) }}"
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
                        value="{{ old('company', $customer->company) }}"
                    />
                    <flux:error name="company" />
                </div>
                
                <div>
                    <flux:label for="address">Address</flux:label>
                    <flux:textarea 
                        name="address" 
                        id="address"
                        rows="3"
                    >{{ old('address', $customer->address) }}</flux:textarea>
                    <flux:error name="address" />
                </div>
                
                <div class="border-t border-zinc-200 dark:border-zinc-700 pt-6">
                    <h3 class="text-sm font-medium text-zinc-900 dark:text-white mb-4">Change Password</h3>
                    <div>
                        <flux:label for="password">New Password</flux:label>
                        <flux:input 
                            type="password" 
                            name="password" 
                            id="password"
                        />
                        <flux:error name="password" />
                        <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">
                            Leave blank to keep current password. Minimum 8 characters if changing.
                        </p>
                    </div>
                </div>
                
                <div class="flex justify-between items-center pt-6 border-t border-zinc-200 dark:border-zinc-700">
                    <form action="{{ route('admin.customers.destroy', $customer) }}" method="POST" onsubmit="return confirm('Are you sure you want to deactivate this customer?');">
                        @csrf
                        @method('DELETE')
                        <flux:button type="submit" variant="danger">Deactivate Customer</flux:button>
                    </form>
                    
                    <div class="flex gap-2">
                        <a href="{{ route('admin.customers.show', $customer) }}">
                            <flux:button type="button" variant="ghost">Cancel</flux:button>
                        </a>
                        <flux:button type="submit" variant="primary">Update Customer</flux:button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
