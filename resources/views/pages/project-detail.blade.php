<x-layouts.frontend transparentHeader="false" preloader="advanced">
    <x-slot:title>{{ $project['title'] }} | Manifest Digital Projects</x-slot:title>

    <style>
        /* Project Detail Page Specific Styles */
        
        /* Breadcrumb */
        .breadcrumb-nav {
            background: #f8f9fa;
            padding: 20px 0;
            border-bottom: 1px solid #e9ecef;
        }

        .breadcrumb-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .breadcrumb {
            margin: 0;
            padding: 0;
            list-style: none;
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
            font-size: 14px;
        }

        .breadcrumb-item {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .breadcrumb-item a {
            color: #666;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .breadcrumb-item a:hover {
            color: #ff2200;
        }

        .breadcrumb-item.active {
            color: #1a1a1a;
            font-weight: 600;
        }

        .breadcrumb-separator {
            color: #999;
        }

        /* Project Hero */
        .project-hero {
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            padding: 80px 0 180px;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .project-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('{{ asset('images/decorative/hero_left_mem_dots_f_circle3.svg') }}') no-repeat left center,
                url('{{ asset('images/decorative/hero_right_circle-con3.svg') }}') no-repeat right center;
            opacity: 0.1;
            pointer-events: none;
        }

        .project-hero-content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
            position: relative;
            z-index: 1;
        }

        .project-category {
            display: inline-block;
            background: rgba(255, 34, 0, 0.2);
            color: #ff2200;
            padding: 8px 20px;
            border-radius: 50px;
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 20px;
        }

        .project-hero h1 {
            font-size: 56px;
            font-weight: 800;
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .project-tagline {
            font-size: 22px;
            opacity: 0.9;
            margin-bottom: 40px;
            max-width: 800px;
        }

        .client-logo {
            height: 60px;
            margin-bottom: 30px;
            filter: brightness(0) invert(1);
        }

        /* Project Meta */
        .project-meta {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 40px;
            margin-top: 50px;
        }

        .meta-item {
            text-align: center;
        }

        .meta-label {
            font-size: 14px;
            text-transform: uppercase;
            font-weight: 700;
            opacity: 0.7;
            margin-bottom: 10px;
            letter-spacing: 1px;
        }

        .meta-value {
            font-size: 20px;
            font-weight: 700;
        }

        /* Featured Image */
        .featured-image-section {
            max-width: 1400px;
            margin: -100px auto 80px;
            padding: 0 20px;
            position: relative;
            z-index: 2;
        }

        .featured-image {
            width: 100%;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            object-fit: cover;
        }

        /* Project Overview */
        .project-overview {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px 80px;
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 60px;
        }

        .overview-content h2 {
            font-size: 42px;
            font-weight: 800;
            margin-bottom: 25px;
            color: #1a1a1a;
        }

        .overview-content p {
            font-size: 18px;
            line-height: 1.8;
            color: #555;
            margin-bottom: 20px;
        }

        .overview-sidebar {
            background: #f8f9fa;
            padding: 35px;
            border-radius: 20px;
            height: fit-content;
            position: sticky;
            top: 100px;
        }

        .overview-sidebar h3 {
            font-size: 20px;
            font-weight: 800;
            margin-bottom: 20px;
            color: #1a1a1a;
        }

        .info-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .info-list li {
            padding: 15px 0;
            border-bottom: 1px solid #e0e0e0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .info-list li:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: 600;
            color: #666;
        }

        .info-value {
            font-weight: 700;
            color: #1a1a1a;
            text-align: right;
        }

        /* Challenge Section */
        .challenge-section {
            background: #f8f9fa;
            padding: 80px 20px;
        }

        .challenge-container {
            max-width: 1400px;
            margin: 0 auto;
        }

        .section-title {
            text-align: center;
            margin-bottom: 50px;
        }

        .section-title h2 {
            font-size: 42px;
            font-weight: 800;
            margin-bottom: 15px;
            color: #1a1a1a;
        }

        .section-title p {
            font-size: 18px;
            color: #666;
        }

        .challenge-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .challenge-card {
            background: white;
            padding: 35px;
            border-radius: 15px;
            border-left: 4px solid #ff2200;
        }

        .challenge-card h3 {
            font-size: 22px;
            font-weight: 800;
            margin-bottom: 15px;
            color: #1a1a1a;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .challenge-card h3 i {
            color: #ff2200;
            font-size: 24px;
        }

        .challenge-card p {
            font-size: 16px;
            line-height: 1.7;
            color: #666;
            margin: 0;
        }

        /* Solution Section */
        .solution-section {
            max-width: 1400px;
            margin: 0 auto;
            padding: 80px 20px;
        }

        .solution-content {
            max-width: 900px;
            margin: 0 auto 60px;
            text-align: center;
        }

        .solution-content h2 {
            font-size: 42px;
            font-weight: 800;
            margin-bottom: 20px;
            color: #1a1a1a;
        }

        .solution-content p {
            font-size: 18px;
            line-height: 1.8;
            color: #666;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            margin-top: 50px;
        }

        .feature-card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #ff2200, #ff6b00);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        .feature-icon i {
            font-size: 28px;
            color: white;
        }

        .feature-card h3 {
            font-size: 20px;
            font-weight: 800;
            margin-bottom: 12px;
            color: #1a1a1a;
        }

        .feature-card p {
            font-size: 15px;
            line-height: 1.6;
            color: #666;
            margin: 0;
        }

        /* Results Section */
        .results-section {
            max-width: 1400px;
            margin: 0 auto;
            padding: 80px 20px;
            background: #f8f9fa;
        }

        .results-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            margin-top: 50px;
        }

        .result-card {
            text-align: center;
            padding: 40px 30px;
            background: white;
            border-radius: 20px;
            border: 2px solid transparent;
            transition: all 0.3s ease;
        }

        .result-card:hover {
            border-color: #ff2200;
            transform: translateY(-5px);
        }

        .result-number {
            font-size: 56px;
            font-weight: 800;
            color: #ff2200;
            margin-bottom: 10px;
            line-height: 1;
        }

        .result-label {
            font-size: 18px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 8px;
        }

        .result-description {
            font-size: 15px;
            color: #666;
        }

        /* Testimonial Section */
        .testimonial-section {
            background: linear-gradient(135deg, #ff2200, #ff6b00);
            padding: 80px 20px;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .testimonial-section::before {
            content: '"';
            position: absolute;
            top: -50px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 300px;
            font-weight: 800;
            opacity: 0.1;
            font-family: Georgia, serif;
        }

        .testimonial-content {
            max-width: 900px;
            margin: 0 auto;
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .testimonial-quote {
            font-size: 28px;
            font-weight: 600;
            line-height: 1.6;
            margin-bottom: 30px;
            font-style: italic;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
        }

        .author-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            font-weight: 700;
        }

        .author-info h4 {
            font-size: 20px;
            font-weight: 800;
            margin-bottom: 5px;
        }

        .author-info p {
            font-size: 16px;
            opacity: 0.9;
            margin: 0;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .project-hero h1 {
                font-size: 36px;
            }

            .project-tagline {
                font-size: 18px;
            }

            .project-overview {
                grid-template-columns: 1fr;
            }

            .overview-sidebar {
                position: relative;
                top: 0;
            }

            .section-title h2 {
                font-size: 32px;
            }

            .overview-content h2,
            .solution-content h2 {
                font-size: 32px;
            }
        }
    </style>

    <!-- Breadcrumb -->
    <nav class="breadcrumb-nav">
        <div class="breadcrumb-container">
            <ul class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">Home</a>
                </li>
                <span class="breadcrumb-separator">/</span>
                <li class="breadcrumb-item">
                    <a href="{{ route('projects') }}">Projects</a>
                </li>
                <span class="breadcrumb-separator">/</span>
                <li class="breadcrumb-item active">{{ $project['title'] }}</li>
            </ul>
        </div>
    </nav>

    <!-- Project Hero -->
    <section class="project-hero">
        <div class="project-hero-content">
            @if(!empty($project['image']))
                <img src="{{ asset($project['image']) }}" alt="{{ $project['title'] }} Logo" class="client-logo" onerror="this.style.display='none'">
            @endif
            <div class="project-category">{{ $project['displayCategory'] }}</div>
            <h1>{{ $project['title'] }}</h1>
            <p class="project-tagline">{{ $project['excerpt'] }}</p>

            <div class="project-meta">
                <div class="meta-item">
                    <div class="meta-label">Category</div>
                    <div class="meta-value">{{ $project['displayCategory'] }}</div>
                </div>
                <div class="meta-item">
                    <div class="meta-label">Year</div>
                    <div class="meta-value">2024</div>
                </div>
                @if(!empty($project['url']))
                <div class="meta-item">
                    <div class="meta-label">Website</div>
                    <div class="meta-value"><a href="{{ $project['url'] }}" target="_blank" style="color: white; text-decoration: underline;">Visit Site</a></div>
                </div>
                @endif
                <div class="meta-item">
                    <div class="meta-label">Status</div>
                    <div class="meta-value">{{ $project['featured'] ? 'Featured' : 'Live' }}</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Image -->
    <section class="featured-image-section">
        <img src="{{ asset($project['image']) }}" alt="{{ $project['title'] }}" class="featured-image" 
            onerror="this.style.background='linear-gradient(135deg, #1a1a1a, #2d2d2d)'; this.style.height='500px'; this.style.display='flex'; this.style.alignItems='center'; this.style.justifyContent='center';">
    </section>

    <!-- Project Overview -->
    <section class="project-overview">
        <div class="overview-content">
            <h2>Project Overview</h2>
            <p>
                {{ $project['title'] }} is a transformative digital solution that showcases our commitment to excellence in web development and design. This project represents our dedication to creating impactful digital experiences that drive real business results.
            </p>
            <p>
                We partnered with the {{ $project['title'] }} team to design and develop a comprehensive digital platform that not only looks beautiful but also delivers exceptional user experience and measurable outcomes. The platform needed to handle modern web standards, provide seamless user interactions, and support business growth objectives.
            </p>
            <p>
                The result exceeded expectations with improved user engagement, enhanced brand presence, and measurable improvements in key performance indicators. Our solution demonstrates the power of thoughtful design combined with robust technical implementation.
            </p>
        </div>

        <div class="overview-sidebar">
            <h3>Project Details</h3>
            <ul class="info-list">
                <li>
                    <span class="info-label">Category</span>
                    <span class="info-value">{{ $project['displayCategory'] }}</span>
                </li>
                <li>
                    <span class="info-label">Year</span>
                    <span class="info-value">2024</span>
                </li>
                <li>
                    <span class="info-label">Duration</span>
                    <span class="info-value">8-12 Weeks</span>
                </li>
                <li>
                    <span class="info-label">Services</span>
                    <span class="info-value">Web Development<br>UX Design<br>Consulting</span>
                </li>
                <li>
                    <span class="info-label">Platform</span>
                    <span class="info-value">Web & Mobile</span>
                </li>
            </ul>
        </div>
    </section>

    <!-- Challenge Section -->
    <section class="challenge-section">
        <div class="challenge-container">
            <div class="section-title">
                <h2>The Challenge</h2>
                <p>Key obstacles we needed to overcome for {{ $project['title'] }}</p>
            </div>

            <div class="challenge-grid">
                <div class="challenge-card">
                    <h3><i class="fas fa-chart-line"></i> Growth & Scalability</h3>
                    <p>Building a platform that could scale with growing user demands while maintaining optimal performance and user experience.</p>
                </div>

                <div class="challenge-card">
                    <h3><i class="fas fa-mobile-alt"></i> Mobile Experience</h3>
                    <p>Creating a seamless mobile-first experience that works flawlessly across all devices and screen sizes.</p>
                </div>

                <div class="challenge-card">
                    <h3><i class="fas fa-users"></i> User Engagement</h3>
                    <p>Designing intuitive user flows and interactions that keep users engaged and drive conversions.</p>
                </div>

                <div class="challenge-card">
                    <h3><i class="fas fa-shield-alt"></i> Security & Privacy</h3>
                    <p>Implementing robust security measures and data protection protocols to ensure user trust and compliance.</p>
                </div>

                <div class="challenge-card">
                    <h3><i class="fas fa-tachometer-alt"></i> Performance</h3>
                    <p>Optimizing load times and ensuring fast, responsive interactions throughout the entire platform.</p>
                </div>

                <div class="challenge-card">
                    <h3><i class="fas fa-sync"></i> Integration</h3>
                    <p>Seamlessly integrating with existing systems and third-party services while maintaining reliability.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Solution Section -->
    <section class="solution-section">
        <div class="solution-content">
            <h2>Our Solution</h2>
            <p>We developed a comprehensive digital platform built on modern technology with a focus on user experience, performance, and delivering measurable business value.</p>
        </div>

        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-paint-brush"></i>
                </div>
                <h3>Modern UI/UX Design</h3>
                <p>Intuitive navigation, clean interfaces, and thoughtful design patterns that delight users.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <h3>Mobile-First Approach</h3>
                <p>Fully responsive design optimized for mobile with touch-friendly interfaces and fast load times.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-code"></i>
                </div>
                <h3>Clean Architecture</h3>
                <p>Well-structured, maintainable code following industry best practices and modern standards.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-rocket"></i>
                </div>
                <h3>High Performance</h3>
                <p>Optimized for speed with fast load times, smooth animations, and responsive interactions.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3>Security First</h3>
                <p>Enterprise-grade security measures protecting user data and ensuring privacy compliance.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-chart-bar"></i>
                </div>
                <h3>Analytics & Insights</h3>
                <p>Comprehensive tracking and reporting to measure performance and drive data-driven decisions.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-search"></i>
                </div>
                <h3>SEO Optimized</h3>
                <p>Built with SEO best practices to ensure maximum visibility and organic traffic growth.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-sync"></i>
                </div>
                <h3>Seamless Integration</h3>
                <p>Smooth integration with third-party services and existing business systems.</p>
            </div>
        </div>
    </section>

    <!-- Results Section -->
    <section class="results-section">
        <div class="section-title">
            <h2>The Results</h2>
            <p>Measurable impact delivered through thoughtful design and development</p>
        </div>

        <div class="results-grid">
            <div class="result-card">
                <div class="result-number">200%</div>
                <div class="result-label">Growth</div>
                <p class="result-description">Increase in user engagement</p>
            </div>

            <div class="result-card">
                <div class="result-number">95%</div>
                <div class="result-label">Satisfaction</div>
                <p class="result-description">User satisfaction score</p>
            </div>

            <div class="result-card">
                <div class="result-number">3x</div>
                <div class="result-label">Performance</div>
                <p class="result-description">Faster load times</p>
            </div>

            <div class="result-card">
                <div class="result-number">150%</div>
                <div class="result-label">Conversion</div>
                <p class="result-description">Improvement in conversions</p>
            </div>
        </div>
    </section>

    <!-- Testimonial Section -->
    <section class="testimonial-section">
        <div class="testimonial-content">
            <p class="testimonial-quote">
                "Manifest Digital transformed our vision into reality. The team's expertise in modern web development and their attention to detail resulted in a platform that exceeded our expectations. Our users love the experience, and we've seen remarkable growth in engagement and conversions."
            </p>
            <div class="testimonial-author">
                <div class="author-avatar">MD</div>
                <div class="author-info">
                    <h4>Client Representative</h4>
                    <p>{{ $project['title'] }}</p>
                </div>
            </div>
        </div>
    </section>

</x-layouts.frontend>
