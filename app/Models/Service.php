<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Service extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'title',
        'slug',
        'short_description',
        'long_description',
        'type',
        'price',
        'currency',
        'billing_interval',
        'metadata',
        'available',
        'visible',
        'created_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'metadata' => 'array',
        'available' => 'boolean',
        'visible' => 'boolean',
        'price' => 'decimal:2',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($service) {
            if (empty($service->uuid)) {
                $service->uuid = (string) Str::uuid();
            }
            if (empty($service->slug)) {
                $service->slug = Str::slug($service->title);
            }
        });

        static::updating(function ($service) {
            if ($service->isDirty('title') && !$service->isDirty('slug')) {
                $service->slug = Str::slug($service->title);
            }
            
            // Track price changes
            if ($service->isDirty('price') && $service->getOriginal('price')) {
                ServicePriceHistory::create([
                    'service_id' => $service->id,
                    'old_price' => $service->getOriginal('price'),
                    'new_price' => $service->price,
                    'currency' => $service->currency,
                    'changed_by' => auth()->id(),
                ]);
            }
        });
    }

    /**
     * Get the user who created this service.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the categories for this service.
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_service')
            ->withTimestamps();
    }

    /**
     * Get the variants for this service.
     */
    public function variants(): HasMany
    {
        return $this->hasMany(ServiceVariant::class)->orderBy('order');
    }

    /**
     * Get the price history for this service.
     */
    public function priceHistory(): HasMany
    {
        return $this->hasMany(ServicePriceHistory::class)->latest();
    }

    /**
     * Get the order items for this service.
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Scope a query to only include available services.
     */
    public function scopeAvailable($query)
    {
        return $query->where('available', true);
    }

    /**
     * Scope a query to only include visible services.
     */
    public function scopeVisible($query)
    {
        return $query->where('visible', true);
    }

    /**
     * Scope a query to filter by type.
     */
    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope a query to filter by category.
     */
    public function scopeInCategory($query, $categoryId)
    {
        return $query->whereHas('categories', function ($q) use ($categoryId) {
            $q->where('categories.id', $categoryId);
        });
    }

    /**
     * Get the public URL for this service.
     */
    public function getUrlAttribute(): string
    {
        return route('services.show', $this->slug);
    }

    /**
     * Get formatted price with currency detection.
     */
    public function getFormattedPriceAttribute(): string
    {
        if (app()->bound(\App\Services\CurrencyService::class)) {
            $currencyService = app(\App\Services\CurrencyService::class);
            $priceInfo = $currencyService->getServicePrice($this);
            return $priceInfo['formatted'];
        }
        
        return number_format($this->price, 2) . ' ' . $this->currency;
    }

    /**
     * Get localized price information.
     */
    public function getPriceInfo(): array
    {
        if (app()->bound(\App\Services\CurrencyService::class)) {
            $currencyService = app(\App\Services\CurrencyService::class);
            return $currencyService->getServicePrice($this);
        }
        
        return [
            'price' => $this->price,
            'currency' => \App\Models\Currency::where('code', $this->currency)->first() ?: new \App\Models\Currency(),
            'formatted' => $this->getFormattedPriceAttribute(),
            'is_regional' => false,
        ];
    }

    /**
     * Get the regional pricing for this service.
     */
    public function regionalPricing(): HasMany
    {
        return $this->hasMany(RegionalPricing::class);
    }

    /**
     * Get the route key name for Laravel.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
