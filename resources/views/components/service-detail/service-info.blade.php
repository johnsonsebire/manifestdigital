@props([
    'title' => 'About This Service',
    'description' => 'Our comprehensive web development service covers everything from concept to deployment, ensuring your digital presence stands out in today\'s competitive market.',
    'details' => [
        [
            'title' => 'What\'s Included',
            'items' => [
                'Custom Design & Development',
                'Responsive Mobile Design',
                'SEO Optimization',
                'Performance Optimization',
                'Security Implementation',
                'Content Management System',
                '3 Months Free Support',
                'Training & Documentation'
            ]
        ],
        [
            'title' => 'Technologies Used',
            'items' => [
                'React / Vue.js / Angular',
                'Laravel / Node.js',
                'MySQL / PostgreSQL',
                'AWS / Google Cloud',
                'Docker & Kubernetes',
                'Git Version Control',
                'CI/CD Pipelines',
                'Testing Frameworks'
            ]
        ],
        [
            'title' => 'Deliverables',
            'items' => [
                'Fully Functional Website',
                'Source Code Access',
                'Documentation Package',
                'Training Materials',
                'SEO Report',
                'Performance Audit',
                'Security Assessment',
                'Maintenance Guide'
            ]
        ]
    ],
    'timeline' => [
        ['phase' => 'Discovery', 'duration' => '1-2 weeks', 'description' => 'Requirements gathering and project planning'],
        ['phase' => 'Design', 'duration' => '2-3 weeks', 'description' => 'UI/UX design and prototyping'],
        ['phase' => 'Development', 'duration' => '4-8 weeks', 'description' => 'Frontend and backend development'],
        ['phase' => 'Testing', 'duration' => '1-2 weeks', 'description' => 'Quality assurance and bug fixes'],
        ['phase' => 'Deployment', 'duration' => '1 week', 'description' => 'Launch and post-deployment support']
    ]
])

<section class="service-info-section">
    <div class="service-info-container">
        <div class="section-intro">
            <h2>{{ $title }}</h2>
            <p>{{ $description }}</p>
        </div>
        
        <div class="service-details">
            @foreach($details as $detail)
            <div class="detail-card">
                <h3>{{ $detail['title'] }}</h3>
                <ul>
                    @foreach($detail['items'] as $item)
                    <li>
                        <i class="fas fa-check"></i>
                        <span>{{ $item }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endforeach
        </div>
        
        <div class="timeline-section">
            <h3>Project Timeline</h3>
            <div class="timeline">
                @foreach($timeline as $index => $phase)
                <div class="timeline-item">
                    <div class="timeline-marker">
                        <span>{{ $index + 1 }}</span>
                    </div>
                    <div class="timeline-content">
                        <h4>{{ $phase['phase'] }}</h4>
                        <div class="duration">{{ $phase['duration'] }}</div>
                        <p>{{ $phase['description'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
/* Service Info Section */
.service-info-section {
    padding: 80px 20px;
    background: white;
}

.service-info-container {
    max-width: 1400px;
    margin: 0 auto;
}

.service-details {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 30px;
    margin: 50px 0;
}

.detail-card {
    background: #f8f9fa;
    padding: 30px;
    border-radius: 15px;
    border-left: 4px solid #ff2200;
}

.detail-card h3 {
    font-size: 22px;
    font-weight: 800;
    margin-bottom: 20px;
    color: #1a1a1a;
}

.detail-card ul {
    list-style: none;
    padding: 0;
}

.detail-card li {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    margin-bottom: 12px;
    font-size: 15px;
    line-height: 1.5;
}

.detail-card li i {
    color: #ff2200;
    margin-top: 2px;
    font-size: 14px;
}

.detail-card li span {
    color: #333;
}

.timeline-section {
    margin-top: 60px;
    padding-top: 60px;
    border-top: 1px solid #eee;
}

.timeline-section h3 {
    font-size: 28px;
    font-weight: 800;
    text-align: center;
    margin-bottom: 50px;
    color: #1a1a1a;
}

.timeline {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 40px;
    position: relative;
}

.timeline-item {
    text-align: center;
    position: relative;
}

.timeline-marker {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #ff2200, #ff6b00);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    color: white;
    font-weight: 800;
    font-size: 18px;
}

.timeline-content h4 {
    font-size: 20px;
    font-weight: 800;
    margin-bottom: 8px;
    color: #1a1a1a;
}

.duration {
    font-size: 14px;
    font-weight: 600;
    color: #ff2200;
    margin-bottom: 10px;
}

.timeline-content p {
    color: #666;
    font-size: 14px;
    line-height: 1.5;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .service-details {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .detail-card {
        padding: 20px;
    }
    
    .timeline {
        grid-template-columns: 1fr;
        gap: 30px;
    }
    
    .timeline-item::after {
        content: '';
        position: absolute;
        bottom: -15px;
        left: 50%;
        width: 2px;
        height: 30px;
        background: linear-gradient(180deg, #ff2200, #ff6b00);
        transform: translateX(-50%);
    }
    
    .timeline-item:last-child::after {
        display: none;
    }
}
</style>
@endpush