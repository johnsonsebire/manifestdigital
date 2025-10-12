@props([
    'title' => 'Join the Manifest Digital Team',
    'subtitle' => 'Build the future of digital solutions with Ghana\'s leading development team. Where innovation meets collaboration, and every project shapes tomorrow.',
    'stats' => [
        ['number' => '10+', 'label' => 'Years Experience'],
        ['number' => '40+', 'label' => 'Projects Delivered'],
        ['number' => '15+', 'label' => 'Team Members']
    ]
])

<!-- Opportunities Hero Section -->
<section class="opportunities-hero" id="main-content" role="banner">
    <!-- Decorative elements -->
    <div class="opportunities-hero-decorative" aria-hidden="true">
        <img src="{{ asset('images/decorative/hero_left_mem_dots_f_circle3.svg') }}" alt="" class="hero-decoration left">
        <img src="{{ asset('images/decorative/hero_right_circle-con3.svg') }}" alt="" class="hero-decoration right">
        <img src="{{ asset('images/decorative/mem_donut.svg') }}" alt="" class="hero-decoration center">
    </div>
    
    <div class="opportunities-hero-content">
        <h1>{{ $title }}</h1>
        <p class="subtitle">{{ $subtitle }}</p>
        
        <!-- Hero Statistics -->
        <div class="opportunities-hero-stats" role="group" aria-label="Company statistics">
            @foreach($stats as $stat)
            <div class="hero-stat">
                <span class="hero-stat-number" aria-label="Over {{ $stat['number'] }}">{{ $stat['number'] }}</span>
                <span class="hero-stat-label">{{ $stat['label'] }}</span>
            </div>
            @endforeach
        </div>
        
        <!-- Hero Action Buttons -->
        <div class="opportunities-hero-buttons">
            <a href="#opportunities-section" class="hero-btn-primary">
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