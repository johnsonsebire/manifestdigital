@props([
    'title' => 'Comprehensive Digital Solutions',
    'subtitle' => 'From strategy to execution, we deliver end-to-end digital services that drive growth',
    'services' => [],
    'accentImage' => 'frontend/images/decorative/cta_left_mem_dots_f_circle2.svg',
    'animateOnScroll' => true,
    'staggerChildren' => true
])

@php
$defaultServices = [
    ['name' => 'AI/ML Solutions', 'hasAccent' => false],
    ['name' => 'UI/UX Design', 'hasAccent' => true],
    ['name' => 'Custom Web Development', 'hasAccent' => false],
    ['name' => 'Mobile App Development', 'hasAccent' => false],
    ['name' => 'Enterprise Solutions', 'hasAccent' => false],
    ['name' => 'Logos & Branding', 'hasAccent' => false],
    ['name' => 'SEO & Digital Marketing', 'hasAccent' => false],
    ['name' => 'IT Training & Support', 'hasAccent' => false],
    ['name' => 'Cloud Computing Solutions', 'hasAccent' => false],
    ['name' => 'Cyber Security', 'hasAccent' => false],
    ['name' => 'Blockchain Solutions', 'hasAccent' => false],
    ['name' => 'Email & Communication Design', 'hasAccent' => false]
];

$servicesList = empty($services) ? $defaultServices : $services;
@endphp

<section class="what-we-do">
    <h2{{ $animateOnScroll ? ' class=animate-on-scroll' : '' }}>{{ $title }}</h2>
    @if($subtitle)
        <p class="services-subheading{{ $animateOnScroll ? ' animate-on-scroll' : '' }}">{{ $subtitle }}</p>
    @endif
    
    <div class="services-grid{{ $staggerChildren ? ' stagger-children' : '' }}">
        @foreach($servicesList as $service)
            <div class="service-item">
                @if($service['hasAccent'] ?? false)
                    <img src="{{ $accentImage }}" alt="" class="service-accent">
                @endif
                <h3>{{ $service['name'] }}</h3>
                <div class="service-underline"></div>
            </div>
        @endforeach
    </div>
</section>