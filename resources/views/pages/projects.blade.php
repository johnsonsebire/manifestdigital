<x-layouts.frontend>
    
    @section('meta')
        <meta name="description" content="Explore our portfolio of 40+ successful projects. From nonprofits to enterprises across Ghana, UK, and USA - see how Manifest Digital delivers data-driven digital solutions.">
        <meta name="keywords" content="web development portfolio Ghana, digital agency projects, website design examples, mobile app portfolio, Ghana web development showcase">
    @endsection

    @section('title', 'Our Projects | Manifest Digital Portfolio')

    <!-- Projects Hero Section -->
    <section class="projects-hero">
        <h1>Our <span class="highlight">Portfolio</span></h1>
        <p>Explore 40+ successful projects delivered for purpose-driven organizations across Ghana, UK, and USA since 2014</p>
    </section>

    <!-- Projects Section -->
    <x-projects.filters-section />
    
    <!-- Projects Grid Section -->
    <x-projects.grid-section />

    <!-- Stats Section -->
    <x-projects.stats-section />
</x-layouts.frontend>