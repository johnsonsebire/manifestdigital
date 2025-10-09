@props([
    'category' => 'AI & Machine Learning',
    'title' => 'How AI is Transforming Business Operations in Ghana',
    'excerpt' => 'Discover how Ghanaian businesses are leveraging artificial intelligence and machine learning to automate processes, reduce costs by up to 70%, and deliver exceptional customer experiences 24/7.',
    'image' => null,
    'date' => null,
    'readingTime' => null,
    'url' => '#',
    'badge' => 'Featured'
])

<article {{ $attributes->merge(['class' => 'featured-article']) }} data-category="{{ Str::slug($category) }}">
    <div class="featured-content">
        <div class="featured-image">
            @if($badge)
                <div class="featured-badge">{{ $badge }}</div>
            @endif
            @if($image)
                <img src="{{ asset($image) }}" alt="{{ $title }}">
            @endif
        </div>
        <div class="featured-text">
            <div class="featured-category">{{ $category }}</div>
            <h3>{{ $title }}</h3>
            <p>{{ $excerpt }}</p>
            
            <div class="article-meta">
                @if($date)
                    <span>
                        <i class="fas fa-calendar"></i>
                        {{ $date }}
                    </span>
                @endif
                @if($readingTime)
                    <span>
                        <i class="fas fa-clock"></i>
                        {{ $readingTime }} min read
                    </span>
                @endif
            </div>
            
            <a href="{{ $url }}" class="read-more-btn">
                Read Full Article
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</article>

<style>
.featured-article {
    margin-bottom: 60px;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 20px;
    overflow: hidden;
    transition: all 0.3s ease;
    position: relative;
}

.featured-article:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
}

.featured-content {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0;
}

.featured-image {
    position: relative;
    overflow: hidden;
    min-height: 400px;
}

.featured-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.featured-article:hover .featured-image img {
    transform: scale(1.1);
}

.featured-badge {
    position: absolute;
    top: 20px;
    left: 20px;
    background: #ff2200;
    color: white;
    padding: 8px 20px;
    border-radius: 50px;
    font-weight: 700;
    font-size: 14px;
    z-index: 2;
}

.featured-text {
    padding: 60px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.featured-category {
    color: #ff2200;
    font-weight: 700;
    font-size: 14px;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 15px;
}

.featured-text h3 {
    font-size: 36px;
    font-weight: 800;
    margin-bottom: 20px;
    color: #1a1a1a;
    line-height: 1.3;
}

.featured-text p {
    font-size: 18px;
    color: #666;
    margin-bottom: 25px;
    line-height: 1.7;
}

.article-meta {
    display: flex;
    align-items: center;
    gap: 20px;
    margin-bottom: 25px;
    font-size: 15px;
    color: #999;
}

.article-meta span {
    display: flex;
    align-items: center;
    gap: 8px;
}

.article-meta i {
    color: #ff2200;
}

.read-more-btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: #ff2200;
    color: white;
    padding: 14px 32px;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 700;
    transition: all 0.3s ease;
    align-self: flex-start;
}

.read-more-btn:hover {
    background: #cc1b00;
    color: white;
    transform: translateX(5px);
}

@media (max-width: 992px) {
    .featured-content {
        grid-template-columns: 1fr;
    }

    .featured-text {
        padding: 40px;
    }

    .featured-text h3 {
        font-size: 28px;
    }
}

@media (max-width: 768px) {
    .featured-text {
        padding: 30px;
    }

    .featured-text h3 {
        font-size: 24px;
    }

    .featured-text p {
        font-size: 16px;
    }
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

.featured-article {
    animation: fadeInUp 0.6s ease-out;
}
</style>