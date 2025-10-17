<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creating comprehensive permissions...');
        
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            // User management
            'view-users',
            'create-users',
            'edit-users',
            'delete-users',
            
            // Role management
            'view-roles',
            'create-roles',
            'edit-roles',
            'delete-roles',
            'assign-roles',
            
            // Dashboard access
            'access-dashboard',
            'access-admin-panel',
            
            // Orders
            'view-orders',
            'create-orders',
            'edit-orders',
            'delete-orders',
            'manage-orders',
            'view-own-orders',
            'cancel-orders',
            'update-order-status',
            
            // Invoices
            'view-invoices',
            'create-invoices',
            'edit-invoices',
            'delete-invoices',
            'manage-invoices',
            'view-own-invoices',
            'send-invoices',
            'record-invoice-payments',
            'export-invoices',
            
            // Projects
            'view-projects',
            'create-projects',
            'edit-projects',
            'delete-projects',
            'manage-projects',
            'view-own-projects',
            'update-project-status',
            'manage-project-tasks',
            'manage-project-files',
            'manage-project-messages',
            
            // Services
            'view-services',
            'create-services',
            'edit-services',
            'delete-services',
            'manage-services',
            
            // Categories
            'view-categories',
            'create-categories',
            'edit-categories',
            'delete-categories',
            'manage-categories',
            
            // Forms
            'view-forms',
            'create-forms',
            'edit-forms',
            'delete-forms',
            'manage-forms',
            'update-forms',
            
            // Form Submissions
            'view-form-submissions',
            'create-form-submissions',
            'edit-form-submissions',
            'delete-form-submissions',
            'manage-form-submissions',
            'export-form-submissions',
            
            // Change Requests
            'view-change-requests',
            'create-change-requests',
            'edit-change-requests',
            'delete-change-requests',
            'approve-change-requests',
            'reject-change-requests',
            
            // Reports & Analytics
            'view-reports',
            'view-analytics',
            'export-reports',
            
            // Notifications
            'view-notifications',
            'manage-notifications',
            
            // Settings
            'manage-settings',
            'view-settings',
        ];

        foreach ($permissions as $permissionName) {
            Permission::firstOrCreate([
                'name' => $permissionName,
                'guard_name' => 'web'
            ]);
            
            $this->command->info("Created permission: {$permissionName}");
        }

        $this->command->info('Permissions created successfully!');
        
        // Assign permissions to roles
        $this->assignPermissionsToRoles();
    }

    /**
     * Assign permissions to roles
     */
    private function assignPermissionsToRoles(): void
    {
        $this->command->info('Assigning permissions to roles...');

        // Super Admin gets all permissions
        $superAdmin = Role::where('name', 'Super Admin')->first();
        if ($superAdmin) {
            $superAdmin->syncPermissions(Permission::all());
            $this->command->info('✓ Assigned all permissions to Super Admin');
        }

        // Administrator gets most permissions except user/role management
        $administrator = Role::where('name', 'Administrator')->first();
        if ($administrator) {
            $adminPermissions = Permission::whereIn('name', [
                'access-dashboard',
                'access-admin-panel',
                'view-orders', 'create-orders', 'edit-orders', 'manage-orders', 'update-order-status', 'cancel-orders',
                'view-invoices', 'create-invoices', 'edit-invoices', 'manage-invoices', 'send-invoices', 'record-invoice-payments', 'export-invoices',
                'view-projects', 'create-projects', 'edit-projects', 'manage-projects', 'update-project-status', 'manage-project-tasks', 'manage-project-files', 'manage-project-messages',
                'view-services', 'create-services', 'edit-services', 'manage-services',
                'view-categories', 'create-categories', 'edit-categories', 'manage-categories',
                'view-forms', 'create-forms', 'edit-forms', 'manage-forms', 'update-forms',
                'view-form-submissions', 'manage-form-submissions', 'export-form-submissions',
                'view-change-requests', 'create-change-requests', 'edit-change-requests', 'approve-change-requests', 'reject-change-requests',
                'view-reports', 'view-analytics', 'export-reports',
                'view-notifications',
                'view-settings',
            ])->get();
            $administrator->syncPermissions($adminPermissions);
            $this->command->info('✓ Assigned admin permissions to Administrator');
        }

        // Finance Manager
        $financeManager = Role::where('name', 'Finance Manager')->first();
        if ($financeManager) {
            $financePermissions = Permission::whereIn('name', [
                'access-dashboard',
                'access-admin-panel',
                'view-orders', 'update-order-status',
                'view-invoices', 'create-invoices', 'edit-invoices', 'manage-invoices', 'send-invoices', 'record-invoice-payments', 'export-invoices',
                'view-projects',
                'view-reports', 'view-analytics', 'export-reports',
                'view-notifications',
            ])->get();
            $financeManager->syncPermissions($financePermissions);
            $this->command->info('✓ Assigned finance permissions to Finance Manager');
        }

        // Staff
        $staff = Role::where('name', 'Staff')->first();
        if ($staff) {
            $staffPermissions = Permission::whereIn('name', [
                'access-dashboard',
                'access-admin-panel',
                'view-orders', 'create-orders', 'edit-orders',
                'view-invoices',
                'view-projects', 'create-projects', 'edit-projects', 'manage-project-tasks', 'manage-project-files', 'manage-project-messages',
                'view-services', 'view-categories',
                'view-forms', 'view-form-submissions', 'export-form-submissions',
                'view-change-requests', 'create-change-requests',
                'view-reports',
                'view-notifications',
            ])->get();
            $staff->syncPermissions($staffPermissions);
            $this->command->info('✓ Assigned staff permissions to Staff');
        }

        // Customer
        $customer = Role::where('name', 'Customer')->first();
        if ($customer) {
            $customerPermissions = Permission::whereIn('name', [
                'access-dashboard',
                'view-own-orders',
                'view-own-invoices',
                'view-own-projects',
                'create-form-submissions',
                'create-change-requests',
                'view-notifications',
            ])->get();
            $customer->syncPermissions($customerPermissions);
            $this->command->info('✓ Assigned customer permissions to Customer');
        }

        // Partner
        $partner = Role::where('name', 'Partner')->first();
        if ($partner) {
            $partnerPermissions = Permission::whereIn('name', [
                'access-dashboard',
                'view-orders', 'create-orders',
                'view-invoices',
                'view-projects', 'create-projects',
                'view-services', 'view-categories',
                'view-reports',
                'view-notifications',
            ])->get();
            $partner->syncPermissions($partnerPermissions);
            $this->command->info('✓ Assigned partner permissions to Partner');
        }

        // Affiliate
        $affiliate = Role::where('name', 'Affiliate')->first();
        if ($affiliate) {
            $affiliatePermissions = Permission::whereIn('name', [
                'access-dashboard',
                'view-orders', 'create-orders',
                'view-services', 'view-categories',
                'view-notifications',
            ])->get();
            $affiliate->syncPermissions($affiliatePermissions);
            $this->command->info('✓ Assigned affiliate permissions to Affiliate');
        }

        // Student
        $student = Role::where('name', 'Student')->first();
        if ($student) {
            $studentPermissions = Permission::whereIn('name', [
                'access-dashboard',
                'view-own-orders',
                'view-own-projects',
                'create-form-submissions',
                'view-notifications',
            ])->get();
            $student->syncPermissions($studentPermissions);
            $this->command->info('✓ Assigned student permissions to Student');
        }

        // Human Resource Manager
        $hrManager = Role::where('name', 'Human Resource Manager')->first();
        if ($hrManager) {
            $hrPermissions = Permission::whereIn('name', [
                'access-dashboard',
                'access-admin-panel',
                'view-users', 'create-users', 'edit-users',
                'view-roles', 'assign-roles',
                'view-projects',
                'view-reports',
                'view-notifications',
                'manage-settings',
            ])->get();
            $hrManager->syncPermissions($hrPermissions);
            $this->command->info('✓ Assigned HR permissions to Human Resource Manager');
        }

        $this->command->info('All permissions assigned successfully!');
    }
}
