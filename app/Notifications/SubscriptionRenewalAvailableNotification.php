<?php

namespace App\Notifications;

use App\Models\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SubscriptionRenewalAvailableNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $subscription;
    public $earlyRenewalDiscount;
    public $customMessage;

    /**
     * Create a new notification instance.
     */
    public function __construct(Subscription $subscription, ?float $earlyRenewalDiscount = null, ?string $customMessage = null)
    {
        $this->subscription = $subscription;
        $this->earlyRenewalDiscount = $earlyRenewalDiscount;
        $this->customMessage = $customMessage;
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
        $daysUntilExpiration = now()->diffInDays($this->subscription->expires_at, false);
        $renewalUrl = route('customer.subscriptions.renew', $this->subscription->uuid);

        $mailMessage = (new MailMessage)
            ->subject("Early Renewal Available for {$service->title}")
            ->greeting("Hello {$notifiable->name},")
            ->line($this->getIntroductionMessage($daysUntilExpiration));

        // Service details
        $mailMessage->line("**Current Service:** {$service->title}")
            ->line("**Current Expiration:** " . $this->subscription->expires_at->format('F j, Y'))
            ->line("**Time Remaining:** {$daysUntilExpiration} days");

        // Pricing information
        $priceInfo = $service->getPriceInfo();
        $basePrice = (float) $service->price;
        $renewalPrice = $service->getRenewalPrice();

        $mailMessage->line("**Regular Renewal Price:** {$priceInfo['formatted']}");

        // Early renewal discount
        if ($this->earlyRenewalDiscount && $this->earlyRenewalDiscount > 0) {
            $discountAmount = $basePrice * ($this->earlyRenewalDiscount / 100);
            $earlyPrice = $basePrice - $discountAmount;
            
            $mailMessage->line("**Early Renewal Discount:** {$this->earlyRenewalDiscount}% off")
                ->line("**Early Renewal Price:** $" . number_format($earlyPrice, 2));
        } elseif ($service->renewal_discount_percentage > 0) {
            $mailMessage->line("**Renewal Discount:** {$service->renewal_discount_percentage}% off")
                ->line("**Your Renewal Price:** $" . number_format($renewalPrice, 2));
        }

        // Benefits of early renewal
        $mailMessage->line('')
            ->line('**Benefits of Early Renewal:**')
            ->line('• Avoid service interruption')
            ->line('• Lock in current pricing')
            ->line('• No setup fees for renewals');

        if ($service->hasSetupFee()) {
            $mailMessage->line("• Save {$service->setup_fee} in setup fees");
        }

        // Extension information
        if ($daysUntilExpiration > 0) {
            $newExpirationDate = $this->subscription->expires_at->addMonths($service->subscription_duration_months);
            $mailMessage->line("• Extend your service until " . $newExpirationDate->format('F j, Y'));
        }

        // Custom message from admin
        if ($this->customMessage) {
            $mailMessage->line('')
                ->line('**Special Message:**')
                ->line($this->customMessage);
        }

        // Service-specific renewal message
        if ($service->subscription_metadata && isset($service->subscription_metadata['early_renewal_message'])) {
            $mailMessage->line('')
                ->line($service->subscription_metadata['early_renewal_message']);
        }

        // Call to action
        $mailMessage->action('Renew Early Now', $renewalUrl);

        // Additional information
        $mailMessage->line('')
            ->line('You can renew at any time before your current subscription expires. Early renewals will extend your current subscription period.')
            ->line('Questions? Our support team is here to help!')
            ->line('Thank you for your continued trust in our services.');

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
            'expires_at' => $this->subscription->expires_at,
            'days_until_expiration' => now()->diffInDays($this->subscription->expires_at, false),
            'early_renewal_discount' => $this->earlyRenewalDiscount,
            'renewal_url' => route('customer.subscriptions.renew', $this->subscription->uuid),
            'type' => 'early_renewal_available',
            'custom_message' => $this->customMessage,
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
     * Get introduction message based on time until expiration.
     */
    private function getIntroductionMessage(int $daysUntilExpiration): string
    {
        if ($daysUntilExpiration > 30) {
            return "Good news! Early renewal is now available for your subscription. Renew now to lock in your current pricing and avoid any service interruption.";
        } elseif ($daysUntilExpiration > 7) {
            return "Your subscription renewal window is open! Renew early to ensure uninterrupted service and take advantage of renewal benefits.";
        } else {
            return "Your subscription expires soon. Renew now to avoid service interruption and secure your continued access.";
        }
    }

    /**
     * Get notification identifier for queuing.
     */
    public function uniqueId(): string
    {
        return "subscription-renewal-available-{$this->subscription->id}";
    }

    /**
     * Determine the time at which the job should timeout.
     */
    public function retryUntil(): \DateTime
    {
        return now()->addHours(24);
    }
}
