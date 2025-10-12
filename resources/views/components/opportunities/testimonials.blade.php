@props([
    'title' => 'Meet Our Amazing Team',
    'subtitle' => 'Hear from our talented team members about their journey, growth, and success stories at Manifest Digital.',
    'testimonials' => [
        [
            'name' => 'Sarah Kennedy',
            'role' => 'Senior Full-Stack Developer',
            'duration' => '3 Years at Manifest',
            'badge' => 'Team Lead',
            'gradient' => 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
            'quote' => 'Joining Manifest Digital was the best career decision I\'ve ever made. I started as a junior developer and have grown into a team lead position. The company truly invests in your growth - I\'ve attended 3 major conferences, earned 4 certifications, and led multiple high-impact projects. The supportive culture and cutting-edge technology stack make every day exciting.',
            'achievements' => [
                '2021: Junior Developer → Full-Stack Developer',
                '2022: Senior Developer → Project Lead',
                '2023: Team Lead → Mentoring Program'
            ]
        ],
        [
            'name' => 'Marcus Chen',
            'role' => 'Senior UI/UX Designer',
            'duration' => '2.5 Years at Manifest',
            'badge' => 'Design Lead',
            'gradient' => 'linear-gradient(135deg, #22c1c3 0%, #fdbb2d 100%)',
            'quote' => 'The creative freedom and collaborative environment at Manifest is unmatched. I\'ve worked on award-winning designs for Fortune 500 clients while building our internal design system. The team respects design thinking, and leadership actively seeks our input on strategic decisions. Plus, the flexible schedule lets me maintain my work-life balance perfectly.',
            'stats' => [
                ['number' => '2x', 'label' => 'Design Awards Winner'],
                ['number' => '15+', 'label' => 'Led Client Projects'],
                ['number' => '1', 'label' => 'Built Company Design System'],
                ['number' => '1', 'label' => 'UX Certification Completed']
            ]
        ],
        [
            'name' => 'Aisha Patel',
            'role' => 'Digital Marketing Manager',
            'duration' => '1.8 Years at Manifest',
            'badge' => 'Growth Specialist',
            'gradient' => 'linear-gradient(135deg, #feca57 0%, #ff6b6b 100%)',
            'quote' => 'As someone who transitioned from traditional marketing to digital, Manifest provided the perfect environment to learn and grow. The team embraced my fresh perspective while providing mentorship in areas I needed to develop. I\'ve launched successful campaigns that increased client engagement by 300% and built lasting partnerships with industry leaders.',
            'highlights' => [
                ['number' => '300%', 'label' => 'Engagement Increase'],
                ['number' => '12', 'label' => 'Successful Campaigns'],
                ['number' => '8', 'label' => 'Industry Partnerships']
            ]
        ],
        [
            'name' => 'David Rodriguez',
            'role' => 'Business Development Lead',
            'duration' => '4 Years at Manifest',
            'badge' => 'Senior Partner',
            'gradient' => 'linear-gradient(135deg, #2ecc71 0%, #27ae60 100%)',
            'quote' => 'What sets Manifest apart is the entrepreneurial spirit combined with genuine care for both clients and employees. I\'ve had the autonomy to develop innovative partnership strategies while being supported by brilliant technical teams. The profit-sharing and stock options show they truly value long-term commitment. This isn\'t just a job - it\'s building something meaningful together.',
            'contributions' => [
                '25+ Strategic Partnerships',
                '200% Revenue Growth',
                'Enterprise Client Acquisition',
                'International Market Entry'
            ]
        ]
    ]
])

<!-- Team Testimonials Section -->
<section class="team-testimonials py-5" style="background-color: #FFFCFA; position: relative; overflow: hidden;">
    <!-- Decorative Elements -->
    <img src="{{ asset('images/decorative/cta_left_mem_dots_f_circle2.svg') }}" alt="" class="position-absolute d-none d-lg-block" style="left: -35px; top: 10%; width: 70px; opacity: 0.5; animation: float 7s ease-in-out infinite; background: transparent !important;">
    <img src="{{ asset('images/decorative/hero_right_circle-con3.svg') }}" alt="" class="position-absolute d-none d-lg-block" style="right: -45px; top: 50%; width: 90px; opacity: 0.6; animation: float 9s ease-in-out infinite reverse; background: transparent !important;">
    
    <div class="container">
        <!-- Section Header -->
        <div class="row">
            <div class="col-lg-8 mx-auto text-center mb-5">
                <h2 class="display-5 fw-bold mb-4" style="color: #000;">{{ $title }}</h2>
                <p class="lead" style="color: #666; font-size: 1.25rem; line-height: 1.6;">{{ $subtitle }}</p>
            </div>
        </div>

        <!-- Testimonials Carousel -->
        <div id="testimonialsCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="8000">
            <div class="carousel-indicators" style="bottom: -50px;">
                @foreach($testimonials as $index => $testimonial)
                <button type="button" data-bs-target="#testimonialsCarousel" data-bs-slide-to="{{ $index }}" 
                        class="testimonial-indicator {{ $index === 0 ? 'active' : '' }}" 
                        aria-current="{{ $index === 0 ? 'true' : 'false' }}" 
                        aria-label="Slide {{ $index + 1 }}"></button>
                @endforeach
            </div>
            
            <div class="carousel-inner">
                @foreach($testimonials as $index => $testimonial)
                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                    <div class="row align-items-center">
                        <div class="col-lg-4 mb-4 mb-lg-0">
                            <div class="text-center">
                                <div class="testimonial-photo-container mx-auto mb-3" style="width: 200px; height: 200px;">
                                    <!-- Placeholder for team member photo -->
                                    <div class="rounded-circle shadow-lg overflow-hidden h-100" style="background: {{ $testimonial['gradient'] }}; display: flex; align-items: center; justify-content: center;">
                                        <div class="text-center text-white">
                                            <i class="fas fa-user fa-3x mb-2" style="opacity: 0.8;"></i>
                                            <div class="small fw-medium">{{ explode(' ', $testimonial['name'])[0] }} {{ substr(explode(' ', $testimonial['name'])[1] ?? '', 0, 1) }}.</div>
                                        </div>
                                    </div>
                                </div>
                                <h4 class="h5 fw-bold mb-1" style="color: #333;">{{ $testimonial['name'] }}</h4>
                                <p class="text-muted small mb-2">{{ $testimonial['role'] }}</p>
                                <div class="d-flex justify-content-center gap-2">
                                    <span class="badge rounded-pill" style="background: linear-gradient(135deg, #FF4900 0%, #FF6B35 100%); color: white; font-size: 0.7rem;">{{ $testimonial['duration'] }}</span>
                                    <span class="badge rounded-pill" style="background: {{ $testimonial['gradient'] }}; color: white; font-size: 0.7rem;">{{ $testimonial['badge'] }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="testimonial-content ps-lg-4">
                                <div class="position-relative">
                                    <i class="fas fa-quote-left testimonial-quote-left" style="color: #FF4900; opacity: 0.8; font-size: 1.8rem; position: absolute; top: 5px; left: 5px;"></i>
                                    <blockquote class="mb-4" style="font-size: 1.1rem; line-height: 1.7; color: #333; font-style: italic; position: relative; padding: 20px 30px 20px 15px;">
                                        {{ $testimonial['quote'] }}
                                    </blockquote>
                                    <i class="fas fa-quote-right testimonial-quote-right" style="color: #FF4900; opacity: 0.8; font-size: 1.8rem; position: absolute; bottom: 5px; right: 5px;"></i>
                                </div>
                                
                                @if(isset($testimonial['achievements']))
                                <div class="career-progression">
                                    <h5 class="h6 fw-bold mb-3" style="color: #FF4900;">Career Journey at Manifest:</h5>
                                    <div class="timeline-items">
                                        @foreach($testimonial['achievements'] as $achievement)
                                        <div class="timeline-item d-flex align-items-center mb-2">
                                            <div class="timeline-dot me-3" style="width: 10px; height: 10px; background: #FF4900; border-radius: 50%;"></div>
                                            <span class="small text-muted">{{ $achievement }}</span>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif

                                @if(isset($testimonial['stats']))
                                <div class="achievements">
                                    <h5 class="h6 fw-bold mb-3" style="color: #FF4900;">Key Achievements:</h5>
                                    <div class="row g-2">
                                        @foreach($testimonial['stats'] as $stat)
                                        <div class="col-sm-6">
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="fas fa-trophy text-warning me-2"></i>
                                                <span class="small text-muted">{{ $stat['number'] }} {{ $stat['label'] }}</span>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif

                                @if(isset($testimonial['highlights']))
                                <div class="results-highlights">
                                    <h5 class="h6 fw-bold mb-3" style="color: #FF4900;">Impact & Results:</h5>
                                    <div class="row g-3">
                                        @foreach($testimonial['highlights'] as $highlight)
                                        <div class="col-sm-4">
                                            <div class="text-center p-3 rounded-3" style="background: linear-gradient(135deg, rgba(254,202,87,0.1) 0%, rgba(255,107,107,0.1) 100%); border: 1px solid rgba(254,202,87,0.2);">
                                                <div class="h4 fw-bold mb-1" style="color: #ff6b6b;">{{ $highlight['number'] }}</div>
                                                <small class="text-muted">{{ $highlight['label'] }}</small>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif

                                @if(isset($testimonial['contributions']))
                                <div class="business-growth">
                                    <h5 class="h6 fw-bold mb-3" style="color: #FF4900;">Business Growth Contributions:</h5>
                                    <div class="row g-2">
                                        @foreach($testimonial['contributions'] as $contribution)
                                        <div class="col-sm-6">
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="fas fa-handshake text-success me-2"></i>
                                                <span class="small text-muted">{{ $contribution }}</span>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Carousel Controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#testimonialsCarousel" data-bs-slide="prev" style="left: -50px;">
                <div class="carousel-control-icon" style="background: linear-gradient(135deg, #FF4900 0%, #FF6B35 100%); border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-chevron-left text-white"></i>
                </div>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#testimonialsCarousel" data-bs-slide="next" style="right: -50px;">
                <div class="carousel-control-icon" style="background: linear-gradient(135deg, #FF4900 0%, #FF6B35 100%); border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-chevron-right text-white"></i>
                </div>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <!-- Team Statistics Footer -->
        <div class="row mt-5">
            <div class="col-lg-10 mx-auto">
                <div class="text-center p-4 rounded-3" style="background: linear-gradient(135deg, rgba(255,73,0,0.03) 0%, rgba(255,107,53,0.03) 100%); border: 1px solid rgba(255,73,0,0.1);">
                    <h3 class="h4 fw-bold mb-4" style="color: #FF4900;">Join Our Success Stories</h3>
                    <div class="row g-4">
                        <div class="col-md-3 col-sm-6">
                            <div class="text-center">
                                <div class="h3 fw-bold mb-2" style="color: #FF4900;">15+</div>
                                <p class="small mb-0" style="color: #666;">Team Members Promoted</p>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="text-center">
                                <div class="h3 fw-bold mb-2" style="color: #FF4900;">40+</div>
                                <p class="small mb-0" style="color: #666;">Certifications Earned</p>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="text-center">
                                <div class="h3 fw-bold mb-2" style="color: #FF4900;">8</div>
                                <p class="small mb-0" style="color: #666;">Industry Awards Won</p>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="text-center">
                                <div class="h3 fw-bold mb-2" style="color: #FF4900;">92%</div>
                                <p class="small mb-0" style="color: #666;">Employee Retention Rate</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>