<!-- Projects Grid Section -->
<section class="projects-grid-section" x-data="projectsGrid">
    <!-- Projects Grid -->
    <div class="projects-grid" x-ref="gridContainer" x-show="filteredProjects.length > 0">
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
                console.log('🚀 Projects Grid initialized');
                try {
                    console.log('📡 Loading initial projects...');
                    await this.loadProjects();
                    console.log('✅ Initial projects loaded:', this.projects.length);
                } catch (error) {
                    console.error('❌ Error loading initial projects:', error);
                }
                this.setupInfiniteScroll();
                
                this.$watch('currentFilter', (value) => {
                    console.log('🔍 Filter changed:', value);
                    this.filterProjects();
                });
                
                this.$watch('searchTerm', (value) => {
                    console.log('🔎 Search term changed:', value);
                    this.filterProjects();
                });
                
                window.addEventListener('filter-changed', (event) => {
                    console.log('🎯 Filter event received:', event.detail);
                    this.currentFilter = event.detail.filter;
                    this.searchTerm = event.detail.searchTerm;
                });
            },

            async loadProjects() {
                if (!this.hasMore || this.loading) {
                    console.log('⏭️ Skipping load - hasMore:', this.hasMore, 'loading:', this.loading);
                    return;
                }
                
                this.loading = true;
                console.log('📥 Fetching projects - Page:', this.page);
                
                try {
                    const url = `/api/projects?page=${this.page}`;
                    console.log('🌐 API URL:', url);
                    
                    const response = await fetch(url);
                    console.log('📊 Response status:', response.status);
                    
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    
                    const data = await response.json();
                    console.log('📦 Data received:', data);
                    
                    if (data.projects.length === 0) {
                        console.log('🏁 No more projects to load');
                        this.hasMore = false;
                    } else {
                        this.projects = [...this.projects, ...data.projects];
                        console.log('✨ Projects updated. Total:', this.projects.length);
                        this.filterProjects();
                        this.page++;
                    }
                } catch (error) {
                    console.error('💥 Error loading projects:', error);
                    console.error('Error details:', error.message);
                } finally {
                    this.loading = false;
                    console.log('🔄 Loading state reset');
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