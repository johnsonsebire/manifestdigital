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
        // Subscription-related fields
        'is_subscription',
        'subscription_duration_months',
        'auto_renew_enabled',
        'minimum_billing_term_months',
        'grace_period_days',
        'prorated_billing',
        'early_termination_fee',
        'setup_fee',
        'cancellation_policy',
        'renewal_discount_percentage',
        'reminder_schedule',
        'custom_expiration_email_template',
        'subscription_metadata',
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
        // Subscription-related casts
        'is_subscription' => 'boolean',
        'auto_renew_enabled' => 'boolean',
        'prorated_billing' => 'boolean',
        'early_termination_fee' => 'decimal:2',
        'setup_fee' => 'decimal:2',
        'renewal_discount_percentage' => 'decimal:2',
        'reminder_schedule' => 'array',
        'subscription_metadata' => 'array',
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
     * Scope a query to subscription services only.
     */
    public function scopeSubscriptionOnly($query)
    {
        return $query->where('is_subscription', true);
    }

    /**
     * Scope a query to one-time services only.
     */
    public function scopeOneTimeOnly($query)
    {
        return $query->where('is_subscription', false);
    }

    /**
     * Scope services with active subscriptions.
     */
    public function scopeWithActiveSubscriptions($query)
    {
        return $query->whereHas('activeSubscriptions');
    }

    /**
     * Scope services with expiring subscriptions.
     */
    public function scopeWithExpiringSubscriptions($query)
    {
        return $query->whereHas('expiringSubscriptions');
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
     * Get the subscriptions for this service.
     */
    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * Get active subscriptions for this service.
     */
    public function activeSubscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class)
            ->where('status', 'active')
            ->where('expires_at', '>', now());
    }

    /**
     * Get expiring subscriptions (within reminder window).
     */
    public function expiringSubscriptions(): HasMany
    {
        $reminderDays = $this->getMaxReminderDays();
        
        return $this->hasMany(Subscription::class)
            ->where('status', 'active')
            ->whereBetween('expires_at', [now(), now()->addDays($reminderDays)]);
    }

    /**
     * Get subscription expiration reminders for this service.
     */
    public function expirationReminders(): HasMany
    {
        return $this->hasMany(ServiceExpirationReminder::class);
    }

    /**
     * Get the route key name for Laravel.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Get default reminder schedule for this service.
     */
    public function getDefaultReminderSchedule(): array
    {
        return $this->reminder_schedule ?: [
            'enabled' => true,
            'intervals' => ['15_days', '10_days', '5_days', '1_day'],
            'post_expiration' => ['expired'],
        ];
    }

    /**
     * Get maximum reminder days for query optimization.
     */
    public function getMaxReminderDays(): int
    {
        $schedule = $this->getDefaultReminderSchedule();
        $maxDays = 0;

        foreach ($schedule['intervals'] ?? [] as $interval) {
            $days = (int) str_replace('_days', '', $interval);
            if ($days > $maxDays) {
                $maxDays = $days;
            }
        }

        return $maxDays ?: 15; // Default to 15 days
    }

    /**
     * Check if service requires subscription management.
     */
    public function requiresSubscriptionManagement(): bool
    {
        return $this->is_subscription && $this->subscription_duration_months > 0;
    }

    /**
     * Get subscription duration in months.
     */
    public function getSubscriptionDurationAttribute(): ?int
    {
        return $this->is_subscription ? $this->subscription_duration_months : null;
    }

    /**
     * Get minimum billing term in months.
     */
    public function getMinimumBillingTermAttribute(): ?int
    {
        return $this->is_subscription ? ($this->minimum_billing_term_months ?: 1) : null;
    }

    /**
     * Get grace period in days.
     */
    public function getGracePeriodAttribute(): int
    {
        return $this->is_subscription ? ($this->grace_period_days ?: 0) : 0;
    }

    /**
     * Calculate subscription expiration date from start date.
     */
    public function calculateExpirationDate(\DateTime $startDate): \DateTime
    {
        if (!$this->is_subscription || !$this->subscription_duration_months) {
            throw new \InvalidArgumentException('Service is not a subscription or duration not set');
        }

        return (clone $startDate)->add(new \DateInterval("P{$this->subscription_duration_months}M"));
    }

    /**
     * Calculate renewal price with discount.
     */
    public function getRenewalPrice(): float
    {
        $basePrice = (float) $this->price;
        
        if ($this->renewal_discount_percentage && $this->renewal_discount_percentage > 0) {
            $discount = $basePrice * ($this->renewal_discount_percentage / 100);
            return $basePrice - $discount;
        }

        return $basePrice;
    }

    /**
     * Get cancellation policy text.
     */
    public function getCancellationPolicyText(): string
    {
        return $this->cancellation_policy ?: 'Standard cancellation policy applies.';
    }

    /**
     * Check if early termination fee applies.
     */
    public function hasEarlyTerminationFee(): bool
    {
        return $this->is_subscription && $this->early_termination_fee > 0;
    }

    /**
     * Check if setup fee applies.
     */
    public function hasSetupFee(): bool
    {
        return $this->setup_fee > 0;
    }

    /**
     * Get total initial cost (service price + setup fee).
     */
    public function getTotalInitialCost(): float
    {
        return (float) $this->price + (float) ($this->setup_fee ?: 0);
    }
}
