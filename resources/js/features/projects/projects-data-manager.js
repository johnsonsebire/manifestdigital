/**
 * Projects Data Manager
 * Handles data fetching, caching, and manipulation for projects
 */
class ProjectsDataManager {
    constructor() {
        this.cache = new Map();
        this.currentPage = 1;
        this.itemsPerPage = 9;
        this.loading = false;
        this.hasMore = true;
        this.currentFilter = 'all';
        this.searchTerm = '';
    }

    async fetchProjects(page, filter = 'all', search = '') {
        const cacheKey = `${page}-${filter}-${search}`;

        // Check cache first
        if (this.cache.has(cacheKey)) {
            return this.cache.get(cacheKey);
        }

        try {
            const response = await fetch(`/api/projects?page=${page}&filter=${filter}&search=${search}`);
            if (!response.ok) throw new Error('Network response was not ok');

            const data = await response.json();
            
            // Cache the results
            this.cache.set(cacheKey, data);
            
            return data;
        } catch (error) {
            console.error('Error fetching projects:', error);
            throw error;
        }
    }

    clearCache() {
        this.cache.clear();
    }

    resetPagination() {
        this.currentPage = 1;
        this.hasMore = true;
    }

    setFilter(filter) {
        this.currentFilter = filter;
        this.resetPagination();
        this.clearCache();
    }

    setSearch(term) {
        this.searchTerm = term;
        this.resetPagination();
        this.clearCache();
    }

    async loadNextPage() {
        if (this.loading || !this.hasMore) return null;

        this.loading = true;

        try {
            const data = await this.fetchProjects(
                this.currentPage,
                this.currentFilter,
                this.searchTerm
            );

            this.currentPage++;
            this.hasMore = data.hasMore;
            this.loading = false;

            return data.projects;
        } catch (error) {
            this.loading = false;
            throw error;
        }
    }
}

// Export for external use
window.ProjectsDataManager = ProjectsDataManager;