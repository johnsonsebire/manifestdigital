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
                'isPopular' => false
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
                'isPopular' => true
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
                'isPopular' => false
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
                'isPopular' => false
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
                'isPopular' => false
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
                'isPopular' => false
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
                'isPopular' => true
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
                'isPopular' => false
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
                'isPopular' => false
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
                'isPopular' => true
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
                'isPopular' => false
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
                'isPopular' => false
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
                'isPopular' => true
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
                'isPopular' => false
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
                'isPopular' => false
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
                'isPopular' => true
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
                'isPopular' => false
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
                'isPopular' => false
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
                'isPopular' => true
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
                'isPopular' => false
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
                        <div class="price">
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
</style>