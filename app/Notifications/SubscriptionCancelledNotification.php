<?php

namespace App\Notifications;

use App\Models\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SubscriptionCancelledNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $subscription;
    public $cancellationReason;
    public $effectiveDate;
    public $refundAmount;
    public $dataRetentionDays;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        Subscription $subscription, 
        ?string $cancellationReason = null, 
        ?\DateTime $effectiveDate = null,
        ?float $refundAmount = null,
        ?int $dataRetentionDays = null
    ) {
        $this->subscription = $subscription;
        $this->cancellationReason = $cancellationReason;
        $this->effectiveDate = $effectiveDate;
        $this->refundAmount = $refundAmount;
        $this->dataRetentionDays = $dataRetentionDays;
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
        $effectiveDate = $this->effectiveDate ?? $this->subscription->cancelled_at ?? now();
        $originalExpiration = $this->subscription->expires_at;

        $mailMessage = (new MailMessage)
            ->subject("Subscription Cancelled: {$service->title}")
            ->greeting("Hello {$notifiable->name},")
            ->line($this->getCancellationMessage($effectiveDate));

        // Subscription details
        $mailMessage->line("**Service:** {$service->title}")
            ->line("**Subscription ID:** {$this->subscription->uuid}")
            ->line("**Cancellation Date:** " . $effectiveDate->format('F j, Y'))
            ->line("**Original Expiration:** " . $originalExpiration->format('F j, Y'));

        // Cancellation reason if provided
        if ($this->cancellationReason) {
            $mailMessage->line("**Reason:** {$this->cancellationReason}");
        }

        // Service access information
        if ($effectiveDate->isPast()) {
            $mailMessage->line("**Service Status:** Access has been suspended");
        } else {
            $daysRemaining = now()->diffInDays($effectiveDate, false);
            $mailMessage->line("**Service Access:** Continues until " . $effectiveDate->format('F j, Y') . " ({$daysRemaining} days remaining)");
        }

        // Refund information
        if ($this->refundAmount && $this->refundAmount > 0) {
            $mailMessage->line("")
                ->line("**Refund Information:**")
                ->line("A refund of $" . number_format($this->refundAmount, 2) . " will be processed within 5-7 business days.")
                ->line("The refund will be credited to your original payment method.");
        }

        // Early termination fee if applicable
        if ($service->hasEarlyTerminationFee() && $this->subscription->hasEarlyTerminationFee()) {
            $terminationFee = $service->early_termination_fee;
            $mailMessage->line("")
                ->line("**Early Termination Fee:**")
                ->line("A fee of $" . number_format($terminationFee, 2) . " applies for cancellation before the minimum term completion.")
                ->line("This fee will be charged to your payment method on file.");
        }

        // Data retention information
        $retentionDays = $this->dataRetentionDays ?? 
            ($service->subscription_metadata['data_retention_days'] ?? 30);
        
        if ($retentionDays > 0) {
            $dataDeleteDate = $effectiveDate->clone()->addDays($retentionDays);
            $mailMessage->line("")
                ->line("**Data Retention:**")
                ->line("Your service data will be retained until " . $dataDeleteDate->format('F j, Y') . ".")
                ->line("After this date, all data will be permanently deleted and cannot be recovered.")
                ->line("If you wish to reactivate your service, please do so before this date.");
        }

        // Reactivation information
        if (!$effectiveDate->isPast()) {
            $reactivateUrl = route('customer.subscriptions.reactivate', $this->subscription->uuid);
            $mailMessage->action('Reactivate Subscription', $reactivateUrl);
            $mailMessage->line("You can reactivate your subscription at any time before the cancellation effective date.");
        } else {
            $renewUrl = route('customer.subscriptions.renew', $this->subscription->uuid);
            $mailMessage->action('Subscribe Again', $renewUrl);
        }

        // Export data option
        if ($retentionDays > 0) {
            $exportUrl = route('customer.subscriptions.export-data', $this->subscription->uuid);
            $mailMessage->line("")
                ->line("Need your data? You can export all your service data before the deletion date.")
                ->action('Export My Data', $exportUrl);
        }

        // Feedback request
        $feedbackUrl = route('customer.feedback.create', ['subscription' => $this->subscription->uuid]);
        $mailMessage->line("")
            ->line("We're sorry to see you go. Your feedback helps us improve our services.")
            ->action('Share Feedback', $feedbackUrl);

        // Footer
        $mailMessage->line("")
            ->line("If you have any questions about this cancellation or need assistance, please contact our support team.")
            ->line("Thank you for choosing our services. We hope to serve you again in the future.");

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
            'cancelled_at' => $this->subscription->cancelled_at,
            'effective_date' => $this->effectiveDate,
            'cancellation_reason' => $this->cancellationReason,
            'refund_amount' => $this->refundAmount,
            'data_retention_days' => $this->dataRetentionDays,
            'status' => 'cancelled',
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
     * Get cancellation message based on effective date.
     */
    private function getCancellationMessage(\DateTime $effectiveDate): string
    {
        if ($effectiveDate->isPast()) {
            return "Your subscription has been cancelled and service access has been suspended.";
        } else {
            $daysRemaining = now()->diffInDays($effectiveDate, false);
            return "Your subscription cancellation has been processed. Your service will remain active until {$effectiveDate->format('F j, Y')} ({$daysRemaining} days remaining).";
        }
    }

    /**
     * Get notification identifier for queuing.
     */
    public function uniqueId(): string
    {
        return "subscription-cancelled-{$this->subscription->id}";
    }

    /**
     * Determine the time at which the job should timeout.
     */
    public function retryUntil(): \DateTime
    {
        return now()->addHours(24);
    }
}
