@props([
    'title' => 'Mission & Vision',
    'subtitle' => 'Driving digital transformation with purpose and passion',
    'cards' => [
        [
            'icon' => 'fas fa-bullseye',
            'title' => 'Our Mission',
            'content' => 'To empower businesses—especially in Ghana and across Africa—with the digital tools and strategies they need to succeed in a fast-moving, tech-driven world. We aim to bridge the gap between local expertise and global best practices, ensuring that our clients not only thrive locally but also compete internationally.'
        ],
        [
            'icon' => 'fas fa-eye',
            'title' => 'Our Vision',
            'content' => 'To be Africa\'s leading digital transformation partner, recognized globally for delivering innovative, purpose-driven technology solutions that create lasting impact. We envision a future where every organization, regardless of size or location, has access to world-class digital solutions that drive growth and success.'
        ]
    ]
])

<section class="mission-vision-section">
    <div class="container">
        <h2 class="section-title">{{ $title }}</h2>
        <p class="section-subtitle">{{ $subtitle }}</p>
        
        <div class="mission-vision-grid">
            @foreach($cards as $card)
            <div class="mv-card">
                <div class="mv-icon">
                    <i class="{{ $card['icon'] }}"></i>
                </div>
                <h3>{{ $card['title'] }}</h3>
                <p>{{ $card['content'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<style>
.mission-vision-section {
    background: #f8f9fa;
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

.mission-vision-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 3rem;
    margin-top: 3rem;
}

.mv-card {
    background: white;
    padding: 3rem 2rem;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    text-align: center;
    transition: transform 0.3s;
}

.mv-card:hover {
    transform: translateY(-10px);
}

.mv-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #ff2200, #ff6b00);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    color: white;
    font-size: 2rem;
}

.mv-card h3 {
    font-size: 1.8rem;
    font-weight: 700;
    margin-bottom: 1rem;
    color: #ff2200;
}

.mv-card p {
    font-size: 1.1rem;
    color: #666;
    line-height: 1.7;
}

@media (max-width: 768px) {
    .section-title {
        font-size: 2rem;
    }

    .mv-card {
        padding: 2rem 1.5rem;
    }

    .mv-card h3 {
        font-size: 1.5rem;
    }
}
</style>