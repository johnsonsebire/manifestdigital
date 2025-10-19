@props([
    'title' => 'Transparent Pricing, Exceptional Value',
    'subtitle' => 'Choose the perfect plan for your organization. Scale up or down anytime—no contracts, no surprises.',
    'pricingCategories' => [],
    'decorativeImages' => [
        'leftStripes' => 'images/decorative/mem_dots_f_tri.svg',
        'rightShape' => 'images/decorative/cta_left_mem_dots_f_circle2.svg'
    ],
    'animateOnScroll' => true
])

@php
// Default static pricing as fallback - will be replaced by dynamic pricing
$defaultPricingCategories = [
    'websites' => [
        'title' => 'Websites',
        'plans' => [
            [
                'name' => 'Essentials',
                'tagline' => 'Perfect for getting started',
                'price' => ['currency' => 'GH₵', 'amount' => '250', 'period' => '/month'],
                'cancelText' => 'Cancel anytime • 14-day guarantee',
                'ctaText' => 'Start Building',
                'ctaUrl' => route('services.show', 'website-essentials'),
                'features' => [
                    'Up to 5 pages',
                    'Responsive design',
                    'Basic SEO setup',
                    'Contact form integration',
                    'Social media links',
                    '2 rounds of revisions',
                    '30-day support'
                ],
                'hasAccent' => true,
                'isPopular' => false,
                'serviceSlug' => 'website-essentials'
            ],
            [
                'name' => 'Professional',
                'tagline' => 'Most popular for growing teams',
                'price' => ['currency' => 'GH₵', 'amount' => '500', 'period' => '/month'],
                'cancelText' => 'Cancel anytime • 14-day guarantee',
                'ctaText' => 'Get Professional',
                'ctaUrl' => route('services.show', 'website-professional'),
                'features' => [
                    'Up to 15 pages',
                    'Custom UI/UX design',
                    'Advanced SEO optimization',
                    'CMS integration',
                    'Blog functionality',
                    'E-commerce ready (up to 50 products)',
                    'Analytics integration',
                    'Unlimited revisions',
                    '90-day support'
                ],
                'hasAccent' => false,
                'isPopular' => true,
                'serviceSlug' => 'website-professional'
            ],
            [
                'name' => 'Enterprise',
                'tagline' => 'For mission-critical projects',
                'price' => ['currency' => 'GH₵', 'amount' => '1,500', 'period' => '/month'],
                'cancelText' => 'Custom terms available',
                'ctaText' => 'Talk to Sales',
                'ctaUrl' => route('services.show', 'website-enterprise'),
                'features' => [
                    'Unlimited pages',
                    'Premium custom design',
                    'Advanced functionality',
                    'Multi-language support',
                    'Custom integrations & APIs',
                    'Advanced e-commerce (unlimited products)',
                    'Dedicated project team',
                    'Priority support & maintenance',
                    '1-year support included'
                ],
                'hasAccent' => false,
                'isPopular' => false,
                'serviceSlug' => 'website-enterprise'
            ]
        ]
    ],
    'uiux' => [
        'title' => 'UI/UX Design',
        'plans' => [
            [
                'name' => 'Basic Design',
                'tagline' => 'Essential design services',
                'price' => ['currency' => 'GH₵', 'amount' => '2,500', 'period' => '/project'],
                'cancelText' => '1-2 weeks delivery',
                'ctaText' => 'Get Started',
                'ctaUrl' => route('services.show', 'basic-ui-ux-design'),
                'features' => [
                    'Up to 3 screen designs',
                    'Wireframe sketches',
                    'Basic user flow',
                    'Mobile responsive design',
                    '2 revision rounds',
                    'Figma source files',
                    'Style guide basics'
                ],
                'hasAccent' => true,
                'isPopular' => false,
                'serviceSlug' => 'basic-ui-ux-design'
            ],
            [
                'name' => 'Professional Design',
                'tagline' => 'Complete design system',
                'price' => ['currency' => 'GH₵', 'amount' => '6,000', 'period' => '/project'],
                'cancelText' => '2-4 weeks delivery',
                'ctaText' => 'Get Professional',
                'ctaUrl' => route('services.show', 'professional-ui-ux-design'),
                'features' => [
                    'Up to 10 screen designs',
                    'Interactive prototypes',
                    'Complete user journey mapping',
                    'Responsive design (mobile, tablet, desktop)',
                    'User research & personas',
                    'Unlimited revisions',
                    'Complete design system',
                    'Developer handoff package',
                    '60-day support'
                ],
                'hasAccent' => false,
                'isPopular' => true
            ],
            [
                'name' => 'Complete Design',
                'tagline' => 'Full UX/UI solution',
                'price' => ['currency' => 'GH₵', 'amount' => '6,000', 'period' => '/project'],
                'cancelText' => '3-4 weeks delivery',
                'ctaText' => 'Get Full Package',
                'ctaUrl' => route('services.show', 'complete-ui-ux-design'),
                'features' => [
                    'Unlimited screens',
                    'User research & personas',
                    'Interactive prototypes',
                    'Complete user journey mapping',
                    'Usability testing',
                    'Unlimited revisions',
                    'Complete design system',
                    'Developer handoff package',
                    '60-day support'
                ],
                'hasAccent' => false,
                'isPopular' => true,
                'serviceSlug' => 'complete-ui-ux-design'
            ],
            [
                'name' => 'Enterprise Design',
                'tagline' => 'Full-scale UX solution',
                'price' => ['currency' => 'GH₵', 'amount' => '10,000+', 'period' => ''],
                'cancelText' => 'Custom timeline',
                'ctaText' => 'Contact Us',
                'ctaUrl' => route('services.show', 'enterprise-ui-ux-design'),
                'features' => [
                    'Unlimited screens & flows',
                    'Advanced interactive prototypes',
                    'User testing & validation',
                    'Multi-platform design system',
                    'Accessibility compliance (WCAG)',
                    'UX strategy & consulting',
                    'Animation & micro-interactions',
                    'Dedicated design team',
                    '6-month support & updates'
                ],
                'hasAccent' => false,
                'isPopular' => false,
                'serviceSlug' => 'enterprise-ui-ux-design'
            ]
        ]
    ],
    'hosting' => [
        'title' => 'Hosting',
        'plans' => [
            [
                'name' => 'Starter Hosting',
                'tagline' => 'Basic shared hosting',
                'price' => ['currency' => 'GH₵', 'amount' => '50', 'period' => '/month'],
                'cancelText' => 'Annual billing available',
                'ctaText' => 'Get Started',
                'ctaUrl' => route('services.show', 'starter-web-hosting'),
                'features' => [
                    '5GB SSD storage',
                    '50GB bandwidth',
                    'Free SSL certificate',
                    '1 website',
                    'Daily backups',
                    'Email support'
                ],
                'hasAccent' => false,
                'isPopular' => false,
                'serviceSlug' => 'starter-web-hosting'
            ],
            [
                'name' => 'Business Hosting',
                'tagline' => 'For growing businesses',
                'price' => ['currency' => 'GH₵', 'amount' => '150', 'period' => '/month'],
                'cancelText' => 'Annual billing available',
                'ctaText' => 'Get Started',
                'ctaUrl' => route('services.show', 'business-web-hosting'),
                'features' => [
                    '25GB SSD storage',
                    '200GB bandwidth',
                    'Free SSL certificate',
                    'Up to 5 websites',
                    'Daily backups',
                    'Priority support',
                    'Free CDN'
                ],
                'hasAccent' => false,
                'isPopular' => true,
                'serviceSlug' => 'business-web-hosting'
            ],
            [
                'name' => 'Premium Hosting',
                'tagline' => 'Maximum performance',
                'price' => ['currency' => 'GH₵', 'amount' => '400', 'period' => '/month'],
                'cancelText' => 'Dedicated resources',
                'ctaText' => 'Get Started',
                'ctaUrl' => route('services.show', 'premium-web-hosting'),
                'features' => [
                    '100GB SSD storage',
                    'Unlimited bandwidth',
                    'Free SSL certificate',
                    'Unlimited websites',
                    'Hourly backups',
                    '24/7 priority support',
                    'Free CDN & caching',
                    'Dedicated IP'
                ],
                'hasAccent' => false,
                'isPopular' => false,
                'serviceSlug' => 'premium-web-hosting'
            ]
        ]
    ],
    'domains' => [
        'title' => 'Domain Names',
        'plans' => [
            [
                'name' => '.com Domain',
                'tagline' => 'Most popular extension',
                'price' => ['currency' => 'GH₵', 'amount' => '300', 'period' => '/year'],
                'cancelText' => 'Auto-renewal available',
                'ctaText' => 'Register Now',
                'ctaUrl' => route('services.show', 'com-domain-registration'),
                'features' => [
                    'Free DNS management',
                    'Free WHOIS privacy',
                    'Email forwarding',
                    '24/7 support'
                ],
                'hasAccent' => false,
                'isPopular' => false,
                'serviceSlug' => 'com-domain-registration'
            ],
            [
                'name' => '.gh Domains',
                'tagline' => 'Ghana local domain',
                'price' => ['currency' => 'GH₵', 'amount' => '600', 'period' => '/year'],
                'cancelText' => 'Local business identity',
                'ctaText' => 'Register Now',
                'ctaUrl' => route('services.show', 'gh-domain-registration'),
                'features' => [
                    'Free DNS management',
                    'Local SEO advantage',
                    'Email forwarding',
                    'Ghana business credibility',
                    '24/7 support'
                ],
                'hasAccent' => false,
                'isPopular' => true,
                'serviceSlug' => 'gh-domain-registration'
            ],
            [
                'name' => 'Premium Domains',
                'tagline' => 'Custom pricing',
                'price' => ['currency' => 'GH₵', 'amount' => 'Custom', 'period' => ''],
                'cancelText' => 'Contact for pricing',
                'ctaText' => 'Contact Us',
                'ctaUrl' => route('services.show', 'premium-domain-acquisition'),
                'features' => [
                    'Short & memorable names',
                    'Brandable domains',
                    'Market research included',
                    'Negotiation assistance',
                    'Free transfer support'
                ],
                'hasAccent' => false,
                'isPopular' => false,
                'serviceSlug' => 'premium-domain-acquisition'
            ]
        ]
    ],
    'apps' => [
        'title' => 'App Development',
        'plans' => [
            [
                'name' => 'Simple App',
                'tagline' => 'Simple mobile app',
                'price' => ['currency' => 'GH₵', 'amount' => '5,000', 'period' => 'starting'],
                'cancelText' => '2-4 weeks delivery',
                'ctaText' => 'Get Started',
                'ctaUrl' => route('services.show', 'simple-mobile-app'),
                'features' => [
                    'iOS or Android (single platform)',
                    'Up to 5 screens',
                    'Basic UI/UX design',
                    'Push notifications',
                    'User authentication',
                    '30-day support'
                ],
                'hasAccent' => false,
                'isPopular' => false,
                'serviceSlug' => 'simple-mobile-app'
            ],
            [
                'name' => 'Professional App',
                'tagline' => 'Full-featured app',
                'price' => ['currency' => 'GH₵', 'amount' => '25,000', 'period' => 'starting'],
                'cancelText' => '6-8 weeks delivery',
                'ctaText' => 'Get Started',
                'ctaUrl' => route('services.show', 'professional-mobile-app'),
                'features' => [
                    'iOS & Android (both platforms)',
                    'Up to 15 screens',
                    'Custom UI/UX design',
                    'Backend integration',
                    'Payment gateway',
                    'Analytics integration',
                    '90-day support'
                ],
                'hasAccent' => false,
                'isPopular' => true,
                'serviceSlug' => 'professional-mobile-app'
            ],
            [
                'name' => 'Enterprise App',
                'tagline' => 'Complex solutions',
                'price' => ['currency' => 'GH₵', 'amount' => '50,000+', 'period' => ''],
                'cancelText' => 'Custom timeline',
                'ctaText' => 'Contact Us',
                'ctaUrl' => route('services.show', 'enterprise-mobile-app'),
                'features' => [
                    'Multi-platform (iOS, Android, Web)',
                    'Unlimited screens',
                    'Premium design & branding',
                    'Advanced features & integrations',
                    'Real-time functionality',
                    'Dedicated team',
                    '1-year support & maintenance'
                ],
                'hasAccent' => false,
                'isPopular' => false,
                'serviceSlug' => 'enterprise-mobile-app'
            ]
        ]
    ],
    'consulting' => [
        'title' => 'Consulting Services',
        'plans' => [
            [
                'name' => 'Hourly Consulting',
                'tagline' => 'Pay as you go',
                'price' => ['currency' => 'GH₵', 'amount' => '500', 'period' => '/hour'],
                'cancelText' => 'Minimum 2 hours',
                'ctaText' => 'Book Session',
                'ctaUrl' => route('services.show', 'hourly-technical-consulting'),
                'features' => [
                    'Technical advice',
                    'Strategy planning',
                    'Code review',
                    'Architecture design',
                    'Follow-up email summary'
                ],
                'hasAccent' => false,
                'isPopular' => false,
                'serviceSlug' => 'hourly-technical-consulting'
            ],
            [
                'name' => 'Monthly Retainer',
                'tagline' => 'Ongoing support',
                'price' => ['currency' => 'GH₵', 'amount' => '5,000', 'period' => '/month'],
                'cancelText' => '10 hours included',
                'ctaText' => 'Get Started',
                'ctaUrl' => route('services.show', 'monthly-consulting-retainer'),
                'features' => [
                    '10 consulting hours/month',
                    'Priority scheduling',
                    'Dedicated consultant',
                    'Strategic roadmap',
                    'Monthly reports',
                    'Email & Slack support'
                ],
                'hasAccent' => false,
                'isPopular' => true,
                'serviceSlug' => 'monthly-consulting-retainer'
            ],
            [
                'name' => 'Project Consulting',
                'tagline' => 'Custom engagement',
                'price' => ['currency' => 'GH₵', 'amount' => 'Custom', 'period' => ''],
                'cancelText' => 'Tailored to your needs',
                'ctaText' => 'Contact Us',
                'ctaUrl' => route('services.show', 'project-based-consulting'),
                'features' => [
                    'Full project assessment',
                    'Technology selection',
                    'Team augmentation',
                    'Implementation support',
                    'Post-launch optimization',
                    'Custom SLA'
                ],
                'hasAccent' => false,
                'isPopular' => false,
                'serviceSlug' => 'project-based-consulting'
            ]
        ]
    ],
    'training' => [
        'title' => 'Training Services',
        'plans' => [
            [
                'name' => 'Individual Training',
                'tagline' => 'One-on-one sessions',
                'price' => ['currency' => 'GH₵', 'amount' => '3,000', 'period' => '/period'],
                'cancelText' => 'Flexible scheduling',
                'ctaText' => 'Book Now',
                'ctaUrl' => route('services.show', 'individual-technical-training'),
                'features' => [
                    'Personalized curriculum',
                    'Hands-on exercises',
                    'Progress tracking',
                    'Certificate of completion',
                    'Learning resources included'
                ],
                'hasAccent' => false,
                'isPopular' => false,
                'serviceSlug' => 'individual-technical-training'
            ],
            [
                'name' => 'Team Training',
                'tagline' => 'Groups of 5-10',
                'price' => ['currency' => 'GH₵', 'amount' => '2,000', 'period' => '/period'],
                'cancelText' => 'Full-day workshop',
                'ctaText' => 'Book Workshop',
                'ctaUrl' => route('services.show', 'team-technical-training'),
                'features' => [
                    'Customized content',
                    'Interactive sessions',
                    'Team projects',
                    'Post-training support (30 days)',
                    'Certificates for all participants',
                    'Training materials'
                ],
                'hasAccent' => false,
                'isPopular' => true,
                'serviceSlug' => 'team-technical-training'
            ],
            [
                'name' => 'Corporate Training',
                'tagline' => 'Large organizations',
                'price' => ['currency' => 'GH₵', 'amount' => 'Custom', 'period' => ''],
                'cancelText' => 'Multi-day programs',
                'ctaText' => 'Contact Us',
                'ctaUrl' => route('services.show', 'corporate-training-program'),
                'features' => [
                    'Unlimited participants',
                    'Custom curriculum design',
                    'On-site or remote delivery',
                    'Skills assessment',
                    '90-day post-training support',
                    'Management reporting'
                ],
                'hasAccent' => false,
                'isPopular' => false,
                'serviceSlug' => 'corporate-training-program'
            ]
        ]
    ]
];

$categoriesList = empty($pricingCategories) ? $defaultPricingCategories : $pricingCategories;
@endphp

<section class="pricing" id="pricing">
    <img src="{{ asset($decorativeImages['leftStripes']) }}" alt="" class="decorative-element pricing-left-stripes">
    <img src="{{ asset($decorativeImages['rightShape']) }}" alt="" class="decorative-element pricing-right-shape">
    
    <h2{{ $animateOnScroll ? ' class=animate-on-scroll' : '' }}>{{ $title }}</h2>
    <p class="pricing-subheading{{ $animateOnScroll ? ' animate-on-scroll' : '' }}">{{ $subtitle }}</p>

    <!-- Currency Switcher -->
    <div class="currency-switcher{{ $animateOnScroll ? ' animate-on-scroll' : '' }}">
        <div class="currency-switcher-container">
            <label for="currency-select" class="currency-label">
                <i class="fas fa-globe" aria-hidden="true"></i>
                Currency:
            </label>
            <select id="currency-select" class="currency-select" aria-label="Select currency">
                <option value="GHS" data-symbol="GH₵">Ghana Cedi (GH₵)</option>
                <option value="USD" data-symbol="$">US Dollar ($)</option>
                <option value="EUR" data-symbol="€">Euro (€)</option>
                <option value="GBP" data-symbol="£">British Pound (£)</option>
            </select>
            <div class="currency-loading" style="display: none;">
                <i class="fas fa-spinner fa-spin" aria-hidden="true"></i>
                <span>Updating prices...</span>
            </div>
        </div>
    </div>

    <!-- Desktop Pricing Tabs with Navigation -->
    <div class="pricing-tabs-wrapper{{ $animateOnScroll ? ' animate-on-scroll' : '' }}">
        <button class="pricing-tabs-nav pricing-tabs-nav-left" aria-label="Scroll tabs left" disabled>
            <i class="fas fa-chevron-left" aria-hidden="true"></i>
        </button>
        <div class="pricing-tabs-container">
            <div class="pricing-tabs">
                @foreach($categoriesList as $key => $category)
                    <button class="pricing-tab{{ $loop->first ? ' active' : '' }}" data-tab="{{ $key }}">{{ $category['title'] }}</button>
                @endforeach
            </div>
        </div>
        <button class="pricing-tabs-nav pricing-tabs-nav-right" aria-label="Scroll tabs right">
            <i class="fas fa-chevron-right" aria-hidden="true"></i>
        </button>
    </div>
    
    <!-- Mobile Pricing Dropdown -->
    <div class="pricing-tabs-mobile-dropdown{{ $animateOnScroll ? ' animate-on-scroll' : '' }}">
        <button class="pricing-dropdown-selected" aria-expanded="false" aria-haspopup="listbox" role="combobox" aria-labelledby="pricing-dropdown-label">
            <span class="selected-text">{{ reset($categoriesList)['title'] }}</span>
            <i class="fas fa-chevron-down dropdown-arrow" aria-hidden="true"></i>
        </button>
        <div class="pricing-dropdown-options" role="listbox" aria-labelledby="pricing-dropdown-label">
            @foreach($categoriesList as $key => $category)
                <div class="pricing-dropdown-option{{ $loop->first ? ' active' : '' }}" role="option" data-tab="{{ $key }}" tabindex="0">{{ $category['title'] }}</div>
            @endforeach
        </div>
    </div>
    
    <!-- Hidden label for accessibility -->
    <div id="pricing-dropdown-label" class="sr-only">Select pricing category</div>
    
    <!-- Pricing Content for each category -->
    @foreach($categoriesList as $key => $category)
        <div class="pricing-content{{ $loop->first ? ' active' : '' }}" id="{{ $key }}">
            <div class="pricing-grid{{ $loop->first ? ' stagger-children' : '' }}">
                @foreach($category['plans'] as $plan)
                    <div class="pricing-card{{ $plan['isPopular'] ? ' popular' : '' }}">
                        @if($plan['hasAccent'])
                            <img src="{{ asset('images/decorative/cta_left_mem_dots_f_circle2.svg') }}" alt="" class="pricing-card-accent">
                        @endif
                        <h3>{{ $plan['name'] }}</h3>
                        <p class="pricing-tagline">{{ $plan['tagline'] }}</p>
                        <div class="price" data-service-slug="{{ $plan['serviceSlug'] ?? '' }}">
                            <span class="currency">{{ $plan['price']['currency'] }}</span>
                            <span class="amount">{{ $plan['price']['amount'] }}</span>
                            @if($plan['price']['period'])
                                <span class="period">{{ $plan['price']['period'] }}</span>
                            @endif
                        </div>
                        <p class="cancel-text">{{ $plan['cancelText'] }}</p>
                        <a href="{{ $plan['ctaUrl'] }}" class="btn-pricing">{{ $plan['ctaText'] }}</a>
                        <ul class="features-list">
                            @foreach($plan['features'] as $feature)
                                <li><i class="fas fa-circle-check"></i> {{ $feature }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach

    <!-- Regional Discounts Notice -->
    <div class="regional-discount-notice{{ $animateOnScroll ? ' animate-on-scroll' : '' }}">
        <div class="notice-content">
            <i class="fas fa-info-circle notice-icon"></i>
            <span class="notice-text">
                {{-- <strong>Regional Pricing:</strong> Base rates displayed. Automatic regional discounts applied based on your location to ensure fair pricing across different markets. Current regional discounts active for Ghana only! --}}
                <strong> Regional Pricing Notice</strong> We are rolling out regional discounts, but the prices displayed are currently for Ghana only. For pricing applicable to your region, please email: <a href="mailto:sales@manifestghana.com">sales@manifestghana.com </a>
            </span>
        </div>
    </div>
</section>

<style>
/* Regional Discount Notice Styles */
.regional-discount-notice {
    background: linear-gradient(135deg, #f0f8ff 0%, #e6f3ff 100%);
    border: 1px solid #d1e7ff;
    border-radius: 12px;
    padding: 1rem 1.5rem;
    margin: 1.5rem auto 2.5rem;
    max-width: 800px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.notice-content {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
}

.notice-icon {
    color: #0066cc;
    font-size: 1.1rem;
    margin-top: 0.1rem;
    flex-shrink: 0;
}

.notice-text {
    color: #333;
    font-size: 0.95rem;
    line-height: 1.5;
}

.notice-text strong {
    color: #0066cc;
    font-weight: 600;
}

/* Mobile responsiveness for the notice */
@media (max-width: 768px) {
    .regional-discount-notice {
        margin: 1rem 1rem 2rem;
        padding: 0.875rem 1rem;
    }

    .notice-text {
        font-size: 0.9rem;
    }
}

/* Currency Switcher Styles */
.currency-switcher {
    display: flex;
    justify-content: center;
    margin: 2rem 0 2.5rem;
}

.currency-switcher-container {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    background: linear-gradient(135deg, #ffffff 0%, #fbfbfb 100%);
    border: 2px solid #e1e1e1;
    border-radius: 12px;
    padding: 0.75rem 1.25rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
}

.currency-switcher-container:hover {
    border-color: #ff5722;
    box-shadow: 0 4px 12px rgba(255, 87, 34, 0.15);
}

.currency-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.95rem;
    font-weight: 600;
    color: #333;
    margin: 0;
    cursor: default;
}

.currency-label .fas {
    color: #ff5722;
    font-size: 1rem;
}

.currency-select {
    background: white;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 0.5rem 2rem 0.5rem 0.75rem;
    font-size: 0.95rem;
    font-weight: 500;
    color: #333;
    cursor: pointer;
    transition: all 0.2s ease;
    appearance: none;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 0.5rem center;
    background-repeat: no-repeat;
    background-size: 1.5em 1.5em;
    min-width: 180px;
}

.currency-select:hover {
    border-color: #ff5722;
    box-shadow: 0 0 0 3px rgba(255, 87, 34, 0.1);
}

.currency-select:focus {
    outline: none;
    border-color: #ff5722;
    box-shadow: 0 0 0 3px rgba(255, 87, 34, 0.2);
}

.currency-loading {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #666;
    font-size: 0.9rem;
    font-weight: 500;
}

.currency-loading .fas {
    color: #ff5722;
}

/* Loading state for dynamic pricing */
.price.loading .amount {
    opacity: 0.6;
    animation: pulse 1.5s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% {
        opacity: 0.6;
    }
    50% {
        opacity: 0.3;
    }
}

/* Error notice styles */
.pricing-error-notice {
    background: linear-gradient(135deg, #ffe8e8 0%, #ffebeb 100%);
    border: 1px solid #ffccc7;
    border-radius: 8px;
    margin: 1rem auto 2rem;
    max-width: 600px;
    animation: slideInDown 0.3s ease-out;
}

.error-content {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem 1.25rem;
}

.error-icon {
    color: #d63031;
    font-size: 1.1rem;
    flex-shrink: 0;
}

.error-text {
    color: #333;
    font-size: 0.95rem;
    flex-grow: 1;
}

.error-close {
    background: none;
    border: none;
    color: #d63031;
    cursor: pointer;
    font-size: 1rem;
    padding: 0.25rem;
    border-radius: 4px;
    transition: background-color 0.2s ease;
    flex-shrink: 0;
}

.error-close:hover {
    background-color: rgba(214, 48, 49, 0.1);
}

@keyframes slideInDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Mobile responsiveness for currency switcher */
@media (max-width: 768px) {
    .currency-switcher-container {
        flex-direction: column;
        gap: 0.5rem;
        padding: 1rem;
        text-align: center;
    }

    .currency-label {
        justify-content: center;
        font-size: 0.9rem;
    }

    .currency-select {
        min-width: 160px;
        font-size: 0.9rem;
    }

    .currency-loading {
        font-size: 0.85rem;
    }

    .pricing-error-notice {
        margin: 1rem 1rem 2rem;
    }

    .error-content {
        padding: 0.875rem 1rem;
    }

    .error-text {
        font-size: 0.9rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Load dynamic pricing from currency service
    loadDynamicPricing();
    
    // Setup currency switcher
    const currencySelect = document.getElementById('currency-select');
    if (currencySelect) {
        currencySelect.addEventListener('change', handleCurrencyChange);
    }
});

async function loadDynamicPricing(currency = null) {
    try {
        // Add loading state
        const priceElements = document.querySelectorAll('.price[data-service-slug]');
        priceElements.forEach(el => el.classList.add('loading'));
        
        // Show currency loading if currency is being changed
        if (currency) {
            showCurrencyLoading(true);
        }

        // Build API URL with currency parameter
        const apiUrl = currency ? `/api/pricing?currency=${currency}` : '/api/pricing';

        // Fetch dynamic pricing data
        const response = await fetch(apiUrl, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            }
        });

        if (!response.ok) {
            console.warn('Dynamic pricing API not available, using static prices');
            return;
        }

        const data = await response.json();
        
        if (data.success && data.data) {
            updatePricingDisplay(data.data);
            updateCurrencySelect(data.data.currency);
        }
    } catch (error) {
        console.warn('Error loading dynamic pricing:', error);
        showError('Failed to load pricing. Please refresh the page.');
    } finally {
        // Remove loading state
        const priceElements = document.querySelectorAll('.price[data-service-slug]');
        priceElements.forEach(el => el.classList.remove('loading'));
        
        showCurrencyLoading(false);
    }
}

function handleCurrencyChange(event) {
    const selectedCurrency = event.target.value;
    loadDynamicPricing(selectedCurrency);
}

function showCurrencyLoading(show) {
    const loadingElement = document.querySelector('.currency-loading');
    const selectElement = document.getElementById('currency-select');
    
    if (loadingElement && selectElement) {
        loadingElement.style.display = show ? 'flex' : 'none';
        selectElement.disabled = show;
    }
}

function updateCurrencySelect(currency) {
    const selectElement = document.getElementById('currency-select');
    if (selectElement && currency.code) {
        selectElement.value = currency.code;
    }
}

function showError(message) {
    // Create or update error notice
    let errorNotice = document.querySelector('.pricing-error-notice');
    if (!errorNotice) {
        errorNotice = document.createElement('div');
        errorNotice.className = 'pricing-error-notice';
        const pricingSection = document.querySelector('.pricing');
        if (pricingSection) {
            pricingSection.insertBefore(errorNotice, pricingSection.firstChild);
        }
    }
    
    errorNotice.innerHTML = `
        <div class="error-content">
            <i class="fas fa-exclamation-triangle error-icon"></i>
            <span class="error-text">${message}</span>
            <button class="error-close" onclick="this.parentElement.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    
    // Auto-hide after 5 seconds
    setTimeout(() => {
        if (errorNotice && errorNotice.parentElement) {
            errorNotice.remove();
        }
    }, 5000);
}

function updatePricingDisplay(pricingData) {
    const { currency, services } = pricingData;
    
    // Update each service price
    services.forEach(service => {
        const priceElement = document.querySelector(`[data-service-slug="${service.slug}"]`);
        
        if (priceElement && service.price !== null) {
            // Update currency symbol
            const currencySpan = priceElement.querySelector('.currency');
            if (currencySpan) {
                currencySpan.textContent = currency.symbol;
            }
            
            // Update amount
            const amountSpan = priceElement.querySelector('.amount');
            if (amountSpan && service.price !== null) {
                // Use the numeric price directly and format it properly
                const numericPrice = parseFloat(service.price);
                if (numericPrice === 0) {
                    amountSpan.textContent = 'Custom';
                } else {
                    // Format with commas for thousands
                    amountSpan.textContent = numericPrice.toLocaleString('en-US', {
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 0
                    });
                }
            }
        }
    });

    // Update regional pricing notice if needed
    updateRegionalNotice(currency);
}

function updateRegionalNotice(currency) {
    const noticeElement = document.querySelector('.regional-discount-notice .notice-text');
    
    if (noticeElement && currency.code !== 'GHS') {
        // Show that pricing is automatically adjusted for their region
        noticeElement.innerHTML = `
            <strong>Regional Pricing Active:</strong> 
            Prices automatically adjusted for your region (${currency.code}). 
            Base pricing shown in ${currency.symbol} with regional discounts already applied.
            For questions, contact: <a href="mailto:sales@manifestghana.com">sales@manifestghana.com</a>
        `;
    }
}
</script>