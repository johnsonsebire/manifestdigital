@props([
    'title' => 'Our Blog',
    'subtitle' => 'Insights on digital transformation, web development, AI, and technology trends to help your business thrive in the digital age.',
    'highlightWord' => 'Blog',
    'backgroundImage' => 'images/decorative/hero_top_mem_stripe_circle2.png'
])

<section class="blog-hero" {{ $attributes }}>
    <div class="blog-hero-content">
        <h1>{!! str_replace($highlightWord, '<span class="highlight">' . $highlightWord . '</span>', $title) !!}</h1>
        <p>{{ $subtitle }}</p>
    </div>
</section>

<style>
.blog-hero {
    background: linear-gradient(135deg, rgba(26, 26, 26, 0.95), rgba(45, 45, 45, 0.95)),
        url('{{ asset($backgroundImage) }}') no-repeat center;
    background-size: cover;
    padding: 120px 0 80px;
    text-align: center;
    color: white;
    position: relative;
    overflow: hidden;
}

.blog-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: radial-gradient(circle at 30% 50%, rgba(255, 34, 0, 0.1) 0%, transparent 50%);
}

.blog-hero-content {
    position: relative;
    z-index: 1;
    max-width: 800px;
    margin: 0 auto;
}

.blog-hero h1 {
    font-size: 64px;
    font-weight: 800;
    margin-bottom: 20px;
    line-height: 1.2;
}

.blog-hero p {
    font-size: 20px;
    opacity: 0.9;
    margin-bottom: 0;
}

.blog-hero .highlight {
    color: #ff2200;
}

@media (max-width: 992px) {
    .blog-hero h1 {
        font-size: 48px;
    }
}

@media (max-width: 768px) {
    .blog-hero h1 {
        font-size: 36px;
    }

    .blog-hero p {
        font-size: 16px;
    }
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.blog-hero h1,
.blog-hero p {
    animation: fadeInUp 0.6s ease-out;
}

.blog-hero p {
    animation-delay: 0.2s;
}
</style>