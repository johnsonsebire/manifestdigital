@props([
    'serviceTitle' => 'Web Development Services',
    'serviceSubtitle' => 'Custom Solutions for Your Digital Success',
    'description' => 'Transform your business with cutting-edge web applications that deliver exceptional user experiences and drive measurable results.',
    'keyBenefits' => [
        'Responsive Design',
        'Modern Technologies',
        'SEO Optimized',
        'Fast Performance',
        'Scalable Architecture',
        '24/7 Support'
    ],
    'ctaText' => 'Get Started Today',
    'secondaryCtaText' => 'View Portfolio'
])

<section class="service-hero">
    <div class="service-hero-container">
        <div class="hero-content">
            <div class="hero-text">
                <div class="breadcrumb">
                    <a href="{{ route('home') }}">Home</a>
                    <span>/</span>
                    <a href="{{ route('solutions') }}">Solutions</a>
                    <span>/</span>
                    <span>{{ $serviceTitle }}</span>
                </div>
                
                <h1>{{ $serviceTitle }}</h1>
                <h2>{{ $serviceSubtitle }}</h2>
                <p>{{ $description }}</p>
                
                <div class="key-benefits">
                    @foreach($keyBenefits as $benefit)
                    <div class="benefit-tag">
                        <i class="fas fa-check"></i>
                        <span>{{ $benefit }}</span>
                    </div>
                    @endforeach
                </div>
                
                <div class="hero-actions">
                    <a href="#contact" class="btn-primary">{{ $ctaText }}</a>
                    <a href="#portfolio" class="btn-secondary">{{ $secondaryCtaText }}</a>
                </div>
            </div>
            
            <div class="hero-visual">
                <div class="visual-element">
                    <div class="floating-card card-1">
                        <i class="fas fa-code"></i>
                        <span>Clean Code</span>
                    </div>
                    <div class="floating-card card-2">
                        <i class="fas fa-mobile-alt"></i>
                        <span>Responsive</span>
                    </div>
                    <div class="floating-card card-3">
                        <i class="fas fa-rocket"></i>
                        <span>Fast Loading</span>
                    </div>
                    <div class="floating-card card-4">
                        <i class="fas fa-shield-alt"></i>
                        <span>Secure</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
/* Service Detail Hero */
.service-hero {
    background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 50%, #1a1a1a 100%);
    color: white;
    padding: 120px 20px 80px;
    min-height: 80vh;
    display: flex;
    align-items: center;
    position: relative;
    overflow: hidden;
}

.service-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: radial-gradient(circle at 30% 20%, rgba(255, 34, 0, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 70% 80%, rgba(255, 107, 0, 0.1) 0%, transparent 50%);
    pointer-events: none;
}

.service-hero-container {
    max-width: 1400px;
    margin: 0 auto;
    width: 100%;
}

.hero-content {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 60px;
    align-items: center;
}

.breadcrumb {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 20px;
    font-size: 14px;
}

.breadcrumb a {
    color: #ccc;
    text-decoration: none;
    transition: color 0.3s ease;
}

.breadcrumb a:hover {
    color: #ff2200;
}

.breadcrumb span {
    color: #666;
}

.hero-text h1 {
    font-size: 48px;
    font-weight: 900;
    line-height: 1.2;
    margin-bottom: 10px;
    background: linear-gradient(135deg, #ff2200, #ff6b00);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.hero-text h2 {
    font-size: 24px;
    font-weight: 600;
    color: #ccc;
    margin-bottom: 20px;
}

.hero-text p {
    font-size: 18px;
    line-height: 1.6;
    color: #bbb;
    margin-bottom: 30px;
}

.key-benefits {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 15px;
    margin-bottom: 40px;
}

.benefit-tag {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 12px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 20px;
    font-size: 14px;
    font-weight: 600;
}

.benefit-tag i {
    color: #ff2200;
    font-size: 12px;
}

.hero-actions {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
}

.hero-visual {
    position: relative;
    height: 400px;
}

.visual-element {
    position: relative;
    width: 100%;
    height: 100%;
}

.floating-card {
    position: absolute;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 15px;
    padding: 20px;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
    color: white;
    animation: float 3s ease-in-out infinite;
}

.floating-card i {
    font-size: 24px;
    color: #ff2200;
}

.floating-card span {
    font-size: 14px;
    font-weight: 600;
}

.card-1 {
    top: 20px;
    left: 20px;
    animation-delay: 0s;
}

.card-2 {
    top: 80px;
    right: 30px;
    animation-delay: 0.5s;
}

.card-3 {
    bottom: 100px;
    left: 40px;
    animation-delay: 1s;
}

.card-4 {
    bottom: 30px;
    right: 20px;
    animation-delay: 1.5s;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

/* Responsive Design */
@media (max-width: 968px) {
    .hero-content {
        grid-template-columns: 1fr;
        gap: 40px;
        text-align: center;
    }
    
    .hero-text h1 {
        font-size: 36px;
    }
    
    .key-benefits {
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
        gap: 10px;
    }
    
    .hero-visual {
        height: 300px;
    }
}

@media (max-width: 480px) {
    .hero-text h1 {
        font-size: 28px;
    }
    
    .hero-text h2 {
        font-size: 20px;
    }
    
    .hero-actions {
        flex-direction: column;
        align-items: center;
    }
    
    .floating-card {
        padding: 15px;
    }
    
    .floating-card i {
        font-size: 20px;
    }
    
    .floating-card span {
        font-size: 12px;
    }
}
</style>
@endpush