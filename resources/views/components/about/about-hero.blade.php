@props([
    'title' => 'We Craft Digital Solutions for Purpose-Driven Organizations',
    'subtitle' => 'A trusted IT services partner since 2014, empowering organizations globally with innovative technology solutions',
    'stats' => [
        [
            'number' => '10+',
            'label' => 'Years of Excellence'
        ],
        [
            'number' => '100+',
            'label' => 'Happy Clients'
        ],
        [
            'number' => '3',
            'label' => 'Countries Served'
        ],
        [
            'number' => '100%',
            'label' => 'Client Satisfaction'
        ]
    ]
])

<section class="about-hero">
    <div class="container">
        <div class="about-hero-content">
            <h1>{{ $title }}</h1>
            <p>{{ $subtitle }}</p>
            
            <div class="hero-stats">
                @foreach($stats as $stat)
                <div class="stat-item">
                    <span class="stat-number">{{ $stat['number'] }}</span>
                    <span class="stat-label">{{ $stat['label'] }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<style>
.about-hero {
    background: linear-gradient(135deg, rgba(255, 34, 0, 0.9), rgba(255, 107, 0, 0.9));
    min-height: 60vh;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    padding: 4rem 0;
    position: relative;
    overflow: hidden;
    text-align: center;
}

.about-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: radial-gradient(circle at 20% 50%, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
}

.about-hero-content {
    position: relative;
    z-index: 1;
    max-width: 1000px;
    margin: 0 auto;
}

.about-hero h1 {
    font-size: 3.5rem;
    font-weight: 800;
    margin-bottom: 1.5rem;
    line-height: 1.2;
}

.about-hero p {
    font-size: 1.3rem;
    margin-bottom: 2rem;
    opacity: 0.95;
}

.hero-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 2rem;
    margin-top: 3rem;
}

.stat-item {
    text-align: center;
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 800;
    display: block;
    margin-bottom: 0.5rem;
}

.stat-label {
    font-size: 1rem;
    opacity: 0.9;
}

@media (max-width: 992px) {
    .about-hero h1 {
        font-size: 2.5rem;
    }
}

@media (max-width: 768px) {
    .about-hero h1 {
        font-size: 2rem;
    }

    .about-hero p {
        font-size: 1.1rem;
    }

    .hero-stats {
        grid-template-columns: repeat(2, 1fr);
    }
}
</style>