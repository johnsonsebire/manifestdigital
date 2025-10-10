/**
 * Infinite Projects Scroll
 * Handles infinite scrolling functionality for projects grid
 */
class InfiniteProjectsScroll {
    constructor(options = {}) {
        this.options = {
            gridContainer: '#projectsGrid',
            loadingIndicator: '#infiniteScrollLoading',
            errorContainer: '#infiniteScrollError',
            endContent: '#endOfContent',
            noResults: '#noResults',
            scrollTrigger: '#scrollTrigger',
            ...options
        };

        this.dataManager = new ProjectsDataManager();
        this.init();
    }

    init() {
        this.grid = document.querySelector(this.options.gridContainer);
        this.loadingIndicator = document.querySelector(this.options.loadingIndicator);
        this.errorContainer = document.querySelector(this.options.errorContainer);
        this.endContent = document.querySelector(this.options.endContent);
        this.noResults = document.querySelector(this.options.noResults);
        this.scrollTrigger = document.querySelector(this.options.scrollTrigger);

        this.setupIntersectionObserver();
        this.bindEvents();
        this.loadInitialProjects();
    }

    setupIntersectionObserver() {
        this.observer = new IntersectionObserver(
            (entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        this.loadMoreProjects();
                    }
                });
            },
            {
                root: null,
                rootMargin: '100px',
                threshold: 0.1
            }
        );

        if (this.scrollTrigger) {
            this.observer.observe(this.scrollTrigger);
        }
    }

    bindEvents() {
        // Handle retry button click
        const retryButton = document.querySelector('#retryLoadMore');
        if (retryButton) {
            retryButton.addEventListener('click', () => {
                this.hideError();
                this.loadMoreProjects();
            });
        }

        // Listen for filter changes
        document.addEventListener('projectsFiltered', (e) => {
            this.handleFilterChange(e.detail);
        });
    }

    async loadInitialProjects() {
        this.showLoading();
        try {
            const projects = await this.dataManager.loadNextPage();
            this.renderProjects(projects, true);
        } catch (error) {
            this.showError();
        }
    }

    async loadMoreProjects() {
        if (this.dataManager.loading || !this.dataManager.hasMore) return;

        this.showLoading();
        try {
            const projects = await this.dataManager.loadNextPage();
            this.renderProjects(projects);
        } catch (error) {
            this.showError();
        }
    }

    renderProjects(projects, replace = false) {
        this.hideLoading();

        if (!projects || projects.length === 0) {
            if (replace) {
                this.showNoResults();
            } else {
                this.showEndContent();
            }
            return;
        }

        if (replace) {
            this.grid.innerHTML = '';
        }

        const fragment = document.createDocumentFragment();

        projects.forEach(project => {
            const card = this.createProjectCard(project);
            fragment.appendChild(card);
        });

        this.grid.appendChild(fragment);

        // Show end content if no more projects
        if (!this.dataManager.hasMore) {
            this.showEndContent();
        }
    }

    createProjectCard(project) {
        const card = document.createElement('div');
        card.className = 'project-card';
        card.innerHTML = `
            <img src="${project.image}" alt="${project.title}" loading="lazy">
            <div class="project-card-content">
                <span class="project-category">${project.category}</span>
                <h3>${project.title}</h3>
                <a href="${project.link}" class="project-link">
                    View Project
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        `;
        return card;
    }

    handleFilterChange(filterData) {
        this.dataManager.setFilter(filterData.category);
        this.dataManager.setSearch(filterData.searchTerm);
        
        this.hideEndContent();
        this.hideError();
        this.loadInitialProjects();
    }

    showLoading() {
        if (this.loadingIndicator) {
            this.loadingIndicator.style.display = 'flex';
        }
    }

    hideLoading() {
        if (this.loadingIndicator) {
            this.loadingIndicator.style.display = 'none';
        }
    }

    showError() {
        this.hideLoading();
        if (this.errorContainer) {
            this.errorContainer.style.display = 'flex';
        }
    }

    hideError() {
        if (this.errorContainer) {
            this.errorContainer.style.display = 'none';
        }
    }

    showEndContent() {
        this.hideLoading();
        if (this.endContent) {
            this.endContent.style.display = 'flex';
        }
    }

    hideEndContent() {
        if (this.endContent) {
            this.endContent.style.display = 'none';
        }
    }

    showNoResults() {
        this.hideLoading();
        this.hideEndContent();
        if (this.noResults) {
            this.noResults.style.display = 'block';
        }
    }

    hideNoResults() {
        if (this.noResults) {
            this.noResults.style.display = 'none';
        }
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    window.infiniteProjectsScroll = new InfiniteProjectsScroll();
});