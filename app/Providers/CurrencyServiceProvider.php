<?php

namespace App\Providers;

use App\Services\CurrencyService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class CurrencyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(CurrencyService::class, function ($app) {
            return new CurrencyService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Share currency service with all views
        View::composer('*', function ($view) {
            $currencyService = app(CurrencyService::class);
            $view->with('currencyService', $currencyService);
            $view->with('activeCurrencies', $currencyService->getActiveCurrencies());
            $view->with('userCurrency', $currencyService->detectUserCurrency());
        });
    }
}
