<x-layouts.frontend 
    title="Manifest Digital | Custom Web & App Development in Ghana | Est. 2014"
    :transparent-header="true"
    preloader='advanced'
    notificationStyle='modern-purple'>
@push('styles')
@vite('resources/css/opportunities.css')
@endpush 


<!-- Opportunities Hero Section -->
<section class="opportunities-hero" id="main-content" role="banner">
    <!-- Decorative elements -->
    <div class="opportunities-hero-decorative" aria-hidden="true">
        <img src="{{ asset('images/decorative/hero_left_mem_dots_f_circle3.svg') }}" alt="" class="hero-decoration left">
        <img src="{{ asset('images/decorative/hero_right_circle-con3.svg') }}" alt="" class="hero-decoration right">
        <img src="{{ asset('images/decorative/mem_donut.svg') }}" alt="" class="hero-decoration center">
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

<x-frontend.opportunities.life-at-manifest />

<x-frontend.opportunities.team-testimonials />

<x-frontend.opportunities.opportunities-listing />

<x-frontend.opportunities.opportunity-modal />

<x-frontend.opportunities.application-form />

<x-frontend.opportunities.application-success />



</x-layouts.frontend>
