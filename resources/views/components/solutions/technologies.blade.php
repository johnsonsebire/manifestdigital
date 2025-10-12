@props([
    'title' => 'Technologies We Master',
    'description' => 'Cutting-edge tools and frameworks that power modern digital solutions',
    'categories' => [
        [
            'name' => 'Frontend Development',
            'technologies' => [
                ['name' => 'React', 'icon' => 'fab fa-react', 'color' => '#61DAFB'],
                ['name' => 'Vue.js', 'icon' => 'fab fa-vuejs', 'color' => '#4FC08D'],
                ['name' => 'Angular', 'icon' => 'fab fa-angular', 'color' => '#DD0031'],
                ['name' => 'TypeScript', 'icon' => 'fab fa-js-square', 'color' => '#3178C6'],
                ['name' => 'Next.js', 'icon' => 'fas fa-layer-group', 'color' => '#000000'],
                ['name' => 'Tailwind CSS', 'icon' => 'fas fa-paint-brush', 'color' => '#06B6D4']
            ]
        ],
        [
            'name' => 'Backend Development',
            'technologies' => [
                ['name' => 'Laravel', 'icon' => 'fab fa-laravel', 'color' => '#FF2D20'],
                ['name' => 'Node.js', 'icon' => 'fab fa-node-js', 'color' => '#339933'],
                ['name' => 'Python', 'icon' => 'fab fa-python', 'color' => '#3776AB'],
                ['name' => 'PHP', 'icon' => 'fab fa-php', 'color' => '#777BB4'],
                ['name' => 'Express.js', 'icon' => 'fas fa-server', 'color' => '#000000'],
                ['name' => 'Django', 'icon' => 'fab fa-python', 'color' => '#092E20']
            ]
        ],
        [
            'name' => 'Mobile Development',
            'technologies' => [
                ['name' => 'React Native', 'icon' => 'fab fa-react', 'color' => '#61DAFB'],
                ['name' => 'Flutter', 'icon' => 'fas fa-mobile-alt', 'color' => '#02569B'],
                ['name' => 'iOS Swift', 'icon' => 'fab fa-apple', 'color' => '#FA7343'],
                ['name' => 'Android Kotlin', 'icon' => 'fab fa-android', 'color' => '#3DDC84'],
                ['name' => 'Ionic', 'icon' => 'fas fa-mobile', 'color' => '#3880FF'],
                ['name' => 'Xamarin', 'icon' => 'fab fa-microsoft', 'color' => '#512BD4']
            ]
        ],
        [
            'name' => 'Cloud & DevOps',
            'technologies' => [
                ['name' => 'AWS', 'icon' => 'fab fa-aws', 'color' => '#FF9900'],
                ['name' => 'Azure', 'icon' => 'fab fa-microsoft', 'color' => '#0078D4'],
                ['name' => 'Google Cloud', 'icon' => 'fab fa-google', 'color' => '#4285F4'],
                ['name' => 'Docker', 'icon' => 'fab fa-docker', 'color' => '#2496ED'],
                ['name' => 'Kubernetes', 'icon' => 'fas fa-dharmachakra', 'color' => '#326CE5'],
                ['name' => 'Jenkins', 'icon' => 'fab fa-jenkins', 'color' => '#D33833']
            ]
        ]
    ]
])

<section class="technologies-section">
    <div class="technologies-container">
        <div class="section-intro">
            <h2>{{ $title }}</h2>
            <p>{{ $description }}</p>
        </div>
        
        <div class="tech-categories">
            @foreach($categories as $category)
            <div class="tech-category">
                <h3>{{ $category['name'] }}</h3>
                <div class="tech-grid">
                    @foreach($category['technologies'] as $tech)
                    <div class="tech-item" data-color="{{ $tech['color'] }}">
                        <div class="tech-icon">
                            <i class="{{ $tech['icon'] }}" style="color: {{ $tech['color'] }}"></i>
                        </div>
                        <span>{{ $tech['name'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="tech-stats">
            <div class="stat-item">
                <div class="stat-number">50+</div>
                <div class="stat-label">Technologies Mastered</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">100+</div>
                <div class="stat-label">Projects Completed</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">5+</div>
                <div class="stat-label">Years Experience</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">24/7</div>
                <div class="stat-label">Technical Support</div>
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
/* Technologies Section */
.technologies-section {
    background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
    color: white;
    padding: 80px 20px;
}

.technologies-container {
    max-width: 1400px;
    margin: 0 auto;
}

.technologies-section .section-intro h2 {
    color: white;
}

.technologies-section .section-intro p {
    color: #ccc;
}

.tech-categories {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 40px;
    margin-top: 50px;
    margin-bottom: 60px;
}

.tech-category h3 {
    font-size: 24px;
    font-weight: 800;
    margin-bottom: 30px;
    background: linear-gradient(135deg, #ff2200, #ff6b00);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.tech-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
    gap: 20px;
}

.tech-item {
    background: rgba(255, 255, 255, 0.05);
    padding: 20px;
    border-radius: 12px;
    text-align: center;
    transition: all 0.3s ease;
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.tech-item:hover {
    transform: translateY(-5px);
    background: rgba(255, 255, 255, 0.1);
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
}

.tech-icon {
    font-size: 36px;
    margin-bottom: 10px;
}

.tech-item span {
    font-size: 14px;
    font-weight: 600;
    color: #fff;
}

.tech-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 30px;
    margin-top: 60px;
    padding-top: 60px;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
}

.stat-item {
    text-align: center;
}

.stat-number {
    font-size: 48px;
    font-weight: 900;
    background: linear-gradient(135deg, #ff2200, #ff6b00);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 10px;
    line-height: 1;
}

.stat-label {
    font-size: 16px;
    color: #ccc;
    font-weight: 600;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .tech-categories {
        grid-template-columns: 1fr;
        gap: 30px;
    }
    
    .tech-grid {
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
        gap: 15px;
    }
    
    .tech-item {
        padding: 15px;
    }
    
    .tech-icon {
        font-size: 28px;
    }
    
    .stat-number {
        font-size: 36px;
    }
}
</style>
@endpush