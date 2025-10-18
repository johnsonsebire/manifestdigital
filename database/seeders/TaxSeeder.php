<?php

namespace Database\Seeders;

use App\Models\Tax;
use App\Models\Currency;
use App\Models\RegionalTax;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Ghana taxes
        $vat = Tax::create([
            'name' => 'Value Added Tax',
            'code' => 'VAT',
            'description' => 'Ghana Value Added Tax - Standard rate for goods and services',
            'type' => 'percentage',
            'rate' => 15.00,
            'is_active' => true,
            'is_default' => true,
            'is_inclusive' => false,
            'sort_order' => 1,
        ]);

        $nhil = Tax::create([
            'name' => 'National Health Insurance Levy',
            'code' => 'NHIL',
            'description' => 'National Health Insurance Levy for Ghana healthcare funding',
            'type' => 'percentage',
            'rate' => 2.50,
            'is_active' => true,
            'is_default' => true,
            'is_inclusive' => false,
            'sort_order' => 2,
        ]);

        $covid = Tax::create([
            'name' => 'COVID-19 Health Recovery Levy',
            'code' => 'COVID',
            'description' => 'COVID-19 Health Recovery Levy for pandemic response',
            'type' => 'percentage',
            'rate' => 1.00,
            'is_active' => true,
            'is_default' => true,
            'is_inclusive' => false,
            'sort_order' => 3,
        ]);

        // Create international/exempt tax (0%)
        $exempt = Tax::create([
            'name' => 'Tax Exempt',
            'code' => 'EXEMPT',
            'description' => 'Tax exemption for international clients and specific services',
            'type' => 'percentage',
            'rate' => 0.00,
            'is_active' => true,
            'is_default' => false,
            'is_inclusive' => false,
            'sort_order' => 4,
        ]);

        // Get currencies
        $ghs = Currency::where('code', 'GHS')->first();
        $usd = Currency::where('code', 'USD')->first();

        if ($ghs) {
            // Configure Ghana-specific taxes for GHS currency
            RegionalTax::create([
                'tax_id' => $vat->id,
                'country_code' => 'GH',
                'currency_id' => $ghs->id,
                'rate_override' => null, // Use default VAT rate
                'is_inclusive' => null, // Use default setting
                'priority' => 1,
                'is_active' => true,
            ]);

            RegionalTax::create([
                'tax_id' => $nhil->id,
                'country_code' => 'GH',
                'currency_id' => $ghs->id,
                'rate_override' => null, // Use default NHIL rate
                'is_inclusive' => null, // Use default setting
                'priority' => 2,
                'is_active' => true,
            ]);

            RegionalTax::create([
                'tax_id' => $covid->id,
                'country_code' => 'GH',
                'currency_id' => $ghs->id,
                'rate_override' => null, // Use default COVID levy rate
                'is_inclusive' => null, // Use default setting
                'priority' => 3,
                'is_active' => true,
            ]);
        }

        if ($usd) {
            // Configure international tax exemption for USD currency
            RegionalTax::create([
                'tax_id' => $exempt->id,
                'country_code' => null, // All countries except Ghana
                'currency_id' => $usd->id,
                'rate_override' => 0.00, // Ensure 0% tax
                'is_inclusive' => false,
                'priority' => 1,
                'is_active' => true,
            ]);
        }

        // Example of region-specific rate override
        // Create a special VAT rate for a specific region if needed
        // RegionalTax::create([
        //     'tax_id' => $vat->id,
        //     'country_code' => 'NG', // Nigeria example
        //     'currency_id' => null,
        //     'rate_override' => 7.50, // Different VAT rate for Nigeria
        //     'is_inclusive' => null,
        //     'priority' => 1,
        //     'is_active' => true,
        // ]);

        $this->command->info('✅ Tax system seeded successfully!');
        $this->command->info('   📊 Created ' . Tax::count() . ' taxes');
        $this->command->info('   🌍 Created ' . RegionalTax::count() . ' regional configurations');
        $this->command->info('   🇬🇭 Ghana: VAT (15%) + NHIL (2.5%) + COVID (1%) = 18.5% total');
        $this->command->info('   🌐 International (USD): 0% tax (exempt)');
    }
}
