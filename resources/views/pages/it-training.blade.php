<x-layouts.frontend
    title="IT Training Services | Manifest Digital"
    :transparent-header="false"
    preloader="advanced"
    notificationStyle="detailed">
    
    @push('styles')
    @vite('resources/css/it-training.css')
    @endpush

    <!-- Breadcrumb Navigation -->
    <nav class="breadcrumb-nav">
        <div class="breadcrumb-container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('solutions') }}">Solutions</a></li>
                <li class="breadcrumb-item active">IT Training</li>
            </ol>
        </div>
    </nav>

    <!-- Service Hero Section -->
    <section class="service-hero">
        <div class="hero-container">
            <div class="service-hero-content">
                <h1>Best IT Training Provider</h1>
                <p>Comprehensive IT training programs designed to upskill your team and prepare professionals for the rapidly evolving technology landscape with industry-recognized certifications.</p>
                
                <div class="hero-stats">
                    <div class="stat-item">
                        <span class="stat-number">1000+</span>
                        <span class="stat-label">Students Trained</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">15+</span>
                        <span class="stat-label">Certification Programs</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">95%</span>
                        <span class="stat-label">Pass Rate</span>
                    </div>
                </div>
                
                <div class="hero-actions">
                    <a href="{{ route('book-a-call') }}" class="btn-primary">Enroll Now</a>
                    <a href="{{ route('projects') }}" class="btn-secondary">View Programs</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Service Overview -->
    <section class="service-overview">
        <div class="overview-container">
            <div class="overview-content">
                <h2>Empowering Careers Through Quality IT Education</h2>
                <p>At Manifest Digital, we are recognized as the best IT training provider, offering comprehensive programs that combine theoretical knowledge with practical, hands-on experience. Our training programs are designed to meet industry standards and prepare professionals for successful careers in technology.</p>
                <p>Whether you're looking to start a career in IT, advance your current skills, or provide corporate training for your team, we offer flexible learning options including classroom training and online programs to fit your schedule and learning preferences.</p>
            </div>
        </div>
    </section>

    <!-- Certification Programs Section -->
    <section class="certifications-section">
        <div class="certifications-container">
            <div class="section-title">
                <h2>Industry-Recognized Certifications</h2>
                <p>Comprehensive certification programs to advance your IT career</p>
            </div>
            
            <div class="certifications-grid">
                <div class="cert-card">
                    <div class="cert-icon">
                        <i class="fas fa-desktop"></i>
                    </div>
                    <h3>IC3 Certification</h3>
                    <p>Internet and Computing Core Certification covering digital literacy, key applications, and living online skills.</p>
                </div>
                
                <div class="cert-card">
                    <div class="cert-icon">
                        <i class="fab fa-aws"></i>
                    </div>
                    <h3>AWS Certification</h3>
                    <p>Amazon Web Services certification programs including Solutions Architect, Developer, and SysOps Administrator tracks.</p>
                </div>
                
                <div class="cert-card">
                    <div class="cert-icon">
                        <i class="fas fa-project-diagram"></i>
                    </div>
                    <h3>PMP Certification</h3>
                    <p>Project Management Professional certification preparation for advanced project management skills and methodologies.</p>
                </div>
                
                <div class="cert-card">
                    <div class="cert-icon">
                        <i class="fas fa-code"></i>
                    </div>
                    <h3>Web Design & Development</h3>
                    <p>Comprehensive web development training covering HTML, CSS, JavaScript, frameworks, and modern development practices.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Key Features Section -->
    <section class="features-section">
        <div class="features-container">
            <div class="section-title">
                <h2>Why Choose Our IT Training</h2>
                <p>Comprehensive training solutions tailored to your professional development needs</p>
            </div>
            
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <h3>Expert Instructors</h3>
                    <p>Learn from industry professionals with real-world experience and advanced certifications in their respective fields.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-laptop-code"></i>
                    </div>
                    <h3>Hands-On Training</h3>
                    <p>Practical, hands-on exercises and projects that simulate real-world scenarios and build job-ready skills.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-users-class"></i>
                    </div>
                    <h3>Flexible Learning Options</h3>
                    <p>Choose from classroom training, online programs, or hybrid models to fit your schedule and learning preferences.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-certificate"></i>
                    </div>
                    <h3>Industry Certifications</h3>
                    <p>Preparation for globally recognized IT certifications that enhance your career prospects and earning potential.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <h3>Corporate Training</h3>
                    <p>Customized corporate training programs designed to upskill your entire team and meet specific business objectives.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3>Ongoing Support</h3>
                    <p>Continued support and mentoring even after course completion to ensure your success in the field.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Training Delivery Methods Section -->
    <section class="delivery-section">
        <div class="delivery-container">
            <div class="section-title">
                <h2>Training Delivery Methods</h2>
                <p>Flexible learning options to suit your lifestyle and preferences</p>
            </div>
            
            <div class="delivery-grid">
                <div class="delivery-card">
                    <div class="delivery-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>Classroom Training</h3>
                    <p>Traditional face-to-face instruction with direct interaction, group discussions, and collaborative learning experiences.</p>
                </div>
                
                <div class="delivery-card">
                    <div class="delivery-icon">
                        <i class="fas fa-laptop"></i>
                    </div>
                    <h3>Online Programs</h3>
                    <p>Self-paced online learning with access to recorded lectures, interactive modules, and virtual labs from anywhere.</p>
                </div>
                
                <div class="delivery-card">
                    <div class="delivery-icon">
                        <i class="fas fa-blender-phone"></i>
                    </div>
                    <h3>Hybrid Learning</h3>
                    <p>Combination of classroom and online learning for maximum flexibility while maintaining personal interaction.</p>
                </div>
                
                <div class="delivery-card">
                    <div class="delivery-icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <h3>Corporate On-site</h3>
                    <p>Customized training delivered at your company location for teams and enterprise-level skill development.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Process Section -->
    <section class="process-section">
        <div class="section-title">
            <h2>Our Training Process</h2>
            <p>A structured approach to ensure effective learning and certification success</p>
        </div>
        
        <div class="process-timeline">
            <div class="process-step">
                <div class="step-content">
                    <h3>Assessment & Planning</h3>
                    <p>Evaluate your current skill level and career goals to recommend the most suitable training program and learning path.</p>
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
                    <h3>Foundation Learning</h3>
                    <p>Build strong foundational knowledge through structured modules, hands-on exercises, and practical assignments.</p>
                </div>
            </div>
            
            <div class="process-step">
                <div class="step-content">
                    <h3>Practical Application</h3>
                    <p>Apply learned concepts through real-world projects, lab exercises, and scenario-based problem solving.</p>
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
                    <h3>Certification Preparation</h3>
                    <p>Intensive exam preparation including practice tests, review sessions, and focused study on certification objectives.</p>
                </div>
            </div>
            
            <div class="process-step">
                <div class="step-content">
                    <h3>Career Support</h3>
                    <p>Ongoing career guidance, job placement assistance, and continued support to help you succeed in your IT career.</p>
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
                <h2>Technologies We Teach</h2>
                <p>Comprehensive coverage of modern IT technologies and platforms</p>
            </div>
            
            <div class="tech-grid">
                <div class="tech-item">
                    <h4>Cloud Platforms</h4>
                    <p>AWS, Azure, Google Cloud</p>
                </div>
                <div class="tech-item">
                    <h4>Programming</h4>
                    <p>Python, Java, JavaScript</p>
                </div>
                <div class="tech-item">
                    <h4>Web Technologies</h4>
                    <p>HTML, CSS, React, Laravel</p>
                </div>
                <div class="tech-item">
                    <h4>Databases</h4>
                    <p>MySQL, MongoDB, PostgreSQL</p>
                </div>
                <div class="tech-item">
                    <h4>DevOps Tools</h4>
                    <p>Docker, Kubernetes, Jenkins</p>
                </div>
                <div class="tech-item">
                    <h4>Project Management</h4>
                    <p>Agile, Scrum, PMBOK</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section class="pricing-section">
        <div class="pricing-container">
            <div class="section-title">
                <h2>Training Packages</h2>
                <p>Affordable training options for individuals and organizations</p>
            </div>
            
            <div class="pricing-grid">
                <div class="pricing-card">
                    <div class="pricing-header">
                        <h3>Individual Course</h3>
                        <div class="price">
                            <span class="currency">$</span>
                            <span class="amount">500</span>
                            <span class="period">Per Course</span>
                        </div>
                    </div>
                    <div class="pricing-body">
                        <ul class="pricing-features">
                            <li><i class="fas fa-check"></i> Single certification prep</li>
                            <li><i class="fas fa-check"></i> 40+ hours of training</li>
                            <li><i class="fas fa-check"></i> Practice exams</li>
                            <li><i class="fas fa-check"></i> Course materials</li>
                            <li><i class="fas fa-check"></i> 3 months support</li>
                        </ul>
                        <a href="{{ route('book-a-call') }}" class="pricing-btn">Enroll Now</a>
                    </div>
                </div>
                
                <div class="pricing-card popular">
                    <div class="popular-badge">Most Popular</div>
                    <div class="pricing-header">
                        <h3>Professional Bundle</h3>
                        <div class="price">
                            <span class="currency">$</span>
                            <span class="amount">1,500</span>
                            <span class="period">3 Courses</span>
                        </div>
                    </div>
                    <div class="pricing-body">
                        <ul class="pricing-features">
                            <li><i class="fas fa-check"></i> 3 certification programs</li>
                            <li><i class="fas fa-check"></i> 120+ hours of training</li>
                            <li><i class="fas fa-check"></i> Hands-on projects</li>
                            <li><i class="fas fa-check"></i> Career guidance</li>
                            <li><i class="fas fa-check"></i> Job placement assistance</li>
                            <li><i class="fas fa-check"></i> 6 months support</li>
                        </ul>
                        <a href="{{ route('book-a-call') }}" class="pricing-btn">Get Started</a>
                    </div>
                </div>
                
                <div class="pricing-card">
                    <div class="pricing-header">
                        <h3>Corporate Training</h3>
                        <div class="price">
                            <span class="currency">$</span>
                            <span class="amount">5,000</span>
                            <span class="period">Per Team</span>
                        </div>
                    </div>
                    <div class="pricing-body">
                        <ul class="pricing-features">
                            <li><i class="fas fa-check"></i> Customized curriculum</li>
                            <li><i class="fas fa-check"></i> On-site or remote training</li>
                            <li><i class="fas fa-check"></i> Team skill assessment</li>
                            <li><i class="fas fa-check"></i> Progress tracking</li>
                            <li><i class="fas fa-check"></i> Manager dashboards</li>
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
                <p>Everything you need to know about our IT training programs</p>
            </div>
            
            <div class="faq-accordion">
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>What certifications do you offer preparation for?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-answer-content">
                            <p>We offer preparation for IC3, AWS certifications (Solutions Architect, Developer, SysOps), PMP, Web Design & Development, CompTIA, Microsoft Azure, Google Cloud, and many other industry-recognized certifications. Our programs are regularly updated to reflect current industry standards.</p>
                        </div>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>Can I take courses online or do I need to attend in person?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-answer-content">
                            <p>We offer flexible learning options including classroom training, fully online programs, and hybrid models. You can choose the format that best fits your schedule and learning preferences. Online students have access to the same quality instruction and resources as classroom attendees.</p>
                        </div>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>Do you provide job placement assistance?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-answer-content">
                            <p>Yes, we provide comprehensive career support including resume building, interview preparation, job search strategies, and connections with our network of hiring partners. Our goal is to help you successfully transition into or advance in your IT career.</p>
                        </div>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>What is your pass rate for certification exams?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-answer-content">
                            <p>We maintain a 95% pass rate across all our certification programs. This high success rate is achieved through our comprehensive curriculum, experienced instructors, extensive practice exams, and personalized support for each student.</p>
                        </div>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>Do you offer corporate training for teams?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-answer-content">
                            <p>Absolutely! We provide customized corporate training programs that can be delivered on-site at your location or remotely. Our corporate programs include skill assessments, customized curriculum, progress tracking, and dedicated support to meet your organization's specific needs.</p>
                        </div>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>What support do you provide after course completion?</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <div class="faq-answer-content">
                            <p>We provide ongoing support including access to updated course materials, alumni network, continuing education opportunities, career counseling, and technical support. Our commitment to your success extends well beyond course completion.</p>
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
            <p>Explore other services that complement your IT training journey</p>
        </div>
        
        <div class="related-grid">
            <a href="{{ route('sap-consulting') }}" class="related-card">
                <div class="related-icon">
                    <i class="fas fa-cogs"></i>
                </div>
                <h4>SAP Consulting</h4>
                <p>SAP training and implementation services</p>
            </a>
            
            <a href="{{ route('website-development') }}" class="related-card">
                <div class="related-icon">
                    <i class="fas fa-code"></i>
                </div>
                <h4>Website Development</h4>
                <p>Apply your web development skills in real projects</p>
            </a>
            
            <a href="{{ route('cloud-computing') }}" class="related-card">
                <div class="related-icon">
                    <i class="fas fa-cloud"></i>
                </div>
                <h4>Cloud Computing</h4>
                <p>Cloud services and DevOps training programs</p>
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
        /* Certifications Section Styles */
        .certifications-section {
            background: #f8f9fa;
            padding: 80px 20px;
        }
        
        .certifications-container {
            max-width: 1400px;
            margin: 0 auto;
        }
        
        .certifications-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            margin-top: 50px;
        }
        
        .cert-card {
            background: white;
            padding: 35px;
            border-radius: 15px;
            text-align: center;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        
        .cert-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border-color: #ff2200;
        }
        
        .cert-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #ff2200, #ff6b00);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }
        
        .cert-icon i {
            font-size: 32px;
            color: white;
        }
        
        .cert-card h3 {
            font-size: 22px;
            font-weight: 800;
            margin-bottom: 15px;
            color: #1a1a1a;
        }
        
        .cert-card p {
            font-size: 16px;
            line-height: 1.6;
            color: #666;
            margin: 0;
        }

        /* Delivery Methods Section Styles */
        .delivery-section {
            padding: 80px 20px;
        }
        
        .delivery-container {
            max-width: 1400px;
            margin: 0 auto;
        }
        
        .delivery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin-top: 50px;
        }
        
        .delivery-card {
            background: white;
            padding: 30px;
            border-radius: 12px;
            text-align: center;
            transition: all 0.3s ease;
            border: 2px solid #e9ecef;
        }
        
        .delivery-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            border-color: #ff2200;
        }
        
        .delivery-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #ff2200, #ff6b00);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }
        
        .delivery-icon i {
            font-size: 26px;
            color: white;
        }
        
        .delivery-card h3 {
            font-size: 20px;
            font-weight: 800;
            margin-bottom: 12px;
            color: #1a1a1a;
        }
        
        .delivery-card p {
            font-size: 15px;
            line-height: 1.6;
            color: #666;
            margin: 0;
        }
    </style>
</x-layouts.frontend>
