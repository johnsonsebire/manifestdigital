@props([
    'style' => 'dark', // Options: 'dark', 'modern-purple'
    'icon' => '🎉',
    'text' => 'Launch Special: First month 20% off + free brand consultation (GH₵500 value) • Limited spots available',
    'ctaText' => 'Claim Offer',
    'ctaUrl' => '#'
])

<!-- Notification Topbar -->
<div class="notification-topbar notification-topbar--{{ $style }}">
    <span class="notification-icon">{{ $icon }}</span>
    <div class="notification-content">
        <span class="notification-text">{{ $text }}</span>
        <a href="{{ $ctaUrl }}" class="notification-cta">{{ $ctaText }}</a>
    </div>
    <button class="notification-close" aria-label="Close notification">×</button>
</div>