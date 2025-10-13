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
                'ctaUrl' => '#',
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
                'ctaUrl' => '#',
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
                'ctaUrl' => '#',
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
                'ctaUrl' => '#',
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
                'ctaUrl' => '#',
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
                'ctaUrl' => '#',
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
                'ctaUrl' => '#',
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
                'ctaUrl' => '#',
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
                'ctaUrl' => '#',
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
                'ctaUrl' => '#',
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
                'ctaUrl' => '#',
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
                'ctaUrl' => '#',
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
                'ctaUrl' => '#',
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
                'ctaUrl' => '#',
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
                'ctaUrl' => '#',
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
                'ctaUrl' => '#',
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
                'ctaUrl' => '#',
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
                'ctaUrl' => '#',
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
                'ctaUrl' => '#',
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
                'ctaUrl' => '#',
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
                'ctaUrl' => '#',
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
</section>