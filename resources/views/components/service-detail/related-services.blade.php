@props([
    'title' => 'Related Services',
    'description' => 'Explore our other services that complement your web development project',
    'services' => [
        [
            'title' => 'Mobile App Development',
            'description' => 'Native and cross-platform mobile applications for iOS and Android',
            'icon' => 'fas fa-mobile-alt',
            'features' => ['React Native', 'Flutter', 'Native iOS/Android', 'Cross-platform'],
            'link' => '#mobile-development',
            'price' => 'Starting from $3,000'
        ],
        [
            'title' => 'E-commerce Solutions',
            'description' => 'Complete online store development with payment integration',
            'icon' => 'fas fa-shopping-cart',
            'features' => ['WooCommerce', 'Shopify', 'Custom E-commerce', 'Payment Gateway'],
            'link' => '#ecommerce',
            'price' => 'Starting from $4,500'
        ],
        [
            'title' => 'Digital Marketing',
            'description' => 'SEO, social media marketing, and digital advertising campaigns',
            'icon' => 'fas fa-bullhorn',
            'features' => ['SEO Optimization', 'Social Media', 'PPC Campaigns', 'Analytics'],
            'link' => '#digital-marketing',
            'price' => 'Starting from $800/month'
        ],
        [
            'title' => 'UI/UX Design',
            'description' => 'User-centered design that converts visitors into customers',
            'icon' => 'fas fa-paint-brush',
            'features' => ['User Research', 'Wireframing', 'Prototyping', 'Design Systems'],
            'link' => '#ui-ux-design',
            'price' => 'Starting from $1,500'
        ],
        [
            'title' => 'Cloud Hosting',
            'description' => 'Reliable and scalable cloud hosting solutions for your applications',
            'icon' => 'fas fa-cloud',
            'features' => ['AWS/Azure', 'Auto-scaling', 'Backup Solutions', '99.9% Uptime'],
            'link' => '#cloud-hosting',
            'price' => 'Starting from $50/month'
        ],
        [
            'title' => 'Maintenance & Support',
            'description' => 'Ongoing maintenance, updates, and technical support services',
            'icon' => 'fas fa-tools',
            'features' => ['Regular Updates', 'Security Monitoring', 'Performance Optimization', '24/7 Support'],
            'link' => '#maintenance',
            'price' => 'Starting from $200/month'
        ]
    ]
])

<section class="related-services-section">
    <div class="related-services-container">
        <div class="section-intro">
            <h2>{{ $title }}</h2>
            <p>{{ $description }}</p>
        </div>
        
        <div class="services-grid">
            @foreach($services as $service)
            <div class="service-card">
                <div class="service-icon">
                    <i class="{{ $service['icon'] }}"></i>
                </div>
                
                <div class="service-content">
                    <h3>{{ $service['title'] }}</h3>
                    <p>{{ $service['description'] }}</p>
                    
                    <div class="service-features">
                        @foreach($service['features'] as $feature)
                        <span class="feature-tag">{{ $feature }}</span>
                        @endforeach
                    </div>
                    
                    <div class="service-price">{{ $service['price'] }}</div>
                    
                    <div class="service-actions">
                        <a href="{{ $service['link'] }}" class="btn-service">Learn More</a>
                        <a href="#contact" class="btn-quote">Get Quote</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="services-cta">
            <div class="cta-content">
                <h3>Need a Custom Solution?</h3>
                <p>We can combine multiple services to create the perfect solution for your business needs</p>
                <div class="cta-actions">
                    <a href="#contact" class="btn-primary">Discuss Your Project</a>
                    <a href="{{ route('solutions') }}" class="btn-secondary">View All Services</a>
                </div>
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
/* Related Services Section */
.related-services-section {
    background: white;
    padding: 80px 20px;
}

.related-services-container {
    max-width: 1400px;
    margin: 0 auto;
}

.services-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 30px;
    margin: 50px 0;
}

.service-card {
    background: #f8f9fa;
    border-radius: 20px;
    padding: 30px;
    text-align: center;
    transition: all 0.3s ease;
    border-top: 4px solid #ff2200;
    position: relative;
}

.service-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 40px rgba(0,0,0,0.15);
    background: white;
}

.service-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #ff2200, #ff6b00);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 25px;
}

.service-icon i {
    font-size: 32px;
    color: white;
}

.service-content h3 {
    font-size: 24px;
    font-weight: 800;
    color: #1a1a1a;
    margin-bottom: 15px;
}

.service-content p {
    color: #666;
    font-size: 16px;
    line-height: 1.6;
    margin-bottom: 20px;
}

.service-features {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    justify-content: center;
    margin-bottom: 20px;
}

.feature-tag {
    background: rgba(255, 34, 0, 0.1);
    color: #ff2200;
    padding: 6px 12px;
    border-radius: 15px;
    font-size: 12px;
    font-weight: 600;
}

.service-price {
    font-size: 18px;
    font-weight: 800;
    color: #1a1a1a;
    margin-bottom: 25px;
    background: linear-gradient(135deg, #ff2200, #ff6b00);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.service-actions {
    display: flex;
    gap: 15px;
    justify-content: center;
    flex-wrap: wrap;
}

.btn-service,
.btn-quote {
    padding: 12px 24px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    font-size: 14px;
    transition: all 0.3s ease;
    display: inline-block;
}

.btn-service {
    background: #ff2200;
    color: white;
    border: 2px solid #ff2200;
}

.btn-service:hover {
    background: #cc1a00;
    transform: translateY(-2px);
}

.btn-quote {
    background: transparent;
    color: #ff2200;
    border: 2px solid #ff2200;
}

.btn-quote:hover {
    background: #ff2200;
    color: white;
    transform: translateY(-2px);
}

.services-cta {
    background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
    border-radius: 20px;
    padding: 50px 30px;
    text-align: center;
    margin-top: 60px;
    color: white;
}

.services-cta h3 {
    font-size: 32px;
    font-weight: 900;
    margin-bottom: 15px;
    background: linear-gradient(135deg, #ff2200, #ff6b00);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.services-cta p {
    font-size: 18px;
    color: #ccc;
    margin-bottom: 30px;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

.cta-actions {
    display: flex;
    gap: 20px;
    justify-content: center;
    flex-wrap: wrap;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .services-grid {
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
    }
    
    .service-card {
        padding: 25px;
    }
    
    .service-icon {
        width: 60px;
        height: 60px;
    }
    
    .service-icon i {
        font-size: 24px;
    }
    
    .service-content h3 {
        font-size: 20px;
    }
    
    .service-actions {
        flex-direction: column;
        align-items: center;
    }
    
    .btn-service,
    .btn-quote {
        width: 100%;
        text-align: center;
    }
    
    .services-cta {
        padding: 40px 20px;
    }
    
    .services-cta h3 {
        font-size: 28px;
    }
    
    .cta-actions {
        flex-direction: column;
        align-items: center;
    }
}

@media (max-width: 480px) {
    .services-grid {
        grid-template-columns: 1fr;
    }
    
    .service-card {
        padding: 20px;
    }
    
    .feature-tag {
        font-size: 11px;
        padding: 4px 8px;
    }
}
</style>
@endpush