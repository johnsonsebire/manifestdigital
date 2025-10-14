<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Run the roles seeder first to create necessary roles and permissions
        $this->call(RolesSeeder::class);
        
        // Create the super admin user
        $this->call(SuperAdminSeeder::class);
        
        // Seed the contact form
        $this->call(ContactFormSeeder::class);

        // Create a test user for development
        if (app()->environment('local', 'development')) {
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);
        }
    }
}
