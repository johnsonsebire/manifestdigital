<?php

namespace Database\Factories;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Currency>
 */
class CurrencyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $currencies = $this->getCurrencyData();
        $currency = $this->faker->randomElement($currencies);

        return [
            'code' => $currency['code'],
            'name' => $currency['name'],
            'symbol' => $currency['symbol'],
            'exchange_rate_to_usd' => $currency['exchange_rate'],
            'is_base_currency' => $currency['code'] === 'USD',
            'is_active' => $this->faker->boolean(90),
            'decimal_places' => $currency['decimal_places'],
            'format' => $currency['format'],
            'metadata' => [
                'country_codes' => $currency['countries'],
                'numeric_code' => $currency['numeric_code'],
                'minor_unit' => $currency['decimal_places'],
            ],
            'exchange_rate_updated_at' => $this->faker->dateTimeBetween('-1 week', 'now'),
        ];
    }

    /**
     * Get realistic currency data
     */
    private function getCurrencyData(): array
    {
        return [
            [
                'code' => 'USD',
                'name' => 'US Dollar',
                'symbol' => '$',
                'exchange_rate' => 1.00,
                'decimal_places' => 2,
                'format' => '{{symbol}}{{amount}}',
                'countries' => ['US'],
                'numeric_code' => '840',
            ],
            [
                'code' => 'EUR',
                'name' => 'Euro',
                'symbol' => '€',
                'exchange_rate' => 0.85,
                'decimal_places' => 2,
                'format' => '{{symbol}}{{amount}}',
                'countries' => ['DE', 'FR', 'IT', 'ES'],
                'numeric_code' => '978',
            ],
            [
                'code' => 'GBP',
                'name' => 'British Pound Sterling',
                'symbol' => '£',
                'exchange_rate' => 0.73,
                'decimal_places' => 2,
                'format' => '{{symbol}}{{amount}}',
                'countries' => ['GB'],
                'numeric_code' => '826',
            ],
            [
                'code' => 'CAD',
                'name' => 'Canadian Dollar',
                'symbol' => 'C$',
                'exchange_rate' => 1.35,
                'decimal_places' => 2,
                'format' => '{{symbol}}{{amount}}',
                'countries' => ['CA'],
                'numeric_code' => '124',
            ],
            [
                'code' => 'AUD',
                'name' => 'Australian Dollar',
                'symbol' => 'A$',
                'exchange_rate' => 1.52,
                'decimal_places' => 2,
                'format' => '{{symbol}}{{amount}}',
                'countries' => ['AU'],
                'numeric_code' => '036',
            ],
            [
                'code' => 'JPY',
                'name' => 'Japanese Yen',
                'symbol' => '¥',
                'exchange_rate' => 150.00,
                'decimal_places' => 0,
                'format' => '{{symbol}}{{amount}}',
                'countries' => ['JP'],
                'numeric_code' => '392',
            ],
            [
                'code' => 'GHS',
                'name' => 'Ghanaian Cedi',
                'symbol' => '₵',
                'exchange_rate' => 12.00,
                'decimal_places' => 2,
                'format' => '{{symbol}}{{amount}}',
                'countries' => ['GH'],
                'numeric_code' => '936',
            ],
            [
                'code' => 'NGN',
                'name' => 'Nigerian Naira',
                'symbol' => '₦',
                'exchange_rate' => 770.00,
                'decimal_places' => 2,
                'format' => '{{symbol}}{{amount}}',
                'countries' => ['NG'],
                'numeric_code' => '566',
            ],
            [
                'code' => 'ZAR',
                'name' => 'South African Rand',
                'symbol' => 'R',
                'exchange_rate' => 18.50,
                'decimal_places' => 2,
                'format' => '{{symbol}}{{amount}}',
                'countries' => ['ZA'],
                'numeric_code' => '710',
            ],
            [
                'code' => 'INR',
                'name' => 'Indian Rupee',
                'symbol' => '₹',
                'exchange_rate' => 83.00,
                'decimal_places' => 2,
                'format' => '{{symbol}}{{amount}}',
                'countries' => ['IN'],
                'numeric_code' => '356',
            ],
        ];
    }

    /**
     * Create USD as base currency
     */
    public function usd(): static
    {
        return $this->state([
            'code' => 'USD',
            'name' => 'US Dollar',
            'symbol' => '$',
            'exchange_rate_to_usd' => 1.00,
            'is_base_currency' => true,
            'is_active' => true,
            'decimal_places' => 2,
            'format' => '${{amount}}',
            'metadata' => [
                'country_codes' => ['US'],
                'numeric_code' => '840',
                'minor_unit' => 2,
                'is_crypto' => false,
            ],
        ]);
    }

    /**
     * Create EUR currency
     */
    public function eur(): static
    {
        return $this->state([
            'code' => 'EUR',
            'name' => 'Euro',
            'symbol' => '€',
            'exchange_rate_to_usd' => 0.85,
            'is_base_currency' => false,
            'is_active' => true,
            'decimal_places' => 2,
            'format' => '€{{amount}}',
            'metadata' => [
                'country_codes' => ['DE', 'FR', 'IT', 'ES', 'NL'],
                'numeric_code' => '978',
                'minor_unit' => 2,
                'is_crypto' => false,
            ],
        ]);
    }

    /**
     * Create GBP currency
     */
    public function gbp(): static
    {
        return $this->state([
            'code' => 'GBP',
            'name' => 'British Pound Sterling',
            'symbol' => '£',
            'exchange_rate_to_usd' => 0.73,
            'is_base_currency' => false,
            'is_active' => true,
            'decimal_places' => 2,
            'format' => '£{{amount}}',
            'metadata' => [
                'country_codes' => ['GB'],
                'numeric_code' => '826',
                'minor_unit' => 2,
                'is_crypto' => false,
            ],
        ]);
    }

    /**
     * Create GHS currency (Ghanaian Cedi)
     */
    public function ghs(): static
    {
        return $this->state([
            'code' => 'GHS',
            'name' => 'Ghanaian Cedi',
            'symbol' => '₵',
            'exchange_rate_to_usd' => 12.00,
            'is_base_currency' => false,
            'is_active' => true,
            'decimal_places' => 2,
            'format' => '₵{{amount}}',
            'metadata' => [
                'country_codes' => ['GH'],
                'numeric_code' => '936',
                'minor_unit' => 2,
                'is_crypto' => false,
            ],
        ]);
    }

    /**
     * Create an active currency
     */
    public function active(): static
    {
        return $this->state([
            'is_active' => true,
        ]);
    }

    /**
     * Create an inactive currency
     */
    public function inactive(): static
    {
        return $this->state([
            'is_active' => false,
        ]);
    }

    /**
     * Create a cryptocurrency
     */
    public function crypto(): static
    {
        $cryptos = [
            [
                'code' => 'BTC',
                'name' => 'Bitcoin',
                'symbol' => '₿',
                'exchange_rate' => 0.000023,
                'decimal_places' => 8,
            ],
            [
                'code' => 'ETH',
                'name' => 'Ethereum',
                'symbol' => 'Ξ',
                'exchange_rate' => 0.0004,
                'decimal_places' => 6,
            ],
        ];

        $crypto = $this->faker->randomElement($cryptos);

        return $this->state([
            'code' => $crypto['code'],
            'name' => $crypto['name'],
            'symbol' => $crypto['symbol'],
            'exchange_rate_to_usd' => $crypto['exchange_rate'],
            'is_base_currency' => false,
            'is_active' => true,
            'decimal_places' => $crypto['decimal_places'],
            'format' => '{{amount}} {{symbol}}',
            'metadata' => [
                'is_crypto' => true,
                'blockchain' => $crypto['code'] === 'BTC' ? 'Bitcoin' : 'Ethereum',
                'volatility' => 'high',
            ],
        ]);
    }

    /**
     * Create a currency with recent exchange rate update
     */
    public function recentRate(): static
    {
        return $this->state([
            'exchange_rate_updated_at' => $this->faker->dateTimeBetween('-1 day', 'now'),
        ]);
    }

    /**
     * Create a currency with outdated exchange rate
     */
    public function outdatedRate(): static
    {
        return $this->state([
            'exchange_rate_updated_at' => $this->faker->dateTimeBetween('-1 month', '-2 days'),
        ]);
    }
}