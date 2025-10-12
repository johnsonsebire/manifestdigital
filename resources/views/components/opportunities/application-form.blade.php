@props([
    'jobTitle' => 'Position',
    'jobId' => '',
    'showForm' => false
])

<!-- Application Form Section -->
<section class="application-form-section py-5" 
         style="background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%); {{ $showForm ? '' : 'display: none;' }}" 
         id="application-form-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <!-- Form Header -->
                <div class="text-center mb-5">
                    <h2 class="display-6 fw-bold mb-3" style="color: #333;">Apply for <span id="application-job-title" style="color: #FF4900;">{{ $jobTitle }}</span></h2>
                    <p class="lead text-muted">Take the next step in your career journey. We're excited to learn more about you!</p>
                </div>

                <!-- Application Form -->
                <div class="application-form-container">
                    <form id="job-application-form" class="needs-validation" novalidate enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="application-job-id" name="job_id" value="{{ $jobId }}">
                        
                        <!-- Progress Indicator -->
                        <div class="progress-indicator mb-5">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="step-indicator active" data-step="1">
                                    <div class="step-number">1</div>
                                    <div class="step-label">Personal Info</div>
                                </div>
                                <div class="progress-line"></div>
                                <div class="step-indicator" data-step="2">
                                    <div class="step-number">2</div>
                                    <div class="step-label">Experience</div>
                                </div>
                                <div class="progress-line"></div>
                                <div class="step-indicator" data-step="3">
                                    <div class="step-number">3</div>
                                    <div class="step-label">Documents</div>
                                </div>
                                <div class="progress-line"></div>
                                <div class="step-indicator" data-step="4">
                                    <div class="step-number">4</div>
                                    <div class="step-label">Review</div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 1: Personal Information -->
                        <div class="form-step active" id="step-1">
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-header bg-transparent border-bottom-0 pt-4">
                                    <h4 class="mb-0" style="color: #333;">Personal Information</h4>
                                    <p class="text-muted small mb-0">Tell us about yourself</p>
                                </div>
                                <div class="card-body px-4 pb-4">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="first-name" class="form-label fw-medium">First Name *</label>
                                            <input type="text" class="form-control" id="first-name" name="first_name" required>
                                            <div class="invalid-feedback">Please provide your first name.</div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="last-name" class="form-label fw-medium">Last Name *</label>
                                            <input type="text" class="form-control" id="last-name" name="last_name" required>
                                            <div class="invalid-feedback">Please provide your last name.</div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="email" class="form-label fw-medium">Email Address *</label>
                                            <input type="email" class="form-control" id="email" name="email" required>
                                            <div class="invalid-feedback">Please provide a valid email address.</div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="phone" class="form-label fw-medium">Phone Number *</label>
                                            <input type="tel" class="form-control" id="phone" name="phone" required>
                                            <div class="invalid-feedback">Please provide your phone number.</div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="location" class="form-label fw-medium">Current Location *</label>
                                            <input type="text" class="form-control" id="location" name="location" placeholder="City, State/Country" required>
                                            <div class="invalid-feedback">Please provide your current location.</div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="availability" class="form-label fw-medium">Availability *</label>
                                            <select class="form-select" id="availability" name="availability" required>
                                                <option value="">Select availability</option>
                                                <option value="immediately">Immediately</option>
                                                <option value="2_weeks">2 weeks notice</option>
                                                <option value="1_month">1 month notice</option>
                                                <option value="2_months">2+ months notice</option>
                                            </select>
                                            <div class="invalid-feedback">Please select your availability.</div>
                                        </div>
                                        <div class="col-12">
                                            <label for="linkedin" class="form-label fw-medium">LinkedIn Profile</label>
                                            <input type="url" class="form-control" id="linkedin" name="linkedin" placeholder="https://linkedin.com/in/yourprofile">
                                        </div>
                                        <div class="col-12">
                                            <label for="portfolio" class="form-label fw-medium">Portfolio/Website</label>
                                            <input type="url" class="form-control" id="portfolio" name="portfolio" placeholder="https://yourportfolio.com">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 2: Experience & Skills -->
                        <div class="form-step" id="step-2">
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-header bg-transparent border-bottom-0 pt-4">
                                    <h4 class="mb-0" style="color: #333;">Experience & Skills</h4>
                                    <p class="text-muted small mb-0">Share your professional background</p>
                                </div>
                                <div class="card-body px-4 pb-4">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="experience-years" class="form-label fw-medium">Years of Experience *</label>
                                            <select class="form-select" id="experience-years" name="experience_years" required>
                                                <option value="">Select experience level</option>
                                                <option value="0-1">0-1 years</option>
                                                <option value="2-3">2-3 years</option>
                                                <option value="4-5">4-5 years</option>
                                                <option value="6-8">6-8 years</option>
                                                <option value="9+">9+ years</option>
                                            </select>
                                            <div class="invalid-feedback">Please select your experience level.</div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="current-role" class="form-label fw-medium">Current/Recent Role</label>
                                            <input type="text" class="form-control" id="current-role" name="current_role" placeholder="e.g., Senior Developer">
                                        </div>
                                        <div class="col-12">
                                            <label for="skills" class="form-label fw-medium">Key Skills *</label>
                                            <textarea class="form-control" id="skills" name="skills" rows="3" 
                                                    placeholder="List your relevant technical skills, programming languages, frameworks, tools, etc." required></textarea>
                                            <div class="invalid-feedback">Please describe your key skills.</div>
                                        </div>
                                        <div class="col-12">
                                            <label for="experience-summary" class="form-label fw-medium">Experience Summary *</label>
                                            <textarea class="form-control" id="experience-summary" name="experience_summary" rows="4" 
                                                    placeholder="Briefly describe your professional experience, key achievements, and what you're passionate about..." required></textarea>
                                            <div class="invalid-feedback">Please provide an experience summary.</div>
                                        </div>
                                        <div class="col-12">
                                            <label for="why-manifest" class="form-label fw-medium">Why Manifest Digital? *</label>
                                            <textarea class="form-control" id="why-manifest" name="why_manifest" rows="3" 
                                                    placeholder="What interests you about this role and our company?" required></textarea>
                                            <div class="invalid-feedback">Please tell us why you're interested in Manifest Digital.</div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="salary-expectation" class="form-label fw-medium">Salary Expectation</label>
                                            <input type="text" class="form-control" id="salary-expectation" name="salary_expectation" placeholder="e.g., $80,000 - $100,000">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="work-preference" class="form-label fw-medium">Work Preference *</label>
                                            <select class="form-select" id="work-preference" name="work_preference" required>
                                                <option value="">Select preference</option>
                                                <option value="remote">Remote</option>
                                                <option value="hybrid">Hybrid</option>
                                                <option value="onsite">On-site</option>
                                                <option value="flexible">Flexible</option>
                                            </select>
                                            <div class="invalid-feedback">Please select your work preference.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 3: Documents -->
                        <div class="form-step" id="step-3">
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-header bg-transparent border-bottom-0 pt-4">
                                    <h4 class="mb-0" style="color: #333;">Documents & Portfolio</h4>
                                    <p class="text-muted small mb-0">Upload your resume and supporting documents</p>
                                </div>
                                <div class="card-body px-4 pb-4">
                                    <!-- Resume Upload -->
                                    <div class="mb-4">
                                        <label class="form-label fw-medium">Resume/CV *</label>
                                        <div class="file-upload-container">
                                            <div class="file-upload-area border rounded-3 p-4 text-center" id="resume-upload-area">
                                                <input type="file" class="d-none" id="resume-upload" name="resume" accept=".pdf,.doc,.docx" required>
                                                <div class="upload-content">
                                                    <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                                                    <p class="mb-2">Drag & drop your resume here or <button type="button" class="btn btn-link p-0 upload-trigger">browse files</button></p>
                                                    <small class="text-muted">Supported formats: PDF, DOC, DOCX (max 5MB)</small>
                                                </div>
                                                <div class="file-info d-none">
                                                    <i class="fas fa-file-alt fa-2x text-success mb-2"></i>
                                                    <p class="mb-0 file-name"></p>
                                                    <button type="button" class="btn btn-sm btn-outline-danger mt-2 remove-file">Remove</button>
                                                </div>
                                            </div>
                                            <div class="invalid-feedback">Please upload your resume.</div>
                                        </div>
                                    </div>

                                    <!-- Cover Letter Upload -->
                                    <div class="mb-4">
                                        <label class="form-label fw-medium">Cover Letter</label>
                                        <div class="file-upload-container">
                                            <div class="file-upload-area border rounded-3 p-4 text-center" id="cover-letter-upload-area">
                                                <input type="file" class="d-none" id="cover-letter-upload" name="cover_letter" accept=".pdf,.doc,.docx">
                                                <div class="upload-content">
                                                    <i class="fas fa-file-text fa-2x text-muted mb-2"></i>
                                                    <p class="mb-2">Drag & drop your cover letter or <button type="button" class="btn btn-link p-0 upload-trigger">browse files</button></p>
                                                    <small class="text-muted">Supported formats: PDF, DOC, DOCX (max 5MB)</small>
                                                </div>
                                                <div class="file-info d-none">
                                                    <i class="fas fa-file-text fa-2x text-success mb-2"></i>
                                                    <p class="mb-0 file-name"></p>
                                                    <button type="button" class="btn btn-sm btn-outline-danger mt-2 remove-file">Remove</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Portfolio Upload -->
                                    <div class="mb-4">
                                        <label class="form-label fw-medium">Portfolio Samples</label>
                                        <div class="file-upload-container">
                                            <div class="file-upload-area border rounded-3 p-4 text-center" id="portfolio-upload-area">
                                                <input type="file" class="d-none" id="portfolio-upload" name="portfolio_files[]" multiple accept=".pdf,.jpg,.jpeg,.png,.gif,.zip">
                                                <div class="upload-content">
                                                    <i class="fas fa-images fa-2x text-muted mb-2"></i>
                                                    <p class="mb-2">Upload portfolio samples or <button type="button" class="btn btn-link p-0 upload-trigger">browse files</button></p>
                                                    <small class="text-muted">Images, PDFs, or ZIP files (max 10MB each)</small>
                                                </div>
                                                <div class="files-list d-none"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Additional Comments -->
                                    <div class="mb-0">
                                        <label for="additional-comments" class="form-label fw-medium">Additional Comments</label>
                                        <textarea class="form-control" id="additional-comments" name="additional_comments" rows="3" 
                                                placeholder="Any additional information you'd like to share..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 4: Review & Submit -->
                        <div class="form-step" id="step-4">
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-header bg-transparent border-bottom-0 pt-4">
                                    <h4 class="mb-0" style="color: #333;">Review & Submit</h4>
                                    <p class="text-muted small mb-0">Please review your application before submitting</p>
                                </div>
                                <div class="card-body px-4 pb-4">
                                    <!-- Application Summary -->
                                    <div class="application-summary">
                                        <div class="row g-4">
                                            <div class="col-md-6">
                                                <h5 class="h6 fw-bold mb-3" style="color: #FF4900;">Personal Information</h5>
                                                <div class="summary-item">
                                                    <strong>Name:</strong> <span id="review-name"></span>
                                                </div>
                                                <div class="summary-item">
                                                    <strong>Email:</strong> <span id="review-email"></span>
                                                </div>
                                                <div class="summary-item">
                                                    <strong>Phone:</strong> <span id="review-phone"></span>
                                                </div>
                                                <div class="summary-item">
                                                    <strong>Location:</strong> <span id="review-location"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <h5 class="h6 fw-bold mb-3" style="color: #FF4900;">Experience</h5>
                                                <div class="summary-item">
                                                    <strong>Experience:</strong> <span id="review-experience"></span>
                                                </div>
                                                <div class="summary-item">
                                                    <strong>Current Role:</strong> <span id="review-role"></span>
                                                </div>
                                                <div class="summary-item">
                                                    <strong>Work Preference:</strong> <span id="review-work-preference"></span>
                                                </div>
                                                <div class="summary-item">
                                                    <strong>Availability:</strong> <span id="review-availability"></span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row mt-4">
                                            <div class="col-12">
                                                <h5 class="h6 fw-bold mb-3" style="color: #FF4900;">Uploaded Documents</h5>
                                                <div id="review-documents"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Terms and Conditions -->
                                    <div class="terms-section mt-4 pt-4 border-top">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" id="terms-agreement" name="terms_agreement" required>
                                            <label class="form-check-label" for="terms-agreement">
                                                I agree to the <a href="#" class="text-decoration-none" style="color: #FF4900;">Terms and Conditions</a> and <a href="#" class="text-decoration-none" style="color: #FF4900;">Privacy Policy</a> *
                                            </label>
                                            <div class="invalid-feedback">You must agree to the terms and conditions.</div>
                                        </div>
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" id="marketing-consent" name="marketing_consent">
                                            <label class="form-check-label" for="marketing-consent">
                                                I would like to receive updates about future opportunities and company news
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Navigation -->
                        <div class="form-navigation d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-outline-secondary btn-lg" id="prev-step" style="display: none;">
                                <i class="fas fa-arrow-left me-2"></i>Previous
                            </button>
                            <div class="ms-auto">
                                <button type="button" class="btn btn-primary btn-lg" id="next-step" style="background: linear-gradient(135deg, #FF4900 0%, #FF6B35 100%); border: none;">
                                    Next <i class="fas fa-arrow-right ms-2"></i>
                                </button>
                                <button type="submit" class="btn btn-success btn-lg" id="submit-application" style="display: none; background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border: none;">
                                    <i class="fas fa-paper-plane me-2"></i>Submit Application
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                
                <!-- Success Message -->
                <div class="application-success text-center py-5" id="application-success" style="display: none;">
                    <div class="mb-4">
                        <i class="fas fa-check-circle fa-4x text-success mb-3"></i>
                        <h3 class="h2 fw-bold mb-3" style="color: #28a745;">Application Submitted Successfully!</h3>
                        <p class="lead text-muted mb-4">Thank you for your interest in joining Manifest Digital. We've received your application and will review it carefully.</p>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="alert alert-info border-0" style="background: linear-gradient(135deg, rgba(13,202,240,0.1) 0%, rgba(13,110,253,0.1) 100%);">
                                <h5 class="alert-heading fw-bold">What happens next?</h5>
                                <ul class="list-unstyled mb-0 text-start">
                                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i>We'll send you a confirmation email within the next few minutes</li>
                                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Our team will review your application within 2-3 business days</li>
                                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i>If you're a good fit, we'll reach out to schedule an initial interview</li>
                                    <li class="mb-0"><i class="fas fa-check text-success me-2"></i>You can check your application status by logging into your candidate portal</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="button" class="btn btn-primary btn-lg me-3" onclick="window.location.reload()" style="background: linear-gradient(135deg, #FF4900 0%, #FF6B35 100%); border: none;">
                            <i class="fas fa-briefcase me-2"></i>Apply for Another Position
                        </button>
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-lg">
                            <i class="fas fa-home me-2"></i>Back to Home
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Custom Styles -->
<style>
.progress-indicator {
    position: relative;
}

.step-indicator {
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
    z-index: 10;
}

.step-number {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #e9ecef;
    color: #6c757d;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    margin-bottom: 8px;
    transition: all 0.3s ease;
}

.step-indicator.active .step-number {
    background: linear-gradient(135deg, #FF4900 0%, #FF6B35 100%);
    color: white;
}

.step-indicator.completed .step-number {
    background: #28a745;
    color: white;
}

.step-label {
    font-size: 0.875rem;
    font-weight: 500;
    color: #6c757d;
    text-align: center;
}

.step-indicator.active .step-label {
    color: #FF4900;
}

.progress-line {
    flex: 1;
    height: 2px;
    background: #e9ecef;
    margin: 0 20px;
    margin-top: 20px;
    position: relative;
}

.progress-line.completed {
    background: #28a745;
}

.form-step {
    display: none;
}

.form-step.active {
    display: block;
    animation: fadeInUp 0.5s ease;
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

.file-upload-area {
    background: #f8f9fa;
    border: 2px dashed #dee2e6 !important;
    transition: all 0.3s ease;
    cursor: pointer;
}

.file-upload-area:hover {
    border-color: #FF4900 !important;
    background: rgba(255, 73, 0, 0.02);
}

.file-upload-area.drag-over {
    border-color: #FF4900 !important;
    background: rgba(255, 73, 0, 0.05);
}

.upload-trigger {
    color: #FF4900 !important;
    text-decoration: underline !important;
}

.summary-item {
    margin-bottom: 8px;
    font-size: 0.9rem;
}

.summary-item strong {
    color: #333;
    width: 120px;
    display: inline-block;
}

@media (max-width: 768px) {
    .progress-line {
        display: none;
    }
    
    .step-indicator {
        flex-direction: row;
        justify-content: flex-start;
        margin-bottom: 20px;
    }
    
    .step-number {
        margin-bottom: 0;
        margin-right: 12px;
    }
}
</style>