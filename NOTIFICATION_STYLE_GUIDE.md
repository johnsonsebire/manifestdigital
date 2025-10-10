# Notification Topbar Style System

## Overview
The notification topbar component now supports multiple visual styles through the `style` prop, allowing you to match your brand or page theme.

## Available Styles

### 1. Dark (Default)
Classic dark gradient with orange accent buttons.

**Visual:**
- Background: Linear gradient from `#1a1a1a` to `#000000`
- CTA Button: Orange `#FF4900`
- Close Button: White with orange hover

**Usage:**
```blade
<x-layouts.frontend notificationStyle="dark">
    <!-- page content -->
</x-layouts.frontend>
```

Or explicitly:
```blade
<x-notification-topbar style="dark" />
```

### 2. Modern Purple
Modern purple gradient with vibrant orange accent buttons.

**Visual:**
- Background: Linear gradient from `#667eea` (light purple) to `#764ba2` (deep purple)
- CTA Button: Orange `#FF4900` with white text
- CTA Hover: Lighter orange `#FF6B3D`
- Close Button: White overlay with orange hover `#FF4900`

**Usage:**
```blade
<x-layouts.frontend notificationStyle="modern-purple">
    <!-- page content -->
</x-layouts.frontend>
```

Or explicitly:
```blade
<x-notification-topbar style="modern-purple" />
```

## Component Props

The notification topbar accepts the following props:

```blade
<x-notification-topbar
    style="dark"                    // Style variant: 'dark', 'modern-purple'
    icon="🎉"                        // Emoji or icon character
    text="Your message here"        // Main notification message
    ctaText="Claim Offer"           // Call-to-action button text
    ctaUrl="#"                       // Call-to-action button URL
/>
```

### Default Values
```php
'style' => 'dark'
'icon' => '🎉'
'text' => 'Launch Special: First month 20% off + free brand consultation (GH₵500 value) • Limited spots available'
'ctaText' => 'Claim Offer'
'ctaUrl' => '#'
```

## Usage Examples

### Example 1: Home Page with Dark Style
```blade
<x-layouts.frontend 
    transparentHeader="true" 
    notificationStyle="dark"
    preloader="advanced"
>
    <x-slot:title>Home | Manifest Digital</x-slot:title>
    
    <!-- Page content -->
</x-layouts.frontend>
```

### Example 2: Projects Page with Modern Purple
```blade
<x-layouts.frontend 
    transparentHeader="false" 
    notificationStyle="modern-purple"
    preloader="advanced"
>
    <x-slot:title>Projects | Manifest Digital</x-slot:title>
    
    <!-- Page content -->
</x-layouts.frontend>
```

### Example 3: Custom Notification Content with Purple Style
```blade
<x-layouts.frontend notificationStyle="modern-purple">
    <x-slot:title>Special Offer</x-slot:title>
    
    <!-- Override notification content -->
    <x-slot:notification>
        <x-notification-topbar 
            style="modern-purple"
            icon="✨"
            text="New Feature Launch: AI-Powered Design Tools • Try Beta Now"
            ctaText="Get Early Access"
            ctaUrl="/beta-signup"
        />
    </x-slot:notification>
    
    <!-- Page content -->
</x-layouts.frontend>
```

## Customization

### Adding New Styles

To add a new notification style:

1. **Add CSS in `resources/css/styles.css`:**

```css
/* New Style Name */
.notification-topbar--your-style-name {
    background: linear-gradient(135deg, #your-start 0%, #your-end 100%);
    box-shadow: 0 4px 20px rgba(your-color, 0.3);
}

.notification-topbar--your-style-name .notification-cta {
    background: #your-cta-bg;
    color: #your-cta-text;
    box-shadow: 0 2px 12px rgba(your-color, 0.2);
}

.notification-topbar--your-style-name .notification-cta:hover {
    background: #your-cta-hover;
    color: #your-hover-text;
    transform: translateY(-2px) scale(1.05);
    box-shadow: 0 4px 16px rgba(your-color, 0.3);
}

.notification-topbar--your-style-name .notification-close {
    background: rgba(255, 255, 255, 0.2);
    border-color: rgba(255, 255, 255, 0.4);
}

.notification-topbar--your-style-name .notification-close:hover {
    background: #your-close-hover-bg;
    color: #your-close-hover-text;
    border-color: #your-close-hover-border;
}
```

2. **Update documentation** to include your new style option.

3. **Use it:**
```blade
<x-layouts.frontend notificationStyle="your-style-name">
```

## Style Guidelines

### Color Contrast
Ensure proper contrast ratios for accessibility:
- Text on background: At least 4.5:1
- CTA button text: At least 4.5:1
- Close button icon: At least 3:1

### Animation
All styles include consistent animations:
- Slide down on show: 0.4s cubic-bezier
- Icon pulse: 2s ease-in-out infinite
- Button hover: 0.3s ease transitions

### Responsive Behavior
All styles are responsive:
- Mobile: Single column layout
- Tablet: Adjusted padding and spacing
- Desktop: Full horizontal layout

## Browser Support
All styles work on:
- Chrome/Edge 90+
- Firefox 88+
- Safari 14+
- Mobile browsers (iOS Safari 14+, Chrome Mobile)

## Performance
- CSS-only styling (no JavaScript overhead)
- GPU-accelerated animations (transform, opacity)
- Minimal reflow/repaint
- Optimized z-index layering

## Accessibility
All styles maintain:
- ARIA labels on close button
- Keyboard navigation support
- Screen reader announcements
- Focus visible states
- Color contrast compliance

## Testing

Test each style variant:
```bash
# View with dark style
/projects?notification=dark

# View with modern purple style
/projects?notification=modern-purple
```

## Migration Guide

### From Previous Version
If upgrading from version without style support:

**Before:**
```blade
<x-notification-topbar />
```

**After (no changes required, defaults to 'dark'):**
```blade
<x-notification-topbar />
```

**Or specify style:**
```blade
<x-notification-topbar style="modern-purple" />
```

## Troubleshooting

### Style Not Applying
1. Check style name spelling (case-sensitive)
2. Ensure CSS file is compiled (`npm run build`)
3. Clear browser cache
4. Verify prop is being passed correctly

### Colors Not Matching
1. Check CSS variable values
2. Verify gradient syntax
3. Test in different browsers
4. Check for CSS override conflicts

## Future Styles

Planned style variants:
- `gradient-blue`: Blue ocean gradient
- `sunset-orange`: Warm sunset colors
- `forest-green`: Nature-inspired green
- `minimal-gray`: Subtle monochrome

Vote for your favorite or suggest new styles!
