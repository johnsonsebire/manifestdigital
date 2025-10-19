<?php

namespace Database\Seeders;

use App\Models\RegionalPricing;
use App\Models\Service;
use App\Models\Currency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegionalPricingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get GHS currency
        $ghsCurrency = Currency::where('code', 'GHS')->first();
        
        if (!$ghsCurrency) {
            $this->command->warn('GHS currency not found. Please run CurrencySeeder first.');
            return;
        }

        // Regional pricing data for West Africa (Ghana)
        $regionalPricing = [
            'website-essentials' => 250.00,
            'website-professional' => 500.00,
            'website-enterprise' => 1500.00,
            'basic-ui-ux-design' => 2500.00,
            'professional-ui-ux-design' => 6000.00,
            'enterprise-ui-ux-design' => 10000.00,
            'starter-web-hosting' => 50.00,
            'business-web-hosting' => 150.00,
            'premium-web-hosting' => 400.00,
            'com-domain-registration' => 300.00,
            'gh-domain-registration' => 600.00,
            'premium-domain-acquisition' => 0.00, // Custom pricing
            'simple-mobile-app' => 5000.00,
            'professional-mobile-app' => 25000.00,
            'enterprise-mobile-app' => 50000.00,
            'hourly-technical-consulting' => 500.00,
            'monthly-consulting-retainer' => 5000.00,
            'project-based-consulting' => 0.00, // Custom pricing
            'individual-technical-training' => 3000.00,
            'team-technical-training' => 2000.00,
            'corporate-training-program' => 0.00, // Custom pricing
        ];

        foreach ($regionalPricing as $serviceSlug => $price) {
            $service = Service::where('slug', $serviceSlug)->first();
            
            if (!$service) {
                $this->command->warn("Service '{$serviceSlug}' not found. Skipping.");
                continue;
            }

            RegionalPricing::updateOrCreate(
                [
                    'service_id' => $service->id,
                    'currency_id' => $ghsCurrency->id,
                    'country_code' => null, // Applies to entire West Africa region
                ],
                [
                    'price' => $price,
                    'region' => 'West Africa',
                    'original_price' => $service->price, // Store the original USD price
                    'is_active' => true,
                ]
            );
        }

        $this->command->info('Regional pricing for West Africa (Ghana) seeded successfully.');
    }
}
