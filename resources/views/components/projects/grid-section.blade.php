<!-- Projects Grid Section -->
<section class="projects-grid-section" x-data="projectsGrid">
    <!-- Projects Grid -->
    <div class="projects-grid" x-ref="gridContainer" x-show="filteredProjects.length > 0">
        <template x-for="project in filteredProjects" :key="project.id">
            <div 
                class="project-card" 
                :data-category="project.category"
                :data-id="project.id"
                x-show="isVisible(project)"
                x-transition:enter="fade-enter"
                x-transition:enter-start="fade-enter-start"
                x-transition:enter-end="fade-enter-end"
            >
                <img :src="project.image" :alt="project.title" loading="lazy">
                <div class="project-card-content">
                    <span class="project-category" x-text="project.displayCategory"></span>
                    <h3 x-text="project.title"></h3>
                    <a :href="project.url" class="project-link" target="_blank" rel="noopener noreferrer" @click.stop>
                        <span>Visit Website</span>
                        <i class="fa-solid fa-up-right-from-square"></i>
                    </a>
                </div>
            </div>
        </template>
    </div>
    
    <!-- Scroll Trigger for Infinite Scroll -->
    <div x-ref="scrollTrigger" x-show="hasMore && !loading" style="height: 1px;"></div>
    
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
                
                // Set up watchers BEFORE loading projects
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
                
                // Load initial projects
                try {
                    console.log('📡 Loading initial projects...');
                    await this.loadProjects();
                    console.log('✅ Initial projects loaded:', this.projects.length);
                    console.log('✅ Filtered projects:', this.filteredProjects.length);
                } catch (error) {
                    console.error('❌ Error loading initial projects:', error);
                }
                
                this.setupInfiniteScroll();
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
                        this.hasMore = data.hasMore; // Update hasMore from API response
                        this.filterProjects();
                        this.page++;
                        console.log('📄 Next page will be:', this.page, '| Has more:', this.hasMore);
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
                console.log('🔄 Setting up infinite scroll');
                const options = {
                    root: null,
                    rootMargin: '200px', // Trigger 200px before reaching the element
                    threshold: 0.1
                };

                this.observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting && !this.loading && this.hasMore) {
                            console.log('📍 Scroll trigger intersected, loading more projects...');
                            this.loadProjects();
                        }
                    });
                }, options);

                // Wait for the scroll trigger element to be available
                this.$nextTick(() => {
                    const trigger = this.$refs.scrollTrigger;
                    if (trigger) {
                        console.log('✅ Observing scroll trigger element');
                        this.observer.observe(trigger);
                    } else {
                        console.warn('⚠️ Scroll trigger element not found');
                    }
                });
            },

            filterProjects() {
                console.log('🔧 Filtering projects. Total:', this.projects.length, 'Filter:', this.currentFilter);
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
                        (project.excerpt && project.excerpt.toLowerCase().includes(searchLower))
                    );
                }

                this.filteredProjects = filtered;
                console.log('✅ Filtered results:', this.filteredProjects.length);
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