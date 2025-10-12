@props([
    'title' => 'Service Packages',
    'description' => 'Choose the perfect package for your needs. All packages include our core features with varying levels of customization and support.',
    'packages' => [
        [
            'name' => 'Starter',
            'description' => 'Perfect for small businesses and startups',
            'price' => '$2,500',
            'duration' => 'Starting from',
            'features' => [
                'Up to 5 pages',
                'Responsive design',
                'Basic SEO setup',
                'Contact form',
                'Social media integration',
                '1 month support',
                'Basic analytics'
            ],
            'popular' => false,
            'cta' => 'Get Started'
        ],
        [
            'name' => 'Professional',
            'description' => 'Ideal for growing businesses',
            'price' => '$5,000',
            'duration' => 'Starting from',
            'features' => [
                'Up to 15 pages',
                'Custom design',
                'Advanced SEO',
                'CMS integration',
                'Blog functionality',
                'E-commerce ready',
                '3 months support',
                'Advanced analytics',
                'Performance optimization'
            ],
            'popular' => true,
            'cta' => 'Most Popular'
        ],
        [
            'name' => 'Enterprise',
            'description' => 'For large organizations with complex needs',
            'price' => '$10,000',
            'duration' => 'Starting from',
            'features' => [
                'Unlimited pages',
                'Custom functionality',
                'Enterprise SEO',
                'Multi-language support',
                'Advanced integrations',
                'Custom CMS',
                '6 months support',
                'Priority support',
                'Dedicated project manager',
                'Training included'
            ],
            'popular' => false,
            'cta' => 'Contact Us'
        ]
    ],
    'addOns' => [
        ['name' => 'E-commerce Integration', 'price' => '$1,500'],
        ['name' => 'Multi-language Support', 'price' => '$800'],
        ['name' => 'Advanced Analytics', 'price' => '$500'],
        ['name' => 'Third-party Integrations', 'price' => '$300/each'],
        ['name' => 'Extended Support (per month)', 'price' => '$200'],
        ['name' => 'Priority Support', 'price' => '$500/month']
    ]
])

<section class="pricing-section">
    <div class="pricing-container">
        <div class="section-intro">
            <h2>{{ $title }}</h2>
            <p>{{ $description }}</p>
        </div>
        
        <div class="pricing-grid">
            @foreach($packages as $package)
            <div class="pricing-card {{ $package['popular'] ? 'popular' : '' }}">
                @if($package['popular'])
                <div class="popular-badge">Most Popular</div>
                @endif
                
                <div class="package-header">
                    <h3>{{ $package['name'] }}</h3>
                    <p>{{ $package['description'] }}</p>
                    <div class="price">
                        <span class="amount">{{ $package['price'] }}</span>
                        <span class="duration">{{ $package['duration'] }}</span>
                    </div>
                </div>
                
                <div class="package-features">
                    @foreach($package['features'] as $feature)
                    <div class="feature-item">
                        <i class="fas fa-check"></i>
                        <span>{{ $feature }}</span>
                    </div>
                    @endforeach
                </div>
                
                <div class="package-cta">
                    <a href="#contact" class="btn-package {{ $package['popular'] ? 'btn-primary' : 'btn-outline' }}">
                        {{ $package['cta'] }}
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="add-ons-section">
            <h3>Optional Add-ons</h3>
            <div class="add-ons-grid">
                @foreach($addOns as $addOn)
                <div class="add-on-item">
                    <span class="add-on-name">{{ $addOn['name'] }}</span>
                    <span class="add-on-price">{{ $addOn['price'] }}</span>
                </div>
                @endforeach
            </div>
        </div>
        
        <div class="pricing-note">
            <p><strong>Note:</strong> All prices are estimates and may vary based on specific requirements. Contact us for a detailed quote tailored to your project needs.</p>
        </div>
    </div>
</section>

@push('styles')
<style>
/* Pricing Section */
.pricing-section {
    padding: 80px 20px;
    background: white;
}

.pricing-container {
    max-width: 1400px;
    margin: 0 auto;
}

.pricing-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 30px;
    margin: 50px 0;
}

.pricing-card {
    background: #f8f9fa;
    border-radius: 20px;
    padding: 30px;
    text-align: center;
    transition: all 0.3s ease;
    position: relative;
    border: 2px solid transparent;
}

.pricing-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 40px rgba(0,0,0,0.1);
}

.pricing-card.popular {
    background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
    color: white;
    border: 2px solid #ff2200;
    transform: scale(1.05);
}

.popular-badge {
    position: absolute;
    top: -10px;
    left: 50%;
    transform: translateX(-50%);
    background: linear-gradient(135deg, #ff2200, #ff6b00);
    color: white;
    padding: 8px 20px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 700;
}

.package-header h3 {
    font-size: 28px;
    font-weight: 900;
    margin-bottom: 10px;
    color: inherit;
}

.pricing-card.popular .package-header h3 {
    background: linear-gradient(135deg, #ff2200, #ff6b00);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.package-header p {
    color: #666;
    margin-bottom: 25px;
    font-size: 16px;
}

.pricing-card.popular .package-header p {
    color: #ccc;
}

.price {
    margin-bottom: 30px;
}

.amount {
    font-size: 48px;
    font-weight: 900;
    color: #1a1a1a;
    display: block;
    line-height: 1;
}

.pricing-card.popular .amount {
    background: linear-gradient(135deg, #ff2200, #ff6b00);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.duration {
    font-size: 14px;
    color: #666;
    font-weight: 600;
}

.pricing-card.popular .duration {
    color: #ccc;
}

.package-features {
    text-align: left;
    margin-bottom: 30px;
}

.feature-item {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 12px;
    font-size: 15px;
}

.feature-item i {
    color: #28a745;
    font-size: 14px;
    flex-shrink: 0;
}

.pricing-card.popular .feature-item i {
    color: #ff2200;
}

.feature-item span {
    color: inherit;
}

.package-cta {
    margin-top: auto;
}

.btn-package {
    width: 100%;
    padding: 15px;
    border-radius: 10px;
    font-weight: 700;
    text-decoration: none;
    display: inline-block;
    transition: all 0.3s ease;
}

.add-ons-section {
    margin: 60px 0;
    padding: 40px;
    background: #f8f9fa;
    border-radius: 20px;
}

.add-ons-section h3 {
    font-size: 28px;
    font-weight: 800;
    text-align: center;
    margin-bottom: 30px;
    color: #1a1a1a;
}

.add-ons-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 15px;
}

.add-on-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 20px;
    background: white;
    border-radius: 10px;
    border-left: 4px solid #ff2200;
}

.add-on-name {
    font-weight: 600;
    color: #1a1a1a;
}

.add-on-price {
    font-weight: 800;
    color: #ff2200;
}

.pricing-note {
    text-align: center;
    padding: 30px;
    background: #fff3cd;
    border-radius: 15px;
    border-left: 4px solid #ffc107;
}

.pricing-note p {
    color: #856404;
    margin: 0;
    font-size: 14px;
    line-height: 1.5;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .pricing-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .pricing-card.popular {
        transform: none;
    }
    
    .add-ons-grid {
        grid-template-columns: 1fr;
    }
    
    .add-on-item {
        flex-direction: column;
        text-align: center;
        gap: 10px;
    }
}

@media (max-width: 480px) {
    .pricing-card {
        padding: 20px;
    }
    
    .amount {
        font-size: 36px;
    }
    
    .add-ons-section {
        padding: 30px 20px;
    }
}
</style>
@endpush