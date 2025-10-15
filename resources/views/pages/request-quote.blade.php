<x-layouts.frontend title="Get a Quote - Request Custom Quote | Manifest Digital" :transparent-header="false" preloader='advanced'>

    @push('styles')
        @vite(['resources/css/request-quote.css'])
    @endpush

    <x-quote.hero />
    <x-quote.form-container />

    @push('scripts')
        <script>
            // Quote Form JavaScript
            document.addEventListener('DOMContentLoaded', function () {
                let currentStep = 1;
                let selectedService = '';
                let selectedBudget = '';
                let selectedTimeline = '';
                let uploadedFiles = [];

                // Service selection
                const serviceCards = document.querySelectorAll('.service-card');
                const step1NextBtn = document.getElementById('step1Next');
                const serviceInput = document.getElementById('serviceInput');

                serviceCards.forEach(card => {
                    card.addEventListener('click', function () {
                        serviceCards.forEach(c => c.classList.remove('selected'));
                        this.classList.add('selected');
                        selectedService = this.dataset.service;
                        serviceInput.value = selectedService; // Update hidden input
                        step1NextBtn.disabled = false;
                    });
                });

                // Budget selection
                const budgetOptions = document.querySelectorAll('.budget-option');
                const budgetInput = document.getElementById('budgetInput');

                budgetOptions.forEach(option => {
                    option.addEventListener('click', function () {
                        budgetOptions.forEach(o => o.classList.remove('selected'));
                        this.classList.add('selected');
                        selectedBudget = this.dataset.budget;
                        budgetInput.value = selectedBudget; // Update hidden input
                    });
                });

                // Timeline selection
                const timelineOptions = document.querySelectorAll('.timeline-option');
                const timelineInput = document.getElementById('timelineInput');

                timelineOptions.forEach(option => {
                    option.addEventListener('click', function () {
                        timelineOptions.forEach(o => o.classList.remove('selected'));
                        this.classList.add('selected');
                        selectedTimeline = this.dataset.timeline;
                        timelineInput.value = selectedTimeline; // Update hidden input
                    });
                });

                // File upload functionality
                const fileUpload = document.getElementById('fileUpload');
                const fileInput = document.getElementById('fileInput');
                const uploadedFilesContainer = document.getElementById('uploadedFiles');

                if (fileUpload && fileInput) {
                    fileUpload.addEventListener('click', () => fileInput.click());

                    fileUpload.addEventListener('dragover', function (e) {
                        e.preventDefault();
                        this.classList.add('dragover');
                    });

                    fileUpload.addEventListener('dragleave', function (e) {
                        e.preventDefault();
                        this.classList.remove('dragover');
                    });

                    fileUpload.addEventListener('drop', function (e) {
                        e.preventDefault();
                        this.classList.remove('dragover');
                        handleFiles(e.dataTransfer.files);
                    });

                    fileInput.addEventListener('change', function (e) {
                        handleFiles(e.target.files);
                    });
                }

                function handleFiles(files) {
                    Array.from(files).forEach(file => {
                        if (file.size > 10 * 1024 * 1024) { // 10MB limit
                            alert(`File ${file.name} is too large. Maximum size is 10MB.`);
                            return;
                        }

                        uploadedFiles.push(file);
                        displayUploadedFile(file);
                    });
                }

                function displayUploadedFile(file) {
                    const fileDiv = document.createElement('div');
                    fileDiv.className = 'uploaded-file';
                    fileDiv.innerHTML = `
                        <div class="file-info">
                            <i class="fas fa-file file-icon"></i>
                            <div>
                                <div class="file-name">${file.name}</div>
                                <div class="file-size">${formatFileSize(file.size)}</div>
                            </div>
                        </div>
                        <button class="remove-file" onclick="removeFile('${file.name}', this)">
                            <i class="fas fa-times"></i>
                        </button>
                    `;
                    uploadedFilesContainer.appendChild(fileDiv);
                }

                function formatFileSize(bytes) {
                    if (bytes === 0) return '0 Bytes';
                    const k = 1024;
                    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                    const i = Math.floor(Math.log(bytes) / Math.log(k));
                    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
                }

                // Make removeFile function global
                window.removeFile = function (fileName, button) {
                    uploadedFiles = uploadedFiles.filter(file => file.name !== fileName);
                    button.parentElement.remove();
                };

                // Form validation
                function validateStep(step) {
                    switch (step) {
                        case 1:
                            return selectedService !== '';
                        case 2:
                            const title = document.getElementById('projectTitle').value.trim();
                            const description = document.getElementById('projectDescription').value.trim();
                            return title && description;
                        case 3:
                            return true; // Optional selections
                        case 4:
                            const firstName = document.getElementById('firstName').value.trim();
                            const lastName = document.getElementById('lastName').value.trim();
                            const email = document.getElementById('email').value.trim();
                            return firstName && lastName && email && validateEmail(email);
                        default:
                            return true;
                    }
                }

                function validateEmail(email) {
                    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    return re.test(email);
                }

                // Update summary
                function updateSummary() {
                    const summaryItems = document.getElementById('summaryItems');
                    let summary = '';

                    // Selected service
                    const serviceCard = document.querySelector('.service-card.selected');
                    if (serviceCard) {
                        const serviceName = serviceCard.querySelector('h3').textContent;
                        const servicePrice = serviceCard.querySelector('.service-price').textContent;
                        summary += `
                            <div class="summary-item">
                                <span class="summary-label">Service Type</span>
                                <span class="summary-value">${serviceName}<br><small>${servicePrice}</small></span>
                            </div>
                        `;
                    }

                    // Project details
                    const projectTitle = document.getElementById('projectTitle').value;
                    if (projectTitle) {
                        summary += `
                            <div class="summary-item">
                                <span class="summary-label">Project Title</span>
                                <span class="summary-value">${projectTitle}</span>
                            </div>
                        `;
                    }

                    // Budget
                    const budgetOption = document.querySelector('.budget-option.selected');
                    if (budgetOption) {
                        const budgetAmount = budgetOption.querySelector('.budget-amount').textContent;
                        summary += `
                            <div class="summary-item">
                                <span class="summary-label">Budget Range</span>
                                <span class="summary-value">${budgetAmount}</span>
                            </div>
                        `;
                    }

                    // Timeline
                    const timelineOption = document.querySelector('.timeline-option.selected');
                    if (timelineOption) {
                        const timelinePeriod = timelineOption.querySelector('.timeline-period').textContent;
                        summary += `
                            <div class="summary-item">
                                <span class="summary-label">Timeline</span>
                                <span class="summary-value">${timelinePeriod}</span>
                            </div>
                        `;
                    }

                    // Contact info
                    const firstName = document.getElementById('firstName').value;
                    const lastName = document.getElementById('lastName').value;
                    const email = document.getElementById('email').value;

                    if (firstName && lastName && email) {
                        summary += `
                            <div class="summary-item">
                                <span class="summary-label">Contact Person</span>
                                <span class="summary-value">${firstName} ${lastName}<br><small>${email}</small></span>
                            </div>
                        `;
                    }

                    // Files uploaded
                    if (uploadedFiles.length > 0) {
                        summary += `
                            <div class="summary-item">
                                <span class="summary-label">Uploaded Files</span>
                                <span class="summary-value">${uploadedFiles.length} file(s)</span>
                            </div>
                        `;
                    }

                    summaryItems.innerHTML = summary;
                }

                // Navigation functions
                window.nextStep = function () {
                    if (validateStep(currentStep)) {
                        currentStep++;
                        switchToStep(currentStep);
                        if (currentStep === 5) {
                            updateSummary();
                        }
                    } else {
                        alert('Please complete all required fields before proceeding.');
                    }
                };

                window.prevStep = function () {
                    currentStep--;
                    switchToStep(currentStep);
                };

                function switchToStep(step) {
                    // Hide all steps
                    document.querySelectorAll('.quote-step').forEach(s => {
                        s.classList.remove('active');
                    });

                    // Show current step
                    document.getElementById('step' + step).classList.add('active');

                    // Update progress indicators
                    document.querySelectorAll('.progress-step').forEach((progressStep, index) => {
                        progressStep.classList.remove('active', 'completed');
                        if (index + 1 < step) {
                            progressStep.classList.add('completed');
                        } else if (index + 1 === step) {
                            progressStep.classList.add('active');
                        }
                    });
                }

                // Submit quote - Now submits to Laravel backend
                window.submitQuote = function () {
                    const submitBtn = document.getElementById('submitBtn');
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Submitting...';

                    // Submit the actual form to the backend
                    document.getElementById('quoteForm').submit();
                };
            });
        </script>
    @endpush

</x-layouts.frontend>