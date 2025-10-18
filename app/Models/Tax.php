<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tax extends Model
{
    protected $fillable = [
        'name',
        'code',
        'rate',
        'type',
        'fixed_amount',
        'description',
        'is_inclusive',
        'is_active',
        'is_default',
        'sort_order',
        'metadata',
    ];

    protected $casts = [
        'rate' => 'decimal:2',
        'fixed_amount' => 'decimal:2',
        'is_inclusive' => 'boolean',
        'is_active' => 'boolean',
        'is_default' => 'boolean',
        'metadata' => 'array',
    ];

    /**
     * Get the invoices that use this tax.
     */
    public function invoices(): BelongsToMany
    {
        return $this->belongsToMany(Invoice::class, 'invoice_taxes')
            ->withPivot(['tax_rate', 'taxable_amount', 'tax_amount', 'is_inclusive', 'metadata'])
            ->withTimestamps();
    }

    /**
     * Get the regional tax configurations for this tax.
     */
    public function regionalTaxes(): HasMany
    {
        return $this->hasMany(RegionalTax::class);
    }

    /**
     * Calculate tax amount for a given base amount.
     */
    public function calculateTaxAmount(float $baseAmount, bool $isInclusive = null): float
    {
        $inclusive = $isInclusive ?? $this->is_inclusive;
        
        if ($this->type === 'fixed') {
            return $this->fixed_amount ?? 0;
        }
        
        $rate = $this->rate / 100;
        
        if ($inclusive) {
            // Tax is included in the base amount
            return $baseAmount - ($baseAmount / (1 + $rate));
        } else {
            // Tax is added to the base amount
            return $baseAmount * $rate;
        }
    }

    /**
     * Get active taxes.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get default taxes.
     */
    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    /**
     * Get taxes ordered by sort order.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    /**
     * Get applicable taxes for a specific region/country.
     */
    public function scopeForRegion($query, $countryCode = null, $currencyId = null)
    {
        return $query->whereHas('regionalTaxes', function ($q) use ($countryCode, $currencyId) {
            $q->where('is_applicable', true);
            
            if ($countryCode) {
                $q->where('country_code', $countryCode);
            }
            
            if ($currencyId) {
                $q->where('currency_id', $currencyId);
            }
        });
    }
}
