@extends('emails.layouts.app')

@section('title', 'Early Renewal Available')
@section('tagline', 'Renew Early & Save')

@section('content')
<div class="greeting">
    Hello {{ $subscription->customer->name }},
</div>

<div class="content-text">
    Good news! Early renewal is now available for your <strong>{{ $subscription->service->title }}</strong> subscription. 
    Renew now to lock in your current pricing and avoid any service interruption.
</div>

<div class="highlight-box" style="background-color: #d1fae5; border-left-color: #059669;">
    <div style="font-size: 18px; font-weight: 600; color: #065f46; margin-bottom: 12px;">
        🎉 Early Renewal Benefits
    </div>
    <div style="color: #047857;">
        Renew before expiration and extend your service with no downtime!
    </div>
</div>

<table class="info-table">
    <tr>
        <th>Current Subscription</th>
        <th></th>
    </tr>
    <tr>
        <td><strong>Service</strong></td>
        <td>{{ $subscription->service->title }}</td>
    </tr>
    <tr>
        <td><strong>Current Expiration</strong></td>
        <td>{{ $subscription->expires_at->format('F j, Y') }}</td>
    </tr>
    <tr>
        <td><strong>Time Remaining</strong></td>
        <td style="color: #2563eb; font-weight: 600;">
            {{ $daysUntilExpiration }} {{ Str::plural('day', $daysUntilExpiration) }}
        </td>
    </tr>
    <tr>
        <td><strong>Billing Interval</strong></td>
        <td style="text-transform: capitalize;">{{ str_replace('_', ' ', $subscription->billing_interval) }}</td>
    </tr>
</table>

@php
    $service = $subscription->service;
    $priceInfo = $service->getPriceInfo();
    $basePrice = (float) $service->price;
    $renewalPrice = $service->getRenewalPrice();
    $hasStandardDiscount = $service->renewal_discount_percentage > 0;
    $hasEarlyDiscount = isset($earlyRenewalDiscount) && $earlyRenewalDiscount > 0;
    
    if ($hasEarlyDiscount) {
        $discountAmount = $basePrice * ($earlyRenewalDiscount / 100);
        $earlyPrice = $basePrice - $discountAmount;
        $totalSavings = $basePrice - $earlyPrice;
    } else {
        $earlyPrice = $renewalPrice;
        $totalSavings = $basePrice - $renewalPrice;
    }
    
    $newExpirationDate = $subscription->expires_at->copy()->addMonths($service->subscription_duration_months);
@endphp

<div class="content-text">
    <strong>Early Renewal Pricing:</strong>
</div>

<table class="info-table">
    <tr>
        <td><strong>Regular Price</strong></td>
        <td style="text-decoration: line-through; color: #9ca3af;">
            {{ $priceInfo['formatted'] }}
        </td>
    </tr>
    
    @if($hasEarlyDiscount)
    <tr>
        <td><strong>Early Renewal Discount</strong></td>
        <td style="color: #059669; font-weight: 600;">
            {{ $earlyRenewalDiscount }}% OFF
        </td>
    </tr>
    <tr>
        <td><strong>Your Early Renewal Price</strong></td>
        <td style="font-size: 18px; color: #059669; font-weight: 700;">
            ${{ number_format($earlyPrice, 2) }}
        </td>
    </tr>
    <tr>
        <td><strong>You Save</strong></td>
        <td style="color: #059669; font-weight: 600;">
            ${{ number_format($totalSavings, 2) }}
        </td>
    </tr>
    @elseif($hasStandardDiscount)
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
        <td><strong>Your Renewal Price</strong></td>
        <td style="font-size: 18px; color: #1f2937; font-weight: 700;">
            {{ $priceInfo['formatted'] }}
        </td>
    </tr>
    @endif
    
    <tr style="background-color: #f9fafb;">
        <td><strong>New Expiration Date</strong></td>
        <td style="color: #2563eb; font-weight: 600;">
            {{ $newExpirationDate->format('F j, Y') }}
        </td>
    </tr>
</table>

@if($hasEarlyDiscount)
<div class="highlight-box" style="background-color: #dbeafe; border-left-color: #2563eb;">
    <div style="color: #1e40af;">
        <strong>🎁 Limited Time Offer!</strong><br>
        Renew now and save an extra {{ $earlyRenewalDiscount }}% on top of your renewal discount!
    </div>
</div>
@endif

<div class="button-container">
    <a href="{{ route('customer.subscriptions.renew', $subscription->uuid) }}" class="email-button">
        Renew Early Now
    </a>
</div>

<div class="content-text" style="margin-top: 32px;">
    <strong>Why renew early?</strong>
</div>

<div class="content-text">
    ✓ <strong>Avoid service interruption</strong> - Renew before expiration<br>
    ✓ <strong>Lock in current pricing</strong> - Protect against price increases<br>
    ✓ <strong>No setup fees</strong> - Save ${{ number_format($service->setup_fee ?? 0, 2) }} on renewals<br>
    @if($hasEarlyDiscount || $hasStandardDiscount)
    ✓ <strong>Save money</strong> - Get ${{ number_format($totalSavings, 2) }} off with renewal discount<br>
    @endif
    ✓ <strong>Extend from current date</strong> - Your {{ $daysUntilExpiration }} remaining days are added to your renewal<br>
    ✓ <strong>Peace of mind</strong> - One less thing to worry about
</div>

@if($daysUntilExpiration > 0)
<div class="highlight-box">
    <div style="color: #374151;">
        <strong>💡 How it works:</strong><br>
        When you renew early, your new subscription period starts from your current expiration date 
        ({{ $subscription->expires_at->format('F j, Y') }}), so you don't lose any remaining time! 
        Your service will continue until {{ $newExpirationDate->format('F j, Y') }}.
    </div>
</div>
@endif

@if(isset($customMessage) && $customMessage)
<div class="highlight-box" style="background-color: #fef3c7; border-left-color: #f59e0b;">
    <div style="color: #92400e;">
        <strong>📢 Special Message from Us:</strong><br>
        {{ $customMessage }}
    </div>
</div>
@endif

@if($service->subscription_metadata && isset($service->subscription_metadata['early_renewal_message']))
<div class="content-text" style="margin-top: 24px; padding: 20px; background-color: #f3f4f6; border-radius: 8px;">
    {{ $service->subscription_metadata['early_renewal_message'] }}
</div>
@endif

<div class="content-text" style="margin-top: 24px;">
    You can renew at any time before your current subscription expires. Early renewals will extend 
    your current subscription period, so you never lose any time you've already paid for.
</div>

<div class="content-text">
    Questions? Our support team is here to help! We appreciate your continued trust in our services.
</div>

<div class="content-text" style="font-weight: 600; color: #1f2937;">
    Thank you for being a valued customer!
</div>
@endsection
