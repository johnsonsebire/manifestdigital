<?php

namespace App\Notifications;

use App\Models\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SubscriptionExpiringNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $subscription;
    public $reminderType;
    public $customTemplate;

    /**
     * Create a new notification instance.
     */
    public function __construct(Subscription $subscription, string $reminderType, ?string $customTemplate = null)
    {
        $this->subscription = $subscription;
        $this->reminderType = $reminderType;
        $this->customTemplate = $customTemplate;
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
        $daysRemaining = $this->getDaysRemaining();
        $service = $this->subscription->service;
        $order = $this->subscription->order;

        $subject = $this->getEmailSubject($daysRemaining);
        $greeting = $this->getEmailGreeting($notifiable, $daysRemaining);
        $renewalUrl = route('customer.subscriptions.renew', $this->subscription->uuid);

        $mailMessage = (new MailMessage)
            ->subject($subject)
            ->greeting($greeting)
            ->line($this->getExpirationMessage($daysRemaining))
            ->line("**Service:** {$service->title}")
            ->line("**Current Plan:** {$this->subscription->billing_interval}")
            ->line("**Expiration Date:** " . $this->subscription->expires_at->format('F j, Y'));

        // Add service-specific details
        if ($service->price > 0) {
            $priceInfo = $service->getPriceInfo();
            $mailMessage->line("**Renewal Price:** {$priceInfo['formatted']}");
            
            if ($service->renewal_discount_percentage > 0) {
                $renewalPrice = $service->getRenewalPrice();
                $mailMessage->line("**Renewal Discount:** {$service->renewal_discount_percentage}% off (${$renewalPrice})");
            }
        }

        // Add setup fee info if applicable
        if ($service->hasSetupFee()) {
            $mailMessage->line("*Setup fee waived for renewals");
        }

        // Custom message from service configuration
        if ($service->subscription_metadata && isset($service->subscription_metadata['renewal_message'])) {
            $mailMessage->line('')
                ->line($service->subscription_metadata['renewal_message']);
        }

        // Add renewal action button
        $mailMessage->action('Renew Subscription', $renewalUrl);

        // Add cancellation policy if exists
        if ($service->cancellation_policy) {
            $mailMessage->line('')
                ->line('**Cancellation Policy:**')
                ->line($service->getCancellationPolicyText());
        }

        // Footer
        $mailMessage->line('')
            ->line('If you have any questions about your subscription, please contact our support team.')
            ->line('Thank you for choosing our services!');

        return $mailMessage;
    }

    /**
     * Get the database representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'subscription_id' => $this->subscription->id,
            'subscription_uuid' => $this->subscription->uuid,
            'service_title' => $this->subscription->service->title,
            'reminder_type' => $this->reminderType,
            'days_remaining' => $this->getDaysRemaining(),
            'expires_at' => $this->subscription->expires_at,
            'renewal_url' => route('customer.subscriptions.renew', $this->subscription->uuid),
            'message' => $this->getExpirationMessage($this->getDaysRemaining()),
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return $this->toDatabase($notifiable);
    }

    /**
     * Get days remaining until expiration.
     */
    private function getDaysRemaining(): int
    {
        return now()->diffInDays($this->subscription->expires_at, false);
    }

    /**
     * Get email subject based on days remaining.
     */
    private function getEmailSubject(int $daysRemaining): string
    {
        $service = $this->subscription->service->title;

        if ($daysRemaining > 1) {
            return "Your {$service} subscription expires in {$daysRemaining} days";
        } elseif ($daysRemaining === 1) {
            return "Your {$service} subscription expires tomorrow";
        } else {
            return "Your {$service} subscription expires today";
        }
    }

    /**
     * Get email greeting.
     */
    private function getEmailGreeting(object $notifiable, int $daysRemaining): string
    {
        $name = $notifiable->name ?? 'Valued Customer';
        
        if ($daysRemaining > 1) {
            return "Hello {$name},";
        } else {
            return "Urgent: Hello {$name},";
        }
    }

    /**
     * Get expiration message based on days remaining.
     */
    private function getExpirationMessage(int $daysRemaining): string
    {
        if ($daysRemaining > 1) {
            return "This is a friendly reminder that your subscription will expire in {$daysRemaining} days. To ensure uninterrupted service, please renew your subscription before the expiration date.";
        } elseif ($daysRemaining === 1) {
            return "**Important:** Your subscription expires tomorrow. To avoid service interruption, please renew your subscription immediately.";
        } else {
            return "**Urgent:** Your subscription expires today. Please renew now to prevent service interruption.";
        }
    }

    /**
     * Get notification identifier for queuing.
     */
    public function uniqueId(): string
    {
        return "subscription-expiring-{$this->subscription->id}-{$this->reminderType}";
    }

    /**
     * Determine the time at which the job should timeout.
     */
    public function retryUntil(): \DateTime
    {
        return now()->addHours(24);
    }
}
