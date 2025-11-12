<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SubscriptionStatusUpdateReport extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public array $reportData
    ) {}

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
        $stats = $this->reportData['stats'];
        $date = $this->reportData['date'];

        $message = (new MailMessage)
            ->subject('Subscription Status Update Report - ' . now()->format('M d, Y'))
            ->greeting('Hello Administrator,')
            ->line('The automatic subscription status update has completed.')
            ->line("**Execution Time:** {$date}")
            ->line('')
            ->line('**Summary:**')
            ->line("- Total Processed: {$stats['total_processed']}")
            ->line("- Expired: {$stats['expired']}")
            ->line("- Suspended: {$stats['suspended']}")
            ->line("- Notifications Sent: {$stats['notifications_sent']}")
            ->line("- Errors: {$stats['errors']}");

        if ($stats['errors'] > 0) {
            $message->line('')
                ->line('⚠️ **Warning:** Some subscriptions encountered errors during processing.')
                ->line('Please check the application logs for details.');
        }

        $message->action('View Subscriptions', route('admin.subscriptions.index'))
            ->line('Thank you for using our subscription management system!');

        return $message;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'subscription_status_update_report',
            'date' => $this->reportData['date'],
            'stats' => $this->reportData['stats'],
            'message' => 'Subscription status update completed',
        ];
    }

    /**
     * Get the database representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        return $this->toArray($notifiable);
    }
}
