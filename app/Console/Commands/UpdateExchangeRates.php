<?php

namespace App\Console\Commands;

use App\Services\CurrencyService;
use Illuminate\Console\Command;

class UpdateExchangeRates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'currency:update-rates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update exchange rates from external API';

    /**
     * Execute the console command.
     */
    public function handle(CurrencyService $currencyService)
    {
        $this->info('Updating exchange rates...');
        
        if ($currencyService->updateExchangeRates()) {
            $this->info('Exchange rates updated successfully!');
        } else {
            $this->error('Failed to update exchange rates. Check logs for details.');
        }
    }
}
