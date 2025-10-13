
document.addEventListener('DOMContentLoaded', function() {
    // Initialize opportunities page functionality
    initializeOpportunitiesPage();
    
    // Initialize application form
    initializeApplicationForm();
    
    // Initialize file uploads
    initializeFileUploads();
    
    // Initialize animations
    initializeAnimations();
});

function initializeOpportunitiesPage() {
    // Notification topbar close functionality
    const notificationClose = document.querySelector('.notification-close');
    if (notificationClose) {
        notificationClose.addEventListener('click', function() {
            document.querySelector('.notification-topbar').style.display = 'none';
        });
    }
    
    // Reading tracker
    function updateReadingTracker() {
        const windowHeight = window.innerHeight;
        const documentHeight = document.documentElement.scrollHeight;
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        const trackLength = documentHeight - windowHeight;
        const percentScrolled = Math.min(100, Math.max(0, (scrollTop / trackLength) * 100));
        
        const readingTracker = document.querySelector('.reading-tracker');
        if (readingTracker) {
            readingTracker.style.width = percentScrolled + '%';
        }
    }
    
    window.addEventListener('scroll', updateReadingTracker, { passive: true });
    window.addEventListener('resize', updateReadingTracker, { passive: true });
    updateReadingTracker();
    
    // Smooth scroll for hero buttons
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
    
    // Hero statistics counter animation
    function animateCounters() {
        const stats = document.querySelectorAll('.hero-stat-number');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const target = entry.target;
                    const finalNumber = target.textContent;
                    const numericValue = parseInt(finalNumber.replace(/\D/g, ''));
                    
                    let currentValue = 0;
                    const increment = numericValue / 50;
                    const timer = setInterval(() => {
                        currentValue += increment;
                        if (currentValue >= numericValue) {
                            currentValue = numericValue;
                            clearInterval(timer);
                        }
                        target.textContent = Math.floor(currentValue) + finalNumber.replace(/\d/g, '').replace(/^\d+/, '');
                    }, 40);
                    
                    observer.unobserve(target);
                }
            });
        }, { threshold: 0.5 });

        stats.forEach(stat => observer.observe(stat));
    }
    
    animateCounters();
}

function initializeApplicationForm() {
    let currentStep = 1;
    const totalSteps = 4;
    
    const nextBtn = document.getElementById('nextBtn');
    const prevBtn = document.getElementById('prevBtn');
    const submitBtn = document.getElementById('submitBtn');
    const form = document.getElementById('applicationForm');
    
    if (!nextBtn || !prevBtn || !submitBtn || !form) return;

    // Form navigation
    nextBtn.addEventListener('click', function() {
        if (validateStep(currentStep)) {
            if (currentStep < totalSteps) {
                goToStep(currentStep + 1);
            }
        }
    });

    prevBtn.addEventListener('click', function() {
        if (currentStep > 1) {
            goToStep(currentStep - 1);
        }
    });

    function goToStep(step) {
        // Hide current step
        const currentStepEl = document.querySelector(`.career-form-step[data-step="${currentStep}"]`);
        const currentProgressEl = document.querySelector(`.career-progress-step[data-step="${currentStep}"]`);
        
        if (currentStepEl) currentStepEl.classList.remove('active');
        if (currentProgressEl) currentProgressEl.classList.remove('active');
        
        // Mark current step as completed if moving forward
        if (step > currentStep && currentProgressEl) {
            currentProgressEl.classList.add('completed');
        }
        
        currentStep = step;
        
        // Show new step
        const newStepEl = document.querySelector(`.career-form-step[data-step="${currentStep}"]`);
        const newProgressEl = document.querySelector(`.career-progress-step[data-step="${currentStep}"]`);
        
        if (newStepEl) newStepEl.classList.add('active');
        if (newProgressEl) newProgressEl.classList.add('active');
        
        // Update navigation buttons
        prevBtn.style.display = currentStep === 1 ? 'none' : 'block';
        nextBtn.style.display = currentStep === totalSteps ? 'none' : 'block';
        submitBtn.style.display = currentStep === totalSteps ? 'block' : 'none';
        
        // Update summary on last step
        if (currentStep === totalSteps) {
            updateSummary();
        }
        
        // Scroll to top of form
        const formContent = document.querySelector('.application-form-content');
        if (formContent) {
            formContent.scrollIntoView({ 
                behavior: 'smooth',
                block: 'start'
            });
        }
    }

    function validateStep(step) {
        let isValid = true;
        const stepElement = document.querySelector(`.career-form-step[data-step="${step}"]`);
        if (!stepElement) return true;
        
        const requiredFields = stepElement.querySelectorAll('[required]');
        
        requiredFields.forEach(field => {
            if (!field.checkValidity()) {
                field.classList.add('is-invalid');
                isValid = false;
            } else {
                field.classList.remove('is-invalid');
                field.classList.add('is-valid');
            }
        });
        
        // Special validation for file upload in step 3
        if (step === 3) {
            const resumeFile = document.getElementById('resumeFile');
            if (resumeFile && !resumeFile.files.length) {
                document.getElementById('resumeUpload')?.classList.add('is-invalid');
                isValid = false;
            }
        }
        
        return isValid;
    }

    function updateSummary() {
        // Update summary values
        const firstName = document.getElementById('firstName')?.value || '';
        const lastName = document.getElementById('lastName')?.value || '';
        const summaryName = document.getElementById('summaryName');
        if (summaryName) summaryName.textContent = `${firstName} ${lastName}`;
        
        const email = document.getElementById('email')?.value || '';
        const summaryEmail = document.getElementById('summaryEmail');
        if (summaryEmail) summaryEmail.textContent = email;
        
        const positionSelect = document.getElementById('position');
        const summaryPosition = document.getElementById('summaryPosition');
        if (positionSelect && summaryPosition) {
            const positionText = positionSelect.options[positionSelect.selectedIndex].text;
            summaryPosition.textContent = positionText;
        }
        
        const experienceSelect = document.getElementById('experience');
        const summaryExperience = document.getElementById('summaryExperience');
        if (experienceSelect && summaryExperience) {
            const experienceText = experienceSelect.options[experienceSelect.selectedIndex].text;
            summaryExperience.textContent = experienceText;
        }
        
        const resumeFile = document.getElementById('resumeFile');
        const summaryResume = document.getElementById('summaryResume');
        if (resumeFile && summaryResume) {
            summaryResume.textContent = resumeFile.files[0] ? resumeFile.files[0].name : 'No file uploaded';
        }
    }

    // Form submission
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        try {
            // Show loading state
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Submitting...';
            submitBtn.disabled = true;
            
            // Simulate form submission
            await new Promise(resolve => setTimeout(resolve, 2000));
            
            // Generate application reference
            const timestamp = Date.now();
            const randomNum = Math.floor(Math.random() * 9999);
            const applicationRef = `MD-2024-APP-${randomNum.toString().padStart(4, '0')}`;
            
            // Show success page
            handleSuccessfulSubmission(applicationRef);
            
        } catch (error) {
            console.error('Form submission error:', error);
            alert('Something went wrong. Please try again.');
        } finally {
            // Reset loading state
            submitBtn.innerHTML = '<i class="fas fa-paper-plane me-2"></i>Submit Application';
            submitBtn.disabled = false;
        }
    });

    function handleSuccessfulSubmission(applicationRef) {
        // Update application reference
        const appRefElement = document.getElementById('applicationReference');
        if (appRefElement) {
            appRefElement.textContent = applicationRef;
        }
        
        // Hide application form and show success section
        document.querySelector('.application-form')?.classList.add('d-none');
        document.getElementById('applicationSuccess')?.classList.remove('d-none');
        
        // Scroll to success section
        document.getElementById('applicationSuccess')?.scrollIntoView({ 
            behavior: 'smooth',
            block: 'start'
        });
    }
}

function initializeFileUploads() {
    // File upload functionality
    setupFileUpload('resumeUpload', 'resumeFile', false);
    setupFileUpload('additionalUpload', 'additionalFiles', true);

    function setupFileUpload(containerId, inputId, multiple = false) {
        const container = document.getElementById(containerId);
        const input = document.getElementById(inputId);
        if (!container || !input) return;
        
        const uploadContent = container.querySelector('.file-upload-content');
        if (!uploadContent) return;
        
        // Click to browse
        uploadContent.addEventListener('click', () => input.click());
        
        // Drag and drop
        uploadContent.addEventListener('dragover', (e) => {
            e.preventDefault();
            container.classList.add('dragover');
        });
        
        uploadContent.addEventListener('dragleave', () => {
            container.classList.remove('dragover');
        });
        
        uploadContent.addEventListener('drop', (e) => {
            e.preventDefault();
            container.classList.remove('dragover');
            
            const files = Array.from(e.dataTransfer.files);
            handleFiles(files, input, container, multiple);
        });
        
        // File input change
        input.addEventListener('change', (e) => {
            const files = Array.from(e.target.files);
            handleFiles(files, input, container, multiple);
        });
    }

    function handleFiles(files, input, container, multiple) {
        if (!files || files.length === 0) return;

        if (!multiple && files.length > 1) {
            files = [files[0]]; // Take only first file for single upload
        }
        
        // Validate files
        const validFiles = files.filter(file => {
            const validTypes = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'];
            const extension = file.name.split('.').pop().toLowerCase();
            const maxSize = 5 * 1024 * 1024; // 5MB
            
            return validTypes.includes(extension) && file.size <= maxSize;
        });
        
        if (validFiles.length === 0) {
            alert('Please select valid files (PDF, DOC, DOCX, JPG, PNG) under 5MB.');
            return;
        }
        
        // Create new FileList with valid files
        const dt = new DataTransfer();
        validFiles.forEach(file => dt.items.add(file));
        input.files = dt.files;
        
        // Show file preview
        showFilePreview(validFiles, container, multiple);
        
        // Remove validation error states
        container.classList.remove('is-invalid');
    }

    function showFilePreview(files, container, multiple) {
        const previewContainer = multiple ? 
            container.querySelector('.additional-files-preview') : 
            container.querySelector('.file-preview');
        
        if (!previewContainer) return;
        
        if (!multiple) {
            // Single file preview
            previewContainer.classList.remove('d-none');
            const file = files[0];
            const fileName = previewContainer.querySelector('.file-name');
            const fileSize = previewContainer.querySelector('.file-size');
            
            if (fileName) fileName.textContent = file.name;
            if (fileSize) fileSize.textContent = formatFileSize(file.size);
            
            // Remove file functionality
            const removeBtn = previewContainer.querySelector('.remove-file');
            if (removeBtn) {
                removeBtn.onclick = () => {
                    const inputId = container.id.replace('Upload', 'File');
                    const fileInput = document.getElementById(inputId);
                    if (fileInput) fileInput.value = '';
                    previewContainer.classList.add('d-none');
                };
            }
        } else {
            // Multiple files preview
            previewContainer.innerHTML = '';
            files.forEach((file, index) => {
                const filePreview = document.createElement('div');
                filePreview.className = 'd-flex align-items-center justify-content-between p-3 bg-light rounded-3 mb-2';
                filePreview.innerHTML = `
                    <div class="d-flex align-items-center">
                        <i class="fas fa-file fa-lg me-3" style="color: #FF4900;"></i>
                        <div>
                            <div class="fw-semibold">${file.name}</div>
                            <small class="text-muted">${formatFileSize(file.size)}</small>
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-danger remove-additional-file" data-index="${index}">
                        <i class="fas fa-trash"></i>
                    </button>
                `;
                previewContainer.appendChild(filePreview);
            });
        }
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }
}

function initializeAnimations() {
    // Preloader animation
    setTimeout(() => {
        const logoImage = document.querySelector('.logo-image');
        const loadingText = document.querySelector('.loading-text');
        
        if (logoImage) logoImage.classList.add('loaded');
        if (loadingText) loadingText.classList.add('show');
    }, 500);

    // Animate progress bar
    const progressBar = document.querySelector('.progress-bar');
    if (progressBar) {
        let width = 0;
        const interval = setInterval(() => {
            width += 2;
            progressBar.style.width = width + '%';
            
            if (width >= 100) {
                clearInterval(interval);
                // Hide preloader
                setTimeout(() => {
                    const preloader = document.getElementById('preloader');
                    if (preloader) {
                        preloader.style.opacity = '0';
                        setTimeout(() => {
                            preloader.style.display = 'none';
                        }, 500);
                    }
                }, 300);
            }
        }, 30);
    }
    
    // Animation on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    // Observe elements for animation
    document.querySelectorAll('.opportunity-card, .benefits-card, .life-value-card').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(el);
    });
}

// Global functions for opportunity modal (if needed by components)
window.openOpportunityModal = function(opportunityId) {
    // This will be handled by the opportunity-modal component
    console.log('Opening opportunity modal for:', opportunityId);
};

window.startApplication = function() {
    // This will be handled by the application form component
    console.log('Starting application process');
};

window.resetApplicationForm = function() {
    // Reset form functionality
    const form = document.getElementById('applicationForm');
    if (form) {
        form.reset();
        // Reset to step 1
        document.querySelectorAll('.career-form-step').forEach(step => step.classList.remove('active'));
        document.querySelector('.career-form-step[data-step="1"]')?.classList.add('active');
        
        // Hide success section and show application form
        document.getElementById('applicationSuccess')?.classList.add('d-none');
        document.querySelector('.application-form')?.classList.remove('d-none');
    }
};
