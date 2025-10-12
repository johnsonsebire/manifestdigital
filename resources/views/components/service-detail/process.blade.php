@props([
    'title' => 'Our Development Process',
    'description' => 'A proven methodology that ensures successful project delivery, from concept to launch and beyond.',
    'processes' => [
        [
            'step' => '01',
            'title' => 'Discovery & Planning',
            'description' => 'We start by understanding your business goals, target audience, and project requirements.',
            'activities' => [
                'Stakeholder interviews',
                'Market research',
                'Competitive analysis',
                'Technical requirements gathering',
                'Project timeline creation'
            ],
            'deliverables' => ['Project Brief', 'Technical Specification', 'Project Timeline'],
            'duration' => '1-2 weeks'
        ],
        [
            'step' => '02',
            'title' => 'Design & Prototyping',
            'description' => 'Our design team creates intuitive user experiences with interactive prototypes.',
            'activities' => [
                'User experience design',
                'Visual design creation',
                'Interactive prototyping',
                'Design system development',
                'Client feedback integration'
            ],
            'deliverables' => ['Wireframes', 'UI Designs', 'Interactive Prototype'],
            'duration' => '2-3 weeks'
        ],
        [
            'step' => '03',
            'title' => 'Development & Testing',
            'description' => 'Agile development approach with continuous testing and quality assurance.',
            'activities' => [
                'Frontend development',
                'Backend development',
                'Database design',
                'API development',
                'Quality assurance testing'
            ],
            'deliverables' => ['Working Application', 'Test Reports', 'Documentation'],
            'duration' => '4-8 weeks'
        ],
        [
            'step' => '04',
            'title' => 'Launch & Support',
            'description' => 'Seamless deployment with ongoing maintenance and technical support.',
            'activities' => [
                'Production deployment',
                'Performance optimization',
                'Security implementation',
                'Training delivery',
                'Ongoing support setup'
            ],
            'deliverables' => ['Live Website', 'Training Materials', 'Support Documentation'],
            'duration' => '1 week + ongoing'
        ]
    ]
])

<section class="process-section">
    <div class="process-container">
        <div class="section-intro">
            <h2>{{ $title }}</h2>
            <p>{{ $description }}</p>
        </div>
        
        <div class="process-timeline">
            @foreach($processes as $index => $process)
            <div class="process-step">
                <div class="step-header">
                    <div class="step-number">{{ $process['step'] }}</div>
                    <div class="step-info">
                        <h3>{{ $process['title'] }}</h3>
                        <div class="step-duration">{{ $process['duration'] }}</div>
                    </div>
                </div>
                
                <div class="step-content">
                    <p>{{ $process['description'] }}</p>
                    
                    <div class="step-details">
                        <div class="activities">
                            <h4>Key Activities</h4>
                            <ul>
                                @foreach($process['activities'] as $activity)
                                <li>{{ $activity }}</li>
                                @endforeach
                            </ul>
                        </div>
                        
                        <div class="deliverables">
                            <h4>Deliverables</h4>
                            <div class="deliverable-tags">
                                @foreach($process['deliverables'] as $deliverable)
                                <span class="deliverable-tag">{{ $deliverable }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                
                @if($index < count($processes) - 1)
                <div class="step-connector"></div>
                @endif
            </div>
            @endforeach
        </div>
        
        <div class="process-cta">
            <div class="cta-content">
                <h3>Ready to Start Your Project?</h3>
                <p>Let's discuss your requirements and create a customized development plan</p>
                <div class="cta-actions">
                    <a href="#contact" class="btn-primary">Start Your Project</a>
                    <a href="#" class="btn-secondary">Download Process Guide</a>
                </div>
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
/* Process Section */
.process-section {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 80px 20px;
}

.process-container {
    max-width: 1400px;
    margin: 0 auto;
}

.process-timeline {
    margin: 50px 0;
}

.process-step {
    background: white;
    border-radius: 20px;
    padding: 40px;
    margin-bottom: 30px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    position: relative;
    transition: all 0.3s ease;
}

.process-step:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 40px rgba(0,0,0,0.15);
}

.step-header {
    display: flex;
    align-items: center;
    gap: 30px;
    margin-bottom: 25px;
}

.step-number {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #ff2200, #ff6b00);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    font-weight: 900;
    color: white;
    flex-shrink: 0;
}

.step-info h3 {
    font-size: 28px;
    font-weight: 800;
    color: #1a1a1a;
    margin-bottom: 5px;
}

.step-duration {
    font-size: 14px;
    font-weight: 600;
    color: #ff2200;
    background: rgba(255, 34, 0, 0.1);
    padding: 4px 12px;
    border-radius: 20px;
    display: inline-block;
}

.step-content > p {
    font-size: 16px;
    color: #666;
    line-height: 1.6;
    margin-bottom: 30px;
}

.step-details {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
}

.activities h4,
.deliverables h4 {
    font-size: 18px;
    font-weight: 800;
    color: #1a1a1a;
    margin-bottom: 15px;
}

.activities ul {
    list-style: none;
    padding: 0;
}

.activities li {
    padding: 8px 0;
    color: #333;
    font-size: 15px;
    position: relative;
    padding-left: 20px;
}

.activities li::before {
    content: '•';
    color: #ff2200;
    font-weight: bold;
    position: absolute;
    left: 0;
}

.deliverable-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.deliverable-tag {
    background: linear-gradient(135deg, #ff2200, #ff6b00);
    color: white;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 600;
}

.step-connector {
    position: absolute;
    bottom: -15px;
    left: 50%;
    width: 4px;
    height: 30px;
    background: linear-gradient(180deg, #ff2200, #ff6b00);
    transform: translateX(-50%);
    border-radius: 2px;
}

.process-cta {
    background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
    border-radius: 20px;
    padding: 50px 30px;
    text-align: center;
    margin-top: 60px;
    color: white;
}

.process-cta h3 {
    font-size: 32px;
    font-weight: 900;
    margin-bottom: 15px;
    background: linear-gradient(135deg, #ff2200, #ff6b00);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.process-cta p {
    font-size: 18px;
    color: #ccc;
    margin-bottom: 30px;
}

.cta-actions {
    display: flex;
    gap: 20px;
    justify-content: center;
    flex-wrap: wrap;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .process-step {
        padding: 30px 20px;
    }
    
    .step-header {
        flex-direction: column;
        text-align: center;
        gap: 20px;
    }
    
    .step-number {
        width: 60px;
        height: 60px;
        font-size: 20px;
    }
    
    .step-info h3 {
        font-size: 24px;
    }
    
    .step-details {
        grid-template-columns: 1fr;
        gap: 25px;
    }
    
    .process-cta {
        padding: 40px 20px;
    }
    
    .process-cta h3 {
        font-size: 28px;
    }
    
    .cta-actions {
        flex-direction: column;
        align-items: center;
    }
}

@media (max-width: 480px) {
    .deliverable-tags {
        justify-content: center;
    }
    
    .deliverable-tag {
        font-size: 12px;
        padding: 6px 12px;
    }
}
</style>
@endpush