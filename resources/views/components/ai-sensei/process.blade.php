@props([
    'title' => 'Our AI Implementation Process',
    'description' => 'From concept to deployment, we ensure smooth AI integration into your business',
    'steps' => [
        [
            'number' => '1',
            'title' => 'Discovery & Analysis',
            'description' => 'We start by understanding your business challenges, goals, and existing workflows. Our team conducts a thorough analysis to identify the best AI opportunities for maximum impact.'
        ],
        [
            'number' => '2',
            'title' => 'Strategy & Planning',
            'description' => 'We develop a customized AI roadmap with clear objectives, milestones, and success metrics. You\'ll receive a detailed proposal with transparent pricing and timelines.'
        ],
        [
            'number' => '3',
            'title' => 'Development & Training',
            'description' => 'Our experts build and train your AI models using your data and industry best practices. We ensure the solution is tailored to your specific needs and use cases.'
        ],
        [
            'number' => '4',
            'title' => 'Testing & Optimization',
            'description' => 'Rigorous testing ensures accuracy, reliability, and performance. We fine-tune the models and optimize for speed, cost-efficiency, and user experience.'
        ],
        [
            'number' => '5',
            'title' => 'Deployment & Support',
            'description' => 'We handle seamless deployment and provide comprehensive training for your team. Ongoing support, monitoring, and continuous improvement ensure long-term success.'
        ]
    ]
])

<section class="process-section">
    <div class="capabilities-container">
        <div class="section-header">
            <h2>{{ $title }}</h2>
            <p>{{ $description }}</p>
        </div>
        
        <div class="process-steps">
            @foreach($steps as $step)
            <div class="process-step">
                <div class="step-number">{{ $step['number'] }}</div>
                <div class="step-content">
                    <h3>{{ $step['title'] }}</h3>
                    <p>{{ $step['description'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

@push('styles')
<style>
.process-section {
    padding: 100px 0;
    background: #f8f8f8;
}

.process-steps {
    max-width: 1000px;
    margin: 60px auto 0;
    padding: 0 20px;
}

.process-step {
    display: grid;
    grid-template-columns: 80px 1fr;
    gap: 30px;
    margin-bottom: 50px;
    position: relative;
}

.process-step:not(:last-child)::after {
    content: '';
    position: absolute;
    left: 40px;
    top: 80px;
    width: 2px;
    height: calc(100% - 30px);
    background: linear-gradient(to bottom, #ff2200, transparent);
}

.step-number {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #ff2200, #ff4422);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 32px;
    font-weight: 800;
    color: white;
}

.step-content h3 {
    font-size: 24px;
    font-weight: 700;
    margin-bottom: 12px;
    color: #1a1a1a;
}

.step-content p {
    font-size: 16px;
    color: #666;
    line-height: 1.7;
}

@media (max-width: 768px) {
    .process-step {
        grid-template-columns: 60px 1fr;
        gap: 20px;
    }
    
    .step-number {
        width: 60px;
        height: 60px;
        font-size: 24px;
    }
    
    .process-step:not(:last-child)::after {
        left: 30px;
        top: 60px;
    }
}
</style>
@endpush