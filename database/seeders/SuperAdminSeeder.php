<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class SuperAdminSeeder extends Seeder
{
    /**
     * Create a super admin user for the application.
     */
    public function run(): void
    {
        $this->command->info('Creating super admin user...');

        // Check if super admin role exists
        $superAdminRole = Role::where('name', 'Super Admin')->first();
        
        if (!$superAdminRole) {
            $this->command->error('Super Admin role not found! Please run RolesSeeder first.');
            return;
        }

        // Create the super admin user if it doesn't exist
        $user = User::firstOrNew(['email' => 'admin@manifestdigital.com']);
        
        // Get password from environment variable or use a fallback
        $password = env('SUPER_ADMIN_PASSWORD') ?: 'Admin@123!';
        
        if (!$user->exists) {
            $user->fill([
                'name' => 'Super Administrator',
                'email' => 'johnson@manifestghana.com',
                'password' => Hash::make($password),
                'email_verified_at' => now(),
            ]);
            
            $user->save();
            $this->command->info('Super admin user created successfully!');
        } else {
            $this->command->info('Super admin user already exists. Ensuring proper role assignment.');
        }

        // Ensure the user has the Super Admin role
        if (!$user->hasRole('Super Admin')) {
            $user->assignRole('Super Admin');
            $this->command->info('Super Admin role assigned successfully!');
        } else {
            $this->command->info('User already has Super Admin role.');
        }

        // Output user login details (only in development)
        if (app()->environment('local', 'development')) {
            $this->command->info('----------------------------------------');
            $this->command->info('Super Admin Login Details:');
            $this->command->info('Email: johnson@manifestghana.com');
            $this->command->info('Password: ' . (env('SUPER_ADMIN_PASSWORD') ? '[from .env file]' : 'Admin@123!'));
            $this->command->info('----------------------------------------');
            $this->command->warn('Remember to secure your .env file in production!');
        }
    }
}