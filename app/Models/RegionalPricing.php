<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RegionalPricing extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'regional_pricing';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'service_id',
        'currency_id',
        'country_code',
        'region',
        'price',
        'original_price',
        'markup_percentage',
        'is_active',
        'metadata',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'original_price' => 'decimal:2',
        'markup_percentage' => 'decimal:2',
        'is_active' => 'boolean',
        'metadata' => 'array',
    ];

    /**
     * Get the service this pricing belongs to.
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Get the currency for this pricing.
     */
    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    /**
     * Get the country this pricing applies to.
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_code', 'code');
    }

    /**
     * Scope a query to only include active pricing.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to filter by country.
     */
    public function scopeForCountry($query, $countryCode)
    {
        return $query->where('country_code', $countryCode);
    }

    /**
     * Scope a query to filter by region.
     */
    public function scopeForRegion($query, $region)
    {
        return $query->where('region', $region);
    }

    /**
     * Get formatted price with currency symbol.
     */
    public function getFormattedPriceAttribute(): string
    {
        return $this->currency->formatAmount($this->price);
    }

    /**
     * Calculate savings compared to base price.
     */
    public function getSavingsAttribute(): float
    {
        if ($this->original_price <= $this->price) {
            return 0;
        }
        
        return $this->original_price - $this->price;
    }

    /**
     * Calculate savings percentage.
     */
    public function getSavingsPercentageAttribute(): float
    {
        if ($this->original_price <= 0 || $this->original_price <= $this->price) {
            return 0;
        }
        
        return round(($this->savings / $this->original_price) * 100, 2);
    }
}
