@props([
    'title' => 'Manifest Digital | Custom Web & App Development in Ghana | Est. 2014',
    'transparentHeader' => false,
    'preloader' => 'advanced',
    'notificationStyle' => 'dark' // Options: 'dark', 'modern-purple'
])   


<!DOCTYPE html>

<html lang="en">

<head><!DOCTYPE html>

    <meta charset="UTF-8"><html lang="en">

    <meta name="viewport" content="width=device-width, initial-scale=1.0"><head>

    <meta name="description" content="Join Manifest Digital's growing team! Explore career opportunities in web development, UI/UX design, digital marketing & business development. Competitive salaries, remote work options, professional growth opportunities in Ghana.">    <meta charset="UTF-8">

    <meta name="keywords" content="careers Ghana, web developer jobs Accra, UI UX designer jobs Ghana, digital marketing careers, tech jobs Ghana, remote work opportunities, software developer positions, business development manager, internships Accra, Ghana tech jobs, Manifest Digital careers">    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="author" content="Manifest Digital">    <meta name="description" content="Join Manifest Digital's growing team! 6 open positions in web development, UI/UX design, digital marketing & business development. Competitive salaries, remote work options, professional growth opportunities. Apply now in Accra, Ghana.">

        <meta name="keywords" content="careers Ghana, web developer jobs Accra, UI UX designer jobs Ghana, digital marketing careers, tech jobs Ghana, remote work opportunities, software developer positions, frontend developer intern, business development manager, graphic designer jobs, internships Accra, Ghana tech jobs, Manifest Digital careers, full stack developer Ghana, senior developer positions, digital agency jobs">

    <title>{{ $title }}</title>    >

        <meta name="author" content="Manifest Digital">

    <!-- Favicon -->

    <link rel="icon" type="image/x-icon" href="{{ asset('images/logos/favicon.png') }}">    <!-- Favicon -->

        <link rel="icon" type="image/x-icon" href="images/logos/favicon.png">

    <!-- Open Graph Meta Tags -->    

    <meta property="og:title" content="Careers at Manifest Digital | Join Our Team">    <!-- Open Graph Meta Tags -->

    <meta property="og:description" content="Build the future of digital solutions with Ghana's leading development team. Remote, hybrid, and on-site opportunities available.">    <meta property="og:title" content="Careers at Manifest Digital | Join Our Team">

    <meta property="og:type" content="website">    <meta property="og:description" content="Build the future of digital solutions with Ghana's leading development team. Remote, hybrid, and on-site opportunities available.">

    <meta property="og:url" content="{{ url()->current() }}">    <meta property="og:type" content="website">

    <meta property="og:image" content="{{ asset('images/team/manifest-team-hero.jpg') }}">    <meta property="og:url" content="https://manifestghana.com/opportunities">

        <meta property="og:image" content="https://manifestghana.com/images/team/manifest-team-hero.jpg">

    <!-- Twitter Card Meta Tags -->    

    <meta name="twitter:card" content="summary_large_image">    <!-- Twitter Card Meta Tags -->

    <meta name="twitter:title" content="Join Manifest Digital's Growing Team">    <meta name="twitter:card" content="summary_large_image">

    <meta name="twitter:description" content="Career opportunities in web development, design, marketing, and more. Remote and on-site positions in Ghana.">    <meta name="twitter:title" content="Join Manifest Digital's Growing Team">

    <meta name="twitter:image" content="{{ asset('images/team/manifest-team-social.jpg') }}">    <meta name="twitter:description" content="Career opportunities in web development, design, marketing, and more. Remote and on-site positions in Ghana.">

        <meta name="twitter:image" content="https://manifestghana.com/images/team/manifest-team-social.jpg">

    <!-- SEO Meta Tags -->    

    <meta name="robots" content="index, follow">    <!-- Enhanced SEO Meta Tags -->

    <meta name="theme-color" content="#FF4900">    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">

    <link rel="canonical" href="{{ url()->current() }}">    <meta name="google-site-verification" content="your-google-verification-code-here">

        <meta name="msvalidate.01" content="your-bing-verification-code-here">

    <!-- CSS Files -->    <link rel="canonical" href="https://manifestghana.com/opportunities">

    @vite(['resources/css/app.css'])    

        <!-- Hreflang for International SEO -->

    <!-- Bootstrap CSS -->    <link rel="alternate" hreflang="en" href="https://manifestghana.com/opportunities">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">    <link rel="alternate" hreflang="en-gh" href="https://manifestghana.com/opportunities">

        <link rel="alternate" hreflang="x-default" href="https://manifestghana.com/opportunities">

    <!-- Font Awesome -->    

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">    <!-- Additional SEO Meta Tags -->

        <meta name="theme-color" content="#FF4900">

    <!-- Custom Styles -->    <meta name="msapplication-TileColor" content="#FF4900">

    @stack('styles')    <meta name="application-name" content="Manifest Digital Careers">

        <meta name="apple-mobile-web-app-title" content="Manifest Digital Jobs">

    <!-- Structured Data for Organization -->    <meta name="apple-mobile-web-app-capable" content="yes">

    <script type="application/ld+json">    <meta name="apple-mobile-web-app-status-bar-style" content="default">

    {    

        "@context": "https://schema.org",    <!-- Preload Critical Resources -->

        "@type": "Organization",    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Anybody:wght@400;500;600;700;800&display=swap" as="style">

        "name": "Manifest Digital",    <link rel="preconnect" href="https://fonts.googleapis.com">

        "url": "{{ url('/') }}",    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

        "logo": "{{ asset('images/logos/logo.png') }}",    

        "description": "Leading web development and digital transformation company in Ghana, offering innovative solutions since 2014.",    <!-- DNS Prefetch for Performance -->

        "address": {    <link rel="dns-prefetch" href="//cdn.jsdelivr.net">

            "@type": "PostalAddress",    <link rel="dns-prefetch" href="//cdnjs.cloudflare.com">

            "streetAddress": "123 Tech Hub Street",    <link rel="dns-prefetch" href="//www.googletagmanager.com">

            "addressLocality": "Accra",    <link rel="dns-prefetch" href="//www.google-analytics.com">

            "addressRegion": "Greater Accra",    

            "postalCode": "GA-123-4567",    <!-- Additional Resource Preloading -->

            "addressCountry": "Ghana"    <link rel="preload" href="images/manifest-logo.svg" as="image" type="image/svg+xml">

        },    <link rel="prefetch" href="images/decorative/hero_underline.svg" as="image">

        "contactPoint": {    

            "@type": "ContactPoint",    <!-- Critical Resource Optimization -->

            "telephone": "+233-20-123-4567",    <link rel="preload" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">

            "contactType": "HR Department",    <noscript><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"></noscript>

            "email": "careers@manifestdigital.com"    

        },    <!-- Additional Open Graph Meta Tags -->

        "sameAs": [    <meta property="og:site_name" content="Manifest Digital">

            "https://www.linkedin.com/company/manifest-digital-ghana",    <meta property="og:locale" content="en_US">

            "https://twitter.com/manifestghana",    <meta property="article:modified_time" content="2024-01-15T10:00:00+00:00">

            "https://github.com/manifestghana"    

        ]    <!-- Additional Twitter Meta Tags -->

    }    <meta name="twitter:site" content="@manifestghana">

    </script>    <meta name="twitter:creator" content="@manifestghana">

</head>    

<body>    <!-- Structured Data for Organization -->

    <!-- Preloader -->    <script type="application/ld+json">

    @if($preloader === 'advanced')    {

        <div id="preloader" class="advanced-preloader">        "@context": "https://schema.org/",

            <div class="preloader-content">        "@type": "Organization",

                <div class="preloader-logo">        "name": "Manifest Digital",

                    <img src="{{ asset('images/logos/logo.png') }}" alt="Manifest Digital" style="max-width: 150px;">        "alternateName": "Manifest Digital Ghana",

                </div>        "url": "https://manifestghana.com",

                <div class="preloader-spinner">        "logo": "https://manifestghana.com/images/logos/logo.png",

                    <div class="spinner-ring"></div>        "description": "Ghana's leading digital solutions company, specializing in web development, mobile apps, and digital transformation since 2014.",

                    <div class="spinner-ring"></div>        "foundingDate": "2014",

                    <div class="spinner-ring"></div>        "numberOfEmployees": {

                </div>            "@type": "QuantitativeValue",

                <div class="preloader-text">Loading Amazing Opportunities...</div>            "value": "15-25"

                <div class="preloader-progress">        },

                    <div class="progress-bar"></div>        "location": {

                </div>            "@type": "Place",

            </div>            "name": "Manifest Digital Office",

        </div>            "address": {

    @elseif($preloader === 'simple')                "@type": "PostalAddress",

        <div id="preloader" class="simple-preloader">                "streetAddress": "123 Tech Hub Street",

            <div class="simple-spinner"></div>                "addressLocality": "Accra",

        </div>                "addressRegion": "Greater Accra",

    @endif                "postalCode": "GA-123-4567",

                "addressCountry": "Ghana"

    <!-- Reading Progress Bar -->            },

    <div class="reading-tracker" style="position: fixed; top: 0; left: 0; width: 0%; height: 3px; background: linear-gradient(135deg, #FF4900 0%, #FF6B35 100%); z-index: 9999; transition: width 0.3s ease;"></div>            "geo": {

                "@type": "GeoCoordinates",

    <!-- Header/Navigation -->                "latitude": "5.6037",

    <header class="navbar navbar-expand-lg {{ $transparentHeader ? 'navbar-transparent position-absolute' : 'navbar-light bg-white shadow-sm' }} w-100" style="z-index: 1000;">                "longitude": "-0.1870"

        <div class="container">            }

            <a class="navbar-brand" href="{{ route('home') }}">        },

                <img src="{{ asset('images/logos/logo.png') }}" alt="Manifest Digital" style="height: 40px;">        "contactPoint": {

            </a>            "@type": "ContactPoint",

                        "telephone": "+233-20-123-4567",

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">            "contactType": "HR Department",

                <span class="navbar-toggler-icon"></span>            "email": "careers@manifestdigital.com",

            </button>            "availableLanguage": ["English"]

                    },

            <div class="collapse navbar-collapse" id="navbarNav">        "sameAs": [

                <ul class="navbar-nav ms-auto">            "https://www.linkedin.com/company/manifest-digital-ghana",

                    <li class="nav-item">            "https://twitter.com/manifestghana",

                        <a class="nav-link" href="{{ route('home') }}">Home</a>            "https://github.com/manifestghana",

                    </li>            "https://www.facebook.com/manifestdigitalghana"

                    <li class="nav-item">        ],

                        <a class="nav-link" href="{{ route('about') }}">About</a>        "industry": "Information Technology",

                    </li>        "keywords": "web development, mobile apps, digital transformation, UI/UX design, digital marketing, software development",

                    <li class="nav-item">        "workingHours": [

                        <a class="nav-link" href="{{ route('projects') }}">Projects</a>            "Mo-Fr 09:00-17:00"

                    </li>        ]

                    <li class="nav-item">    }

                        <a class="nav-link active" href="{{ route('opportunities') }}">Careers</a>    </script>

                    </li>

                    <li class="nav-item">    <!-- Structured Data for Job Postings -->

                        <a class="nav-link" href="{{ route('book-a-call') }}">Book a Call</a>    <script type="application/ld+json">

                    </li>    {

                    <li class="nav-item">        "@context": "https://schema.org/",

                        <a class="btn btn-primary ms-2" href="{{ route('request-quote') }}" style="background: linear-gradient(135deg, #FF4900 0%, #FF6B35 100%); border: none;">        "@type": "ItemList",

                            Get Quote        "name": "Career Opportunities at Manifest Digital",

                        </a>        "description": "Current job openings and career opportunities at Manifest Digital Ghana",

                    </li>        "numberOfItems": 6,

                </ul>        "itemListElement": [

            </div>            {

        </div>                "@type": "JobPosting",

    </header>                "title": "Senior Full-Stack Developer",

                "description": "Lead development of scalable web applications using modern technologies including React, Node.js, and Laravel. Join our dynamic team working on exciting projects for clients across various industries.",

    <!-- Main Content -->                "datePosted": "2024-01-10",

    <main>                "validThrough": "2024-03-10",

        {{ $slot }}                "employmentType": ["FULL_TIME"],

    </main>                "hiringOrganization": {

                    "@type": "Organization",

    <!-- Footer -->                    "name": "Manifest Digital",

    <footer class="bg-dark text-light py-5">                    "sameAs": "https://manifestghana.com",

        <div class="container">                    "logo": "https://manifestghana.com/images/logos/logo.png"

            <div class="row">                },

                <div class="col-lg-4 mb-4">                "jobLocation": {

                    <img src="{{ asset('images/logos/logo-white.png') }}" alt="Manifest Digital" style="height: 40px;" class="mb-3">                    "@type": "Place",

                    <p class="text-muted">Leading web development and digital transformation company in Ghana, delivering innovative solutions since 2014.</p>                    "address": {

                    <div class="social-links">                        "@type": "PostalAddress",

                        <a href="#" class="text-light me-3"><i class="fab fa-linkedin"></i></a>                        "addressLocality": "Accra",

                        <a href="#" class="text-light me-3"><i class="fab fa-twitter"></i></a>                        "addressCountry": "Ghana"

                        <a href="#" class="text-light me-3"><i class="fab fa-github"></i></a>                    }

                        <a href="#" class="text-light"><i class="fab fa-facebook"></i></a>                },

                    </div>                "baseSalary": {

                </div>                    "@type": "MonetaryAmount",

                <div class="col-lg-2 col-md-6 mb-4">                    "currency": "GHS",

                    <h5>Company</h5>                    "value": {

                    <ul class="list-unstyled">                        "@type": "QuantitativeValue",

                        <li><a href="{{ route('about') }}" class="text-muted text-decoration-none">About Us</a></li>                        "value": "8000-12000",

                        <li><a href="{{ route('opportunities') }}" class="text-muted text-decoration-none">Careers</a></li>                        "unitText": "MONTH"

                        <li><a href="#" class="text-muted text-decoration-none">Blog</a></li>                    }

                        <li><a href="#" class="text-muted text-decoration-none">Contact</a></li>                },

                    </ul>                "qualifications": "Bachelor's degree in Computer Science or related field, 3+ years of experience in full-stack development, proficiency in React, Node.js, Laravel, MySQL, TypeScript, Docker, and AWS.",

                </div>                "responsibilities": "Lead development of scalable web applications, collaborate with design and product teams, mentor junior developers, participate in code reviews, contribute to technical architecture decisions."

                <div class="col-lg-2 col-md-6 mb-4">            },

                    <h5>Services</h5>            {

                    <ul class="list-unstyled">                "@type": "JobPosting",

                        <li><a href="#" class="text-muted text-decoration-none">Web Development</a></li>                "title": "Senior UI/UX Designer",

                        <li><a href="#" class="text-muted text-decoration-none">Mobile Apps</a></li>                "description": "Create intuitive and visually stunning user experiences for web and mobile applications. Work with cross-functional teams to deliver award-winning designs for diverse clients.",

                        <li><a href="#" class="text-muted text-decoration-none">UI/UX Design</a></li>                "datePosted": "2024-01-08",

                        <li><a href="#" class="text-muted text-decoration-none">Digital Marketing</a></li>                "validThrough": "2024-03-08",

                    </ul>                "employmentType": ["FULL_TIME"],

                </div>                "hiringOrganization": {

                <div class="col-lg-4 mb-4">                    "@type": "Organization",

                    <h5>Get In Touch</h5>                    "name": "Manifest Digital",

                    <p class="text-muted">                    "sameAs": "https://manifestghana.com",

                        <i class="fas fa-map-marker-alt me-2"></i>                    "logo": "https://manifestghana.com/images/logos/logo.png"

                        123 Tech Hub Street, Accra, Ghana                },

                    </p>                "jobLocation": {

                    <p class="text-muted">                    "@type": "Place",

                        <i class="fas fa-phone me-2"></i>                    "address": {

                        +233 20 123 4567                        "@type": "PostalAddress",

                    </p>                        "addressLocality": "Accra",

                    <p class="text-muted">                        "addressCountry": "Ghana"

                        <i class="fas fa-envelope me-2"></i>                    }

                        careers@manifestdigital.com                },

                    </p>                "baseSalary": {

                </div>                    "@type": "MonetaryAmount",

            </div>                    "currency": "GHS",

            <hr class="my-4">                    "value": {

            <div class="row align-items-center">                        "@type": "QuantitativeValue",

                <div class="col-md-6">                        "value": "6000-10000",

                    <p class="text-muted mb-0">&copy; {{ date('Y') }} Manifest Digital. All rights reserved.</p>                        "unitText": "MONTH"

                </div>                    }

                <div class="col-md-6 text-md-end">                },

                    <a href="#" class="text-muted text-decoration-none me-3">Privacy Policy</a>                "qualifications": "Bachelor's degree in Design or related field, 3+ years of UI/UX design experience, expertise in Figma, Adobe XD, prototyping, user research, and design systems.",

                    <a href="#" class="text-muted text-decoration-none">Terms of Service</a>                "responsibilities": "Design user interfaces and experiences, conduct user research, create prototypes and wireframes, collaborate with development teams, maintain design systems."

                </div>            },

            </div>            {

        </div>                "@type": "JobPosting",

    </footer>                "title": "Business Development Manager",

                "description": "Drive business growth through strategic partnerships and client acquisition. Lead sales initiatives and build lasting relationships with enterprise clients.",

    <!-- Bootstrap JS -->                "datePosted": "2024-01-05",

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>                "validThrough": "2024-03-05",

                    "employmentType": ["FULL_TIME"],

    <!-- Vite JS -->                "hiringOrganization": {

    @vite(['resources/js/app.js'])                    "@type": "Organization",

                        "name": "Manifest Digital",

    <!-- Custom Scripts -->                    "sameAs": "https://manifestghana.com",

    @stack('scripts')                    "logo": "https://manifestghana.com/images/logos/logo.png"

                },

    <!-- Preloader Script -->                "jobLocation": {

    <script>                    "@type": "Place",

        document.addEventListener('DOMContentLoaded', function() {                    "address": {

            const preloader = document.getElementById('preloader');                        "@type": "PostalAddress",

            if (preloader) {                        "addressLocality": "Accra",

                // Simulate loading time                        "addressCountry": "Ghana"

                setTimeout(() => {                    }

                    preloader.style.opacity = '0';                },

                    preloader.style.visibility = 'hidden';                "baseSalary": {

                    setTimeout(() => {                    "@type": "MonetaryAmount",

                        preloader.remove();                    "currency": "GHS",

                    }, 300);                    "value": {

                }, 1500);                        "@type": "QuantitativeValue",

            }                        "value": "7000-11000",

                        "unitText": "MONTH"

            // Reading Progress Bar                    }

            const readingTracker = document.querySelector('.reading-tracker');                },

                            "qualifications": "Bachelor's degree in Business or related field, 3+ years of business development experience, proven track record in sales, partnerships, strategy, CRM, and lead generation.",

            function updateReadingProgress() {                "responsibilities": "Develop business strategies, identify partnership opportunities, manage client relationships, negotiate contracts, analyze market trends."

                const windowHeight = window.innerHeight;            },

                const documentHeight = document.documentElement.scrollHeight;            {

                const scrollTop = window.pageYOffset || document.documentElement.scrollTop;                "@type": "JobPosting",

                const trackLength = documentHeight - windowHeight;                "title": "Creative Graphic Designer",

                const pctScrolled = Math.min(100, Math.max(0, Math.floor((scrollTop / trackLength) * 100)));                "description": "Bring creative visions to life through compelling visual designs. Work on diverse projects including branding, marketing materials, and digital assets.",

                                "datePosted": "2024-01-12",

                if (readingTracker) {                "validThrough": "2024-03-12",

                    readingTracker.style.width = pctScrolled + '%';                "employmentType": ["FULL_TIME"],

                }                "hiringOrganization": {

            }                    "@type": "Organization",

                                "name": "Manifest Digital",

            window.addEventListener('scroll', updateReadingProgress, { passive: true });                    "sameAs": "https://manifestghana.com",

            window.addEventListener('resize', updateReadingProgress, { passive: true });                    "logo": "https://manifestghana.com/images/logos/logo.png"

            updateReadingProgress();                },

        });                "jobLocation": {

    </script>                    "@type": "Place",

</body>                    "address": {

</html>                        "@type": "PostalAddress",
                        "addressLocality": "Accra",
                        "addressCountry": "Ghana"
                    }
                },
                "baseSalary": {
                    "@type": "MonetaryAmount",
                    "currency": "GHS",
                    "value": {
                        "@type": "QuantitativeValue",
                        "value": "4000-7000",
                        "unitText": "MONTH"
                    }
                },
                "qualifications": "Bachelor's degree in Graphic Design or related field, 2+ years of design experience, proficiency in Photoshop, Illustrator, branding, typography, and print design.",
                "responsibilities": "Create visual designs, develop brand materials, design marketing collateral, collaborate with marketing team, maintain brand consistency."
            },
            {
                "@type": "JobPosting",
                "title": "Digital Marketing Intern",
                "description": "Gain hands-on experience in digital marketing strategies, social media management, and campaign optimization in a fast-paced agency environment.",
                "datePosted": "2024-01-15",
                "validThrough": "2024-04-15",
                "employmentType": ["INTERN", "PART_TIME"],
                "hiringOrganization": {
                    "@type": "Organization",
                    "name": "Manifest Digital",
                    "sameAs": "https://manifestghana.com",
                    "logo": "https://manifestghana.com/images/logos/logo.png"
                },
                "jobLocation": {
                    "@type": "Place",
                    "address": {
                        "@type": "PostalAddress",
                        "addressLocality": "Accra",
                        "addressCountry": "Ghana"
                    }
                },
                "baseSalary": {
                    "@type": "MonetaryAmount",
                    "currency": "GHS",
                    "value": {
                        "@type": "QuantitativeValue",
                        "value": "1500-2500",
                        "unitText": "MONTH"
                    }
                },
                "qualifications": "Currently pursuing or recently completed degree in Marketing, Communications, or related field. Knowledge of social media, content creation, analytics, SEO, and email marketing.",
                "responsibilities": "Assist with social media management, create content, analyze campaign performance, support SEO initiatives, help with email marketing campaigns."
            },
            {
                "@type": "JobPosting",
                "title": "Frontend Development Intern",
                "description": "Learn modern web development technologies and contribute to real client projects. Perfect opportunity for students or recent graduates to build professional experience.",
                "datePosted": "2024-01-13",
                "validThrough": "2024-04-13",
                "employmentType": ["INTERN", "PART_TIME"],
                "hiringOrganization": {
                    "@type": "Organization",
                    "name": "Manifest Digital",
                    "sameAs": "https://manifestghana.com",
                    "logo": "https://manifestghana.com/images/logos/logo.png"
                },
                "jobLocation": {
                    "@type": "Place",
                    "address": {
                        "@type": "PostalAddress",
                        "addressLocality": "Accra",
                        "addressCountry": "Ghana"
                    }
                },
                "baseSalary": {
                    "@type": "MonetaryAmount",
                    "currency": "GHS",
                    "value": {
                        "@type": "QuantitativeValue",
                        "value": "1200-2000",
                        "unitText": "MONTH"
                    }
                },
                "qualifications": "Currently pursuing or recently completed degree in Computer Science or related field. Basic knowledge of HTML/CSS, JavaScript, React, Git, and responsive design.",
                "responsibilities": "Develop user interfaces, implement responsive designs, collaborate with senior developers, learn modern development practices, contribute to code reviews."
            }
        ]
    }
    </script>

    <!-- Structured Data for WebSite -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebSite",
        "name": "Manifest Digital",
        "url": "https://manifestghana.com",
        "potentialAction": {
            "@type": "SearchAction",
            "target": {
                "@type": "EntryPoint",
                "urlTemplate": "https://manifestghana.com/search?q={search_term_string}"
            },
            "query-input": "required name=search_term_string"
        }
    }
    </script>

    <!-- Structured Data for BreadcrumbList -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "BreadcrumbList",
        "itemListElement": [
            {
                "@type": "ListItem",
                "position": 1,
                "name": "Home",
                "item": "https://manifestghana.com"
            },
            {
                "@type": "ListItem",
                "position": 2,
                "name": "Careers",
                "item": "https://manifestghana.com/opportunities"
            }
        ]
    }
    </script>
    
    <!-- Google Analytics 4 (GA4) -->
    <!-- Google Analytics - disabled in demo mode (replace GA_MEASUREMENT_ID with actual ID) -->
    <!-- <script async src="https://www.googletagmanager.com/gtag/js?id=GA_MEASUREMENT_ID"></script> -->
    <script>
        // Google Analytics setup with error handling
        window.dataLayer = window.dataLayer || [];
        function gtag(){
            try {
                dataLayer.push(arguments);
            } catch (error) {
                console.warn('Google Analytics error:', error);
            }
        }
        gtag('js', new Date());
        
        // Only configure if this is not a placeholder
        if (typeof gtag === 'function' && 'GA_MEASUREMENT_ID'.startsWith('G-')) {
            // Configure GA4 with enhanced ecommerce and custom parameters
            gtag('config', 'GA_MEASUREMENT_ID', {
            // Enhanced measurement for better insights
            enhanced_measurement_scroll: true,
            enhanced_measurement_outbound_links: true,
            enhanced_measurement_site_search: true,
            enhanced_measurement_video: true,
            enhanced_measurement_file_downloads: true,
            
            // Custom configuration for careers page
            custom_map: {
                'custom_parameter_1': 'job_category',
                'custom_parameter_2': 'application_step',
                'custom_parameter_3': 'form_completion_rate'
            },
            
            // Privacy and data settings
            anonymize_ip: true,
            allow_google_signals: true,
            allow_ad_personalization_signals: false,
            
            // Page-specific settings
            page_title: 'Careers - Opportunities',
            page_location: window.location.href,
            content_group1: 'Careers',
            content_group2: 'Recruitment',
            content_group3: 'Application Portal'
        });
        
        // Set up custom dimensions for career-specific tracking
        gtag('config', 'GA_MEASUREMENT_ID', {
            custom_map: {
                'dimension1': 'user_type',
                'dimension2': 'job_interest',
                'dimension3': 'application_source',
                'dimension4': 'device_category',
                'dimension5': 'engagement_level'
            }
        });
        
        // Enhanced ecommerce for application funnel tracking
        gtag('event', 'begin_checkout', {
            currency: 'USD',
            value: 0,
            items: [{
                item_id: 'career_application',
                item_name: 'Job Application Process',
                item_category: 'Recruitment',
                item_category2: 'Career Portal',
                quantity: 1,
                price: 0
            }]
        });
        } else {
            console.warn('Google Analytics not configured - using placeholder ID');
        }
    </script>
    
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-XXXXXXX');</script>
    <!-- End Google Tag Manager -->
    
    <title>Careers at Manifest Digital | Join Our Team | Remote & On-site Opportunities</title>
    
    <!-- Critical Above-the-Fold CSS -->
    <style>
        /* Critical CSS for immediate rendering */
        body { 
            font-family: 'Anybody', sans-serif; 
            line-height: 1.6; 
            margin: 0; 
            padding: 0; 
        }
        .hero-section { 
            background: linear-gradient(135deg, #FF4900 0%, #ff6b35 100%); 
            color: white; 
            min-height: 100vh; 
            display: flex; 
            align-items: center; 
        }
        .container { 
            max-width: 1200px; 
            margin: 0 auto; 
            padding: 0 15px; 
        }
        .btn-primary { 
            background: #FF4900; 
            border: none; 
            padding: 12px 24px; 
            border-radius: 5px; 
            color: white; 
            text-decoration: none; 
            display: inline-block; 
        }
        .navbar { 
            position: fixed; 
            top: 0; 
            width: 100%; 
            background: rgba(255, 255, 255, 0.95); 
            backdrop-filter: blur(10px); 
            z-index: 1000; 
        }
        .logo-image { 
            max-height: 40px; 
            width: auto; 
        }
        /* Loading state for lazy images */
        img[data-src] { 
            background: #f8f9fa; 
            min-height: 40px; 
        }
        /* Prevent layout shift */
        .hero-stats { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); 
            gap: 2rem; 
            margin-top: 3rem; 
        }
    </style>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anybody:ital,wght@0,400;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS (already preloaded in head) -->
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="styles.css">

    <!-- Anime.js CDN - load synchronously for immediate use -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
    
    <style>
        /* Preloader Styles */
        #preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            overflow: hidden;
        }

        .preloader-container {
            text-align: center;
            position: relative;
        }

        .loader-logo {
            width: 80px;
            height: 80px;
            margin: 0 auto 2rem;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .logo-image {
            width: 50px;
            height: 50px;
            object-fit: contain;
            opacity: 0;
            transform: scale(0.5);
            transition: all 0.6s ease;
        }
        
        .logo-image.loaded {
            opacity: 1;
            transform: scale(1);
        }

        .loading-dots {
            display: flex;
            gap: 8px;
            justify-content: center;
            margin-bottom: 1.5rem;
        }

        .loading-dots .dot {
            width: 12px;
            height: 12px;
            background: #FF4900;
            border-radius: 50%;
            opacity: 0.3;
        }

        .loading-text {
            color: white;
            font-size: 1.1rem;
            font-weight: 400;
            opacity: 0;
            transition: opacity 0.6s ease;
        }

        .loading-text.show {
            opacity: 1;
        }

        .progress-bar-container {
            width: 300px;
            height: 4px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 2px;
            margin-top: 2rem;
            overflow: hidden;
        }

        .progress-bar {
            width: 0%;
            height: 100%;
            background: linear-gradient(90deg, #FF4900, #FF6B35);
            border-radius: 2px;
            transition: width 0.3s ease;
        }

        /* Opportunities Hero Styles */
        .opportunities-hero {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #FFFCFA 0%, #FFF8F3 50%, #FFFCFA 100%);
            overflow: hidden;
            padding: 120px 0 80px;
        }

        .opportunities-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 30% 20%, rgba(255, 73, 0, 0.08) 0%, transparent 50%),
                        radial-gradient(circle at 80% 60%, rgba(255, 107, 53, 0.06) 0%, transparent 50%);
            pointer-events: none;
        }

        .opportunities-hero-content {
            position: relative;
            z-index: 2;
            text-align: center;
            max-width: 1000px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .opportunities-hero h1 {
            font-size: 3.5rem;
            font-weight: 800;
            color: #1a1a1a;
            margin-bottom: 24px;
            line-height: 1.1;
            opacity: 0;
            transform: translateY(30px);
            animation: heroFadeInUp 1s ease-out 0.3s forwards;
        }

        .opportunities-hero .subtitle {
            font-size: 1.4rem;
            color: #666;
            margin-bottom: 48px;
            font-weight: 400;
            line-height: 1.6;
            opacity: 0;
            transform: translateY(30px);
            animation: heroFadeInUp 1s ease-out 0.6s forwards;
        }

        .opportunities-hero-stats {
            display: flex;
            justify-content: center;
            gap: 48px;
            margin-bottom: 48px;
            opacity: 0;
            transform: translateY(30px);
            animation: heroFadeInUp 1s ease-out 0.9s forwards;
        }

        .hero-stat {
            text-align: center;
        }

        .hero-stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #FF4900 0%, #FF6B35 100%);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: block;
        }

        .hero-stat-label {
            font-size: 0.9rem;
            color: #888;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-top: 8px;
        }

        .opportunities-hero-buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
            margin-bottom: 60px;
            opacity: 0;
            transform: translateY(30px);
            animation: heroFadeInUp 1s ease-out 1.2s forwards;
        }

        .hero-btn-primary {
            background: linear-gradient(135deg, #FF4900 0%, #FF6B35 100%);
            color: white;
            padding: 16px 32px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 4px 15px rgba(255, 73, 0, 0.3);
        }

        .hero-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 73, 0, 0.4);
            color: white;
            text-decoration: none;
        }

        .hero-btn-secondary {
            background: rgba(255, 255, 255, 0.8);
            color: #1a1a1a;
            padding: 16px 32px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
            border: 2px solid rgba(255, 73, 0, 0.2);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: inline-flex;
            align-items: center;
            gap: 10px;
            backdrop-filter: blur(10px);
        }

        .hero-btn-secondary:hover {
            transform: translateY(-2px);
            background: rgba(255, 255, 255, 0.95);
            border-color: rgba(255, 73, 0, 0.4);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            color: #1a1a1a;
            text-decoration: none;
        }

        .opportunities-hero-decorative {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            pointer-events: none;
            overflow: hidden;
            z-index: 0;
        }

        .hero-decoration {
            position: absolute;
            opacity: 0.3;
            animation: float 6s ease-in-out infinite;
            background: transparent !important;
        }

        .hero-decoration.left {
            top: 15%;
            left: -5%;
            width: 120px;
            height: 120px;
            animation-delay: 0s;
            z-index: -1;
        }

        .hero-decoration.right {
            top: 20%;
            right: -5%;
            width: 100px;
            height: 100px;
            animation-delay: 2s;
            z-index: -1;
        }

        .hero-decoration.center {
            bottom: 15%;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 80px;
            animation-delay: 4s;
            z-index: -1;
        }

        /* Fix decorative elements globally */
        .decorative-element,
        .decorative {
            position: absolute !important;
            pointer-events: none !important;
            z-index: -1 !important;
            background: transparent !important;
            opacity: 0.4;
        }

        /* Ensure sections with decorative elements have proper positioning */
        .hero-section,
        .work-environment,
        .team-testimonials,
        .cta-footer {
            position: relative;
            z-index: 1;
            overflow: hidden;
        }

        /* CTA Section Decorative Elements Positioning */
        .cta-left {
            left: -40px !important;
            top: 20% !important;
            width: 80px !important;
        }

        .cta-top-right {
            right: -30px !important;
            top: 10% !important;
            width: 70px !important;
        }

        .cta-right-under {
            right: -35px !important;
            bottom: 30% !important;
            width: 75px !important;
        }

        .cta-left-under {
            left: -25px !important;
            bottom: 20% !important;
            width: 65px !important;
        }

        .cta-button-donut {
            left: 10% !important;
            bottom: 10% !important;
            width: 90px !important;
            animation: float 7s ease-in-out infinite reverse;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            25% { transform: translateY(-10px) rotate(2deg); }
            50% { transform: translateY(5px) rotate(-1deg); }
            75% { transform: translateY(-5px) rotate(1deg); }
        }

        /* Life at Manifest Value Cards */
        .life-value-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 30px rgba(255, 73, 0, 0.15);
            border-color: rgba(255, 73, 0, 0.2);
        }

        .life-value-card:hover .rounded-circle {
            transform: scale(1.1);
            transition: transform 0.3s ease;
        }

        /* Benefits Cards Styles */
        .benefits-card {
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .benefits-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .benefits-card:hover .rounded-circle {
            transform: scale(1.05);
            transition: transform 0.3s ease;
        }

        .benefits-card .list-unstyled li {
            transition: all 0.2s ease;
        }

        .benefits-card:hover .list-unstyled li {
            transform: translateX(2px);
        }

        /* Office Culture Highlights Responsive */
        @media (max-width: 768px) {
            .benefits-card .list-unstyled {
                font-size: 0.9rem;
            }
            
            .benefits-card .rounded-circle {
                width: 50px !important;
                height: 50px !important;
            }
            
            .benefits-card .fa-lg {
                font-size: 1rem !important;
            }
        }

        /* Team Testimonials Styles */
        .team-testimonials {
            position: relative;
            overflow: hidden;
        }

        .testimonial-indicator {
            width: 12px !important;
            height: 12px !important;
            border-radius: 50% !important;
            background: rgba(255, 73, 0, 0.3) !important;
            border: none !important;
            margin: 0 8px !important;
            transition: all 0.3s ease !important;
        }

        .testimonial-indicator.active {
            background: linear-gradient(135deg, #FF4900 0%, #FF6B35 100%) !important;
            transform: scale(1.2) !important;
        }

        .carousel-item {
            transition: transform 0.8s ease-in-out;
            padding: 20px 0;
        }

        .testimonial-content blockquote {
            position: relative;
            margin-bottom: 2rem;
            padding-left: 30px;
            padding-top: 20px;
            overflow: visible;
        }

        .testimonial-content .fa-quote-left {
            position: absolute;
            top: -15px;
            left: -15px;
            z-index: 2;
            color: #FF4900 !important;
            font-size: 2rem !important;
            opacity: 1 !important;
            display: block !important;
            visibility: visible !important;
        }

        /* Specific targeting for testimonial quote icons */
        .testimonial-content .fas.fa-quote-left {
            position: absolute !important;
            top: -10px !important;
            right: -10px !important;
            left: auto !important;
            z-index: 10 !important;
            color: #FF4900 !important;
            font-size: 2.5rem !important;
            opacity: 0.8 !important;
            display: block !important;
            visibility: visible !important;
            transform: none !important;
        }

        /* Quote icon container positioning */
        .testimonial-content .mb-4:first-child {
            position: relative !important;
            height: 40px !important;
            overflow: visible !important;
        }

        /* Testimonial content container */
        .testimonial-content .position-relative {
            overflow: visible !important;
            position: relative !important;
        }

        /* Opening quote positioning - Force left positioning */
        .testimonial-content .position-relative .testimonial-quote-left {
            position: absolute !important;
            top: 5px !important;
            left: 5px !important;
            right: auto !important;
            bottom: auto !important;
            font-size: 1.8rem !important;
            z-index: 5 !important;
            color: #FF4900 !important;
            opacity: 0.9 !important;
            line-height: 1 !important;
        }

        /* Closing quote positioning - Force right positioning */
        .testimonial-content .position-relative .testimonial-quote-right {
            position: absolute !important;
            bottom: 5px !important;
            right: 5px !important;
            left: auto !important;
            top: auto !important;
            font-size: 1.8rem !important;
            z-index: 5 !important;
            color: #FF4900 !important;
            opacity: 0.9 !important;
            line-height: 1 !important;
        }

        /* Ensure blockquote has proper spacing for quotes */
        .testimonial-content .position-relative blockquote {
            margin: 15px 10px !important;
            padding: 15px 25px !important;
            position: relative !important;
            z-index: 1 !important;
        }

        .testimonial-photo-container {
            position: relative;
            transition: transform 0.3s ease;
        }

        .testimonial-photo-container:hover {
            transform: scale(1.05);
        }

        .timeline-item {
            position: relative;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: 5px;
            top: 25px;
            width: 1px;
            height: calc(100% + 8px);
            background: linear-gradient(to bottom, #FF4900, transparent);
        }

        .timeline-item:last-child::before {
            display: none;
        }

        .carousel-control-prev,
        .carousel-control-next {
            width: auto;
            opacity: 0.8;
            transition: opacity 0.3s ease;
        }

        .carousel-control-prev:hover,
        .carousel-control-next:hover {
            opacity: 1;
        }

        .carousel-control-icon:hover {
            transform: scale(1.1);
            transition: transform 0.2s ease;
        }

        /* Testimonials Responsive Design */
        @media (max-width: 768px) {
            .testimonial-photo-container {
                width: 150px !important;
                height: 150px !important;
            }

            .testimonial-content {
                padding-left: 0 !important;
                margin-top: 2rem;
            }

            .testimonial-content blockquote {
                font-size: 1rem !important;
                text-align: center;
            }

            .testimonial-content .fa-quote-left {
                position: relative;
                display: block !important;
                text-align: center;
                left: 0;
                top: 0;
                margin-bottom: 1rem;
                visibility: visible !important;
                color: #FF4900;
                font-size: 1.2rem;
                opacity: 0.7;
            }

            .carousel-control-prev,
            .carousel-control-next {
                display: none;
            }

            .achievements .row,
            .business-growth .row {
                justify-content: center;
            }

            .results-highlights .row {
                gap: 1rem;
            }

            .timeline-item::before {
                display: none;
            }
        }

        @media (max-width: 480px) {
            .testimonial-content blockquote {
                font-size: 0.95rem !important;
                line-height: 1.5 !important;
            }

            .timeline-items,
            .achievements,
            .business-growth,
            .results-highlights {
                margin-top: 1.5rem;
            }
        }

        /* Application Success Section Styles */
        .application-success {
            position: relative;
            overflow: hidden;
        }

        .success-checkmark {
            animation: checkmark-appear 0.8s ease-out 0.5s both;
        }

        @keyframes checkmark-appear {
            0% {
                transform: scale(0) rotate(-45deg);
                opacity: 0;
            }
            50% {
                transform: scale(1.2) rotate(-45deg);
                opacity: 1;
            }
            100% {
                transform: scale(1) rotate(0deg);
                opacity: 1;
            }
        }

        @keyframes pulse-ring {
            0% {
                transform: translateX(-50%) scale(0.8);
                opacity: 1;
            }
            100% {
                transform: translateX(-50%) scale(1.4);
                opacity: 0;
            }
        }

        .timeline-step {
            transition: all 0.3s ease;
        }

        .timeline-step:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .timeline-step:hover .step-number {
            transform: scale(1.1);
        }

        .social-link:hover {
            transform: scale(1.1);
        }

        .reference-number {
            animation: reference-glow 2s ease-in-out infinite alternate;
        }

        @keyframes reference-glow {
            0% {
                box-shadow: 0 0 10px rgba(155, 89, 182, 0.3);
            }
            100% {
                box-shadow: 0 0 20px rgba(155, 89, 182, 0.6);
            }
        }

        /* Success Section Responsive Design */
        @media (max-width: 768px) {
            .success-icon-container {
                margin-bottom: 2rem !important;
            }

            .success-circle {
                width: 100px !important;
                height: 100px !important;
            }

            .success-checkmark {
                font-size: 2rem !important;
            }

            .success-ring-1,
            .success-ring-2 {
                display: none;
            }

            .timeline-step {
                margin-bottom: 2rem;
            }

            .display-4 {
                font-size: 2rem !important;
            }

            .reference-number {
                font-size: 0.9rem !important;
                letter-spacing: 0.5px !important;
            }
        }

        @media (max-width: 480px) {
            .timeline-step .step-number {
                width: 40px !important;
                height: 40px !important;
                font-size: 0.9rem;
            }

            .timeline-step .fa-2x {
                font-size: 1.5rem !important;
            }

            .social-links {
                justify-content: center !important;
            }

            .contact-details .d-flex {
                flex-direction: column;
                align-items: flex-start !important;
                gap: 0.5rem;
            }

            .contact-details i {
                margin-right: 0 !important;
                margin-bottom: 0.25rem;
            }
        }

        /* Opportunities Listing Styles */
        .opportunities-listing .filter-btn {
            background: white;
            color: #666;
            border: 2px solid #ddd;
            padding: 12px 24px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .opportunities-listing .filter-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(255, 73, 0, 0.2);
        }

        .opportunities-listing .filter-btn.active {
            background: linear-gradient(135deg, #FF4900 0%, #FF6B35 100%) !important;
            color: white !important;
            border-color: #FF4900 !important;
        }

        .opportunities-listing .filter-btn:not(.active):hover {
            background: rgba(255, 73, 0, 0.1) !important;
            border-color: #FF4900 !important;
            color: #FF4900 !important;
        }

        .opportunities-listing .search-box input:focus {
            outline: none;
            border-color: #FF4900;
            box-shadow: 0 0 0 3px rgba(255, 73, 0, 0.1);
        }

        /* Base opportunity card styles */
        .opportunity-card {
            background: transparent !important;
            background-color: transparent !important;
            border: none !important;
        }

        .opportunity-card .card {
            cursor: pointer;
            background: transparent !important;
            background-color: transparent !important;
            border: none !important;
        }

        .opportunity-card .card,
        .opportunity-card .card-body {
            background: transparent !important;
            background-color: transparent !important;
            border: none !important;
        }

        .opportunity-card .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            background: transparent !important;
            background-color: transparent !important;
            border: none !important;
        }

        .opportunity-card:hover .card-body {
            background: transparent !important;
            background-color: transparent !important;
        }

        .opportunity-card .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 73, 0, 0.3);
        }

        .opportunity-card .badge {
            font-size: 0.75rem;
            padding: 0.35em 0.65em;
        }

        /* Opportunity Modal Styles */
        .modal-content {
            max-height: 90vh;
        }

        .modal-type-badge {
            font-size: 0.75rem;
            padding: 0.35em 0.65em;
        }

        .modal-department-badge {
            background: rgba(102,102,102,0.1) !important;
            color: #666 !important;
            font-size: 0.75rem;
            padding: 0.35em 0.65em;
        }

        .modal-skills .badge {
            background: rgba(255,73,0,0.1);
            color: #FF4900;
            font-size: 0.75rem;
            padding: 0.35em 0.65em;
            margin-bottom: 0.5rem;
        }

        .modal-footer .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        /* Application Form Styles - Using unique class names for this wizard */
        .career-application-progress {
            position: relative;
        }

        .career-progress-step {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            z-index: 2;
            background: transparent !important;
            border: none !important;
            outline: none !important;
            box-shadow: none !important;
            -webkit-appearance: none !important;
            -moz-appearance: none !important;
            appearance: none !important;
        }

        .career-step-circle {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.9) !important;
            border: 2px solid #ddd !important;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 8px;
            position: relative;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
        }

        .career-progress-step.active .career-step-circle {
            border-color: #FF4900 !important;
            background: linear-gradient(135deg, #FF4900 0%, #FF6B35 100%) !important;
            color: white !important;
            box-shadow: 0 4px 20px rgba(255, 73, 0, 0.3) !important;
            outline: none !important;
            transform: scale(1.1);
        }

        .career-progress-step.completed .career-step-circle {
            border-color: #28a745 !important;
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important;
            color: white !important;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3) !important;
        }

        .career-progress-step.completed .career-step-number {
            display: none;
        }

        .career-progress-step.completed .career-step-check {
            display: block !important;
        }

        .career-step-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: #666;
            text-align: center;
            max-width: 100px;
            background: transparent !important;
            border: none !important;
            padding: 0;
        }

        .career-progress-step.active .career-step-label {
            color: #FF4900;
            font-weight: 700;
        }

        .career-progress-line {
            flex: 1;
            height: 3px;
            background: #ddd;
            margin: 0 10px;
            position: relative;
            top: -21px;
        }

        .career-form-step {
            display: none;
        }

        .career-form-step.active {
            display: block;
            animation: careerFadeInUp 0.5s ease;
        }

        /* Remove unwanted focus outlines from all career form elements */
        .career-progress-step,
        .career-progress-step.active,
        .career-progress-step.completed,
        .career-step-circle,
        .career-step-number,
        .career-step-label {
            outline: none !important;
        }

        /* Ensure no yellow highlighting or rectangular backgrounds for career form */
        .career-progress-step *,
        .career-progress-container *,
        .career-form-progress * {
            box-sizing: border-box !important;
        }

        /* Override any browser default styling for career form */
        .career-progress-step {
            -webkit-appearance: none !important;
            -moz-appearance: none !important;
            appearance: none !important;
        }

        .career-progress-step.active {
            outline: none !important;
            box-shadow: none !important;
        }

        @keyframes careerFadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #FF4900;
            box-shadow: 0 0 0 0.2rem rgba(255, 73, 0, 0.25);
        }

        .file-upload-area:hover .file-upload-content {
            border-color: #FF4900;
            background: rgba(255, 73, 0, 0.02);
        }

        .file-upload-area.dragover .file-upload-content {
            border-color: #FF4900;
            background: rgba(255, 73, 0, 0.05);
            border-style: solid;
        }

        .summary-item {
            margin-bottom: 1rem;
        }

        .summary-value {
            font-weight: 600;
            color: #333;
            margin-top: 4px;
            padding: 8px 12px;
            background: rgba(255, 73, 0, 0.05);
            border-radius: 6px;
            border-left: 3px solid #FF4900;
        }

        .form-navigation .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .opportunities-filters-tabs {
                justify-content: flex-start !important;
                overflow-x: auto;
                padding-bottom: 8px;
                scrollbar-width: none;
                -ms-overflow-style: none;
            }
            
            .opportunities-filters-tabs::-webkit-scrollbar {
                display: none;
            }

            .modal-dialog {
                margin: 1rem;
            }
            
            .modal-body {
                padding: 16px !important;
            }
            
            .modal-header,
            .modal-footer {
                padding: 16px !important;
            }

            .career-application-progress {
                margin-bottom: 2rem !important;
            }

            .career-step-circle {
                width: 40px;
                height: 40px;
            }

            .career-step-label {
                font-size: 0.75rem;
                max-width: 80px;
            }

            .career-progress-line {
                margin: 0 5px;
                top: -16px;
            }

            .form-navigation {
                flex-direction: column;
                gap: 1rem;
            }

            .form-navigation .ms-auto {
                margin-left: 0 !important;
            }
        }

        @keyframes heroFadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .opportunities-hero {
                min-height: 90vh;
                padding: 100px 0 60px;
            }

            .opportunities-hero h1 {
                font-size: 2.5rem;
                margin-bottom: 20px;
            }

            .opportunities-hero .subtitle {
                font-size: 1.2rem;
                margin-bottom: 36px;
            }

            .opportunities-hero-stats {
                gap: 32px;
                margin-bottom: 36px;
            }

            .hero-stat-number {
                font-size: 2rem;
            }

            .opportunities-hero-buttons {
                flex-direction: column;
                align-items: center;
                gap: 16px;
                margin-bottom: 40px;
            }

            .hero-btn-primary,
            .hero-btn-secondary {
                width: 100%;
                max-width: 280px;
                justify-content: center;
                padding: 14px 24px;
                font-size: 1rem;
            }

            .hero-decoration.left,
            .hero-decoration.right,
            .hero-decoration.center {
                display: none;
            }
        }

        @media (max-width: 480px) {
            .opportunities-hero h1 {
                font-size: 2rem;
            }

            .opportunities-hero .subtitle {
                font-size: 1.1rem;
            }

            .opportunities-hero-stats {
                flex-direction: column;
                gap: 24px;
            }

            .hero-stat-number {
                font-size: 1.8rem;
            }
        }

        /* Enhanced Mobile Optimizations */
        @media (max-width: 992px) {
            .opportunity-card {
                margin-bottom: 20px;
            }

            .modal-dialog {
                margin: 10px;
                max-width: calc(100vw - 20px);
            }

            .modal-body {
                padding: 20px 15px;
            }

            .benefits-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .testimonial-content {
                padding: 20px;
            }

            .timeline-item {
                padding: 15px 20px;
            }
        }

        @media (max-width: 768px) {
            /* File upload areas mobile optimization */
            .file-upload-area .file-upload-content {
                padding: 20px 15px !important;
                min-height: 120px;
                display: flex;
                flex-direction: column;
                justify-content: center;
            }

            .file-upload-content i {
                font-size: 1.5rem !important;
                margin-bottom: 12px !important;
            }

            .file-upload-content p {
                font-size: 0.9rem;
                margin-bottom: 8px;
            }

            /* Form step navigation mobile */
            .form-navigation {
                padding: 15px 0;
                gap: 10px;
            }

            .btn-nav {
                padding: 12px 20px;
                font-size: 0.9rem;
                flex: 1;
                min-width: 0;
            }

            /* Application form mobile spacing */
            .career-form-step .card {
                margin-bottom: 20px;
            }

            .career-form-step .card-body {
                padding: 20px 15px !important;
            }

            /* Progress indicator mobile */
            .progress-indicator {
                padding: 15px 20px;
                margin-bottom: 20px;
            }

            .career-progress-step {
                min-width: 40px;
                height: 40px;
                font-size: 0.8rem;
            }

            .career-progress-step-label {
                font-size: 0.7rem;
                margin-top: 5px;
            }

            /* Touch-friendly buttons */
            .opportunity-card .btn,
            .filter-btn,
            .hero-btn-primary,
            .hero-btn-secondary {
                min-height: 44px;
                padding: 12px 20px;
            }

            /* Modal adjustments */
            .modal-header {
                padding: 15px;
            }

            .modal-title {
                font-size: 1.3rem;
            }

            .modal-footer {
                padding: 15px;
                gap: 10px;
            }

            .modal-footer .btn {
                flex: 1;
                min-height: 44px;
            }

            /* Testimonials mobile */
            .carousel-control-prev,
            .carousel-control-next {
                width: 44px;
                height: 44px;
                border-radius: 50%;
                background: rgba(255, 73, 0, 0.1);
                border: 2px solid rgba(255, 73, 0, 0.2);
            }

            .carousel-indicators button {
                width: 12px;
                height: 12px;
                border-radius: 50%;
                margin: 0 5px;
            }
        }

        @media (max-width: 576px) {
            /* Extra small screens */
            .opportunities-hero {
                padding: 100px 0 60px;
                min-height: auto;
            }

            .opportunities-hero-content {
                padding: 0 15px;
            }

            .opportunities-hero-buttons {
                flex-direction: column;
                align-items: stretch;
                gap: 15px;
                max-width: 300px;
                margin: 0 auto 40px;
            }

            .hero-btn-primary,
            .hero-btn-secondary {
                width: 100%;
                text-align: center;
            }

            /* Opportunities section */
            .section-title {
                font-size: 2rem !important;
                margin-bottom: 30px;
            }

            .opportunities-filters {
                flex-direction: column;
                gap: 15px;
                align-items: stretch;
            }

            .filter-buttons {
                flex-wrap: wrap;
                gap: 8px;
            }

            .filter-btn {
                flex: 1;
                min-width: calc(50% - 4px);
                font-size: 0.8rem;
                padding: 10px 12px;
            }

            .search-box {
                width: 100%;
            }

            /* Benefits section */
            .benefits-card {
                margin-bottom: 15px;
            }

            .benefits-card .card-body {
                padding: 20px 15px;
            }

            /* Application form */
            .application-form-container {
                padding: 0 10px;
            }

            .career-form-step .row.g-3 {
                --bs-gutter-x: 0.75rem;
            }

            /* Success section */
            .success-section {
                padding: 40px 15px;
            }

            .success-timeline {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .timeline-item {
                text-align: center;
            }

            .success-actions {
                flex-direction: column;
                gap: 15px;
            }

            .success-actions .btn {
                width: 100%;
            }
        }

        /* Tablet-specific optimizations */
        @media (min-width: 768px) and (max-width: 1024px) {
            .opportunities-hero-stats {
                gap: 32px;
            }

            .benefits-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 24px;
            }

            .opportunities-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 24px;
            }

            .modal-dialog {
                max-width: 90vw;
            }

            .career-form-step .row.g-3 {
                --bs-gutter-x: 2rem;
            }
        }

        /* Landscape mobile optimizations */
        @media (max-height: 500px) and (orientation: landscape) {
            .opportunities-hero {
                min-height: auto;
                padding: 60px 0 40px;
            }

            .opportunities-hero h1 {
                font-size: 2.5rem;
                margin-bottom: 16px;
            }

            .opportunities-hero .subtitle {
                font-size: 1.2rem;
                margin-bottom: 24px;
            }

            .opportunities-hero-stats {
                margin-bottom: 24px;
            }

            .opportunities-hero-buttons {
                margin-bottom: 30px;
            }
        }

        /* High DPI displays */
        @media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
            .hero-decoration img,
            .logo-image {
                image-rendering: -webkit-optimize-contrast;
                image-rendering: crisp-edges;
            }
        }

        /* Reduced motion preferences */
        @media (prefers-reduced-motion: reduce) {
            .opportunities-hero h1,
            .opportunities-hero .subtitle,
            .opportunities-hero-stats,
            .opportunities-hero-buttons {
                animation: none;
                opacity: 1;
                transform: none;
            }

            .opportunity-card,
            .benefits-card {
                transition: none;
            }

            .carousel {
                transition: none;
            }

            .carousel-item {
                transition: none;
            }
        }

        /* Dark mode support - excluding modals */
        @media (prefers-color-scheme: dark) {
            .file-upload-content {
                background: #2d2d2d !important;
                border-color: #555 !important;
                color: #fff;
            }

            .file-upload-content i {
                color: #aaa !important;
            }

            .form-control,
            .form-select {
                background: #2d2d2d;
                border-color: #555;
                color: #fff;
            }

            .form-control:focus,
            .form-select:focus {
                background: #2d2d2d;
                border-color: #FF4900;
                color: #fff;
                box-shadow: 0 0 0 0.2rem rgba(255, 73, 0, 0.25);
            }
        }

        /* Force light mode for all modals - override dark mode */
        .modal-content,
        .modal-header,
        .modal-body,
        .modal-footer {
            background: #fff !important;
            color: #333 !important;
        }

        .modal-title {
            color: #333 !important;
        }

        .modal .btn-close {
            filter: invert(1) grayscale(100%) brightness(200%) !important;
        }

        .modal .form-control,
        .modal .form-select {
            background: #fff !important;
            color: #333 !important;
            border-color: #ddd !important;
        }

        .modal .form-control:focus,
        .modal .form-select:focus {
            background: #fff !important;
            color: #333 !important;
            border-color: #FF4900 !important;
            box-shadow: 0 0 0 0.2rem rgba(255, 73, 0, 0.25) !important;
        }

        /* Modal badges and elements */
        .modal .modal-type-badge,
        .modal .modal-department-badge {
            background: #f8f9fa !important;
            color: #495057 !important;
            border: 1px solid #dee2e6 !important;
        }

        /* Modal backdrop should remain standard */
        .modal-backdrop {
            background-color: rgba(0, 0, 0, 0.5) !important;
        }

        /* Accessibility Enhancements */
        
        /* Focus Management */
        .btn:focus,
        .form-control:focus,
        .form-select:focus,
        .filter-btn:focus {
            outline: 2px solid #FF4900;
            outline-offset: 2px;
            box-shadow: 0 0 0 0.2rem rgba(255, 73, 0, 0.25);
        }

        .opportunity-card:focus-within {
            outline: 2px solid #FF4900;
            outline-offset: 2px;
        }

        /* High Contrast Mode Support */
        @media (prefers-contrast: high) {
            .opportunity-card,
            .benefits-card,
            .testimonial-card {
                border: 2px solid currentColor;
            }

            .btn {
                border: 2px solid currentColor;
            }

            .filter-btn.active {
                background: #000 !important;
                color: #fff !important;
                border: 2px solid #fff;
            }
        }

        /* Skip Links */
        .skip-link {
            position: absolute;
            top: -40px;
            left: 6px;
            background: #FF4900;
            color: white;
            padding: 8px;
            text-decoration: none;
            border-radius: 4px;
            z-index: 9999;
            font-weight: 600;
        }

        .skip-link:focus {
            top: 6px;
        }

        /* Screen Reader Only Content */
        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }

        .sr-only-focusable:focus {
            position: static;
            width: auto;
            height: auto;
            padding: inherit;
            margin: inherit;
            overflow: visible;
            clip: auto;
            white-space: normal;
        }

        /* Error States */
        .form-control.is-invalid,
        .form-select.is-invalid {
            border-color: #dc3545;
            padding-right: calc(1.5em + 0.75rem);
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath d='M5.8 4.6L6.2 4.6 6.2 6.6 5.8 6.6z M5.8 7.4L6.2 7.4 6.2 7.8 5.8 7.8z'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }

        .invalid-feedback {
            display: block;
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        /* Loading States */
        .loading {
            position: relative;
            color: transparent;
        }

        .loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            margin: -10px 0 0 -10px;
            border: 2px solid #f3f3f3;
            border-top: 2px solid #FF4900;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Form Labels Enhancement */
        .form-label {
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #333;
        }

        .form-label.required::after {
            content: ' *';
            color: #dc3545;
        }

        /* File Upload Accessibility */
        .file-upload-area[aria-invalid="true"] .file-upload-content {
            border-color: #dc3545;
            background-color: #f8d7da;
        }

        .file-upload-area .file-preview {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 12px;
            background: #f8f9fa;
        }

        /* Error Handling Styles */
        .upload-error .file-upload-content {
            border-color: #dc3545 !important;
            background-color: #f8d7da !important;
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            50% { transform: translateX(5px); }
            75% { transform: translateX(-3px); }
        }

        /* Global Error Container */
        #global-error-container .alert {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95) !important;
            border: none;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border-left: 4px solid;
        }

        #global-error-container .alert-danger {
            border-left-color: #dc3545;
            color: #721c24;
        }

        #global-error-container .alert-warning {
            border-left-color: #ffc107;
            color: #856404;
        }

        #global-error-container .alert-success {
            border-left-color: #28a745;
            color: #155724;
        }

        #global-error-container .alert-info {
            border-left-color: #17a2b8;
            color: #0c5460;
        }

        /* Form Validation Enhancement */
        .form-control.is-invalid {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
            animation: pulse-error 1s ease-in-out;
        }

        @keyframes pulse-error {
            0% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.25); }
            70% { box-shadow: 0 0 0 0.4rem rgba(220, 53, 69, 0); }
            100% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0); }
        }

        /* Loading States */
        .btn[aria-busy="true"] {
            position: relative;
            pointer-events: none;
        }

        .btn[aria-busy="true"]:after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.1);
            border-radius: inherit;
        }



        /* Modal Accessibility */
        .modal[aria-hidden="true"] {
            display: none;
        }

        .modal-backdrop {
            background-color: rgba(0, 0, 0, 0.5);
        }

        /* Keyboard Navigation Indicators */
        .carousel:focus-within .carousel-control-prev,
        .carousel:focus-within .carousel-control-next {
            opacity: 1;
        }

        .carousel-indicators button:focus {
            outline: 2px solid #FF4900;
            outline-offset: 2px;
        }

        /* Career Progress Indicator Accessibility */
        .career-progress-step[aria-current="step"] {
            background: linear-gradient(135deg, #FF4900 0%, #FF6B35 100%);
            color: white;
            border: 2px solid #FF4900;
        }

        .career-progress-step[aria-completed="true"] {
            background: #28a745;
            color: white;
            border: 2px solid #28a745;
        }

        /* Filter Button States */
        .filter-btn[aria-pressed="true"] {
            background: linear-gradient(135deg, #FF4900 0%, #FF6B35 100%);
            color: white;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Search Input Enhancement */
        .search-input {
            position: relative;
        }

        .search-input::before {
            content: '\f002';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            z-index: 2;
        }

        .search-input input {
            padding-left: 40px;
        }

        /* Status Messages */
        .status-message {
            padding: 12px 16px;
            border-radius: 8px;
            margin: 16px 0;
            font-weight: 500;
        }

        .status-message.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .status-message.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .status-message.info {
            background: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }

        /* Animation Enhancements */
        .opportunity-card,
        .benefits-card,
        .value-card,
        .career-form-step,
        .modal-dialog {
            will-change: transform, opacity;
            backface-visibility: hidden;
            transform-style: preserve-3d;
        }

        /* Smooth transitions for interactive elements */
        .btn-primary,
        .btn-outline-primary,
        .filter-btn,
        .form-control,
        .file-upload-area {
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            will-change: transform;
        }

        /* Enhanced hover states */
        .opportunity-card:hover {
            background: transparent !important;
            background-color: transparent !important;
            border: none !important;
        }

        .opportunity-card:hover .card {
            box-shadow: 0 10px 30px rgba(255, 73, 0, 0.1);
        }

        .benefits-card:hover {
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .value-card:hover {
            box-shadow: 0 15px 35px rgba(255, 73, 0, 0.12);
        }

        /* Career form step transitions */
        .career-form-step {
            transform-origin: center center;
        }

        .career-form-step.transitioning {
            pointer-events: none;
        }

        /* Loading state enhancements */
        .btn[aria-busy="true"] {
            position: relative;
            overflow: hidden;
        }

        .btn[aria-busy="true"]:before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            animation: shimmer 1.5s infinite;
        }

        @keyframes shimmer {
            0% { left: -100%; }
            100% { left: 100%; }
        }

        /* Success animations */
        .success-content > * {
            transform: translateY(30px);
            opacity: 0;
        }

        .success-checkmark {
            transform: scale(0);
            animation: checkmarkBounce 0.8s ease-out 0.3s forwards;
        }

        @keyframes checkmarkBounce {
            0% { transform: scale(0) rotate(0deg); }
            50% { transform: scale(1.2) rotate(180deg); }
            100% { transform: scale(1) rotate(360deg); }
        }

        /* Notification slide animations */
        .alert {
            transform: translateX(300px);
            opacity: 0;
            animation: slideInRight 0.5s ease-out forwards;
        }

        @keyframes slideInRight {
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        /* Performance optimizations */
        .animated-element {
            transform: translateZ(0);
            backface-visibility: hidden;
            perspective: 1000px;
        }

        /* Critical CSS for above-the-fold content */
        .critical-image {
            display: block;
            max-width: 100%;
            height: auto;
        }

        .lazy-loading {
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .lazy-loaded {
            opacity: 1;
        }

        .lazy-error {
            opacity: 0.5;
            background-color: #f8f9fa;
            border: 1px dashed #dee2e6;
        }

        /* Optimize rendering performance */
        .opportunity-card,
        .benefits-card,
        .value-card,
        .testimonial-card {
            transform: translateZ(0);
            backface-visibility: hidden;
            will-change: auto;
        }

        .opportunity-card:hover,
        .benefits-card:hover,
        .value-card:hover,
        .testimonial-card:hover {
            will-change: transform;
        }

        /* Optimize form performance */
        .form-control,
        .form-select,
        .btn {
            transform: translateZ(0);
        }

        /* Optimize modal performance */
        .modal {
            backface-visibility: hidden;
        }

        .modal-dialog {
            transform: translateZ(0);
        }

        /* GPU acceleration for animations */
        @keyframes optimizedFadeIn {
            from {
                opacity: 0;
                transform: translate3d(0, 20px, 0);
            }
            to {
                opacity: 1;
                transform: translate3d(0, 0, 0);
            }
        }

        .animate-on-scroll {
            animation: optimizedFadeIn 0.6s ease-out;
        }

        /* Contain layout shifts */
        .hero-section,
        .application-form,
        .opportunities-grid {
            contain: layout style paint;
        }

        /* Optimize carousel performance */
        .carousel-item {
            transform: translateZ(0);
            backface-visibility: hidden;
        }

        /* Optimize loading states */
        .loading {
            contain: strict;
        }

        /* Font display optimization - applied to external fonts */
        * {
            font-display: swap;
        }

        /* Animation Preferences */
        @media (prefers-reduced-motion: reduce) {
            .loading::after {
                animation: none;
            }
            
            .carousel-item {
                transition: none;
            }
            
            .opportunity-card,
            .benefits-card,
            .value-card,
            .career-form-step,
            .modal-dialog,
            .btn-primary,
            .btn-outline-primary,
            .filter-btn,
            .form-control,
            .file-upload-area {
                transform: none !important;
                transition: none !important;
                animation: none !important;
                will-change: auto;
            }

            .success-checkmark {
                animation: none;
                transform: scale(1);
            }

            .alert {
                animation: none;
                transform: translateX(0);
                opacity: 1;
            }

            .btn[aria-busy="true"]:before {
                animation: none;
            }
        }
    </style>
</head>

<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-XXXXXXX"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    
    <!-- Skip Links for Accessibility -->
    <a href="#main-content" class="skip-link">Skip to main content</a>
    <a href="#opportunities-section" class="skip-link">Skip to job opportunities</a>
    <a href="#application-form" class="skip-link">Skip to application form</a>

    <!-- Preloader -->
    <div id="preloader" role="status" aria-label="Loading career opportunities page">
        <div class="preloader-container">
            <div class="loader-logo">
                <img src="images/logos/favicon.png" alt="Manifest Digital Logo" class="logo-image critical-image">
            </div>
            <div class="loading-dots" aria-hidden="true">
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
            </div>
            <div class="loading-text">Building amazing career opportunities...</div>
            <div class="progress-bar-container" aria-hidden="true">
                <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
        <span class="sr-only">Page is loading, please wait...</span>
    </div>

    <!-- Reading Tracker Progress Bar -->
    <div class="reading-tracker"></div>
    
    <!-- Notification Topbar -->
    <div class="notification-topbar">
        <span class="notification-icon">🚀</span>
        <div class="notification-content">
            <span class="notification-text">
                We're Hiring! Join our growing team of 15+ talented professionals • Remote and hybrid positions available
            </span>
            <a href="#opportunities" class="notification-cta">View Positions</a>
        </div>
        <button class="notification-close" aria-label="Close notification">×</button>
    </div>
    
    <header class="primary-header transparent">
        <a href="index.html" class="logo"></a>
      
        <nav>
            <a href="index.html">Home</a>
            <a href="projects.html">Projects</a>
            <a href="ai-sensei-chat.html">AI Sensei</a>
            <a href="opportunities.html" class="active">Opportunities</a>
            <a href="book-a-call.html">Book a Call</a>
        </nav>
        <div class="header-right">
            <a href="auth/auth.html" class="login">Login</a>
            <a href="quote-request.html" class="btn-primary">Get a Quote</a>
        </div>
        
        <!-- Mobile menu toggle -->
        <button class="mobile-menu-toggle" aria-label="Toggle menu">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </button>
    </header>

    <!-- Mobile navigation overlay -->
    <div class="mobile-nav-overlay"></div>
    
    <!-- Mobile navigation menu -->
    <div class="mobile-nav">
        <nav>
            <a href="index.html">Home</a>
            <a href="projects.html">Projects</a>
            <a href="ai-sensei-chat.html">AI Sensei</a>
            <a href="opportunities.html" class="active">Opportunities</a>
            <a href="book-a-call.html">Book a Call</a>
        </nav>
        <div class="mobile-nav-buttons">
            <a href="auth/auth.html" class="login">Login</a>
            <a href="quote-request.html" class="btn-primary">Get a Quote</a>
        </div>
    </div>

    <!-- Opportunities Hero Section -->
    <section class="opportunities-hero" id="main-content" role="banner">
        <!-- Decorative elements -->
        <div class="opportunities-hero-decorative" aria-hidden="true">
            <img src="images/decorative/hero_left_mem_dots_f_circle3.svg" alt="" class="hero-decoration left">
            <img src="images/decorative/hero_right_circle-con3.svg" alt="" class="hero-decoration right">
            <img src="images/decorative/mem_donut.svg" alt="" class="hero-decoration center">
        </div>
        
        <div class="opportunities-hero-content">
            <h1>Join the Manifest Digital Team</h1>
            <p class="subtitle">
                Build the future of digital solutions with Ghana's leading development team. 
                Where innovation meets collaboration, and every project shapes tomorrow.
            </p>
            
            <!-- Hero Statistics -->
            <div class="opportunities-hero-stats" role="group" aria-label="Company statistics">
                <div class="hero-stat">
                    <span class="hero-stat-number" aria-label="Over 10 years">10+</span>
                    <span class="hero-stat-label">Years Experience</span>
                </div>
                <div class="hero-stat">
                    <span class="hero-stat-number" aria-label="Over 40 projects">40+</span>
                    <span class="hero-stat-label">Projects Delivered</span>
                </div>
                <div class="hero-stat">
                    <span class="hero-stat-number" aria-label="Over 15 team members">15+</span>
                    <span class="hero-stat-label">Team Members</span>
                </div>
            </div>
            
            <!-- Hero Action Buttons -->
            <div class="opportunities-hero-buttons">
                <a href="#opportunities" class="hero-btn-primary">
                    <i class="fas fa-briefcase"></i>
                    View Open Positions
                </a>
                <a href="#culture" class="hero-btn-secondary">
                    <i class="fas fa-heart"></i>
                    Learn About Our Culture
                </a>
            </div>
        </div>
    </section>

    <!-- Life at Manifest Digital Section -->
    <section id="culture" class="life-at-manifest py-5 position-relative" style="background-color: #FFFCFA; overflow: hidden;">
        <!-- Decorative Elements positioned at viewport edges -->
        <img data-src="images/decorative/hero_left_mem_dots_f_circle3.svg" alt="" class="position-absolute d-none d-lg-block" style="left: -30px; top: 20%; width: 60px; opacity: 0.6; animation: float 6s ease-in-out infinite; background: transparent !important;" loading="lazy">
        <img data-src="images/decorative/how_it_works_mem_dots_f_circle2.svg" alt="" class="position-absolute d-none d-lg-block" style="right: -40px; top: 60%; width: 80px; opacity: 0.7; animation: float 8s ease-in-out infinite reverse; background: transparent !important;" loading="lazy">
        
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center mb-5">
                    <h2 class="display-5 fw-bold mb-4 life-at-manifest" style="color: #000;">Life at Manifest Digital</h2>
                    <p class="lead" style="color: #666; font-size: 1.25rem; line-height: 1.6;">
                        We're more than just a team – we're a family of innovators, creators, and problem-solvers 
                        passionate about building digital experiences that matter.
                    </p>
                </div>
            </div>

            <!-- Company Values Grid -->
            <div class="row g-4 mb-5">
                <div class="col-md-6 col-lg-3">
                    <div class="text-center h-100 p-4 rounded-3 life-value-card" style="background: linear-gradient(135deg, rgba(255,73,0,0.05) 0%, rgba(255,107,53,0.05) 100%); border: 1px solid rgba(255,73,0,0.1); transition: all 0.3s ease;">
                        <div class="mb-3">
                            <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center" style="width: 70px; height: 70px; background: linear-gradient(135deg, #FF4900 0%, #FF6B35 100%);">
                                <i class="fas fa-lightbulb fa-lg text-white"></i>
                            </div>
                        </div>
                        <h4 class="h5 fw-bold mb-3" style="color: #FF4900;">Innovation First</h4>
                        <p class="small mb-0" style="color: #666; line-height: 1.5;">
                            We embrace cutting-edge technologies and creative solutions to solve complex challenges.
                        </p>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-3">
                    <div class="text-center h-100 p-4 rounded-3 life-value-card" style="background: linear-gradient(135deg, rgba(255,73,0,0.05) 0%, rgba(255,107,53,0.05) 100%); border: 1px solid rgba(255,73,0,0.1); transition: all 0.3s ease;">
                        <div class="mb-3">
                            <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center" style="width: 70px; height: 70px; background: linear-gradient(135deg, #FF4900 0%, #FF6B35 100%);">
                                <i class="fas fa-users fa-lg text-white"></i>
                            </div>
                        </div>
                        <h4 class="h5 fw-bold mb-3" style="color: #FF4900;">Team Collaboration</h4>
                        <p class="small mb-0" style="color: #666; line-height: 1.5;">
                            We believe great ideas come from diverse perspectives working together seamlessly.
                        </p>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-3">
                    <div class="text-center h-100 p-4 rounded-3 life-value-card" style="background: linear-gradient(135deg, rgba(255,73,0,0.05) 0%, rgba(255,107,53,0.05) 100%); border: 1px solid rgba(255,73,0,0.1); transition: all 0.3s ease;">
                        <div class="mb-3">
                            <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center" style="width: 70px; height: 70px; background: linear-gradient(135deg, #FF4900 0%, #FF6B35 100%);">
                                <i class="fas fa-chart-line fa-lg text-white"></i>
                            </div>
                        </div>
                        <h4 class="h5 fw-bold mb-3" style="color: #FF4900;">Continuous Growth</h4>
                        <p class="small mb-0" style="color: #666; line-height: 1.5;">
                            We invest in our team's professional development and encourage learning at every step.
                        </p>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-3">
                    <div class="text-center h-100 p-4 rounded-3 life-value-card" style="background: linear-gradient(135deg, rgba(255,73,0,0.05) 0%, rgba(255,107,53,0.05) 100%); border: 1px solid rgba(255,73,0,0.1); transition: all 0.3s ease;">
                        <div class="mb-3">
                            <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center" style="width: 70px; height: 70px; background: linear-gradient(135deg, #FF4900 0%, #FF6B35 100%);">
                                <i class="fas fa-balance-scale fa-lg text-white"></i>
                            </div>
                        </div>
                        <h4 class="h5 fw-bold mb-3" style="color: #FF4900;">Work-Life Balance</h4>
                        <p class="small mb-0" style="color: #666; line-height: 1.5;">
                            We prioritize well-being and maintain healthy boundaries for sustainable success.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Work Environment Highlights -->
            <div class="row align-items-center mb-5">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <h3 class="h2 fw-bold mb-4" style="color: #333;">Our Work Environment</h3>
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center mb-3">
                                <div class="rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: linear-gradient(135deg, #FF4900 0%, #FF6B35 100%);">
                                    <i class="fas fa-home fa-sm text-white"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1 h6 fw-bold" style="color: #333;">Remote Friendly</h5>
                                    <small style="color: #666;">Flexible work arrangements</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center mb-3">
                                <div class="rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: linear-gradient(135deg, #FF4900 0%, #FF6B35 100%);">
                                    <i class="fas fa-clock fa-sm text-white"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1 h6 fw-bold" style="color: #333;">Flexible Hours</h5>
                                    <small style="color: #666;">Work when you're most productive</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center mb-3">
                                <div class="rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: linear-gradient(135deg, #FF4900 0%, #FF6B35 100%);">
                                    <i class="fas fa-graduation-cap fa-sm text-white"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1 h6 fw-bold" style="color: #333;">Learning Budget</h5>
                                    <small style="color: #666;">Annual professional development fund</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center mb-3">
                                <div class="rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: linear-gradient(135deg, #FF4900 0%, #FF6B35 100%);">
                                    <i class="fas fa-heart fa-sm text-white"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1 h6 fw-bold" style="color: #333;">Health & Wellness</h5>
                                    <small style="color: #666;">Comprehensive benefits package</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="position-relative">
                        <!-- Placeholder for team photo - will be replaced with actual image -->
                        <div class="rounded-3 shadow-lg overflow-hidden" style="height: 300px; background: linear-gradient(135deg, #FF4900 0%, #FF6B35 100%); display: flex; align-items: center; justify-content: center;">
                            <div class="text-center text-white">
                                <i class="fas fa-camera fa-3x mb-3" style="opacity: 0.7;"></i>
                                <p class="mb-0 fw-medium">Team Collaboration Photo</p>
                                <small style="opacity: 0.8;">Coming Soon</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Comprehensive Benefits & Culture Showcase -->
            <div class="row mb-5">
                <div class="col-12">
                    <div class="text-center mb-5">
                        <h3 class="h2 fw-bold mb-3 benefits-section" style="color: #333;">Beyond Just a Job - Complete Benefits Package</h3>
                        <p class="lead text-muted mb-0">We invest in your success, well-being, and professional growth</p>
                    </div>
                    
                    <!-- Benefits Grid -->
                    <div class="row g-4 mb-5">
                        <!-- Health & Wellness -->
                        <div class="col-lg-4 col-md-6">
                            <div class="h-100 p-4 rounded-3 text-center benefits-card" style="background: linear-gradient(135deg, rgba(34,193,195,0.05) 0%, rgba(253,187,45,0.05) 100%); border: 1px solid rgba(34,193,195,0.1); transition: all 0.3s ease;">
                                <div class="mb-3">
                                    <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background: linear-gradient(135deg, #22c1c3 0%, #fdbb2d 100%);">
                                        <i class="fas fa-heartbeat fa-lg text-white"></i>
                                    </div>
                                </div>
                                <h4 class="h5 fw-bold mb-3" style="color: #22c1c3;">Health & Wellness</h4>
                                <ul class="list-unstyled small text-muted text-start">
                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>100% Health Insurance Coverage</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Mental Health Support</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Wellness Stipend ($500/year)</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Gym Membership Reimbursement</li>
                                    <li class="mb-0"><i class="fas fa-check-circle text-success me-2"></i>Annual Health Check-ups</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Professional Development -->
                        <div class="col-lg-4 col-md-6">
                            <div class="h-100 p-4 rounded-3 text-center benefits-card" style="background: linear-gradient(135deg, rgba(106,17,203,0.05) 0%, rgba(37,117,252,0.05) 100%); border: 1px solid rgba(106,17,203,0.1); transition: all 0.3s ease;">
                                <div class="mb-3">
                                    <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                        <i class="fas fa-user-graduate fa-lg text-white"></i>
                                    </div>
                                </div>
                                <h4 class="h5 fw-bold mb-3" style="color: #667eea;">Professional Growth</h4>
                                <ul class="list-unstyled small text-muted text-start">
                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>$2,000 Learning Budget</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Conference Attendance</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Certification Reimbursement</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Mentorship Programs</li>
                                    <li class="mb-0"><i class="fas fa-check-circle text-success me-2"></i>Skill Development Time</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Work-Life Balance -->
                        <div class="col-lg-4 col-md-6">
                            <div class="h-100 p-4 rounded-3 text-center benefits-card" style="background: linear-gradient(135deg, rgba(255,73,0,0.05) 0%, rgba(255,107,53,0.05) 100%); border: 1px solid rgba(255,73,0,0.1); transition: all 0.3s ease;">
                                <div class="mb-3">
                                    <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background: linear-gradient(135deg, #FF4900 0%, #FF6B35 100%);">
                                        <i class="fas fa-calendar-check fa-lg text-white"></i>
                                    </div>
                                </div>
                                <h4 class="h5 fw-bold mb-3" style="color: #FF4900;">Time & Flexibility</h4>
                                <ul class="list-unstyled small text-muted text-start">
                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>25 Days Paid Time Off</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Flexible Working Hours</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Remote Work Options</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Personal Development Days</li>
                                    <li class="mb-0"><i class="fas fa-check-circle text-success me-2"></i>Sabbatical Opportunities</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Financial Benefits -->
                        <div class="col-lg-4 col-md-6">
                            <div class="h-100 p-4 rounded-3 text-center benefits-card" style="background: linear-gradient(135deg, rgba(46,204,113,0.05) 0%, rgba(39,174,96,0.05) 100%); border: 1px solid rgba(46,204,113,0.1); transition: all 0.3s ease;">
                                <div class="mb-3">
                                    <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%);">
                                        <i class="fas fa-piggy-bank fa-lg text-white"></i>
                                    </div>
                                </div>
                                <h4 class="h5 fw-bold mb-3" style="color: #2ecc71;">Financial Security</h4>
                                <ul class="list-unstyled small text-muted text-start">
                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Competitive Salary</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Performance Bonuses</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Pension Contribution</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Stock Options</li>
                                    <li class="mb-0"><i class="fas fa-check-circle text-success me-2"></i>Profit Sharing</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Tech & Equipment -->
                        <div class="col-lg-4 col-md-6">
                            <div class="h-100 p-4 rounded-3 text-center benefits-card" style="background: linear-gradient(135deg, rgba(116,235,213,0.05) 0%, rgba(159,172,230,0.05) 100%); border: 1px solid rgba(116,235,213,0.1); transition: all 0.3s ease;">
                                <div class="mb-3">
                                    <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background: linear-gradient(135deg, #74ebd5 0%, #acb6e5 100%);">
                                        <i class="fas fa-laptop-code fa-lg text-white"></i>
                                    </div>
                                </div>
                                <h4 class="h5 fw-bold mb-3" style="color: #74ebd5;">Tech & Tools</h4>
                                <ul class="list-unstyled small text-muted text-start">
                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>MacBook Pro/PC Setup</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Premium Software Licenses</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Home Office Stipend</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Latest Development Tools</li>
                                    <li class="mb-0"><i class="fas fa-check-circle text-success me-2"></i>24/7 Tech Support</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Team & Culture -->
                        <div class="col-lg-4 col-md-6">
                            <div class="h-100 p-4 rounded-3 text-center benefits-card" style="background: linear-gradient(135deg, rgba(254,202,87,0.05) 0%, rgba(255,107,107,0.05) 100%); border: 1px solid rgba(254,202,87,0.1); transition: all 0.3s ease;">
                                <div class="mb-3">
                                    <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background: linear-gradient(135deg, #feca57 0%, #ff6b6b 100%);">
                                        <i class="fas fa-users-cog fa-lg text-white"></i>
                                    </div>
                                </div>
                                <h4 class="h5 fw-bold mb-3" style="color: #feca57;">Team Culture</h4>
                                <ul class="list-unstyled small text-muted text-start">
                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Team Building Events</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Quarterly Offsites</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Innovation Fridays</li>
                                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Open Communication</li>
                                    <li class="mb-0"><i class="fas fa-check-circle text-success me-2"></i>Diversity & Inclusion</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Office Culture Highlights -->
            <div class="row mb-5">
                <div class="col-lg-10 mx-auto">
                    <div class="p-5 rounded-3" style="background: linear-gradient(135deg, rgba(255,73,0,0.02) 0%, rgba(255,107,53,0.02) 100%); border: 1px solid rgba(255,73,0,0.08);">
                        <div class="text-center mb-4">
                            <h3 class="h2 fw-bold mb-3" style="color: #333;">A Day in the Life at Manifest</h3>
                            <p class="lead text-muted mb-4">Experience our vibrant, supportive, and innovative work environment</p>
                        </div>
                        
                        <div class="row g-4">
                            <div class="col-md-6 col-lg-3">
                                <div class="text-center">
                                    <div class="mb-3">
                                        <i class="fas fa-coffee fa-2x" style="color: #8B4513;"></i>
                                    </div>
                                    <h5 class="fw-bold mb-2" style="color: #333;">Morning Energizers</h5>
                                    <p class="small text-muted mb-0">Start your day with premium coffee, healthy snacks, and energizing team check-ins</p>
                                </div>
                            </div>
                            
                            <div class="col-md-6 col-lg-3">
                                <div class="text-center">
                                    <div class="mb-3">
                                        <i class="fas fa-rocket fa-2x" style="color: #FF4900;"></i>
                                    </div>
                                    <h5 class="fw-bold mb-2" style="color: #333;">Innovation Sessions</h5>
                                    <p class="small text-muted mb-0">Collaborate on cutting-edge projects with the latest tools and technologies</p>
                                </div>
                            </div>
                            
                            <div class="col-md-6 col-lg-3">
                                <div class="text-center">
                                    <div class="mb-3">
                                        <i class="fas fa-gamepad fa-2x" style="color: #9b59b6;"></i>
                                    </div>
                                    <h5 class="fw-bold mb-2" style="color: #333;">Break Time Fun</h5>
                                    <p class="small text-muted mb-0">Game room, ping pong, meditation space, and relaxation areas for mental breaks</p>
                                </div>
                            </div>
                            
                            <div class="col-md-6 col-lg-3">
                                <div class="text-center">
                                    <div class="mb-3">
                                        <i class="fas fa-award fa-2x" style="color: #f39c12;"></i>
                                    </div>
                                    <h5 class="fw-bold mb-2" style="color: #333;">Recognition</h5>
                                    <p class="small text-muted mb-0">Monthly achievements, peer recognition, and celebration of wins big and small</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="text-center mt-4">
                            <div class="d-inline-flex align-items-center px-4 py-2 rounded-pill" style="background: linear-gradient(135deg, #FF4900 0%, #FF6B35 100%); color: white;">
                                <i class="fas fa-quote-left me-2"></i>
                                <span class="fw-medium">"The best place I've ever worked. Truly feels like a family!"</span>
                                <i class="fas fa-quote-right ms-2"></i>
                            </div>
                            <p class="small text-muted mt-2 mb-0">- Sarah K., Senior Developer</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Team Statistics -->
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="text-center p-4 rounded-3" style="background: linear-gradient(135deg, rgba(255,73,0,0.03) 0%, rgba(255,107,53,0.03) 100%); border: 1px solid rgba(255,73,0,0.1);">
                        <h3 class="h4 fw-bold mb-4" style="color: #FF4900;">Why Our Team Loves It Here</h3>
                        <div class="row g-4">
                            <div class="col-md-4">
                                <div class="text-center">
                                    <div class="h2 fw-bold mb-2" style="color: #FF4900;">95%</div>
                                    <p class="small mb-0" style="color: #666;">Team Satisfaction Rate</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center">
                                    <div class="h2 fw-bold mb-2" style="color: #FF4900;">3.2</div>
                                    <p class="small mb-0" style="color: #666;">Average Years Experience</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center">
                                    <div class="h2 fw-bold mb-2" style="color: #FF4900;">15+</div>
                                    <p class="small mb-0" style="color: #666;">Professional Certifications</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Testimonials Section -->
    <section class="team-testimonials py-5" style="background-color: #FFFCFA; position: relative; overflow: hidden;">
        <!-- Decorative Elements positioned at viewport edges -->
        <img src="images/decorative/cta_left_mem_dots_f_circle2.svg" alt="" class="position-absolute d-none d-lg-block critical-image" style="left: -35px; top: 10%; width: 70px; opacity: 0.5; animation: float 7s ease-in-out infinite; background: transparent !important;">
        <img src="images/decorative/hero_right_circle-con3.svg" alt="" class="position-absolute d-none d-lg-block critical-image" style="right: -45px; top: 50%; width: 90px; opacity: 0.6; animation: float 9s ease-in-out infinite reverse; background: transparent !important;">
        
        <div class="container">
            <!-- Section Header -->
            <div class="row">
                <div class="col-lg-8 mx-auto text-center mb-5">
                    <h2 class="display-5 fw-bold mb-4" style="color: #000;">Meet Our Amazing Team</h2>
                    <p class="lead" style="color: #666; font-size: 1.25rem; line-height: 1.6;">
                        Hear from our talented team members about their journey, growth, and success stories at Manifest Digital.
                    </p>
                </div>
            </div>

            <!-- Testimonials Carousel -->
            <div id="testimonialsCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="8000">
                <div class="carousel-indicators" style="bottom: -50px;">
                    <button type="button" data-bs-target="#testimonialsCarousel" data-bs-slide-to="0" class="active testimonial-indicator" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#testimonialsCarousel" data-bs-slide-to="1" class="testimonial-indicator" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#testimonialsCarousel" data-bs-slide-to="2" class="testimonial-indicator" aria-label="Slide 3"></button>
                    <button type="button" data-bs-target="#testimonialsCarousel" data-bs-slide-to="3" class="testimonial-indicator" aria-label="Slide 4"></button>
                </div>
                
                <div class="carousel-inner">
                    <!-- Testimonial 1 - Sarah K., Senior Developer -->
                    <div class="carousel-item active">
                        <div class="row align-items-center">
                            <div class="col-lg-4 mb-4 mb-lg-0">
                                <div class="text-center">
                                    <div class="testimonial-photo-container mx-auto mb-3" style="width: 200px; height: 200px;">
                                        <!-- Placeholder for team member photo -->
                                        <div class="rounded-circle shadow-lg overflow-hidden h-100" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center;">
                                            <div class="text-center text-white">
                                                <i class="fas fa-user fa-3x mb-2" style="opacity: 0.8;"></i>
                                                <div class="small fw-medium">Sarah K.</div>
                                            </div>
                                        </div>
                                    </div>
                                    <h4 class="h5 fw-bold mb-1" style="color: #333;">Sarah Kennedy</h4>
                                    <p class="text-muted small mb-2">Senior Full-Stack Developer</p>
                                    <div class="d-flex justify-content-center gap-2">
                                        <span class="badge rounded-pill" style="background: linear-gradient(135deg, #FF4900 0%, #FF6B35 100%); color: white; font-size: 0.7rem;">3 Years at Manifest</span>
                                        <span class="badge rounded-pill" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; font-size: 0.7rem;">Team Lead</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="testimonial-content ps-lg-4">
                                    <div class="position-relative">
                                        <i class="fas fa-quote-left testimonial-quote-left" style="color: #FF4900; opacity: 0.8;"></i>
                                        <blockquote class="mb-4" style="font-size: 1.1rem; line-height: 1.7; color: #333; font-style: italic; position: relative; padding: 20px 30px 20px 15px;">
                                            "Joining Manifest Digital was the best career decision I've ever made. I started as a junior developer and have grown into a team lead position. The company truly invests in your growth - I've attended 3 major conferences, earned 4 certifications, and led multiple high-impact projects. The supportive culture and cutting-edge technology stack make every day exciting."
                                        </blockquote>
                                        <i class="fas fa-quote-right testimonial-quote-right" style="color: #FF4900; opacity: 0.8;"></i>
                                    </div>
                                    <div class="career-progression">
                                        <h5 class="h6 fw-bold mb-3" style="color: #FF4900;">Career Journey at Manifest:</h5>
                                        <div class="timeline-items">
                                            <div class="timeline-item d-flex align-items-center mb-2">
                                                <div class="timeline-dot me-3" style="width: 10px; height: 10px; background: #FF4900; border-radius: 50%;"></div>
                                                <span class="small text-muted">2021: Junior Developer → Full-Stack Developer</span>
                                            </div>
                                            <div class="timeline-item d-flex align-items-center mb-2">
                                                <div class="timeline-dot me-3" style="width: 10px; height: 10px; background: #FF4900; border-radius: 50%;"></div>
                                                <span class="small text-muted">2022: Senior Developer → Project Lead</span>
                                            </div>
                                            <div class="timeline-item d-flex align-items-center mb-2">
                                                <div class="timeline-dot me-3" style="width: 10px; height: 10px; background: #FF4900; border-radius: 50%;"></div>
                                                <span class="small text-muted">2023: Team Lead → Mentoring Program</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Testimonial 2 - Marcus Chen, UI/UX Designer -->
                    <div class="carousel-item">
                        <div class="row align-items-center">
                            <div class="col-lg-4 mb-4 mb-lg-0">
                                <div class="text-center">
                                    <div class="testimonial-photo-container mx-auto mb-3" style="width: 200px; height: 200px;">
                                        <div class="rounded-circle shadow-lg overflow-hidden h-100" style="background: linear-gradient(135deg, #22c1c3 0%, #fdbb2d 100%); display: flex; align-items: center; justify-content: center;">
                                            <div class="text-center text-white">
                                                <i class="fas fa-user fa-3x mb-2" style="opacity: 0.8;"></i>
                                                <div class="small fw-medium">Marcus C.</div>
                                            </div>
                                        </div>
                                    </div>
                                    <h4 class="h5 fw-bold mb-1" style="color: #333;">Marcus Chen</h4>
                                    <p class="text-muted small mb-2">Senior UI/UX Designer</p>
                                    <div class="d-flex justify-content-center gap-2">
                                        <span class="badge rounded-pill" style="background: linear-gradient(135deg, #FF4900 0%, #FF6B35 100%); color: white; font-size: 0.7rem;">2.5 Years at Manifest</span>
                                        <span class="badge rounded-pill" style="background: linear-gradient(135deg, #22c1c3 0%, #fdbb2d 100%); color: white; font-size: 0.7rem;">Design Lead</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="testimonial-content ps-lg-4">
                                    <div class="position-relative">
                                        <i class="fas fa-quote-left testimonial-quote-left" style="color: #FF4900; opacity: 0.8;"></i>
                                        <blockquote class="mb-4" style="font-size: 1.1rem; line-height: 1.7; color: #333; font-style: italic; position: relative; padding: 20px 30px 20px 15px;">
                                            "The creative freedom and collaborative environment at Manifest is unmatched. I've worked on award-winning designs for Fortune 500 clients while building our internal design system. The team respects design thinking, and leadership actively seeks our input on strategic decisions. Plus, the flexible schedule lets me maintain my work-life balance perfectly."
                                        </blockquote>
                                        <i class="fas fa-quote-right testimonial-quote-right" style="color: #FF4900; opacity: 0.8;"></i>
                                    </div>
                                    <div class="achievements">
                                        <h5 class="h6 fw-bold mb-3" style="color: #FF4900;">Key Achievements:</h5>
                                        <div class="row g-2">
                                            <div class="col-sm-6">
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="fas fa-trophy text-warning me-2"></i>
                                                    <span class="small text-muted">2x Design Awards Winner</span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="fas fa-users text-primary me-2"></i>
                                                    <span class="small text-muted">Led 15+ Client Projects</span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="fas fa-palette text-info me-2"></i>
                                                    <span class="small text-muted">Built Company Design System</span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="fas fa-graduation-cap text-success me-2"></i>
                                                    <span class="small text-muted">UX Certification Completed</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Testimonial 3 - Aisha Patel, Marketing Manager -->
                    <div class="carousel-item">
                        <div class="row align-items-center">
                            <div class="col-lg-4 mb-4 mb-lg-0">
                                <div class="text-center">
                                    <div class="testimonial-photo-container mx-auto mb-3" style="width: 200px; height: 200px;">
                                        <div class="rounded-circle shadow-lg overflow-hidden h-100" style="background: linear-gradient(135deg, #feca57 0%, #ff6b6b 100%); display: flex; align-items: center; justify-content: center;">
                                            <div class="text-center text-white">
                                                <i class="fas fa-user fa-3x mb-2" style="opacity: 0.8;"></i>
                                                <div class="small fw-medium">Aisha P.</div>
                                            </div>
                                        </div>
                                    </div>
                                    <h4 class="h5 fw-bold mb-1" style="color: #333;">Aisha Patel</h4>
                                    <p class="text-muted small mb-2">Digital Marketing Manager</p>
                                    <div class="d-flex justify-content-center gap-2">
                                        <span class="badge rounded-pill" style="background: linear-gradient(135deg, #FF4900 0%, #FF6B35 100%); color: white; font-size: 0.7rem;">1.8 Years at Manifest</span>
                                        <span class="badge rounded-pill" style="background: linear-gradient(135deg, #feca57 0%, #ff6b6b 100%); color: white; font-size: 0.7rem;">Growth Specialist</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="testimonial-content ps-lg-4">
                                    <div class="position-relative">
                                        <i class="fas fa-quote-left testimonial-quote-left" style="color: #FF4900; opacity: 0.8;"></i>
                                        <blockquote class="mb-4" style="font-size: 1.1rem; line-height: 1.7; color: #333; font-style: italic; position: relative; padding: 20px 30px 20px 15px;">
                                            "As someone who transitioned from traditional marketing to digital, Manifest provided the perfect environment to learn and grow. The team embraced my fresh perspective while providing mentorship in areas I needed to develop. I've launched successful campaigns that increased client engagement by 300% and built lasting partnerships with industry leaders."
                                        </blockquote>
                                        <i class="fas fa-quote-right testimonial-quote-right" style="color: #FF4900; opacity: 0.8;"></i>
                                    </div>
                                    <div class="results-highlights">
                                        <h5 class="h6 fw-bold mb-3" style="color: #FF4900;">Impact & Results:</h5>
                                        <div class="row g-3">
                                            <div class="col-sm-4">
                                                <div class="text-center p-3 rounded-3" style="background: linear-gradient(135deg, rgba(254,202,87,0.1) 0%, rgba(255,107,107,0.1) 100%); border: 1px solid rgba(254,202,87,0.2);">
                                                    <div class="h4 fw-bold mb-1" style="color: #ff6b6b;">300%</div>
                                                    <small class="text-muted">Engagement Increase</small>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="text-center p-3 rounded-3" style="background: linear-gradient(135deg, rgba(254,202,87,0.1) 0%, rgba(255,107,107,0.1) 100%); border: 1px solid rgba(254,202,87,0.2);">
                                                    <div class="h4 fw-bold mb-1" style="color: #ff6b6b;">12</div>
                                                    <small class="text-muted">Successful Campaigns</small>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="text-center p-3 rounded-3" style="background: linear-gradient(135deg, rgba(254,202,87,0.1) 0%, rgba(255,107,107,0.1) 100%); border: 1px solid rgba(254,202,87,0.2);">
                                                    <div class="h4 fw-bold mb-1" style="color: #ff6b6b;">8</div>
                                                    <small class="text-muted">Industry Partnerships</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Testimonial 4 - David Rodriguez, Business Development -->
                    <div class="carousel-item">
                        <div class="row align-items-center">
                            <div class="col-lg-4 mb-4 mb-lg-0">
                                <div class="text-center">
                                    <div class="testimonial-photo-container mx-auto mb-3" style="width: 200px; height: 200px;">
                                        <div class="rounded-circle shadow-lg overflow-hidden h-100" style="background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%); display: flex; align-items: center; justify-content: center;">
                                            <div class="text-center text-white">
                                                <i class="fas fa-user fa-3x mb-2" style="opacity: 0.8;"></i>
                                                <div class="small fw-medium">David R.</div>
                                            </div>
                                        </div>
                                    </div>
                                    <h4 class="h5 fw-bold mb-1" style="color: #333;">David Rodriguez</h4>
                                    <p class="text-muted small mb-2">Business Development Lead</p>
                                    <div class="d-flex justify-content-center gap-2">
                                        <span class="badge rounded-pill" style="background: linear-gradient(135deg, #FF4900 0%, #FF6B35 100%); color: white; font-size: 0.7rem;">4 Years at Manifest</span>
                                        <span class="badge rounded-pill" style="background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%); color: white; font-size: 0.7rem;">Senior Partner</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="testimonial-content ps-lg-4">
                                    <div class="position-relative">
                                        <i class="fas fa-quote-left testimonial-quote-left" style="color: #FF4900; opacity: 0.8;"></i>
                                        <blockquote class="mb-4" style="font-size: 1.1rem; line-height: 1.7; color: #333; font-style: italic; position: relative; padding: 20px 30px 20px 15px;">
                                            "What sets Manifest apart is the entrepreneurial spirit combined with genuine care for both clients and employees. I've had the autonomy to develop innovative partnership strategies while being supported by brilliant technical teams. The profit-sharing and stock options show they truly value long-term commitment. This isn't just a job - it's building something meaningful together."
                                        </blockquote>
                                        <i class="fas fa-quote-right testimonial-quote-right" style="color: #FF4900; opacity: 0.8;"></i>
                                    </div>
                                    <div class="business-growth">
                                        <h5 class="h6 fw-bold mb-3" style="color: #FF4900;">Business Growth Contributions:</h5>
                                        <div class="row g-2">
                                            <div class="col-sm-6">
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="fas fa-handshake text-success me-2"></i>
                                                    <span class="small text-muted">25+ Strategic Partnerships</span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="fas fa-chart-line text-primary me-2"></i>
                                                    <span class="small text-muted">200% Revenue Growth</span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="fas fa-building text-info me-2"></i>
                                                    <span class="small text-muted">Enterprise Client Acquisition</span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="fas fa-globe text-warning me-2"></i>
                                                    <span class="small text-muted">International Market Entry</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Carousel Controls -->
                <button class="carousel-control-prev" type="button" data-bs-target="#testimonialsCarousel" data-bs-slide="prev" style="left: -50px;">
                    <div class="carousel-control-icon" style="background: linear-gradient(135deg, #FF4900 0%, #FF6B35 100%); border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-chevron-left text-white"></i>
                    </div>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#testimonialsCarousel" data-bs-slide="next" style="right: -50px;">
                    <div class="carousel-control-icon" style="background: linear-gradient(135deg, #FF4900 0%, #FF6B35 100%); border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-chevron-right text-white"></i>
                    </div>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>

            <!-- Team Statistics Footer -->
            <div class="row mt-5">
                <div class="col-lg-10 mx-auto">
                    <div class="text-center p-4 rounded-3" style="background: linear-gradient(135deg, rgba(255,73,0,0.03) 0%, rgba(255,107,53,0.03) 100%); border: 1px solid rgba(255,73,0,0.1);">
                        <h3 class="h4 fw-bold mb-4" style="color: #FF4900;">Join Our Success Stories</h3>
                        <div class="row g-4">
                            <div class="col-md-3 col-sm-6">
                                <div class="text-center">
                                    <div class="h3 fw-bold mb-2" style="color: #FF4900;">15+</div>
                                    <p class="small mb-0" style="color: #666;">Team Members Promoted</p>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="text-center">
                                    <div class="h3 fw-bold mb-2" style="color: #FF4900;">40+</div>
                                    <p class="small mb-0" style="color: #666;">Certifications Earned</p>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="text-center">
                                    <div class="h3 fw-bold mb-2" style="color: #FF4900;">8</div>
                                    <p class="small mb-0" style="color: #666;">Industry Awards Won</p>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="text-center">
                                    <div class="h3 fw-bold mb-2" style="color: #FF4900;">92%</div>
                                    <p class="small mb-0" style="color: #666;">Employee Retention Rate</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Opportunities Listing Section -->
    <section id="opportunities-section" class="opportunities-listing py-5" style="background: linear-gradient(135deg, #FFFCFA 0%, #FFF8F3 50%, #FFFCFA 100%);">
        <div class="container">
            <!-- Section Header -->
            <div class="row">
                <div class="col-lg-8 mx-auto text-center mb-5">
                    <h2 class="display-5 fw-bold mb-4 opportunities-section" style="color: #000;">Current Opportunities</h2>
                    <p class="lead mb-4" style="color: #666; font-size: 1.25rem; line-height: 1.6;">
                        Find your perfect role and grow with us. We're always looking for talented individuals 
                        who share our passion for digital innovation.
                    </p>
                </div>
            </div>

            <!-- Filters and Search -->
            <div class="row mb-5">
                <div class="col-12">
                    <div class="d-flex flex-column flex-lg-row gap-3 align-items-center justify-content-center">
                        <!-- Department Filters -->
                        <div class="opportunities-filters-wrapper">
                            <div class="opportunities-filters-container">
                                <div class="opportunities-filters-tabs d-flex gap-2 flex-wrap justify-content-center" role="tablist" aria-label="Filter opportunities by department">
                                    <button class="filter-btn active" data-filter="all" role="tab" aria-pressed="true" aria-controls="opportunitiesGrid" tabindex="0">
                                        All Opportunities
                                        <span class="sr-only">(currently showing all 6 opportunities)</span>
                                    </button>
                                    <button class="filter-btn" data-filter="development" role="tab" aria-pressed="false" aria-controls="opportunitiesGrid" tabindex="-1">
                                        Development
                                        <span class="sr-only">(2 opportunities)</span>
                                    </button>
                                    <button class="filter-btn" data-filter="design" role="tab" aria-pressed="false" aria-controls="opportunitiesGrid" tabindex="-1">
                                        Design
                                        <span class="sr-only">(2 opportunities)</span>
                                    </button>
                                    <button class="filter-btn" data-filter="marketing" role="tab" aria-pressed="false" aria-controls="opportunitiesGrid" tabindex="-1">
                                        Marketing
                                        <span class="sr-only">(1 opportunity)</span>
                                    </button>
                                    <button class="filter-btn" data-filter="business" role="tab" aria-pressed="false" aria-controls="opportunitiesGrid" tabindex="-1">
                                        Business
                                        <span class="sr-only">(1 opportunity)</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Search Box -->
                        <div class="search-box position-relative" style="min-width: 300px;">
                            <label for="opportunitySearch" class="sr-only">Search opportunities by title, skills, or description</label>
                            <i class="fas fa-search position-absolute" style="left: 18px; top: 50%; transform: translateY(-50%); color: #999;" aria-hidden="true"></i>
                            <input type="text" id="opportunitySearch" placeholder="Search opportunities..." 
                                   aria-describedby="search-help" 
                                   style="padding: 12px 20px 12px 45px; border: 2px solid #ddd; border-radius: 50px; width: 100%; font-size: 16px; transition: border-color 0.3s ease;">
                            <div id="search-help" class="sr-only">Type to search across job titles, descriptions, and required skills</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Opportunities Grid -->
            <div class="row" id="opportunitiesGrid">
                <!-- Full-Stack Developer Position -->
                <div class="col-lg-6 col-xl-4 mb-4 opportunity-card" data-category="development" data-type="job">
                    <div class="card h-100 shadow-sm border-0" style="border-radius: 16px; transition: all 0.3s ease;">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div class="opportunity-type-badge px-3 py-1 rounded-pill" style="background: linear-gradient(135deg, rgba(255,73,0,0.1) 0%, rgba(255,107,53,0.1) 100%); color: #FF4900; font-size: 0.85rem; font-weight: 600;">
                                    Full-Time
                                </div>
                                <div class="opportunity-department-badge px-3 py-1 rounded-pill" style="background: rgba(102,102,102,0.1); color: #666; font-size: 0.85rem; font-weight: 600;">
                                    Development
                                </div>
                            </div>
                            
                            <h4 class="card-title h5 fw-bold mb-3" style="color: #333;">Senior Full-Stack Developer</h4>
                            
                            <p class="card-text text-muted mb-3" style="font-size: 0.95rem; line-height: 1.5;">
                                Join our development team to build cutting-edge web applications using modern technologies. 
                                Lead projects and mentor junior developers.
                            </p>
                            
                            <div class="opportunity-details mb-3">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-map-marker-alt me-2" style="color: #FF4900; font-size: 0.9rem;"></i>
                                    <small class="text-muted">Remote / Lagos, Nigeria</small>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-clock me-2" style="color: #FF4900; font-size: 0.9rem;"></i>
                                    <small class="text-muted">Full-Time, 40 hours/week</small>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-calendar me-2" style="color: #FF4900; font-size: 0.9rem;"></i>
                                    <small class="text-muted">Posted 3 days ago</small>
                                </div>
                            </div>
                            
                            <div class="d-flex gap-2 flex-wrap mb-3">
                                <span class="badge" style="background: rgba(255,73,0,0.1); color: #FF4900;">React</span>
                                <span class="badge" style="background: rgba(255,73,0,0.1); color: #FF4900;">Node.js</span>
                                <span class="badge" style="background: rgba(255,73,0,0.1); color: #FF4900;">Laravel</span>
                                <span class="badge" style="background: rgba(255,73,0,0.1); color: #FF4900;">MySQL</span>
                            </div>
                            
                            <button class="btn w-100 mt-auto" style="background: linear-gradient(135deg, #FF4900 0%, #FF6B35 100%); color: white; border: none; padding: 12px; border-radius: 8px; font-weight: 600; transition: all 0.3s ease;" onclick="openOpportunityModal('senior-fullstack-dev')">
                                View Details & Apply
                            </button>
                        </div>
                    </div>
                </div>

                <!-- UI/UX Designer Position -->
                <div class="col-lg-6 col-xl-4 mb-4 opportunity-card" data-category="design" data-type="job">
                    <div class="card h-100 shadow-sm border-0" style="border-radius: 16px; transition: all 0.3s ease;">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div class="opportunity-type-badge px-3 py-1 rounded-pill" style="background: linear-gradient(135deg, rgba(255,73,0,0.1) 0%, rgba(255,107,53,0.1) 100%); color: #FF4900; font-size: 0.85rem; font-weight: 600;">
                                    Full-Time
                                </div>
                                <div class="opportunity-department-badge px-3 py-1 rounded-pill" style="background: rgba(102,102,102,0.1); color: #666; font-size: 0.85rem; font-weight: 600;">
                                    Design
                                </div>
                            </div>
                            
                            <h4 class="card-title h5 fw-bold mb-3" style="color: #333;">Senior UI/UX Designer</h4>
                            
                            <p class="card-text text-muted mb-3" style="font-size: 0.95rem; line-height: 1.5;">
                                Create beautiful and intuitive user experiences for web and mobile applications. 
                                Work closely with development teams to bring designs to life.
                            </p>
                            
                            <div class="opportunity-details mb-3">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-map-marker-alt me-2" style="color: #FF4900; font-size: 0.9rem;"></i>
                                    <small class="text-muted">Remote / Lagos, Nigeria</small>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-clock me-2" style="color: #FF4900; font-size: 0.9rem;"></i>
                                    <small class="text-muted">Full-Time, 40 hours/week</small>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-calendar me-2" style="color: #FF4900; font-size: 0.9rem;"></i>
                                    <small class="text-muted">Posted 1 week ago</small>
                                </div>
                            </div>
                            
                            <div class="d-flex gap-2 flex-wrap mb-3">
                                <span class="badge" style="background: rgba(255,73,0,0.1); color: #FF4900;">Figma</span>
                                <span class="badge" style="background: rgba(255,73,0,0.1); color: #FF4900;">Adobe XD</span>
                                <span class="badge" style="background: rgba(255,73,0,0.1); color: #FF4900;">Prototyping</span>
                                <span class="badge" style="background: rgba(255,73,0,0.1); color: #FF4900;">User Research</span>
                            </div>
                            
                            <button class="btn w-100 mt-auto" style="background: linear-gradient(135deg, #FF4900 0%, #FF6B35 100%); color: white; border: none; padding: 12px; border-radius: 8px; font-weight: 600; transition: all 0.3s ease;" onclick="openOpportunityModal('senior-ui-ux-designer')">
                                View Details & Apply
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Marketing Intern Position -->
                <div class="col-lg-6 col-xl-4 mb-4 opportunity-card" data-category="marketing" data-type="internship">
                    <div class="card h-100 shadow-sm border-0" style="border-radius: 16px; transition: all 0.3s ease;">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div class="opportunity-type-badge px-3 py-1 rounded-pill" style="background: linear-gradient(135deg, rgba(52,152,219,0.1) 0%, rgba(41,128,185,0.1) 100%); color: #3498db; font-size: 0.85rem; font-weight: 600;">
                                    Internship
                                </div>
                                <div class="opportunity-department-badge px-3 py-1 rounded-pill" style="background: rgba(102,102,102,0.1); color: #666; font-size: 0.85rem; font-weight: 600;">
                                    Marketing
                                </div>
                            </div>
                            
                            <h4 class="card-title h5 fw-bold mb-3" style="color: #333;">Digital Marketing Intern</h4>
                            
                            <p class="card-text text-muted mb-3" style="font-size: 0.95rem; line-height: 1.5;">
                                Learn digital marketing strategies while working on real client campaigns. 
                                Perfect opportunity for students or recent graduates.
                            </p>
                            
                            <div class="opportunity-details mb-3">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-map-marker-alt me-2" style="color: #FF4900; font-size: 0.9rem;"></i>
                                    <small class="text-muted">Remote / Lagos, Nigeria</small>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-clock me-2" style="color: #FF4900; font-size: 0.9rem;"></i>
                                    <small class="text-muted">Part-Time, 20 hours/week</small>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-calendar me-2" style="color: #FF4900; font-size: 0.9rem;"></i>
                                    <small class="text-muted">Posted 5 days ago</small>
                                </div>
                            </div>
                            
                            <div class="d-flex gap-2 flex-wrap mb-3">
                                <span class="badge" style="background: rgba(255,73,0,0.1); color: #FF4900;">Social Media</span>
                                <span class="badge" style="background: rgba(255,73,0,0.1); color: #FF4900;">Content Creation</span>
                                <span class="badge" style="background: rgba(255,73,0,0.1); color: #FF4900;">Analytics</span>
                                <span class="badge" style="background: rgba(255,73,0,0.1); color: #FF4900;">SEO</span>
                            </div>
                            
                            <button class="btn w-100 mt-auto" style="background: linear-gradient(135deg, #FF4900 0%, #FF6B35 100%); color: white; border: none; padding: 12px; border-radius: 8px; font-weight: 600; transition: all 0.3s ease;" onclick="openOpportunityModal('digital-marketing-intern')">
                                View Details & Apply
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Business Development Position -->
                <div class="col-lg-6 col-xl-4 mb-4 opportunity-card" data-category="business" data-type="job">
                    <div class="card h-100 shadow-sm border-0" style="border-radius: 16px; transition: all 0.3s ease;">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div class="opportunity-type-badge px-3 py-1 rounded-pill" style="background: linear-gradient(135deg, rgba(255,73,0,0.1) 0%, rgba(255,107,53,0.1) 100%); color: #FF4900; font-size: 0.85rem; font-weight: 600;">
                                    Full-Time
                                </div>
                                <div class="opportunity-department-badge px-3 py-1 rounded-pill" style="background: rgba(102,102,102,0.1); color: #666; font-size: 0.85rem; font-weight: 600;">
                                    Business
                                </div>
                            </div>
                            
                            <h4 class="card-title h5 fw-bold mb-3" style="color: #333;">Business Development Manager</h4>
                            
                            <p class="card-text text-muted mb-3" style="font-size: 0.95rem; line-height: 1.5;">
                                Drive business growth through strategic partnerships and client relationships. 
                                Lead sales initiatives and expand our market presence.
                            </p>
                            
                            <div class="opportunity-details mb-3">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-map-marker-alt me-2" style="color: #FF4900; font-size: 0.9rem;"></i>
                                    <small class="text-muted">Lagos, Nigeria</small>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-clock me-2" style="color: #FF4900; font-size: 0.9rem;"></i>
                                    <small class="text-muted">Full-Time, 40 hours/week</small>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-calendar me-2" style="color: #FF4900; font-size: 0.9rem;"></i>
                                    <small class="text-muted">Posted 2 weeks ago</small>
                                </div>
                            </div>
                            
                            <div class="d-flex gap-2 flex-wrap mb-3">
                                <span class="badge" style="background: rgba(255,73,0,0.1); color: #FF4900;">Sales</span>
                                <span class="badge" style="background: rgba(255,73,0,0.1); color: #FF4900;">Partnerships</span>
                                <span class="badge" style="background: rgba(255,73,0,0.1); color: #FF4900;">Strategy</span>
                                <span class="badge" style="background: rgba(255,73,0,0.1); color: #FF4900;">CRM</span>
                            </div>
                            
                            <button class="btn w-100 mt-auto" style="background: linear-gradient(135deg, #FF4900 0%, #FF6B35 100%); color: white; border: none; padding: 12px; border-radius: 8px; font-weight: 600; transition: all 0.3s ease;" onclick="openOpportunityModal('business-development-manager')">
                                View Details & Apply
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Frontend Development Intern -->
                <div class="col-lg-6 col-xl-4 mb-4 opportunity-card" data-category="development" data-type="internship">
                    <div class="card h-100 shadow-sm border-0" style="border-radius: 16px; transition: all 0.3s ease;">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div class="opportunity-type-badge px-3 py-1 rounded-pill" style="background: linear-gradient(135deg, rgba(52,152,219,0.1) 0%, rgba(41,128,185,0.1) 100%); color: #3498db; font-size: 0.85rem; font-weight: 600;">
                                    Internship
                                </div>
                                <div class="opportunity-department-badge px-3 py-1 rounded-pill" style="background: rgba(102,102,102,0.1); color: #666; font-size: 0.85rem; font-weight: 600;">
                                    Development
                                </div>
                            </div>
                            
                            <h4 class="card-title h5 fw-bold mb-3" style="color: #333;">Frontend Development Intern</h4>
                            
                            <p class="card-text text-muted mb-3" style="font-size: 0.95rem; line-height: 1.5;">
                                Learn modern frontend development while working on real projects. 
                                Great opportunity for computer science students and bootcamp graduates.
                            </p>
                            
                            <div class="opportunity-details mb-3">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-map-marker-alt me-2" style="color: #FF4900; font-size: 0.9rem;"></i>
                                    <small class="text-muted">Remote / Lagos, Nigeria</small>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-clock me-2" style="color: #FF4900; font-size: 0.9rem;"></i>
                                    <small class="text-muted">Part-Time, 25 hours/week</small>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-calendar me-2" style="color: #FF4900; font-size: 0.9rem;"></i>
                                    <small class="text-muted">Posted 1 week ago</small>
                                </div>
                            </div>
                            
                            <div class="d-flex gap-2 flex-wrap mb-3">
                                <span class="badge" style="background: rgba(255,73,0,0.1); color: #FF4900;">HTML/CSS</span>
                                <span class="badge" style="background: rgba(255,73,0,0.1); color: #FF4900;">JavaScript</span>
                                <span class="badge" style="background: rgba(255,73,0,0.1); color: #FF4900;">React</span>
                                <span class="badge" style="background: rgba(255,73,0,0.1); color: #FF4900;">Git</span>
                            </div>
                            
                            <button class="btn w-100 mt-auto" style="background: linear-gradient(135deg, #FF4900 0%, #FF6B35 100%); color: white; border: none; padding: 12px; border-radius: 8px; font-weight: 600; transition: all 0.3s ease;" onclick="openOpportunityModal('frontend-development-intern')">
                                View Details & Apply
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Graphic Design Position -->
                <div class="col-lg-6 col-xl-4 mb-4 opportunity-card" data-category="design" data-type="job">
                    <div class="card h-100 shadow-sm border-0" style="border-radius: 16px; transition: all 0.3s ease;">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div class="opportunity-type-badge px-3 py-1 rounded-pill" style="background: linear-gradient(135deg, rgba(255,73,0,0.1) 0%, rgba(255,107,53,0.1) 100%); color: #FF4900; font-size: 0.85rem; font-weight: 600;">
                                    Full-Time
                                </div>
                                <div class="opportunity-department-badge px-3 py-1 rounded-pill" style="background: rgba(102,102,102,0.1); color: #666; font-size: 0.85rem; font-weight: 600;">
                                    Design
                                </div>
                            </div>
                            
                            <h4 class="card-title h5 fw-bold mb-3" style="color: #333;">Creative Graphic Designer</h4>
                            
                            <p class="card-text text-muted mb-3" style="font-size: 0.95rem; line-height: 1.5;">
                                Create compelling visual content for digital and print media. 
                                Work on brand identity, marketing materials, and web graphics.
                            </p>
                            
                            <div class="opportunity-details mb-3">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-map-marker-alt me-2" style="color: #FF4900; font-size: 0.9rem;"></i>
                                    <small class="text-muted">Remote / Lagos, Nigeria</small>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-clock me-2" style="color: #FF4900; font-size: 0.9rem;"></i>
                                    <small class="text-muted">Full-Time, 40 hours/week</small>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-calendar me-2" style="color: #FF4900; font-size: 0.9rem;"></i>
                                    <small class="text-muted">Posted 4 days ago</small>
                                </div>
                            </div>
                            
                            <div class="d-flex gap-2 flex-wrap mb-3">
                                <span class="badge" style="background: rgba(255,73,0,0.1); color: #FF4900;">Photoshop</span>
                                <span class="badge" style="background: rgba(255,73,0,0.1); color: #FF4900;">Illustrator</span>
                                <span class="badge" style="background: rgba(255,73,0,0.1); color: #FF4900;">Branding</span>
                                <span class="badge" style="background: rgba(255,73,0,0.1); color: #FF4900;">Typography</span>
                            </div>
                            
                            <button class="btn w-100 mt-auto" style="background: linear-gradient(135deg, #FF4900 0%, #FF6B35 100%); color: white; border: none; padding: 12px; border-radius: 8px; font-weight: 600; transition: all 0.3s ease;" onclick="openOpportunityModal('creative-graphic-designer')">
                                View Details & Apply
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- No Results Message -->
            <div id="noResultsMessage" class="text-center py-5" style="display: none;">
                <i class="fas fa-search fa-3x mb-3" style="color: #ddd;"></i>
                <h4 class="h5 mb-3" style="color: #666;">No opportunities found</h4>
                <p class="text-muted">Try adjusting your search or filter criteria to see more results.</p>
            </div>
        </div>
    </section>

    <!-- Opportunity Detail Modal -->
    <div class="modal fade" id="opportunityModal" tabindex="-1" aria-labelledby="opportunityModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content" style="border: none; border-radius: 16px; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);">
                <div class="modal-header" style="border-bottom: 1px solid #eee; padding: 24px;">
                    <div class="d-flex flex-column">
                        <h4 class="modal-title fw-bold mb-2" id="opportunityModalLabel" style="color: #333;"></h4>
                        <div class="d-flex gap-2">
                            <span class="badge modal-type-badge"></span>
                            <span class="badge modal-department-badge"></span>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="margin: 0;"></button>
                </div>
                
                <div class="modal-body" style="padding: 24px;">
                    <!-- Job Overview -->
                    <div class="mb-4">
                        <h5 class="fw-bold mb-3" style="color: #FF4900;">Job Overview</h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-map-marker-alt me-2" style="color: #FF4900; width: 16px;"></i>
                                    <div>
                                        <small class="text-muted d-block">Location</small>
                                        <span class="modal-location"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-clock me-2" style="color: #FF4900; width: 16px;"></i>
                                    <div>
                                        <small class="text-muted d-block">Schedule</small>
                                        <span class="modal-schedule"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-briefcase me-2" style="color: #FF4900; width: 16px;"></i>
                                    <div>
                                        <small class="text-muted d-block">Experience Level</small>
                                        <span class="modal-experience"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-calendar me-2" style="color: #FF4900; width: 16px;"></i>
                                    <div>
                                        <small class="text-muted d-block">Posted</small>
                                        <span class="modal-posted"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Job Description -->
                    <div class="mb-4">
                        <h5 class="fw-bold mb-3" style="color: #FF4900;">About This Role</h5>
                        <div class="modal-description" style="color: #666; line-height: 1.6;"></div>
                    </div>

                    <!-- Key Responsibilities -->
                    <div class="mb-4">
                        <h5 class="fw-bold mb-3" style="color: #FF4900;">Key Responsibilities</h5>
                        <ul class="modal-responsibilities" style="color: #666; line-height: 1.6; padding-left: 20px;"></ul>
                    </div>

                    <!-- Requirements -->
                    <div class="mb-4">
                        <h5 class="fw-bold mb-3" style="color: #FF4900;">Requirements</h5>
                        <ul class="modal-requirements" style="color: #666; line-height: 1.6; padding-left: 20px;"></ul>
                    </div>

                    <!-- Skills & Technologies -->
                    <div class="mb-4">
                        <h5 class="fw-bold mb-3" style="color: #FF4900;">Skills & Technologies</h5>
                        <div class="modal-skills d-flex gap-2 flex-wrap"></div>
                    </div>

                    <!-- What We Offer -->
                    <div class="mb-4">
                        <h5 class="fw-bold mb-3" style="color: #FF4900;">What We Offer</h5>
                        <ul class="modal-benefits" style="color: #666; line-height: 1.6; padding-left: 20px;">
                            <li>Competitive salary and performance bonuses</li>
                            <li>Flexible working hours and remote work options</li>
                            <li>Professional development budget and learning opportunities</li>
                            <li>Health insurance and wellness programs</li>
                            <li>Collaborative and innovative work environment</li>
                            <li>Modern tools and technology stack</li>
                            <li>Career growth and advancement opportunities</li>
                        </ul>
                    </div>

                    <!-- Application Process -->
                    <div class="mb-4">
                        <h5 class="fw-bold mb-3" style="color: #FF4900;">Application Process</h5>
                        <div class="row g-3">
                            <div class="col-sm-6 col-md-3">
                                <div class="text-center p-3 rounded-3" style="background: rgba(255, 73, 0, 0.05); border: 1px solid rgba(255, 73, 0, 0.1);">
                                    <div class="rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: linear-gradient(135deg, #FF4900 0%, #FF6B35 100%);">
                                        <i class="fas fa-file-alt text-white fa-sm"></i>
                                    </div>
                                    <small class="fw-bold" style="color: #FF4900;">Apply</small>
                                    <div style="font-size: 0.75rem; color: #666;">Submit application</div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="text-center p-3 rounded-3" style="background: rgba(255, 73, 0, 0.05); border: 1px solid rgba(255, 73, 0, 0.1);">
                                    <div class="rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: linear-gradient(135deg, #FF4900 0%, #FF6B35 100%);">
                                        <i class="fas fa-search text-white fa-sm"></i>
                                    </div>
                                    <small class="fw-bold" style="color: #FF4900;">Review</small>
                                    <div style="font-size: 0.75rem; color: #666;">Application review</div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="text-center p-3 rounded-3" style="background: rgba(255, 73, 0, 0.05); border: 1px solid rgba(255, 73, 0, 0.1);">
                                    <div class="rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: linear-gradient(135deg, #FF4900 0%, #FF6B35 100%);">
                                        <i class="fas fa-comments text-white fa-sm"></i>
                                    </div>
                                    <small class="fw-bold" style="color: #FF4900;">Interview</small>
                                    <div style="font-size: 0.75rem; color: #666;">Meet the team</div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="text-center p-3 rounded-3" style="background: rgba(255, 73, 0, 0.05); border: 1px solid rgba(255, 73, 0, 0.1);">
                                    <div class="rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: linear-gradient(135deg, #FF4900 0%, #FF6B35 100%);">
                                        <i class="fas fa-handshake text-white fa-sm"></i>
                                    </div>
                                    <small class="fw-bold" style="color: #FF4900;">Offer</small>
                                    <div style="font-size: 0.75rem; color: #666;">Join the team</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer" style="border-top: 1px solid #eee; padding: 24px; background: rgba(255, 73, 0, 0.02);">
                    <div class="d-flex gap-3 w-100">
                        <button type="button" class="btn flex-fill" style="background: white; color: #666; border: 2px solid #ddd; padding: 12px 24px; border-radius: 8px; font-weight: 600;" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="button" class="btn flex-fill" style="background: linear-gradient(135deg, #FF4900 0%, #FF6B35 100%); color: white; border: none; padding: 12px 24px; border-radius: 8px; font-weight: 600;" onclick="startApplication()">
                            <i class="fas fa-paper-plane me-2"></i>Apply Now
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Application Form Section -->
    <section id="apply" class="application-form py-5" style="background: white;">
        <div class="container">
            <!-- Section Header -->
            <div class="row">
                <div class="col-lg-8 mx-auto text-center mb-5">
                    <h2 class="display-5 fw-bold mb-4" style="color: #000;">Apply to Join Our Team</h2>
                    <p class="lead mb-4" style="color: #666; font-size: 1.25rem; line-height: 1.6;">
                        Ready to start your journey with us? Complete the application form below and we'll get back to you within 48 hours.
                    </p>
                </div>
            </div>

            <!-- Multi-Step Form -->
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <!-- Progress Indicator -->
                    <div class="career-application-progress mb-5" role="progressbar" aria-label="Application form progress" aria-valuenow="1" aria-valuemin="1" aria-valuemax="4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="career-progress-step active" data-step="1" aria-current="step" aria-label="Step 1 of 4: Personal Information - Current step">
                                <div class="career-step-circle">
                                    <span class="career-step-number" aria-hidden="true">1</span>
                                    <i class="fas fa-check career-step-check d-none" aria-hidden="true"></i>
                                </div>
                                <span class="career-step-label">Personal Info</span>
                            </div>
                            <div class="career-progress-line" aria-hidden="true"></div>
                            <div class="career-progress-step" data-step="2" aria-label="Step 2 of 4: Position & Experience - Not completed">
                                <div class="career-step-circle">
                                    <span class="career-step-number" aria-hidden="true">2</span>
                                    <i class="fas fa-check career-step-check d-none" aria-hidden="true"></i>
                                </div>
                                <span class="career-step-label">Position & Experience</span>
                            </div>
                            <div class="career-progress-line" aria-hidden="true"></div>
                            <div class="career-progress-step" data-step="3" aria-label="Step 3 of 4: Documents - Not completed">
                                <div class="career-step-circle">
                                    <span class="career-step-number" aria-hidden="true">3</span>
                                    <i class="fas fa-check career-step-check d-none" aria-hidden="true"></i>
                                </div>
                                <span class="career-step-label">Documents</span>
                            </div>
                            <div class="career-progress-line" aria-hidden="true"></div>
                            <div class="career-progress-step" data-step="4" aria-label="Step 4 of 4: Review & Submit - Not completed">
                                <div class="career-step-circle">
                                    <span class="career-step-number" aria-hidden="true">4</span>
                                    <i class="fas fa-check career-step-check d-none" aria-hidden="true"></i>
                                </div>
                                <span class="career-step-label">Review & Submit</span>
                            </div>
                        </div>
                    </div>

                    <!-- Application Form -->
                    <form id="applicationForm" class="application-form-content" novalidate aria-label="Job application form">
                        <!-- Step 1: Personal Information -->
                        <div class="career-form-step active" data-step="1">
                            <div class="card shadow-sm border-0" style="border-radius: 16px;">
                                <div class="card-body p-4">
                                    <h4 class="card-title fw-bold mb-4" style="color: #FF4900;">Personal Information</h4>
                                    
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="firstName" class="form-label fw-semibold required">First Name</label>
                                            <input type="text" class="form-control" id="firstName" name="firstName" required aria-describedby="firstName-error" style="border-radius: 8px; border: 2px solid #e0e0e0; padding: 12px 16px;">
                                            <div class="invalid-feedback" id="firstName-error">Please provide your first name.</div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="lastName" class="form-label fw-semibold">Last Name *</label>
                                            <input type="text" class="form-control" id="lastName" name="lastName" required style="border-radius: 8px; border: 2px solid #e0e0e0; padding: 12px 16px;">
                                            <div class="invalid-feedback">Please provide your last name.</div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="email" class="form-label fw-semibold">Email Address *</label>
                                            <input type="email" class="form-control" id="email" name="email" required style="border-radius: 8px; border: 2px solid #e0e0e0; padding: 12px 16px;">
                                            <div class="invalid-feedback">Please provide a valid email address.</div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="phone" class="form-label fw-semibold">Phone Number *</label>
                                            <input type="tel" class="form-control" id="phone" name="phone" required style="border-radius: 8px; border: 2px solid #e0e0e0; padding: 12px 16px;">
                                            <div class="invalid-feedback">Please provide your phone number.</div>
                                        </div>
                                        <div class="col-12">
                                            <label for="location" class="form-label fw-semibold">Current Location *</label>
                                            <input type="text" class="form-control" id="location" name="location" placeholder="City, State/Country" required style="border-radius: 8px; border: 2px solid #e0e0e0; padding: 12px 16px;">
                                            <div class="invalid-feedback">Please provide your current location.</div>
                                        </div>
                                        <div class="col-12">
                                            <label for="linkedinUrl" class="form-label fw-semibold">LinkedIn Profile</label>
                                            <input type="url" class="form-control" id="linkedinUrl" name="linkedinUrl" placeholder="https://linkedin.com/in/yourprofile" style="border-radius: 8px; border: 2px solid #e0e0e0; padding: 12px 16px;">
                                            <div class="form-text">Optional: Share your LinkedIn profile to help us learn more about you.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 2: Position & Experience -->
                        <div class="career-form-step" data-step="2">
                            <div class="card shadow-sm border-0" style="border-radius: 16px;">
                                <div class="card-body p-4">
                                    <h4 class="card-title fw-bold mb-4" style="color: #FF4900;">Position & Experience</h4>
                                    
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label for="position" class="form-label fw-semibold">Preferred Position *</label>
                                            <select class="form-select" id="position" name="position" required style="border-radius: 8px; border: 2px solid #e0e0e0; padding: 12px 16px;">
                                                <option value="">Select a position...</option>
                                                <option value="senior-fullstack-dev">Senior Full-Stack Developer</option>
                                                <option value="senior-ui-ux-designer">Senior UI/UX Designer</option>
                                                <option value="digital-marketing-intern">Digital Marketing Intern</option>
                                                <option value="business-development-manager">Business Development Manager</option>
                                                <option value="frontend-development-intern">Frontend Development Intern</option>
                                                <option value="creative-graphic-designer">Creative Graphic Designer</option>
                                                <option value="open-to-opportunities">Open to any suitable position</option>
                                            </select>
                                            <div class="invalid-feedback">Please select your preferred position.</div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="experience" class="form-label fw-semibold">Years of Experience *</label>
                                            <select class="form-select" id="experience" name="experience" required style="border-radius: 8px; border: 2px solid #e0e0e0; padding: 12px 16px;">
                                                <option value="">Select experience level...</option>
                                                <option value="0-1">0-1 years (Entry Level)</option>
                                                <option value="1-3">1-3 years (Junior Level)</option>
                                                <option value="3-5">3-5 years (Mid Level)</option>
                                                <option value="5-7">5-7 years (Senior Level)</option>
                                                <option value="7+">7+ years (Expert Level)</option>
                                            </select>
                                            <div class="invalid-feedback">Please select your experience level.</div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="availability" class="form-label fw-semibold">Availability *</label>
                                            <select class="form-select" id="availability" name="availability" required style="border-radius: 8px; border: 2px solid #e0e0e0; padding: 12px 16px;">
                                                <option value="">Select availability...</option>
                                                <option value="immediate">Available immediately</option>
                                                <option value="2-weeks">2 weeks notice</option>
                                                <option value="1-month">1 month notice</option>
                                                <option value="2-months">2 months notice</option>
                                                <option value="flexible">Flexible timing</option>
                                            </select>
                                            <div class="invalid-feedback">Please select your availability.</div>
                                        </div>
                                        <div class="col-12">
                                            <label for="skills" class="form-label fw-semibold">Key Skills & Technologies *</label>
                                            <textarea class="form-control" id="skills" name="skills" rows="3" placeholder="List your key skills, technologies, and tools (e.g., React, Figma, JavaScript, Marketing, etc.)" required style="border-radius: 8px; border: 2px solid #e0e0e0; padding: 12px 16px; resize: vertical;"></textarea>
                                            <div class="invalid-feedback">Please list your key skills and technologies.</div>
                                        </div>
                                        <div class="col-12">
                                            <label for="motivation" class="form-label fw-semibold">Why do you want to join Manifest Digital? *</label>
                                            <textarea class="form-control" id="motivation" name="motivation" rows="4" placeholder="Tell us what interests you about working with our team and how you can contribute to our mission..." required style="border-radius: 8px; border: 2px solid #e0e0e0; padding: 12px 16px; resize: vertical;"></textarea>
                                            <div class="invalid-feedback">Please share your motivation for joining our team.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 3: Documents -->
                        <div class="career-form-step" data-step="3">
                            <div class="card shadow-sm border-0" style="border-radius: 16px;">
                                <div class="card-body p-4">
                                    <h4 class="card-title fw-bold mb-4" style="color: #FF4900;">Documents & Portfolio</h4>
                                    
                                    <div class="row g-4">
                                        <!-- Resume Upload -->
                                        <div class="col-12">
                                            <label class="form-label fw-semibold">Resume/CV *</label>
                                            <div class="file-upload-area" id="resumeUpload">
                                                <div class="file-upload-content text-center p-4" style="border: 2px dashed #ddd; border-radius: 12px; background: #fafafa; cursor: pointer; transition: all 0.3s ease;">
                                                    <i class="fas fa-cloud-upload-alt fa-2x mb-3" style="color: #999;"></i>
                                                    <p class="mb-2 fw-semibold" style="color: #666;">Drop your resume here or click to browse</p>
                                                    <p class="mb-0 small text-muted">Supported formats: PDF, DOC, DOCX (Max 5MB)</p>
                                                    <input type="file" id="resumeFile" name="resumeFile" accept=".pdf,.doc,.docx" hidden required>
                                                </div>
                                                <div class="file-preview d-none mt-3">
                                                    <div class="d-flex align-items-center justify-content-between p-3 bg-light rounded-3">
                                                        <div class="d-flex align-items-center">
                                                            <i class="fas fa-file-pdf fa-lg me-3" style="color: #FF4900;"></i>
                                                            <div>
                                                                <div class="fw-semibold file-name"></div>
                                                                <small class="text-muted file-size"></small>
                                                            </div>
                                                        </div>
                                                        <button type="button" class="btn btn-sm btn-outline-danger remove-file">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="invalid-feedback">Please upload your resume.</div>
                                            </div>
                                        </div>

                                        <!-- Portfolio Link -->
                                        <div class="col-12">
                                            <label for="portfolioUrl" class="form-label fw-semibold">Portfolio/Website URL</label>
                                            <input type="url" class="form-control" id="portfolioUrl" name="portfolioUrl" placeholder="https://yourportfolio.com" style="border-radius: 8px; border: 2px solid #e0e0e0; padding: 12px 16px;">
                                            <div class="form-text">Optional: Share your portfolio, GitHub, or personal website.</div>
                                        </div>

                                        <!-- Cover Letter -->
                                        <div class="col-12">
                                            <label for="coverLetter" class="form-label fw-semibold">Cover Letter</label>
                                            <textarea class="form-control" id="coverLetter" name="coverLetter" rows="6" placeholder="Optional: Write a personalized message about your interest in this position and how your experience aligns with our needs..." style="border-radius: 8px; border: 2px solid #e0e0e0; padding: 12px 16px; resize: vertical;"></textarea>
                                            <div class="form-text">Optional: A cover letter helps us understand your unique qualifications.</div>
                                        </div>

                                        <!-- Additional Documents -->
                                        <div class="col-12">
                                            <label class="form-label fw-semibold">Additional Documents (Optional)</label>
                                            <div class="file-upload-area" id="additionalUpload">
                                                <div class="file-upload-content text-center p-4" style="border: 2px dashed #ddd; border-radius: 12px; background: #fafafa; cursor: pointer; transition: all 0.3s ease;">
                                                    <i class="fas fa-paperclip fa-2x mb-3" style="color: #999;"></i>
                                                    <p class="mb-2 fw-semibold" style="color: #666;">Upload certificates, references, or other documents</p>
                                                    <p class="mb-0 small text-muted">Supported formats: PDF, DOC, DOCX, JPG, PNG (Max 5MB each)</p>
                                                    <input type="file" id="additionalFiles" name="additionalFiles" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" multiple hidden>
                                                </div>
                                                <div class="additional-files-preview mt-3"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 4: Review & Submit -->
                        <div class="career-form-step" data-step="4">
                            <div class="card shadow-sm border-0" style="border-radius: 16px;">
                                <div class="card-body p-4">
                                    <h4 class="card-title fw-bold mb-4" style="color: #FF4900;">Review & Submit</h4>
                                    
                                    <div class="application-summary">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="summary-item">
                                                    <label class="fw-semibold text-muted">Full Name</label>
                                                    <div class="summary-value" id="summaryName"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="summary-item">
                                                    <label class="fw-semibold text-muted">Email</label>
                                                    <div class="summary-value" id="summaryEmail"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="summary-item">
                                                    <label class="fw-semibold text-muted">Position</label>
                                                    <div class="summary-value" id="summaryPosition"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="summary-item">
                                                    <label class="fw-semibold text-muted">Experience</label>
                                                    <div class="summary-value" id="summaryExperience"></div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="summary-item">
                                                    <label class="fw-semibold text-muted">Resume</label>
                                                    <div class="summary-value" id="summaryResume"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr class="my-4">

                                    <div class="form-check mb-4">
                                        <input class="form-check-input" type="checkbox" id="termsAccept" name="termsAccept" required style="transform: scale(1.2);">
                                        <label class="form-check-label fw-semibold" for="termsAccept">
                                            I agree to the <a href="#" style="color: #FF4900;">Terms of Service</a> and <a href="#" style="color: #FF4900;">Privacy Policy</a> *
                                        </label>
                                        <div class="invalid-feedback">You must agree to the terms and privacy policy.</div>
                                    </div>

                                    <div class="form-check mb-4">
                                        <input class="form-check-input" type="checkbox" id="dataConsent" name="dataConsent" required style="transform: scale(1.2);">
                                        <label class="form-check-label fw-semibold" for="dataConsent">
                                            I consent to the processing of my personal data for recruitment purposes *
                                        </label>
                                        <div class="invalid-feedback">Data processing consent is required.</div>
                                    </div>

                                    <div class="form-check mb-4">
                                        <input class="form-check-input" type="checkbox" id="marketingConsent" name="marketingConsent" style="transform: scale(1.2);">
                                        <label class="form-check-label" for="marketingConsent">
                                            I would like to receive updates about future opportunities at Manifest Digital (Optional)
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Navigation -->
                        <div class="form-navigation d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-outline-secondary" id="prevBtn" style="display: none; padding: 12px 32px; border-radius: 8px; font-weight: 600;">
                                <i class="fas fa-arrow-left me-2"></i>Previous
                            </button>
                            <div class="ms-auto">
                                <button type="button" class="btn" id="nextBtn" style="background: linear-gradient(135deg, #FF4900 0%, #FF6B35 100%); color: white; border: none; padding: 12px 32px; border-radius: 8px; font-weight: 600;">
                                    Next<i class="fas fa-arrow-right ms-2"></i>
                                </button>
                                <button type="submit" class="btn" id="submitBtn" style="background: linear-gradient(135deg, #FF4900 0%, #FF6B35 100%); color: white; border: none; padding: 12px 32px; border-radius: 8px; font-weight: 600; display: none;">
                                    <i class="fas fa-paper-plane me-2"></i>Submit Application
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Application Success Section -->
    <section id="applicationSuccess" class="application-success py-5 d-none" style="background: linear-gradient(135deg, #FFFCFA 0%, #FFF8F3 50%, #FFFCFA 100%); position: relative; overflow: hidden;">
        <!-- Decorative Elements positioned at viewport edges -->
        <img src="images/decorative/hero_underline.svg" alt="" class="position-absolute d-none d-lg-block" style="left: -50px; top: 15%; width: 100px; opacity: 0.4; animation: float 6s ease-in-out infinite; background: transparent !important;">
        <img src="images/decorative/cta_top_right_mem_dots_f_tri%20(1).svg" alt="" class="position-absolute d-none d-lg-block" style="right: -40px; top: 25%; width: 80px; opacity: 0.5; animation: float 8s ease-in-out infinite reverse; background: transparent !important;">
        
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="success-content">
                        <!-- Success Animation Container -->
                        <div class="text-center mb-5">
                            <div class="success-icon-container mb-4" style="position: relative;">
                                <div class="success-circle" style="width: 120px; height: 120px; margin: 0 auto; border-radius: 50%; background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%); display: flex; align-items: center; justify-content: center; box-shadow: 0 10px 30px rgba(46, 204, 113, 0.3);">
                                    <i class="fas fa-check fa-3x text-white success-checkmark"></i>
                                </div>
                                <!-- Animated Success Rings -->
                                <div class="success-ring-1" style="position: absolute; top: -10px; left: 50%; transform: translateX(-50%); width: 140px; height: 140px; border: 2px solid rgba(46, 204, 113, 0.3); border-radius: 50%; animation: pulse-ring 2s infinite;"></div>
                                <div class="success-ring-2" style="position: absolute; top: -20px; left: 50%; transform: translateX(-50%); width: 160px; height: 160px; border: 2px solid rgba(46, 204, 113, 0.2); border-radius: 50%; animation: pulse-ring 2s infinite 0.5s;"></div>
                            </div>
                            
                            <h2 class="display-4 fw-bold mb-4" style="color: #2ecc71;">Application Submitted Successfully!</h2>
                            <p class="lead mb-4" style="color: #666; font-size: 1.25rem; line-height: 1.6;">
                                Thank you for your interest in joining the Manifest Digital team. We're excited to learn more about you and explore how we can grow together.
                            </p>
                        </div>
                    </div>

                    <!-- What Happens Next Timeline -->
                    <div class="next-steps-timeline mb-5">
                        <h3 class="h2 fw-bold text-center mb-5" style="color: #333;">What Happens Next?</h3>
                        
                        <div class="timeline-container">
                            <div class="row g-4">
                                <!-- Step 1: Review -->
                                <div class="col-md-6 col-lg-3">
                                    <div class="timeline-step timeline-item text-center h-100 p-4 rounded-3" style="background: linear-gradient(135deg, rgba(52,152,219,0.05) 0%, rgba(41,128,185,0.05) 100%); border: 1px solid rgba(52,152,219,0.1); transition: all 0.3s ease;">
                                        <div class="step-number mb-3 mx-auto d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: linear-gradient(135deg, #3498db 0%, #2980b9 100%); border-radius: 50%; color: white; font-weight: bold;">1</div>
                                        <div class="step-icon mb-3">
                                            <i class="fas fa-search fa-2x" style="color: #3498db;"></i>
                                        </div>
                                        <h4 class="h5 fw-bold mb-3" style="color: #3498db;">Application Review</h4>
                                        <p class="small text-muted mb-3">Our HR team carefully reviews your application, resume, and portfolio.</p>
                                        <div class="timeline-duration">
                                            <span class="badge rounded-pill" style="background: rgba(52,152,219,0.1); color: #3498db; font-size: 0.75rem;">24-48 Hours</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Step 2: Initial Contact -->
                                <div class="col-md-6 col-lg-3">
                                    <div class="timeline-step timeline-item text-center h-100 p-4 rounded-3" style="background: linear-gradient(135deg, rgba(155,89,182,0.05) 0%, rgba(142,68,173,0.05) 100%); border: 1px solid rgba(155,89,182,0.1); transition: all 0.3s ease;">
                                        <div class="step-number mb-3 mx-auto d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: linear-gradient(135deg, #9b59b6 0%, #8e44ad 100%); border-radius: 50%; color: white; font-weight: bold;">2</div>
                                        <div class="step-icon mb-3">
                                            <i class="fas fa-phone fa-2x" style="color: #9b59b6;"></i>
                                        </div>
                                        <h4 class="h5 fw-bold mb-3" style="color: #9b59b6;">Initial Contact</h4>
                                        <p class="small text-muted mb-3">We'll reach out to schedule a brief phone or video screening call.</p>
                                        <div class="timeline-duration">
                                            <span class="badge rounded-pill" style="background: rgba(155,89,182,0.1); color: #9b59b6; font-size: 0.75rem;">Within 3 Days</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Step 3: Interview Process -->
                                <div class="col-md-6 col-lg-3">
                                    <div class="timeline-step timeline-item text-center h-100 p-4 rounded-3" style="background: linear-gradient(135deg, rgba(241,196,15,0.05) 0%, rgba(230,126,34,0.05) 100%); border: 1px solid rgba(241,196,15,0.1); transition: all 0.3s ease;">
                                        <div class="step-number mb-3 mx-auto d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: linear-gradient(135deg, #f1c40f 0%, #e67e22 100%); border-radius: 50%; color: white; font-weight: bold;">3</div>
                                        <div class="step-icon mb-3">
                                            <i class="fas fa-users fa-2x" style="color: #f1c40f;"></i>
                                        </div>
                                        <h4 class="h5 fw-bold mb-3" style="color: #f1c40f;">Interview Process</h4>
                                        <p class="small text-muted mb-3">Meet with team members, showcase your skills, and learn about our culture.</p>
                                        <div class="timeline-duration">
                                            <span class="badge rounded-pill" style="background: rgba(241,196,15,0.1); color: #f1c40f; font-size: 0.75rem;">1-2 Weeks</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Step 4: Decision -->
                                <div class="col-md-6 col-lg-3">
                                    <div class="timeline-step timeline-item text-center h-100 p-4 rounded-3" style="background: linear-gradient(135deg, rgba(46,204,113,0.05) 0%, rgba(39,174,96,0.05) 100%); border: 1px solid rgba(46,204,113,0.1); transition: all 0.3s ease;">
                                        <div class="step-number mb-3 mx-auto d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%); border-radius: 50%; color: white; font-weight: bold;">4</div>
                                        <div class="step-icon mb-3">
                                            <i class="fas fa-handshake fa-2x" style="color: #2ecc71;"></i>
                                        </div>
                                        <h4 class="h5 fw-bold mb-3" style="color: #2ecc71;">Final Decision</h4>
                                        <p class="small text-muted mb-3">We'll make our decision and extend an offer to the selected candidate.</p>
                                        <div class="timeline-duration">
                                            <span class="badge rounded-pill" style="background: rgba(46,204,113,0.1); color: #2ecc71; font-size: 0.75rem;">Within 1 Week</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information & Support -->
                    <div class="contact-support mb-5">
                        <div class="row">
                            <div class="col-lg-6 mb-4 mb-lg-0">
                                <div class="h-100 p-4 rounded-3" style="background: linear-gradient(135deg, rgba(255,73,0,0.03) 0%, rgba(255,107,53,0.03) 100%); border: 1px solid rgba(255,73,0,0.1);">
                                    <h4 class="h5 fw-bold mb-3" style="color: #FF4900;">Questions About Your Application?</h4>
                                    <p class="text-muted mb-3">Our HR team is here to help you throughout the process.</p>
                                    <div class="contact-details">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-envelope me-3" style="color: #FF4900; width: 20px;"></i>
                                            <a href="mailto:careers@manifestdigital.com" class="text-decoration-none" style="color: #666;">careers@manifestdigital.com</a>
                                        </div>
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-phone me-3" style="color: #FF4900; width: 20px;"></i>
                                            <a href="tel:+1234567890" class="text-decoration-none" style="color: #666;">+1 (234) 567-8900</a>
                                        </div>
                                        <div class="d-flex align-items-start">
                                            <i class="fas fa-clock me-3 mt-1" style="color: #FF4900; width: 20px;"></i>
                                            <span class="text-muted small">Response time: Within 24 hours</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="h-100 p-4 rounded-3" style="background: linear-gradient(135deg, rgba(52,152,219,0.03) 0%, rgba(41,128,185,0.03) 100%); border: 1px solid rgba(52,152,219,0.1);">
                                    <h4 class="h5 fw-bold mb-3" style="color: #3498db;">Stay Connected</h4>
                                    <p class="text-muted mb-3">Follow us for company updates, team spotlights, and new opportunities.</p>
                                    <div class="social-links d-flex gap-3">
                                        <a href="#" class="social-link d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: linear-gradient(135deg, #1da1f2 0%, #0d8bd9 100%); border-radius: 50%; color: white; text-decoration: none; transition: transform 0.2s ease;">
                                            <i class="fab fa-twitter"></i>
                                        </a>
                                        <a href="#" class="social-link d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: linear-gradient(135deg, #0077b5 0%, #005885 100%); border-radius: 50%; color: white; text-decoration: none; transition: transform 0.2s ease;">
                                            <i class="fab fa-linkedin-in"></i>
                                        </a>
                                        <a href="#" class="social-link d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: linear-gradient(135deg, #833ab4 0%, #fd1d1d 50%, #fcb045 100%); border-radius: 50%; color: white; text-decoration: none; transition: transform 0.2s ease;">
                                            <i class="fab fa-instagram"></i>
                                        </a>
                                        <a href="#" class="social-link d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: linear-gradient(135deg, #FF4900 0%, #FF6B35 100%); border-radius: 50%; color: white; text-decoration: none; transition: transform 0.2s ease;">
                                            <i class="fas fa-globe"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Application Summary & Reference -->
                    <div class="application-reference mb-5">
                        <div class="text-center p-4 rounded-3" style="background: linear-gradient(135deg, rgba(155,89,182,0.03) 0%, rgba(142,68,173,0.03) 100%); border: 1px solid rgba(155,89,182,0.1);">
                            <h4 class="h5 fw-bold mb-3" style="color: #9b59b6;">Your Application Reference</h4>
                            <p class="text-muted mb-3">Save this reference number for future correspondence:</p>
                            <div class="reference-number d-inline-flex align-items-center px-4 py-2 rounded-pill" style="background: linear-gradient(135deg, #9b59b6 0%, #8e44ad 100%); color: white; font-family: 'Courier New', monospace; font-weight: bold; letter-spacing: 1px;">
                                <i class="fas fa-hashtag me-2"></i>
                                <span id="applicationReference">MD-2024-APP-7891</span>
                            </div>
                            <p class="small text-muted mt-3 mb-0">You will receive a confirmation email shortly with all the details.</p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="text-center">
                        <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                            <button type="button" class="btn btn-lg px-4 py-3" onclick="resetApplicationForm()" style="background: linear-gradient(135deg, #FF4900 0%, #FF6B35 100%); border: none; color: white; border-radius: 50px; font-weight: 600; transition: all 0.3s ease;">
                                <i class="fas fa-plus me-2"></i>Submit Another Application
                            </button>
                            <a href="#opportunities" class="btn btn-outline-primary btn-lg px-4 py-3" style="border: 2px solid #FF4900; color: #FF4900; border-radius: 50px; font-weight: 600; text-decoration: none; transition: all 0.3s ease;">
                                <i class="fas fa-search me-2"></i>View Other Opportunities
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <section class="cta-footer">
        <div class="cta">
            <!-- Decorative elements for CTA section -->
            <img src="images/decorative/cta_left_mem_dots_f_circle2.svg" alt="" class="decorative-element cta-left critical-image">
            <img src="images/decorative/cta_top_right_mem_dots_f_tri (1).svg" alt="" class="decorative-element cta-top-right critical-image">
            <img src="images/decorative/right_under_cta_mem_dots_f_circle2.svg" alt="" class="decorative-element cta-right-under critical-image">
            <img src="images/decorative/left_under_cta_mem_dots_f_tri (1).svg" alt="" class="decorative-element cta-left-under critical-image">
            
            <h2>Ready to join our amazing team?</h2>
            <a href="#application-form" class="btn-cta">Apply Now</a>
            <img src="images/decorative/left_under_footer_mem_donut (1).svg" alt="" class="decorative-element cta-button-donut critical-image">
        </div>
        <footer>
            <div class="footer-content">
                <div class="footer-logo"></div>
                <nav class="footer-nav">
                    <div>
                        <a href="about.html">About Us</a>
                        <a href="opportunities.html">Opportunities</a>
                        <a href="blog.html">Our Blog</a>
                        <a href="solutions.html">Solutions</a>
                        <a href="policies.html">Policies</a>
                    </div>
                    <div>
                        <a href="#">Mobile App Design</a>
                        <a href="#">Website Development</a>
                        <a href="#">SAP Consulting</a>
                        <a href="#">Brand Positioning</a>
                        <a href="#">IT Training</a>
                    </div>
                    <div>
                        <a href="#">SEO Services</a>
                        <a href="#">QA Testing</a>
                        <a href="#">Blockchain Solutions</a>
                        <a href="#">Cyber Security</a>
                        <a href="#">Cloud Computing</a>
                    </div>
                </nav>
            </div>
            <div class="social">
                <h3 class="social-heading">Connect With Us</h3>
                <div class="social-icons">
                    <a href="#" class="social-icon" aria-label="X (Twitter)"><i class="fab fa-x-twitter"></i></a>
                    <a href="#" class="social-icon" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-icon" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#" class="social-icon" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
            <div class="copyright"><p>Copyright 2025 - Manifest Digital</p></div>
        </footer>
    </section>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
    
    <script>
        // Global Error Handler
        window.addEventListener('error', function(event) {
            console.error('Global JavaScript Error:', event.error);
            // Hide any visible error messages and show fallback
            const errorElements = document.querySelectorAll('.alert-danger');
            errorElements.forEach(el => el.style.display = 'none');
            
            // Show a user-friendly message
            const body = document.body;
            if (body && !document.querySelector('.global-error-message')) {
                const errorDiv = document.createElement('div');
                errorDiv.className = 'alert alert-warning global-error-message';
                errorDiv.style.cssText = 'position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 9999; max-width: 90%;';
                errorDiv.innerHTML = '<strong>Notice:</strong> Some interactive features may be limited. The page content is still fully accessible.';
                body.appendChild(errorDiv);
                
                // Auto-hide after 5 seconds
                setTimeout(() => {
                    if (errorDiv.parentNode) {
                        errorDiv.parentNode.removeChild(errorDiv);
                    }
                }, 5000);
            }
            
            return true; // Prevent default error handling
        });

        // Handle unhandled promise rejections
        window.addEventListener('unhandledrejection', function(event) {
            console.error('Unhandled Promise Rejection:', event.reason);
            event.preventDefault(); // Prevent default browser behavior
        });

        // Preloader Animation with Error Handling
        document.addEventListener('DOMContentLoaded', function() {
            try {
                // Check if anime.js is loaded
                if (typeof anime === 'undefined') {
                    console.warn('Anime.js not loaded, skipping animations');
                    // Hide preloader immediately if animations can't run
                    const preloader = document.getElementById('preloader');
                    if (preloader) {
                        preloader.style.display = 'none';
                    }
                    return;
                }

                const logoImage = document.querySelector('.logo-image');
                const loadingText = document.querySelector('.loading-text');
                const progressBar = document.querySelector('.progress-bar');
                const dots = document.querySelectorAll('.loading-dots .dot');

                // Animate logo if elements exist
                if (logoImage && loadingText) {
                    setTimeout(() => {
                        logoImage.classList.add('loaded');
                        loadingText.classList.add('show');
                    }, 500);
                }

                // Animate dots if they exist
                if (dots.length > 0) {
                    dots.forEach((dot, index) => {
                        anime({
                            targets: dot,
                            opacity: [0.3, 1, 0.3],
                            scale: [1, 1.2, 1],
                            duration: 1000,
                            delay: index * 200,
                            loop: true,
                            easing: 'easeInOutSine'
                        });
                    });
                }

                // Animate progress bar if it exists
                if (progressBar) {
                    anime({
                        targets: progressBar,
                        width: '100%',
                        duration: 2000,
                        easing: 'easeInOutCubic',
                        complete: function() {
                            // Hide preloader
                            setTimeout(() => {
                                const preloader = document.getElementById('preloader');
                                if (preloader) {
                                    anime({
                                        targets: preloader,
                                        opacity: 0,
                                        duration: 500,
                                        easing: 'easeOutCubic',
                                        complete: function() {
                                            preloader.style.display = 'none';
                                        }
                                    });
                                }
                            }, 300);
                        }
                    });
                } else {
                    // If no progress bar, hide preloader immediately
                    setTimeout(() => {
                        const preloader = document.getElementById('preloader');
                        if (preloader) {
                            preloader.style.display = 'none';
                        }
                    }, 1000);
                }
            } catch (error) {
                console.error('Preloader animation error:', error);
                // Hide preloader on error
                const preloader = document.getElementById('preloader');
                if (preloader) {
                    preloader.style.display = 'none';
                }
            }
        });

        // Smooth scroll for hero buttons
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

        // Hero statistics counter animation
        function animateCounters() {
            const stats = document.querySelectorAll('.hero-stat-number');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const target = entry.target;
                        const finalNumber = target.textContent;
                        const numericValue = parseInt(finalNumber.replace(/\D/g, ''));
                        
                        anime({
                            targets: { count: 0 },
                            count: numericValue,
                            duration: 2000,
                            easing: 'easeOutCubic',
                            update: function(anim) {
                                const currentValue = Math.floor(anim.animatables[0].target.count);
                                target.textContent = currentValue + finalNumber.replace(/\d/g, '').replace(/^\d+/, '');
                            }
                        });
                        
                        observer.unobserve(target);
                    }
                });
            }, { threshold: 0.5 });

            stats.forEach(stat => observer.observe(stat));
        }

        // Initialize counter animation when page loads
        document.addEventListener('DOMContentLoaded', animateCounters);

        // Comprehensive Animation System
        class AnimationController {
            constructor() {
                this.isReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
                this.animatedElements = new Set();
                this.init();
            }

            init() {
                if (this.isReducedMotion) {
                    console.log('Reduced motion preference detected, skipping animations');
                    return;
                }

                this.setupScrollAnimations();
                this.setupCardAnimations();
                this.setupFormAnimations();
                this.setupModalAnimations();
                this.setupHoverEffects();
                this.setupSuccessAnimations();
            }

            // Scroll-triggered reveal animations
            setupScrollAnimations() {
                const scrollElements = [
                    { selector: '.life-at-manifest h2', animation: 'slideInUp' },
                    { selector: '.company-values .value-card', animation: 'staggeredSlideUp' },
                    { selector: '.benefits-section h2', animation: 'slideInLeft' },
                    { selector: '.benefits-card', animation: 'staggeredFadeIn' },
                    { selector: '.opportunities-section h2', animation: 'slideInRight' },
                    { selector: '.opportunity-card', animation: 'staggeredSlideUp' },
                    { selector: '.testimonials-section h2', animation: 'fadeInScale' },
                    { selector: '.application-form h2', animation: 'bounceInDown' },
                    { selector: '.career-form-step', animation: 'slideInFromSide' }
                ];

                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting && !this.animatedElements.has(entry.target)) {
                            this.animatedElements.add(entry.target);
                            this.triggerAnimation(entry.target, entry.target.dataset.animation);
                        }
                    });
                }, { 
                    threshold: 0.1,
                    rootMargin: '0px 0px -100px 0px'
                });

                scrollElements.forEach(({ selector, animation }) => {
                    const elements = document.querySelectorAll(selector);
                    elements.forEach((el, index) => {
                        el.dataset.animation = animation;
                        el.dataset.index = index;
                        el.style.opacity = '0';
                        el.style.transform = this.getInitialTransform(animation);
                        observer.observe(el);
                    });
                });
            }

            // Get initial transform state based on animation type
            getInitialTransform(animationType) {
                const transforms = {
                    'slideInUp': 'translateY(50px)',
                    'slideInDown': 'translateY(-50px)',
                    'slideInLeft': 'translateX(-50px)',
                    'slideInRight': 'translateX(50px)',
                    'staggeredSlideUp': 'translateY(30px)',
                    'staggeredFadeIn': 'translateY(20px) scale(0.9)',
                    'fadeInScale': 'scale(0.8)',
                    'bounceInDown': 'translateY(-100px) scale(0.8)',
                    'slideInFromSide': 'translateX(-30px)'
                };
                return transforms[animationType] || 'translateY(20px)';
            }

            // Trigger specific animation
            triggerAnimation(element, animationType) {
                const index = parseInt(element.dataset.index) || 0;
                const baseDelay = animationType.includes('staggered') ? index * 100 : 0;

                const animations = {
                    'slideInUp': {
                        opacity: [0, 1],
                        translateY: [50, 0],
                        duration: 800,
                        delay: baseDelay,
                        easing: 'easeOutCubic'
                    },
                    'slideInDown': {
                        opacity: [0, 1],
                        translateY: [-50, 0],
                        duration: 600,
                        delay: baseDelay,
                        easing: 'easeOutQuart'
                    },
                    'slideInLeft': {
                        opacity: [0, 1],
                        translateX: [-50, 0],
                        duration: 700,
                        delay: baseDelay,
                        easing: 'easeOutCubic'
                    },
                    'slideInRight': {
                        opacity: [0, 1],
                        translateX: [50, 0],
                        duration: 700,
                        delay: baseDelay,
                        easing: 'easeOutCubic'
                    },
                    'staggeredSlideUp': {
                        opacity: [0, 1],
                        translateY: [30, 0],
                        duration: 600,
                        delay: baseDelay,
                        easing: 'easeOutCubic'
                    },
                    'staggeredFadeIn': {
                        opacity: [0, 1],
                        translateY: [20, 0],
                        scale: [0.9, 1],
                        duration: 500,
                        delay: baseDelay,
                        easing: 'easeOutCubic'
                    },
                    'fadeInScale': {
                        opacity: [0, 1],
                        scale: [0.8, 1],
                        duration: 800,
                        delay: baseDelay,
                        easing: 'easeOutBack'
                    },
                    'bounceInDown': {
                        opacity: [0, 1],
                        translateY: [-100, 0],
                        scale: [0.8, 1],
                        duration: 1000,
                        delay: baseDelay,
                        easing: 'easeOutBounce'
                    },
                    'slideInFromSide': {
                        opacity: [0, 1],
                        translateX: [-30, 0],
                        duration: 500,
                        delay: baseDelay,
                        easing: 'easeOutCubic'
                    }
                };

                anime({
                    targets: element,
                    ...animations[animationType]
                });
            }

            // Card hover and interaction animations
            setupCardAnimations() {
                // Opportunity cards
                document.querySelectorAll('.opportunity-card').forEach(card => {
                    card.addEventListener('mouseenter', () => {
                        if (!this.isReducedMotion) {
                            anime({
                                targets: card,
                                scale: 1.03,
                                duration: 300,
                                easing: 'easeOutCubic'
                            });
                        }
                    });

                    card.addEventListener('mouseleave', () => {
                        if (!this.isReducedMotion) {
                            anime({
                                targets: card,
                                scale: 1,
                                duration: 300,
                                easing: 'easeOutCubic'
                            });
                        }
                    });
                });

                // Benefits cards
                document.querySelectorAll('.benefits-card').forEach(card => {
                    card.addEventListener('mouseenter', () => {
                        if (!this.isReducedMotion) {
                            const icon = card.querySelector('i');
                            anime({
                                targets: icon,
                                scale: 1.2,
                                rotate: '5deg',
                                duration: 400,
                                easing: 'easeOutElastic(1, .6)'
                            });
                        }
                    });

                    card.addEventListener('mouseleave', () => {
                        if (!this.isReducedMotion) {
                            const icon = card.querySelector('i');
                            anime({
                                targets: icon,
                                scale: 1,
                                rotate: '0deg',
                                duration: 400,
                                easing: 'easeOutElastic(1, .6)'
                            });
                        }
                    });
                });

                // Value cards
                document.querySelectorAll('.value-card').forEach(card => {
                    card.addEventListener('mouseenter', () => {
                        if (!this.isReducedMotion) {
                            anime({
                                targets: card,
                                translateY: -10,
                                boxShadow: '0 20px 40px rgba(255, 73, 0, 0.15)',
                                duration: 300,
                                easing: 'easeOutCubic'
                            });
                        }
                    });

                    card.addEventListener('mouseleave', () => {
                        if (!this.isReducedMotion) {
                            anime({
                                targets: card,
                                translateY: 0,
                                boxShadow: '0 5px 15px rgba(0, 0, 0, 0.1)',
                                duration: 300,
                                easing: 'easeOutCubic'
                            });
                        }
                    });
                });
            }

            // Form step transitions and interactions
            setupFormAnimations() {
                // Form step transitions
                const originalGoToStep = window.goToStep;
                window.goToStep = (stepNumber) => {
                    if (!this.isReducedMotion) {
                        const currentStep = document.querySelector('.career-form-step.active');
                        const targetStep = document.querySelector(`#step${stepNumber}`);

                        if (currentStep && targetStep) {
                            // Animate out current step
                            anime({
                                targets: currentStep,
                                opacity: 0,
                                translateX: -30,
                                duration: 300,
                                easing: 'easeInCubic',
                                complete: () => {
                                    originalGoToStep(stepNumber);
                                    
                                    // Animate in new step
                                    anime({
                                        targets: targetStep,
                                        opacity: [0, 1],
                                        translateX: [30, 0],
                                        duration: 400,
                                        easing: 'easeOutCubic'
                                    });
                                }
                            });
                            return;
                        }
                    }
                    originalGoToStep(stepNumber);
                };

                // Form field focus animations
                document.querySelectorAll('.form-control').forEach(input => {
                    input.addEventListener('focus', () => {
                        if (!this.isReducedMotion) {
                            anime({
                                targets: input,
                                scale: 1.02,
                                borderWidth: '2px',
                                duration: 200,
                                easing: 'easeOutCubic'
                            });
                        }
                    });

                    input.addEventListener('blur', () => {
                        if (!this.isReducedMotion) {
                            anime({
                                targets: input,
                                scale: 1,
                                borderWidth: '1px',
                                duration: 200,
                                easing: 'easeOutCubic'
                            });
                        }
                    });
                });

                // File upload animations
                document.querySelectorAll('.file-upload-area').forEach(area => {
                    area.addEventListener('dragenter', () => {
                        if (!this.isReducedMotion) {
                            anime({
                                targets: area,
                                scale: 1.02,
                                duration: 200,
                                easing: 'easeOutCubic'
                            });
                        }
                    });

                    area.addEventListener('dragleave', () => {
                        if (!this.isReducedMotion) {
                            anime({
                                targets: area,
                                scale: 1,
                                duration: 200,
                                easing: 'easeOutCubic'
                            });
                        }
                    });
                });
            }

            // Modal entrance and exit animations
            setupModalAnimations() {
                const modals = document.querySelectorAll('.modal');
                modals.forEach(modal => {
                    modal.addEventListener('show.bs.modal', () => {
                        if (!this.isReducedMotion) {
                            const modalDialog = modal.querySelector('.modal-dialog');
                            anime({
                                targets: modalDialog,
                                scale: [0.8, 1],
                                opacity: [0, 1],
                                duration: 400,
                                easing: 'easeOutBack'
                            });
                        }
                    });

                    modal.addEventListener('hide.bs.modal', () => {
                        if (!this.isReducedMotion) {
                            const modalDialog = modal.querySelector('.modal-dialog');
                            anime({
                                targets: modalDialog,
                                scale: [1, 0.8],
                                opacity: [1, 0],
                                duration: 300,
                                easing: 'easeInCubic'
                            });
                        }
                    });
                });
            }

            // Button and interactive element hover effects
            setupHoverEffects() {
                // Primary buttons
                document.querySelectorAll('.btn-primary, .btn-outline-primary').forEach(btn => {
                    btn.addEventListener('mouseenter', () => {
                        if (!this.isReducedMotion) {
                            anime({
                                targets: btn,
                                scale: 1.05,
                                duration: 200,
                                easing: 'easeOutCubic'
                            });
                        }
                    });

                    btn.addEventListener('mouseleave', () => {
                        if (!this.isReducedMotion) {
                            anime({
                                targets: btn,
                                scale: 1,
                                duration: 200,
                                easing: 'easeOutCubic'
                            });
                        }
                    });
                });

                // Filter buttons
                document.querySelectorAll('.filter-btn').forEach(btn => {
                    btn.addEventListener('click', () => {
                        if (!this.isReducedMotion) {
                            anime({
                                targets: btn,
                                scale: [1, 0.95, 1],
                                duration: 300,
                                easing: 'easeOutElastic(1, .6)'
                            });
                        }
                    });
                });
            }

            // Success and completion animations
            setupSuccessAnimations() {
                // Success checkmark animation (enhanced)
                const originalHandleSuccessfulSubmission = window.handleSuccessfulSubmission;
                if (originalHandleSuccessfulSubmission) {
                    window.handleSuccessfulSubmission = (applicationRef) => {
                        originalHandleSuccessfulSubmission(applicationRef);
                        
                        if (!this.isReducedMotion) {
                            // Animate success section entrance
                            const successSection = document.getElementById('applicationSuccess');
                            if (successSection) {
                                anime({
                                    targets: successSection.querySelectorAll('.success-content > *'),
                                    opacity: [0, 1],
                                    translateY: [30, 0],
                                    delay: anime.stagger(200),
                                    duration: 600,
                                    easing: 'easeOutCubic'
                                });

                                // Special animation for checkmark
                                const checkmark = successSection.querySelector('.success-checkmark');
                                if (checkmark) {
                                    anime({
                                        targets: checkmark,
                                        scale: [0, 1.2, 1],
                                        rotate: [0, 360],
                                        duration: 800,
                                        delay: 300,
                                        easing: 'easeOutBounce'
                                    });
                                }
                            }
                        }
                    };
                }
            }

            // Loading state animations
            animateLoadingState(element, isLoading) {
                if (this.isReducedMotion) return;

                if (isLoading) {
                    anime({
                        targets: element,
                        scale: 0.95,
                        duration: 200,
                        easing: 'easeOutCubic'
                    });
                } else {
                    anime({
                        targets: element,
                        scale: 1,
                        duration: 200,
                        easing: 'easeOutCubic'
                    });
                }
            }

            // Notification animations
            animateNotification(notification) {
                if (this.isReducedMotion) return;

                anime({
                    targets: notification,
                    translateX: [300, 0],
                    opacity: [0, 1],
                    duration: 500,
                    easing: 'easeOutCubic'
                });
            }
        }

        // Initialize animation system
        let animationController;
        document.addEventListener('DOMContentLoaded', () => {
            animationController = new AnimationController();
        });

        // Analytics Tracking System
        class AnalyticsTracker {
            constructor() {
                this.isGoogleAnalyticsLoaded = false;
                this.eventQueue = [];
                this.sessionId = this.generateSessionId();
                this.startTime = Date.now();
                this.scrollDepth = 0;
                this.maxScrollDepth = 0;
                this.timeOnPage = 0;
                this.init();
            }

            generateSessionId() {
                return 'careers_' + Date.now() + '_' + Math.random().toString(36).substring(2, 15);
            }

            init() {
                this.checkGoogleAnalytics();
                this.setupPageTracking();
                this.setupScrollTracking();
                this.setupEngagementTracking();
                this.setupFormTracking();
                this.setupJobListingTracking();
                this.setupModalTracking();
                this.setupErrorTracking();
                this.setupPerformanceTracking();
                
                // Process queued events when GA loads
                this.waitForGoogleAnalytics();
            }

            checkGoogleAnalytics() {
                this.isGoogleAnalyticsLoaded = typeof gtag !== 'undefined';
                if (!this.isGoogleAnalyticsLoaded) {
                    console.info('Google Analytics not detected. Events will be queued and logged locally.');
                }
            }

            waitForGoogleAnalytics() {
                const checkInterval = setInterval(() => {
                    if (typeof gtag !== 'undefined') {
                        this.isGoogleAnalyticsLoaded = true;
                        this.processEventQueue();
                        clearInterval(checkInterval);
                    }
                }, 1000);

                // Stop checking after 30 seconds
                setTimeout(() => clearInterval(checkInterval), 30000);
            }

            processEventQueue() {
                while (this.eventQueue.length > 0) {
                    const event = this.eventQueue.shift();
                    this.sendEvent(event.action, event.category, event.label, event.value);
                }
            }

            // Core event tracking method
            trackEvent(action, category, label = '', value = null) {
                const eventData = {
                    action,
                    category,
                    label,
                    value,
                    timestamp: Date.now(),
                    sessionId: this.sessionId,
                    url: window.location.href,
                    userAgent: navigator.userAgent
                };

                // Log locally for debugging
                console.log('Analytics Event:', eventData);

                if (this.isGoogleAnalyticsLoaded) {
                    this.sendEvent(action, category, label, value);
                } else {
                    this.eventQueue.push(eventData);
                }

                // Store in localStorage for offline analysis
                this.storeEventLocally(eventData);
            }

            sendEvent(action, category, label, value) {
                if (typeof gtag !== 'undefined') {
                    const eventParams = {
                        event_category: category,
                        event_label: label,
                        session_id: this.sessionId
                    };

                    if (value !== null) {
                        eventParams.value = value;
                    }

                    gtag('event', action, eventParams);
                }
            }

            storeEventLocally(eventData) {
                try {
                    const events = JSON.parse(localStorage.getItem('careers_analytics') || '[]');
                    events.push(eventData);
                    
                    // Keep only last 100 events to prevent storage bloat
                    if (events.length > 100) {
                        events.splice(0, events.length - 100);
                    }
                    
                    localStorage.setItem('careers_analytics', JSON.stringify(events));
                } catch (error) {
                    console.warn('Failed to store analytics event locally:', error);
                }
            }

            // Page-level tracking
            setupPageTracking() {
                // Track page view
                this.trackEvent('page_view', 'Careers', 'Opportunities Page');

                // Track page load performance
                window.addEventListener('load', () => {
                    const loadTime = Date.now() - this.startTime;
                    this.trackEvent('page_load_time', 'Performance', 'Load Complete', loadTime);
                });

                // Track page unload
                window.addEventListener('beforeunload', () => {
                    this.timeOnPage = Date.now() - this.startTime;
                    this.trackEvent('page_time', 'Engagement', 'Time on Page', Math.round(this.timeOnPage / 1000));
                    this.trackEvent('scroll_depth', 'Engagement', 'Max Scroll Depth', this.maxScrollDepth);
                });

                // Track visibility changes
                document.addEventListener('visibilitychange', () => {
                    if (document.hidden) {
                        this.trackEvent('page_hidden', 'Engagement', 'Tab Hidden');
                    } else {
                        this.trackEvent('page_visible', 'Engagement', 'Tab Visible');
                    }
                });
            }

            // Scroll depth tracking
            setupScrollTracking() {
                let ticking = false;

                const updateScrollDepth = () => {
                    const scrolled = window.scrollY;
                    const maxScroll = document.documentElement.scrollHeight - window.innerHeight;
                    this.scrollDepth = Math.round((scrolled / maxScroll) * 100);
                    
                    if (this.scrollDepth > this.maxScrollDepth) {
                        this.maxScrollDepth = this.scrollDepth;
                        
                        // Track milestone scroll depths
                        const milestones = [25, 50, 75, 90, 100];
                        milestones.forEach(milestone => {
                            if (this.maxScrollDepth >= milestone && !this[`scrollMilestone${milestone}`]) {
                                this[`scrollMilestone${milestone}`] = true;
                                this.trackEvent('scroll_milestone', 'Engagement', `${milestone}% Scrolled`, milestone);
                            }
                        });
                    }
                    
                    ticking = false;
                };

                window.addEventListener('scroll', () => {
                    if (!ticking) {
                        requestAnimationFrame(updateScrollDepth);
                        ticking = true;
                    }
                }, { passive: true });
            }

            // Section visibility tracking
            setupEngagementTracking() {
                const sections = [
                    { selector: '.opportunities-hero', name: 'Hero Section' },
                    { selector: '.life-at-manifest', name: 'Life at Manifest' },
                    { selector: '.benefits-section', name: 'Benefits Package' },
                    { selector: '.opportunities-section', name: 'Job Listings' },
                    { selector: '.testimonials-section', name: 'Team Testimonials' },
                    { selector: '.application-form', name: 'Application Form' }
                ];

                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const sectionName = entry.target.dataset.sectionName;
                            this.trackEvent('section_view', 'Content', sectionName);
                        }
                    });
                }, { threshold: 0.5 });

                sections.forEach(({ selector, name }) => {
                    const element = document.querySelector(selector);
                    if (element) {
                        element.dataset.sectionName = name;
                        observer.observe(element);
                    }
                });
            }

            // Form interaction tracking
            setupFormTracking() {
                // Track form step progression
                const originalGoToStep = window.goToStep;
                if (originalGoToStep) {
                    window.goToStep = (stepNumber) => {
                        this.trackEvent('form_step', 'Application', `Step ${stepNumber}`);
                        originalGoToStep(stepNumber);
                    };
                }

                // Track form field interactions
                document.querySelectorAll('.form-control').forEach(field => {
                    let focused = false;
                    let interacted = false;

                    field.addEventListener('focus', () => {
                        if (!focused) {
                            focused = true;
                            this.trackEvent('form_field_focus', 'Application', field.name || field.id);
                        }
                    });

                    field.addEventListener('input', () => {
                        if (!interacted) {
                            interacted = true;
                            this.trackEvent('form_field_interaction', 'Application', field.name || field.id);
                        }
                    });

                    field.addEventListener('blur', () => {
                        if (field.value.trim()) {
                            this.trackEvent('form_field_completed', 'Application', field.name || field.id);
                        }
                    });
                });

                // Track file uploads
                document.querySelectorAll('input[type="file"]').forEach(input => {
                    input.addEventListener('change', (e) => {
                        const files = e.target.files;
                        if (files.length > 0) {
                            this.trackEvent('file_upload', 'Application', input.id, files.length);
                            
                            // Track file types
                            Array.from(files).forEach(file => {
                                const extension = file.name.split('.').pop().toLowerCase();
                                this.trackEvent('file_type', 'Application', extension);
                            });
                        }
                    });
                });

                // Track form submission attempts
                document.querySelectorAll('form').forEach(form => {
                    form.addEventListener('submit', (e) => {
                        this.trackEvent('form_submit_attempt', 'Application', 'Career Application');
                    });
                });
            }

            // Job listing interaction tracking
            setupJobListingTracking() {
                // Track filter usage
                document.querySelectorAll('.filter-btn').forEach(btn => {
                    btn.addEventListener('click', () => {
                        const filterType = btn.textContent.trim();
                        this.trackEvent('filter_click', 'Job Search', filterType);
                    });
                });

                // Track search usage
                const searchInput = document.getElementById('jobSearch');
                if (searchInput) {
                    let searchTimeout;
                    searchInput.addEventListener('input', () => {
                        clearTimeout(searchTimeout);
                        searchTimeout = setTimeout(() => {
                            if (searchInput.value.trim()) {
                                this.trackEvent('search_query', 'Job Search', searchInput.value.length > 0 ? 'Search Used' : 'Search Cleared');
                            }
                        }, 500);
                    });
                }

                // Track job card clicks
                document.querySelectorAll('.opportunity-card').forEach(card => {
                    card.addEventListener('click', () => {
                        const jobTitle = card.querySelector('h3')?.textContent || 'Unknown Position';
                        this.trackEvent('job_card_click', 'Job Interest', jobTitle);
                    });
                });

                // Track apply button clicks
                document.querySelectorAll('.apply-btn').forEach(btn => {
                    btn.addEventListener('click', () => {
                        const jobTitle = btn.closest('.opportunity-card')?.querySelector('h3')?.textContent || 'Unknown Position';
                        this.trackEvent('apply_button_click', 'Job Interest', jobTitle);
                    });
                });
            }

            // Modal interaction tracking
            setupModalTracking() {
                document.querySelectorAll('.modal').forEach(modal => {
                    modal.addEventListener('show.bs.modal', () => {
                        const modalTitle = modal.querySelector('.modal-title')?.textContent || 'Unknown Modal';
                        this.trackEvent('modal_open', 'Job Details', modalTitle);
                    });

                    modal.addEventListener('hide.bs.modal', () => {
                        const modalTitle = modal.querySelector('.modal-title')?.textContent || 'Unknown Modal';
                        this.trackEvent('modal_close', 'Job Details', modalTitle);
                    });
                });

                // Track modal apply buttons
                document.querySelectorAll('.modal .btn-primary').forEach(btn => {
                    if (btn.textContent.includes('Apply')) {
                        btn.addEventListener('click', () => {
                            const modalTitle = btn.closest('.modal')?.querySelector('.modal-title')?.textContent || 'Unknown Position';
                            this.trackEvent('modal_apply_click', 'Job Interest', modalTitle);
                        });
                    }
                });
            }

            // Error tracking
            setupErrorTracking() {
                // Track JavaScript errors
                window.addEventListener('error', (event) => {
                    this.trackEvent('javascript_error', 'Error', event.message || 'Unknown Error');
                });

                // Track form validation errors
                const originalShowFormError = window.errorHandler?.showFormError;
                if (originalShowFormError) {
                    window.errorHandler.showFormError = (fieldId, message) => {
                        this.trackEvent('form_validation_error', 'Application', `${fieldId}: ${message}`);
                        originalShowFormError.call(window.errorHandler, fieldId, message);
                    };
                }

                // Track file upload errors
                const originalHandleFileUploadError = window.errorHandler?.handleFileUploadError;
                if (originalHandleFileUploadError) {
                    window.errorHandler.handleFileUploadError = (error, fileUploadArea) => {
                        this.trackEvent('file_upload_error', 'Application', error.message || 'Upload Failed');
                        originalHandleFileUploadError.call(window.errorHandler, error, fileUploadArea);
                    };
                }
            }

            // Performance tracking
            setupPerformanceTracking() {
                // Track Core Web Vitals
                if ('web-vital' in window) {
                    import('https://unpkg.com/web-vitals@3/dist/web-vitals.js').then(({ getCLS, getFID, getFCP, getLCP, getTTFB }) => {
                        getCLS((metric) => this.trackEvent('core_web_vital', 'Performance', 'CLS', Math.round(metric.value * 1000)));
                        getFID((metric) => this.trackEvent('core_web_vital', 'Performance', 'FID', Math.round(metric.value)));
                        getFCP((metric) => this.trackEvent('core_web_vital', 'Performance', 'FCP', Math.round(metric.value)));
                        getLCP((metric) => this.trackEvent('core_web_vital', 'Performance', 'LCP', Math.round(metric.value)));
                        getTTFB((metric) => this.trackEvent('core_web_vital', 'Performance', 'TTFB', Math.round(metric.value)));
                    }).catch(err => console.warn('Web Vitals not available:', err));
                }

                // Track animation performance
                let frameCount = 0;
                let lastTime = performance.now();
                
                const measureFPS = (currentTime) => {
                    frameCount++;
                    if (currentTime - lastTime >= 1000) {
                        const fps = Math.round((frameCount * 1000) / (currentTime - lastTime));
                        if (fps < 30) {
                            this.trackEvent('performance_issue', 'Performance', 'Low FPS', fps);
                        }
                        frameCount = 0;
                        lastTime = currentTime;
                    }
                    requestAnimationFrame(measureFPS);
                };
                
                // Only measure FPS if animations are enabled
                if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                    requestAnimationFrame(measureFPS);
                }
            }

            // Conversion tracking for successful applications
            trackConversion(applicationRef) {
                this.trackEvent('application_success', 'Conversion', 'Application Submitted', 1);
                this.trackEvent('conversion', 'Goal', 'Career Application Complete', 1);
                
                // Track application reference for follow-up analysis
                if (applicationRef) {
                    this.trackEvent('application_reference', 'Conversion', applicationRef);
                }

                // Calculate and track completion time
                const completionTime = Date.now() - this.startTime;
                this.trackEvent('application_duration', 'Conversion', 'Time to Complete', Math.round(completionTime / 1000));
            }

            // Career-specific tracking methods
            trackJobInterest(jobTitle, action) {
                this.trackEvent(action, 'Job Interest', jobTitle);
                
                // Also track as enhanced ecommerce event
                if (typeof gtag !== 'undefined') {
                    gtag('event', 'select_item', {
                        item_list_id: 'job_opportunities',
                        item_list_name: 'Job Opportunities',
                        items: [{
                            item_id: jobTitle.toLowerCase().replace(/\s+/g, '_'),
                            item_name: jobTitle,
                            item_category: 'Job Opportunity',
                            item_list_position: Array.from(document.querySelectorAll('.opportunity-card')).findIndex(card => 
                                card.querySelector('h3')?.textContent === jobTitle) + 1
                        }]
                    });
                }
            }

            trackApplicationFunnel(step, stepName) {
                this.trackEvent('application_funnel', 'Application', `${step}: ${stepName}`);
                
                // Track as enhanced ecommerce checkout progress
                if (typeof gtag !== 'undefined') {
                    gtag('event', 'checkout_progress', {
                        checkout_step: step,
                        checkout_option: stepName,
                        items: [{
                            item_id: 'career_application',
                            item_name: 'Job Application Process',
                            item_category: 'Recruitment',
                            quantity: 1,
                            price: 0
                        }]
                    });
                }
            }

            trackEngagementQuality() {
                const timeOnPage = Date.now() - this.startTime;
                const engagementScore = this.calculateEngagementScore(timeOnPage, this.maxScrollDepth);
                
                this.trackEvent('engagement_quality', 'Engagement', 'Quality Score', engagementScore);
                
                // Set custom dimension for engagement level
                if (typeof gtag !== 'undefined') {
                    gtag('config', 'GA_MEASUREMENT_ID', {
                        dimension5: engagementScore > 70 ? 'High' : engagementScore > 40 ? 'Medium' : 'Low'
                    });
                }
            }

            calculateEngagementScore(timeOnPage, scrollDepth) {
                let score = 0;
                
                // Time component (0-40 points)
                const timeMinutes = timeOnPage / (1000 * 60);
                if (timeMinutes > 5) score += 40;
                else if (timeMinutes > 2) score += 30;
                else if (timeMinutes > 1) score += 20;
                else if (timeMinutes > 0.5) score += 10;
                
                // Scroll depth component (0-30 points)
                if (scrollDepth > 80) score += 30;
                else if (scrollDepth > 60) score += 25;
                else if (scrollDepth > 40) score += 20;
                else if (scrollDepth > 20) score += 10;
                
                // Interaction component (0-30 points)
                const localEvents = JSON.parse(localStorage.getItem('careers_analytics') || '[]');
                const interactionEvents = localEvents.filter(event => 
                    ['form_field_interaction', 'job_card_click', 'modal_open', 'filter_click'].includes(event.action)
                ).length;
                
                if (interactionEvents > 10) score += 30;
                else if (interactionEvents > 5) score += 25;
                else if (interactionEvents > 2) score += 15;
                else if (interactionEvents > 0) score += 10;
                
                return Math.min(score, 100);
            }

            // Get analytics summary for debugging
            getAnalyticsSummary() {
                return {
                    sessionId: this.sessionId,
                    timeOnPage: Date.now() - this.startTime,
                    maxScrollDepth: this.maxScrollDepth,
                    eventsTracked: this.eventQueue.length,
                    localEvents: JSON.parse(localStorage.getItem('careers_analytics') || '[]').length,
                    engagementScore: this.calculateEngagementScore(Date.now() - this.startTime, this.maxScrollDepth)
                };
            }

            // Export analytics data for analysis
            exportAnalyticsData() {
                const data = {
                    summary: this.getAnalyticsSummary(),
                    events: JSON.parse(localStorage.getItem('careers_analytics') || '[]'),
                    session: {
                        id: this.sessionId,
                        startTime: this.startTime,
                        url: window.location.href,
                        referrer: document.referrer,
                        userAgent: navigator.userAgent,
                        screenResolution: `${screen.width}x${screen.height}`,
                        viewportSize: `${window.innerWidth}x${window.innerHeight}`
                    }
                };
                
                // Create downloadable JSON file
                const blob = new Blob([JSON.stringify(data, null, 2)], { type: 'application/json' });
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = `careers_analytics_${this.sessionId}.json`;
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                URL.revokeObjectURL(url);
                
                return data;
            }
        }

        // Initialize analytics with error handling
        let analyticsTracker;
        document.addEventListener('DOMContentLoaded', () => {
            try {
                analyticsTracker = new AnalyticsTracker();
                
                // Initialize analytics debug panel (hidden by default)
                createAnalyticsDebugPanel();
            } catch (error) {
                console.error('Analytics initialization error:', error);
                // Create a fallback analytics object to prevent other errors
                analyticsTracker = {
                    trackPageView: () => {},
                    trackEvent: () => {},
                    trackFormSubmission: () => {},
                    trackJobInterest: () => {},
                    trackApplicationStart: () => {},
                    trackApplicationComplete: () => {},
                    trackApplicationFunnel: () => {},
                    trackError: () => {},
                    trackPerformanceMetric: () => {},
                    trackConversion: () => {},
                    trackScroll: () => {},
                    trackFormInteraction: () => {},
                    trackFileUpload: () => {},
                    trackModalView: () => {},
                    trackButtonClick: () => {},
                    trackSearchUsage: () => {},
                    trackFilterUsage: () => {},
                    trackEngagementQuality: () => {},
                    trackReadingProgress: () => {},
                    cleanupExpiredEvents: () => {},
                    exportData: () => ({}),
                    getSessionSummary: () => ({
                        sessionId: 'fallback-session',
                        timeOnPage: 0,
                        maxScrollDepth: 0,
                        localEvents: 0,
                        engagementScore: 0
                    })
                };
            }
        });

        // Analytics Debug Panel (for development and testing)
        function createAnalyticsDebugPanel() {
            // Only show in development (when URL contains localhost or specific params)
            const isDevelopment = window.location.hostname === 'localhost' || 
                                 window.location.search.includes('debug=analytics') ||
                                 window.location.hash.includes('debug');
            
            if (!isDevelopment) return;

            const debugPanel = document.createElement('div');
            debugPanel.id = 'analytics-debug-panel';
            debugPanel.innerHTML = `
                <div style="position: fixed; bottom: 20px; left: 20px; z-index: 10000; background: rgba(0,0,0,0.9); color: white; padding: 15px; border-radius: 8px; font-family: monospace; font-size: 12px; max-width: 300px; min-width: 250px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                        <strong>Analytics Debug</strong>
                        <button id="toggle-analytics-debug" style="background: #FF4900; color: white; border: none; padding: 2px 6px; border-radius: 3px; font-size: 10px;">Hide</button>
                    </div>
                    <div id="analytics-stats">
                        <div>Session: <span id="debug-session">-</span></div>
                        <div>Time: <span id="debug-time">0s</span></div>
                        <div>Scroll: <span id="debug-scroll">0%</span></div>
                        <div>Events: <span id="debug-events">0</span></div>
                        <div>Engagement: <span id="debug-engagement">0%</span></div>
                    </div>
                    <div style="margin-top: 10px; display: flex; gap: 5px;">
                        <button id="export-analytics" style="background: #28a745; color: white; border: none; padding: 4px 8px; border-radius: 3px; font-size: 10px;">Export</button>
                        <button id="clear-analytics" style="background: #dc3545; color: white; border: none; padding: 4px 8px; border-radius: 3px; font-size: 10px;">Clear</button>
                    </div>
                </div>
            `;
            
            document.body.appendChild(debugPanel);

            // Update debug panel every second
            const updateDebugPanel = () => {
                if (analyticsTracker) {
                    const summary = analyticsTracker.getAnalyticsSummary();
                    document.getElementById('debug-session').textContent = summary.sessionId.slice(-8);
                    document.getElementById('debug-time').textContent = Math.round(summary.timeOnPage / 1000) + 's';
                    document.getElementById('debug-scroll').textContent = summary.maxScrollDepth + '%';
                    document.getElementById('debug-events').textContent = summary.localEvents;
                    document.getElementById('debug-engagement').textContent = summary.engagementScore + '%';
                }
            };

            setInterval(updateDebugPanel, 1000);

            // Debug panel controls
            document.getElementById('toggle-analytics-debug').addEventListener('click', () => {
                const panel = document.getElementById('analytics-debug-panel');
                const isVisible = panel.style.display !== 'none';
                panel.style.display = isVisible ? 'none' : 'block';
                document.getElementById('toggle-analytics-debug').textContent = isVisible ? 'Show' : 'Hide';
            });

            document.getElementById('export-analytics').addEventListener('click', () => {
                if (analyticsTracker) {
                    analyticsTracker.exportAnalyticsData();
                }
            });

            document.getElementById('clear-analytics').addEventListener('click', () => {
                localStorage.removeItem('careers_analytics');
                console.log('Analytics data cleared');
            });

            console.log('Analytics Debug Panel initialized. Add ?debug=analytics to URL to show panel.');
        }

        // Error Handling System
        class ErrorHandler {
            constructor() {
                this.errorContainer = this.createErrorContainer();
                this.bindGlobalErrorHandlers();
            }

            createErrorContainer() {
                const container = document.createElement('div');
                container.id = 'global-error-container';
                container.className = 'fixed-top';
                container.style.cssText = `
                    z-index: 9999;
                    padding: 20px;
                    pointer-events: none;
                `;
                document.body.appendChild(container);
                return container;
            }

            bindGlobalErrorHandlers() {
                // Handle JavaScript errors
                window.addEventListener('error', (event) => {
                    console.error('Global error:', event.error);
                    this.showError('An unexpected error occurred. Please refresh the page and try again.', 'error');
                });

                // Handle promise rejections
                window.addEventListener('unhandledrejection', (event) => {
                    console.error('Unhandled promise rejection:', event.reason);
                    this.showError('Something went wrong. Please try again.', 'error');
                });

                // Handle network errors for fetch requests
                this.interceptFetch();
            }

            interceptFetch() {
                const originalFetch = window.fetch;
                window.fetch = async (...args) => {
                    try {
                        const response = await originalFetch(...args);
                        if (!response.ok) {
                            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                        }
                        return response;
                    } catch (error) {
                        if (error.name === 'TypeError' && error.message.includes('fetch')) {
                            this.showError('Network connection error. Please check your internet connection.', 'error');
                        } else {
                            this.showError('Server error. Please try again later.', 'error');
                        }
                        throw error;
                    }
                };
            }

            showError(message, type = 'error', duration = 5000) {
                const alert = document.createElement('div');
                alert.className = `alert alert-${type === 'error' ? 'danger' : type} alert-dismissible fade show`;
                alert.setAttribute('role', 'alert');
                alert.innerHTML = `
                    <div class="d-flex align-items-center">
                        <i class="fas fa-${this.getIcon(type)} me-2"></i>
                        <div class="flex-grow-1">${message}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `;
                
                alert.style.cssText = `
                    pointer-events: all;
                    margin-bottom: 10px;
                    border-radius: 8px;
                    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                `;

                this.errorContainer.appendChild(alert);

                // Auto-dismiss after duration
                if (duration > 0) {
                    setTimeout(() => {
                        if (alert.parentNode) {
                            alert.classList.remove('show');
                            setTimeout(() => {
                                if (alert.parentNode) {
                                    alert.remove();
                                }
                            }, 150);
                        }
                    }, duration);
                }

                // Announce to screen readers
                announceToScreenReader(`${type}: ${message}`);
            }

            getIcon(type) {
                const icons = {
                    error: 'exclamation-triangle',
                    warning: 'exclamation-circle',
                    success: 'check-circle',
                    info: 'info-circle'
                };
                return icons[type] || 'exclamation-triangle';
            }

            showFormError(fieldId, message) {
                const field = document.getElementById(fieldId);
                if (!field) return;

                field.classList.add('is-invalid');
                field.setAttribute('aria-invalid', 'true');

                let feedback = field.parentNode.querySelector('.invalid-feedback');
                if (!feedback) {
                    feedback = document.createElement('div');
                    feedback.className = 'invalid-feedback';
                    field.parentNode.appendChild(feedback);
                }
                feedback.textContent = message;
                feedback.style.display = 'block';

                // Focus on the field
                field.focus();
            }

            clearFieldError(fieldId) {
                const field = document.getElementById(fieldId);
                if (!field) return;

                field.classList.remove('is-invalid');
                field.setAttribute('aria-invalid', 'false');

                const feedback = field.parentNode.querySelector('.invalid-feedback');
                if (feedback) {
                    feedback.style.display = 'none';
                }
            }

            handleFileUploadError(error, fileUploadArea) {
                let message = 'File upload failed. Please try again.';
                
                if (error.message.includes('size')) {
                    message = 'File is too large. Maximum size is 5MB.';
                } else if (error.message.includes('type')) {
                    message = 'File type not supported. Please use PDF, DOC, DOCX, JPG, or PNG.';
                } else if (error.message.includes('network')) {
                    message = 'Network error during upload. Please check your connection.';
                }

                this.showError(message, 'error');
                
                if (fileUploadArea) {
                    fileUploadArea.classList.add('upload-error');
                    fileUploadArea.setAttribute('aria-invalid', 'true');
                    
                    setTimeout(() => {
                        fileUploadArea.classList.remove('upload-error');
                        fileUploadArea.setAttribute('aria-invalid', 'false');
                    }, 3000);
                }
            }
        }

        // Initialize error handler
        const errorHandler = new ErrorHandler();

        // Form Validation Enhancement
        function validateEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }

        function validatePhone(phone) {
            const phoneRegex = /^[\+]?[1-9][\d]{0,15}$/;
            return phoneRegex.test(phone.replace(/[\s\-\(\)]/g, ''));
        }

        function validateUrl(url) {
            try {
                new URL(url);
                return true;
            } catch {
                return false;
            }
        }

        function validateFileSize(file, maxSizeMB = 5) {
            return file.size <= maxSizeMB * 1024 * 1024;
        }

        function validateFileType(file, allowedTypes = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png']) {
            const extension = file.name.split('.').pop().toLowerCase();
            return allowedTypes.includes(extension);
        }

        // Enhanced form validation with error handling
        function validateFormField(field) {
            const value = field.value.trim();
            const fieldId = field.id;
            const fieldType = field.type;
            const isRequired = field.hasAttribute('required');

            // Clear previous errors
            errorHandler.clearFieldError(fieldId);

            // Required field validation
            if (isRequired && !value) {
                errorHandler.showFormError(fieldId, `${field.labels[0]?.textContent || 'This field'} is required.`);
                return false;
            }

            // Type-specific validation
            if (value) {
                switch (fieldType) {
                    case 'email':
                        if (!validateEmail(value)) {
                            errorHandler.showFormError(fieldId, 'Please enter a valid email address.');
                            return false;
                        }
                        break;
                    case 'tel':
                        if (!validatePhone(value)) {
                            errorHandler.showFormError(fieldId, 'Please enter a valid phone number.');
                            return false;
                        }
                        break;
                    case 'url':
                        if (!validateUrl(value)) {
                            errorHandler.showFormError(fieldId, 'Please enter a valid URL.');
                            return false;
                        }
                        break;
                }
            }

            return true;
        }

        // Network retry mechanism
        async function retryOperation(operation, maxRetries = 3, delay = 1000) {
            for (let i = 0; i < maxRetries; i++) {
                try {
                    return await operation();
                } catch (error) {
                    if (i === maxRetries - 1) throw error;
                    await new Promise(resolve => setTimeout(resolve, delay * Math.pow(2, i)));
                }
            }
        }

        // Graceful degradation for JavaScript disabled users
        function enhanceFormForNoJS() {
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                // Add server-side fallback action if JS fails
                if (!form.action) {
                    form.action = '/opportunities/apply';
                    form.method = 'post';
                }
                
                // Add noscript fallback for multi-step forms
                const noscriptFallback = document.createElement('noscript');
                noscriptFallback.innerHTML = `
                    <div class="alert alert-info">
                        <strong>JavaScript Required:</strong> 
                        For the best experience, please enable JavaScript. 
                        Alternatively, you can email your application to careers@manifestghana.com
                    </div>
                `;
                form.parentNode.insertBefore(noscriptFallback, form);
            });
        }

            // Initialize error handling enhancements
            document.addEventListener('DOMContentLoaded', function() {
                enhanceFormForNoJS();
                
                // Add real-time validation to all form fields
                const formFields = document.querySelectorAll('input, textarea, select');
                formFields.forEach(field => {
                    field.addEventListener('blur', () => validateFormField(field));
                    field.addEventListener('input', () => {
                        if (field.classList.contains('is-invalid')) {
                            validateFormField(field);
                        }
                    });
                });
            });

        // Accessibility helper functions
        function announceToScreenReader(message) {
            const announcement = document.createElement('div');
            announcement.setAttribute('aria-live', 'polite');
            announcement.setAttribute('aria-atomic', 'true');
            announcement.className = 'sr-only';
            announcement.textContent = message;
            document.body.appendChild(announcement);
            
            setTimeout(() => {
                document.body.removeChild(announcement);
            }, 1000);
        }
        
        function updateProgressStep(stepNumber, isCompleted = false, isCurrent = false) {
            const progressSteps = document.querySelectorAll('.career-progress-step');
            const progressBar = document.querySelector('.career-application-progress');
            
            progressSteps.forEach((step, index) => {
                const stepNum = index + 1;
                
                if (stepNum < stepNumber) {
                    step.setAttribute('aria-completed', 'true');
                    step.setAttribute('aria-current', 'false');
                } else if (stepNum === stepNumber) {
                    step.setAttribute('aria-current', isCurrent ? 'step' : 'false');
                    step.setAttribute('aria-completed', isCompleted ? 'true' : 'false');
                } else {
                    step.setAttribute('aria-current', 'false');
                    step.setAttribute('aria-completed', 'false');
                }
            });
            
            // Update progress bar value
            if (progressBar) {
                progressBar.setAttribute('aria-valuenow', stepNumber);
            }
        }
        
        function validateFormStep(stepNumber) {
            const currentStep = document.querySelector(`.career-form-step[data-step="${stepNumber}"]`);
            if (!currentStep) return true;
            
            const requiredFields = currentStep.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('is-invalid');
                    field.setAttribute('aria-invalid', 'true');
                    isValid = false;
                } else {
                    field.classList.remove('is-invalid');
                    field.setAttribute('aria-invalid', 'false');
                }
            });
            
            return isValid;
        }

        // Opportunities filtering and search functionality
        document.addEventListener('DOMContentLoaded', function() {
            const filterButtons = document.querySelectorAll('.opportunities-listing .filter-btn');
            const searchInput = document.getElementById('opportunitySearch');
            const opportunityCards = document.querySelectorAll('.opportunity-card');
            const noResultsMessage = document.getElementById('noResultsMessage');

            // Filter functionality with accessibility
            filterButtons.forEach((button, index) => {
                button.addEventListener('click', function() {
                    // Update active button and ARIA states
                    filterButtons.forEach(btn => {
                        btn.classList.remove('active');
                        btn.setAttribute('aria-pressed', 'false');
                        btn.tabIndex = -1;
                    });
                    this.classList.add('active');
                    this.setAttribute('aria-pressed', 'true');
                    this.tabIndex = 0;
                    
                    const filterValue = this.dataset.filter;
                    filterOpportunities(filterValue, searchInput.value);
                    
                    // Announce filter change to screen readers
                    announceToScreenReader(`Showing ${filterValue === 'all' ? 'all' : filterValue} opportunities`);
                });
                
                // Keyboard navigation for filter buttons
                button.addEventListener('keydown', function(e) {
                    let targetIndex = index;
                    
                    switch(e.key) {
                        case 'ArrowRight':
                        case 'ArrowDown':
                            e.preventDefault();
                            targetIndex = (index + 1) % filterButtons.length;
                            break;
                        case 'ArrowLeft':
                        case 'ArrowUp':
                            e.preventDefault();
                            targetIndex = (index - 1 + filterButtons.length) % filterButtons.length;
                            break;
                        case 'Home':
                            e.preventDefault();
                            targetIndex = 0;
                            break;
                        case 'End':
                            e.preventDefault();
                            targetIndex = filterButtons.length - 1;
                            break;
                        case 'Enter':
                        case ' ':
                            e.preventDefault();
                            button.click();
                            return;
                    }
                    
                    if (targetIndex !== index) {
                        filterButtons[targetIndex].focus();
                        filterButtons[targetIndex].tabIndex = 0;
                        button.tabIndex = -1;
                    }
                });
            });

            // Search functionality
            searchInput.addEventListener('input', function() {
                const activeFilter = document.querySelector('.opportunities-listing .filter-btn.active').dataset.filter;
                filterOpportunities(activeFilter, this.value);
            });

            function filterOpportunities(category, searchTerm) {
                let visibleCount = 0;
                const searchTermLower = searchTerm.toLowerCase();

                opportunityCards.forEach(card => {
                    const cardCategory = card.dataset.category;
                    const cardTitle = card.querySelector('.card-title').textContent.toLowerCase();
                    const cardDescription = card.querySelector('.card-text').textContent.toLowerCase();
                    const cardSkills = Array.from(card.querySelectorAll('.badge')).map(badge => badge.textContent.toLowerCase());
                    
                    const matchesCategory = category === 'all' || cardCategory === category;
                    const matchesSearch = searchTerm === '' || 
                                        cardTitle.includes(searchTermLower) || 
                                        cardDescription.includes(searchTermLower) ||
                                        cardSkills.some(skill => skill.includes(searchTermLower));

                    if (matchesCategory && matchesSearch) {
                        card.style.display = 'block';
                        visibleCount++;
                        
                        // Add entrance animation
                        card.style.opacity = '0';
                        card.style.transform = 'translateY(20px)';
                        setTimeout(() => {
                            card.style.transition = 'all 0.3s ease';
                            card.style.opacity = '1';
                            card.style.transform = 'translateY(0)';
                        }, 50);
                    } else {
                        card.style.display = 'none';
                    }
                });

                // Show/hide no results message
                noResultsMessage.style.display = visibleCount === 0 ? 'block' : 'none';
            }
        });

        // Comprehensive opportunity data structure
        const opportunityData = {
            'senior-fullstack-dev': {
                title: 'Senior Full-Stack Developer',
                type: 'Full-Time',
                department: 'Development',
                location: 'Remote / Lagos, Nigeria',
                schedule: 'Full-Time, 40 hours/week',
                experience: 'Senior Level (3+ years)',
                posted: 'Posted 3 days ago',
                description: 'We are seeking a talented Senior Full-Stack Developer to join our growing development team. You\'ll work on cutting-edge web applications, lead technical initiatives, and mentor junior developers while building scalable solutions for our diverse client portfolio.',
                responsibilities: [
                    'Develop and maintain full-stack web applications using modern technologies',
                    'Lead technical architecture decisions and code reviews',
                    'Mentor junior developers and promote best practices',
                    'Collaborate with design and product teams to deliver exceptional user experiences',
                    'Optimize application performance and ensure scalability',
                    'Participate in agile development processes and sprint planning'
                ],
                requirements: [
                    'Bachelor\'s degree in Computer Science or equivalent experience',
                    '3+ years of experience in full-stack web development',
                    'Proficient in React, Node.js, and modern JavaScript/TypeScript',
                    'Experience with Laravel, PHP, and database design (MySQL, PostgreSQL)',
                    'Strong understanding of RESTful APIs and microservices architecture',
                    'Experience with version control (Git) and CI/CD pipelines',
                    'Excellent problem-solving and communication skills'
                ],
                skills: ['React', 'Node.js', 'Laravel', 'MySQL', 'TypeScript', 'Git', 'Docker', 'AWS']
            },
            'senior-ui-ux-designer': {
                title: 'Senior UI/UX Designer',
                type: 'Full-Time',
                department: 'Design',
                location: 'Remote / Lagos, Nigeria',
                schedule: 'Full-Time, 40 hours/week',
                experience: 'Senior Level (3+ years)',
                posted: 'Posted 1 week ago',
                description: 'Join our design team as a Senior UI/UX Designer and help create beautiful, intuitive user experiences. You\'ll work on diverse projects ranging from web applications to mobile apps, conducting user research and creating design systems that delight our clients and their users.',
                responsibilities: [
                    'Design user interfaces and experiences for web and mobile applications',
                    'Conduct user research and usability testing to inform design decisions',
                    'Create wireframes, prototypes, and high-fidelity mockups',
                    'Develop and maintain design systems and style guides',
                    'Collaborate with developers to ensure accurate implementation',
                    'Present design concepts to clients and stakeholders'
                ],
                requirements: [
                    'Bachelor\'s degree in Design, HCI, or related field',
                    '3+ years of experience in UI/UX design',
                    'Proficiency in Figma, Adobe XD, and design tools',
                    'Strong understanding of user-centered design principles',
                    'Experience with user research and usability testing',
                    'Knowledge of responsive design and accessibility standards',
                    'Excellent communication and presentation skills'
                ],
                skills: ['Figma', 'Adobe XD', 'Prototyping', 'User Research', 'Wireframing', 'Design Systems', 'Sketch', 'InVision']
            },
            'digital-marketing-intern': {
                title: 'Digital Marketing Intern',
                type: 'Internship',
                department: 'Marketing',
                location: 'Remote / Lagos, Nigeria',
                schedule: 'Part-Time, 20 hours/week',
                experience: 'Entry Level (0-1 years)',
                posted: 'Posted 5 days ago',
                description: 'Perfect opportunity for students or recent graduates to gain hands-on experience in digital marketing. You\'ll work on real client campaigns, learn industry best practices, and contribute to our marketing initiatives while developing your skills in a supportive environment.',
                responsibilities: [
                    'Assist in creating and managing social media content',
                    'Support email marketing campaigns and automation',
                    'Help with SEO research and content optimization',
                    'Analyze marketing metrics and prepare reports',
                    'Assist in content creation for blogs and marketing materials',
                    'Support paid advertising campaigns on various platforms'
                ],
                requirements: [
                    'Currently pursuing or recently completed degree in Marketing, Communications, or related field',
                    'Basic understanding of digital marketing concepts',
                    'Familiarity with social media platforms and trends',
                    'Strong written communication skills',
                    'Analytical mindset with attention to detail',
                    'Eagerness to learn and adapt in a fast-paced environment'
                ],
                skills: ['Social Media', 'Content Creation', 'Analytics', 'SEO', 'Email Marketing', 'Canva', 'Google Analytics', 'Facebook Ads']
            },
            'business-development-manager': {
                title: 'Business Development Manager',
                type: 'Full-Time',
                department: 'Business',
                location: 'Lagos, Nigeria',
                schedule: 'Full-Time, 40 hours/week',
                experience: 'Mid-Senior Level (2-5 years)',
                posted: 'Posted 2 weeks ago',
                description: 'Drive business growth as our Business Development Manager. You\'ll identify new opportunities, build strategic partnerships, and expand our client base while working closely with our leadership team to achieve revenue targets and market expansion goals.',
                responsibilities: [
                    'Identify and pursue new business opportunities and partnerships',
                    'Develop and maintain relationships with key clients and stakeholders',
                    'Prepare proposals, presentations, and contract negotiations',
                    'Collaborate with internal teams to ensure client satisfaction',
                    'Analyze market trends and competitive landscape',
                    'Achieve sales targets and contribute to revenue growth'
                ],
                requirements: [
                    'Bachelor\'s degree in Business, Marketing, or related field',
                    '2-5 years of experience in business development or sales',
                    'Proven track record of meeting sales targets',
                    'Strong networking and relationship-building skills',
                    'Excellent presentation and negotiation abilities',
                    'Experience with CRM systems and sales processes',
                    'Understanding of digital services and technology industry'
                ],
                skills: ['Sales', 'Partnerships', 'Strategy', 'CRM', 'Negotiation', 'Presentations', 'Lead Generation', 'Account Management']
            },
            'frontend-development-intern': {
                title: 'Frontend Development Intern',
                type: 'Internship',
                department: 'Development',
                location: 'Remote / Lagos, Nigeria',
                schedule: 'Part-Time, 25 hours/week',
                experience: 'Entry Level (0-1 years)',
                posted: 'Posted 1 week ago',
                description: 'Great opportunity for computer science students or bootcamp graduates to gain real-world frontend development experience. You\'ll work on live projects, learn modern development practices, and be mentored by our senior developers.',
                responsibilities: [
                    'Develop responsive web interfaces using HTML, CSS, and JavaScript',
                    'Work with React and modern frontend frameworks',
                    'Collaborate with designers to implement pixel-perfect designs',
                    'Write clean, maintainable, and well-documented code',
                    'Participate in code reviews and team meetings',
                    'Learn and apply best practices in frontend development'
                ],
                requirements: [
                    'Currently pursuing degree in Computer Science or completed coding bootcamp',
                    'Basic knowledge of HTML, CSS, and JavaScript',
                    'Familiarity with React or willingness to learn quickly',
                    'Understanding of responsive design principles',
                    'Experience with Git version control',
                    'Strong problem-solving skills and attention to detail'
                ],
                skills: ['HTML/CSS', 'JavaScript', 'React', 'Git', 'Responsive Design', 'Bootstrap', 'Figma', 'VS Code']
            },
            'creative-graphic-designer': {
                title: 'Creative Graphic Designer',
                type: 'Full-Time',
                department: 'Design',
                location: 'Remote / Lagos, Nigeria',
                schedule: 'Full-Time, 40 hours/week',
                experience: 'Mid Level (2-4 years)',
                posted: 'Posted 4 days ago',
                description: 'We\'re looking for a creative Graphic Designer to join our team and create compelling visual content across digital and print media. You\'ll work on diverse projects including brand identity, marketing materials, and web graphics for our varied client portfolio.',
                responsibilities: [
                    'Create visual designs for digital and print marketing materials',
                    'Develop brand identity elements and maintain brand consistency',
                    'Design web graphics, social media content, and promotional materials',
                    'Collaborate with marketing and development teams on projects',
                    'Prepare files for print production and digital distribution',
                    'Stay updated with design trends and industry best practices'
                ],
                requirements: [
                    'Bachelor\'s degree in Graphic Design or related field',
                    '2-4 years of professional graphic design experience',
                    'Proficiency in Adobe Creative Suite (Photoshop, Illustrator, InDesign)',
                    'Strong understanding of typography, color theory, and composition',
                    'Experience with print production and digital design',
                    'Portfolio demonstrating creative and technical skills',
                    'Ability to work under tight deadlines and manage multiple projects'
                ],
                skills: ['Photoshop', 'Illustrator', 'Branding', 'Typography', 'InDesign', 'Print Design', 'Logo Design', 'Layout Design']
            }
        };

        // Opportunity modal functionality
        function openOpportunityModal(opportunityId) {
            const opportunity = opportunityData[opportunityId];
            if (!opportunity) return;

            // Populate modal content
            document.getElementById('opportunityModalLabel').textContent = opportunity.title;
            
            // Set badges
            const typeBadge = document.querySelector('.modal-type-badge');
            const departmentBadge = document.querySelector('.modal-department-badge');
            
            typeBadge.textContent = opportunity.type;
            typeBadge.className = 'badge modal-type-badge';
            if (opportunity.type === 'Internship') {
                typeBadge.style.background = 'linear-gradient(135deg, rgba(52,152,219,0.1) 0%, rgba(41,128,185,0.1) 100%)';
                typeBadge.style.color = '#3498db';
            } else {
                typeBadge.style.background = 'linear-gradient(135deg, rgba(255,73,0,0.1) 0%, rgba(255,107,53,0.1) 100%)';
                typeBadge.style.color = '#FF4900';
            }
            
            departmentBadge.textContent = opportunity.department;
            
            // Populate overview details
            document.querySelector('.modal-location').textContent = opportunity.location;
            document.querySelector('.modal-schedule').textContent = opportunity.schedule;
            document.querySelector('.modal-experience').textContent = opportunity.experience;
            document.querySelector('.modal-posted').textContent = opportunity.posted;
            
            // Populate description
            document.querySelector('.modal-description').textContent = opportunity.description;
            
            // Populate responsibilities
            const responsibilitiesList = document.querySelector('.modal-responsibilities');
            responsibilitiesList.innerHTML = '';
            opportunity.responsibilities.forEach(responsibility => {
                const li = document.createElement('li');
                li.textContent = responsibility;
                li.style.marginBottom = '8px';
                responsibilitiesList.appendChild(li);
            });
            
            // Populate requirements
            const requirementsList = document.querySelector('.modal-requirements');
            requirementsList.innerHTML = '';
            opportunity.requirements.forEach(requirement => {
                const li = document.createElement('li');
                li.textContent = requirement;
                li.style.marginBottom = '8px';
                requirementsList.appendChild(li);
            });
            
            // Populate skills
            const skillsContainer = document.querySelector('.modal-skills');
            skillsContainer.innerHTML = '';
            opportunity.skills.forEach(skill => {
                const badge = document.createElement('span');
                badge.className = 'badge';
                badge.textContent = skill;
                skillsContainer.appendChild(badge);
            });
            
            // Store opportunity ID for application process
            document.querySelector('[onclick="startApplication()"]').setAttribute('data-opportunity-id', opportunityId);
            
            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('opportunityModal'));
            modal.show();
        }

        // Application process
        function startApplication() {
            const opportunityId = document.querySelector('[onclick="startApplication()"]').getAttribute('data-opportunity-id');
            const opportunity = opportunityData[opportunityId];
            
            // Close the modal first
            const modal = bootstrap.Modal.getInstance(document.getElementById('opportunityModal'));
            modal.hide();
            
            // Pre-fill the position in the application form
            setTimeout(() => {
                document.getElementById('position').value = opportunityId;
                
                // Scroll to application form
                document.getElementById('apply').scrollIntoView({ 
                    behavior: 'smooth',
                    block: 'start'
                });
            }, 300);
        }

        // Multi-step form functionality
        document.addEventListener('DOMContentLoaded', function() {
            let currentStep = 1;
            const totalSteps = 4;
            
            const nextBtn = document.getElementById('nextBtn');
            const prevBtn = document.getElementById('prevBtn');
            const submitBtn = document.getElementById('submitBtn');
            const form = document.getElementById('applicationForm');

            // Form navigation
            nextBtn.addEventListener('click', function() {
                if (validateStep(currentStep)) {
                    if (currentStep < totalSteps) {
                        goToStep(currentStep + 1);
                    }
                }
            });

            prevBtn.addEventListener('click', function() {
                if (currentStep > 1) {
                    goToStep(currentStep - 1);
                }
            });

            function goToStep(step) {
                // Hide current step
                document.querySelector(`.career-form-step[data-step="${currentStep}"]`).classList.remove('active');
                document.querySelector(`.career-progress-step[data-step="${currentStep}"]`).classList.remove('active');
                
                // Mark current step as completed if moving forward
                if (step > currentStep) {
                    document.querySelector(`.career-progress-step[data-step="${currentStep}"]`).classList.add('completed');
                }
                
                currentStep = step;
                
                // Show new step
                document.querySelector(`.career-form-step[data-step="${currentStep}"]`).classList.add('active');
                document.querySelector(`.career-progress-step[data-step="${currentStep}"]`).classList.add('active');
                
                // Update navigation buttons
                prevBtn.style.display = currentStep === 1 ? 'none' : 'block';
                nextBtn.style.display = currentStep === totalSteps ? 'none' : 'block';
                submitBtn.style.display = currentStep === totalSteps ? 'block' : 'none';
                
                // Update summary on last step
                if (currentStep === totalSteps) {
                    updateSummary();
                }
                
                // Scroll to top of form
                document.querySelector('.application-form-content').scrollIntoView({ 
                    behavior: 'smooth',
                    block: 'start'
                });
            }

            function validateStep(step) {
                let isValid = true;
                const stepElement = document.querySelector(`.career-form-step[data-step="${step}"]`);
                const requiredFields = stepElement.querySelectorAll('[required]');
                
                requiredFields.forEach(field => {
                    if (!field.checkValidity()) {
                        field.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        field.classList.remove('is-invalid');
                        field.classList.add('is-valid');
                    }
                });
                
                // Special validation for file upload in step 3
                if (step === 3) {
                    const resumeFile = document.getElementById('resumeFile');
                    if (!resumeFile.files.length) {
                        document.getElementById('resumeUpload').classList.add('is-invalid');
                        isValid = false;
                    }
                }
                
                return isValid;
            }

            function updateSummary() {
                // Update summary values
                const firstName = document.getElementById('firstName').value;
                const lastName = document.getElementById('lastName').value;
                document.getElementById('summaryName').textContent = `${firstName} ${lastName}`;
                document.getElementById('summaryEmail').textContent = document.getElementById('email').value;
                
                const positionSelect = document.getElementById('position');
                const positionText = positionSelect.options[positionSelect.selectedIndex].text;
                document.getElementById('summaryPosition').textContent = positionText;
                
                const experienceSelect = document.getElementById('experience');
                const experienceText = experienceSelect.options[experienceSelect.selectedIndex].text;
                document.getElementById('summaryExperience').textContent = experienceText;
                
                const resumeFile = document.getElementById('resumeFile').files[0];
                document.getElementById('summaryResume').textContent = resumeFile ? resumeFile.name : 'No file uploaded';
            }

            // File upload functionality
            setupFileUpload('resumeUpload', 'resumeFile', false);
            setupFileUpload('additionalUpload', 'additionalFiles', true);

            function setupFileUpload(containerId, inputId, multiple = false) {
                const container = document.getElementById(containerId);
                const input = document.getElementById(inputId);
                const uploadContent = container.querySelector('.file-upload-content');
                
                // Click to browse
                uploadContent.addEventListener('click', () => input.click());
                
                // Drag and drop
                uploadContent.addEventListener('dragover', (e) => {
                    e.preventDefault();
                    container.classList.add('dragover');
                });
                
                uploadContent.addEventListener('dragleave', () => {
                    container.classList.remove('dragover');
                });
                
                uploadContent.addEventListener('drop', (e) => {
                    e.preventDefault();
                    container.classList.remove('dragover');
                    
                    const files = Array.from(e.dataTransfer.files);
                    handleFiles(files, input, container, multiple);
                });
                
                // File input change
                input.addEventListener('change', (e) => {
                    const files = Array.from(e.target.files);
                    handleFiles(files, input, container, multiple);
                });
            }

            // File validation helper functions
            function validateAndFilterFiles(files, container) {
                const validFiles = [];
                const errors = [];

                for (const file of files) {
                    try {
                        // Validate file type
                        if (!validateFileType(file)) {
                            errors.push(`${file.name}: Invalid file type. Please use PDF, DOC, DOCX, JPG, or PNG.`);
                            continue;
                        }

                        // Validate file size
                        if (!validateFileSize(file)) {
                            errors.push(`${file.name}: File too large. Maximum size is 5MB.`);
                            continue;
                        }

                        // Additional security checks
                        if (file.name.length > 255) {
                            errors.push(`${file.name}: Filename too long (max 255 characters).`);
                            continue;
                        }

                        // Check for suspicious file names
                        if (/[<>:"/\\|?*]/.test(file.name)) {
                            errors.push(`${file.name}: Invalid characters in filename.`);
                            continue;
                        }

                        validFiles.push(file);
                    } catch (error) {
                        console.error('File validation error:', error);
                        errors.push(`${file.name}: Validation failed.`);
                    }
                }

                // Display errors if any
                if (errors.length > 0) {
                    const errorMessage = errors.length === 1 ? 
                        errors[0] : 
                        `Multiple file errors:\n• ${errors.join('\n• ')}`;
                    
                    errorHandler.showError(errorMessage, 'error');
                    
                    if (container) {
                        container.classList.add('upload-error');
                        container.setAttribute('aria-invalid', 'true');
                        
                        setTimeout(() => {
                            container.classList.remove('upload-error');
                            container.setAttribute('aria-invalid', 'false');
                        }, 5000);
                    }
                }

                // Success message for valid files
                if (validFiles.length > 0) {
                    const successMessage = validFiles.length === 1 ? 
                        `${validFiles[0].name} selected successfully.` : 
                        `${validFiles.length} files selected successfully.`;
                    
                    announceToScreenReader(successMessage);
                }

                return validFiles;
            }

            function handleFiles(files, input, container, multiple) {
                try {
                    if (!files || files.length === 0) {
                        errorHandler.showError('No files selected. Please try again.', 'warning');
                        return;
                    }

                    if (!multiple && files.length > 1) {
                        files = [files[0]]; // Take only first file for single upload
                        errorHandler.showError('Only one file allowed. First file selected.', 'info', 3000);
                    }
                    
                    // Validate files with comprehensive error handling
                    const validFiles = validateAndFilterFiles(files, container);
                    
                    if (validFiles.length === 0) {
                        return; // Errors already displayed by validateAndFilterFiles
                    }
                    
                    // Create new FileList with valid files
                    const dt = new DataTransfer();
                    validFiles.forEach(file => dt.items.add(file));
                    input.files = dt.files;
                    
                    // Show file preview with error handling
                    try {
                        showFilePreview(validFiles, container, multiple);
                    } catch (previewError) {
                        console.error('File preview error:', previewError);
                        errorHandler.showError('Files uploaded but preview failed. Files are still attached.', 'warning');
                    }
                    
                    // Remove validation error states
                    container.classList.remove('is-invalid', 'upload-error');
                    container.setAttribute('aria-invalid', 'false');
                    
                } catch (error) {
                    console.error('File handling error:', error);
                    errorHandler.handleFileUploadError(error, container);
                }
            }

            function showFilePreview(files, container, multiple) {
                const previewContainer = multiple ? 
                    container.querySelector('.additional-files-preview') : 
                    container.querySelector('.file-preview');
                
                if (!multiple) {
                    // Single file preview
                    previewContainer.classList.remove('d-none');
                    const file = files[0];
                    previewContainer.querySelector('.file-name').textContent = file.name;
                    previewContainer.querySelector('.file-size').textContent = formatFileSize(file.size);
                    
                    // Remove file functionality
                    previewContainer.querySelector('.remove-file').onclick = () => {
                        document.getElementById(container.id.replace('Upload', 'File')).value = '';
                        previewContainer.classList.add('d-none');
                    };
                } else {
                    // Multiple files preview
                    previewContainer.innerHTML = '';
                    files.forEach((file, index) => {
                        const filePreview = document.createElement('div');
                        filePreview.className = 'd-flex align-items-center justify-content-between p-3 bg-light rounded-3 mb-2';
                        filePreview.innerHTML = `
                            <div class="d-flex align-items-center">
                                <i class="fas fa-file fa-lg me-3" style="color: #FF4900;"></i>
                                <div>
                                    <div class="fw-semibold">${file.name}</div>
                                    <small class="text-muted">${formatFileSize(file.size)}</small>
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-danger remove-additional-file" data-index="${index}">
                                <i class="fas fa-trash"></i>
                            </button>
                        `;
                        previewContainer.appendChild(filePreview);
                    });
                    
                    // Remove file functionality for additional files
                    previewContainer.querySelectorAll('.remove-additional-file').forEach(btn => {
                        btn.onclick = (e) => {
                            const index = parseInt(e.currentTarget.dataset.index);
                            // This would require more complex file management for multiple files
                            // For now, just remove the preview element
                            e.currentTarget.closest('.d-flex').remove();
                        };
                    });
                }
            }

            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }

            // Enhanced form submission with error handling
            form.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                try {
                    // Clear any previous errors
                    errorHandler.errorContainer.innerHTML = '';
                    
                    // Comprehensive form validation
                    if (!await validateFormComprehensively()) {
                        return;
                    }
                    
                    // Show loading state
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Submitting...';
                    submitBtn.disabled = true;
                    submitBtn.setAttribute('aria-busy', 'true');
                    
                    // Announce submission start to screen readers
                    announceToScreenReader('Submitting application, please wait...');
                    
                    // Simulate form submission with retry mechanism
                    const submissionResult = await retryOperation(async () => {
                        return await simulateFormSubmission();
                    }, 3, 2000);
                    
                    if (submissionResult.success) {
                        handleSuccessfulSubmission(submissionResult.applicationRef);
                    } else {
                        throw new Error(submissionResult.error || 'Submission failed');
                    }
                    
                } catch (error) {
                    console.error('Form submission error:', error);
                    handleSubmissionError(error);
                } finally {
                    // Reset loading state
                    submitBtn.innerHTML = '<i class="fas fa-paper-plane me-2"></i>Submit Application';
                    submitBtn.disabled = false;
                    submitBtn.setAttribute('aria-busy', 'false');
                }
            });

            // Comprehensive form validation
            async function validateFormComprehensively() {
                let isValid = true;
                const errors = [];

                // Validate each step
                for (let step = 1; step <= 4; step++) {
                    if (!validateStep(step)) {
                        isValid = false;
                        errors.push(`Step ${step} has validation errors.`);
                    }
                }

                // Additional file validation
                const resumeInput = document.getElementById('resume');
                if (!resumeInput.files || resumeInput.files.length === 0) {
                    isValid = false;
                    errors.push('Resume is required.');
                    errorHandler.showFormError('resume', 'Please upload your resume.');
                }

                // Validate file integrity
                if (resumeInput.files && resumeInput.files.length > 0) {
                    try {
                        const file = resumeInput.files[0];
                        if (file.size === 0) {
                            isValid = false;
                            errors.push('Resume file appears to be empty.');
                        }
                    } catch (error) {
                        isValid = false;
                        errors.push('Error reading resume file.');
                    }
                }

                // Terms acceptance validation
                const termsCheckbox = document.getElementById('termsAccept');
                if (!termsCheckbox.checked) {
                    isValid = false;
                    errors.push('You must accept the terms and conditions.');
                    errorHandler.showFormError('termsAccept', 'Please accept the terms and conditions to continue.');
                }

                // Display validation errors
                if (!isValid) {
                    const errorMessage = errors.length === 1 ? 
                        errors[0] : 
                        `Please fix the following issues:\n• ${errors.join('\n• ')}`;
                    
                    errorHandler.showError(errorMessage, 'error');
                    
                    // Focus on first invalid field
                    const firstInvalidField = document.querySelector('.is-invalid, [aria-invalid="true"]');
                    if (firstInvalidField) {
                        firstInvalidField.focus();
                        firstInvalidField.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                }

                return isValid;
            }

            // Simulate form submission with realistic scenarios
            async function simulateFormSubmission() {
                return new Promise((resolve, reject) => {
                    setTimeout(() => {
                        // Simulate different scenarios
                        const scenarios = [
                            { probability: 0.85, success: true },
                            { probability: 0.10, success: false, error: 'Network timeout. Please try again.' },
                            { probability: 0.03, success: false, error: 'Server temporarily unavailable.' },
                            { probability: 0.02, success: false, error: 'File upload failed. Please check your files.' }
                        ];

                        let random = Math.random();
                        for (const scenario of scenarios) {
                            if (random < scenario.probability) {
                                if (scenario.success) {
                                    // Generate unique application reference
                                    const timestamp = Date.now();
                                    const randomNum = Math.floor(Math.random() * 9999);
                                    const applicationRef = `MD-2024-APP-${randomNum.toString().padStart(4, '0')}`;
                                    
                                    resolve({
                                        success: true,
                                        applicationRef: applicationRef,
                                        timestamp: new Date().toISOString()
                                    });
                                } else {
                                    resolve({
                                        success: false,
                                        error: scenario.error
                                    });
                                }
                                return;
                            }
                            random -= scenario.probability;
                        }
                        
                        // Fallback to success
                        resolve({ success: true, applicationRef: 'MD-2024-APP-0001' });
                    }, Math.random() * 2000 + 1000); // 1-3 second delay
                });
            }

            // Handle successful submission
            function handleSuccessfulSubmission(applicationRef) {
                try {
                    // Get form data for success page
                    const firstName = document.getElementById('firstName').value;
                    const lastName = document.getElementById('lastName').value;
                    const email = document.getElementById('email').value;
                    const positionSelect = document.getElementById('position');
                    const positionText = positionSelect.options[positionSelect.selectedIndex].text;
                    
                    // Create URL parameters for success page
                    const successParams = new URLSearchParams({
                        ref: applicationRef,
                        firstName: firstName,
                        lastName: lastName,
                        email: email,
                        position: positionText
                    });
                    
                    // Announce success to screen readers
                    announceToScreenReader(`Application submitted successfully. Your reference number is ${applicationRef}. Redirecting to confirmation page.`);
                    
                    // Redirect to success page with applicant data
                    window.location.href = `application-success.html?${successParams.toString()}`;
                    
                } catch (error) {
                    console.error('Error handling successful submission:', error);
                    
                    // Fallback to inline success display if redirect fails
                    try {
                        // Update application reference
                        document.getElementById('applicationReference').textContent = applicationRef;
                        
                        // Hide application form and show success section
                        document.querySelector('.application-form').classList.add('d-none');
                        document.getElementById('applicationSuccess').classList.remove('d-none');
                        
                        // Scroll to success section
                        document.getElementById('applicationSuccess').scrollIntoView({ 
                            behavior: 'smooth',
                            block: 'start'
                        });
                        
                        // Show fallback success notification
                        errorHandler.showError('Application submitted successfully! You will receive a confirmation email shortly.', 'success', 8000);
                    } catch (fallbackError) {
                        console.error('Fallback success handling failed:', fallbackError);
                        alert(`Application submitted successfully! Reference: ${applicationRef}`);
                    }
                }
                
                // Track conversion with analytics tracker
                if (typeof analyticsTracker !== 'undefined') {
                    analyticsTracker.trackConversion(applicationRef);
                }
                
                // Fallback for direct Google Analytics
                if (typeof gtag !== 'undefined') {
                    gtag('event', 'form_submit', {
                        'event_category': 'Application',
                        'event_label': 'Career Application',
                        'value': 1
                    });
                }
                
            }

            // Handle submission errors
            function handleSubmissionError(error) {
                let userMessage = 'We encountered an issue submitting your application. Please try again.';
                
                if (error.message.includes('network') || error.message.includes('Network')) {
                    userMessage = 'Network connection issue. Please check your internet connection and try again.';
                } else if (error.message.includes('timeout')) {
                    userMessage = 'Request timed out. Please try again in a moment.';
                } else if (error.message.includes('server') || error.message.includes('Server')) {
                    userMessage = 'Server temporarily unavailable. Please try again in a few minutes.';
                } else if (error.message.includes('file') || error.message.includes('File')) {
                    userMessage = 'File upload issue. Please check your files and try again.';
                }
                
                errorHandler.showError(userMessage, 'error');
                
                // Provide alternative submission method
                setTimeout(() => {
                    errorHandler.showError(
                        'Having trouble? You can also email your application to careers@manifestghana.com', 
                        'info', 
                        10000
                    );
                }, 3000);
                
                // Announce error to screen readers
                announceToScreenReader('Application submission failed. ' + userMessage);
            }

            // Reset application form function (global scope)
            window.resetApplicationForm = function() {
                // Reset form
                form.reset();
                goToStep(1);
                
                // Clear file previews
                document.querySelectorAll('.file-preview').forEach(preview => {
                    preview.classList.add('d-none');
                });
                document.querySelectorAll('.additional-files-preview').forEach(preview => {
                    preview.innerHTML = '';
                });
                
                // Hide success section and show application form
                document.getElementById('applicationSuccess').classList.add('d-none');
                document.querySelector('.application-form').classList.remove('d-none');
                
                // Scroll to application form
                document.querySelector('.application-form').scrollIntoView({ 
                    behavior: 'smooth',
                    block: 'start'
                });
            };
        });

        // Performance Optimization Manager
        class PerformanceOptimizer {
            constructor() {
                this.lazyImageObserver = null;
                this.isInitialized = false;
            }

            init() {
                if (this.isInitialized) return;
                
                // Initialize all performance optimizations
                this.setupImageLazyLoading();
                this.preloadCriticalResources();
                this.optimizeAnimationPerformance();
                this.setupResourceOptimization();
                this.monitorCoreWebVitals();
                this.enableServiceWorker();
                
                this.isInitialized = true;
                console.log('Performance optimizations initialized');
            }

            setupImageLazyLoading() {
                // Convert existing images to lazy loading
                const images = document.querySelectorAll('img:not([data-src])');
                images.forEach(img => {
                    if (!img.src.includes('data:') && !img.classList.contains('critical-image')) {
                        img.dataset.src = img.src;
                        img.src = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMSIgaGVpZ2h0PSIxIiB2aWV3Qm94PSIwIDAgMSAxIiBmaWxsPSJub25lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxyZWN0IHdpZHRoPSIxIiBoZWlnaHQ9IjEiIGZpbGw9IiNmOGY5ZmEiLz48L3N2Zz4=';
                        img.classList.add('lazy-loading');
                    }
                });

                // Create Intersection Observer for lazy loading
                this.lazyImageObserver = new IntersectionObserver((entries, observer) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const img = entry.target;
                            const src = img.dataset.src;
                            
                            if (src) {
                                // Create a new image to preload
                                const tempImg = new Image();
                                
                                tempImg.onload = () => {
                                    img.src = src;
                                    img.classList.remove('lazy-loading');
                                    img.classList.add('lazy-loaded');
                                    
                                    // Trigger fade in animation
                                    if (typeof anime !== 'undefined') {
                                        anime({
                                            targets: img,
                                            opacity: [0, 1],
                                            duration: 300,
                                            easing: 'easeOutCubic'
                                        });
                                    }
                                };
                                
                                tempImg.onerror = () => {
                                    img.classList.add('lazy-error');
                                    img.alt = 'Image failed to load';
                                    console.warn('Failed to load image:', src);
                                };
                                
                                tempImg.src = src;
                                observer.unobserve(img);
                            }
                        }
                    });
                }, {
                    root: null,
                    rootMargin: '50px',
                    threshold: 0.1
                });
                
                // Observe all lazy loading images
                document.querySelectorAll('img[data-src]').forEach(img => {
                    this.lazyImageObserver.observe(img);
                });
            }

            preloadCriticalResources() {
                // Preload critical images that should load immediately
                const criticalImages = [
                    'images/manifest-logo.svg'
                ];
                
                criticalImages.forEach(src => {
                    const link = document.createElement('link');
                    link.rel = 'preload';
                    link.as = 'image';
                    link.href = src;
                    document.head.appendChild(link);
                });
                
                // Preload critical CSS
                const criticalCSS = `
                    .hero-section { background: linear-gradient(135deg, #FF4900 0%, #ff6b35 100%); }
                    .opportunity-card { transform: translateZ(0); }
                    .benefits-card { backface-visibility: hidden; }
                `;
                
                const style = document.createElement('style');
                style.innerHTML = criticalCSS;
                document.head.appendChild(style);
                
                // Prefetch next likely resources
                const prefetchUrls = [
                    'images/decorative/hero_underline.svg',
                    'images/decorative/mem_donut.svg'
                ];
                
                prefetchUrls.forEach(url => {
                    const link = document.createElement('link');
                    link.rel = 'prefetch';
                    link.href = url;
                    document.head.appendChild(link);
                });
            }

            optimizeAnimationPerformance() {
                // Use will-change for elements that will be animated
                const animatedElements = document.querySelectorAll('.opportunity-card, .benefits-card, .value-card, .testimonial-card');
                animatedElements.forEach(el => {
                    // Apply will-change before hover
                    el.addEventListener('mouseenter', () => {
                        el.style.willChange = 'transform';
                    }, { passive: true });
                    
                    // Remove will-change after animation
                    el.addEventListener('mouseleave', () => {
                        el.style.willChange = 'auto';
                    }, { passive: true });
                });
                
                // Optimize scroll animations with throttling
                let ticking = false;
                const scrollHandler = () => {
                    if (!ticking) {
                        requestAnimationFrame(() => {
                            this.handleScrollAnimations();
                            ticking = false;
                        });
                        ticking = true;
                    }
                };
                
                window.addEventListener('scroll', scrollHandler, { passive: true });
                
                // Pause animations when tab is not visible
                document.addEventListener('visibilitychange', () => {
                    if (typeof anime !== 'undefined') {
                        if (document.hidden) {
                            anime.running.forEach(anim => anim.pause());
                        } else {
                            anime.running.forEach(anim => anim.play());
                        }
                    }
                });
            }

            handleScrollAnimations() {
                // Optimized scroll-based animations
                const elements = document.querySelectorAll('.animate-on-scroll:not(.animated)');
                elements.forEach(el => {
                    const rect = el.getBoundingClientRect();
                    if (rect.top < window.innerHeight * 0.8) {
                        el.classList.add('animated');
                        
                        if (typeof anime !== 'undefined') {
                            anime({
                                targets: el,
                                opacity: [0, 1],
                                translateY: [30, 0],
                                duration: 600,
                                easing: 'easeOutCubic',
                                complete: () => {
                                    el.style.willChange = 'auto';
                                }
                            });
                        }
                    }
                });
            }

            setupResourceOptimization() {
                // Add resource hints
                this.addResourceHints();
                
                // Optimize third-party scripts
                this.optimizeThirdPartyScripts();
                
                // Setup code splitting for large features
                this.setupCodeSplitting();
                
                // Enable memory management
                this.setupMemoryManagement();
            }

            addResourceHints() {
                const hints = [
                    { rel: 'dns-prefetch', href: '//fonts.googleapis.com' },
                    { rel: 'dns-prefetch', href: '//cdnjs.cloudflare.com' },
                    { rel: 'dns-prefetch', href: '//www.googletagmanager.com' },
                    { rel: 'preconnect', href: 'https://fonts.gstatic.com', crossorigin: true }
                ];
                
                hints.forEach(hint => {
                    if (!document.querySelector(`link[href="${hint.href}"]`)) {
                        const link = document.createElement('link');
                        link.rel = hint.rel;
                        link.href = hint.href;
                        if (hint.crossorigin) link.crossOrigin = hint.crossorigin;
                        document.head.appendChild(link);
                    }
                });
            }

            optimizeThirdPartyScripts() {
                // Defer non-critical scripts
                const scripts = document.querySelectorAll('script[src]:not([async]):not([defer])');
                scripts.forEach(script => {
                    if (!script.src.includes('anime.min.js') && !script.src.includes('bootstrap')) {
                        script.defer = true;
                    }
                });
            }

            setupCodeSplitting() {
                // Lazy load heavy features only when needed
                const loadAdvancedFeatures = () => {
                    // Load analytics only when user interacts
                    if (typeof analyticsTracker === 'undefined') {
                        console.log('Loading analytics on demand');
                    }
                };

                // Load on first interaction
                ['click', 'scroll', 'keydown'].forEach(event => {
                    document.addEventListener(event, loadAdvancedFeatures, { once: true, passive: true });
                });
            }

            setupMemoryManagement() {
                let cleanupTimer;
                
                const performCleanup = () => {
                    // Clear expired analytics events
                    if (typeof analyticsTracker !== 'undefined') {
                        analyticsTracker.cleanupExpiredEvents?.();
                    }
                    
                    // Clear animation instances
                    if (typeof anime !== 'undefined' && anime.running.length === 0) {
                        console.log('Animation cleanup performed');
                    }
                    
                    // Clear old event listeners
                    this.cleanupEventListeners();
                };
                
                cleanupTimer = setInterval(performCleanup, 300000); // 5 minutes
                
                window.addEventListener('beforeunload', () => {
                    clearInterval(cleanupTimer);
                    this.cleanup();
                });
            }

            cleanupEventListeners() {
                // Remove old event listeners to prevent memory leaks
                const oldElements = document.querySelectorAll('[data-cleanup-listeners]');
                oldElements.forEach(el => {
                    el.removeAttribute('data-cleanup-listeners');
                });
            }

            monitorCoreWebVitals() {
                if (!('PerformanceObserver' in window)) return;

                // Monitor Largest Contentful Paint (LCP)
                const lcpObserver = new PerformanceObserver((list) => {
                    const entries = list.getEntries();
                    const lastEntry = entries[entries.length - 1];
                    
                    console.log('LCP:', lastEntry.startTime);
                    
                    if (typeof analyticsTracker !== 'undefined' && analyticsTracker.trackPerformanceMetric) {
                        try {
                            analyticsTracker.trackPerformanceMetric('LCP', lastEntry.startTime);
                        } catch (error) {
                            console.warn('Analytics LCP tracking error:', error);
                        }
                    }
                });
                lcpObserver.observe({ entryTypes: ['largest-contentful-paint'] });
                
                // Monitor First Input Delay (FID)
                const fidObserver = new PerformanceObserver((list) => {
                    const entries = list.getEntries();
                    entries.forEach(entry => {
                        const fid = entry.processingStart - entry.startTime;
                        console.log('FID:', fid);
                        
                        if (typeof analyticsTracker !== 'undefined' && analyticsTracker.trackPerformanceMetric) {
                            try {
                                analyticsTracker.trackPerformanceMetric('FID', fid);
                            } catch (error) {
                                console.warn('Analytics FID tracking error:', error);
                            }
                        }
                    });
                });
                fidObserver.observe({ entryTypes: ['first-input'] });
                
                // Monitor Cumulative Layout Shift (CLS)
                let clsValue = 0;
                const clsObserver = new PerformanceObserver((list) => {
                    const entries = list.getEntries();
                    entries.forEach(entry => {
                        if (!entry.hadRecentInput) {
                            clsValue += entry.value;
                        }
                    });
                    
                    console.log('CLS:', clsValue);
                    
                    if (typeof analyticsTracker !== 'undefined' && analyticsTracker.trackPerformanceMetric) {
                        try {
                            analyticsTracker.trackPerformanceMetric('CLS', clsValue);
                        } catch (error) {
                            console.warn('Analytics CLS tracking error:', error);
                        }
                    }
                });
                clsObserver.observe({ entryTypes: ['layout-shift'] });
                
                // Monitor Time to First Byte (TTFB)
                window.addEventListener('load', () => {
                    const navTiming = performance.getEntriesByType('navigation')[0];
                    const ttfb = navTiming.responseStart - navTiming.requestStart;
                    
                    console.log('TTFB:', ttfb);
                    
                    if (typeof analyticsTracker !== 'undefined' && analyticsTracker.trackPerformanceMetric) {
                        try {
                            analyticsTracker.trackPerformanceMetric('TTFB', ttfb);
                        } catch (error) {
                            console.warn('Analytics TTFB tracking error:', error);
                        }
                    }
                });
            }

            enableServiceWorker() {
                // Register service worker for offline functionality
                if ('serviceWorker' in navigator) {
                    window.addEventListener('load', () => {
                        const swCode = `
                            const CACHE_NAME = 'opportunities-v1';
                            const urlsToCache = [
                                '/',
                                'opportunities.html',
                                'images/manifest-logo.svg',
                                'https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js',
                                'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css'
                            ];

                            self.addEventListener('install', event => {
                                event.waitUntil(
                                    caches.open(CACHE_NAME)
                                        .then(cache => cache.addAll(urlsToCache))
                                );
                            });

                            self.addEventListener('fetch', event => {
                                event.respondWith(
                                    caches.match(event.request)
                                        .then(response => {
                                            return response || fetch(event.request);
                                        })
                                );
                            });
                        `;
                        
                        const blob = new Blob([swCode], { type: 'application/javascript' });
                        const swUrl = URL.createObjectURL(blob);
                        
                        navigator.serviceWorker.register(swUrl)
                            .then(registration => {
                                console.log('ServiceWorker registered successfully');
                            })
                            .catch(error => {
                                console.warn('ServiceWorker registration failed (this is normal for file:// URLs):', error.message);
                            });
                    });
                }
            }

            cleanup() {
                // Clean up observers
                if (this.lazyImageObserver) {
                    this.lazyImageObserver.disconnect();
                }
                
                // Clear any remaining timers
                const highestId = setTimeout(() => {}, 0);
                for (let i = 0; i < highestId; i++) {
                    clearTimeout(i);
                }
            }
        }

        // Initialize performance optimizer with error handling
        let performanceOptimizer;
        try {
            performanceOptimizer = new PerformanceOptimizer();
            
            // Initialize on DOM ready with priority
            const initPerformanceOptimizer = () => {
                try {
                    performanceOptimizer.init();
                } catch (error) {
                    console.error('Performance optimizer initialization error:', error);
                }
            };
            
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', () => {
                    setTimeout(initPerformanceOptimizer, 100);
                });
            } else {
                setTimeout(initPerformanceOptimizer, 100);
            }
        } catch (error) {
            console.error('Performance optimizer creation error:', error);
        }

        // ========================
        // Reading Tracker
        // ========================
        const readingTracker = document.querySelector('.reading-tracker');
        
        function updateReadingTracker() {
            const windowHeight = window.innerHeight;
            const documentHeight = document.documentElement.scrollHeight;
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            const trackLength = documentHeight - windowHeight;
            const percentScrolled = Math.min(100, Math.max(0, (scrollTop / trackLength) * 100));
            
            if (readingTracker) {
                readingTracker.style.width = percentScrolled + '%';
            }
            
            // Track reading progress for analytics
            if (typeof analyticsTracker !== 'undefined' && analyticsTracker.trackReadingProgress) {
                analyticsTracker.trackReadingProgress(Math.round(percentScrolled));
            }
        }
        
        window.addEventListener('scroll', updateReadingTracker, { passive: true });
        window.addEventListener('resize', updateReadingTracker, { passive: true });
        
        // Initial update
        updateReadingTracker();

    </script>
</body>
</html>