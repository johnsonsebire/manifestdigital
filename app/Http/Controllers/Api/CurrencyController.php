<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Service;
use App\Services\CurrencyService;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    protected CurrencyService $currencyService;

    public function __construct(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
    }

    /**
     * Get all active currencies.
     */
    public function index()
    {
        return response()->json([
            'currencies' => $this->currencyService->getActiveCurrencies(),
            'current_currency' => $this->currencyService->detectUserCurrency(),
        ]);
    }

    /**
     * Switch user currency.
     */
    public function switch(Request $request)
    {
        $request->validate([
            'currency' => 'required|string|size:3|exists:currencies,code',
        ]);

        $success = $this->currencyService->setUserCurrency($request->currency);

        if ($success) {
            return response()->json([
                'success' => true,
                'message' => 'Currency switched successfully',
                'current_currency' => $this->currencyService->detectUserCurrency(),
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid currency code',
        ], 400);
    }

    /**
     * Get service price in user's currency.
     */
    public function servicePrice(Service $service)
    {
        $priceInfo = $this->currencyService->getServicePrice($service);

        return response()->json($priceInfo);
    }

    /**
     * Convert price between currencies.
     */
    public function convert(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'from' => 'required|string|size:3|exists:currencies,code',
            'to' => 'required|string|size:3|exists:currencies,code',
        ]);

        $conversionInfo = $this->currencyService->getConversionInfo(
            $request->amount,
            $request->from,
            $request->to
        );

        return response()->json($conversionInfo);
    }

    /**
     * Get exchange rates for a currency.
     */
    public function exchangeRates(Currency $currency)
    {
        $rates = [];
        
        foreach ($this->currencyService->getActiveCurrencies() as $targetCurrency) {
            if ($targetCurrency->code !== $currency->code) {
                $rate = $this->currencyService->getExchangeRate($currency->code, $targetCurrency->code);
                $rates[$targetCurrency->code] = [
                    'rate' => $rate,
                    'currency' => $targetCurrency,
                ];
            }
        }

        return response()->json([
            'base_currency' => $currency,
            'rates' => $rates,
            'updated_at' => $currency->exchange_rate_updated_at,
        ]);
    }
}
