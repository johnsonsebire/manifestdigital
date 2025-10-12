<x-layouts.frontend 
    title="Web Development Services | Manifest Digital"
    :transparent-header="false"
    preloader="simple"
    notificationStyle="dark">

    @push('styles')
    <style>
        /* Service Detail Page Specific Styles */
        
        /* Breadcrumb */
        .breadcrumb-nav {
            background: #f8f9fa;
            padding: 20px 0;
            border-bottom: 1px solid #e9ecef;
        }
        
        .breadcrumb-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .breadcrumb {
            margin: 0;
            padding: 0;
            list-style: none;
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
            font-size: 14px;
        }
        
        .breadcrumb-item {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .breadcrumb-item a {
            color: #666;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .breadcrumb-item a:hover {
            color: #ff2200;
        }
        
        .breadcrumb-item.active {
            color: #1a1a1a;
            font-weight: 600;
        }
        
        .breadcrumb-separator {
            color: #999;
        }
        
        /* Service Hero */
        .service-hero {
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            padding: 80px 0 60px;
            color: white;
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
            background: url('/images/decorative/hero_left_mem_dots_f_circle3.svg') no-repeat left center,
                        url('/images/decorative/hero_right_circle-con3.svg') no-repeat right center;
            opacity: 0.1;
            pointer-events: none;
        }
        
        .service-hero-content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
            position: relative;
            z-index: 1;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }
        
        .service-hero-text h1 {
            font-size: 52px;
            font-weight: 800;
            margin-bottom: 20px;
            line-height: 1.2;
        }
        
        .service-category {
            display: inline-block;
            background: rgba(255, 34, 0, 0.2);
            color: #ff2200;
            padding: 8px 20px;
            border-radius: 50px;
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 20px;
        }
        
        .service-hero-text p {
            font-size: 18px;
            line-height: 1.7;
            opacity: 0.9;
            margin-bottom: 30px;
        }
        
        .hero-features {
            display: flex;
            gap: 30px;
            flex-wrap: wrap;
            margin-top: 30px;
        }
        
        .hero-feature {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .hero-feature i {
            color: #ff2200;
            font-size: 20px;
        }
        
        .hero-feature span {
            font-size: 16px;
        }
        
        .service-hero-icon {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .service-icon-large {
            width: 300px;
            height: 300px;
            background: linear-gradient(135deg, #ff2200, #ff6b00);
            border-radius: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            transform: rotate(-5deg);
            transition: transform 0.3s ease;
        }
        
        .service-icon-large:hover {
            transform: rotate(0deg) scale(1.05);
        }
        
        .service-icon-large i {
            font-size: 120px;
            color: white;
        }
        
        /* Service Overview */
        .service-overview {
            max-width: 1400px;
            margin: 0 auto;
            padding: 80px 20px;
        }
        
        .overview-content {
            max-width: 900px;
            margin: 0 auto;
        }
        
        .overview-content h2 {
            font-size: 42px;
            font-weight: 800;
            margin-bottom: 20px;
            color: #1a1a1a;
        }
        
        .overview-content p {
            font-size: 18px;
            line-height: 1.8;
            color: #555;
            margin-bottom: 25px;
        }
        
        /* Key Features Section */
        .features-section {
            background: #f8f9fa;
            padding: 80px 20px;
        }
        
        .features-container {
            max-width: 1400px;
            margin: 0 auto;
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 50px;
        }
        
        .section-title h2 {
            font-size: 42px;
            font-weight: 800;
            margin-bottom: 15px;
            color: #1a1a1a;
        }
        
        .section-title p {
            font-size: 18px;
            color: #666;
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }
        
        .feature-card {
            background: white;
            padding: 35px;
            border-radius: 15px;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border-color: #ff2200;
        }
        
        .feature-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #ff2200, #ff6b00);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }
        
        .feature-icon i {
            font-size: 28px;
            color: white;
        }
        
        .feature-card h3 {
            font-size: 22px;
            font-weight: 800;
            margin-bottom: 12px;
            color: #1a1a1a;
        }
        
        .feature-card p {
            font-size: 16px;
            line-height: 1.6;
            color: #666;
            margin: 0;
        }
        
        /* Process Section */
        .process-section {
            max-width: 1400px;
            margin: 0 auto;
            padding: 80px 20px;
        }
        
        .process-timeline {
            position: relative;
            margin-top: 50px;
        }
        
        .process-timeline::before {
            content: '';
            position: absolute;
            left: 50%;
            top: 40px;
            bottom: 40px;
            width: 3px;
            background: linear-gradient(180deg, #ff2200, #ff6b00);
            transform: translateX(-50%);
        }
        
        .process-step {
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            gap: 40px;
            margin-bottom: 60px;
            position: relative;
            align-items: center;
        }
        
        .process-step:nth-child(odd) .step-content {
            grid-column: 1;
        }
        
        .process-step:nth-child(odd) .step-number-wrapper {
            grid-column: 2;
        }
        
        .process-step:nth-child(odd) .step-spacer {
            grid-column: 3;
        }
        
        .process-step:nth-child(even) .step-content {
            grid-column: 3;
        }
        
        .process-step:nth-child(even) .step-number-wrapper {
            grid-column: 2;
        }
        
        .process-step:nth-child(even) .step-spacer {
            grid-column: 1;
        }
        
        .step-content {
            background: white;
            padding: 35px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        }
        
        .step-content h3 {
            font-size: 24px;
            font-weight: 800;
            margin-bottom: 15px;
            color: #1a1a1a;
        }
        
        .step-content p {
            font-size: 16px;
            line-height: 1.7;
            color: #666;
            margin: 0;
        }
        
        .step-number-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .step-number {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #ff2200, #ff6b00);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            font-weight: 800;
            color: white;
            position: relative;
            z-index: 2;
            box-shadow: 0 5px 20px rgba(255, 34, 0, 0.3);
        }
        
        .step-spacer {
            min-width: 0;
        }
        
        /* Technologies Section */
        .tech-section {
            background: #1a1a1a;
            padding: 80px 20px;
            color: white;
        }
        
        .tech-container {
            max-width: 1400px;
            margin: 0 auto;
        }
        
        .tech-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 30px;
            margin-top: 50px;
        }
        
        .tech-item {
            text-align: center;
            padding: 25px;
            background: rgba(255,255,255,0.05);
            border-radius: 12px;
            transition: all 0.3s ease;
        }
        
        .tech-item:hover {
            background: rgba(255,255,255,0.1);
            transform: translateY(-5px);
        }
        
        .tech-item i {
            font-size: 48px;
            margin-bottom: 15px;
            color: #ff2200;
        }
        
        .tech-item h4 {
            font-size: 16px;
            font-weight: 700;
            margin: 0;
        }
        
        /* Pricing Section */
        .pricing-section {
            max-width: 1400px;
            margin: 0 auto;
            padding: 80px 20px;
        }
        
        .pricing-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 30px;
            margin-top: 50px;
        }
        
        .pricing-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            border: 2px solid transparent;
            position: relative;
            overflow: hidden;
        }
        
        .pricing-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.15);
            border-color: #ff2200;
        }
        
        .pricing-card.featured {
            border-color: #ff2200;
            transform: scale(1.05);
        }
        
        .popular-badge {
            position: absolute;
            top: -10px;
            right: 20px;
            background: #ff2200;
            color: white;
            padding: 6px 16px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            box-shadow: 0 2px 10px rgba(255, 34, 0, 0.3);
        }
        
        .pricing-card h3 {
            font-size: 28px;
            font-weight: 800;
            margin-bottom: 10px;
            color: #1a1a1a;
        }
        
        .pricing-card .price {
            font-size: 48px;
            font-weight: 800;
            color: #ff2200;
            margin-bottom: 10px;
        }
        
        .pricing-card .price span {
            font-size: 18px;
            color: #666;
            font-weight: 600;
        }
        
        .pricing-card .description {
            color: #666;
            margin-bottom: 30px;
            font-size: 16px;
        }
        
        .pricing-features {
            list-style: none;
            padding: 0;
            margin: 0 0 30px 0;
        }
        
        .pricing-features li {
            padding: 12px 0;
            color: #555;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .pricing-features li:last-child {
            border-bottom: none;
        }
        
        .pricing-features i {
            color: #ff2200;
            font-size: 16px;
        }
        
        .pricing-btn {
            width: 100%;
            padding: 16px;
            background: #ff2200;
            color: white;
            border: none;
            border-radius: 50px;
            font-weight: 700;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: block;
            text-align: center;
        }
        
        .pricing-btn:hover {
            background: #cc1b00;
            color: white;
            transform: translateY(-2px);
        }
        
        /* FAQ Section */
        .faq-section {
            background: #f8f9fa;
            padding: 80px 20px;
        }
        
        .faq-container {
            max-width: 900px;
            margin: 0 auto;
        }
        
        .faq-item {
            background: white;
            border-radius: 12px;
            margin-bottom: 20px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .faq-question {
            padding: 25px;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: background 0.3s ease;
        }
        
        .faq-question:hover {
            background: #f8f9fa;
        }
        
        .faq-question h3 {
            font-size: 18px;
            font-weight: 700;
            margin: 0;
            color: #1a1a1a;
        }
        
        .faq-question i {
            font-size: 20px;
            color: #ff2200;
            transition: transform 0.3s ease;
        }
        
        .faq-item.active .faq-question i {
            transform: rotate(180deg);
        }
        
        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }
        
        .faq-item.active .faq-answer {
            max-height: 500px;
        }
        
        .faq-answer-content {
            padding: 0 25px 25px;
            color: #666;
            line-height: 1.7;
        }
        
        /* Related Services */
        .related-services {
            max-width: 1400px;
            margin: 0 auto;
            padding: 80px 20px;
        }
        
        .related-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 50px;
        }
        
        .related-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            text-decoration: none;
            display: block;
        }
        
        .related-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }
        
        .related-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #ff2200, #ff6b00);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }
        
        .related-icon i {
            font-size: 28px;
            color: white;
        }
        
        .related-card h3 {
            font-size: 22px;
            font-weight: 800;
            margin-bottom: 12px;
            color: #1a1a1a;
        }
        
        .related-card p {
            font-size: 15px;
            color: #666;
            margin-bottom: 15px;
        }
        
        .related-card .learn-more {
            color: #ff2200;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        /* Responsive Design */
        @media (max-width: 992px) {
            .service-hero-content {
                grid-template-columns: 1fr;
                gap: 40px;
            }
            
            .service-hero-text h1 {
                font-size: 38px;
            }
            
            .service-icon-large {
                width: 200px;
                height: 200px;
            }
            
            .service-icon-large i {
                font-size: 80px;
            }
            
            .process-timeline::before {
                left: 40px;
                top: 20px;
                bottom: 20px;
            }
            
            .process-step {
                grid-template-columns: auto 1fr;
                gap: 20px;
                margin-left: 0;
                margin-bottom: 40px;
            }
            
            .process-step .step-content {
                grid-column: 2 !important;
                grid-row: 1;
            }
            
            .process-step .step-number-wrapper {
                grid-column: 1 !important;
                grid-row: 1;
                align-self: start;
                padding-top: 35px;
            }
            
            .process-step .step-spacer {
                display: none;
            }
            
            .step-number {
                width: 60px;
                height: 60px;
                font-size: 24px;
            }
            
            .pricing-card.featured {
                transform: none;
            }
        }
        
        @media (max-width: 768px) {
            .service-hero-text h1 {
                font-size: 32px;
            }
            
            .section-title h2 {
                font-size: 32px;
            }
            
            .features-grid,
            .pricing-grid,
            .related-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
    @endpush

    <!-- Breadcrumb Navigation -->
    <nav class="breadcrumb-nav">
        <div class="breadcrumb-container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></li>
                <li class="breadcrumb-item"><a href="{{ route('solutions') }}">Solutions</a></li>
                <li class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></li>
                <li class="breadcrumb-item active">Web Development</li>
            </ol>
        </div>
    </nav>

    <!-- Service Hero Section -->
    <section class="service-hero">
        <div class="service-hero-content">
            <div class="service-hero-text">
                <div class="service-category">Web Development</div>
                <h1>Professional Web Development Services</h1>
                <p>Build powerful, scalable, and user-friendly websites that drive results. From simple landing pages to complex web applications, we deliver digital experiences that engage your audience and grow your business.</p>
                <div class="hero-features">
                    <div class="hero-feature">
                        <i class="fas fa-check-circle"></i>
                        <span>Responsive Design</span>
                    </div>
                    <div class="hero-feature">
                        <i class="fas fa-check-circle"></i>
                        <span>SEO Optimized</span>
                    </div>
                    <div class="hero-feature">
                        <i class="fas fa-check-circle"></i>
                        <span>Fast Performance</span>
                    </div>
                </div>
            </div>
            <div class="service-hero-icon">
                <div class="service-icon-large">
                    <i class="fas fa-code"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Service Overview -->
    <section class="service-overview">
        <div class="overview-content">
            <h2>Transform Your Online Presence</h2>
            <p>In today's digital world, your website is often the first point of contact with potential customers. We specialize in creating modern, high-performance websites that not only look stunning but also deliver measurable business results.</p>
            <p>Our web development services combine cutting-edge technology with proven design principles to create websites that are fast, secure, and optimized for conversions. Whether you need a corporate website, e-commerce platform, or custom web application, we have the expertise to bring your vision to life.</p>
            <p>We follow industry best practices and use the latest web technologies to ensure your website is built for success. From initial planning to post-launch support, we're with you every step of the way.</p>
        </div>
    </section>

    <!-- Key Features Section -->
    <section class="features-section">
        <div class="features-container">
            <div class="section-title">
                <h2>What We Deliver</h2>
                <p>Comprehensive web development solutions tailored to your business needs</p>
            </div>
            
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h3>Responsive Design</h3>
                    <p>Your website will look perfect on all devices - desktop, tablet, and mobile. We ensure a seamless user experience across all screen sizes.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-tachometer-alt"></i>
                    </div>
                    <h3>Lightning Fast</h3>
                    <p>Optimized for speed with lazy loading, code splitting, and CDN integration. Your users will enjoy blazing-fast page loads.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <h3>SEO Optimized</h3>
                    <p>Built-in SEO best practices to help your website rank higher in search results and attract organic traffic.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3>Secure & Reliable</h3>
                    <p>SSL encryption, regular security updates, and protection against common vulnerabilities to keep your site safe.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-cog"></i>
                    </div>
                    <h3>Easy Management</h3>
                    <p>User-friendly CMS integration allows you to update content, add pages, and manage your site without technical knowledge.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3>Analytics Integration</h3>
                    <p>Track visitor behavior, conversions, and key metrics with integrated analytics tools to make data-driven decisions.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Process Section -->
    <section class="process-section">
        <div class="section-title">
            <h2>Our Development Process</h2>
            <p>A proven methodology for delivering exceptional websites</p>
        </div>
        
        <div class="process-timeline">
            <div class="process-step">
                <div class="step-content">
                    <h3>Discovery & Planning</h3>
                    <p>We start by understanding your business goals, target audience, and project requirements. This phase includes competitor analysis, feature planning, and creating a detailed project roadmap.</p>
                </div>
                <div class="step-number-wrapper">
                    <div class="step-number">1</div>
                </div>
                <div class="step-spacer"></div>
            </div>
            
            <div class="process-step">
                <div class="step-spacer"></div>
                <div class="step-number-wrapper">
                    <div class="step-number">2</div>
                </div>
                <div class="step-content">
                    <h3>Design & Prototyping</h3>
                    <p>Our designers create wireframes and high-fidelity mockups that bring your vision to life. We focus on user experience, brand consistency, and conversion optimization.</p>
                </div>
            </div>
            
            <div class="process-step">
                <div class="step-content">
                    <h3>Development</h3>
                    <p>Using modern frameworks and best practices, we build your website with clean, maintainable code. Regular updates keep you informed of progress.</p>
                </div>
                <div class="step-number-wrapper">
                    <div class="step-number">3</div>
                </div>
                <div class="step-spacer"></div>
            </div>
            
            <div class="process-step">
                <div class="step-spacer"></div>
                <div class="step-number-wrapper">
                    <div class="step-number">4</div>
                </div>
                <div class="step-content">
                    <h3>Testing & QA</h3>
                    <p>Rigorous testing across devices, browsers, and scenarios ensures your website works flawlessly. We test performance, security, and user experience.</p>
                </div>
            </div>
            
            <div class="process-step">
                <div class="step-content">
                    <h3>Launch & Support</h3>
                    <p>We handle the deployment and provide training on managing your website. Post-launch support ensures smooth operation and continued success.</p>
                </div>
                <div class="step-number-wrapper">
                    <div class="step-number">5</div>
                </div>
                <div class="step-spacer"></div>
            </div>
        </div>
    </section>

    <!-- Technologies Section -->
    <section class="tech-section">
        <div class="tech-container">
            <div class="section-title" style="color: white;">
                <h2>Technologies We Use</h2>
                <p style="color: rgba(255,255,255,0.9);">Modern, reliable technologies for building world-class websites</p>
            </div>
            
            <div class="tech-grid">
                <div class="tech-item">
                    <i class="fab fa-react"></i>
                    <h4>React</h4>
                </div>
                <div class="tech-item">
                    <i class="fab fa-node-js"></i>
                    <h4>Node.js</h4>
                </div>
                <div class="tech-item">
                    <i class="fab fa-wordpress"></i>
                    <h4>WordPress</h4>
                </div>
                <div class="tech-item">
                    <i class="fab fa-laravel"></i>
                    <h4>Laravel</h4>
                </div>
                <div class="tech-item">
                    <i class="fab fa-html5"></i>
                    <h4>HTML5</h4>
                </div>
                <div class="tech-item">
                    <i class="fab fa-css3-alt"></i>
                    <h4>CSS3</h4>
                </div>
                <div class="tech-item">
                    <i class="fab fa-js"></i>
                    <h4>JavaScript</h4>
                </div>
                <div class="tech-item">
                    <i class="fab fa-php"></i>
                    <h4>PHP</h4>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section class="pricing-section">
        <div class="section-title">
            <h2>Choose Your Package</h2>
            <p>Flexible pricing options to fit your budget and requirements</p>
        </div>
        
        <div class="pricing-grid">
            <div class="pricing-card">
                <h3>Starter</h3>
                <div class="price">GH₵5,000 <span>one-time</span></div>
                <p class="description">Perfect for small businesses and startups</p>
                <ul class="pricing-features">
                    <li><i class="fas fa-check"></i> Up to 5 pages</li>
                    <li><i class="fas fa-check"></i> Responsive design</li>
                    <li><i class="fas fa-check"></i> Contact form</li>
                    <li><i class="fas fa-check"></i> SEO basics</li>
                    <li><i class="fas fa-check"></i> 3 months support</li>
                    <li><i class="fas fa-check"></i> Mobile optimized</li>
                </ul>
                <a href="{{ url('book-a-call') }}" class="pricing-btn">Get Started</a>
            </div>
            
            <div class="pricing-card featured">
                <div class="popular-badge">Most Popular</div>
                <h3>Professional</h3>
                <div class="price">GH₵12,000 <span>one-time</span></div>
                <p class="description">Best for growing businesses</p>
                <ul class="pricing-features">
                    <li><i class="fas fa-check"></i> Up to 15 pages</li>
                    <li><i class="fas fa-check"></i> Custom design</li>
                    <li><i class="fas fa-check"></i> CMS integration</li>
                    <li><i class="fas fa-check"></i> Advanced SEO</li>
                    <li><i class="fas fa-check"></i> E-commerce ready</li>
                    <li><i class="fas fa-check"></i> 6 months support</li>
                    <li><i class="fas fa-check"></i> Analytics setup</li>
                    <li><i class="fas fa-check"></i> Blog functionality</li>
                </ul>
                <a href="{{ url('book-call') }}" class="pricing-btn">Get Started</a>
            </div>
            
            <div class="pricing-card">
                <h3>Enterprise</h3>
                <div class="price">Custom</div>
                <p class="description">For large-scale projects</p>
                <ul class="pricing-features">
                    <li><i class="fas fa-check"></i> Unlimited pages</li>
                    <li><i class="fas fa-check"></i> Custom features</li>
                    <li><i class="fas fa-check"></i> API integration</li>
                    <li><i class="fas fa-check"></i> Multi-language</li>
                    <li><i class="fas fa-check"></i> Advanced security</li>
                    <li><i class="fas fa-check"></i> 12 months support</li>
                    <li><i class="fas fa-check"></i> Dedicated manager</li>
                    <li><i class="fas fa-check"></i> Priority support</li>
                </ul>
                <a href="{{ url('book-call') }}" class="pricing-btn">Contact Us</a>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq-section">
        <div class="faq-container">
            <div class="section-title">
                <h2>Frequently Asked Questions</h2>
                <p>Everything you need to know about our web development services</p>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <h3>How long does it take to build a website?</h3>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        <p>The timeline depends on the complexity and scope of your project. A simple 5-page website typically takes 2-3 weeks, while more complex websites with custom features can take 6-12 weeks. We provide a detailed timeline during the initial consultation.</p>
                    </div>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <h3>Will my website be mobile-friendly?</h3>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        <p>Absolutely! All our websites are built with a mobile-first approach, ensuring they look and function perfectly on smartphones, tablets, and desktops. We test across multiple devices and screen sizes to guarantee the best user experience.</p>
                    </div>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <h3>Can I update the website content myself?</h3>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        <p>Yes! We integrate user-friendly content management systems (CMS) like WordPress or custom admin panels that allow you to easily update text, images, and other content without any technical knowledge. We also provide training to help you get started.</p>
                    </div>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <h3>Do you provide ongoing support after launch?</h3>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        <p>Yes, we offer various support packages to keep your website running smoothly. This includes security updates, bug fixes, content updates, and technical support. Support duration varies by package - from 3 months to 12 months with our Enterprise package.</p>
                    </div>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <h3>Will my website be optimized for search engines?</h3>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        <p>Yes, we implement SEO best practices in all our websites, including proper HTML structure, meta tags, fast loading speeds, mobile optimization, and XML sitemaps. For advanced SEO, we offer dedicated SEO services to help you rank higher in search results.</p>
                    </div>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <h3>What if I need changes after the website is live?</h3>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        <p>We're happy to make changes and improvements after launch. Minor tweaks are usually included in your support package, while larger changes or new features can be quoted separately. We're committed to ensuring your website continues to meet your evolving business needs.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Related Services -->
    <section class="related-services">
        <div class="section-title">
            <h2>Related Services</h2>
            <p>Explore other services that complement your web development project</p>
        </div>
        
        <div class="related-grid">
            <a href="#" class="related-card">
                <div class="related-icon">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <h3>Mobile App Development</h3>
                <p>Extend your digital presence with native iOS and Android applications.</p>
                <span class="learn-more">Learn More <i class="fas fa-arrow-right"></i></span>
            </a>
            
            <a href="#" class="related-card">
                <div class="related-icon">
                    <i class="fas fa-search"></i>
                </div>
                <h3>SEO Services</h3>
                <p>Improve your search rankings and drive organic traffic to your website.</p>
                <span class="learn-more">Learn More <i class="fas fa-arrow-right"></i></span>
            </a>
            
            <a href="#" class="related-card">
                <div class="related-icon">
                    <i class="fas fa-cloud"></i>
                </div>
                <h3>Cloud Hosting</h3>
                <p>Scalable and secure cloud infrastructure for your web applications.</p>
                <span class="learn-more">Learn More <i class="fas fa-arrow-right"></i></span>
            </a>
        </div>
    </section>

    {{-- <x-frontend.cta-footer /> --}}

    @push('scripts')
    <script>
        // FAQ Accordion
        const faqItems = document.querySelectorAll('.faq-item');
        
        faqItems.forEach(item => {
            const question = item.querySelector('.faq-question');
            
            question.addEventListener('click', () => {
                const isActive = item.classList.contains('active');
                
                // Close all FAQs
                faqItems.forEach(faq => faq.classList.remove('active'));
                
                // Open clicked FAQ if it wasn't active
                if (!isActive) {
                    item.classList.add('active');
                }
            });
        });
    </script>
    @endpush

</x-layouts.frontend>