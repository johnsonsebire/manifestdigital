@extends('emails.layouts.app')

@section('title', 'Invoice Notification')

@section('content')
    <div class="greeting">Hello {{ $notifiable->name }}!</div>
    
    <div class="content-text">
        You have received a new invoice for your order. Please review the details below and make payment before the due date.
    </div>
    
    <table class="info-table">
        <tr>
            <th>Invoice Details</th>
            <th>Information</th>
        </tr>
        <tr>
            <td><strong>Invoice Number</strong></td>
            <td>{{ $invoice->invoice_number }}</td>
        </tr>
        <tr>
            <td><strong>Invoice Date</strong></td>
            <td>{{ $invoice->invoice_date->format('F d, Y') }}</td>
        </tr>
        <tr>
            <td><strong>Due Date</strong></td>
            <td>
                {{ $invoice->due_date->format('F d, Y') }}
                @if($invoice->isOverdue())
                    <span class="status-badge status-overdue">Overdue</span>
                @elseif($invoice->due_date->isToday())
                    <span class="status-badge status-pending">Due Today</span>
                @elseif($invoice->due_date->isTomorrow())
                    <span class="status-badge status-pending">Due Tomorrow</span>
                @endif
            </td>
        </tr>
        <tr>
            <td><strong>Amount Due</strong></td>
            <td style="font-size: 18px; font-weight: 600; color: #FF4900;">{{ $invoice->getCurrencySymbol() }}{{ number_format($invoice->total_amount, 2) }}</td>
        </tr>
        <tr>
            <td><strong>Status</strong></td>
            <td><span class="status-badge status-{{ $invoice->status }}">{{ ucfirst($invoice->status) }}</span></td>
        </tr>
    </table>
    
    @if($invoice->subtotal && $invoice->usesMultiTaxSystem())
        <div class="content-text">
            <strong>Invoice Breakdown:</strong>
        </div>
        
        <table class="info-table">
            <tr>
                <td><strong>Subtotal</strong></td>
                <td>{{ $invoice->getCurrencySymbol() }}{{ number_format($invoice->subtotal, 2) }}</td>
            </tr>
            @php
                $taxBreakdown = $invoice->getFormattedTaxBreakdown();
            @endphp
            @foreach($taxBreakdown as $tax)
            <tr>
                <td><strong>{{ $tax['name'] }} ({{ $tax['rate'] }}%)</strong></td>
                <td>{{ $invoice->getCurrencySymbol() }}{{ number_format($tax['amount'], 2) }}</td>
            </tr>
            @endforeach
            @if($invoice->additional_fees > 0)
            <tr>
                <td><strong>Additional Fees</strong></td>
                <td>{{ $invoice->getCurrencySymbol() }}{{ number_format($invoice->additional_fees, 2) }}</td>
            </tr>
            @endif
            <tr style="border-top: 2px solid #e5e7eb;">
                <td><strong>Total Amount</strong></td>
                <td style="font-weight: 600; color: #FF4900;">{{ $invoice->getCurrencySymbol() }}{{ number_format($invoice->total_amount, 2) }}</td>
            </tr>
        </table>
    @endif
    
    <div class="button-container">
        <a href="{{ app()->environment('local', 'staging') ? '#invoice-details' : route('customer.invoices.show', $invoice) }}" class="email-button">
            View & Pay Invoice
        </a>
    </div>
    
    <div class="highlight-box">
        <strong>Payment Instructions:</strong><br>
        Please make payment before the due date to avoid any delays in processing your order. You can view the full invoice and make payment through your customer portal.
    </div>
    
    @if($invoice->notes)
    <div class="content-text">
        <strong>Additional Notes:</strong><br>
        {{ $invoice->notes }}
    </div>
    @endif
@endsection