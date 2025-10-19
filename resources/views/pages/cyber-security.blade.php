<x-layouts.frontend
    title="Cyber Security | Manifest Digital"
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
                <li class="breadcrumb-item active">Cyber Security</li>
            </ol>
        </div>
    </nav>

    <!-- Service Hero Section -->
    <section class="service-hero">
        <div class="hero-container">
            <div class="service-hero-content">
                <h1>Enterprise Cybersecurity Solutions & Digital Protection Services</h1>
                <p>Comprehensive cybersecurity solutions designed to protect your business from digital threats, ensure data privacy, maintain regulatory compliance, and safeguard your organization's critical assets from cyber attacks.</p>
                
                <div class="hero-stats">
                    <div class="stat-item">
                        <span class="stat-number">200+</span>
                        <span class="stat-label">Organizations Protected</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">99.9%</span>
                        <span class="stat-label">Threat Prevention Rate</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">24/7</span>
                        <span class="stat-label">Security Monitoring</span>
                    </div>
                </div>
                
                <div class="hero-actions">
                    <a href="{{ route('book-a-call') }}" class="btn-primary">Get Protected</a>
                    <a href="{{ route('projects') }}" class="btn-secondary">Security Audit</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Service Overview -->
    <section class="service-overview">
        <div class="overview-container">
            <div class="overview-content">
                <h2>Protect Your Business from Evolving Cyber Threats</h2>
                <p>At Manifest Digital, we understand that cybersecurity is not just an IT concern—it's a business imperative. Our comprehensive cybersecurity solutions are designed to protect your organization from sophisticated cyber threats while ensuring business continuity and regulatory compliance.</p>
                <p>From threat assessment and vulnerability management to incident response and security awareness training, we provide end-to-end cybersecurity services that adapt to your business needs and evolving threat landscape.</p>
            </div>
        </div>
    </section>

    <!-- Security Services Section -->
    <section class="features-section">
        <div class="features-container">
            <div class="section-title">
                <h2>Our Cybersecurity Services</h2>
                <p>Comprehensive security solutions to protect your digital assets</p>
            </div>
            
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <h3>Security Assessments</h3>
                    <p>Comprehensive security assessments including vulnerability testing, risk analysis, and security posture evaluation to identify and prioritize security gaps.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3>Penetration Testing</h3>
                    <p>Ethical hacking and penetration testing services to simulate real-world attacks and identify vulnerabilities before malicious actors can exploit them.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-eye"></i>
                    </div>
                    <h3>Security Monitoring</h3>
                    <p>24/7 security monitoring and threat detection using advanced SIEM solutions, AI-powered analytics, and expert security analysts.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-ambulance"></i>
                    </div>
                    <h3>Incident Response</h3>
                    <p>Rapid incident response services including threat containment, forensic analysis, recovery planning, and post-incident security improvements.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h3>Security Training</h3>
                    <p>Comprehensive cybersecurity awareness training programs for employees, including phishing simulation, security best practices, and compliance training.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h3>Compliance Management</h3>
                    <p>Regulatory compliance services for GDPR, ISO 27001, SOC 2, HIPAA, and other industry standards with ongoing compliance monitoring and reporting.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Security Solutions Section -->
    <section class="solutions-section">
        <div class="solutions-container">
            <div class="section-title">
                <h2>Advanced Security Solutions</h2>
                <p>Cutting-edge technologies for comprehensive cyber protection</p>
            </div>
            
            <div class="solutions-grid">
                <div class="solution-card">
                    <div class="solution-icon">
                        <i class="fas fa-lock"></i>
                    </div>
                    <h3>Data Encryption</h3>
                    <p>Advanced encryption solutions for data at rest, in transit, and in use to protect sensitive information.</p>
                </div>
                
                <div class="solution-card">
                    <div class="solution-icon">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <h3>Identity Management</h3>
                    <p>Comprehensive identity and access management solutions including multi-factor authentication and privileged access management.</p>
                </div>
                
                <div class="solution-card">
                    <div class="solution-icon">
                        <i class="fas fa-network-wired"></i>
                    </div>
                    <h3>Network Security</h3>
                    <p>Network security solutions including firewalls, intrusion detection systems, and network segmentation strategies.</p>
                </div>
                
                <div class="solution-card">
                    <div class="solution-icon">
                        <i class="fas fa-cloud-upload-alt"></i>
                    </div>
                    <h3>Cloud Security</h3>
                    <p>Cloud security architecture, configuration management, and continuous monitoring for AWS, Azure, and Google Cloud platforms.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Process Section -->
    <section class="process-section">
        <div class="section-title">
            <h2>Our Cybersecurity Process</h2>
            <p>A systematic approach to protecting your organization from cyber threats</p>
        </div>
        
        <div class="process-timeline">
            <div class="process-step">
                <div class="step-content">
                    <h3>Security Assessment</h3>
                    <p>Comprehensive evaluation of your current security posture, identification of vulnerabilities, and risk assessment across all systems and processes.</p>
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
                    <h3>Security Strategy</h3>
                    <p>Development of customized security strategy and roadmap aligned with your business objectives, compliance requirements, and risk tolerance.</p>
                </div>
            </div>
            
            <div class="process-step">
                <div class="step-content">
                    <h3>Implementation</h3>
                    <p>Deployment of security controls, technologies, and processes including employee training, policy development, and technical implementations.</p>
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
                    <h3>Monitoring & Response</h3>
                    <p>Continuous security monitoring, threat detection, incident response, and proactive threat hunting to maintain security posture.</p>
                </div>
            </div>
            
            <div class="process-step">
                <div class="step-content">
                    <h3>Continuous Improvement</h3>
                    <p>Regular security reviews, updates to security controls, threat intelligence integration, and adaptation to emerging threats and technologies.</p>
                </div>
                <div class="step-number-wrapper">
                    <div class="step-number">5</div>
                </div>
                <div class="step-spacer"></div>
            </div>
        </div>
    </section>

    <!-- Security Technologies Section -->
    <section class="tech-section">
        <div class="tech-container">
            <div class="section-title" style="color: white;">
                <h2>Security Technologies & Tools</h2>
                <p>Enterprise-grade security tools and technologies for comprehensive protection</p>
            </div>
            
            <div class="tech-grid">
                <div class="tech-item">
                    <h4>Splunk SIEM</h4>
                    <p>Security monitoring & analytics</p>
                </div>
                <div class="tech-item">
                    <h4>CrowdStrike</h4>
                    <p>Endpoint protection platform</p>
                </div>
                <div class="tech-item">
                    <h4>Palo Alto</h4>
                    <p>Next-gen firewall solutions</p>
                </div>
                <div class="tech-item">
                    <h4>Okta</h4>
                    <p>Identity & access management</p>
                </div>
                <div class="tech-item">
                    <h4>Nessus</h4>
                    <p>Vulnerability scanning</p>
                </div>
                <div class="tech-item">
                    <h4>Metasploit</h4>
                    <p>Penetration testing</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section class="pricing-section">
        <div class="pricing-container">
            <div class="section-title">
                <h2>Cybersecurity Service Packages</h2>
                <p>Flexible security solutions to match your organization's needs and budget</p>
            </div>
            
            <div class="pricing-grid">
                <div class="pricing-card">
                    <div class="pricing-header">
                        <h3>Security Essentials</h3>
                        <div class="price">
                            <span class="currency">$</span>
                            <span class="amount">2,500</span>
                            <span class="period">Per Month</span>
                        </div>
                    </div>
                    <div class="pricing-body">
                        <ul class="pricing-features">
                            <li><i class="fas fa-check"></i> Security assessment</li>
                            <li><i class="fas fa-check"></i> Basic monitoring</li>
                            <li><i class="fas fa-check"></i> Employee training</li>
                            <li><i class="fas fa-check"></i> Incident response</li>
                            <li><i class="fas fa-check"></i> Monthly reporting</li>
                        </ul>
                        <a href="{{ route('book-a-call') }}" class="pricing-btn">Get Started</a>
                    </div>
                </div>
                
                <div class="pricing-card popular">
                    <div class="popular-badge">Most Popular</div>
                    <div class="pricing-header">
                        <h3>Security Professional</h3>
                        <div class="price">
                            <span class="currency">$</span>
                            <span class="amount">5,000</span>
                            <span class="period">Per Month</span>
                        </div>
                    </div>
                    <div class="pricing-body">
                        <ul class="pricing-features">
                            <li><i class="fas fa-check"></i> Everything in Essentials</li>
                            <li><i class="fas fa-check"></i> 24/7 monitoring</li>
                            <li><i class="fas fa-check"></i> Penetration testing</li>
                            <li><i class="fas fa-check"></i> Compliance management</li>
                            <li><i class="fas fa-check"></i> Advanced threat detection</li>
                            <li><i class="fas fa-check"></i> Dedicated security analyst</li>
                        </ul>
                        <a href="{{ route('book-a-call') }}" class="pricing-btn">Get Started</a>
                    </div>
                </div>
                
                <div class="pricing-card">
                    <div class="pricing-header">
                        <h3>Enterprise Security</h3>
                        <div class="price">
                            <span class="currency">$</span>
                            <span class="amount">10,000</span>
                            <span class="period">Per Month</span>
                        </div>
                    </div>
                    <div class="pricing-body">
                        <ul class="pricing-features">
                            <li><i class="fas fa-check"></i> Everything in Professional</li>
                            <li><i class="fas fa-check"></i> Custom security solutions</li>
                            <li><i class="fas fa-check"></i> Red team exercises</li>
                            <li><i class="fas fa-check"></i> Security architecture</li>
                            <li><i class="fas fa-check"></i> Advanced compliance</li>
                            <li><i class="fas fa-check"></i> Dedicated security team</li>
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
                <p>Everything you need to know about our cybersecurity services</p>
            </div>
            
            <div class="faq-accordion">
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>What types of security threats do you protect against?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-answer-content">
                            <p>We protect against a wide range of cyber threats including malware, ransomware, phishing attacks, advanced persistent threats (APTs), insider threats, DDoS attacks, and social engineering. Our solutions adapt to emerging threats and zero-day vulnerabilities.</p>
                        </div>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>How quickly can you respond to security incidents?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-answer-content">
                            <p>Our incident response team provides 24/7 coverage with initial response within 15 minutes for critical incidents. We have rapid containment procedures and can deploy on-site security experts within 4 hours for major incidents requiring immediate attention.</p>
                        </div>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>Do you help with regulatory compliance?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-answer-content">
                            <p>Yes, we provide comprehensive compliance services for GDPR, ISO 27001, SOC 2, HIPAA, PCI DSS, and other industry standards. We help with compliance assessments, gap analysis, remediation planning, and ongoing compliance monitoring.</p>
                        </div>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>What industries do you serve?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-answer-content">
                            <p>We serve various industries including healthcare, financial services, manufacturing, retail, government, education, and technology. Our security solutions are tailored to meet industry-specific compliance requirements and threat landscapes.</p>
                        </div>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>How do you ensure business continuity during security incidents?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-answer-content">
                            <p>We develop comprehensive business continuity and disaster recovery plans, maintain backup systems, and implement incident response procedures that minimize business disruption. Our goal is to contain threats while maintaining critical business operations.</p>
                        </div>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>What ongoing security services do you provide?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-answer-content">
                            <p>Our ongoing services include 24/7 security monitoring, regular vulnerability assessments, security awareness training, patch management, threat intelligence updates, security policy reviews, and continuous improvement of security posture.</p>
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
            <p>Explore other services that complement your cybersecurity strategy</p>
        </div>
        
        <div class="related-grid">
            <a href="{{ route('qa-testing') }}" class="related-card">
                <div class="related-icon">
                    <i class="fas fa-bug"></i>
                </div>
                <h4>QA Testing</h4>
                <p>Security testing and vulnerability assessment services</p>
            </a>
            
            <a href="{{ route('blockchain-solutions') }}" class="related-card">
                <div class="related-icon">
                    <i class="fas fa-link"></i>
                </div>
                <h4>Blockchain Solutions</h4>
                <p>Secure blockchain applications with advanced cryptography</p>
            </a>
            
            <a href="{{ route('cloud-computing') }}" class="related-card">
                <div class="related-icon">
                    <i class="fas fa-cloud"></i>
                </div>
                <h4>Cloud Computing</h4>
                <p>Secure cloud infrastructure and data protection</p>
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
        /* Security Solutions Section Styles */
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
