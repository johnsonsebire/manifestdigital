<!-- Open Opportunities Section -->
<section id="open-positions" class="opportunities-listing py-5" style="background-color: #FFFCFA;">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center mb-5">
                <h2 class="display-5 fw-bold mb-4" style="color: #000;">Open Opportunities</h2>
                <p class="lead" style="color: #666; font-size: 1.25rem; line-height: 1.6;">
                    Join our team and help us build the future of digital experiences. 
                    We're looking for passionate individuals who share our vision.
                </p>
            </div>
        </div>

        <!-- Search and Filter Controls -->
        <div class="row mb-5">
            <div class="col-lg-8 mx-auto">
                <div class="search-filter-container p-4 rounded-3" style="background: white; border: 1px solid rgba(255,73,0,0.1); box-shadow: 0 2px 10px rgba(255,73,0,0.05);">
                    <div class="row g-3 align-items-end">
                        <!-- Search Input -->
                        <div class="col-md-6">
                            <label for="jobSearch" class="form-label small fw-bold" style="color: #333;">Search Positions</label>
                            <div class="position-relative">
                                <input type="text" id="jobSearch" class="form-control form-control-lg" placeholder="Search by title, skills, or keywords..." 
                                       style="border: 2px solid #e9ecef; border-radius: 12px; padding-left: 50px; transition: all 0.3s ease;">
                                <i class="fas fa-search position-absolute text-muted" style="left: 18px; top: 50%; transform: translateY(-50%);"></i>
                            </div>
                        </div>

                        <!-- Department Filter -->
                        <div class="col-md-3">
                            <label for="departmentFilter" class="form-label small fw-bold" style="color: #333;">Department</label>
                            <select id="departmentFilter" class="form-select form-select-lg" style="border: 2px solid #e9ecef; border-radius: 12px;">
                                <option value="">All Departments</option>
                                <option value="engineering">Engineering</option>
                                <option value="design">Design</option>
                                <option value="marketing">Marketing</option>
                                <option value="sales">Sales</option>
                                <option value="operations">Operations</option>
                            </select>
                        </div>

                        <!-- Location Filter -->
                        <div class="col-md-3">
                            <label for="locationFilter" class="form-label small fw-bold" style="color: #333;">Location</label>
                            <select id="locationFilter" class="form-select form-select-lg" style="border: 2px solid #e9ecef; border-radius: 12px;">
                                <option value="">All Locations</option>
                                <option value="remote">Remote</option>
                                <option value="hybrid">Hybrid</option>
                                <option value="on-site">On-site</option>
                            </select>
                        </div>
                    </div>

                    <!-- Active Filters Display -->
                    <div id="activeFilters" class="mt-3" style="display: none;">
                        <div class="d-flex align-items-center flex-wrap gap-2">
                            <small class="text-muted me-2">Active filters:</small>
                            <div id="filterTags" class="d-flex flex-wrap gap-2"></div>
                            <button type="button" id="clearFilters" class="btn btn-link btn-sm text-danger p-0 ms-2" style="text-decoration: none;">
                                <i class="fas fa-times-circle me-1"></i>Clear all
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Results Summary -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div id="resultsCount" class="text-muted">
                        <span class="fw-bold" style="color: #FF4900;">12</span> open positions found
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <small class="text-muted">Sort by:</small>
                        <select id="sortBy" class="form-select form-select-sm" style="width: auto; border: 1px solid #dee2e6;">
                            <option value="newest">Newest First</option>
                            <option value="title">Job Title</option>
                            <option value="department">Department</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Job Listings Grid -->
        <div class="row g-4" id="jobListings">
            <!-- Senior Full Stack Developer -->
            <div class="col-lg-6 job-card" data-department="engineering" data-location="remote" data-title="Senior Full Stack Developer" data-skills="javascript react laravel php mysql">
                <div class="h-100 p-4 rounded-3 job-opportunity-card" style="background: white; border: 1px solid rgba(255,73,0,0.1); transition: all 0.3s ease; cursor: pointer;">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="flex-grow-1">
                            <h3 class="h5 fw-bold mb-2 job-title" style="color: #333;">Senior Full Stack Developer</h3>
                            <div class="d-flex flex-wrap gap-2 mb-2">
                                <span class="badge bg-light text-dark small">Engineering</span>
                                <span class="badge bg-success small">Remote</span>
                                <span class="badge bg-primary small">Full-time</span>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="small text-muted">Posted 2 days ago</div>
                            <div class="small fw-bold" style="color: #FF4900;">$80k - $120k</div>
                        </div>
                    </div>
                    
                    <p class="text-muted mb-3 job-description">
                        Join our engineering team to build scalable web applications using modern technologies. 
                        You'll work on exciting projects that impact thousands of users daily.
                    </p>
                    
                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">Key Skills:</small>
                        <div class="d-flex flex-wrap gap-1">
                            <span class="badge bg-light text-dark small">JavaScript</span>
                            <span class="badge bg-light text-dark small">React</span>
                            <span class="badge bg-light text-dark small">Laravel</span>
                            <span class="badge bg-light text-dark small">PHP</span>
                            <span class="badge bg-light text-dark small">MySQL</span>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="small text-muted">
                            <i class="fas fa-map-marker-alt me-1"></i>
                            Remote • Full-time
                        </div>
                        <button class="btn btn-sm btn-outline-primary rounded-pill job-apply-btn" data-job-id="senior-fullstack">
                            <i class="fas fa-paper-plane me-1"></i>
                            Apply Now
                        </button>
                    </div>
                </div>
            </div>

            <!-- UX/UI Designer -->
            <div class="col-lg-6 job-card" data-department="design" data-location="hybrid" data-title="UX/UI Designer" data-skills="figma adobe sketch prototyping">
                <div class="h-100 p-4 rounded-3 job-opportunity-card" style="background: white; border: 1px solid rgba(255,73,0,0.1); transition: all 0.3s ease; cursor: pointer;">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="flex-grow-1">
                            <h3 class="h5 fw-bold mb-2 job-title" style="color: #333;">UX/UI Designer</h3>
                            <div class="d-flex flex-wrap gap-2 mb-2">
                                <span class="badge bg-light text-dark small">Design</span>
                                <span class="badge bg-warning small">Hybrid</span>
                                <span class="badge bg-primary small">Full-time</span>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="small text-muted">Posted 1 week ago</div>
                            <div class="small fw-bold" style="color: #FF4900;">$65k - $90k</div>
                        </div>
                    </div>
                    
                    <p class="text-muted mb-3 job-description">
                        Create intuitive and beautiful user experiences for our digital products. 
                        Collaborate with cross-functional teams to deliver exceptional design solutions.
                    </p>
                    
                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">Key Skills:</small>
                        <div class="d-flex flex-wrap gap-1">
                            <span class="badge bg-light text-dark small">Figma</span>
                            <span class="badge bg-light text-dark small">Adobe Creative</span>
                            <span class="badge bg-light text-dark small">Sketch</span>
                            <span class="badge bg-light text-dark small">Prototyping</span>
                            <span class="badge bg-light text-dark small">User Research</span>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="small text-muted">
                            <i class="fas fa-map-marker-alt me-1"></i>
                            London • Hybrid
                        </div>
                        <button class="btn btn-sm btn-outline-primary rounded-pill job-apply-btn" data-job-id="ux-ui-designer">
                            <i class="fas fa-paper-plane me-1"></i>
                            Apply Now
                        </button>
                    </div>
                </div>
            </div>

            <!-- DevOps Engineer -->
            <div class="col-lg-6 job-card" data-department="engineering" data-location="remote" data-title="DevOps Engineer" data-skills="aws docker kubernetes terraform">
                <div class="h-100 p-4 rounded-3 job-opportunity-card" style="background: white; border: 1px solid rgba(255,73,0,0.1); transition: all 0.3s ease; cursor: pointer;">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="flex-grow-1">
                            <h3 class="h5 fw-bold mb-2 job-title" style="color: #333;">DevOps Engineer</h3>
                            <div class="d-flex flex-wrap gap-2 mb-2">
                                <span class="badge bg-light text-dark small">Engineering</span>
                                <span class="badge bg-success small">Remote</span>
                                <span class="badge bg-primary small">Full-time</span>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="small text-muted">Posted 3 days ago</div>
                            <div class="small fw-bold" style="color: #FF4900;">$85k - $130k</div>
                        </div>
                    </div>
                    
                    <p class="text-muted mb-3 job-description">
                        Build and maintain our cloud infrastructure. Implement CI/CD pipelines and 
                        ensure our applications run smoothly at scale.
                    </p>
                    
                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">Key Skills:</small>
                        <div class="d-flex flex-wrap gap-1">
                            <span class="badge bg-light text-dark small">AWS</span>
                            <span class="badge bg-light text-dark small">Docker</span>
                            <span class="badge bg-light text-dark small">Kubernetes</span>
                            <span class="badge bg-light text-dark small">Terraform</span>
                            <span class="badge bg-light text-dark small">Jenkins</span>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="small text-muted">
                            <i class="fas fa-map-marker-alt me-1"></i>
                            Remote • Full-time
                        </div>
                        <button class="btn btn-sm btn-outline-primary rounded-pill job-apply-btn" data-job-id="devops-engineer">
                            <i class="fas fa-paper-plane me-1"></i>
                            Apply Now
                        </button>
                    </div>
                </div>
            </div>

            <!-- Product Manager -->
            <div class="col-lg-6 job-card" data-department="operations" data-location="hybrid" data-title="Product Manager" data-skills="product strategy analytics roadmap">
                <div class="h-100 p-4 rounded-3 job-opportunity-card" style="background: white; border: 1px solid rgba(255,73,0,0.1); transition: all 0.3s ease; cursor: pointer;">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="flex-grow-1">
                            <h3 class="h5 fw-bold mb-2 job-title" style="color: #333;">Product Manager</h3>
                            <div class="d-flex flex-wrap gap-2 mb-2">
                                <span class="badge bg-light text-dark small">Operations</span>
                                <span class="badge bg-warning small">Hybrid</span>  
                                <span class="badge bg-primary small">Full-time</span>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="small text-muted">Posted 5 days ago</div>
                            <div class="small fw-bold" style="color: #FF4900;">$75k - $110k</div>
                        </div>
                    </div>
                    
                    <p class="text-muted mb-3 job-description">
                        Drive product strategy and roadmap. Work closely with engineering and design teams 
                        to deliver features that delight our customers.
                    </p>
                    
                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">Key Skills:</small>
                        <div class="d-flex flex-wrap gap-1">
                            <span class="badge bg-light text-dark small">Product Strategy</span>
                            <span class="badge bg-light text-dark small">Analytics</span>
                            <span class="badge bg-light text-dark small">Roadmap</span>
                            <span class="badge bg-light text-dark small">Agile</span>
                            <span class="badge bg-light text-dark small">User Research</span>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="small text-muted">
                            <i class="fas fa-map-marker-alt me-1"></i>
                            London • Hybrid
                        </div>
                        <button class="btn btn-sm btn-outline-primary rounded-pill job-apply-btn" data-job-id="product-manager">
                            <i class="fas fa-paper-plane me-1"></i>
                            Apply Now
                        </button>
                    </div>
                </div>
            </div>

            <!-- Marketing Specialist -->
            <div class="col-lg-6 job-card" data-department="marketing" data-location="remote" data-title="Digital Marketing Specialist" data-skills="seo social media content analytics">
                <div class="h-100 p-4 rounded-3 job-opportunity-card" style="background: white; border: 1px solid rgba(255,73,0,0.1); transition: all 0.3s ease; cursor: pointer;">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="flex-grow-1">
                            <h3 class="h5 fw-bold mb-2 job-title" style="color: #333;">Digital Marketing Specialist</h3>
                            <div class="d-flex flex-wrap gap-2 mb-2">
                                <span class="badge bg-light text-dark small">Marketing</span>
                                <span class="badge bg-success small">Remote</span>
                                <span class="badge bg-primary small">Full-time</span>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="small text-muted">Posted 1 week ago</div>
                            <div class="small fw-bold" style="color: #FF4900;">$45k - $70k</div>
                        </div>
                    </div>
                    
                    <p class="text-muted mb-3 job-description">
                        Develop and execute digital marketing campaigns. Grow our online presence 
                        and drive engagement across multiple channels.
                    </p>
                    
                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">Key Skills:</small>
                        <div class="d-flex flex-wrap gap-1">
                            <span class="badge bg-light text-dark small">SEO</span>
                            <span class="badge bg-light text-dark small">Social Media</span>
                            <span class="badge bg-light text-dark small">Content Strategy</span>
                            <span class="badge bg-light text-dark small">Analytics</span>
                            <span class="badge bg-light text-dark small">PPC</span>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="small text-muted">
                            <i class="fas fa-map-marker-alt me-1"></i>
                            Remote • Full-time
                        </div>
                        <button class="btn btn-sm btn-outline-primary rounded-pill job-apply-btn" data-job-id="marketing-specialist">
                            <i class="fas fa-paper-plane me-1"></i>
                            Apply Now
                        </button>
                    </div>
                </div>
            </div>

            <!-- Sales Representative -->
            <div class="col-lg-6 job-card" data-department="sales" data-location="on-site" data-title="Sales Representative" data-skills="sales crm communication relationship">
                <div class="h-100 p-4 rounded-3 job-opportunity-card" style="background: white; border: 1px solid rgba(255,73,0,0.1); transition: all 0.3s ease; cursor: pointer;">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="flex-grow-1">
                            <h3 class="h5 fw-bold mb-2 job-title" style="color: #333;">Sales Representative</h3>
                            <div class="d-flex flex-wrap gap-2 mb-2">
                                <span class="badge bg-light text-dark small">Sales</span>
                                <span class="badge bg-info small">On-site</span>
                                <span class="badge bg-primary small">Full-time</span>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="small text-muted">Posted 2 weeks ago</div>
                            <div class="small fw-bold" style="color: #FF4900;">$50k - $80k + Commission</div>
                        </div>
                    </div>
                    
                    <p class="text-muted mb-3 job-description">
                        Build relationships with potential clients and drive revenue growth. 
                        Present our solutions and help businesses transform digitally.
                    </p>
                    
                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">Key Skills:</small>
                        <div class="d-flex flex-wrap gap-1">
                            <span class="badge bg-light text-dark small">Sales Strategy</span>
                            <span class="badge bg-light text-dark small">CRM</span>
                            <span class="badge bg-light text-dark small">Communication</span>
                            <span class="badge bg-light text-dark small">Relationship Building</span>
                            <span class="badge bg-light text-dark small">Negotiation</span>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="small text-muted">
                            <i class="fas fa-map-marker-alt me-1"></i>
                            London • On-site
                        </div>
                        <button class="btn btn-sm btn-outline-primary rounded-pill job-apply-btn" data-job-id="sales-representative">
                            <i class="fas fa-paper-plane me-1"></i>
                            Apply Now
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- No Results Message -->
        <div id="noResults" class="row" style="display: none;">
            <div class="col-lg-6 mx-auto text-center py-5">
                <div class="mb-4">
                    <i class="fas fa-search fa-3x text-muted" style="opacity: 0.5;"></i>
                </div>
                <h3 class="h4 fw-bold mb-3" style="color: #333;">No positions found</h3>
                <p class="text-muted mb-4">
                    We couldn't find any positions matching your criteria. 
                    Try adjusting your search or filters.
                </p>
                <button id="resetSearch" class="btn btn-outline-primary rounded-pill">
                    <i class="fas fa-refresh me-2"></i>
                    Reset Search
                </button>
            </div>
        </div>

        <!-- Load More Button -->
        <div class="row mt-5" id="loadMoreSection">
            <div class="col-12 text-center">
                <button id="loadMoreJobs" class="btn btn-outline-primary btn-lg rounded-pill px-4">
                    <i class="fas fa-plus me-2"></i>
                    Load More Positions
                </button>
                <p class="small text-muted mt-2 mb-0">Showing 6 of 12 positions</p>
            </div>
        </div>
    </div>
</section>

<style>
.job-opportunity-card:hover {
    border-color: #FF4900 !important;
    box-shadow: 0 8px 25px rgba(255,73,0,0.15) !important;
    transform: translateY(-3px);
}

.job-apply-btn:hover {
    background-color: #FF4900 !important;
    border-color: #FF4900 !important;
    color: white !important;
}

#jobSearch:focus,
#departmentFilter:focus,
#locationFilter:focus {
    border-color: #FF4900;
    box-shadow: 0 0 0 0.2rem rgba(255,73,0,0.25);
}

.filter-tag {
    background: linear-gradient(135deg, #FF4900 0%, #FF6B35 100%);
    color: white;
    padding: 4px 12px;
    border-radius: 15px;
    font-size: 0.875rem;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.filter-tag .remove-filter {
    cursor: pointer;
    opacity: 0.8;
}

.filter-tag .remove-filter:hover {
    opacity: 1;
}

.search-highlight {
    background-color: #fff3cd;
    padding: 1px 3px;
    border-radius: 3px;
}
</style>