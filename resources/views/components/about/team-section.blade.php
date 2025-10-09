@props([
    'title' => 'Our People',
    'subtitle' => 'Meet the passionate professionals who drive innovation, creativity, and excellence in everything we do.',
    'style' => 'default', // 'default', 'photo', or 'circle'
    'members' => []
])

<section class="team-section {{ $style }}-style">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">{{ $title }}</h2>
            <p class="section-subtitle">{{ $subtitle }}</p>
        </div>
        
        <div class="team-grid">
            @foreach($members as $member)
                @if($style === 'photo')
                    <x-about.team.photo-member-card :member="$member" />
                @elseif($style === 'circle')
                    <x-about.team.circle-member-card :member="$member" />
                @else
                    <x-about.team.member-card :member="$member" />
                @endif
            @endforeach
        </div>
    </div>
</section>

<style>
.team-section {
    padding: 5rem 0;
}

.team-section.photo-style {
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
}

.team-section.circle-style {
    background: #ffffff;
}

.section-header {
    text-align: center;
    margin-bottom: 4rem;
}

.section-title {
    font-size: 2.5rem;
    font-weight: 800;
    margin-bottom: 1.5rem;
    color: #1a1a1a;
}

.section-subtitle {
    font-size: 1.2rem;
    color: #666;
    line-height: 1.6;
    max-width: 800px;
    margin: 0 auto;
}

.team-grid {
    display: grid;
    gap: 3rem;
    margin-top: 2rem;
}

.default-style .team-grid {
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
}

.photo-style .team-grid {
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    max-width: 1400px;
    margin: 0 auto;
}

.circle-style .team-grid {
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    max-width: 1200px;
    margin: 0 auto;
    gap: 3rem 2rem;
}

@media (max-width: 768px) {
    .section-title {
        font-size: 2rem;
    }

    .team-grid {
        gap: 2rem;
    }

    .default-style .team-grid {
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    }
}
</style>