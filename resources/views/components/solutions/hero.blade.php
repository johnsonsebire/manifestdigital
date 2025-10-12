@props([
    'title' => 'Our <span class="highlight">Solutions</span>',
    'description' => 'Comprehensive digital services designed to transform your business and drive measurable results in the modern digital landscape.'
])

<section class="solutions-hero">
    <div class="solutions-hero-content">
        <h1>{!! $title !!}</h1>
        <p>{{ $description }}</p>
    </div>
</section>

@push('styles')
<style>
/* Solutions Page Specific Styles */
.solutions-hero {
    background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
    padding: 120px 0 80px;
    text-align: center;
    color: white;
    position: relative;
    overflow: hidden;
}

.solutions-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('{{ asset("images/decorative/hero_left_mem_dots_f_circle3.svg") }}') no-repeat left center,
                url('{{ asset("images/decorative/hero_right_circle-con3.svg") }}') no-repeat right center;
    opacity: 0.1;
    pointer-events: none;
}

.solutions-hero-content {
    position: relative;
    z-index: 1;
    max-width: 900px;
    margin: 0 auto;
}

.solutions-hero h1 {
    font-size: 64px;
    font-weight: 800;
    margin-bottom: 20px;
    line-height: 1.2;
}

.solutions-hero p {
    font-size: 20px;
    opacity: 0.9;
    margin-bottom: 0;
}

.solutions-hero .highlight {
    color: #ff2200;
}

@media (max-width: 768px) {
    .solutions-hero h1 {
        font-size: 42px;
    }
    
    .solutions-hero p {
        font-size: 16px;
    }
}
</style>
@endpush