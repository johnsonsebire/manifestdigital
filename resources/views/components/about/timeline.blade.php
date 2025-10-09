@props([
    'title' => 'Our Journey',
    'subtitle' => 'A decade of growth, innovation, and impact',
    'timeline' => [
        [
            'year' => '2014',
            'title' => 'The Beginning',
            'content' => 'Manifest Multimedia was founded with a vision to provide purpose-driven digital solutions to organizations in Ghana and beyond. Started with a small team of passionate developers and designers.'
        ],
        [
            'year' => '2017',
            'title' => 'Expansion & Growth',
            'content' => 'Expanded our services to include mobile app development and AI solutions. Grew our team and client base across multiple African countries and international markets.'
        ],
        [
            'year' => '2020',
            'title' => 'Digital Transformation',
            'content' => 'Pivoted to focus on AI and machine learning solutions. Helped numerous businesses navigate the digital transformation accelerated by the global pandemic.'
        ],
        [
            'year' => '2024',
            'title' => 'Rebranding to Manifest Digital',
            'content' => 'Officially rebranded to Manifest Digital, reflecting our evolution into a comprehensive digital transformation partner. Launched AI Sensei and expanded our global reach.'
        ],
        [
            'year' => '2025',
            'title' => 'The Future',
            'content' => 'Continuing to innovate and lead in AI solutions, automation, and digital transformation. Committed to empowering African businesses to compete globally.'
        ]
    ]
])

<section class="timeline-section">
    <div class="container">
        <h2 class="section-title">{{ $title }}</h2>
        <p class="section-subtitle">{{ $subtitle }}</p>
        
        <div class="timeline">
            @foreach($timeline as $item)
            <div class="timeline-item">
                <div class="timeline-year">{{ $item['year'] }}</div>
                <div class="timeline-content">
                    <h4>{{ $item['title'] }}</h4>
                    <p>{{ $item['content'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<style>
.timeline-section {
    padding: 5rem 0;
    background: #f8f9fa;
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

.timeline {
    position: relative;
    max-width: 900px;
    margin: 3rem auto;
    padding: 2rem 0;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    width: 3px;
    height: 100%;
    background: linear-gradient(to bottom, #ff2200, #ff6b00);
}

.timeline-item {
    display: flex;
    justify-content: flex-start;
    padding: 2rem 0;
    position: relative;
}

.timeline-item:nth-child(even) {
    justify-content: flex-end;
}

.timeline-content {
    width: 45%;
    background: white;
    padding: 2rem;
    border-radius: 12px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    position: relative;
}

.timeline-year {
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #ff2200, #ff6b00);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 800;
    font-size: 1.2rem;
    box-shadow: 0 0 0 10px rgba(255, 34, 0, 0.1);
}

.timeline-content h4 {
    font-size: 1.3rem;
    font-weight: 700;
    margin-bottom: 1rem;
    color: #ff2200;
}

.timeline-content p {
    color: #666;
    line-height: 1.6;
}

@media (max-width: 992px) {
    .timeline::before {
        left: 30px;
    }

    .timeline-item {
        justify-content: flex-end !important;
        padding-left: 80px;
    }

    .timeline-content {
        width: 100%;
    }

    .timeline-year {
        left: 30px;
    }
}

@media (max-width: 768px) {
    .section-title {
        font-size: 2rem;
    }

    .timeline-content {
        padding: 1.5rem;
    }

    .timeline-year {
        width: 60px;
        height: 60px;
        font-size: 1rem;
    }
}
</style>