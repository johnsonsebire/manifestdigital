<?php

namespace App\Notifications;

use App\Models\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SubscriptionRenewedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $subscription;

    /**
     * Create a new notification instance.
     */
    public function __construct(Subscription $subscription)
    {
        $this->subscription = $subscription;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Subscription Renewed - ' . $this->subscription->service->title)
            ->markdown('emails.subscriptions.renewed', [
                'subscription' => $this->subscription,
            ]);
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable): array
    {
        return [
            'subscription_id' => $this->subscription->id,
            'subscription_uuid' => $this->subscription->uuid,
            'service_id' => $this->subscription->service_id,
            'service_title' => $this->subscription->service->title,
            'renewal_date' => $this->subscription->last_renewed_at?->toDateTimeString(),
            'new_expiration_date' => $this->subscription->expires_at->toDateTimeString(),
            'billing_amount' => $this->subscription->billing_amount,
            'currency' => $this->subscription->currency,
            'auto_renew' => $this->subscription->auto_renew,
            'message' => 'Your subscription has been successfully renewed.',
        ];
    }
}
