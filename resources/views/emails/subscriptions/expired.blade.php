@extends('emails.layouts.app')

@section('title', 'Subscription Expired')
@section('tagline', 'Service Access Suspended')

@section('content')
<div class="greeting">
    Hello {{ $subscription->customer->name }},
</div>

<div class="content-text">
    @if($daysExpired === 0)
        Your subscription expired today and service access has been suspended.
    @elseif($daysExpired === 1)
        Your subscription expired yesterday. Your service access has been suspended.
    @else
        Your subscription expired <strong>{{ $daysExpired }} days ago</strong>. Your service access has been suspended.
    @endif
</div>

<div class="highlight-box" style="background-color: #fee2e2; border-left-color: #dc2626;">
    <div style="font-size: 18px; font-weight: 600; color: #991b1b; margin-bottom: 12px;">
        ⚠️ Service Access Suspended
    </div>
    <div style="color: #991b1b;">
        Renew your subscription to restore access to {{ $subscription->service->title }}.
    </div>
</div>

<table class="info-table">
    <tr>
        <th>Subscription Information</th>
        <th></th>
    </tr>
    <tr>
        <td><strong>Service</strong></td>
        <td>{{ $subscription->service->title }}</td>
    </tr>
    <tr>
        <td><strong>Expired On</strong></td>
        <td style="color: #dc2626; font-weight: 600;">
            {{ $subscription->expires_at->format('F j, Y') }}
        </td>
    </tr>
    <tr>
        <td><strong>Days Since Expiration</strong></td>
        <td>{{ $daysExpired }} {{ Str::plural('day', $daysExpired) }}</td>
    </tr>
    <tr>
        <td><strong>Service Status</strong></td>
        <td>
            <span class="status-badge status-cancelled">Suspended</span>
        </td>
    </tr>
</table>

@php
    $service = $subscription->service;
    $gracePeriodDays = $gracePeriodDays ?? $service->grace_period_days ?? 0;
@endphp

@if($gracePeriodDays > 0)
    @php
        $gracePeriodEnd = $subscription->expires_at->copy()->addDays($gracePeriodDays);
        $graceDaysRemaining = now()->diffInDays($gracePeriodEnd, false);
    @endphp
    
    @if($graceDaysRemaining > 0)
    <div class="highlight-box" style="background-color: #fef3c7; border-left-color: #f59e0b;">
        <div style="color: #92400e;">
            <strong>⏰ Grace Period Active</strong><br>
            You have <strong>{{ $graceDaysRemaining }} {{ Str::plural('day', $graceDaysRemaining) }}</strong> 
            remaining to renew before permanent suspension on {{ $gracePeriodEnd->format('F j, Y') }}.
        </div>
    </div>
    @else
    <div class="content-text" style="color: #dc2626;">
        <strong>Grace period has ended.</strong> Service has been permanently suspended.
    </div>
    @endif
@endif

@php
    $priceInfo = $service->getPriceInfo();
    $renewalPrice = $service->getRenewalPrice();
    $hasDiscount = $service->renewal_discount_percentage > 0;
@endphp

<div class="content-text">
    <strong>Renewal Pricing:</strong>
</div>

<table class="info-table">
    @if($hasDiscount)
    <tr>
        <td><strong>Regular Price</strong></td>
        <td style="text-decoration: line-through; color: #9ca3af;">
            {{ $priceInfo['formatted'] }}
        </td>
    </tr>
    <tr>
        <td><strong>Renewal Discount</strong></td>
        <td style="color: #059669; font-weight: 600;">
            {{ $service->renewal_discount_percentage }}% OFF
        </td>
    </tr>
    <tr>
        <td><strong>Your Renewal Price</strong></td>
        <td style="font-size: 18px; color: #059669; font-weight: 700;">
            ${{ number_format($renewalPrice, 2) }}
        </td>
    </tr>
    @else
    <tr>
        <td><strong>Renewal Price</strong></td>
        <td style="font-size: 18px; color: #1f2937; font-weight: 700;">
            {{ $priceInfo['formatted'] }}
        </td>
    </tr>
    @endif
</table>

@if($service->hasEarlyTerminationFee() && $subscription->hasEarlyTerminationFee())
<div class="highlight-box" style="background-color: #fee2e2; border-left-color: #dc2626;">
    <div style="color: #991b1b;">
        <strong>⚠️ Early Termination Fee Notice</strong><br>
        A fee of ${{ number_format($service->early_termination_fee, 2) }} applies for cancellation 
        before the minimum term completion.
    </div>
</div>
@endif

<div class="button-container">
    <a href="{{ route('customer.subscriptions.renew', $subscription->uuid) }}" class="email-button">
        Renew Subscription & Restore Access
    </a>
</div>

@php
    $dataRetentionDays = $service->subscription_metadata['data_retention_days'] ?? 30;
    $dataDeleteDate = $subscription->expires_at->copy()->addDays($dataRetentionDays);
    $daysUntilDataDeletion = now()->diffInDays($dataDeleteDate, false);
@endphp

@if($daysUntilDataDeletion > 0)
<div class="highlight-box" style="background-color: #fef3c7; border-left-color: #f59e0b;">
    <div style="color: #92400e;">
        <strong>📁 Data Retention Notice</strong><br>
        Your service data will be permanently deleted on <strong>{{ $dataDeleteDate->format('F j, Y') }}</strong> 
        ({{ $daysUntilDataDeletion }} {{ Str::plural('day', $daysUntilDataDeletion) }} remaining) 
        if your subscription is not renewed.
    </div>
</div>

<div class="button-container">
    <a href="{{ route('customer.subscriptions.export-data', $subscription->uuid) }}" 
       style="background: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%); 
              box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.3);
              display: inline-block;
              color: #ffffff !important;
              text-decoration: none;
              padding: 12px 24px;
              border-radius: 8px;
              font-weight: 600;
              font-size: 14px;">
        Export My Data Before Deletion
    </a>
</div>
@endif

<div class="content-text" style="margin-top: 32px;">
    <strong>What happens next?</strong>
</div>

<div class="content-text">
    ✗ Service access is currently suspended<br>
    @if($gracePeriodDays > 0 && $graceDaysRemaining > 0)
    ✓ Grace period active for {{ $graceDaysRemaining }} more {{ Str::plural('day', $graceDaysRemaining) }}<br>
    @endif
    @if($daysUntilDataDeletion > 0)
    ⏰ Data will be deleted in {{ $daysUntilDataDeletion }} {{ Str::plural('day', $daysUntilDataDeletion) }}<br>
    @endif
    ✓ Renew now to restore full access immediately
</div>

<div class="content-text" style="margin-top: 24px;">
    We value your business and hope to continue serving you. If you have any questions 
    or need assistance, please contact our support team.
</div>

<div class="content-text" style="font-weight: 600; color: #1f2937;">
    We hope to see you back soon!
</div>
@endsection
