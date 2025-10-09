<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Transform your digital presence with Manifest Digital. Expert web development, mobile apps, and IT solutions for purpose-driven organizations in Ghana & worldwide. 10+ years experience since 2014.">
    <meta name="keywords" content="web development Ghana, custom app development, digital agency Ghana, UI/UX design services, enterprise solutions, IT consulting, affordable web design packages, SAP consulting, blockchain solutions">
    <meta name="author" content="Manifest Digital">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{asset('frontend/images/logos/favicon.png')}}">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="Manifest Digital | Custom Web & App Development in Ghana | Est. 2014">
    <meta property="og:description" content="Data-driven, customer-centric digital solutions for purpose-driven organizations. Full-stack team, transparent communication, proven results since 2014.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://manifestghana.com">
    
    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Manifest Digital | Expert Web & App Development Ghana">
    <meta name="twitter:description" content="10+ years delivering digital solutions for purpose-driven organizations. Full-stack team, fast turnaround, transparent pricing.">
    
    <title>Manifest Digital | Custom Web & App Development in Ghana | Est. 2014</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anybody:ital,wght@0,400;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for social icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="{{asset('frontend/css/styles.css')}}">
   

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
        
    </style>
</head>
<body class="loading">
<x-layouts.frontend.primary-header />

    <main class="main-content">
        {{ $slot }}
    </main>

    <x-layouts.frontend.footer />
</body>
</html>