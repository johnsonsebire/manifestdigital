<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceExpirationReminder extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'service_id',
        'customer_id',
        'reminder_days_before',
        'email_template',
        'is_active',
        'custom_schedule',
        'custom_message',
        'metadata',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'reminder_days_before' => 'array',
        'custom_schedule' => 'array',
        'metadata' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'reminder_days_before' => '[15, 10, 5, 0]',
        'is_active' => true,
    ];

    /**
     * Get the service this reminder belongs to.
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Get the customer this reminder is for (null = service default).
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    /**
     * Scope for active reminders.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for service defaults (no specific customer).
     */
    public function scopeServiceDefaults($query)
    {
        return $query->whereNull('customer_id');
    }

    /**
     * Scope for customer-specific reminders.
     */
    public function scopeCustomerSpecific($query)
    {
        return $query->whereNotNull('customer_id');
    }

    /**
     * Get reminder schedule for a specific customer or service default.
     */
    public static function getReminderSchedule($serviceId, $customerId = null): array
    {
        // First try to get customer-specific reminder
        if ($customerId) {
            $reminder = static::where('service_id', $serviceId)
                ->where('customer_id', $customerId)
                ->active()
                ->first();
            
            if ($reminder) {
                return $reminder->reminder_days_before;
            }
        }

        // Fall back to service default
        $serviceDefault = static::where('service_id', $serviceId)
            ->whereNull('customer_id')
            ->active()
            ->first();

        return $serviceDefault ? $serviceDefault->reminder_days_before : [15, 10, 5, 0];
    }

    /**
     * Check if reminders should be sent for given days before expiration.
     */
    public function shouldSendReminderFor(int $daysBeforeExpiration): bool
    {
        return in_array($daysBeforeExpiration, $this->reminder_days_before);
    }

    /**
     * Get the email template to use for reminders.
     */
    public function getEmailTemplate(int $daysBeforeExpiration): string
    {
        if ($this->email_template) {
            return $this->email_template;
        }

        // Default template based on days before expiration
        return match($daysBeforeExpiration) {
            15 => 'emails.subscription.expiring-15-days',
            10 => 'emails.subscription.expiring-10-days',
            5 => 'emails.subscription.expiring-5-days',
            0 => 'emails.subscription.expired',
            default => 'emails.subscription.expiring-general',
        };
    }
}
