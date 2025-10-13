<x-layouts.frontend 
    title="Manifest Digital | Custom Web & App Development in Ghana | Est. 2014"
    :transparent-header="true"
    preloader='advanced'
    notificationStyle='modern-purple'>
  
@push('styles')
<style>
/* Success Section Styles */
.success-section {
    padding: 120px 0 80px;
    position: relative;
    overflow: hidden;
    background: linear-gradient(135deg, #FFFCFA 0%, #FFF8F3 50%, #FFFCFA 100%);
}

.success-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: radial-gradient(circle at 30% 20%, rgba(255, 73, 0, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(255, 107, 53, 0.03) 0%, transparent 50%);
    pointer-events: none;
}

/* Decorative Elements */
.success-decorative {
    position: absolute;
    pointer-events: none;
    z-index: 1;
    background: transparent !important;
    opacity: 0.4;
}

.success-left {
    left: -50px;
    top: 15%;
    width: 100px;
    animation: float 6s ease-in-out infinite;
}

.success-right {
    right: -40px;
    top: 25%;
    width: 80px;
    animation: float 8s ease-in-out infinite reverse;
}

@keyframes float {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    25% { transform: translateY(-10px) rotate(2deg); }
    50% { transform: translateY(5px) rotate(-1deg); }
    75% { transform: translateY(-5px) rotate(1deg); }
}

/* Success Animation */
.success-icon {
    width: 120px;
    height: 120px;
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 2rem;
    position: relative;
    z-index: 2;
}

.success-icon i {
    font-size: 3rem;
    color: white;
}

.success-ring {
    position: absolute;
    border: 2px solid rgba(40, 167, 69, 0.3);
    border-radius: 50%;
    animation: pulse-ring 2s infinite;
    z-index: 1;
}

.success-ring-1 {
    width: 140px;
    height: 140px;
    top: -10px;
    left: -10px;
}

.success-ring-2 {
    width: 160px;
    height: 160px;
    top: -20px;
    left: -20px;
    animation-delay: 0.5s;
}

@keyframes pulse-ring {
    0% {
        transform: scale(0.8);
        opacity: 1;
    }
    100% {
        transform: scale(1.2);
        opacity: 0;
    }
}

.reference-number {
    background: linear-gradient(135deg, #FF4900 0%, #FF6B35 100%);
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 25px;
    font-weight: 600;
    font-size: 1rem;
    letter-spacing: 1px;
    display: inline-block;
    margin: 1.5rem 0;
}

/* Process Timeline */
.process-timeline {
    max-width: 800px;
    margin: 3rem auto;
}

.timeline-step {
    display: flex;
    align-items: center;
    margin-bottom: 2rem;
    padding: 1.5rem;
    background: rgba(255, 255, 255, 0.8);
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
    position: relative;
    z-index: 2;
}

.timeline-step:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

.step-number {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #FF4900 0%, #FF6B35 100%);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    margin-right: 1.5rem;
    flex-shrink: 0;
}

.step-content h4 {
    color: #333;
    margin-bottom: 0.5rem;
    font-weight: 600;
}

.step-content p {
    color: #666;
    margin: 0;
    line-height: 1.6;
}

/* Action Buttons */
.action-buttons {
    margin: 3rem 0;
    position: relative;
    z-index: 2;
}

.btn-primary-success {
    background: linear-gradient(135deg, #FF4900 0%, #FF6B35 100%);
    border: none;
    padding: 1rem 2rem;
    border-radius: 50px;
    font-weight: 600;
    text-decoration: none;
    color: white;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
    margin: 0.5rem;
}

.btn-primary-success:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(255, 73, 0, 0.3);
    color: white;
    text-decoration: none;
}

.btn-outline-success {
    background: transparent;
    border: 2px solid #FF4900;
    color: #FF4900;
    padding: 1rem 2rem;
    border-radius: 50px;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
    margin: 0.5rem;
}

.btn-outline-success:hover {
    background: #FF4900;
    color: white;
    transform: translateY(-2px);
    text-decoration: none;
}

/* Contact Info */
.contact-info {
    background: rgba(255, 255, 255, 0.9);
    border-radius: 20px;
    padding: 2rem;
    margin: 3rem 0;
    box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    position: relative;
    z-index: 2;
}

.contact-method {
    display: flex;
    align-items: center;
    margin-bottom: 1rem;
}

.contact-method i {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #FF4900 0%, #FF6B35 100%);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    flex-shrink: 0;
}

.contact-method a {
    color: #FF4900;
    text-decoration: none;
    font-weight: 600;
}

.contact-method a:hover {
    text-decoration: underline;
}

/* Social Links */
.social-links {
    margin-top: 2rem;
}

.social-links a {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #FF4900 0%, #FF6B35 100%);
    color: white;
    border-radius: 50%;
    text-decoration: none;
    margin: 0.5rem;
    transition: all 0.3s ease;
}

.social-links a:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(255, 73, 0, 0.3);
    color: white;
}

/* Responsive Design */
@media (max-width: 768px) {
    .success-section {
        padding: 100px 0 60px;
    }

    .success-icon {
        width: 100px;
        height: 100px;
    }

    .success-icon i {
        font-size: 2.5rem;
    }

    .timeline-step {
        flex-direction: column;
        text-align: center;
    }

    .step-number {
        margin-right: 0;
        margin-bottom: 1rem;
    }

    .btn-primary-success,
    .btn-outline-success {
        display: block;
        text-align: center;
        margin: 0.5rem 0;
        width: 100%;
        max-width: 300px;
        justify-content: center;
    }

    .success-left,
    .success-right {
        display: none;
    }
}

/* Accessibility Enhancements */
.sr-only {
    position: absolute;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    overflow: hidden;
    clip: rect(0, 0, 0, 0);
    white-space: nowrap;
    border: 0;
}

/* Reduced motion */
@media (prefers-reduced-motion: reduce) {
    * {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
    }
    
    .success-left,
    .success-right {
        animation: none;
    }
    
    .success-ring {
        animation: none;
    }
}
</style>
@endpush


<!-- Success Section -->
<section class="success-section" role="main" aria-label="Application success confirmation">
    <!-- Decorative Elements -->
    <img src="{{ asset('images/decorative/hero_underline.svg') }}" alt="" class="success-decorative success-left" loading="lazy">
    <img src="{{ asset('images/decorative/cta_top_right_mem_dots_f_tri (1).svg') }}" alt="" class="success-decorative success-right" loading="lazy">
    
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <!-- Success Animation -->
                <div class="success-icon" role="img" aria-label="Success checkmark">
                    <div class="success-ring success-ring-1" aria-hidden="true"></div>
                    <div class="success-ring success-ring-2" aria-hidden="true"></div>
                    <i class="fas fa-check" aria-hidden="true"></i>
                </div>

                <h1 class="display-4 fw-bold mb-4">Application Submitted Successfully!</h1>
                <p class="lead mb-4">
                    Thank you for your interest in joining the {{ config('app.name') }} team! 
                    We've received your application and will review it carefully.
                </p>

                <div class="reference-number" role="status" aria-live="polite">
                    Application Reference: <span id="referenceNumber">{{ $referenceNumber ?? 'MD-' . date('Ymd') . '-' . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT) }}</span>
                </div>

                <p class="mt-3">
                    <strong>We'll get back to you within 48 hours</strong> with next steps. 
                    Keep an eye on your email inbox (including spam folder).
                </p>
            </div>
        </div>

        <!-- Process Timeline -->
        <div class="process-timeline">
            <h2 class="text-center mb-4">What Happens Next?</h2>
            
            <div class="timeline-step">
                <div class="step-number" aria-label="Step 1">1</div>
                <div class="step-content">
                    <h3 class="h4">Application Review</h3>
                    <p>Our HR team will review your application and match your skills with our current openings. This typically takes 24-48 hours.</p>
                </div>
            </div>

            <div class="timeline-step">
                <div class="step-number" aria-label="Step 2">2</div>
                <div class="step-content">
                    <h3 class="h4">Initial Screening</h3>
                    <p>If your profile matches our requirements, we'll contact you for a brief phone/video screening to discuss your experience and interests.</p>
                </div>
            </div>

            <div class="timeline-step">
                <div class="step-number" aria-label="Step 3">3</div>
                <div class="step-content">
                    <h3 class="h4">Technical Interview</h3>
                    <p>For technical roles, you'll have a skills-based interview with our team leads to assess your expertise and problem-solving abilities.</p>
                </div>
            </div>

            <div class="timeline-step">
                <div class="step-number" aria-label="Step 4">4</div>
                <div class="step-content">
                    <h3 class="h4">Final Decision</h3>
                    <p>We'll make our final decision and extend an offer to successful candidates, including salary, benefits, and start date details.</p>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons text-center">
            <a href="{{ route('opportunities') }}" class="btn-outline-success">
                <i class="fas fa-arrow-left" aria-hidden="true"></i>
                View Other Opportunities
            </a>
            <a href="{{ route('home') }}" class="btn-primary-success">
                <i class="fas fa-home" aria-hidden="true"></i>
                Back to Homepage
            </a>
        </div>

        <!-- Contact Information -->
        <div class="contact-info">
            <h2 class="text-center mb-4">Questions About Your Application?</h2>
            <div class="row">
                <div class="col-md-6">
                    <div class="contact-method">
                        <i class="fas fa-envelope" aria-hidden="true"></i>
                        <div>
                            <strong>Email Us</strong><br>
                            <a href="mailto:careers@manifestdigital.gh">careers@manifestdigital.gh</a>
                        </div>
                    </div>
                    <div class="contact-method">
                        <i class="fas fa-phone" aria-hidden="true"></i>
                        <div>
                            <strong>Call Us</strong><br>
                            <a href="tel:+233549539417">+233 54 953 9417</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="contact-method">
                        <i class="fab fa-whatsapp" aria-hidden="true"></i>
                        <div>
                            <strong>WhatsApp</strong><br>
                            <a href="https://wa.me/233549539417" target="_blank" rel="noopener noreferrer">+233 54 953 9417</a>
                        </div>
                    </div>
                    <div class="contact-method">
                        <i class="fas fa-clock" aria-hidden="true"></i>
                        <div>
                            <strong>Response Time</strong><br>
                            Within 48 hours
                        </div>
                    </div>
                </div>
            </div>

            <!-- Social Links -->
            <div class="social-links text-center">
                <a href="#" target="_blank" rel="noopener noreferrer" aria-label="Follow us on Twitter">
                    <i class="fab fa-twitter" aria-hidden="true"></i>
                </a>
                <a href="#" target="_blank" rel="noopener noreferrer" aria-label="Follow us on LinkedIn">
                    <i class="fab fa-linkedin-in" aria-hidden="true"></i>
                </a>
                <a href="#" target="_blank" rel="noopener noreferrer" aria-label="Follow us on Facebook">
                    <i class="fab fa-facebook-f" aria-hidden="true"></i>
                </a>
                <a href="#" target="_blank" rel="noopener noreferrer" aria-label="Follow us on Instagram">
                    <i class="fab fa-instagram" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </div>
</section>


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize success page functionality
    initializeSuccessPage();
    
    // Handle URL parameters for personalization
    handleURLParameters();
    
    // Initialize animations
    initializeSuccessAnimations();
});

function initializeSuccessPage() {
    // Generate unique reference number if not provided
    const referenceElement = document.getElementById('referenceNumber');
    if (referenceElement && !referenceElement.textContent.includes('MD-')) {
        referenceElement.textContent = generateReferenceNumber();
    }
    
    // Track application success event
    if (typeof gtag !== 'undefined') {
        gtag('event', 'application_submitted', {
            event_category: 'Careers',
            event_label: 'Application Success Page',
            value: 1
        });
    }
}

function generateReferenceNumber() {
    const date = new Date();
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    const time = String(date.getHours()).padStart(2, '0') + String(date.getMinutes()).padStart(2, '0');
    return `MD-${year}${month}${day}-${time}`;
}

function handleURLParameters() {
    // Handle form data from URL parameters (if redirected from form)
    const urlParams = new URLSearchParams(window.location.search);
    const applicantName = urlParams.get('name');
    const applicantEmail = urlParams.get('email');
    const position = urlParams.get('position');
    const referenceNumber = urlParams.get('ref');

    if (applicantName) {
        const heading = document.querySelector('h1');
        if (heading) {
            heading.innerHTML = `Thank you, ${escapeHtml(applicantName)}!<br>Application Submitted Successfully!`;
        }
    }

    if (position) {
        const leadText = document.querySelector('.lead');
        if (leadText) {
            leadText.innerHTML = `
                Thank you for applying for the <strong>${escapeHtml(position)}</strong> position at {{ config('app.name') }}! 
                We've received your application and will review it carefully.
            `;
        }
    }

    if (referenceNumber) {
        const refElement = document.getElementById('referenceNumber');
        if (refElement) {
            refElement.textContent = escapeHtml(referenceNumber);
        }
    }
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function initializeSuccessAnimations() {
    // Check if user prefers reduced motion
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    
    if (prefersReducedMotion) {
        return; // Skip animations if user prefers reduced motion
    }
    
    // Success icon entrance animation
    const successIcon = document.querySelector('.success-icon');
    if (successIcon) {
        successIcon.style.opacity = '0';
        successIcon.style.transform = 'scale(0.5)';
        
        setTimeout(() => {
            successIcon.style.transition = 'all 0.8s cubic-bezier(0.68, -0.55, 0.265, 1.55)';
            successIcon.style.opacity = '1';
            successIcon.style.transform = 'scale(1)';
        }, 200);
    }
    
    // Timeline steps animation
    const timelineSteps = document.querySelectorAll('.timeline-step');
    timelineSteps.forEach((step, index) => {
        step.style.opacity = '0';
        step.style.transform = 'translateY(30px)';
        
        setTimeout(() => {
            step.style.transition = 'all 0.6s ease';
            step.style.opacity = '1';
            step.style.transform = 'translateY(0)';
        }, 500 + (index * 150));
    });
    
    // Action buttons animation
    const actionButtons = document.querySelectorAll('.action-buttons a');
    actionButtons.forEach((button, index) => {
        button.style.opacity = '0';
        button.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            button.style.transition = 'all 0.5s ease';
            button.style.opacity = '1';
            button.style.transform = 'translateY(0)';
        }, 1200 + (index * 100));
    });
    
    // Contact info animation
    const contactInfo = document.querySelector('.contact-info');
    if (contactInfo) {
        contactInfo.style.opacity = '0';
        contactInfo.style.transform = 'translateY(30px)';
        
        setTimeout(() => {
            contactInfo.style.transition = 'all 0.6s ease';
            contactInfo.style.opacity = '1';
            contactInfo.style.transform = 'translateY(0)';
        }, 1500);
    }
}

// Add smooth scroll behavior for any anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Print functionality (if needed)
function printApplicationReference() {
    const referenceNumber = document.getElementById('referenceNumber')?.textContent;
    if (referenceNumber) {
        const printWindow = window.open('', '_blank');
        printWindow.document.write(`
            <html>
            <head>
                <title>Application Reference</title>
                <style>
                    body { font-family: Arial, sans-serif; padding: 20px; }
                    .reference { font-size: 24px; font-weight: bold; color: #FF4900; }
                </style>
            </head>
            <body>
                <h1>{{ config('app.name') }} - Application Reference</h1>
                <p>Your application reference number:</p>
                <div class="reference">${referenceNumber}</div>
                <p>Please save this reference number for your records.</p>
            </body>
            </html>
        `);
        printWindow.document.close();
        printWindow.print();
    }
}

// Email sharing functionality
function shareApplicationSuccess() {
    const referenceNumber = document.getElementById('referenceNumber')?.textContent;
    const subject = encodeURIComponent('Application Submitted - {{ config('app.name') }}');
    const body = encodeURIComponent(`
I have successfully submitted my job application to {{ config('app.name') }}.

Application Reference: ${referenceNumber}

They will get back to me within 48 hours with next steps.
    `);
    
    window.location.href = `mailto:?subject=${subject}&body=${body}`;
}

// Global functions that can be called from other parts of the application
window.successPageFunctions = {
    printReference: printApplicationReference,
    shareSuccess: shareApplicationSuccess,
    generateReference: generateReferenceNumber
};
</script>
@endpush


</x-layouts.frontend>
