<!-- Multi-Step Application Form -->
<div class="modal fade" id="applicationModal" tabindex="-1" aria-labelledby="applicationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content" style="border-radius: 20px; border: none; overflow: hidden;">
            <!-- Modal Header -->
            <div class="modal-header border-0 p-4" style="background: linear-gradient(135deg, #FF4900 0%, #FF6B35 100%);">
                <div class="flex-grow-1 text-white">
                    <h1 class="modal-title h4 fw-bold mb-2" id="applicationModalLabel">Apply for Senior Full Stack Developer</h1>
                    <div class="progress" style="height: 6px; background-color: rgba(255,255,255,0.3);">
                        <div class="progress-bar bg-white" role="progressbar" style="width: 33%" aria-valuenow="1" aria-valuemin="0" aria-valuemax="3" id="applicationProgress"></div>
                    </div>
                    <div class="mt-2">
                        <small class="text-white-75">Step <span id="currentStep">1</span> of 3</small>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body p-4">
                <form id="jobApplicationForm" novalidate>
                    <!-- Step 1: Personal Information -->
                    <div class="step-content" id="step1" style="display: block;">
                        <div class="text-center mb-4">
                            <div class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background: linear-gradient(135deg, #FF4900 0%, #FF6B35 100%);">
                                <i class="fas fa-user fa-lg text-white"></i>
                            </div>
                            <h2 class="h4 fw-bold mb-2" style="color: #333;">Personal Information</h2>
                            <p class="text-muted mb-0">Tell us about yourself and your background</p>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="firstName" class="form-label fw-bold">First Name *</label>
                                <input type="text" class="form-control form-control-lg" id="firstName" name="firstName" required style="border-radius: 12px; border: 2px solid #e9ecef;">
                                <div class="invalid-feedback">Please provide your first name.</div>
                            </div>
                            <div class="col-md-6">
                                <label for="lastName" class="form-label fw-bold">Last Name *</label>
                                <input type="text" class="form-control form-control-lg" id="lastName" name="lastName" required style="border-radius: 12px; border: 2px solid #e9ecef;">
                                <div class="invalid-feedback">Please provide your last name.</div>
                            </div>
                            <div class="col-12">
                                <label for="email" class="form-label fw-bold">Email Address *</label>
                                <input type="email" class="form-control form-control-lg" id="email" name="email" required style="border-radius: 12px; border: 2px solid #e9ecef;">
                                <div class="invalid-feedback">Please provide a valid email address.</div>
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label fw-bold">Phone Number *</label>
                                <input type="tel" class="form-control form-control-lg" id="phone" name="phone" required style="border-radius: 12px; border: 2px solid #e9ecef;">
                                <div class="invalid-feedback">Please provide your phone number.</div>
                            </div>
                            <div class="col-md-6">
                                <label for="location" class="form-label fw-bold">Current Location *</label>
                                <input type="text" class="form-control form-control-lg" id="location" name="location" required placeholder="City, Country" style="border-radius: 12px; border: 2px solid #e9ecef;">
                                <div class="invalid-feedback">Please provide your current location.</div>
                            </div>
                            <div class="col-12">
                                <label for="linkedinUrl" class="form-label fw-bold">LinkedIn Profile</label>
                                <input type="url" class="form-control form-control-lg" id="linkedinUrl" name="linkedinUrl" placeholder="https://linkedin.com/in/your-profile" style="border-radius: 12px; border: 2px solid #e9ecef;">
                                <div class="form-text">Optional: Share your LinkedIn profile for additional context</div>
                            </div>
                            <div class="col-12">
                                <label for="portfolioUrl" class="form-label fw-bold">Portfolio/Website</label>
                                <input type="url" class="form-control form-control-lg" id="portfolioUrl" name="portfolioUrl" placeholder="https://your-portfolio.com" style="border-radius: 12px; border: 2px solid #e9ecef;">
                                <div class="form-text">Optional: Share your portfolio or personal website</div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Experience & Skills -->
                    <div class="step-content" id="step2" style="display: none;">
                        <div class="text-center mb-4">
                            <div class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background: linear-gradient(135deg, #FF4900 0%, #FF6B35 100%);">
                                <i class="fas fa-briefcase fa-lg text-white"></i>
                            </div>
                            <h2 class="h4 fw-bold mb-2" style="color: #333;">Experience & Skills</h2>
                            <p class="text-muted mb-0">Share your professional background and expertise</p>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="currentRole" class="form-label fw-bold">Current Role *</label>
                                <input type="text" class="form-control form-control-lg" id="currentRole" name="currentRole" required placeholder="e.g., Senior Developer" style="border-radius: 12px; border: 2px solid #e9ecef;">
                                <div class="invalid-feedback">Please provide your current role.</div>
                            </div>
                            <div class="col-md-6">
                                <label for="currentCompany" class="form-label fw-bold">Current Company *</label>
                                <input type="text" class="form-control form-control-lg" id="currentCompany" name="currentCompany" required style="border-radius: 12px; border: 2px solid #e9ecef;">
                                <div class="invalid-feedback">Please provide your current company.</div>
                            </div>
                            <div class="col-md-6">
                                <label for="experienceYears" class="form-label fw-bold">Years of Experience *</label>
                                <select class="form-select form-select-lg" id="experienceYears" name="experienceYears" required style="border-radius: 12px; border: 2px solid #e9ecef;">
                                    <option value="">Select experience level</option>
                                    <option value="0-1">0-1 years</option>
                                    <option value="1-3">1-3 years</option>
                                    <option value="3-5">3-5 years</option>
                                    <option value="5-8">5-8 years</option>
                                    <option value="8-12">8-12 years</option>
                                    <option value="12+">12+ years</option>
                                </select>
                                <div class="invalid-feedback">Please select your experience level.</div>
                            </div>
                            <div class="col-md-6">
                                <label for="salaryRange" class="form-label fw-bold">Expected Salary Range</label>
                                <select class="form-select form-select-lg" id="salaryRange" name="salaryRange" style="border-radius: 12px; border: 2px solid #e9ecef;">
                                    <option value="">Prefer not to say</option>
                                    <option value="40-60k">$40k - $60k</option>
                                    <option value="60-80k">$60k - $80k</option>
                                    <option value="80-100k">$80k - $100k</option>
                                    <option value="100-120k">$100k - $120k</option>
                                    <option value="120k+">$120k+</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="keySkills" class="form-label fw-bold">Key Skills *</label>
                                <textarea class="form-control form-control-lg" id="keySkills" name="keySkills" rows="3" required placeholder="List your key technical skills, programming languages, frameworks, etc." style="border-radius: 12px; border: 2px solid #e9ecef;"></textarea>
                                <div class="invalid-feedback">Please provide your key skills.</div>
                                <div class="form-text">Separate skills with commas (e.g., JavaScript, React, Laravel, PHP)</div>
                            </div>
                            <div class="col-12">
                                <label for="workExperience" class="form-label fw-bold">Brief Work Experience Summary *</label>
                                <textarea class="form-control form-control-lg" id="workExperience" name="workExperience" rows="4" required placeholder="Briefly describe your relevant work experience and key achievements..." style="border-radius: 12px; border: 2px solid #e9ecef;"></textarea>
                                <div class="invalid-feedback">Please provide a brief work experience summary.</div>
                            </div>
                            <div class="col-12">
                                <label for="availabilityDate" class="form-label fw-bold">Available Start Date *</label>
                                <input type="date" class="form-control form-control-lg" id="availabilityDate" name="availabilityDate" required min="{{ date('Y-m-d') }}" style="border-radius: 12px; border: 2px solid #e9ecef;">
                                <div class="invalid-feedback">Please provide your availability date.</div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Application & Documents -->
                    <div class="step-content" id="step3" style="display: none;">
                        <div class="text-center mb-4">
                            <div class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background: linear-gradient(135deg, #FF4900 0%, #FF6B35 100%);">
                                <i class="fas fa-file-alt fa-lg text-white"></i>
                            </div>
                            <h2 class="h4 fw-bold mb-2" style="color: #333;">Application & Documents</h2>
                            <p class="text-muted mb-0">Complete your application with additional information</p>
                        </div>

                        <div class="row g-3">
                            <!-- Resume Upload -->
                            <div class="col-12">
                                <label class="form-label fw-bold">Resume/CV *</label>
                                <div class="file-upload-area p-4 rounded-3 text-center" style="border: 2px dashed #dee2e6; background: #f8f9fa; cursor: pointer; transition: all 0.3s ease;" id="resumeUploadArea">
                                    <input type="file" id="resumeFile" name="resumeFile" accept=".pdf,.doc,.docx" required hidden>
                                    <div class="file-upload-content">
                                        <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                                        <div class="fw-bold mb-2" style="color: #333;">Drop your resume here or click to browse</div>
                                        <small class="text-muted">Supported formats: PDF, DOC, DOCX (Max 5MB)</small>
                                    </div>
                                    <div class="file-upload-success" style="display: none;">
                                        <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                                        <div class="fw-bold text-success" id="resumeFileName">File uploaded successfully</div>
                                        <button type="button" class="btn btn-sm btn-outline-secondary mt-2" id="changeResumeBtn">Change File</button>
                                    </div>
                                </div>
                                <div class="invalid-feedback">Please upload your resume.</div>
                            </div>

                            <!-- Cover Letter -->
                            <div class="col-12">
                                <label for="coverLetter" class="form-label fw-bold">Cover Letter</label>
                                <textarea class="form-control form-control-lg" id="coverLetter" name="coverLetter" rows="5" placeholder="Tell us why you're interested in this position and what makes you a great fit..." style="border-radius: 12px; border: 2px solid #e9ecef;"></textarea>
                                <div class="form-text">Optional: Share why you're excited about this role and our company</div>
                            </div>

                            <!-- Additional Questions -->
                            <div class="col-12">
                                <label for="remoteWork" class="form-label fw-bold">Remote Work Experience *</label>
                                <select class="form-select form-select-lg" id="remoteWork" name="remoteWork" required style="border-radius: 12px; border: 2px solid #e9ecef;">
                                    <option value="">Select your experience</option>
                                    <option value="extensive">Extensive (3+ years)</option>
                                    <option value="moderate">Moderate (1-3 years)</option>
                                    <option value="limited">Limited (less than 1 year)</option>
                                    <option value="none">No remote experience</option>
                                </select>
                                <div class="invalid-feedback">Please select your remote work experience.</div>
                            </div>

                            <div class="col-12">
                                <label for="whyInterested" class="form-label fw-bold">Why are you interested in Manifest Digital? *</label>
                                <textarea class="form-control form-control-lg" id="whyInterested" name="whyInterested" rows="3" required placeholder="What attracts you to our company and this role?" style="border-radius: 12px; border: 2px solid #e9ecef;"></textarea>
                                <div class="invalid-feedback">Please tell us why you're interested in our company.</div>
                            </div>

                            <div class="col-12">
                                <label for="additionalInfo" class="form-label fw-bold">Additional Information</label>
                                <textarea class="form-control form-control-lg" id="additionalInfo" name="additionalInfo" rows="3" placeholder="Anything else you'd like us to know? Certifications, languages, achievements, etc." style="border-radius: 12px; border: 2px solid #e9ecef;"></textarea>
                                <div class="form-text">Optional: Share any additional information that might be relevant</div>
                            </div>

                            <!-- Consent & GDPR -->
                            <div class="col-12">
                                <div class="form-check p-3 rounded-3" style="background: rgba(255,73,0,0.05); border: 1px solid rgba(255,73,0,0.1);">
                                    <input class="form-check-input" type="checkbox" id="dataConsent" name="dataConsent" required style="margin-top: 0.25rem;">
                                    <label class="form-check-label small" for="dataConsent">
                                        <strong>Data Processing Consent *</strong><br>
                                        I consent to the processing of my personal data for recruitment purposes. I understand that my information will be used to evaluate my application and communicate about this position. I can withdraw this consent at any time by contacting <a href="mailto:privacy@manifestdigital.com" style="color: #FF4900;">privacy@manifestdigital.com</a>.
                                    </label>
                                    <div class="invalid-feedback">Please consent to data processing to continue.</div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="marketingConsent" name="marketingConsent">
                                    <label class="form-check-label small" for="marketingConsent">
                                        I would like to receive updates about future job opportunities at Manifest Digital (optional)
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer border-0 p-4 justify-content-between" style="background: #FFFCFA;">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-4" id="prevStepBtn" style="display: none;">
                    <i class="fas fa-arrow-left me-2"></i>Previous
                </button>
                <div class="ms-auto d-flex gap-2">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="button" class="btn btn-primary rounded-pill px-4" style="background: #FF4900; border-color: #FF4900;" id="nextStepBtn">
                        Next Step <i class="fas fa-arrow-right ms-2"></i>
                    </button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4" style="background: #FF4900; border-color: #FF4900; display: none;" id="submitAppBtn" form="jobApplicationForm">
                        <i class="fas fa-paper-plane me-2"></i>Submit Application
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.file-upload-area:hover {
    border-color: #FF4900 !important;
    background-color: rgba(255,73,0,0.02) !important;
}

.file-upload-area.dragover {
    border-color: #FF4900 !important;
    background-color: rgba(255,73,0,0.05) !important;
}

.form-control:focus,
.form-select:focus {
    border-color: #FF4900;
    box-shadow: 0 0 0 0.2rem rgba(255,73,0,0.25);
}

.form-check-input:checked {
    background-color: #FF4900;
    border-color: #FF4900;
}

.form-check-input:focus {
    border-color: #FF4900;
    box-shadow: 0 0 0 0.2rem rgba(255,73,0,0.25);
}

.text-white-75 {
    color: rgba(255,255,255,0.75) !important;
}

/* Step Animation */
.step-content {
    opacity: 0;
    transform: translateX(20px);
    transition: all 0.3s ease;
}

.step-content[style*="display: block"] {
    opacity: 1;
    transform: translateX(0);
}

/* Progress Bar Animation */
.progress-bar {
    transition: width 0.3s ease;
}

/* Loading State */
.btn.loading {
    position: relative;
    color: transparent !important;
}

.btn.loading::after {
    content: "";
    position: absolute;
    width: 16px;
    height: 16px;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    border: 2px solid transparent;
    border-top: 2px solid currentColor;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    color: white;
}

@keyframes spin {
    0% { transform: translate(-50%, -50%) rotate(0deg); }
    100% { transform: translate(-50%, -50%) rotate(360deg); }
}
</style>