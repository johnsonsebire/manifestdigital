@props([
    'articles' => []
])

<div class="blog-grid-container">
    <div class="blog-grid" x-data="{ filterCategory: '' }">
        @foreach($articles as $article)
            <x-blog.card 
                :category="$article['category']"
                :title="$article['title']"
                :excerpt="$article['excerpt']"
                :image="$article['image']"
                :author="$article['author']"
                :reading-time="$article['readingTime']"
                :url="$article['url']"
                x-show="filterCategory === '' || '{{ Str::slug($article['category']) }}' === filterCategory"
                x-transition:enter="fade-enter"
                x-transition:enter-start="fade-enter-start"
                x-transition:enter-end="fade-enter-end"
                x-transition:leave="fade-leave"
                x-transition:leave-start="fade-leave-start"
                x-transition:leave-end="fade-leave-end"
            />
        @endforeach
    </div>
    
    @if(empty($articles))
        <div class="no-articles">
            <i class="fas fa-newspaper"></i>
            <h3>No articles found</h3>
            <p>Check back later for new content</p>
        </div>
    @endif
</div>

<style>
.blog-grid-container {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.blog-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 30px;
    margin: 50px 0;
}

.no-articles {
    text-align: center;
    padding: 100px 0;
    color: #666;
}

.no-articles i {
    font-size: 48px;
    color: #ddd;
    margin-bottom: 20px;
}

.no-articles h3 {
    font-size: 24px;
    font-weight: 700;
    margin-bottom: 10px;
    color: #333;
}

.no-articles p {
    font-size: 16px;
}

/* Transitions */
.fade-enter {
    transition: all 0.3s ease-out;
}

.fade-enter-start {
    opacity: 0;
    transform: scale(0.9);
}

.fade-enter-end {
    opacity: 1;
    transform: scale(1);
}

.fade-leave {
    transition: all 0.3s ease-in;
}

.fade-leave-start {
    opacity: 1;
    transform: scale(1);
}

.fade-leave-end {
    opacity: 0;
    transform: scale(0.9);
}

/* Responsive Design */
@media (max-width: 768px) {
    .blog-grid {
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
    }
}

@media (max-width: 480px) {
    .blog-grid {
        grid-template-columns: 1fr;
    }
    
    .blog-grid-container {
        padding: 0 15px;
    }
}
</style>