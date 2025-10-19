<x-layouts.frontend
    title="Brand Positioning Services | Manifest Digital"
    :transparent-header="false"
    preloader="advanced"
    notificationStyle="detailed">
    @push('styles')
    @vite('resources/css/brand-positioning.css')
    @endpush 

    <!-- Breadcrumb Navigation -->
    <nav class="breadcrumb-nav">
        <div class="breadcrumb-container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('solutions') }}">Solutions</a></li>
                <li class="breadcrumb-item active">Brand Positioning</li>
            </ol>
        </div>
    </nav>

    <!-- Service Hero Section -->
    <section class="service-hero">
        <div class="hero-container">
            <div class="service-hero-content">
                <h1>Inspire Confidence and Trust in Your Brand</h1>
                <p>Strategic brand positioning services that help your business stand out, connect with your audience, and achieve sustainable market leadership through powerful branding solutions.</p>
                
                <div class="hero-stats">
                    <div class="stat-item">
                        <span class="stat-number">200+</span>
                        <span class="stat-label">Brands Positioned</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">7+</span>
                        <span class="stat-label">Years Experience</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">90%</span>
                        <span class="stat-label">Brand Recognition Increase</span>
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
                <h2>Build a Brand That Inspires Action</h2>
                <p>At Manifest Digital, we understand that strong brands don't happen by accident. Our comprehensive brand positioning services help you define your unique value proposition, connect with your target audience, and create lasting impressions that drive business growth.</p>
                <p>From strategic planning and digital transformation to marketing execution, we provide end-to-end brand positioning solutions that ensure your brand resonates with customers and stands out in today's competitive marketplace.</p>
            </div>
        </div>
    </section>

    <!-- Key Features Section -->
    <section class="features-section">
        <div class="features-container">
            <div class="section-title">
                <h2>Our Brand Solutions</h2>
                <p>Comprehensive brand positioning services tailored to your business goals</p>
            </div>
            
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-lightbulb"></i>
                    </div>
                    <h3>Strategic Branding</h3>
                    <p>Develop powerful brand strategies that align with your business objectives and resonate with your target audience through comprehensive market research and analysis.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3>Brand Strategy</h3>
                    <p>Create compelling brand strategies that define your market position, differentiate you from competitors, and guide all your marketing communications.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-digital-tachograph"></i>
                    </div>
                    <h3>Digital Transformation</h3>
                    <p>Transform your brand for the digital age with modern brand experiences across all touchpoints, from websites to social media platforms.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-bullhorn"></i>
                    </div>
                    <h3>Marketing Solutions</h3>
                    <p>Integrated marketing campaigns that amplify your brand message and drive engagement across all channels, both digital and traditional.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-palette"></i>
                    </div>
                    <h3>Visual Identity</h3>
                    <p>Create stunning visual identities including logos, color palettes, typography, and brand guidelines that reflect your brand personality.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>Brand Experience</h3>
                    <p>Design cohesive brand experiences that delight customers at every touchpoint and build long-term brand loyalty and advocacy.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Brand Solutions Section -->
    <section class="solutions-section">
        <div class="solutions-container">
            <div class="section-title">
                <h2>Brand Positioning Solutions</h2>
                <p>Tailored approaches for different business needs and market segments</p>
            </div>
            
            <div class="solutions-grid">
                <div class="solution-card">
                    <div class="solution-icon">
                        <i class="fas fa-rocket"></i>
                    </div>
                    <h3>Startup Branding</h3>
                    <p>Launch your startup with a strong brand foundation that attracts investors, customers, and top talent from day one.</p>
                </div>
                
                <div class="solution-card">
                    <div class="solution-icon">
                        <i class="fas fa-sync-alt"></i>
                    </div>
                    <h3>Brand Repositioning</h3>
                    <p>Refresh and revitalize existing brands to better align with market changes and business evolution.</p>
                </div>
                
                <div class="solution-card">
                    <div class="solution-icon">
                        <i class="fas fa-globe"></i>
                    </div>
                    <h3>Global Brand Strategy</h3>
                    <p>Develop brand strategies that work across different markets and cultures while maintaining brand consistency.</p>
                </div>
                
                <div class="solution-card">
                    <div class="solution-icon">
                        <i class="fas fa-award"></i>
                    </div>
                    <h3>Premium Positioning</h3>
                    <p>Position your brand as a premium choice in your market category with sophisticated brand strategies.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Process Section -->
    <section class="process-section">
        <div class="section-title">
            <h2>Our Brand Positioning Process</h2>
            <p>A proven methodology for building powerful brands</p>
        </div>
        
        <div class="process-timeline">
            <div class="process-step">
                <div class="step-content">
                    <h3>Discovery & Research</h3>
                    <p>Deep dive into your business, market, competitors, and target audience to understand your unique positioning opportunities and challenges.</p>
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
                    <h3>Strategy Development</h3>
                    <p>Create comprehensive brand strategy including positioning statement, brand personality, value proposition, and messaging architecture.</p>
                </div>
            </div>
            
            <div class="process-step">
                <div class="step-content">
                    <h3>Visual Identity Creation</h3>
                    <p>Design visual brand elements including logo, color palette, typography, imagery style, and comprehensive brand guidelines.</p>
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
                    <h3>Brand Activation</h3>
                    <p>Launch your new brand across all touchpoints including marketing materials, digital presence, and customer communications.</p>
                </div>
            </div>
            
            <div class="process-step">
                <div class="step-content">
                    <h3>Monitoring & Optimization</h3>
                    <p>Track brand performance, gather feedback, and continuously optimize your brand strategy for maximum impact and recognition.</p>
                </div>
                <div class="step-number-wrapper">
                    <div class="step-number">5</div>
                </div>
                <div class="step-spacer"></div>
            </div>
        </div>
    </section>

    <!-- Brand Tools Section -->
    <section class="tech-section">
        <div class="tech-container">
            <div class="section-title" style="color: white;">
                <h2>Brand Development Tools</h2>
                <p>Professional tools and platforms for comprehensive brand development</p>
            </div>
            
            <div class="tech-grid">
                <div class="tech-item">
                    <h4>Adobe Creative Suite</h4>
                    <p>Professional design tools</p>
                </div>
                <div class="tech-item">
                    <h4>Figma</h4>
                    <p>Collaborative design platform</p>
                </div>
                <div class="tech-item">
                    <h4>Brand Guidelines</h4>
                    <p>Comprehensive style guides</p>
                </div>
                <div class="tech-item">
                    <h4>Market Research</h4>
                    <p>Data-driven insights</p>
                </div>
                <div class="tech-item">
                    <h4>Analytics Tools</h4>
                    <p>Brand performance tracking</p>
                </div>
                <div class="tech-item">
                    <h4>Social Media</h4>
                    <p>Brand presence management</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section class="pricing-section">
        <div class="pricing-container">
            <div class="section-title">
                <h2>Brand Positioning Packages</h2>
                <p>Choose the solution that best fits your brand development needs</p>
            </div>
            
            <div class="pricing-grid">
                <div class="pricing-card">
                    <div class="pricing-header">
                        <h3>Brand Essentials</h3>
                        <div class="price">
                            <span class="currency">$</span>
                            <span class="amount">3,000</span>
                            <span class="period">Starting from</span>
                        </div>
                    </div>
                    <div class="pricing-body">
                        <ul class="pricing-features">
                            <li><i class="fas fa-check"></i> Brand strategy development</li>
                            <li><i class="fas fa-check"></i> Logo design & variations</li>
                            <li><i class="fas fa-check"></i> Color palette & typography</li>
                            <li><i class="fas fa-check"></i> Basic brand guidelines</li>
                            <li><i class="fas fa-check"></i> Business card design</li>
                        </ul>
                        <a href="{{ route('book-a-call') }}" class="pricing-btn">Get Started</a>
                    </div>
                </div>
                
                <div class="pricing-card popular">
                    <div class="popular-badge">Most Popular</div>
                    <div class="pricing-header">
                        <h3>Brand Professional</h3>
                        <div class="price">
                            <span class="currency">$</span>
                            <span class="amount">7,500</span>
                            <span class="period">Starting from</span>
                        </div>
                    </div>
                    <div class="pricing-body">
                        <ul class="pricing-features">
                            <li><i class="fas fa-check"></i> Complete brand strategy</li>
                            <li><i class="fas fa-check"></i> Visual identity system</li>
                            <li><i class="fas fa-check"></i> Marketing materials design</li>
                            <li><i class="fas fa-check"></i> Digital brand assets</li>
                            <li><i class="fas fa-check"></i> Brand guidelines manual</li>
                            <li><i class="fas fa-check"></i> 3 months support</li>
                        </ul>
                        <a href="{{ route('book-a-call') }}" class="pricing-btn">Get Started</a>
                    </div>
                </div>
                
                <div class="pricing-card">
                    <div class="pricing-header">
                        <h3>Brand Enterprise</h3>
                        <div class="price">
                            <span class="currency">$</span>
                            <span class="amount">15,000</span>
                            <span class="period">Starting from</span>
                        </div>
                    </div>
                    <div class="pricing-body">
                        <ul class="pricing-features">
                            <li><i class="fas fa-check"></i> Comprehensive brand audit</li>
                            <li><i class="fas fa-check"></i> Multi-market brand strategy</li>
                            <li><i class="fas fa-check"></i> Complete brand ecosystem</li>
                            <li><i class="fas fa-check"></i> Brand activation campaign</li>
                            <li><i class="fas fa-check"></i> Performance tracking</li>
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
                <p>Everything you need to know about our brand positioning services</p>
            </div>
            
            <div class="faq-accordion">
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>How long does a brand positioning project take?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-answer-content">
                            <p>Brand positioning projects typically take 6-12 weeks depending on scope. Brand Essentials projects take 4-6 weeks, Professional projects take 8-10 weeks, and Enterprise projects can take 12-16 weeks. We provide detailed timelines during our initial consultation.</p>
                        </div>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>What's included in brand guidelines?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-answer-content">
                            <p>Our brand guidelines include logo usage rules, color specifications, typography guidelines, imagery style, voice and tone guidelines, and application examples across various media. Enterprise packages include comprehensive brand manuals with detailed implementation instructions.</p>
                        </div>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>Can you help rebrand an existing business?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-answer-content">
                            <p>Absolutely! We specialize in brand repositioning and rebranding projects. We'll assess your current brand, identify opportunities for improvement, and develop a strategic approach to evolve your brand while maintaining customer recognition and loyalty.</p>
                        </div>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>Do you provide ongoing brand management?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-answer-content">
                            <p>Yes, we offer ongoing brand management services including brand monitoring, performance tracking, marketing material development, and brand guideline updates. Our support packages ensure your brand remains consistent and effective across all touchpoints.</p>
                        </div>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>How do you measure brand positioning success?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-answer-content">
                            <p>We track various metrics including brand awareness, brand recognition, customer perception surveys, market share, engagement rates, and conversion metrics. We provide regular reports showing how your brand positioning is performing and impacting your business goals.</p>
                        </div>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>Can you help with digital brand transformation?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-answer-content">
                            <p>Yes, digital transformation is a core part of our brand positioning services. We help brands adapt to digital channels, create cohesive online experiences, optimize for social media, and develop digital-first brand strategies that resonate with modern consumers.</p>
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
            <p>Explore other services that complement your brand positioning project</p>
        </div>
        
        <div class="related-grid">
            <a href="{{ route('website-development') }}" class="related-card">
                <div class="related-icon">
                    <i class="fas fa-globe"></i>
                </div>
                <h4>Website Development</h4>
                <p>Build websites that reflect your brand positioning</p>
            </a>
            
            <a href="{{ route('seo-services') }}" class="related-card">
                <div class="related-icon">
                    <i class="fas fa-search"></i>
                </div>
                <h4>SEO Services</h4>
                <p>Optimize your brand's online visibility and reach</p>
            </a>
            
            <a href="{{ route('mobile-app-design') }}" class="related-card">
                <div class="related-icon">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <h4>Mobile App Development</h4>
                <p>Extend your brand experience to mobile platforms</p>
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
        /* Brand Solutions Section Styles */
        .solutions-section {
            background: #f8f9fa;
            padding: 80px 20px;
        }
        
        .solutions-container {
            max-width: 1400px;
            margin: 0 auto;
        }
        
        .solutions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            margin-top: 50px;
        }
        
        .solution-card {
            background: white;
            padding: 35px;
            border-radius: 15px;
            text-align: center;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        
        .solution-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border-color: #ff2200;
        }
        
        .solution-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #ff2200, #ff6b00);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }
        
        .solution-icon i {
            font-size: 32px;
            color: white;
        }
        
        .solution-card h3 {
            font-size: 22px;
            font-weight: 800;
            margin-bottom: 15px;
            color: #1a1a1a;
        }
        
        .solution-card p {
            font-size: 16px;
            line-height: 1.6;
            color: #666;
            margin: 0;
        }
    </style>
</x-layouts.frontend>
