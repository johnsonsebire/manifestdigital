@props([
    'projects' => [],
    'currentProjectId' => null,
    'title' => 'Related Projects'
])

<section class="related-projects">
    <div class="section-header">
        <h2>{{ $title }}</h2>
    </div>
    
    <div class="projects-grid">
        @foreach($projects->where('id', '!=', $currentProjectId)->take(3) as $project)
            <div class="project-card">
                <div class="project-image">
                    @if($project->thumbnail)
                        <img src="{{ asset($project->thumbnail) }}" 
                             alt="{{ $project->title }}"
                             loading="lazy">
                    @endif
                    
                    @if($project->category)
                        <div class="project-category">{{ $project->category }}</div>
                    @endif
                </div>
                
                <div class="project-content">
                    <h3>
                        <a href="{{ route('projects.show', $project->slug) }}">
                            {{ $project->title }}
                        </a>
                    </h3>
                    
                    <p>{{ Str::limit($project->excerpt, 120) }}</p>
                    
                    <div class="project-footer">
                        @if($project->client)
                            <div class="project-client">
                                <i class="fas fa-building"></i>
                                <span>{{ $project->client }}</span>
                            </div>
                        @endif
                        
                        @if($project->completion_date)
                            <div class="project-date">
                                <i class="fas fa-calendar"></i>
                                <span>{{ $project->completion_date->format('M Y') }}</span>
                            </div>
                        @endif
                    </div>
                </div>
                
                <a href="{{ route('projects.show', $project->slug) }}" 
                   class="project-link"
                   aria-label="View {{ $project->title }}">
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        @endforeach
    </div>
    
    <div class="section-footer">
        <a href="{{ route('projects.index') }}" class="view-all-btn">
            View All Projects
            <i class="fas fa-arrow-right"></i>
        </a>
    </div>
</section>

<style>
.related-projects {
    margin: 80px 0;
    padding: 0 20px;
}

.section-header {
    text-align: center;
    margin-bottom: 40px;
}

.section-header h2 {
    font-size: 36px;
    font-weight: 800;
    color: #333;
}

.projects-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 30px;
    max-width: 1200px;
    margin: 0 auto;
}

.project-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    position: relative;
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
}

.project-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
}

.project-image {
    position: relative;
    height: 200px;
    background: #f0f0f0;
    overflow: hidden;
}

.project-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.project-card:hover .project-image img {
    transform: scale(1.1);
}

.project-category {
    position: absolute;
    top: 15px;
    left: 15px;
    background: rgba(255, 34, 0, 0.95);
    color: white;
    padding: 6px 16px;
    border-radius: 50px;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.project-content {
    padding: 30px;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.project-content h3 {
    font-size: 22px;
    font-weight: 700;
    margin-bottom: 15px;
    line-height: 1.4;
}

.project-content h3 a {
    color: #333;
    text-decoration: none;
    transition: color 0.3s ease;
}

.project-content h3 a:hover {
    color: #ff2200;
}

.project-content p {
    color: #666;
    font-size: 16px;
    line-height: 1.6;
    margin-bottom: 20px;
    flex: 1;
}

.project-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    color: #999;
    font-size: 14px;
}

.project-client,
.project-date {
    display: flex;
    align-items: center;
    gap: 8px;
}

.project-link {
    position: absolute;
    bottom: 20px;
    right: 20px;
    width: 40px;
    height: 40px;
    background: #ff2200;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    text-decoration: none;
    transition: all 0.3s ease;
}

.project-link:hover {
    transform: translateX(5px);
    background: #cc1b00;
}

.section-footer {
    text-align: center;
    margin-top: 50px;
}

.view-all-btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 15px 30px;
    background: white;
    color: #333;
    text-decoration: none;
    border-radius: 50px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
}

.view-all-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    color: #ff2200;
}

.view-all-btn i {
    transition: transform 0.3s ease;
}

.view-all-btn:hover i {
    transform: translateX(5px);
}

/* Responsive Design */
@media (max-width: 1024px) {
    .projects-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .section-header h2 {
        font-size: 30px;
    }
    
    .projects-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }
}

@media (max-width: 480px) {
    .related-projects {
        margin: 60px 0;
    }
    
    .project-content {
        padding: 20px;
    }
    
    .project-content h3 {
        font-size: 20px;
    }
    
    .project-footer {
        flex-direction: column;
        gap: 10px;
        align-items: flex-start;
    }
}
</style>