@props([
    'category' => null,
    'title' => '',
    'excerpt' => '',
    'image' => null,
    'author' => [
        'name' => '',
        'avatar' => null,
        'initials' => null
    ],
    'readingTime' => null,
    'url' => '#'
])

<article {{ $attributes->merge(['class' => 'blog-card']) }} data-category="{{ Str::slug($category) }}">
    <div class="blog-card-image">
        @if($category)
            <div class="card-category-badge">{{ $category }}</div>
        @endif
        @if($image)
            <img src="{{ asset($image) }}" alt="{{ $title }}">
        @endif
    </div>
    
    <div class="blog-card-content">
        <h3>
            <a href="{{ $url }}">{{ $title }}</a>
        </h3>
        
        <p class="blog-card-excerpt">{{ $excerpt }}</p>
        
        <div class="blog-card-footer">
            <div class="author-info">
                @if($author['avatar'])
                    <img class="author-avatar" src="{{ asset($author['avatar']) }}" alt="{{ $author['name'] }}">
                @elseif($author['initials'])
                    <div class="author-avatar">{{ $author['initials'] }}</div>
                @endif
                <span>{{ $author['name'] }}</span>
            </div>
            
            @if($readingTime)
                <div class="reading-time">
                    <i class="fas fa-clock"></i>
                    <span>{{ $readingTime }} min</span>
                </div>
            @endif
        </div>
    </div>
</article>

<style>
.blog-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
    display: flex;
    flex-direction: column;
}

.blog-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
}

.blog-card-image {
    position: relative;
    overflow: hidden;
    height: 250px;
    background: #f0f0f0;
}

.blog-card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.blog-card:hover .blog-card-image img {
    transform: scale(1.1);
}

.card-category-badge {
    position: absolute;
    top: 15px;
    left: 15px;
    background: rgba(255, 34, 0, 0.95);
    color: white;
    padding: 6px 16px;
    border-radius: 50px;
    font-weight: 700;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.blog-card-content {
    padding: 30px;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.blog-card-content h3 {
    font-size: 22px;
    font-weight: 800;
    margin-bottom: 15px;
    color: #1a1a1a;
    line-height: 1.4;
}

.blog-card-content h3 a {
    color: inherit;
    text-decoration: none;
    transition: color 0.3s ease;
}

.blog-card-content h3 a:hover {
    color: #ff2200;
}

.blog-card-excerpt {
    color: #666;
    font-size: 16px;
    line-height: 1.6;
    margin-bottom: 20px;
    flex: 1;
}

.blog-card-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 20px;
    border-top: 1px solid #eee;
    font-size: 14px;
    color: #999;
}

.author-info {
    display: flex;
    align-items: center;
    gap: 10px;
}

.author-avatar {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    background: linear-gradient(135deg, #ff2200, #ff6b00);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 700;
    font-size: 14px;
    overflow: hidden;
}

.author-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.reading-time {
    display: flex;
    align-items: center;
    gap: 5px;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.blog-card {
    animation: fadeInUp 0.6s ease-out;
}
</style>