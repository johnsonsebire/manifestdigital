@extends('emails.layouts.app')

@section('title', 'Subscription Renewed')
@section('tagline', 'Thank You for Renewing!')

@section('content')
<div class="greeting">
    Hello {{ $subscription->customer->name }},
</div>

<div class="content-text">
    Great news! Your subscription has been successfully renewed. Thank you for continuing to trust our services!
</div>

<div class="highlight-box" style="background-color: #d1fae5; border-left-color: #059669;">
    <div style="font-size: 18px; font-weight: 600; color: #065f46; margin-bottom: 12px;">
        ✅ Subscription Renewed Successfully
    </div>
    <div style="color: #047857;">
        Your service access has been extended and is active until {{ $subscription->expires_at->format('F j, Y') }}.
    </div>
</div>

<table class="info-table">
    <tr>
        <th>Renewal Details</th>
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
        <td><strong>Renewal Date</strong></td>
        <td>{{ ($subscription->last_renewed_at ?? now())->format('F j, Y') }}</td>
    </tr>
    <tr>
        <td><strong>New Expiration Date</strong></td>
        <td style="color: #059669; font-weight: 600; font-size: 16px;">
            {{ $subscription->expires_at->format('F j, Y') }}
        </td>
    </tr>
    <tr>
        <td><strong>Billing Interval</strong></td>
        <td style="text-transform: capitalize;">{{ str_replace('_', ' ', $subscription->billing_interval) }}</td>
    </tr>
    <tr>
        <td><strong>Next Billing Date</strong></td>
        <td>{{ $subscription->next_billing_date->format('F j, Y') }}</td>
    </tr>
    <tr>
        <td><strong>Status</strong></td>
        <td>
            <span class="status-badge status-approved">Active</span>
        </td>
    </tr>
</table>

@php
    $isEarlyRenewal = isset($subscription->metadata['last_renewal']['early_renewal']) && 
                      $subscription->metadata['last_renewal']['early_renewal'];
@endphp

@if($isEarlyRenewal)
<div class="highlight-box" style="background-color: #dbeafe; border-left-color: #2563eb;">
    <div style="color: #1e40af;">
        <strong>🎉 Early Renewal Bonus!</strong><br>
        Thank you for renewing early! Your renewal period was added to your existing time, 
        so you didn't lose any days from your previous subscription.
    </div>
</div>
@endif

<div class="content-text">
    <strong>Payment Summary:</strong>
</div>

@php
    $renewalPrice = $subscription->metadata['last_renewal']['price'] ?? $subscription->billing_amount;
    $service = $subscription->service;
    $hasDiscount = $service->renewal_discount_percentage > 0;
@endphp

<table class="info-table">
    <tr>
        <td><strong>Amount Charged</strong></td>
        <td style="font-size: 18px; color: #1f2937; font-weight: 700;">
            ${{ number_format($renewalPrice, 2) }}
        </td>
    </tr>
    @if($hasDiscount)
    <tr>
        <td><strong>Renewal Discount Applied</strong></td>
        <td style="color: #059669; font-weight: 600;">
            {{ $service->renewal_discount_percentage }}% OFF
        </td>
    </tr>
    @endif
    <tr>
        <td><strong>Payment Method</strong></td>
        <td>{{ $subscription->order->payment_method ?? 'Card ending in ****' }}</td>
    </tr>
    <tr>
        <td><strong>Currency</strong></td>
        <td>{{ strtoupper($subscription->currency) }}</td>
    </tr>
</table>

<div class="button-container">
    <a href="{{ route('customer.subscriptions.show', $subscription->uuid) }}" class="email-button">
        View Subscription Details
    </a>
</div>

<div class="content-text" style="margin-top: 32px;">
    <strong>What's included in your subscription:</strong>
</div>

<div class="content-text">
    ✓ Full access to {{ $subscription->service->title }}<br>
    ✓ All premium features and updates<br>
    ✓ Priority customer support<br>
    ✓ {{ ucfirst($subscription->billing_interval) }} billing cycle<br>
    @if($subscription->auto_renew)
    ✓ Automatic renewal enabled (can be disabled anytime)<br>
    @endif
    ✓ Access until {{ $subscription->expires_at->format('F j, Y') }}
</div>

@if($subscription->auto_renew)
<div class="highlight-box">
    <div style="color: #374151;">
        <strong>🔄 Auto-Renewal Enabled</strong><br>
        Your subscription will automatically renew on {{ $subscription->next_billing_date->format('F j, Y') }}. 
        You can disable auto-renewal anytime from your account settings.
    </div>
</div>
@else
<div class="highlight-box" style="background-color: #fef3c7; border-left-color: #f59e0b;">
    <div style="color: #92400e;">
        <strong>⚠️ Manual Renewal Required</strong><br>
        Auto-renewal is currently disabled. You'll need to manually renew before 
        {{ $subscription->expires_at->format('F j, Y') }} to continue your service.
    </div>
</div>
@endif

<div class="content-text" style="margin-top: 32px;">
    <strong>Manage your subscription:</strong>
</div>

<div class="content-text">
    • View subscription details and usage<br>
    • Update payment methods<br>
    • Enable/disable auto-renewal<br>
    • Access billing history and invoices<br>
    • Manage notification preferences
</div>

<div class="button-container">
    <a href="{{ route('customer.subscriptions.index') }}" 
       style="background: linear-gradient(135deg, #6366f1 0%, #818cf8 100%); 
              box-shadow: 0 4px 6px -1px rgba(99, 102, 241, 0.3);
              display: inline-block;
              color: #ffffff !important;
              text-decoration: none;
              padding: 12px 24px;
              border-radius: 8px;
              font-weight: 600;
              font-size: 14px;">
        Manage My Subscriptions
    </a>
</div>

<div class="content-text" style="margin-top: 32px;">
    We'll send you renewal reminders before your next billing date, so you'll never be surprised. 
    You can adjust your notification preferences in your account settings.
</div>

<div class="content-text">
    If you have any questions about your subscription or need assistance, our support team is 
    always here to help. Just reply to this email or visit our support center.
</div>

<div class="content-text" style="font-weight: 600; color: #1f2937;">
    Thank you for your continued trust and support!
</div>

<div class="content-text" style="margin-top: 24px; padding: 20px; background-color: #f3f4f6; border-radius: 8px; text-align: center;">
    <strong>Need help or have questions?</strong><br>
    <span style="font-size: 14px; color: #6b7280;">
        Our support team is available 24/7 to assist you.<br>
        Email us at {{ setting('company_email', 'support@example.com') }}
    </span>
</div>
@endsection
