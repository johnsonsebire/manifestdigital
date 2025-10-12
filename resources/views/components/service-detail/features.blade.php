@props([
    'title' => 'Key Features & Benefits',
    'description' => 'Discover the powerful features that make our web development service stand out from the competition.',
    'features' => [
        [
            'icon' => 'fas fa-mobile-alt',
            'title' => 'Fully Responsive Design',
            'description' => 'Your website will look perfect on all devices - desktop, tablet, and mobile.',
            'benefits' => [
                'Mobile-first approach',
                'Cross-browser compatibility',
                'Optimized user experience',
                'Better search rankings'
            ]
        ],
        [
            'icon' => 'fas fa-rocket',
            'title' => 'Lightning Fast Performance',
            'description' => 'Optimized for speed with advanced caching and performance techniques.',
            'benefits' => [
                'Sub-2 second load times',
                'CDN integration',
                'Image optimization',
                'Code minification'
            ]
        ],
        [
            'icon' => 'fas fa-shield-alt',
            'title' => 'Enterprise Security',
            'description' => 'Bank-level security measures to protect your data and users.',
            'benefits' => [
                'SSL encryption',
                'Regular security updates',
                'Backup systems',
                'Vulnerability scanning'
            ]
        ],
        [
            'icon' => 'fas fa-search',
            'title' => 'SEO Optimized',
            'description' => 'Built with search engine optimization best practices from the ground up.',
            'benefits' => [
                'Meta tag optimization',
                'Schema markup',
                'Site map generation',
                'Analytics integration'
            ]
        ],
        [
            'icon' => 'fas fa-cogs',
            'title' => 'Easy Content Management',
            'description' => 'User-friendly admin panel to manage your content without technical knowledge.',
            'benefits' => [
                'Intuitive interface',
                'WYSIWYG editor',
                'Media management',
                'User role management'
            ]
        ],
        [
            'icon' => 'fas fa-chart-line',
            'title' => 'Analytics & Reporting',
            'description' => 'Comprehensive analytics to track your website performance and user behavior.',
            'benefits' => [
                'Google Analytics integration',
                'Custom dashboards',
                'Performance monitoring',
                'Conversion tracking'
            ]
        ]
    ]
])

<section class="features-section">
    <div class="features-container">
        <div class="section-intro">
            <h2>{{ $title }}</h2>
            <p>{{ $description }}</p>
        </div>
        
        <div class="features-grid">
            @foreach($features as $feature)
            <div class="feature-card">
                <div class="feature-header">
                    <div class="feature-icon">
                        <i class="{{ $feature['icon'] }}"></i>
                    </div>
                    <h3>{{ $feature['title'] }}</h3>
                </div>
                
                <p>{{ $feature['description'] }}</p>
                
                <div class="feature-benefits">
                    @foreach($feature['benefits'] as $benefit)
                    <div class="benefit-item">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ $benefit }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="features-cta">
            <div class="cta-content">
                <h3>Ready to Get Started?</h3>
                <p>Let's discuss how these features can benefit your specific project</p>
                <div class="cta-actions">
                    <a href="#contact" class="btn-primary">Start Your Project</a>
                    <a href="#" class="btn-secondary">Schedule a Call</a>
                </div>
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
/* Features Section */
.features-section {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 80px 20px;
}

.features-container {
    max-width: 1400px;
    margin: 0 auto;
}

.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 30px;
    margin: 50px 0;
}

.feature-card {
    background: white;
    padding: 30px;
    border-radius: 20px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    border-top: 4px solid #ff2200;
}

.feature-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 40px rgba(0,0,0,0.15);
}

.feature-header {
    display: flex;
    align-items: center;
    gap: 20px;
    margin-bottom: 20px;
}

.feature-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #ff2200, #ff6b00);
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.feature-icon i {
    font-size: 24px;
    color: white;
}

.feature-card h3 {
    font-size: 22px;
    font-weight: 800;
    color: #1a1a1a;
    margin: 0;
}

.feature-card > p {
    color: #666;
    font-size: 16px;
    line-height: 1.6;
    margin-bottom: 25px;
}

.feature-benefits {
    display: grid;
    gap: 12px;
}

.benefit-item {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 15px;
}

.benefit-item i {
    color: #28a745;
    font-size: 14px;
    flex-shrink: 0;
}

.benefit-item span {
    color: #333;
    font-weight: 500;
}

.features-cta {
    background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
    border-radius: 20px;
    padding: 50px 30px;
    text-align: center;
    margin-top: 60px;
    color: white;
}

.features-cta h3 {
    font-size: 32px;
    font-weight: 900;
    margin-bottom: 15px;
    background: linear-gradient(135deg, #ff2200, #ff6b00);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.features-cta p {
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
    .features-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .feature-card {
        padding: 25px;
    }
    
    .feature-header {
        flex-direction: column;
        text-align: center;
        gap: 15px;
    }
    
    .features-cta {
        padding: 40px 20px;
    }
    
    .features-cta h3 {
        font-size: 28px;
    }
    
    .cta-actions {
        flex-direction: column;
        align-items: center;
    }
}

@media (max-width: 480px) {
    .features-grid {
        grid-template-columns: 1fr;
    }
    
    .feature-card {
        padding: 20px;
    }
    
    .feature-icon {
        width: 50px;
        height: 50px;
    }
    
    .feature-icon i {
        font-size: 20px;
    }
    
    .feature-card h3 {
        font-size: 20px;
    }
}
</style>
@endpush