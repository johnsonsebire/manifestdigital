<x-layouts.frontend
    title="SEO Services | Manifest Digital"
    :transparent-header="false"
    preloader="advanced"
    notificationStyle="detailed">
    
  @push('styles')
    @vite('resources/css/seo-services.css')
    @endpush

    <!-- Breadcrumb Navigation -->
    <nav class="breadcrumb-nav">
        <div class="breadcrumb-container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('solutions') }}">Solutions</a></li>
                <li class="breadcrumb-item active">SEO Services</li>
            </ol>
        </div>
    </nav>

    <!-- Service Hero Section -->
    <section class="service-hero">
        <div class="hero-container">
            <div class="service-hero-content">
                <h1>Effective SEO Companies to Boost Traffic & Revenue</h1>
                <p>Professional search engine optimization services that dramatically help increase your organization's revenue and impact through effective SEO solutions that drive qualified traffic.</p>
                
                <div class="hero-stats">
                    <div class="stat-item">
                        <span class="stat-number">300+</span>
                        <span class="stat-label">Websites Optimized</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">150%</span>
                        <span class="stat-label">Average Traffic Increase</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">6+</span>
                        <span class="stat-label">Years SEO Experience</span>
                    </div>
                </div>
                
                <div class="hero-actions">
                    <a href="{{ route('book-a-call') }}" class="btn-primary">Get Started</a>
                    <a href="{{ route('projects') }}" class="btn-secondary">View Case Studies</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Service Overview -->
    <section class="service-overview">
        <div class="overview-container">
            <div class="overview-content">
                <h2>Drive More Traffic, Generate More Revenue</h2>
                <p>At Manifest Digital, we understand that effective SEO is more than just ranking higher in search results – it's about driving qualified traffic that converts into customers and revenue. Our comprehensive SEO strategies are designed to dramatically increase your organization's online visibility and business impact.</p>
                <p>From organic search optimization to advanced digital marketing campaigns, we provide data-driven SEO solutions that deliver measurable results and sustainable growth for your business.</p>
            </div>
        </div>
    </section>

    <!-- SEO Services Section -->
    <section class="features-section">
        <div class="features-container">
            <div class="section-title">
                <h2>SEO Services We Provide</h2>
                <p>Comprehensive search engine optimization solutions for sustainable growth</p>
            </div>
            
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <h3>Organic Search</h3>
                    <p>Complete organic search optimization including keyword research, on-page SEO, technical SEO, and content optimization to improve your natural search rankings.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-bullhorn"></i>
                    </div>
                    <h3>Digital Advertising</h3>
                    <p>Strategic digital advertising campaigns including Google Ads, Bing Ads, and social media advertising to complement your organic SEO efforts.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-share-alt"></i>
                    </div>
                    <h3>Social Media Marketing</h3>
                    <p>Integrated social media marketing strategies that support your SEO goals and help build brand authority across all major social platforms.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <h3>Detailed Analytics & Reports</h3>
                    <p>Comprehensive analytics and detailed reporting that track your SEO performance, traffic growth, conversions, and ROI with actionable insights.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-edit"></i>
                    </div>
                    <h3>Content Strategy</h3>
                    <p>Strategic content planning and optimization that targets your audience's search intent and supports your overall SEO and business objectives.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-cogs"></i>
                    </div>
                    <h3>Technical SEO</h3>
                    <p>Advanced technical SEO audits and optimization including site speed, mobile optimization, schema markup, and crawlability improvements.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- SEO Strategies Section -->
    <section class="strategies-section">
        <div class="strategies-container">
            <div class="section-title">
                <h2>Our SEO Strategies</h2>
                <p>Proven methodologies that deliver sustainable results</p>
            </div>
            
            <div class="strategies-grid">
                <div class="strategy-card">
                    <div class="strategy-icon">
                        <i class="fas fa-key"></i>
                    </div>
                    <h3>Keyword Research</h3>
                    <p>In-depth keyword analysis to identify high-value search terms that your target audience uses to find your products and services.</p>
                </div>
                
                <div class="strategy-card">
                    <div class="strategy-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <h3>On-Page Optimization</h3>
                    <p>Comprehensive on-page SEO including title tags, meta descriptions, header optimization, and internal linking strategies.</p>
                </div>
                
                <div class="strategy-card">
                    <div class="strategy-icon">
                        <i class="fas fa-link"></i>
                    </div>
                    <h3>Link Building</h3>
                    <p>White-hat link building strategies that earn high-quality backlinks from authoritative websites in your industry.</p>
                </div>
                
                <div class="strategy-card">
                    <div class="strategy-icon">
                        <i class="fas fa-map-marked-alt"></i>
                    </div>
                    <h3>Local SEO</h3>
                    <p>Local search optimization to help your business appear in local search results and Google My Business listings.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Process Section -->
    <section class="process-section">
        <div class="section-title">
            <h2>Our SEO Process</h2>
            <p>A systematic approach to achieving and maintaining top search rankings</p>
        </div>
        
        <div class="process-timeline">
            <div class="process-step">
                <div class="step-content">
                    <h3>SEO Audit & Analysis</h3>
                    <p>Comprehensive analysis of your current website performance, competitive landscape, and identification of optimization opportunities.</p>
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
                    <p>Create a customized SEO strategy based on your business goals, target audience, and competitive analysis findings.</p>
                </div>
            </div>
            
            <div class="process-step">
                <div class="step-content">
                    <h3>Implementation & Optimization</h3>
                    <p>Execute the SEO strategy through on-page optimization, technical improvements, content creation, and link building activities.</p>
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
                    <h3>Monitoring & Reporting</h3>
                    <p>Continuous monitoring of SEO performance with detailed monthly reports showing progress, insights, and recommendations.</p>
                </div>
            </div>
            
            <div class="process-step">
                <div class="step-content">
                    <h3>Ongoing Optimization</h3>
                    <p>Continuous optimization and strategy refinement based on performance data, algorithm updates, and changing business needs.</p>
                </div>
                <div class="step-number-wrapper">
                    <div class="step-number">5</div>
                </div>
                <div class="step-spacer"></div>
            </div>
        </div>
    </section>

    <!-- SEO Tools Section -->
    <section class="tech-section">
        <div class="tech-container">
            <div class="section-title" style="color: white;">
                <h2>SEO Tools & Technologies</h2>
                <p>Professional SEO tools for comprehensive optimization and analysis</p>
            </div>
            
            <div class="tech-grid">
                <div class="tech-item">
                    <h4>Google Analytics</h4>
                    <p>Traffic & performance analysis</p>
                </div>
                <div class="tech-item">
                    <h4>SEMrush</h4>
                    <p>Keyword research & competition</p>
                </div>
                <div class="tech-item">
                    <h4>Ahrefs</h4>
                    <p>Backlink analysis & monitoring</p>
                </div>
                <div class="tech-item">
                    <h4>Google Search Console</h4>
                    <p>Search performance insights</p>
                </div>
                <div class="tech-item">
                    <h4>Screaming Frog</h4>
                    <p>Technical SEO auditing</p>
                </div>
                <div class="tech-item">
                    <h4>Moz Pro</h4>
                    <p>SEO tracking & optimization</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section class="pricing-section">
        <div class="pricing-container">
            <div class="section-title">
                <h2>SEO Service Packages</h2>
                <p>Flexible SEO solutions to match your business needs and budget</p>
            </div>
            
            <div class="pricing-grid">
                <div class="pricing-card">
                    <div class="pricing-header">
                        <h3>SEO Starter</h3>
                        <div class="price">
                            <span class="currency">$</span>
                            <span class="amount">800</span>
                            <span class="period">Per Month</span>
                        </div>
                    </div>
                    <div class="pricing-body">
                        <ul class="pricing-features">
                            <li><i class="fas fa-check"></i> SEO audit & analysis</li>
                            <li><i class="fas fa-check"></i> Keyword research</li>
                            <li><i class="fas fa-check"></i> On-page optimization</li>
                            <li><i class="fas fa-check"></i> Monthly reporting</li>
                            <li><i class="fas fa-check"></i> Google Analytics setup</li>
                        </ul>
                        <a href="{{ route('book-a-call') }}" class="pricing-btn">Get Started</a>
                    </div>
                </div>
                
                <div class="pricing-card popular">
                    <div class="popular-badge">Most Popular</div>
                    <div class="pricing-header">
                        <h3>SEO Professional</h3>
                        <div class="price">
                            <span class="currency">$</span>
                            <span class="amount">1,500</span>
                            <span class="period">Per Month</span>
                        </div>
                    </div>
                    <div class="pricing-body">
                        <ul class="pricing-features">
                            <li><i class="fas fa-check"></i> Everything in Starter</li>
                            <li><i class="fas fa-check"></i> Content optimization</li>
                            <li><i class="fas fa-check"></i> Link building campaign</li>
                            <li><i class="fas fa-check"></i> Technical SEO fixes</li>
                            <li><i class="fas fa-check"></i> Local SEO optimization</li>
                            <li><i class="fas fa-check"></i> Competitor analysis</li>
                        </ul>
                        <a href="{{ route('book-a-call') }}" class="pricing-btn">Get Started</a>
                    </div>
                </div>
                
                <div class="pricing-card">
                    <div class="pricing-header">
                        <h3>SEO Enterprise</h3>
                        <div class="price">
                            <span class="currency">$</span>
                            <span class="amount">3,000</span>
                            <span class="period">Per Month</span>
                        </div>
                    </div>
                    <div class="pricing-body">
                        <ul class="pricing-features">
                            <li><i class="fas fa-check"></i> Everything in Professional</li>
                            <li><i class="fas fa-check"></i> Advanced content strategy</li>
                            <li><i class="fas fa-check"></i> PPC campaign management</li>
                            <li><i class="fas fa-check"></i> Social media marketing</li>
                            <li><i class="fas fa-check"></i> Advanced analytics</li>
                            <li><i class="fas fa-check"></i> Dedicated account manager</li>
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
                <p>Everything you need to know about our SEO services</p>
            </div>
            
            <div class="faq-accordion">
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>How long does it take to see SEO results?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-answer-content">
                            <p>SEO results typically begin showing within 3-6 months, with significant improvements often visible within 6-12 months. However, timeline can vary based on competition, website condition, and target keywords. We provide monthly reports to track progress and adjust strategies as needed.</p>
                        </div>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>Do you guarantee first page rankings?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-answer-content">
                            <p>While we cannot ethically guarantee specific rankings (search engines control this), we do guarantee improved organic traffic, better search visibility, and measurable results. Our proven strategies consistently deliver top rankings for our clients across various industries.</p>
                        </div>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>What's included in your SEO audit?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-answer-content">
                            <p>Our comprehensive SEO audit includes technical SEO analysis, on-page optimization review, content analysis, backlink profile assessment, competitor analysis, keyword research, and site speed evaluation. You'll receive a detailed report with prioritized recommendations.</p>
                        </div>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>Do you work with local businesses?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-answer-content">
                            <p>Yes! We specialize in local SEO for businesses targeting local customers. Our local SEO services include Google My Business optimization, local citations, location-based keyword targeting, and review management to help you dominate local search results.</p>
                        </div>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>Can you help with content creation?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-answer-content">
                            <p>Absolutely! Our content strategy includes creating SEO-optimized blog posts, landing pages, and website content. We research relevant topics, target appropriate keywords, and create engaging content that both search engines and users love.</p>
                        </div>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>How do you measure SEO success?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-answer-content">
                            <p>We track multiple KPIs including organic traffic growth, keyword rankings, conversion rates, click-through rates, bounce rate improvements, and ultimately, revenue impact. Monthly reports provide clear insights into your SEO performance and ROI.</p>
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
            <p>Explore other services that complement your SEO strategy</p>
        </div>
        
        <div class="related-grid">
            <a href="{{ route('website-development') }}" class="related-card">
                <div class="related-icon">
                    <i class="fas fa-globe"></i>
                </div>
                <h4>Website Development</h4>
                <p>SEO-optimized websites built for search engine success</p>
            </a>
            
            <a href="{{ route('brand-positioning') }}" class="related-card">
                <div class="related-icon">
                    <i class="fas fa-bullhorn"></i>
                </div>
                <h4>Brand Positioning</h4>
                <p>Build brand authority that supports your SEO efforts</p>
            </a>
            
            <a href="{{ route('mobile-app-design') }}" class="related-card">
                <div class="related-icon">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <h4>Mobile App Development</h4>
                <p>Mobile-first solutions that complement your SEO strategy</p>
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
        /* SEO Strategies Section Styles */
        .strategies-section {
            background: #f8f9fa;
            padding: 80px 20px;
        }
        
        .strategies-container {
            max-width: 1400px;
            margin: 0 auto;
        }
        
        .strategies-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            margin-top: 50px;
        }
        
        .strategy-card {
            background: white;
            padding: 35px;
            border-radius: 15px;
            text-align: center;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        
        .strategy-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border-color: #ff2200;
        }
        
        .strategy-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #ff2200, #ff6b00);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }
        
        .strategy-icon i {
            font-size: 32px;
            color: white;
        }
        
        .strategy-card h3 {
            font-size: 22px;
            font-weight: 800;
            margin-bottom: 15px;
            color: #1a1a1a;
        }
        
        .strategy-card p {
            font-size: 16px;
            line-height: 1.6;
            color: #666;
            margin: 0;
        }
    </style>
</x-layouts.frontend>
