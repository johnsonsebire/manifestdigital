@props([
    'title' => 'Our Story',
    'subtitle' => 'From humble beginnings to a globally trusted digital partner',
    'content' => [
        'Since 2014, Manifest Digital (formerly Manifest Multimedia) has been a trusted IT services partner, empowering organizations globally with innovative technology solutions. With over 10 years of deep industry experience, we deliver comprehensive, end-to-end solutions that drive tangible, measurable results.',
        'We\'re a people-first technology company established to produce work that benefits people. Our journey began with a simple vision: to bridge the gap between local expertise and global best practices, ensuring that our clients not only thrive locally but also compete internationally.'
    ],
    'highlightTitle' => 'Why Choose Us?',
    'highlightContent' => 'Our unique expertise and client-focused approach ensure your business outcomes are at the heart of everything we do. We don\'t just deliver projects; we deliver success. Partner with a globally trusted brand to bring confidence, skill, and innovation to your digital journey.'
])

<section class="story-section">
    <div class="container">
        <h2 class="section-title">{{ $title }}</h2>
        <p class="section-subtitle">{{ $subtitle }}</p>
        
        <div class="story-content">
            @foreach($content as $paragraph)
            <p class="story-text">{{ $paragraph }}</p>
            @endforeach

            <div class="highlight-box">
                <h3>{{ $highlightTitle }}</h3>
                <p class="story-text">{{ $highlightContent }}</p>
            </div>
        </div>
    </div>
</section>

<style>
section {
    padding: 5rem 0;
}

.section-title {
    font-size: 2.5rem;
    font-weight: 800;
    margin-bottom: 1rem;
    text-align: center;
}

.section-subtitle {
    font-size: 1.2rem;
    color: #666;
    text-align: center;
    max-width: 700px;
    margin: 0 auto 3rem;
}

.story-content {
    max-width: 900px;
    margin: 0 auto;
}

.story-text {
    font-size: 1.1rem;
    line-height: 1.8;
    color: #555;
    margin-bottom: 1.5rem;
}

.highlight-box {
    background: linear-gradient(135deg, rgba(255, 34, 0, 0.05), rgba(255, 107, 0, 0.05));
    border-left: 4px solid #ff2200;
    padding: 2rem;
    margin: 2rem 0;
    border-radius: 8px;
}

.highlight-box h3 {
    color: #ff2200;
    font-weight: 700;
    margin-bottom: 1rem;
}

@media (max-width: 768px) {
    .section-title {
        font-size: 2rem;
    }
}
</style>