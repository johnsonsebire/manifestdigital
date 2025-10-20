<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Subscription extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'order_id',
        'service_id',
        'customer_id',
        'starts_at',
        'expires_at',
        'next_billing_date',
        'current_period_start',
        'current_period_end',
        'billing_interval',
        'minimum_term_months',
        'renewal_price',
        'renewal_discount_percentage',
        'auto_renew',
        'status',
        'trial_ends_at',
        'cancelled_at',
        'cancellation_reason',
        'custom_billing_terms',
        'metadata',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'next_billing_date' => 'datetime',
        'current_period_start' => 'datetime',
        'current_period_end' => 'datetime',
        'trial_ends_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'auto_renew' => 'boolean',
        'custom_billing_terms' => 'array',
        'metadata' => 'array',
        'renewal_price' => 'decimal:2',
        'renewal_discount_percentage' => 'decimal:2',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($subscription) {
            if (empty($subscription->uuid)) {
                $subscription->uuid = (string) Str::uuid();
            }
        });
    }

    /**
     * Get the order that created this subscription.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the service for this subscription.
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Get the customer for this subscription.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    /**
     * Get reminder logs for this subscription.
     */
    public function reminderLogs(): HasMany
    {
        return $this->hasMany(ExpirationReminderLog::class);
    }

    /**
     * Scope for active subscriptions.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope for expired subscriptions.
     */
    public function scopeExpired($query)
    {
        return $query->where('status', 'expired');
    }

    /**
     * Scope for subscriptions expiring soon.
     */
    public function scopeExpiringSoon($query, $days = 30)
    {
        return $query->where('expires_at', '<=', now()->addDays($days))
            ->where('expires_at', '>', now())
            ->where('status', 'active');
    }

    /**
     * Scope for subscriptions needing renewal reminders.
     */
    public function scopeNeedingReminders($query, $days)
    {
        return $query->where('expires_at', '=', now()->addDays($days)->toDateString())
            ->where('status', 'active');
    }

    /**
     * Check if subscription is active.
     */
    public function isActive(): bool
    {
        return $this->status === 'active' && $this->expires_at > now();
    }

    /**
     * Check if subscription is expired.
     */
    public function isExpired(): bool
    {
        return $this->expires_at <= now() || $this->status === 'expired';
    }

    /**
     * Check if subscription is in trial period.
     */
    public function isInTrial(): bool
    {
        return $this->trial_ends_at && $this->trial_ends_at > now();
    }

    /**
     * Get days until expiration.
     */
    public function getDaysUntilExpiration(): int
    {
        return max(0, now()->diffInDays($this->expires_at, false));
    }

    /**
     * Get days overdue.
     */
    public function getDaysOverdue(): int
    {
        return $this->isExpired() ? now()->diffInDays($this->expires_at) : 0;
    }

    /**
     * Calculate renewal price with discount.
     */
    public function getDiscountedRenewalPrice(): float
    {
        $basePrice = $this->renewal_price ?? $this->service->price;
        $discount = $basePrice * ($this->renewal_discount_percentage / 100);
        return $basePrice - $discount;
    }

    /**
     * Check if minimum term is satisfied.
     */
    public function canCancelEarly(): bool
    {
        if (!$this->minimum_term_months) {
            return true;
        }

        $minimumEndDate = $this->starts_at->addMonths($this->minimum_term_months);
        return now() >= $minimumEndDate;
    }

    /**
     * Get the route key name for Laravel.
     */
    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    /**
     * Mark subscription as expired.
     */
    public function markAsExpired(): void
    {
        $this->update([
            'status' => 'expired',
        ]);
    }

    /**
     * Cancel subscription.
     */
    public function cancel(string $reason = null): void
    {
        $this->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
            'cancellation_reason' => $reason,
            'auto_renew' => false,
        ]);
    }

    /**
     * Renew subscription for next period.
     */
    public function renew(int $periods = 1): void
    {
        $interval = $this->billing_interval;
        $newStart = $this->expires_at;
        
        switch ($interval) {
            case 'monthly':
                $newEnd = $newStart->copy()->addMonths($periods);
                break;
            case 'yearly':
                $newEnd = $newStart->copy()->addYears($periods);
                break;
            default:
                throw new \InvalidArgumentException("Cannot renew one-time subscription");
        }

        $this->update([
            'current_period_start' => $newStart,
            'current_period_end' => $newEnd,
            'expires_at' => $newEnd,
            'next_billing_date' => $newEnd,
            'status' => 'active',
        ]);
    }
}space App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    //
}
