@props([
    'title' => 'Our Development Process',
    'description' => 'A proven methodology that ensures successful project delivery',
    'steps' => [
        [
            'number' => '01',
            'title' => 'Discovery & Planning',
            'description' => 'We analyze your requirements, conduct market research, and create detailed project roadmaps',
            'icon' => 'fas fa-search'
        ],
        [
            'number' => '02',
            'title' => 'Design & Prototyping',
            'description' => 'Our designers create intuitive user experiences with interactive prototypes for validation',
            'icon' => 'fas fa-paint-brush'
        ],
        [
            'number' => '03',
            'title' => 'Development & Testing',
            'description' => 'Agile development approach with continuous testing and quality assurance',
            'icon' => 'fas fa-code'
        ],
        [
            'number' => '04',
            'title' => 'Deployment & Support',
            'description' => 'Seamless deployment with ongoing maintenance and 24/7 technical support',
            'icon' => 'fas fa-rocket'
        ]
    ]
])

<section class="process-section">
    <div class="process-container">
        <div class="section-intro">
            <h2>{{ $title }}</h2>
            <p>{{ $description }}</p>
        </div>
        
        <div class="process-steps">
            @foreach($steps as $index => $step)
            <div class="process-step" data-step="{{ $index + 1 }}">
                <div class="step-number">{{ $step['number'] }}</div>
                <div class="step-content">
                    <div class="step-icon">
                        <i class="{{ $step['icon'] }}"></i>
                    </div>
                    <h4>{{ $step['title'] }}</h4>
                    <p>{{ $step['description'] }}</p>
                </div>
                @if($index < count($steps) - 1)
                <div class="step-connector"></div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</section>

@push('styles')
<style>
/* Process Section */
.process-section {
    padding: 80px 20px;
    background: white;
}

.process-container {
    max-width: 1400px;
    margin: 0 auto;
}

.process-steps {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 40px;
    margin-top: 50px;
    position: relative;
}

.process-step {
    text-align: center;
    position: relative;
    padding: 30px 20px;
}

.step-number {
    font-size: 48px;
    font-weight: 900;
    background: linear-gradient(135deg, #ff2200, #ff6b00);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 20px;
    line-height: 1;
}

.step-content {
    background: #f8f9fa;
    padding: 30px;
    border-radius: 15px;
    transition: all 0.3s ease;
    height: 100%;
}

.step-content:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.step-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #ff2200, #ff6b00);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
}

.step-icon i {
    font-size: 24px;
    color: white;
}

.step-content h4 {
    font-size: 20px;
    font-weight: 800;
    margin-bottom: 15px;
    color: #1a1a1a;
}

.step-content p {
    color: #666;
    font-size: 14px;
    line-height: 1.6;
}

.step-connector {
    position: absolute;
    top: 50%;
    right: -20px;
    width: 40px;
    height: 2px;
    background: linear-gradient(90deg, #ff2200, #ff6b00);
    transform: translateY(-50%);
    z-index: 1;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .process-steps {
        grid-template-columns: 1fr;
        gap: 30px;
    }
    
    .step-connector {
        display: none;
    }
    
    .process-step::after {
        content: '';
        position: absolute;
        bottom: -15px;
        left: 50%;
        width: 2px;
        height: 30px;
        background: linear-gradient(180deg, #ff2200, #ff6b00);
        transform: translateX(-50%);
    }
    
    .process-step:last-child::after {
        display: none;
    }
}
</style>
@endpush