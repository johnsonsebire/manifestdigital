@props([
    'title' => 'What our clients say',
    'testimonials' => [],
    'animateOnScroll' => true,
    'autoPlay' => true
])

@php
$defaultTestimonials = [
    [
        'stars' => 5,
        'text' => 'I requested a website from Manifest Multimedia for the sale of my books and personal blogging. They did not only deliver in time but with excellence and professionalism. I am happy with their customer service, progress update, and pricing.',
        'author' => 'Mawuli Nyador',
        'position' => 'Author & Blogger, Ghana',
        'avatar' => null
    ],
    [
        'stars' => 5,
        'text' => 'Working with Manifest has been solid in quickly responding to challenges. They lead communicative project management with accessibility to several tools and channels like email and WhatsApp. Excellent customer care that quickly addresses needs.',
        'author' => 'Executive Director',
        'position' => 'Nondenominational Organization',
        'avatar' => null
    ],
    [
        'stars' => 5,
        'text' => 'After a successful launch, the website traffic increased by 50%. The team held weekly meetings for project updates, reviews, and feedback. Their professionalism and consistency made them valuable partners.',
        'author' => 'Richard Akita',
        'position' => 'Human Capacity Development Org',
        'avatar' => null
    ],
    [
        'stars' => 5,
        'text' => 'I love my website and I will totally recommend Manifest Multimedia. They are so professional, time efficient, helpful and precise. Thank you once again!',
        'author' => 'Pamela Ofori',
        'position' => 'Business Owner, UK',
        'avatar' => null
    ],
    [
        'stars' => 5,
        'text' => 'Working with Manifest for nearly 2 years and I like how they work with speed. Their works are neat with beautiful interfaces. Thanks for making our platforms what they are.',
        'author' => 'Kwame Baah',
        'position' => 'Yve Digital & Get The Artiste',
        'avatar' => null
    ],
    [
        'stars' => 5,
        'text' => 'Having worked with Manifest Ghana, I will recommend them to any client. They are professional, time-efficient and productivity is of a high standard. I am really impressed with their work.',
        'author' => 'Esther Yeboah',
        'position' => 'Jeer Care, UK',
        'avatar' => null
    ]
];

$testimonialsList = empty($testimonials) ? $defaultTestimonials : $testimonials;
@endphp

<section class="testimonials">
    <h2{{ $animateOnScroll ? ' class=animate-on-scroll' : '' }}>{{ $title }}</h2>
    
    <div class="testimonials-carousel{{ $animateOnScroll ? ' animate-on-scroll' : '' }}">
        <div class="carousel-container">
            <div class="carousel-track">
                @foreach($testimonialsList as $index => $testimonial)
                    <div class="testimonial-card{{ $index === 0 ? ' active' : '' }}">
                        <div class="testimonial-stars">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star{{ $i <= ($testimonial['stars'] ?? 5) ? '' : '-o' }}"></i>
                            @endfor
                        </div>
                        <p class="testimonial-text">"{{ $testimonial['text'] }}"</p>
                        <div class="testimonial-author">
                            <div class="author-avatar">
                                @if($testimonial['avatar'] ?? null)
                                    <img src="{{ asset($testimonial['avatar']) }}" alt="{{ $testimonial['author'] }}">
                                @else
                                    <i class="fas fa-user"></i>
                                @endif
                            </div>
                            <div class="author-info">
                                <h4>{{ $testimonial['author'] }}</h4>
                                <p>{{ $testimonial['position'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        
        <!-- Navigation Bullets -->
        <div class="carousel-dots">
            @foreach($testimonialsList as $index => $testimonial)
                <button class="dot{{ $index === 0 ? ' active' : '' }}" 
                        data-slide="{{ $index }}" 
                        aria-label="Go to testimonial {{ $index + 1 }}"></button>
            @endforeach
        </div>
    </div>
</section>