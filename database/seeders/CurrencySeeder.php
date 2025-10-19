<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Services\CurrencyService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Use the existing currency service for initial data
        $currencyService = app(CurrencyService::class);
        $currencyService->seedInitialData();
        
        // Ensure our specific currencies are properly configured
        $currencies = [
            [
                'code' => 'USD',
                'name' => 'US Dollar',
                'symbol' => '$',
                'exchange_rate_to_usd' => 1.00,
                'is_base_currency' => true, // USD as base currency
                'is_active' => true,
                'decimal_places' => 2,
                'format' => '{symbol}{amount}',
            ],
            [
                'code' => 'GHS',
                'name' => 'Ghana Cedi',
                'symbol' => 'GH₵',
                'exchange_rate_to_usd' => 0.074, // 1 GHS = 0.074 USD
                'is_base_currency' => false,
                'is_active' => true,
                'decimal_places' => 2,
                'format' => '{symbol}{amount}',
            ],
        ];

        foreach ($currencies as $currencyData) {
            Currency::updateOrCreate(
                ['code' => $currencyData['code']],
                array_merge($currencyData, ['exchange_rate_updated_at' => now()])
            );
        }
        
        $this->command->info('Currency data seeded successfully with USD and GHS configurations.');
    }
}
