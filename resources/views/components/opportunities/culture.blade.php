@props([
    'title' => 'Life at Manifest Digital',
    'subtitle' => 'We\'re more than just a team – we\'re a family of innovators, creators, and problem-solvers passionate about building digital experiences that matter.',
    'values' => [
        [
            'icon' => 'fas fa-lightbulb',
            'title' => 'Innovation First',
            'description' => 'We embrace cutting-edge technologies and creative solutions to solve complex challenges.'
        ],
        [
            'icon' => 'fas fa-users',
            'title' => 'Team Collaboration',
            'description' => 'We believe great ideas come from diverse perspectives working together seamlessly.'
        ],
        [
            'icon' => 'fas fa-chart-line',
            'title' => 'Continuous Growth',
            'description' => 'We invest in our team\'s professional development and encourage learning at every step.'
        ],
        [
            'icon' => 'fas fa-balance-scale',
            'title' => 'Work-Life Balance',
            'description' => 'We prioritize well-being and maintain healthy boundaries for sustainable success.'
        ]
    ],
    'benefits' => [
        [
            'icon' => 'fas fa-heartbeat',
            'title' => 'Health & Wellness',
            'gradient' => 'linear-gradient(135deg, #22c1c3 0%, #fdbb2d 100%)',
            'items' => [
                '100% Health Insurance Coverage',
                'Mental Health Support',
                'Wellness Stipend ($500/year)',
                'Gym Membership Reimbursement',
                'Annual Health Check-ups'
            ]
        ],
        [
            'icon' => 'fas fa-user-graduate',
            'title' => 'Professional Growth',
            'gradient' => 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
            'items' => [
                '$2,000 Learning Budget',
                'Conference Attendance',
                'Certification Reimbursement',
                'Mentorship Programs',
                'Skill Development Time'
            ]
        ],
        [
            'icon' => 'fas fa-calendar-check',
            'title' => 'Time & Flexibility',
            'gradient' => 'linear-gradient(135deg, #FF4900 0%, #FF6B35 100%)',
            'items' => [
                '25 Days Paid Time Off',
                'Flexible Working Hours',
                'Remote Work Options',
                'Personal Development Days',
                'Sabbatical Opportunities'
            ]
        ],
        [
            'icon' => 'fas fa-piggy-bank',
            'title' => 'Financial Security',
            'gradient' => 'linear-gradient(135deg, #2ecc71 0%, #27ae60 100%)',
            'items' => [
                'Competitive Salary',
                'Performance Bonuses',
                'Pension Contribution',
                'Stock Options',
                'Profit Sharing'
            ]
        ],
        [
            'icon' => 'fas fa-laptop-code',
            'title' => 'Tech & Tools',
            'gradient' => 'linear-gradient(135deg, #74ebd5 0%, #acb6e5 100%)',
            'items' => [
                'MacBook Pro/PC Setup',
                'Premium Software Licenses',
                'Home Office Stipend',
                'Latest Development Tools',
                '24/7 Tech Support'
            ]
        ],
        [
            'icon' => 'fas fa-users-cog',
            'title' => 'Team Culture',
            'gradient' => 'linear-gradient(135deg, #feca57 0%, #ff6b6b 100%)',
            'items' => [
                'Team Building Events',
                'Quarterly Offsites',
                'Innovation Fridays',
                'Open Communication',
                'Diversity & Inclusion'
            ]
        ]
    ]
])

<!-- Life at Manifest Digital Section -->
<section id="culture" class="life-at-manifest py-5 position-relative" style="background-color: #FFFCFA; overflow: hidden;">
    <!-- Decorative Elements -->
    <img src="{{ asset('images/decorative/hero_left_mem_dots_f_circle3.svg') }}" alt="" class="position-absolute d-none d-lg-block" style="left: -30px; top: 20%; width: 60px; opacity: 0.6; animation: float 6s ease-in-out infinite; background: transparent !important;" loading="lazy">
    <img src="{{ asset('images/decorative/how_it_works_mem_dots_f_circle2.svg') }}" alt="" class="position-absolute d-none d-lg-block" style="right: -40px; top: 60%; width: 80px; opacity: 0.7; animation: float 8s ease-in-out infinite reverse; background: transparent !important;" loading="lazy">
    
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center mb-5">
                <h2 class="display-5 fw-bold mb-4 life-at-manifest" style="color: #000;">{{ $title }}</h2>
                <p class="lead" style="color: #666; font-size: 1.25rem; line-height: 1.6;">{{ $subtitle }}</p>
            </div>
        </div>

        <!-- Company Values Grid -->
        <div class="row g-4 mb-5">
            @foreach($values as $value)
            <div class="col-md-6 col-lg-3">
                <div class="text-center h-100 p-4 rounded-3 life-value-card" style="background: linear-gradient(135deg, rgba(255,73,0,0.05) 0%, rgba(255,107,53,0.05) 100%); border: 1px solid rgba(255,73,0,0.1); transition: all 0.3s ease;">
                    <div class="mb-3">
                        <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center" style="width: 70px; height: 70px; background: linear-gradient(135deg, #FF4900 0%, #FF6B35 100%);">
                            <i class="{{ $value['icon'] }} fa-lg text-white"></i>
                        </div>
                    </div>
                    <h4 class="h5 fw-bold mb-3" style="color: #FF4900;">{{ $value['title'] }}</h4>
                    <p class="small mb-0" style="color: #666; line-height: 1.5;">{{ $value['description'] }}</p>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Work Environment Highlights -->
        <div class="row align-items-center mb-5">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <h3 class="h2 fw-bold mb-4" style="color: #333;">Our Work Environment</h3>
                <div class="row g-3">
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center mb-3">
                            <div class="rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: linear-gradient(135deg, #FF4900 0%, #FF6B35 100%);">
                                <i class="fas fa-home fa-sm text-white"></i>
                            </div>
                            <div>
                                <h5 class="mb-1 h6 fw-bold" style="color: #333;">Remote Friendly</h5>
                                <small style="color: #666;">Flexible work arrangements</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center mb-3">
                            <div class="rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: linear-gradient(135deg, #FF4900 0%, #FF6B35 100%);">
                                <i class="fas fa-clock fa-sm text-white"></i>
                            </div>
                            <div>
                                <h5 class="mb-1 h6 fw-bold" style="color: #333;">Flexible Hours</h5>
                                <small style="color: #666;">Work when you're most productive</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center mb-3">
                            <div class="rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: linear-gradient(135deg, #FF4900 0%, #FF6B35 100%);">
                                <i class="fas fa-graduation-cap fa-sm text-white"></i>
                            </div>
                            <div>
                                <h5 class="mb-1 h6 fw-bold" style="color: #333;">Learning Budget</h5>
                                <small style="color: #666;">Annual professional development fund</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center mb-3">
                            <div class="rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: linear-gradient(135deg, #FF4900 0%, #FF6B35 100%);">
                                <i class="fas fa-heart fa-sm text-white"></i>
                            </div>
                            <div>
                                <h5 class="mb-1 h6 fw-bold" style="color: #333;">Health & Wellness</h5>
                                <small style="color: #666;">Comprehensive benefits package</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="position-relative">
                    <!-- Placeholder for team photo -->
                    <div class="rounded-3 shadow-lg overflow-hidden" style="height: 300px; background: linear-gradient(135deg, #FF4900 0%, #FF6B35 100%); display: flex; align-items: center; justify-content: center;">
                        <div class="text-center text-white">
                            <i class="fas fa-camera fa-3x mb-3" style="opacity: 0.7;"></i>
                            <p class="mb-0 fw-medium">Team Collaboration Photo</p>
                            <small style="opacity: 0.8;">Coming Soon</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Benefits Package -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="text-center mb-5">
                    <h3 class="h2 fw-bold mb-3 benefits-section" style="color: #333;">Beyond Just a Job - Complete Benefits Package</h3>
                    <p class="lead text-muted mb-0">We invest in your success, well-being, and professional growth</p>
                </div>
                
                <!-- Benefits Grid -->
                <div class="row g-4 mb-5">
                    @foreach($benefits as $benefit)
                    <div class="col-lg-4 col-md-6">
                        <div class="h-100 p-4 rounded-3 text-center benefits-card" style="background: {{ str_replace('#', 'rgba(', $benefit['gradient']) }}{{ str_replace(')', ', 0.05)', str_replace('100%', '100%', $benefit['gradient'])) }}; border: 1px solid {{ str_replace('#', 'rgba(', $benefit['gradient']) }}{{ str_replace(')', ', 0.1)', str_replace('100%', '100%', $benefit['gradient'])) }}; transition: all 0.3s ease;">
                            <div class="mb-3">
                                <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background: {{ $benefit['gradient'] }};">
                                    <i class="{{ $benefit['icon'] }} fa-lg text-white"></i>
                                </div>
                            </div>
                            <h4 class="h5 fw-bold mb-3" style="color: {{ explode(' ', str_replace('linear-gradient(135deg, ', '', $benefit['gradient']))[0] }};">{{ $benefit['title'] }}</h4>
                            <ul class="list-unstyled small text-muted text-start">
                                @foreach($benefit['items'] as $item)
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>{{ $item }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Team Statistics -->
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="text-center p-4 rounded-3" style="background: linear-gradient(135deg, rgba(255,73,0,0.03) 0%, rgba(255,107,53,0.03) 100%); border: 1px solid rgba(255,73,0,0.1);">
                    <h3 class="h4 fw-bold mb-4" style="color: #FF4900;">Why Our Team Loves It Here</h3>
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="text-center">
                                <div class="h2 fw-bold mb-2" style="color: #FF4900;">95%</div>
                                <p class="small mb-0" style="color: #666;">Team Satisfaction Rate</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center">
                                <div class="h2 fw-bold mb-2" style="color: #FF4900;">3.2</div>
                                <p class="small mb-0" style="color: #666;">Average Years Experience</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center">
                                <div class="h2 fw-bold mb-2" style="color: #FF4900;">15+</div>
                                <p class="small mb-0" style="color: #666;">Professional Certifications</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>