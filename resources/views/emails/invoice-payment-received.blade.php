@extends('emails.layouts.app')

@section('title', 'Payment Confirmation')

@section('content')
    <div class="greeting">Hello {{ $notifiable->name }}!</div>
    
    <div class="content-text">
        Great news! We have received your payment for invoice <strong>{{ $invoice->invoice_number }}</strong>. Thank you for your prompt payment!
    </div>
    
    <div class="highlight-box" style="background-color: #d1fae5; border-left-color: #10b981;">
        <strong>✓ Payment Confirmed</strong><br>
        Your payment has been successfully processed and your invoice is now marked as paid.
    </div>
    
    <table class="info-table">
        <tr>
            <th>Payment Details</th>
            <th>Information</th>
        </tr>
        <tr>
            <td><strong>Invoice Number</strong></td>
            <td>{{ $invoice->invoice_number }}</td>
        </tr>
        <tr>
            <td><strong>Payment Date</strong></td>
            <td>{{ $invoice->paid_at ? $invoice->paid_at->format('F d, Y g:i A') : now()->format('F d, Y g:i A') }}</td>
        </tr>
        <tr>
            <td><strong>Amount Paid</strong></td>
            <td style="font-size: 18px; font-weight: 600; color: #10b981;">{{ $invoice->getCurrencySymbol() }}{{ number_format($invoice->amount_paid, 2) }}</td>
        </tr>
        @if($invoice->balance_due > 0)
        <tr>
            <td><strong>Remaining Balance</strong></td>
            <td style="font-weight: 600; color: #f59e0b;">{{ $invoice->getCurrencySymbol() }}{{ number_format($invoice->balance_due, 2) }}</td>
        </tr>
        @endif
        <tr>
            <td><strong>Status</strong></td>
            <td><span class="status-badge status-paid">Paid</span></td>
        </tr>
    </table>
    
    @if($invoice->order_id)
    <div class="content-text">
        <strong>What's Next?</strong><br>
        Now that your payment has been received, we'll begin processing your order immediately. You'll receive updates as we progress through each stage.
    </div>
    @endif
    
    <div class="button-container">
        <a href="{{ app()->environment('local', 'staging') ? '#invoice-receipt' : route('customer.invoices.show', $invoice) }}" class="email-button">
            View Invoice Receipt
        </a>
    </div>
    
    @if($invoice->balance_due <= 0)
    <div class="content-text">
        This invoice is now fully paid. You can download your receipt from the customer portal at any time for your records.
    </div>
    @else
    <div class="content-text">
        <strong>Partial Payment Received:</strong> This invoice still has a remaining balance of {{ $invoice->getCurrencySymbol() }}{{ number_format($invoice->balance_due, 2) }}. Please make the remaining payment at your earliest convenience.
    </div>
    @endif
@endsection