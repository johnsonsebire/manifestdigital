<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Custom Styles -->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased" x-data="{ showMobileMenu: false }">
    <!-- Preloader -->
    <x-layout.preloader />

    <!-- Reading Progress Tracker -->
    <div class="reading-tracker"></div>

    <!-- Notification Topbar -->
    <x-layout.notification-topbar />

    <!-- Header -->
    <x-layout.header />

    <!-- Main Content -->
    <main class="main-content">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <x-layout.footer />

    <!-- Scroll to Top Button -->
    <button class="scroll-to-top" aria-label="Scroll to top">
        <i class="fas fa-arrow-up"></i>
    </button>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>