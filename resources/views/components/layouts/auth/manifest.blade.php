<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('images/logos/favicon.png') }}">
    
    <title>{{ $title ?? 'Authentication' }} | {{ config('app.name', 'Manifest Digital') }}</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anybody:ital,wght@0,400;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Anime.js CDN -->
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
            color: #ffffff;
            font-family: 'Anybody', sans-serif;
            font-size: 1.2rem;
            font-weight: 600;
            opacity: 0;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .progress-bar {
            width: 200px;
            height: 3px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 2px;
            margin: 2rem auto 0;
            overflow: hidden;
        }

        .progress-fill {
            width: 0%;
            height: 100%;
            background: linear-gradient(90deg, #FF4900, #FF6B3D);
            border-radius: 2px;
        }

        /* Animated background elements */
        .bg-element {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 73, 0, 0.05);
        }

        .bg-element-1 {
            width: 300px;
            height: 300px;
            top: -150px;
            left: -150px;
        }

        .bg-element-2 {
            width: 200px;
            height: 200px;
            bottom: -100px;
            right: -100px;
        }

        .bg-element-3 {
            width: 150px;
            height: 150px;
            top: 50%;
            right: -75px;
        }

        /* Hide page content during loading */
        body.loading {
            overflow: hidden;
        }

        body.loading .main-content {
            opacity: 0;
            transform: translateY(30px);
        }

        /* Fade out animation */
        .preloader-fade-out {
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.6s ease, visibility 0.6s ease;
        }
        
        /* Auth Page Specific Styles */
        .auth-hero {
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            padding: 140px 0 60px;
        }
        
        .auth-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('{{ asset('images/decorative/hero_left_mem_dots_f_circle3.svg') }}') no-repeat left center,
                        url('{{ asset('images/decorative/hero_right_circle-con3.svg') }}') no-repeat right center;
            background-size: 300px, 250px;
            opacity: 0.1;
            z-index: 1;
        }
        
        .auth-container {
            background: #FFFCFA;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            max-width: 900px;
            width: 100%;
            margin: 0 auto;
            position: relative;
            z-index: 2;
        }
        
        .auth-content {
            padding: 0;
        }
        
        .auth-form h2 {
            font-family: 'Anybody', sans-serif;
            font-weight: 800;
            font-size: 32px;
            color: #1a1a1a;
            margin-bottom: 12px;
            text-align: center;
        }
        
        .auth-form .subtitle {
            text-align: center;
            color: #666;
            font-size: 16px;
            margin-bottom: 40px;
        }
        
        .form-group {
            margin-bottom: 24px;
            position: relative;
        }
        
        .form-label {
            font-family: 'Anybody', sans-serif;
            font-weight: 600;
            font-size: 14px;
            color: #1a1a1a;
            margin-bottom: 8px;
            display: block;
        }
        
        .form-input {
            width: 100%;
            padding: 16px 20px;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            font-family: 'Anybody', sans-serif;
            font-size: 16px;
            color: #1a1a1a;
            background: #fff;
            transition: all 0.3s ease;
            height: 56px;
            box-sizing: border-box;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #FF4900;
            box-shadow: 0 0 0 3px rgba(255, 73, 0, 0.1);
        }
        
        .form-input.error {
            border-color: #dc3545;
        }
        
        .form-input.success {
            border-color: #28a745;
        }
        
        .form-error {
            color: #dc3545;
            font-size: 14px;
            margin-top: 6px;
            display: block;
        }
        
        .password-toggle {
            position: absolute !important;
            right: 20px !important;
            top: 45px !important;
            background: transparent !important;
            border: 0 !important;
            outline: none !important;
            color: #666 !important;
            cursor: pointer !important;
            font-size: 16px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 20px !important;
            height: 20px !important;
            padding: 0 !important;
            margin: 0 !important;
            line-height: 1 !important;
            z-index: 999 !important;
            box-shadow: none !important;
        }
        
        .checkbox-group {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 32px;
        }
        
        .checkbox-input {
            width: 20px;
            height: 20px;
            margin: 0;
            accent-color: #FF4900;
        }
        
        .checkbox-label {
            font-size: 14px;
            color: #666;
            line-height: 1.5;
            margin: 0;
        }
        
        .checkbox-label a {
            color: #FF4900;
            text-decoration: none;
        }
        
        .checkbox-label a:hover {
            text-decoration: underline;
        }
        
        .btn-auth {
            width: 100%;
            padding: 16px;
            background: #FF4900;
            color: white;
            border: none;
            border-radius: 12px;
            font-family: 'Anybody', sans-serif;
            font-weight: 700;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 24px;
        }
        
        .btn-auth:hover {
            background: #FF6B3D;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 73, 0, 0.3);
        }
        
        .btn-auth:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }
        
        .divider {
            text-align: center;
            margin: 32px 0;
            position: relative;
        }
        
        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #e0e0e0;
            z-index: 1;
        }
        
        .divider span {
            position: relative;
            background: #FFFCFA;
            padding: 0 20px;
            color: #666;
            font-size: 14px;
            z-index: 2;
        }
        
        .social-login {
            display: flex;
            gap: 16px;
            margin-bottom: 32px;
        }
        
        .btn-social {
            flex: 1;
            padding: 14px;
            border: 2px solid #e0e0e0;
            background: white;
            border-radius: 12px;
            font-family: 'Anybody', sans-serif;
            font-weight: 600;
            font-size: 14px;
            color: #1a1a1a;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        
        .btn-social:hover {
            border-color: #FF4900;
            background: #fff7f5;
        }
        
        .back-to-login {
            text-align: center;
            margin-top: 24px;
        }
        
        .back-to-login a {
            color: #FF4900;
            text-decoration: none;
            font-weight: 600;
        }
        
        .back-to-login a:hover {
            text-decoration: underline;
        }
        
        /* Reading Tracker Progress Bar */
        .reading-tracker {
            position: fixed;
            top: 0;
            left: 0;
            width: 0%;
            height: 3px;
            background: linear-gradient(90deg, #FF4900, #FF6B3D);
            z-index: 1000;
            transition: width 0.3s ease;
        }
        
        /* Notification Topbar */
        .notification-topbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: linear-gradient(135deg, #FF4900, #FF6B3D);
            color: white;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            z-index: 9998;
            transform: translateY(-100%);
            opacity: 0;
            visibility: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            font-family: 'Anybody', sans-serif;
        }
        
        .notification-topbar.show {
            transform: translateY(0);
            opacity: 1;
            visibility: visible;
        }
        
        .notification-topbar .notification-icon {
            font-size: 18px;
            animation: bounce 2s infinite;
        }
        
        .notification-content {
            display: flex;
            align-items: center;
            gap: 16px;
            flex: 1;
            justify-content: center;
        }
        
        .notification-text {
            font-size: 14px;
            font-weight: 500;
        }
        
        .notification-cta {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 6px 12px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            font-size: 13px;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }
        
        .notification-cta:hover {
            background: rgba(255, 255, 255, 0.3);
            color: white;
            text-decoration: none;
        }
        
        .notification-close {
            background: none;
            border: none;
            color: white;
            font-size: 20px;
            cursor: pointer;
            padding: 0;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0.8;
            transition: opacity 0.3s ease;
        }
        
        .notification-close:hover {
            opacity: 1;
        }
        
        body.notification-visible {
            padding-top: 60px;
        }
        
        body.notification-visible .primary-header {
            top: 60px;
        }
        
        /* Header Styles */
        .primary-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: rgba(255, 252, 250, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            padding: 20px 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 1000;
            transition: all 0.3s ease;
        }
        
        .logo {
            width: 180px;
            height: 40px;
            background: url('{{ asset('images/logos/logo-dark.svg') }}') no-repeat center;
            background-size: contain;
            transition: transform 0.3s ease;
        }
        
        .logo:hover {
            transform: scale(1.05);
        }
        
        .primary-header nav {
            display: flex;
            gap: 40px;
            align-items: center;
        }
        
        .primary-header nav a {
            font-family: 'Anybody', sans-serif;
            font-weight: 600;
            font-size: 16px;
            color: #1a1a1a;
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .primary-header nav a:hover {
            color: #FF4900;
        }
        
        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .login {
            font-family: 'Anybody', sans-serif;
            font-weight: 600;
            font-size: 16px;
            color: #1a1a1a;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .login:hover,
        .login.active {
            color: #FF4900;
        }
        
        .btn-primary {
            background: #FF4900;
            color: white;
            padding: 14px 28px;
            border-radius: 50px;
            font-family: 'Anybody', sans-serif;
            font-weight: 700;
            font-size: 16px;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }
        
        .btn-primary:hover {
            background: #FF6B3D;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 73, 0, 0.3);
            color: white;
            text-decoration: none;
        }
        
        /* Mobile menu toggle */
        .mobile-menu-toggle {
            display: none;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 30px;
            height: 30px;
            background: none;
            border: none;
            cursor: pointer;
            padding: 0;
            position: relative;
        }
        
        .mobile-menu-toggle span {
            display: block;
            width: 3px;
            height: 3px;
            background: #1a1a1a;
            border-radius: 50%;
            margin: 1px;
            transition: all 0.3s ease;
        }
        
        /* Mobile Navigation */
        .mobile-nav-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1998;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        
        .mobile-nav {
            position: fixed;
            top: 0;
            right: -100%;
            width: 320px;
            height: 100vh;
            background: #FFFCFA;
            z-index: 1999;
            padding: 80px 40px 40px;
            transition: right 0.3s ease;
            overflow-y: auto;
        }
        
        .mobile-nav.active {
            right: 0;
        }
        
        .mobile-nav-overlay.active {
            opacity: 1;
            visibility: visible;
        }
        
        .mobile-nav nav {
            display: flex;
            flex-direction: column;
            gap: 30px;
            margin-bottom: 40px;
        }
        
        .mobile-nav nav a {
            font-family: 'Anybody', sans-serif;
            font-weight: 600;
            font-size: 18px;
            color: #1a1a1a;
            text-decoration: none;
            padding: 15px 0;
            border-bottom: 1px solid #f0f0f0;
            transition: color 0.3s ease;
        }
        
        .mobile-nav nav a:hover {
            color: #FF4900;
        }
        
        .mobile-nav-buttons {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }
        
        /* Mobile Responsive */
        @media (max-width: 768px) {
            .auth-hero {
                padding: 140px 20px 60px;
                min-height: auto;
            }
            
            .auth-container {
                margin: 20px;
                border-radius: 16px;
            }
            
            .auth-content {
                padding: 30px 24px;
            }
            
            .auth-form h2 {
                font-size: 28px;
            }
            
            .primary-header {
                padding: 20px;
            }
            
            .primary-header nav {
                display: none;
            }
            
            .mobile-menu-toggle {
                display: flex;
            }
            
            .notification-topbar {
                padding: 10px 16px;
            }
            
            .notification-text {
                font-size: 13px;
            }
            
            .notification-cta {
                padding: 4px 8px;
                font-size: 12px;
            }
        }
    </style>
</head>
<body class="loading">
    <!-- Preloader -->
    <div id="preloader">
        <div class="bg-element bg-element-1"></div>
        <div class="bg-element bg-element-2"></div>
        <div class="bg-element bg-element-3"></div>
        
        <div class="preloader-container">
            <div class="loader-logo">
                <img src="{{ Vite::asset('resources/images/logos/favicon.png') }}" alt="Manifest Digital Logo" class="logo-image">
            </div>
            
            <div class="loading-dots">
                <div class="dot dot-1"></div>
                <div class="dot dot-2"></div>
                <div class="dot dot-3"></div>
                <div class="dot dot-4"></div>
                <div class="dot dot-5"></div>
            </div>
            
            <div class="loading-text">Loading</div>
            
            <div class="progress-bar">
                <div class="progress-fill"></div>
            </div>
        </div>
    </div>

    <!-- Reading Tracker Progress Bar -->
    <div class="reading-tracker"></div>
    
    <!-- Notification Topbar -->
    <div class="notification-topbar">
        <span class="notification-icon">🎉</span>
        <div class="notification-content">
            <span class="notification-text">
                Launch Special: First month 20% off + free brand consultation (GH₵500 value) • Limited spots available
            </span>
            <a href="#" class="notification-cta">Claim Offer</a>
        </div>
        <button class="notification-close" aria-label="Close notification">×</button>
    </div>
    
    <header class="primary-header">
        <a href="{{ route('home') }}" class="logo"></a>
        <nav>
            <a href="{{ route('home') }}">Home</a>
            <a href="{{ route('projects') }}">Projects</a>
            <a href="{{ url('ai-chat') }}">AI Sensei</a>
            <a href="{{ url('book-call') }}">Book a Call</a>
        </nav>
        <div class="header-right">
            <a href="{{ route('login') }}" class="login {{ request()->routeIs('login') ? 'active' : '' }}">Login</a>
            <a href="{{ route('request-quote') }}" class="btn-primary">Get a Quote</a>
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
            <a href="{{ route('home') }}">Home</a>
            <a href="{{ route('projects') }}">Projects</a>
            <a href="{{ url('ai-chat') }}">AI Sensei</a>
            <a href="{{ url('book-call') }}">Book a Call</a>
        </nav>
        <div class="mobile-nav-buttons">
            <a href="{{ url('login') }}" class="login {{ request()->routeIs('login') ? 'active' : '' }}">Login</a>
            <a href="{{ url('request-quote') }}" class="btn-primary">Get a Quote</a>
        </div>
    </div>

    <!-- Auth Hero Section -->
    <section class="auth-hero">
        <div class="auth-container">
            {{ $slot }}
        </div>
    </section>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // ========================
        // Preloader Animation
        // ========================
        document.addEventListener('DOMContentLoaded', function() {
            // Animate background elements
            anime({
                targets: '.bg-element-1',
                rotate: 360,
                duration: 20000,
                loop: true,
                easing: 'linear'
            });
            
            anime({
                targets: '.bg-element-2',
                rotate: -360,
                duration: 15000,
                loop: true,
                easing: 'linear'
            });
            
            anime({
                targets: '.bg-element-3',
                rotate: 360,
                duration: 25000,
                loop: true,
                easing: 'linear'
            });
            
            // Logo container animation
            anime({
                targets: '.loader-logo',
                scale: [0.9, 1],
                rotateY: [0, 360],
                duration: 3000,
                easing: 'easeInOutQuad',
                loop: true,
                direction: 'alternate'
            });
            
            // Logo image reveal with smooth entrance
            setTimeout(() => {
                const logoImage = document.querySelector('.logo-image');
                if (logoImage) {
                    logoImage.classList.add('loaded');
                }
            }, 500);
            
            // Logo image pulse animation
            anime({
                targets: '.logo-image',
                scale: [1, 1.1, 1],
                duration: 2000,
                delay: 1000,
                loop: true,
                easing: 'easeInOutQuad'
            });
            
            // Loading dots animation - target only preloader dots
            anime({
                targets: '.loading-dots .dot',
                opacity: [0.3, 1],
                scale: [1, 1.2],
                duration: 600,
                delay: anime.stagger(100),
                loop: true,
                direction: 'alternate',
                easing: 'easeInOutQuad'
            });
            
            // Loading text fade in
            anime({
                targets: '.loading-text',
                opacity: [0, 1],
                translateY: [20, 0],
                duration: 800,
                delay: 1000,
                easing: 'easeOutQuad'
            });
            
            // Progress bar fill
            anime({
                targets: '.progress-fill',
                width: ['0%', '100%'],
                duration: 3000,
                delay: 1500,
                easing: 'easeInOutQuad'
            });
            
            // Hide preloader after animations complete
            setTimeout(function() {
                // Fade out preloader
                anime({
                    targets: '#preloader',
                    opacity: [1, 0],
                    duration: 600,
                    easing: 'easeOutQuad',
                    complete: function() {
                        document.getElementById('preloader').style.display = 'none';
                        document.body.style.overflow = 'hidden';
                        
                        // Show notification after preloader if not previously closed
                        if (typeof window.showNotificationAfterPreloader === 'function') {
                            window.showNotificationAfterPreloader();
                        }
                        
                        // Animate main content in
                        anime({
                            targets: '.main-content',
                            opacity: [0, 1],
                            translateY: [30, 0],
                            duration: 800,
                            easing: 'easeOutQuad'
                        });
                        
                        // Staggered animation for sections
                        anime({
                            targets: 'header, main, .cta-footer',
                            opacity: [0, 1],
                            translateY: [20, 0],
                            duration: 600,
                            delay: anime.stagger(200),
                            easing: 'easeOutQuad',
                            complete: function() {
                                document.body.classList.remove('loading');
                                document.body.style.overflow = '';
                            }
                        });
                    }
                });
            }, 4500);
        });

        // Notification bar timing after preloader
        function showNotificationAfterPreloader() {
            const notificationClosed = localStorage.getItem('notificationClosed');
            
            if (!notificationClosed) {
                setTimeout(() => {
                    const notificationTopbar = document.querySelector('.notification-topbar');
                    if (notificationTopbar) {
                        notificationTopbar.classList.add('show');
                        document.body.classList.add('notification-visible');
                    }
                    
                    const closeBtn = document.querySelector('.notification-close');
                    if (closeBtn && !closeBtn.hasAttribute('data-listener-added')) {
                        closeBtn.setAttribute('data-listener-added', 'true');
                        closeBtn.addEventListener('click', function() {
                            const notificationTopbar = document.querySelector('.notification-topbar');
                            if (notificationTopbar) {
                                notificationTopbar.classList.remove('show');
                                document.body.classList.remove('notification-visible');
                                localStorage.setItem('notificationClosed', 'true');
                            }
                        });
                    }
                }, 300);
            }
        }

        setTimeout(showNotificationAfterPreloader, 4500);
        
        // Mobile menu functionality
        const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
        const mobileNav = document.querySelector('.mobile-nav');
        const mobileNavOverlay = document.querySelector('.mobile-nav-overlay');
        
        if (mobileMenuToggle) {
            mobileMenuToggle.addEventListener('click', function() {
                mobileNav.classList.toggle('active');
                mobileNavOverlay.classList.toggle('active');
                document.body.classList.toggle('mobile-nav-open');
            });
        }
        
        if (mobileNavOverlay) {
            mobileNavOverlay.addEventListener('click', function() {
                mobileNav.classList.remove('active');
                mobileNavOverlay.classList.remove('active');
                document.body.classList.remove('mobile-nav-open');
            });
        }
    </script>
    
    @stack('scripts')
</body>
</html>