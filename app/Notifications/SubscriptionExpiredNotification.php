<?php

namespace App\Notifications;

use App\Models\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SubscriptionExpiredNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $subscription;
    public $gracePeriodDays;

    /**
     * Create a new notification instance.
     */
    public function __construct(Subscription $subscription, ?int $gracePeriodDays = null)
    {
        $this->subscription = $subscription;
        $this->gracePeriodDays = $gracePeriodDays ?? $subscription->service->getGracePeriodAttribute();
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $service = $this->subscription->service;
        $daysExpired = now()->diffInDays($this->subscription->expires_at);
        $renewalUrl = route('customer.subscriptions.renew', $this->subscription->uuid);

        $mailMessage = (new MailMessage)
            ->subject("Your {$service->title} subscription has expired")
            ->greeting("Hello {$notifiable->name},")
            ->line($this->getExpirationMessage($daysExpired))
            ->line("**Service:** {$service->title}")
            ->line("**Expired On:** " . $this->subscription->expires_at->format('F j, Y'))
            ->line("**Days Since Expiration:** {$daysExpired}");

        // Grace period information
        if ($this->gracePeriodDays > 0) {
            $gracePeriodEnd = $this->subscription->expires_at->addDays($this->gracePeriodDays);
            $graceDaysRemaining = now()->diffInDays($gracePeriodEnd, false);
            
            if ($graceDaysRemaining > 0) {
                $mailMessage->line("**Grace Period:** {$graceDaysRemaining} days remaining until service suspension");
            } else {
                $mailMessage->line("**Service Status:** Suspended (grace period ended)");
            }
        } else {
            $mailMessage->line("**Service Status:** Suspended");
        }

        // Renewal pricing
        if ($service->price > 0) {
            $priceInfo = $service->getPriceInfo();
            $mailMessage->line("**Renewal Price:** {$priceInfo['formatted']}");
            
            if ($service->renewal_discount_percentage > 0) {
                $renewalPrice = $service->getRenewalPrice();
                $mailMessage->line("**Renewal Discount:** {$service->renewal_discount_percentage}% off (${$renewalPrice})");
            }
        }

        // Early termination fee if applicable
        if ($service->hasEarlyTerminationFee() && $this->subscription->hasEarlyTerminationFee()) {
            $mailMessage->line("**Note:** Early termination fee may apply for minimum term violations.");
        }

        // Renewal action
        $mailMessage->action('Renew Now', $renewalUrl);

        // Data retention warning
        if ($service->subscription_metadata && isset($service->subscription_metadata['data_retention_days'])) {
            $retentionDays = $service->subscription_metadata['data_retention_days'];
            $dataDeleteDate = $this->subscription->expires_at->addDays($retentionDays);
            
            $mailMessage->line('')
                ->line("**Important:** Your service data will be permanently deleted on " . $dataDeleteDate->format('F j, Y') . " if not renewed.");
        }

        // Support information
        $mailMessage->line('')
            ->line('If you have any questions or need assistance with your renewal, please contact our support team.')
            ->line('We value your business and hope to continue serving you.');

        return $mailMessage;
    }

    /**
     * Get the database representation of the notification.
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'subscription_id' => $this->subscription->id,
            'subscription_uuid' => $this->subscription->uuid,
            'service_title' => $this->subscription->service->title,
            'expired_at' => $this->subscription->expires_at,
            'days_expired' => now()->diffInDays($this->subscription->expires_at),
            'grace_period_days' => $this->gracePeriodDays,
            'renewal_url' => route('customer.subscriptions.renew', $this->subscription->uuid),
            'status' => 'expired',
        ];
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return $this->toDatabase($notifiable);
    }

    /**
     * Get expiration message based on days expired.
     */
    private function getExpirationMessage(int $daysExpired): string
    {
        if ($daysExpired === 0) {
            return "Your subscription expired today. To restore your service access, please renew your subscription immediately.";
        } elseif ($daysExpired === 1) {
            return "Your subscription expired yesterday. Your service access has been suspended. Please renew to restore access.";
        } else {
            return "Your subscription expired {$daysExpired} days ago. Your service access has been suspended. Please renew to restore access.";
        }
    }

    /**
     * Get notification identifier for queuing.
     */
    public function uniqueId(): string
    {
        return "subscription-expired-{$this->subscription->id}";
    }

    /**
     * Determine the time at which the job should timeout.
     */
    public function retryUntil(): \DateTime
    {
        return now()->addHours(24);
    }
}
