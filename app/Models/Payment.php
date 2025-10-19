<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Payment extends Model
{
    use HasFactory, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
        'amount',
        'currency',
        'method',
        'gateway_response',
        'status',
        'reference',
        'paid_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'gateway_response' => 'array',
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    /**
     * Get the order this payment belongs to.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Scope a query to filter by status.
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope a query for successful payments.
     */
    public function scopeSucceeded($query)
    {
        return $query->where('status', 'succeeded');
    }

    /**
     * Check if payment was successful.
     */
    public function isSuccessful(): bool
    {
        return $this->status === 'succeeded';
    }

    /**
     * Check if payment failed.
     */
    public function isFailed(): bool
    {
        return $this->status === 'failed';
    }

    /**
     * Get formatted amount.
     */
    public function getFormattedAmountAttribute(): string
    {
        return number_format($this->amount, 2) . ' ' . $this->currency;
    }

    /**
     * Configure activity logging options.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'amount',
                'currency',
                'method',
                'status',
                'reference',
                'paid_at',
                'gateway_response'
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => match($eventName) {
                'created' => 'Payment initiated',
                'updated' => 'Payment status updated',
                'deleted' => 'Payment record deleted',
                default => "Payment {$eventName}",
            })
            ->useLogName('payments');
    }
}
