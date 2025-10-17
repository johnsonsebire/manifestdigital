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
        
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        
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
    }
}
