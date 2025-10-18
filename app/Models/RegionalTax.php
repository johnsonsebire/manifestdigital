<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RegionalTax extends Model
{
    protected $fillable = [
        'tax_id',
        'currency_id',
        'country_code',
        'region',
        'rate_override',
        'is_applicable',
        'is_inclusive',
        'priority',
        'conditions',
        'metadata',
    ];

    protected $casts = [
        'rate_override' => 'decimal:2',
        'is_applicable' => 'boolean',
        'is_inclusive' => 'boolean',
        'conditions' => 'array',
        'metadata' => 'array',
    ];

    /**
     * Get the tax definition.
     */
    public function tax(): BelongsTo
    {
        return $this->belongsTo(Tax::class);
    }

    /**
     * Get the currency for this regional tax.
     */
    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    /**
     * Get applicable regional taxes for a specific region.
     */
    public function scopeApplicable($query)
    {
        return $query->where('is_applicable', true);
    }

    /**
     * Get regional taxes for a specific country.
     */
    public function scopeForCountry($query, $countryCode)
    {
        return $query->where('country_code', $countryCode);
    }

    /**
     * Get regional taxes for a specific currency.
     */
    public function scopeForCurrency($query, $currencyId)
    {
        return $query->where('currency_id', $currencyId);
    }

    /**
     * Get regional taxes ordered by priority (higher priority first).
     */
    public function scopeByPriority($query)
    {
        return $query->orderBy('priority', 'desc');
    }
}
