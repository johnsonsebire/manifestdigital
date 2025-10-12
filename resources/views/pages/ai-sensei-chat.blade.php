<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Sensei Chat - Minimal Interface</title>
    <meta name="description" content="Minimal AI Sensei chat interface for embedded use or standalone chat experience.">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('images/logos/favicon.png') }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anybody:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Anime.js CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>

    @vite(['resources/css/ai-chat.css', 'resources/js/ai-chat.js'])
</head>
<body>
    <x-ai-chat.preloader />
    {{-- <x-common.notification-topbar /> --}}
    
    <!-- Minimal Header -->
    <div class="minimal-header">
        <a href="{{ route('home') }}" class="minimal-logo">
            <img src="{{ asset('images/logos/logo.png') }}" alt="Manifest Digital">
        </a>
    </div>

    <!-- Header Controls -->
    <div class="header-controls">
        <button class="theme-toggle" id="themeToggle" onclick="toggleTheme()" title="Toggle Dark/Light Mode">
            <i class="fas fa-sun" id="themeIcon"></i>
        </button>
        <a href="{{ url('ai-chat') }}" class="back-btn">
            <i class="fas fa-external-link-alt"></i>
            <span>Full Site</span>
        </a>
    </div>

    <!-- Chat Container -->
    <div class="chat-container">
        <x-ai-chat.sidebar />
        <x-ai-chat.main-chat />
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>