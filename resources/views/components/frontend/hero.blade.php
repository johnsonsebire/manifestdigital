@props([
    'title' => 'Data-driven solutions for purpose-driven organizations',
    'highlightWord' => 'solutions',
    'rotatingWords' => ['Data-driven', 'Bespoke', 'Custom AI', 'Super fast'],
    'subtitle' => 'Websites, apps, logos - whatever your project needs, anytime!',
    'ctaText' => 'View Pricing',
    'ctaUrl' => '#pricing',
    'ctaId' => 'view-pricing-btn',
    'tagline' => 'We deliver excellent solutions, no fluff.',
    'decorativeImages' => [
        'leftDots' => Vite::asset('resources/images/decorative/hero_left_mem_dots_f_circle3.svg'),
        'rightCircles' => Vite::asset('resources/images/decorative/hero_right_circle-con3.svg'),
        'topCircle' => asset('images/decorative/hero_top_mem_stripe_circle2.png'),
        'underline' => asset('images/decorative/hero_underline.svg')
    ]
])

<section class="hero">
    <!-- Decorative elements for the hero section -->
    <img src="{{ $decorativeImages['leftDots'] }}" alt="" class="decorative-element hero-left-dots">
    <img src="{{ $decorativeImages['rightCircles'] }}" alt="" class="decorative-element hero-right-circles">
    <img src="{{ $decorativeImages['topCircle'] }}" alt="" class="decorative-element hero-top-circle">

    <h1>
        <div class="text-rotate-wrapper">
            <div class="text-rotate-container">
                <div class="text-rotate-inner">
                    <div class="text-rotate">
                        @foreach($rotatingWords as $word)
                            <span class="text-rotate-item" data-width="true">{{ $word }}</span>
                        @endforeach
                    </div>
                </div>
                <div class="underline-container">
                    <img src="{{ $decorativeImages['underline'] }}" alt="" class="underline-svg">
                </div>
            </div>
        </div>
        <span class="highlight">{{ $highlightWord }}</span> for<br>purpose-driven organizations.
    </h1>
    
    <p class="subtitle">{{ $subtitle }}</p>
    
    <a href="{{ $ctaUrl }}" class="btn-primary" id="{{ $ctaId }}">{{ $ctaText }}</a>
    
    <p class="tagline">{{ $tagline }}</p>
</section>