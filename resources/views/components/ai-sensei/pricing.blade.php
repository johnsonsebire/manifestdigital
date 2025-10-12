@props([
    'title' => 'AI Solutions for Every Business',
    'description' => 'Flexible pricing packages designed to fit your needs and budget',
    'plans' => [
        [
            'name' => 'AI Starter',
            'price' => 'GH₵2,500',
            'period' => '/month',
            'description' => 'Perfect for small businesses starting their AI journey',
            'features' => [
                'Basic AI chatbot (1 platform)',
                'Up to 1,000 conversations/month',
                'Custom training on your data',
                'Email support',
                'Monthly analytics report',
                '2 integration points'
            ],
            'buttonText' => 'Get Started',
            'buttonUrl' => '/book-a-call',
            'featured' => false
        ],
        [
            'name' => 'AI Professional',
            'price' => 'GH₵6,000',
            'period' => '/month',
            'description' => 'Comprehensive AI solution for growing businesses',
            'features' => [
                'Advanced AI chatbot (multi-platform)',
                'Up to 10,000 conversations/month',
                'Custom ML models',
                'Workflow automation (3 processes)',
                'Priority support (24/7)',
                'Advanced analytics dashboard',
                'Unlimited integrations',
                'API access'
            ],
            'buttonText' => 'Get Started',
            'buttonUrl' => '/book-a-call',
            'featured' => true,
            'badge' => 'MOST POPULAR'
        ],
        [
            'name' => 'AI Enterprise',
            'price' => 'Custom',
            'period' => '',
            'description' => 'Tailored AI solutions for large organizations',
            'features' => [
                'Enterprise AI platform',
                'Unlimited conversations',
                'Custom model development',
                'Full automation suite',
                'Dedicated AI team',
                'White-label solutions',
                'SLA guarantees',
                'On-premise deployment option'
            ],
            'buttonText' => 'Contact Sales',
            'buttonUrl' => '/book-a-call',
            'featured' => false
        ]
    ]
])

<section class="pricing-section" id="pricing">
    <div class="section-header">
        <h2>{{ $title }}</h2>
        <p>{{ $description }}</p>
    </div>
    
    <div class="pricing-cards">
        @foreach($plans as $plan)
        <div class="pricing-card-ai {{ $plan['featured'] ? 'featured' : '' }}">
            @if($plan['featured'] && isset($plan['badge']))
            <span class="pricing-badge">{{ $plan['badge'] }}</span>
            @endif
            <h3>{{ $plan['name'] }}</h3>
            <div class="pricing-price">
                <span class="amount">{{ $plan['price'] }}</span>
                @if($plan['period'])
                <span class="period">{{ $plan['period'] }}</span>
                @endif
            </div>
            <p class="pricing-description">{{ $plan['description'] }}</p>
            <ul class="pricing-features">
                @foreach($plan['features'] as $feature)
                <li><i class="fas fa-check-circle"></i> {{ $feature }}</li>
                @endforeach
            </ul>
            <a href="{{ $plan['buttonUrl'] }}" class="btn-pricing-ai">{{ $plan['buttonText'] }}</a>
        </div>
        @endforeach
    </div>
</section>

@push('styles')
<style>
.pricing-section {
    padding: 100px 0;
    background: white;
}

.pricing-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 30px;
    max-width: 1200px;
    margin: 50px auto 0;
    padding: 0 20px;
}

.pricing-card-ai {
    background: white;
    border: 2px solid #e0e0e0;
    border-radius: 16px;
    padding: 40px 30px;
    transition: all 0.3s ease;
    position: relative;
}

.pricing-card-ai.featured {
    border-color: #ff2200;
    box-shadow: 0 10px 40px rgba(255, 34, 0, 0.15);
}

.pricing-card-ai:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 50px rgba(0,0,0,0.1);
}

.pricing-badge {
    position: absolute;
    top: -15px;
    right: 30px;
    background: #ff2200;
    color: white;
    padding: 6px 16px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 700;
}

.pricing-card-ai h3 {
    font-size: 28px;
    font-weight: 800;
    margin-bottom: 15px;
    color: #1a1a1a;
}

.pricing-price {
    margin-bottom: 25px;
}

.pricing-price .amount {
    font-size: 48px;
    font-weight: 800;
    color: #ff2200;
}

.pricing-price .period {
    font-size: 18px;
    color: #666;
}

.pricing-description {
    font-size: 15px;
    color: #666;
    margin-bottom: 25px;
    line-height: 1.6;
}

.pricing-features {
    list-style: none;
    padding: 0;
    margin: 0 0 30px 0;
}

.pricing-features li {
    padding: 12px 0;
    color: #333;
    font-size: 15px;
    display: flex;
    align-items: center;
    gap: 12px;
    border-bottom: 1px solid #f0f0f0;
}

.pricing-features li:last-child {
    border-bottom: none;
}

.pricing-features li i {
    color: #ff2200;
    font-size: 14px;
}

.btn-pricing-ai {
    width: 100%;
    padding: 14px 28px;
    background: linear-gradient(135deg, #ff2200, #ff4422);
    color: white;
    border: none;
    border-radius: 8px;
    font-weight: 700;
    font-size: 16px;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-block;
    text-align: center;
}

.btn-pricing-ai:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(255, 34, 0, 0.3);
    color: white;
}

@media (max-width: 768px) {
    .pricing-cards {
        grid-template-columns: 1fr;
    }
}
</style>
@endpush