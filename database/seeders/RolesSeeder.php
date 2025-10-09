<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Setting up roles...');
        
        // Define the roles as per your requirements
        $roles = [
            'Customer',
            'Affiliate',
            'Partner',
            'Student',
            'Staff',
            'Administrator',
            'Finance Manager',
            'Super Admin',
            'Human Resource Manager',
        ];

        $this->command->info('Creating roles...');
        
        foreach ($roles as $roleName) {
            $role = Role::firstOrCreate([
                'name' => $roleName,
                'guard_name' => 'web'
            ]);
            
            $this->command->info("Ensured role exists: {$roleName}");
        }

        $this->command->info('Roles created successfully!');
        
        // Optional: Create some basic permissions (you can expand this later)
        $this->createBasicPermissions();
    }

    /**
     * Create some basic permissions
     */
    private function createBasicPermissions(): void
    {
        $this->command->info('Creating basic permissions...');
        
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
            
            // Basic operations
            'view-reports',
            'manage-settings',
        ];

        foreach ($permissions as $permissionName) {
            Permission::firstOrCreate([
                'name' => $permissionName,
                'guard_name' => 'web'
            ]);
            
            $this->command->info("Created permission: {$permissionName}");
        }

        // Assign all permissions to Super Admin
        $superAdmin = Role::where('name', 'Super Admin')->first();
        if ($superAdmin) {
            $superAdmin->givePermissionTo(Permission::all());
            $this->command->info('Assigned all permissions to Super Admin role');
        }

        // Assign admin permissions to Administrator
        $administrator = Role::where('name', 'Administrator')->first();
        if ($administrator) {
            $adminPermissions = [
                'view-users', 'create-users', 'edit-users',
                'view-roles', 'assign-roles',
                'access-dashboard', 'access-admin-panel',
                'view-reports', 'manage-settings'
            ];
            $administrator->givePermissionTo($adminPermissions);
            $this->command->info('Assigned admin permissions to Administrator role');
        }

        // Basic permissions for Staff
        $staff = Role::where('name', 'Staff')->first();
        if ($staff) {
            $staffPermissions = ['access-dashboard', 'view-reports'];
            $staff->givePermissionTo($staffPermissions);
            $this->command->info('Assigned basic permissions to Staff role');
        }

        $this->command->info('Basic permissions created and assigned successfully!');
    }
}
