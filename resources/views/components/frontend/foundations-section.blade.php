@props([
    'title' => 'Our Solutions are Built on Solid Foundations',
    'foundations' => [],
    'decorativeImages' => [
        'topPipe' => 'frontend/images/decorative/purple_mem_3d_semi_pipe.svg',
        'leftDonut' => 'frontend/images/decorative/mem_donut.svg',
        'rightTriangle' => 'frontend/images/decorative/mem_dots_f_tri.svg'
    ],
    'animateOnScroll' => true,
    'staggerChildren' => true
])

@php
$defaultFoundations = [
    [
        'icon' => 'fas fa-shield-halved',
        'title' => 'Secure',
        'description' => 'Building trust through robust security measures that protect your users and safeguard sensitive information at every touchpoint.'
    ],
    [
        'icon' => 'fas fa-bolt',
        'title' => 'Fast',
        'description' => 'Optimized for speed to boost search rankings and deliver exceptional user experiences that keep visitors engaged.'
    ],
    [
        'icon' => 'fas fa-mobile-screen-button',
        'title' => 'Responsive',
        'description' => 'Seamlessly adapting to any device, ensuring consistent, beautiful experiences across desktops, tablets, and smartphones.'
    ],
    [
        'icon' => 'fas fa-universal-access',
        'title' => 'Inclusive',
        'description' => 'Designed for everyone with intuitive, accessible interfaces that welcome all users regardless of ability or background.'
    ],
    [
        'icon' => 'fas fa-eye',
        'title' => 'Clear',
        'description' => 'Elegant simplicity that communicates your message effectively, cutting through noise to deliver crystal-clear value.'
    ],
    [
        'icon' => 'fas fa-heart',
        'title' => 'Memorable',
        'description' => 'Crafting compelling narratives that resonate deeply, making your brand unforgettable for all the right reasons.'
    ]
];

$foundationsList = empty($foundations) ? $defaultFoundations : $foundations;
@endphp

<section class="section-four">
    <!-- Decorative elements for section-four -->
    <img src="{{ asset($decorativeImages['topPipe']) }}" alt="" class="decorative-element top-pipe">
    <img src="{{ asset($decorativeImages['leftDonut']) }}" alt="" class="decorative-element left-donut">
    <img src="{{ asset($decorativeImages['rightTriangle']) }}" alt="" class="decorative-element right-triangle">
    
    <div class="content-box">
        <h2{{ $animateOnScroll ? ' class=animate-on-scroll' : '' }}>{{ $title }}</h2>
        <div class="foundations-grid{{ $staggerChildren ? ' stagger-children' : '' }}">
            @foreach($foundationsList as $foundation)
                <div class="foundation-item">
                    <div class="foundation-icon">
                        <i class="{{ $foundation['icon'] }}"></i>
                    </div>
                    <h3>{{ $foundation['title'] }}</h3>
                    <p>{{ $foundation['description'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>