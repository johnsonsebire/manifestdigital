<x-layouts.frontend 
    title="Blog | Latest Insights & Updates - Manifest Digital"
    :transparent-header="false"
    preloader="advanced"
    notificationStyle="dark">

    <style>
        /* Blog Page Specific Styles */
        .blog-hero {
            background: linear-gradient(135deg, rgba(26, 26, 26, 0.95), rgba(45, 45, 45, 0.95)),
                url('{{ asset('images/decorative/hero_top_mem_stripe_circle2.png') }}') no-repeat center;
            background-size: cover;
            padding: 120px 0 80px;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .blog-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 30% 50%, rgba(255, 34, 0, 0.1) 0%, transparent 50%);
        }

        .blog-hero-content {
            position: relative;
            z-index: 1;
            max-width: 800px;
            margin: 0 auto;
        }

        .blog-hero h1 {
            font-size: 64px;
            font-weight: 800;
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .blog-hero p {
            font-size: 20px;
            opacity: 0.9;
            margin-bottom: 0;
        }

        .blog-hero .highlight {
            color: #ff2200;
        }

        /* Blog Filters Section */
        .blog-filters {
            padding: 40px 0;
            background: white;
            border-bottom: 1px solid #eee;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .filters-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .filter-buttons {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .filter-btn {
            padding: 10px 24px;
            background: transparent;
            border: 2px solid #ddd;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            color: #333;
            font-size: 15px;
        }

        .filter-btn:hover,
        .filter-btn.active {
            background: #ff2200;
            border-color: #ff2200;
            color: white;
            transform: translateY(-2px);
        }

        .search-box {
            position: relative;
        }

        .search-box input {
            padding: 10px 20px 10px 45px;
            border: 2px solid #ddd;
            border-radius: 50px;
            width: 300px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        .search-box input:focus {
            outline: none;
            border-color: #ff2200;
        }

        .search-box i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
        }

        /* Blog Grid Section */
        .blog-grid-section {
            max-width: 1400px;
            margin: 0 auto;
            padding: 60px 20px;
        }

        .section-header {
            text-align: center;
            margin-bottom: 50px;
        }

        .section-header h2 {
            font-size: 42px;
            font-weight: 800;
            margin-bottom: 15px;
            color: #1a1a1a;
        }

        .section-header p {
            font-size: 18px;
            color: #666;
            max-width: 600px;
            margin: 0 auto;
        }

        /* Featured Article */
        .featured-article {
            margin-bottom: 60px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.3s ease;
            position: relative;
        }

        .featured-article:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .featured-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0;
        }

        .featured-image {
            position: relative;
            overflow: hidden;
            min-height: 400px;
        }

        .featured-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .featured-article:hover .featured-image img {
            transform: scale(1.1);
        }

        .featured-badge {
            position: absolute;
            top: 20px;
            left: 20px;
            background: #ff2200;
            color: white;
            padding: 8px 20px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 14px;
            z-index: 2;
        }

        .featured-text {
            padding: 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .featured-category {
            color: #ff2200;
            font-weight: 700;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 15px;
        }

        .featured-text h3 {
            font-size: 36px;
            font-weight: 800;
            margin-bottom: 20px;
            color: #1a1a1a;
            line-height: 1.3;
        }

        .featured-text p {
            font-size: 18px;
            color: #666;
            margin-bottom: 25px;
            line-height: 1.7;
        }

        .article-meta {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 25px;
            font-size: 15px;
            color: #999;
        }

        .article-meta span {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .article-meta i {
            color: #ff2200;
        }

        .read-more-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: #ff2200;
            color: white;
            padding: 14px 32px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 700;
            transition: all 0.3s ease;
            align-self: flex-start;
        }

        .read-more-btn:hover {
            background: #cc1b00;
            color: white;
            transform: translateX(5px);
        }

        /* Blog Articles Grid */
        .blog-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
            gap: 40px;
            margin-bottom: 60px;
        }

        .blog-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            display: flex;
            flex-direction: column;
        }

        .blog-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .blog-card-image {
            position: relative;
            overflow: hidden;
            height: 250px;
            background: #f0f0f0;
        }

        .blog-card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .blog-card:hover .blog-card-image img {
            transform: scale(1.1);
        }

        .card-category-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            background: rgba(255, 34, 0, 0.95);
            color: white;
            padding: 6px 16px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .blog-card-content {
            padding: 30px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .blog-card-content h3 {
            font-size: 22px;
            font-weight: 800;
            margin-bottom: 15px;
            color: #1a1a1a;
            line-height: 1.4;
        }

        .blog-card-content h3 a {
            color: inherit;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .blog-card-content h3 a:hover {
            color: #ff2200;
        }

        .blog-card-excerpt {
            color: #666;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 20px;
            flex: 1;
        }

        .blog-card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 20px;
            border-top: 1px solid #eee;
            font-size: 14px;
            color: #999;
        }

        .author-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .author-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: linear-gradient(135deg, #ff2200, #ff6b00);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 14px;
        }

        .reading-time {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* Pagination */
        .pagination-section {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin-top: 60px;
        }

        .pagination-btn {
            padding: 12px 20px;
            background: white;
            border: 2px solid #ddd;
            border-radius: 10px;
            color: #333;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .pagination-btn:hover {
            background: #ff2200;
            border-color: #ff2200;
            color: white;
        }

        .pagination-btn.active {
            background: #ff2200;
            border-color: #ff2200;
            color: white;
        }

        .pagination-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Newsletter Section */
        .newsletter-section {
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            padding: 80px 20px;
            margin-top: 80px;
            position: relative;
            overflow: hidden;
        }

        .newsletter-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('{{ asset('images/decorative/cta_left_mem_dots_f_circle2.svg') }}') no-repeat left center,
                url('{{ asset('images/decorative/cta_top_right_mem_dots_f_tri (1).svg') }}') no-repeat right top;
            opacity: 0.1;
        }

        .newsletter-content {
            max-width: 800px;
            margin: 0 auto;
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .newsletter-content h2 {
            font-size: 42px;
            font-weight: 800;
            color: white;
            margin-bottom: 20px;
        }

        .newsletter-content p {
            font-size: 18px;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 40px;
        }

        .newsletter-form {
            display: flex;
            gap: 15px;
            max-width: 600px;
            margin: 0 auto;
        }

        .newsletter-form input {
            flex: 1;
            padding: 16px 24px;
            border-radius: 50px;
            border: 2px solid transparent;
            font-size: 16px;
            outline: none;
            transition: border-color 0.3s ease;
        }

        .newsletter-form input:focus {
            border-color: #ff2200;
        }

        .newsletter-form button {
            padding: 16px 40px;
            background: #ff2200;
            color: white;
            border: none;
            border-radius: 50px;
            font-weight: 700;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .newsletter-form button:hover {
            background: #cc1b00;
            transform: translateY(-2px);
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .blog-hero h1 {
                font-size: 48px;
            }

            .featured-content {
                grid-template-columns: 1fr;
            }

            .featured-text {
                padding: 40px;
            }

            .featured-text h3 {
                font-size: 28px;
            }

            .blog-grid {
                grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
                gap: 30px;
            }
        }

        @media (max-width: 768px) {
            .blog-hero h1 {
                font-size: 36px;
            }

            .blog-hero p {
                font-size: 16px;
            }

            .filters-container {
                flex-direction: column;
                align-items: stretch;
            }

            .filter-buttons {
                justify-content: center;
            }

            .search-box input {
                width: 100%;
            }

            .featured-text {
                padding: 30px;
            }

            .featured-text h3 {
                font-size: 24px;
            }

            .featured-text p {
                font-size: 16px;
            }

            .blog-grid {
                grid-template-columns: 1fr;
            }

            .newsletter-content h2 {
                font-size: 32px;
            }

            .newsletter-form {
                flex-direction: column;
            }

            .section-header h2 {
                font-size: 32px;
            }
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .blog-card,
        .featured-article {
            animation: fadeInUp 0.6s ease-out;
        }

        .blog-card:nth-child(2) {
            animation-delay: 0.1s;
        }

        .blog-card:nth-child(3) {
            animation-delay: 0.2s;
        }

        .blog-card:nth-child(4) {
            animation-delay: 0.3s;
        }
    </style>

    <!-- Hero Section -->
    <section class="blog-hero">
        <div class="blog-hero-content">
            <h1>Our <span class="highlight">Blog</span></h1>
            <p>Insights on digital transformation, web development, AI, and technology trends to help your business
                thrive in the digital age.</p>
        </div>
    </section>

    <!-- Filters Section -->
    <section class="blog-filters">
        <div class="filters-container">
            <div class="filter-buttons">
                <button class="filter-btn active" data-category="all">All Articles</button>
                <button class="filter-btn" data-category="web-development">Web Development</button>
                <button class="filter-btn" data-category="ai-ml">AI & ML</button>
                <button class="filter-btn" data-category="digital-strategy">Digital Strategy</button>
                <button class="filter-btn" data-category="case-studies">Case Studies</button>
                <button class="filter-btn" data-category="tutorials">Tutorials</button>
            </div>
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="blogSearch" placeholder="Search articles...">
            </div>
        </div>
    </section>

    <!-- Featured Article -->
    <section class="blog-grid-section">
        <article class="featured-article" data-category="ai-ml">
            <div class="featured-content">
                <div class="featured-image">
                    <div class="featured-badge">Featured</div>
                    <img src="{{ asset('images/decorative/purple_mem_3d_semi_pipe.svg') }}" alt="AI Transformation in Ghana">
                </div>
                <div class="featured-text">
                    <div class="featured-category">AI & Machine Learning</div>
                    <h3>How AI is Transforming Business Operations in Ghana</h3>
                    <p>Discover how Ghanaian businesses are leveraging artificial intelligence and machine learning to
                        automate processes, reduce costs by up to 70%, and deliver exceptional customer experiences
                        24/7.</p>
                    <div class="article-meta">
                        <span><i class="fas fa-calendar"></i> October 1, 2025</span>
                        <span><i class="fas fa-clock"></i> 8 min read</span>
                    </div>
                    <a href="{{ url('blog.show', 'ai-transforming-business-operations-ghana') }}" class="read-more-btn">
                        Read Full Article
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </article>

        <!-- Section Header -->
        <div class="section-header">
            <h2>Latest Articles</h2>
            <p>Stay updated with the latest insights, trends, and expert advice from our team</p>
        </div>

        <!-- Blog Articles Grid -->
        <div class="blog-grid" id="blogGrid">
            <!-- Article 1 -->
            <article class="blog-card" data-category="web-development">
                <div class="blog-card-image">
                    <div class="card-category-badge">Web Development</div>
                    <img src="{{ asset('images/decorative/hero_underline.svg') }}" alt="Progressive Web Apps">
                </div>
                <div class="blog-card-content">
                    <h3><a href="{{ url('blog.show', 'progressive-web-apps-2025') }}">The Rise of Progressive Web Apps (PWAs) in 2025</a></h3>
                    <p class="blog-card-excerpt">Progressive Web Apps are revolutionizing how businesses deliver mobile
                        experiences. Learn why PWAs are becoming the go-to solution for African startups.</p>
                    <div class="blog-card-footer">
                        <div class="author-info">
                            <div class="author-avatar">KA</div>
                            <span>Kwame Asante</span>
                        </div>
                        <div class="reading-time">
                            <i class="fas fa-clock"></i>
                            <span>6 min</span>
                        </div>
                    </div>
                </div>
            </article>

            <!-- Article 2 -->
            <article class="blog-card" data-category="digital-strategy">
                <div class="blog-card-image">
                    <div class="card-category-badge">Digital Strategy</div>
                    <img src="{{ asset('images/decorative/hero_left_mem_dots_f_circle3.svg') }}" alt="Digital Marketing">
                </div>
                <div class="blog-card-content">
                    <h3><a href="{{ url('blog.show', 'digital-marketing-ghanaian-nonprofits') }}">5 Digital Marketing Strategies for Ghanaian Nonprofits</a></h3>
                    <p class="blog-card-excerpt">Effective digital marketing doesn't require a massive budget. Discover
                        proven strategies that help nonprofits amplify their impact and reach donors.</p>
                    <div class="blog-card-footer">
                        <div class="author-info">
                            <div class="author-avatar">AM</div>
                            <span>Ama Mensah</span>
                        </div>
                        <div class="reading-time">
                            <i class="fas fa-clock"></i>
                            <span>7 min</span>
                        </div>
                    </div>
                </div>
            </article>

            <!-- Article 3 -->
            <article class="blog-card" data-category="case-studies">
                <div class="blog-card-image">
                    <div class="card-category-badge">Case Study</div>
                    <img src="{{ asset('images/projects/goodnewslibrary.png') }}" alt="Good News Library Case Study">
                </div>
                <div class="blog-card-content">
                    <h3><a href="{{ url('blog.show', 'good-news-library-case-study') }}">Case Study: Building Good News Library's Digital Platform</a></h3>
                    <p class="blog-card-excerpt">How we helped Good News Library reach thousands of readers with a
                        custom content management system and mobile-first design approach.</p>
                    <div class="blog-card-footer">
                        <div class="author-info">
                            <div class="author-avatar">KO</div>
                            <span>Kofi Owusu</span>
                        </div>
                        <div class="reading-time">
                            <i class="fas fa-clock"></i>
                            <span>10 min</span>
                        </div>
                    </div>
                </div>
            </article>

            <!-- Article 4 -->
            <article class="blog-card" data-category="ai-ml">
                <div class="blog-card-image">
                    <div class="card-category-badge">AI & ML</div>
                    <img src="{{ asset('images/decorative/how_it_works_mem_dots_f_circle2.svg') }}" alt="Chatbots">
                </div>
                <div class="blog-card-content">
                    <h3><a href="{{ url('blog.show', 'intelligent-chatbots-customer-service') }}">Building Intelligent Chatbots for Customer Service</a></h3>
                    <p class="blog-card-excerpt">Learn how AI-powered chatbots can handle 80% of routine customer
                        inquiries, freeing your team to focus on complex issues and strategic work.</p>
                    <div class="blog-card-footer">
                        <div class="author-info">
                            <div class="author-avatar">EA</div>
                            <span>Efua Agyeman</span>
                        </div>
                        <div class="reading-time">
                            <i class="fas fa-clock"></i>
                            <span>9 min</span>
                        </div>
                    </div>
                </div>
            </article>

            <!-- Article 5 -->
            <article class="blog-card" data-category="tutorials">
                <div class="blog-card-image">
                    <div class="card-category-badge">Tutorial</div>
                    <img src="{{ asset('images/decorative/mem_donut.svg') }}" alt="Website Performance">
                </div>
                <div class="blog-card-content">
                    <h3><a href="{{ url('blog.show', 'optimizing-website-performance-africa') }}">Optimizing Website Performance for African Internet Speeds</a></h3>
                    <p class="blog-card-excerpt">A practical guide to making your website lightning-fast even on slower
                        connections. Essential techniques every African web developer should know.</p>
                    <div class="blog-card-footer">
                        <div class="author-info">
                            <div class="author-avatar">YB</div>
                            <span>Yaw Boateng</span>
                        </div>
                        <div class="reading-time">
                            <i class="fas fa-clock"></i>
                            <span>12 min</span>
                        </div>
                    </div>
                </div>
            </article>

            <!-- Article 6 -->
            <article class="blog-card" data-category="web-development">
                <div class="blog-card-image">
                    <div class="card-category-badge">Web Development</div>
                    <img src="{{ asset('images/decorative/hero_right_circle-con3.svg') }}" alt="Mobile First">
                </div>
                <div class="blog-card-content">
                    <h3><a href="{{ url('blog.show', 'mobile-first-design-africa') }}">Why Mobile-First Design Matters in Africa</a></h3>
                    <p class="blog-card-excerpt">With over 70% of African internet users accessing the web via mobile
                        devices, mobile-first design isn't optional—it's essential for success.</p>
                    <div class="blog-card-footer">
                        <div class="author-info">
                            <div class="author-avatar">AB</div>
                            <span>Akosua Bonsu</span>
                        </div>
                        <div class="reading-time">
                            <i class="fas fa-clock"></i>
                            <span>5 min</span>
                        </div>
                    </div>
                </div>
            </article>

            <!-- Article 7 -->
            <article class="blog-card" data-category="digital-strategy">
                <div class="blog-card-image">
                    <div class="card-category-badge">Digital Strategy</div>
                    <img src="{{ asset('images/decorative/cta_left_mem_dots_f_circle2.svg') }}" alt="Data Analytics">
                </div>
                <div class="blog-card-content">
                    <h3><a href="{{ url('blog.show', 'data-driven-decision-making-small-businesses') }}">Data-Driven Decision Making for Small Businesses</a></h3>
                    <p class="blog-card-excerpt">Transform your business with data analytics. Learn how to collect,
                        analyze, and act on customer data to drive growth and improve ROI.</p>
                    <div class="blog-card-footer">
                        <div class="author-info">
                            <div class="author-avatar">KN</div>
                            <span>Kwesi Nkrumah</span>
                        </div>
                        <div class="reading-time">
                            <i class="fas fa-clock"></i>
                            <span>8 min</span>
                        </div>
                    </div>
                </div>
            </article>

            <!-- Article 8 -->
            <article class="blog-card" data-category="case-studies">
                <div class="blog-card-image">
                    <div class="card-category-badge">Case Study</div>
                    <img src="{{ asset('images/projects/kokoplus.png') }}" alt="KokoPlus Case Study">
                </div>
                <div class="blog-card-content">
                    <h3><a href="{{ url('blog.show', 'kokoplus-scaling-10000-users') }}">How KokoPlus Scaled to 10,000+ Users with Cloud Infrastructure</a></h3>
                    <p class="blog-card-excerpt">Discover how we helped KokoPlus build a scalable, secure platform that
                        handles thousands of concurrent users without breaking a sweat.</p>
                    <div class="blog-card-footer">
                        <div class="author-info">
                            <div class="author-avatar">FA</div>
                            <span>Fiifi Ansah</span>
                        </div>
                        <div class="reading-time">
                            <i class="fas fa-clock"></i>
                            <span>11 min</span>
                        </div>
                    </div>
                </div>
            </article>

            <!-- Article 9 -->
            <article class="blog-card" data-category="ai-ml">
                <div class="blog-card-image">
                    <div class="card-category-badge">AI & ML</div>
                    <img src="{{ asset('images/decorative/mem_dots_f_tri.svg') }}" alt="Predictive Analytics">
                </div>
                <div class="blog-card-content">
                    <h3><a href="{{ url('blog.show', 'predictive-analytics-forecasting-business-trends') }}">Predictive Analytics: Forecasting Business Trends with AI</a></h3>
                    <p class="blog-card-excerpt">Use machine learning to predict customer behavior, optimize inventory,
                        and make smarter business decisions with predictive analytics tools.</p>
                    <div class="blog-card-footer">
                        <div class="author-info">
                            <div class="author-avatar">NQ</div>
                            <span>Nana Quaye</span>
                        </div>
                        <div class="reading-time">
                            <i class="fas fa-clock"></i>
                            <span>10 min</span>
                        </div>
                    </div>
                </div>
            </article>
        </div>

        <!-- Pagination -->
        <div class="pagination-section">
            <button class="pagination-btn" disabled>
                <i class="fas fa-chevron-left"></i> Previous
            </button>
            <a href="#" class="pagination-btn active">1</a>
            <a href="#" class="pagination-btn">2</a>
            <a href="#" class="pagination-btn">3</a>
            <a href="#" class="pagination-btn">4</a>
            <button class="pagination-btn">
                Next <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="newsletter-section">
        <div class="newsletter-content">
            <h2>Stay Updated</h2>
            <p>Get the latest insights, tutorials, and case studies delivered straight to your inbox. Join 1,000+
                subscribers.</p>
            <form class="newsletter-form" id="newsletterForm">
                <input type="email" placeholder="Enter your email address" required>
                <button type="submit">Subscribe</button>
            </form>
        </div>
    </section>

    <script>
        // Blog Filter Functionality
        const filterButtons = document.querySelectorAll('.filter-btn');
        const blogCards = document.querySelectorAll('.blog-card');
        const featuredArticle = document.querySelector('.featured-article');

        filterButtons.forEach(button => {
            button.addEventListener('click', () => {
                // Remove active class from all buttons
                filterButtons.forEach(btn => btn.classList.remove('active'));
                // Add active class to clicked button
                button.classList.add('active');

                const category = button.dataset.category;

                // Show/hide featured article
                if (category === 'all' || featuredArticle.dataset.category === category) {
                    featuredArticle.style.display = 'block';
                } else {
                    featuredArticle.style.display = 'none';
                }

                // Filter blog cards
                blogCards.forEach(card => {
                    if (category === 'all' || card.dataset.category === category) {
                        card.style.display = 'flex';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });

        // Search Functionality
        const searchInput = document.getElementById('blogSearch');

        searchInput.addEventListener('input', (e) => {
            const searchTerm = e.target.value.toLowerCase();

            blogCards.forEach(card => {
                const title = card.querySelector('h3').textContent.toLowerCase();
                const excerpt = card.querySelector('.blog-card-excerpt').textContent.toLowerCase();

                if (title.includes(searchTerm) || excerpt.includes(searchTerm)) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });

            // Handle featured article
            const featuredTitle = featuredArticle.querySelector('h3').textContent.toLowerCase();
            const featuredText = featuredArticle.querySelector('.featured-text p').textContent.toLowerCase();

            if (featuredTitle.includes(searchTerm) || featuredText.includes(searchTerm)) {
                featuredArticle.style.display = 'block';
            } else {
                featuredArticle.style.display = 'none';
            }
        });

        // Newsletter Form Submission
        const newsletterForm = document.getElementById('newsletterForm');

        newsletterForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const email = newsletterForm.querySelector('input[type="email"]').value;

            // Here you would typically send this to your backend
            alert(`Thank you for subscribing with ${email}! You'll receive our latest updates soon.`);
            newsletterForm.reset();
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add scroll animation for blog cards
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe all blog cards
        blogCards.forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';
            card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(card);
        });
    </script>

</x-layouts.frontend>