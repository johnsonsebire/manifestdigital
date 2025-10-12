@props([
    'title' => 'Measurable Business Impact',
    'description' => 'Our AI solutions deliver real, quantifiable results for your business',
    'stats' => [
        [
            'number' => '70%',
            'title' => 'Cost Reduction',
            'description' => 'Average savings on customer support costs with AI chatbots'
        ],
        [
            'number' => '10x',
            'title' => 'Faster Processing',
            'description' => 'Speed improvement in document processing and data entry'
        ],
        [
            'number' => '24/7',
            'title' => 'Always Available',
            'description' => 'Round-the-clock customer engagement without additional staff'
        ],
        [
            'number' => '95%',
            'title' => 'Accuracy Rate',
            'description' => 'Precision in automated tasks and predictions'
        ]
    ]
])

<section class="roi-section">
    <div class="roi-container">
        <div class="section-header">
            <h2 style="color: white;">{{ $title }}</h2>
            <p style="color: rgba(255,255,255,0.9);">{{ $description }}</p>
        </div>
        
        <div class="roi-stats">
            @foreach($stats as $stat)
            <div class="roi-stat">
                <div class="roi-number">{{ $stat['number'] }}</div>
                <h3>{{ $stat['title'] }}</h3>
                <p>{{ $stat['description'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

@push('styles')
<style>
.roi-section {
    padding: 100px 0;
    background: linear-gradient(135deg, #1a1a1a, #2d2d2d);
    color: white;
}

.roi-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.roi-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 40px;
    margin-top: 60px;
}

.roi-stat {
    text-align: center;
}

.roi-number {
    font-size: 64px;
    font-weight: 800;
    background: linear-gradient(135deg, #ff2200, #ff6600);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 15px;
}

.roi-stat h3 {
    font-size: 22px;
    font-weight: 700;
    margin-bottom: 10px;
}

.roi-stat p {
    font-size: 16px;
    opacity: 0.9;
}

@media (max-width: 768px) {
    .roi-number {
        font-size: 48px;
    }
}
</style>
@endpush