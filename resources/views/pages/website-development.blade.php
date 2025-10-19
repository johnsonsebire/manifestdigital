<x-layouts.frontend
    title="Website Development Services | Manifest Digital"
    :transparent-header="false"
    preloader="advanced"
    notificationStyle="detailed">
    
   @push('styles')
    @vite('resources/css/website-development.css')
    @endpush 

    <!-- Breadcrumb Navigation -->
    <nav class="breadcrumb-nav">
        <div class="breadcrumb-container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('solutions') }}">Solutions</a></li>
                <li class="breadcrumb-item active">Website Development</li>
            </ol>
        </div>
    </nav>

    <!-- Service Hero Section -->
    <section class="service-hero">
        <div class="hero-container">
            <div class="service-hero-content">
                <h1>We Build Websites That Work!</h1>
                <p>Create powerful, responsive websites that drive results and deliver exceptional user experiences for your business across all industries.</p>
                
                <div class="hero-stats">
                    <div class="stat-item">
                        <span class="stat-number">8+</span>
                        <span class="stat-label">Years Experience</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">500+</span>
                        <span class="stat-label">Websites Built</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">99%</span>
                        <span class="stat-label">Uptime Guaranteed</span>
                    </div>
                </div>
                
                <div class="hero-actions">
                    <a href="{{ route('book-a-call') }}" class="btn-primary">Get Started</a>
                    <a href="{{ route('projects') }}" class="btn-secondary">View Portfolio</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Service Overview -->
    <section class="service-overview">
        <div class="overview-container">
            <div class="overview-content">
                <h2>Professional Website Development Across Industries</h2>
                <p>At Manifest Digital, we specialize in creating custom websites that not only look amazing but also perform exceptionally well. With over 8 years of experience, we've helped businesses across multiple industries establish their online presence and achieve their digital goals.</p>
                <p>We serve diverse sectors including Healthcare, Education, NGO/Charity, Government, and various business industries. Our websites are built with modern technologies, optimized for performance, and designed to convert visitors into customers.</p>
            </div>
        </div>
    </section>

    <!-- Key Features Section -->
    <section class="features-section">
        <div class="features-container">
            <div class="section-title">
                <h2>What We Deliver</h2>
                <p>Comprehensive website development services tailored to your industry needs</p>
            </div>
            
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h3>Responsive Design</h3>
                    <p>Mobile-first websites that look and perform perfectly on all devices, from smartphones to desktops, ensuring optimal user experience across all platforms.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-tachometer-alt"></i>
                    </div>
                    <h3>Lightning Fast Performance</h3>
                    <p>Optimized websites with fast loading speeds, clean code, and efficient architecture that enhance user experience and search engine rankings.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <h3>SEO Optimized</h3>
                    <p>Built-in search engine optimization features including proper HTML structure, meta tags, and XML sitemaps to help your website rank higher in search results.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3>Secure & Reliable</h3>
                    <p>Industry-standard security measures, SSL certificates, regular backups, and robust hosting solutions to keep your website safe and accessible.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-edit"></i>
                    </div>
                    <h3>Easy Content Management</h3>
                    <p>User-friendly content management systems that allow you to easily update your website content, images, and pages without technical expertise.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3>Analytics Integration</h3>
                    <p>Comprehensive analytics and tracking setup to monitor your website performance, user behavior, and conversion rates for data-driven decisions.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Industry Focus Section -->
    <section class="industry-section">
        <div class="industry-container">
            <div class="section-title">
                <h2>Industries We Serve</h2>
                <p>Specialized website solutions across diverse sectors</p>
            </div>
            
            <div class="industry-grid">
                <div class="industry-card">
                    <div class="industry-icon">
                        <i class="fas fa-heartbeat"></i>
                    </div>
                    <h3>Healthcare</h3>
                    <p>HIPAA-compliant websites for hospitals, clinics, and medical professionals with patient portals and appointment systems.</p>
                </div>
                
                <div class="industry-card">
                    <div class="industry-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h3>Education</h3>
                    <p>Learning management systems, school websites, and educational platforms with student and parent portals.</p>
                </div>
                
                <div class="industry-card">
                    <div class="industry-icon">
                        <i class="fas fa-hands-helping"></i>
                    </div>
                    <h3>NGO/Charity</h3>
                    <p>Donation platforms, volunteer management systems, and awareness websites for non-profit organizations.</p>
                </div>
                
                <div class="industry-card">
                    <div class="industry-icon">
                        <i class="fas fa-landmark"></i>
                    </div>
                    <h3>Government</h3>
                    <p>Accessible, compliant government websites with citizen services, document management, and public information systems.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Process Section -->
    <section class="process-section">
        <div class="section-title">
            <h2>Our Development Process</h2>
            <p>A proven methodology that delivers exceptional results</p>
        </div>
        
        <div class="process-timeline">
            <div class="process-step">
                <div class="step-content">
                    <h3>Discovery & Planning</h3>
                    <p>We start by understanding your business goals, target audience, and specific requirements. Our team conducts thorough research and creates a comprehensive project plan.</p>
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
                    <p>Our design team creates wireframes, mockups, and interactive prototypes that align with your brand identity and user experience goals.</p>
                </div>
            </div>
            
            <div class="process-step">
                <div class="step-content">
                    <h3>Development & Integration</h3>
                    <p>Using modern web technologies and best practices, we build your website with clean, maintainable code and integrate all necessary features and systems.</p>
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
                    <h3>Testing & Quality Assurance</h3>
                    <p>Comprehensive testing across multiple browsers, devices, and platforms to ensure your website functions flawlessly and meets all requirements.</p>
                </div>
            </div>
            
            <div class="process-step">
                <div class="step-content">
                    <h3>Launch & Support</h3>
                    <p>We handle the deployment process and provide ongoing maintenance, updates, and support to ensure your website continues to perform optimally.</p>
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
                <p>Modern web technologies for superior performance and scalability</p>
            </div>
            
            <div class="tech-grid">
                <div class="tech-item">
                    <h4>Laravel</h4>
                    <p>Robust PHP framework</p>
                </div>
                <div class="tech-item">
                    <h4>React</h4>
                    <p>Dynamic user interfaces</p>
                </div>
                <div class="tech-item">
                    <h4>WordPress</h4>
                    <p>Content management</p>
                </div>
                <div class="tech-item">
                    <h4>Node.js</h4>
                    <p>Server-side development</p>
                </div>
                <div class="tech-item">
                    <h4>MySQL</h4>
                    <p>Database management</p>
                </div>
                <div class="tech-item">
                    <h4>AWS</h4>
                    <p>Cloud hosting solutions</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section class="pricing-section">
        <div class="pricing-container">
            <div class="section-title">
                <h2>Website Packages</h2>
                <p>Choose the solution that best fits your business needs</p>
            </div>
            
            <div class="pricing-grid">
                <div class="pricing-card">
                    <div class="pricing-header">
                        <h3>Business Website</h3>
                        <div class="price">
                            <span class="currency">$</span>
                            <span class="amount">2,500</span>
                            <span class="period">Starting from</span>
                        </div>
                    </div>
                    <div class="pricing-body">
                        <ul class="pricing-features">
                            <li><i class="fas fa-check"></i> 5-10 page website</li>
                            <li><i class="fas fa-check"></i> Responsive design</li>
                            <li><i class="fas fa-check"></i> Contact forms</li>
                            <li><i class="fas fa-check"></i> SEO optimization</li>
                            <li><i class="fas fa-check"></i> 3 months support</li>
                        </ul>
                        <a href="{{ route('book-a-call') }}" class="pricing-btn">Get Started</a>
                    </div>
                </div>
                
                <div class="pricing-card popular">
                    <div class="popular-badge">Most Popular</div>
                    <div class="pricing-header">
                        <h3>Professional Website</h3>
                        <div class="price">
                            <span class="currency">$</span>
                            <span class="amount">5,000</span>
                            <span class="period">Starting from</span>
                        </div>
                    </div>
                    <div class="pricing-body">
                        <ul class="pricing-features">
                            <li><i class="fas fa-check"></i> Custom design & development</li>
                            <li><i class="fas fa-check"></i> Content management system</li>
                            <li><i class="fas fa-check"></i> E-commerce functionality</li>
                            <li><i class="fas fa-check"></i> Analytics integration</li>
                            <li><i class="fas fa-check"></i> 6 months support</li>
                        </ul>
                        <a href="{{ route('book-a-call') }}" class="pricing-btn">Get Started</a>
                    </div>
                </div>
                
                <div class="pricing-card">
                    <div class="pricing-header">
                        <h3>Enterprise Website</h3>
                        <div class="price">
                            <span class="currency">$</span>
                            <span class="amount">10,000</span>
                            <span class="period">Starting from</span>
                        </div>
                    </div>
                    <div class="pricing-body">
                        <ul class="pricing-features">
                            <li><i class="fas fa-check"></i> Complex web applications</li>
                            <li><i class="fas fa-check"></i> Custom integrations</li>
                            <li><i class="fas fa-check"></i> Advanced security features</li>
                            <li><i class="fas fa-check"></i> Performance optimization</li>
                            <li><i class="fas fa-check"></i> 12 months support</li>
                        </ul>
                        <a href="{{ route('book-a-call') }}" class="pricing-btn">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq-section">
        <div class="faq-container">
            <div class="section-title">
                <h2>Frequently Asked Questions</h2>
                <p>Everything you need to know about our website development services</p>
            </div>
            
            <div class="faq-accordion">
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
        </div>
    </section>

    <!-- Related Services -->
    <section class="related-services">
        <div class="section-title">
            <h2>Related Services</h2>
            <p>Explore other services that complement your website development project</p>
        </div>
        
        <div class="related-grid">
            <a href="{{ route('mobile-app-design') }}" class="related-card">
                <div class="related-icon">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <h4>Mobile App Development</h4>
                <p>Extend your web presence with powerful mobile applications</p>
            </a>
            
            <a href="{{ route('seo-services') }}" class="related-card">
                <div class="related-icon">
                    <i class="fas fa-search"></i>
                </div>
                <h4>SEO Services</h4>
                <p>Boost your website's visibility in search engines</p>
            </a>
            
            <a href="{{ route('brand-positioning') }}" class="related-card">
                <div class="related-icon">
                    <i class="fas fa-bullhorn"></i>
                </div>
                <h4>Brand Positioning</h4>
                <p>Build a strong brand identity for your online presence</p>
            </a>
        </div>
    </section>

    <script>
        // FAQ Accordion functionality
        document.addEventListener('DOMContentLoaded', function() {
            const faqItems = document.querySelectorAll('.faq-item');
            
            faqItems.forEach(item => {
                const question = item.querySelector('.faq-question');
                
                question.addEventListener('click', () => {
                    const isActive = item.classList.contains('active');
                    
                    // Close all other items
                    faqItems.forEach(otherItem => {
                        if (otherItem !== item) {
                            otherItem.classList.remove('active');
                        }
                    });
                    
                    // Toggle current item
                    item.classList.toggle('active', !isActive);
                });
            });
        });
    </script>

    <style>
        /* Industry Section Styles */
        .industry-section {
            background: #f8f9fa;
            padding: 80px 20px;
        }
        
        .industry-container {
            max-width: 1400px;
            margin: 0 auto;
        }
        
        .industry-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            margin-top: 50px;
        }
        
        .industry-card {
            background: white;
            padding: 35px;
            border-radius: 15px;
            text-align: center;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        
        .industry-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border-color: #ff2200;
        }
        
        .industry-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #ff2200, #ff6b00);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }
        
        .industry-icon i {
            font-size: 32px;
            color: white;
        }
        
        .industry-card h3 {
            font-size: 22px;
            font-weight: 800;
            margin-bottom: 15px;
            color: #1a1a1a;
        }
        
        .industry-card p {
            font-size: 16px;
            line-height: 1.6;
            color: #666;
            margin: 0;
        }
    </style>
</x-layouts.frontend>
