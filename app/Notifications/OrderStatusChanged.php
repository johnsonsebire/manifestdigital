<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderStatusChanged extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Order $order,
        public string $oldStatus,
        public string $newStatus
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
        $statusMessages = [
            'pending' => 'Your order is pending review.',
            'approved' => 'Great news! Your order has been approved and a project has been created.',
            'processing' => 'Your order is being processed.',
            'completed' => 'Your order has been completed successfully!',
            'cancelled' => 'Your order has been cancelled.',
            'paid' => 'Payment received! Your order will be processed shortly.',
        ];

        $message = (new MailMessage)
            ->subject('Order #' . $this->order->id . ' Status Updated')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Your order status has been updated from **' . ucfirst($this->oldStatus) . '** to **' . ucfirst($this->newStatus) . '**.');

        if (isset($statusMessages[$this->newStatus])) {
            $message->line($statusMessages[$this->newStatus]);
        }

        $message->action('View Order', route('customer.orders.show', $this->order))
            ->line('Thank you for your business!');

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
            'order_id' => $this->order->id,
            'old_status' => $this->oldStatus,
            'new_status' => $this->newStatus,
            'message' => 'Order #' . $this->order->id . ' status changed to ' . ucfirst($this->newStatus),
        ];
    }
}
