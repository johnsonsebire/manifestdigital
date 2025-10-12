@props([
    'title' => 'Why Choose Manifest Digital',
    'description' => 'We combine technical expertise with business acumen to deliver solutions that drive real results',
    'reasons' => [
        [
            'icon' => 'fas fa-award',
            'title' => '10+ Years Experience',
            'description' => 'Over a decade of delivering successful digital solutions across Africa and beyond'
        ],
        [
            'icon' => 'fas fa-users',
            'title' => 'Expert Team',
            'description' => 'Skilled professionals with certifications and expertise in cutting-edge technologies'
        ],
        [
            'icon' => 'fas fa-chart-line',
            'title' => 'Proven Results',
            'description' => '40+ successful projects with measurable impact and client satisfaction'
        ],
        [
            'icon' => 'fas fa-headset',
            'title' => '24/7 Support',
            'description' => 'Round-the-clock technical support to ensure your business never stops'
        ]
    ]
])

<section class="why-choose-section">
    <div class="why-choose-container">
        <div class="section-intro">
            <h2>{{ $title }}</h2>
            <p>{{ $description }}</p>
        </div>
        
        <div class="why-choose-grid">
            @foreach($reasons as $reason)
            <div class="why-card">
                <div class="why-icon">
                    <i class="{{ $reason['icon'] }}"></i>
                </div>
                <h4>{{ $reason['title'] }}</h4>
                <p>{{ $reason['description'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

@push('styles')
<style>
/* Why Choose Us Section */
.why-choose-section {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 80px 20px;
    margin: 80px 0;
}

.why-choose-container {
    max-width: 1400px;
    margin: 0 auto;
}

.why-choose-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 40px;
    margin-top: 50px;
}

.why-card {
    text-align: center;
    padding: 30px;
    background: white;
    border-radius: 15px;
    transition: all 0.3s ease;
}

.why-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.why-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #ff2200, #ff6b00);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
}

.why-icon i {
    font-size: 36px;
    color: white;
}

.why-card h4 {
    font-size: 22px;
    font-weight: 800;
    margin-bottom: 15px;
    color: #1a1a1a;
}

.why-card p {
    color: #666;
    font-size: 15px;
    line-height: 1.6;
}
</style>
@endpush