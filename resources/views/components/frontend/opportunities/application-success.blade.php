<!-- Application Success Modal -->
<div class="modal fade" id="applicationSuccessModal" tabindex="-1" aria-labelledby="applicationSuccessModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px; border: none; overflow: hidden;">
            <!-- Success Animation and Header -->
            <div class="modal-body p-0">
                <div class="text-center p-5" style="background: linear-gradient(135deg, rgba(46,204,113,0.1) 0%, rgba(39,174,96,0.1) 100%);">
                    <!-- Success Animation -->
                    <div class="success-animation mb-4">
                        <div class="success-circle mx-auto d-flex align-items-center justify-content-center" style="width: 100px; height: 100px; background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%); border-radius: 50%; animation: successPulse 2s ease-out;">
                            <i class="fas fa-check fa-3x text-white success-check" style="animation: successCheck 0.8s ease-out 0.3s both;"></i>
                        </div>
                    </div>

                    <!-- Success Message -->
                    <h1 class="h2 fw-bold mb-3" style="color: #27ae60;">Application Submitted Successfully!</h1>
                    <p class="lead mb-4" style="color: #666;">
                        Thank you for your interest in joining our team. We've received your application 
                        and are excited to review your qualifications.
                    </p>

                    <!-- Application Details -->
                    <div class="bg-white rounded-3 p-4 mb-4 text-start" style="box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                        <h2 class="h5 fw-bold mb-3" style="color: #333;">Application Details</h2>
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <div class="d-flex justify-content-between">
                                    <strong class="small" style="color: #666;">Position:</strong>
                                    <span class="small" style="color: #333;" id="appliedPosition">Senior Full Stack Developer</span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="d-flex justify-content-between">
                                    <strong class="small" style="color: #666;">Application ID:</strong>
                                    <span class="small fw-bold" style="color: #FF4900;" id="applicationId">#APP-2024-001234</span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="d-flex justify-content-between">
                                    <strong class="small" style="color: #666;">Submitted:</strong>
                                    <span class="small" style="color: #333;" id="submissionDate">Today</span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="d-flex justify-content-between">
                                    <strong class="small" style="color: #666;">Status:</strong>
                                    <span class="badge bg-warning small">Under Review</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- What Happens Next Section -->
                <div class="p-5" style="background: #FFFCFA;">
                    <h2 class="h4 fw-bold mb-4 text-center" style="color: #333;">What Happens Next?</h2>
                    
                    <!-- Timeline -->
                    <div class="timeline-container">
                        <div class="row g-4">
                            <div class="col-md-4">
                                <div class="timeline-item text-center h-100">
                                    <div class="timeline-icon mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background: linear-gradient(135deg, #FF4900 0%, #FF6B35 100%); border-radius: 50%;">
                                        <i class="fas fa-search fa-lg text-white"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <h3 class="h6 fw-bold mb-2" style="color: #FF4900;">Application Review</h3>
                                        <p class="small text-muted mb-2">Our hiring team will carefully review your application and qualifications.</p>
                                        <div class="small fw-bold" style="color: #333;">Within 2-3 business days</div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="timeline-item text-center h-100">
                                    <div class="timeline-icon mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%;">
                                        <i class="fas fa-comments fa-lg text-white"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <h3 class="h6 fw-bold mb-2" style="color: #667eea;">Initial Interview</h3>
                                        <p class="small text-muted mb-2">If selected, we'll schedule a phone/video call to discuss your background.</p>
                                        <div class="small fw-bold" style="color: #333;">Within 1 week</div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="timeline-item text-center h-100">
                                    <div class="timeline-icon mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%); border-radius: 50%;">
                                        <i class="fas fa-handshake fa-lg text-white"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <h3 class="h6 fw-bold mb-2" style="color: #2ecc71;">Final Decision</h3>
                                        <p class="small text-muted mb-2">Final interviews and decision. We'll keep you updated throughout the process.</p>
                                        <div class="small fw-bold" style="color: #333;">Within 2 weeks</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Information -->
                    <div class="row mt-5">
                        <div class="col-lg-8 mx-auto">
                            <div class="alert alert-info border-0 rounded-3" style="background: linear-gradient(135deg, rgba(52,152,219,0.1) 0%, rgba(41,128,185,0.1) 100%); border-left: 4px solid #3498db !important;">
                                <div class="d-flex align-items-start">
                                    <i class="fas fa-info-circle fa-lg me-3 mt-1" style="color: #3498db;"></i>
                                    <div>
                                        <h3 class="h6 fw-bold mb-2" style="color: #3498db;">Important Information</h3>
                                        <ul class="mb-0 small" style="color: #666;">
                                            <li class="mb-1">Check your email (including spam folder) for updates</li>
                                            <li class="mb-1">We'll contact you even if your application isn't successful</li>
                                            <li class="mb-1">Feel free to apply for other positions if this one isn't a fit</li>
                                            <li class="mb-0">Questions? Contact us at <a href="mailto:careers@manifestdigital.com" style="color: #3498db;">careers@manifestdigital.com</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons Section -->
                <div class="p-4 border-top" style="background: white;">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center justify-content-center p-3 rounded-3" style="background: rgba(255,73,0,0.05); border: 1px solid rgba(255,73,0,0.1);">
                                <div class="text-center">
                                    <i class="fas fa-bell fa-lg mb-2" style="color: #FF4900;"></i>
                                    <div class="small fw-bold mb-1" style="color: #333;">Stay Updated</div>
                                    <p class="small text-muted mb-2">Get notified about your application status</p>
                                    <button class="btn btn-sm btn-outline-primary rounded-pill" id="enableNotifications">
                                        Enable Notifications
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="d-flex align-items-center justify-content-center p-3 rounded-3" style="background: rgba(46,204,113,0.05); border: 1px solid rgba(46,204,113,0.1);">
                                <div class="text-center">
                                    <i class="fas fa-share-alt fa-lg mb-2" style="color: #2ecc71;"></i>
                                    <div class="small fw-bold mb-1" style="color: #333;">Refer a Friend</div>
                                    <p class="small text-muted mb-2">Know someone who'd be great for this role?</p>
                                    <button class="btn btn-sm btn-outline-success rounded-pill" id="referFriendBtn">
                                        Share Position
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer border-0 p-4 justify-content-center" style="background: #FFFCFA;">
                <div class="d-flex flex-column flex-md-row gap-3 align-items-center">
                    <button type="button" class="btn btn-outline-primary rounded-pill px-4" id="viewOtherPositions">
                        <i class="fas fa-search me-2"></i>View Other Positions
                    </button>
                    <button type="button" class="btn btn-primary rounded-pill px-4" style="background: #FF4900; border-color: #FF4900;" data-bs-dismiss="modal">
                        <i class="fas fa-home me-2"></i>Back to Homepage
                    </button>
                </div>
                
                <div class="text-center mt-3">
                    <small class="text-muted">
                        Application reference: <strong id="referenceNumber">#APP-2024-001234</strong>
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Email Confirmation Toast -->
<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="emailConfirmationToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <div class="rounded me-2" style="width: 20px; height: 20px; background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%);"></div>
            <strong class="me-auto">Confirmation Email Sent</strong>
            <small>Just now</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            We've sent a confirmation email to <strong id="confirmationEmail">your email address</strong>. 
            Please check your inbox for next steps.
        </div>
    </div>
</div>

<style>
/* Success Animation */
@keyframes successPulse {
    0% {
        transform: scale(0.5);
        opacity: 0;
    }
    50% {
        transform: scale(1.1);
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}

@keyframes successCheck {
    0% {
        transform: scale(0);
        opacity: 0;
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}

/* Timeline Styling */
.timeline-container {
    position: relative;
}

.timeline-container::before {
    content: '';
    position: absolute;
    top: 30px;
    left: 0;
    right: 0;
    height: 2px;
    background: linear-gradient(90deg, #FF4900 33%, #667eea 33% 66%, #2ecc71 66%);
    z-index: 0;
}

@media (max-width: 767px) {
    .timeline-container::before {
        display: none;
    }
}

.timeline-icon {
    position: relative;
    z-index: 1;
}

.timeline-item {
    position: relative;
}

/* Hover Effects */
.timeline-item:hover .timeline-icon {
    transform: scale(1.1);
    transition: transform 0.3s ease;
}

/* Button Animations */
.btn:hover {
    transform: translateY(-2px);
    transition: all 0.3s ease;
}

/* Modal Animation Override */
.modal.fade .modal-dialog {
    transform: scale(0.8);
    transition: all 0.3s ease;
}

.modal.show .modal-dialog {
    transform: scale(1);
}

/* Toast Styling */
.toast {
    border: none;
    box-shadow: 0 4px 20px rgba(0,0,0,0.15);
}

.toast-header {
    background: linear-gradient(135deg, rgba(46,204,113,0.1) 0%, rgba(39,174,96,0.1) 100%);
    border-bottom: 1px solid rgba(46,204,113,0.2);
}

/* Responsive adjustments */
@media (max-width: 576px) {
    .modal-dialog {
        margin: 0.5rem;
    }
    
    .timeline-item {
        margin-bottom: 2rem;
    }
    
    .timeline-icon {
        width: 50px !important;
        height: 50px !important;
    }
    
    .timeline-icon i {
        font-size: 1rem !important;
    }
}
</style>