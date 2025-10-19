<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Currency extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'name',
        'symbol',
        'exchange_rate_to_usd',
        'is_base_currency',
        'is_active',
        'decimal_places',
        'format',
        'metadata',
        'exchange_rate_updated_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_base_currency' => 'boolean',
        'is_active' => 'boolean',
        'decimal_places' => 'integer',
        'exchange_rate_to_usd' => 'decimal:6',
        'metadata' => 'array',
        'exchange_rate_updated_at' => 'datetime',
    ];

    /**
     * Get the countries that use this currency.
     */
    public function countries(): HasMany
    {
        return $this->hasMany(Country::class, 'currency_code', 'code');
    }

    /**
     * Get the regional pricing for this currency.
     */
    public function regionalPricing(): HasMany
    {
        return $this->hasMany(RegionalPricing::class);
    }

    /**
     * Get exchange rates where this currency is the 'from' currency.
     */
    public function exchangeRatesFrom(): HasMany
    {
        return $this->hasMany(CurrencyExchangeRate::class, 'from_currency', 'code');
    }

    /**
     * Get exchange rates where this currency is the 'to' currency.
     */
    public function exchangeRatesTo(): HasMany
    {
        return $this->hasMany(CurrencyExchangeRate::class, 'to_currency', 'code');
    }

    /**
     * Scope a query to only include active currencies.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to get the base currency.
     */
    public function scopeBase($query)
    {
        return $query->where('is_base_currency', true);
    }

    /**
     * Scope a query to order currencies by name.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('name', 'asc');
    }

    /**
     * Get the base currency (USD).
     */
    public static function getBaseCurrency(): ?Currency
    {
        return static::base()->first();
    }

    /**
     * Format an amount in this currency.
     */
    public function formatAmount(float $amount): string
    {
        $formatted = number_format($amount, $this->decimal_places);
        
        if ($this->format) {
            // Support both {amount} and {{amount}} template formats for backward compatibility
            return str_replace(['{amount}', '{{amount}}', '{symbol}', '{{symbol}}'], [$formatted, $formatted, $this->symbol, $this->symbol], $this->format);
        }
        
        return $this->symbol . $formatted;
    }

    /**
     * Convert amount from USD to this currency.
     */
    public function convertFromUsd(float $usdAmount): float
    {
        if ($this->is_base_currency) {
            return $usdAmount;
        }
        
        return round($usdAmount * $this->exchange_rate_to_usd, $this->decimal_places);
    }

    /**
     * Convert amount from this currency to USD.
     */
    public function convertToUsd(float $amount): float
    {
        if ($this->is_base_currency) {
            return $amount;
        }
        
        return round($amount / $this->exchange_rate_to_usd, 2);
    }

    /**
     * Check if exchange rate needs updating (older than 24 hours).
     */
    public function needsRateUpdate(): bool
    {
        if ($this->is_base_currency) {
            return false;
        }
        
        return !$this->exchange_rate_updated_at || 
               $this->exchange_rate_updated_at->lt(now()->subDay());
    }

    /**
     * Update exchange rate.
     */
    public function updateExchangeRate(float $rate, string $source = 'manual'): void
    {
        $this->update([
            'exchange_rate_to_usd' => $rate,
            'exchange_rate_updated_at' => now(),
        ]);

        // Store or update historical rate
        CurrencyExchangeRate::updateOrCreate([
            'from_currency' => 'USD',
            'to_currency' => $this->code,
            'rate_date' => now()->toDateString(),
        ], [
            'rate' => $rate,
            'source' => $source,
            'fetched_at' => now(),
        ]);
    }

    /**
     * Get the exchange rate (accessor for compatibility).
     */
    public function getExchangeRateAttribute(): float
    {
        return $this->exchange_rate_to_usd;
    }
}
