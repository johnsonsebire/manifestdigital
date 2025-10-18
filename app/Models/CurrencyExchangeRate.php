<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CurrencyExchangeRate extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'from_currency',
        'to_currency',
        'rate',
        'source',
        'rate_date',
        'fetched_at',
        'metadata',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'rate' => 'decimal:6',
        'rate_date' => 'date',
        'fetched_at' => 'datetime',
        'metadata' => 'array',
    ];

    /**
     * Get the from currency.
     */
    public function fromCurrency(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'from_currency', 'code');
    }

    /**
     * Get the to currency.
     */
    public function toCurrency(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'to_currency', 'code');
    }

    /**
     * Scope a query to get latest rates.
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('rate_date', 'desc')->orderBy('fetched_at', 'desc');
    }

    /**
     * Scope a query to get rates for a specific date.
     */
    public function scopeForDate($query, $date)
    {
        return $query->where('rate_date', $date);
    }

    /**
     * Scope a query to get rates from a specific currency.
     */
    public function scopeFrom($query, $currency)
    {
        return $query->where('from_currency', $currency);
    }

    /**
     * Scope a query to get rates to a specific currency.
     */
    public function scopeTo($query, $currency)
    {
        return $query->where('to_currency', $currency);
    }

    /**
     * Get the latest exchange rate between two currencies.
     */
    public static function getLatestRate(string $fromCurrency, string $toCurrency): ?float
    {
        $rate = static::from($fromCurrency)
            ->to($toCurrency)
            ->latest()
            ->first();

        return $rate?->rate;
    }

    /**
     * Get historical rates for charting.
     */
    public static function getHistoricalRates(string $fromCurrency, string $toCurrency, int $days = 30): array
    {
        $rates = static::from($fromCurrency)
            ->to($toCurrency)
            ->where('rate_date', '>=', now()->subDays($days))
            ->orderBy('rate_date')
            ->get(['rate_date', 'rate']);

        return $rates->map(function ($rate) {
            return [
                'date' => $rate->rate_date->format('Y-m-d'),
                'rate' => (float) $rate->rate,
            ];
        })->toArray();
    }
}
