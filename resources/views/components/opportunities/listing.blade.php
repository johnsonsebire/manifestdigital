@props([
    'title' => 'Current Opportunities',
    'subtitle' => 'Explore exciting career opportunities and find the perfect role to grow your career with us.',
    'opportunities' => [
        [
            'id' => 'senior-full-stack-dev',
            'title' => 'Senior Full-Stack Developer',
            'department' => 'Engineering',
            'location' => 'Remote / San Francisco',
            'type' => 'Full-time',
            'experience' => 'Senior Level',
            'salary' => '$120,000 - $160,000',
            'tags' => ['Laravel', 'React', 'AWS', 'PostgreSQL'],
            'featured' => true,
            'urgent' => false,
            'posted_date' => '2024-01-15',
            'description' => 'Lead the development of complex web applications using Laravel and React. Mentor junior developers and drive technical architecture decisions.',
            'requirements' => [
                '5+ years of full-stack development experience',
                'Expert proficiency in Laravel and PHP 8+',
                'Strong React and TypeScript skills',
                'Experience with AWS cloud services',
                'Knowledge of PostgreSQL and Redis',
                'Experience leading technical teams'
            ],
            'benefits' => [
                'Competitive salary with equity options',
                'Comprehensive health insurance',
                'Flexible remote work policy',
                '$5,000 annual learning budget',
                '4 weeks paid vacation'
            ]
        ],
        [
            'id' => 'ui-ux-designer',
            'title' => 'Senior UI/UX Designer',
            'department' => 'Design',
            'location' => 'Remote / New York',
            'type' => 'Full-time',
            'experience' => 'Senior Level',
            'salary' => '$90,000 - $130,000',
            'tags' => ['Figma', 'Design Systems', 'User Research', 'Prototyping'],
            'featured' => true,
            'urgent' => true,
            'posted_date' => '2024-01-20',
            'description' => 'Create exceptional user experiences and drive design strategy across our product portfolio. Lead user research and build scalable design systems.',
            'requirements' => [
                '4+ years of UX/UI design experience',
                'Expert proficiency in Figma and design tools',
                'Strong portfolio demonstrating user-centered design',
                'Experience with design systems and component libraries',
                'Knowledge of user research methodologies',
                'Experience collaborating with development teams'
            ],
            'benefits' => [
                'Design conference attendance budget',
                'Latest design tools and equipment',
                'Flexible work arrangements',
                'Health and wellness stipend',
                'Stock options program'
            ]
        ],
        [
            'id' => 'frontend-developer',
            'title' => 'Frontend Developer',
            'department' => 'Engineering',
            'location' => 'Remote',
            'type' => 'Full-time',
            'experience' => 'Mid Level',
            'salary' => '$80,000 - $110,000',
            'tags' => ['React', 'TypeScript', 'Tailwind CSS', 'Next.js'],
            'featured' => false,
            'urgent' => false,
            'posted_date' => '2024-01-18',
            'description' => 'Build beautiful, responsive user interfaces and contribute to our component library. Work closely with designers to implement pixel-perfect designs.',
            'requirements' => [
                '3+ years of frontend development experience',
                'Strong React and TypeScript skills',
                'Experience with modern CSS frameworks',
                'Knowledge of responsive design principles',
                'Experience with Git and agile workflows',
                'Understanding of web performance optimization'
            ],
            'benefits' => [
                'Professional development budget',
                'Remote-first culture',
                'Flexible working hours',
                'Health insurance coverage',
                'Annual team retreat'
            ]
        ],
        [
            'id' => 'devops-engineer',
            'title' => 'DevOps Engineer',
            'department' => 'Engineering',
            'location' => 'Remote / Austin',
            'type' => 'Full-time',
            'experience' => 'Senior Level',
            'salary' => '$110,000 - $150,000',
            'tags' => ['AWS', 'Docker', 'Kubernetes', 'Terraform'],
            'featured' => false,
            'urgent' => true,
            'posted_date' => '2024-01-22',
            'description' => 'Build and maintain scalable infrastructure and deployment pipelines. Ensure high availability and security of our production systems.',
            'requirements' => [
                '4+ years of DevOps/Infrastructure experience',
                'Expert knowledge of AWS services',
                'Experience with containerization and orchestration',
                'Proficiency in Infrastructure as Code (Terraform)',
                'Strong scripting skills (Python, Bash)',
                'Experience with monitoring and logging tools'
            ],
            'benefits' => [
                'Certification reimbursement program',
                'Home office setup budget',
                'Performance bonuses',
                'Comprehensive benefits package',
                'Professional mentorship program'
            ]
        ],
        [
            'id' => 'marketing-manager',
            'title' => 'Digital Marketing Manager',
            'department' => 'Marketing',
            'location' => 'Remote / Los Angeles',
            'type' => 'Full-time',
            'experience' => 'Mid Level',
            'salary' => '$70,000 - $95,000',
            'tags' => ['SEO', 'Content Marketing', 'Analytics', 'Social Media'],
            'featured' => false,
            'urgent' => false,
            'posted_date' => '2024-01-16',
            'description' => 'Drive digital marketing strategy and execution across multiple channels. Analyze performance metrics and optimize campaigns for maximum ROI.',
            'requirements' => [
                '3+ years of digital marketing experience',
                'Strong knowledge of SEO and content marketing',
                'Experience with Google Analytics and marketing tools',
                'Social media marketing expertise',
                'Data-driven approach to campaign optimization',
                'Excellent written and verbal communication skills'
            ],
            'benefits' => [
                'Marketing tools and software budget',
                'Conference and workshop attendance',
                'Flexible work schedule',
                'Health and dental insurance',
                'Performance-based bonuses'
            ]
        ],
        [
            'id' => 'data-scientist',
            'title' => 'Data Scientist',
            'department' => 'Analytics',
            'location' => 'Remote / Seattle',
            'type' => 'Full-time',
            'experience' => 'Senior Level',
            'salary' => '$130,000 - $170,000',
            'tags' => ['Python', 'Machine Learning', 'SQL', 'TensorFlow'],
            'featured' => true,
            'urgent' => false,
            'posted_date' => '2024-01-14',
            'description' => 'Build machine learning models and data pipelines to drive business insights. Work with large datasets and develop predictive analytics solutions.',
            'requirements' => [
                '4+ years of data science experience',
                'Strong Python and SQL skills',
                'Experience with ML frameworks (TensorFlow, PyTorch)',
                'Knowledge of statistical analysis and modeling',
                'Experience with big data technologies',
                'Strong communication and visualization skills'
            ],
            'benefits' => [
                'Research and development budget',
                'Access to high-performance computing resources',
                'Conference presentation opportunities',
                'Equity participation program',
                'Continuing education support'
            ]
        ]
    ]
])

<!-- Current Opportunities Section -->
<section class="current-opportunities py-5" style="background-color: #fff; position: relative;">
    <!-- Section Header -->
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center mb-5">
                <h2 class="display-5 fw-bold mb-4" style="color: #000;">{{ $title }}</h2>
                <p class="lead" style="color: #666; font-size: 1.25rem; line-height: 1.6;">{{ $subtitle }}</p>
            </div>
        </div>

        <!-- Filters and Search -->
        <div class="row mb-5">
            <div class="col-lg-10 mx-auto">
                <div class="opportunities-filters card border-0 shadow-sm p-4">
                    <div class="row g-3 align-items-end">
                        <!-- Search Input -->
                        <div class="col-md-4">
                            <label for="job-search" class="form-label fw-medium" style="color: #333;">Search Positions</label>
                            <div class="input-group">
                                <span class="input-group-text border-end-0" style="background: #f8f9fa; border-color: #dee2e6;">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" class="form-control border-start-0" id="job-search" placeholder="Job title, skills, keywords..." style="border-color: #dee2e6;">
                            </div>
                        </div>
                        
                        <!-- Department Filter -->
                        <div class="col-md-3">
                            <label for="department-filter" class="form-label fw-medium" style="color: #333;">Department</label>
                            <select class="form-select" id="department-filter" style="border-color: #dee2e6;">
                                <option value="">All Departments</option>
                                <option value="Engineering">Engineering</option>
                                <option value="Design">Design</option>
                                <option value="Marketing">Marketing</option>
                                <option value="Analytics">Analytics</option>
                            </select>
                        </div>
                        
                        <!-- Experience Filter -->
                        <div class="col-md-3">
                            <label for="experience-filter" class="form-label fw-medium" style="color: #333;">Experience Level</label>
                            <select class="form-select" id="experience-filter" style="border-color: #dee2e6;">
                                <option value="">All Levels</option>
                                <option value="Junior Level">Junior Level</option>
                                <option value="Mid Level">Mid Level</option>
                                <option value="Senior Level">Senior Level</option>
                            </select>
                        </div>
                        
                        <!-- Location Filter -->
                        <div class="col-md-2">
                            <label for="location-filter" class="form-label fw-medium" style="color: #333;">Location</label>
                            <select class="form-select" id="location-filter" style="border-color: #dee2e6;">
                                <option value="">All Locations</option>
                                <option value="Remote">Remote</option>
                                <option value="San Francisco">San Francisco</option>
                                <option value="New York">New York</option>
                                <option value="Austin">Austin</option>
                                <option value="Los Angeles">Los Angeles</option>
                                <option value="Seattle">Seattle</option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Quick Filters -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex flex-wrap gap-2">
                                <span class="text-muted small fw-medium me-3">Quick filters:</span>
                                <button type="button" class="btn btn-outline-primary btn-sm quick-filter" data-filter="featured">
                                    <i class="fas fa-star me-1"></i>Featured
                                </button>
                                <button type="button" class="btn btn-outline-danger btn-sm quick-filter" data-filter="urgent">
                                    <i class="fas fa-clock me-1"></i>Urgent Hiring
                                </button>
                                <button type="button" class="btn btn-outline-success btn-sm quick-filter" data-filter="remote">
                                    <i class="fas fa-home me-1"></i>Remote Only
                                </button>
                                <button type="button" class="btn btn-outline-secondary btn-sm" id="clear-filters">
                                    <i class="fas fa-times me-1"></i>Clear All
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Jobs Listing -->
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div id="jobs-container" class="jobs-container">
                    @foreach($opportunities as $job)
                    <div class="job-card card border-0 shadow-sm mb-4 position-relative" 
                         data-job-id="{{ $job['id'] }}"
                         data-department="{{ $job['department'] }}"
                         data-experience="{{ $job['experience'] }}"
                         data-location="{{ $job['location'] }}"
                         data-tags="{{ implode(',', $job['tags']) }}"
                         data-featured="{{ $job['featured'] ? 'true' : 'false' }}"
                         data-urgent="{{ $job['urgent'] ? 'true' : 'false' }}">
                        
                        @if($job['featured'])
                        <div class="featured-ribbon position-absolute" style="top: 15px; right: 15px; z-index: 10;">
                            <span class="badge" style="background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%); color: #000; font-size: 0.7rem; padding: 5px 10px;">
                                <i class="fas fa-star me-1"></i>Featured
                            </span>
                        </div>
                        @endif
                        
                        @if($job['urgent'])
                        <div class="urgent-ribbon position-absolute" style="top: {{ $job['featured'] ? '45px' : '15px' }}; right: 15px; z-index: 10;">
                            <span class="badge bg-danger" style="font-size: 0.7rem; padding: 5px 10px; animation: pulse 2s infinite;">
                                <i class="fas fa-clock me-1"></i>Urgent
                            </span>
                        </div>
                        @endif
                        
                        <div class="card-body p-4">
                            <div class="row align-items-start">
                                <div class="col-lg-8">
                                    <!-- Job Header -->
                                    <div class="mb-3">
                                        <h3 class="h4 fw-bold mb-2" style="color: #333;">{{ $job['title'] }}</h3>
                                        <div class="job-meta d-flex flex-wrap gap-3 text-muted small">
                                            <span><i class="fas fa-building me-1"></i>{{ $job['department'] }}</span>
                                            <span><i class="fas fa-map-marker-alt me-1"></i>{{ $job['location'] }}</span>
                                            <span><i class="fas fa-briefcase me-1"></i>{{ $job['type'] }}</span>
                                            <span><i class="fas fa-chart-line me-1"></i>{{ $job['experience'] }}</span>
                                        </div>
                                    </div>
                                    
                                    <!-- Job Description -->
                                    <p class="text-muted mb-3" style="line-height: 1.6;">{{ $job['description'] }}</p>
                                    
                                    <!-- Skills Tags -->
                                    <div class="skills-tags mb-3">
                                        <div class="d-flex flex-wrap gap-2">
                                            @foreach($job['tags'] as $tag)
                                            <span class="badge rounded-pill" style="background: linear-gradient(135deg, rgba(255,73,0,0.1) 0%, rgba(255,107,53,0.1) 100%); color: #FF4900; border: 1px solid rgba(255,73,0,0.2); font-weight: 500;">{{ $tag }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                    
                                    <!-- Posted Date -->
                                    <div class="posted-date">
                                        <small class="text-muted">
                                            <i class="far fa-calendar-alt me-1"></i>
                                            Posted {{ \Carbon\Carbon::parse($job['posted_date'])->diffForHumans() }}
                                        </small>
                                    </div>
                                </div>
                                
                                <div class="col-lg-4">
                                    <div class="text-lg-end">
                                        <!-- Salary -->
                                        <div class="salary mb-3">
                                            <div class="h5 fw-bold mb-1" style="color: #28a745;">{{ $job['salary'] }}</div>
                                            <small class="text-muted">Annual Salary</small>
                                        </div>
                                        
                                        <!-- Action Buttons -->
                                        <div class="action-buttons d-flex flex-column gap-2">
                                            <button type="button" class="btn btn-primary view-details-btn" 
                                                    data-job-id="{{ $job['id'] }}"
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#jobDetailsModal"
                                                    style="background: linear-gradient(135deg, #FF4900 0%, #FF6B35 100%); border: none;">
                                                <i class="fas fa-eye me-2"></i>View Details
                                            </button>
                                            <button type="button" class="btn btn-outline-primary apply-now-btn" 
                                                    data-job-id="{{ $job['id'] }}"
                                                    data-job-title="{{ $job['title'] }}">
                                                <i class="fas fa-paper-plane me-2"></i>Apply Now
                                            </button>
                                        </div>
                                        
                                        <!-- Save Job -->
                                        <div class="save-job mt-2">
                                            <button type="button" class="btn btn-link btn-sm save-job-btn p-0" 
                                                    data-job-id="{{ $job['id'] }}"
                                                    style="color: #666; text-decoration: none;">
                                                <i class="far fa-heart me-1"></i>Save Job
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- No Results Message -->
                <div id="no-results" class="text-center py-5" style="display: none;">
                    <div class="mb-4">
                        <i class="fas fa-search fa-3x text-muted"></i>
                    </div>
                    <h4 class="h5 mb-3" style="color: #666;">No positions found matching your criteria</h4>
                    <p class="text-muted mb-4">Try adjusting your filters or search terms to find more opportunities.</p>
                    <button type="button" class="btn btn-outline-primary" id="clear-all-filters">
                        <i class="fas fa-refresh me-2"></i>Clear All Filters
                    </button>
                </div>
                
                <!-- Load More -->
                <div class="text-center mt-5" id="load-more-container">
                    <button type="button" class="btn btn-outline-primary btn-lg" id="load-more-jobs">
                        <i class="fas fa-plus me-2"></i>Load More Positions
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Inline Styles for Animations -->
<style>
@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

.job-card {
    transition: all 0.3s ease;
    border-left: 4px solid transparent !important;
}

.job-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15) !important;
    border-left-color: #FF4900 !important;
}

.job-card[data-featured="true"] {
    border-left-color: #FFD700 !important;
    background: linear-gradient(135deg, rgba(255,215,0,0.02) 0%, rgba(255,165,0,0.02) 100%);
}

.job-card[data-urgent="true"] {
    border-left-color: #dc3545 !important;
}

.quick-filter.active {
    background-color: #FF4900 !important;
    border-color: #FF4900 !important;
    color: white !important;
}

.save-job-btn.saved {
    color: #FF4900 !important;
}

.save-job-btn.saved i {
    transform: scale(1.2);
}

.fade-in {
    animation: fadeIn 0.5s ease-in;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>