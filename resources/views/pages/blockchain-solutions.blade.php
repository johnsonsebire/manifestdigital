<x-layouts.frontend
    title="Blockchain Solutions | Manifest Digital"
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
                <li class="breadcrumb-item active">Blockchain Solutions</li>
            </ol>
        </div>
    </nav>

    <!-- Service Hero Section -->
    <section class="service-hero">
        <div class="hero-container">
            <div class="service-hero-content">
                <h1>Revolutionary Blockchain Development & Cryptocurrency Solutions</h1>
                <p>Cutting-edge blockchain solutions that leverage distributed ledger technology to enhance security, transparency, and efficiency in your business operations while creating new opportunities for digital transformation.</p>
                
                <div class="hero-stats">
                    <div class="stat-item">
                        <span class="stat-number">50+</span>
                        <span class="stat-label">Blockchain Projects</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">15+</span>
                        <span class="stat-label">Smart Contracts Deployed</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">99.9%</span>
                        <span class="stat-label">Security Standard</span>
                    </div>
                </div>
                
                <div class="hero-actions">
                    <a href="{{ route('book-a-call') }}" class="btn-primary">Get Started</a>
                    <a href="{{ route('projects') }}" class="btn-secondary">View Projects</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Service Overview -->
    <section class="service-overview">
        <div class="overview-container">
            <div class="overview-content">
                <h2>Transform Your Business with Blockchain Technology</h2>
                <p>At Manifest Digital, we specialize in developing innovative blockchain solutions that solve real-world business challenges. Our expertise spans across smart contract development, decentralized applications, cryptocurrency solutions, and blockchain consulting.</p>
                <p>From supply chain transparency to secure digital transactions, we help businesses leverage the power of distributed ledger technology to create trust, eliminate intermediaries, and unlock new revenue streams.</p>
            </div>
        </div>
    </section>

    <!-- Blockchain Services Section -->
    <section class="features-section">
        <div class="features-container">
            <div class="section-title">
                <h2>Our Blockchain Services</h2>
                <p>Comprehensive blockchain development and consultation services</p>
            </div>
            
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-file-contract"></i>
                    </div>
                    <h3>Smart Contract Development</h3>
                    <p>Custom smart contracts built on Ethereum, Binance Smart Chain, and other platforms to automate business processes and ensure transparent execution.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-coins"></i>
                    </div>
                    <h3>Cryptocurrency Solutions</h3>
                    <p>Complete cryptocurrency development including token creation, ICO/STO platforms, wallet development, and cryptocurrency exchange solutions.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-network-wired"></i>
                    </div>
                    <h3>Decentralized Applications (DApps)</h3>
                    <p>Full-stack DApp development with intuitive user interfaces, smart contract integration, and seamless blockchain connectivity.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3>Blockchain Consulting</h3>
                    <p>Strategic blockchain consulting to identify opportunities, assess feasibility, and develop implementation roadmaps for your business.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shipping-fast"></i>
                    </div>
                    <h3>Supply Chain Solutions</h3>
                    <p>Blockchain-powered supply chain tracking systems that provide end-to-end transparency, traceability, and authenticity verification.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3>Blockchain Security</h3>
                    <p>Comprehensive security audits, smart contract testing, and security consulting to ensure your blockchain solutions are protected against threats.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Blockchain Platforms Section -->
    <section class="platforms-section">
        <div class="platforms-container">
            <div class="section-title">
                <h2>Blockchain Platforms We Work With</h2>
                <p>Expertise across leading blockchain networks and protocols</p>
            </div>
            
            <div class="platforms-grid">
                <div class="platform-card">
                    <div class="platform-icon">
                        <i class="fab fa-ethereum"></i>
                    </div>
                    <h3>Ethereum</h3>
                    <p>Smart contracts and DApps on the world's leading smart contract platform.</p>
                </div>
                
                <div class="platform-card">
                    <div class="platform-icon">
                        <i class="fas fa-link"></i>
                    </div>
                    <h3>Binance Smart Chain</h3>
                    <p>Fast and low-cost blockchain solutions with Ethereum compatibility.</p>
                </div>
                
                <div class="platform-card">
                    <div class="platform-icon">
                        <i class="fas fa-cube"></i>
                    </div>
                    <h3>Polygon</h3>
                    <p>Scalable blockchain solutions with faster transactions and lower fees.</p>
                </div>
                
                <div class="platform-card">
                    <div class="platform-icon">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <h3>Solana</h3>
                    <p>High-performance blockchain for large-scale decentralized applications.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Process Section -->
    <section class="process-section">
        <div class="section-title">
            <h2>Our Blockchain Development Process</h2>
            <p>A systematic approach to delivering secure and scalable blockchain solutions</p>
        </div>
        
        <div class="process-timeline">
            <div class="process-step">
                <div class="step-content">
                    <h3>Discovery & Analysis</h3>
                    <p>Comprehensive analysis of your business requirements, blockchain feasibility assessment, and technology stack selection.</p>
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
                    <p>Design blockchain architecture, smart contract specifications, and system integration plans aligned with your business objectives.</p>
                </div>
            </div>
            
            <div class="process-step">
                <div class="step-content">
                    <h3>Development & Testing</h3>
                    <p>Develop smart contracts, build DApps, and conduct comprehensive testing including security audits and performance optimization.</p>
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
                    <h3>Deployment & Integration</h3>
                    <p>Deploy blockchain solutions to production networks, integrate with existing systems, and ensure seamless operation.</p>
                </div>
            </div>
            
            <div class="process-step">
                <div class="step-content">
                    <h3>Maintenance & Support</h3>
                    <p>Ongoing monitoring, maintenance, security updates, and technical support to ensure optimal performance and security.</p>
                </div>
                <div class="step-number-wrapper">
                    <div class="step-number">5</div>
                </div>
                <div class="step-spacer"></div>
            </div>
        </div>
    </section>

    <!-- Blockchain Technologies Section -->
    <section class="tech-section">
        <div class="tech-container">
            <div class="section-title" style="color: white;">
                <h2>Blockchain Technologies & Tools</h2>
                <p>Cutting-edge tools and frameworks for blockchain development</p>
            </div>
            
            <div class="tech-grid">
                <div class="tech-item">
                    <h4>Solidity</h4>
                    <p>Smart contract programming</p>
                </div>
                <div class="tech-item">
                    <h4>Web3.js</h4>
                    <p>Blockchain interaction library</p>
                </div>
                <div class="tech-item">
                    <h4>Truffle</h4>
                    <p>Development framework</p>
                </div>
                <div class="tech-item">
                    <h4>MetaMask</h4>
                    <p>Wallet integration</p>
                </div>
                <div class="tech-item">
                    <h4>IPFS</h4>
                    <p>Decentralized storage</p>
                </div>
                <div class="tech-item">
                    <h4>OpenZeppelin</h4>
                    <p>Security standards</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section class="pricing-section">
        <div class="pricing-container">
            <div class="section-title">
                <h2>Blockchain Development Packages</h2>
                <p>Flexible blockchain solutions for different project needs and budgets</p>
            </div>
            
            <div class="pricing-grid">
                <div class="pricing-card">
                    <div class="pricing-header">
                        <h3>Smart Contract</h3>
                        <div class="price">
                            <span class="currency">$</span>
                            <span class="amount">3,000</span>
                            <span class="period">Per Contract</span>
                        </div>
                    </div>
                    <div class="pricing-body">
                        <ul class="pricing-features">
                            <li><i class="fas fa-check"></i> Custom smart contract</li>
                            <li><i class="fas fa-check"></i> Security audit</li>
                            <li><i class="fas fa-check"></i> Testing & deployment</li>
                            <li><i class="fas fa-check"></i> Documentation</li>
                            <li><i class="fas fa-check"></i> Basic support</li>
                        </ul>
                        <a href="{{ route('book-a-call') }}" class="pricing-btn">Get Started</a>
                    </div>
                </div>
                
                <div class="pricing-card popular">
                    <div class="popular-badge">Most Popular</div>
                    <div class="pricing-header">
                        <h3>DApp Development</h3>
                        <div class="price">
                            <span class="currency">$</span>
                            <span class="amount">15,000</span>
                            <span class="period">Per Project</span>
                        </div>
                    </div>
                    <div class="pricing-body">
                        <ul class="pricing-features">
                            <li><i class="fas fa-check"></i> Full DApp development</li>
                            <li><i class="fas fa-check"></i> Smart contract integration</li>
                            <li><i class="fas fa-check"></i> Frontend development</li>
                            <li><i class="fas fa-check"></i> Wallet integration</li>
                            <li><i class="fas fa-check"></i> Security testing</li>
                            <li><i class="fas fa-check"></i> 3 months support</li>
                        </ul>
                        <a href="{{ route('book-a-call') }}" class="pricing-btn">Get Started</a>
                    </div>
                </div>
                
                <div class="pricing-card">
                    <div class="pricing-header">
                        <h3>Enterprise Blockchain</h3>
                        <div class="price">
                            <span class="currency">$</span>
                            <span class="amount">50,000</span>
                            <span class="period">Starting Price</span>
                        </div>
                    </div>
                    <div class="pricing-body">
                        <ul class="pricing-features">
                            <li><i class="fas fa-check"></i> Custom blockchain solution</li>
                            <li><i class="fas fa-check"></i> Multi-platform development</li>
                            <li><i class="fas fa-check"></i> System integration</li>
                            <li><i class="fas fa-check"></i> Advanced security</li>
                            <li><i class="fas fa-check"></i> Ongoing maintenance</li>
                            <li><i class="fas fa-check"></i> Dedicated team</li>
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
                <p>Everything you need to know about our blockchain services</p>
            </div>
            
            <div class="faq-accordion">
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>What blockchain platforms do you specialize in?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-answer-content">
                            <p>We specialize in Ethereum, Binance Smart Chain, Polygon, Solana, and other leading blockchain platforms. Our expertise covers smart contract development, DApp creation, and custom blockchain solutions across multiple networks.</p>
                        </div>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>How long does blockchain development take?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-answer-content">
                            <p>Development timelines vary based on complexity. Simple smart contracts may take 2-4 weeks, while full DApps typically require 3-6 months. Enterprise blockchain solutions can take 6-12 months depending on requirements and integrations.</p>
                        </div>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>Do you provide blockchain consulting services?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-answer-content">
                            <p>Yes, we offer comprehensive blockchain consulting including feasibility analysis, technology selection, implementation strategy, and regulatory compliance guidance. We help businesses identify blockchain opportunities and create implementation roadmaps.</p>
                        </div>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>How do you ensure blockchain security?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-answer-content">
                            <p>We implement rigorous security practices including comprehensive code audits, smart contract testing, vulnerability assessments, and following industry best practices. We also conduct third-party security audits for critical applications.</p>
                        </div>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>Can you integrate blockchain with existing systems?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-answer-content">
                            <p>Absolutely! We specialize in integrating blockchain solutions with existing enterprise systems, databases, and applications. We ensure seamless data flow and maintain compatibility with your current technology stack.</p>
                        </div>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>What support do you provide after deployment?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-answer-content">
                            <p>We provide ongoing support including monitoring, maintenance, security updates, performance optimization, and technical assistance. Our support packages are tailored to your specific needs and can include 24/7 monitoring for critical applications.</p>
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
            <p>Explore other services that complement your blockchain development</p>
        </div>
        
        <div class="related-grid">
            <a href="{{ route('cyber-security') }}" class="related-card">
                <div class="related-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h4>Cyber Security</h4>
                <p>Advanced security solutions for blockchain applications</p>
            </a>
            
            <a href="{{ route('website-development') }}" class="related-card">
                <div class="related-icon">
                    <i class="fas fa-globe"></i>
                </div>
                <h4>Website Development</h4>
                <p>Web interfaces for blockchain and DApp integration</p>
            </a>
            
            <a href="{{ route('mobile-app-design') }}" class="related-card">
                <div class="related-icon">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <h4>Mobile App Development</h4>
                <p>Mobile applications with blockchain connectivity</p>
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
        /* Blockchain Platforms Section Styles */
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
