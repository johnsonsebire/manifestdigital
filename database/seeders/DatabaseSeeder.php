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
        // Run the roles seeder first to create necessary roles
        $this->call(RolesSeeder::class);
        
        // Run the permissions seeder to create and assign all permissions
        $this->call(PermissionsSeeder::class);
        
        // Create the super admin user
        $this->call(SuperAdminSeeder::class);
        
        // Seed the contact form
        $this->call(ContactFormSeeder::class);

        // Seed Quote Request form
        $this->call(RequestQuoteFormSeeder::class);

        // Seed Book A Call form
        $this->call(BookACallFormSeeder::class);

        // Seed Team Profile Update Form
        $this->call(TeamProfileFormSeeder::class);

        // Seed tax system
        $this->call(TaxSeeder::class);

        // Create a test user for development
        if (app()->environment('local', 'development')) {
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);
        }
    }
}
