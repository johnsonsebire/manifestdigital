@props([
    'transparentHeader' => false,
    'preloader' => 'advanced',
    'title' => 'Manifest Digital | Custom Web & App Development in Ghana | Est. 2014'
])

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Transform your digital presence with Manifest Digital. Expert web development, mobile apps, and IT solutions for purpose-driven organizations in Ghana & worldwide. 10+ years experience since 2014.">
    <meta name="keywords"
        content="web development Ghana, custom app development, digital agency Ghana, UI/UX design services, enterprise solutions, IT consulting, affordable web design packages, SAP consulting, blockchain solutions">
    <meta name="author" content="Manifest Digital">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('images/logos/favicon.png') }}">>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Transform your digital presence with Manifest Digital. Expert web development, mobile apps, and IT solutions for purpose-driven organizations in Ghana & worldwide. 10+ years experience since 2014.">
    <meta name="keywords"
        content="web development Ghana, custom app development, digital agency Ghana, UI/UX design services, enterprise solutions, IT consulting, affordable web design packages, SAP consulting, blockchain solutions">
    <meta name="author" content="Manifest Digital">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('images/logos/favicon.png') }}">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="Manifest Digital | Custom Web & App Development in Ghana | Est. 2014">
    <meta property="og:description"
        content="Data-driven, customer-centric digital solutions for purpose-driven organizations. Full-stack team, transparent communication, proven results since 2014.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://manifestghana.com">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Manifest Digital | Expert Web & App Development Ghana">
    <meta name="twitter:description"
        content="10+ years delivering digital solutions for purpose-driven organizations. Full-stack team, fast turnaround, transparent pricing.">

    <title>{{ $title }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anybody:ital,wght@0,400;0,600;0,700;0,800;1,400&display=swap"
        rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for social icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.12.0/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/css/styles.css', 'resources/js/scripts.js'])

    <!-- Additional CSS -->
    @stack('styles')

    <!-- Anime.js CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
    @if ($preloader == 'simple')
        @vite(['resources/css/simple-preloader.css', 'resources/js/simple-preloader.js'])
    @else
        @vite(['resources/css/advanced-preloader.css', 'resources/js/advanced-preloader.js'])
    @endif
    
    <!-- Initial state setup for preloader -->
    <style>
        .loading .main-content {
            opacity: 0;
            visibility: hidden;
        }
    </style>
</head>

<body class="loading">

    @if ($preloader == 'simple')
        <x-common.simple-preloader />
    @else
        <x-common.advanced-preloader />
    @endif

    <x-layouts.frontend.primary-header :transparent="$transparentHeader" />

    <main class="main-content">
        {{ $slot }}
    </main>

    <x-layouts.frontend.footer />
</body>

</html>
