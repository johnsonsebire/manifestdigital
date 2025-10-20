@extends('emails.layouts.app')

@section('title', 'Subscription Expiring Soon')
@section('tagline', 'Subscription Renewal Reminder')

@section('content')
<div class="greeting">
    Hello {{ $subscription->customer->name }},
</div>

<div class="content-text">
    @if($daysRemaining > 1)
        This is a friendly reminder that your subscription will expire in <strong>{{ $daysRemaining }} days</strong>.
    @elseif($daysRemaining === 1)
        <strong>Important:</strong> Your subscription expires tomorrow!
    @else
        <strong>Urgent:</strong> Your subscription expires today!
    @endif
</div>

<div class="highlight-box">
    <div style="font-size: 18px; font-weight: 600; color: #1f2937; margin-bottom: 12px;">
        📦 {{ $subscription->service->title }}
    </div>
    <div style="color: #6b7280;">
        Don't lose access to your service. Renew now to continue enjoying uninterrupted service.
    </div>
</div>

<table class="info-table">
    <tr>
        <th>Subscription Details</th>
        <th></th>
    </tr>
    <tr>
        <td><strong>Service</strong></td>
        <td>{{ $subscription->service->title }}</td>
    </tr>
    <tr>
        <td><strong>Current Plan</strong></td>
        <td style="text-transform: capitalize;">{{ str_replace('_', ' ', $subscription->billing_interval) }}</td>
    </tr>
    <tr>
        <td><strong>Expiration Date</strong></td>
        <td>
            <span style="color: #dc2626; font-weight: 600;">
                {{ $subscription->expires_at->format('F j, Y') }}
            </span>
            ({{ $subscription->expires_at->diffForHumans() }})
        </td>
    </tr>
    @if($subscription->auto_renew)
    <tr>
        <td><strong>Auto-Renewal</strong></td>
        <td>
            <span class="status-badge status-approved">Enabled</span>
        </td>
    </tr>
    @endif
</table>

@php
    $service = $subscription->service;
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

@if($service->hasSetupFee())
<div class="highlight-box" style="background-color: #dbeafe; border-left-color: #2563eb;">
    <div style="color: #1e40af;">
        <strong>💰 Good News!</strong> Setup fees are waived for renewals. 
        Save ${{ number_format($service->setup_fee, 2) }}!
    </div>
</div>
@endif

<div class="button-container">
    <a href="{{ route('renewal.index', $subscription) }}" class="email-button">
        Renew Subscription Now
    </a>
</div>

<div class="content-text" style="margin-top: 32px;">
    <strong>Why renew now?</strong>
</div>

<div class="content-text">
    ✓ Maintain uninterrupted access to your service<br>
    ✓ Lock in current pricing<br>
    ✓ No setup fees for renewals<br>
    @if($hasDiscount)
    ✓ Save {{ $service->renewal_discount_percentage }}% with renewal discount<br>
    @endif
    ✓ Extend your subscription from your current expiration date
</div>

@if($subscription->service->cancellation_policy)
<div class="content-text" style="margin-top: 24px; padding-top: 24px; border-top: 1px solid #e5e7eb;">
    <strong>Cancellation Policy:</strong><br>
    <span style="font-size: 14px; color: #6b7280;">
        {{ $subscription->service->cancellation_policy }}
    </span>
</div>
@endif

<div class="content-text" style="margin-top: 24px;">
    If you have any questions about your subscription or need assistance with renewal, 
    please don't hesitate to contact our support team. We're here to help!
</div>

<div class="content-text" style="font-weight: 600; color: #1f2937;">
    Thank you for choosing our services!
</div>
@endsection
