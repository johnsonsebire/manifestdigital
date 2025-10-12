@props([
    'badgeText' => '🤖 AI-Powered Solutions',
    'title' => 'Your <span class="highlight">AI Sensei</span><br>Transform Business with Intelligence',
    'description' => 'Harness the power of artificial intelligence to automate workflows, enhance customer experiences, and unlock data-driven insights that drive real growth.',
    'primaryButtonText' => 'Schedule AI Consultation',
    'primaryButtonUrl' => '/book-a-call',
    'secondaryButtonText' => 'View Pricing',
    'secondaryButtonUrl' => '#pricing'
])

<section class="ai-hero">
    <div class="ai-hero-content">
        <span class="ai-badge">{{ $badgeText }}</span>
        <h1>{!! $title !!}</h1>
        <p>{{ $description }}</p>
        <div class="ai-cta-buttons">
            <a href="{{ $primaryButtonUrl }}" class="btn-ai-primary">
                <i class="fas fa-calendar-check"></i> {{ $primaryButtonText }}
            </a>
            <a href="{{ $secondaryButtonUrl }}" class="btn-ai-secondary">
                <i class="fas fa-tag"></i> {{ $secondaryButtonText }}
            </a>
        </div>
    </div>
</section>

@push('styles')
<style>
/* AI Sensei Page Specific Styles */
.ai-hero {
    background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
    padding: 140px 0 100px;
    text-align: center;
    color: white;
    position: relative;
    overflow: hidden;
}

.ai-hero::before {
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

.ai-hero-content {
    max-width: 900px;
    margin: 0 auto;
    padding: 0 20px;
    position: relative;
    z-index: 1;
}

.ai-badge {
    display: inline-block;
    padding: 8px 20px;
    background: rgba(255, 34, 0, 0.2);
    border: 2px solid #ff2200;
    border-radius: 30px;
    color: #ff2200;
    font-weight: 600;
    font-size: 14px;
    margin-bottom: 25px;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.ai-hero h1 {
    font-size: 64px;
    font-weight: 800;
    margin-bottom: 25px;
    line-height: 1.2;
}

.ai-hero .highlight {
    background: linear-gradient(135deg, #ff2200, #ff6600);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.ai-hero p {
    font-size: 22px;
    opacity: 0.95;
    margin-bottom: 40px;
    line-height: 1.6;
}

.ai-cta-buttons {
    display: flex;
    gap: 20px;
    justify-content: center;
    flex-wrap: wrap;
}

.btn-ai-primary {
    padding: 16px 36px;
    background: linear-gradient(135deg, #ff2200, #ff4422);
    color: white;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 700;
    font-size: 18px;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    transition: all 0.3s ease;
}

.btn-ai-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(255, 34, 0, 0.3);
    color: white;
}

.btn-ai-secondary {
    padding: 16px 36px;
    background: transparent;
    color: white;
    border: 2px solid white;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 700;
    font-size: 18px;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    transition: all 0.3s ease;
}

.btn-ai-secondary:hover {
    background: white;
    color: #1a1a1a;
}

@media (max-width: 768px) {
    .ai-hero h1 {
        font-size: 40px;
    }
    
    .ai-hero p {
        font-size: 18px;
    }
    
    .ai-cta-buttons {
        flex-direction: column;
    }
}
</style>
@endpush