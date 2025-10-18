<?php

namespace Database\Seeders;

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
        $currencyService = app(CurrencyService::class);
        $currencyService->seedInitialData();
        
        $this->command->info('Initial currency and country data seeded successfully.');
    }
}
