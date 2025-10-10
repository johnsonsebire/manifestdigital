<!-- Projects Grid Section -->
<section class="projects-grid" x-data="projectsGrid" x-init="initGrid">
    <div class="container">
        <!-- Projects Grid -->
        <div class="projects-grid-container" x-ref="gridContainer">
            <template x-for="project in filteredProjects" :key="project.id">
                <div 
                    class="project-card" 
                    :class="project.category"
                    x-show="isVisible(project)"
                    x-transition:enter="fade-enter"
                    x-transition:enter-start="fade-enter-start"
                    x-transition:enter-end="fade-enter-end"
                >
                    <div class="project-image">
                        <img :src="project.image" :alt="project.title" loading="lazy">
                        <div class="project-overlay">
                            <a :href="'/projects/' + project.slug" class="project-link">
                                <i class="fas fa-link"></i>
                            </a>
                        </div>
                    </div>
                    <div class="project-content">
                        <h3 class="project-title" x-text="project.title"></h3>
                        <p class="project-category" x-text="getCategoryLabel(project.category)"></p>
                        <p class="project-description" x-text="project.description"></p>
                        <div class="project-tech-stack">
                            <template x-for="tech in project.technologies" :key="tech">
                                <span class="tech-tag" x-text="tech"></span>
                            </template>
                        </div>
                    </div>
                </div>
            </template>
        </div>
        
        <!-- Loading State -->
        <div class="loading-spinner" x-show="loading">
            <div class="spinner"></div>
            <p>Loading more projects...</p>
        </div>
        
        <!-- No Results Message -->
        <div class="no-results" x-show="filteredProjects.length === 0 && !loading">
            <i class="fas fa-search"></i>
            <h3>No projects found</h3>
            <p>Try adjusting your search or filter criteria</p>
        </div>
    </div>
</section>

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('projectsGrid', () => ({
            projects: [],
            filteredProjects: [],
            currentFilter: 'all',
            searchTerm: '',
            loading: false,
            page: 1,
            hasMore: true,
            observer: null,

            async init() {
                await this.loadProjects();
                this.setupInfiniteScroll();
                
                this.$watch('currentFilter', (value) => {
                    this.filterProjects();
                });
                
                this.$watch('searchTerm', (value) => {
                    this.filterProjects();
                });
                
                this.$on('filter-changed', ({ filter, searchTerm }) => {
                    this.currentFilter = filter;
                    this.searchTerm = searchTerm;
                });
            },

            async loadProjects() {
                if (!this.hasMore || this.loading) return;
                
                this.loading = true;
                try {
                    const response = await fetch(`/api/projects?page=${this.page}`);
                    const data = await response.json();
                    
                    if (data.projects.length === 0) {
                        this.hasMore = false;
                    } else {
                        this.projects = [...this.projects, ...data.projects];
                        this.filterProjects();
                        this.page++;
                    }
                } catch (error) {
                    console.error('Error loading projects:', error);
                } finally {
                    this.loading = false;
                }
            },

            setupInfiniteScroll() {
                const options = {
                    root: null,
                    rootMargin: '0px',
                    threshold: 0.1
                };

                this.observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            this.loadProjects();
                        }
                    });
                }, options);

                // Observe the last project card
                this.$watch('filteredProjects', () => {
                    this.$nextTick(() => {
                        const lastCard = this.$refs.gridContainer.lastElementChild;
                        if (lastCard) {
                            this.observer.observe(lastCard);
                        }
                    });
                });
            },

            filterProjects() {
                let filtered = this.projects;

                // Apply category filter
                if (this.currentFilter !== 'all') {
                    filtered = filtered.filter(project => 
                        project.category === this.currentFilter
                    );
                }

                // Apply search filter
                if (this.searchTerm) {
                    const searchLower = this.searchTerm.toLowerCase();
                    filtered = filtered.filter(project =>
                        project.title.toLowerCase().includes(searchLower) ||
                        project.description.toLowerCase().includes(searchLower) ||
                        project.technologies.some(tech => 
                            tech.toLowerCase().includes(searchLower)
                        )
                    );
                }

                this.filteredProjects = filtered;
            },

            isVisible(project) {
                if (this.currentFilter === 'all') return true;
                return project.category === this.currentFilter;
            },

            getCategoryLabel(category) {
                const labels = {
                    'nonprofit': 'Nonprofit',
                    'business': 'Business',
                    'education': 'Education',
                    'health': 'Healthcare',
                    'tech': 'Technology'
                };
                return labels[category] || category;
            }
        }));
    });
</script>
@endpush