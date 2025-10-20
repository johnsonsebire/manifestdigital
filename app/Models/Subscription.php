<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid', 'order_id', 'service_id', 'customer_id', 'starts_at', 'expires_at',
        'next_billing_date', 'current_period_start', 'current_period_end',
        'billing_interval', 'minimum_term_months', 'renewal_price', 
        'renewal_discount_percentage', 'auto_renew', 'status', 'trial_ends_at',
        'cancelled_at', 'cancellation_reason', 'custom_billing_terms', 'metadata',
    ];

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

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($subscription) {
            if (empty($subscription->uuid)) {
                $subscription->uuid = (string) Str::uuid();
            }
        });
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function isActive(): bool
    {
        return $this->status === 'active' && $this->expires_at > now();
    }

    public function isExpired(): bool
    {
        return $this->expires_at <= now() || $this->status === 'expired';
    }

    public function getDaysUntilExpiration(): int
    {
        return max(0, now()->diffInDays($this->expires_at, false));
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }
}