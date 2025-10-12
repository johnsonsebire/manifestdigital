@props([
    'title' => 'AI Solutions Across Industries',
    'description' => 'See how businesses like yours are leveraging AI to gain competitive advantage',
    'useCases' => [
        [
            'icon' => 'fas fa-store',
            'title' => 'E-Commerce',
            'description' => 'Product recommendations, chatbots, inventory prediction, dynamic pricing'
        ],
        [
            'icon' => 'fas fa-heartbeat',
            'title' => 'Healthcare',
            'description' => 'Patient triage, appointment scheduling, medical record analysis'
        ],
        [
            'icon' => 'fas fa-graduation-cap',
            'title' => 'Education',
            'description' => 'Personalized learning, automated grading, student support chatbots'
        ],
        [
            'icon' => 'fas fa-building',
            'title' => 'Real Estate',
            'description' => 'Property matching, lead qualification, market analysis'
        ],
        [
            'icon' => 'fas fa-chart-bar',
            'title' => 'Finance',
            'description' => 'Fraud detection, risk assessment, automated reporting'
        ],
        [
            'icon' => 'fas fa-users',
            'title' => 'Customer Service',
            'description' => '24/7 support, ticket routing, sentiment analysis'
        ]
    ]
])

<section class="use-cases">
    <div class="capabilities-container">
        <div class="section-header">
            <h2>{{ $title }}</h2>
            <p>{{ $description }}</p>
        </div>
        
        <div class="use-cases-grid">
            @foreach($useCases as $useCase)
            <div class="use-case-card">
                <div class="use-case-icon">
                    <i class="{{ $useCase['icon'] }}"></i>
                </div>
                <h3>{{ $useCase['title'] }}</h3>
                <p>{{ $useCase['description'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

@push('styles')
<style>
.use-cases {
    padding: 100px 0;
    background: #f8f8f8;
}

.use-cases-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 25px;
    margin-top: 50px;
}

.use-case-card {
    background: white;
    padding: 35px 25px;
    border-radius: 12px;
    text-align: center;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.use-case-card:hover {
    border-color: #ff2200;
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
}

.use-case-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #ff220015, #ff442215);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
}

.use-case-icon i {
    font-size: 36px;
    color: #ff2200;
}

.use-case-card h3 {
    font-size: 20px;
    font-weight: 700;
    margin-bottom: 12px;
    color: #1a1a1a;
}

.use-case-card p {
    font-size: 15px;
    color: #666;
    line-height: 1.6;
}

@media (max-width: 768px) {
    .use-cases-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endpush