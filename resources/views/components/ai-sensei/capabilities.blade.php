@props([
    'title' => 'Cutting-Edge AI Solutions',
    'description' => 'From intelligent chatbots to predictive analytics, we build custom AI solutions tailored to your business needs',
    'capabilities' => [
        [
            'icon' => 'fas fa-comments',
            'title' => 'AI Chatbots & Assistants',
            'description' => 'Intelligent conversational AI that handles customer inquiries 24/7, reducing support costs by up to 70%.',
            'features' => [
                'Natural language processing',
                'Multi-platform integration',
                'Custom training on your data',
                'Analytics & insights dashboard'
            ]
        ],
        [
            'icon' => 'fas fa-robot',
            'title' => 'Business Automation',
            'description' => 'Automate repetitive tasks and workflows with AI-powered tools that learn and improve over time.',
            'features' => [
                'Document processing & extraction',
                'Workflow automation',
                'Email & communication automation',
                'Data entry & validation'
            ]
        ],
        [
            'icon' => 'fas fa-brain',
            'title' => 'Machine Learning Models',
            'description' => 'Custom ML models for predictions, classifications, and pattern recognition tailored to your industry.',
            'features' => [
                'Predictive analytics',
                'Customer behavior modeling',
                'Fraud detection',
                'Recommendation systems'
            ]
        ],
        [
            'icon' => 'fas fa-chart-line',
            'title' => 'Data Analytics & Insights',
            'description' => 'Transform raw data into actionable insights with AI-powered analytics and visualization tools.',
            'features' => [
                'Real-time data processing',
                'Automated reporting',
                'Trend analysis & forecasting',
                'Custom dashboards'
            ]
        ],
        [
            'icon' => 'fas fa-microchip',
            'title' => 'AI Integration Services',
            'description' => 'Seamlessly integrate AI capabilities into your existing systems and workflows.',
            'features' => [
                'API development & integration',
                'OpenAI & GPT integration',
                'Cloud AI services (AWS, Azure, GCP)',
                'Legacy system modernization'
            ]
        ],
        [
            'icon' => 'fas fa-shield-alt',
            'title' => 'AI Security & Compliance',
            'description' => 'Enterprise-grade security and compliance for your AI implementations.',
            'features' => [
                'Data privacy & GDPR compliance',
                'Secure model deployment',
                'Bias detection & mitigation',
                'Audit trails & monitoring'
            ]
        ]
    ]
])

<section class="ai-capabilities">
    <div class="capabilities-container">
        <div class="section-header">
            <h2>{{ $title }}</h2>
            <p>{{ $description }}</p>
        </div>
        
        <div class="capabilities-grid">
            @foreach($capabilities as $capability)
            <div class="capability-card">
                <div class="capability-icon">
                    <i class="{{ $capability['icon'] }}"></i>
                </div>
                <h3>{{ $capability['title'] }}</h3>
                <p>{{ $capability['description'] }}</p>
                <ul class="capability-features">
                    @foreach($capability['features'] as $feature)
                    <li><i class="fas fa-check-circle"></i> {{ $feature }}</li>
                    @endforeach
                </ul>
            </div>
            @endforeach
        </div>
    </div>
</section>

@push('styles')
<style>
.ai-capabilities {
    padding: 100px 0;
    background: white;
}

.capabilities-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.section-header {
    text-align: center;
    margin-bottom: 60px;
}

.section-header h2 {
    font-size: 48px;
    font-weight: 800;
    margin-bottom: 20px;
    color: #1a1a1a;
}

.section-header p {
    font-size: 20px;
    color: #666;
    max-width: 700px;
    margin: 0 auto;
}

.capabilities-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 30px;
}

.capability-card {
    background: #f8f8f8;
    padding: 40px 30px;
    border-radius: 16px;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.capability-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background: linear-gradient(135deg, #ff2200, #ff4422);
    transform: scaleY(0);
    transition: transform 0.3s ease;
}

.capability-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.1);
}

.capability-card:hover::before {
    transform: scaleY(1);
}

.capability-icon {
    width: 70px;
    height: 70px;
    background: linear-gradient(135deg, #ff2200, #ff4422);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 25px;
}

.capability-icon i {
    font-size: 32px;
    color: white;
}

.capability-card h3 {
    font-size: 24px;
    font-weight: 700;
    margin-bottom: 15px;
    color: #1a1a1a;
}

.capability-card p {
    font-size: 16px;
    color: #666;
    line-height: 1.7;
    margin-bottom: 20px;
}

.capability-features {
    list-style: none;
    padding: 0;
    margin: 0;
}

.capability-features li {
    padding: 8px 0;
    color: #333;
    font-size: 15px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.capability-features li i {
    color: #ff2200;
    font-size: 12px;
}

@media (max-width: 768px) {
    .section-header h2 {
        font-size: 36px;
    }
    
    .capabilities-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endpush