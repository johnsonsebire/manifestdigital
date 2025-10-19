<x-layouts.frontend
    title="SAP Consulting Services | Manifest Digital"
    :transparent-header="false"
    preloader="advanced"
    notificationStyle="detailed">
    
    @push('styles')
    @vite('resources/css/sap-consulting.css')
    @endpush 

    <!-- Breadcrumb Navigation -->
    <nav class="breadcrumb-nav">
        <div class="breadcrumb-container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('solutions') }}">Solutions</a></li>
                <li class="breadcrumb-item active">SAP Consulting</li>
            </ol>
        </div>
    </nav>

    <!-- Service Hero Section -->
    <section class="service-hero">
        <div class="hero-container">
            <div class="service-hero-content">
                <h1>Improve Business Outcomes with Proven SAP Solutions</h1>
                <p>Expert SAP consulting services to optimize your business processes, implement robust ERP systems, and maximize your technology investment with business-oriented solutions.</p>
                
                <div class="hero-stats">
                    <div class="stat-item">
                        <span class="stat-number">50+</span>
                        <span class="stat-label">SAP Projects</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">10+</span>
                        <span class="stat-label">Years SAP Experience</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">95%</span>
                        <span class="stat-label">Success Rate</span>
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
                <h2>Transform Your Business with SAP Excellence</h2>
                <p>At Manifest Digital, we provide comprehensive SAP consulting services designed to improve your business outcomes through proven SAP solutions. Our experienced team specializes in SAP implementation, system integration, and business process optimization.</p>
                <p>Whether you need custom ERP systems, SAP PI/PO integration, or business-oriented consultation, we deliver solutions that streamline your operations, enhance productivity, and drive sustainable growth across your organization.</p>
            </div>
        </div>
    </section>

    <!-- Key Features Section -->
    <section class="features-section">
        <div class="features-container">
            <div class="section-title">
                <h2>Our SAP Services</h2>
                <p>Comprehensive SAP solutions tailored to your business requirements</p>
            </div>
            
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-cogs"></i>
                    </div>
                    <h3>SAP PI/PO Integration</h3>
                    <p>Expert SAP Process Integration and Process Orchestration services to connect your systems seamlessly and enable efficient data flow across your enterprise.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <h3>Custom ERP Systems</h3>
                    <p>Tailored ERP solutions built on SAP foundations to meet your specific business requirements and industry needs with scalable architecture.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3>Business-Oriented Consultation</h3>
                    <p>Strategic SAP consulting focused on business outcomes, process optimization, and maximizing ROI from your SAP investments.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-database"></i>
                    </div>
                    <h3>SAP Implementation</h3>
                    <p>Full-cycle SAP implementation services from planning and design to deployment and go-live support, ensuring smooth project delivery.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-sync-alt"></i>
                    </div>
                    <h3>System Migration</h3>
                    <p>Seamless migration from legacy systems to SAP platforms with minimal business disruption and comprehensive data integrity assurance.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-users-cog"></i>
                    </div>
                    <h3>Training & Support</h3>
                    <p>Comprehensive user training programs and ongoing support services to ensure your team maximizes the benefits of your SAP investment.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- SAP Modules Section -->
    <section class="modules-section">
        <div class="modules-container">
            <div class="section-title">
                <h2>SAP Modules We Specialize In</h2>
                <p>Expert knowledge across core SAP business modules</p>
            </div>
            
            <div class="modules-grid">
                <div class="module-card">
                    <div class="module-icon">
                        <i class="fas fa-coins"></i>
                    </div>
                    <h3>SAP FI/CO</h3>
                    <p>Financial Accounting & Controlling</p>
                </div>
                
                <div class="module-card">
                    <div class="module-icon">
                        <i class="fas fa-shipping-fast"></i>
                    </div>
                    <h3>SAP SD</h3>
                    <p>Sales & Distribution</p>
                </div>
                
                <div class="module-card">
                    <div class="module-icon">
                        <i class="fas fa-industry"></i>
                    </div>
                    <h3>SAP MM</h3>
                    <p>Materials Management</p>
                </div>
                
                <div class="module-card">
                    <div class="module-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>SAP HCM</h3>
                    <p>Human Capital Management</p>
                </div>
                
                <div class="module-card">
                    <div class="module-icon">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <h3>SAP BI/BW</h3>
                    <p>Business Intelligence & Data Warehouse</p>
                </div>
                
                <div class="module-card">
                    <div class="module-icon">
                        <i class="fas fa-exchange-alt"></i>
                    </div>
                    <h3>SAP PI/PO</h3>
                    <p>Process Integration & Orchestration</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Process Section -->
    <section class="process-section">
        <div class="section-title">
            <h2>Our SAP Implementation Process</h2>
            <p>A proven methodology for successful SAP deployments</p>
        </div>
        
        <div class="process-timeline">
            <div class="process-step">
                <div class="step-content">
                    <h3>Assessment & Planning</h3>
                    <p>Comprehensive analysis of your current systems, business processes, and requirements to develop a tailored SAP implementation strategy.</p>
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
                    <h3>System Design & Architecture</h3>
                    <p>Design optimal SAP architecture and system landscape that aligns with your business objectives and technical requirements.</p>
                </div>
            </div>
            
            <div class="process-step">
                <div class="step-content">
                    <h3>Configuration & Development</h3>
                    <p>Configure SAP modules and develop custom solutions, integrations, and enhancements to meet your specific business needs.</p>
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
                    <p>Rigorous testing including unit, integration, and user acceptance testing to ensure system stability and business process compliance.</p>
                </div>
            </div>
            
            <div class="process-step">
                <div class="step-content">
                    <h3>Go-Live & Support</h3>
                    <p>Managed go-live process with comprehensive cutover support and ongoing maintenance to ensure smooth operations and optimal performance.</p>
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
                <h2>SAP Technologies & Platforms</h2>
                <p>Expertise across the complete SAP ecosystem</p>
            </div>
            
            <div class="tech-grid">
                <div class="tech-item">
                    <h4>SAP S/4HANA</h4>
                    <p>Next-generation ERP suite</p>
                </div>
                <div class="tech-item">
                    <h4>SAP ECC</h4>
                    <p>Core ERP platform</p>
                </div>
                <div class="tech-item">
                    <h4>SAP HANA</h4>
                    <p>In-memory database platform</p>
                </div>
                <div class="tech-item">
                    <h4>SAP Cloud</h4>
                    <p>Cloud-based solutions</p>
                </div>
                <div class="tech-item">
                    <h4>SAP Fiori</h4>
                    <p>Modern user experience</p>
                </div>
                <div class="tech-item">
                    <h4>ABAP</h4>
                    <p>Custom development</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section class="pricing-section">
        <div class="pricing-container">
            <div class="section-title">
                <h2>SAP Consulting Packages</h2>
                <p>Flexible engagement models to suit your project needs</p>
            </div>
            
            <div class="pricing-grid">
                <div class="pricing-card">
                    <div class="pricing-header">
                        <h3>SAP Assessment</h3>
                        <div class="price">
                            <span class="currency">$</span>
                            <span class="amount">5,000</span>
                            <span class="period">Starting from</span>
                        </div>
                    </div>
                    <div class="pricing-body">
                        <ul class="pricing-features">
                            <li><i class="fas fa-check"></i> Current system analysis</li>
                            <li><i class="fas fa-check"></i> Business process review</li>
                            <li><i class="fas fa-check"></i> Gap analysis report</li>
                            <li><i class="fas fa-check"></i> Recommendations</li>
                            <li><i class="fas fa-check"></i> Implementation roadmap</li>
                        </ul>
                        <a href="{{ route('book-a-call') }}" class="pricing-btn">Get Started</a>
                    </div>
                </div>
                
                <div class="pricing-card popular">
                    <div class="popular-badge">Most Popular</div>
                    <div class="pricing-header">
                        <h3>SAP Implementation</h3>
                        <div class="price">
                            <span class="currency">$</span>
                            <span class="amount">50,000</span>
                            <span class="period">Starting from</span>
                        </div>
                    </div>
                    <div class="pricing-body">
                        <ul class="pricing-features">
                            <li><i class="fas fa-check"></i> Full SAP implementation</li>
                            <li><i class="fas fa-check"></i> System configuration</li>
                            <li><i class="fas fa-check"></i> Data migration</li>
                            <li><i class="fas fa-check"></i> User training</li>
                            <li><i class="fas fa-check"></i> Go-live support</li>
                            <li><i class="fas fa-check"></i> 6 months support</li>
                        </ul>
                        <a href="{{ route('book-a-call') }}" class="pricing-btn">Get Started</a>
                    </div>
                </div>
                
                <div class="pricing-card">
                    <div class="pricing-header">
                        <h3>SAP Enterprise</h3>
                        <div class="price">
                            <span class="currency">$</span>
                            <span class="amount">150,000</span>
                            <span class="period">Starting from</span>
                        </div>
                    </div>
                    <div class="pricing-body">
                        <ul class="pricing-features">
                            <li><i class="fas fa-check"></i> Enterprise-wide deployment</li>
                            <li><i class="fas fa-check"></i> Custom development</li>
                            <li><i class="fas fa-check"></i> System integrations</li>
                            <li><i class="fas fa-check"></i> Advanced reporting</li>
                            <li><i class="fas fa-check"></i> Multi-location rollout</li>
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
                <p>Everything you need to know about our SAP consulting services</p>
            </div>
            
            <div class="faq-accordion">
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>How long does a typical SAP implementation take?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-answer-content">
                            <p>SAP implementation timelines vary based on project scope and complexity. A basic single-module implementation typically takes 6-9 months, while comprehensive multi-module deployments can take 12-18 months. We provide detailed project timelines during the assessment phase.</p>
                        </div>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>Do we need to replace our existing systems entirely?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-answer-content">
                            <p>Not necessarily. We can implement SAP modules gradually or integrate SAP with your existing systems through our SAP PI/PO expertise. Our assessment will determine the best approach for your specific situation and business requirements.</p>
                        </div>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>What training and support do you provide?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-answer-content">
                            <p>We provide comprehensive user training programs, administrator training, and end-user documentation. Our support includes go-live assistance, post-implementation support, and ongoing maintenance to ensure your team can effectively use the SAP system.</p>
                        </div>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>Can you help with SAP S/4HANA migration?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-answer-content">
                            <p>Yes, we specialize in SAP S/4HANA migration projects. We help organizations transition from SAP ECC to S/4HANA with comprehensive migration strategies, including system conversion, new implementation, and selective data transition approaches.</p>
                        </div>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>Do you provide custom SAP development?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-answer-content">
                            <p>Absolutely! Our team includes certified ABAP developers who can create custom reports, interfaces, conversions, enhancements, forms, and workflows (RICEF objects) to extend SAP functionality according to your business requirements.</p>
                        </div>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>What industries do you have SAP experience in?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-answer-content">
                            <p>We have SAP implementation experience across manufacturing, retail, healthcare, financial services, oil & gas, utilities, and public sector organizations. Our industry expertise helps us configure SAP solutions that align with sector-specific requirements and best practices.</p>
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
            <p>Explore other services that complement your SAP consulting project</p>
        </div>
        
        <div class="related-grid">
            <a href="{{ route('cloud-computing') }}" class="related-card">
                <div class="related-icon">
                    <i class="fas fa-cloud"></i>
                </div>
                <h4>Cloud Computing</h4>
                <p>SAP cloud hosting and migration services</p>
            </a>
            
            <a href="{{ route('qa-testing') }}" class="related-card">
                <div class="related-icon">
                    <i class="fas fa-bug"></i>
                </div>
                <h4>QA Testing</h4>
                <p>Comprehensive SAP system testing services</p>
            </a>
            
            <a href="{{ route('it-training') }}" class="related-card">
                <div class="related-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h4>IT Training</h4>
                <p>SAP user and administrator training programs</p>
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
        /* SAP Modules Section Styles */
        .modules-section {
            background: #f8f9fa;
            padding: 80px 20px;
        }
        
        .modules-container {
            max-width: 1400px;
            margin: 0 auto;
        }
        
        .modules-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin-top: 50px;
        }
        
        .module-card {
            background: white;
            padding: 30px;
            border-radius: 12px;
            text-align: center;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        
        .module-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            border-color: #ff2200;
        }
        
        .module-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #ff2200, #ff6b00);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
        }
        
        .module-icon i {
            font-size: 22px;
            color: white;
        }
        
        .module-card h3 {
            font-size: 18px;
            font-weight: 800;
            margin-bottom: 8px;
            color: #1a1a1a;
        }
        
        .module-card p {
            font-size: 14px;
            color: #666;
            margin: 0;
        }
    </style>
</x-layouts.frontend>
