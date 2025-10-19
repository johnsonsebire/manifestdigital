<x-layouts.frontend
    title="Cloud Computing | Manifest Digital"
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
                <li class="breadcrumb-item active">Cloud Computing</li>
            </ol>
        </div>
    </nav>

    <!-- Service Hero Section -->
    <section class="service-hero">
        <div class="hero-container">
            <div class="service-hero-content">
                <h1>Enterprise Cloud Computing Solutions & Infrastructure Services</h1>
                <p>Comprehensive cloud computing solutions designed to modernize your infrastructure, reduce operational costs, enhance scalability, and enable seamless digital transformation for sustainable business growth.</p>
                
                <div class="hero-stats">
                    <div class="stat-item">
                        <span class="stat-number">300+</span>
                        <span class="stat-label">Cloud Migrations</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">40%</span>
                        <span class="stat-label">Average Cost Savings</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">99.9%</span>
                        <span class="stat-label">Uptime Guarantee</span>
                    </div>
                </div>
                
                <div class="hero-actions">
                    <a href="{{ route('book-a-call') }}" class="btn-primary">Start Migration</a>
                    <a href="{{ route('projects') }}" class="btn-secondary">View Case Studies</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Service Overview -->
    <section class="service-overview">
        <div class="overview-container">
            <div class="overview-content">
                <h2>Transform Your Business with Cloud Technology</h2>
                <p>At Manifest Digital, we specialize in delivering enterprise-grade cloud computing solutions that drive digital transformation. Our comprehensive cloud services enable organizations to leverage the power of AWS, Azure, and Google Cloud platforms for enhanced performance, scalability, and cost-effectiveness.</p>
                <p>From cloud migration and infrastructure management to DevOps implementation and cloud security, we provide end-to-end cloud solutions that align with your business objectives and accelerate your journey to the cloud.</p>
            </div>
        </div>
    </section>

    <!-- Cloud Services Section -->
    <section class="features-section">
        <div class="features-container">
            <div class="section-title">
                <h2>Our Cloud Computing Services</h2>
                <p>Comprehensive cloud solutions for digital transformation and business growth</p>
            </div>
            
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-cloud-upload-alt"></i>
                    </div>
                    <h3>Cloud Migration</h3>
                    <p>Seamless migration of applications, data, and infrastructure to cloud platforms with minimal downtime and comprehensive risk mitigation strategies.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-server"></i>
                    </div>
                    <h3>Infrastructure Management</h3>
                    <p>Complete cloud infrastructure management including provisioning, monitoring, optimization, and maintenance of cloud resources and services.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3>Cloud Security</h3>
                    <p>Comprehensive cloud security solutions including identity management, data encryption, compliance monitoring, and threat protection across all cloud environments.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-code-branch"></i>
                    </div>
                    <h3>DevOps & CI/CD</h3>
                    <p>DevOps implementation with continuous integration and deployment pipelines, automation tools, and infrastructure as code for rapid, reliable software delivery.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3>Cost Optimization</h3>
                    <p>Cloud cost optimization services including resource rightsizing, usage monitoring, reserved instance planning, and cost governance strategies.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-database"></i>
                    </div>
                    <h3>Data & Analytics</h3>
                    <p>Cloud-based data platforms, data lakes, analytics solutions, and business intelligence tools to unlock insights from your data.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Cloud Platforms Section -->
    <section class="platforms-section">
        <div class="platforms-container">
            <div class="section-title">
                <h2>Cloud Platforms We Support</h2>
                <p>Expert services across leading cloud platforms and technologies</p>
            </div>
            
            <div class="platforms-grid">
                <div class="platform-card">
                    <div class="platform-icon">
                        <i class="fab fa-aws"></i>
                    </div>
                    <h3>Amazon Web Services</h3>
                    <p>Comprehensive AWS services including EC2, S3, RDS, Lambda, and advanced AWS solutions.</p>
                </div>
                
                <div class="platform-card">
                    <div class="platform-icon">
                        <i class="fab fa-microsoft"></i>
                    </div>
                    <h3>Microsoft Azure</h3>
                    <p>Full Azure stack including virtual machines, storage, databases, and Azure Active Directory.</p>
                </div>
                
                <div class="platform-card">
                    <div class="platform-icon">
                        <i class="fab fa-google"></i>
                    </div>
                    <h3>Google Cloud Platform</h3>
                    <p>GCP services including Compute Engine, Cloud Storage, BigQuery, and AI/ML services.</p>
                </div>
                
                <div class="platform-card">
                    <div class="platform-icon">
                        <i class="fas fa-layer-group"></i>
                    </div>
                    <h3>Multi-Cloud Strategy</h3>
                    <p>Multi-cloud and hybrid cloud solutions that leverage the best of multiple cloud providers.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Process Section -->
    <section class="process-section">
        <div class="section-title">
            <h2>Our Cloud Migration Process</h2>
            <p>A proven methodology for successful cloud transformation</p>
        </div>
        
        <div class="process-timeline">
            <div class="process-step">
                <div class="step-content">
                    <h3>Assessment & Planning</h3>
                    <p>Comprehensive assessment of current infrastructure, applications, and requirements to develop a detailed cloud migration strategy and roadmap.</p>
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
                    <h3>Architecture Design</h3>
                    <p>Design cloud architecture optimized for performance, security, and cost-effectiveness while ensuring scalability and reliability.</p>
                </div>
            </div>
            
            <div class="process-step">
                <div class="step-content">
                    <h3>Migration Execution</h3>
                    <p>Execute phased migration with minimal business disruption, including data migration, application refactoring, and infrastructure deployment.</p>
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
                    <h3>Testing & Validation</h3>
                    <p>Comprehensive testing of migrated systems, performance validation, security verification, and user acceptance testing.</p>
                </div>
            </div>
            
            <div class="process-step">
                <div class="step-content">
                    <h3>Optimization & Support</h3>
                    <p>Ongoing optimization, monitoring, and support to ensure optimal performance, cost-effectiveness, and continuous improvement.</p>
                </div>
                <div class="step-number-wrapper">
                    <div class="step-number">5</div>
                </div>
                <div class="step-spacer"></div>
            </div>
        </div>
    </section>

    <!-- Cloud Technologies Section -->
    <section class="tech-section">
        <div class="tech-container">
            <div class="section-title" style="color: white;">
                <h2>Cloud Technologies & Tools</h2>
                <p>Advanced cloud technologies and DevOps tools for comprehensive solutions</p>
            </div>
            
            <div class="tech-grid">
                <div class="tech-item">
                    <h4>Terraform</h4>
                    <p>Infrastructure as Code</p>
                </div>
                <div class="tech-item">
                    <h4>Kubernetes</h4>
                    <p>Container orchestration</p>
                </div>
                <div class="tech-item">
                    <h4>Docker</h4>
                    <p>Containerization platform</p>
                </div>
                <div class="tech-item">
                    <h4>Jenkins</h4>
                    <p>CI/CD automation</p>
                </div>
                <div class="tech-item">
                    <h4>Prometheus</h4>
                    <p>Monitoring & alerting</p>
                </div>
                <div class="tech-item">
                    <h4>Ansible</h4>
                    <p>Configuration management</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section class="pricing-section">
        <div class="pricing-container">
            <div class="section-title">
                <h2>Cloud Computing Packages</h2>
                <p>Flexible cloud solutions tailored to your business needs and scale</p>
            </div>
            
            <div class="pricing-grid">
                <div class="pricing-card">
                    <div class="pricing-header">
                        <h3>Cloud Migration</h3>
                        <div class="price">
                            <span class="currency">$</span>
                            <span class="amount">5,000</span>
                            <span class="period">Starting Price</span>
                        </div>
                    </div>
                    <div class="pricing-body">
                        <ul class="pricing-features">
                            <li><i class="fas fa-check"></i> Migration assessment</li>
                            <li><i class="fas fa-check"></i> Migration planning</li>
                            <li><i class="fas fa-check"></i> Data migration</li>
                            <li><i class="fas fa-check"></i> Application migration</li>
                            <li><i class="fas fa-check"></i> 30 days support</li>
                        </ul>
                        <a href="{{ route('book-a-call') }}" class="pricing-btn">Get Started</a>
                    </div>
                </div>
                
                <div class="pricing-card popular">
                    <div class="popular-badge">Most Popular</div>
                    <div class="pricing-header">
                        <h3>Managed Cloud</h3>
                        <div class="price">
                            <span class="currency">$</span>
                            <span class="amount">3,500</span>
                            <span class="period">Per Month</span>
                        </div>
                    </div>
                    <div class="pricing-body">
                        <ul class="pricing-features">
                            <li><i class="fas fa-check"></i> Infrastructure management</li>
                            <li><i class="fas fa-check"></i> 24/7 monitoring</li>
                            <li><i class="fas fa-check"></i> Security management</li>
                            <li><i class="fas fa-check"></i> Cost optimization</li>
                            <li><i class="fas fa-check"></i> Performance tuning</li>
                            <li><i class="fas fa-check"></i> Backup & recovery</li>
                        </ul>
                        <a href="{{ route('book-a-call') }}" class="pricing-btn">Get Started</a>
                    </div>
                </div>
                
                <div class="pricing-card">
                    <div class="pricing-header">
                        <h3>Enterprise Cloud</h3>
                        <div class="price">
                            <span class="currency">$</span>
                            <span class="amount">8,000</span>
                            <span class="period">Per Month</span>
                        </div>
                    </div>
                    <div class="pricing-body">
                        <ul class="pricing-features">
                            <li><i class="fas fa-check"></i> Everything in Managed</li>
                            <li><i class="fas fa-check"></i> Multi-cloud strategy</li>
                            <li><i class="fas fa-check"></i> DevOps implementation</li>
                            <li><i class="fas fa-check"></i> Advanced analytics</li>
                            <li><i class="fas fa-check"></i> Compliance management</li>
                            <li><i class="fas fa-check"></i> Dedicated cloud architect</li>
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
                <p>Everything you need to know about our cloud computing services</p>
            </div>
            
            <div class="faq-accordion">
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>Which cloud platform should I choose for my business?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-answer-content">
                            <p>The choice depends on your specific requirements, existing technology stack, compliance needs, and business objectives. We conduct thorough assessments to recommend the best platform(s) - whether AWS, Azure, Google Cloud, or a multi-cloud approach.</p>
                        </div>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>How long does cloud migration take?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-answer-content">
                            <p>Migration timelines vary based on complexity and scope. Simple applications may migrate in 2-4 weeks, while enterprise migrations can take 3-12 months. We use phased approaches to minimize business disruption and provide detailed timelines during planning.</p>
                        </div>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>How much can I save by moving to the cloud?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-answer-content">
                            <p>Organizations typically save 20-40% on infrastructure costs through cloud migration. Savings come from reduced hardware costs, improved efficiency, better resource utilization, and elimination of on-premises maintenance. We provide detailed cost analysis and ROI projections.</p>
                        </div>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>Is my data secure in the cloud?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-answer-content">
                            <p>Yes, cloud platforms provide enterprise-grade security often superior to on-premises solutions. We implement comprehensive security measures including encryption, access controls, monitoring, and compliance frameworks to protect your data and applications.</p>
                        </div>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>Do you provide ongoing cloud management?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-answer-content">
                            <p>Yes, we offer comprehensive managed cloud services including 24/7 monitoring, performance optimization, security management, cost optimization, backup management, and ongoing support to ensure optimal cloud performance.</p>
                        </div>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>Can you help with regulatory compliance in the cloud?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-answer-content">
                            <p>Absolutely! We have extensive experience with compliance frameworks including GDPR, HIPAA, SOC 2, ISO 27001, and industry-specific regulations. We ensure your cloud infrastructure meets all required compliance standards and maintains audit readiness.</p>
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
            <p>Explore other services that complement your cloud computing strategy</p>
        </div>
        
        <div class="related-grid">
            <a href="{{ route('cyber-security') }}" class="related-card">
                <div class="related-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h4>Cyber Security</h4>
                <p>Advanced security solutions for cloud environments</p>
            </a>
            
            <a href="{{ route('website-development') }}" class="related-card">
                <div class="related-icon">
                    <i class="fas fa-globe"></i>
                </div>
                <h4>Website Development</h4>
                <p>Cloud-native web applications and scalable solutions</p>
            </a>
            
            <a href="{{ route('qa-testing') }}" class="related-card">
                <div class="related-icon">
                    <i class="fas fa-bug"></i>
                </div>
                <h4>QA Testing</h4>
                <p>Cloud application testing and quality assurance</p>
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
        /* Cloud Platforms Section Styles */
        .platforms-section {
            background: #f8f9fa;
            padding: 80px 20px;
        }
        
        .platforms-container {
            max-width: 1400px;
            margin: 0 auto;
        }
        
        .platforms-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            margin-top: 50px;
        }
        
        .platform-card {
            background: white;
            padding: 35px;
            border-radius: 15px;
            text-align: center;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        
        .platform-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border-color: #ff2200;
        }
        
        .platform-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #ff2200, #ff6b00);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }
        
        .platform-icon i {
            font-size: 32px;
            color: white;
        }
        
        .platform-card h3 {
            font-size: 22px;
            font-weight: 800;
            margin-bottom: 15px;
            color: #1a1a1a;
        }
        
        .platform-card p {
            font-size: 16px;
            line-height: 1.6;
            color: #666;
            margin: 0;
        }
    </style>
</x-layouts.frontend>
