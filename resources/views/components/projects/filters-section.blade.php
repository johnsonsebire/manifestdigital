<!-- Filters Section -->
<section class="projects-filters" x-data="projectFilters">
    <div class="filters-container">
        <!-- Desktop Scrollable Filters -->
        <div class="projects-filters-wrapper">
            <button class="projects-filters-nav projects-filters-nav-left" aria-label="Scroll filters left" :disabled="!canScrollLeft">
                <i class="fas fa-chevron-left" aria-hidden="true"></i>
            </button>
            <div class="projects-filters-container" x-ref="filterContainer" @scroll="updateScrollButtons">
                <div class="projects-filters-tabs">
                    <button 
                        class="filter-btn" 
                        :class="{ 'active': currentFilter === 'all' }"
                        @click="setFilter('all')" 
                        data-filter="all"
                    >All Projects</button>
                    <button 
                        class="filter-btn" 
                        :class="{ 'active': currentFilter === 'nonprofit' }"
                        @click="setFilter('nonprofit')" 
                        data-filter="nonprofit"
                    >Nonprofits</button>
                    <button 
                        class="filter-btn" 
                        :class="{ 'active': currentFilter === 'business' }"
                        @click="setFilter('business')" 
                        data-filter="business"
                    >Business</button>
                    <button 
                        class="filter-btn" 
                        :class="{ 'active': currentFilter === 'education' }"
                        @click="setFilter('education')" 
                        data-filter="education"
                    >Education</button>
                    <button 
                        class="filter-btn" 
                        :class="{ 'active': currentFilter === 'health' }"
                        @click="setFilter('health')" 
                        data-filter="health"
                    >Healthcare</button>
                    <button 
                        class="filter-btn" 
                        :class="{ 'active': currentFilter === 'tech' }"
                        @click="setFilter('tech')" 
                        data-filter="tech"
                    >Technology</button>
                </div>
            </div>
            <button class="projects-filters-nav projects-filters-nav-right" aria-label="Scroll filters right" :disabled="!canScrollRight">
                <i class="fas fa-chevron-right" aria-hidden="true"></i>
            </button>
        </div>
        
        <!-- Mobile Dropdown Alternative -->
        <div class="projects-filters-mobile-dropdown">
            <button 
                class="projects-dropdown-selected" 
                :aria-expanded="isDropdownOpen" 
                aria-haspopup="listbox" 
                role="combobox" 
                aria-labelledby="projects-dropdown-label"
                @click="toggleDropdown"
            >
                <span class="selected-text" x-text="getFilterLabel(currentFilter)"></span>
                <i class="fas fa-chevron-down dropdown-arrow" aria-hidden="true"></i>
            </button>
            <div 
                class="projects-dropdown-options" 
                role="listbox" 
                aria-labelledby="projects-dropdown-label"
                x-show="isDropdownOpen"
                @click.away="isDropdownOpen = false"
            >
                <template x-for="filter in filters" :key="filter.value">
                    <div 
                        class="projects-dropdown-option" 
                        :class="{ 'active': currentFilter === filter.value }"
                        role="option" 
                        :data-filter="filter.value" 
                        @click="selectFilter(filter.value)"
                        x-text="filter.label"
                    ></div>
                </template>
            </div>
        </div>
        
        <!-- Hidden label for accessibility -->
        <div id="projects-dropdown-label" class="sr-only">Select project category</div>
        
        <!-- Search Box -->
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input 
                type="text" 
                id="projectSearch" 
                placeholder="Search projects..."
                x-model="searchTerm"
                @input="handleSearch"
            >
        </div>
    </div>
</section>

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('projectFilters', () => ({
            currentFilter: 'all',
            searchTerm: '',
            isDropdownOpen: false,
            canScrollLeft: false,
            canScrollRight: true,
            filters: [
                { value: 'all', label: 'All Projects' },
                { value: 'nonprofit', label: 'Nonprofits' },
                { value: 'business', label: 'Business' },
                { value: 'education', label: 'Education' },
                { value: 'health', label: 'Healthcare' },
                { value: 'tech', label: 'Technology' }
            ],

            init() {
                this.$nextTick(() => {
                    this.updateScrollButtons();
                });

                window.addEventListener('resize', () => {
                    this.updateScrollButtons();
                });
            },

            setFilter(filter) {
                this.currentFilter = filter;
                this.isDropdownOpen = false;
                this.$dispatch('filter-changed', { filter, searchTerm: this.searchTerm });
            },

            handleSearch() {
                this.$dispatch('filter-changed', { 
                    filter: this.currentFilter, 
                    searchTerm: this.searchTerm 
                });
            },

            getFilterLabel(filterValue) {
                const filter = this.filters.find(f => f.value === filterValue);
                return filter ? filter.label : 'All Projects';
            },

            toggleDropdown() {
                this.isDropdownOpen = !this.isDropdownOpen;
            },

            selectFilter(filter) {
                this.setFilter(filter);
            },

            updateScrollButtons() {
                const container = this.$refs.filterContainer;
                if (container) {
                    this.canScrollLeft = container.scrollLeft > 0;
                    this.canScrollRight = container.scrollLeft < (container.scrollWidth - container.clientWidth - 1);
                }
            },

            scrollLeft() {
                const container = this.$refs.filterContainer;
                if (container) {
                    container.scrollBy({
                        left: -(container.clientWidth * 0.8),
                        behavior: 'smooth'
                    });
                }
            },

            scrollRight() {
                const container = this.$refs.filterContainer;
                if (container) {
                    container.scrollBy({
                        left: container.clientWidth * 0.8,
                        behavior: 'smooth'
                    });
                }
            }
        }));
    });
</script>
@endpush