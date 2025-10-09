@props([
    'title' => 'How it Works',
    'steps' => [],
    'ctaText' => 'Ready to Transform Your Digital Presence?',
    'decorativeImage' => 'frontend/images/decorative/how_it_works_mem_dots_f_circle2.svg',
    'animateOnScroll' => true,
    'staggerChildren' => true
])

@php
$defaultSteps = [
    [
        'icon' => 'fas fa-comments',
        'title' => 'Share Your Vision',
        'description' => 'Tell us about your project goals, target audience, and brand vision. We\'ll schedule a consultation to understand your unique needs and craft a tailored digital strategy.'
    ],
    [
        'icon' => 'fas fa-code',
        'title' => 'We Design & Develop',
        'description' => 'Our expert team combines data-driven insights with creative excellence to build your solution. Track progress in real-time, provide feedback, and watch your vision come to life.'
    ],
    [
        'icon' => 'fas fa-rocket',
        'title' => 'Launch & Grow',
        'description' => 'We deliver pixel-perfect, performance-optimized solutions on time. Post-launch, we provide ongoing support, training, and optimization to ensure your digital success.'
    ]
];

$stepsList = empty($steps) ? $defaultSteps : $steps;
@endphp

<section class="how-it-works">
    <!-- Decorative element for how-it-works section -->
    <img src="{{ $decorativeImage }}" alt="" class="decorative-element dots-circle">
    
    <h2{{ $animateOnScroll ? ' class=animate-on-scroll' : '' }}>{{ $title }}</h2>
    <div class="columns{{ $staggerChildren ? ' stagger-children' : '' }}">
        @foreach($stepsList as $step)
            <div class="column">
                <div class="icon">
                    <i class="{{ $step['icon'] }}"></i>
                </div>
                <h3>{{ $step['title'] }}</h3>
                <p>{{ $step['description'] }}</p>
            </div>
        @endforeach
    </div>
    @if($ctaText)
        <p class="cta-text">{{ $ctaText }}</p>
    @endif
</section>