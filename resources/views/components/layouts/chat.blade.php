@props([
    'title' => 'AI Chat',
    'description' => 'Chat with our AI assistant',
    'preloader' => 'simple',
])

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - Manifest Digital</title>
    <meta name="description" content="{{ $description }}">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.ico') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css'])
    <style>
        :root {
            color-scheme: dark;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            color: rgba(255, 255, 255, 0.9);
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }

        .app-container {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            position: relative;
            z-index: 1;
        }

        .gradient-background {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background:
                radial-gradient(circle at 15% 50%, rgba(255, 34, 0, 0.1), transparent 25%),
                radial-gradient(circle at 85% 30%, rgba(255, 85, 51, 0.1), transparent 25%);
            z-index: 0;
            pointer-events: none;
        }

        .noise-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%' height='100%' filter='url(%23noiseFilter)' opacity='0.1'/%3E%3C/svg%3E");
            opacity: 0.4;
            z-index: 0;
            pointer-events: none;
        }

        .main-header {
            padding: 16px;
            background: rgba(255, 255, 255, 0.03);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            position: relative;
            z-index: 10;
        }

        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: rgba(255, 255, 255, 0.9);
        }

        .brand img {
            height: 32px;
            width: auto;
        }

        .brand-name {
            font-size: 18px;
            font-weight: 600;
        }

        .main-content {
            flex: 1;
            padding: 32px 16px;
            max-width: 1200px;
            margin: 0 auto;
            width: 100%;
            box-sizing: border-box;
            position: relative;
            z-index: 1;
        }

        @media (max-width: 640px) {
            .main-content {
                padding: 16px;
            }
        }
    </style>

    <!-- Scripts -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
    @if ($preloader == 'simple')
        @vite('resources/css/simple-preloader.css')
    @else
        @vite('resources/css/advanced-preloader.css')
    @endif
</head>

<body>
    @if ($preloader == 'simple')
        <x-common.simple-preloader />
        @else 
        <x-common.advanced-preloader />
    @endif

    <div class="app-container">
        <header class="main-header">
            <div class="header-content">
                <a href="{{ route('home') }}" class="brand">
                    <img src="{{ asset('frontend/images/logos/logo.png') }}" alt="Manifest Digital Logo">
                </a>
            </div>
        </header>

        <main class="main-content">
            {{ $slot }}
        </main>
    </div>

    <div class="gradient-background"></div>
    <div class="noise-overlay"></div>
    @if ($preloader == 'simple')
        @push('scripts')
            @vite('resources/js/simple-preloader.js')
        @else
            @vite('resources/js/advanced-preloader.js')
        @endif
        @stack('scripts')
        @vite(['resources/js/app.js', 'resources/js/scripts.js'])
    </body>

    </html>
