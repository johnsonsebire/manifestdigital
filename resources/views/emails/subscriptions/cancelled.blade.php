@extends('emails.layouts.app')

@section('title', 'Subscription Cancelled')
@section('tagline', 'Cancellation Confirmation')

@section('content')
<div class="greeting">
    Hello {{ $subscription->customer->name }},
</div>

@php
    $effectiveDate = $effectiveDate ?? $subscription->cancelled_at ?? now();
    $isPastCancellation = $effectiveDate->isPast();
    $daysRemaining = $isPastCancellation ? 0 : now()->diffInDays($effectiveDate, false);
@endphp

<div class="content-text">
    @if($isPastCancellation)
        Your subscription has been cancelled and service access has been suspended.
    @else
        Your subscription cancellation has been processed. Your service will remain active until 
        <strong>{{ $effectiveDate->format('F j, Y') }}</strong> ({{ $daysRemaining }} {{ Str::plural('day', $daysRemaining) }} remaining).
    @endif
</div>

<div class="highlight-box" style="background-color: #fee2e2; border-left-color: #dc2626;">
    <div style="font-size: 18px; font-weight: 600; color: #991b1b; margin-bottom: 12px;">
        @if($isPastCancellation)
            🛑 Subscription Cancelled
        @else
            ⏰ Cancellation Scheduled
        @endif
    </div>
    <div style="color: #991b1b;">
        @if($isPastCancellation)
            Your service access has been suspended.
        @else
            Your subscription will be cancelled on {{ $effectiveDate->format('F j, Y') }}.
        @endif
    </div>
</div>

<table class="info-table">
    <tr>
        <th>Cancellation Details</th>
        <th></th>
    </tr>
    <tr>
        <td><strong>Service</strong></td>
        <td>{{ $subscription->service->title }}</td>
    </tr>
    <tr>
        <td><strong>Subscription ID</strong></td>
        <td><code style="font-family: monospace; font-size: 12px;">{{ $subscription->uuid }}</code></td>
    </tr>
    <tr>
        <td><strong>Cancellation Date</strong></td>
        <td>{{ ($subscription->cancelled_at ?? now())->format('F j, Y') }}</td>
    </tr>
    <tr>
        <td><strong>Effective Date</strong></td>
        <td style="font-weight: 600;">{{ $effectiveDate->format('F j, Y') }}</td>
    </tr>
    <tr>
        <td><strong>Original Expiration</strong></td>
        <td>{{ $subscription->expires_at->format('F j, Y') }}</td>
    </tr>
    @if(isset($cancellationReason) && $cancellationReason)
    <tr>
        <td><strong>Reason</strong></td>
        <td>{{ $cancellationReason }}</td>
    </tr>
    @endif
    <tr>
        <td><strong>Service Status</strong></td>
        <td>
            @if($isPastCancellation)
                <span class="status-badge status-cancelled">Access Suspended</span>
            @else
                <span class="status-badge status-pending">Active Until {{ $effectiveDate->format('M j') }}</span>
            @endif
        </td>
    </tr>
</table>

@if(!$isPastCancellation)
<div class="highlight-box" style="background-color: #dbeafe; border-left-color: #2563eb;">
    <div style="color: #1e40af;">
        <strong>ℹ️ Service Access</strong><br>
        You continue to have full access to your service until {{ $effectiveDate->format('F j, Y') }}. 
        After this date, your access will be suspended.
    </div>
</div>
@endif

@php
    $service = $subscription->service;
@endphp

@if(isset($refundAmount) && $refundAmount > 0)
<div class="content-text">
    <strong>Refund Information:</strong>
</div>

<table class="info-table">
    <tr>
        <td><strong>Refund Amount</strong></td>
        <td style="font-size: 18px; color: #059669; font-weight: 700;">
            ${{ number_format($refundAmount, 2) }}
        </td>
    </tr>
    <tr>
        <td><strong>Processing Time</strong></td>
        <td>5-7 business days</td>
    </tr>
    <tr>
        <td><strong>Refund Method</strong></td>
        <td>Original payment method</td>
    </tr>
</table>

<div class="highlight-box" style="background-color: #d1fae5; border-left-color: #059669;">
    <div style="color: #065f46;">
        A refund of ${{ number_format($refundAmount, 2) }} will be processed within 5-7 business days 
        and credited to your original payment method.
    </div>
</div>
@endif

@if($service->hasEarlyTerminationFee() && $subscription->hasEarlyTerminationFee())
<div class="content-text">
    <strong>Early Termination Fee:</strong>
</div>

<table class="info-table">
    <tr>
        <td><strong>Fee Amount</strong></td>
        <td style="font-size: 18px; color: #dc2626; font-weight: 700;">
            ${{ number_format($service->early_termination_fee, 2) }}
        </td>
    </tr>
    <tr>
        <td><strong>Reason</strong></td>
        <td>Cancellation before minimum term completion</td>
    </tr>
    <tr>
        <td><strong>Charge Date</strong></td>
        <td>Within 3-5 business days</td>
    </tr>
</table>

<div class="highlight-box" style="background-color: #fee2e2; border-left-color: #dc2626;">
    <div style="color: #991b1b;">
        <strong>⚠️ Early Termination Fee Notice</strong><br>
        A fee of ${{ number_format($service->early_termination_fee, 2) }} applies for cancellation 
        before the minimum term completion. This fee will be charged to your payment method on file.
    </div>
</div>
@endif

@php
    $retentionDays = $dataRetentionDays ?? $service->subscription_metadata['data_retention_days'] ?? 30;
    $dataDeleteDate = $effectiveDate->copy()->addDays($retentionDays);
@endphp

@if($retentionDays > 0)
<div class="content-text">
    <strong>Data Retention:</strong>
</div>

<table class="info-table">
    <tr>
        <td><strong>Data Retention Period</strong></td>
        <td>{{ $retentionDays }} {{ Str::plural('day', $retentionDays) }}</td>
    </tr>
    <tr>
        <td><strong>Data Deletion Date</strong></td>
        <td style="color: #dc2626; font-weight: 600;">
            {{ $dataDeleteDate->format('F j, Y') }}
        </td>
    </tr>
    <tr>
        <td><strong>What Gets Deleted</strong></td>
        <td>All service data and configurations</td>
    </tr>
</table>

<div class="highlight-box" style="background-color: #fef3c7; border-left-color: #f59e0b;">
    <div style="color: #92400e;">
        <strong>📁 Important Data Notice</strong><br>
        Your service data will be retained until <strong>{{ $dataDeleteDate->format('F j, Y') }}</strong>. 
        After this date, all data will be <strong>permanently deleted</strong> and cannot be recovered.
        @if(!$isPastCancellation)
        <br><br>
        If you wish to reactivate your service, please do so before this date to preserve your data.
        @endif
    </div>
</div>

<div class="button-container">
    <a href="{{ route('customer.subscriptions.export-data', $subscription->uuid) }}" 
       style="background: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%); 
              box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.3);
              display: inline-block;
              color: #ffffff !important;
              text-decoration: none;
              padding: 14px 28px;
              border-radius: 8px;
              font-weight: 600;
              font-size: 16px;">
        Export My Data
    </a>
</div>
@endif

@if(!$isPastCancellation)
<div class="content-text" style="margin-top: 32px;">
    <strong>Changed your mind?</strong>
</div>

<div class="content-text">
    You can reactivate your subscription at any time before the cancellation effective date. 
    Your service will continue without interruption.
</div>

<div class="button-container">
    <a href="{{ route('customer.subscriptions.reactivate', $subscription->uuid) }}" 
       style="background: linear-gradient(135deg, #059669 0%, #10b981 100%); 
              box-shadow: 0 4px 6px -1px rgba(5, 150, 105, 0.3);
              display: inline-block;
              color: #ffffff !important;
              text-decoration: none;
              padding: 14px 28px;
              border-radius: 8px;
              font-weight: 600;
              font-size: 16px;">
        Reactivate Subscription
    </a>
</div>
@else
<div class="content-text" style="margin-top: 32px;">
    <strong>Want to come back?</strong>
</div>

<div class="content-text">
    We'd love to have you back! You can subscribe again at any time to restore your service access.
</div>

<div class="button-container">
    <a href="{{ route('customer.subscriptions.renew', $subscription->uuid) }}" class="email-button">
        Subscribe Again
    </a>
</div>
@endif

<div class="content-text" style="margin-top: 32px;">
    <strong>We value your feedback!</strong>
</div>

<div class="content-text">
    We're sorry to see you go. Your feedback helps us improve our services and better serve our customers.
</div>

<div class="button-container">
    <a href="{{ route('customer.feedback.create', ['subscription' => $subscription->uuid]) }}" 
       style="background: linear-gradient(135deg, #6366f1 0%, #818cf8 100%); 
              box-shadow: 0 4px 6px -1px rgba(99, 102, 241, 0.3);
              display: inline-block;
              color: #ffffff !important;
              text-decoration: none;
              padding: 12px 24px;
              border-radius: 8px;
              font-weight: 600;
              font-size: 14px;">
        Share Your Feedback
    </a>
</div>

<div class="content-text" style="margin-top: 32px;">
    If you have any questions about this cancellation or need assistance, please don't hesitate 
    to contact our support team. We're here to help.
</div>

<div class="content-text" style="font-weight: 600; color: #1f2937;">
    Thank you for choosing our services. We hope to serve you again in the future.
</div>
@endsection
