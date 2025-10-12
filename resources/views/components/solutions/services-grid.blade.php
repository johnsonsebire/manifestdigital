@props([
    'sectionTitle' => 'What We Offer',
    'sectionDescription' => 'From web development to AI solutions, we provide end-to-end digital services tailored to your business needs.',
    'services' => [
        [
            'icon' => 'fas fa-code',
            'title' => 'Web Development',
            'description' => 'Custom websites and web applications built with modern technologies for optimal performance and user experience.',
            'features' => [
                'Responsive Design',
                'E-commerce Solutions',
                'Content Management Systems',
                'Progressive Web Apps'
            ],
            'link' => '/book-a-call'
        ],
        [
            'icon' => 'fas fa-mobile-alt',
            'title' => 'Mobile App Development',
            'description' => 'Native and cross-platform mobile applications that deliver seamless experiences across iOS and Android devices.',
            'features' => [
                'iOS & Android Apps',
                'Cross-Platform Solutions',
                'App Store Optimization',
                'Maintenance & Updates'
            ],
            'link' => '/book-a-call'
        ],
        [
            'icon' => 'fas fa-brain',
            'title' => 'AI & Machine Learning',
            'description' => 'Intelligent automation and predictive analytics to help your business make data-driven decisions and improve efficiency.',
            'features' => [
                'AI Chatbots',
                'Predictive Analytics',
                'Process Automation',
                'Natural Language Processing'
            ],
            'link' => '/ai-sensei'
        ],
        [
            'icon' => 'fas fa-cloud',
            'title' => 'Cloud Computing',
            'description' => 'Scalable cloud infrastructure and migration services to ensure your applications run reliably and cost-effectively.',
            'features' => [
                'Cloud Migration',
                'Infrastructure Setup',
                'DevOps & CI/CD',
                '24/7 Monitoring'
            ],
            'link' => '/book-a-call'
        ],
        [
            'icon' => 'fas fa-shield-alt',
            'title' => 'Cyber Security',
            'description' => 'Comprehensive security solutions to protect your digital assets and ensure compliance with industry standards.',
            'features' => [
                'Security Audits',
                'Penetration Testing',
                'Data Encryption',
                'Compliance Management'
            ],
            'link' => '/book-a-call'
        ],
        [
            'icon' => 'fas fa-link',
            'title' => 'Blockchain Solutions',
            'description' => 'Decentralized applications and smart contracts to enhance transparency and security in your business operations.',
            'features' => [
                'Smart Contracts',
                'DApp Development',
                'Tokenization',
                'Blockchain Consulting'
            ],
            'link' => '/book-a-call'
        ],
        [
            'icon' => 'fas fa-search',
            'title' => 'SEO Services',
            'description' => 'Strategic search engine optimization to improve your online visibility and drive organic traffic to your website.',
            'features' => [
                'Keyword Research',
                'On-Page Optimization',
                'Link Building',
                'Performance Analytics'
            ],
            'link' => '/book-a-call'
        ],
        [
            'icon' => 'fas fa-check-double',
            'title' => 'QA Testing',
            'description' => 'Rigorous quality assurance testing to ensure your applications are bug-free, secure, and deliver exceptional user experiences.',
            'features' => [
                'Manual Testing',
                'Automated Testing',
                'Performance Testing',
                'Security Testing'
            ],
            'link' => '/book-a-call'
        ],
        [
            'icon' => 'fas fa-cogs',
            'title' => 'SAP Consulting',
            'description' => 'Expert SAP implementation and consulting services to streamline your enterprise resource planning and business processes.',
            'features' => [
                'SAP Implementation',
                'System Integration',
                'Custom Development',
                'Training & Support'
            ],
            'link' => '/book-a-call'
        ],
        [
            'icon' => 'fas fa-bullhorn',
            'title' => 'Brand Positioning',
            'description' => 'Strategic brand development and positioning to help your business stand out in competitive markets.',
            'features' => [
                'Brand Strategy',
                'Visual Identity',
                'Market Research',
                'Digital Marketing'
            ],
            'link' => '/book-a-call'
        ],
        [
            'icon' => 'fas fa-graduation-cap',
            'title' => 'IT Training',
            'description' => 'Comprehensive IT training programs to upskill your team and keep them updated with the latest technologies.',
            'features' => [
                'Custom Training Programs',
                'Certification Courses',
                'Workshops & Bootcamps',
                'Online Learning'
            ],
            'link' => '/book-a-call'
        ],
        [
            'icon' => 'fas fa-rocket',
            'title' => 'Digital Transformation',
            'description' => 'End-to-end digital transformation strategies to modernize your business operations and stay competitive.',
            'features' => [
                'Strategy Consulting',
                'Process Optimization',
                'Technology Integration',
                'Change Management'
            ],
            'link' => '/book-a-call'
        ]
    ]
])

<section class="solutions-section">
    <div class="section-intro">
        <h2>{{ $sectionTitle }}</h2>
        <p>{{ $sectionDescription }}</p>
    </div>

    <div class="services-grid">
        @foreach($services as $service)
        <div class="service-card">
            <div class="service-icon">
                <i class="{{ $service['icon'] }}"></i>
            </div>
            <h3>{{ $service['title'] }}</h3>
            <p>{{ $service['description'] }}</p>
            <ul class="service-features">
                @foreach($service['features'] as $feature)
                <li><i class="fas fa-check-circle"></i> {{ $feature }}</li>
                @endforeach
            </ul>
            <a href="{{ $service['link'] }}" class="service-link">
                Learn More <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        @endforeach
    </div>
</section>

@push('styles')
<style>
/* Solutions Grid Section */
.solutions-section {
    max-width: 1400px;
    margin: 0 auto;
    padding: 80px 20px;
}

.section-intro {
    text-align: center;
    margin-bottom: 60px;
}

.section-intro h2 {
    font-size: 42px;
    font-weight: 800;
    margin-bottom: 20px;
    color: #1a1a1a;
}

.section-intro p {
    font-size: 18px;
    color: #666;
    max-width: 700px;
    margin: 0 auto;
    line-height: 1.7;
}

/* Service Cards */
.services-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
    gap: 40px;
    margin-bottom: 80px;
}

.service-card {
    background: white;
    border-radius: 20px;
    padding: 40px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.service-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 4px;
    background: linear-gradient(90deg, #ff2200, #ff6b00);
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.3s ease;
}

.service-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.15);
}

.service-card:hover::before {
    transform: scaleX(1);
}

.service-icon {
    width: 70px;
    height: 70px;
    background: linear-gradient(135deg, #ff2200, #ff6b00);
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 25px;
    transition: transform 0.3s ease;
}

.service-card:hover .service-icon {
    transform: scale(1.1) rotate(5deg);
}

.service-icon i {
    font-size: 32px;
    color: white;
}

.service-card h3 {
    font-size: 26px;
    font-weight: 800;
    margin-bottom: 15px;
    color: #1a1a1a;
}

.service-card p {
    color: #666;
    font-size: 16px;
    line-height: 1.7;
    margin-bottom: 25px;
}

.service-features {
    list-style: none;
    padding: 0;
    margin: 0 0 25px 0;
}

.service-features li {
    padding: 8px 0;
    color: #555;
    font-size: 15px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.service-features li i {
    color: #ff2200;
    font-size: 12px;
}

.service-link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: #ff2200;
    font-weight: 700;
    text-decoration: none;
    transition: gap 0.3s ease;
}

.service-link:hover {
    gap: 15px;
    color: #cc1b00;
}

@media (max-width: 768px) {
    .services-grid {
        grid-template-columns: 1fr;
        gap: 30px;
    }
    
    .section-intro h2 {
        font-size: 32px;
    }
}
</style>
@endpush