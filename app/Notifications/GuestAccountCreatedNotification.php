<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class GuestAccountCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $order;

    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $loginUrl = route('login');
        $passwordResetUrl = route('password.request');
        
        return (new MailMessage)
            ->subject('Welcome! Your account has been created')
            ->greeting("Hello {$notifiable->name},")
            ->line('Thank you for your order! Because your order includes subscription services, we\'ve created an account for you to manage your subscriptions.')
            ->line("**Order:** #{$this->order->uuid}")
            ->line("**Email:** {$notifiable->email}")
            ->line('')
            ->line('**To access your account:**')
            ->line('1. Click "Set Password" below to create your password')
            ->line('2. Use your email address to log in')
            ->line('3. Manage your subscriptions and view renewal dates')
            ->line('')
            ->action('Set Your Password', $passwordResetUrl)
            ->line('')
            ->line('**Your account includes access to:**')
            ->line('• Subscription management and renewal')
            ->line('• Order history and invoices')
            ->line('• Service updates and notifications')
            ->line('• Support ticket system')
            ->line('')
            ->line('If you already have an account with this email address, your order has been linked to your existing account.')
            ->line('')
            ->line('Questions? Contact our support team - we\'re here to help!')
            ->line('Welcome to our service!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'order_uuid' => $this->order->uuid,
            'account_created' => true,
            'message' => 'Account created for subscription management',
        ];
    }
}
