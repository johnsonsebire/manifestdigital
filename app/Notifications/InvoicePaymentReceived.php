<?php

namespace App\Notifications;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InvoicePaymentReceived extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Invoice $invoice,
        public float $amount
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
            ->subject('Payment Received - Invoice ' . $this->invoice->invoice_number)
            ->view('emails.invoice-payment-received', [
                'notifiable' => $notifiable,
                'invoice' => $this->invoice,
                'amount' => $this->amount,
            ]);
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
            'payment_amount' => $this->amount,
            'balance_due' => $this->invoice->balance_due,
            'is_fully_paid' => $this->invoice->balance_due <= 0,
            'message' => 'Payment of $' . number_format($this->amount, 2) . ' received for invoice ' . $this->invoice->invoice_number,
        ];
    }
}
