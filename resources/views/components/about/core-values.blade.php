@props([
    'title' => 'Our Core Values',
    'subtitle' => 'The principles that guide everything we do',
    'values' => [
        [
            'icon' => 'fas fa-shield-alt',
            'title' => 'Secure',
            'description' => 'Good for building trust and protecting users and information. We prioritize security in every solution we build.'
        ],
        [
            'icon' => 'fas fa-bolt',
            'title' => 'Fast',
            'description' => 'Good for search engines and general user experience. Speed is not just a feature; it\'s a fundamental requirement.'
        ],
        [
            'icon' => 'fas fa-mobile-alt',
            'title' => 'Responsive',
            'description' => 'Good for maintaining the same experience across multiple devices. We ensure consistency everywhere.'
        ],
        [
            'icon' => 'fas fa-users',
            'title' => 'Inclusive',
            'description' => 'We build simple and easy to use solutions for everyone, ensuring accessibility for all users.'
        ],
        [
            'icon' => 'fas fa-lightbulb',
            'title' => 'Clear',
            'description' => 'We keep it elegant and easy to understand. Good for conveying your message across effectively.'
        ],
        [
            'icon' => 'fas fa-star',
            'title' => 'Memorable',
            'description' => 'We tell the stories that matter and make you memorable for the right reasons.'
        ]
    ]
])

<section class="core-values-section">
    <div class="container">
        <h2 class="section-title">{{ $title }}</h2>
        <p class="section-subtitle">{{ $subtitle }}</p>
        
        <div class="values-grid">
            @foreach($values as $value)
            <div class="value-card">
                <div class="value-icon">
                    <i class="{{ $value['icon'] }}"></i>
                </div>
                <h4>{{ $value['title'] }}</h4>
                <p>{{ $value['description'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<style>
.core-values-section {
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

.values-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
    margin-top: 3rem;
}

.value-card {
    background: white;
    padding: 2rem;
    border-radius: 12px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    transition: all 0.3s;
    border-top: 3px solid #ff2200;
}

.value-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(255, 34, 0, 0.2);
}

.value-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, rgba(255, 34, 0, 0.1), rgba(255, 107, 0, 0.1));
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1rem;
    color: #ff2200;
    font-size: 1.8rem;
}

.value-card h4 {
    font-size: 1.3rem;
    font-weight: 700;
    margin-bottom: 0.8rem;
    color: #333;
}

.value-card p {
    font-size: 1rem;
    color: #666;
    line-height: 1.6;
}

@media (max-width: 768px) {
    .section-title {
        font-size: 2rem;
    }

    .values-grid {
        grid-template-columns: 1fr;
    }

    .value-card {
        padding: 1.5rem;
    }
}
</style>