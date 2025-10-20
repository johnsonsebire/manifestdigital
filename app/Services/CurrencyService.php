<?php

namespace App\Services;

use App\Models\Currency;
use App\Models\Country;
use App\Models\RegionalPricing;
use App\Models\Service;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CurrencyService
{
    /**
     * Cache TTL for exchange rates (1 hour).
     */
    protected const CACHE_TTL = 3600;

    /**
     * Get user's currency based on IP geolocation.
     */
    public function detectUserCurrency(?string $ip = null): Currency
    {
        // Use provided IP or get from request
        $ip = $ip ?: request()->ip();
        
        // Try to get from session first (user preference)
        if (session()->has('currency_code')) {
            $currency = Currency::where('code', session('currency_code'))->active()->first();
            if ($currency) {
                return $currency;
            }
        }
        
        // Try geolocation detection
        $country = $this->detectCountryFromIp($ip);
        
        if ($country && $country->currency) {
            // Store in session for future requests
            session(['currency_code' => $country->currency->code]);
            return $country->currency;
        }
        
        // For local development or when geolocation fails,
        // check if we have GHS regional pricing available and default to that
        // (assuming Ghana-based business)
        $hasGhsRegionalPricing = RegionalPricing::whereHas('currency', function($query) {
            $query->where('code', 'GHS');
        })->exists();
        
        if ($hasGhsRegionalPricing) {
            $ghsCurrency = Currency::where('code', 'GHS')->active()->first();
            if ($ghsCurrency) {
                session(['currency_code' => 'GHS']);
                return $ghsCurrency;
            }
        }
        
        // Fallback to USD (base currency)
        return Currency::getBaseCurrency() ?: $this->createDefaultCurrency();
    }

    /**
     * Detect country from IP address.
     */
    protected function detectCountryFromIp(string $ip): ?Country
    {
        // Skip local IPs
        if ($ip === '127.0.0.1' || $ip === '::1' || str_starts_with($ip, '192.168.') || str_starts_with($ip, '10.')) {
            return null;
        }

        try {
            // Use a free IP geolocation service
            $response = Http::timeout(5)->get("http://ip-api.com/json/{$ip}?fields=status,country,countryCode");
            
            if ($response->successful() && $response->json('status') === 'success') {
                $countryCode = $response->json('countryCode');
                return Country::where('code', $countryCode)->active()->first();
            }
        } catch (\Exception $e) {
            Log::warning('Geolocation API failed', ['ip' => $ip, 'error' => $e->getMessage()]);
        }

        return null;
    }

    /**
     * Get service price in user's currency.
     */
    public function getServicePrice(Service $service, ?Currency $currency = null): array
    {
        $currency = $currency ?: $this->detectUserCurrency();
        
        // Check for regional pricing first
        $regionalPrice = $this->getRegionalPrice($service, $currency);
        if ($regionalPrice) {
            return [
                'price' => $regionalPrice->price,
                'currency' => $currency,
                'formatted' => $regionalPrice->formatted_price,
                'original_price' => $regionalPrice->original_price,
                'savings' => $regionalPrice->savings,
                'savings_percentage' => $regionalPrice->savings_percentage,
                'is_regional' => true,
            ];
        }
        
        // Convert from service's base price
        $convertedPrice = $this->convertPrice($service->price, $service->currency, $currency->code);
        
        return [
            'price' => $convertedPrice,
            'currency' => $currency,
            'formatted' => $currency->formatAmount($convertedPrice),
            'original_price' => $service->price,
            'savings' => 0,
            'savings_percentage' => 0,
            'is_regional' => false,
        ];
    }

    /**
     * Get regional pricing for a service and currency.
     */
    protected function getRegionalPrice(Service $service, Currency $currency): ?RegionalPricing
    {
        // First, try to find pricing based on the currency itself
        // This is useful when we know the user wants GHS pricing
        if ($currency->code !== 'USD') {
            // Try currency-based regional pricing first
            $regionalPrice = RegionalPricing::where('service_id', $service->id)
                ->where('currency_id', $currency->id)
                ->active()
                ->orderBy('created_at', 'desc')
                ->first();
                
            if ($regionalPrice) {
                return $regionalPrice;
            }
        }
        
        // Then try country detection
        $country = $this->detectCountryFromIp(request()->ip());
        
        // Try country-specific pricing
        if ($country) {
            $regionalPrice = RegionalPricing::where('service_id', $service->id)
                ->where('currency_id', $currency->id)
                ->where('country_code', $country->code)
                ->active()
                ->first();
                
            if ($regionalPrice) {
                return $regionalPrice;
            }
            
            // Try region-based pricing
            if ($country->region) {
                $regionalPrice = RegionalPricing::where('service_id', $service->id)
                    ->where('currency_id', $currency->id)
                    ->where('region', $country->region)
                    ->whereNull('country_code')
                    ->active()
                    ->first();
                    
                if ($regionalPrice) {
                    return $regionalPrice;
                }
            }
        }
        
        // If we have GHS currency but no country detected (local dev), 
        // assume Ghana/West Africa region
        if ($currency->code === 'GHS') {
            $regionalPrice = RegionalPricing::where('service_id', $service->id)
                ->where('currency_id', $currency->id)
                ->where(function($query) {
                    $query->where('country_code', 'GH')
                          ->orWhere('region', 'West Africa')
                          ->orWhereNull('country_code');
                })
                ->active()
                ->orderBy('country_code', 'desc') // Prefer country-specific over regional
                ->first();
                
            if ($regionalPrice) {
                return $regionalPrice;
            }
        }
        
        return null;
    }

    /**
     * Convert price between currencies.
     */
    public function convertPrice(float $amount, string $fromCurrency, string $toCurrency): float
    {
        if ($fromCurrency === $toCurrency) {
            return $amount;
        }
        
        $cacheKey = "exchange_rate_{$fromCurrency}_{$toCurrency}";
        
        $rate = Cache::remember($cacheKey, self::CACHE_TTL, function () use ($fromCurrency, $toCurrency) {
            return $this->getExchangeRate($fromCurrency, $toCurrency);
        });
        
        return round($amount * $rate, 2);
    }

    /**
     * Get exchange rate between currencies.
     */
    protected function getExchangeRate(string $fromCurrency, string $toCurrency): float
    {
        // Check if we have the rate in our database
        $dbRate = \App\Models\CurrencyExchangeRate::getLatestRate($fromCurrency, $toCurrency);
        if ($dbRate !== null) {
            return $dbRate;
        }

        // For USD base conversions, use currency model rates
        if ($fromCurrency === 'USD') {
            $currency = Currency::where('code', $toCurrency)->first();
            return $currency ? (1 / $currency->exchange_rate_to_usd) : 1.0;
        }
        
        if ($toCurrency === 'USD') {
            $currency = Currency::where('code', $fromCurrency)->first();
            return $currency ? (1 / $currency->exchange_rate_to_usd) : 1.0;
        }
        
        // For non-USD conversions, convert through USD
        $fromToUsd = $this->getExchangeRate($fromCurrency, 'USD');
        $usdToTarget = $this->getExchangeRate('USD', $toCurrency);
        
        return $fromToUsd * $usdToTarget;
    }

    /**
     * Update exchange rates from external API.
     */
    public function updateExchangeRates(): bool
    {
        try {
            // Using a free exchange rate API (you can replace with your preferred service)
            $response = Http::timeout(10)->get('https://api.exchangerate-api.com/v4/latest/USD');
            
            if (!$response->successful()) {
                Log::error('Failed to fetch exchange rates', ['status' => $response->status()]);
                return false;
            }
            
            $data = $response->json();
            $rates = $data['rates'] ?? [];
            
            foreach ($rates as $currencyCode => $rate) {
                $currency = Currency::where('code', $currencyCode)->first();
                if ($currency && !$currency->is_base_currency) {
                    $currency->updateExchangeRate($rate, 'api');
                }
            }
            
            Log::info('Exchange rates updated successfully', ['currencies' => count($rates)]);
            
            // Clear cache
            Cache::flush();
            
            return true;
            
        } catch (\Exception $e) {
            Log::error('Failed to update exchange rates', ['error' => $e->getMessage()]);
            return false;
        }
    }

    /**
     * Set user's preferred currency.
     */
    public function setUserCurrency(string $currencyCode): bool
    {
        $currency = Currency::where('code', $currencyCode)->active()->first();
        
        if (!$currency) {
            return false;
        }
        
        session(['currency_code' => $currencyCode]);
        return true;
    }

    /**
     * Get all active currencies for selection.
     */
    public function getActiveCurrencies(): \Illuminate\Database\Eloquent\Collection
    {
        return Currency::active()->orderBy('name')->get();
    }

    /**
     * Format amount in specific currency.
     */
    public function formatAmount(float $amount, string $currencyCode): string
    {
        $currency = Currency::where('code', $currencyCode)->first();
        
        if (!$currency) {
            return number_format($amount, 2) . ' ' . $currencyCode;
        }
        
        return $currency->formatAmount($amount);
    }

    /**
     * Get currency conversion information for display.
     */
    public function getConversionInfo(float $amount, string $fromCurrency, string $toCurrency): array
    {
        $convertedAmount = $this->convertPrice($amount, $fromCurrency, $toCurrency);
        $rate = $this->getExchangeRate($fromCurrency, $toCurrency);
        
        return [
            'original_amount' => $amount,
            'original_currency' => $fromCurrency,
            'converted_amount' => $convertedAmount,
            'target_currency' => $toCurrency,
            'exchange_rate' => $rate,
            'formatted_original' => $this->formatAmount($amount, $fromCurrency),
            'formatted_converted' => $this->formatAmount($convertedAmount, $toCurrency),
        ];
    }

    /**
     * Create default USD currency if none exists.
     */
    protected function createDefaultCurrency(): Currency
    {
        return Currency::firstOrCreate([
            'code' => 'USD'
        ], [
            'name' => 'US Dollar',
            'symbol' => '$',
            'exchange_rate_to_usd' => 1.0,
            'is_base_currency' => true,
            'is_active' => true,
            'decimal_places' => 2,
            'format' => '${{amount}}',
        ]);
    }

    /**
     * Seed initial currencies and countries.
     */
    public function seedInitialData(): void
    {
        // Create base currencies
        $currencies = [
            [
                'code' => 'USD',
                'name' => 'US Dollar',
                'symbol' => '$',
                'exchange_rate_to_usd' => 1.0,
                'is_base_currency' => true,
                'decimal_places' => 2,
                'format' => '${{amount}}',
            ],
            [
                'code' => 'GHS',
                'name' => 'Ghana Cedi',
                'symbol' => '₵',
                'exchange_rate_to_usd' => 12.0, // This will be updated by API
                'is_base_currency' => false,
                'decimal_places' => 2,
                'format' => '₵{{amount}}',
            ],
        ];

        foreach ($currencies as $currencyData) {
            Currency::firstOrCreate(
                ['code' => $currencyData['code']],
                $currencyData
            );
        }

        // Create initial countries
        $countries = [
            [
                'code' => 'US',
                'name' => 'United States',
                'currency_code' => 'USD',
                'region' => 'North America',
                'phone_code' => '+1',
            ],
            [
                'code' => 'GH',
                'name' => 'Ghana',
                'currency_code' => 'GHS',
                'region' => 'Africa',
                'phone_code' => '+233',
            ],
        ];

        foreach ($countries as $countryData) {
            Country::firstOrCreate(
                ['code' => $countryData['code']],
                $countryData
            );
        }
    }
}