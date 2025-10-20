<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExpirationReminderLog extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'subscription_id',
        'reminder_type',
        'sent_at',
        'email_template_used',
        'recipient_email',
        'status',
        'error_message',
        'email_provider_id',
        'metadata',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'sent_at' => 'datetime',
        'metadata' => 'array',
    ];

    /**
     * Get the subscription this log belongs to.
     */
    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }

    /**
     * Scope for successful deliveries.
     */
    public function scopeDelivered($query)
    {
        return $query->whereIn('status', ['sent', 'delivered', 'opened', 'clicked']);
    }

    /**
     * Scope for failed deliveries.
     */
    public function scopeFailed($query)
    {
        return $query->whereIn('status', ['failed', 'bounced']);
    }

    /**
     * Scope by reminder type.
     */
    public function scopeByType($query, $type)
    {
        return $query->where('reminder_type', $type);
    }

    /**
     * Check if reminder was already sent for subscription and type.
     */
    public static function wasReminderSent($subscriptionId, $reminderType): bool
    {
        return static::where('subscription_id', $subscriptionId)
            ->where('reminder_type', $reminderType)
            ->exists();
    }

    /**
     * Log a reminder being sent.
     */
    public static function logReminder(
        $subscriptionId, 
        $reminderType, 
        $emailTemplate, 
        $recipientEmail, 
        $status = 'sent',
        $metadata = []
    ): self {
        return static::create([
            'subscription_id' => $subscriptionId,
            'reminder_type' => $reminderType,
            'sent_at' => now(),
            'email_template_used' => $emailTemplate,
            'recipient_email' => $recipientEmail,
            'status' => $status,
            'metadata' => $metadata,
        ]);
    }

    /**
     * Update delivery status.
     */
    public function updateStatus($status, $errorMessage = null, $emailProviderId = null): void
    {
        $this->update([
            'status' => $status,
            'error_message' => $errorMessage,
            'email_provider_id' => $emailProviderId,
        ]);
    }

    /**
     * Get reminder type as human readable text.
     */
    public function getReminderTypeTextAttribute(): string
    {
        return match($this->reminder_type) {
            '15_days' => '15 days before expiration',
            '10_days' => '10 days before expiration',
            '5_days' => '5 days before expiration',
            '1_day' => '1 day before expiration',
            'expired' => 'Subscription expired',
            default => $this->reminder_type,
        };
    }

    /**
     * Get status with color for UI display.
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'sent', 'delivered' => 'green',
            'opened', 'clicked' => 'blue',
            'failed', 'bounced' => 'red',
            default => 'gray',
        };
    }
}
