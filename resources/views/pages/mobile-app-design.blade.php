<x-layouts.frontend
    title="Mobile App Development Services | Manifest Digital"
    :transparent-header="false"
    preloader="advanced"
    notificationStyle="detailed">
    
    @push('styles')
    @vite('resources/css/mobile-app-design.css')
    @endpush 

    <!-- Breadcrumb Navigation -->
    <nav class="breadcrumb-nav">
        <div class="breadcrumb-container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('solutions') }}">Solutions</a></li>
                <li class="breadcrumb-item active">Mobile App Development</li>
            </ol>
        </div>
    </nav>

    <!-- Service Hero Section -->
    <section class="service-hero">
        <div class="hero-container">
            <div class="service-hero-content">
                <h1>Trusted Mobile Application Development Company</h1>
                <p>Transform your innovative ideas into powerful, user-friendly mobile applications that engage users and drive business growth across all platforms.</p>
                
                <div class="hero-stats">
                    <div class="stat-item">
                        <span class="stat-number">100+</span>
                        <span class="stat-label">Apps Delivered</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">5+</span>
                        <span class="stat-label">Years Experience</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">98%</span>
                        <span class="stat-label">Client Satisfaction</span>
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
                <h2>Building Mobile Experiences That Matter</h2>
                <p>At Manifest Digital, we specialize in creating exceptional mobile applications that not only look stunning but also deliver seamless user experiences. Our team of expert developers and designers work closely with you to transform your vision into reality.</p>
                <p>Whether you need a native iOS app, Android application, or cross-platform solution, we have the expertise and experience to deliver high-quality mobile applications that drive engagement, increase conversions, and help your business thrive in the mobile-first world.</p>
            </div>
        </div>
    </section>

    <!-- Key Features Section -->
    <section class="features-section">
        <div class="features-container">
            <div class="section-title">
                <h2>What We Deliver</h2>
                <p>Comprehensive mobile app development services tailored to your business needs</p>
            </div>
            
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h3>Cross-Platform Development</h3>
                    <p>Build once, deploy everywhere. Our cross-platform solutions ensure your app works seamlessly on both iOS and Android devices while maintaining native performance.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>Professional Consultation</h3>
                    <p>Our experienced team provides strategic guidance throughout the development process, ensuring your app aligns with your business goals and market requirements.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </div>
                    <h3>Scalable Solutions</h3>
                    <p>Future-proof your investment with scalable architectures that grow with your business. Our apps are built to handle increasing user loads and feature expansions.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-paint-brush"></i>
                    </div>
                    <h3>UI/UX Design Excellence</h3>
                    <p>Create stunning interfaces that users love. Our design team crafts intuitive, beautiful user experiences that increase engagement and retention.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3>Security & Performance</h3>
                    <p>Built with security in mind and optimized for peak performance. We implement industry best practices to ensure your app is fast, secure, and reliable.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3>Ongoing Support</h3>
                    <p>Comprehensive maintenance and support services to keep your app updated, secure, and running smoothly with the latest features and improvements.</p>
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
                    <h3>Discovery & Strategy</h3>
                    <p>We begin by understanding your business goals, target audience, and technical requirements. Our team conducts thorough market research and competitor analysis to create a comprehensive development strategy.</p>
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
                    <p>Our design team creates wireframes, mockups, and interactive prototypes that bring your app concept to life. We focus on user experience, visual design, and usability testing.</p>
                </div>
            </div>
            
            <div class="process-step">
                <div class="step-content">
                    <h3>Development & Integration</h3>
                    <p>Using the latest technologies and development frameworks, we build your app with clean, maintainable code. We integrate necessary APIs, databases, and third-party services.</p>
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
                    <p>Rigorous testing across multiple devices and platforms ensures your app functions flawlessly. We conduct performance testing, security audits, and user acceptance testing.</p>
                </div>
            </div>
            
            <div class="process-step">
                <div class="step-content">
                    <h3>Launch & Support</h3>
                    <p>We handle the app store submission process and provide ongoing maintenance, updates, and support to ensure your app continues to perform optimally after launch.</p>
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
                <p>Cutting-edge tools and frameworks for superior app development</p>
            </div>
            
            <div class="tech-grid">
                <div class="tech-item">
                    <h4>React Native</h4>
                    <p>Cross-platform development</p>
                </div>
                <div class="tech-item">
                    <h4>Flutter</h4>
                    <p>High-performance mobile apps</p>
                </div>
                <div class="tech-item">
                    <h4>Swift</h4>
                    <p>Native iOS development</p>
                </div>
                <div class="tech-item">
                    <h4>Kotlin</h4>
                    <p>Modern Android development</p>
                </div>
                <div class="tech-item">
                    <h4>Firebase</h4>
                    <p>Backend services & analytics</p>
                </div>
                <div class="tech-item">
                    <h4>AWS</h4>
                    <p>Cloud infrastructure & hosting</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section class="pricing-section">
        <div class="pricing-container">
            <div class="section-title">
                <h2>Investment Plans</h2>
                <p>Choose the package that best fits your project requirements</p>
            </div>
            
            <div class="pricing-grid">
                <div class="pricing-card">
                    <div class="pricing-header">
                        <h3>Starter App</h3>
                        <div class="price">
                            <span class="currency">$</span>
                            <span class="amount">5,000</span>
                            <span class="period">Starting from</span>
                        </div>
                    </div>
                    <div class="pricing-body">
                        <ul class="pricing-features">
                            <li><i class="fas fa-check"></i> Simple mobile app</li>
                            <li><i class="fas fa-check"></i> Cross-platform development</li>
                            <li><i class="fas fa-check"></i> Basic UI/UX design</li>
                            <li><i class="fas fa-check"></i> 3 months support</li>
                            <li><i class="fas fa-check"></i> App store submission</li>
                        </ul>
                        <a href="{{ route('book-a-call') }}" class="pricing-btn">Get Started</a>
                    </div>
                </div>
                
                <div class="pricing-card popular">
                    <div class="popular-badge">Most Popular</div>
                    <div class="pricing-header">
                        <h3>Professional App</h3>
                        <div class="price">
                            <span class="currency">$</span>
                            <span class="amount">12,000</span>
                            <span class="period">Starting from</span>
                        </div>
                    </div>
                    <div class="pricing-body">
                        <ul class="pricing-features">
                            <li><i class="fas fa-check"></i> Advanced mobile app</li>
                            <li><i class="fas fa-check"></i> Custom UI/UX design</li>
                            <li><i class="fas fa-check"></i> API integrations</li>
                            <li><i class="fas fa-check"></i> User authentication</li>
                            <li><i class="fas fa-check"></i> Admin dashboard</li>
                            <li><i class="fas fa-check"></i> 6 months support</li>
                        </ul>
                        <a href="{{ route('book-a-call') }}" class="pricing-btn">Get Started</a>
                    </div>
                </div>
                
                <div class="pricing-card">
                    <div class="pricing-header">
                        <h3>Enterprise App</h3>
                        <div class="price">
                            <span class="currency">$</span>
                            <span class="amount">25,000</span>
                            <span class="period">Starting from</span>
                        </div>
                    </div>
                    <div class="pricing-body">
                        <ul class="pricing-features">
                            <li><i class="fas fa-check"></i> Full-featured app</li>
                            <li><i class="fas fa-check"></i> Custom backend development</li>
                            <li><i class="fas fa-check"></i> Advanced integrations</li>
                            <li><i class="fas fa-check"></i> Analytics & reporting</li>
                            <li><i class="fas fa-check"></i> DevOps & deployment</li>
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
                <p>Everything you need to know about our mobile app development services</p>
            </div>
            
            <div class="faq-accordion">
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>How long does it take to develop a mobile app?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-answer-content">
                            <p>Development timelines vary based on app complexity. A simple app typically takes 8-12 weeks, while complex apps with advanced features can take 16-24 weeks. We provide detailed project timelines during the consultation phase.</p>
                        </div>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>Do you develop for both iOS and Android?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-answer-content">
                            <p>Yes! We develop native iOS and Android apps, as well as cross-platform solutions using React Native and Flutter. Cross-platform development allows you to reach both markets with a single codebase, reducing costs and development time.</p>
                        </div>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>Will you help with app store submissions?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-answer-content">
                            <p>Absolutely! We handle the entire app store submission process for both Apple App Store and Google Play Store, including preparing app store assets, descriptions, and ensuring compliance with store guidelines.</p>
                        </div>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>Do you provide ongoing app maintenance?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-answer-content">
                            <p>Yes, we offer comprehensive maintenance packages that include bug fixes, security updates, OS compatibility updates, feature enhancements, and performance monitoring to ensure your app stays current and runs smoothly.</p>
                        </div>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>Can you integrate third-party services and APIs?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-answer-content">
                            <p>Yes, we have extensive experience integrating various third-party services including payment gateways, social media APIs, mapping services, analytics tools, push notification services, and custom backend systems.</p>
                        </div>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>What is your approach to app security?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-answer-content">
                            <p>Security is paramount in our development process. We implement encryption, secure authentication, data protection measures, and follow industry best practices for secure coding. All apps undergo security testing before launch.</p>
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
            <p>Explore other services that complement your mobile app development project</p>
        </div>
        
        <div class="related-grid">
            <a href="{{ route('website-development') }}" class="related-card">
                <div class="related-icon">
                    <i class="fas fa-globe"></i>
                </div>
                <h4>Website Development</h4>
                <p>Professional websites that work seamlessly with your mobile app</p>
            </a>
            
            <a href="{{ route('brand-positioning') }}" class="related-card">
                <div class="related-icon">
                    <i class="fas fa-bullhorn"></i>
                </div>
                <h4>Brand Positioning</h4>
                <p>Build a strong brand identity for your mobile app launch</p>
            </a>
            
            <a href="{{ route('qa-testing') }}" class="related-card">
                <div class="related-icon">
                    <i class="fas fa-bug"></i>
                </div>
                <h4>QA Testing</h4>
                <p>Comprehensive testing services for mobile applications</p>
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
</x-layouts.frontend>
