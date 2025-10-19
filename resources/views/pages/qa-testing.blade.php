<x-layouts.frontend
    title="QA Testing | Manifest Digital"
    :transparent-header="false"
    preloader="advanced"
    notificationStyle="detailed">
    
    <style>
        @import url("{{ asset('css/service-detail.css') }}");
    </style>

    <!-- Breadcrumb Navigation -->
    <nav class="breadcrumb-nav">
        <div class="breadcrumb-container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('solutions') }}">Solutions</a></li>
                <li class="breadcrumb-item active">QA Testing</li>
            </ol>
        </div>
    </nav>

    <!-- Service Hero Section -->
    <section class="service-hero">
        <div class="hero-container">
            <div class="service-hero-content">
                <h1>Professional Quality Assurance & Testing Services</h1>
                <p>Comprehensive QA testing services that ensure your software applications are reliable, secure, and deliver exceptional user experiences across all platforms and devices.</p>
                
                <div class="hero-stats">
                    <div class="stat-item">
                        <span class="stat-number">500+</span>
                        <span class="stat-label">Applications Tested</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">99%</span>
                        <span class="stat-label">Bug Detection Rate</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">24/7</span>
                        <span class="stat-label">Testing Support</span>
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
                <h2>Ensure Quality, Reliability & User Satisfaction</h2>
                <p>At Manifest Digital, we understand that quality assurance is critical to your software's success. Our comprehensive QA testing services are designed to identify and eliminate bugs, performance issues, and security vulnerabilities before your application reaches end users.</p>
                <p>From manual testing to automated test suites, we provide thorough quality assurance that ensures your software meets the highest standards of functionality, usability, and reliability across all platforms and devices.</p>
            </div>
        </div>
    </section>

    <!-- Testing Services Section -->
    <section class="features-section">
        <div class="features-container">
            <div class="section-title">
                <h2>Our QA Testing Services</h2>
                <p>Comprehensive testing solutions for all your quality assurance needs</p>
            </div>
            
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-hand-pointer"></i>
                    </div>
                    <h3>Manual Testing</h3>
                    <p>Comprehensive manual testing including functional testing, usability testing, exploratory testing, and user acceptance testing to ensure optimal user experience.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-robot"></i>
                    </div>
                    <h3>Automated Testing</h3>
                    <p>Advanced test automation using industry-leading tools to create reliable, repeatable test suites for regression testing and continuous integration pipelines.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-tachometer-alt"></i>
                    </div>
                    <h3>Performance Testing</h3>
                    <p>Load testing, stress testing, and performance optimization to ensure your application performs well under various conditions and user loads.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3>Security Testing</h3>
                    <p>Comprehensive security assessments including vulnerability testing, penetration testing, and security code reviews to protect against threats.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h3>Mobile Testing</h3>
                    <p>Specialized mobile application testing across iOS and Android devices, including device compatibility, performance, and user interface testing.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-sync-alt"></i>
                    </div>
                    <h3>Regression Testing</h3>
                    <p>Continuous regression testing to ensure new features and updates don't break existing functionality, maintaining software stability.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testing Types Section -->
    <section class="testing-types-section">
        <div class="testing-container">
            <div class="section-title">
                <h2>Testing Methodologies</h2>
                <p>Advanced testing approaches for comprehensive quality assurance</p>
            </div>
            
            <div class="testing-grid">
                <div class="testing-card">
                    <div class="testing-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h3>Functional Testing</h3>
                    <p>Verify that all features work according to specifications and business requirements.</p>
                </div>
                
                <div class="testing-card">
                    <div class="testing-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>Usability Testing</h3>
                    <p>Evaluate user experience and interface design to ensure intuitive navigation and functionality.</p>
                </div>
                
                <div class="testing-card">
                    <div class="testing-icon">
                        <i class="fas fa-database"></i>
                    </div>
                    <h3>API Testing</h3>
                    <p>Test application programming interfaces for functionality, reliability, and data exchange.</p>
                </div>
                
                <div class="testing-card">
                    <div class="testing-icon">
                        <i class="fas fa-globe"></i>
                    </div>
                    <h3>Cross-Browser Testing</h3>
                    <p>Ensure consistent functionality and appearance across different browsers and platforms.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Process Section -->
    <section class="process-section">
        <div class="section-title">
            <h2>Our QA Testing Process</h2>
            <p>A systematic approach to ensuring comprehensive quality assurance</p>
        </div>
        
        <div class="process-timeline">
            <div class="process-step">
                <div class="step-content">
                    <h3>Requirements Analysis</h3>
                    <p>Thorough analysis of project requirements, specifications, and acceptance criteria to develop comprehensive test strategies.</p>
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
                    <h3>Test Planning</h3>
                    <p>Create detailed test plans, test cases, and testing schedules aligned with project timelines and quality objectives.</p>
                </div>
            </div>
            
            <div class="process-step">
                <div class="step-content">
                    <h3>Test Environment Setup</h3>
                    <p>Establish proper testing environments, configure test data, and set up automation frameworks for efficient testing.</p>
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
                    <h3>Test Execution</h3>
                    <p>Execute comprehensive testing including functional, performance, security, and compatibility testing across all target platforms.</p>
                </div>
            </div>
            
            <div class="process-step">
                <div class="step-content">
                    <h3>Reporting & Validation</h3>
                    <p>Document findings, track bug resolution, and validate fixes to ensure all quality standards are met before release.</p>
                </div>
                <div class="step-number-wrapper">
                    <div class="step-number">5</div>
                </div>
                <div class="step-spacer"></div>
            </div>
        </div>
    </section>

    <!-- Testing Tools Section -->
    <section class="tech-section">
        <div class="tech-container">
            <div class="section-title" style="color: white;">
                <h2>Testing Tools & Technologies</h2>
                <p>Industry-leading tools for comprehensive quality assurance</p>
            </div>
            
            <div class="tech-grid">
                <div class="tech-item">
                    <h4>Selenium</h4>
                    <p>Web automation testing</p>
                </div>
                <div class="tech-item">
                    <h4>Jest & Cypress</h4>
                    <p>JavaScript testing frameworks</p>
                </div>
                <div class="tech-item">
                    <h4>JMeter</h4>
                    <p>Performance & load testing</p>
                </div>
                <div class="tech-item">
                    <h4>Postman</h4>
                    <p>API testing & validation</p>
                </div>
                <div class="tech-item">
                    <h4>TestRail</h4>
                    <p>Test case management</p>
                </div>
                <div class="tech-item">
                    <h4>Appium</h4>
                    <p>Mobile app testing</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section class="pricing-section">
        <div class="pricing-container">
            <div class="section-title">
                <h2>QA Testing Packages</h2>
                <p>Flexible testing solutions to match your project needs and timeline</p>
            </div>
            
            <div class="pricing-grid">
                <div class="pricing-card">
                    <div class="pricing-header">
                        <h3>Basic QA</h3>
                        <div class="price">
                            <span class="currency">$</span>
                            <span class="amount">1,200</span>
                            <span class="period">Per Project</span>
                        </div>
                    </div>
                    <div class="pricing-body">
                        <ul class="pricing-features">
                            <li><i class="fas fa-check"></i> Manual testing</li>
                            <li><i class="fas fa-check"></i> Functional testing</li>
                            <li><i class="fas fa-check"></i> Cross-browser testing</li>
                            <li><i class="fas fa-check"></i> Bug reporting</li>
                            <li><i class="fas fa-check"></i> Test documentation</li>
                        </ul>
                        <a href="{{ route('book-a-call') }}" class="pricing-btn">Get Started</a>
                    </div>
                </div>
                
                <div class="pricing-card popular">
                    <div class="popular-badge">Most Popular</div>
                    <div class="pricing-header">
                        <h3>Professional QA</h3>
                        <div class="price">
                            <span class="currency">$</span>
                            <span class="amount">2,500</span>
                            <span class="period">Per Project</span>
                        </div>
                    </div>
                    <div class="pricing-body">
                        <ul class="pricing-features">
                            <li><i class="fas fa-check"></i> Everything in Basic</li>
                            <li><i class="fas fa-check"></i> Automated testing</li>
                            <li><i class="fas fa-check"></i> Performance testing</li>
                            <li><i class="fas fa-check"></i> Security testing</li>
                            <li><i class="fas fa-check"></i> Mobile testing</li>
                            <li><i class="fas fa-check"></i> API testing</li>
                        </ul>
                        <a href="{{ route('book-a-call') }}" class="pricing-btn">Get Started</a>
                    </div>
                </div>
                
                <div class="pricing-card">
                    <div class="pricing-header">
                        <h3>Enterprise QA</h3>
                        <div class="price">
                            <span class="currency">$</span>
                            <span class="amount">5,000</span>
                            <span class="period">Per Project</span>
                        </div>
                    </div>
                    <div class="pricing-body">
                        <ul class="pricing-features">
                            <li><i class="fas fa-check"></i> Everything in Professional</li>
                            <li><i class="fas fa-check"></i> Continuous testing</li>
                            <li><i class="fas fa-check"></i> Test automation framework</li>
                            <li><i class="fas fa-check"></i> Advanced security testing</li>
                            <li><i class="fas fa-check"></i> Load & stress testing</li>
                            <li><i class="fas fa-check"></i> Dedicated QA team</li>
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
                <p>Everything you need to know about our QA testing services</p>
            </div>
            
            <div class="faq-accordion">
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>What types of applications do you test?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-answer-content">
                            <p>We test all types of applications including web applications, mobile apps (iOS and Android), desktop software, APIs, e-commerce platforms, and enterprise software. Our testing expertise covers various industries and technology stacks.</p>
                        </div>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>How long does the testing process take?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-answer-content">
                            <p>Testing timelines vary based on project complexity, scope, and requirements. Basic testing typically takes 1-2 weeks, while comprehensive testing for complex applications may take 4-6 weeks. We provide detailed timelines during project planning.</p>
                        </div>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>Do you provide test automation services?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-answer-content">
                            <p>Yes, we specialize in test automation using industry-leading tools like Selenium, Cypress, Jest, and Appium. We create robust automated test suites that can be integrated into your CI/CD pipeline for continuous testing.</p>
                        </div>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>What deliverables do you provide?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-answer-content">
                            <p>We provide comprehensive test plans, detailed test cases, bug reports with severity levels, test execution reports, automated test scripts (if applicable), and final quality assessment reports with recommendations.</p>
                        </div>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>Can you integrate with our development process?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-answer-content">
                            <p>Absolutely! We integrate seamlessly with your development workflow, including Agile/Scrum methodologies, CI/CD pipelines, and project management tools. We adapt our testing process to complement your existing development practices.</p>
                        </div>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>Do you offer ongoing testing support?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-answer-content">
                            <p>Yes, we provide ongoing QA support including regression testing for updates, maintenance of automated test suites, performance monitoring, and continuous testing as part of your development lifecycle.</p>
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
            <p>Explore other services that complement your quality assurance needs</p>
        </div>
        
        <div class="related-grid">
            <a href="{{ route('website-development') }}" class="related-card">
                <div class="related-icon">
                    <i class="fas fa-globe"></i>
                </div>
                <h4>Website Development</h4>
                <p>Quality-focused web development with built-in testing</p>
            </a>
            
            <a href="{{ route('mobile-app-design') }}" class="related-card">
                <div class="related-icon">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <h4>Mobile App Development</h4>
                <p>Mobile applications with comprehensive testing coverage</p>
            </a>
            
            <a href="{{ route('cyber-security') }}" class="related-card">
                <div class="related-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h4>Cyber Security</h4>
                <p>Security testing and vulnerability assessments</p>
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
        /* Testing Types Section Styles */
        .testing-types-section {
            background: #f8f9fa;
            padding: 80px 20px;
        }
        
        .testing-container {
            max-width: 1400px;
            margin: 0 auto;
        }
        
        .testing-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            margin-top: 50px;
        }
        
        .testing-card {
            background: white;
            padding: 35px;
            border-radius: 15px;
            text-align: center;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        
        .testing-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border-color: #ff2200;
        }
        
        .testing-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #ff2200, #ff6b00);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }
        
        .testing-icon i {
            font-size: 32px;
            color: white;
        }
        
        .testing-card h3 {
            font-size: 22px;
            font-weight: 800;
            margin-bottom: 15px;
            color: #1a1a1a;
        }
        
        .testing-card p {
            font-size: 16px;
            line-height: 1.6;
            color: #666;
            margin: 0;
        }
    </style>
</x-layouts.frontend>
