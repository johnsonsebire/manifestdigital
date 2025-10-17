<?php

namespace App\Notifications;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InvoiceSent extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Invoice $invoice
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
        return (new MailMessage)
            ->subject('Invoice ' . $this->invoice->invoice_number . ' - Payment Due')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('You have received a new invoice for your order.')
            ->line('**Invoice Number:** ' . $this->invoice->invoice_number)
            ->line('**Amount Due:** $' . number_format($this->invoice->total_amount, 2))
            ->line('**Due Date:** ' . $this->invoice->due_date->format('F d, Y'))
            ->action('View Invoice', route('customer.invoices.show', $this->invoice))
            ->line('Please make payment before the due date to avoid any delays.')
            ->line('Thank you for your business!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'invoice_id' => $this->invoice->id,
            'invoice_number' => $this->invoice->invoice_number,
            'amount' => $this->invoice->total_amount,
            'due_date' => $this->invoice->due_date->toDateString(),
            'message' => 'Invoice ' . $this->invoice->invoice_number . ' has been sent',
        ];
    }
}
