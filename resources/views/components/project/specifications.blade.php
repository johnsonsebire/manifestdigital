@props([
    'specifications' => [],
    'technologies' => []
])

<div class="project-specs">
    {{-- Technical Specifications --}}
    @if(count($specifications))
        <div class="specs-section">
            <h3>Technical Specifications</h3>
            <div class="specs-grid">
                @foreach($specifications as $spec)
                    <div class="spec-item">
                        <div class="spec-label">{{ $spec['label'] }}</div>
                        <div class="spec-value">{{ $spec['value'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
    
    {{-- Technologies Used --}}
    @if(count($technologies))
        <div class="specs-section">
            <h3>Technologies Used</h3>
            <div class="tech-grid">
                @foreach($technologies as $tech)
                    <div class="tech-item" x-data="{ showTooltip: false }">
                        <div class="tech-icon" 
                             @mouseenter="showTooltip = true"
                             @mouseleave="showTooltip = false">
                            @if(isset($tech['icon']))
                                <i class="{{ $tech['icon'] }}"></i>
                            @elseif(isset($tech['image']))
                                <img src="{{ asset($tech['image']) }}" alt="{{ $tech['name'] }}">
                            @endif
                            
                            <div x-show="showTooltip" 
                                 x-transition
                                 class="tech-tooltip"
                                 x-cloak>
                                {{ $tech['name'] }}
                                @if(isset($tech['version']))
                                    <span class="version">v{{ $tech['version'] }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

<style>
.project-specs {
    background: white;
    border-radius: 20px;
    padding: 40px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
    margin: 40px 0;
}

.specs-section {
    margin-bottom: 40px;
}

.specs-section:last-child {
    margin-bottom: 0;
}

.specs-section h3 {
    font-size: 24px;
    font-weight: 700;
    margin-bottom: 25px;
    color: #333;
}

.specs-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
}

.spec-item {
    background: #f8f8f8;
    padding: 20px;
    border-radius: 15px;
    transition: all 0.3s ease;
}

.spec-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
}

.spec-label {
    color: #666;
    font-size: 14px;
    margin-bottom: 8px;
}

.spec-value {
    color: #333;
    font-weight: 600;
    font-size: 16px;
}

.tech-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
}

.tech-item {
    position: relative;
}

.tech-icon {
    width: 60px;
    height: 60px;
    background: #f8f8f8;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    color: #333;
    transition: all 0.3s ease;
    cursor: pointer;
}

.tech-icon:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.tech-icon img {
    width: 32px;
    height: 32px;
    object-fit: contain;
}

.tech-tooltip {
    position: absolute;
    bottom: 100%;
    left: 50%;
    transform: translateX(-50%);
    background: #333;
    color: white;
    padding: 8px 12px;
    border-radius: 6px;
    font-size: 14px;
    white-space: nowrap;
    margin-bottom: 10px;
    z-index: 10;
}

.tech-tooltip::after {
    content: '';
    position: absolute;
    top: 100%;
    left: 50%;
    transform: translateX(-50%);
    border-width: 5px;
    border-style: solid;
    border-color: #333 transparent transparent transparent;
}

.tech-tooltip .version {
    opacity: 0.7;
    font-size: 12px;
    margin-left: 5px;
}

[x-cloak] {
    display: none !important;
}

/* Responsive Design */
@media (max-width: 768px) {
    .project-specs {
        padding: 30px;
    }
    
    .specs-grid {
        grid-template-columns: 1fr;
    }
    
    .specs-section h3 {
        font-size: 20px;
    }
}

@media (max-width: 480px) {
    .project-specs {
        padding: 20px;
        border-radius: 15px;
    }
    
    .tech-icon {
        width: 50px;
        height: 50px;
        font-size: 20px;
    }
    
    .tech-icon img {
        width: 28px;
        height: 28px;
    }
}
</style>