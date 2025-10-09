@props([
    'categories' => [
        ['id' => 'all', 'name' => 'All Articles'],
        ['id' => 'web-development', 'name' => 'Web Development'],
        ['id' => 'ai-ml', 'name' => 'AI & ML'],
        ['id' => 'digital-strategy', 'name' => 'Digital Strategy'],
        ['id' => 'case-studies', 'name' => 'Case Studies'],
        ['id' => 'tutorials', 'name' => 'Tutorials']
    ],
    'activeCategory' => 'all',
    'searchPlaceholder' => 'Search articles...'
])

<section class="blog-filters"
    x-data="{
        activeCategory: @js($activeCategory),
        searchQuery: '',
        
        filterArticles() {
            this.$dispatch('filter-articles', {
                category: this.activeCategory,
                search: this.searchQuery
            });
        }
    }"
>
    <div class="filters-container">
        <div class="filter-buttons">
            @foreach($categories as $category)
                <button 
                    class="filter-btn"
                    :class="{ 'active': activeCategory === '{{ $category['id'] }}' }"
                    @click="activeCategory = '{{ $category['id'] }}'; filterArticles()"
                >
                    {{ $category['name'] }}
                </button>
            @endforeach
        </div>
        
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input 
                type="text" 
                x-model="searchQuery"
                @input.debounce.300ms="filterArticles()"
                placeholder="{{ $searchPlaceholder }}"
            >
        </div>
    </div>
</section>

<style>
.blog-filters {
    padding: 40px 0;
    background: white;
    border-bottom: 1px solid #eee;
    position: sticky;
    top: 0;
    z-index: 100;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}

.filters-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px;
}

.filter-buttons {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
}

.filter-btn {
    padding: 10px 24px;
    background: transparent;
    border: 2px solid #ddd;
    border-radius: 50px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    color: #333;
    font-size: 15px;
}

.filter-btn:hover,
.filter-btn.active {
    background: #ff2200;
    border-color: #ff2200;
    color: white;
    transform: translateY(-2px);
}

.search-box {
    position: relative;
}

.search-box input {
    padding: 10px 20px 10px 45px;
    border: 2px solid #ddd;
    border-radius: 50px;
    width: 300px;
    font-size: 16px;
    transition: border-color 0.3s ease;
}

.search-box input:focus {
    outline: none;
    border-color: #ff2200;
}

.search-box i {
    position: absolute;
    left: 18px;
    top: 50%;
    transform: translateY(-50%);
    color: #999;
}

@media (max-width: 768px) {
    .filters-container {
        flex-direction: column;
        align-items: stretch;
    }

    .filter-buttons {
        justify-content: center;
    }

    .search-box input {
        width: 100%;
    }
}
</style>