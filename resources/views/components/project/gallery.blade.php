@props([
    'images' => [],
    'title' => ''
])

<div class="project-gallery" x-data="{
    activeImage: 0,
    isLightboxOpen: false,
    totalImages: {{ count($images) }},
    
    nextImage() {
        this.activeImage = (this.activeImage + 1) % this.totalImages;
    },
    
    prevImage() {
        this.activeImage = (this.activeImage - 1 + this.totalImages) % this.totalImages;
    },
    
    openLightbox(index) {
        this.activeImage = index;
        this.isLightboxOpen = true;
        document.body.style.overflow = 'hidden';
    },
    
    closeLightbox() {
        this.isLightboxOpen = false;
        document.body.style.overflow = '';
    }
}" @keydown.escape="closeLightbox">
    
    {{-- Thumbnail Grid --}}
    <div class="gallery-grid">
        @foreach($images as $index => $image)
            <div class="gallery-item" 
                @click="openLightbox({{ $index }})"
                :class="{ 'featured': $index === 0 }">
                <img src="{{ asset($image['thumbnail']) }}" 
                     alt="{{ $image['caption'] ?? $title . ' - Image ' . ($index + 1) }}"
                     loading="{{ $index === 0 ? 'eager' : 'lazy' }}">
                @if($image['caption'])
                    <div class="gallery-caption">{{ $image['caption'] }}</div>
                @endif
            </div>
        @endforeach
    </div>

    {{-- Lightbox --}}
    <div x-show="isLightboxOpen" 
         x-transition.opacity 
         class="lightbox" 
         @click.self="closeLightbox">
        
        <button class="lightbox-close" @click="closeLightbox">
            <i class="fas fa-times"></i>
        </button>
        
        <button class="lightbox-nav prev" @click="prevImage">
            <i class="fas fa-chevron-left"></i>
        </button>
        
        <div class="lightbox-content">
            <template x-for="(image, index) in {{ json_encode($images) }}" :key="index">
                <div x-show="activeImage === index" 
                     x-transition:enter="fade-enter"
                     x-transition:enter-start="fade-enter-start"
                     x-transition:enter-end="fade-enter-end"
                     class="lightbox-slide">
                    <img :src="image.full" :alt="image.caption || '{{ $title }} - Image ' + (index + 1)">
                    <div x-show="image.caption" class="lightbox-caption" x-text="image.caption"></div>
                </div>
            </template>
            
            <div class="lightbox-counter">
                <span x-text="activeImage + 1"></span>
                <span>/</span>
                <span x-text="totalImages"></span>
            </div>
        </div>
        
        <button class="lightbox-nav next" @click="nextImage">
            <i class="fas fa-chevron-right"></i>
        </button>
    </div>
</div>

<style>
.project-gallery {
    margin: 40px 0;
}

.gallery-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
}

.gallery-item {
    position: relative;
    border-radius: 15px;
    overflow: hidden;
    cursor: pointer;
    aspect-ratio: 4/3;
}

.gallery-item.featured {
    grid-column: span 2;
    grid-row: span 2;
}

.gallery-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.gallery-item:hover img {
    transform: scale(1.05);
}

.gallery-caption {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
    color: white;
    padding: 20px 15px 15px;
    font-size: 14px;
    opacity: 0;
    transform: translateY(20px);
    transition: all 0.3s ease;
}

.gallery-item:hover .gallery-caption {
    opacity: 1;
    transform: translateY(0);
}

.lightbox {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.9);
    z-index: 1000;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px;
}

.lightbox-content {
    position: relative;
    max-width: 90vw;
    max-height: 90vh;
}

.lightbox-slide {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.lightbox-slide img {
    max-width: 100%;
    max-height: 80vh;
    object-fit: contain;
}

.lightbox-caption {
    color: white;
    text-align: center;
    padding: 20px;
    max-width: 600px;
}

.lightbox-close {
    position: absolute;
    top: 20px;
    right: 20px;
    background: none;
    border: none;
    color: white;
    font-size: 24px;
    cursor: pointer;
    z-index: 1001;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: all 0.3s ease;
}

.lightbox-close:hover {
    background: rgba(255,255,255,0.1);
}

.lightbox-nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: white;
    font-size: 24px;
    cursor: pointer;
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: all 0.3s ease;
    background: rgba(0,0,0,0.5);
}

.lightbox-nav:hover {
    background: rgba(0,0,0,0.8);
}

.lightbox-nav.prev {
    left: 20px;
}

.lightbox-nav.next {
    right: 20px;
}

.lightbox-counter {
    position: absolute;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    color: white;
    font-size: 14px;
    background: rgba(0,0,0,0.5);
    padding: 5px 15px;
    border-radius: 20px;
}

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

/* Responsive Design */
@media (max-width: 1024px) {
    .gallery-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .gallery-grid {
        gap: 15px;
    }
    
    .lightbox {
        padding: 20px;
    }
    
    .lightbox-nav {
        width: 40px;
        height: 40px;
        font-size: 20px;
    }
}

@media (max-width: 480px) {
    .gallery-grid {
        grid-template-columns: 1fr;
    }
    
    .gallery-item.featured {
        grid-column: span 1;
        grid-row: span 1;
    }
    
    .lightbox-nav {
        display: none;
    }
}
</style>