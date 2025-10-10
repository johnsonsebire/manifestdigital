<!-- Stats Section -->
<section class="projects-stats" x-data="projectStats">
    <div class="container">
        <div class="stats-grid">
            <div class="stats-card">
                <div class="stats-icon">
                    <i class="fas fa-briefcase"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-number">
                        <span x-text="completedProjects"></span>+
                    </h3>
                    <p class="stats-label">Projects Completed</p>
                </div>
            </div>

            <div class="stats-card">
                <div class="stats-icon">
                    <i class="fas fa-smile"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-number">
                        <span x-text="satisfiedClients"></span>%
                    </h3>
                    <p class="stats-label">Client Satisfaction</p>
                </div>
            </div>

            <div class="stats-card">
                <div class="stats-icon">
                    <i class="fas fa-code-branch"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-number">
                        <span x-text="technologies"></span>+
                    </h3>
                    <p class="stats-label">Technologies Used</p>
                </div>
            </div>

            <div class="stats-card">
                <div class="stats-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-number">
                        <span x-text="yearsExperience"></span>+
                    </h3>
                    <p class="stats-label">Years Experience</p>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('projectStats', () => ({
            completedProjects: 0,
            satisfiedClients: 0,
            technologies: 0,
            yearsExperience: 0,
            targetStats: {
                completedProjects: 800,
                satisfiedClients: 100,
                technologies: 25,
                yearsExperience: 10
            },

            init() {
                this.animateNumbers();
            },

            animateNumbers() {
                const duration = 2000; // Animation duration in milliseconds
                const steps = 60; // Number of steps in the animation
                const interval = duration / steps;

                Object.keys(this.targetStats).forEach(stat => {
                    const target = this.targetStats[stat];
                    const increment = target / steps;
                    let current = 0;
                    let step = 0;

                    const timer = setInterval(() => {
                        step++;
                        current = Math.ceil(increment * step);

                        if (step >= steps || current >= target) {
                            this[stat] = target;
                            clearInterval(timer);
                        } else {
                            this[stat] = current;
                        }
                    }, interval);
                });
            }
        }));
    });
</script>
@endpush

@push('styles')
<style>
    .projects-stats {
        padding: 4rem 0;
        background-color: var(--section-bg);
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
        text-align: center;
    }

    .stats-card {
        padding: 2rem;
        background: var(--card-bg);
        border-radius: var(--border-radius);
        box-shadow: var(--card-shadow);
        transition: transform 0.3s ease;
    }

    .stats-card:hover {
        transform: translateY(-5px);
    }

    .stats-icon {
        font-size: 2.5rem;
        color: var(--primary-color);
        margin-bottom: 1rem;
    }

    .stats-number {
        font-size: 2.5rem;
        font-weight: bold;
        color: var(--heading-color);
        margin-bottom: 0.5rem;
    }

    .stats-label {
        font-size: 1.1rem;
        color: var(--text-color);
    }

    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 480px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush